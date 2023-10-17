@extends('layouts.app')
@push('custom-css')
    <style>
        /* .rincian{
                border: 1px solid black;
              }
              .rincian th, td{
                border: 1px solid black;
              } */
    </style>
@endpush
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    DATA GAJI {{ $gaji->nama }}
                    {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table style="font-size: 12px"
                                    class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            {{-- <th rowspan="2">No</th> --}}
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">NIP</th>
                                            <th rowspan="2">Gaji Gross</th>
                                            <th rowspan="2">
                                                {{ $gaji->status_pegawai == 1 ? 'Gaji Pokok' : 'Gaji per Hari' }}</th>
                                            <th style="width: 25%" rowspan="2">Jml. Hari Kerja</th>
                                            <th style="text-align: center" colspan="3">Tunjangan</th>
                                            <th rowspan="2">Adjusment</th>
                                            <th rowspan="2">Total Gaji</th>
                                            <th style="text-align: center" colspan="3">Premi Asuransi</th>
                                            <th style="text-align: center" colspan="4">Potongan</th>
                                            <th rowspan="2">Netto Gaji</th>
                                            <th rowspan="2">Sisa Pinjaman</th>
                                        </tr>
                                        <tr>
                                            <th>Makan</th>
                                            <th>Transport</th>
                                            <th>Supervisor</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>JP</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>JP</th>
                                            <th>{{ $gaji->status_pegawai == 1 ? 'Pinjaman' : 'PPh 21' }}</th>
                                            {{-- <th ></th>
                                            <th ></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            {{-- <td >{{$loop->iteration}}</td> --}}
                                            <td>{{ $gaji->nama }}</td>
                                            <td>{{ $gaji->nip_pegawai }}</td>
                                            <td> @rupiah($gaji->status_pegawai == 1 ? $gaji->gaji_pokok + $gaji->uang_makan + $gaji->uang_transport : $gaji->gaji_gross_kontrak)</td>
                                            <td>@rupiah($gaji->gaji_pokok)</td>
                                            <td>{{ $gaji->jumlah_masuk }}</td>
                                            <td>@rupiah($gaji->uang_makan)</td>
                                            <td>@rupiah($gaji->uang_transport)</td>
                                            <td>@rupiah($gaji->supervisor)</td>
                                            <td>@rupiah($gaji->adjustment)</td>
                                            <td>@rupiah($total_gaji)</td>
                                            <td>@rupiah($gaji->premi_bpjs_ket)</td>
                                            <td>@rupiah($gaji->premi_bpjs_kes)</td>
                                            <td>@rupiah($gaji->premi_jp)</td>
                                            <td>@rupiah($gaji->pot_bpjs_ket)</td>
                                            <td>@rupiah($gaji->pot_bpjs_kes)</td>
                                            <td>@rupiah($gaji->pot_jp)</td>
                                            <td>@rupiah($gaji->status_pegawai == 1 ? $gaji->nominal_pinjaman : $pph)</td>
                                            <td>@rupiah($netto)</td>
                                            <td>@rupiah($gaji->sisa_pinjaman)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block-header" style="margin-top: 20px">
            <div class="row">
                <div class="col-lg-6">
                    <div style="margin-top: 20px;">
                        <h2 >
                            SLIP GAJI {{ $gaji->nama }}
                            {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                        </h2>
                </div>
                </div>
                <div class="col-lg-6">
                    <div class="pull-right">
                        <a target="_blank" href="{{route('cetak', $gaji->nip_pegawai)}}" class="btn btn-success waves-effect"><i class="material-icons">print</i><span>Cetak</span></a>
                    </div>
                </div>
            </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-1">
                                    <img src="{{ asset('public/asset/images/logo.png') }}" width="100px" height="100px"
                                        alt="">
                                </div>
                                <div class="col-lg-11">
                                    <H2
                                        style="margin-left: 30px;font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; color:black">
                                        PT. KRIS SETIABUDI UTAMA</H2>
                                    <p
                                        style="margin-left: 30px;font-family: Arial; font-size: 13px; font-weight:400; color:black">
                                        Epicentrum Walk Strata Office Suites Lt.6 Unit 0610 B <br>
                                        Komp. Rasuna Epicentrum, Jl.HR. Rasuna Said, Kuningan - Jakarta Selatan
                                    </p>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:black;background-color:black; margin-top: 1px">
                            <div class="mt-5">
                                <div>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="width: 150px">Periode</td>
                                                <td style="width: 10px">:</td>
                                                <td>@if($gaji->bulan == 01)
                                                    Januari {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 02)
                                                    Februari {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 03)
                                                    Maret {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 04)
                                                    April {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 05)
                                                    Mei {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 06)
                                                    Juni {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 07)
                                                    Juli {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == '08')
                                                    Agustus {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == '09')
                                                    September {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 10)
                                                    Oktober {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 11)
                                                    November {{$gaji->tahun}}
                                                    @elseif($gaji->bulan == 12)
                                                    Desember {{$gaji->tahun}}
                                                    @endif</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">No. Karyawan</td>
                                                <td style="width: 10px">:</td>
                                                <td>{{$gaji->nip_pegawai}}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">Nama / Jabatan</td>
                                                <td style="width: 10px">:</td>
                                                <td><b>{{$gaji->nama}} / {{$gaji->nama_jabatan}}</b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">No. NPWP</td>
                                                <td style="width: 10px">:</td>
                                                <td>{{$gaji->npwp}}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <hr>
                                <div style="margin-top: 10px">
                                    <table class="rincian">
                                        <tbody>
                                            <tr>
                                                <td style="width: 350px; padding-bottom: 10px"><b>TOTAL BIAYA GAJI DAN
                                                        TUNJANGAN PERUSAHAAN</b></td>
                                                <td style="width: 8%"></td>
                                                <td style="width: 20px"><b>:</b></td>
                                                <td> <b> @if ($gaji->status_pegawai == 2) @uang($gaji->gaji_gross_kontrak + $gaji->premi_bpjs_kes + $gaji->premi_bpjs_ket + $gaji->premi_jp + $pph) @else @uang($gaji->gaji_pokok + $gaji->uang_makan + $gaji->uang_transport + $gaji->premi_bpjs_kes + $gaji->premi_bpjs_ket + $gaji->premi_jp + $pph) @endif</b> </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px;padding-bottom: 10px"><b>PERINCIAN</b></td>
                                                <td></td>
                                                <td style="width: 10px"></td>
                                                <td></td>
                                                <td><b>TANGGUNGAN KARYAWAN</b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px"><b>1. Biaya Gaji</b></td>
                                                <td></td>
                                                <td style="width: 10px"></td>
                                                <td></td>
                                                <td><b>POTONGAN</b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gaji Pokok</td>
                                                <td></td>
                                                <td style="width: 10px">:</td>
                                                <td style="width: 100px">@uang($gaji->gaji_pokok)</td>
                                                <td style="width: 200px" >Pinjaman</td>
                                                <td style="width: 10px" >:</td>
                                                <td>@if ($gaji->pinjaman != 0)
                                                    @uang($gaji->pinjaman)
                                                    @else
                                                    -
                                                @endif</td>
                                            </tr>
                                            <tr>
                                                <td> </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Absent</td>
                                                <td>:</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px; padding-top:10px"><b>2. Biaya Tunjangan</b></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>BPJS Ketenagakerjaan &nbsp;&nbsp;&nbsp;&nbsp;2%</td>
                                                <td>:</td>
                                                <td>@uang($gaji->pot_bpjs_ket)</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Makan</td>
                                                <td style="width: 150px">{{$gaji->jumlah_masuk}} hari</td>
                                                <td style="width: 10px">:</td>
                                                <td> @uang($gaji->uang_makan) </td>
                                                <td>BPJS Kesehatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1%</td>
                                                <td>:</td>
                                                <td>@uang($gaji->pot_bpjs_kes)</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transport</td>
                                                <td style="width: 150px">{{$gaji->jumlah_masuk}} hari</td>
                                                <td style="width: 10px">:</td>
                                                <td> @uang($gaji->uang_transport) </td>
                                                <td>Jaminan Pensiun &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1%</td>
                                                <td>:</td>
                                                <td>@uang($gaji->pot_jp)</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adjustment</td>
                                                <td style="width: 150px"></td>
                                                <td style="width: 10px">:</td>
                                                <td>@if ($gaji->adjustment != 0) 
                                                    @uang($gaji->adjustment)
                                                    @else
                                                    -
                                                @endif</td>
                                                <td style="text-align: center"><b>TOTAL</b></td>
                                                <td><b>:</b></td>
                                                <td><b>@uang($gaji->pinjaman + $gaji->pot_bpjs_kes + $gaji->pot_bpjs_ket + $gaji->pot_jp)</b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px;padding-top: 10px"></td>
                                                <td style="width: 150px"></td>
                                                <td style="width: 10px"></td>
                                                <td>
                                                    <hr align="left" width="80%" size="8"
                                                        style="background-color:black; margin-top: 10px; margin-bottom: 2px; height: 2px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="width: 150px; text-align:center; margin-top: 1%; padding-bottom: 20px;">
                                                    <b>GAJI GROSS</b>
                                                </td>
                                                <td style="width: 150px;"></td>
                                                <td style="width: 10px;margin-top: 1%; padding-bottom: 20px;"><b>:</b></td>
                                                <td style="margin-top: 1%; padding-bottom: 20px;"><b>@if ($gaji->status_pegawai == 2) @uang($gaji->gaji_gross_kontrak) @else @uang($gaji->gaji_pokok + $gaji->uang_makan + $gaji->uang_transport) @endif </b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px; padding-top: 10px">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BPJS Ketenagakerjaan</td>
                                                <td style="width: 150px">4,24%</td>
                                                <td style="width: 10px">:</td>
                                                <td> @uang($gaji->premi_bpjs_ket) </td>
                                            </tr>
                                            <tr style="padding-top: 10px">
                                                <td style="width: 150px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BPJS Kesehatan
                                                </td>
                                                <td style="width: 150px">4%</td>
                                                <td style="width: 10px">:</td>
                                                <td> @uang($gaji->premi_bpjs_kes)</td>
                                            </tr>
                                            <tr style="padding-top: 10px">
                                                <td style="width: 150px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jaminan Pensiun
                                                </td>
                                                <td style="width: 150px">2%</td>
                                                <td style="width: 10px">:</td>
                                                <td> @uang($gaji->premi_jp) </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px;padding-top: 10px"></td>
                                                <td style="width: 150px"></td>
                                                <td style="width: 10px"></td>
                                                <td>
                                                    <hr align="left" width="80%" size="8"
                                                        style="background-color:black; margin-top: 10px; margin-bottom: 2px; height: 2px;">
                                                </td>
                                            </tr>
                                            <tr style="padding-top: 10px">
                                                <td style="width: 150px"></td>
                                                <td style="width: 150px"></td>
                                                <td style="width: 10px"></td>
                                                <td> <b> @uang($gaji->premi_bpjs_kes + $gaji->premi_bpjs_ket + $gaji->premi_jp) </b> </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px; padding-top:10px"><b>3. Pajak Karyawan Yang
                                                        ditanggung Perusahaan</b></td>
                                                <td style="width: 150px"></td>
                                                <td style="width: 10px">:</td>
                                                <td><b>@if ($pph != 0)
                                                    @uang($pph)
                                                    @else
                                                    -
                                                @endif</b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px; padding-top:10px"><b>NETTO GAJI YANG DITERIMA</b>
                                                </td>
                                                <td style="width: 150px"></td>
                                                <td style="width: 10px">:</td>
                                                <td><b> @uang($netto)</b></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 150px; padding-top:10px"><b>DITERIMA OLEH :</b></td>
                                                <td style="width: 150px"></td>
                                                <td style="width: 10px"></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet"> --}}
@endsection
