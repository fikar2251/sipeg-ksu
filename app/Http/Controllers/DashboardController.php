<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pegawaitetap = Pegawai::select('pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('status_pegawai', 1)->get();

        $pegawaikontrak = Pegawai::select('pegawai.*', 'jabatan.nama as nama_jabatan')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->where('status_pegawai', 2)->get();

        $counttetap = count($pegawaitetap);
        $countkontrak = count($pegawaikontrak);
        $total = $counttetap + $countkontrak;
        return view('dashboard', [
            'tetap' => $counttetap,
            'kontrak' => $countkontrak,
            'total' => $total
        ]);
    }
}
