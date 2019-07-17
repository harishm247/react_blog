<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Superadmin extends CI_Controller {
	public function __construct(){
        parent::__construct();
        clear_cache();
        $this->load->model('superadmin_model');       
       $this->load->library('chapter247_email');      
    }
	public function index(){
		redirect('behindthescreen');
	}
	private function _check_login(){		
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}
	public function login(){ 
		if(superadmin_logged_in()===TRUE) redirect('backend/superadmin/dashboard');
		 $data['title']='Admin login';
		 $this->form_validation->set_rules('password', 'Password', 'trim|required');
		 $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() == TRUE){
			$this->load->model('user_model');
			$email     = $this->input->post('email');
       		$password  = $this->input->post('password');
			if($this->user_model->login($email,$password)){ 
				redirect('backend/superadmin/dashboard');
			}else{
				redirect('behindthescreen');
			}
		}		
		$this->load->view('backend/login');
	}
	public function logout(){
		$this->_check_login(); //check  login authentication
		$this->session->sess_destroy();
		redirect(base_url().'behindthescreen');
	}
    public function dashboard($id='')
	{   
		$data['title']='Dashboard';
		$this->_check_login();
		$data['user'] = $this->common_model->get_row('users',array('user_id'=>$id));
		$data['social_media'] = $this->common_model->get_row('fh_social_media',array('user_id'=>$id));
      	$data['approve_by_admin_blog'] = $this->common_model->get_result_count('fh_blog_articles',array('approved_by_admin'=>1),'blog_id');	
      	$data['unapprove_by_admin_blog'] = $this->common_model->get_result_count('fh_blog_articles',array('approved_by_admin'=>0),'blog_id');
      	$data['pending_by_admin_blog'] = $this->common_model->get_result_count('fh_blog_articles',array('approved_by_admin'=>3),'blog_id');$data['approve_by_admin_video'] = $this->common_model->get_result_count('fh_videos',array('approved_by_admin'=>1),'v_id');	
      	$data['unapprove_by_admin_video'] = $this->common_model->get_result_count('fh_videos',array('approved_by_admin'=>0),'v_id');
      	$data['pending_by_admin_video'] = $this->common_model->get_result_count('fh_videos',array('approved_by_admin'=>3),'v_id');$data['approve_by_admin_shop'] = $this->common_model->get_result_count('fh_shop',array('approved_by_admin'=>1),'shop_id');	
      	$data['unapprove_by_admin_shop'] = $this->common_model->get_result_count('fh_shop',array('approved_by_admin'=>0),'shop_id');
      	$data['pending_by_admin_shop'] = $this->common_model->get_result_count('fh_shop',array('approved_by_admin'=>3),'shop_id');$data['approve_by_admin_trips'] = $this->common_model->get_result_count('fh_upcoming_trips',array('approved_by_admin'=>1),'up_t_id');	
      	$data['unapprove_by_admin_trips'] = $this->common_model->get_result_count('fh_upcoming_trips',array('approved_by_admin'=>0),'up_t_id');
      	$data['pending_by_admin_trips'] = $this->common_model->get_result_count('fh_upcoming_trips',array('approved_by_admin'=>3),'up_t_id');$data['approve_by_admin_desti'] = $this->common_model->get_result_count('fh_favorite_destinations',array('approved_by_admin'=>1),'favorite_id');	
      	$data['unapprove_by_admin_desti'] = $this->common_model->get_result_count('fh_favorite_destinations',array('approved_by_admin'=>0),'favorite_id');
      	$data['pending_by_admin_desti'] = $this->common_model->get_result_count('fh_favorite_destinations',array('approved_by_admin'=>3),'favorite_id');$data['approve_by_admin_incre'] = $this->common_model->get_result_count('fh_favorite_incredible_places',array($id,'approved_by_admin'=>1),'incredible_id');	
      	$data['unapprove_by_admin_incre'] = $this->common_model->get_result_count('fh_favorite_incredible_places',array($id,'approved_by_admin'=>0),'incredible_id');
      	$data['pending_by_admin_incre'] = $this->common_model->get_result_count('fh_favorite_incredible_places',array($id,'approved_by_admin'=>3),'incredible_id');
      	$data['infludata'] = $this->common_model->get_influence_count();
      	$data['influenceusers'] = $this->common_model->influencer_user();
      	$data['totlaUser'] = $this->common_model->get_total_count();
		$data["users"] = $this->common_model->get_recent_users();
		$data['template']='backend/users/admin_dashboard';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function profile(){
		$this->_check_login(); //check login authentication
		$data['title']='Account Details';
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		// $this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE)	{
			$user_data  = array(
							'first_name'	=>	$this->input->post('firstname'),
							'last_name'	=>  $this->input->post('lastname'),
							'email'		=>	$this->input->post('email'),
							);
			if($this->superadmin_model->update('users', $user_data,array('user_id'=>superadmin_id()))){
				 $this->session->set_flashdata('msg_success','Profile details updated successfully');
				redirect('backend/superadmin/profile');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Profile Updation process has been failed. Please try again');
				redirect('backend/superadmin/profile');
			}
		}else{
			$data['user'] = $this->superadmin_model->get_row('users', array('user_id'=>superadmin_id()));
			$data['template']='backend/profile';
			$this->load->view('templates/superadmin_template',$data);
		}
	}
	public function change_password(){
		$this->_check_login(); //check login authentication
		$data['title']='Change Password';
		$this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required|callback_password_check');
		$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|matches[confpassword]');
		$this->form_validation->set_rules('confpassword','Confirm Password', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			$salt = $this->salt();
			$user_data  = array('salt'=>$salt,'password' => sha1($salt.sha1($salt.sha1($this->input->post('newpassword')))));
			if($this->superadmin_model->update('users',$user_data,array('user_id'=>superadmin_id()))){
				$this->session->set_flashdata('msg_success','Password has been updated successfully');
				//redirect('backend/superadmin/login');
				redirect('backend/superadmin/change_password');
				$inactive = 5; 
				$a = 5; 
				if ($inactive==$a) {    // unset $_SESSION variable for this page
				    session_destroy();   // destroy session data
				    redirect('backend/superadmin/login');
				}
				//session_destroy();
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Password updation process has been failed. Please try again');
				redirect('backend/superadmin/change_password');
			}
		}
		$data['template']='backend/change_password';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function forget_password(){
		$status = false;
		$errorMessage = "something went wrong";
		$email = $this->input->post('email');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$user_data  = array(
				'email'		=> $email,
				'reset_password_time'		=> date('H:i:s'),
				'new_password_key' => random_string('alnum', 20)
			);
		    $matchUserData = $this->superadmin_model->get_row("users",array('email'=>$email),array('user_id,first_name,last_name,email,user_role'));
		    if(!empty($matchUserData)){
		  	 $user_role = $matchUserData->user_role;
			  	if($user_role==0)
			  	{
			  	$this->common_model->update('users', $user_data,array("user_id"=>$matchUserData->user_id));
			      /** Send email for users **/
					$this->chapter247_email->set_language('en');
		    	    $this->chapter247_email->set_email_templates(107);
		    	    $email_template=$this->common_model->get_email('en',107);
					$param = array(
						"template"=>array(
							"var_name" => array(
								"email" => $this->input->post('email'),
								"first_name" => $matchUserData->first_name,
								"last_name" => $matchUserData->last_name,
								"reset_link" => $user_data['new_password_key']
							),
							"temp" => $email_template->template_body,

						),
						"email" => array(
							"to"        =>   'prem.chapter247@gmail.com',
							"from"      =>   SUPPORT_EMAIL,
							"from_name" =>   NO_REPLY_EMAIL_FROM_NAME,
							"subject"   =>  $email_template->template_subject,
						)
					);
					$status = $this->chapter247_email->send_mail($param);
					if($status){
						$errorMessage = 'Password reset link has been sent to '.$email.'. Don\'t forget to check your spam and junk folders if it doesn\'t show up.';
					}else
					{ 
					  	$errorMessage = 'Email Message has not sent'; 
					}
		   		}
			  	else
			  	{
			  	$errorMessage = "Please enter admin email adddress.";
			  	}
		    }
		    else{
		    	$errorMessage = "The email id is not exists in our system";
		    }
		    echo json_encode($errorMessage);
	}
	public function reset_admin_password(){
		$data[] = array(); 
		$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[6]');
 		$this->form_validation->set_rules('confirm_password','Confirm Password', 'trim|required|min_length[6]|matches[password]');
 		if ($this->form_validation->run() == False){
 			$this->session->set_flashdata('msg_error',$this->form_validation->error_array());
				$data["error"] = 	$this->form_validation->error_array();
		}
		else
		{
				if(!empty($_GET['token'])){  
				 	$token_value  = $_GET['token']; 
				 	$user =$this->superadmin_model->get_row('users',array('new_password_key'=>$token_value),array("user_id,email,first_name,reset_password_time"));
					if(!empty($user)){

						$salt = $this->salt();
						$user_data  = array('salt'=>$salt,'password' => sha1($salt.sha1($salt.sha1($this->input->post('password')))),'new_password_key'=>'');
						if($this->superadmin_model->update('users',$user_data,array('user_id'=>1))){
							$this->session->set_flashdata('msg_success','Password has been updated successfully');
								redirect('/reset_admin_password'."?token=".$token_value);	
						}
					}
					else{
						$this->session->set_flashdata('msg_error','Somthing wrong with token, please provide <br> valid token.');
					}
				}
				else
				{
					$this->session->set_flashdata('msg_error','Token is missing');
				}

		}
		$this->load->view('backend/reset_admin_password');
	}
	public function password_check($oldpassword){
		$this->_check_login(); //check login authentication
		$this->load->model('user_model');
		$user_info = $this->user_model->get_row('users',array('user_id'=>superadmin_id()));
        $salt = $user_info->salt;
		if($this->common_model->password_check(array('password'=>sha1($salt.sha1($salt.sha1($oldpassword)))),superadmin_id())){
			return TRUE;
		}else{
			$this->form_validation->set_message('password_check', 'The %s does not match');
			return FALSE;
		}

	}
	function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);
	}

	public function change_status_users($id="",$status="",$offset=""){
	    $this->_check_login(); //check login authentication
	    $data['title']='';
	    $data=array('status'=>$status);
	    if($this->superadmin_model->update('users',$data,array('user_id'=>$id)))    {
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');}
	    redirect($_SERVER['HTTP_REFERER']);
	}
	public function option()
	{
		$this->_check_login(); //check login authentication
		$data['title']='Setting option';
		
		//$this->form_validation->set_rules('name[]','All Field','required');
		if (isset($_POST["option"])){
		$name=$this->input->post('name');
		$ids=$this->input->post('ids');
		$i=0;
			foreach ($name as $value) 
			{
					$post_data = array('option_value' => htmlentities($value));
					$optionid=array('id'=>$ids[$i]);
					if($ids[$i]!=26){
					$this->superadmin_model->update('options',$post_data,$optionid);
						}
					$i++;
			}
			$this->session->set_flashdata('msg_success','Data updated successfully.');
			redirect('backend/superadmin/option');				
		  }
		$data['option'] = $this->superadmin_model->get_result('options');
		$data['template'] ='backend/option';
		$this->load->view('templates/superadmin_template', $data);
	} 
	public function email_notification()
	{
		$this->_check_login(); //check login authentication
		$data['title']='Contact Us Notification';
		$data['notification'] = $this->superadmin_model->get_result('contactus_notification');
		$data['template'] ='backend/email/email_notification';
		$this->load->view('templates/superadmin_template', $data);
	} 

 	function error_404(){
    	$this->_check_login(); //check login authentication
		$data['template']='backend/404';		
		$this->load->view('templates/superadmin_template',$data);
	} 
    public function change_all_user_status(){
		$status   = $this->input->post('status'); 
		$ids      = $this->input->post('row_id');
		
		$this->common_model->change_notification_status('contactus_notification','id',$ids,$status);
		$default_arr=array('status'=>TRUE);
	   $this->session->set_flashdata('msg_success','Email notifications deleted successfully');
        //echo json_encode($default_arr);   
	}	
}