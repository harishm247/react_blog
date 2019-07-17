<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Upcoming_trips extends CI_Controller
{
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		$this->load->model('user_model');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); //check login authentication
	} 


	public function index($offset="")
	{
		$this->load->model('user_model');
		$search=array();
			if(!empty($_GET))
			{
				if(!empty($_GET['blogs_title']))
				$search[] = "select * from `fh_blog_articles`";
				
			}
		$sort = "DESC";
		$data['title']='All Upcoming Trips';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url']   = base_url().'backend/upcoming_trips/index';
        $config['total_rows'] = $this->user_model->all_users_trip_list(0,0,$search,$sort);
        
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
		
		$data['videos']=$this->user_model->all_users_trip_list($offset,PER_PAGE,$search,$sort);
		if(!empty($_POST["submitOrder"]) && $_POST["submitOrder"]==1){ 
			for ($i=0; $i < count($_POST['main_id']); $i++) {     
	                $order_data['order_by'] = $_POST['order_by'][$i];   
	                $this->superadmin_model->update('fh_upcoming_trips',$order_data,array('up_t_id'=>$_POST['main_id'][$i]));
	        }
	            $this->session->set_flashdata('msg_success','Order updated successfully.');
	                redirect('backend/upcoming_trips');
		}
		$data['offset']=$offset;
		$this->pagination->initialize($config);
        $data['pagination']	= $this->pagination->create_links();
		$data['template']='backend/trips/upcoming_trips';
       $this->load->view('templates/superadmin_template',$data);
	}
	function change_all_status(){
		$status      = $this->input->post('status');
		$ids      = $this->input->post('row_id');
		$this->common_model->change_all_status('fh_upcoming_trips','up_t_id',$ids,$status);
		$default_arr=array('status'=>TRUE);
		$this->session->set_flashdata('msg_success','Status has been changed successfully');
        echo json_encode($default_arr);   
	}
}