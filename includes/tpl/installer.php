<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/css/login.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/assets/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="/login"><b>Binary </b>MLM</a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Software Installation</p>
                <div id="status"></div>
                <hr>
                <p>
                    Before you can use MLM System, you must install it first. Please fill this form for establish the database connection.
                </p>
                <form id="final" >
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Admin Username" name="adminuname" id="adminuname" required>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Admin Password" name="adminpass" id="adminpass" required>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Admin Email" name="adminmail" id="adminmail" required>
                    </div>
                    
                    <hr>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Hostname" name="hostname" id="hostname">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="DB Name" name="dbname" id="dbname">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="DB User" name="user" id="user">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="DB Password" name="pass" id="pass">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="#"  class="btn btn-primary btn-block btn-flat" id="install">Install</a>
                        </div><!-- /.col -->
                    </div>
                </form>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="/assets/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="/assets/plugins/iCheck/icheck.min.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.ui.shake.js"></script>
        <!-- TOKENIZE -->
        <script type="text/javascript" >
            $(function () {
                $.ajaxPrefilter(function (options, origOptions, jqXHR) {
                    options.data = options.data + "&token=" + $("#token").val();
                });
            });
        </script>
        <script type="text/javascript" src="/assets/js/installer.js"></script>
    </body>
</html>
