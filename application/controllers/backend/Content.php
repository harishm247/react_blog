<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Content extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        clear_cache();
        $this->load->model('superadmin_model');
    }
    public function index()
    {
         $this->pages();
    }
     private function _check_login(){
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}
		public function pages($offset=""){
		$this->_check_login(); //check login authentication
		$data['title']='pages'; 
		if(isset($_POST['submit'])){
    
			$this->form_validation->set_rules('page_title','Page Title','required');
			$this->form_validation->set_rules('page_content','Page Content','required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run() == TRUE){
			$page_data = array(
				'title'	=>	$this->input->post('page_title'),
				'slug'		=> 	url_title($this->input->post('page_title'), '-', TRUE),
				'description'	=>	$this->input->post('page_content'),
				'meta_description'	=>	$this->input->post('meta_description'),
				'meta_content'	=>	$this->input->post('meta_title'),
				'meta_keyword'	=>	$this->input->post('meta_keywords'),
				'status'		=>	1,
				'created_at'		=>	date('Y-m-d H:i:s A'),
				'post_type'	=>	$this->input->post('post_type'));
				if($this->superadmin_model->insert('pages',$page_data)){
					$this->session->set_flashdata('msg_success','Page added successfully.');
					redirect('backend/content/pages');
				}else{
					$this->session->set_flashdata('msg_error','Failed, Please try again.');
					redirect('backend/content/pages');
				}
			}
		}

		$per_page=10;
		$data['offset']=$offset;
		$data['pages'] = $this->superadmin_model->pages($offset,$per_page);
 		$config=backend_pagination();
		$config['base_url'] = base_url().'backend/content/pages';
		$config['total_rows'] = $this->superadmin_model->pages(0,0);
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
 		$data['template']='backend/page/pages';
		$this->load->view('templates/superadmin_template',$data);
	}
	
	public function page_edit($page_id='',$offset=''){
		$this->_check_login(); //check login authentication
		$data['title']='edit_page';

		if(empty($page_id)) redirect('backend/content/pages');
		$this->form_validation->set_rules('page_content','Content','required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			$page_data = array(		
			 //    'page_title'	=>	$this->input->post('page_title'),
				// 'page_slug'		=> 	url_title($this->input->post('page_title'), '-', TRUE),						
				'description'	=>	$this->input->post('page_content'),
				'meta_content'	=>	$this->input->post('meta_title'),
				'meta_keyword'	=>	$this->input->post('meta_keywords'),
				'meta_description'	=>	$this->input->post('meta_description'),
				'updated_at'	=>	date('Y-m-d H:i:s A'));
			if($this->superadmin_model->update('pages',$page_data,array('page_id'=>$page_id))){
				$this->session->set_flashdata('msg_success','Page updated successfully.');
				redirect('backend/content/pages/'.$offset);
			}else{
				$this->session->set_flashdata('msg_error','Failed, Please try again.');
				redirect('backend/content/pages/'.$offset);
			}
		}
		$data['page'] = $this->superadmin_model->get_row('pages',array('page_id'=>$page_id));
		$data['template'] ='backend/page/page_edit';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function page_delete($page_id ='',$offset=''){
		$this->_check_login(); //check login authentication
		$data['title']='';
		if(empty($page_id)) redirect('backend/content/pages');
		if($this->superadmin_model->delete('pages',array('page_id'=> $page_id,'post_type'=>'page'))){
				$this->session->set_flashdata('msg_success','Page deleted successfully.');
				redirect('backend/content/pages/'.$offset);
		}else{
			$this->session->set_flashdata('msg_error','Failed, Please try again.');
			redirect('backend/content/pages/'.$offset);
		}
	}
	
	public function changeuserstatus_t($id="",$status="",$offset="",$table_name="")	{
		$this->_check_login(); //check login authentication
		$data['title']='';
		if($status==0) $status=1;
		else $status=0;
		$data=array('status'=>$status);
		if($this->superadmin_model->update("pages",$data,array('page_id'=>$id)))
		$this->session->set_flashdata('msg_success','Status Updated successfully.');
		redirect($_SERVER['HTTP_REFERER']);
		}
  
  
   public function client_feedback($offset=0)
    {
    	$this->_check_login(); //check login authentication
    	$data['title']='client_feedback';
    	if(isset($_POST['update'])){
			$order = $this->input->post('order');
			foreach ($order as $key => $value) { 
			$this->superadmin_model->update('cms_client_feedback',array('order'=>$value),array('page_id'=>$key));
			}            
			$this->session->set_flashdata('msg_success','Order sequence updated successfully.');
			redirect('backend/content/client_feedback');
    	}
		$per_page=25;
		$data['offset']=$offset;
		$data['feedback'] = $this->superadmin_model->client_feedback($offset,$per_page,'page');
 		$config=backend_pagination();
		$config['base_url'] = base_url().'backend/content/client_feedback';
		$config['total_rows'] = $this->superadmin_model->client_feedback(0,0,'page');
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
 		$data['template']='backend/content/client_feedback';
		$this->load->view('templates/superadmin_template',$data);
    }
    public function client_feedback_add()
    {
    	 $this->_check_login(); //check login authentication
    	 $data['title']='add_client_feedback';
        
		
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('designation','Designation','required');
		$this->form_validation->set_rules('feedback','Feedback','required');
		
		$this->form_validation->set_rules('order', 'sequence No.', 'required');
		
        $this->form_validation->set_rules('client_image', '', 'callback_check_client_image');
        
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			 $client_data = array(
			 	'name'    =>    ucfirst($this->input->post('name')),
                'feedback'       =>    $this->input->post('feedback'), 
                'designation'=>    $this->input->post('designation'),  
                'order'		     =>  $this->input->post('order'),                        
                'created'        =>  date('Y-m-d H:i:s A')
                );
             if($this->session->userdata('check_client_image')!=''){
                $check_client_image=$this->session->userdata('check_client_image');               
                 $client_data['client_image'] = 'assets/uploads/client_images/'.$check_client_image['client_img']; 
             }
					
			if($this->superadmin_model->insert('cms_client_feedback',$client_data)){
				$this->session->set_flashdata('msg_success','Feedback Added successfully.');
				redirect('backend/content/client_feedback');
			}else{
				$this->session->set_flashdata('msg_error','Failed, Please try again.');
				redirect('backend/content/client_feedback');
			}
		}
    	$data['template']='backend/content/client_feedback_add';
		$this->load->view('templates/superadmin_template',$data);
    }
     public function client_feedback_edit($id='')
    {
    	$this->_check_login(); //check login authentication
    	$data['title']='edit_client_feedback';
    	if(empty($id)) { redirect('backend/content/client_feedback'); }
    	
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('designation','Designation','required'); 
		$this->form_validation->set_rules('feedback','Feedback','required|trim');
		if(!empty($_FILES['client_image']['name'])){			
        $this->form_validation->set_rules('client_image', '', 'callback_check_client_image');
        }        
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			 $client_data = array(
			 	'name'    =>    ucfirst($this->input->post('name')),
                'feedback'    =>    $this->input->post('feedback'),    
                'designation'=>    $this->input->post('designation'),       
                );
             if($this->session->userdata('check_client_image')!=''){
                $check_client_image=$this->session->userdata('check_client_image');               
                 $client_data['client_image'] = 'assets/uploads/client_images/'.$check_client_image['client_img']; 
             }
					
			if($this->superadmin_model->update('cms_client_feedback',$client_data,array('id'=>$id))){
				$this->session->set_flashdata('msg_success','Feedback Added successfully.');
				redirect('backend/content/client_feedback');
			}else{
				$this->session->set_flashdata('msg_error','Failed, Please try again.');
				redirect('backend/content/client_feedback');
			}
		}
		$data['feedback']=$this->superadmin_model->get_row('cms_client_feedback',array('id'=>$id)); 
    	$data['template']='backend/content/client_feedback_edit';
		$this->load->view('templates/superadmin_template',$data);
    }
       public function client_feedback_delete($id='')
    {
    	 $this->_check_login(); //check login authentication
    	 $data['title']='';
        if(empty($id)) redirect(base_url().'backend/content/client_feedback');
        $data1['img']=$this->superadmin_model->checkimg('cms_client_feedback',$id);
        $filepath=$data1['img']->client_image;
        if(!empty($filepath)) @unlink($filepath);
       
        if($this->superadmin_model->delete('cms_client_feedback',array('page_id'=>$id))){
                $this->session->set_flashdata('msg_success','Client Feedback deleted successfully.');
                redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error','Failed, Please try again.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
     function check_client_image($str){
    $this->_check_login(); //check login authentication
    $data['title']='';
    if(empty($_FILES['client_image']['name'])){
            $this->form_validation->set_message('check_client_image', 'Choose Client Image');
           return FALSE;
    }
    $image = getimagesize($_FILES['client_image']['tmp_name']);
        if (($image[0] < 260 || $image[1] < 260) || ($image[0] > 300 || $image[1] > 300) ){
            $this->form_validation->set_message('check_client_image', 'Oops! Your Client image needs to be atleast 260 x 260 pixels and at max 300 x 300.');
            return FALSE;    
        }
    if(!empty($_FILES['client_image']['name'])):
        $config['upload_path'] = './assets/uploads/client_images/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']  = '5024';
        $config['max_width']  = '5024';
        $config['max_height']  = '5024';
        $this->load->library('upload', $config);
         $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('client_image')){
            $this->form_validation->set_message('check_client_image', $this->upload->display_errors());
            return FALSE;
        }else{
            $data = $this->upload->data(); // upload image                    
            $this->session->set_userdata('check_client_image',array('image_url'=>$config['upload_path'].$data['file_name'],
                 'client_img'=>$data['file_name']));
            return TRUE;
        }
    else:
        $this->form_validation->set_message('check_client_image', 'The %s field required.');
        return FALSE;
    endif;
    }

     public function sub_page_banner()
   {
    	$this->_check_login(); //check login authentication
    	$data['title']='sub_page_banner';
    	
		$this->form_validation->set_rules('title','title','trim');
		$this->form_validation->set_rules('sub_title1', 'sub_title1', 'trim');	
		$this->form_validation->set_rules('banner_img','','callback_banner_img_check');
			
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){	    		
           $data_insert['page_id']=$this->input->post('page_name');
		   $data_insert['title']	=	$this->input->post('title');
		   $data_insert['sub_titile_1']	=	$this->input->post('sub_title1');
		   $data_insert['content_alignment']	=	$this->input->post('content_alignment');
		   $data_insert['created'] = date('Y-m-d,H:i:s A');
		   if($this->session->userdata('banner_img_check')!=''){
				$banner_img_check=$this->session->userdata('banner_img_check');
				$data_insert['banner_image'] = 'assets/uploads/sub_page_banner/'.$banner_img_check['banner_img'];				
			}          
          if($banner_id = $this->superadmin_model->insert('sub_page_banners',$data_insert)){
				if($this->session->userdata('banner_img_check')):
					$this->session->unset_userdata('banner_img_check');				   
				endif;				
			  $this->session->set_flashdata('msg_success','Banner Image Added successfully.');
			  redirect('backend/content/sub_page_banner');
		   }
		}
	$data['banner_info'] = $this->superadmin_model->get_result('sub_page_banners');	
   	$data['template']='backend/content/sub_page_banner';
	$this->load->view('templates/superadmin_template',$data);
   }
   public function sub_page_banner_edit($id='')
   {   
   	    $this->_check_login(); //check login authentication
    	$data['title']='edit_sub_page_banner';
    	if(empty($id)){ redirect('backend/content/sub_page_banner'); }
		$this->form_validation->set_rules('title','title','trim');
		$this->form_validation->set_rules('sub_title1', 'sub_title1', 'trim');	
		if(!empty($_FILES['banner_img']['tmp_name'])){
		$this->form_validation->set_rules('banner_img','','callback_banner_img_check');
	    }
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
	     		
           $data_update['page_id']=$this->input->post('page_name');
		   $data_update['title']	=	$this->input->post('title');
		   $data_update['sub_titile_1']	=	$this->input->post('sub_title1');
		   $data_update['content_alignment']	=	$this->input->post('content_alignment');
		   $data_update['updated'] = date('Y-m-d,H:i:s A');
		   if($this->session->userdata('banner_img_check')!=''){
				$banner_img_check=$this->session->userdata('banner_img_check');
				$data_update['banner_image'] = 'assets/uploads/sub_page_banner/'.$banner_img_check['banner_img'];				
			}	
		if($this->superadmin_model->update('sub_page_banners', $data_update,array('page_id'=>$id))){
             if($this->session->userdata('banner_img_check')):
					$this->session->unset_userdata('banner_img_check');				   
				endif;
		     $this->session->set_flashdata('msg_success','Banner Image updated successfully.');
			  redirect('backend/content/sub_page_banner');		
		}	
	 }			
    $data['banner_info'] = $this->superadmin_model->get_row('sub_page_banners',array('id'=>$id));	
    if(!$data['banner_info']){ redirect('backend/content/sub_page_banner'); }
   	$data['template']='backend/content/sub_page_banner_edit';
	$this->load->view('templates/superadmin_template',$data);
   }
   public function delete_sub_page_banner($id=''){    
        $this->_check_login(); //check login authentication
        $data['title']='';
        if(empty($id)) redirect(base_url().'backend/content/sub_page_banner');
        $data1['img']=$this->superadmin_model->checkimg('sub_page_banners',$id);
        $filepath=$data1['img']->banner_image;
        if(!empty($filepath)) @unlink($filepath);
       
        if($this->superadmin_model->delete('sub_page_banners',array('id'=>$id))){
                $this->session->set_flashdata('msg_success','Banner image deleted successfully.');
                redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error','Failed, Please try again.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
       public function banner_img_check($str){
    $this->_check_login(); //check login authentication
    $data['title']='';
	if(empty($_FILES['banner_img']['name'])){
			$this->form_validation->set_message('banner_img_check', 'Choose Banner Image.');
           return FALSE;
		}
	$image = getimagesize($_FILES['banner_img']['tmp_name']);
       if ($image[0] != 1230 || $image[1] != 365) {
           $this->form_validation->set_message('banner_img_check', 'Oops! Your banner image needs to be exactly 1230 x 365 pixels.');
           return FALSE;
       }
	if(!empty($_FILES['banner_img']['name'])):
		$config['upload_path']   = './assets/uploads/sub_page_banner/';
		$config['allowed_types'] = 'jpeg|jpg|png';
		$config['max_size']      = '5024';
		$config['max_width']     = '5024';
		$config['max_height']    = '5024';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('banner_img')){
			$this->form_validation->set_message('banner_img_check', $this->upload->display_errors());
			return FALSE;
		}else{
			$data = $this->upload->data(); // upload image			
			$this->session->set_userdata('banner_img_check',array('image_url'=>$config['upload_path'].$data['file_name'],'banner_img'=>$data['file_name']));
			return TRUE;
		}
	else:
		$this->form_validation->set_message('banner_img_check','The %s field required.');
		return FALSE;
	endif;
	}
    public function live_stores()
    {
    
    $this->_check_login(); //check login authentication
    $data['title']='live_stores';
    if($this->input->post('type_action') == 1){       
		$this->form_validation->set_rules('page_to_redirect','page_to_redirect','trim');
		$this->form_validation->set_rules('order', 'sequence No.', 'required');
		$this->form_validation->set_rules('live_store','','callback_check_live_store');	
    }
    if($this->input->post('type_action') == 2){   
       $this->form_validation->set_rules('title', 'Header title', 'required');
    }
    if($this->input->post('type_action') == 3){       
    	
		if(!empty($_FILES['live_store']['tmp_name'])){
			$this->form_validation->set_rules('live_store','','callback_check_live_store');
	  	}	
	  	 $this->form_validation->set_rules('page_to_redirect_edit','page_to_redirect_edit','trim');	
    }
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
              if($this->input->post('type_action') == 1 || $this->input->post('type_action') == 3){ 
					if($this->session->userdata('check_live_store')!=''){
						$check_live_store=$this->session->userdata('check_live_store');
						$data_img['live_store_img'] = 'assets/uploads/live_stores/'.$check_live_store['live_store'];
					}  
					if($this->input->post('type_action') == 1){
						$data_img['live_store_link'] = $this->input->post('page_to_redirect');
						$data_img['created'] = date('Y-m-d,H:i:s A');
						$data_img['order'] = $this->input->post('order');
						if($this->superadmin_model->insert('cms_live_online_store',$data_img)){
							$this->session->unset_userdata('check_live_store');		
							$this->session->set_flashdata('msg_success','Online Store Added successfully.');
						}else{
							$this->session->set_flashdata('msg_error','Failed, Please try again.');
						}								
					} 			
					if($this->input->post('type_action') == 3){
						$data_img['live_store_link'] = $this->input->post('page_to_redirect_edit');
						$data_img['order'] = $this->input->post('order_edit');
						if($this->superadmin_model->update('cms_live_online_store',$data_img,array('id'=>$this->input->post('row_id')))){
							$this->session->unset_userdata('check_live_store');		
							$this->session->set_flashdata('msg_success','Updated Store Added successfully.');
						}else{
							$this->session->set_flashdata('msg_error','Failed, Please try again.');
						}
					} 
					redirect('backend/content/live_stores');			
									
              }
         	 if($this->input->post('type_action') == 2){ 					
						$data_insert['title'] = $this->input->post('title');
					if($this->superadmin_model->update('cms_live_online_store',$data_insert,array('type'=>1))){
						
					$this->session->set_flashdata('msg_success','Online Store Header Title Updated successfully.');
					redirect('backend/content/live_stores');
					}else{
					$this->session->set_flashdata('msg_error','Failed, Please try again.');
					redirect('backend/content/live_stores');
					}	
              } 
		}
    $data['live_store_title'] = $this->superadmin_model->get_row('cms_live_online_store',array('type'=>'1'),array());
    $data['live_store_img'] = $this->superadmin_model->get_result('cms_live_online_store',array('type'=>'2'),array(''),array('order','ASC')); 
    $data['template']='backend/content/live_stores';
	$this->load->view('templates/superadmin_template',$data);
    }

      public function delete_live_store($id='')
    {
    	 $this->_check_login(); //check login authentication
    	 $data['title']='';
        if(empty($id)) redirect(base_url().'backend/content/live_stores');
        $data1['img']=$this->superadmin_model->checkimg('cms_live_online_store',$id);
        $filepath=$data1['img']->live_store_img;
        if(!empty($filepath)) @unlink($filepath);
       
        if($this->superadmin_model->delete('cms_live_online_store',array('id'=>$id))){
                $this->session->set_flashdata('msg_success','Live Store image deleted successfully.');
                redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error','Failed, Please try again.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    function check_live_store($str){ 
    $this->_check_login(); //check login authentication
    $data['title']='';
    if(empty($_FILES['live_store']['name'])){    	
            $this->form_validation->set_message('check_live_store', 'Choose the open store Image');
           return FALSE;
        }	
    if(!empty($_FILES['live_store']['name'])):
    	$image = getimagesize($_FILES['live_store']['tmp_name']);
        if ($image[0] < 160 || $image[1] < 45 || $image[0] > 320 || $image[1] > 90) {
           $this->form_validation->set_message('check_live_store', 'Oops! Your Live store image needs to be atleast of 160 x 45 pixels and at most of 320 X 90 pixels.');
           return FALSE;
      	 }
    	
        $config['upload_path'] = './assets/uploads/live_stores/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']  = '5024';
        $config['max_width']  = '5024';
        $config['max_height']  = '5024';
        $this->load->library('upload', $config);
			if (!$this->upload->do_upload('live_store')){
				$this->form_validation->set_message('check_live_store', $this->upload->display_errors());
				return FALSE;
			}else{
				$data = $this->upload->data(); // upload image                    
				$this->session->set_userdata('check_live_store',array('live_store'=>$data['file_name']));
				return TRUE;
			}
    else:    	
        $this->form_validation->set_message('check_live_store', 'The %s field required.');
        return FALSE;
    endif;
    }
	public function bulk_it()
    {    	
		    $this->_check_login(); //check login authentication
		    $data['title']='bulk_it';
            if(isset($_POST['update'])){
			    if($this->input->post('type_action')==2){			   
				$order = $this->input->post('order');
				foreach ($order as $key => $value) { 
				$this->superadmin_model->update('cms_bulk_it',array('order'=>$value),array('id'=>$key));
				}            
				$this->session->set_flashdata('msg_success','Order sequence updated successfully.');
				redirect('backend/content/bulk_it');
	    		}
	    	}	
            
            if($this->input->post('type_action')==1) {
           
         	$this->form_validation->set_rules('title1','Content','required');
         	$this->form_validation->set_rules('order', 'sequence No.', 'required');
         	$this->form_validation->set_rules('bulk_it_img','','callback_check_bulk_it_img');
         	       	
         	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run() == TRUE){
				
				$content_data['title1']= $this->input->post('title1');
				$content_data['order'] = $this->input->post('order');			
					if($this->session->userdata('check_bulk_it_img')!=''){
								
					$check_bulk_it_img = $this->session->userdata('check_bulk_it_img');
					$content_data['bulk_it_img'] = 'assets/uploads/cms_bulk_img/'.$check_bulk_it_img['bulk_it_img'];
					}
                 
				if($this->superadmin_model->insert('cms_bulk_it',$content_data)){
			     $this->session->unset_userdata('check_bulk_it_img');		
				$this->session->set_flashdata('msg_success','Content Added successfully.');
				redirect('backend/content/bulk_it');
			    }else{
				$this->session->set_flashdata('msg_error','Failed, Please try again.');
				redirect('backend/content/bulk_it');
			    }
			}
	     }		
   
   $data['bulk_content'] = $this->superadmin_model->get_result('cms_bulk_it',array(),array(),array('order','ASC'));
    $data['template']='backend/content/bulk_it';
	$this->load->view('templates/superadmin_template',$data);
    }
  
   public function bulk_it_edit($id='')
    {
        $this->_check_login(); //check login authentication
        $data['title']='bulk_it_edit';
        if(!$data['bulk_content'] = $this->superadmin_model->get_row('cms_bulk_it',array('id'=>$id))){
        	redirect('backend/content/bulk_it');
        }
	   		$this->form_validation->set_rules('title1','Title1','required');         
			if(!empty($_FILES['bulk_it_img']['tmp_name'])){
	        $this->form_validation->set_rules('bulk_it_img','','callback_check_bulk_it_img');
			}	   
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
      
				$content_data['title1']= $this->input->post('title1');
					if($this->session->userdata('check_bulk_it_img')!=''){
					$data1['img']=$this->superadmin_model->checkimg('cms_bulk_it',$id);
					$filepath=$data1['img']->bulk_it_img;
					if(!empty($filepath)) @unlink($filepath);	
					$check_bulk_it_img = $this->session->userdata('check_bulk_it_img');
					$content_data['bulk_it_img'] = 'assets/uploads/cms_bulk_img/'.$check_bulk_it_img['bulk_it_img'];
					}
			
       if($this->superadmin_model->update('cms_bulk_it',$content_data,array('id'=>$id))){
       	         $this->session->unset_userdata('check_bulk_it_img');
				$this->session->set_flashdata('msg_success','Updated successfully.');
				redirect('backend/content/bulk_it');
		}else{
				$this->session->set_flashdata('msg_error','Failed, Please try again.');
				redirect('backend/content/bulk_it');
       }   
       
	}	
   
    $data['template']='backend/content/bulk_it_edit';
	$this->load->view('templates/superadmin_template',$data);
    }


   function check_bulk_it_img($str){
    $this->_check_login(); //check login authentication
 
    if(empty($_FILES['bulk_it_img']['name'])){
            $this->form_validation->set_message('check_bulk_it_img', 'Choose Images');
           return FALSE;
        }
    
    if(!empty($_FILES['bulk_it_img']['name'])):
    	$image = getimagesize($_FILES['bulk_it_img']['tmp_name']);
      if($_POST['type']==2){
	       if ($image[0] < 125 || $image[1] < 125) {
	           $this->form_validation->set_message('check_bulk_it_img', 'Oops! bulk it Slider image needs to be atleast 125 x 125 pixels.');
	           return FALSE;
	       }
	       if ($image[0] > 250 || $image[1] > 250) {
	           $this->form_validation->set_message('check_bulk_it_img', 'Oops!  bulk it Slider image needs to be at most of 250 x 250 pixels.');
	           return FALSE;
	       }
      } 
      if($_POST['type']==1){
      	  if ($image[0] < 1240 || $image[1] < 560) {
	           $this->form_validation->set_message('check_bulk_it_img', 'Oops! bulk it image needs to be atleast 1240 x 560 pixels.');
	           return FALSE;
	      }
      }
        $config['upload_path'] = './assets/uploads/cms_bulk_img/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size']  = '5024';
        $config['max_width']  = '5024';
        $config['max_height']  = '5024';
        $this->load->library('upload', $config);
			if (!$this->upload->do_upload('bulk_it_img')){
				$this->form_validation->set_message('check_bulk_it_img', $this->upload->display_errors());
				return FALSE;
			}else{
				$data = $this->upload->data(); // upload image                    
				$this->session->set_userdata('check_bulk_it_img',array('bulk_it_img'=>$data['file_name']));
				return TRUE;
			}
    else:
        $this->form_validation->set_message('check_bulk_it_img', 'The %s field required.');
        return FALSE;
    endif;
    }
    public function delete_bulk_it($id='')
    {
    	 $this->_check_login(); //check login authentication
    	 $data['title']='';
        if(empty($id)) redirect(base_url().'backend/content/bulk_it_slider');
        $data1['img']=$this->superadmin_model->checkimg('bulk_it_cms',$id);
        $filepath=$data1['img']->banner_image;
        if(!empty($filepath)) @unlink($filepath);
       
        if($this->superadmin_model->delete('bulk_it_cms',array('id'=>$id))){
                $this->session->set_flashdata('msg_success','Slider image deleted successfully.');
                redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error','Failed, Please try again.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function open_store()
   {
      $this->_check_login(); //check login authentication
      $data['title']='open_store';  
            $data['open_store'] = $this->superadmin_model->get_row('cms_home_page',array('id'=>1));       
         	$this->form_validation->set_rules('page_content','Content','required');         	
         	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run() == TRUE){			
			
               // $open_store_data['title'] = 'Fund_it';
               // $open_store_data['main_content'] = $this->input->post('page_content');
				$open_store_data['updated_content'] = $this->input->post('page_content');	
				$open_store_data['updated'] = date('Y-m-d,H:i:s A');			               
				if($this->superadmin_model->update('cms_home_page',$open_store_data,array('id'=>1))){				
				$this->session->set_flashdata('msg_success','Content updated successfully.');
				redirect('backend/content/open_store');
			    }else{
				$this->session->set_flashdata('msg_error','Failed, Please try again.');
				redirect('backend/content/open_store');
			    }
			}
		
		$data['template']='backend/content/open_store';
		$this->load->view('templates/superadmin_template',$data);
   }
   public function fund_it()
    {  
      
    	$this->_check_login(); //check login authentication
    	$data['title']='fund_it';
        $data['open_store'] = $this->superadmin_model->get_row('cms_home_page',array('id'=>2));
        $this->form_validation->set_rules('page_content','Content','required');         	
         	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run() == TRUE){					
             
             	//$open_store_data['main_content'] = $this->input->post('page_content');
				$open_store_data['updated_content'] = $this->input->post('page_content');	
				$open_store_data['updated'] = date('Y-m-d,H:i:s A');			               
				if($this->superadmin_model->update('cms_home_page',$open_store_data,array('id'=>2))){				
				$this->session->set_flashdata('msg_success','Content updated successfully.');
				redirect('backend/content/fund_it');
			    }else{
				$this->session->set_flashdata('msg_error','Failed, Please try again.');
				redirect('backend/content/fund_it');
			    }
			}
        
   
		
	    $data['template']='backend/content/fund_it';
		$this->load->view('templates/superadmin_template',$data);
    }
   public function check_background_img($str)
   {
   	$this->_check_login(); //check login authentication
   	$data['title']='';
   	   	  if(empty($_FILES['background_img']['name'])){
            $this->form_validation->set_message('check_background_img', 'Choose  Image');
           return FALSE;
    }
    $image = getimagesize($_FILES['background_img']['tmp_name']);       
    if(!empty($_FILES['background_img']['name'])):
        $config['upload_path'] = './assets/uploads/cms_bulk_img/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']  = '5024';
        $config['max_width']  = '5024';
        $config['max_height']  = '5024';       
        $this->load->library('upload', $config);
         $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('background_img')){
            $this->form_validation->set_message('check_background_img', $this->upload->display_errors());
            return FALSE;
        }else{
            $data = $this->upload->data(); // upload image                    
            $this->session->set_userdata('check_background_img',array('background_image'=>$data['file_name']));
            return TRUE;
        }
    else:
        $this->form_validation->set_message('check_background_img', 'The %s field required.');
        return FALSE;
    endif;
   
   }

    public function menus($offset=0){
    
		$this->_check_login(); //check login authentication
		$data['title']='menus'; 
        if($this->input->post('action_type')==2){
         if(isset($_POST['update'])){
			    		   
				$order = $this->input->post('order');
				foreach ($order as $key => $value) { 
				$this->superadmin_model->update('menu_footer',array('order'=>$value),array('id'=>$key));
				}            
				$this->session->set_flashdata('msg_success','Order sequence updated successfully.');
				redirect('backend/content/menus');
	   	}	
	   }	
	     if($this->input->post('action_type')==1){
			if(isset($_POST['add'])){
				$this->form_validation->set_rules('menu_section','Menu Section','required');
				$this->form_validation->set_rules('menu_title','Menu Title','required');
				$this->form_validation->set_rules('link_type','Link Type Title','required');
				$this->form_validation->set_rules('link','link','trim');
				$this->form_validation->set_rules('order','Menu Sequence Order','required');

				$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
				if ($this->form_validation->run() == TRUE){
				$menu_data = array(
					'menu_section'	=>	$this->input->post('menu_section'),
					'menu_title'	=>	$this->input->post('menu_title'),
					'menu_slug'		=> 	url_title($this->input->post('menu_title'), '-', TRUE),
					'link_type'	=>	$this->input->post('link_type'),
					'rediredt_link'	=>	$this->input->post('link'),
					'order'	=>	$this->input->post('order'),
					'status'	=>	1,
					'created'	=>	date('Y-m-d H:i:s A'));
					if($this->input->post('link_type')==3){           
					$menu_data['rediredt_link'] = $this->input->post('site_link');
					}elseif($this->input->post('link_type')==2){
					$menu_data['rediredt_link'] = $this->input->post('custom_link');				
					}else{
					$menu_data['rediredt_link'] = $this->input->post('site_page_link');
					}
					if($this->superadmin_model->insert('menu_footer',$menu_data)){
						$this->session->set_flashdata('msg_success','Menu added successfully.');
						redirect('backend/content/menus');
					}else{
						$this->session->set_flashdata('msg_error','Failed, Please try again.');
						redirect('backend/content/menus');
					}
				}
			}
		}	

		$per_page=25;
		$data['offset']=$offset;
		$data['menu'] = $this->superadmin_model->menu_footer($offset,$per_page);
 		$config=backend_pagination();
		$config['base_url'] = base_url().'backend/content/menus';
		$config['total_rows'] = $this->superadmin_model->menu_footer(0,0);
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		$data['pages'] = $this->superadmin_model->get_result('pages',array('status'=>1));
 		$data['template']='backend/content/menus';
		$this->load->view('templates/superadmin_template',$data);
	}

	public function menu_edit($menu_id='',$offset=''){
		$this->_check_login(); //check login authentication
		$data['title']='menu_edit';
		if(empty($menu_id)) redirect('backend/content/menus');
			$this->form_validation->set_rules('menu_section','Menu Section','required');
			$this->form_validation->set_rules('menu_title','Menu Title','required');
			$this->form_validation->set_rules('link_type','Link Type','required');
			$this->form_validation->set_rules('link','link','trim');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			$menu_data = array(
				'menu_section'	=>	$this->input->post('menu_section'),
				'menu_title'	=>	$this->input->post('menu_title'),
				// 'menu_slug'		=> 	url_title($this->input->post('menu_title'), '-', TRUE),
				'link_type'		=>	$this->input->post('link_type'),
				'updated'		=>	date('Y-m-d H:i:s A'));
			if($this->input->post('link_type')==3){           
            $menu_data['rediredt_link'] = $this->input->post('link');
			}elseif($this->input->post('link_type')==2){
			$menu_data['rediredt_link'] = $this->input->post('custom_link');				
			}else{
			 $menu_data['rediredt_link'] = $this->input->post('site_page_link');
			}
			if($this->superadmin_model->update('menu_footer',$menu_data,array('id'=>$menu_id))){
				$this->session->set_flashdata('msg_success','Menu updated successfully.');
				redirect('backend/content/menus');
			}else{
				$this->session->set_flashdata('msg_error','Failed, Please try again.');
				redirect('backend/content/menus');
			}
		}
		if(!$data['menu'] = $this->superadmin_model->get_row('menu_footer',array('id'=>$menu_id))){
			redirect('backend/content/menus');
		}
		$data['pages'] = $this->superadmin_model->get_result('pages',array('status'=>1));
		$data['template'] ='backend/content/menu_edit';
		$this->load->view('templates/superadmin_template',$data);
	}

	public function menu_delete($menu_id =''){
		$this->_check_login(); //check login authentication		
		if(empty($menu_id)) redirect('backend/content/menus');
		if($this->superadmin_model->delete('menu_footer',array('id'=>$menu_id))){
				$this->session->set_flashdata('msg_success','Menu deleted successfully.');
				redirect('backend/content/menus');
		}else{
			$this->session->set_flashdata('msg_error','Failed, Please try again.');
			redirect('backend/content/menus');
		}
	}

}