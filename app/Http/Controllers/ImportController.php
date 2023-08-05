<?php

namespace App\Http\Controllers;

use App\Helpers\HitungGaji;
use App\Imports\AbsensiImport;
use App\Imports\MultiSheetSelector;
use App\Imports\UsersImport;
use App\Models\DetailAbsen;
use App\Models\Gaji;
use App\Models\Import;
use App\Models\Pegawai;
use App\Models\PPH;
use App\Models\PTKP;
use App\Models\StatusKaryawan;
use App\Models\Umr;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::select('pegawai.*', 'gaji.*', 'status_pekerjaan.nama as nama_status', 'jabatan.nama as nama_jabatan')
            ->join('gaji', 'gaji.kode_absen', '=', 'pegawai.kode_absen')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'pegawai.status_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->get();

        // dd($count);
        return view('import.index', [
            'pegawai' => $pegawai
        ]);
    }

    public function hitungSalary()
    {
        $pinjaman = request()->input('pinjaman') ? request()->input('pinjaman') : 0;
        $adjustment = request()->input('adjustment') ? request()->input('adjustment') : 0;
        $supervisor = request()->input('supervisor') ? request()->input('supervisor') : 0;
        $nip = request()->input('nip') ? request()->input('nip') : 0;
        $thr = request()->input('thr') ? request()->input('thr') : 0;
        try {
            //code...
            $data = Gaji::where('nik_pegawai', $nip)->first();
            $pegawai = Pegawai::where('nip_pegawai', $nip)->first();
            if ($pegawai->status_pegawai == 1) {
                $update = Gaji::where('nik_pegawai', $nip)->update([
                    'adjustment' => $adjustment,
                    'pinjaman' => $pinjaman,
                    'supervisor' => $supervisor,
                ]);
            } elseif ($pegawai->status_pegawai == 2) {
                # code...
                if ($data->nik_pegawai == '22052013-21') {
                    $update = Gaji::where('nik_pegawai', $nip)->update([
                        'adjustment' => $data->premi_bpjs_kes - 50000,
                        // 'pinjaman' => $pinjaman,
                        'thr' => $thr,
                    ]);
                } else {
                    $update = Gaji::where('nik_pegawai', $nip)->update([
                        'adjustment' => $adjustment,
                        // 'pinjaman' => $pinjaman,
                        'thr' => $thr,
                    ]);
                }
            }
            return redirect()->route('detailGaji', $nip)->with('success', 'update berhasil');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('detailGaji', $nip)->with('error', $th->getMessage());
        }
        // dd($nip);
        // $netto_gaji = HitungGaji::hitung($nip, $pinjaman, $adjustment);
    }

    public function gajiAll()
    {
        $dataTetap = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('pegawai.status_pegawai', 1)->get();
        $dataKontrak = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('pegawai.status_pegawai', 2)->get();
        // dd($data->gaji_pokok + $data->uang_makan + $data->uang_transport);
        // dd($data->status_pegawai);
        foreach ($dataTetap as $key => $data) {
            $netto_gaji_tetap = HitungGaji::hitungTetap($data->nip_pegawai, $data->pinjaman, $data->adjustment, $data->supervisor);
        }
        foreach ($dataKontrak as $key => $datas) {
            $total_gaji = HitungGaji::hitungKontrak($datas->nip_pegawai, $datas->adjustment);
            $pph = HitungGaji::hitungPPH($datas->nip_pegawai, $datas->thr);
            $netto_kontrak = [$total_gaji - $pph];
            $total = $datas->gaji_gross_kontrak + $datas->adjustment;
            $total_gaji = $total - $datas->pot_bjs_kes - $datas->pot_bpjs_ket - $datas->pot_jp;
        }
        // var_dump($netto_kontrak);
        // die;
        // if ($data->status_pegawai == 1) {
        //     # code...
        //     $netto_gaji = HitungGaji::hitungTetap($id, $data->pinjaman, $data->adjustment);
        //     $total_gaji = $data->uang_makan + $data->uang_transport + $data->gaji_pokok + $data->adjustment;
        //     $pph = 0;
        // } else {
        //     $total_gaji = HitungGaji::hitungKontrak($id, $data->adjustment);
        //     $pph = HitungGaji::hitungPPH($id, $data->thr);
        //     $netto_gaji = $total_gaji - $pph;
        //     $total = $data->gaji_gross_kontrak + $data->adjustment;
        //     $total_gaji = $total - $data->pot_bjs_kes - $data->pot_bpjs_ket - $data->pot_jp;
        // }
        return view('gaji.gajiAll', [
            // 'gaji' => $data,
            'netto_tetap' => $netto_gaji_tetap,
            'netto_kontrak' => $netto_kontrak,
            'total_gaji' => $total_gaji,
            'pph' => $pph,
            'data_tetap' => $dataTetap,
            'data_kontrak' => $dataKontrak
        ]);
    }
    public function detailGaji($id)
    {
        $data = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('gaji.nik_pegawai', $id)->first();
        // dd($data->gaji_pokok + $data->uang_makan + $data->uang_transport);
        // dd($data->status_pegawai);
        if ($data->status_pegawai == 1) {
            # code...
            $netto_gaji = HitungGaji::hitungTetap($id, $data->pinjaman, $data->adjustment, $data->supervisor);
            $total_gaji = $data->uang_makan + $data->uang_transport + $data->gaji_pokok + $data->adjustment + $data->supervisor;
            $pph = 0;
        } else {
            $total_gaji = HitungGaji::hitungKontrak($id, $data->adjustment);
            $pph = HitungGaji::hitungPPH($id, $data->thr);
            $netto_gaji = $total_gaji - $pph;
            $total = $data->gaji_gross_kontrak + $data->adjustment;
            $total_gaji = $total - $data->pot_bjs_kes - $data->pot_bpjs_ket - $data->pot_jp;
        }
        // dd($data->pph);
        // dd($data);
        // dd($data);
        return view('gaji.index', [
            'gaji' => $data,
            'netto' => $netto_gaji,
            'total_gaji' => $total_gaji,
            'pph' => $pph
        ]);
    }

    public function cetak($id)
    {

        $data = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('gaji.nik_pegawai', $id)->first();
        // dd($data->gaji_pokok + $data->uang_makan + $data->uang_transport);
        // dd($data->status_pegawai);
        if ($data->status_pegawai == 1) {
            # code...
            $netto_gaji = HitungGaji::hitungTetap($id, $data->pinjaman, $data->adjustment, $data->supervisor);
            $total_gaji = $data->uang_makan + $data->uang_transport + $data->gaji_pokok + $data->adjustment + $data->supervisor;
            $pph = 0;
        } else {
            $total_gaji = HitungGaji::hitungKontrak($id, $data->adjustment);
            $pph = HitungGaji::hitungPPH($id, $data->thr);
            $netto_gaji = $total_gaji - $pph;
            $total = $data->gaji_gross_kontrak + $data->adjustment;
            $total_gaji = $total - $data->pot_bjs_kes - $data->pot_bpjs_ket - $data->pot_jp;
        }
        // dd($data->pph);
        // dd($data);
        // dd($data->nama);
        $print = [
            'gaji' => $data,
            'netto' => $netto_gaji,
            'total_gaji' => $total_gaji,
            'pph' => $pph
        ];
        $pdf = FacadePdf::loadView('gaji.cetak', $print)->setPaper('a4', 'portrait');
        return $pdf->download('slip_gaji.pdf');

        return view('gaji.cetak', [
            'gaji' => $data,
            'netto' => $netto_gaji,
            'total_gaji' => $total_gaji,
            'pph' => $pph
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $bulan = $request->bulan;
        // dd($bulan);
        $data = Excel::toArray([], $request->file('excel')->store('temp'), null, null, null, true)[0];
        $date = $data[0];
        $count_data = count($data);
        $times = array_slice($data, 1, $count_data);
        $jum = count($date);
        foreach ($times as $value) {
            for ($i = 7; $i < $jum - 1; $i++) {
                # code...
                if (!empty($date[$i]) && $value[1] != 'NIP') {
                    $datas[] = [
                        'tgl'   => $date[$i],
                        'in' => $value[$i],
                        'out' => $value[$i + 1],
                        'nik' => $value[1],
                        'jumlah_kehadiran' => $value[6]
                    ];
                }
            }
            $year = Carbon::parse($date[$i])->format("Y");
        }
        // dd($value);
        try {
            // dd($datas);
            foreach ($datas as $key => $value) {

                $bulan = Carbon::parse($value['tgl'])->format("m");
                $tahun = Carbon::parse($value['tgl'])->format("Y");
                $tanggal = Carbon::parse($value['tgl'])->format("d");
                if ($request->filter == $bulan) {
                    // dd($value);
                    if ($value['in'] !== '00:00') {
                        $insert =  DetailAbsen::create([
                            'kode_absen' => $value['nik'],
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'tanggal' => $tanggal,
                            'masuk' => $value['in'],
                            'keluar' => $value['out'],
                        ]);
                        $this->hitungGaji($value['jumlah_kehadiran'], $value['nik'], $year, $bulan);
                    }
                }
                // dd($bulan);

            }
            return redirect()->back()->with('success', 'Import success!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function hitungGaji($kehadiran, $kode_absen, $year, $bulan)
    {
        $pegawai = Pegawai::where('kode_absen', $kode_absen)->first();
        if ($pegawai != null) {
            # code...
            if ($pegawai->status_pegawai == 1) {
                HitungGaji::masterTetap($pegawai, $kode_absen, $kehadiran, $year);
            } elseif ($pegawai->status_pegawai == 2) {
                HitungGaji::masterKontrak($pegawai, $kode_absen, $kehadiran, $year, $bulan);
                // $detail_absen = DetailAbsen::where('kode_absen', $kode_absen)->first();

            }
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function show(Import $import)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function edit(Import $import)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Import $import)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function destroy(Import $import)
    {
        //
    }
}
