<?php

namespace App\Http\Controllers;

use App\Models\KaryawanKontrak;
use Illuminate\Http\Request;

class KaryawanKontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('karyawan.kontrak.index');
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
     * @param  \App\Models\KaryawanKontrak  $karyawanKontrak
     * @return \Illuminate\Http\Response
     */
    public function show(KaryawanKontrak $karyawanKontrak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KaryawanKontrak  $karyawanKontrak
     * @return \Illuminate\Http\Response
     */
    public function edit(KaryawanKontrak $karyawanKontrak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KaryawanKontrak  $karyawanKontrak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KaryawanKontrak $karyawanKontrak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KaryawanKontrak  $karyawanKontrak
     * @return \Illuminate\Http\Response
     */
    public function destroy(KaryawanKontrak $karyawanKontrak)
    {
        //
    }
}
