@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    DATA KEHADIRAN KARYAWAN
                    {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                </h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            {{-- <form id="form_validation" role="form" action="{{ route('kirimGaji') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf --}}
                        <form action="{{route('kehadiran')}}" method="GET">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p>
                                        <b>Pilih Bulan</b>
                                    </p>
                                    <select required name="bulan" class="tahun form-control  show-tick">
                                        <option  value="">Pilih Bulan</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  1) value='1'>Januari</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  2) value='2'>Februari</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  3) value='3'>Maret</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  4) value='4'>April</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  5) value='5'>Mei</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  6) value='6'>Juni</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  7) value='7'>Juli</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  8) value='8'>Agustus</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  9) value='9'>September</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  10) value='10'>Oktober</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  11) value='11'>November</option>
                                        <option @selected(isset($_GET['bulan']) && $_GET['bulan'] ==  12) value='12'>Desember</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label class="form-label">Pilih Tahun</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input autocomplete="off" type="text" id="periodeakhir" name="tahun"
                                                class="form-control datepickermaster2" value="<?php if (isset($_GET['tahun'])) {
                                                    echo $_GET['tahun'];
                                                } ?>"
                                                required />

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" name="upload" value="submit" class="btn btn-lg btn-success"
                                        style="margin-top: 20px">Send</button>
                                </div>
                            </div>

                        </form>
                                {{-- </form> --}}
                                <div class="table-responsive">
                                    <table id="kehadiran" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">#</th>
                                                <th rowspan="2">Nama Lengkap</th>
                                                <th rowspan="2">NIP</th>
                                                <th rowspan="2">Jabatan</th>
                                                <th rowspan="2">Status</th>
                                                {{-- <th>Bulan</th>
                                            <th>Tahun</th> --}}
                                                <th style="text-align: center" colspan="31">Tanggal

                                                </th>



                                                {{-- <th>Status Kehadiran</th>
                                            <th>Aksi</th> --}}
                                            </tr>
                                            <tr>
                                                @php
                                                    // $i = 1;
                                                @endphp
                                                {{-- @for ($i = 0; $i < count($total_tanggal); $i++)
                                                <th> {{ $i + 1 }} </th>
                                            @endfor --}}
                                                @foreach ($total_tanggal as $item)
                                                    <th> {{ $item }} </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($pegawai as $index => $data1)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a data-id="{{ $data1->nip_pegawai }}"
                                                            data-adjustment="{{ $data1->adjustment }}"
                                                            data-pinjaman="{{ $data1->pinjaman }}"
                                                            data-supervisor="{{ $data1->supervisor }}"
                                                            data-thr="{{ $data1->thr }}"
                                                            data-gapok="{{ $data1->gaji_pokok }}"
                                                            data-ukan="{{ $data1->uang_makan }}"
                                                            data-uport="{{ $data1->uang_transport }}" class="editbtn"
                                                            title="HITUNG GAJI" data-target="#gajiModal" data-toggle="modal"
                                                            href="#"><i class="material-icons"
                                                                aria-hidden="true">attach_money</i></a>
                                                        <a title="DETAIL GAJI {{ $data1->nama }}" target="_blank"
                                                            href="{{ route('detailGaji', $data1->nip_pegawai . '_' . $data1->bulan) }}"><i
                                                                class="material-icons" aria-hidden="true">search</i></a>
                                                    </td>
                                                    <td>{{ $data1->nama }}</td>
                                                    <td>{{ $data1->nip_pegawai }}</td>
                                                    <td>{{ $data1->nama_jabatan }}</td>
                                                    <td>Pegawai {{ $data1->nama_status }}</td>
                                                    {{-- @else --}}
                                                    {{-- <td>
                                                    @if ($data1->bulan == 01)
                                                        Januari
                                                    @elseif($data1->bulan == 02)
                                                        Februari
                                                    @elseif($data1->bulan == 03)
                                                        Maret
                                                    @elseif($data1->bulan == 04)
                                                        April
                                                    @elseif($data1->bulan == 05)
                                                        Mei
                                                    @elseif($data1->bulan == 06)
                                                        Juni
                                                    @elseif($data1->bulan == 07)
                                                        Juli
                                                    @elseif($data1->bulan == '08')
                                                        Agustus
                                                    @elseif($data1->bulan == '09')
                                                        September
                                                    @elseif($data1->bulan == 10)
                                                        Oktober
                                                    @elseif($data1->bulan == 11)
                                                        November
                                                    @elseif($data1->bulan == 12)
                                                        Desember
                                                    @endif
                                                </td>
                                                <td>{{ $data1->tahun }}</td> --}}
                                                    @php
                                                        $tgl = $tanggal->where('kode_absen', $data1->kode_absen);
                                                        // dd($tgl);
                                                    @endphp
                                                    @foreach ($total_tanggal as $item)
                                                        <td>
                                                            @foreach ($tgl as $tg)
                                                                @if ($item == $tg->tanggal)
                                                                    @if ($tg->masuk == '00:00:00')
                                                                        @if ($tg->status_pegawai == 1)
                                                                            <a href="#" class="absens"
                                                                                data-target="#absen" data-toggle="modal"
                                                                                data-id="{{ $tg->kode_absen }}"
                                                                                data-tanggal="{{ $tg->tanggal }}-{{ $tg->bulan }}-{{ $tg->tahun }}">
                                                                                @if ($tg->keterangan == 'C')
                                                                                    <span
                                                                                        class="badge bg-orange">{{ $tg->keterangan }}</span><br>
                                                                                @elseif($tg->keterangan == 'SID')
                                                                                    <span
                                                                                        class="badge bg-orange">{{ $tg->keterangan }}</span><br>
                                                                                @elseif($tg->keterangan == 'IK')
                                                                                    <span
                                                                                        class="badge bg-orange">{{ $tg->keterangan }}</span><br>
                                                                                @elseif($tg->keterangan == 'IPG')
                                                                                    <span
                                                                                        class="badge bg-orange">{{ $tg->keterangan }}</span><br>
                                                                                @else
                                                                                    <span class="badge bg-red">A</span><br>
                                                                                @endif
                                                                            </a>
                                                                        @else
                                                                            <span class="badge bg-red">A</span><br>
                                                                        @endif
                                                                        {{-- <span id="jam_masuk">{{$tg->masuk}}</span> --}}
                                                                    @else
                                                                        <span class="badge bg-green">H</span>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                    @endforeach
                                                    </td>


                                                    {{-- <td>
                                                    @if ($data1->masuk == '00:00:00')
                                                        <span class="badge bg-red">Tidak hadir</span> <br>
                                                        (Izin)
                                                    @else
                                                        <span class="badge bg-green">Hadir</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a data-id="{{ $data1->nip_pegawai }}"
                                                        data-adjustment="{{ $data1->adjustment }}"
                                                        data-pinjaman="{{ $data1->pinjaman }}"
                                                        data-supervisor="{{ $data1->supervisor }}"
                                                        data-thr="{{ $data1->thr }}"
                                                        data-gapok="{{ $data1->gaji_pokok }}"
                                                        data-ukan="{{ $data1->uang_makan }}"
                                                        data-uport="{{ $data1->uang_transport }}" class="editbtn"
                                                        title="HITUNG GAJI" data-target="#gajiModal" data-toggle="modal"
                                                        href="#"><i class="material-icons"
                                                            aria-hidden="true">attach_money</i></a>
                                                    <a title="DETAIL GAJI {{ $data1->nama }}" target="_blank"
                                                        href="{{ route('detailGaji', $data1->nip_pegawai . '_' . $data1->bulan) }}"><i
                                                            class="material-icons" aria-hidden="true">search</i></a>
                                                </td> --}}
                                                </tr>
                                                {{-- @php
                                                $no++;
                                                $previousName = $data1->nama;
                                            @endphp --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="gajiModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Input Pinjaman dan Adjustment</h4>

                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('hitungSalary') }}">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                                        <!-- <div class="form-group"> -->
                                        <div>
                                            <input type="hidden" class="form-control" value="" id="nip"
                                                name="nip">
                                        </div>
                                        <label for="pinjaman">Pinjaman ( Max Pinjaman: <span id="saldo_pinjaman"></span>
                                            )</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="pinjaman"
                                                    id="pinjaman">
                                            </div>
                                        </div>
                                        <select id="opsi-pinjaman" class="form-control show-tick pinjaman"
                                            style="margin-bottom: 100px;" name="keterangan_adjustment">
                                            <option value="">-- Opsi Pinjaman --</option>
                                            <option value="tenor">Tenor</option>
                                            <option value="nominal">Nominal</option>
                                        </select>
                                        <div id="tenor-pinjaman" style="display: none">
                                            <label style="margin-top: 20px;" for="adjusment">Tenor Pinjaman</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="tenor"
                                                        id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="nominal-pinjaman" style="display: none">
                                            <label style="margin-top: 20px;" for="adjusment">Nominal Pinjaman</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="nominal"
                                                        id="">
                                                </div>
                                            </div>
                                        </div>
                                        <hr style=" border-top: 2px solid black;">
                                        <label style="margin-top: 20px;" for="adjusment">Adjustment</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="adjustment"
                                                    id="adjustment">
                                            </div>
                                        </div>
                                        <!-- <div class="row-clearfix" style="margin-top: 20px; margin-bottom: 100px;"> -->
                                        <!-- <div class="col-sm-3">
                                                                                                <div class="demo-switch-title">PENAMBAHAN</div>
                                                                                                <div class="switch">
                                                                                                    <label><input type="checkbox" value="tambah" name="penambahan"><span class="lever switch-col-grey"></span></label>
                                                                                                </div>
                                                                                            </div> -->
                                        <!-- <div class="col-lg-12"> -->
                                        <select class="form-control show-tick" style="margin-bottom: 100px;"
                                            name="keterangan_adjustment">
                                            <option value="">-- Opsi Adjusment --</option>
                                            <option value="tambah">Penambahan</option>
                                            <option value="kurang">Pengurangan</option>
                                        </select>

                                        <!-- </div> -->
                                        <!-- </div> -->
                                        <div id="supervisor" style="display: none;">
                                            <label style="margin-top: 20px;" for="supervisor">Supervisor</label>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="supervisor"
                                                        id="inputSupervisor">
                                                </div>
                                            </div>

                                        </div>
                                        <label id="htr" for="thr">THR</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="thr"
                                                    id="thr">
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control">
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                            </div> --}}
                                    {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" id="remember_me_5" class="filled-in">
                                <label for="remember_me_5">Remember Me</label>
                                <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect">LOGIN</button>
                            </div> --}}
                                </div>

                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-success waves-effect"><i class="material-icons me-3">save</i>SIMPAN</button> --}}
                            <button type="submit" name="submit" class="btn btn-success waves-effect"> <i
                                    class="material-icons">save</i><span>SIMPAN</span></button>
                            {{-- <button type="button" name="submit" class="btn btn-success waves-effect"><i class="material-icons">add</i><span>TAMBAH ROLE</span></button> --}}
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> <i
                                    class="material-icons">close</i><span>TUTUP</span></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="absen" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Keterangan Tidak Hadir</h4>

                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('update-absen') }}">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                                        <select id="opsi-pinjaman" class="form-control show-tick pinjaman"
                                            style="margin-bottom: 100px;" name="ket_tdk_hadir">
                                            <option value="">-- Keterangan Tidak Hadir --</option>
                                            <option value="C">C</option>
                                            <option value="SID">SID</option>
                                            <option value="IK">IK</option>
                                            <option value="IPG">IPG</option>
                                        </select>
                                        <label style="margin-top: 20px;" for="adjusment">Kode Absen</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="kode_absen"
                                                    id="kode_absen" readonly>
                                            </div>
                                        </div>
                                        <label style="margin-top: 20px;" for="adjusment">Tanggal</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="tanggal" id="tanggal"
                                                    readonly>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control">
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                            </div> --}}
                                    {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <input type="checkbox" id="remember_me_5" class="filled-in">
                                <label for="remember_me_5">Remember Me</label>
                                <button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect">LOGIN</button>
                            </div> --}}
                                </div>

                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-success waves-effect"><i class="material-icons me-3">save</i>SIMPAN</button> --}}
                            <button type="submit" name="submit" class="btn btn-success waves-effect"> <i
                                    class="material-icons">save</i><span>SIMPAN</span></button>
                            {{-- <button type="button" name="submit" class="btn btn-success waves-effect"><i class="material-icons">add</i><span>TAMBAH ROLE</span></button> --}}
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"> <i
                                    class="material-icons">close</i><span>TUTUP</span></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
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
        $(".datepickermaster2").datepicker({
            format: 'yyyy',
            viewMode: "years",
            minViewMode: "years"
        });
        $(document).ready(function() {
            $('#kehadiran').DataTable({
                fixedColumns: {
                    left: 3,
                    right: 0,
                },
                paging: false,
                scrollCollapse: true,
                scrollX: true,
                // scrollY: 300
            });
            $(document).on('click', '.editbtn', function() {
                {{-- alert('Please enter') --}}
                var nip = $(this).attr('data-id');
                var pinjaman = $(this).attr('data-pinjaman');
                var adjustment = $(this).attr('data-adjustment');
                var supervisor = $(this).attr('data-supervisor');
                var thr = $(this).attr('data-thr');
                var gapok = $(this).attr('data-gapok');
                var ukan = $(this).attr('data-ukan');
                var uport = $(this).attr('data-uport');
                if (nip == '01062012-12') {
                    $('#supervisor').css('display', 'block')
                    $('#htr').css('margin-top', '0px')
                } else {
                    $('#htr').css('margin-top', '20px')
                    $('#supervisor').css('display', 'none')
                }
                var value_pinjaman = parseInt(gapok) + parseInt(ukan) + parseInt(uport)
                var sisa_pinjaman = value_pinjaman - parseInt(pinjaman)
                var bilangan = sisa_pinjaman;

                var number_string = bilangan.toString(),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                console.log(rupiah);
                $('#nip').val(nip);
                $('#pinjaman').val(pinjaman);
                $('#adjustment').val(adjustment);
                $('#thr').val(thr);
                $('#inputSupervisor').val(supervisor);
                $('#saldo_pinjaman').text(rupiah);
                //  alert(book_id)
            });

            $(document).on('click', '.absens', function() {
                {{-- alert('Please enter') --}}
                var nip = $(this).attr('data-id');
                var tanggal = $(this).attr('data-tanggal');

                console.log(tanggal);
                $('#kode_absen').val(nip);
                $('#tanggal').val(tanggal);
            });


        });
        $(document).on('change', '.pinjaman', function() {
            let pinjam = document.getElementById('opsi-pinjaman').value;
            let tenor = document.getElementById('tenor-pinjaman');
            let nominal = document.getElementById('nominal-pinjaman');
            if (pinjam == 'tenor') {
                tenor.style.display = 'block';
                nominal.style.display = 'none';
            } else if (pinjam == 'nominal') {
                tenor.style.display = 'none';
                nominal.style.display = 'block';
            } else {
                tenor.style.display = 'none';
                nominal.style.display = 'none';
            }
            console.log(pinjam);
        });
    </script>
@endpush
