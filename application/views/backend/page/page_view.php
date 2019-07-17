<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard / </a></li>
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard / </a></li>
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard / </a></li>
</ul>
<div class="box paint color_0 ">
            <div class="title">
              <h4> <i class="icon-book"></i>&nbsp;<span>View Page </span> </h4>
            </div>
            <div class="content">
               <div class="form-row control-group row-fluid">
                  <label class="control-label span3" for="normal-field">Page Name</label>
                  <div class="controls span7">
                    <?php if(!empty($page->page_name)) echo $page->page_name ; else echo " "; ?>
                  </div>
                </div>
                <div class="form-row control-group row-fluid">
                  <label class="control-label span3" for="normal-field">Meta Title</label>
                  <div class="controls span7">
                   <?php if(!empty($page->meta_title)) echo $page->meta_title ; else echo " " ;?>
                  </div>
                </div>
                <div class="form-row control-group row-fluid">
                  <label class="control-label span3" for="normal-field">Meta Description</label>
                  <div class="controls span7">
                 <?php if(!empty($page->meta_description)) echo $page->meta_description ; else  echo " ";?>
                  </div>
                </div>
                <div class="form-row control-group row-fluid">
                  <label class="control-label span3" for="normal-field">Page Title</label>
                  <div class="controls span7">
                   <?php if(!empty($page->page_title)) echo $page->page_title ; else echo " ";?>
                  </div>
                </div>
                <div class="form-row control-group row-fluid">
                  <label class="control-label span3" for="normal-field">Page Content</label>
                  <div class="controls span7">
                   <?php if(!empty($page->page_content)) echo $page->page_content ; else echo " ";?>
                  </div>
                </div>
                 <div class=" row-fluid">
                    <div class="span3 visible-desktop"></div>
                      <div class="span7 ">
                        <a href="<?php echo base_url()?>backend/content/pages"><button class="btn btn-primary">Back</button></a>
                      </div>
                      <br>
                  </div>
            </div>
          </div>
          <!-- End .box -->