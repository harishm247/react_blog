<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Email_templates extends CI_Controller {
	public function __construct(){
	    parent::__construct();  
	    $this->load->model('superadmin_model');   
        if(!superadmin_logged_in())
        {
            redirect('backend/superadmin');
        }
    }
 
      public function index($offset=0)
      {
      
        $data['title']='Email Template';    
        $per_page= 25;
        $data['offset']=$offset;
        $data['news'] = $this->superadmin_model->email_templates_model($offset,$per_page);
        $config=backend_pagination();
        $config['base_url'] = base_url().'backend/email_templates/index';
        $config['total_rows'] = $this->superadmin_model->email_templates_model(0,0);
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 4;
        if(!empty($_SERVER['QUERY_STRING'])){
         $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
        }
        else{
         $config['suffix'] ='';
        }
        $data['total_records'] = $config['total_rows'];
        $config['first_url'] = $config['base_url'].$config['suffix'];
        $this->pagination->initialize($config);
        $data['pagination']=$this->pagination->create_links();  

        $data['template']='backend/email/index';
        $this->load->view('templates/superadmin_template',$data);
     }
    public function email_templates_add()
    {    
    	$data['title']='Add Email Template';
		$this->form_validation->set_rules('template_name', 'Title', 'required');
		$this->form_validation->set_rules('template_subject', 'Subject', 'required');
		$this->form_validation->set_rules('template_body', 'Body', 'required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if ($this->form_validation->run() == TRUE){
			$data_insert['template_name'] = $this->input->post('template_name');
			$data_insert['template_subject'] = $this->input->post('template_subject');

			$data_insert['template_body'] = $this->input->post('template_body');
			$data_insert['template_subject_admin']	= $this->input->post('template_subject_admin');
			$data_insert['template_body_admin']=$this->input->post('template_body_admin');
			$data_insert['template_created'] =	date('Y-m-d h:i:s');
            $this->superadmin_model->insert('email_templates',$data_insert);
            $this->session->set_flashdata('msg_success','Email Template added successfully.');
			redirect('backend/email_templates');
		   }	  		
    	$data['template']='backend/email/email_templates_add';
		$this->load->view('templates/superadmin_template',$data);
    }

    public function email_templates_edit($id='')
    {   
        $data['title'] = 'Edit Email Template';
        if($id == ''){ redirect('backend/email_templates'); }
        $row_get = $this->common_model->count_rows('email_templates', array('id'=>$id),'','');
        if($row_get < 1){ 
          redirect('backend/superadmin/error_404');
        }
        $this->form_validation->set_rules('template_name', 'Title', 'required');
        $this->form_validation->set_rules('template_subject', 'Subject', 'required');
        $this->form_validation->set_rules('template_body', 'Body', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE)
        {   
            $data_insert['template_name'] = $this->input->post('template_name');
			$data_insert['template_subject'] = $this->input->post('template_subject');
			$data_insert['template_body'] = $this->input->post('template_body');
            $data_insert['template_subject_admin']	= $this->input->post('template_subject_admin');
			$data_insert['template_body_admin']=$this->input->post('template_body_admin');
			$data_insert['template_updated'] =	date('Y-m-d h:i:s');
            $this->superadmin_model->update('email_templates',$data_insert,$array = array('id' => $id, ));
			$this->session->set_flashdata('msg_success','Email Template Updated successfully.');
			redirect('backend/email_templates');
		   }	  

		$data['email_template'] = $this->superadmin_model->get_result('email_templates',$array = array('id' =>$id) ,array(),array());
    	 
    	$data['template']='backend/email/email_templates_edit';
		$this->load->view('templates/superadmin_template',$data);
    }

    public function email_templates_delete($id='')
    {
    	if(empty($id)){ redirect('backend/email_templates/'); }
        if($this->superadmin_model->delete('email_templates',array('id'=>$id)))
        {
           $this->session->set_flashdata('msg_success','Email Template deleted successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error','Failed, Please try again.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

	
}