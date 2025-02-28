<?php

namespace App\Http\Controllers;

use App\Models\DetailAbsen;
use App\Models\Gaji;
use App\Models\LemburAbsen;
use App\Models\Pegawai;
use App\Models\StatusKaryawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\HitungLembur;
use App\Models\Lembur;
use Illuminate\Support\Facades\Session as Session;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestPayloadValueResolver;

class LemburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai =  Pegawai::where('kode_absen', 001)->first();
        $data = DetailAbsen::where('kode_absen', $pegawai->kode_absen)->get();
        $datas = DetailAbsen::all();
        $status =  StatusKaryawan::where('id', $pegawai->status_pegawai)->first();
        $startDate = '2023-9-15';
        $endDate = '2023-9-17';
        $range = DB::table('gaji_absen')->whereBetween(DB::raw("CONCAT (tahun, '-', bulan, '-', tanggal)"), [$startDate, $endDate])->get();

        if ($pegawai->status_pegawai == 1) {
            foreach ($data as $key => $value) {

                $defaultDate = Carbon::parse($value->tahun . '-' . $value->bulan . '-' . $value->tanggal);

                // Waktu awal
                $waktuAwal = Carbon::parse($defaultDate->format('Y-m-d') . $value->masuk);


                // Waktu akhir
                $waktuAkhir = Carbon::parse($defaultDate->format('Y-m-d') . $value->keluar);

                // Upah per jam
                $upahPerJam = round($pegawai->gaji_pokok / 173);

                // Daftar tanggal libur nasional (gantilah sesuai kebutuhan Anda)
                $liburNasional = [
                    '2023-12-25', // Contoh: Hari Natal
                    // Tambahkan tanggal-tanggal libur nasional lainnya di sini
                ];

                // Menentukan apakah hari ini adalah hari libur nasional
                $isLiburNasional = in_array($waktuAwal->format('Y-m-d'), $liburNasional);

                // Menghitung upah berdasarkan kondisi yang berlaku
                $upahTotal = 0;
                $jml_lembur = 0;
                // Jika hari bukan Sabtu, Minggu, atau hari libur nasional
                if (!$isLiburNasional && !in_array($waktuAwal->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                    $waktuMulaiPerhitungan = Carbon::parse($waktuAwal->format('Y-m-d') . ' 16:30:00');
                    $duration = $waktuMulaiPerhitungan->diffInHours($waktuAkhir);
                    if ($duration >= 4) {
                        $uangMakan = 1;
                        $uangMakanTransport = 0;
                    } else {
                        $uangMakan = 0;
                        $uangMakanTransport = 0;
                    }

                    // Hitung upah untuk jam pertama (1,5x upah per jam)
                    if ($duration >= 1) {
                        $upahTotal += (1.5 * $upahPerJam);
                        $duration -= 1; // Mengurangkan 60 menit (1 jam) dari durasi
                        $jml_lembur += 1.5;
                    }

                    // Hitung upah untuk jam-jam berikutnya (2x upah per jam)
                    if ($duration > 0) {
                        $upahTotal += ($duration * 2 * $upahPerJam);
                        $jml_lembur += $duration * 2;
                    }



                    // dd($upahTotal);
                    $keterangan = 'hari biasa';
                } else {
                    // Jika hari Sabtu, Minggu, atau hari libur nasional
                    if ($value->keluar == '16:30:00') {
                        $duration = 8;
                    } else {

                        $duration = $waktuAwal->diffInHours($waktuAkhir);
                    }
                    if ($duration >= 4) {
                        $uangMakanTransport = 1;
                        $uangMakan = 0;
                    } else {
                        $uangMakanTransport = 0;
                        $uangMakan = 0;
                    }

                    // dd($duration);

                    // Hitung upah berdasarkan rumus sesuai dengan durasi waktu
                    // for ($i = 1; $i <= $duration; $i++) {
                    //     if ($i == 1) {
                    //         $upahTotal += (2 * $upahPerJam);
                    //     } elseif ($i == 9) {
                    //         $upahTotal += (3 * $upahPerJam);
                    //     } else {
                    //         $upahTotal += (4 * $upahPerJam);
                    //     }
                    // }

                    // Hitung upah untuk jam pertama (1,5x upah per jam)
                    // dd($duration);
                    for ($i = 1; $i <= $duration; $i++) {
                        if ($i <= 8) {
                            $upahTotal += (2 * $upahPerJam);
                        } elseif ($i == 9) {
                            $upahTotal += (3 * $upahPerJam);
                        } else {
                            $upahTotal += (4 * $upahPerJam);
                        }
                    }

                    if ($duration > 8 && $duration <= 9) {
                        $jml_lembur += (8 * 2);
                        $jml_lembur += (1 * 3);
                    } elseif ($duration > 9) {
                        $jml_lembur += (8 * 2);
                        $jml_lembur += (1 * 3);
                        $jml_lembur += (($duration - 9) * 4);
                    } else {
                        $jml_lembur += (8 * 2);
                    }
                    // dd($upahTotal);
                    $keterangan = 'hari libur';
                }
                $datas[] = [
                    'upah' => $upahTotal,
                    'durasi' => $duration,
                    'uang_makan' => $uangMakan,
                    'uang_makan_transport' => $uangMakanTransport,
                    'keterangan' => $keterangan,
                    'jml_lembur' => $jml_lembur,
                ];
            }
        } elseif ($pegawai->status_pegawai == 2) {
            foreach ($data as $key => $value) {
                # code...

                $defaultDate = Carbon::parse($value->tahun . '-' . $value->bulan . '-' . $value->tanggal);

                // Waktu awal
                $waktuAwal = Carbon::parse($defaultDate->format('Y-m-d') . $value->masuk);


                // Waktu akhir
                $waktuAkhir = Carbon::parse($defaultDate->format('Y-m-d') . $value->keluar);

                // Upah per jam
                $upahPerJam = $pegawai->gaji_pokok / 8;

                $waktuMulaiPerhitungan = Carbon::parse($waktuAwal->format('Y-m-d') . ' 16:30:00');
                $duration = $waktuMulaiPerhitungan->diffInHours($waktuAkhir);

                $upahTotal = $duration * $upahPerJam;

                $datas[] = [
                    'upah' => $upahTotal,
                    'durasi' => $duration,
                    'uang_makan' => 0,
                    'uang_makan_transport' => 0,
                    'jml_lembur' => $duration,
                ];
            }
        } elseif ($pegawai->nip_pegawai == '15102010-19') {
            $jml_lembur = 0;
            foreach ($data as $key => $value) {
                # code...

                $defaultDate = Carbon::parse($value->tahun . '-' . $value->bulan . '-' . $value->tanggal);

                // Waktu awal
                $waktuAwal = Carbon::parse($defaultDate->format('Y-m-d') . $value->masuk);


                // Waktu akhir
                $waktuAkhir = Carbon::parse($defaultDate->format('Y-m-d') . $value->keluar);

                // Upah per jam
                $upahPerJam = ($pegawai->gaji_pokok * 22 - 660000) / 173;

                // Daftar tanggal libur nasional (gantilah sesuai kebutuhan Anda)
                $liburNasional = [
                    '2023-12-25', // Contoh: Hari Natal
                    // Tambahkan tanggal-tanggal libur nasional lainnya di sini
                ];

                // Menentukan apakah hari ini adalah hari libur nasional
                $isLiburNasional = in_array($waktuAwal->format('Y-m-d'), $liburNasional);

                // Menghitung upah berdasarkan kondisi yang berlaku
                $upahTotal = 0;

                // Jika hari bukan Sabtu, Minggu, atau hari libur nasional
                if (!$isLiburNasional && !in_array($waktuAwal->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                    $waktuMulaiPerhitungan = Carbon::parse($waktuAwal->format('Y-m-d') . ' 16:30:00');
                    $duration = $waktuMulaiPerhitungan->diffInHours($waktuAkhir);
                    // Hitung upah untuk jam pertama (1,5x upah per jam)
                    if ($duration >= 1) {
                        $upahTotal += (1.5 * $upahPerJam);
                        $duration -= 1; // Mengurangkan 60 menit (1 jam) dari durasi
                        $jml_lembur += 1.5;
                    }
                    // Hitung upah untuk jam-jam berikutnya (2x upah per jam)
                    if ($duration > 0) {
                        $upahTotal += ($duration * 2 * $upahPerJam);
                        $jml_lembur += $duration * 2;
                    }


                    // dd($upahTotal);
                    $keterangan = 'hari biasa';
                } else {
                    // Jika hari Sabtu, Minggu, atau hari libur nasional
                    if ($value->keluar == '16:30:00') {
                        $duration = 8;
                    } else {

                        $duration = $waktuAwal->diffInHours($waktuAkhir);
                    }
                    // dd($duration);

                    // Hitung upah berdasarkan rumus sesuai dengan durasi waktu
                    // for ($i = 1; $i <= $duration; $i++) {
                    //     if ($i == 1) {
                    //         $upahTotal += (2 * $upahPerJam);
                    //     } elseif ($i == 9) {
                    //         $upahTotal += (3 * $upahPerJam);
                    //     } else {
                    //         $upahTotal += (4 * $upahPerJam);
                    //     }
                    // }

                    // Hitung upah untuk jam pertama (1,5x upah per jam)
                    for ($i = 1; $i <= $duration; $i++) {
                        if ($i <= 8) {
                            $upahTotal += (2 * $upahPerJam);
                        } else {
                            $upahTotal += (4 * $upahPerJam);
                        }
                    }

                    if ($duration > 8 && $duration <= 9) {
                        $jml_lembur += (8 * 2);
                        $jml_lembur += (1 * 3);
                    } else {
                        $jml_lembur += (8 * 2);
                    }

                    $keterangan = 'hari libur';
                }
                $datas[] = [
                    'upah' => $upahTotal,
                    'durasi' => $duration,
                    'uang_makan' => 0,
                    'uang_makan_transport' => 0,
                    'keterangan' => $keterangan,
                    'jml_lembur' => $jml_lembur,
                ];
            }
        } elseif ($pegawai->nip_pegawai == '28042014-23') {
        }

        $totalUpah = 0;
        $totalUangMakan = 0;
        $totalUangMakanTransport = 0;
        foreach ($datas as $key => $data) {
            $totalUpah += $data['upah'];
            $totalUangMakan += $data['uang_makan'];
            $totalUangMakanTransport += $data['uang_makan_transport'];
        }

        $pembulatanUpah = round($totalUpah);
        $upahUangMakan = $status->uang_makan * $totalUangMakan;
        $upahUangMakanTransport = ($status->uang_transport + $status->uang_makan) * $totalUangMakanTransport;

        $total = $pembulatanUpah + $upahUangMakan + $upahUangMakanTransport;
        // dd($datas);

        return view('lembur.index');
    }

    public function import()
    {
        return view('lembur.import');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $bulan = $request->bulan;
        $data = Excel::toArray([], $request->file('excel')->store('temp'), null, null, null, true)[0];
        // dd($data);
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
                        'jumlah_kehadiran' => $value[6],
                        // 'keterangan' => $value[7],
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
                // if ($request->filter == $bulan) {
                // dd($value);
                if ($value['in'] !== '00:00') {
                    $insert =  LemburAbsen::create([
                        'kode_absen' => $value['nik'],
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'tanggal' => $tanggal,
                        'masuk' => $value['in'],
                        'keluar' => $value['out'],
                        // 'keterangan' => $value['keterangan'],
                    ]);
                    // $dataPegawai = Pegawai::where('kode_absen', $value['nik'])->first();
                    // $dataLembur = Lembur::where('nip_pegawai', $dataPegawai->nip_pegawai)->first();
                    // if ($dataPegawai->status_pegawai == 1) {
                    //     if ($dataLembur === null) {
                    //         HitungLembur::hitungLemburTetap($value['nik']);
                    //     }
                    // }elseif($dataPegawai->status_pegawai == 2){
                    //     HitungLembur::hitungLemburKontrak($value['nik']);
                    // }
                    // $this->hitungGaji($value['jumlah_kehadiran'], $value['nik'], $year, $bulan);
                }
                // }
            }
            return redirect()->to('/importlembur')->with('success', 'Import success!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function lemburAll()
    {
        $lemburAbsen = LemburAbsen::all();
        if (!$lemburAbsen->isEmpty()) {
            # code...
            foreach ($lemburAbsen as $key => $value) {
                $pegawai = Pegawai::where('kode_absen', $value->kode_absen)->first();
                // dd($value->kode_absen);
                if ($pegawai->status_pegawai ==  1) {
                    $dataLembur[] = HitungLembur::hitungLemburTetap($value->kode_absen);
                } else {
                    $dataLembur[] = HitungLembur::hitungLemburKontrak($value->kode_absen);
                }
            }
            $total_tanggal = [];
            // dd($lemburAbsen);
        } else {

            $dataLembur[] = [];
            $total_tanggal = [];
        }


        return view('lembur.index', compact('dataLembur', 'total_tanggal'));
    }

    public function filterLembur(Request $request)
    {
        $awal = request()->get('periodeawal');
        $akhir = request()->get('periodeakhir');

        $periodeAwal = Carbon::parse($awal)->format('d');
        $periodeAkhir = Carbon::parse($akhir)->format('d');

        $periodeAwalBulan = Carbon::parse($awal)->format('m');
        $periodeAkhirBulan = Carbon::parse($akhir)->format('m');
        // dd($periodeAwal);

        $lemburAbsen = LemburAbsen::whereBetween('tanggal', [$periodeAwal, $periodeAkhir])
            ->whereBetween('bulan', [$periodeAwalBulan, $periodeAkhirBulan])
            ->get();
        // dd($lemburAbsen);
        if (!$lemburAbsen->isEmpty()) {
            // dd('true');
            // $collect =  collect($dataLembur);
            $lembur = $lemburAbsen->unique(function ($item) {
                return $item->kode_absen;
            });
            // dd($uniqueArray);
            // dd($lembur);
            if (!$lembur->isEmpty()) {
                # code...
                foreach ($lembur as $key => $value) {
                    $pegawai = Pegawai::where('kode_absen', $value->kode_absen)->first();
                    if ($pegawai->status_pegawai ==  1) {
                        $dataTetap = HitungLembur::hitungLemburTetap($value->kode_absen, $periodeAwal, $periodeAkhir);
                        $dataLembur[] = $dataTetap;
                    } else {
                        $dataKontrak = HitungLembur::hitungLemburKontrak($value->kode_absen, $periodeAwal, $periodeAkhir);
                        $dataLembur[] = $dataKontrak;
                    }
                    // break;
                };
                $grand_totals = 0;
                foreach ($dataLembur as $value) {
                    foreach ($value as $values) {
                        $grand_totals += $values['total'];
                    }
                }

                $rudianto = LemburAbsen::select('pegawai.*', 'lembur_absen.*', 'status_pekerjaan.nama as nama_status', 'jabatan.nama as nama_jabatan')
                    // ->join('gaji_absen', 'gaji.kode_absen', '=', 'gaji_absen.kode_absen')
                    ->join('pegawai', 'pegawai.kode_absen', '=', 'lembur_absen.kode_absen')
                    ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'pegawai.status_pegawai')
                    ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
                    ->where('lembur_absen.kode_absen', '020')
                    ->whereBetween('tanggal', [$periodeAwal, $periodeAkhir])
                    ->whereBetween('bulan', [$periodeAwalBulan, $periodeAkhirBulan])
                    ->first();

                $lemburRudianto = LemburAbsen::select('lembur_absen.*', 'pegawai.*', 'lembur_absen.bulan as bulan_lembur', 'status_pekerjaan.nama as nama_status', 'jabatan.nama as nama_jabatan')
                    ->join('pegawai', 'pegawai.kode_absen', '=', 'lembur_absen.kode_absen')
                    ->join('gaji', 'gaji.kode_absen', '=', 'pegawai.kode_absen')
                    ->join('status_pekerjaan', 'status_pekerjaan.id', '=', 'pegawai.status_pegawai')
                    ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
                    ->get();
                // dd($lemburRudianto);
                $total = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                $totals = 7;
                for ($i = 0; $i < $total; $i++) {
                    $total_tanggal[] = $i + 1;
                }

                // dd($lemburRudianto);
                // dd($data2);
                // dd($totals);
                // dd($dataLembur);

                // dd($data);
                // $dataLembur = array_unique($data);

            } else {

                $dataLembur[] = [];
                $totals = 0;
                $rudianto = [];
                $total_tanggal = [];
                $lemburRudianto = [];
                $grand_totals = 0;
                // dd('salah');

                // return view('lembur.index', compact('dataLembur', 'totals', 'rudianto', 'total_tanggal', 'lemburRudianto', 'grand_totals'))->with('sweet-warning', 'Data Tidak ada');
            }



            // dd($dataLembur);
            Session::put('success', 'Sukses');
            Session::forget('success');
            return view('lembur.index', compact('dataLembur', 'totals', 'rudianto', 'total_tanggal', 'lemburRudianto', 'grand_totals'))->with('success', 'Sukses!');
        } else {
            // dd('salah');
            $dataLembur[] = [];
            $totals = 0;
            $rudianto = [];
            $total_tanggal = [];
            $lemburRudianto = [];
            $grand_totals = 0;
            Session::put('error', 'data tidak ada');
            Session::forget('error');
            // dd(Session::get('error'));
            return view('lembur.index', compact('dataLembur', 'totals', 'rudianto', 'total_tanggal', 'lemburRudianto', 'grand_totals'))->with('error', 'Data Tidak ada');
        }


        // dd($periodeAwal);
    }

    public function updateAbsen(Request $request)
    {
        $explode = explode('-', $request->tanggal);
        $tanggal = $explode[0];
        $bulan = $explode[1];
        $tahun = $explode[2];
        try {
            LemburAbsen::where('kode_absen', $request->kode_absen)
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
            // dd('true');
            // return redirect()->route('lemburFilter')->withInput([
            //     'periodeawal' => $request->awal,
            //     'periodeakhir' => $request->akhir,
            // ]);
            // return back()->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
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
}
