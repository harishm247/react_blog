<div class="">
   <header class="panel-heading">
      Hello <?php echo superadmin_name(); ?>, Welcome to the admin section of  <?php echo SITE_NAME; ?>  <i class="icon-smile"></i>
   </header>
</div>
<div class="panel-body">
   <!--========================ORDER SECTION===================-->
  
   <?php 
  // $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
  // $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)]; 
   //$color=array('#ffc107','#1e7e34','#117a8b','#bd2130','#0062cc','#dddddd');
   $color=array('#ffa800','#d7ccc8','#f8bbd0','#cfd8dc','#17a2b8','#ffc107','#1da1f2','#f98315','#a7ffeb');
  
   $x=0;
   ?>
   <div class="col-md-12">
      <div class="report-section">
         <!--daily report-->
         
		 <?php foreach($projects as $row){?>
		  <div class="col-md-3">
            <div class="info-box " style="background-color:<?php echo $color[$x];$x++;if($x==9)$x=0;//echo $color[rand(0,5)];?>">
        
               <div class="info-box-content">
                  <span class="info-box-text"><a href="<?php echo base_url().'backend/projects/project/'.$row->id;?>"><?php echo $row->project_name;?></a></span>
               </div>
              
            </div>
			</div>
         <?php } ?>
         <!--Weekly report-->
		 <?php /* ?>
         <div class="">
            <div class="info-box info-success">
               <span class="info-box-icon"><i class="fa fa-usd"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Last 7 Days
                  <span class="pull-right" style="font-size: 12px">- <?php 
                     if (!empty($stat_sevenDays_orders->total_orders))
                       echo $stat_sevenDays_orders->total_orders;
                     else
                       echo "0";
                     ?> orders
                  </span></span>
                  <div class="info-box-number">
                     <div class="cryptocurrency-popover">
                         <?php
                           $sevenDaysInDollor = 0.00;
                           $sevenDaysInEth    = 0.00;
                           $sevenDaysInBtc    = 0.00;
                           if(!empty($stat_sevenDays_orders)){
                             $sevenDaysInDollor = $stat_sevenDays_orders->total_amounts * $stat_sevenDays_orders->currency_amount_in_dollor;
                             $sevenDaysInEth    = $stat_sevenDays_orders->total_amounts * $stat_sevenDays_orders->currency_amount_in_ethereum;
                             $sevenDaysInBtc    = $stat_sevenDays_orders->total_amounts * $stat_sevenDays_orders->currency_amount_in_bitcoin;
                           }
                         ?>
                         <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($sevenDaysInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($sevenDaysInEth,8); ?> ETH">
                          <i class="fa fa-dollar"></i><?php echo number_format($sevenDaysInDollor,2); ?>
                         </span>
                     </div>
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 50%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
         <!--Monthly report-->
         <div class="">
            <div class="info-box info-danger">
               <span class="info-box-icon"><i class="fa fa-usd"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Last 30 Days 
                  <span class="pull-right" style="font-size: 12px">- <?php 
                     if (!empty($stat_thirtyDays_orders->total_orders))
                       echo $stat_thirtyDays_orders->total_orders;
                     else
                       echo "0";
                     ?> orders
                  </span></span>
                  <div class="info-box-number">
                     <div class="cryptocurrency-popover">
                      <?php
                        $thirtyDaysInDollor = 0.00;
                        $thirtyDaysInEth    = 0.00;
                        $thirtyDaysInBtc    = 0.00;
                        if(!empty($stat_thirtyDays_orders)){
                          $thirtyDaysInDollor = $stat_thirtyDays_orders->total_amounts * $stat_thirtyDays_orders->currency_amount_in_dollor;
                          $thirtyDaysInEth    = $stat_thirtyDays_orders->total_amounts * $stat_thirtyDays_orders->currency_amount_in_ethereum;
                          $thirtyDaysInBtc    = $stat_thirtyDays_orders->total_amounts * $stat_thirtyDays_orders->currency_amount_in_bitcoin;
                        }
                      ?>
                        <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($thirtyDaysInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($thirtyDaysInEth,8); ?> ETH">
                          <i class="fa fa-dollar"></i><?php echo number_format($thirtyDaysInDollor,2); ?>
                        </span>
                     </div>
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 50%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
         <!--Yearly report-->
         <div class="">
            <div class="info-box info-info">
               <span class="info-box-icon"><i class="fa fa-usd"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total <span class="pull-right" style="font-size: 12px">- <?php 
                     if (!empty($stat_all_orders->total_orders))
                       echo $stat_all_orders->total_orders;
                     else
                       echo "0";
                     ?> orders</span></span>
                  <div class="info-box-number">
                     <div class="cryptocurrency-popover">
                      <?php
                        $allInDollor = 0.00;
                        $allInEth    = 0.00;
                        $allInBtc    = 0.00;
                        if(!empty($stat_all_orders)){
                          $allInDollor = $stat_all_orders->total_amounts * $stat_all_orders->currency_amount_in_dollor;
                          $allInEth    = $stat_all_orders->total_amounts * $stat_all_orders->currency_amount_in_ethereum;
                          $allInBtc    = $stat_all_orders->total_amounts * $stat_all_orders->currency_amount_in_bitcoin;
                        }
                      ?>
                        <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($allInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($allInEth,8); ?> ETH">
                          <i class="fa fa-dollar"></i><?php echo number_format($allInDollor,2); ?>
                        </span>
                     </div>
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 50%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
		 <?php */ ?>
      </div>
   </div>
   <!--========================SUPPORT SECTION===================-->
  

</div>
<div class="panel-body"></div>
<style>
.info-box-text{
	margin-top:20px;
}
.info-box-text a{
	color:#fff;
	font-size:18px;
}
.info-box {
	text-align:center;
}
.info-box-content {
    margin-left: 0; 
}
</style>