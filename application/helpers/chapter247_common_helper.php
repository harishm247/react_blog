<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	clear cache
*/
if ( ! function_exists('clear_cache')) {
	function clear_cache(){
		$CI =& get_instance();
		$CI->output->set_header('Expires: Wed, 11 Jan 1984 05:00:00 GMT' );
		$CI->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
		$CI->output->set_header("Cache-Control: no-cache, no-store, must-revalidate");
		$CI->output->set_header("Pragma: no-cache");			
	}
}

if (!function_exists('feedback_subject_status_Api')) {
	function feedback_subject_status_Api($lang,$status = '') {
			if($lang=='ar'){
				$status_array = array(
	      	array('id'=>1,'name'=>'عرض تجريبي مجاني'),
		      array('id'=>2,'name'=>'مشاكل الدفع'),
		      array('id'=>3,'name'=>'مشكلة تقنية'),
		      array('id'=>4,'name'=>'آخر'),
	     	);
			}else{
	     	$status_array = array(
	      	array('id'=>1,'name'=>'Free demo'),
		      array('id'=>2,'name'=>'Payment issues'),
		      array('id'=>3,'name'=>'Technical issues'),
		      array('id'=>4,'name'=>'Other'),
	     	);
			}
     
			if ($status == '')
          return $status_array;
      else
          return element($status, $status_array);
  }
}

if ( ! function_exists('getRow')) {
	function getRow($table='', $data='', $col=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_row($table, $data, $col);		
		if($query)
			return $query;
		else		
			return '';
	}
}

if (!function_exists('country_list')) {
	function country_list() {
      $status_array = json_decode(file_get_contents(base_url().'assets/backend/admin/js/country.json'));
      return $status_array;
     
  }
}


if (!function_exists('phonecodes_list')) {
	function phonecodes_list($id) {
	$status_array = json_decode(file_get_contents(base_url().'assets/backend/admin/js/phonecodes.json'));
	
  return $status_array->$id;
	}
}

if ( ! function_exists('backend_pagination')) {
	function backend_pagination(){
		$data = array();		
		$data['full_tag_open'] = '<ul class="pagination">';		
		$data['full_tag_close'] = '</ul>';
		$data['first_tag_open'] = '<li>';
		$data['first_tag_close'] = '</li>';
		$data['num_tag_open'] = '<li>';
		$data['num_tag_close'] = '</li>';
		$data['last_tag_open'] = '<li>';
		$data['last_tag_close'] = '</li>';
		$data['next_tag_open'] = '<li>';
		$data['next_tag_close'] = '</li>';
		$data['prev_tag_open'] = '<li>';
		$data['prev_tag_close'] = '</li>';
		$data['cur_tag_open'] = '<li class="active"><a href="#">';
		$data['cur_tag_close'] = '</a></li>';
		return $data;
	}					
}

if ( ! function_exists('get_unread_msg_superadmin')) {
	function get_unread_msg_superadmin($message_id=''){	
		$CI =& get_instance();		
		 if($query = $CI->superadmin_model->get_unread_msg($message_id))
		 	return $query;
		 else
		 	return false;
	}
}

if ( ! function_exists('getDataResult')) {
	function getDataResult($table='', $data=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_result($table, $data);		
		if($query)
			return $query;
		else		
			return '';
	}
}


if ( ! function_exists('getDataFormat')) {
	function getDataFormat($data){
		return date("d M, Y H:i A", strtotime($data));
	}
}

if ( ! function_exists('gatDaet')) {
	function gatDaet($data){
		return date("d M, Y", strtotime($data));
	}
}

if(!function_exists('get_contry_by_ip')){
	function get_contry_by_ip($ip)
	{
		$details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));
	
		if(!empty($details))
		{
			if (!property_exists($details, 'geoplugin_countryCode')) {
				return null;
			}
			return array('countryCode'=> $details->geoplugin_countryCode,'country' =>$details->geoplugin_countryName);
		}
		return null;
	}
}

