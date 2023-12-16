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
                            <form action=" {{route('lemburFilter')}} " method="GET">
                                @csrf
                            <div class="row">
                             <div class="col-sm-3">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input autocomplete="off" type="text" id="periodeawal" name="periodeawal" class="form-control datepickermaster2" value="<?php if(isset($_POST["cari"])){ echo $_POST["periodeawal"]; } ?>" required/>
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
                                    <input autocomplete="off" type="text" id="periodeakhir" name="periodeakhir" class="form-control datepickermaster2" value="<?php if(isset($_POST["cari"])){ echo $_POST["periodeakhir"]; } ?>" required/>
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
                                        </tr>
                                        
                                        @php
                                          $no ++;  
                                        @endphp
                                        @endforeach
                                        @endforeach
                                        <tr>
                                            <td style="text-align: right" colspan="12">Total</td>
                                            <td>@rupiah($grand_totals)</td>
                                        </tr>
                                        @else

                                        @endif
                                       
                                    </tbody>
                                </table>
                            </div>
                            @if ($rudianto)
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
                                                <table id="kehadiran" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            {{-- <th rowspan="2">No</th> --}}
                                                            {{-- <th rowspan="2">#</th> --}}
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
                                                            @for ($i = 0; $i < count($total_tanggal); $i++)
                                                                <th> {{ $i + 1 }} </th>
                                                            @endfor
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                
                                                        {{-- @foreach ($rudianto as $index => $data1) --}}
                                                            <tr>
                                                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                                                {{-- <td>
                                                                    <a data-id="{{ $rudianto->nip_pegawai }}"
                                                                        data-adjustment="{{ $rudianto->adjustment }}"
                                                                        data-pinjaman="{{ $rudianto->pinjaman }}"
                                                                        data-supervisor="{{ $rudianto->supervisor }}"
                                                                        data-thr="{{ $rudianto->thr }}" data-gapok="{{ $rudianto->gaji_pokok }}"
                                                                        data-ukan="{{ $rudianto->uang_makan }}"
                                                                        data-uport="{{ $rudianto->uang_transport }}" class="editbtn"
                                                                        title="HITUNG GAJI" data-target="#gajiModal" data-toggle="modal"
                                                                        href="#"><i class="material-icons"
                                                                            aria-hidden="true">attach_money</i></a>
                                                                    <a title="DETAIL GAJI {{ $rudianto->nama }}" target="_blank"
                                                                        href="{{ route('detailGaji', $rudianto->nip_pegawai . '_' . $rudianto->bulan) }}"><i
                                                                            class="material-icons" aria-hidden="true">search</i></a>
                                                                </td> --}}
                                                                <td>{{ $rudianto->nama }}</td>
                                                                <td>{{ $rudianto->nip_pegawai }}</td>
                                                                <td>{{ $rudianto->nama_jabatan }}</td>
                                                                <td>Pegawai {{ $rudianto->nama_status }}</td>
                                                                {{-- @else --}}
                                                                {{-- <td>
                                                                    @if ($rudianto->bulan == 01)
                                                                        Januari
                                                                    @elseif($rudianto->bulan == 02)
                                                                        Februari
                                                                    @elseif($rudianto->bulan == 03)
                                                                        Maret
                                                                    @elseif($rudianto->bulan == 04)
                                                                        April
                                                                    @elseif($rudianto->bulan == 05)
                                                                        Mei
                                                                    @elseif($rudianto->bulan == 06)
                                                                        Juni
                                                                    @elseif($rudianto->bulan == 07)
                                                                        Juli
                                                                    @elseif($rudianto->bulan == '08')
                                                                        Agustus
                                                                    @elseif($rudianto->bulan == '09')
                                                                        September
                                                                    @elseif($rudianto->bulan == 10)
                                                                        Oktober
                                                                    @elseif($rudianto->bulan == 11)
                                                                        November
                                                                    @elseif($rudianto->bulan == 12)
                                                                        Desember
                                                                    @endif
                                                                </td>
                                                                <td>{{ $rudianto->tahun }}</td> --}}
                                                                @php
                                                                    $tgl = $lemburRudianto->where('kode_absen', $rudianto->kode_absen);
                                                                    // dd($tgl);
                                                                @endphp
                                                                @foreach ($total_tanggal as $item)
                                                                    <td>
                                                                        @foreach ($tgl as $tg)
                                                                            @if ($item == $tg->tanggal)
                                                                                @if ($tg->masuk == '00:00:00')
                                                                                    @if ($tg->status_pegawai == 1)
                                                                                        <a href="#" id="absen"
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
                                                                                <a href="#"
                                                                                class="absens"
                                                                                            data-target="#absen" data-toggle="modal"
                                                                                            data-id="{{ $tg->kode_absen }}"
                                                                                            data-tanggal="{{ $tg->tanggal }}-{{ $tg->bulan_lembur }}-{{ $tg->tahun }}"
                                                                                >
                                                                                @if ($tg->keterangan == 1)
                                                                                <span class="badge bg-green">M</span>
                                                                                @elseif($tg->keterangan == 2)
                                                                                <span class="badge bg-green">P</span>
                                                                                @else   
                                                                                <span class="badge bg-green">H</span>
                                                                                @endif
                                                                                </a>
                                                                                   
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
                                                        {{-- @endforeach --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            @endif
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="absen" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Keterangan Lembur</h4>

                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('update-absen-rudianto') }}">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                                    <select id="opsi-pinjaman" class="form-control show-tick pinjaman"
                                        style="margin-bottom: 100px;" name="ket_tdk_hadir">
                                        <option value="">-- Keterangan Lembur --</option>
                                        <option value="1">Maintenance</option>
                                        <option value="2">Membantu Produksi</option>
                                    </select>
                                    <label style="margin-top: 20px;" for="adjusment">Kode Absen</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="kode_absen" id="kode_absen"
                                                readonly>
                                        </div>
                                    </div>
                                    <label style="margin-top: 20px;" for="adjusment">Tanggal</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="tanggal" id="tanggal"
                                                readonly>
                                        </div>
                                    </div>

                                    {{-- <label style="margin-top: 20px;" for="adjusment">Awal</label> --}}
                                    {{-- <div class="form-group">
                                        <div class="form-line"> --}}
                                            <input hidden type="hidden" class="form-control" name="awal" id="awal"
                                                readonly>
                                        {{-- </div>
                                    </div> --}}
                                    {{-- <label style="margin-top: 20px;" for="adjusment">Akhir</label> --}}
                                    {{-- <div class="form-group">
                                        <div class="form-line"> --}}
                                            <input  type="hidden" class="form-control" name="akhir" id="akhir"
                                                readonly>
                                        {{-- </div>
                                    </div> --}}
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
    
    
        $(document).on('click', '.absens', function() {
                {{-- alert('Please enter') --}}
                var nip = $(this).attr('data-id');
                var tanggal = $(this).attr('data-tanggal');
                var periodeAwal = $('#periodeawal').val();
                var periodeAkhir = $('#periodeakhir').val();
                // var tanggal = $(this).attr('data-tanggal');

                console.log(tanggal);
                $('#kode_absen').val(nip);
                $('#tanggal').val(tanggal);
                $('#awal').val(periodeAwal);
                $('#akhir').val(periodeAkhir);
            });
    
    </script>
@endpush
