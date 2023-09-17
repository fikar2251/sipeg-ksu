<?php

namespace App\Helpers;

use App\Models\DetailAbsen;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\PPH;
use App\Models\PTKP;
use App\Models\StatusKaryawan;
use App\Models\Umr;
use Carbon\Carbon;

class HitungGaji
{
    public static function hitungTetap($nip, $pinjaman, $adjustment, $supervisor)
    {
        $gaji = Gaji::where('nik_pegawai', $nip)->first();
        $pegawai = Pegawai::where('nip_pegawai', $nip)->first();
        // dd($pegawai->nip_pegawai);
        // die;
        if ($gaji->keterangan_adjustment == 'tambah') {
            # code...
            $total_gaji = $gaji->uang_makan + $gaji->uang_transport + $pegawai->gaji_pokok + $adjustment + $supervisor;
        }elseif ($gaji->keterangan_adjustment == 'kurang') {
            $total_gaji = $gaji->uang_makan + $gaji->uang_transport + $pegawai->gaji_pokok - $adjustment + $supervisor;
        }else {
            $total_gaji = $gaji->uang_makan + $gaji->uang_transport + $pegawai->gaji_pokok + $adjustment + $supervisor;
        }
        //netto gaji
        $netto_gaji = $total_gaji - $gaji->pot_bpjs_ket - $gaji->pot_bpjs_kes - $gaji->pot_jp - $pinjaman;

        return $netto_gaji;
    }

    public static function hitungKontrak($nip, $adjustment)
    {
        $gaji = Gaji::where('nik_pegawai', $nip)->first();
        $pegawai = Pegawai::where('nip_pegawai', $nip)->first();
        // $total_gaji = $gaji->uang_makan + $gaji->uang_transport + $pegawai->gaji_pokok + $adjustment;
        //netto gaji
        if ($gaji->keterangan_adjustment == 'tambah') {
            # code...
            $total = $gaji->gaji_gross_kontrak + $adjustment;
        }elseif ($gaji->keterangan_adjustment == 'kurang') {
            # code...
            $total = $gaji->gaji_gross_kontrak - $adjustment;
        }else {
            $total = $gaji->gaji_gross_kontrak + $adjustment;
        }
        $total_gaji = $total - $gaji->pot_bpjs_kes - $gaji->pot_bpjs_ket - $gaji->pot_jp;

        return $total_gaji;
    }

    public static function hitungPPH($nip, $thr)
    {
        $data =  Gaji::select('gaji.*', 'pegawai.*', 'jabatan.persentase as persen_jabatan', 'jabatan.biaya_jabatan_max as nilai_jabatan')
            ->join('pegawai', 'pegawai.nip_pegawai', '=', 'gaji.nik_pegawai')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('gaji.nik_pegawai', $nip)->first();
        //gaji bruto
        $tun_bpjs_ket = $data->premi_bpjs_ket + $data->premi_jp;
        $tun_bpjs_kes = $data->premi_bpjs_kes;
        $gaji_bruto = $tun_bpjs_kes + $tun_bpjs_ket + $data->gaji_gross_kontrak;
        $tgl_masuk_kerja = Carbon::parse($data->tanggal_masuk_kerja)->format("m");
        // dd($tgl_masuk_kerja);
        //pengurangan
        $biaya_jabatan = round($gaji_bruto * $data->persen_jabatan / 100);
        if ($biaya_jabatan > $data->nilai_jabatan) {
            $biaya_jabatan = $data->nilai_jabatan;
        }
        $peng_bpjs_ket = $data->pot_bpjs_ket + $data->pot_jp;
        $peng_bpjs_kes = $data->pot_bpjs_kes;
        $pengurangan = $biaya_jabatan + $peng_bpjs_kes + $peng_bpjs_ket;
        

        //netto gaji disetahunkan
        if ($tgl_masuk_kerja == 02) {
            # code...
            $netto_gaji_setahun = ((($gaji_bruto - $thr) - $pengurangan) * 11) +  $thr;
        } else {
            $netto_gaji_setahun = ((($gaji_bruto - $thr) - $pengurangan) * 12) +  $thr;
        }
        
        //ptkp setahun
        $ptkp =  PTKP::where('type', $data->ptkp)->first();
        
        //pkp setahun
        $pkp = $netto_gaji_setahun - $ptkp->nilai;
        
        //pkp tanpa thr
        $pkp_tanpa_thr = $pkp - $thr;
        
        //pph-21 tanpa thr
        $pph = PPH::all();
        foreach ($pph as $key => $value) {
            if ($pkp_tanpa_thr > $value->nilai_min && $pkp_tanpa_thr <= $value->nilai_max) {
                $pph_tanpa_thr = round($pkp_tanpa_thr * $value->persentase / 100 - $value->pengurangan, 0);
            }else{
                $pph_tanpa_thr = 0;
            }
        }
      

        //pph-21 dengan thr
        foreach ($pph as $key => $value) {
            if ($pkp > $value->nilai_min && $pkp <= $value->nilai_max) {
                $pph_dengan_thr = round($pkp * $value->persentase / 100 - $value->pengurangan, 0);
            }else{
                $pph_dengan_thr = 0;
            }
        }
        
        //pph-21 thr
        $pph_thr = $pph_dengan_thr - $pph_tanpa_thr;
        // return $pph_thr;

        //pph-21
        if ($tgl_masuk_kerja != 01) {
            $pembagi = 12 - $tgl_masuk_kerja;
        } elseif ($tgl_masuk_kerja == 12) {
            $pembagi = 1;
        } else {
            $pembagi = 12;
        }
        $pph21 = round($pph_tanpa_thr / $pembagi + $pph_thr, 0);

        return $pph21;
    }

