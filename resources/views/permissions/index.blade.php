@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                PERMISSION
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
                            <a style="margin-left: 7.5%" title="TAMBAH PERMISSION" href="javascript:void(0);" name="submit" class="btn btn-success waves-effect"><i class="material-icons">add</i><span>TAMBAH PERMISSION</span></a>
                        </div>
                        {{-- <form id="form_validation" method="post" action="">
                            <div class="col-sm-2">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input id="pilihExport" class="form-control" name="namafile" value="<?php // $getnamafile; ?>" />
                                        <label class="form-label">Pilih data export</label>
                                    </div>
                                </div>
                            </div>
                            <?php if ($getnamafile == "Karyawan") { ?>
                                <a title="EXPORT DATA KARYAWAN" href="pages/karyawan/cetakkaryawan.php?&act=excel" class="btn btn-primary waves-effect"><i class="material-icons">import_export</i><span>EXPORT DATA</span></a>
                        </form> --}}
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            {{-- <h4 style="margin-left: 54%"><b>Jumlah Karyawan : 257<?php // $rowheader->jumlahkaryawan; ?></b></h4> --}}
                        </div>
                        {{-- <?php }else{ ?> --}}
                        {{-- <div class="col-md-12">
                            <h4 style="margin-right: 70%"><b>Jumlah Karyawan : <?php // $rowheader->jumlahkaryawan; ?></b></h4>
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
                                    @foreach ($permission as $item)
                                    <tr>
                                        <td> {{$loop->iteration}} </td>
                                        <td> {{$item->name}} </td>
                                        <td class="text-center" style="width: 20%">
                                            <a title="UBAH PERMISSION" href="#"><i class="material-icons" aria-hidden="true">edit</i></a>
                                            <a title="HAPUS PERMISSION" href="#" role="button" class="hapusPermission" data-id="" data-toggle="modal"><i class="material-icons" aria-hidden="true">delete</i></a>
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
</section
@endsection