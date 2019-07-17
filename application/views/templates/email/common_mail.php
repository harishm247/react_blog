     
<!--==============================content=================================-->
<table width="100%" border="0" style="padding:0px 10px;">
  <tr>
  <td>

  <div class="content" style="font-size:17px;line-height: 30px;padding-left:15px;padding-right:15px;color:#0d0d0d;">
  	<?php if(empty($template_type)){ ?>
     <p><?php if(!empty($subject)){ echo ucfirst($subject); } ?></p>
   <?php } ?>  
     
     <p><?php if(!empty($mail_body)){ echo $mail_body; }  ?> </p>    
  </div>
</td>
</tr>

</table>