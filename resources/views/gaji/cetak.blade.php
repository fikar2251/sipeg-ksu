<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>404 | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    {{-- <link rel="icon" href="{{asset('asset/favicon.ico" type="image/x-icon')}}"> --}}

    <!-- Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('asset/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('asset/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('asset/css/style.css')}}" rel="stylesheet"> --}}
    <style>
        table {
            font-size: 12px;
        }

        page[size="A4"][layout="landscape"] {
           width:   29.7cm;
            height: 21cm;
        }

        page[size="A4"] {
            width:  21cm;
            height: 29.7cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }
        .container{
            display: flex;
        }
        h2{
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }
/* 
        .rincian{
                border: 1px solid black;
              }
              .rincian th, td{
                border: 1px solid black;
              } */
    </style>
</head>

<body>
   
        
            

                <img style="float:left; margin-right: 20px;" src="{{public_path("asset/images/logo.png")}}" width="100px" height="100px" alt="">
                <H2 style="margin-bottom: 1px">PT. KRIS SETIABUDI UTAMA</H2>
                <p style="font-size: 12px; margin-bottom: 5%">
                    Epicentrum Walk Strata Office Suites Lt.6 Unit 0610 B <br>
                    Komp. Rasuna Epicentrum, Jl.HR. Rasuna Said, Kuningan - Jakarta Selatan
                </p>
        <hr>
        <div>
            <div>
                <table>
                    <tbody>
                        <tr>
                            <td style=" ">Periode</td>
                            <td style=" ">:</td>
                            <td>Juni 2023</td>
                        </tr>
                        <tr>
                            <td style=" ">No. Karyawan</td>
                            <td style=" ">:</td>
                            <td>{{$gaji->nip_pegawai}}</td>
                        </tr>
                        <tr>
                            <td style=" ">Nama / Jabatan</td>
                            <td style=" ">:</td>
                            <td><b>{{$gaji->nama}} / {{$gaji->nama_jabatan}}</b></td>
                        </tr>
                        <tr>
                            <td style=" ">No. NPWP</td>
                            <td style=" 10px">:</td>
                            <td>{{$gaji->npwp}}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div style="margin-top: 10px">
                <table class="rincian">
                    <tbody>
                        <tr>
                            <td ><b>TOTAL BIAYA GAJI DAN
                                    TUNJANGAN PERUSAHAAN</b></td>
                            <td style="width: 70px; "></td>
                            <td style=" "><b>:</b></td>
                            <td style="width: 80px;"> <b>  @uang($gaji->gaji_pokok + $gaji->uang_makan + $gaji->uang_transport + $gaji->adjustment)</b> </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 10px"><b>PERINCIAN</b></td>
                            <td></td>
                            <td style=" "></td>
                            <td></td>
                            <td style=" "><b>TANGGUNGAN KARYAWAN</b></td>
                        </tr>
                        <tr>
                            <td style=" "><b>1. Biaya Gaji</b></td>
                            <td></td>
                            <td style=" "></td>
                            <td></td>
                            <td><b>POTONGAN</b></td>
                        </tr>
                        <tr>
                            <td style=" ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gaji Pokok</td>
                            <td></td>
                            <td style=" ">:</td>
                            <td style=" ">1.000.000</td>
                            <td style="width: 180px ">Pinjaman</td>
                            <td style=" ">:</td>
                            <td style=" ">@if ($gaji->pinjaman != 0)
                                @uang($gaji->pinjaman)
                                @else
                                -
                            @endif</td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Absent</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>2. Biaya Tunjangan</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="display: flex">BPJS Ketenagakerjaan <span style="margin-left: 18px" >2%</span></td>
                            <td>:</td>
                            <td>@uang($gaji->pot_bpjs_ket)</td>
                        </tr>
                        <tr>
                            <td style=" ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Makan</td>
                            <td style=" ">22 hari</td>
                            <td style=" ">:</td>
                            <td>@uang($gaji->uang_makan) </td>
                            <td>BPJS Kesehatan
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1%
                            </td>
                            <td>:</td>
                            <td>@uang($gaji->pot_bpjs_kes)</td>
                        </tr>
                        <tr>
                            <td style=" ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transport</td>
                            <td style=" ">{{$gaji->jumlah_masuk}} hari</td>
                            <td style=" ">:</td>
                            <td> @uang($gaji->uang_transport) </td>
                            <td>Jaminan Pensiun
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1%</td>
                            <td>:</td>
                            <td>@uang($gaji->pot_jp)</td>
                        </tr>
                        <tr>
                            <td style=" ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adjustment</td>
                            <td style=" "></td>
                            <td style=" ">:</td>
                            <td>@if ($gaji->adjustment != 0) 
                                @uang($gaji->adjustment)
                                @else
                                -
                            @endif</td>
                            <td style="text-align: center"><b>TOTAL</b></td>
                            <td><b>:</b></td>
                            <td><b>@uang($gaji->pinjaman + $gaji->pot_bpjs_kes + $gaji->pot_bpjs_ket + $gaji->pot_jp)</b></td>
                        </tr>
                        <tr>
                            <td style="padding-top: "></td>
                            <td style=" "></td>
                            <td style=" "></td>
                            <td>
                                <hr width="60%" align="left" style="margin-left: 0%">
                            </td>
                        </tr>
                        <tr>
                            <td style=" text-align:center; margin-top:; padding-bottom: 20px;">
                                <b>GAJI GROSS</b>
                            </td>
                            <td style=""></td>
                            <td style=" margin-top:; padding-bottom: 20px;"><b>:</b></td>
                            <td style="margin-top:; padding-bottom: 20px;"><b> 1.440.000 </b></td>
                        </tr>
                        <tr>
                            <td style="">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BPJS Ketenagakerjaan</td>
                            <td style=" ">4,24%</td>
                            <td style=" ">:</td>
                            <td> @uang($gaji->premi_bpjs_ket) </td>
                        </tr>
                        <tr style="padding-top: ">
                            <td style=" ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BPJS Kesehatan
                            </td>
                            <td style=" ">4%</td>
                            <td style=" ">:</td>
                            <td>  @uang($gaji->premi_bpjs_kes) </td>
                        </tr>
                        <tr style="padding-top: ">
                            <td style=" ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jaminan Pensiun
                            </td>
                            <td style=" ">2%</td>
                            <td style=" ">:</td>
                            <td>  @uang($gaji->premi_jp) </td>
                        </tr>
                        <tr>
                            <td style="padding-top: "></td>
                            <td style=" "></td>
                            <td style=" "></td>
                            <td>
                                <hr width="60%" style="margin-left: 0%">
                            </td>
                        </tr>
                        <tr style="padding-top: ">
                            <td style=" "></td>
                            <td style=" "></td>
                            <td style=" "></td>
                            <td> <b>@uang($gaji->premi_bpjs_kes + $gaji->premi_bpjs_ket + $gaji->premi_jp)</b> </td>
                        </tr>
                        <tr>
                            <td style=" padding-top: 10px;"><b>3. Pajak Karyawan Yang
                                    ditanggung Perusahaan</b></td>
                            <td style=" "></td>
                            <td style=" ">:</td>
                            <td><b>@if ($pph != 0)
                                @uang($pph)
                                @else
                                -
                            @endif</b></td>
                        </tr>
                        <tr>
                            <td style=" padding-top: 10px;"><b>NETTO GAJI YANG DITERIMA</b>
                            </td>
                            <td style=" "></td>
                            <td style=" ">:</td>
                            <td><b>  @uang($netto) </b></td>
                        </tr>
                        <tr>
                            <td style=" padding-top: 10px;"><b>DITERIMA OLEH :</b></td>
                            <td style=" "></td>
                            <td style=" "></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
   

    <!-- Jquery Core Js -->
    {{-- <script src="{{asset('asset/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('asset/plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('asset/plugins/node-waves/waves.js')}}"></script> --}}
</body>

</html>
