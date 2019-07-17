<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/REST_Controller.php";
require APPPATH."third_party/Auth/Authorization.php";

class Api extends REST_Controller {
  private $user;
  private $params;
  private $language;

  public function __construct(){
  	parent::__construct();
  	$this->load->model('api_model');
  	$this->load->library('chapter247_email');
  	//$this->_languageRequest();
 		header("Access-Control-Allow-Headers:X-Requested-With,content-type,Auth-Key,Language,Allow,x-xsrf-token");
		header("Access-Control-Allow-Credentials:TRUE");
		header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
		header('Access-Control-Allow-Origin: *');
		if ($_SERVER["REQUEST_METHOD"] == "OPTIONS"){
	    	$_SERVER["REQUEST_METHOD"] = "POST";
	    	die();
		}
		$this->lang->load('rest_controller', $this->language);
	}

	private function _authRequest($headers = array()){
	  	if (empty($headers)) {
	  		$headers = $this->input->request_headers();
	  	}
	    if (array_key_exists('Auth-Key', $headers) && !empty($headers['Auth-Key'])) {
	    	$key = str_replace('Bearer ', '', $headers['Auth-Key']);
		    $decodedToken = AUTHORIZATION::validateToken($key);
		    if ($decodedToken != false) {
		      $this->user = $decodedToken;
		    }else{
		      $this->response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
	    		die();
		    }
		}else{
		    $this->response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
	    	die();
		}
	}

