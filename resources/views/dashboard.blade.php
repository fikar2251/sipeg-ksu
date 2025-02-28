@extends('layouts.app')
@section('content')
<section class="content">
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">accessibility</i>
                </div>
                <div class="content">
                    <div class="text">TOTAL KARYAWAN</div>
                    <div class="number count-to" data-from="0" data-to="{{$total}}" data-speed="15" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">accessibility</i>
                </div>
                <div class="content">
                    <div class="text">KARYAWAN TETAP</div>
                    <div class="number count-to" data-from="0" data-to="{{$tetap}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">accessibility</i>
                </div>
                <div class="content">
                    <div class="text">KARYAWAN KONTRAK</div>
                    <div class="number count-to" data-from="0" data-to="{{$kontrak}}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="content">
                    <div class="text">NEW VISITORS</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- #END# Widgets -->
</div>
</section>
@endsection