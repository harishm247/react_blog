<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Incredible_places extends CI_Controller {
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
		$data['title']='Incredible Places List';
		$search=array();
		$user_info = $this->session->userdata('user_info');
		
		$sort='desc';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url']   = base_url().'backend/incredible_places/index/';
        $config['total_rows'] = $this->user_model->incredible_places_list(0,0,$search,$sort);
       
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
			
		$data['incredible_places']=$this->user_model->incredible_places_list($offset,PER_PAGE,$search,$sort);
		
        $this->pagination->initialize($config);
        $data['pagination']	= $this->pagination->create_links();
		$data['user_info'] 	= $user_info;
		$data['world_regions']=$this->common_model->get_result('fh_world_regions','','',array('region','ASC'));
		if(empty($_GET['user_id'])){
			$data['users']=$this->common_model->get_result('users',array('user_role'=>1),array('user_id','first_name','last_name'),array('first_name','ASC'));
		}
	
        $data['template']	= 'backend/incredible_places/incredible_places_list';
        $data['offset']		= $offset;
        $this->load->view('templates/superadmin_template',$data);
	}

	public function delete($tablename="",$field="",$id="",$title=""){
	    $this->_check_login(); //check login authentication
	   
	if($this->common_model->delete($tablename,array($field=>$id))){
	    $this->session->set_flashdata('msg_success',$title.' has been deleted successfully');
	}
	    redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function change_approve($id="",$approved_by_admin="",$offset=""){
	    $this->_check_login(); //check login authentication
	    $data['title']='';
	    $data=array('approved_by_admin'=>$approved_by_admin);
	     if($approved_by_admin==1)$msg='Incredible Place has been approved successfully';
   		   else $msg='Incredible Place has been unapproved successfully';
	    if($this->superadmin_model->update('fh_favorite_incredible_places',$data,array('incredible_id'=>$id)))    {
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');}
	    redirect($_SERVER['HTTP_REFERER']);
	}

}