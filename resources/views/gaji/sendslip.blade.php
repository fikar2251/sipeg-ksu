@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>KIRIM SLIP GAJI KE EMAIL</h2>
            </div>
            <div class="row clearfix js-sweetalert">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" style="height:140px;">
                        <div class="body">
                            <form id="form_validation" role="form" action="{{ route('kirimGaji') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <p>
                                            <b>Pilih Bulan</b>
                                        </p>
                                        <select required name="bulan" class="tahun form-control  show-tick">
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
                                        {{-- <select required name="filter" class="tahun form-control">
                                            <option value="">Pilih Tahun</option>
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
                                        </select> --}}
                                        <label class="form-label">Pilih Tahun</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input autocomplete="off" type="text" id="periodeakhir" name="tahun"
                                                    class="form-control datepickermaster2" value="<?php if (isset($_POST['cari'])) {
                                                        echo $_POST['periodeakhir'];
                                                    } ?>"
                                                    required />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <p>
                                            <b>Pilih Karyawan</b>
                                        </p>
                                        <select required name="karyawan" class="pegawai form-control show-tick">
                                            <option value="">Pilih Karyawan</option>
                                            <option value="all">Semua Karyawan</option>
                                            @foreach ($pegawai as $item)
                                                <option value='{{ $item->nip_pegawai }}'>{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" name="upload" value="Submit" class="btn btn-lg btn-success"
                                            style="margin-top: 20px">Send</button>
                                    </div>
                            </form>


                        </div>

                    </div>
                </div>
            </div>

    </section>
@endsection
@push('custom-scripts')
    <!-- jQuery -->
    {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        $(".datepickermaster2").datepicker({
            format: 'yyyy',
            viewMode: "years",
            minViewMode: "years"
        });
        $(".pegawai").select2();
    </script>

    {{-- <script>
        $('.datepickermaster2').datetimepicker({
            dayOfWeekStart: 1,
            lang: 'id',
            timepicker: false,
            disabledDates: ['1986/01/08', '1986/01/09', '1986/01/10'],
            format: 'Y'
        });
    </script> --}}
@endpush
