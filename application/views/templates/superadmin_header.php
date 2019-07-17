<?php  
  $main_segment  = $this->uri->segment(2); 
  $segment       = $this->uri->segment(3);
  $segment4      = $this->uri->segment(4); 

   if($segment=='dashboard') $dashboard='active'; else $dashboard='';

   if($main_segment=='category' || $main_segment=='attribute' || ($main_segment=='products' && ($segment=='variation_themes' || $segment=='add_variation_theme' || $segment=='edit_variation_theme'))) $catalog='active'; else $catalog='';
   if($main_segment=='category' && ($segment=='add_category' || $segment=='edit' || $segment=='index' || $segment=='add_subcategory' && $segment=='')) $Categories='active'; else $Categories='';
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="icon" type="image/png" href="<?php echo BACKEND_THEME_URL; ?>images/flowhaus-fav-logo.png"/>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Mosaddek">
      <meta name="keyword" content="">
      <title><?php if(isset($title)){ echo ucfirst($title)." | "; } ?><?php echo SITE_NAME;?></title>
      <!-- Bootstrap core CSS -->
      <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
      <link href="<?php echo BACKEND_THEME_URL ?>css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo BACKEND_THEME_URL ?>css/bootstrap-reset.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo BACKEND_THEME_URL ?>css/bootstrap-datetimepicker.min.css" />
      <!--external css-->
      <link href="<?php echo BACKEND_THEME_URL ?>plugin/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <link href="<?php echo BACKEND_THEME_URL ?>plugin/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
      <link rel="stylesheet" href="<?php echo BACKEND_THEME_URL ?>css/owl.carousel.css" type="text/css">
      <!-- Custom styles for this template -->
      <link href="<?php echo BACKEND_THEME_URL ?>css/style.css" rel="stylesheet">
      <link href="<?php echo BACKEND_THEME_URL ?>css/style-responsive.css" rel="stylesheet" />
      <link href="<?php echo BACKEND_THEME_URL; ?>css/sweetalert.css" rel="stylesheet" type="text/css"/>
      
      <link rel="stylesheet" type="text/css" media="all" href="<?php echo BACKEND_THEME_URL ?>css/easyzoom.css">
      <script src="<?php echo BACKEND_THEME_URL ?>js/jquery.js"></script>
      <!--fancy box -->
      <link href="<?php echo BACKEND_THEME_URL ?>css/rating.css" rel="stylesheet">
      <link href="<?php echo BACKEND_THEME_URL ?>css/jasny-bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo SELLER_THEME_URL; ?>css/cryptofont.min.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo BACKEND_THEME_URL ?>font-awesome/css/font-awesome.min.css">
      <script src="<?php echo BACKEND_THEME_URL; ?>js/sweetalert.js" type="text/javascript"></script>
      <script src="<?php echo BACKEND_THEME_URL ?>js/rating.js"></script>
      <script src="<?php echo base_url(); ?>assets/backend/admin/js/notify.min.js"></script>
      <script src="<?php echo BACKEND_THEME_URL; ?>js/moment.min.js"></script>  
      <script src="<?php echo BACKEND_THEME_URL; ?>js/bootstrap-datetimepicker.min.js"></script>   

      <script>
         SITE_URL = "<?php echo base_url(); ?>";
      </script>
      <style>
         .form-group .col-md-9{
            margin-top: 8px;
         }
      </style>
   </head>
   <body>
      <section id="container" >
      <!--header start-->
      <header class="header">
         <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3 no-padding">
            <div class="sidebar-toggle-box">
               <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
            <a href="<?php echo base_url('backend/superadmin')?>" class="logo">FLOW<span>HAUS</span></a>
            <!--logo end-->
         </div>
         <!-- <div class="col-md-8 col-lg-8"> -->
         <div class="top-nav col-md-9 col-lg-9 col-sm-9 col-xs-9">
            <div class="col-md-10 col-lg-10 col-sm-8 col-xs-8 padding-left">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <div class="nav notify-row yamm" id="top_menu">
                     <!--  notification start -->
                     <!--  notification end -->
                  </div>
               </div>
            </div>
            <!--search & user info start-->
            <div class="col-md-2 col-lg-2 col-sm-4 col-xs-4 no-padding">
               <ul class="nav pull-right ">
                  <li class="dropdown">
                     <a data-toggle="dropdown" class="dropdown-toggle admin-logout" href="#">
                     <img alt="" src="<?php echo BACKEND_THEME_URL ?>images/flowhaus-fav-logo.png" style="width: 18px;">
                     <span class="username" style="vertical-align: middle;"><?php echo ucwords(superadmin_details()); ?></span>
                     <b class="caret"></b>
                     </a>
                     <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li><a href="http://flowhaus.com/" target="_blank"><i class="fa fa-home"></i>Front Website</a></li>
                        <li><a href="<?php echo base_url()?>backend/superadmin/profile"><i class="fa fa-user"></i>My Profile</a></li>
                        <li><a href="<?php echo base_url()?>backend/superadmin/change_password"><i class="fa fa-key"></i>Change Password</a></li>
                        <li><a href="<?php echo base_url()?>backend/superadmin/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                     </ul>
                  </li>
                  <!-- user login dropdown end -->
               </ul>
               <!--search & user info end-->
            </div>
         </div>
      </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
         <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
               <li>
                  <a class="<?php echo $dashboard ?>" href="<?php echo base_url('backend/superadmin/dashboard') ?>">
                  <i class="icon-dashboard"></i>
                  <span>Dashboard</span>
                  </a>
               </li>
			   <?php if($this->session->userdata('user_info')['user_role']==0){?>
			    <li class="sub-menu dcjq-parent-li">
                  <a  href="<?php echo base_url('backend/users') ?>" class="<?php if($main_segment == 'users') echo 'active'; ?>">
                  <i class="fa fa-users" aria-hidden="true"></i>
                  <span>Manage Users</span>
                  </a>
                  <ul class="sub">
                     <li class="sub-menu <?php if(($main_segment == 'users' && $segment != 'influencer'  && $segment != 'edit_user')  || (isset($_GET['user_type']) && $_GET['user_type']==1 && $main_segment == 'users') ) echo 'active';?>" >
                        <a href="<?php echo base_url('backend/users') ?>" ><i class="fa fa-list" aria-hidden="true"></i>Users</a>
                     </li>
                     <li class="sub-menu <?php if(($main_segment == 'users' &&  $segment == 'influencer') || (isset($_GET['user_type']) && $_GET['user_type']==2 && $main_segment == 'users') ) echo 'active';?>">
                        <a href="<?php echo base_url('backend/users/influencer') ?>" >  <i class="fa fa-list" aria-hidden="true"></i>Influencer </a>
                     </li>
                  </ul>
               </li>
     
			   <?php } ?>
 
      <!--       <li class="sub-menu dcjq-parent-li">
               <a  href="<?php echo base_url('backend/videos') ?>" class="<?php if($main_segment == 'videos') echo 'active'; ?>">
               <i class="fa fa-play" aria-hidden="true"></i>
               <span>Videos</span>
               </a>
            </li> -->
        <!--     <li class="sub-menu dcjq-parent-li">
               <a  href="<?php echo base_url('backend/shops') ?>" class="<?php if($main_segment == 'shops') echo 'active'; ?>">
               <i class="fa fa-shopping-cart" aria-hidden="true"></i>
               <span>My Shop</span>
               </a>
            </li>
            <li class="sub-menu dcjq-parent-li">
               <a  href="<?php echo base_url('backend/upcoming_trips') ?>" class="<?php if($main_segment == 'upcoming_trips') echo 'active'; ?>">
               <i class="fa fa-plane" aria-hidden="true"></i>
               <span>Upcoming Trips</span>
               </a>
            </li> -->
            <!-- Getting id from edit function for showing active  -->
            <?php if(empty($destination_id)){ $destination_id=' ';} if(!empty($destination_id)){ $destination_id; } ?>
            <li class="sub-menu dcjq-parent-li">
              <!--  <a  href="<?php echo base_url('backend/favorite_destinations') ?>" class="<?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) echo 'active'; ?>">
               <i class="fa fa-star" aria-hidden="true"></i>
               <span>Destinations</span>
               </a> -->
               <!--  &&  -->
              <!--  <ul class="sub" style="display: block;">
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) {if(!empty($_GET['category']) && $_GET['category']==1){ echo 'active'; } }  ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations?category=1') ?>"> <i class="icon-th-list"></i> Favorite Destinations</a>
                     </li>
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id){if(!empty($_GET['category']) && $_GET['category']==2){ echo 'active'; } } ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations?category=2') ?>"> <i class="icon-th-list"></i> Urban Destinations</a>
                     </li>
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) { if(!empty($_GET['category']) && $_GET['category']==3){ echo 'active'; } }  ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations?category=3') ?>"> <i class="icon-th-list"></i> Beach Destinations</a>
                     </li>
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) {if(!empty($_GET['category']) && $_GET['category']==4){ echo 'active'; } }  ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations?category=4') ?>"> <i class="icon-sort-by-attributes"></i>Extraordinary Destinations</a>
                     </li>
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) {if(empty($_GET['category'])){ echo 'active'; } }  ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations') ?>"> <i class="icon-th-list"></i> All Destinations</a>
                     </li>
                  </ul>
            </li> -->
             <?php if(empty($place_id)){ $place_id=' ';} if(!empty($place_id)){ $place_id; } ?>
              <?php if(empty($destination_id)){ $destination_id=' ';} if(!empty($destination_id)){ $destination_id; } ?>
       <!--      <li class="sub-menu dcjq-parent-li">
               <a  href="<?php echo base_url('backend/favorite_incredible_places') ?>" class="<?php if($main_segment == 'favorite_incredible_places' || $segment4 == $place_id) echo 'active'; ?>">
               <i class="fa fa-glass" aria-hidden="true"></i>
               <span>Incredible Place</span>
               </a>
            </li> --> 
            <li class="sub-menu dcjq-parent-li">
               <a  href="<?php echo base_url('backend/influencer_details') ?>" class="<?php if($main_segment == 'influence_details' || $main_segment=='all_users_blog' || $main_segment=='videos' || $main_segment=='shops' || $main_segment == 'upcoming_trips' || $main_segment == 'favorite_incredible_places' || $segment=='blog_type' || $segment4 == $place_id || $main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id  ) echo 'active'; ?>">
               <i class="fa fa-book" aria-hidden="true"></i>
               <span>Influencer's Info</span><span class="dcjq-icon">
               </a>
               <ul class="sub" style="display: block;">
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'influence_details' && $segment == '') echo 'active'; ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/influence_details') ?>"> <i class="icon-th-list"></i> Influencer Type</a>
                     </li>
                     <li class="sub-menu dcjq-parent-li <?php if($segment == 'category') echo 'active'; ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/influence_details/category') ?>"> <i class="icon-sort-by-attributes"></i>Influencer Category</a>
                     </li>
                  <li class="sub-menu dcjq-parent-li">
                     <a  href="<?php echo base_url('backend/all_users_blog') ?>" class="<?php if($main_segment == 'all_users_blog') echo 'active'; ?>">
                     <i class="fa fa-book" aria-hidden="true"></i>
                     <span>Articles</span><span class="dcjq-icon"></a>
                        <ul class="sub" style="display: block;">
                           <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'all_users_blog' && $segment == 'index' || $segment == '') echo 'active'; ?>">
                              <a class="dcjq-parent" href="<?php echo base_url('backend/all_users_blog') ?>"> <i class="icon-th-list"></i> Articles</a>
                           </li>
                           <li class="sub-menu dcjq-parent-li <?php if($segment == 'blog_type' ) echo 'active'; ?>">
                              <a class="dcjq-parent" href="<?php echo base_url('backend/all_users_blog/blog_type') ?>"> <i class="icon-sort-by-attributes"></i>Article Type</a>
                           </li>
                        </ul>
                  </li>
                  <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'videos') echo 'active'; ?>">
                     <a  href="<?php echo base_url('backend/videos') ?>" class="">
                     <i class="fa fa-play" aria-hidden="true"></i>
                     <span>Videos</span>
                     </a>
                  </li> 
                  <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'shops') echo 'active'; ?>">
                     <a  href="<?php echo base_url('backend/shops') ?>" class="">
                     <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                     <span>My Shop</span>
                     </a>
                  </li>
                  <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'upcoming_trips') echo 'active'; ?>">
                     <a  href="<?php echo base_url('backend/upcoming_trips') ?>" class="">
                     <i class="fa fa-plane" aria-hidden="true"></i>
                     <span>Upcoming Trips</span>
                     </a>
                  </li>
                 
                  <li class="sub-menu dcjq-parent-li">
                     <a  href="<?php echo base_url('backend/favorite_destinations') ?>" class="<?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) echo 'active'; ?>">
                     <i class="fa fa-star" aria-hidden="true"></i>
                     <span>Destinations</span>
                     </a>
                     <!--  &&  -->
                     <ul class="sub" style="display: block;">
                           <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) {if(!empty($_GET['category']) && $_GET['category']==1){ echo 'active'; } }  ?>">
                              <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations?category=1') ?>"> <i class="icon-th-list"></i> Favorite Destinations</a>
                           </li>
                           <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id){if(!empty($_GET['category']) && $_GET['category']==2){ echo 'active'; } } ?>">
                              <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations?category=2') ?>"> <i class="icon-th-list"></i> Urban Destinations</a>
                           </li>
                           <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) { if(!empty($_GET['category']) && $_GET['category']==3){ echo 'active'; } }  ?>">
                              <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations?category=3') ?>"> <i class="icon-th-list"></i> Beach Destinations</a>
                           </li>
                           <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) {if(!empty($_GET['category']) && $_GET['category']==4){ echo 'active'; } }  ?>">
                              <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations?category=4') ?>"> <i class="icon-sort-by-attributes"></i>Extraordinary Destinations</a>
                           </li>
                           <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_destinations' || $segment == 'add_destinations' || $segment4==$destination_id) {if(empty($_GET['category'])){ echo 'active'; } }  ?>">
                              <a class="dcjq-parent" href="<?php echo base_url('backend/favorite_destinations') ?>"> <i class="icon-th-list"></i> All Destinations</a>
                           </li>
                        </ul>
                  </li>
                 
                  <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'favorite_incredible_places' || $segment4 == $place_id) echo 'active'; ?>">
                     <a  href="<?php echo base_url('backend/favorite_incredible_places') ?>" class="">
                     <i class="fa fa-glass" aria-hidden="true"></i>
                     <span>Incredible Place</span>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="sub-menu dcjq-parent-li">
               <a  href="<?php echo base_url('backend/content') ?>" class="<?php if($main_segment == 'content' ) echo 'active'; ?>">
               <i class="fa fa-book" aria-hidden="true"></i>
               <span>Content Management</span><span class="dcjq-icon">
               </a>
                  <ul class="sub" style="display: block;">
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'content') echo 'active'; ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/content/page_edit') ?>"> <i class="icon-th-list"></i>Pages</a>
                     </li>
                  </ul>
            </li>
            <li class="sub-menu dcjq-parent-li">
               <a class="dcjq-parent <?php if($segment == 'email_notification') echo 'active'; ?>" href="<?php echo base_url('backend/superadmin/email_notification') ?>"> <i class="icon-th-list"></i>Support</a>
            </li>
            <li class="sub-menu dcjq-parent-li">
               <a  href="" class="<?php if($segment == 'option' || $main_segment == 'world_region' || $main_segment == 'email_templates') echo 'active'; ?>">
               <i class="fa fa-book" aria-hidden="true"></i>
               <span>Global Setting</span><span class="dcjq-icon">
               </a>
                  <ul class="sub" style="display: block;">
                     <li class="sub-menu dcjq-parent-li <?php if($segment == 'option' && $segment4 == '') echo 'active'; ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/superadmin/option') ?>" class="<?php if($main_segment == 'option') echo 'active'; ?>" > <i class="icon-th-list"></i>Setting</a>
                     </li>
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'email_templates') echo 'active'; ?>">
                         <a class="dcjq-parent" href="<?php echo base_url('backend/email_templates') ?>"> <i class="icon-th-list"></i>Email Templates</a>
                     </li>
                  <!--     <li class="sub-menu dcjq-parent-li <?php if($segment == 'email_notification') echo 'active'; ?> ">
                         <a class="dcjq-parent" href="<?php echo base_url('backend/superadmin/email_notification') ?>" class="<?php if($main_segment == 'email_notification') echo 'active'; ?>"> <i class="icon-th-list"></i>Notifications</a>
                     </li> -->
                     <li class="sub-menu dcjq-parent-li <?php if($main_segment == 'world_region') echo 'active'; ?>">
                        <a class="dcjq-parent" href="<?php echo base_url('backend/world_region') ?>"> <i class="icon-th-list"></i> World Region</a>
                     </li>
                  </ul>
            </li>
               <!--multi level menu end-->
            </ul>
            <!-- sidebar menu end-->
         </div>
      </aside>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
         <!-- page start-->
         <div class="row">
            <div class="col-lg-12">
            <?php msg_alert(); ?>   
               <section class="panel">
               <!-- Starting the right side content from here  -->