	private function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);
	}

	public function signup_post(){ 
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
		$this->form_validation->set_rules('mobile_no', 'Mobile No.', 'trim|required');
		$this->form_validation->set_rules('password','Password', 'trim|required|min_length[6]|max_length[20]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password','Confirm Password', 'trim|required');
		
		try {
			if ($this->form_validation->run() == False)	{
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error'	;
				$list = json_encode($data);
			 	throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}

         	$ip=$this->input->ip_address();
         	if($ip=='192.168.2.121') $ip='111.118.248.118';
			//$val = get_contry_by_ip($ip);
			$salt=$this->salt();
			$user_data  = array(
				'first_name'	=>	$this->input->post('full_name'),
				'user_name'	=>  $this->input->post('full_name'),
				'email'		=>	$this->input->post('email'),
				'password' => sha1($salt.sha1($salt.sha1($this->input->post('password')))),
				'status' => 1,
				'salt'=>$salt,
				'is_verified' => 0,
				'created'	=> date('Y-m-d h:i:s'),
				'created_ip'		=>	$this->input->ip_address(),
				"is_recieve_email" => 1
			);
			if(!$user_id =$this->api_model->insert('users', $user_data)){
			
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$this->api_model->update('users',array('last_ip' => $this->input->ip_address(), 'last_login' => date('Y-m-d h:i:s')),array('user_id'=>$user_id));


			/******************Send email for user *************************/
			$this->chapter247_email->set_language('en');
    	    $this->chapter247_email->set_email_templates(1);
    	    $email_template=$this->common_model->get_email('en',1);
			$param = array(
				"template"=>array(
					"var_name" => array(
						"user_name" => $this->input->post('first_name').' '.$this->input->post('last_name'),
						"email" => $this->input->post('email'),
						"password" => $this->input->post('password'),
					),
					"temp" => $email_template->template_body,

				),
				"email" => array(
					"to"        =>   $this->input->post('email'),
					"from"      =>   SUPPORT_EMAIL,
					"from_name" =>   NO_REPLY_EMAIL_FROM_NAME,
					"subject"   =>  $email_template->template_subject,
				)
			);
			$status = $this->chapter247_email->send_mail($param);
    		/********** End for user email   **********/

    		$user_info = $this->api_model->get_row('users',array('email'=>$this->input->post('email')));
			if(empty($user_info)){
					$userD['email']  =  $this->input->post('email');
					$userD['created_at']=  date('Y-m-d H:i:s');
					$userD['user_ip']  =  $this->input->ip_address();
					$this->api_model->insert('users', $userD);
			}
	    	$user_val  = array(
				'id' 			=> $user_id,
				'first_name'	=>	$this->input->post('first_name'),
				'last_name'	=>  $this->input->post('last_name'),
				'email'		=>	$this->input->post('email')
			);
	        $data['token'] = AUTHORIZATION::generateToken($user_val);
			$data['user'] = $user_val;
			$data['status']=True;
			$data['message'] = 'User sign up successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}

	public function login_post(){
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('email', $this->lang->line('email'), 'required|valid_email',array('required'=> $this->lang->line('required'),'valid_email'=> $this->lang->line('valid_email')));
		try {
			if ($this->form_validation->run() == False)	{
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error'	;
				$list = json_encode($data);
				
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}

			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			$val      = $this->api_model->login($email,$password);

			if(!empty($val) && $val['status']== 1){
				$output['token'] = AUTHORIZATION::generateToken($val['user']);
				$output['user'] = $val['user'];
				$profile_image=$this->api_model->get_row('users',array('user_id'=>$val['user']['id']),array('profile_thumbnail_small'));
				if(!empty($profile_image->profile_thumbnail_small))
					$output['profile_image'] = base_url($profile_image->profile_thumbnail_small);
				else
					$output['profile_image'] = base_url('assets/frontend/img/user.svg');

				$output['status'] = true;				
				$output['message'] = 	'Login Successful';
				$this->set_response($output, REST_Controller::HTTP_OK);
				$this->api_model->update('users',array('last_ip' => $this->input->ip_address(),
							'last_login' => date('Y-m-d h:i:s')),array('user_id'=>$val['user']['id']));
			}else{ 
				$data['message'] = 	$val['error_message'];
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}


	public function check_profile($str){
  		if(empty($_FILES['profile_image']['name'])){
			$this->form_validation->set_message('check_profile', 'Choose Image');
		   return FALSE;
		}
		if(!empty($_FILES['profile_image']['name'])):
			$config['upload_path'] = './assets/uploads/users';
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['max_width']  = '5200';
			$config['max_height'] = '6000';
			$config['min_width']  = '260';
			$config['min_height'] = '300';
			$config['file_name']  = $this->salt();
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('profile_image')){
				$this->form_validation->set_message('check_profile', strip_tags($this->upload->display_errors()));
				return FALSE;
			}else{
				$fileData = $this->upload->data();
				$config_imgp['source_path']      	= './assets/uploads/users/';
				$config_imgp['destination_path'] 	= './assets/uploads/users/thumbnail/';
				$config_imgp['width']            	= '260';
				$config_imgp['height']           	= '300';
				$config_imgp['file_name_source'] 	= $fileData['file_name'];
				$config_imgp['file_name'] 				= $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
				$thumbnail  = create_thumbnail($config_imgp);
				$config_imgs['source_path']      = './assets/uploads/users/thumbnail/';
				$config_imgs['destination_path'] = './assets/uploads/users/thumbnail_small/';
				$config_imgs['width']            = '100';
				$config_imgs['height']           = '100';
				$config_imgs['file_name_source'] = $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
				$config_imgs['file_name'] 			 = $fileData['raw_name'].'-thumbnail-small'.$fileData['file_ext'];
				$thumbnail_small  = create_thumbnail($config_imgs);
				$this->session->set_userdata('check_profile',array('image'=>'assets/uploads/users/'.$fileData['file_name'],'thumbnail'=>'assets/uploads/users/thumbnail/'.$thumbnail['file_name'],'thumbnail_source'=>'assets/uploads/users/thumbnail_small/'.$thumbnail_small['file_name']));
				return TRUE;
			}
		else:
			$this->form_validation->set_message('check_profile', 'The %s field required');
			return FALSE;
		endif;
    } 
	
	/*****************************
	Blog Article
	*****************************/
	public function blog_list_get(){
		
		$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
		$per_page = isset($_GET['limit']) ? $_GET['limit'] : 10;
		$searchString	= null;
		if(isset($_GET['search'])){
			$searchString	= trim($this->input->get('search'));
			$category	= trim($this->input->get('category'));
		}
		$category = null;
		if(isset($_GET['type'])){
			$category	= trim($this->input->get('type'));
		}
		$data['blog'] = $this->api_model->blog($offset,$per_page,null,$searchString, false,$category);
		$data['total_rows'] = $this->api_model->blog(0,0,null,$searchString,true,$category);
		$data['message'] ='Blog List';
		$data['status']=True;
		$this->set_response($data, REST_Controller::HTTP_OK);
	} 


	private function generate_login_token($user) {
		$user_val  = array(
	    	'id' 			=> $user['user_id'],
				'first_name'	=>	$user['first_name'],
				'last_name'	=>  $user['last_name'],
				'email'		=>	$user['email']
			);
	    return AUTHORIZATION::generateToken($user_val);
	}
	
	public function email_check($str='',$id=''){
   		$user =$this->api_model->get_row('users',array('email'=>$str));
		if(!empty($user->email)):
			$this->form_validation->set_message('email_check', 'The %s address already exists.');
		   return FALSE;
		else:
		   return TRUE;
		endif;
	}


	public function forgot_password_post(){
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		try {
			if ($this->form_validation->run() == False)	{
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error'	;
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$email = $this->input->post('email');
			$user =$this->api_model->get_row('users',array('email'=>$email,'user_role'=>1,'status!='=>2));
			if(empty($user))
			{	$data['message'] = "Your email address isn't register.";
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}

	    	if(!empty($user)){

			    $tokenData['id'] = uniqid();
			    $tokenData['name'] = $user->first_name;
			    $tokenData['email'] = $user->email;
			    $tokenData['date'] = date('Y-m-d h:i:s');
			    $token = AUTHORIZATION::generateToken($tokenData);

		      	$updateResult = $this->api_model->update('users',array('reset_token'=>$token),array('user_id'=>$user->user_id));
		      	//$url = FRONTEND_URL.'#/auth/reset-password?token='.$token;
		      	$url =  'http://localhost:4200/#/auth/reset-password?token='.$token;
		      	if($updateResult){

		      		/******************Send email*************************/
		      		$this->chapter247_email->set_language($this->language);
			    	$this->chapter247_email->set_email_templates(2);
					$param = array(
						"template"=>array(
							"var_name" => array(
								"user_name" => $user->first_name.' '.$user->last_name,
								"reset_link"=>$url,
								"site_name"=> SHOW_SITE_NAME,
							),
							"temp" =>'Demo'
						),
						"email" => array(
							"to"        =>   $user->email,
							"from"      =>   SUPPORT_EMAIL,
							"from_name" =>   NO_REPLY_EMAIL_FROM_NAME,
							"subject"   => 'Reset Password'
							),
							"email_body_template" => "Reset password Link"
					);
					$status = $this->chapter247_email->send_mail($param);
		    		/*****************************************************/
					$data['message'] ='Password reset instructions has been sent to '.$user->email.'. Don\'t forget to check your spam and junk folders if it doesn\'t show up.';
						$this->set_response($data, REST_Controller::HTTP_OK);
			    }
		    }
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		
	}

	public function reset_password_check_post(){
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		try {
			if ($this->form_validation->run() == False){
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$reset_token = $this->input->post('token');
			$user =$this->api_model->get_row('users',array('reset_token'=>$reset_token,'status!='=>2));
			if(empty($user))
			{	$data['status']  = False;
				$data['message'] = 'Your token is incorrect';
				$list = json_encode($data); 	
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}

	    	if(!empty($user)){
	  			$key = str_replace('Bearer ', '', $this->input->post('token'));
	    		$decoded_token = AUTHORIZATION::validateToken($key);
	    		$my_date_time =  date("Y-m-d H:i:s", strtotime($decoded_token->date."+2 hours"));
	    		if(date("Y-m-d H:i:s") > $my_date_time){
	    			$data['status'] = False;
	    			$data['message'] ='Your token has been expired';
	    		}else{
	    			$data['status'] = True;
	    			$data['message'] ='valid token';
	    		}
				$this->set_response($data, REST_Controller::HTTP_OK);
			}
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		
	}


	public function reset_password_post(){

		$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[6]');
 		$this->form_validation->set_rules('confirm_password','Confirm Password', 'trim|required|min_length[6]|matches[password]');
 		$this->form_validation->set_rules('token', 'Token', 'trim|required');

 		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
			$reset_token = $this->input->post('token');
			$user =$this->api_model->get_row('users',array('reset_token'=>$reset_token,'status!='=>2));
			if(empty($user))
			{	
				$data['message'] = 'Sorry! Password updation process has been failed. Please try again';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}

	    	if(!empty($user)){
					$updateResult = $this->api_model->update('users',array('password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),'reset_token'=>''),array('user_id'=>$user->user_id));
					/******************Send email*************************/
				$this->chapter247_email->set_language($this->language);
		    	$this->chapter247_email->set_email_templates(3);
					$param = array(
						"template"=>array(
							"var_name" => array(
								"user_name" => trim($user->first_name.' '.$user->last_name),
								"url"=> FRONTEND_URL
							)
						),
						"email" => array(
							"to"        =>   $user->email,
							"from"      =>   SUPPORT_EMAIL,
							"from_name" =>   NO_REPLY_EMAIL_FROM_NAME
						)
					);
					$status = $this->chapter247_email->send_mail($param);
		    	/*****************************************************/
					$data['message'] ='Password updated successfully';
				$this->set_response($data, REST_Controller::HTTP_OK);
			}
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		
	} 
 
	/************************
	   Blog Article
	*************************/  
	public function my_blogs_get(){
		$this->_authRequest();
		$user = $this->user;	
		$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
		$per_page = isset($_GET['limit']) ? $_GET['limit'] : API_PER_PAGE;
		$searchString	=  null;
		if(isset($_GET['search'])){
			$searchString	= trim($this->input->get('search'));
		}
		$category = null;
		if(isset($_GET['category'])){
			$category	= trim($this->input->get('category'));
		}
		$data['blog'] = $this->api_model->blog($offset,$per_page,$user->id,$searchString, false,$category);
		$data['total_rows'] = $this->api_model->blog(0,0,$user->id,$searchString,true,$category);	
		$data['message'] ='Blog List';
		$this->set_response($data, REST_Controller::HTTP_OK);
 	}

	public function blogs_detail_get($blog_id=''){
		$this->_authRequest();
		//$blog_id = isset($_GET['blog_id']) ? $_GET['blog_id'] : null;
		$slug = isset($_GET['slug']) ? $_GET['slug'] : null;
		try{ 
			if(empty($blog_id) ){
	 			throw new Exception('No Detail Found', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$detail = $this->api_model->blogs_detail(null,$blog_id);
			//echo $this->db->last_query();die;
			if (empty($detail))	{
				 throw new Exception('No Detail Found', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$detail->date = date("m/d/Y", strtotime($detail->date)); 
			$data['Detail'] = $detail;
			$data['blog_type'] = $this->api_model->get_result('fh_blog_article_type',array('status'=>1),array('blog_article_id','type'),array('order_by','asc'));
			$data['message'] = 'Details';
			$data['status']=true;
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	} 

	public function delete_blog_get($blog_id=0){ 
		$this->_authRequest();
		$user = $this->user;

		if(empty($blog_id) && $blog_id < 1){
 			throw new Exception('No blog id Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		$delete = $this->api_model->delete('fh_blog_articles',array('blog_id'=>$blog_id));
		
		try{
			if ($delete!=1){
				 throw new Exception('Invalid id', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['status']=true;
			$data['message'] = 'Blog deleted successfully';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	}
	
   /**************************
	Created By: Abhilasha - Chapter247
	Created At: 03-11-2018 10:00 AM
	M:Rohit Agrawal 12-13-2018 :11:06 AM
	**************************/
	//add edit blog post
	public function image_upload($image,$path){
		$array = explode(";base64," ,$image);
		$imageExt = str_replace('data:image/', '', $array[0]);
		$base64string = str_replace(' ', '+', $array[1]);
		$data = base64_decode($base64string);
		$file_name=uniqid() . ".".$imageExt;
		$file ='./'.$path.$file_name;
		$success = file_put_contents($file, $data);
	    $target_path = './assets/uploads/';
	    $config_manip = array(
	        'image_library' => 'gd2',
	        'source_image' => $file,
	        'new_image' => './'.$path.'thumbnail/',
	        'maintain_ratio' => FALSE,
	        'create_thumb' => TRUE,
	        'thumb_marker' => '',
	        'height' => 100,
	        'width' => 100
	    );
	    $this->load->library('image_lib', $config_manip);
	    $this->image_lib->resize();
 		return	$file_name;
	}

	public function add_blog_post(){  
		$this->_authRequest();
		$user = $this->user; 
		$this->form_validation->set_rules('type','Blog Article Type Id','required');
     	$this->form_validation->set_rules('blog_title','Blog Title','required');
        $this->form_validation->set_rules('order_by','Order By','numeric');
        $update_image_status=false;
        if($this->input->post('blog_id')!==null)
        {
        	$row= $this->api_model->get_row('fh_blog_articles',array('blog_id'=>$this->input->post('blog_id')),array('cover_photo','cover_photo_thumbnail'));
        	if($row->cover_photo=='')
        		$update_image_status=TRUE;
        }
        if($this->input->post('blog_id')==NULL || $update_image_status ||  !empty($_POST['cover_photo'])){
       		$this->form_validation->set_rules('cover_photo', 'Cover Photo', 'required');
       	}
        try {
			if ($this->form_validation->run() == False)	{
				$data['status']  = False;
				$data['error']   = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
            $data=array(
               'user_id'        		=> $user->id,
               'type_other'				=> $this->input->post('type_other'),
               'order_by'				=> $this->input->post('order_by'),
               'blog_article_type_id'   => $this->input->post('type'),
               'date'					=> date("Y-m-d", strtotime($this->input->post('date'))),
               'blog_title'     		=> $this->input->post('blog_title'),
               'url'  					=> $this->input->post('url'),
               'blog_tag'       		=> $this->input->post('blog_tag'),
       		);
            $path='assets/uploads/blog/';
      		if(!empty($_POST['cover_photo'])):
      			$image_name=$this->image_upload($_POST['cover_photo'],$path);
			   	$data['cover_photo']  = $path.$image_name;  
		      	$data['cover_photo_thumbnail']  = $path.'thumbnail/'.$image_name; 
	    	endif;
     	    if($this->input->post('blog_id')!==null){
     			if(isset($_FILES['cover_photo']['name'])  && $_FILES['cover_photo']['name']!=''){
				if($row->cover_photo!='' && file_exists(FCPATH.$row->cover_photo)) unlink(FCPATH.$row->cover_photo);
     			if($row->cover_photo_thumbnail!='' && file_exists(FCPATH.$row->cover_photo_thumbnail))unlink(FCPATH.$row->cover_photo_thumbnail);
	     	}
      		$data['updated']  = date('Y-m-d H:i:s');
       		if(!$this->api_model->update('fh_blog_articles',$data,array('user_id' => $user->id,'blog_id'=> $this->input->post('blog_id')))){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
	   		$data['status']  = TRUE;
			$data['message'] = 'Article updated successfully.'; 
      	}else{
      		$data['slug'] = $this->api_model->create_unique_slug($this->input->post('blog_title'), 'fh_blog_articles');
      		$data['created']  = date('Y-m-d H:i:s');
        	if(!$this->api_model->insert('fh_blog_articles', $data)){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$data['status']  = TRUE;
			$data['message'] = 'Article added successfully. It will be publish once admin review it.';
		}		
		$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		

	}
	

	public function check_image($str,$is_image=1){
	   	if(!isset($_FILES['cover_photo'])){
			$this->form_validation->set_message('check_image', 'Please select cover image');
		   return FALSE;
		}
		if(!empty($_FILES['cover_photo']['name'])):
			$config['upload_path']   = './assets/uploads/blog';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_width']     = '5200';
			$config['max_height']    = '6000';
			$config['min_width']     = '260';
			$config['min_height']    = '300';
			$config['file_name']     = $this->salt();
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('cover_photo')){
				$this->form_validation->set_message('check_image', strip_tags($this->upload->display_errors()));
				return FALSE;
			}else{
				$fileData = $this->upload->data();
				$config_imgp['source_path']      = './assets/uploads/blog/';
				$config_imgp['destination_path'] = './assets/uploads/blog/thumbnail/';
				$config_imgp['width']            = '260';
				$config_imgp['height']           = '300';
				$config_imgp['file_name_source'] = $fileData['file_name'];
				$config_imgp['file_name'] 		 = $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
				$thumbnail  = create_thumbnail($config_imgp);
					
				$this->session->set_userdata('check_image',array('image'=>'assets/uploads/blog/'.$fileData['file_name'],'thumbnail'=>'assets/uploads/blog/thumbnail/'.$thumbnail['file_name']));
				return TRUE;
			}
		else:
			$this->form_validation->set_message('check_image', 'The %s field required');
			return FALSE;
		endif;
	}
   	
   
	/*******************
	    SECTION:Common
	********************/    	
	public function check_img($str,$param){
        $param=explode(',',$param);
        $name= $param[0];
        $url=$param[1];
        //echo $name;die;
	   	if(!isset($_FILES[$name])){
			//if(empty($_FILES['cover_photo']['name'])){
			$this->form_validation->set_message('check_img', 'Please select image');
		   return FALSE;
		}
		if(!empty($_FILES[$name]['name'])):
			$config['upload_path']   = '.'.$url.'/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_width']     = '5200';
			$config['max_height']    = '6000'; 
			$config['min_width']     = '260';
			$config['min_height']    = '300';
			$config['file_name']     = $this->salt();
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($name)){
				$this->form_validation->set_message('check_img', strip_tags($this->upload->display_errors()));
				return FALSE;
			}else{
				$fileData = $this->upload->data();
				$config_imgp['source_path']      = '.'.$url.'/';
				$config_imgp['destination_path'] = '.'.$url.'/thumbnail/';
				$config_imgp['width']            = '260';
				$config_imgp['height']           = '300';
				$config_imgp['file_name_source'] = $fileData['file_name'];
				$config_imgp['file_name'] 		 = $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
				$thumbnail  = create_thumbnail($config_imgp);
			
				$this->session->set_userdata('check_img',array('image'=>$url.'/'.$fileData['file_name'],'thumbnail'=>$url.'/thumbnail/'.$thumbnail['file_name']));
				return TRUE;
			}
		else:
			$this->form_validation->set_message('check_img', 'The %s field required');
			return FALSE;
		endif;
	}

	public function valid_url($str){
	   return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
	}


   	public function update_email($email,$id){
		$user_info = $this->api_model->get_row('users',array('email'=>$email,'user_id!='=>$id),array('email'));
		if(empty($user_info)){
			return TRUE;
		}else{
			$this->form_validation->set_message('update_email', 'Email id already exists');
			return FALSE;
		}
	}

	public function change_password_post(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required|callback_password_check['.$user->id.']');
			$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required');
			$this->form_validation->set_rules('confirm_password','Confirm Password', 'trim|required|matches[newpassword]');
		
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$user_info = $this->api_model->get_row('users',array('user_id'=>$user->id),array('password','salt'));
			$user_data  = array('password' => sha1($user_info->salt.sha1($user_info->salt.sha1($_POST['newpassword']))));
			if($this->api_model->update('users',$user_data,array('user_id'=>$user->id))){
				$data['message'] = 'Password has been updated successfully';
				$data['status']=True;
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_OK);
			}else{
				$data['message'] = 'Sorry! Password updation process has been failed. Please try again';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}

	public function password_check($oldpassword,$id){
		$user_info = $this->api_model->get_row('users',array('user_id'=>$id),array('password','salt'));
		$oldpassword=sha1($user_info->salt.sha1($user_info->salt.sha1($oldpassword)));
		if ($oldpassword===$user_info->password)
		{
			return TRUE;
		}else{
			$this->form_validation->set_message('password_check', 'The %s does not match');
			return FALSE;
		}
	}


	/**************************
		My Videos
	**************************/
	public function my_videos_list_get(){ 
		$this->_authRequest();
		$user=$this->user;
		
		$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
		$per_page = isset($_GET['limit']) ? $_GET['limit'] : 10;
		$data['my_videos'] = $this->api_model->my_videos($offset,$per_page,$user->id);
  
		try {
			$data['total_rows'] = $this->api_model->my_videos(0,0,$user->id);
			$data['status']=true;
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
	}

	public function my_video_fetch_get($v_id=0){
		$this->_authRequest();
		$user=$this->user;
		$val="(case when (cover_photo = NULL || cover_photo = '') then cover_photo else (CONCAT('".base_url()."',cover_photo)) end) as cover_photo";
		$va_to="(case when (cover_photo_thumbnail = NULL || cover_photo_thumbnail = '') then cover_photo_thumbnail else (CONCAT('".base_url()."',cover_photo_thumbnail))  end) as cover_photo_thumbnail";
		$data['my_video'] = $this->api_model->get_row('fh_videos',array('v_id'=>$v_id),array('v_id','user_id','title','date','url','tags_and_keywords','created',$val,$va_to,'DATE_FORMAT(updated, "%m/%d/%Y %H:%i:%S") as updated'));
		try {
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
	}


	public function add_my_videos_post(){   
		$this->_authRequest();
		$user = $this->user; 
			
		$this->form_validation->set_rules('video_title','Video Title','required');
		$this->form_validation->set_rules('date','Date','required');
		$this->form_validation->set_rules('url','Url','required|callback_valid_url');
		$this->form_validation->set_rules('video_tags','Video Tags','required');
		$this->form_validation->set_rules('order_by','Order By','numeric');
		$update_image_status=FALSE;
		if($this->input->post('v_id')!==null){
			$row= $this->api_model->get_row('fh_videos',array('v_id'=>$this->input->post('v_id')),array('cover_photo','cover_photo_thumbnail'));
			if($row->cover_photo=='')
				$update_image_status=TRUE;
		}
	    if(($this->input->post('v_id')==NULL && !empty($_FILES['cover_photo']['name'])) || $update_image_status){
	        $this->form_validation->set_rules('cover_photo', 'Cover photo', 'required');
	    }
	     
	    try {
			if ($this->form_validation->run() == False)	{
				$data['status']  = False;
				$data['error']   = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
	       
	        $data=array(
	           'user_id'        		=> $user->id,
	           'title'          		=> $this->input->post('video_title'),
	           'order_by'          		=> $this->input->post('order_by'),
	           'date'     	    		=> date("Y-m-d", strtotime($this->input->post('date'))),
	           'url'  					=> $this->input->post('url'),
	           'tags_and_keywords'     	=> $this->input->post('video_tags'),
	        );

	       	$path='assets/uploads/my_videos/';
			if(!empty($_POST['cover_photo'])):
				$image_name=$this->image_upload($_POST['cover_photo'],$path);
				$data['cover_photo']  = $path.$image_name;  
				$data['cover_photo_thumbnail']  = $path.'thumbnail/'.$image_name; 
			endif;   
	    
	     	if($this->input->post('v_id')!==null){
	     		if(isset($_FILES['cover_photo']['name'])  && $_FILES['cover_photo']['name']!=''){
		     		if($row->cover_photo!='' && file_exists(FCPATH.$row->cover_photo))unlink(FCPATH.$row->cover_photo);
		     		if($row->cover_photo_thumbnail!='' && file_exists(FCPATH.$row->cover_photo_thumbnail))unlink(FCPATH.$row->cover_photo_thumbnail);
		       	}

		       	$data['updated']  = date('Y-m-d H:i:s');
		       	if(!$this->api_model->update('fh_videos',$data,array('user_id' => $user->id,'v_id'=> $this->input->post('v_id')))){
					throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
				$data['status']  = true;
			   	$data['message'] = 'Video updated successfully.'; 
	      	}else{
	      		$data['created']  = date('Y-m-d H:i:s');
	        	if(!$this->api_model->insert('fh_videos', $data)){
					throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
				$data['status']  = true;
				$data['message'] = 'Video added successfully. It will be publish once admin review it.';
			}		
		$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		
	}

	public function delete_my_videos_get($v_id=0){ 
		$this->_authRequest();
		$user = $this->user;

		if(empty($v_id) && $v_id < 1){
 			throw new Exception('No Video Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		$delete = $this->api_model->delete('fh_videos',array('v_id'=>$v_id));
		
		try{
			if ($delete!=1){
				 throw new Exception('Invalid id', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['status']=true;
			$data['message'] = 'Video deleted successfully';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	}

	/**************************
		My Social Media
	**************************/

	public function my_social_media_fetch_get($user_id=0){
		$this->_authRequest();
		$user=$this->user;
		
		$data['social_media'] = $this->api_model->get_row('fh_social_media',array('user_id'=>$user->id));
		
		
		try {
			// if (empty($data['blog_type']))	{
			// 	 throw new Exception('No Influencer type found', REST_Controller::HTTP_BAD_REQUEST);	
			// } 
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
	}


	public function add_my_social_media_post(){  
		$this->_authRequest();
		$user = $this->user; 
	
	$this->form_validation->set_rules('instagram','Instagram','required|callback_valid_url');	
    $this->form_validation->set_rules('facebook','Facebook','required|callback_valid_url');
    $this->form_validation->set_rules('twitter','Twitter','required|callback_valid_url');
    $this->form_validation->set_rules('youtube','Youtube','required|callback_valid_url');
    $this->form_validation->set_rules('pinterest','Pinterest','required|callback_valid_url');
    $this->form_validation->set_rules('linkedin','Linkedin','required|callback_valid_url');
    $this->form_validation->set_rules('spotify','Spotify','required|callback_valid_url');	

    $this->form_validation->set_rules('facebook_followers','Facebook Followers','required');
    $this->form_validation->set_rules('twitter_followers','Twitter Followers','required');
    $this->form_validation->set_rules('youtube_subscribers','Youtube Subscribers','required');
    $this->form_validation->set_rules('pinterest_followers','Pinterest Followers','required');
    $this->form_validation->set_rules('total_reach','Total reach','required');

         
    try {
		if ($this->form_validation->run() == False)	{ 
			$data['status']  = False;
			$data['error']   = 	$this->form_validation->error_array();
			$data['message'] = 'validation error';
			$list = json_encode($data);
			throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
		}
       
     	$data=array(
           'user_id'        => $user->id,
           'instagram'      => $this->input->post('instagram'),
           'facebook'       => $this->input->post('facebook'),
           'twitter'     	=> $this->input->post('twitter'),
           'youtube'  	    => $this->input->post('youtube'),
           'pinterest'     	=> $this->input->post('pinterest'),
           'linkedin'     	=> $this->input->post('linkedin'),
           'spotify'      	=> $this->input->post('spotify'),
           'facebook_followers'      => $this->input->post('facebook_followers'),
           'twitter_followers'     	 => $this->input->post('twitter_followers'),
           'youtube_subscribers'  	 => $this->input->post('youtube_subscribers'),
           'pinterest_followers'     => $this->input->post('pinterest_followers'),
           'total_reach'     	     => $this->input->post('total_reach'),
      	);

      	
    
     	if($this->input->post('sm_id')!==null){
 
       		if(!$this->api_model->update('fh_social_media',$data,array('user_id' => $user->id,'sm_id'=> $this->input->post('sm_id')))){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
	   		$data['message'] = 'Social Media updated successfully.'; 
      	}else{
      	
        	if(!$this->api_model->insert('fh_social_media', $data)){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$data['message'] = 'Social Media added successfully.';
		}	

		$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		

	}

	public function delete_my_social_media_delete($user_id=0){ 
		$this->_authRequest();
		$user = $this->user;

		if(empty($user->id) && $user->id < 1){
 			throw new Exception('No Social Media Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		$delete = $this->api_model->delete('fh_social_media',array('user_id'=>$user->id));
		
		try{
			if ($delete!=1){
				 throw new Exception('Invalid id', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['status']=true;
			$data['message'] = 'Social Media deleted successfully';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	}

	public function change_status_get($blog_id=0){ 
		$this->_authRequest();
		$user = $this->user;

		if(empty($blog_id) && $blog_id < 1){
 			throw new Exception('Article id is not Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		$delete = $this->api_model->update('fh_blog_articles',array('status'=>2),array('blog_id'=>$blog_id));
		
		try{
			if ($delete!=1){
				 throw new Exception('Invalid id', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['status']=true;
			$data['message'] = 'Article deleted successfully';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	}

	/*********************
	  Change Status
	**********************/
	public function all_change_status_get(){
	    $this->change_status($_GET['t'],$_GET['c'],$_GET['id'],$_GET['status'],$_GET['m']);
	}


	public function change_status($table_name,$column_name,$value,$status,$text){ 
		$this->_authRequest();
		$user = $this->user;
    
		if(empty($value) || $value < 0){
 			throw new Exception('No '.$text.' id Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		$change_status = $this->api_model->update($table_name,array('status'=>$status),array($column_name=>$value,'user_id'=>$user->id));
		
		try{
			if ($change_status!=1){
				 throw new Exception('Invalid id', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['status']=true;
			$data['message'] = $text.' Status have been changed successfully';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	}

 	/* rohit 11-16-2018 */ 
 	public function remove_image_get(){
   		$this->remove_images($_GET['t'],$_GET['c'],$_GET['id']);
	}
 	public function remove_images($table_name,$column_name,$value){ 
		$this->_authRequest();
		$user = $this->user; 
    
		if(empty($value) || $value < 0){
 			throw new Exception('No '.$_GET['c'].' Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		if($table_name=='users'){
			$data_photo = $this->api_model->get_row($table_name,array('user_id'=>$user->id),array('profile_image','profile_thumbnail','profile_thumbnail_small'));
			if(!empty($data_photo))
			{
				if($data_photo->profile_image!='' && file_exists(FCPATH.$data_photo->profile_image))
					unlink(FCPATH.$data_photo->profile_image);
				if($data_photo->profile_thumbnail!='' && file_exists(FCPATH.$data_photo->profile_thumbnail))
					unlink(FCPATH.$data_photo->profile_thumbnail);
				if($data_photo->profile_thumbnail_small!='' && file_exists(FCPATH.$data_photo->profile_thumbnail_small))
					unlink(FCPATH.$data_photo->profile_thumbnail_small);
				$image=array(
					'profile_image'=>'',
					'profile_thumbnail'=>'',
					'profile_thumbnail_small'=>''
				);
				$change_status = $this->api_model->update($table_name,$image,array('user_id'=>$user->id));	
			}
		}else if($table_name=='fh_videos'  || $table_name=='fh_shop' || $table_name=='fh_blog_articles'){
			$data_photo = $this->api_model->get_row($table_name,array($column_name=>$value,'user_id'=>$user->id),array('cover_photo','cover_photo_thumbnail'));
			if(!empty($data_photo))
			{
				if($data_photo->cover_photo!='' && file_exists(FCPATH.$data_photo->cover_photo))
					unlink(FCPATH.$data_photo->cover_photo);
				if($data_photo->cover_photo_thumbnail!='' && file_exists(FCPATH.$data_photo->cover_photo_thumbnail))
					unlink(FCPATH.$data_photo->cover_photo_thumbnail);
				$image=array(
					'cover_photo'=>'',
					'cover_photo_thumbnail'=>''
				);
				$change_status = $this->api_model->update($table_name,$image,array($column_name=>$value,'user_id'=>$user->id));	
			}
		}else{
			$data_photo = $this->api_model->get_row($table_name,array($column_name=>$value,'user_id'=>$user->id),array('photo','photo_thumbnail'));
			if(!empty($data_photo))
			{
				if($data_photo->photo!='' && file_exists(FCPATH.$data_photo->photo))
					unlink(FCPATH.$data_photo->photo);
				if($data_photo->photo_thumbnail!='' && file_exists(FCPATH.$data_photo->photo_thumbnail))
					unlink(FCPATH.$data_photo->photo_thumbnail);
				$image=array(
					'photo'=>'',
					'photo_thumbnail'=>'',
				);
				$change_status = $this->api_model->update($table_name,$image,array($column_name=>$value,'user_id'=>$user->id));	
			}
		}
		
		try{
			
			$data['status']=true;
			$data['message'] = 'Status of '.$_GET['c'].' pdated successfully';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	}


	/* R.A 12-06-2018 Profile Section */
	public function user_profile_get(){
		$this->_authRequest();
		$user = $this->user;
		$val="(case when (profile_image = NULL || profile_image = '') then profile_image else (CONCAT('".base_url()."',profile_image)) end) as profile_image";
		$va_to="(case when (profile_thumbnail = NULL || profile_thumbnail = '') then profile_thumbnail else (CONCAT('".base_url()."',profile_thumbnail))  end) as profile_thumbnail";
		$data['user'] = $this->api_model->get_row('users',array('user_id'=>$user->id),array('user_id','first_name','last_name','email',$val,$va_to));
		try {
		if (empty($data['user']))	{
			$type['message'] = 'No User Found';
			$list = json_encode($type);
			throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
		}
			$data['message'] = 'User Infomation';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
	}


	public function update_profile_post(){
		$this->_authRequest();
		$user = $this->user;
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|callback_update_email['.$user->id.']');
		/*if(!empty($_FILES) && $_FILES['profile_image']!='')
			$this->form_validation->set_rules('profile_image', 'Profile Image', 'required');*/

		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$user_data  = array(
				'first_name'	=>	$this->input->post('full_name'),
				'email' 		=>	$this->input->post('email'),
				'created'		=>	$this->input->ip_address(),
				'modified'		=>  date('Y-m-d h:i:s'),
			);

			$path='assets/uploads/users/';
			if(!empty($_POST['profile_image'])):
				$image_name=$this->image_upload($_POST['profile_image'],$path);
				$user_data['profile_image']  = $path.$image_name;  
				$user_data['profile_thumbnail']  = $path.'thumbnail/'.$image_name;
				$user_data['profile_thumbnail_small'] = $path.'thumbnail/'.$image_name; 
			endif;
			
			if(!$this->api_model->update('users',$user_data,array('user_id'=>$user->id))){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data); 	
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			$user_val  = array(
				'id' 			=> $user->id,
				'first_name'	=>	$this->input->post('first_name'),
				'last_name'	=>  $this->input->post('last_name'),
				'email'		=>	$this->input->post('email')
			);
	        $data['token'] = AUTHORIZATION::generateToken($user_val);
			$data['user'] = $user_val;
			$profile_image=$this->api_model->get_row('users',array('user_id'=>$user->id),array('profile_thumbnail_small'));
			if(!empty($profile_image->profile_thumbnail_small))
				$data['profile_image'] = base_url($profile_image->profile_thumbnail_small);
			else
				$data['profile_image'] = base_url('assets/frontend/img/user.svg');
			$data['status']=True;

			$data['message'] = 'User profile updated successfully.';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}


	public function valid_url_social($str){
	   if($str==='')
	   		return TRUE;	
	   else			
	   		return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
	}


	public function social_media_post(){
		$this->_authRequest();
		$user = $this->user;
		$this->form_validation->set_rules('instagram','Instagram','callback_valid_url');	
	    $this->form_validation->set_rules('facebook','Facebook','callback_valid_url');
	    $this->form_validation->set_rules('twitter','Twitter','callback_valid_url');
	    $this->form_validation->set_rules('youtube','Youtube','callback_valid_url');
	    $this->form_validation->set_rules('pinterest','pinterest','callback_valid_url');
	    $this->form_validation->set_rules('linkedin','linkedin','callback_valid_url');
	    $this->form_validation->set_rules('spotify','Spotify','callback_valid_url');	
		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
	
			$social=array(
				'spotify'=>	$this->input->post('spotify'),
				'linkedin'=>	$this->input->post('linkedin'),
				'pinterest'=>	$this->input->post('pinterest'),
				'youtube'=>	$this->input->post('youtube'),
				'twitter'=>	$this->input->post('twitter'),
				'facebook'=>	$this->input->post('facebook'),
				'instagram'=>	$this->input->post('instagram'),
			);
			if($this->api_model->get_row('fh_social_media',array('user_id'=>$user->id),array('user_id')))	
			{
				$this->api_model->update('fh_social_media',$social,array('user_id'=>$user->id));
			}else{
				$social['user_id']=$user->id;
				$this->api_model->insert('fh_social_media',$social);
			}	
			$data['status']=True;
			$data['message'] = 'Social Media Infomation updated successfully.';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}


	/* End of code */

	/**********************
	Code Written By - Prem Panwar 
	Date - 08-12-18
	Code For getting Pages data
	**********************/
	public function content_management_get()
	{
		//$this->_authRequest();
		if($_GET['slug']=='about-us'){
			$data["pages1"] = $this->api_model->get_row("pages",array("status"=>1,"slug"=>"about-what-is-flow"));
			$data["pages2"] = $this->api_model->get_row("pages",array("status"=>1,"slug"=>'about-who-is-flowhaus'));
			$data["pages3"] = $this->api_model->get_row("pages",array("status"=>1,"slug"=>'about-us-what-is-flowhaus'));
			$data["pages4"] = $this->api_model->get_row("pages",array("status"=>1,"slug"=>'about-us-affiliate-partnerships'));
			$data['message'] ='Page List';
			$data['status']=True;
		$this->set_response($data, REST_Controller::HTTP_OK);
		}else{
			$data["pages"] = $this->api_model->get_row("pages",array("status"=>1,"slug"=>$_GET['slug']));
			$data['message'] ='Page List';
			$data['status']=True;
			$this->set_response($data, REST_Controller::HTTP_OK);
		}
	}


	public function footer_get(){
		//$this->_authRequest();
		$data["socials"] = $this->api_model->get_result("options",array('status'=>1,'option_value!='=>'','section'=>1),array('option_name','option_value','section'));
		$data["email"] = get_option_url('EMAIL');
		$data['message'] ='Options List';
		$data['status']=True;
		
		$this->set_response($data, REST_Controller::HTTP_OK,JSON_NUMERIC_CHECK);
	}

	public function contact_form_post(){ 
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email',array('valid_email' => 'Please enter valid email address'));		
		
		$this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
		$this->form_validation->set_rules('message','Message', 'trim|required|max_length[500]');

		if($this->input->post('user_type') == 'Travel Influencer'){
			$str = $this->input->post('instagram_handle');
			//echo '$str $str $str '.$str ;
			$text = explode('/',$str);
		
			if($str=='' || sizeof($text)<4 || (!empty($text) && empty($text[3]))){
			//	echo 'dsdssd';
				$this->form_validation->set_rules('instagram_handle','Instagram', 'required|trim|instagramValid',array('instagramValid' => 'Please enter valid Instagram handle'));
			}
		}
		if($this->input->post('website') != ''){
			$this->form_validation->set_rules('website','Website', 'trim|callback_valid_url',array('valid_url' => 'Please enter valid website'));
		}
		try { 
			if ($this->form_validation->run() == False)	{
					$data['error'] = 	$this->form_validation->error_array();
					$data['message'] = 'validation error'	;
					$list = json_encode($data);
				 	throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			//die();
			$user_data  = array(
				'name'	=>	$this->input->post('name'),
				'user_type'	=>  $this->input->post('user_type'),
				'email'		=>	$this->input->post('email'),
				'website' => $this->input->post('website'),
				'instagram_handle' => $this->input->post('instagram_handle'),
				'message' => $this->input->post('message'),
				'created'	=> date('Y-m-d h:i:s'),
				'created_ip' =>	$this->input->ip_address()
			);
			
			if(!$user_id =$this->api_model->insert('contactus_notification', $user_data)){
				$data['message'] = 'Something Went Wrong. Please try again.';
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}

    		/******************  Send email for users ***************/
			$this->chapter247_email->set_language('en');
    	    $this->chapter247_email->set_email_templates(102);
    	    $email_template=$this->common_model->get_email('en',102);
    	   // echo "<pre>"; print_r($email_template); die();
			$param = array(
				"template"=>array(
					"var_name" => array(
						"name" => $this->input->post('name'),
						"email" => $this->input->post('email'),
					),
					"temp" => $email_template->template_body,

				),
				"email" => array(
					"to"        =>   $this->input->post('email'),
					"from"      =>   NO_REPLY_EMAIL,
					"from_name" =>   NO_REPLY_EMAIL_FROM_NAME,
					"subject"   =>  $email_template->template_subject,
				)
			);
			$status = $this->chapter247_email->send_mail($param);
			//p($status); die();
			if($status){ $data['email_message'] = 'Email Message has been sent'; }else{ $data['email_error_message'] = 'Email Message has not sent'; }
    	/******************* End Code For Users ****************/
			$data['status']=True;
			$data['message'] = 'Message has been sent, Our team will contact you soon';
			$this->set_response($data, REST_Controller::HTTP_OK);



		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}


	public function forget_password_post(){

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		try {
			if ($this->form_validation->run() == False)	{
				
					$data['error'] = 	$this->form_validation->error_array();
					$data['message'] = 'validation error'	;
					$list = json_encode($data);
				 	throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			$user_data  = array(
				'reset_password_time'		=> date('H:i:s'),
				'new_password_key' => random_string('alnum', 20)
			);
			$matchUser_id = $this->api_model->get_row("users",array('email'=>$this->input->post('email')),array('user_id,first_name'));
			if(!empty($matchUser_id)){
			if(!$user_id =$this->api_model->update('users', $user_data,array("user_id"=>$matchUser_id->user_id))){
				$data['message'] = 'Something Went Wrong. Please try again.';
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			}else{ 
				$data['message'] = 'Requested Email Does Not Exist';
					$list = json_encode($data);
				 	throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
				  die();
			}
    		/****************** Send email for users *************************/
			
			$this->chapter247_email->set_language('en');
    	    $this->chapter247_email->set_email_templates(2);
    	    $email_template=$this->common_model->get_email('en',2);
			$param = array(
				"template"=>array(
					"var_name" => array(
						"email" => $this->input->post('email'),
						"name" => $matchUser_id->first_name,
						"reset_link" => $user_data['new_password_key']
					),
					"temp" => $email_template->template_body,

				),
				"email" => array(
					"to"        =>   $this->input->post('email'),
					"from"      =>   SUPPORT_EMAIL,
					"from_name" =>   NO_REPLY_EMAIL_FROM_NAME,
					"subject"   =>  $email_template->template_subject,
				)
			);
			$status = $this->chapter247_email->send_mail($param);
			if($status){ $data['email_message'] = 'Email Message has been sent'; }else{ $data['email_error_message'] = 'Email Message has not sent'; }
    		/******************* End Code For users ****************/
			$data['status']=True;
			$data['message'] = 'Message has been sent';
			$this->set_response($data, REST_Controller::HTTP_OK);



		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}

	}


	public function reset_user_password_post(){

		$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[6]');
 		$this->form_validation->set_rules('confirm_password','Confirm Password', 'trim|required|min_length[6]|matches[password]');
		$this->form_validation->set_rules('token', 'Token', 'required');
 		//$this->form_validation->set_rules('token', 'Token', 'trim|required');

 		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
			//echo $_GET['token']; echo "<pre>"; die
			if(!empty($this->input->post('token'))){  
			 $token_value  = $this->input->post('token'); 
			 $user =$this->api_model->get_row('users',array('new_password_key'=>$token_value),array("user_id,email,first_name,reset_password_time"));
			}
			if(empty($user))
			{	
				$data['message'] = 'Sorry! Wrong token is provided, Password change process has been faild';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			
    	if(!empty($user)){
    		 $tokenTime = strtotime($user->reset_password_time);
			 $ExpTime = strtotime(date('H:i:s'));
			 $newTime = $ExpTime-$tokenTime;
			 $timeInMinites = $newTime/60;
			if($timeInMinites>480){  
				$data['message'] = 'Sorry! Password Token has Expired';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			$salt=$this->salt();
			
				$updateResult = $this->api_model->update('users',array('password' =>sha1($salt.sha1($salt.sha1($this->input->post('password')))), 'new_password_key'=>$this->input->post('token'),'salt'=>$salt),array('user_id'=>$user->user_id));
				/******************Send email*************************/
			$this->chapter247_email->set_language('en');
	    	$this->chapter247_email->set_email_templates('en',3);
	    	$email_template=$this->common_model->get_email('en',3);
				$param = array(
					"template"=>array(
						"var_name" => array(
							"user_name" => trim($user->first_name),
							"url"=> FRONTEND_URL
						),
						"temp" => $email_template->template_body,
					),
					"email" => array(
						"to"        =>   $user->email,
						"from"      =>   SUPPORT_EMAIL,
						"subject"   =>  $email_template->template_subject,
						"from_name" =>   NO_REPLY_EMAIL_FROM_NAME
					)
				);
				$status = $this->chapter247_email->send_mail($param);

	    	/*****************************************************/

			$data['message'] ='Password change successfully';
			$this->set_response($data, REST_Controller::HTTP_OK);
		  }
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		
 		
	}
	/**********************
	Above Code Ending was wrriten at below date
	Code Written By - Prem Panwar 
	Date - 08-12-18
	Code For getting Pages data
	**********************/
}




