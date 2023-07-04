
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>LOGIN SIPEG KSU</title>
    <!-- Favicon-->
    <link rel="icon" href="asset/favicon.png" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    
    <!-- Bootstrap Core Css -->
    <link href="asset/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    
    <!-- Waves Effect Css -->
    <link href="asset/plugins/node-waves/waves.css" rel="stylesheet" />
    
    <!-- Animation Css -->
    <link href="asset/plugins/animate-css/animate.css" rel="stylesheet" />
    
    <!-- JQuery DataTable Css -->
    <link href="asset/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
    <!-- Morris Chart Css-->
    <link href="asset/plugins/morrisjs/morris.css" rel="stylesheet" />
    
    <!-- Custom Css -->
    <link href="asset/css/style.css" rel="stylesheet">
    
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="asset/css/themes/all-themes.css" rel="stylesheet" />
    
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
        <img src="asset/images/banner.png"width="100%">
    
            <!-- <a href="javascript:void(0);">Sistem Informasi SDM<br>PT. Rekadaya Elektrika</a><br /> -->

                    <!-- header("location:index.php?failed&gagallogin");
                    $message = "Username atau Password tidak sesuai";
                    echo "<script type='text/javascript'>alert('$message');</script>"; -->
                    {{-- <br>
                    <div class='alert bg-red alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        Username atau Password tidak sesuai
                    </div>

           <br>
                    <div class='alert bg-red alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        Karyawan tidak aktif
                    </div>  
          
                    <br>
                    <div class='alert bg-red alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        Username atau Password tidak sesuai
                    </div>
        </div> --}}


        <div class="card">
            {{-- <?php if (isset($_GET["berhasil"])) { ?> --}}
                {{-- <div class="alert alert-success">Email terkirim
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                </div> --}}
            {{-- <?php
            } elseif (isset($_GET["reset"])) { ?> --}}
                {{-- <div class="alert alert-success">Reset password berhasil, silahkan cek email anda
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                </div> --}}
            {{-- <?php } ?> --}}
            <div class="body">
                <form id="sign_in" method="POST" action="{{route('login')}}">
                @csrf
                    <!-- <div class="msg">Sign in to start your session</div> -->
                  
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="Email" value="<?php if (isset($_COOKIE["email"])) {
                                                                                                                echo $_COOKIE["email"];
                                                                                                            } ?>" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" value="<?php if (isset($_COOKIE["password"])) {
                                                                                                                            echo $_COOKIE["password"];
                                                                                                                        } ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink" <?php if (isset($_COOKIE['email'])) { ?> checked <?php } ?>>
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit" name="submit_login">LOGIN</button>
                        </div>
                    </div>
                    {{-- <div class="row m-t-15 m-b--20">
                        <!-- <div class="col-xs-6">
                            <a href="register.php">Register Now!</a>
                        </div> -->
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.php">Forgot Password?</a>
                        </div>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>

     <!-- Jquery Core Js -->
     <script src="asset/plugins/jquery/jquery.min.js"></script>

     <!-- Bootstrap Core Js -->
     <script src="asset/plugins/bootstrap/js/bootstrap.js"></script>
 
     <!-- Waves Effect Plugin Js -->
     <script src="asset/plugins/node-waves/waves.js"></script>
 
     <!-- Validation Plugin Js -->
     <script src="asset/plugins/jquery-validation/jquery.validate.js"></script>
 
     <!-- Custom Js -->
     <script src="asset/js/admin.js"></script>
     <script src="asset/js/pages/examples/sign-in.js"></script>
</body>

</html>