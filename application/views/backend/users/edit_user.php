<style type="text/css">
   hr.style1{
   border:none;
   border-left:1px solid hsla(200, 10%, 50%,100);
   height:100vh;
   width:1px;
   }
</style>
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <?php if(@($_GET['user_type']==1)){ ?>
      <li><a href="<?php echo base_url('backend/users'); ?>">Users</a></li>
     
      <li><b>User Info</b></li>
      <?php }else{ ?>
      <li><a href="<?php echo base_url('backend/users/influencer'); ?>">Influencers</a></li>
      <li><b>Influencer Info</b></li>
       <?php 
      } ?>
   </ul>
</div>
<div class="col-sm-12">
   <div class="panel-body">
     <div class="table-responsive">
      <div class="panel-heading colum">
        <i class="icon-user"></i> User Information 
      </div>
    <table  width="100%" class="table table-striped table-hover"> 
      <tr>
          <td style="text-align: center;">
             <table>
          <?php if(!empty($user->profile_image)){ ?>
              <img style="width:130px;height: 130px;border: 1px;border-radius: 50%;margin-top: 5px" src="<?php echo base_url().$user->profile_image;?>"> 
         <?php } 
         else { ?>
          <img style="width:130px;border: 1px;border-radius: 75px;margin-top: 5px" src="<?php echo base_url()?>assets/uploads/dummyimage.png">
         <?php  }

          ?> 
             </table>
          </td>  
          <td class="info"> <h5><b>User Info :</b></h5>
            <table>
             <tr><th>User ID :</th>
            <td> <?php if(!empty($user->user_id)){ echo '# '.$user->user_id; } ?></td></tr>   
         
            <tr><th>Username :</th>
            <td> <?php if(!empty($user->first_name)){ echo ucfirst($user->first_name.' '.$user->last_name); } ?></td></tr>  
            <tr><th>Email :</th>
            <td> <a href="mailto:<?php echo $user->email; ?>"><?php if(!empty($user->email)){ echo $user->email; } ?></a></td></tr>
            <tr><th>Contact Number :</th>
            <td><?php if(!empty($user->mobile)){ echo $user->mobile; }else{ echo "NA";} ?></td></tr>
            <tr><th>Status :</th>
                <td class="btn  btn-xs cursor-text">
                  <div class="btn-group">
                      <button data-toggle="dropdown" type="button" 
                        <?php if($user->status==1){ ?>
                        class="btn btn-success btn-xs dropdown-toggle">Active
                        <?php }if($user->status==0){ ?>
                        class="btn btn-warning btn-xs dropdown-toggle">Deactive 
                        <?php } ?>
                        <span class="caret"></span>
                      </button>
                    <ul role="menu" class="dropdown-menu">
                       <?php if($user->status==0){ ?>
                       <li><a href="<?php echo base_url('backend/superadmin/change_status_users/'.$user->user_id.'/1/')?>" > Active</a> </li>
                     <?php } ?>
                     <?php if($user->status==1){ ?>
                       <li><a href="<?php echo base_url('backend/superadmin/change_status_users/'.$user->user_id.'/0/')?>" > Deactive</a> </li>
                     <?php } ?>
                               
                    </ul> 
                  </div>
                </td>
            </tr>                   
            </table>
          </td> 
          <td><h5><b>Account access :</b></h5>
           <table>
            <?php  if(!empty($user->created)){ ?>
               <tr>
                <th>
                 Account created:
                 </th>
                 <td><i class="fa fa-calendar"></i>
                 <?php echo date('d M Y,h:i  A',strtotime($user->created)); ?><br></td>
               </tr>
            <?php } ?>
             <?php  if(!empty($user->modified)){ ?>
               <tr>
                 <th> 
                 Account Updated :
                 </th>
                 <td><i class="fa fa-calendar"></i>
                 <?php echo date('d M Y,h:i  A',strtotime($user->modified)); ?><br></td>
               </tr>
            <?php } ?>
            <?php  if(!empty($user->last_login)){ ?>
               <tr>
                 <th> 
                 Last login :
                 </th>
                 <td><i class="fa fa-calendar"></i>
                 <?php echo date('d M Y,h:i  A',strtotime($user->last_login)); ?><br></td>
               </tr>
            <?php } ?>
             <?php  if(!empty($user->last_ip)){ ?>
               <tr>
                 <th> 
                 Last login IP :
                 </th>
                 <td>
                 <?php echo $user->last_ip; ?><br></td>
               </tr>
            <?php } ?>
           </table>
         </td>
        </tr>
       </table>
 <!------------- Written by Prem Influencer Information ---------------->
 <?php if(!empty($influencerInfor)) { ?>
     <div class="panel-heading colum">
        <i class="fa fa-child"></i> Influencer Information
      </div>
     <table  width="100%" class="influencerInfor-table" style="margin-bottom: 14px;"> 
            
            <tr>
              <?php if(!empty($influencerInfor->fname)): ?>
              <th>User Name :</th>
              <td><?php $fname = ucfirst($influencerInfor->fname);$lname = ucfirst($influencerInfor->lname); echo $fname." ".$lname; ?></td>
              <?php endif; ?>
              <?php if(!empty($influencerInfor->country)): ?>
              <th>Country :</th><td><?= ucfirst($influencerInfor->country);?></td>
              <?php endif; ?> 
              <?php if(!empty($influencerInfor->state)): ?>
              <th>State :</th><td><?= ucfirst($influencerInfor->state);?></td>
              <?php endif; ?>
            </tr>
            <?php //endif; ?>
            <?php if(!empty($influencerInfor->screen_name)): ?>
            <tr><th>Screen Name :</th><td><?= ucfirst($influencerInfor->screen_name);?></td>
            <?php endif; ?>
             <?php if(!empty($influencerInfor->city)): ?>
            <th>City :</th><td><?= ucfirst($influencerInfor->city); ?></td>
             <?php endif; ?>
            </tr>
           
            <tr>
              <?php if(!empty($influencerInfor->type)): ?>
              <th>Influencer Type : </th><td><?=ucfirst($influencerInfor->type); ?></td>
            <?php endif; ?>
              <?php if(!empty($influencerInfor->region)): ?>
              <th>World Region :</th>
               <td><?=ucfirst($influencerInfor->region)?></td><?php endif; ?>
           </tr> 
           
            <tr>
              <?php if(!empty($influencerInfor->email)): ?>
              <th>Email :</th><td><?=$influencerInfor->email ?></td>
            <?php endif; ?>
            <?php if(!empty($influencerInfor->postal_code)): ?>
            <th>Postal Code : </th><td><?=$influencerInfor->postal_code?></td>
          <?php endif; ?>
            </tr> 

            <tr>
               <?php if(!empty($influencerInfor->email2)) { ?>
              <th>Alternate Email :</th><td><?= $influencerInfor->email2;  ?></td>
            <?php } else { ?>
              <th>Alternate Email :</th><td><?php echo "NA" ; ?></td>
            <?php } ?>
            <?php if(!empty($influencerInfor->created)): ?>
              <th>Created Date :</th><td><i class="fa fa-calendar"> </i> <?= date('d M Y,h:i  A',strtotime($influencerInfor->created)); ?></td>
            <?php endif; ?>
           </tr> 

            <tr>
               <?php if(!empty($influencerInfor->phone1)): ?>
              <th>Phone Number :</th><td><?=$influencerInfor->phone1?></td>
            <?php endif; ?>
              <?php if(!empty($influencerInfor->modified)): ?>
              <th>Updated Date :</th><td><i class="fa fa-calendar"></i> <?= date('d M Y,h:i  A',strtotime($influencerInfor->modified)); ?></td>
            <?php endif; ?>
              <td></td></tr> 
            <tr>
              <?php if(!empty($influencerInfor->phone2)){ ?>
              <th>Alternate Number :</th><td><?=$influencerInfor->phone2 ?></td>
              <th></th>
              <td></td>
            <?php } else {?> 
               <th>Alternate Number :</th><td><?="NA" ?></td>
                <th></th>
              <td></td>
              <?php }?>
            </tr> 
            <tr>
              <?php if(!empty($influencerInfor->url)): ?>
              <th>URL :</th><td><a href="<?=$influencerInfor->url ?>" target="_blank">View Details</a></td>
            <?php endif; ?>
            
           </tr>  
            <tr>
              <?php if(!empty($influencerInfor->how_I_flow)): ?>
              <th>How I Flow :</th> <td><?php  $wordCount = str_word_count($influencerInfor->how_I_flow); if($wordCount>5) { echo word_limiter($influencerInfor->how_I_flow,5); echo "<a href='' id='$influencerInfor->favorite_incredible_places_id' data-toggle='modal' class='descriptionModel' data-target='#descriptionModel'>View More</a>"; } else{ echo $influencerInfor->how_I_flow; } ?></td>
               <div class="modal fade" id="descriptionModel" role="dialog" style="margin-top: 100px;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: ">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title text-center"><b>How I Flow</b></h4>
                                </div>
                                <div class="panel-body">
                                   <div class="inner-content">
                                    <p id="descriptionContent" style="padding: 10px;font-size: 15px"><?= $influencerInfor->how_I_flow ?></p></div>
                                </div>
                            </div>
                        </div>
                     </div>
            <?php endif; ?>
              <td></td><td></td>
            </tr>
            <tr>
             <?php if(!empty($influencerInfor->about)): ?>
             <th>About :</th> <td><?php  $wordCount = str_word_count($influencerInfor->about); if($wordCount>5) { echo word_limiter($influencerInfor->about,5); echo "<a href='' id='$influencerInfor->favorite_incredible_places_id' data-toggle='modal' class='descriptionModel' data-target='#aboutModel'>View More</a>"; } else{ echo $influencerInfor->about; } ?></td><?php endif; ?>      <div class="modal fade" id="aboutModel" role="dialog" style="margin-top: 100px;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: ">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title text-center"><b>About</b></h4>
                                </div>
                                <div class="panel-body">
                                   <div class="inner-content">
                                    <p id="descriptionContent" style="padding: 10px;font-size: 15px"><?= $influencerInfor->about ?></p></div>
                                </div>
                            </div>
                        </div>
                     </div>
              <td></td><td></td>
            </tr> 
      </table>
   <?php } ?>
