<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="">

    <title><?php echo SITE_NAME ?> | Admin login</title>
    <link rel="icon" href="/assets/admin/images/favicon.ico" type="image/x-icon" />

     <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo BACKEND_THEME_URL?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BACKEND_THEME_URL?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo BACKEND_THEME_URL?>plugin/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo BACKEND_THEME_URL?>css/style.css" rel="stylesheet">
    <link href="<?php echo BACKEND_THEME_URL?>css/style-responsive.css" rel="stylesheet" />
</head>

<body class="lock-screen" onload="startTime()">
        <div id="time"></div>
        <?php echo form_open(current_url().'?token='.$_GET['token'], array('class'=>'form-signin','id'=>'reset_pasword')); ?>
	
		<div class="login-logo">  
			<a href="<?php echo base_url()?>">
				<!--<img src="<?php echo BACKEND_THEME_URL ?>images/superadmin-logo.png" class="logo">-->
				<img style="margin: 20px 21px 0 0;" src="<?php echo base_url("assets/uploads/login-logo.svg"); ?>">
			</a>
		</div>	
         <?php if($this->session->flashdata('msg_error')){ ?>
         <div class="text-center">
                                  
        <span class="help-block btn btn-danger" style="width: 90%;">
        <?php echo $this->session->flashdata('msg_error'); } ?></span>
       <?php if($this->session->flashdata('msg_success')) { ?>
         <div class="text-center">
                                  
        <span class="help-block btn btn-danger" style="width: 90%;">
        <?php echo $this->session->flashdata('msg_success'); } ?></span>
                 
    </div>
          <div class="login-wrap">
            
           <!--  <input type="text" class="form-control" placeholder="Email" autofocus  name="email">
            <?php echo form_error('email')?> -->
          <div class="password-tile">
          <input  name="password" type="password" id="password" class="form-control" placeholder="Enter New Password">
          <?php echo form_error('password')?>
        </div>
        <div class="password-tile">
          <input  name="confirm_password" type="password" class="form-control" placeholder="Re-type New Password">
          <?php echo form_error('confirm_password') ?>
        </div>
          <button class="btn btn-lock" type="submit">Change Password
                      <i class="icon-arrow-right"></i>
          </button>
          <a href="<?php echo base_url('behindthescreen'); ?>" data-toggle="modal" class="pull-right" style="margin-top: 9px">Login</a>
          </div>
      </form>
    </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo BACKEND_THEME_URL?>js/jquery.js"></script>
    <script src="<?php echo BACKEND_THEME_URL?>js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function () {  
    $('#reset_pasword').validate({
      rules : {
          password : {
              required: true,
              minlength : 6
          },
          confirm_password : {
              required: true,
              minlength : 6,
              equalTo : "#password"
          },
      }
    });
  });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<style type="text/css" media="screen">
/*.login-wrap button{
  display: block;
  margin: auto;
}*/
.login-wrap .password-tile label{
  position: absolute;
  bottom: -25px;

}
.login-wrap .password-tile input{
  margin-bottom: 30px;
}
.login-wrap .password-tile{
  position: relative;
}
.logo{
	margin: 12px;
}
.login-logo img.logo {
    width: 190px;
}
span{
    color: #0C0C0C;
	font-size: 16px;
	font-weight: bold;
	padding: 0px;
	margin: 0px;
}
.form-signin{
	background-color:#fff;
}
.login-logo a{
	color:#fff;
}
.login-logo a:hover{
	color:#09929c;
}
.password-close{
    width: 100%;
    position: absolute;
    top: 7px;
    left: 269px;
    font-size: 34px;
}
</style>
  </body>
</html>
