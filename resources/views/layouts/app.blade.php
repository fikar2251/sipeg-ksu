<!DOCTYPE html>
<html>

<head>
    @include('layouts.header')

</head>

<body class="theme-red">
    <!-- Page Loader -->
    <!--
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Harap menunggu sebentar...</p>
        </div>
    </div>
 -->

    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    @include('layouts.navbar')
    <section>
        @include('layouts.sidebar')
    </section>


    @yield('content')




    <!-- Bootstrap Material Datetime Picker Plugin Js
<script src="plugins/JqueryACtextbox/jquery-1.10.2.js"></script>-->

<script src="asset/plugins/jquery/jquery.min.js"></script>


    <!-- Bootstrap Core Js -->
    <script src="asset/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="asset/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="asset/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="asset/plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="asset/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="asset/plugins/raphael/raphael.min.js"></script>
    {{-- <script src="asset/plugins/morrisjs/morris.js"></script> --}}

    <!-- Jquery DataTable Plugin Js -->
    <script src="asset/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="asset/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="asset/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="asset/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="asset/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="asset/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="asset/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="asset/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="asset/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- ChartJs -->
    <script src="asset/plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="asset/plugins/flot-charts/jquery.flot.js"></script>
    <script src="asset/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="asset/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="asset/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="asset/plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="asset/plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="asset/js/admin.js"></script>
    <script src="asset/js/pages/index.js"></script>
    {{-- <script src="asset/js/pages/forms/advanced-form-elements.js"></script> --}}

    <!-- Demo Js -->
    <script src="asset/js/demo.js"></script>

    <!-- Dropzone Plugin Js -->
    <script src="asset/plugins/dropzone/dropzone.js"></script>

    <!-- Bootstrap Colorpicker Js -->
    <script src="asset/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

    <!-- Input Mask Plugin Js -->
    <script src="asset/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <!-- Multi Select Plugin Js -->
    <script src="asset/plugins/multi-select/js/jquery.multi-select.js"></script>

    <!-- Jquery Spinner Plugin Js -->
    <script src="asset/plugins/jquery-spinner/js/jquery.spinner.js"></script>

    <!-- Bootstrap Tags Input Plugin Js -->
    <script src="asset/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- noUISlider Plugin Js -->
    <script src="asset/plugins/nouislider/nouislider.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="asset/plugins/bootstrap-notify/bootstrap-notify.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="asset/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="asset/plugins/jquery-validation/additional-methods.js"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="asset/plugins/jquery-steps/jquery.steps.js"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="asset/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="asset/plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="asset/plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="asset/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Custom Js -->
    <script src="asset/js/pages/forms/basic-form-elements.js"></script>
    {{-- <script src="asset/js/dell.js"></script> --}}
    <script src="asset/js/pages/tables/jquery-datatable.js"></script>
    {{-- <script type="text/javascript">
        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'DD-MM-YYYY',
            time: false
        });
        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'DD-MM-YYYY HH:mm:ss'
        });
    </script> --}}
    {{-- <script src="asset/js/pages/forms/advanced-form-elements.js"></script>  --}}
    <script src="asset/js/pages/ui/modals.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!--<script type="text/javascript" src="asset/plugins/autoformat/jquery-3.2.1.slim.min.js"></script>-->
    {{-- <script type="text/javascript" src="asset/plugins/autoformat/simple.money.format.js"></script> --}}
    {{-- <script type="text/javascript">
        $('.money').simpleMoneyFormat();
    </script> --}}
    @stack('custom-scripts')

    <script>
      

        <?php if (session('success')) { ?>
            toastr.success("<?= session('success') ?>");
        <?php } ?>
        <?php if (session('sweet-warning')) { ?>
            toastr.warning("<?= session('warning') ?>");
        <?php } ?>
        <?php if (session('error')) { ?>
            toastr.error("<?= session('error') ?>");
        <?php } ?> 
    </script>
    <!-- <script type="text/javascript" src="../../js/dhtmlwindow.js"></script> -->
</body>

</html>
