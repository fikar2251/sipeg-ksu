@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>IMPORT EXCEL</h2>
            </div>
            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" style="height:140px;">
                        <div class="body">
                            <form id="form_validation" role="form" action="{{ route('file-import') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label for="exampleFormControlFile1">DATA KEHADIRAN KARYAWAN</label>
                                        <input required name="excel" type="file" class="form-control-file"
                                            id="exampleFormControlFile1">
                                        {{-- <label style="font-size: 12px; color:red;"><span style="color:red">*</span>Hanya bisa menggunakan file excel(.xls)</label> --}}

                                    </div>
                                    <div class="col-sm-3">
                                        <select required name="filter" class="tahun form-control">
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
                                    <div class="col-sm-2">
                                        <button type="submit" name="upload" value="Submit"
                                            class="btn btn-lg btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>


                        </div>

                    </div>
                </div>
            </div>
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
                                                <td>{{ $data1->jumlah_masuk }}</td>
                                                <td>
                                                    <a data-id="{{ $data1->nip_pegawai }}" class="editbtn"
                                                        title="HITUNG GAJI" data-target="#gajiModal" data-toggle="modal"
                                                        href="#"><i class="material-icons"
                                                            aria-hidden="true">mode_edit</i></a>
                                                    <a title="DETAIL GAJI {{ $data1->nama }}" target="_blank"
                                                        href="{{ route('detailGaji', $data1->nip_pegawai) }}"><i
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
                                    <div class="form-group form-float">
                                        <div>
                                            <input type="hidden" class="form-control" value="" id="nip"
                                                name="nip">
                                        </div>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="pinjaman">
                                            <label class="form-label">Pinjaman</label>
                                        </div>
                                        <div class="form-line" style="margin-top: 20px;">
                                            <input type="text" class="form-control" name="adjustment">
                                            <label class="form-label">Adjustment</label>
                                        </div>
                                        <div class="row-clearfix" style="margin-top: 20px;">
                                            <div class="col-sm-3">
                                                <div class="demo-switch-title">PENAMBAHAN</div>
                                                <div class="switch">
                                                    <label><input type="checkbox" ><span class="lever switch-col-grey"></span></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="demo-switch-title">PENGURANGAN</div>
                                                <div class="switch">
                                                    <label><input type="checkbox" ><span class="lever switch-col-grey"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div  id="supervisor" class="form-line" style="margin-top: 80px;">
                                            <input type="text" class="form-control" name="supervisor">
                                            <label class="form-label">Supervisor</label>
                                        </div>
                                        <div  id="supervisor" class="form-line" style="margin-top: 20px;">
                                            <input type="text" class="form-control" name="thr">
                                            <label class="form-label">THR</label>
                                        </div>
                                    </div>
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
                var book_id = $(this).attr('data-id');
                console.log(book_id);
                $('#nip').val(book_id);
                //  alert(book_id)
            });

        });
    </script>
@endpush
