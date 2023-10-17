<?php

namespace App\Helpers;

use App\Models\DetailAbsen;
use App\Models\Lembur;
use App\Models\LemburAbsen;
use App\Models\Pegawai;
use App\Models\StatusKaryawan;
use Carbon\Carbon;

class HitungLembur
{
    public static function hitungLemburTetap($kode_absen)
    {
        $pegawai =  Pegawai::where('kode_absen', $kode_absen)->first();
        $data = LemburAbsen::where('kode_absen', $pegawai->kode_absen)->get();
        $status =  StatusKaryawan::where('id', $pegawai->status_pegawai)->first();
        // $data = Carbon::between('2023-09-30', '2023-10-02')

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

        $totalUpah = 0;
        $totalUangMakan = 0;
        $totalUangMakanTransport = 0;
        foreach ($datas as $key => $data) {
            $totalUpah += $data['upah'];
            $totalUangMakan += $data['uang_makan'];
            $totalUangMakanTransport += $data['uang_makan_transport'];
            $keterangans = $data['keterangan'];
        }

        $pembulatanUpah = round($totalUpah);
        $upahUangMakan = $status->uang_makan * $totalUangMakan;
        $upahUangMakanTransport = ($status->uang_transport + $status->uang_makan) * $totalUangMakanTransport;

        $total = $pembulatanUpah + $upahUangMakan + $upahUangMakanTransport;
        $dataFinal[] = [
            'nip_pegawai' => $pegawai->nip_pegawai,
            'nama' => $pegawai->nama,
            'kode_absen' => $pegawai->kode_absen,
            'upah_per_jam' => $upahPerJam,
            'jml_lembur' => $jml_lembur,
            'upah' => $totalUpah,
            'pembulatan_upah' => $pembulatanUpah,
            'um' => $status->uang_makan,
            'jml_umb' => $totalUangMakan,
            'umb' => $upahUangMakan,
            'umt' => $status->uang_transport + $status->uang_makan,
            'jml_uml' => $totalUangMakanTransport,
            'uml' => $upahUangMakanTransport,
            'total' => $total,
            'durasi' => $data['durasi'],
            'keterangan' => $keterangans
        ];

        return $dataFinal;
    }

    public static function hitungLemburKontrak($kode_absen)
    {
        $pegawai =  Pegawai::where('kode_absen', $kode_absen)->first();
        $data = LemburAbsen::where('kode_absen', $pegawai->kode_absen)->get();
        $status =  StatusKaryawan::where('id', $pegawai->status_pegawai)->first();

        if ($pegawai->nip_pegawai == '15102010-19') {
            // dd('trueee');
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
            foreach ($data as $key => $value) {
                if ($value->keterangan == 1) {
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
                        'keterangan' => 'Karyawan Kontrak',
                    ];
                } else {
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
                                $uangMakan = 0;
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
                                $uangMakanTransport = 0;
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
                }
            }
        } else {
            // dd('true');
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
                    'keterangan' => 'Karyawan Kontrak',
                ];
            }
        }
        $totalUpah = 0;
        $totalUangMakan = 0;
        $totalUangMakanTransport = 0;
        foreach ($datas as $key => $data) {
            $totalUpah += $data['upah'];
            $totalUangMakan += $data['uang_makan'];
            $totalUangMakanTransport += $data['uang_makan_transport'];
            $keterangans = $data['keterangan'];
            $jml_lembur = $data['jml_lembur'];
        }

        $pembulatanUpah = round($totalUpah);
        $upahUangMakan = $status->uang_makan * $totalUangMakan;
        $upahUangMakanTransport = ($status->uang_transport + $status->uang_makan) * $totalUangMakanTransport;

        $total = $pembulatanUpah + $upahUangMakan + $upahUangMakanTransport;
        $dataFinal[] = [
            'nip_pegawai' => $pegawai->nip_pegawai,
            'nama' => $pegawai->nama,
            'kode_absen' => $pegawai->kode_absen,
            'upah_per_jam' => $upahPerJam,
            'jml_lembur' => $jml_lembur,
            'upah' => $totalUpah,
            'pembulatan_upah' => $pembulatanUpah,
            'um' => $status->uang_makan,
            'jml_umb' => $totalUangMakan,
            'umb' => $upahUangMakan,
            'umt' => $status->uang_transport + $status->uang_makan,
            'jml_uml' => $totalUangMakanTransport,
            'uml' => $upahUangMakanTransport,
            'total' => $total,
            'durasi' => $data['durasi'],
            'keterangan' => $keterangans
        ];

        return $dataFinal;
    }
}
