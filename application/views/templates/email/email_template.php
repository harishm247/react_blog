<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Flowhaus</title>
    <style>
      td:empty{
   display: none;
}
.copy-right-section a{
  text-decoration:none;
  vertical-align:middle;
  display:inline-block;
}
    </style>
 </head>
<body style="padding:50px 0; margin:0;font-family: sans-serif; background-color:#ececec;">  

    <table  border="0" cellpadding="0" cellspacing="0"  width="600" style="margin: auto;font-family: sans-serif;">
        <tr>
            <td style="background-color: #ffffff;font-family: sans-serif;padding: 30px;padding-bttom:0px;font-size: 15px;">
              <table width="600" border="0" cellpadding="0" cellspacing="0" style="width:600px;margin: 0 auto;background-color: #ffffff;    padding-left:19px;padding-right: 15px;" >
               
                <tr>
                  <td style="font-family: sans-serif;">
                   <?php echo $email_message; ?> 
                  </td>
                </tr><br>
                <tr>
                <td style="vertical-align:middle;font-family:arial,sans-serif,sans-serif;">
                  <?php if(!empty(get_option_url('PHONE'))): ?>
                    <span style="font-size:12px"><a href="tel:1-866-306-9353" style="color:#373d3f;text-decoration:none" target="_blank"><?php  echo get_option_url('PHONE'); ?></a>&nbsp;&nbsp;&nbsp;|</span>
                    <span>&nbsp;&nbsp;&nbsp;
                    <a href="<?php  echo get_option_url('SUPPORT_EMAIL'); ?>" style="text-decoration:none;color:#373d3f;font-size:12px" target="_blank"><?php  echo get_option_url('SUPPORT_EMAIL'); ?></a>
                         &nbsp;&nbsp;&nbsp;|</span><span>&nbsp;&nbsp;&nbsp;<a href="" style="text-decoration:none;color:#373d3f;font-size:12px" target="_blank" data-saferedirecturl="">Support</a></span>
                       <?php endif; ?>
                  </td>
                  </tr>
              </table>                   
            </td>
        </tr>
        <tr>
          <td style="color: #959595;" >
          <?php //if(!empty(get_option_url())): ?>
        <table cellpadding="0" cellspacing="0" style="background-color:#ffffff;padding: 15px 15px 15px 50px;width: 100%;" width="100%">
      
        <tr>
        <td style="padding-bottom:10px;font-size:14px;line-height:15px;font-family:arial,sans-serif,sans-serif">
      Flow On!
      </td>
      </tr>
    <!--   <tr>
      <td style="font-size:14px;padding-top:8px; padding-bottom:8px;line-height:15px;font-family:arial,sans-serif,sans-serif">
      Flowhaus Team
      </td>
      </tr> -->
      <tr>
      <td style="font-size:10px;line-height:15px;font-family:arial,sans-serif,sans-serif">
    <div style="margin-bottom: 25px"> 
    <a href="http://flowhaus.com/"> <img style="margin-top: 5px" src="<?php echo base_url('assets/uploads/flowhaus.png'); ?>" class="CToWUd" width="120px">
  </div> 
      </td>
        </tr>
        <tr>
           <td class="copy-right-section" style="border-collapse:collapse;"> 
             <span style="text-align:right;display:inline-block;vertical-align:middle">
               <span style="font-size:13px;font-family:arial,sans-serif,sans-serif">Follow Us on Instagram:</span>
               <?php if(!empty(get_option_url('FACEBOOK_URL'))): ?>
               <a href="<?php echo get_option_url('FACEBOOK_URL'); ?>" style="text-decoration:none;vertical-align:middle;display:inline-block;" target="_blank">
                <img style="width: 16px;margin-top: 3px;" src="<?php echo base_url('assets/uploads/social/facebook.png'); ?>" class="CToWUd"></a>
              <?php endif; ?>
              <?php if(!empty(get_option_url('INSTAGRAM_URL'))): ?>
              <a style=""  href="<?php echo get_option_url('INSTAGRAM_URL'); ?>" target="_blanks" data-saferedirecturl="">
                <img style="width: 16px;margin-top: 3px;" src="<?php echo base_url('assets/uploads/social/instagram.png'); ?>" class="CToWUd">
              </a>
            <?php endif; ?>
              <?php if(!empty(get_option_url('TWITTER_URL'))): ?>
               <a href="<?php echo get_option_url('TWITTER_URL'); ?>" style="text-decoration:none;vertical-align:middle;display:inline-block;" target="_blank" data-saferedirecturl="">
                <img style="width: 16px;margin-top: 3px;" src="<?php echo base_url('assets/uploads/social/twitter.png'); ?>" class="CToWUd">
               </a>
                <?php endif; ?>
              <?php if(!empty(get_option_url('PINTREST_URL'))): ?>
               <a href="<?php echo get_option_url('PINTREST_URL'); ?>" style="text-decoration:none;vertical-align:middle;display:inline-block;" target="_blank" data-saferedirecturl="">
                <img style="width: 16px;margin-top: 3px;" src="<?php echo base_url('assets/uploads/social/pintrest.png'); ?>" class="CToWUd">
               </a>
              <?php endif; ?>
              <?php if(!empty(get_option_url('LINKEDIN_URL'))): ?>
               <a href="<?php echo get_option_url('LINKEDIN_URL'); ?>" style="text-decoration:none;vertical-align:middle;display:inline-block;" target="_blank" data-saferedirecturl="">
                <img style="width: 16px;margin-top: 3px;" src="<?php echo base_url('assets/uploads/social/linkedin.png'); ?>" class="CToWUd">
              </a>
              <?php endif; ?>
              <?php if(!empty(get_option_url('YOUTUBE_URL'))): ?>
               <a href="<?php echo get_option_url('YOUTUBE_URL'); ?>" style="text-decoration:none;vertical-align:middle;display:inline-block;" target="_blank" data-saferedirecturl="">
                <img style="width: 16px;margin-top: 3px;" src="<?php echo base_url('assets/uploads/social/youtube.png'); ?>" class="CToWUd">
              </a>
            <?php endif; ?>
             </span>
             <span style="font-size:12px;display:inline-block;font-family:arial,sans-serif">Copyright &copy; 2019 Flowhaus, All Rights Reserved</span>
           </td>
        </tr>
         <tr class="footer-email">
           <td style="font-size:10px;line-height:15px;font-family:arial,sans-serif,sans-serif">
            
            <?php if(!empty(get_option_url('ADDRESS'))): ?>
            <div style="color:#373d3f"><?php echo get_option_url('ADDRESS'); ?> </div>
           <div></div><span class="HOEnZb"><font color="#888888">
           </font></span>
         <?php endif; ?>
          </td>
        </tr>
        </table>   
        <?php //endif; ?>         
          </td>
        </tr>
    </table>
</body>
</html>