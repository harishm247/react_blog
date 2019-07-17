    </section>
                </div>
            </div>
        </section>
    </section>
</section>
<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo BACKEND_THEME_URL ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>js/jasny-bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo BACKEND_THEME_URL ?>js/jquery.scrollTo.min.js"></script>
<script src="<?php echo BACKEND_THEME_URL ?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo BACKEND_THEME_URL ?>js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?php echo BACKEND_THEME_URL ?>plugin/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?php echo BACKEND_THEME_URL ?>js/owl.carousel.js" ></script>
<script src="<?php echo BACKEND_THEME_URL ?>js/jquery.customSelect.min.js" ></script>
<script src="<?php echo BACKEND_THEME_URL ?>js/respond.min.js" ></script>
<!--common script for all pages-->
<script src="<?php echo BACKEND_THEME_URL ?>js/common-scripts.js"></script>
<!--script for this page-->
<script src="<?php echo BACKEND_THEME_URL ?>js/sparkline-chart.js"></script>
<script src="<?php echo BACKEND_THEME_URL ?>js/easy-pie-chart.js"></script>
<script src="<?php echo BACKEND_THEME_URL ?>js/count.js"></script>
<script src="<?php echo base_url(); ?>assets/seller/js/custom.js"></script>

<!-- multiple select -->
<link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>plugin/jquery-multi-select/css/multi-select.css" />
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>plugin/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>plugin/jquery-multi-select/js/jquery.quicksearch.js"></script> 
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>plugin/select2/select2.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
     // var handleMultiSelect = function () {
      $('.my_multi_select1').multiSelect();
      $('#my_multi_select2').multiSelect({
          selectableOptgroup: true
      });
      $("#e19").select2({ maximumSelectionSize: 100});
  });
</script>
<script>  
  //setTimeout(function(){ $(".alert").hide("slow") }, 10000); 
</script>
<!-- Disable enter from forms -->
<script type="text/javascript"> 
function stopRKey(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = stopRKey; 
</script>
<!-- color picker -->
<link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>css/colorpicker.css" />
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>js/bootstrap-colorpicker.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
   $('.colorpicker-default').colorpicker({
      format: 'hex'
   });
  });
</script>
<!-- <script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>tinymce/tinymce.min.js"></script> -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript">
  tinymce.init({
      selector: ".tinymce_edittor",
      relative_urls : false,
      remove_script_host : false,
      convert_urls : true,
      menubar: false,
      width :832,
      height :300,
      plugins: [
          "advlist autolink lists link image charmap print preview anchor media",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime table contextmenu paste textcolor directionality",
      ],
      image_advtab: true,
      resize: false,
      toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | preview code ", 
      //toolbar: "styleselect | bold italic | bullist | link image media | preview code",    
       file_browser_callback : elFinderBrowser,   
  });

  function elFinderBrowser(field_name, url, type, win){
    tinymce.activeEditor.windowManager.open({
        file: '<?php echo base_url("elfinders/index") ?>',// use an absolute path!
        title: 'File Manager',
        width: 900,
        height: 450,
        resizable: 'yes'
      },{
      setUrl: function (url) {
        win.document.getElementById(field_name).value = url;
      }
    });
    return false;
  }
</script>
<script>
    $(document).ready(function() {
        $("#owl-demo").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
            autoPlay:true
        });
    });
    $(function(){
        $('select.styled').customSelect();
    });
</script>
<link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>Jcrop-WIP-2.x/css/Jcrop.css">
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>Jcrop-WIP-2.x/js/Jcrop.min.js"></script>
<!-- zoom -->
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>js/easyzoom.js"></script>
<script type="text/javascript">
$(function(){
var $easyzoom = $('.easyzoom').easyZoom();
});
</script>
<!-- print area end -->
<link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>css/jquery.datetimepicker.css"/>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>js/jquery.datetimepicker.js"></script>
<script>
  $('#datetimepicker').datetimepicker1({format:'Y/m/d H:i',value:'',minDate: '+1D',step:10});
  $('#image_button').click(function(){     
  $('#datetimepicker').datetimepicker1('show'); //support hide,show and destroy command
  });    