<!-------------Written Prem for Influencer Information Code End---------------->

 <!-------------aaaaaaaaaa---------------->
 <?php if(!empty($social_media)){?>
     <div class="panel-heading colum" style="margin-top: 15px">
        <i class="icon-user"></i> Social Media
      </div>
     <table  width="100%" class="social_media_table"> 
           <tr>
              <?php if(!empty($social_media->instagram)){ ?>
              <th width="100px">Instagram  :</th>
              <td width="153px;">
                <a href="<?=$social_media->instagram?>" target="_blank"><?=$social_media->instagram ?></a>
              </td>
              <th></th>
              <td></td>
            <?php } else {?> 
               <th width="100px">Instagram  :</th><td><?="NA" ?></td>
                <th></th>
              <td></td>
              <?php }?>
              <th width="185px">Instagram Followers  :</th> <?php if(!empty($social_media->instagram_followers)) { ?>
              <td><?=$social_media->instagram_followers; ?><?php }else{ echo "<td>"; echo "NA"; } ?></td>
            </tr> 
            <tr>
               <?php if(!empty($social_media->facebook)){ ?>
               <th>Facebook :</th><td><a href="<?=$social_media->facebook?>" target="_blank"><?=$social_media->facebook ?></a></td>
               <th></th>
               <td></td>
             <?php } else {?> 
                <th>Facebook :</th><td><?="NA" ?></td>
                 <th></th>
               <td></td>
               <?php }?>
              <th width="185px">Facebook Followers  :</th> 
              <?php if(!empty($social_media->facebook_followers)) { ?>
              <td><?=$social_media->facebook_followers; ?><?php }else{ echo "<td>"; echo "NA"; } ?></td>
             </tr> 
             <tr>
                <?php if(!empty($social_media->twitter)){ ?>
                <th>Twitter :</th><td><a href="<?=$social_media->twitter?>" target="_blank"><?=$social_media->twitter ?></a></td>
                <th></th>
                <td></td>
              <?php } else {?> 
                 <th>Twitter :</th><td><?="NA" ?></td>
                  <th></th>
                <td></td>
                <?php }?>
                <th>Twitter Followers  :</th> <?php if(!empty($social_media->twitter_followers)) { ?>
              <td><?=$social_media->twitter_followers; ?><?php }else{ echo "<td>"; echo "NA"; } ?></td></tr>
                <tr>
                 <?php if(!empty($social_media->youtube)){ ?>
                 <th>Youtube :</th><td><a href="<?=$social_media->youtube?>" target="_blank"><?=$social_media->youtube ?></a></td>
                 <th></th>
                 <td></td>
               <?php } else {?> 
                  <th>Youtube  :</th><td><?="NA" ?></td>
                   <th></th>
                 <td></td>
                 <?php }?>
                 <th>Youtube Subscribers  :</th><?php if(!empty($social_media->youtube_subscribers)) { ?>
              <td><?=$social_media->youtube_subscribers; ?><?php }else{ echo "<td>"; echo "NA"; } ?></td>
               </tr> 
               <tr>
                  <?php if(!empty($social_media->pinterest)){ ?>
                  <th>Pinterest  :</th><td><a href="<?=$social_media->pinterest?>" target="_blank"><?=$social_media->pinterest ?></a></td>
                  <th></th>
                  <td></td>
                <?php } else {?> 
                   <th>Pinterest  :</th><td><?="NA" ?></td>
                    <th></th>
                  <td></td>
                  <?php }?>
                  <th>Pinterest Followers  :</th><?php if(!empty($social_media->pinterest_followers)) { ?>
              <td><?=$social_media->pinterest_followers; ?><?php }else{ echo "<td>"; echo "NA"; } ?></td></tr>
                </tr>
               <tr>
                  <?php if(!empty($social_media->linkedin)){ ?>
                  <th>Linkedin  :</th><td><a href="<?=$social_media->linkedin?>" target="_blank"><?=$social_media->linkedin ?></a></td>
                  <th></th>
                  <td></td>
                <?php } else {?> 
                   <th>Linkedin  :</th><td><?="NA" ?></td>
                    <th></th>
                  <td></td>
                  <?php }?>
                  <th width="185px">Linkedin Followers  :</th><?php if(!empty($social_media->linkedin_followers)) { ?>
              <td><?=$social_media->linkedin_followers; ?><?php }else{ echo "<td>"; echo "NA"; } ?></td>
                </tr> 
           <!--  <tr><th>Twitter</th><td><a href="<?=$social_media->twitter?>" target="_blank"><?=$social_media->twitter?></a></td>
            <th>Twitter Followers</th><td><?=$social_media->twitter_followers?></td></tr>  -->

            <!-- <tr><th>Youtube</th><td><a href="<?=$social_media->youtube?>" target="_blank"><?=$social_media->youtube?></a></td><th>Youtube Subscribers</th><td><?=$social_media->youtube_subscribers?></td></tr>  -->

          <!--   <tr><th>Pinterest</th><td><a href="<?=$social_media->pinterest?>" target="_blank"><?=$social_media->pinterest?></a></td>
            <th>Pinterest Followers</th><td><?=$social_media->pinterest_followers?></td></tr>  -->

     <!--        <tr><th>Linkedin</th><td><a href="<?=$social_media->linkedin?>" target="_blank"><?=$social_media->linkedin?></a></td><td></td><td></td></tr> 
            <tr><th>Spotify</th><td><a href="<?=$social_media->spotify?>" target="_blank"><?=$social_media->spotify?></a></td><td></td><td></td></tr>  -->
           
            <tr><th>Total Reach  :</th><td><?=$social_media->total_reach?></td><td></td><td></td></tr>

    </table>
   <?php } ?>
     </div>   
