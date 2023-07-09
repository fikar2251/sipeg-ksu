<?php

namespace App\Http\Controllers;

use App\Helpers\HitungGaji;
use App\Imports\AbsensiImport;
use App\Imports\MultiSheetSelector;
use App\Imports\UsersImport;
use App\Models\DetailAbsen;
use App\Models\Import;
use App\Models\Pegawai;
use App\Models\StatusKaryawan;
use App\Models\Umr;
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

        return view('import.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


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
                        'nik' => $value[1]
                    ];
                }
            }
            $year = Carbon::parse($date[$i])->format("Y");
            $this->hitungGaji(22, '001', $year);
        }
        try {
            foreach ($datas as $key => $value) {
                $bulan = Carbon::parse($value['tgl'])->format("m");
                $tahun = Carbon::parse($value['tgl'])->format("Y");
                $tanggal = Carbon::parse($value['tgl'])->format("d");
                // dd($bulan);
                if ($value['in'] !== '00:00') {
                    $insert =  DetailAbsen::create([
                        'kode_absen' => $value['nik'],
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'tanggal' => $tanggal,
                        'masuk' => $value['in'],
                        'keluar' => $value['out'],
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Import success!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function hitungGaji($kehadiran, $kode_absen, $year)
    {
        $pegawai = Pegawai::where('kode_absen', $kode_absen)->first();
        $status_karyawan = StatusKaryawan::where('id', $pegawai->status_karyawan)->first();
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