</script>
<?php if ($this->uri->segment(2)=='attribute' || $this->uri->segment(2)=='products' || $this->uri->segment(2)=='tasks') : ?>
<link rel="stylesheet" href="<?php echo BACKEND_THEME_URL ?>css/jquery-ui.css">
<script src="<?php echo BACKEND_THEME_URL ?>js/jquery-ui.js"></script>
<script type="text/javascript">
  $(document).ready(function($){
      //date picker on event promotion page
  	  $(".date").datepicker({
  		  dateFormat: 'dd-mm-yy', 
  	  });

      $("#dpd1").datepicker({
          changeMonth: true,
          dateFormat: 'dd-mm-yy', 
  		    maxDate: 'dateToday',
          numberOfMonths: 1,             
          onClose: function( selectedDate ) {
          $( "#dpd2" ).datepicker( "option", "minDate", selectedDate );
          }
      });

      $("#dpd2").datepicker({
        changeMonth: true,
        dateFormat: 'dd-mm-yy', 
  	    maxDate: 'dateToday',
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
          $( "#dpd1" ).datepicker( "option", "maxDate", selectedDate );
        }
      });
  });
</script>
<?php endif; ?>
<script>
  $(document).ready(function() {
    $("#add").click(function(){
      $("#form").slideToggle();
    });
   
  });

  $("[data-toggle=popover]").popover({
     html: true, 
      content: function() {
      return $('#popover-content').html();
    }
  });

  //tool tips
  $('[data-toggle="tooltip"]').tooltip();
  //    popovers
  $('[data-toggle="popover"]').popover();

  $('body').on("touchstart", function(e){

      $('[data-toggle="tooltip"]').each(function () {
          if($(this).is(e.target)){
              $(this).tooltip('show');
          }
          else{
              $(this).tooltip('hide');
          }
          
      });

      $('[data-toggle="popover"]').each(function () {
          if($(this).is(e.target)){
              $(this).popover('show');
          }
          else{
              $(this).popover('hide');
          }
      });
  });
  
</script>
<!-- validator-->
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/jquery.bvalidator.js"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/presenters/default.min.js"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.js"></script>
<link href="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
      var wow = new WOW(
        {
          boxClass:     'wow',  
          animateClass: 'animated', 
          offset:       0,         
          mobile:       false,    
          live:         true,    
          callback:     function(box) {

          },
          scrollContainer: null
        }
      );
      wow.init();
</script>
<!-- number format -->

<script src="<?php echo BACKEND_THEME_URL ?>js/jquery.maskedinput.min.js"></script>
<script>
  $(document).ready(function(){
    $('.phone_number_format').mask("999-999-9999");;
    $('.zip_code').mask("99999");
  });
</script>
<!-- taging script -->
<?php if($this->uri->segment(3) == 'compose_mail'){ ?>
<link href="<?php echo BACKEND_THEME_URL ?>plugin/magicsuggest/magicsuggest-min.css" rel="stylesheet">
 <script src="<?php echo BACKEND_THEME_URL ?>plugin/magicsuggest/magicsuggest-min.js"></script>
 <script type="text/javascript">
 <?php $user_emails=''; $user_emails = all_user_email(); 
  $mails='';
 foreach ($user_emails as  $value) {
    $mails .= "'".$value->email."' ,";
 }
 ?>
   $(document).ready(function() { 
   var ms = $('#ms').magicSuggest({
       data: [<?php echo $mails; ?>],  
       maxSelection: null, 
        });
     });
   </script>
   <?php } ?>
<!-- taging script End-->
<script>
  function confirmBox(msg, url) {
    swal({
        title: msg,
        type: "warning",
        padding: 0,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        background: '#f1f1f1',
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-confirm',
        cancelButtonClass: 'btn btn-cancle',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
        animation: false
    }, function() {
        window.location.href = url;
    });
  }
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>

<script type="text/javascript">
   $(document).ready(function () {
      $('#frm1').validate({
          rules: {
              type: {
                  required: true,
              },
              order_by: {
                    required: true,
                },
              category: {
                    required: true,
                },
              region: {
                    required: true,
                },
          },
      });
   });
</script>
</body>
</html>
<!-- Temparory css for removing tinyMCE Editor footer -->
<style type="text/css">
  #mceu_32-body{
    display: none;
  }
</style>