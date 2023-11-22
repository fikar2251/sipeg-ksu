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
                    DATA GAJI KARYAWAN TETAP
                    {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table style="font-size: 12px"
                                    class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            {{-- <th rowspan="2">No</th> --}}
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">NIP</th>
                                            <th rowspan="2">Gaji Gross</th>
                                            <th rowspan="2">
                                              Gaji Pokok</th>
                                            <th style="width: 25%" rowspan="2">Jml. Hari Kerja</th>
                                            <th style="width: 25%" rowspan="2">Bulan</th>
                                            <th style="text-align: center" colspan="3">Tunjangan</th>
                                            <th rowspan="2">Adjusment</th>
                                            <th rowspan="2">Total Gaji</th>
                                            <th style="text-align: center" colspan="3">Premi Asuransi</th>
                                            <th style="text-align: center" colspan="4">Potongan</th>
                                            <th rowspan="2">Netto Gaji</th>
                                            <th rowspan="2">Sisa Pinjaman</th>
                                        </tr>
                                        <tr>
                                            <th>Makan</th>
                                            <th>Transport</th>
                                            <th>Supervisor</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>JP</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>JP</th>
                                            <th>Pinjaman</th>
                                            {{-- <th ></th>
                                            <th ></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_tetap as $gaji)
                                        <tr>
                                            {{-- <td >{{$loop->iteration}}</td> --}}
                                            <td>
                                                <a target="_blank" href="{{ route('detailGaji', $gaji->nip_pegawai .'_'.$gaji->bulan) }}">{{ $gaji->nama }}</a>                                                
                                            </td>
                                            <td>{{ $gaji->nip_pegawai }}</td>
                                            <td> @rupiah( $gaji->gaji_pokok + $gaji->uang_makan + $gaji->uang_transport)</td>
                                            <td>@rupiah($gaji->gaji_pokok)</td>
                                            <td>{{ $gaji->jumlah_masuk }}</td>
                                            <td>@if($gaji->bulan == 01)
                                                    Januari
                                                    @elseif($gaji->bulan == 02)
                                                    Februari 
                                                    @elseif($gaji->bulan == 03)
                                                    Maret
                                                    @elseif($gaji->bulan == 04)
                                                    April
                                                    @elseif($gaji->bulan == 05)
                                                    Mei
                                                    @elseif($gaji->bulan == 06)
                                                    Juni
                                                    @elseif($gaji->bulan == 07)
                                                    Juli
                                                    @elseif($gaji->bulan == '08')
                                                    Agustus
                                                    @elseif($gaji->bulan == '09')
                                                    September
                                                    @elseif($gaji->bulan == 10)
                                                    Oktober
                                                    @elseif($gaji->bulan == 11)
                                                    November
                                                    @elseif($gaji->bulan == 12)
                                                    Desember
                                                    @endif</td>
                                            <td>@rupiah($gaji->uang_makan)</td>
                                            <td>@rupiah($gaji->uang_transport)</td>
                                            <td>@rupiah($gaji->supervisor)</td>
                                            <td>@rupiah($gaji->adjustment)</td>
                                            <td>@rupiah($gaji->uang_makan + $gaji->uang_transport + $gaji->gaji_pokok + $gaji->adjustment)</td>
                                            <td>@rupiah($gaji->premi_bpjs_ket)</td>
                                            <td>@rupiah($gaji->premi_bpjs_kes)</td>
                                            <td>@rupiah($gaji->premi_jp)</td>
                                            <td>@rupiah($gaji->pot_bpjs_ket)</td>
                                            <td>@rupiah($gaji->pot_bpjs_kes)</td>
                                            <td>@rupiah($gaji->pot_jp)</td>
                                            <td>
                                                {{-- @rupiah($gaji->nominal_pinjaman) --}}
                                                @if ($gaji->sisa_pinjaman === $gaji->pinjaman)
                                                        @rupiah(0)
                                                    @else
                                                    @rupiah($gaji->nominal_pinjaman)
                                                    @endif
                                            </td>
                                            <td>@php
                                                $netto_gaji_tetap = HitungGaji::hitungTetap($gaji->nip_pegawai, $gaji->pinjaman, $gaji->adjustment, $gaji->supervisor, $gaji->bulan);
                                                echo "Rp. " . number_format($netto_gaji_tetap, 0, ',', '.');
                                            @endphp</td>
                                            <td>@rupiah($gaji->sisa_pinjaman)</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            
                        </div>
                    </div>
                    <div class="block-header">
                        <h2>
                            DATA GAJI KARYAWAN KONTRAK
                            {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
                        </h2>
                    </div>
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table style="font-size: 12px"
                                    class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            {{-- <th rowspan="2">No</th> --}}
                                            <th rowspan="2">Nama</th>
                                            <th rowspan="2">NIP</th>
                                            <th rowspan="2">Gaji Gross</th>
                                            <th rowspan="2">
                                              Gaji per Hari</th>
                                            <th style="width: 25%" rowspan="2">Jml. Hari Kerja</th>
                                            <th style="width: 25%" rowspan="2">Bulan</th>
                                            <th style="text-align: center" colspan="2">Tunjangan</th>
                                            <th rowspan="2">Adjusment</th>
                                            <th rowspan="2">Total Gaji</th>
                                            <th style="text-align: center" colspan="3">Premi Asuransi</th>
                                            <th style="text-align: center" colspan="4">Potongan</th>
                                            <th rowspan="2">Netto Gaji</th>
                                            <th rowspan="2">Sisa Pinjaman</th>
                                        </tr>
                                        <tr>
                                            <th>Makan</th>
                                            <th>Transport</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>JP</th>
                                            <th>BPJS KET.</th>
                                            <th>BPJS KES.</th>
                                            <th>JP</th>
                                            <th>PPh21</th>
                                            {{-- <th ></th>
                                            <th ></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_kontrak as $gaji)
                                        <tr>
                                            {{-- <td >{{$loop->iteration}}</td> --}}
                                            <td> <a target="_blank" href="{{ route('detailGaji', [$gaji->nip_pegawai, $gaji->bulan]) }}">{{ $gaji->nama }}</a> </td>
                                            <td>{{ $gaji->nip_pegawai }}</td>
                                            <td> @rupiah( $gaji->gaji_gross_kontrak)</td>
                                            <td>@rupiah($gaji->gaji_pokok)</td>
                                            <td>{{ $gaji->jumlah_masuk }}</td>
                                            <td>@if($gaji->bulan == 01)
                                                    Januari
                                                    @elseif($gaji->bulan == 02)
                                                    Februari 
                                                    @elseif($gaji->bulan == 03)
                                                    Maret
                                                    @elseif($gaji->bulan == 04)
                                                    April
                                                    @elseif($gaji->bulan == 05)
                                                    Mei
                                                    @elseif($gaji->bulan == 06)
                                                    Juni
                                                    @elseif($gaji->bulan == 07)
                                                    Juli
                                                    @elseif($gaji->bulan == '08')
                                                    Agustus
                                                    @elseif($gaji->bulan == '09')
                                                    September
                                                    @elseif($gaji->bulan == 10)
                                                    Oktober
                                                    @elseif($gaji->bulan == 11)
                                                    November
                                                    @elseif($gaji->bulan == 12)
                                                    Desember
                                                    @endif</td>
                                            <td>@rupiah($gaji->uang_makan)</td>
                                            <td>@rupiah($gaji->uang_transport)</td>
                                            <td>@rupiah($gaji->adjustment)</td>
                                            <td>@rupiah($gaji->gaji_gross_kontrak + $gaji->adjustment -  $gaji->pot_bjs_kes - $gaji->pot_bpjs_ket - $gaji->pot_jp)</td>
                                            <td>@rupiah($gaji->premi_bpjs_ket)</td>
                                            <td>@rupiah($gaji->premi_bpjs_kes)</td>
                                            <td>@rupiah($gaji->premi_jp)</td>
                                            <td>@rupiah($gaji->pot_bpjs_ket)</td>
                                            <td>@rupiah($gaji->pot_bpjs_kes)</td>
                                            <td>@rupiah($gaji->pot_jp)</td>
                                            <td>@php
                                                $pph = HitungGaji::hitungPPH($gaji->nip_pegawai, $gaji->thr);
                                                echo "Rp. " . number_format($pph, 0, ',', '.');
                                            @endphp</td>
                                            <td>@php
                                                $total_gaji = HitungGaji::hitungKontrak($gaji->nip_pegawai, $gaji->adjustment);
                                                $pph = HitungGaji::hitungPPH($gaji->nip_pegawai, $gaji->thr);
                                                $netto_kontrak = $total_gaji - $pph;
                                                echo "Rp. " . number_format($netto_kontrak, 0, ',', '.');
                                            @endphp</td>
                                            <td></td>
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
    </section>
    {{-- <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet"> --}}
@endsection
