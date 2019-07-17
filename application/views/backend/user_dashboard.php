<div class="">
   <header class="panel-heading">
      Hello <?php echo superadmin_name(); ?>, Welcome to the dashboard of Project management  <i class="icon-smile"></i>
   </header>
</div>
<div class="panel-body">

  <div class="color-legend ">
        <select class="form-control commonstatus order-select-status" >
				<!--<option value="">All</option>
				<option value="3">Delete</option>-->
				<option value="">Select</option>
				<option value="0">To do</option>
				<option value="1">In progress</option>
				<option value="2">Done</option>                     
       </select>
      <span class="color-legend0">To Do</span>
      <span class="color-legend1">In Progress</span>
      <span class="color-legend2">Done</span>
  </div>
  <div class="adv-table">
  <?php 
  $status=array('To Do','In Progress','Done'); 
  $color=array('#fff','#f39c12','#4CAF50');
  $bg=array('warning','info','success');
  $i=1;
  ?>
  <?php  foreach($tasks_list as $key=>$projects) { if($i==3)$i=0;?>
       <div class="col-lg-4">
         
      <div class="board-block board-block-<?=$bg[$i]?>">
	      
            <div class="block-header">
               <a target="_blank" href="<?php echo base_url(); ?>backend/user/index/2">
                  <h3 class="chart-tittle">
                    <?php echo date('d-m-Y',strtotime($key));?></span>
					
                  </h3>
               </a>
               <span class=" pull-right badge block-badge"><?php //echo $active_customers->total_rows + $deactive_customers->total_rows;  ?></span>
            </div>
			<?php if(!empty($projects)) { foreach($projects as $key2=>$project){?>
			<?php if(!empty($project)){ ?>
			<div class="project_name"><?php echo $key2;?></div>
            <section class="panel in"  class="">
               <table class="table  personal-task">
                  <tbody>
				  <?php  foreach($project as $task){ ?>
                     <tr class="status<?php echo $task->status;?>">
                        <td>
						<span class="checkboxli term-check">
								<input type="checkbox" id="check<?php echo $task->id;?>" name="checkstatus[]" value="1" class="change_status" task-id="<?php echo $task->id;?>" <?php if($task->status==2)echo 'checked';?>> 
								<label class="" for="check<?php echo $task->id;?>"  style="background:<?php //echo $color[$task->status];?>" ></label>
						</span>
					
						   
                        </td>
                        <td class="desc"><?php echo $task->task;?><br>
						<div class="dates">
						<small class="created_date ">
							<i class="fa fa-clock-o" style="font-size:14px"></i>
							<?php echo date('H:i',strtotime($task->created_date));?>
						</small>
						
						<small class="modified_date">
							<i class="fa fa-calendar" style="font-size:14px"></i>
							<?php echo date('d-m-Y H:i',strtotime($task->modified_date));?>
						</small>
						</div>
						
						<!--<small class="pull-right"><?php echo $status[$task->status];?></small>-->
						</td>
                        <td><?php //echo $active_customers->total_rows;  ?></td>
                     </tr>
				  <?php } ?>
                    <!-- <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a target="_blank" href="<?php echo base_url(); ?>backend/user/index/2?user_name=&email=&country_code=&mobile=&status=2">Inactive Customers</a></td>
                        <td><?php echo $deactive_customers->total_rows;  ?></td>
                     </tr>-->
                  </tbody>
               </table>
            </section>
  <?php }} } ?>
         </div>
         </div>
  <?php $i++;  } ?>
     
      <div class="clearfix"></div>
   </div>
   <div class="clearfix"></div>
 

</div>
<div class="panel-body"></div>
<script>
$(document).ready(function(){
	$('.change_status').click(function(){ 
		if($(this).prop('checked')==true)var status=2;
		else status=0;
		var id = $(this).attr('task-id');
		//alert(status);
		$.ajax({
			url:'<?php echo base_url();?>backend/tasks/change_status/',
			data:{id:id,status:status},
			type:'POST',
			success:function(data){
				
			}
			
		});
	});
	
});



/*$('.personal-task td ').hover(function(){
    $(this).find('.modified_date').show();
	$(this).find('.created_date').hide();
    }, function(){
    $(this).find('.modified_date').hide();
	$(this).find('.created_date').show();
});
*/

$('.table.personal-task').hover(function(){
	 $(this).parents('.panel').prev('.project_name').addClass('active');
   }, function(){
    $(this).parents('.panel').prev('.project_name').removeClass('active');
});

/*$("td.desc").hover(function(){
    $(this).find('.dates').show();
    }, function(){
   $(this).find('.dates').hide();
});*/
</script>
<style>
.info-box-text{
	margin-top:20px;
}
.info-box-text a{
	color:#fff;
	font-size:18px;
}
.project_name{
	padding-left: 15px;
	padding-left: 15px;
    font-weight: 900;
    font-size: 13px;
	clear: both;
    padding: 5px 10px 0;

}

.checkboxli label {
    top: 0px; 
}
.board-block-info .panel.in{
	clear: both;
}
.project_name {
height: 0px;
opacity: 0;
transition: height 500ms;
}
.project_name.active {
height:20px;
opacity: 1;
transition: height 300ms;


}
.panel-body {
     background: #f7efef;
}
tbody{
	    box-shadow: 0px 7px 8px 2px rgba(0,0,0,0.1);
}
.panel{
	margin-bottom:10px;
}
.adv-table table tr td, .adv-table table tr th{
	font-weight: bold;
}
.modified_date{
	float:right;
	margin:5px 0;
	text-transform: capitalize;
	
}
.created_date {
	float:left;
	margin:5px 0;
}
.status0{
	background:#ccc;
}
.status1{
	background:#edc678;
}
.status2{
	background:rgb(128, 216, 255);
}
 .personal-task tbody .status2  td i, .personal-task tbody .status1  td i,.personal-task tbody .status0  td i{
	color:#fff;
}
.color-legend{
  text-align: right;
  }
.color-legend span{
	display:inline-block;
	color:#fff;
	font-weight:bold;
	margin:10px;
	padding: 5px 8px;;
	text-align:center;
}
span.color-legend0{background:#ccc;}
span.color-legend1{background:#edc678;}
span.color-legend2{background:rgb(128, 216, 255);}

select.form-control.commonstatus.order-select-status {
    width: 134px;
    margin-top: 20px;
    margin-left: 30px;
}
</style>