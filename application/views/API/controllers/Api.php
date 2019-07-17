<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."libraries/REST_Controller.php";
require APPPATH."third_party/Auth/Authorization.php";

class Api extends REST_Controller {
  private $user;
  private $params;
  private $language;

  public function __construct()
  {
  	parent::__construct();
  	$this->load->model('Common_model');
  	$this->load->library('chapter247_email');
  	$this->_languageRequest();
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

	private function _languageRequest($headers = array())
  {
  	if (empty($headers)) {
  		$headers = $this->input->request_headers();
  	}
		if (array_key_exists('Language', $headers) && !empty($headers['Language'])) {

    	$list = AUTHORIZATION::validateLanguageToken($headers['Language']);
    	if(property_exists($list, 'language') && ($list->language == "en" || $list->language == "ar")) {
	    	$this->language = $list->language;
    	}else{
    		$this->language = 'en';	
    	}
	 	}else{
	  	$this->language = 'en';
	  }
  }


	/**************************
  Created By: Sonu Bamniya
  Created At: 23 May, 2018 12:00 PM
  **************************/
  private function _authRequest($headers = array())
  {
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


	public function check_image($str,$is_image){

  	if($is_image == 0){
			$this->form_validation->set_message('check_image', 'Please select featured image');
		   return FALSE;
		}

		if($is_image == 1){

			if(empty($_FILES['featured_image']['name'])){
				$this->form_validation->set_message('check_image', 'Please select featured image');
			   return FALSE;
			}
			
			if(!empty($_FILES['featured_image']['name'])):
				$config['upload_path'] = './assets/uploads/blog';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_width']  = '5000';
				$config['max_height'] = '4500';
				$config['min_width']  = '200';
				$config['min_height'] = '150';
				$config['file_name']  = $this->salt();
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('featured_image')){
					$this->form_validation->set_message('check_image', strip_tags($this->upload->display_errors()));
					return FALSE;
				}else{
					$fileData = $this->upload->data();
			    $config_imgp['source_path']      = './assets/uploads/blog/';
	        $config_imgp['destination_path'] = './assets/uploads/blog/thumbnail/';
	      	$config_imgp['width']            = '300';
	        $config_imgp['height']           = '240';
	        $config_imgp['file_name_source'] 	= $fileData['file_name'];
	   			$config_imgp['file_name'] 				= $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
	   			$thumbnail  = create_thumbnail($config_imgp);
					$config_imgs['file_name_source'] = $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
	  			$config_imgs['file_name'] 			 = $fileData['raw_name'].'-thumbnail-small'.$fileData['file_ext'];
	        $config_imgs['source_path']      = './assets/uploads/blog/thumbnail/';
	      	$config_imgs['destination_path'] = './assets/uploads/blog/thumbnail_small/';
	        $config_imgs['width']            = '100';
	        $config_imgs['height']           = '70';
					$thumbnail_small  = create_thumbnail($config_imgs);
					$this->session->set_userdata('check_image',array('image'=>'assets/uploads/blog/'.$fileData['file_name'],'thumbnail'=>'assets/uploads/blog/thumbnail/'.$thumbnail['file_name'],'thumbnail_source'=>'assets/uploads/blog/thumbnail_small/'.$thumbnail_small['file_name']));
					return TRUE;
				}
			else:
				$this->form_validation->set_message('check_image', 'The %s field required');
				return FALSE;
			endif;
		}
  }

  /**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 05-08-2018 12:00 PM
	**************************/
	public function check_profile($str){
  
		if(empty($_FILES['profile_image']['name'])){
			$this->form_validation->set_message('check_profile', 'Choose Image');
		   return FALSE;
		}
		if(!empty($_FILES['profile_image']['name'])):
			$config['upload_path'] = './assets/uploads/users';
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['max_width']  = '1600';
			$config['max_height'] = '1200';
			// $config['min_width']  = '200';
			// $config['min_height'] = '150';
			$config['file_name']  = $this->salt();
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('profile_image')){
				$this->form_validation->set_message('check_profile', strip_tags($this->upload->display_errors()));
				return FALSE;
			}else{
				$fileData = $this->upload->data();
		    $config_imgp['source_path']      	= './assets/uploads/users/';
        $config_imgp['destination_path'] 	= './assets/uploads/users/thumbnail/';
      	$config_imgp['width']            	= '300';
        $config_imgp['height']           	= '240';
        $config_imgp['file_name_source'] 	= $fileData['file_name'];
       	$config_imgp['file_name'] 				= $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
       	$thumbnail  = create_thumbnail($config_imgp);
        $config_imgs['source_path']      = './assets/uploads/users/thumbnail/';
      	$config_imgs['destination_path'] = './assets/uploads/users/thumbnail_small/';
        $config_imgs['width']            = '100';
        $config_imgs['height']           = '70';
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


	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 29-08-2018 12:00 PM
	**************************/
	public function signup_post()
	{

		$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'required|alpha_numeric',array('required'=> $this->lang->line('required'),'alpha_numeric'=> $this->lang->line('alpha_numeric')));

		$this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'required|alpha_numeric',array('required'=> $this->lang->line('required'),'alpha_numeric'=> $this->lang->line('alpha_numeric')));

		$this->form_validation->set_rules('email', $this->lang->line('email'), 'required|valid_email|callback_email_check',array('required'=> $this->lang->line('required'),'valid_email'=> $this->lang->line('valid_email')));

		$this->form_validation->set_rules('password',$this->lang->line('password'), 'required|min_length[6]|max_length[20]|matches[confirm_password]',array('required'=> $this->lang->line('required'),'min_length'=> $this->lang->line('min_length'),'max_length'=> $this->lang->line('max_length'),'matches'=> $this->lang->line('match_password')));



		$this->form_validation->set_rules('confirm_password',$this->lang->line('confirm_password'),'trim|required',array('required'=> $this->lang->line('required')));

		try {
			if ($this->form_validation->run() == False)	{
					$data['error'] = 	$this->form_validation->error_array();
					$data['message'] = 'validation error';
					$list = json_encode($data);
				 	throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}

			$val = get_contry_by_ip($this->input->ip_address());
	
			$user_data  = array(
				'first_name'	=>	$this->input->post('first_name'),
				'last_name'	=>  $this->input->post('last_name'),
				'email'		=>	$this->input->post('email'),
				'phone_code'		=>	'+'.phonecodes_list($val['countryCode']),
				'country'		=>	$val['country'],
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'status' => 1,
				'created_at'	=> date('Y-m-d h:i:s'),
				'created_ip'		=>	$this->input->ip_address(),
				"is_recieve_email" => 1
			);
			if(!$user_id =$this->Common_model->insert('user_master', $user_data)){
			
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$this->Common_model->update('user_master',array('last_ip' => $this->input->ip_address(), 'last_login' => date('Y-m-d h:i:s')),array('user_id'=>$user_id));
			/******************Send email*************************/
    	$this->chapter247_email->set_email_templates(1);
			$param = array(
				"template"=>array(
					"var_name" => array(
						"user_name" => $this->input->post('first_name').' '.$this->input->post('last_name'),
						"url"=> FRONTEND_URL
					)
				),
				"email" => array(
					"to"        =>   $this->input->post('email'),
					"from"      =>   SUPPORT_EMAIL,
					"from_name" =>   NO_REPLY_EMAIL_FROM_NAME
				)
			);
			$status = $this->chapter247_email->send_mail($param);
    	/*****************************************************/
    	$user_info = $this->common_model->get_row('newsletter',array('email'=>$this->input->post('email')));
			if(empty($user_info)){
				$user_data['email']  =  $this->input->post('email');
				$user_data['created_at']=  date('Y-m-d H:i:s');
				$user_data['user_ip']  =  $this->input->ip_address();
				$this->common_model->insert('newsletter', $user_data);
			}
	    $user_val  = array(
	    	'id' 			=> $user_id,
				'first_name'	=>	$this->input->post('first_name'),
				'last_name'	=>  $this->input->post('last_name'),
				'email'		=>	$this->input->post('email')
			);
	    $data['token'] = AUTHORIZATION::generateToken($user_val);
			$data['user'] = $user_val;
			$data['message'] = 'User signed up successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}
	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 30-08-2018 12:00 PM
	**************************/
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
			$email = $this->input->post('email');
      $password = $this->input->post('password');
      $val =	$this->Common_model->login($email,$password);
			if($val['status']!= 1){
				$data['message'] = 	$val['error_message'];
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			$output['token'] = AUTHORIZATION::generateToken($val['user']);
			$output['user'] = $val['user'];
			$output['message'] = 	'Login Successful';
    	$this->set_response($output, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}
	/**************************
	Created By: Sonu Bamniya - Chapter247
	Created At: 06-10-2018 12:56 PM
	**************************/
	public function social_signup_login_post() {

		$this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email' ,array('required'=> $this->lang->line('required'),'valid_email'=> $this->lang->line('valid_email')));
		$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required',array('required'=> $this->lang->line('required')));

		$this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'trim|required' ,array('required'=> $this->lang->line('required')));

		try {
			if ($this->form_validation->run() == False)	{
					$data['message'] = $this->lang->line('social_signup_msg');
					$list = json_encode($data);
				 	throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$email = $this->input->post('email');
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$user =$this->common_model->get_row('user_master',array('email'=> $email,'status!='=>2,'user_role' =>'user'));
			if(!empty($user)){
				$user_data  = array(
					'first_name'	=>	$first_name,
					'last_name'	=>  $last_name,
					'last_ip' => $this->input->ip_address(),
					'last_login' => date('Y-m-d h:i:s')
				);
				$this->Common_model->update('user_master', $user_data, array('user_id'=>$user->user_id));
				$data['token'] = $this->generate_login_token((array)$user);
				$this->set_response($data, REST_Controller::HTTP_OK);
			} else {
				$val = get_contry_by_ip($this->input->ip_address());
				$password = uniqid();
				$user_data  = array(
					'first_name'	=>	$first_name,
					'last_name'	=>  $last_name,
					'email'		=>	$email,
					'phone_code'		=>	'+'.phonecodes_list($val['countryCode']),
					'country'		=>	$val['country'],
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'status' => 1,
					'created_at'	=> date('Y-m-d h:i:s'),
					'created_ip'		=>	$this->input->ip_address(),
					'last_ip' => $this->input->ip_address(),
					'last_login' => date('Y-m-d h:i:s'),
					"is_recieve_email" => 1
				);
				if(!$user_id =$this->Common_model->insert('user_master', $user_data)){
					$data['message'] = 'Something Went Wrong. Please try again.';
					$list = json_encode($data);
					throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
				/******************Send email*************************/
	    	$this->chapter247_email->set_email_templates(1);
				$param = array(
					"template"=>array(
						"var_name" => array(
							"user_name" => trim($first_name.' '.$last_name),
							"url"=> FRONTEND_URL
						)
					),
					"email" => array(
						"to"        =>   $email,
						"from"      =>   SUPPORT_EMAIL,
						"from_name" =>   NO_REPLY_EMAIL_FROM_NAME
					)
				);
				$status = $this->chapter247_email->send_mail($param);
	    	/*****************************************************/
	    	$user_info = $this->common_model->get_row('newsletter',array('email'=>$this->input->post('email')));
				if(empty($user_info)){
					$user_d['email']  =  $this->input->post('email');
					$user_d['created_at']=  date('Y-m-d H:i:s');
					$user_d['user_ip']  =  $this->input->ip_address();
					$this->common_model->insert('newsletter', $user_d);
				}
		    $user_val  = array(
		    	'id' 			=> $user_id,
					'first_name'	=> $first_name,
					'last_name'	=>  $last_name,
					'email'		=>	$email
				);
		    $data['token'] = AUTHORIZATION::generateToken($user_val);
				$data['message'] = 'Success';
				$this->set_response($data, REST_Controller::HTTP_OK);
			}
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
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
	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 30-08-2018 12:00 PM
	**************************/
	public function email_check($str='',$id=''){
   $user =$this->common_model->get_row('user_master',array('email'=>$str,'status!='=>2,'user_role' =>'user','user_id !='=>$id));
		if(!empty($user->email)):
			$this->form_validation->set_message('email_check', 'The %s address already exists.');
		   return FALSE;
		else:
		   return TRUE;
		endif;
	}

	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 31-08-2018 12:00 PM
	**************************/
	public function forgot_password_post(){

	$this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email',array('required'=> $this->lang->line('required'),'valid_email'=> $this->lang->line('valid_email')));
	try {
			if ($this->form_validation->run() == False)	{
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error'	;
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$email = $this->input->post('email');
			$user =$this->common_model->get_row('user_master',array('email'=>$email,'user_role'=>'user','status!='=>2));
			if(empty($user))
			{	$data['message'] = 'Your email isn\'t register.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
    	if(!empty($user)){

		    $tokenData['id'] = uniqid();
		    $tokenData['name'] = $user->first_name;
		    $tokenData['email'] = $user->email;
		    $tokenData['date'] = date('Y-m-d h:i:s');
		    $token = AUTHORIZATION::generateToken($tokenData);

	      $updateResult = $this->common_model->update('user_master',array('reset_token'=>$token),array('user_id'=>$user->user_id));
	      $url = FRONTEND_URL.'#/auth/reset-password?token='.$token;
	      if($updateResult){

	      	/******************Send email*************************/
		    	$this->chapter247_email->set_email_templates(2);
					$param = array(
						"template"=>array(
							"var_name" => array(
								"user_name" => $user->first_name.' '.$user->last_name,
								"reset_link"=>$url,
								"site_name"=> SHOW_SITE_NAME
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
					$data['message'] ='Password reset instructions has been sent to '.$user->email.'. Don\'t forget to check your spam and junk folders if it doesn\'t show up.';
					$this->set_response($data, REST_Controller::HTTP_OK);
		    }
	    }
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		
	}
	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 31-08-2018 12:00 PM
	**************************/
	public function reset_password_check_post(){
		$this->form_validation->set_rules('token', $this->lang->line('token'), 'trim|required',array('required'=> $this->lang->line('required')));
		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$reset_token = $this->input->post('token');
			$user =$this->common_model->get_row('user_master',array('reset_token'=>$reset_token,'status!='=>2));
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

	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 31-08-2018 12:00 PM
	**************************/
	public function reset_password_post(){

		$this->form_validation->set_rules('password',$this->lang->line('password'), 'required|min_length[6]|max_length[20]|matches[confirm_password]',array('required'=> $this->lang->line('required'),'min_length'=> $this->lang->line('min_length'),'max_length'=> $this->lang->line('max_length'),'matches'=> $this->lang->line('match_password')));



		$this->form_validation->set_rules('confirm_password',$this->lang->line('confirm_password'),'trim|required',array('required'=> $this->lang->line('required')));

 		$this->form_validation->set_rules('token', $this->lang->line('token'), 'trim|required',array('required'=> $this->lang->line('required')));

 		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
			$reset_token = $this->input->post('token');
			$user =$this->common_model->get_row('user_master',array('reset_token'=>$reset_token,'status!='=>2));
			if(empty($user))
			{	
				$data['message'] = 'Sorry! Password updation process has been failed. Please try again';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
    	if(!empty($user)){
				$updateResult = $this->common_model->update('user_master',array('password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),'reset_token'=>''),array('user_id'=>$user->user_id));
				/******************Send email*************************/
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

	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 03-09-2018 12:00 PM
	**************************/
	public function blog_list_get(){
		$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
		$per_page = isset($_GET['limit']) ? $_GET['limit'] : 10;
		$searchString	= null;
		if(isset($_GET['search'])){
			$searchString	= trim($this->input->get('search'));
			$category	= trim($this->input->get('category'));
		}
		$category = null;
		if(isset($_GET['category'])){
			$category	= trim($this->input->get('category'));
		}
		$data['blog'] = $this->common_model->blog($offset,$per_page,null,$searchString, false,$category);
		$data['total_rows'] = $this->common_model->blog(0,0,null,$searchString,true,$category);
		$data['message'] ='Blog List';
		$this->set_response($data, REST_Controller::HTTP_OK);
	} 



	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 04-09-2018 12:00 PM
	**************************/
	public function add_blog_post(){

		$this->_authRequest();
		$user = $this->user;


		$this->form_validation->set_rules('blog_category', $this->lang->line('blog_category'), 'required',array('required'=> $this->lang->line('required')));

		$this->form_validation->set_rules('blog_title',$this->lang->line('blog_title'), 'required|max_length[100]',array('required'=> $this->lang->line('required'),'max_length'=> $this->lang->line('max_length_hundread')));

		$this->form_validation->set_rules('blog_content',$this->lang->line('blog_content'), 'required',array('required'=> $this->lang->line('required')));

		$this->form_validation->set_rules('blog_small_content',$this->lang->line('blog_small_content'), 'required|max_length[250]',array('required'=> $this->lang->line('required'),'max_length'=> $this->lang->line('max_length_twofifty')));

		$this->form_validation->set_rules('blog_tag',$this->lang->line('blog_tag'), 'trim|required',array('required'=> $this->lang->line('required')));

		$is_image =$this->input->post('is_image');
		$this->form_validation->set_rules('featured_image', '', 'callback_check_image['.$is_image.']');
		
		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
			$image ='';
			$blog_data  = array(
				'name'	=>	$user->first_name.' '.$user->last_name,
				'email'	=>  $user->email,
				'language' => $this->language,
				'blog_category'		=>	$this->input->post('blog_category'),
				'blog_title'	=>	$this->input->post('blog_title'),
				'blog_content'	=>  $this->input->post('blog_content'),
				'blog_small_content' =>  $this->input->post('blog_small_content'),
				'blog_tag'		=>	$this->input->post('blog_tag'),
				'status' => 3,
				'created_by' =>  $user->id,
				'created_ip' =>  $this->input->ip_address(),
			);
			if($this->input->post('is_image') == 1){

				if($this->session->userdata('check_image')!=''):
				
		    	$check_logo_img=$this->session->userdata('check_image');
		      $blog_data['featured_image']  = $check_logo_img['image'];  
		      $blog_data['featured_thumbnail']  = $check_logo_img['thumbnail']; 
		      $blog_data['featured_thumbnail_small']  = $check_logo_img['thumbnail_source'];            
		      $this->session->unset_userdata('check_image');
		    endif;
		  }

  		if($this->input->post('blog_id')!==null){
      	if(!$this->Common_model->update('blog',$blog_data,array('created_by' => $user->id,'blog_id'=> $this->input->post('blog_id')))){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
				$data['message'] = 'Travel Tip updated successfully. It will be published once admin review it.'; 
      }else{
      	$blog_data['slug'] = $this->Common_model->create_unique_slug($this->input->post('blog_title'), 'blog');
      	if(!$this->Common_model->insert('blog', $blog_data)){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
				$data['message'] = 'Travel Tip added successfully. It will be published once admin review it.';
			}

			
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		
	}
	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 04-09-2018 12:00 PM
	**************************/

	public function category_get($offset=0){
	//	$this->_authRequest();
		$data['category'] =$this->common_model->get_result('blog_category',array(),array('id','category_name'),array('category_name','ASC'));
		try {
			if (empty($data['category']))	{
				 throw new Exception('No category found', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['message'] = 'Category List';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
	}

	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 04-09-2018 12:00 PM
	**************************/

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
		$data['blog'] = $this->common_model->blog($offset,$per_page,$user->id,$searchString, false,$category);
		$data['total_rows'] = $this->common_model->blog(0,0,$user->id,$searchString,true,$category);	
		$data['message'] ='Blog List';
		$this->set_response($data, REST_Controller::HTTP_OK);
 	}


	public function blogs_detail_get(){
		$blog_id = isset($_GET['blog_id']) ? $_GET['blog_id'] : null;
		$slug = isset($_GET['slug']) ? $_GET['slug'] : null;
		try{
			if(empty($blog_id) && $blog_id > 1){
	 			throw new Exception('No Detail Found', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$detail = $this->common_model->blogs_detail($blog_id,$slug);
			if (empty($detail))	{
				 throw new Exception('No Detail Found', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$detail->blog_tag = explode(',',$detail->blog_tag); 
			$data['Detail'] = $detail;
			$data['message'] = 'Details';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	} 


	public function delete_blogs_delete($blog_id=0){
		$this->_authRequest();
		$user = $this->user;
		if(empty($blog_id) && $blog_id < 1){
 			throw new Exception('No blog id Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		$delete = $this->common_model->update('blog',array('status'=>2),array('blog_id'=>$blog_id));
		try{
			if ($delete!=1){
				 throw new Exception('Invalid id', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['message'] = 'Deleted';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	}



	public function user_profile_get(){
		$this->_authRequest();
		$user = $this->user;
		$val="(case when (profile_image = NULL) then profile_image else (CONCAT('".base_url()."',profile_image))  end) as profile_image";
		$va_to="(case when (profile_thumbnail = NULL) then profile_thumbnail else (CONCAT('".base_url()."',profile_thumbnail))  end) as profile_thumbnail";

		$data['user'] = $this->common_model->get_row('user_master',array('user_id'=>$user->id),array('user_id','first_name','last_name','mobile','email',$val,$va_to,'id_doc_type','id_number','expiry_date','country','phone_code', 'is_recieve_email'));
		$data['doc_type_list'] = doc_type();
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

		$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'required|alpha_numeric',array('required'=> $this->lang->line('required'),'alpha_numeric'=> $this->lang->line('alpha_numeric')));

		$this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'required|alpha_numeric',array('required'=> $this->lang->line('required'),'alpha_numeric'=> $this->lang->line('alpha_numeric')));

		if(!empty($_FILES) && $_FILES['profile_image']['name']!='')
		$this->form_validation->set_rules('profile_image', '', 'callback_check_profile');
		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$user_data  = array(
				'first_name'	=>	$this->input->post('first_name'),
				'last_name'		=>  $this->input->post('last_name'),
				'mobile'			=>	$this->input->post('mobile'),
				'phone_code'  =>$this->input->post('phone_code'),
				'id_doc_type'	=>	$this->input->post('id_doc_type'),
				'id_number'		=>	$this->input->post('id_number'),
				'expiry_date'	=>	$this->input->post('expiry_date'),
				'country'			=>	$this->input->post('country'),
				'update_by'		=>	$user->id,
				'update_ip'		=>	$this->input->ip_address(),
				'update_at'		=> date('Y-m-d h:i:s'),
				"is_recieve_email" => trim($this->input->post('is_recieve_email')) != "" ? 1 : 0
			);

			if($this->input->post('is_image') == 1){
				if($this->session->userdata('check_profile')!=''):
      	$check_logo_img=$this->session->userdata('check_profile'); 
        $user_data['profile_image']  = $check_logo_img['image'];  
        $user_data['profile_thumbnail']  = $check_logo_img['thumbnail']; 
        $user_data['profile_thumbnail_small']  = $check_logo_img['thumbnail_source'];           
        $this->session->unset_userdata('check_profile');
      	endif;
			}else{
		  		$user_data['profile_image']  = NULL;  
		      $user_data['profile_thumbnail']  = NULL; 
		      $user_data['profile_thumbnail_small']  = NULL; 	
		  }

			
			if(!$this->Common_model->update('user_master',$user_data,array('user_id'=>$user->id))){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data); 	
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			if ($this->input->post('is_recieve_email') == 1) {
				$user_info = $this->common_model->get_row('newsletter',array('email'=>$user->email));
				if(empty($user_info)){
					$userD['email']  =  $this->input->post('email');
					$userD['created_at']=  date('Y-m-d H:i:s');
					$userD['user_ip']  =  $this->input->ip_address();
					$this->common_model->insert('newsletter', $userD);
				}
			} else {
				$this->common_model->delete('newsletter', array('email'=>$user->email));
			}
			$data['message'] = 'User profile update successfully.';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}
	public function add_package_post(){
		$this->_authRequest();
		$user = $this->user;
		$this->form_validation->set_rules('blog_category', $this->lang->line('blog_category'), 'required',array('required'=> $this->lang->line('required')));
			
		$this->form_validation->set_rules('delivery_urgency', $this->lang->line('delivery_urgency'), 'required',array('required'=> $this->lang->line('required')));

		$this->form_validation->set_rules('departure_location', $this->lang->line('departure_location'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('destination_location', $this->lang->line('destination_location'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('delivery_period', $this->lang->line('delivery_period'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('drop_off_location', $this->lang->line('drop_off_location'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('pickup_location', $this->lang->line('pickup_location'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('number_of_package', $this->lang->line('number_of_package'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('types_of_package', $this->lang->line('types_of_package'), 'required',array('required'=> $this->lang->line('required')));
		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}	$filearray = '';

				$is_image =$this->input->post('is_image');
				if($is_image == 1){
					if(!empty($_FILES) && $_FILES['parcelfile']['name']!=''){
					$files = $_FILES;
					$filearray ="";
	        $count = count($_FILES['parcelfile']['name']);
						for($i=0; $i<$count; $i++){

							$_FILES['parcelfiles']['name']= $files['parcelfile']['name'][$i];
		          $_FILES['parcelfiles']['type']= $files['parcelfile']['type'][$i];
		          $_FILES['parcelfiles']['tmp_name']= $files['parcelfile']['tmp_name'][$i];
		          $_FILES['parcelfiles']['error']= $files['parcelfile']['error'][$i];
		          $_FILES['parcelfiles']['size']= $files['parcelfile']['size'][$i];
							$config['upload_path'] = './assets/uploads/parcel/';
							$config['allowed_types'] = 'jpg|png|jpeg';
							$config['max_width']  = '3200';
							$config['max_height'] = '2400';
							$config['min_width']  = '50';
							$config['min_height'] = '20';
							$config['file_name']  = $this->salt();
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('parcelfiles')){
									$data['status'] = False;
									$data['error'] = $this->upload->display_errors();
									$data['message'] = 'validation error';
									$list = json_encode($data); 
								throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
							}
							$fileData = $this->upload->data();
	         		$images[] = 'assets/uploads/parcel/'.$fileData['file_name'];
	          }
	          	$filearray = implode(',',$images);
	        }
	      }  
	     
				$package_tours  = array(
				'delivery_urgency'		=>	$this->input->post('delivery_urgency'),
				'destination_location'=>  $this->input->post('destination_location'),
			  'departure_location'	=>	$this->input->post('departure_location'),
				'pickup_location'			=>	$this->input->post('pickup_location'),
				'delivery_period'			=>	$this->input->post('delivery_period'),
				'number_of_package'		=>	$this->input->post('number_of_package'),
				'types_of_package'		=>	$this->input->post('types_of_package'),
				'drop_off_location'		=>	$this->input->post('drop_off_location'),
				'destination_latitude'=>	$this->input->post('destination_latitude'),
				'destination_longitude'=>	$this->input->post('destination_longitude'),
				'departure_latitude'	=>	$this->input->post('departure_latitude'),
				'departure_longitude'	=>	$this->input->post('departure_longitude'),
				'cost'								=>	$this->input->post('cost'),
				'status' 				=>  1,
				'created_by'		=>	$user->id,
				'created_ip'		=>	$this->input->ip_address(),
				'created_at'		=> date('Y-m-d h:i:s'),
			);
		
			if($this->input->post('package_id')!=null){
				if($is_image == 1){
				$package_info = $this->common_model->package_details($this->input->post('package_id'));
					if(!empty($filearray) && !empty($package_info->parcel_image)){
						$package_tours['parcel_image'] = $filearray.','.$package_info->parcel_image;
					}else if(!empty($filearray)){
						
							$package_tours['parcel_image'] = $filearray;
					}else{
					
							$package_tours['parcel_image'] = $package_info->parcel_image;
					}
				}
			
      	if(!$this->Common_model->update('package_master',$package_tours,array('created_by' => $user->id,'package_id'=> $this->input->post('package_id')))){
      					$data['message'] = 'Something Went Wrong. Please try again.';
								$list = json_encode($data); 
							throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
				}
				$package_meta  = array(
					'recipient_information'	=>	$this->input->post('recipient_information'),
					'package_information'	=>	$this->input->post('package_information'),
				);
				$this->Common_model->update('package_meta',$package_meta,array('package_id'=> $this->input->post('package_id')));
				$data['message'] = 'Package details updated successfully!'; 
				$data['package_id'] = $this->input->post('package_id');
      }else{
      	if($is_image == 1){
					$package_tours['parcel_image'] = $filearray;
				}

      	if(!$package = $this->Common_model->insert('package_master', $package_tours)){

							$data['message'] = 'Something Went Wrong. Please try again.';
								$list = json_encode($data); 
							throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
				}
				$package_meta  = array(
					'recipient_information'	=>	$this->input->post('recipient_information'),
					'package_information'	=>	$this->input->post('package_information'),
					'package_id'=>$package,
				);
				$this->Common_model->insert('package_meta', $package_meta);
				$data['package_id'] = $package;
				$data['message'] = 'Package details added successfully!';
			}

			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}

	public function delete_package_image_post(){
		$this->_authRequest();
		$user = $this->user;

		$this->form_validation->set_rules('delivery_urgency', $this->lang->line('delivery_urgency'), 'required',array('required'=> $this->lang->line('required')));

		$this->form_validation->set_rules('package_id', $this->lang->line('package_id'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('parcel_image', $this->lang->line('parcel_image'), 'required',array('required'=> $this->lang->line('required')));
		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}	
			$parcel_image = $this->input->post('parcel_image');
			$package_info = $this->common_model->package_details($this->input->post('package_id'));
			$parcel_image_array = explode(',',$package_info->parcel_image);
		
			$vid = str_replace(base_url(), '', $parcel_image);
			
			if(!empty($parcel_image_array)){
				if (($key = array_search($vid,$parcel_image_array)) !== false){
						unlink($parcel_image_array[$key]);
				    unset($parcel_image_array[$key]);
				}
			$package_tours['parcel_image']  = implode(',',$parcel_image_array);
			$this->Common_model->update('package_master',$package_tours,array('package_id'=> $this->input->post('package_id')));
			}

			$data['message'] = 'image remove successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
			
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}


	public function package_search_get(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
			$per_page = isset($_GET['limit']) ? $_GET['limit'] : API_PER_PAGE;
			$destination_latitude =  isset($_GET['destination_latitude']) ? $_GET['destination_latitude'] : 0;
			$destination_longitude = isset($_GET['destination_longitude']) ? $_GET['destination_longitude'] : 0;
			$departure_latitude =  isset($_GET['departure_latitude']) ? $_GET['departure_latitude'] : 0;
			$departure_longitude = isset($_GET['departure_longitude']) ? $_GET['departure_longitude'] : 0;
			$package_info = $this->common_model->package_search($offset,$per_page,$user->id,$destination_latitude,$destination_longitude,$departure_latitude,$departure_longitude, false);
			$data['package'] = $package_info;
			$data['total_rows'] = $this->common_model->package_search(0,0,$user->id,$destination_latitude,$destination_longitude,$departure_latitude,$departure_longitude,true);	
			$data['message'] ='Package List';
			$this->set_response($data, REST_Controller::HTTP_OK);
		}catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
	}



	public function package_get(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
			$per_page = isset($_GET['limit']) ? $_GET['limit'] : API_PER_PAGE;
			$searchString	= '';
			if(isset($_GET['search'])){
				$searchString	= trim($this->input->get('search'));
			}
			$package_info = $this->common_model->package($offset,$per_page,$user->id,$searchString, false);
			$data['package'] =$package_info;
			$data['total_rows'] = $this->common_model->package(0,0,$user->id,$searchString,true);	
			$data['message'] ='Package List';
			$this->set_response($data, REST_Controller::HTTP_OK);
		}catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
 	}

 	public function package_details_get(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$package =  isset($_GET['package_id']) ? $_GET['package_id'] : 0;
			$package_info = $this->common_model->package_details($package);
			if(empty($package_info)){
				$data['message'] = 'No package details found';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
				$package_info->pickup_location = json_decode($package_info->pickup_location);
			 	$package_info->drop_off_location = json_decode($package_info->drop_off_location);
			 	$list = array();
			 	$package_info->recipient_information = json_decode($package_info->recipient_information);
			 	if(!empty($package_info->parcel_image)){
			 	$package_info->parcel_image = explode(',',$package_info->parcel_image);
			 	
				 	foreach($package_info->parcel_image as $value){
						$list[] = base_url().$value;
				 	}
			 	}
			 	$package_info->parcel_image = $list;
		
			$data['package'] =$package_info;
			$data['message'] ='Package Details';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
 	}

 	public function ratting_post(){
		$this->_authRequest();
		$user = $this->user;

		$this->form_validation->set_rules('ratting', $this->lang->line('ratting'), 'required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));

		$this->form_validation->set_rules('blog_id', $this->lang->line('blog_id'), 'required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));

		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$ratting =$this->common_model->get_row('blog_ratting',array('blog_id'=>$this->input->post('blog_id'),'created_by'=>$user->id));
			if(!empty($ratting)){

				$data['status'] = False;
				$data['message'] = 'Your are already send ratting this blog';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			} 
			$blog  = array(
				'blog_id'		=>	$this->input->post('blog_id'),
				'ratting'		=>  $this->input->post('ratting'),
			 	'created_by'		=>	$user->id,
				'created_ip'		=>	$this->input->ip_address(),
				'created_at'		=> date('Y-m-d h:i:s'),
			);
			if(!$this->Common_model->insert('blog_ratting',$blog)){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$data['message'] = 'Ratting add successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
 	}

 	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 12-09-2018 12:00 PM
	**************************/

 	public function add_tour_post(){
		$this->_authRequest();
		$user = $this->user;

		$this->form_validation->set_rules('departure_city', $this->lang->line('departure_city'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('departure_date', $this->lang->line('departure_date'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('destination_city', $this->lang->line('destination_city'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('arrival_datetime', $this->lang->line('arrival_datetime'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('travel_by', $this->lang->line('travel_by'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('travelling_details', $this->lang->line('travelling_details'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('stay_time', $this->lang->line('stay_time'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('is_international', $this->lang->line('is_international'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('is_flexible', $this->lang->line('is_flexible'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('status',$this->lang->line('status'), 'required',array('required'=> $this->lang->line('required')));
		try {
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			
			 if($_POST['is_international']=='true'){$is_international= 1;} else{ $is_international= 0;} 
		   if($_POST['is_flexible']=='true'){$is_flexible= 1;} else{ $is_flexible= 0;} 

			$user_tours  = array(
				'departure_city'	=>	$this->input->post('departure_city'),
				'destination_city'		=>  $this->input->post('destination_city'),
			  'departure_date'			=>	$this->input->post('departure_date'),
				'travelling_details'	=>	$this->input->post('travelling_details'),
				'arrival_datetime'	=>	$this->input->post('arrival_datetime'),
				'travel_by'			=>	$this->input->post('travel_by'),
				'stay_time'			=>	$this->input->post('stay_time'),
				'is_international'	=>	$is_international, 
				'is_flexible'	=> $is_flexible,
				'international_status' =>	$this->input->post('international_status'),
				'status' 			=>  $this->input->post('status'),
				'additional_information' 	=>  $this->input->post('additional_information'),
				'destination_latitude'=>	$this->input->post('destination_latitude'),
				'destination_longitude'=>	$this->input->post('destination_longitude'),
				'departure_latitude'	=>	$this->input->post('departure_latitude'),
				'departure_longitude'	=>	$this->input->post('departure_longitude'),
				'created_by'		=>	$user->id,
				'user_id'		=>	$user->id,
				'created_ip'		=>	$this->input->ip_address(),
				'created_at'		=> date('Y-m-d h:i:s'),
			);

			if($this->input->post('tour_id')!==null){
      	if(!$this->Common_model->update('user_tours',$user_tours,array('user_id' => $user->id,'tour_id'=> $this->input->post('tour_id')))){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
				$data['tour_id'] = $this->input->post('tour_id');
				$data['message'] = 'Trip update successfully!'; 
      }else{
      	if(!$tour_id=$this->Common_model->insert('user_tours', $user_tours)){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				}
				$data['tour_id'] = $tour_id;
				$data['message'] = 'Trip add successfully!';
			}

			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}

	public function tour_get(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
			$per_page = isset($_GET['limit']) ? $_GET['limit'] : API_PER_PAGE;
			$searchString	= null;
			if(isset($_GET['search'])){
				$searchString	= trim($this->input->get('search'));
			}
			$tour_info = $this->common_model->tour($offset,$per_page,$user->id,$searchString, false);
			$data['tour'] =$tour_info;
			$data['total_rows'] = $this->common_model->tour(0,0,$user->id,$searchString,true);	
			$data['message'] ='Trip List';
			$this->set_response($data, REST_Controller::HTTP_OK);
		}catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
 	}

 	public function tour_details_get(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$tour =  isset($_GET['tour_id']) ? $_GET['tour_id'] : 0;
			$tour_info = $this->common_model->tour_details($tour);
			if(empty($tour_info)){
				$data['message'] = 'No tour details found';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$tour_info->travelling_details = json_decode($tour_info->travelling_details);
			$data['tour'] =$tour_info;
			$data['message'] ='Trip Details';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
 	}

 	public function tour_search_get(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
			$per_page = isset($_GET['limit']) ? $_GET['limit'] : API_PER_PAGE;
			$destination_latitude =  isset($_GET['destination_latitude']) ? $_GET['destination_latitude'] : 0;
			$destination_longitude = isset($_GET['destination_longitude']) ? $_GET['destination_longitude'] : 0;
			$departure_latitude =  isset($_GET['departure_latitude']) ? $_GET['departure_latitude'] : 0;
			$departure_longitude = isset($_GET['departure_longitude']) ? $_GET['departure_longitude'] : 0;
			$tour_info = $this->common_model->tour_search($offset,$per_page,$user->id,$destination_latitude,$destination_longitude,$departure_latitude,$departure_longitude, false);
			$data['tour_info'] = $tour_info;
			$data['total_rows'] = $this->common_model->tour_search(0,0,$user->id,$destination_latitude,$destination_longitude,$departure_latitude,$departure_longitude,true);	
			$data['message'] ='Trip List';
			$this->set_response($data, REST_Controller::HTTP_OK);
		}catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
	}

 	public function delete_tour_delete($tour_id=''){
		$this->_authRequest();
		$user = $this->user;
		if(empty($tour_id) && $tour_id < 1){
 			throw new Exception('No Trip Id Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		$delete = $this->common_model->update('user_tours',array('status'=>2),array('tour_id'=>$tour_id));

		try{
			if ($delete !=1 )	{
				 throw new Exception('invalid id', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['message'] = 'Deleted';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 		
	}

	public function delete_package_delete($package_id=''){
		$this->_authRequest();
		$user = $this->user;
		if(empty($package_id) && $package_id < 1){
 			throw new Exception('No Detail Found', REST_Controller::HTTP_BAD_REQUEST);	
		}
		$delete= $this->common_model->update('package_master',array('status'=>2),array('package_id'=>$package_id));
		try{
		if ($delete !=1 )	{
				 throw new Exception('invalid id', REST_Controller::HTTP_BAD_REQUEST);	
			}
			$data['message'] = 'Deleted';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
			$this->set_response($data, $e->getCode());
		}	
 	}


 	private function getTicket_No(){
		return $rnd_no = md5(uniqid(rand(100000, 999999), true));
	}

	public function contact_us_post()
    { 
		try{
			

			$this->form_validation->set_rules('name', $this->lang->line('name'), 'required|max_length[30]',array('required'=> $this->lang->line('required'),'max_length'=> $this->lang->line('max_length_thirty')));

			$this->form_validation->set_rules('email', $this->lang->line('email'), 'required|valid_email|callback_email_check',array('required'=> $this->lang->line('required'),'valid_email'=> $this->lang->line('valid_email')));

			$this->form_validation->set_rules('subject',$this->lang->line('subject'), 'required|trim',array('required'=> $this->lang->line('required')));
			$this->form_validation->set_rules('message', $this->lang->line('message'), 'required|trim|max_length[300]',array('required'=> $this->lang->line('required'),'max_length'=> $this->lang->line('max_length_threehundread')));
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
				$user_info = $this->common_model->get_row('user_master',array('email'=>$this->input->post('email'),'status!='=>2,'user_role' =>'user'));
				$user_data['name']=  $this->input->post('name');
				$user_data['email']  =  $this->input->post('email');
				if($user_info){
					$user_data['user_id']= $user_info->user_id;
					$user_data['user_role']= 1;
				}else{
					$user_data['user_role']= 3;
				}
				$ticket_no = $this->getTicket_No();
				$user_data['ticket_no'] = $ticket_no;
				$user_data['message']=  strip_tags($this->input->post('message'));
				$user_data['subject']=  $this->input->post('subject');
				$user_data['created']=  date('Y-m-d H:i:s');
				$user_data['user_ip']  =  $this->input->ip_address();

			if(!$this->common_model->insert('support', $user_data)){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$data['message'] = 'Support add successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
  }



  public function slider_images_get(){
  $slider_img =	"CONCAT('".base_url()."',slider_img) as slider_img";
  
		$data['slider_images'] = $this->common_model->get_result('slider_images',array('status'=>1),array($slider_img));

		if($this->language=='ar'){
			$fild=	array('main_title_hebrew as main_title','sub_title1_hebrew as sub_title1','sub_content1_hebrew as sub_content1','button1_hebrew as button1','sub_title2_hebrew as sub_title2','sub_content2_hebrew as sub_content2','button2_hebrew as button2','url1','url2');;
		}else{
			$fild=	array('main_title','sub_title1','sub_content1','button1','sub_title2','sub_content2','button2','url1','url2');
		}

		$data['slider_content'] = $this->common_model->get_row('home_content',array('home_content_id'=>1),$fild,array());

		$data['message'] ='slider images';
		$this->set_response($data, REST_Controller::HTTP_OK);
	} 

	public function about_us_get(){
		$background_image =	"CONCAT('".base_url()."',background_image) as background_image";
		$image =	"CONCAT('".base_url()."',image) as image";
		if($this->language=='ar'){
			$fild=	array('title_hibaru as title','content_hibaru as content',$background_image,$image);
		}else{
			$fild=	array('title_english as title','content_english as content',$background_image,$image);
		}
		$data['about_us'] = $this->common_model->get_row('home_page',array('id'=>1),$fild,array());
		$data['message'] ='About Us';
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function how_it_work_get(){
		
		$image =	"CONCAT('".base_url()."',image) as image";
		if($this->language=='ar'){
			$fild=	array('title_hibaru as title','content_hibaru as content',$image);
		}else{
			$fild=	array('title_english as title','content_english as content',$image);
		}
		$section[0] = $this->common_model->get_row('home_page',array('id'=>4),$fild,array());
		$section[1] = $this->common_model->get_row('home_page',array('id'=>5),$fild,array());
		$section[2] = $this->common_model->get_row('home_page',array('id'=>6),$fild,array());
		$section[3] = $this->common_model->get_row('home_page',array('id'=>7),$fild,array());
		$data['message'] ='how it work';
		$data['list'] = $section;
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function page_get(){
		$slug =   isset($_GET['slug']) ? $_GET['slug'] : 0;
		try{
		$data['page'] = $this->common_model->get_row('pages',array('slug'=>$slug),array('description,meta_description,meta_keyword,meta_content,title,type_of_section'),array());
		if(empty($data['page'])){
			$data['page'] = [];
			$data['message'] ='page not found';
			$list = json_encode($data);
			throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
		}
		$data['message'] ='page information';
		$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}

	public function page_list_get(){
		
		$slug =   isset($_GET['slug']) ? $_GET['slug'] : 0;
		try{
		$data['page_list'] = $this->common_model->get_result('pages',array('status'=>1),array('title,type_of_section,slug'),array());
		if(empty($data['page_list'])){
			$data['page_list'] = [];
			$data['message'] ='page list not found';
			$list = json_encode($data);
			throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
		}
		$data['message'] ='page list';
		$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}

	public function get_touch_get(){
		$background_image =	"CONCAT('".base_url()."',background_image) as background_image";
		$image =	"CONCAT('".base_url()."',image) as image";
		if($this->language=='ar'){
			$fild=	array('title_hibaru as title','content_hibaru as content',$background_image,$image);
		}else{
			$fild=	array('title_english as title','content_english as content',$background_image,$image);
		}
		$data['get_touch'] = $this->common_model->get_row('home_page',array('id'=>3),$fild,array());
		$data['message'] ='get touch';
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function download_app_get(){
		$background_image =	"CONCAT('".base_url()."',background_image) as background_image";
		$image =	"CONCAT('".base_url()."',image) as image";
		if($this->language=='ar'){
			$fild=	array('title_hibaru as title','content_hibaru as content',$background_image,$image);
		}else{
			$fild=	array('title_english as title','content_english as content',$background_image,$image);
		}
		$data['download_app'] = $this->common_model->get_row('home_page',array('id'=>2),$fild,array());
		$data['message'] ='Download App';
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function user_story_get(){
		$image =	"CONCAT('".base_url()."',	user_image) as 	user_image";

		if($this->language=='ar'){
			$fild=	array($image,'user_name_arabic as user_name','story_title_arabic as story_title','content_arabic as content','created');
		}else{
			$fild=	array($image,'user_name','story_title','content','created');
		}

		$data['story'] = $this->common_model->get_result('user_story',array('status'=>1),$fild,array('order','ASC'));
		if(empty($data['story'])){
			$data['story']= array();
		}

		$data['message'] ='User Story';
		$this->set_response($data, REST_Controller::HTTP_OK);
	}


	public function setting_get(){
		
		$data['EMAIL'] = $this->common_model->get_row('site_config',array('meta_key'=>'EMAIL'),array('meta_value','meta_value'),array());
		$data['ADDRESS'] = $this->common_model->get_row('site_config',array('meta_key'=>'ADDRESS'),array('meta_value','meta_value'),array());
		$data['CONTACT'] = $this->common_model->get_row('site_config',array('meta_key'=>'CONTACT'),array('meta_value','meta_value'),array());
		$data['message'] ='setting';
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function feedback_subject_get(){
		$data['subject'] = feedback_subject_status_Api();
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	public function newsletter_post()
    { 
		try{
			$this->form_validation->set_rules('email','Email','required|valid_email|trim');

			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$user_info = $this->common_model->get_row('newsletter',array('email'=>$this->input->post('email')));
			if(!empty($user_info))
			{	$data['message'] = 'Subscribed for newsletter successfully!';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_OK);
			}
			
				$user_data['email']  =  $this->input->post('email');
				
				$user_data['created_at']=  date('Y-m-d H:i:s');
				$user_data['user_ip']  =  $this->input->ip_address();

			if(!$this->common_model->insert('newsletter', $user_data)){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			/******************Send email*************************/
			$this->chapter247_email->set_email_templates(101);
			$param = array(
				"template"=>array(
					"var_name" => array(
						"email"=> $this->input->post('email')
					)
				),
				"email" => array(
					"to"        =>   $this->input->post('email'),
					"from"      =>   SUPPORT_EMAIL,
					"from_name" =>   NO_REPLY_EMAIL_FROM_NAME
				)
			);
			$this->chapter247_email->send_mail($param);
			/*****************************************************/
			$data['message'] = 'Subscribed for newsletter successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
  }

  public function message_send_post()
    { $this->_authRequest();
			$user = $this->user;
		try{
	


			$this->form_validation->set_rules('type',$this->lang->line('type'),'required|trim',array('required'=> $this->lang->line('required')));
			$this->form_validation->set_rules('tour_id',$this->lang->line('tour_id'),'required|trim',array('required'=> $this->lang->line('required')));
			$this->form_validation->set_rules('package_id',$this->lang->line('package_id'),'required|trim',array('required'=> $this->lang->line('required')));
			$this->form_validation->set_rules('message',$this->lang->line('message'),'required|trim',array('required'=> $this->lang->line('required')));
			$this->form_validation->set_rules('receiver_id',$this->lang->line('receiver_id'),'required|trim',array('required'=> $this->lang->line('required')));

			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}

			$package_id= $this->input->post('package_id');
			$tour_id= $this->input->post('tour_id');
			$type=$this->input->post('type');
			$receiver_id =$this->input->post('receiver_id');
			$sender_id = $user->id;
			$message = $this->input->post('message');
			$message_info = $this->common_model->message_master_get($package_id,$tour_id,$type,$sender_id,$receiver_id);
			if($sender_id==$receiver_id){
				$data['message'] = 'you can not send message your self';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
			}
			if(!empty($message_info))
			{	if($message_info->is_accepted==1){ 

					$user_message['message']=  strip_tags($message);
					$user_message['sender_id']=  $user->id;
					$user_message['message_id']=  $message_info->message_id;
					$user_message['created']=  date('Y-m-d H:i:s');
					$user_message['created_ip']  =  $this->input->ip_address();

					if($message_info->sender_id==$sender_id){ 
					$this->Common_model->update('message_master',array('receiver_read_count' =>$message_info->receiver_read_count+1),array('message_id'=>$message_info->message_id));
					}else{
						$this->Common_model->update('message_master',array('sender_read_count' =>$message_info->sender_read_count+1),array('message_id'=>$message_info->message_id));
					}

					$this->common_model->insert('message_meta', $user_message);
					$data['message'] = 'Message sent successfully!';
					$list = json_encode($data);
					throw new Exception($list, REST_Controller::HTTP_OK);
				}else if($message_info->is_accepted==2){

					if($message_info->sender_id==$sender_id){
						$data['message'] = 'Chat invitation is rejected by user';
						$list = json_encode($data);
						throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
					}else{

						$data['message'] = 'You rejected chat invitation.';
						$list = json_encode($data);
						throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
					}
				}else {

					if($message_info->sender_id==$sender_id){
						$data['message'] = 'Chat invitation is not accepted from user';
						$list = json_encode($data);
						throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
					}else{

						$data['message'] = 'Please accept chat invitation to send message';
						$list = json_encode($data);
						throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);
					}
				}
				
			}
			
			$user_data['type']  =  $this->input->post('type');
			$user_data['tour_id']  =  $this->input->post('tour_id');
			$user_data['package_id']  =  $this->input->post('package_id');
			$user_data['created_at']=  date('Y-m-d H:i:s');
			$user_data['created_ip']  =  $this->input->ip_address();
			$user_data['sender_id']  =  $user->id;
			$user_data['receiver_id']  =  $this->input->post('receiver_id');
			$user_data['receiver_read_count']  =  1;
		
			if(!$message_id =$this->common_model->insert('message_master', $user_data)){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
				$user_message['message']=  strip_tags($message);
				$user_message['sender_id']=  $user->id;
				$user_message['message_id']=  $message_id;
				$user_message['created']=  date('Y-m-d H:i:s');
				$user_message['created_ip']  =  $this->input->ip_address();
			$this->common_model->insert('message_meta', $user_message);
			$data['message'] = 'Message sent successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
  }

	/**************************
  Created By: Sonu Bamniya
  Created At: 06 Oct, 2018 05:00 PM
  **************************/
  public function my_message_get(){
		$this->_authRequest();
		$user = $this->user;
		$data['message_info'] = $this->common_model->get_converstation_list($user->id, trim($this->input->get('type')));
		$data['message'] ='my message';
		$this->set_response($data, REST_Controller::HTTP_OK);
	}


	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 08-10-2018 11:00 AM
	**************************/

	public function get_support_get(){
		$this->_authRequest();
		$user = $this->user;
		$data['message_info'] = $this->common_model->get_support($user->id);
		$data['message'] ='support list';
		$this->set_response($data, REST_Controller::HTTP_OK);
	}
	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 08-10-2018 11:30 AM
	**************************/

	public function get_support_message_get(){
		$this->_authRequest();
		$user = $this->user;
		$support_id = isset($_GET['support_id']) ? $_GET['support_id'] : 0;
		$ticket_no = isset($_GET['ticket_id']) ? $_GET['ticket_id'] : 0;

		if($support_id == 0){
			$data['all_message'] = array();
		}else{
			$data['all_message'] = $this->common_model->get_support_message($support_id,$user->id,$ticket_no);
		}
		$data['message'] ='support message';
		$this->set_response($data, REST_Controller::HTTP_OK);
	}

	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 08-10-2018 12:30 AM
	**************************/

	public function support_message_send_post()
    { 
    $this->_authRequest();
		$user = $this->user;
		try{

			$this->form_validation->set_rules('type',$this->lang->line('type'),'required|trim',array('required'=> $this->lang->line('required')));

			$this->form_validation->set_rules('message', $this->lang->line('message'), 'required|trim|max_length[250]',array('required'=> $this->lang->line('required'),'max_length'=> $this->lang->line('max_length_two_fifty')));
			$this->form_validation->set_rules('support_id', $this->lang->line('support_id'), 'required|trim|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));
			$this->form_validation->set_rules('ticket_id', $this->lang->line('ticket_id'), 'required|trim',array('required'=> $this->lang->line('required')));
			
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
				$parent_id =	$this->input->post('support_id');
				$message = $this->input->post('message');
				$ticket_no = $this->input->post('ticket_id');
				$user_data['message']=  strip_tags($message);
				$user_data['user_role']=  1;
				$user_data['ticket_no']= $ticket_no;
				$user_data['user_id']=  $user->id;
				$user_data['parent_id']=  $parent_id;
				$user_data['created']=  date('Y-m-d H:i:s');
				$user_data['user_ip']  =  $this->input->ip_address();

			if(!$this->common_model->insert('support', $user_data)){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$data['new_message'] = array('message'=>$message,'created'=> $user_data['created'],'is_sender'=>true);
			$data['message'] = 'message send successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
  }

  /**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 08-10-2018 2:00 AM
	**************************/

	public function message_send_reply_post(){
	 	$this->_authRequest();
		$user = $this->user;
		try{
			$this->form_validation->set_rules('message', $this->lang->line('message'), 'required|trim|max_length[1000]',array('required'=> $this->lang->line('required'),'max_length'=> $this->lang->line('max_length_thousand')));

			$this->form_validation->set_rules('message_id', $this->lang->line('message_id'), 'required|trim',array('required'=> $this->lang->line('required')));

			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
				$message_id =	$this->input->post('message_id');
				$message = $this->input->post('message');
				$user_data['message']=  strip_tags($message);
				$user_data['sender_id']=  $user->id;
				$user_data['message_id']=  $message_id;
				$user_data['created']=  date('Y-m-d H:i:s');
				$user_data['created_ip']  =  $this->input->ip_address();

			if(!$this->common_model->insert('message_meta', $user_data)){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$data['message'] = 'message send successfully!';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}

	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 08-10-2018 3:00 AM
	**************************/
	public function message_list_get(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$offset =   isset($_GET['offset']) ? $_GET['offset'] : 0;
			$message_id =  isset($_GET['message_id']) ? $_GET['message_id'] : 0;
			$per_page = isset($_GET['limit']) ? $_GET['limit'] : 1000;
			$message_list = $this->common_model->message_list($offset,$per_page,$user->id,$message_id);
			$data['message_list'] = $message_list;
			$data['offset'] = $offset;
			$data['limit'] = $per_page;
			$data['total_rows'] = $this->common_model->message_list(0,0,$user->id,$message_id);	
			$data['message'] ='message list';
			$this->set_response($data, REST_Controller::HTTP_OK);
		}catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
	}


	public function chat_messages_get(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$package_id = isset($_GET['package_id']) ? $_GET['package_id'] : 0;
			$tour_id 		= isset($_GET['tour_id']) ? $_GET['tour_id'] : 0;
			$type 			= isset($_GET['type']) ? $_GET['type'] : -1;
			$master_list = $this->common_model->get_message_master_list($package_id,$tour_id,$type,$user->id);
			$data['master_list'] = $master_list;
			$data['message'] ='message list';
			$this->set_response($data, REST_Controller::HTTP_OK);
		}catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
	}

	public function message_accepted_post(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$this->form_validation->set_rules('status', $this->lang->line('status'), 'required|trim|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));

			$this->form_validation->set_rules('message_id', $this->lang->line('message_id'), 'required|trim|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}

			if(!$this->Common_model->update('message_master',array('is_accepted' => $this->input->post('status')),array('message_id'=>$this->input->post('message_id')))){
				$data['message'] = 'Something Went Wrong. Please try again.';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			if($this->input->post('status')==1){
				$data['message'] = 'accepted successfully!';
			}else{
				$data['message'] = 'rejected successfully!';
			}
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}


	public function change_password_post(){
		$this->_authRequest();
		$user = $this->user;
		try{


			$this->form_validation->set_rules('oldpassword', $this->lang->line('oldpassword'), 'trim|required|callback_password_check['.$user->id.']',array('required'=> $this->lang->line('required')));
;

			$this->form_validation->set_rules('newpassword',$this->lang->line('newpassword'), 'trim|required|matches[confpassword]',array('required'=> $this->lang->line('required'),'matches'=> $this->lang->line('match_newpassword')));

			$this->form_validation->set_rules('confpassword',$this->lang->line('confpassword'),'trim|required',array('required'=> $this->lang->line('required')));
		
			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$user_data  = array('password' =>  password_hash($this->input->post('newpassword'), PASSWORD_DEFAULT));
				if($this->Common_model->update('user_master',$user_data,array('user_id'=>$user->id))){
				$data['message'] = 'Password has been updated successfully';
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
	
	
		$user_info = $this->Common_model->get_row('user_master',array('user_id'=>$id));
	
		if (password_verify($oldpassword, $user_info->password))
		{
			return TRUE;
		}else{
			$this->form_validation->set_message('password_check', 'The %s does not match');
			return FALSE;
		}

	}

	public function confirmed_package_post(){
		$this->_authRequest();
		$user = $this->user;
		try{

			$this->form_validation->set_rules('tour_id', $this->lang->line('tour_id'), 'trim|required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));
			$this->form_validation->set_rules('package_id', $this->lang->line('package_id'), 'trim|required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));

			$this->form_validation->set_rules('message_id', $this->lang->line('message_id'), 'trim|required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));

			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}  
				$package_id = $this->input->post('package_id');
				$tour_id = $this->input->post('tour_id');
				$message_id = $this->input->post('message_id');
				$tokan_array = array('package_id'=>$package_id,'tour_id'=>$tour_id,'message_id'=>$message_id);
				$token = AUTHORIZATION::generateToken($tokan_array);
				$confirmed_package  = array('is_confirmed' => 1,'token' => $token,'tour_id' => $tour_id,'status' => 3);
				$confirmed  = array('is_confirmed' => 1,'status' => 3);
				$this->Common_model->update('package_master',$confirmed_package,array('package_id'=>$this->input->post('package_id')));
				$this->Common_model->update('user_tours',$confirmed,array('tour_id'=>$this->input->post('tour_id')));
				if($this->Common_model->update('message_master',$confirmed,array('message_id'=>$this->input->post('message_id')))){
				$data['message'] = 'confirmed package successfully';
				$data['token'] = $token;
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

	public function promo_code_post(){
		$this->_authRequest();
		$user = $this->user;
		try{
			$this->form_validation->set_rules('promo_code', $this->lang->line('promo_code'), 'trim|required',array('required'=> $this->lang->line('required')));

			$this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required',array('required'=> $this->lang->line('required')));

			if ($this->form_validation->run() == False)	{
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}
			$totalAmout =0;
			$promo_code = $this->input->post('promo_code');
			$amount = $this->input->post('amount');
			if($promo = $this->Common_model->get_row('promo_code',array('promo_code'=>$promo_code),array('type','	percentage','flat'))){
				if($promo->type == 'flat'){
						if($promo->flat >= $amount){
							$totalAmout=	siteConfig('MINIMUM_AMOUNT')->meta_value;
						}else{
							$totalAmout= $amount - $promo->flat;
						}
				}else{
						$newamout =	($amount *$promo->percentage)/100;
						 $totalAmout= $amount - $newamout;
						if($totalAmout >= $amount){
							$totalAmout =	siteConfig('MINIMUM_AMOUNT')->meta_value;
						}
				}
			$data['message'] = 'promo code applied successfully';
			$data['total_amout'] = $totalAmout;
			$list = json_encode($data);
			throw new Exception($list, REST_Controller::HTTP_OK);
			}else{
			$data['message'] = 'Sorry! promo code is expired';
			$list = json_encode($data);
			throw new Exception($list, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}
	}

	public function payment_post(){
		$this->_authRequest();
		$user = $this->user;

		$this->form_validation->set_rules('tour_id', $this->lang->line('tour_id'), 'required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));

		$this->form_validation->set_rules('package_id',$this->lang->line('package_id'), 'required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));

		$this->form_validation->set_rules('amount',$this->lang->line('amount'), 'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('expiry_date',$this->lang->line('expiry_date'),'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('cvc',$this->lang->line('cvc'),'required|numeric|max_length[4]',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric'),'max_length'=> $this->lang->line('max_length_four')));

		$this->form_validation->set_rules('card',$this->lang->line('card'),'required|max_length[20]',array('required'=> $this->lang->line('required'),'max_length'=> $this->lang->line('max_length_twenty')));

		$this->form_validation->set_rules('holder_name',$this->lang->line('holder_name'),'required',array('required'=> $this->lang->line('required')));

		$promo_code =	$this->input->post('promo_code');
		try {
			if($this->form_validation->run() == False){
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
			$code =	getData('promo_code',array('promo_code',$promo_code));
			$promo_info ="";
			if(!empty($code)){
				if($code->type == 'flat'){
					$type =	$code->flat;
				}else{
					$type =	$code->percentage;
				}
				$promo_info = $code->type.'-'.$type;
			}
			$invoice_id = $this->common_model->create_invoice_id();

			$payment  = array(
				'package_id'=>	$this->input->post('package_id'),
				'tour_id'		=>	$this->input->post('tour_id'),
				'amount'		=>  $this->input->post('amount'),
				'promo_code' =>  $this->input->post('promo_code'),
				'promo_info' =>  $promo_info,
				'created_by' =>  $user->id,
				'invoice_id' =>  $invoice_id,
				'created_ip' =>  $this->input->ip_address(),
				'holder_name' =>  $this->input->post('holder_name'),
				'expiry_date' =>  $this->input->post('expiry_date'),
				'card' =>  $this->input->post('card'),
			);
	
      if(!$this->Common_model->insert('payment', $payment)){
				throw new Exception("Something Went Wrong. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}

			$confirmed_package  = array('status' => 4);
			$this->Common_model->update('package_master',$confirmed_package,array('package_id'=>$this->input->post('package_id')));
			$this->Common_model->update('user_tours',$confirmed_package,array('tour_id'=>$this->input->post('tour_id')));
			$data['message'] = 'payment successfull';
		
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}		
	}

	public function payment_url_get(){
		$token =   isset($_GET['token']) ? $_GET['token'] : False;
		try {
			$list = AUTHORIZATION::validateLanguageToken($token);
			if(!empty($list)){
				if(!property_exists($list, 'package_id')){
			    $data['message'] = 'token not valid';
					$list = json_encode($data);
					throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
	    	}
			}else{
				$data['message'] = 'token not valid';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);	
			}

			$package_info = $this->common_model->package_details_info($list->package_id);
			$tour_info = $this->common_model->tour_details($list->tour_id);
			$data['departure_location']=$package_info->departure_location;
			$data['destination_location']=$package_info->destination_location;
			$data['amount']='50';
			$data['package_id']=$list->package_id;
			$data['tour_id']=$list->tour_id;
			$data['first_name']=$tour_info->first_name;
			$data['message'] = 'True';
			$this->set_response($data, REST_Controller::HTTP_OK);

		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
	}

	public function change_package_status_get(){
		$this->_authRequest();
		$user = $this->user;

		$this->form_validation->set_rules('status',$this->lang->line('status'),'required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));

		$this->form_validation->set_rules('package_id',$this->lang->line('package_id'), 'required|numeric',array('required'=> $this->lang->line('required'),'numeric'=> $this->lang->line('numeric')));
		try {
			if($this->form_validation->run() == False){
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
			$status = $this->input->post('status');
			$confirmed_package = array('status' => $status);

			if(!$this->Common_model->update('package_master',$confirmed_package,array('package_id'=> $this->input->post('package_id')))){
				throw new Exception("package status change false. Please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$data['message'] = 'package status change';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
	}

	public function package_rating_post(){
		$this->_authRequest();
		$user = $this->user;
		$this->form_validation->set_rules('rating',$this->lang->line('rating'),'required',array('required'=> $this->lang->line('required')));
		$this->form_validation->set_rules('package_id',$this->lang->line('package_id'),'required',array('required'=> $this->lang->line('required')));
		// $this->form_validation->set_rules('package_user_id','package_user_id','required');
		try {
			if($this->form_validation->run() == False){
				$data['status'] = False;
				$data['error'] = 	$this->form_validation->error_array();
				$data['message'] = 'validation error';
				$list = json_encode($data);
				throw new Exception($list, REST_Controller::HTTP_BAD_REQUEST);		
			}
			$package_id = $this->input->post('package_id');
			$rating = $this->input->post('rating');
			$message = $this->input->post('message_rating');
			$package_user_id = $this->input->post('package_user_id');

			$confirmed_package = array('type'=>'package','rating_type_id'=>$package_id,'rating'=> $rating,'message'=>$message,'user_id' =>0,'created_by'=> $user->id);

			if(!$this->Common_model->insert('user_ratting',$confirmed_package)){
				throw new Exception("package rating false. please try again.", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
			}
			$data['message'] = 'package ratting add';
			$this->set_response($data, REST_Controller::HTTP_OK);
		} catch (Exception $e) {
			$info = json_decode($e->getMessage());
			$this->set_response($info, $e->getCode());
		}	
	}


}
/* End of file Api.php */
/* Location: ./application/controllers/Api/Api.php */