    public static function masterTetap($pegawai, $kode_absen, $kehadiran, $year)
    {
        $status_karyawan = StatusKaryawan::where('id', $pegawai->status_pegawai)->first();
        $detail_absen = DetailAbsen::where('kode_absen', $kode_absen)->first();
        $uang_makan = $kehadiran * $status_karyawan->uang_makan;
        $uang_transport = $kehadiran * $status_karyawan->uang_transport;
        //premi
        // $bpjs_ket = 12888 + 16110 + 198690;
        $bpjs_ket = $pegawai->gaji_pokok * 4.24 / 100;
        $umr = Umr::where('tahun', $year)->first();
        if ($pegawai->gaji_pokok < $umr->nominal) {
            $bpjs_kes = round($umr->nominal * $status_karyawan->premi_bpjs_kes_max / 100);
        } elseif ($pegawai->gaji_pokok > $umr->nominal_atas) {
            $bpjs_kes = round($pegawai->nominal_atas * $status_karyawan->premi_bpjs_kes_max / 100);
        } else {
            $bpjs_kes = round($pegawai->gaji_pokok * $status_karyawan->premi_bpjs_kes_max / 100);
        }

        if ($pegawai->gaji_pokok < $status_karyawan->premi_jp_nilai) {
            $premi_jp = round($pegawai->gaji_pokok * $status_karyawan->premi_jp_max / 100);
        } elseif ($pegawai->gaji_pokok > $status_karyawan->premi_jp_nilai) {
            $premi_jp = round($status_karyawan->premi_jp_nilai * $status_karyawan->premi_jp_max / 100);
        }

        //potongan
        $pot_bpjs_ket = $pegawai->gaji_pokok * $status_karyawan->pot_bpjs_ket / 100;
        if ($pegawai->gaji_pokok < $umr->nominal) {
            $pot_bpjs_kes = round($umr->nominal * $status_karyawan->pot_bpjs_kes_max / 100, 0);
        } elseif ($status_karyawan->gaji->pokok > $umr->nominal_atas) {
            $pot_bpjs_kes =  round($pegawai->nominal_atas * $status_karyawan->pot_bpjs_kes_max / 100);
        } else {
            $pot_bpjs_kes =  round($pegawai->gaji_pokok * $status_karyawan->pot_bpjs_kes_max / 100);
        }

        if ($pegawai->gaji_pokok < $status_karyawan->pot_jp_nilai) {
            $pot_jp = round($pegawai->gaji_pokok * $status_karyawan->pot_jp_max / 100);
        } elseif ($pegawai->gaji_pokok > $status_karyawan->pot_jp_nilai) {
            $pot_jp = round($status_karyawan->pot_jp_nilai * $status_karyawan->pot_jp_max / 100);
        }
        $check = Gaji::where('kode_absen', $kode_absen)
        ->where('bulan', $detail_absen->bulan)
        ->first();
        if ($check === null) {
            Gaji::create([
                'nik_pegawai' => $pegawai->nip_pegawai,
                'kode_absen' => $kode_absen,
                'bulan' => $detail_absen->bulan,
                'tahun' => $detail_absen->tahun,
                'jumlah_masuk' => $kehadiran,
                'uang_makan' => $uang_makan,
                'uang_transport' => $uang_transport,
                'premi_bpjs_kes' => $bpjs_kes,
                'premi_bpjs_ket' => $bpjs_ket,
                'premi_jp' => $premi_jp,
                'pot_bpjs_ket' => $pot_bpjs_ket,
                'pot_bpjs_kes' => $pot_bpjs_kes,
                'pot_jp' => $pot_jp,
            ]);
        }
    }

