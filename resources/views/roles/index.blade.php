@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    ROLE
                    {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <br>
                        <div class="row">
                            <div class="col-md-5">
                                <button type="button" data-toggle="modal" data-target="#defaultModal"
                                    style="margin-left: 7.5%" title="TAMBAH ROLE" name="submit"
                                    class="btn btn-success waves-effect"><i class="material-icons">add</i><span>TAMBAH
                                        ROLE</span></button>
                               

                            </div>
                            
                            {{-- <form id="form_validation" method="post" action="">
                            <div class="col-sm-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="pilihExport" class="form-control" name="namafile" value="<?php // $getnamafile;
                                        ?>" />
                                        <label class="form-label">Pilih data export</label>
                                    </div>
                                </div>
                            </div>
                            <?php if ($getnamafile == "Karyawan") { ?>
                                <a title="EXPORT DATA KARYAWAN" href="pages/karyawan/cetakkaryawan.php?&act=excel" class="btn btn-primary waves-effect"><i class="material-icons">import_export</i><span>EXPORT DATA</span></a>
                        </form> --}}
                            <div class="col-md-1"></div>
                            <div class="col-md-6">
                                {{-- <h4 style="margin-left: 54%"><b>Jumlah Karyawan : 257<?php // $rowheader->jumlahkaryawan;
                                ?></b></h4> --}}
                            </div>
                            {{-- <?php }else{ ?> --}}
                            {{-- <div class="col-md-12">
                            <h4 style="margin-right: 70%"><b>Jumlah Karyawan : <?php // $rowheader->jumlahkaryawan;
                            ?></b></h4>
                        </div> --}}
                            {{-- <?php } ?> --}}
                        </div>
                        <br>
                        {{-- <div class="header">
                        <h2>
                            KARYAWAN TETAP
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div> --}}
                        <div class="body">
                             @if ($message = Session::get('success'))
                             <div class="alert bg-green alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{$message}}
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                            {{-- <th>Salary</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td> {{ $loop->iteration }} </td>
                                                <td> {{ $item->name }} </td>
                                                <td class="text-center" style="width: 20%">
                                                    <a title="UBAH ROLE" href="#"><i class="material-icons"
                                                            aria-hidden="true">edit</i></a>
                                                    <a title="HAPUS ROLE" href="#" role="button" class="hapusRole"
                                                        data-id="" data-toggle="modal"><i class="material-icons"
                                                            aria-hidden="true">delete</i></a>
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
        <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Tambah Data Role</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('input-roles') }}">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name">
                                            <label class="form-label">Nama</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control show-tick" multiple name="permission[]">
                                        <option selected disabled>-- Pilih Permission --</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>

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
</section @endsection
