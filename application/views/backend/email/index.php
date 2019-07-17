<div class="bread_parent">
  <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>  
       <li><b>Email Templates</b></li>
        <div class="btn-group pull-right" style="margin-top:-7px;">
      <a class="btn btn-primary btn-sm tooltips" href="<?php echo base_url('backend/email_templates/email_templates_add');?>" id="add" data-original-title="Click to add Email Template"> Add Email Templates 
      </a>
    </div>
  </ul>
</div>

   
  <div class="clearfix"></div> 
    <section class="panel-body no-padding-top" style="margin-top: 24px;">
     <div class="col-lg-14"> 
      <div class="template-title">Search By Title</div>
        <form action="<?php current_url() ?>" method="get" accept-charset="utf-8"  style="margin: 0 0 33px 0px;">
          <!-- <label class="col-md-2 no-padding-left">Title</label> -->
          <label class="col-md-2 no-padding-left">
            <input type="text" name="title" value="<?php echo trim($this->input->get('title')); ?>" class="form-control" placeholder="Search By Tiltle"></label>
         
            <button type="submit" class="btn btn-primary tooltips" data-original-title="Search" ><i class="fa fa-search" aria-hidden="true"></i></button>
          <a href="<?php echo current_url() ?>" class="btn btn-danger tooltips" data-original-title="Reset Search"><i class="fa fa-refresh" aria-hidden="true"></i></a>
          
        </form>
      </div>
      <!-- <header class="panel-heading"  ></header> -->
      <table id="datatable_example" class="email-template-table table-bordered responsive table table-striped table-hover" >
        <thead class="thead_color" >
          <tr>
            <th width="2%">S.No.</th>
            <th width="3%">ID</th>
            <th width="30%">Title</th>
            <th width="30%">Subject</th>
            
            <th width="18%"><i class="fa fa-calendar"></i> Created Date</th>
            <th width="20%">Actions</th>
          </tr>
        </thead>
          <?php  
          if(!empty($news)):
            $j=$offset+1; 
          foreach($news as $row): 
          ?>
            <tbody>
            <tr>
                <td><?php echo $j ?></td>
                <td><?php echo $row->id ?></td>
                <td><?php echo $row->template_name ?></td>
                <td><?php echo $row->template_subject ?></td>
               
                <td class="to_hide_phone"> <?php echo " ".date('d M Y,h:i  A',strtotime($row->template_created)); ?></td>
                <td class="ms">
                    <a href="<?php echo base_url().'backend/email_templates/email_templates_edit/'.$row->id ?>" class="btn btn-primary btn-xs tooltips" rel="tooltip"  data-placement="left" data-original-title="Edit" ><i class="icon-pencil"></i></a>

                    <a href="javascript:void(0);" onclick="return confirmBox('Are you sure you want to delete it?','<?php echo base_url().'backend/email_templates/email_templates_delete/'.$row->id ?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete" onclick="if(confirm('Are you sure you want to delete it?')){return true;} else {return false;}"><i class="icon-trash "></i>
                  </a>


                </td>
              </tr> 
            </tbody> 
          <?php $j++;  endforeach; ?>
        <?php else: ?>
          
        <?php endif; 
        if(!empty($_GET)){ ?>
          <tr>
           <th colspan="9">
              <center class="msg_error">
                      Your search did not match any documents.<br>
                      Suggestions:<br>
                      Make sure that all words are spelled correctly.<br>
                      Try to search by Title.<br>
              </center>
            </th>
          </tr>
        <?php } ?> 

    </table>
    </section>
  
  </div>
<?php echo $pagination;?>
<script type="text/javascript" >
 $(document).ready(function(){
  setTimeout(function(){
  $(".flash").fadeOut("slow", function () {
  $(".flash").remove();
      }); }, 5000);
 });
</script>
<style type="text/css">
.email-template-table.table>tbody{
  border: none;
}
.email-template-table{
  border:1px solid #ddd!important;
}
.template-title{
  font-weight: 700;
  padding-bottom: 20px;
}
</style>