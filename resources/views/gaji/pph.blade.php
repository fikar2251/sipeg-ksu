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
                        <div class="header">
                            <h2>
                                {{-- <center id="allFilter">BULAN <span id="bulanFilter"></span> TAHUN <SPAN id="tahunFilter"></SPAN></center> --}}
                                <center id="allFilter">SEMUA DATA</center>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p>
                                        <b>Pilih Bulan</b>
                                    </p>
                                    <select required name="bulan" id="bulan" class="tahun form-control  show-tick">
                                        <option value="">Pilih Bulan</option>
                                        <option value='1'>Januari</option>
                                        <option value='2'>Februari</option>
                                        <option value='3'>Maret</option>
                                        <option value='4'>April</option>
                                        <option value='5'>Mei</option>
                                        <option value='6'>Juni</option>
                                        <option value='7'>Juli</option>
                                        <option value='8'>Agustus</option>
                                        <option value='9'>September</option>
                                        <option value='10'>Oktober</option>
                                        <option value='11'>November</option>
                                        <option value='12'>Desember</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label class="form-label">Pilih Tahun</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input autocomplete="off" type="text" id="tahun" name="tahun"
                                                class="form-control datepickermaster2" value="<?php if (isset($_GET['tahun'])) {
                                                    echo $_GET['tahun'];
                                                } ?>"
                                                required />

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" name="upload" value="submit"
                                        class="btn btn-lg btn-success upload" style="margin-top: 20px;">Submit</button>
                                    <button type="submit" name="upload" value="submit" class="btn btn-lg btn-warning all"
                                        style="margin-top: 20px; margin-left: 5px;">All</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table style="font-size: 12px" id="pph"
                                    class="table table-bordered table-striped table-hover ">
                                    <thead>

                                        <tr>
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">Nomor NPWP</th>
                                            <th rowspan="2">Bulan</th>
                                            <th rowspan="2">Tahun</th>
                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Gaji Perbulan</th>
                                            <th colspan="2">Tunjangan</th>
                                            <th rowspan="2">THR</th>
                                            <th rowspan="2">Jumlah Gaji Bruto</th>
                                            <th colspan="3">Pengurangan</th>
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
                                        {{-- @foreach ($dataPph as $pph)
                                        <tr>
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
                                        @endforeach --}}
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            let bulan = ''
            let tahun = ''
            $(".datepickermaster2").datepicker({
                format: 'yyyy',
                viewMode: "years",
                minViewMode: "years"
            });
            pph()
           
            $('.upload').on('click', function() {

                bulan = $('#bulan').val();
                tahun = $('#tahun').val();
                if (bulan != null && tahun == '') {
                    swal("Warning!", "Harap pilih tahun!", "warning");
                    return
                }

                pph()
               
                var monthNamesIndonesian = {
                    1: 'JANUARI',
                    2: 'FEBRUARI',
                    3: 'MARET',
                    4: 'APRIL',
                    5: 'MEI',
                    6: 'JUNI',
                    7: 'JULI',
                    8: 'AGUSTUS',
                    9: 'SEPTEMBER',
                    10: 'OKTOBER',
                    11: 'NOVEMBER',
                    12: 'DESEMBER'
                };

                // Ambil nama bulan dari objek
                var monthName = monthNamesIndonesian[bulan];
                $('#allFilter').text('')
                $('#allFilter').append(`<h2>BULAN ${monthName} TAHUN ${tahun} </h2>`)
                $('#bulanFilter').text(monthName)
                $('#tahunFilter').text(tahun)
                bulan = $('#bulan').text = ''
                tahun = $('#tahun').val('');
            })

            $('.all').on('click', function() {
                bulan = '';
                tahun = '';
                $('#allFilter').text('')
                $('#allFilter').append('<h2>SEMUA DATA</h2>')
                pph()
               
            })
            function pph() {
                var table = $('#pph').DataTable({
                serverSide: true,
                processing: true,
                "bDestroy": true,
                paging: true,
                ajax: 
                {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '{{ route("dataPph") }}',
                    data: {
                        bulan: bulan,
                        tahun: tahun,
                    }
                },
                columns: [{
                        data: 'nama',
                    },
                    {
                        data: 'npwp',
                    },
                    {
                        data: 'bulan',
                    },
                    {
                        data: 'tahun',
                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'gaji_perbulan',
                    },
                    {
                        data: 'tunjangan_bpjs_ket',
                    },
                    {
                        data: 'tunjangan_bpjs_kes',
                    },
                    {
                        data: 'thr',
                    },
                    {
                        data: 'jumlah_gaji_bruto',

                    },
                    {
                        data: 'biaya_jabatan',
                    },
                    {
                        data: 'peng_bpjs_ket',
                    },
                    {
                        data: 'peng_bpjs_kes',

                    },
                    {
                        data: 'pengurangan',

                    },
                    {
                        data: 'netto_gaji_setahun',

                    },
                    {
                        data: 'ptkp_setahun',

                    },
                    {
                        data: 'pkp_setahun',

                    },
                    {
                        data: 'pkp_tanpa_thr',

                    },
                    {
                        data: 'pph_tanpa_thr',

                    },
                    {
                        data: 'pph_dengan_thr',

                    },
                    {
                        data: 'pph_thr',

                    },
                    {
                        data: 'pph',
                    },
                    // Tambahkan kolom lain sesuai kebutuhan
                ],
                // fixedColumns: {
                //     left: 3,
                //     right: 0,
                // },
                paging: true,
                // scrollCollapse: true,
                // scrollX: true,
                // scrollY: 300
            });
            }
          


        });

        // Setelah DataTables selesai dimuat, manipulasi DOM
    </script>
@endpush
