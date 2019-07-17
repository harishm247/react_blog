<!--  <div class="user-head">         
         <a style="display: none;"class="btn btn-compose" data-t oggle="modal" href="<?php echo base_url().'backend/notification/compose_mail' ?>">Compose Mail</a> 
 </div>        -->       
    <?php 
      $segment= $this->uri->segment(3); 
      $main_segment= $this->uri->segment(2); 
      $get_notification_type='';
    ?>
      <ul class="inbox-nav inbox-divider">
          <!-- <li class="active"> -->
        
           
<!--           <li class="<?php if($main_segment=='notification' && $segment=='sent_mail' || $main_segment=='notification' && $segment=='sent_mail_detail'){ echo 'active'; } ?>">
              <a style="display: none;" href="<?php echo base_url('backend/notification/sent_mail') ?>" ><i class="icon-envelope-alt" ></i> Sent Mail</a>
          </li> -->
          <li class="<?php if(($main_segment=='support' && $segment=='user_contactus' || $main_segment=='support' && $segment=='user_contactus_reply' || $main_segment=='support' && $segment=='complete_tickets') && empty($_GET) ){ echo 'active'; } ?>">
              <a href="<?php echo base_url('backend/support/user_contactus') ?>" ><i class="fa fa-headphones" ></i> Support</a>
            <span class="inbox-nav-arrow"><a role="button" data-toggle="collapse" href="#collapseExample24" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-angle-down"></i></a></span>
          </li>
          <div class="collapse inbox-nav-collapse <?php if(($main_segment=='support' && $segment=='user_contactus' || $main_segment=='support' && $segment=='user_contactus_reply' || $main_segment=='support' && $segment=='complete_tickets')){ echo 'in'; } ?>" id="collapseExample24">
              <dl>
                <dt class="<?php if($main_segment=='support' && $segment=='user_contactus' && empty($_GET) ){ echo 'active'; } ?>">
				<a href="<?php echo base_url('backend/support/user_contactus') ?>">Incomplete </a></dt>  
				
				<dt class="<?php if($main_segment=='support' && $segment=='complete_tickets' && empty($_GET) ){ echo 'active'; } ?>">
				<a href="<?php echo base_url('backend/support/complete_tickets') ?>">Complete</a></dt>  

                <dt class="<?php if(($main_segment=='support' && $segment=='user_contactus' && (!empty($_GET) && $_GET['sort_starred']==1) )
                || ($main_segment=='support' && $segment=='user_contactus_reply' && !empty($_GET['sort_starred']) && $_GET['sort_starred']==1)){ echo 'active'; } ?>">
				
				<a href="<?php echo base_url('/backend/support/user_contactus?subject=0&contact_id=&sort_starred=1&order=2') ?>">Important </a></dt>                                                    
              </dl>
            </div>                  
      </ul>
<!-- mail modal -->