/**
*	thisis  back end helper 
*/
if ( ! function_exists('msg_alert')) {
	function msg_alert(){
	$CI =& get_instance(); ?>
<?php if($CI->session->flashdata('msg_success')): ?>	
	<script>
		$('.notifyjs-corner').empty();
		/*$.notify("<?php //echo $CI->session->flashdata('msg_success'); ?>", "success");*/
	
		$.notify({
			icon: "<?php echo base_url(); ?>/assets/backend/image/alert-icons/alert-checked.svg",
			title: "<strong>Success</strong> ",
			message: "<?php echo $CI->session->flashdata('msg_success'); ?>"			
		},{
			icon_type: 'image',
			type: 'success',
			allow_duplicates: false
		});

	</script>
 <?php endif; ?>
<?php if($CI->session->flashdata('msg_info')): ?>	
	<script>
		$('.notifyjs-corner').empty();
		/*$.notify("<?php //echo $CI->session->flashdata('msg_info'); ?>", "info");*/

		$.notify({
			icon: "<?php echo base_url(); ?>/assets/backend/image/alert-icons/alert-checked.svg",
			title: "<strong>Info</strong> ",
			message: "<?php echo $CI->session->flashdata('msg_info'); ?>"			
		},{
			icon_type: 'image',
			type: 'success',
			allow_duplicates: false
		});

	</script>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_warning')): ?>	
	<script>
		$('.notifyjs-corner').empty();
		$.notify({
				icon: "<?php echo base_url(); ?>/assets/backend/image/alert-icons/alert-danger.svg",
				title: "<strong>Warning</strong> ",
				message: "<?php echo $CI->session->flashdata('msg_warning'); ?>"

			},{
				icon_type: 'image',
				type: 'warning',
				allow_duplicates: false
			});
	</script>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_error')): ?>	
	<script>
		$('.notifyjs-corner').empty();	
		$.notify({
			icon: "<?php echo base_url(); ?>/assets/backend/image/alert-icons/alert-disabled.svg",
			title: "<strong>Error</strong> ",
			message: "<?php echo $CI->session->flashdata('msg_error'); ?>"

		},{
			icon_type: 'image',
			type: 'danger',
			allow_duplicates: false
		});
	 </script>
<?php endif; ?>
	<?php }					
}
/**
*	check superadmin logged in
*/
if ( ! function_exists('superadmin_logged_in')) {
	function superadmin_logged_in(){
		$CI =& get_instance();
		$superadmin_info = $CI->session->userdata('superadmin_info');
		if($superadmin_info['logged_in']===TRUE && $superadmin_info['user_role'] == 0 )
		    return TRUE;
		else
			return FALSE;
		//die;
	}
}
/**
*	get superadmin id
*/
if ( ! function_exists('superadmin_id')) {
	function superadmin_id(){
		$CI =& get_instance();
		$superadmin_info = $CI->session->userdata('superadmin_info');		
			return $superadmin_info['id'];		
	}
}


if ( ! function_exists('superadmin_name')) { 
	function superadmin_name(){
		$CI =& get_instance();
		$superadmin_info = $CI->session->userdata('superadmin_info');
		if($superadmin_info['logged_in']===TRUE )
		 	return $superadmin_info['first_name']." ".$superadmin_info['last_name'];
		else
			return FALSE;
	}					
}
// Created By Prem 
if ( ! function_exists('superadmin_details')) { 
	function superadmin_details(){
		$CI =& get_instance();
		$superadmin_details = $CI->superadmin_model->get_row('users', array('user_id'=>superadmin_id()));
		$superadmin_info = $CI->session->userdata('superadmin_info');
		if($superadmin_info['logged_in']===TRUE )
		 	return $superadmin_details->first_name." ".$superadmin_details->last_name;
		else
			return FALSE;
	}					
}
//

