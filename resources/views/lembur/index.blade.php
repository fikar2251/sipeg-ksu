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
            <div class="block-header">
                <h2>
                    DATA LEMBUR KARYAWAN
                    {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <form action=" {{route('lemburFilter')}} " method="POST">
                                @csrf
                            <div class="row">
                             <div class="col-sm-3">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="periodeawal" name="periodeawal" class="form-control datepickermaster2" value="<?php if(isset($_POST["cari"])){ echo $_POST["periodeawal"]; } ?>" required/>
                                    <label class="form-label">Periode Awal</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 form-control-label" style="width:50px;">
                            <label>S/D</label>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="periodeakhir" name="periodeakhir" class="form-control datepickermaster2" value="<?php if(isset($_POST["cari"])){ echo $_POST["periodeakhir"]; } ?>" required/>
                                    <label class="form-label">Periode Akhir</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button name="cari" type="submit" class="btn bg-green waves-effect">
                                <i class="material-icons">search</i>
                                <span>CARI</span>
                            </button>
                            <!-- <a href="{{route('lemburAll')}}"  class="btn bg-green waves-effect">
                                <i class="material-icons">refresh</i>
                                <span>RESET</span></a> -->
                        </div>
                            </div>
                            </form>
                           
                            @if(request()->is('lemburFilter'))
                            <div class="table-responsive">
                                <table style="font-size: 12px"
                                    class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            {{-- <th rowspan="2">No</th> --}}
                                            <th rowspan="2">NO</th>
                                            <th rowspan="2">NAMA</th>
                                            <th style="text-align: center" colspan="4">LEMBUR</th>
                                            <th style="text-align: center" colspan="3">U. M & T (H. LIBUR)</th>
                                            <th style="text-align: center" colspan="3">U. M (H. BIASA)</th>
                                            {{-- <th style="text-align: center" colspan="3">U. KENEK</th> --}}
                                            <th rowspan="2">TOTAL</th>
                                        </tr>
                                        <tr>
                                            <th>JML</th>
                                            <th>LMR/JAM</th>
                                            <th>JML</th>
                                            <th >PEMBULATAN</th>
                                            <th>JML</th>
                                            <th >U. M & T</th>
                                            <th>TOTAL</th>
                                            <th>JML</th>
                                            <th>U. MKN</th>
                                            <th>TOTAL</th>
                                            {{-- <th>JML</th>
                                            <th>KENEK</th>
                                            <th>TOTAL</th> --}}
                                         
                                            {{-- <th ></th>
                                            <th ></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($dataLembur) > 0)
                                        @php
                                            $no = 1;
                                        @endphp
                                       @foreach ($dataLembur as $item)
                                       @foreach ($item as $items)             
                                        <tr>
                                            {{-- <td >{{$loop->iteration}}</td> --}}
                                            <td>{{$no}}</td>
                                            <td> {{$items['nama']}} </td>
                                        <td>{{$items['jml_lembur']}}</td>
                                            <td>@rupiah($items['upah_per_jam'])</td>
                                            <td>@rupiah($items['upah'])</td>
                                            <td>@rupiah($items['pembulatan_upah'])</td>
                                            <td>{{$items['jml_uml']}}</td>
                                            <td>@rupiah($items['umt'])</td>
                                            <td>@rupiah($items['uml'])</td>
                                            <td>{{$items['jml_umb']}}</td>
                                            <td>@rupiah($items['um'])</td>
                                            <td>@rupiah($items['umb'])</td>
                                            <td>@rupiah($items['total'])</td>
                                            {{-- <td></td>
                                            <td></td>
                                            <td></td> --}}
                                        </tr>
                                        @php
                                          $no ++;  
                                        @endphp
                                        @endforeach
                                        @endforeach
                                        @else

                                        @endif
                                       
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            
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
        $('.datepickermaster2').datetimepicker({
            dayOfWeekStart: 1,
            lang: 'en',
            timepicker: false,
            disabledDates: ['1986/01/08', '1986/01/09', '1986/01/10'],
            
            format: 'd-m-Y'
        });
    </script>
@endpush