<div class="clearfix"></div>
  <div class="adv-table">
      <div class="col-lg-3">
         <div class="board-block board-block-info">
            <div class="block-header">
               <h3 class="chart-tittle">
                  <a href="<?php echo base_url();?>backend/all_users_blog/?user_id=<?php echo $user->user_id;?>">Blog Articles </a>
               </h3>
               <span class=" pull-right badge block-badge">
               <?php echo $approve_by_admin_blog +  $unapprove_by_admin_blog +  $pending_by_admin_blog;  ?></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right">
               </a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
      <!--                <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Activated</td>
                        <td><?php echo $blog_articles_active; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td>Deactivated</td>
                        <td><?php echo $blog_articles_inactive; ?></td>
                     </tr> -->
                       <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Admin Approved</td>
                        <td><?php echo $approve_by_admin_blog; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td>Admin Unapproved</td>
                        <td><?php echo $unapprove_by_admin_blog; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td>Pending</td>
                        <td><?php echo $pending_by_admin_blog; ?></td>
                     </tr>
                   </tbody>
               </table>
            </section>
         </div>
      </div>
          <div class="col-lg-3">
         <div class="board-block board-block-danger">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/videos/?user_id=<?php echo $user->user_id;?>">My Videos</a>
               </h3>
               <span class=" pull-right badge block-badge">
               <?php echo $approve_by_admin_video +  $unapprove_by_admin_video +  $pending_by_admin_video;  ?></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
              <!--           <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Activated</td>
                        <td><?php echo $my_videos_active; ?></td>
                     </tr> -->
                     <tr>
                        <td>
                           <i class="icon-thumbs-up"></i>
                        </td>
                        <td>Admin Approved</td>
                        <td><?php echo $approve_by_admin_video; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-down"></i>
                        </td>
                        <td>Admin Unapproved</td>
                        <td><?php echo $unapprove_by_admin_video; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td>Pending</td>
                        <td><?php echo $pending_by_admin_video; ?></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
       <div class="col-lg-3">
         <div class="board-block board-block-success">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/shops/?user_id=<?php echo $user->user_id;?>">My Shop</a>
               </h3>
               <span class=" pull-right badge block-badge">
               <?php echo $approve_by_admin_shop +  $unapprove_by_admin_shop +  $pending_by_admin_shop;  ?></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                <!--      <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Activated</td>
                        <td><?php echo $my_shop_active; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td>Deactivated</td>
                        <td><?php echo $my_shop_inactive; ?></td>
                     </tr> -->
                     <tr>
                        <td>
                           <i class="icon-thumbs-up"></i>
                        </td>
                        <td>Admin Approved</td>
                        <td><?php echo $approve_by_admin_shop; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-down"></i>
                        </td>
                        <td>Admin Unapproved</td>
                        <td><?php echo $unapprove_by_admin_shop; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td>Pending</td>
                        <td><?php echo $pending_by_admin_shop; ?></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
       <div class="col-lg-3">
         <div class="board-block board-block-warning">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/upcoming_trips/?user_id=<?php echo $user->user_id;?>">My Upcoming Trips</a>
               </h3>
               <span class=" pull-right badge block-badge">
               <?php echo $approve_by_admin_trip +  $unapprove_by_admin_trip +  $pending_by_admin_trip;  ?></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Admin Approved</td>
                        <td><?php echo $approve_by_admin_trip; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td>Admin Unapproved</td>
                        <td><?php echo $approve_by_admin_trip; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td>Pending</td>
                        <td><?php echo $pending_by_admin_trip; ?></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
      <!------------->
        <div class="col-lg-3">
         <div class="board-block board-block-info">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/favorite_destinations/?user_id=<?php echo $user->user_id;?>">Favorite Destinations </a>
               </h3>
               <span class=" pull-right badge block-badge">
               <?php echo $approve_by_admin_desti +  $unapprove_by_admin_desti +  $pending_by_admin_desti;  ?></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
            <!--          <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Activated</td>
                        <td><?php echo $my_fav_destinations_active; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td>Deactivated</td>
                        <td><?php echo $my_fav_destinations_inactive; ?></td>
                     </tr> -->
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Admin Approved</td>
                        <td><?php echo $approve_by_admin_desti; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td>Admin Unapproved</td>
                        <td><?php echo $unapprove_by_admin_desti; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td>Pending</td>
                        <td><?php echo $pending_by_admin_desti; ?></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
        <div class="col-lg-3">
         <div class="board-block board-block-danger">
            <div class="block-header">
               <h3 class="chart-tittle">
                   <a href="<?php echo base_url();?>backend/favorite_incredible_places/?user_id=<?php echo $user->user_id;?>">Favorite Incredible Places</a> 
               </h3>
               <span class=" pull-right badge block-badge">
               <?php echo $approve_by_admin_place +  $unapprove_by_admin_place +  $pending_by_admin_place;  ?></span>
               <a data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample6" class="block-toggle-btn pull-right"></a>
            </div>
            <section class="panel in" id="collapseExample6">
               <table class="table table-hover personal-task">
                  <tbody>
               <!--       <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Activated</td>
                        <td><?php echo $my_fav_incredible_places_active; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td>Deactivated</td>
                        <td><?php echo $my_fav_incredible_places_inactive; ?></td>
                     </tr> -->

                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td>Admin Approved</td>
                        <td><?php echo $approve_by_admin_place; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td>Admin Unapproved</td>
                        <td><?php echo $unapprove_by_admin_place; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td>Pending</td>
                        <td><?php echo $pending_by_admin_place; ?></td>
                     </tr>
                     
                  </tbody>
               </table>
            </section>
         </div>
      </div>
 </div>