if ( ! function_exists('frontend_pagination')) {
	function frontend_pagination(){
		$data = array();
		$data['full_tag_open'] = '<ul class="pagination">';		
		$data['full_tag_close'] = '</ul>';
		$data['first_tag_open'] = '<li>';
		$data['first_tag_close'] = '</li>';
		$data['num_tag_open'] = '<li>';
		$data['num_tag_close'] = '</li>';
		$data['last_tag_open'] = '<li>';		
		$data['last_tag_close'] = '</li>';
		$data['next_tag_open'] = '<li>';
		$data['next_tag_close'] = '</li>';
		$data['prev_tag_open'] = '<li>';
		$data['prev_tag_close'] = '</li>';
		$data['cur_tag_open'] = '<li class="active"><a href="#">';
		$data['cur_tag_close'] = '</a></li>';
		$data['next_link'] = 'Next';
		$data['prev_link'] = 'Previous';
		return $data;
	}					
}
/**
*	thisis  back end helper 
*/
if ( ! function_exists('msg_alert_front')) {
	function msg_alert_front(){
	$CI =& get_instance(); ?>
	<?php if($CI->session->flashdata('theme_danger')): ?>	
	<div class="alert theme-alert-danger">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
	     <?php echo $CI->session->flashdata('theme_danger'); ?>
	</div>
 <?php endif; ?>
 <?php if($CI->session->flashdata('theme_success')): ?>	
	<div class="alert theme-success">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
	      <?php echo $CI->session->flashdata('theme_success'); ?>
	</div>
 <?php endif; ?>

<?php if($CI->session->flashdata('msg_success')): ?>	
	<div class="alert alert-success">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
	 <?php echo $CI->session->flashdata('msg_success'); ?>
	</div>
 <?php endif; ?>
<?php if($CI->session->flashdata('msg_info')): ?>	
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">&times;</button> 
	   <?php echo $CI->session->flashdata('msg_info'); ?>
	</div>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_warning')): ?>	
	<div class="alert alert-warning">
	
		 <?php echo $CI->session->flashdata('msg_warning'); ?>
	</div>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_error')): ?>	
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button> 
	     <?php echo $CI->session->flashdata('msg_error'); ?>
	</div>
<?php endif; ?>
	<?php }					
}
if(!function_exists('p')){
    function p($data){
        echo '<pre>'; print_r($data); echo '</pre>';
     }
}

if(!function_exists('user_status')){
	function user_status($status=''){
		$status_array= array(
			'1' => 'Active',
      '2' => 'Deactive',
      '3' => 'Banned',
      '4' => 'Pending'             
			);
		return $status_array;
	 }
}
if(!function_exists('status')){
function status($status=''){
		$status_array= array(
			'1' => 'Active',
      '2' => 'Deactive',           
			);
		return $status_array;
	 }
}
if ( ! function_exists('getData')) {
	function getData($table='', $data=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_row($table, array($data[0] => $data[1]));		
		if($query)
			return $query;
		else		
			return '';
	}
}

if ( ! function_exists('siteConfig')) {
	function siteConfig($meta_key=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_row('site_config', array('meta_key' => $meta_key));		
		if($query)
			return $query;
		else		
			return '';
	}
}

if ( ! function_exists('blog_category')){
	function blog_category(){
		$CI =& get_instance();
		$query = $CI->common_model->get_result('blog_category');		
		if($query)
			return $query;
		else		
			return '';
	}
}


if(!function_exists('generatedBreadcrumb')){
        function generateBreadcrumb(){
            $ci=&get_instance();
            $i=2;
            $uri = $ci->uri->segment($i);

            $uri = ucfirst($uri);
            $link='';
            echo  $uri;
            while($uri != ''){
            $prep_link = '';
            
            for($j=2; $j<=$i; $j++){
            $prep_link.=$ci->uri->segment($j).'/';
            }
             $prep_link = ucfirst($prep_link);
            if($ci->uri->segment($i+1)== ''){
                $link.='<li class="active"><a href="'.site_url($prep_link).'">';
                $link.=$ci->uri->segment($i).'</a></li>';
            }else{
                $link.='<li><a href="'.site_url($prep_link).'">';
                $link.=$ci->uri->segment($i).'</a><span class="divider"></span></li>';
            }

            $i++;
            $uri = $ci->uri->segment($i);
            }
            $link .='</ol>';
            return $link;
            }
    }

if ( ! function_exists('create_thumbnail')) {
	function create_thumbnail($config_img='',$img_fix='') {
		$CI =& get_instance();
		$config_image['image_library'] = 'gd2';
		
		$config_image['source_image'] = $config_img['source_path'].$config_img['file_name_source'];	
		//$config_image['create_thumb'] = TRUE;
		$config_image['new_image'] = $config_img['destination_path'].$config_img['file_name'];
		if(isset($config_img['height']) && isset($config_img['width']))
		{
	 	$config_image['height']=$config_img['height'];
		$config_image['width']=$config_img['width'];

		}else{
			$config_image['max_height']=$config_img['max_height'];
			$config_image['max_width']=$config_img['max_width'];
		}

		
		if($img_fix){
		$config_image['maintain_ratio'] = FALSE;
		}
		else{
			$config_image['maintain_ratio'] = TRUE;
			list($width, $height, $type, $attr) = getimagesize($config_img['source_path'].$config_img['file_name_source']);
	        if ($width < $height) {
	        	$cal=$width/$height;
	        	$config_image['width']=$config_img['width']*$cal;
	   
	        }
			if ($height < $width)
			{
				$cal=$height/$width;
		    	$config_image['height']=$config_img['height']*$cal;
			}
		}
		
		$CI->load->library('image_lib');
		$CI->image_lib->initialize($config_image);
	

		if(!$CI->image_lib->resize()) 

			return array('status'=>FALSE,'error_msg'=>$CI->image_lib->display_errors());
		else
	
			return array('status'=>TRUE,'file_name'=>$config_img['file_name']);
			$CI->image_lib->clear();
	}
}


