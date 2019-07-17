<div class="bread_parent">
  <div class="col-md-10">
  <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
       <li><b>Pages</b> </li>       
  </ul>
  </div>
  <div class="col-md-2">
    <div class="btn-group pull-right">
      <a class="btn btn-primary btn-toggle-link tooltips" id="add" rel="tooltip" data-placement="top" data-original-title="Add New Pages" > Add Pages
      </a>
     </div>
  </div>
  <div class="clearfix"></div>
</div><br>
 <div id="tab1"> 
  <div class="panel-body div_border toggle-inner-panel" id="form" style="<?php if(isset($_POST['submit'])) echo"display:block"; else ?>display:none;" >  
    <div class="panel-body aa">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
          <?php echo $this->session->flashdata('msg_error');?>
          <div class="form-body">
            <div class="form-group">
              <label class="col-md-2 control-label">Title <span class="error">*</span></label>
              <div class="col-md-10">
                <input type="hidden" name="post_type" value="page">
                <input type="text" placeholder="Page Title" class="form-control" name="page_title" value="<?php echo set_value('page_title');?>"><?php echo form_error('page_title'); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Content <span class="error">*</span></label>
              <div class="col-md-10">
                <div class="input-group">
                  <textarea class="tinymce_edittor form-control" id="mytextarea" cols="100" rows="50" name="page_content"><?php echo set_value('page_content');?></textarea>
                  <?php echo form_error('page_content'); ?>
                </div>
              </div>
            </div>
           <!--  <header class="panel-heading colum">Meta Information: </header><br>     
       
            <div class="form-group">
                <label class="col-md-2 control-label">Meta Title</label>
                <div class="col-md-9">
                 <textarea class="form-control" cols="150" rows="2" name="meta_title" placeholder="Meta Title"></textarea>
                                 </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Meta Keywords </label>
              <div class="col-md-9">
               <textarea class="form-control" cols="150" rows="3" name="meta_keywords" placeholder="Meta Keywords"></textarea>
                             
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Meta Descritpion </label>
              <div class="col-md-9">
               <textarea class="form-control" cols="150" rows="4" name="meta_description" placeholder="Meta Descritpion"></textarea>          
               <b class="validation_info">The Brief Content must not have more than 225 characters.</b><br> 
              </div>
            </div> -->
          </div> 
          </div>          
          <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
              <button class="btn btn-primary pull-right" name="submit" type="submit" > Save </button>                                           
              </div>
            </div>
          </form>
          <!-- END FORM--> 
        </div>
      
         
       </div> 
<div class="panel-body">
  <div class="adv-table">
   <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
      <thead class="thead_color">
        <tr>
          <th class="jv no_sort">S.No.</th>
          <th class="jv no_sort"> ID</th>
          <th class="no_sort">Page Name</th>
          <th class="no_sort">Page Slug</th>                  
          <th class="to_hide_phone ue no_sort">Status</th>
          <th class="to_hide_phone span2"><i class="fa fa-calendar"></i> Created Date</th>
          <th class="ms no_sort ">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        if(!empty($pages)):
          $i=$offset; foreach($pages as $row): 
        $i++;?>
        <tr>
          <td><?php echo $i.".";?></td>
          <td><?php echo '# '.$row->page_id;?></td>
          <td class=""><a href="<?php echo base_url().'backend/content/page_edit/'.$row->page_id.'/'.$offset?>" class="btn btn-small"  rel="tooltip" data-placement="left" data-original-title=" Edit "><?php if(!empty($row->title)) echo $row->title; ?></a></td>   

           <td class=""><?php if(!empty($row->title)) echo $row->slug; ?></td>                 
          <td class="to_hide_phone">
            <?php if($row->status==1){ ?>
            <a class="label label-success label-mini tooltips" href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->page_id.'/'.$row->status.'/'.$offset.'/pages')?>" rel="tooltip" data-placement="top" data-original-title="Change Status" >Active </a> 
            <?php } 
            else{ ?><a class="label label-warning label-mini tooltips"  href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->page_id.'/'.$row->status.'/'.$offset.'/pages')?>" rel="tooltip" data-placement="top" data-original-title="Change Status" > Deactive </a> 
            <?php } ?>
          </td>
          <td class="to_hide_phone"><?php echo date('d M Y,h:i  A',strtotime($row->created_at)); ?></td>
          <td class="ms">
           
              <a href="<?php echo base_url().'backend/content/page_edit/'.$row->page_id.'/'.$offset?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit ">
                <i class="icon-pencil"></i> 
              </a> 
         <!--      <a style="" href="<?php echo base_url().'backend/content/page_delete/'.$row->page_id.'/'.$offset?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Delete" onclick="if(confirm('Are you sure want to delete?')){return true;} else {return false;}" >                        
                <i class="icon-trash "></i></a>  -->
             
            </td>
          </tr> 
        <?php  endforeach; ?>
      <?php else: ?>
        <tr>
          <th colspan="6"  class="msg"> <center>No Pages Found.</center></th>

        </tr>

      <?php endif; ?>
    </tbody>
  </table>

  <div class="row-fluid  control-group mt15">             

    <div class="span12">
      <?php if(!empty($pagination))  echo $pagination;?>              
    </div>

  </div>
</div>
</div>