    public static function masterKontrak($pegawai, $kode_absen, $kehadiran, $year, $bulan)
    {
        $status_karyawan = StatusKaryawan::where('id', $pegawai->status_pegawai)->first();
        if ($kode_absen == 013) {
            $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, now()->month, now()->year);
            $gaji_gross = $pegawai->gaji_pokok * $jumlah_hari;
        } else {
            $gaji_gross = $pegawai->gaji_pokok * $kehadiran;
        }
        // dd($detail_absen);

        //premi
        // $bpjs_ket = 9240 + 11550 + 142450;
        $bpjs_ket = $pegawai->gaji_pokok * 4.24 / 100;

        $umr = Umr::where('tahun', $year)->first();
        if ($pegawai->gaji_pokok < $umr->nominal) {
            $bpjs_kes = round($umr->nominal * $status_karyawan->premi_bpjs_kes_max / 100);
        } elseif ($pegawai->gaji_pokok > $umr->nominal_atas) {
            $bpjs_kes = round($pegawai->nominal_atas * $status_karyawan->premi_bpjs_kes_max / 100);
        } else {
            $bpjs_kes = round($pegawai->gaji_pokok * $status_karyawan->premi_bpjs_kes_max / 100);
        }

        if ($pegawai->gaji_pokok < $status_karyawan->premi_jp_nilai) {
            $premi_jp = round($pegawai->gaji_pokok * $status_karyawan->premi_jp_max / 100);
        } elseif ($pegawai->gaji_pokok > $status_karyawan->premi_jp_nilai) {
            $premi_jp = round($status_karyawan->premi_jp_nilai * $status_karyawan->premi_jp_max / 100);
        }

        //potongan
        $pot_bpjs_ket = $pegawai->gaji_pokok * $status_karyawan->pot_bpjs_ket / 100;
        if ($pegawai->gaji_pokok < $umr->nominal) {
            $pot_bpjs_kes = round($umr->nominal * $status_karyawan->pot_bpjs_kes_max / 100, 0);
        } elseif ($status_karyawan->gaji->pokok > $umr->nominal_atas) {
            $pot_bpjs_kes =  round($pegawai->nominal_atas * $status_karyawan->pot_bpjs_kes_max / 100);
        } else {
            $pot_bpjs_kes =  round($pegawai->gaji->pokok * $status_karyawan->pot_bpjs_kes_max / 100);
        }

        if ($pegawai->gaji_pokok < $status_karyawan->pot_jp_nilai) {
            $pot_jp = round($pegawai->gaji_pokok * $status_karyawan->pot_jp_max / 100);
        } elseif ($pegawai->gaji_pokok > $status_karyawan->pot_jp_nilai) {
            $pot_jp = round($status_karyawan->pot_jp_nilai * $status_karyawan->pot_jp_max / 100);
        }

        $check = Gaji::where('kode_absen', $kode_absen)->first();
        if ($check === null) {
            // dd($check);
            Gaji::create([
                'nik_pegawai' => $pegawai->nip_pegawai,
                'kode_absen' => $kode_absen,
                'bulan' => $bulan,
                'tahun' => $year,
                'jumlah_masuk' => $kehadiran,
                // 'uang_makan' => $uang_makan,
                // 'uang_transport' => $uang_transport,
                'premi_bpjs_kes' => $bpjs_kes,
                'premi_bpjs_ket' => $bpjs_ket,
                'premi_jp' => $premi_jp,
                'pot_bpjs_ket' => $pot_bpjs_ket,
                'pot_bpjs_kes' => $pot_bpjs_kes,
                'pot_jp' => $pot_jp,
                'gaji_gross_kontrak' => $gaji_gross
            ]);
        }
    }
}
