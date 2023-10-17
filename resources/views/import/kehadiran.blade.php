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
                            {{-- @if ($message = Session::get('success'))
                        <div class="alert bg-green alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ $message }}
                        </div>
                        @endif
                               @if ($message = Session::get('error'))
                               <div class="alert bg-red alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{ $message }}
                            </div>
                            @endif --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>NIP</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th>Bulan</th>
                                            <th>Jumlah Kehadiran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pegawai as $data1)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data1->nama }}</td>
                                                <td>{{ $data1->nip_pegawai }}</td>
                                                <td>{{ $data1->nama_jabatan }}</td>
                                                <td>Pegawai {{ $data1->nama_status }}</td>
                                                <td>@if($data1->bulan == 01)
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
                                                <td>{{ $data1->jumlah_masuk }}</td>
                                                <td>
                                                    <a data-id="{{ $data1->nip_pegawai }}" data-adjustment="{{$data1->adjustment}}" data-pinjaman="{{$data1->pinjaman}}" data-supervisor="{{$data1->supervisor}}" data-thr="{{$data1->thr}}" class="editbtn"
                                                        title="HITUNG GAJI" data-target="#gajiModal" data-toggle="modal"
                                                        href="#"><i class="material-icons"
                                                            aria-hidden="true">attach_money</i></a>
                                                    <a title="DETAIL GAJI {{ $data1->nama }}" target="_blank"
                                                        href="{{ route('detailGaji', [$data1->nip_pegawai, $data1->bulan]) }}"><i
                                                            class="material-icons" aria-hidden="true">search</i></a>
                                                </td>
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
                                        <label for="pinjaman">Pinjaman</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="pinjaman" id="pinjaman">
                                            </div>
                                        </div>
                                        <select id="opsi-pinjaman" class="form-control show-tick pinjaman" style="margin-bottom: 100px;" name="keterangan_adjustment">
                                            <option value="">-- Opsi Pinjaman --</option>
                                            <option value="tenor">Tenor</option>
                                            <option value="nominal">Nominal</option>
                                        </select>
                                        <div id="tenor-pinjaman" style="display: none">
                                            <label style="margin-top: 20px;" for="adjusment">Tenor Pinjaman</label>
                                            <div class="form-group">
                                                <div class="form-line" >
                                                    <input type="text" class="form-control" name="tenor" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="nominal-pinjaman" style="display: none">
                                            <label style="margin-top: 20px;" for="adjusment">Nominal Pinjaman</label>
                                            <div class="form-group">
                                                <div class="form-line" >
                                                    <input type="text" class="form-control" name="nominal" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <label  style="margin-top: 20px;" for="adjusment">Adjustment</label>
                                        <div class="form-group">
                                            <div class="form-line" >
                                                <input type="text" class="form-control" name="adjustment" id="adjustment">
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
                                                <select class="form-control show-tick" style="margin-bottom: 100px;" name="keterangan_adjustment">
                                                    <option value="">-- Opsi Adjusment --</option>
                                                    <option value="tambah">Penambahan</option>
                                                    <option value="kurang">Pengurangan</option>
                                                </select>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                        <div id="supervisor" style="display: none;">
                                            <label style="margin-top: 20px;" for="supervisor">Supervisor</label>
                                            <div class="form-group" >
                                                <div  class="form-line" >
                                                    <input type="text" class="form-control" name="supervisor" id="inputSupervisor" >
                                                </div>
                                            </div>

                                        </div>
                                        <label id="htr" for="thr">THR</label>
                                        <div class="form-group">
                                            <div  class="form-line">
                                                <input type="text" class="form-control" name="thr" id="thr">
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '.editbtn', function() {
                {{-- alert('Please enter') --}}
                var nip = $(this).attr('data-id');
                var pinjaman = $(this).attr('data-pinjaman');
                var adjustment = $(this).attr('data-adjustment');
                var supervisor = $(this).attr('data-supervisor');
                var thr = $(this).attr('data-thr');
                if (nip == '01062012-12') {
                    $('#supervisor').css('display', 'block')
                    $('#htr').css('margin-top', '0px')
                }else{
                    $('#htr').css('margin-top', '20px')
                    $('#supervisor').css('display', 'none')
                }
                console.log(nip);
                $('#nip').val(nip);
                $('#pinjaman').val(pinjaman);
                $('#adjustment').val(adjustment);
                $('#thr').val(thr);
                $('#inputSupervisor').val(supervisor);
                //  alert(book_id)
            });

            
        });
        $(document).on('change', '.pinjaman', function() {
           let pinjam = document.getElementById('opsi-pinjaman').value;
           let tenor = document.getElementById('tenor-pinjaman');
           let nominal = document.getElementById('nominal-pinjaman');
           if (pinjam ==  'tenor') {
            tenor.style.display = 'block';
            nominal.style.display = 'none';
           }else if(pinjam == 'nominal') {
            tenor.style.display = 'none';
            nominal.style.display = 'block';
           }else{
            tenor.style.display = 'none';
            nominal.style.display = 'none';
           }
           console.log(pinjam);
        });
    </script>
@endpush
