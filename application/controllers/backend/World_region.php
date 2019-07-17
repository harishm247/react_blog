<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class World_region Extends CI_Controller{
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		$this->load->model('user_model');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); 
	} 
	public function index()
	{
		$data["title"] = 'World Region';
		if(!empty($this->input->post('worldRegion'))){
			$this->form_validation->set_rules('region', 'Region', 'required'); 
			$this->form_validation->set_rules('order_by', 'Order By', 'required');
			if ($this->form_validation->run() == TRUE){ 
				$region["region"] = $this->input->post("region");
				$region["order_by"] = $this->input->post("order_by");
				if(!empty($this->user_model->insert("fh_world_regions",$region)))
				{
					 $this->session->set_flashdata('msg_success','World region added succsessfully');
					  redirect('backend/world_region');
				}
				else
				{
					$this->session->set_flashdata('msg_error','Something went wrong! Please try again');
				}
			}
		}

      	if($this->input->post('type_action') == 2){     
          $this->form_validation->set_rules('region[]', 'World Region', 'required'); 
		  $this->form_validation->set_rules('order_by[]', 'Order By', 'required');
		    if($this->form_validation->run() == TRUE){
	            for ($i=0; $i < count($_POST['main_id']); $i++) {          
	                $world_region['region'] = $_POST['region'][$i];              
	                $world_region['order_by'] = $_POST['order_by'][$i];   
	                $this->superadmin_model->update('fh_world_regions',$world_region,array('wr_id'=>$_POST['main_id'][$i]));
	            }
                $this->session->set_flashdata('msg_success','World regions updated successfully.');
                redirect('backend/world_region');
       		}
    	}

		$data["worldRegions"] = $this->user_model->get_result_order_by("fh_world_regions");
		$data['template']	= 'backend/worldRegion/world_region';
        $this->load->view('templates/superadmin_template',$data);
	}

	public function change_approve($id="",$approved_by_admin="",$offset=""){
	    $data[]='';
	    $data=array('status'=>$approved_by_admin);
	    if($this->superadmin_model->update('fh_world_regions',$data,array('wr_id'=>$id)))    
	    {
	    	$this->session->set_flashdata('msg_success','Status has been changed successfully');
	    }
	    	redirect($_SERVER['HTTP_REFERER']);
	}

}