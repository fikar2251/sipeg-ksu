<?php

namespace App\Http\Controllers;

use App\Helpers\HitungGaji;
use App\Mail\GajiMail;
use App\Models\Gaji;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $pegawai = Pegawai::all();
        $pegawai = Gaji::select('pegawai.*', 'gaji.*')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->get();
        return view('gaji.sendslip', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function kirimGaji(Request $request)
    {
        if ($request->karyawan === 'all') {
            // dd('true');
            # code...


            $dataGaji = Gaji::where('bulan', $request->bulan)->where('tahun', $request->tahun)->get();
            if ($dataGaji->isEmpty()) {
                return redirect()->back()->with('error', 'Data tidak ada!');
            } else {
                try {
                    foreach ($dataGaji as $key => $value) {
                        // dd('trues');
                        // try {
                        //code...

                        $data = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
                            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
                            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
                            ->where('gaji.nik_pegawai', $value->nik_pegawai)
                            ->where('gaji.bulan', $value->bulan)
                            ->first();
                        // dd($data);
                        // } catch (\Throwable $th) {
                        //     return redirect()->back()->with('error', 'Data Tidak Ada!');
                        // }
                        // $explode = explode('_', $value->nik_pegawai);
                        // dd($data);
                        // dd($data->gaji_pokok + $data->uang_makan + $data->uang_transport);
                        // dd($data->status_pegawai);
                        if ($data->status_pegawai == 1) {
                            # code...
                            $netto_gaji = HitungGaji::hitungTetap($value->nik_pegawai, $data->pinjaman, $data->adjustment, $data->supervisor, $value->bulan);
                            $total_gaji = $data->uang_makan + $data->uang_transport + $data->gaji_pokok + $data->adjustment + $data->supervisor;
                            $pph = 0;
                        } else {
                            $total_gaji = HitungGaji::hitungKontrak($value->nik_pegawai, $data->adjustment);
                            $pph = HitungGaji::hitungPPH($value->nik_pegawai, $data->thr);
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
                        if ($value->bulan == 1) {
                            $bulan = 'Januari';
                        } elseif ($value->bulan == 2) {
                            $bulan = 'Februari';
                        } elseif ($value->bulan == 3) {
                            $bulan = 'Maret';
                        } elseif ($value->bulan == 4) {
                            $bulan = 'April';
                        } elseif ($value->bulan == 5) {
                            $bulan = 'Mei';
                        } elseif ($value->bulan == 6) {
                            $bulan = 'Juni';
                        } elseif ($value->bulan == 7) {
                            $bulan = 'Juli';
                        } elseif ($value->bulan == 8) {
                            $bulan = 'Agustus';
                        } elseif ($value->bulan == 10) {
                            $bulan = 'Oktober';
                        } elseif ($value->bulan == 11) {
                            $bulan = 'November';
                        } else {
                            $bulan = 'Desember';
                        }
                        // dd($bulan);
                        //code...
                        $pdf = Pdf::loadView('gaji.cetak', $print)->setPaper('a4', 'portrait');
                        $pdf->save(public_path('files/' . $value->nik_pegawai . '.pdf'));
                        Mail::to($data->email)->send(new GajiMail($value->nik_pegawai, $data->nama, $bulan, $value->tahun));
                        File::delete(public_path('files/' . $value->nik_pegawai . '.pdf'));
                    }
                    return redirect()->back()->with('success', 'Slip gaji berhasil terkirim');
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', $th->getMessage());
                }
            }
            // dd($dataGaji);

            // dd($data);

        } else {
            //code...
            $dataGaji = Gaji::where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->where('nik_pegawai', $request->karyawan)
                ->first();
            try {
                //code...
                $data = Gaji::select('gaji.*', 'pegawai.*', 'jabatan.nama as nama_jabatan')
                    ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
                    ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
                    ->where('gaji.nik_pegawai', $dataGaji->nik_pegawai)
                    ->where('gaji.bulan', $dataGaji->bulan)
                    ->first();
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Data Tidak ada!');
            }
            // dd($data->gaji_pokok + $data->uang_makan + $data->uang_transport);
            // dd($data->status_pegawai);
            if ($data->status_pegawai == 1) {
                # code...
                $netto_gaji = HitungGaji::hitungTetap($dataGaji->nik_pegawai, $data->pinjaman, $data->adjustment, $data->supervisor, $dataGaji->bulan);
                $total_gaji = $data->uang_makan + $data->uang_transport + $data->gaji_pokok + $data->adjustment + $data->supervisor;
                $pph = 0;
            } else {
                $total_gaji = HitungGaji::hitungKontrak($dataGaji->nik_pegawai, $data->adjustment);
                $pph = HitungGaji::hitungPPH($dataGaji->nik_pegawai, $data->thr);
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
            try {
                // switch ($dataGaji->bulan) {
                //     case 1:
                //         $bulan = 'Januari';
                //     case 2:
                //         $bulan = 'Februari';
                //     case 3:
                //         $bulan = 'Maret';
                //     case 4:
                //         $bulan = 'April';
                //     case 5:
                //         $bulan = 'Mei';
                //     case 6:
                //         $bulan = 'Juni';
                //     case 7:
                //         $bulan = 'Juli';
                //     case 8:
                //         $bulan = 'Agustus';
                //     case 9:
                //         $bulan = 'September';
                //     case 10:
                //         $bulan = 'Oktober';
                //     case 11:
                //         $bulan = 'November';
                //     case 12:
                //         $bulan = 'Desember';
                //         break;

                //     default:
                //         # code...
                //         break;
                // }
                if ($dataGaji->bulan == 1) {
                    $bulan = 'Januari';
                } elseif ($dataGaji->bulan == 2) {
                    $bulan = 'Februari';
                } elseif ($dataGaji->bulan == 3) {
                    $bulan = 'Maret';
                } elseif ($dataGaji->bulan == 4) {
                    $bulan = 'April';
                } elseif ($dataGaji->bulan == 5) {
                    $bulan = 'Mei';
                } elseif ($dataGaji->bulan == 6) {
                    $bulan = 'Juni';
                } elseif ($dataGaji->bulan == 7) {
                    $bulan = 'Juli';
                } elseif ($dataGaji->bulan == 8) {
                    $bulan = 'Agustus';
                } elseif ($dataGaji->bulan == 10) {
                    $bulan = 'Oktober';
                } elseif ($dataGaji->bulan == 11) {
                    $bulan = 'November';
                } else {
                    $bulan = 'Desember';
                }
                // dd($bulan);
                //code...
                $pdf = Pdf::loadView('gaji.cetak', $print)->setPaper('a4', 'portrait');
                $pdf->save(public_path('files/' . $dataGaji->nik_pegawai . '.pdf'));
                Mail::to($data->email)
                    ->send(new GajiMail($dataGaji->nik_pegawai, $data->nama, $bulan, $dataGaji->tahun));
                File::delete(public_path('files/' . $dataGaji->nik_pegawai . '.pdf'));
                return redirect()->back()->with('success', 'Slip gaji berhasil terkirim');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
        }
    }
}
