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
                         <form id="form_validation" role="form" action="{{route('file-import')}}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group">
                                  <div class="col-sm-4">
                                    <label for="exampleFormControlFile1">DATA KEHADIRAN KARYAWAN</label>
                                    <input name="excel" type="file" class="form-control-file" id="exampleFormControlFile1">
                                    {{-- <label style="font-size: 12px; color:red;"><span style="color:red">*</span>Hanya bisa menggunakan file excel(.xls)</label> --}}
                                  </div>
                                  <div class="col-sm-2">
                                    <button type="submit" name="upload" value="Submit" class="btn btn-lg btn-success">Submit</button>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tempat, Tgl Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection