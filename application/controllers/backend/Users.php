<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
	// copy of attribute controller
	public function __construct(){ 
		parent::__construct();
		$this->load->helper('text');
		$this->load->model('superadmin_model');
		$this->load->model('user_model');
		$this->load->library('chapter247_email');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); //check login authentication
	} 
	private function _check_login(){
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}
	public function index($offset=0){ 
		$data['title']='Users List';
		$search=array();
		if(!empty($_GET))
		{
			if(!empty($_GET['name']))
			$search[]=' (first_name like "%'.trim($_GET['name']).'%" or last_name like "%'.trim($_GET['name']).'%") ';
            if(!empty($_GET['status']))
			    $search[]=' status = '.trim($_GET['status']);
		}
		$sort='desc';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url'] = base_url().'backend/users/index/';
        $config['total_rows'] = $this->common_model->get_usersInfo(0,0,$search);
        
        $config['per_page'] = PER_PAGE;
	    $config['uri_segment'] = 4;
	    if(!empty($_SERVER['QUERY_STRING']))
	      $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
	    else
	      $config['suffix'] ='';

	  	$config['first_url'] = $config['base_url'].$config['suffix'];
	    if((int) $offset < 0){
	      $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
	      redirect($config['base_url']);
	    }else if($config['total_rows'] < $offset){
	      $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
	      redirect($config['base_url']);
	    }
		$data['influenceusers'] = $this->common_model->influencer_user();
	
		$data['users']=$this->common_model->get_usersInfo($offset,PER_PAGE,$search);
		if(!empty($_POST["submitOrder"]) && $_POST["submitOrder"]==1){ 
			for ($i=0; $i < count($_POST['main_id']); $i++) {     
	                $order_data['order_by'] = $_POST['order_by'][$i];   
	                $this->superadmin_model->update('users',$order_data,array('user_id'=>$_POST['main_id'][$i]));
	        }
	            $this->session->set_flashdata('msg_success','Order updated successfully.');
	                redirect('backend/users');
		}
        $this->pagination->initialize($config);
        $data['pagination']=$this->pagination->create_links();
        $data['template']='backend/users/user_list';
        $data['offset']=$offset;
        $this->load->view('templates/superadmin_template',$data);
	}
	public function influencer($offset=''){
		$data['title']='Influencer List';
		$search=array();
		if(!empty($_GET))
		{
			if(!empty($_GET['name']))
			$search[]=' (first_name like "%'.trim($_GET['name']).'%" or last_name like "%'.trim($_GET['name']).'%") ';
            if(!empty($_GET['status']))
			    $search[]=' status = '.trim($_GET['status']);
		}
		$sort='desc';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url'] = base_url().'backend/users/influencer/';
        $config['total_rows'] = $this->common_model->get_InfluencerInfo(0,0,$search);
        
        $config['per_page'] = PER_PAGE;
	    $config['uri_segment'] = 4;
	    if(!empty($_SERVER['QUERY_STRING']))
	      $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
	    else
	      $config['suffix'] ='';

	  	$config['first_url'] = $config['base_url'].$config['suffix'];
	    if((int) $offset < 0){
	      $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
	      redirect($config['base_url']);
	    }else if($config['total_rows'] < $offset){
	      $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
	      redirect($config['base_url']);
	    }
		$data['usekkrs'] = $this->common_model->influencer_user();
	
		$data['users']=$this->common_model->get_InfluencerInfo($offset,PER_PAGE,$search);
		if(!empty($_POST["submitOrder"]) && $_POST["submitOrder"]==1){ 
			for ($i=0; $i < count($_POST['main_id']); $i++) {     
	                $order_data['order_by'] = $_POST['order_by'][$i];   
	                $this->superadmin_model->update('users',$order_data,array('user_id'=>$_POST['main_id'][$i]));
	        }
	            $this->session->set_flashdata('msg_success','Order updated successfully.');
	                redirect('backend/users/influencer');
		}
        $this->pagination->initialize($config);
        $data['pagination']=$this->pagination->create_links();
        $data['template']='backend/users/influencer_list';
        $data['offset']=$offset;
        $this->load->view('templates/superadmin_template',$data);
	}
	

    public function change_all_user_status(){
		$status   = $this->input->post('status'); 
		$ids      = $this->input->post('row_id');
		
		$this->common_model->change_user_status('users','user_id',$ids,$status);
		$default_arr=array('status'=>TRUE);
	    header('Content-Type: application/json');
        echo json_encode($default_arr);   
	}	
	public function add_user(){
		$this->_check_login();
		$data['title']='Add User';
			
		$this->form_validation->set_rules('first_name', 'First name', 'required'); 
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');

		if ($this->form_validation->run() == TRUE){ 
		
			$insert = array(
				  'first_name'   => $this->input->post('first_name'),
				  'last_name'    => $this->input->post('last_name'),
				  'email'        => $this->input->post('email'),
				  'user_role'    => 1,
				
			);
			if($this->common_model->insert('users',$insert)){
				
				$this->session->set_flashdata('msg_success','User information added successfully');
                redirect('backend/users');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Adding user has been failed. Please try again');
				redirect('backend/users/add_user');
			}
		}
		$data['template']='backend/users/add_user';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function edit_user($id='')
	{ 
		if(!empty($this->common_model->_checkUserId($id))) {
		$this->_check_login();
		$data['title']='View Users';
		$data['user'] = $this->common_model->get_row('users',array('user_id'=>$id));
		$data['influencerInfor'] = $this->common_model->influencer_infor('fh_influencer_info',array('user_id'=>$id));

        $data['social_media'] = $this->common_model->get_row('fh_social_media',array('user_id'=>$id));
      	
      	// $data['blog_articles_active'] = $this->common_model->get_result_count('fh_blog_articles',array('user_id'=>$id,'status'=>1),'blog_id');	
      	// $data['blog_articles_inactive'] = $this->common_model->get_result_count('fh_blog_articles',array('user_id'=>$id,'status'=>0),'blog_id');

      	$data['approve_by_admin_blog'] = $this->common_model->get_result_count('fh_blog_articles',array('user_id'=>$id,'approved_by_admin'=>1),'blog_id');	
      	$data['unapprove_by_admin_blog'] = $this->common_model->get_result_count('fh_blog_articles',array('user_id'=>$id,'approved_by_admin'=>0),'blog_id');
      	$data['pending_by_admin_blog'] = $this->common_model->get_result_count('fh_blog_articles',array('user_id'=>$id,'approved_by_admin'=>3),'blog_id');

       //  $data['my_videos_active'] = $this->common_model->get_result_count('fh_videos',array('user_id'=>$id,'status'=>1),'v_id');	
      	// $data['my_videos_inactive'] = $this->common_model->get_result_count('fh_videos',array('user_id'=>$id,'status'=>0),'v_id');

      	$data['approve_by_admin_video'] = $this->common_model->get_result_count('fh_videos',array('user_id'=>$id,'approved_by_admin'=>1),'v_id');	
      	$data['unapprove_by_admin_video'] = $this->common_model->get_result_count('fh_videos',array('user_id'=>$id,'approved_by_admin'=>0),'v_id');
      	$data['pending_by_admin_video'] = $this->common_model->get_result_count('fh_videos',array('user_id'=>$id,'approved_by_admin'=>3),'v_id');

      	// $data['my_shop_active'] = $this->common_model->get_result_count('fh_shop',array('user_id'=>$id,'status'=>1),'shop_id');	
      	// $data['my_shop_inactive'] = $this->common_model->get_result_count('fh_shop',array('user_id'=>$id,'status'=>0),'shop_id');

      	$data['approve_by_admin_shop'] = $this->common_model->get_result_count('fh_shop',array('user_id'=>$id,'approved_by_admin'=>1),'shop_id');	
      	$data['unapprove_by_admin_shop'] = $this->common_model->get_result_count('fh_shop',array('user_id'=>$id,'approved_by_admin'=>0),'shop_id');
      	$data['pending_by_admin_shop'] = $this->common_model->get_result_count('fh_shop',array('user_id'=>$id,'approved_by_admin'=>3),'shop_id');

      	// $data['my_upcoming_trips_active'] = $this->common_model->get_result_count('fh_upcoming_trips',array('user_id'=>$id,'status'=>1),'up_t_id');	
      	// $data['my_upcoming_trips_inactive'] = $this->common_model->get_result_count('fh_upcoming_trips',array('user_id'=>$id,'status'=>0),'up_t_id');

      	$data['approve_by_admin_trip'] = $this->common_model->get_result_count('fh_upcoming_trips',array('user_id'=>$id,'approved_by_admin'=>1),'up_t_id');	
      	$data['unapprove_by_admin_trip'] = $this->common_model->get_result_count('fh_upcoming_trips',array('user_id'=>$id,'approved_by_admin'=>0),'up_t_id');
      	$data['pending_by_admin_trip'] = $this->common_model->get_result_count('fh_upcoming_trips',array('user_id'=>$id,'approved_by_admin'=>3),'up_t_id');

      	// $data['my_fav_destinations_active'] = $this->common_model->get_result_count('fh_favorite_destinations',array('user_id'=>$id,'status'=>1),'favorite_id');	
      	// $data['my_fav_destinations_inactive'] = $this->common_model->get_result_count('fh_favorite_destinations',array('user_id'=>$id,'status'=>0),'favorite_id');

      	$data['approve_by_admin_desti'] = $this->common_model->get_result_count('fh_favorite_destinations',array('user_id'=>$id,'approved_by_admin'=>1),'favorite_id');	
      	$data['unapprove_by_admin_desti'] = $this->common_model->get_result_count('fh_favorite_destinations',array('user_id'=>$id,'approved_by_admin'=>0),'favorite_id');
      	$data['pending_by_admin_desti'] = $this->common_model->get_result_count('fh_favorite_destinations',array('user_id'=>$id,'approved_by_admin'=>3),'favorite_id');

      	// $data['my_fav_incredible_places_active'] = $this->common_model->get_result_count('fh_favorite_incredible_places',array('user_id'=>$id,'status'=>1),'incredible_id');	
      	// $data['my_fav_incredible_places_inactive'] = $this->common_model->get_result_count('fh_favorite_incredible_places',array('user_id'=>$id,'status'=>0),'incredible_id');

      	$data['approve_by_admin_place'] = $this->common_model->get_result_count('fh_favorite_incredible_places',array('user_id'=>$id,'approved_by_admin'=>1),'incredible_id');	
      	$data['unapprove_by_admin_place'] = $this->common_model->get_result_count('fh_favorite_incredible_places',array('user_id'=>$id,'approved_by_admin'=>0),'incredible_id');
      	$data['pending_by_admin_place'] = $this->common_model->get_result_count('fh_favorite_incredible_places',array('user_id'=>$id,'approved_by_admin'=>3),'incredible_id');
      
		
		if(isset($_POST['newpassword']))
		{
			$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|matches[confpassword]');
			$this->form_validation->set_rules('confpassword','Confirm Password', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
	
			if ($this->form_validation->run() == TRUE) {
				$salt = $this->salt();
			
				$user_data['password']  = sha1($salt.sha1($salt.sha1($this->input->post('newpassword')))); 
				$user_data['salt']  = $salt;
				if($this->superadmin_model->update('users', $user_data,array('user_id'=>$id))){
		               $this->session->set_flashdata('msg_success','Password updated successfully.');
					   redirect("backend/users/edit_user/$id");
				}
			}
     		else{  
			$this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
				
			}
		}
		if(isset($_POST['newemail']))
		{	
			$this->form_validation->set_rules('newemail', 'Email', 'trim|required|valid_email|is_unique[users.email]');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

			if($this->form_validation->run() == FALSE)
			{
			    $this->session->set_flashdata('msg_error','Sorry! Email Updation process has been failed. Please try again');
			 	redirect(current_url().'?user_type='.$_GET['user_type']);
			}
			else
			{

				$user_data['email'] = $this->input->post('newemail');

				if($this->superadmin_model->update('users', $user_data,array('user_id'=>$id)))
				{
				$matchUserData = $this->superadmin_model->get_row("users",array('email'=>$this->input->post('newemail')),array('user_id,first_name,last_name,email,user_role'));
					/** Send email for users **/
					$this->chapter247_email->set_language('en');
		    	    $this->chapter247_email->set_email_templates(108);
		    	    $email_template=$this->common_model->get_email('en',108);
					$param = array(
						"template"=>array(
							"var_name" => array(
								"email" => $this->input->post('newemail'),
								"first_name" => $matchUserData->first_name,
								"last_name" => $matchUserData->last_name,
							),
							"temp" => $email_template->template_body,

						),
						"email" => array(
							"to"        =>   $this->input->post('newemail'),
							"from"      =>   SUPPORT_EMAIL,
							"from_name" =>   NO_REPLY_EMAIL_FROM_NAME,
							"subject"   =>  $email_template->template_subject,
						)
					);
					$status = $this->chapter247_email->send_mail($param);
					$this->session->set_flashdata('msg_success','The email has been updated successfully & Email has been sent');
					redirect(current_url().'?user_type='.$_GET['user_type']);
				}
			}
		}
		
		$data['template']='backend/users/edit_user';
		$this->load->view('templates/superadmin_template',$data);
	}
	else{ 
		redirect("backend/users");
	}
	} 

	public function check_email_avalibility()  
	{  
	    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) 
	    {  
	        if($this->superadmin_model->is_email_available($_POST["email"]))  
	        {  
	            echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span>This email address is already exists</label>';  
	        }  
	        else  
	        {  
	            echo json_encode(FALSE);  
	        }  
	    }  
	}
	function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);

	}
	public function blogs($offset=0){
		$this->_check_login();
		$data['title']='Blog Articles List';
		$search=array();
		$user_info = $this->session->userdata('user_info');
		
		
		$sort='desc';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url']   = base_url().'backend/users/blogs/';
        $config['total_rows'] = $this->user_model->blogs_list(0,0,$search,$sort);
        
        $config['per_page'] = PER_PAGE;
	    $config['uri_segment'] = 4;
	    if(!empty($_SERVER['QUERY_STRING']))
	      $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
	    else
	      $config['suffix'] ='';

	  	$config['first_url'] = $config['base_url'].$config['suffix'];
	    if((int) $offset < 0){
	      $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
	      redirect($config['base_url']);
	    }else if($config['total_rows'] < $offset){
	      $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
	      redirect($config['base_url']);
	    }
		$data['blogs']=$this->user_model->blogs_list($offset,PER_PAGE,$search,$sort);
        $this->pagination->initialize($config);
        $data['pagination']	= $this->pagination->create_links();
		$data['user_info'] 	= $user_info;
        $data['template']	= 'backend/blogs/blogs_list';
        $data['offset']		= $offset;
        $this->load->view('templates/superadmin_template',$data);
	}
	public function delete($table='',$col='',$value=''){ 
		 //echo "Value=".$value; echo "Table=". $table; echo "Col=".$col;die();
		if($table=='' || $col=='' || $value=='') redirect($_SERVER['HTTP_REFERER']);
		$data = $this->common_model->get_row($table, array($col => $value));
		if (!$data) redirect($_SERVER['HTTP_REFERER']); 
		if ($this->common_model->delete($table, array($col => $value))){ 
			$this->session->set_flashdata('msg_success', 'Data deleted successfully'); 
		}else{ 
			$this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
		} 
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function username_search(){
		$username=$this->input->post('keyword');
		if($username):
        $data= $this->user_model->get_users($username); 
        echo "<ul  id='user-list'>";
        foreach ($data as $key => $value) { ?>
         		
        <li onClick="selectCountry('<?php echo $value["first_name"]." ".$value["last_name"]; ?>');"><?php echo $value["first_name"]." ".$value["last_name"]; ?></li>
        <?php } 
        echo "</ul>";
    endif;
	}
	public function influencer_user_search(){
		$username=$this->input->post('keyword');
		if($username):
        $data= $this->user_model->influencer_user_search($username); 
        echo "<ul  id='user-list'>";
        foreach ($data as $key => $value) { ?>
         		
        <li onClick="selectCountry('<?php echo $value["first_name"]." ".$value["last_name"]; ?>');"><?php echo $value["first_name"]." ".$value["last_name"]; ?></li>
        <?php } 
        echo "</ul>";
    endif;
	}




}