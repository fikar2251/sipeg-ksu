<?php

namespace App\Http\Controllers;

use App\Http\Resources\Karyawan;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\DetailAbsen;
use App\Models\KaryawanTetap;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class KaryawanTetapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::select('pegawai.*', 'jabatan.nama as nama_jabatan', 'departemen.nama as nama_departemen')
            ->join('jabatan', 'jabatan.id', '=', 'pegawai.jabatan')
            ->join('departemen', 'departemen.id', '=', 'pegawai.departemen')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'asc')
            ->where('status_pegawai', 1)->get();

        $cuti = DetailAbsen::where('keterangan', 'C')->get();
        // ->where('pegawai.nip_pegawai', '03101989-01')->count();
        // ->count();

        // dd($pegawai);
        // dd($cuti);

        $count = count($pegawai);
        // dd($count);
        // dd($pegawai);
        return view('karyawan.tetap.index', [
            'pegawai' => $pegawai,
            'jumlah_pegawai' => $count,
            'cuti' => $cuti,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depart = Departemen::all();
        $jabatan = Jabatan::all();
        return view('karyawan.tetap.create', [
            'jabatan' => $jabatan,
            'depart' => $depart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated =  $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'ktp' => 'required',
            'bpjs_kes' => 'required',
            'bpjs_ket' => 'required',
            'npwp' => 'required',
            'email' => 'required|email',
            'gaji_pokok' => 'required',
            'ptkp' => 'required',
            'departemen' => 'required',
            'jabatan' => 'required',
            'tgl_masuk_kerja' => 'required',
            'tgl_lahir' => 'required',
            'tempat_lahir' => 'required',
        ]);
        // dd($validated);
        try {
            $insert = Pegawai::create([
                'nama' => $request->nama,
                'nip_pegawai' => $request->nip,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'ktp' => $request->ktp,
                'bpjs_kes' => $request->bpjs_kes,
                'bpjs_ket' => $request->bpjs_ket,
                'npwp' => $request->npwp,
                'email' => $request->email,
                'gaji_pokok' => $request->gaji_pokok,
                'ptkp' => $request->ptkp,
                'departemen' => $request->departemen,
                'jabatan' => $request->jabatan,
                'tanggal_masuk_kerja' => $request->tgl_masuk_kerja,
                'tanggal_lahir' => $request->tgl_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'status_pegawai' => 1,
                'kode_absen' => 0,
            ]);


            return redirect()->route('karyawantetap')->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            return redirect()->route('karyawantetap')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show(KaryawanTetap $karyawan)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(KaryawanTetap $karyawan)
    {
        $data = KaryawanTetap::find($karyawan->id);
        $depart = Departemen::all();
        $jabatan = Jabatan::all();
        // dd($data->nama);
        return view('karyawan.tetap.edit', [
            'data' => $data,
            'depart' => $depart,
            'jabatan' => $jabatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KaryawanTetap $karyawan)
    {
        $validated =  $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'ktp' => 'required',
            'bpjs_kes' => 'required',
            'bpjs_ket' => 'required',
            'npwp' => 'required',
            'email' => 'required|email',
            'gaji_pokok' => 'required',
            'ptkp' => 'required',
            'departemen' => 'required',
            'jabatan' => 'required',
            'tgl_masuk_kerja' => 'required',
            'tgl_lahir' => 'required',
            'tempat_lahir' => 'required',
        ]);

        try {
            $insert = Pegawai::where('id', $karyawan->id)->update([
                'nama' => $request->nama,
                'nip_pegawai' => $request->nip,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'ktp' => $request->ktp,
                'bpjs_kes' => $request->bpjs_kes,
                'bpjs_ket' => $request->bpjs_ket,
                'npwp' => $request->npwp,
                'email' => $request->email,
                'gaji_pokok' => $request->gaji_pokok,
                'ptkp' => $request->ptkp,
                'departemen' => $request->departemen,
                'jabatan' => $request->jabatan,
                'tanggal_masuk_kerja' => $request->tgl_masuk_kerja,
                'tanggal_lahir' => $request->tgl_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'status_pegawai' => 1,
                'kode_absen' => 0,
            ]);


            return redirect()->route('karyawantetap')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('karyawantetap')->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(KaryawanTetap $karyawan)
    {
        //
    }
}
