<?php
session_start();

$_SESSION["codusr"] = null;
$_SESSION["estado"] = null;

unset($_SESSION);

session_destroy();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Cubo Soft | Alfrio</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="./imagenes/app/favicon.png">            
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->  
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">            
            <!-- /.login-logo -->
            <div class="login-box-body">
                <div class="login-logo">
                    <img src="imagenes/app/cubo.png" alt="Cubo Soft"/>
                </div>
                <p class="login-box-msg">Pruebas V.202500314</p>
                <p class="login-box-msg">Ingrese usuario y contraseña</p>
                <form action="controladores/CT_am_usuarios.php" method="post">
                    <input type="hidden" value="1" name="caso"/>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="email" placeholder="Usuario" required="required">                        
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="paswd" placeholder="Contraseña" required="required">                        
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">                           
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-info btn-block btn-flat">Ingresar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <p>Ir a <a href="https://www.cubosoftalfrio.com/pruebas/">Pruebas</a></p>
                    </div>
                </form>                
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' /* optional */
                });
            });
        </script>
    </body>
</html>
