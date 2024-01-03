@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                DATA KARYAWAN TIDAK AKTIF
                {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <br>
                    <div class="row">
                        {{-- <div class="col-md-5">
                            <a style="margin-left: 7.5%" title="TAMBAH KARYAWAN" href="{{route('createkaryawantetap')}}" name="submit" class="btn btn-success waves-effect"><i class="material-icons">add</i><span>TAMBAH DATA</span></a>
                        </div> --}}
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
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <h4 style="margin-left: 54%"><b>Jumlah Karyawan : {{$jumlah_pegawai}}<?php // $rowheader->jumlahkaryawan; ?></b></h4>
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
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIP</th>
                                        <th>Jabatan</th>
                                        <th>Sisa Cuti</th>
                                        <th>Aksi</th>
                                        {{-- <th>Salary</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pegawai as $indes => $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->nama}}</td>
                                        <td>{{$data->nip_pegawai}}</td>
                                        <td>{{$data->nama_jabatan}}</td>
                                        @php
                                        $sisa_cuti = $cuti->where('kode_absen', $data->kode_absen)->count();
                                        // dd($sisa_cuti);
                                        @endphp
                                        <td>{{12 - $sisa_cuti }} </td>
                                        <td class="text-center">
                                            <a title="DETIL KARYAWAN" href="#" role="button" class="detailKaryawan" data-id="" data-toggle="modal" data-target="#defaultdetailKaryawan{{$data->id}}"><i class="material-icons" aria-hidden="true">zoom_in</i></a>
                                            <a title="UBAH KARYAWAN" href="{{route('editkaryawanTetap', $data->id)}}"><i class="material-icons" aria-hidden="true">edit</i></a>
                                        </td>
                                        <div class="modal fade" id="defaultdetailKaryawan{{$data->id}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="defaultModalLabel">Detail Karyawan</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="panel-body">
                                                            <div class="row clearfix">
                                                                <div class="col-md-6">
                                                                    NIP
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->nip_pegawai}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Status
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->status == 1 ? 'Aktif' : 'Tidak Aktif' }}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Nama Lengkap
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->nama}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Tanggal Lahir
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($data->tanggal_lahir)->format('d-m-Y')}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Jenis Kelamin
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Tempat Lahir
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->tempat_lahir}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                   NPWP
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->npwp}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Nomor KTP
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->ktp}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    Alamat
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->alamat}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                   Jabatan
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->nama_jabatan}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Tgl Masuk Kerja
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($data->tanggal_masuk_kerja)->format('d-m-Y')}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Departemen
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->nama_departemen}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    Gaji Pokok
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="@rupiah($data->gaji_pokok)" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    BPJS Kesehatan
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->bpjs_kes}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    BPJS Ketenagakerjaan
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->bpjs_ket}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    E-mail Pribadi
                                                                    <div class="input-group colorpicker">
                                                                        <div class="form-line">
                                                                           <input type="text" class="form-control" value="{{$data->email}}" readonly>
                                                                        </div>
                                                                        <span class="input-group-addon">
                                                                            <i></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-color="red" class="btn bg-red waves-effect" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </tr>   
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
<script>
   
</script>
@endpush