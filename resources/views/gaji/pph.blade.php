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
@php
    use App\Helpers\HitungGaji;
@endphp
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    DATA PPH
                    {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table style="font-size: 12px" id="pph"
                                    class="table table-bordered table-striped table-hover ">
                                    <thead>
                                        <tr>
                                            {{-- <th rowspan="2">No</th> --}}
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">Nomor NPWP</th>
                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">
                                              Gaji Perbulan</th>
                                            <th style="text-align: center" colspan="2">Tunjangan</th>
                                            <th rowspan="2">THR</th>
                                            <th rowspan="2">Jumlah Gaji Bruto</th>
                                            <th style="text-align: center" colspan="3">Pengurangan</th>
                                            <th rowspan="2">Jumlah Pengurangan</th>
                                            <th rowspan="2">Netto Gaji Setahun / Disetahunkan</th>
                                            <th rowspan="2">PTKP Setahun</th>
                                            <th rowspan="2">PKP Setahun</th>
                                            <th rowspan="2">PKP Tanpa THR</th>
                                            <th rowspan="2">PPh 21 Tanpa THR</th>
                                            <th rowspan="2">PPh 21 dgn THR</th>
                                            <th rowspan="2">PPh 21 THR</th>
                                            <th rowspan="2">PPh 21</th>
                                        </tr>
                                        <tr>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>Biaya Jabatan</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataPph as $pph)
                                        <tr>
                                            {{-- <td >{{$loop->iteration}}</td> --}}
                                           <td>{{$pph['nama']}}</td>
                                           <td>{{$pph['npwp']}}</td>
                                           <td>{{$pph['status']}}</td>
                                           <td>@rupiah($pph['gaji_perbulan'])</td>
                                           <td>@rupiah($pph['tunjangan_bpjs_ket'])</td>
                                           <td>@rupiah($pph['tunjangan_bpjs_kes'])</td>
                                           <td>@rupiah($pph['thr'])</td>
                                           <td>@rupiah($pph['jumlah_gaji_bruto'])</td>
                                           <td>@rupiah($pph['biaya_jabatan'])</td>
                                           <td>@rupiah($pph['peng_bpjs_ket'])</td>
                                           <td>@rupiah($pph['peng_bpjs_kes'])</td>
                                           <td>@rupiah($pph['pengurangan'])</td>
                                           <td>@rupiah($pph['netto_gaji_setahun'])</td>
                                           <td>@rupiah($pph['ptkp_setahun'])</td>
                                           <td>@rupiah($pph['pkp_setahun'])</td>
                                           <td>@rupiah($pph['pkp_tanpa_thr'])</td>
                                           <td>@rupiah($pph['pph_tanpa_thr'])</td>
                                           <td>@rupiah($pph['pph_dengan_thr'])</td>
                                           <td>@rupiah($pph['pph_thr'])</td>
                                           <td>@rupiah($pph['pph'])</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet"> --}}
@endsection
@push('custom-scripts')
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pph').DataTable({
            fixedColumns: {
                left: 3,
                right: 0,
            },
            paging: true,
            scrollCollapse: true,
            scrollX: true,
            scrollY: 300
        });

    });
   
</script>
@endpush
