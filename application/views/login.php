<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=$this->about_model->get_by_nama('program')->row()->value;?> Login</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<style>
#trans {
  position: relative;
  background: rgba(130,130,130,.3);
  border: 1px solid;
  border-top-color: rgba(255,255,255,.4);
  border-left-color: rgba(255,255,255,.4);
  border-bottom-color: rgba(60,60,60,.4);
  border-right-color: rgba(60,60,60,.4);   
}
body {
		background: url("<?php echo base_url('assets/bg.jpg');?>") no-repeat center center fixed; 
		 -webkit-background-size: cover;
		 -moz-background-size: cover;
		 -o-background-size: cover;
		 background-size: cover;
} 
 
</style>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url('assets/font-awesome-4.3.0/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/dist/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/square/blue.css') ?>" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    
        <div class="login-box">
            <div class="login-logo">
                <br />
		<br />
		<br />
		<br />

            </div><!-- /.login-logo -->
            <div class="login-box-body" id="trans">
                <p class="login-box-msg" style="color:black">Silahkan Login</p>
                <form action="<?=site_url('auth/login') ?>" method="post">
                    <div class="form-group has-feedback">
                        <input name="user" type="text" class="form-control" id="user" placeholder="Email"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input name="password" type="password" class="form-control" id="password" placeholder="Password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                    <div class="row">
                        <div class="col-xs-8">    
                                                    
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div><!-- /.col -->
                        
                    </div>
                </form>

                


            </div>
		<!-- /.login-box-body --><div class="callout callout-danger" <?php if(isset($message)){echo "";}else{echo "style='display:none'";}?>>
              <h4>Error Login</h4>
              <p><?=isset($message)?$message:'';?></p>
            </div>
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.3 -->
        <script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.3.min.js') ?>"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
