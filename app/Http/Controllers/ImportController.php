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
use App\Models\Pinjaman;
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
use Yajra\DataTables\Facades\DataTables;

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

    public function kehadiran(Request $request)
    {
        // dd($request->get('bulan'), $request->get('tahun'));
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $pegawai = Pegawai::select('pegawai.*', 'gaji.*', 'status_pekerjaan.nama as nama_status', 'jabatan.nama as nama_jabatan')
            ->join('gaji', 'gaji.kode_absen', '=', 'pegawai.kode_absen')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'pegawai.status_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->get();

        $data = DetailAbsen::select('gaji_absen.*', 'pegawai.*', 'gaji.*', 'status_pekerjaan.nama as nama_status', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.kode_absen', '=', 'gaji_absen.kode_absen')
            ->join('gaji', 'gaji.kode_absen', '=', 'pegawai.kode_absen')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'pegawai.status_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('gaji_absen.bulan', $bulan)
            ->where('gaji_absen.tahun', $tahun)
            ->get();
        $data2 = Gaji::select('pegawai.*', 'gaji.*', 'status_pekerjaan.nama as nama_status', 'jabatan.nama as nama_jabatan')
            // ->join('gaji_absen', 'gaji.kode_absen', '=', 'gaji_absen.kode_absen')
            ->join('pegawai', 'pegawai.kode_absen', '=', 'gaji.kode_absen')
            ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'pegawai.status_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('gaji.bulan', $bulan)
            ->where('gaji.tahun', $tahun)
            ->get();
        // dd($data);
        // $data3 = [];
        // foreach ($data2 as $key => $datas) {
        //     $tanggal = DetailAbsen::where('kode_absen', $datas->kode_absen)->get();
        //     // foreach ($tanggal as $tgl) {
        //     //     $tanggals[] = $tgl->tanggal;
        //     // }
        //     $data3[] = [
        //         'nama' => $datas->nama,
        //         'nip' => $datas->nip_pegawai,
        //         'jabatan' => $datas->nama_jabatan,
        //         'status' => $datas->nama_status,
        //         'bulan' => $datas->bulan,
        //         'tahun' => $datas->tahun,
        //         'tanggal' => [],
        //     ];
        // }
        $total = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $totals = 31;
        $total_tanggal = [26, 27, 28, 29, 30, 31];
        for ($i = 0; $i < $total; $i++) {
            array_push($total_tanggal, $i + 1);
        }
        // dd($total_tanggal);
        // $total_tanggal = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];

        // dd($data2);
        return view('import.kehadiran', [
            'pegawai' => $data2,
            'tanggal' => $data,
            'total_tanggal' => $total_tanggal
        ]);
    }

    public function hitungSalary()
    {
        $pinjaman = request()->input('pinjaman') ? request()->input('pinjaman') : 0;
        $adjustment = request()->input('adjustment') ? request()->input('adjustment') : 0;
        $supervisor = request()->input('supervisor') ? request()->input('supervisor') : 0;
        $keterangan_adjustment = request()->input('keterangan_adjustment');
        $nip = request()->input('nip') ? request()->input('nip') : 0;
        $thr = request()->input('thr') ? request()->input('thr') : 0;
        $tenor =  request()->input('tenor');
        $nominal_pinjaman = request()->input('nominal');
        if ($tenor) {
            $nominal_pinjaman = $pinjaman / $tenor;
        } elseif ($nominal_pinjaman) {
            $tenor = $pinjaman / $nominal_pinjaman;
        } else {
            $tenor = 0;
            $nominal_pinjaman = 0;
        }
        try {
            //code...
            $data = Gaji::where('nik_pegawai', $nip)->first();
            $pegawai = Pegawai::where('nip_pegawai', $nip)->first();
            $sisa_pinjaman = ($pegawai->gaji_pokok + $data->uang_makan + $data->uang_transport) - $data->pinjaman;
            // dd($sisa_pinjaman);
            if ($pinjaman > $sisa_pinjaman) {
                return redirect()->back()->with('error', 'Pinjaman melebihi batas!');
            } else {
                if ($pegawai->status_pegawai == 1) {
                    $update = Gaji::where('nik_pegawai', $nip)->update([
                        'adjustment' => $adjustment,
                        'pinjaman' => $pinjaman,
                        'supervisor' => $supervisor,
                        'tenor' => $tenor,
                        'nominal_pinjaman' => $nominal_pinjaman,
                        'sisa_pinjaman' => $pinjaman,
                        'keterangan_adjustment' => $keterangan_adjustment
                    ]);
                    $data_pinjaman = Pinjaman::where('nip_pegawai', $nip)->first();
                    if ($pinjaman != 0) {
                        Pinjaman::create([
                            'nip_pegawai' => $nip,
                            'pinjaman' => $pinjaman,
                            'tenor' => $tenor,
                            'nominal_pinjaman' => $nominal_pinjaman,
                            'sisa_pinjaman' => $pinjaman
                        ]);
                    }
                } elseif ($pegawai->status_pegawai == 2) {
                    # code...
                    if ($data->nik_pegawai == '22052013-21') {
                        $update = Gaji::where('nik_pegawai', $nip)->update([
                            'adjustment' => $data->premi_bpjs_kes - 50000,
                            'pinjaman' => $pinjaman,
                            'tenor' => $tenor,
                            'nominal_pinjaman' => $nominal_pinjaman,
                            'thr' => $thr,
                        ]);
                    } else {
                        $update = Gaji::where('nik_pegawai', $nip)->update([
                            'adjustment' => $adjustment,
                            'pinjaman' => $pinjaman,
                            'tenor' => $tenor,
                            'nominal_pinjaman' => $nominal_pinjaman,
                            'thr' => $thr,
                        ]);
                    }
                }
            }
            return redirect()->route('detailGaji', $nip . '_' . $data->bulan)->with('success', 'update berhasil');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('detailGaji', $nip . '_' . $data->bulan)->with('error', $th->getMessage());
        }
        // dd($nip);
        // $netto_gaji = HitungGaji::hitung($nip, $pinjaman, $adjustment);
    }

    public function gajiAll()
    {
        $dataTetap = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            // ->leftJoin('pinjaman', 'pinjaman.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->where('pegawai.status_pegawai', 1)->get();
        $dataKontrak = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('pegawai.status_pegawai', 2)->get();
        // dd($data->gaji_pokok + $data->uang_makan + $data->uang_transport);
        // dd($dataTetap);
        $countTetap = count($dataTetap);
        $countKontrak = count($dataKontrak);
        if ($countTetap > 0 && $countKontrak > 0) {
            foreach ($dataTetap as $key => $data) {
                $netto_gaji_tetap = HitungGaji::hitungTetap($data->nip_pegawai, $data->pinjaman, $data->adjustment, $data->supervisor, $data->bulan);
            }
            foreach ($dataKontrak as $key => $datas) {
                // dd($dataKontrak);
                $total_gaji = HitungGaji::hitungKontrak($datas->nip_pegawai, $datas->adjustment);
                $pph = HitungGaji::hitungPPH($datas->nip_pegawai, $datas->thr);
                $netto_kontrak = [$total_gaji - $pph];
                $total = $datas->gaji_gross_kontrak + $datas->adjustment;
                $total_gaji = $total - $datas->pot_bjs_kes - $datas->pot_bpjs_ket - $datas->pot_jp;
            }
        } else {
            $netto_gaji_tetap = 0;
            $total_gaji = 0;
            $pph = 0;
            $total = 0;
            $netto_kontrak = 0;
        }
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

    public function dataGajiTetap(Request $request)
    {
        // dd($request->all());
        $dataTetap = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            // ->leftJoin('pinjaman', 'pinjaman.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->where('pegawai.status_pegawai', 1)
            ->when($request->tahun, function ($query) use ($request) {
                $query->where('tahun', $request->tahun);
            })
            ->when($request->bulan, function ($query) use ($request) {
                $query->where('bulan', $request->bulan);
            })
            ->when($request->bulan && $request->tahun, function ($query) use ($request) {
                $query->where('bulan', $request->bulan);
                $query->where('tahun', $request->tahun);
            })
            ->get();

        $countTetap = count($dataTetap);

        if ($countTetap > 0) {
            foreach ($dataTetap as $key => $data) {
                $netto_gaji_tetap = HitungGaji::hitungTetap($data->nip_pegawai, $data->pinjaman, $data->adjustment, $data->supervisor, $data->bulan);
            }
        } else {
            $netto_gaji_tetap = 0;
        }

        return DataTables::of($dataTetap)
            ->addColumn('netto_gaji', function ($data) {
                $netto_gaji_tetap = HitungGaji::hitungTetap($data->nip_pegawai, $data->pinjaman, $data->adjustment, $data->supervisor, $data->bulan);
                return 'Rp ' . number_format($netto_gaji_tetap, 0, ',', '.');
            })
            ->addColumn('pinjam', function ($data) {
                if ($data->pinjaman === $data->sisa_pinjaman) {
                    return 'Rp ' . number_format(0, 0, ',', '.');
                } else {
                    return 'Rp ' . number_format($data->nominal_pinjaman, 0, ',', '.');
                }
            })
            ->addColumn('namas', function ($data) {
                $href = route('detailGaji', $data->nip_pegawai . '_' . $data->bulan);

                $nama = '<a target="_blank" href="' . $href . '">' . $data->nama . '</a>';
                return $nama;
            })
            ->addColumn('gajiGross', function ($data) {


                $gajiGross =   $data->data_pokok + $data->uang_makan + $data->uang_transport;
                return 'Rp ' . number_format($gajiGross, 0, ',', '.');
            })
            ->addColumn('totalGaji', function ($data) {


                $totalGaji =  $data->uang_makan + $data->uang_transport + $data->gaji_pokok + $data->adjustment;
                return 'Rp ' . number_format($totalGaji, 0, ',', '.');
            })
            ->editColumn('bulan', function ($data) {


                $namaBulan = date('F', mktime(0, 0, 0, $data->bulan, 1));
                return $namaBulan;
            })
            ->editColumn('gaji_pokok', function ($data) {


                return 'Rp ' . number_format($data->gaji_pokok, 0, ',', '.');
            })
            ->editColumn('uang_makan', function ($data) {


                return 'Rp ' . number_format($data->uang_makan, 0, ',', '.');
            })
            ->editColumn('uang_transport', function ($data) {


                return 'Rp ' . number_format($data->uang_transport, 0, ',', '.');
            })
            ->editColumn('supervisor', function ($data) {


                return 'Rp ' . number_format($data->supervisor, 0, ',', '.');
            })
            ->editColumn('adjusment', function ($data) {


                return 'Rp ' . number_format($data->adjusment, 0, ',', '.');
            })
            ->editColumn('premi_bpjs_ket', function ($data) {


                return 'Rp ' . number_format($data->premi_bpjs_ket, 0, ',', '.');
            })
            ->editColumn('premi_bpjs_kes', function ($data) {


                return 'Rp ' . number_format($data->premi_bpjs_kes, 0, ',', '.');
            })
            ->editColumn('premi_jp', function ($data) {


                return 'Rp ' . number_format($data->premi_jp, 0, ',', '.');
            })
            ->editColumn('pot_bpjs_ket', function ($data) {


                return 'Rp ' . number_format($data->pot_bpjs_ket, 0, ',', '.');
            })
            ->editColumn('pot_bpjs_kes', function ($data) {


                return 'Rp ' . number_format($data->pot_bpjs_kes, 0, ',', '.');
            })
            ->editColumn('pot_jp', function ($data) {


                return 'Rp ' . number_format($data->pot_jp, 0, ',', '.');
            })
            ->editColumn('sisa_pinjaman', function ($data) {


                return 'Rp ' . number_format($data->sisa_pinjaman, 0, ',', '.');
            })
            ->rawColumns(['netto_gaji', 'pinjam', 'namas', 'gajiGross', 'totalGaji'])
            ->make(true);
    }

    public function dataGajiKontrak(Request $request)
    {
        $dataKontrak = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('pegawai.status_pegawai', 2)
            ->when($request->tahun, function ($query) use ($request) {
                $query->where('tahun', $request->tahun);
            })
            ->when($request->bulan, function ($query) use ($request) {
                $query->where('bulan', $request->bulan);
            })
            ->when($request->bulan && $request->tahun, function ($query) use ($request) {
                $query->where('bulan', $request->bulan);
                $query->where('tahun', $request->tahun);
            })
            ->get();

        $countKontrak = count($dataKontrak);

        if ($countKontrak > 0) {
            foreach ($dataKontrak as $key => $datas) {
                // dd($dataKontrak);
                $total_gaji = HitungGaji::hitungKontrak($datas->nip_pegawai, $datas->adjustment);
                $pph = HitungGaji::hitungPPH($datas->nip_pegawai, $datas->thr);
                $netto_kontrak = [$total_gaji - $pph];
                $total = $datas->gaji_gross_kontrak + $datas->adjustment;
                $total_gaji = $total - $datas->pot_bjs_kes - $datas->pot_bpjs_ket - $datas->pot_jp;
            }
        } else {
            $total_gaji = 0;
            $pph = 0;
            $total = 0;
            $netto_kontrak = 0;
        }


        return DataTables::of($dataKontrak)
            ->addColumn('netto_gaji', function ($data) {
                $total_gaji = HitungGaji::hitungKontrak($data->nip_pegawai, $data->adjustment);
                $pph = HitungGaji::hitungPPH($data->nip_pegawai, $data->thr);
                $netto_kontrak = $total_gaji - $pph;
                return 'Rp ' . number_format($netto_kontrak, 0, ',', '.');
            })
            ->addColumn('pinjam', function ($data) {
                if ($data->pinjaman === $data->sisa_pinjaman) {
                    return 'Rp ' . number_format(0, 0, ',', '.');
                } else {
                    return 'Rp ' . number_format($data->nominal_pinjaman, 0, ',', '.');
                }
            })
            ->addColumn('namas', function ($data) {
                $href = route('detailGaji', $data->nip_pegawai . '_' . $data->bulan);

                $nama = '<a target="_blank" href="' . $href . '">' . $data->nama . '</a>';
                return $nama;
            })
            ->addColumn('pph', function ($data) {


                $pph = HitungGaji::hitungPPH($data->nip_pegawai, $data->thr);
                return 'Rp ' . number_format($pph, 0, ',', '.');
            })
            ->addColumn('totalGaji', function ($data) {


                $totalGaji =  $data->gaji_gross_kontrak + $data->adjustment -  $data->pot_bjs_kes - $data->pot_bpjs_ket - $data->pot_jp;
                return 'Rp ' . number_format($totalGaji, 0, ',', '.');
            })
            ->editColumn('bulan', function ($data) {


                $namaBulan = date('F', mktime(0, 0, 0, $data->bulan, 1));
                return $namaBulan;
            })
            ->editColumn('gaji_pokok', function ($data) {


                return 'Rp ' . number_format($data->gaji_pokok, 0, ',', '.');
            })
            ->editColumn('uang_makan', function ($data) {


                return 'Rp ' . number_format($data->uang_makan, 0, ',', '.');
            })
            ->editColumn('uang_transport', function ($data) {


                return 'Rp ' . number_format($data->uang_transport, 0, ',', '.');
            })
            ->editColumn('supervisor', function ($data) {


                return 'Rp ' . number_format($data->supervisor, 0, ',', '.');
            })
            ->editColumn('adjusment', function ($data) {


                return 'Rp ' . number_format($data->adjusment, 0, ',', '.');
            })
            ->editColumn('premi_bpjs_ket', function ($data) {


                return 'Rp ' . number_format($data->premi_bpjs_ket, 0, ',', '.');
            })
            ->editColumn('premi_bpjs_kes', function ($data) {


                return 'Rp ' . number_format($data->premi_bpjs_kes, 0, ',', '.');
            })
            ->editColumn('premi_jp', function ($data) {


                return 'Rp ' . number_format($data->premi_jp, 0, ',', '.');
            })
            ->editColumn('pot_bpjs_ket', function ($data) {


                return 'Rp ' . number_format($data->pot_bpjs_ket, 0, ',', '.');
            })
            ->editColumn('pot_bpjs_kes', function ($data) {


                return 'Rp ' . number_format($data->pot_bpjs_kes, 0, ',', '.');
            })
            ->editColumn('pot_jp', function ($data) {


                return 'Rp ' . number_format($data->pot_jp, 0, ',', '.');
            })
            ->editColumn('sisa_pinjaman', function ($data) {


                return 'Rp ' . number_format($data->sisa_pinjaman, 0, ',', '.');
            })
            ->rawColumns(['netto_gaji', 'pinjam', 'namas', 'gajiGross', 'totalGaji'])
            ->make(true);
    }

    public function detailGaji($id)
    {
        // dd($id);
        $explode = explode('_', $id);
        // dd($explode[1]);
        $data = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            // ->leftJoin('pinjaman', 'pinjaman.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->where('gaji.nik_pegawai', $explode[0])
            ->where('gaji.bulan', $explode[1])
            ->first();
        // dd($data->gaji_pokok + $data->uang_makan + $data->uang_transport);
        // dd($data);
        if ($data->status_pegawai == 1) {
            # code...
            $netto_gaji = HitungGaji::hitungTetap($explode[0], $data->pinjaman, $data->adjustment, $data->supervisor, $explode[1]);
            $total_gaji = $data->uang_makan + $data->uang_transport + $data->gaji_pokok + $data->adjustment + $data->supervisor;
            $pph = 0;
        } else {
            $total = HitungGaji::hitungKontrak($explode[0], $data->adjustment);
            $pph = HitungGaji::hitungPPH($explode[0], $data->thr);
            // dd($pph);
            $netto_gaji = abs($total - $pph);
            $total_gaji = $data->gaji_gross_kontrak + $data->adjustment;
            // dd($total);
            // $total_gaji = $total - $data->pot_bjs_kes - $data->pot_bpjs_ket - $data->pot_jp;
        }
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
        $explode = explode('_', $id);
        $data = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('gaji.nik_pegawai', $explode[0])
            ->where('gaji.bulan', $explode[1])
            ->first();
        // dd($data->gaji_pokok + $data->uang_makan + $data->uang_transport);
        // dd($data->status_pegawai);
        if ($data->status_pegawai == 1) {
            # code...
            $netto_gaji = HitungGaji::hitungTetap($explode[0], $data->pinjaman, $data->adjustment, $data->supervisor, $explode[1]);
            $total_gaji = $data->uang_makan + $data->uang_transport + $data->gaji_pokok + $data->adjustment + $data->supervisor;
            $pph = 0;
        } else {
            $total_gaji = HitungGaji::hitungKontrak($explode[0], $data->adjustment);
            $pph = HitungGaji::hitungPPH($explode[0], $data->thr);
            $netto_gaji = abs($total_gaji - $pph);
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

        // $bulan = $request->bulan;
        // dd($bulan);
        $data = Excel::toArray([], $request->file('excel')->store('temp'), null, null, null, true)[0];
        $date = $data[0];
        $count_data = count($data);
        $times = array_slice($data, 1, $count_data);
        $jum = count($date);
        // dd($times);
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
        // dd($datas);
        try {

            foreach ($datas as $key => $value) {

                $bulan = Carbon::parse($value['tgl'])->format("m");
                $tahun = Carbon::parse($value['tgl'])->format("Y");
                $tanggal = Carbon::parse($value['tgl'])->format("d");
                if ($request->filter == $bulan) {
                    // dd($value);
                    // if ($value['in'] !== '00:00') {
                    $insert =  DetailAbsen::create([
                        'kode_absen' => $value['nik'],
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'tanggal' => $tanggal,
                        'masuk' => $value['in'],
                        'keluar' => $value['out'],
                    ]);
                    $this->hitungGaji($value['jumlah_kehadiran'], $value['nik'], $year, $bulan);
                    // }
                }
            }
            return redirect()->to('/kehadiran')->with('success', 'Import success!');
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
                // dd('true');
                try {
                    $hitung = HitungGaji::masterTetap($pegawai, $kode_absen, $kehadiran, $year, $bulan);
                    // dd($hitung);
                    //code...
                } catch (\Throwable $th) {
                    return $th->getMessage();
                }
            } elseif ($pegawai->status_pegawai == 2) {
                try {
                    HitungGaji::masterKontrak($pegawai, $kode_absen, $kehadiran, $year, $bulan);
                    // dd($hitung);
                    //code...
                } catch (\Throwable $th) {
                    return $th->getMessage();
                }

                // $detail_absen = DetailAbsen::where('kode_absen', $kode_absen)->first();

            }
        }
    }

    public function updateAbsen(Request $request)
    {
        $explode = explode('-', $request->tanggal);
        $tanggal = $explode[0];
        $bulan = $explode[1];
        $tahun = $explode[2];
        try {
            DetailAbsen::where('kode_absen', $request->kode_absen)
                ->where([
                    'tanggal' => $tanggal,
                    'bulan' => $bulan,
                    'tahun' => $tahun
                ])
                ->update(
                    [
                        'keterangan' => $request->ket_tdk_hadir
                    ]
                );
            // $data = Gaji::where('kode_absen', $request->kode_absen)
            //     ->where([
            //         'bulan' => $bulan,
            //         'tahun' => $tahun
            //     ])->first();
            // $status = StatusKaryawan::where('id', 1)->first();
            // Gaji::where('kode_absen', $request->kode_absen)
            //     ->where([
            //         'bulan' => $bulan,
            //         'tahun' => $tahun
            //     ])->update([
            //         'uang_makan' => ($data->jumlah_masuk - 1) * $status->uang_makan,
            //         'uang_transport' => ($data->jumlah_masuk - 1) * $status->uang_transport,
            //     ]);
            return redirect()->back()->with('success', 'Successfully updated');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
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
