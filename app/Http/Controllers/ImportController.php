<?php

namespace App\Http\Controllers;

use App\Imports\AbsensiImport;
use App\Imports\MultiSheetSelector;
use App\Imports\UsersImport;
use App\Models\Import;
use Illuminate\Http\Request;
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

        // $new_file_name = $request->file('excel')->getClientOriginalName();
        // $move = $request->file('excel')->move(storage_path() . '/epdk_import/', $new_file_name);
        // $path = storage_path() . '/epdk_import/' . $new_file_name;
        // dd(IOFactory::identify($path));
        // $objPHPExcel = IOFactory::load($path);

        // $spreadsheet = new Spreadsheet();
        // $spreadsheet->getActiveSheet()->fromArray($objPHPExcel->getActiveSheet()->toArray());

        // $newFilePath = str_replace('.xls', '.xlsx', $path);
        // $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save($newFilePath);

        // return $newFilePath;

        $data = Excel::import(new AbsensiImport, $request->file('excel')->store('temp'));
        dd($data);

        // (new UsersImport)->import($request->file('excel'), 'local', \Maatwebsite\Excel\Excel::XLS)
        // $array = (new AbsensiImport)->import($request->file('excel'), 'local', \Maatwebsite\Excel\Excel::XLS);
        // dd($request->file('excel'));
        // Excel::import(new MultiSheetSelector(), $request->file('excel'));
        // echo "<pre>";
        // print_r()
        // foreach ($data as $key => $value) {
        //     dd($value);

        // }
        // $array = (new AbsensiImport)->toArray($path);

        // return redirect()->back();
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
