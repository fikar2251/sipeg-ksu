@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>IMPORT DATA ABSENSI LEMBUR</h2>
            </div>
            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" style="height:140px;">
                        <div class="body">
                            <form id="form_validation" role="form" action="{{ route('import-lembur') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="exampleFormControlFile1">DATA KEHADIRAN KARYAWAN LEMBUR</label>
                                        <input required name="excel" type="file" class="form-control-file"
                                            id="exampleFormControlFile1">
                                        {{-- <label style="font-size: 12px; color:red;"><span style="color:red">*</span>Hanya bisa menggunakan file excel(.xls)</label> --}}

                                    </div>
                                  
                                    {{-- <div class="col-sm-3">
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
                                    </div> --}}
                                    <div class="col-sm-2">
                                        <button type="submit" name="upload" value="Submit"
                                            class="btn btn-lg btn-success">Submit</button>
                                    </div>
                                    <div class="col-sm-4">
                          <button class="btn btn-warning">
                          <a href="{{asset('public/Template_Data_Lembur.xlsx')}}" download>Download Template</a>
                          </button>
                          </div>
                                </div>
                            </form>


                        </div>

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