<div class="clearfix"></div>
    <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>&nbsp Change User's Email :</header>
    <br> 
      <form role="form" class="form-horizontal tasi-form" id="changeEmail" action="<?php echo current_url(); if(!empty($_GET['user_type'])) echo '?user_type='.$_GET['user_type'];?>" enctype="multipart/form-data" method="post">
         <?php //echo validation_errors(); ?>
         <?php //echo $this->session->flashdata('msg_error'); ?>
        <div class="form-group">
            <label class="col-md-2 control-label">Email <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="email" placeholder="New Email" class="form-control" name="newemail" id="newemail" value="<?php if(isset($_POST['newemail']))echo $_POST['newemail'];?>"><div id="email_result"></div>
                <span class="error"><?php echo form_error('newemail'); ?></span>
            </div>
        </div>
        <br>
         <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
               <button class="btn btn-primary" type="submit" id="changeEmailBtn">Change Email</button>
               <a class="btn btn-danger" href="<?php echo base_url()?>backend/users">
               Cancel</a>
            </div>
         </div>
      </form>

<div class="clearfix"></div>
      <form role="form" class="form-horizontal tasi-form" id="changePass" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
         <?php //echo validation_errors(); ?>
         <?php //echo $this->session->flashdata('msg_error');?>
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>&nbsp Change User's Passoword :</header>
         <br>
		    <div class="form-group">
            <label class="col-md-2 control-label">New Password <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="password" placeholder="New Password" class="form-control" name="newpassword" id="password" value="<?php if(isset($_POST['newpassword']))echo $_POST['newpassword'];?>" > <span class="error">
                <?php echo form_error('newpassword'); ?> </span>
            </div>
         </div> 
		     <div class="form-group">
            <label class="col-md-2 control-label">Confirm Password <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="password" placeholder="Confirm Password" class="form-control" name="confpassword" value="<?php if(isset($_POST['confpassword']))echo $_POST['confpassword'];?>" > <span class="error"><?php echo form_error('confpassword'); ?> </span>
            </div>
         </div><br>
         <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
               <button  class="btn btn-primary" type="submit">Change Password</button>
               <a class="btn btn-danger" href="<?php echo base_url()?>backend/users">
               Cancel</a>
            </div>
         </div>
      </form>
      <!-- END FORM--> 
   </div>
