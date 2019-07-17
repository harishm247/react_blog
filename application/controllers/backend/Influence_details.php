<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Influence_details Extends CI_Controller{
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		$this->load->model('user_model');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); 
	} 
	public function index()
	{
		$data['title'] = 'Influencer Details';
		if(!empty($this->input->post('influeTypeSubmit'))){
			$this->form_validation->set_rules('type', 'Type', 'required'); 
			$this->form_validation->set_rules('order_by', 'Order By', 'required');
			if ($this->form_validation->run() == TRUE){ 
				$influencer["type"] = $this->input->post("type");
				$influencer["order_by"] = $this->input->post("order_by");
				if(!empty($this->user_model->insert("fh_influencer_type",$influencer)))
				{
					 $this->session->set_flashdata('msg_success','Influencer type added succsessfully');
					  redirect('backend/influence_details');
				}
				else
				{
					$this->session->set_flashdata('msg_error','Something went wrong! Please try again');
				}
			}
		}

      	if($this->input->post('type_action') == 2){     
          $this->form_validation->set_rules('type[]', 'Type', 'required'); 
		  $this->form_validation->set_rules('order_by[]', 'Order By', 'required');
		  if($this->form_validation->run() == TRUE){  
            for ($i=0; $i < count($_POST['main_id']); $i++) {          
                $category_data['type'] = $_POST['type'][$i];              
                $category_data['order_by'] = $_POST['order_by'][$i];   
                $this->superadmin_model->update('fh_influencer_type',$category_data,array('it_id'=>$_POST['main_id'][$i]));
            }
                $this->session->set_flashdata('msg_success','Influencer type updated successfully.');
                redirect('backend/influence_details');
          }
        }
		
		$data["influencerTypeData"] = $this->user_model->get_result_order_by("fh_influencer_type");
		$data['template']	= 'backend/influencer/influencer_type';
        $this->load->view('templates/superadmin_template',$data);
	}

	public function change_approve($id="",$approved_by_admin="",$offset=""){
	    $data[]='';
	    $data=array('status'=>$approved_by_admin);
	    if($this->superadmin_model->update('fh_influencer_type',$data,array('it_id'=>$id)))    
	    {
	    	$this->session->set_flashdata('msg_success','Status has been changed successfully');
	    }
	    	redirect($_SERVER['HTTP_REFERER']);
	}
	public function category()
	{
		$data['title'] = 'Influencer Category';
		if(!empty($this->input->post('influeCatSubmit'))){
			$this->form_validation->set_rules('category', 'Category', 'required'); 
			$this->form_validation->set_rules('order_by', 'Order By', 'required');
			if ($this->form_validation->run() == TRUE){ 
				$influencer["category"] = $this->input->post("category");
				$influencer["order_by"] = $this->input->post("order_by");
				if(!empty($this->user_model->insert("fh_influencer_speciality_categories",$influencer)))
				{
					 $this->session->set_flashdata('msg_success','Influencer category added succsessfully');
					  redirect('backend/influence_details/category');
				}
				else
				{
					$this->session->set_flashdata('msg_error','Something went wrong! Please try again');
				}
			}
		}
	    if($this->input->post('type_action') == 2){     
          $this->form_validation->set_rules('category[]', 'Category', 'required'); 
		  $this->form_validation->set_rules('order_by[]', 'Order By', 'required');
		  if($this->form_validation->run() == TRUE){
            for ($i=0; $i < count($_POST['main_id']); $i++) {          
                $category_data['category'] = $_POST['category'][$i];              
                $category_data['order_by'] = $_POST['order_by'][$i];   
                $this->superadmin_model->update('fh_influencer_speciality_categories',$category_data,array('isc_id'=>$_POST['main_id'][$i]));
            }
                $this->session->set_flashdata('msg_success','Influencer category updated successfully.');
                redirect('backend/influence_details/category');
       		}
    	}

		
		$data["influencerCatData"] = $this->user_model->get_result_order_by("fh_influencer_speciality_categories");
		$data['template']	= 'backend/influencer/influencer_category';
        $this->load->view('templates/superadmin_template',$data);
	}
	function multi_status_update()
	{
		$status  = $this->input->post('status');
		$ids     = $this->input->post('row_id');
		$table   = $this->input->post('table_name');
		$item_id  = $this->input->post('item_id');

		$status   = $this->common_model->change_publish_status($table,$item_id,$ids,$status);
		if(!empty($status)){
			$this->session->set_flashdata('msg_success','Status Changed succsessfully');
		}
			$default_arr=array('status'=>TRUE);
    }

	public function change_approve_cat($id="",$approved_by_admin="",$offset=""){
	    $data[]='';
	    $data=array('status'=>$approved_by_admin);
	    if($this->superadmin_model->update('fh_influencer_speciality_categories',$data,array('isc_id'=>$id)))    
	    {
	    	$this->session->set_flashdata('msg_success','Status has been changed successfully');
	    }
	    	redirect($_SERVER['HTTP_REFERER']);
	}

}