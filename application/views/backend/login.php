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
        <?php echo form_open(current_url(), array('class'=>'form-signin')); ?>
	
		<div class="login-logo">  
			<a href="<?php echo base_url()?>">
				<!--<img src="<?php echo BACKEND_THEME_URL ?>images/superadmin-logo.png" class="logo">-->
				<img style="margin: 20px 21px 0 0;" src="<?php echo base_url("assets/uploads/login-logo.svg"); ?>">
			</a>
		</div>	
         <?php if($this->session->flashdata('msg_error')): ?>
         <div class="text-center">
                                  
        <span class="help-block btn btn-danger" style="width: 90%;">
        <?php echo $this->session->flashdata('msg_error'); ?></span>
                 
    </div>
    <?php endif; ?>
    <div class="login-wrap">
            
            <input type="text" class="form-control" placeholder="Email" autofocus  name="email">
            <?php echo form_error('email')?>
            <input  name="password" type="password" class="form-control" placeholder="Password">
           <?php echo form_error('password')?>
            <button class="btn btn-lock" type="submit">Sign in
                        <i class="icon-arrow-right"></i>
            </button>
            <a href="" data-toggle="modal" data-target="#myModal" class="pull-right" style="margin-top: 9px">Forgot Password</a>
         
        </div>
      </form>
    </div>
        <!-- The Modal -->
         <div class="modal" id="myModal">
           <div class="modal-dialog" style="padding-top: 162px;">
             <div class="modal-content">
             
               <!-- Modal Header -->
               <div class="modal-header">
                 <h4 class="modal-title">Forgot Password</h4>
                 <button type="button" class="close password-close" data-dismiss="modal">&times;</button>
               </div>
               
               <!-- Modal body -->
               <?= form_open("",array("class"=>"forgetPassword","id"=>"forgetPasswordForm")); ?>
               
               <div class="modal-body">
                <p>Please provide a valid email address.</p> 
                 <div class="form-group">
                  <?=  form_input(["name"=>"email",'value'=> set_value('email'),"class" => "form-control","id" => "email", "placeholder"=>"Email Address"]);
                       echo form_error("email",'<p class="text-danger">','</p>');
                  ?>    
                 </div>
                  <div class="alert alert-danger forget-error-msg">
                    <p style="margin: 0;" class="mesage"></p>
                  </div>
                
               </div>
               <!-- Modal footer -->

               <div class="modal-footer">
                <div id="loading">
                  Loading...
                </div>
                <button type="submit" name="forgetPass" id="formsub" class="btn btn-primary">Send Reset Link</button>

                 <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               </div>
              <?= form_close(); ?>
               
             </div>
           </div>
         </div>
   

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo BACKEND_THEME_URL?>js/jquery.js"></script>
    <script src="<?php echo BACKEND_THEME_URL?>js/bootstrap.min.js"></script>

  <script>
        function startTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
            document.getElementById('time').innerHTML=h+":"+m+":"+s;
            t=setTimeout(function(){startTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }

  $(document).ready(function () {

      $('#forgetPasswordForm').validate({ // initialize the plugin
          rules: {
              email: {
                  required: true,
                  email: true
              },
              order_by: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                  },
              message: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                  }
          },
          // submitHandler: function (form) { // for demo
          //     alert('valid form submitted'); // for demo
          //     return false; // for demo
          // }
      });

  });

 $('#formsub').click(function(e){
     e.preventDefault();
    var forget_email = $('#email').val();
    var url = "<?php echo base_url('backend/superadmin/forget_password'); ?>";
    $.ajax({
       type: "POST",
       url : url,
       data: { email: forget_email},
       beforeSend: function(){
         $("#loading").show();
       },
       complete: function(){
         $("#loading").hide();
       },
       success: function(data){
        var data = data.replace(/\"/g, "");
          if(data!=''){
            $('.mesage').parent().removeClass('forget-error-msg');
           $('.mesage').text(data);
          }
        }
    });
  });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<style type="text/css" media="screen">
#loading { display: none; }
.forget-error-msg{
  display: none;
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
