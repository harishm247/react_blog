<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Videos extends CI_Controller {
	// copy of attribute controller
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		$this->load->model('user_model');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); //check login authentication
	} 

	public function index($offset=0)
	{
		$search=array();
			if(!empty($_GET))
			{
				if(!empty($_GET['blogs_title']))
				$search[] = "select * from `fh_blog_articles`";
				
			}
		$sort = "DESC";
		$data['title']='All Videos List';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url']   = base_url().'backend/videos/index';
        $config['total_rows'] = $this->user_model->all_user_videos_list(0,0,$search,$sort);
        
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
		$data['usersData']= $this->user_model->all_users_list();
		$data['videos']=$this->user_model->all_user_videos_list($offset,PER_PAGE,$search,$sort);
		if(!empty($_POST["submitOrder"]) && $_POST["submitOrder"]==1){ 
			for ($i=0; $i < count($_POST['main_id']); $i++) {     
	                $order_data['order_by'] = $_POST['order_by'][$i];   
	                $this->superadmin_model->update('fh_videos',$order_data,array('v_id'=>$_POST['main_id'][$i]));
	        }
	            $this->session->set_flashdata('msg_success','Order updated successfully.');
	                redirect('backend/videos');
		}
		$data['offset']=$offset;
		$this->pagination->initialize($config);
        $data['pagination']	= $this->pagination->create_links();
		$data['template']='backend/videos/videos_list';
        $this->load->view('templates/superadmin_template',$data);
	}
	
	// public function change_approve($id="",$approved_by_admin="",$offset=""){
	//     $data['title']='';
	//     $data=array('approved_by_admin'=>$approved_by_admin);
	//     if($this->superadmin_model->update('fh_videos',$data,array('v_id'=>$id)))    {
	//     $this->session->set_flashdata('msg_success','Status has been changed successfully');}
	//     redirect($_SERVER['HTTP_REFERER']);
	// }
	function change_all_status(){
		$status   = $this->input->post('status');
		$ids      = $this->input->post('row_id');
		$this->common_model->change_all_status('fh_videos','v_id',$ids,$status);
		$default_arr=array('approved_by_admin'=>TRUE);
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');
        echo json_encode($default_arr);   
	}
	
}