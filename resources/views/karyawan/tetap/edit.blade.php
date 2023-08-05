@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
                UBAH DATA KARYAWAN TETAP
                {{-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> --}}
            </h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <div class="row clearfix">
                            <form action="{{route('updatekaryawanKontrak', $data->id)}}" method="POST" >
                                @csrf
                                @method('PUT')
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <label for="nama">Nama</label>
                                    <div class="form-group ">
                                    
                                        <div class="form-line">
                                            <input type="text" id="jabatan1Input" name="nama" class="form-control" value="{{$data->nama}}" />
                                            {{-- <input type="hidden" id="jabatan1Inputhidden" name="jabatan1Input" class="form-control" value="" /> --}}
                                            {{-- <label class="form-label">Nama</label> --}}
                                        </div>
                                        @error('nama')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="tempat_lahir">NIP</label>
                                    <div class="form-group ">
                                        <div class="form-line">
                                            <input type="text" id="jabatan2Input" name="nip" class="form-control" value="{{$data->nip_pegawai}}" />
                                            {{-- <input type="hidden" id="jabatan2Inputhidden" name="jabatan2Input" class="form-control" value="" /> --}}
                                            {{-- <label class="form-label">NIP</label> --}}
                                        </div>
                                        @error('nip')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label for="tempat_lahir">Alamat</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            {{-- <input type="hidden" id="namaInput1"  class="form-control" value="{{old('alamat')}}" /> --}}
                                            <textarea name="alamat" rows="4" class="form-control no-resize" placeholder="">{{$data->alamat}}</textarea>
                                            {{-- <label class="form-label">Alamat</label> --}}
                                        </div>
                                        @error('alamat')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                   <p>
                                    <b>Pilih Jenis Kelamin</b>
                                   </p>
                                        <select name="jenis_kelamin" id="realisasiInput" class="form-control">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="L" @selected($data->jenis_kelamin == 'L')>Laki-laki</option>
                                            <option value="P" @selected($data->jenis_kelamin == 'P')>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                              
                                </div>
                                <div class="col-sm-6">
                                    <label for="tempat_lahir">No. KTP</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="paguMin" name="ktp" class="form-control" value="{{$data->ktp}}"  />
                                            {{-- <label class="form-label">No KTP</label> --}}
                                        </div>
                                        @error('ktp')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="tempat_lahir">No. BPJS Kesehatan</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="paguMax" name="bpjs_kes" class="form-control" value="{{$data->bpjs_kes}}"  />
                                            {{-- <label class="form-label">No. BPJS Kesehatan</label> --}}
                                        </div>
                                        @error('bpjs_kes')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="tempat_lahir">No. BPJS Ketenagakerjaan</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="paguInput" name="bpjs_ket" class="form-control" value="{{$data->bpjs_ket}}"  />
                                            {{-- <label class="form-label">No. BPJS Ketenagakerjaan</label> --}}
                                        </div>
                                        @error('bpjs_ket')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="tempat_lahir">No. NPWP</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="fungsionalInput" name="npwp" class="form-control" value="{{$data->npwp}}" />
                                            {{-- <label class="form-label">No. NPWP</label> --}}
                                        </div>
                                        @error('npwp')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="tempat_lahir">Email</label>
                                    <div class="form-group ">
                                        <div class="form-line">
                                            <input type="text" id="fungsionalInput" name="email" class="form-control" value="{{$data->email}}" />
                                            {{-- <label class="form-label">Email</label> --}}
                                        </div>
                                        @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="tempat_lahir">Gaji Pokok</label>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="fungsionalInput" name="gaji_pokok" class="form-control" value="{{$data->gaji_pokok}}" />
                                            {{-- <label class="form-label">Gaji Pokok</label> --}}
                                        </div>
                                        @error('gaji_pokok')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <p>
                                        <b>Pilih PTKP</b>
                                       </p>
                                        <select name="ptkp" id="strukturalInput" class="form-control">
                                            <option value="">-- Pilih PTKP --</option>
                                            <option value="TK/0" @selected($data->ptkp == 'TK/0')>TK/0</option>
                                            <option value="K/0" @selected($data->ptkp == 'K/0')>K/0</option>
                                            <option value="K/1" @selected($data->ptkp == 'K/1')>K/1</option>
                                            <option value="K/2" @selected($data->ptkp == 'K/2')>K/2</option>
                                            <option value="K/3" @selected($data->ptkp == 'K/3')>K/3</option>
                                        </select>
                                        @error('ptkp')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                
                                    <!-- <input type="button" value="TAMBAH" class="btn bg-blue waves-effect" onclick="resetSelect()" /> -->
                                </div>
                                <div class="col-sm-12">
                                    <p>
                                        <b>Pilih Departemen</b>
                                    </p>
                                        <select name="departemen" id="strukturalInput" class="form-control show-tick">
                                            <option value="">-- Pilih Departemen --</option>
                                            @foreach ($depart as $dep)
                                            <option value="{{$dep->id}}" @selected($data->departemen == $dep->id)>-- {{$dep->nama}} --</option>
                                            @endforeach
                                        </select>
                                        @error('departemen')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                  
                                    <!-- <input type="button" value="TAMBAH" class="btn bg-blue waves-effect" onclick="resetSelect()" /> -->
                                </div>
                                <div class="col-sm-6">
                                    <p>
                                        <b>Pilih Jabatan</b>
                                    </p>
                                        <select name="jabatan" id="jabatan" class="form-control">
                                            <option value="">-- Pilih Jabatan --</option>
                                            @foreach ($jabatan as $jabs)
                                            <option value="{{$jabs->id}}" @selected($data->jabatan == $jabs->id)>-- {{$jabs->nama}} --</option>
                                            @endforeach
                                        </select>
                                        @error('jabatan')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    <!-- <input type="button" value="TAMBAH" class="btn bg-blue waves-effect" onclick="resetSelect()" /> -->
                                </div>
                                <div class="col-sm-6">
                                    
                                <label for="tgl_masuk_kerja">Tanggal Masuk Kerja</label>
                                    <div class="form-group">
                                        {{-- <div class="form-line" id="bs_datepicker_container">
                                            <label class="form-label">Tanggal Masuk Kerja</label>
                                            <input type="text" name="tgl_masuk_kerja" class="form-control datepicker" placeholder="Please choose a date...">
                                        </div> --}}
                                            <div class="form-line" >
                                                <input id="bs_datepicker_container" name="tgl_masuk_kerja" value="{{\Carbon\Carbon::parse($data->tanggal_masuk_kerja)->format('d-m-Y')}}"  type="text" class="form-control">
                                            </div>
                                            @error('tgl_masuk_kerja')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                      
                                    </div>
                                    <!-- <input type="button" value="TAMBAH" class="btn bg-blue waves-effect" onclick="resetSelect()" /> -->
                                </div>
                                <div class="col-sm-6">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <div class="form-group">
                                        <div class="form-line" >
                                            <input id="tgl_lahir" name="tgl_lahir" value="{{\Carbon\Carbon::parse($data->tanggal_lahir)->format('d-m-Y')}}"  type="text" class="form-control" >
                                        </div>
                                        @error('tgl_lahir')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <!-- <input type="button" value="TAMBAH" class="btn bg-blue waves-effect" onclick="resetSelect()" /> -->
                                </div>
                                <div class="col-sm-6">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="fungsionalInput" value="{{$data->tempat_lahir}}" name="tempat_lahir" class="form-control" value="" />
                                            {{-- <label class="form-label">Tempat Lahir</label> --}}
                                        </div>
                                        @error('tempat_lahir')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                               
                                <!-- </div> -->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" id="button" class="btn bg-green waves-effect">
                                            <i class="material-icons">save</i>
                                            <span>SIMPAN</span>
                                        </button>
                                        <a href="{{route('karyawantetap')}}" class="btn bg-orange waves-effect">
                                            <i class="material-icons">replay</i>
                                            <span>KEMBALI</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script>
        $('#bs_datepicker_container').datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true
        });
        $('#tgl_lahir').datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true
        });
    </script>
@endpush