if(!function_exists('doc_type')){
	function doc_type(){
		$doc_type = array(
				array('id'=>1,'name'=>'Passport'),
	      array('id'=>2,'name'=>'Driving Licence'),
	      array('id'=>3,'name'=>'Green Card'),           
			);
		return $doc_type;
  }
}

if(!function_exists('doc_type_admin')){
	function doc_type_admin($id=""){
		$doc_type = array(
			'1' => 'Passport',
      '2' => 'Driving Licence',
      '3' => 'Green Card',           
			);
		if(array_key_exists($id, $doc_type)){
	    return $doc_type[$id];
	  }else{
	    return $doc_type;
	  }
	}	
}

if (!function_exists('feedback_subject_status')) {

    function feedback_subject_status($status = '') {
        $status_array = array(
						'1' => 'Free demo',
            '2' => 'Payment issues',
          	'3' => 'Technical issues',
            '4' => 'Other'
        );
        if ($status == '')
            return $status_array;
        else
            return element($status, $status_array);
    }

}
/*
/**
*	get_social_url
*/
if ( ! function_exists('get_option_url')) {
	function get_option_url($option_name){	
		$CI =& get_instance();		
		 if($query = $CI->common_model->get_row('options',array('option_name'=>$option_name)))
		 	return $query->option_value;
		 else
		 	return false;
	}
}

if(!function_exists('website_type_name')){
	function website_type_name($id=""){
		$doc_type = array(
			// '1' => 'Hotels',
   //    		'2' => 'Travelocity',
      		'3' => 'Expedia',      
      		// '4' => 'Orbitz',
      		// '5' => 'Hotwire',
      		// '6' => 'Airbnb',   
      		'9'	=> 'BookingFlow', 
      		 '7'	=> 'HostelWorld', 
      		'8'	=> 'Flowhaus', 
		);
		if(array_key_exists($id, $doc_type)){
	    return $doc_type[$id];
	  }else{
	    return 0;
	  }
	}	
}

if(!function_exists('website_type_key')){
	function website_type_key($name=""){
		$doc_type = array(
			// '1' => 'Hotels',
   //    		'2' => 'Travelocity',
      		'3' => 'Expedia',      
      		// '4' => 'Orbitz',
      		// '5' => 'Hotwire',
      		// '6' => 'Airbnb',   
      		'9'	=> 'BookingFlow', 
      		'7'	=> 'HostelWorld', 
      		'8'	=> 'Flowhaus', 
		);
		if($key=array_search($name, $doc_type)){
	    return $key;
	  }else{
	    return 8;
	  }
	}	 
}
if(!function_exists('website_type_password')){
	function website_type_password($name=""){
		$doc_type = array(
			'1' => 'hotel@247',
      		'2' => 'Travelo@247',
      		'3' => 'ExpediaFlow',      
      		'4' => 'Orbitz@247',
      		// '5' => 'Hotwire@247',
      		'6' => 'Airbnb@247',   
      		'7'	=> 'HostelworldFlow', 
      		'8'	=> 'Flow@haus247', 
      		'9'	=> 'BookingFlow', 
		);
		if($key=array_search($name, $doc_type)){
	    return $key;
	  }else{
	    return 8;
	  }
	}	 
}


if(!function_exists('website_type')){
	function website_type($name=""){
		return $doc_type = array(
			// '1' => 'Hotels',
   //    		'2' => 'Travelocity',
      		'3' => 'Expedia',      
      		// '4' => 'Orbitz',
      		// '5' => 'Hotwire',
      		// '6' => 'Airbnb',   
      		'9'	=> 'BookingFlow',  
      		'7'	=> 'HostelWorld',
      		'8'	=> 'Flowhaus',  
		);
	}	
}















