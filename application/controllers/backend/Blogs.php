<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Blogsd extends CI_Controller {
	// copy of attribute controller
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		$this->load->model('user_model');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); //check login authentication
	} 
	private function _check_login(){
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}
	public function index($offset=0){
		$this->_check_login();
		$data['title']='Blog Articles List';
		$search=array();
		$user_info = $this->session->userdata('user_info');
		
		
		$sort='desc';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url']   = base_url().'backend/blogs/index/';
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
        $config['total_rows'] = $this->user_model->blogs_list(0,0,$search,$sort);
		$data['blogs']=$this->user_model->blogs_list($offset,PER_PAGE,$search,$sort);
		$data['users']=$this->user_model->one_user();
        $this->pagination->initialize($config);
        $data['pagination']	= $this->pagination->create_links();
		$data['user_info'] 	= $user_info;
        $data['template']	= 'backend/blogs/blogs_list';
        $data['offset']		= $offset;
        $this->load->view('templates/superadmin_template',$data);
	}
	public function add_task(){
		$this->_check_login();
		$data['title']='Add Task';
		
		$data['projects'] = $this->common_model->get_result('projects');
		$data['users'] = $this->common_model->get_result('users',array('user_role'=>1));
		
		$this->form_validation->set_rules('task', 'Task', 'required'); 
		$this->form_validation->set_rules('project_id', 'Project', 'required');
		$this->form_validation->set_rules('user_id', 'Employee', 'required');
		if ($this->form_validation->run() == TRUE){ 
			
			$insert = array(
				  'project_id' => $this->input->post('project_id'),
				  'user_id'    => $this->input->post('user_id'),
				  'task'       => $this->input->post('task')
				
			);
			if($this->common_model->insert('tasks',$insert)){
				
				$this->session->set_flashdata('msg_success','Task information added successfully');
                redirect('backend/tasks');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Adding task has been failed. Please try again');
				redirect('backend/tasks/add_task');
			}
		}
		$data['template']='backend/tasks/add_task';
		$this->load->view('templates/superadmin_template',$data);
	}

	public function edit_task($id=''){
		$this->_check_login();
		$data['title']='Edit Task';
		$data['projects'] = $this->common_model->get_result('projects');
		$data['users']    = $this->common_model->get_result('users',array('user_role'=>1));
        $user_info = $this->session->userdata('user_info');
		
		 $id = $this->uri->segment(4);
		 $data['tasks']    = $this->common_model->get_row('tasks',array('id'=>$id));
		$this->form_validation->set_rules('user_id', 'Employee', 'required');

		if ($this->form_validation->run() == TRUE){ 
			
			$update = array(
				  'user_id'    => $this->input->post('user_id'),
				  'status'     => $this->input->post('status'),
				  'modified_date'     =>date('Y-m-d H:i:s')
				
			);
			
		
			if($this->common_model->update('tasks',$update,array('id'=>$id))){
				$this->session->set_flashdata('msg_success','Task information updated successfully');
                redirect('backend/tasks');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
				redirect('backend/tasks/edit_task/'.$id);
			}
		}
		
		$data['user_info'] =$user_info;
		$data['template']='backend/tasks/edit_task';
		$this->load->view('templates/superadmin_template',$data);
	}
	function change_status(){
		$this->_check_login();
		
		$status   = $this->input->post('status');
		$id       = $this->input->post('id');
				
		$this->common_model->update('fh_blog_articles',array('status'=>$status),array('id'=>$id));
		   
	}
	public function change_status_blogs($id="",$status="",$offset=""){
	    $this->_check_login(); //check login authentication
	    $data['title']='';
	    $data=array('status'=>$status);
	    if($this->superadmin_model->update('fh_blog_articles',$data,array('blog_id'=>$id)))    {
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');}
	    redirect($_SERVER['HTTP_REFERER']);
	}
	public function change_approve($id="",$approved_by_admin="",$offset=""){
	    $this->_check_login(); //check login authentication
	    $data['title']='';
	    $data=array('approved_by_admin'=>$approved_by_admin);
	    if($this->superadmin_model->update('fh_blog_articles',$data,array('blog_id'=>$id))) {
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');
		}
	    redirect($_SERVER['HTTP_REFERER']);
	}
	function change_all_status(){
		$this->_check_login();
		$ids      = $this->input->post('row_id');
		$this->common_model->change_all_status('fh_blog_articles','id',$ids,$status);
		$default_arr=array('status'=>TRUE);
	    header('Content-Type: application/json');
        echo json_encode($default_arr);   
	}
	
	function assign_multiple_task(){
		$this->_check_login();
		$project_id  = $this->input->post('project_id');
		$user_id     = $this->input->post('user_id');
		$tasks       = $this->input->post('task');
		
		foreach($tasks  as $task){
				$insert = array(
				  'project_id'   =>$project_id,
				  'user_id'     => $user_id,
				  'task'        => $task,

			);
			$this->common_model->insert('tasks',$insert);
		}
		$this->session->set_flashdata('msg_success','Tasks added successfully');
        redirect('backend/tasks');
	}
}