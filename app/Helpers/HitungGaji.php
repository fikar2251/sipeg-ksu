<?php

namespace App\Helpers;

use App\Models\Pegawai;
use App\Models\StatusKaryawan;
use App\Models\Umr;

class HitungGaji
{
    public static function hitung($kehadiran, $kode_absen, $year)
    {
        $data = Pegawai::where('kode_absen', $kode_absen)->first();
        $status_karyawan = StatusKaryawan::where('id', $data->status_karyawan)->first();

        //total gaji
        $uang_makan = $kehadiran * $status_karyawan->uang_makan;
        $uang_transport = $kehadiran * $status_karyawan->uang_transport;
        $gaji_gross = $status_karyawan->gaji_pokok + $uang_makan + $uang_transport;
        $adjustment = 10000;
        $total_gaji = $gaji_gross + $adjustment;

        //premi
        $bpjs_ket = 12888 + 16110 + 198690;
        $umr = Umr::where('tahun', $year)->first();
        if ($status_karyawan->gaji_pokok < $umr->nominal) {
            $bpjs_kes = round($umr->nominal * $status_karyawan->premi_bpjs_kes_max / 100);
        } elseif ($status_karyawan->gaji_pokok > $umr->nominal) {
            $bpjs_kes = round($status_karyawan->gaji_pokok * $status_karyawan->premi_bpjs_kes_max / 100);
        }

        if ($status_karyawan->gaji_pokok < $status_karyawan->premi_jp_nilai) {
            $premi_jp = round($status_karyawan->gaji_pokok * $status_karyawan->premi_jp_max / 100);
        } elseif ($status_karyawan->gaji_pokok > $status_karyawan->premi_jp_nilai) {
            $premi_jp = round($status_karyawan->premi_jp_nilai * $status_karyawan->premi_jp_max / 100);
        }

        //potongan
        $pot_bpjs_ket = $status_karyawan->gaji_pokok * $status_karyawan->pot_bpjs_ket / 100;
        if ($status_karyawan->gaji_pokok < $umr->nominal) {
            $pot_bpjs_kes = round($umr->nominal * $status_karyawan->pot_bpjs_kes_max / 100, 0);
        } elseif ($status_karyawan->gaji->pokok > $umr->nominal) {
            $pot_bpjs_kes =  round($status_karyawan->gaji->pokok * $status_karyawan->pot_bpjs_kes_max / 100);
        }

        if ($status_karyawan->gaji_pokok < $status_karyawan->pot_jp_nilai) {
            $pot_jp = round($status_karyawan->gaji_pokok * $status_karyawan->pot_jp_max / 100);
        } elseif ($status_karyawan->gaji_pokok > $status_karyawan->pot_jp_nilai) {
            $pot_jp = round($status_karyawan->pot_jp_nilai * $status_karyawan->pot_jp_max / 100);
        }

        $pinjaman = 20000;

        //netto gaji
        $netto_gaji = $total_gaji - $pot_bpjs_ket - $pot_bpjs_kes - $pot_jp - $pinjaman;

        return $netto_gaji;
    }
}