</div>
<link   href="<?php echo base_url();?>assets/css/chosen.min.css" rel="stylesheet">
<script src="<?php  echo base_url();?>assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
$(".chosen-select").chosen();
</script>
<script>
   $(document).ready(function(){
    var max_fields_limit      = 10; //set limit for maximum input fields
       var x = 1; //initialize counter for text box
       $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
           e.preventDefault();
               x++; //counter increment
               $('.input_fields_container').append('<div class="form-group"><label class="col-md-2 control-label">Attribute Value <span class="mandatory">*</span></label><div class="input-group col-md-9"><input autocomplete="off" class="input form-control" placeholder="Attribute Value"  name="attribute_value[]" type="text"><div class="input-group-addon"><a href="javatpoint:void(0)" class="remove_field" style="margin-left:10px;">Remove</a></div></div></div>'); //add input field
           
       });  
       $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
           e.preventDefault(); $(this).parents('div.form-group').remove(); x--;
       });
   
   $('#file_type').change(function() {
    $('#read_only').show();
    $('.section').hide();
    if($(this).val()==1 || $(this).val()==2 || $(this).val()==8)
    {
      $('.section-show'+$(this).val()).show();
    }else if($(this).val()==6){
      $('#read_only').hide();
    }else if($(this).val()==9){
      $('.section-show'+$(this).val()).show();
      $('.section-show-all').show();
    }else{
      $('.section-show-all').show();
      $('#read_only').hide();
    }
      });
});
</script>
<script type="text/javascript">
  $(document).ready(function () {  
    $('#changePass').validate({
      rules : {
          newpassword : {
              required: true,
              minlength : 5
          },
          confpassword : {
              required: true,
              minlength : 5,
              equalTo : "#password"
          },
      }
    });
    $('#changeEmail').validate({
      rules : {
          newemail : {
              required: true,
              email: true
          },
      }
    });
  });
</script>
<script type="text/javascript">
   $(document).ready(function(){  
      $('#newemail').keyup(function(){  
           var email = $('#newemail').val();  
           if(email != '')  
           {  
                $.ajax({  
                    url:"<?php echo base_url(); ?>backend/users/check_email_avalibility",  
                     method:"POST",  
                     data:{email:email},  
                     success:function(data){ 
                        console.log(data);
                        if(data){ 
                          $('#email_result').html(data); 
                          $("#changeEmailBtn").attr("disabled", "disabled");
                        }
                        if(data=='false'){
                           $("#changeEmailBtn").prop("disabled", false);
                            $('#email_result').html('');
                        }
                     }  
                });  
           }
           if(email=='') {
                $('#email_result').html('');
          }   
      });  
 }); 
</script>
<style type="text/css">
  .influencerInfor-table tr th {
    padding: 5px 5px;
    
  }
 .social_media_table tr th{
     padding: 5px 5px;
 } 
 table.social_media_table {
    margin-bottom: 21px;
}
</style>