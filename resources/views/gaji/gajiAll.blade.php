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
                        </div>
                    </div>
                    <div class="block-header">
                        <h2>
                            DATA GAJI KARYAWAN TETAP
                            {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                        </h2>
                    </div>
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table id="gajitetap" style="font-size: 12px"
                                    class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            {{-- <th rowspan="2">No</th> --}}
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">NIP</th>
                                            <th rowspan="2">Gaji Gross</th>
                                            <th rowspan="2">
                                                Gaji Pokok</th>
                                            <th style="width: 25%" rowspan="2">Jml. Hari Kerja</th>
                                            <th style="width: 25%" rowspan="2">Bulan</th>
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
                                            <th>Pinjaman</th>
                                            {{-- <th ></th>
                                            <th ></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data_tetap as $gaji)
                                        <tr>
                                            <td>
                                                <a target="_blank" href="{{ route('detailGaji', $gaji->nip_pegawai .'_'.$gaji->bulan) }}">{{ $gaji->nama }}</a>                                                
                                            </td>
                                            <td>{{ $gaji->nip_pegawai }}</td>
                                            <td> @rupiah( $gaji->gaji_pokok + $gaji->uang_makan + $gaji->uang_transport)</td>
                                            <td>@rupiah($gaji->gaji_pokok)</td>
                                            <td>{{ $gaji->jumlah_masuk }}</td>
                                            <td>@if ($gaji->bulan == 01)
                                                    Januari
                                                    @elseif($gaji->bulan == 02)
                                                    Februari 
                                                    @elseif($gaji->bulan == 03)
                                                    Maret
                                                    @elseif($gaji->bulan == 04)
                                                    April
                                                    @elseif($gaji->bulan == 05)
                                                    Mei
                                                    @elseif($gaji->bulan == 06)
                                                    Juni
                                                    @elseif($gaji->bulan == 07)
                                                    Juli
                                                    @elseif($gaji->bulan == '08')
                                                    Agustus
                                                    @elseif($gaji->bulan == '09')
                                                    September
                                                    @elseif($gaji->bulan == 10)
                                                    Oktober
                                                    @elseif($gaji->bulan == 11)
                                                    November
                                                    @elseif($gaji->bulan == 12)
                                                    Desember
                                                    @endif</td>
                                            <td>@rupiah($gaji->uang_makan)</td>
                                            <td>@rupiah($gaji->uang_transport)</td>
                                            <td>@rupiah($gaji->supervisor)</td>
                                            <td>@rupiah($gaji->adjustment)</td>
                                            <td>@rupiah($gaji->uang_makan + $gaji->uang_transport + $gaji->gaji_pokok + $gaji->adjustment)</td>
                                            <td>@rupiah($gaji->premi_bpjs_ket)</td>
                                            <td>@rupiah($gaji->premi_bpjs_kes)</td>
                                            <td>@rupiah($gaji->premi_jp)</td>
                                            <td>@rupiah($gaji->pot_bpjs_ket)</td>
                                            <td>@rupiah($gaji->pot_bpjs_kes)</td>
                                            <td>@rupiah($gaji->pot_jp)</td>
                                            <td>
                                                @if ($gaji->sisa_pinjaman === $gaji->pinjaman)
                                                        @rupiah(0)
                                                    @else
                                                    @rupiah($gaji->nominal_pinjaman)
                                                    @endif
                                            </td>
                                            <td>@php
                                                $netto_gaji_tetap = HitungGaji::hitungTetap($gaji->nip_pegawai, $gaji->pinjaman, $gaji->adjustment, $gaji->supervisor, $gaji->bulan);
                                                echo "Rp. " . number_format($netto_gaji_tetap, 0, ',', '.');
                                            @endphp</td>
                                            <td>@rupiah($gaji->sisa_pinjaman)</td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    <div class="block-header">
                        <h2>
                            DATA GAJI KARYAWAN KONTRAK
                            {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                        </h2>
                    </div>
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table id="gajikontrak" style="font-size: 12px" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th rowspan="2">No</th> --}}
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">NIP</th>
                                            <th rowspan="2">Gaji Gross</th>
                                            <th rowspan="2">
                                                Gaji per Hari</th>
                                            <th style="width: 25%" rowspan="2">Jml. Hari Kerja</th>
                                            <th style="width: 25%" rowspan="2">Bulan</th>
                                            <th style="text-align: center" colspan="2">Tunjangan</th>
                                            <th rowspan="2">Adjusment</th>
                                            <th rowspan="2">Total Gaji</th>
                                            <th style="text-align: center" colspan="3">Premi Asuransi</th>
                                            <th style="text-align: center" colspan="4">Potongan</th>
                                            <th rowspan="2">Netto Gaji</th>
                                        </tr>
                                        <tr>
                                            <th>Makan</th>
                                            <th>Transport</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>JP</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>JP</th>
                                            <th>PPh21</th>
                                            {{-- <th ></th>
                                            <th ></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($data_kontrak as $gaji)
                                        <tr>
                                            <td> <a target="_blank" href="{{ route('detailGaji', [$gaji->nip_pegawai, $gaji->bulan]) }}">{{ $gaji->nama }}</a> </td>
                                            <td>{{ $gaji->nip_pegawai }}</td>
                                            <td> @rupiah( $gaji->gaji_gross_kontrak)</td>
                                            <td>@rupiah($gaji->gaji_pokok)</td>
                                            <td>{{ $gaji->jumlah_masuk }}</td>
                                            <td>@if ($gaji->bulan == 01)
                                                    Januari
                                                    @elseif($gaji->bulan == 02)
                                                    Februari 
                                                    @elseif($gaji->bulan == 03)
                                                    Maret
                                                    @elseif($gaji->bulan == 04)
                                                    April
                                                    @elseif($gaji->bulan == 05)
                                                    Mei
                                                    @elseif($gaji->bulan == 06)
                                                    Juni
                                                    @elseif($gaji->bulan == 07)
                                                    Juli
                                                    @elseif($gaji->bulan == '08')
                                                    Agustus
                                                    @elseif($gaji->bulan == '09')
                                                    September
                                                    @elseif($gaji->bulan == 10)
                                                    Oktober
                                                    @elseif($gaji->bulan == 11)
                                                    November
                                                    @elseif($gaji->bulan == 12)
                                                    Desember
                                                    @endif</td>
                                            <td>@rupiah($gaji->uang_makan)</td>
                                            <td>@rupiah($gaji->uang_transport)</td>
                                            <td>@rupiah($gaji->adjustment)</td>
                                            <td>@rupiah($gaji->gaji_gross_kontrak + $gaji->adjustment -  $gaji->pot_bjs_kes - $gaji->pot_bpjs_ket - $gaji->pot_jp)</td>
                                            <td>@rupiah($gaji->premi_bpjs_ket)</td>
                                            <td>@rupiah($gaji->premi_bpjs_kes)</td>
                                            <td>@rupiah($gaji->premi_jp)</td>
                                            <td>@rupiah($gaji->pot_bpjs_ket)</td>
                                            <td>@rupiah($gaji->pot_bpjs_kes)</td>
                                            <td>@rupiah($gaji->pot_jp)</td>
                                            <td>@php
                                                $pph = HitungGaji::hitungPPH($gaji->nip_pegawai, $gaji->thr);
                                                echo "Rp. " . number_format($pph, 0, ',', '.');
                                            @endphp</td>
                                            <td>@php
                                                $total_gaji = HitungGaji::hitungKontrak($gaji->nip_pegawai, $gaji->adjustment);
                                                $pph = HitungGaji::hitungPPH($gaji->nip_pegawai, $gaji->thr);
                                                $netto_kontrak = $total_gaji - $pph;
                                                echo "Rp. " . number_format($netto_kontrak, 0, ',', '.');
                                            @endphp</td>
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
            gajiTetap()
            gajikontrak()
            $('.upload').on('click', function() {

                bulan = $('#bulan').val();
                tahun = $('#tahun').val();
                if (bulan != null && tahun == '') {
                    swal("Warning!", "Harap pilih tahun!", "warning");
                    return
                }

                gajiTetap()
                gajikontrak()
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
                gajiTetap()
                gajikontrak()
            })

            function gajiTetap() {

                var table = $('#gajitetap').DataTable({
                    serverSide: true,
                    processing: true,
                    "bDestroy": true,
                    paging: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: '{{ route('dataGajiTetap') }}',
                        data: {
                            bulan: bulan,
                            tahun: tahun,
                        }
                    },

                    columns: [{
                            data: 'namas',
                        },
                        {
                            data: 'nip_pegawai',
                        },
                        {
                            data: 'gajiGross',
                        },
                        {
                            data: 'gaji_pokok',
                        },
                        {
                            data: 'jumlah_masuk',
                        },
                        {
                            data: 'bulan',
                        },
                        {
                            data: 'uang_makan',
                        },
                        {
                            data: 'uang_transport',

                        },
                        {
                            data: 'supervisor',
                        },
                        {
                            data: 'adjusment',
                        },
                        {
                            data: 'totalGaji',

                        },
                        {
                            data: 'premi_bpjs_ket',

                        },
                        {
                            data: 'premi_bpjs_kes',

                        },
                        {
                            data: 'premi_jp',

                        },
                        {
                            data: 'pot_bpjs_ket',

                        },
                        {
                            data: 'pot_bpjs_kes',

                        },
                        {
                            data: 'pot_jp',

                        },
                        {
                            data: 'pinjam',

                        },
                        {
                            data: 'netto_gaji',

                        },
                        {
                            data: 'sisa_pinjaman',
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

            function gajikontrak() {
                var tables = $('#gajikontrak').DataTable({
                serverSide: true,
                processing: true,
                "bDestroy": true,
                paging: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: '{{ route('dataGajiKontrak') }}',
                    data: {
                        bulan: bulan,
                        tahun: tahun,
                    }
                },
                columns: [{
                        data: 'namas',
                    },
                    {
                        data: 'nip_pegawai',
                    },
                    {
                        data: 'gaji_gross_kontrak',
                    },
                    {
                        data: 'gaji_pokok',
                    },
                    {
                        data: 'jumlah_masuk',
                    },
                    {
                        data: 'bulan',
                    },
                    {
                        data: 'uang_makan',
                    },
                    {
                        data: 'uang_transport',

                    },
                    {
                        data: 'adjusment',
                    },
                    {
                        data: 'totalGaji',

                    },
                    {
                        data: 'premi_bpjs_ket',

                    },
                    {
                        data: 'premi_bpjs_kes',

                    },
                    {
                        data: 'premi_jp',

                    },
                    {
                        data: 'pot_bpjs_ket',

                    },
                    {
                        data: 'pot_bpjs_kes',

                    },
                    {
                        data: 'pot_jp',

                    },
                    {
                        data: 'pph',

                    },
                    {
                        data: 'netto_gaji',

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
