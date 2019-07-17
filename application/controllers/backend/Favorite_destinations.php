<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Favorite_destinations extends CI_Controller
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
		 if(!empty($_GET['category']))
		{	
		    $cat = $_GET['category'];
			if($cat==1){
				$data['title']='Favorite Destinations';
			}
			elseif($cat==2){
				$data['title']='Urban Destinations';
			}
			elseif($cat==3){
				$data['title']='Beach Destinations';
			}
			elseif($cat==4){
				$data['title']='Extraordinary Destinations';
			}
		}else{$data['title']='All Destinations';}
	
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url']   = base_url().'backend/favorite_destinations/index';
        $config['total_rows'] = $this->user_model->users_fev_destination(0,0,$search,$sort);
        
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
		
		$data['videos']=$this->user_model->users_fev_destination($offset,PER_PAGE,$search,$sort);
		if(!empty($_POST["submitOrder"]) && $_POST["submitOrder"]==1){ 
			//print_r($_POST);die();
			for ($i=0; $i < count($_POST['main_id']); $i++) {     
	                $order_data['order_by'] = $_POST['order_by'][$i];   
	                $this->superadmin_model->update('fh_favorite_destinations',$order_data,array('favorite_id'=>$_POST['main_id'][$i]));
	        }
	            $this->session->set_flashdata('msg_success','Order updated successfully.');
	        if(!empty($_GET))
			{	
				$cat = $_GET['category'];
				
				redirect('backend/favorite_destinations?category='.$cat);
			}else{

	                redirect('backend/favorite_destinations');
			}
		}
		$data['offset']=$offset;
		$this->pagination->initialize($config);
        $data['pagination']	= $this->pagination->create_links();
		$data['template']='backend/favDestination/favorite_destination';
       $this->load->view('templates/superadmin_template',$data);
	}
	public function add_destinations()
	{	
		$data['title']='Add Destinations';
		//echo "<pre>"; print_r($_FILES); die();
		if($this->input->post("action")==1 && !empty($_FILES['cover_photo']['name']))
		{
			$this->form_validation->set_rules('city','City','required');
		    $this->form_validation->set_rules('country','Country','required');
		    $this->form_validation->set_rules('world_region','World Region','required');
		    $this->form_validation->set_rules('url','URL','required');
		    $this->form_validation->set_rules('cover_photo', 'File', 'trim|xss_clean');
		   
		    if($this->form_validation->run()) 
		    {

		      $tempArrImg = array();
		      $thumbImagearry = array();
		      $path='/assets/uploads/destinations/';
		      $config['upload_path']    = $path;
			  $config['allowed_types']  = 'gif|jpg|png|svg';
			  // $config['max_size']       = '1000';
			  $config['min_width']      = '100';
			  $config['min_height']     = '100';
			  $config['max_width']      = '5200';
			  $config['max_height']     = '6000';


			  $validFile = TRUE;
		      $filesCount = count($_FILES['cover_photo']['name']); 
			  for($i = 0; $i < $filesCount; $i++) {
		      	$p = getimagesize($_FILES['cover_photo']['tmp_name'][$i]);
		      	//print_r($p); die();
		      	if($p[0] >= 254 && $p[1] >= 260) {

		      	}
		      	else {
		      		$validFile = FALSE;
		      	}
		      		  	
			  }
					if($validFile) 
					{
				  	for($i = 0; $i < $filesCount; $i++)
	       			{ 
	                 $_FILES['file']['name']     = $_FILES['cover_photo']['name'][$i];
	                 $_FILES['file']['type']     = $_FILES['cover_photo']['type'][$i];
	                 $_FILES['file']['tmp_name'] = $_FILES['cover_photo']['tmp_name'][$i];
	                 $_FILES['file']['error']     = $_FILES['cover_photo']['error'][$i];
	                 $_FILES['file']['size']     = $_FILES['cover_photo']['size'][$i];
	                 $uploadPath = './assets/uploads/destinations/main/';
	                 $config['upload_path'] = $uploadPath;
	                 $config['allowed_types'] = 'jpg|jpeg|png|gif';
	                 $this->load->library('upload', $config);
	                 $this->upload->initialize($config);
	                
		                 if($this->upload->do_upload('file'))
		                 {	
		                 	$tempArrImg[] = $path.$_FILES['cover_photo']['name'][$i];
		                 	
			                $fileData = $this->upload->data();
							$config_imgp['source_path']      	= './assets/uploads/destinations/main/';
							$config_imgp['destination_path'] 	= './assets/uploads/destinations/';
							$config_imgp['width']            	= '260';
							$config_imgp['height']           	= '300';
							$config_imgp['file_name_source'] 	= $fileData['file_name'];
							$config_imgp['file_name'] 			= $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
							$thumbnail  = create_thumbnail($config_imgp);
							$config_imgs['source_path']      = './assets/uploads/destinations/';
							$config_imgs['destination_path'] = './assets/uploads/destinations/thumbnail/';
							$config_imgs['width']            = '100';
							$config_imgs['height']           = '100';
							$config_imgs['file_name_source'] = $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
							$config_imgs['file_name'] 			 = $fileData['raw_name'].'-thumbnail-small'.$fileData['file_ext'];
							$thumbnail_small  = create_thumbnail($config_imgs);
							//$this->session->set_flashdata('msg_success','Inserted successfully');
							$thumbImagearry[] = $path.$config_imgp['file_name'];
						}
						else
		                {  
		                  $this->session->set_flashdata('msg_error',$this->upload->display_errors());
		                }
					}
					}
					else
					{
					$this->session->set_flashdata('msg_error',"Please upload valid image size  "); 
					}
	          	$imageName = implode(',', $tempArrImg);
	          	$thumbImage = implode(',', $thumbImagearry);
	          	if(!empty($this->input->post('category')))
	          		{ 
	          			$category = $this->input->post('category');
	          		} else
	          		{
	          			$category=0;
	          		} 
	          	$data=array(
	               'user_id'        => superadmin_id(),
	               'city'           => $this->input->post('city'),
	               'country'     	=> $this->input->post('country'),
	               'order_by'     	=> $this->input->post('order_by'),
	               'world_region'  	=> $this->input->post('world_region'),
	               'website_type'   => $this->input->post('type'),
	               'url'     	    => $this->input->post('url'),
	               'approved_by_admin'   => 1,
	               'category'   => $category,
	               'photo'          => $imageName,
	               'photo_thumbnail' => $thumbImage,
        		);
        			if($this->user_model->insert('fh_favorite_destinations',$data)){
	        			$this->session->set_flashdata('msg_success','Destination Data Inserted successfully');
	        		    if(!empty($this->input->post('category')))
	        			{
	        				$cat = $this->input->post('category');
	        				redirect('backend/favorite_destinations?category='.$cat);
	        				}else
	        				{
								redirect('backend/favorite_destinations');
	        			    }
	        		}
	        }
			else
		    { 
		    	$this->session->set_flashdata('msg_error','Somthing Wrong With data');
			}
		}
		$data["regions"] = $this->user_model->get_result('fh_world_regions','',array('region,wr_id'));
		$data['template'] ='backend/favDestination/add_destinations';
		$this->load->view('templates/superadmin_template', $data);
	}
	public function edit($id)
	{   
		$data['title'] = 'Edit destinations';
		$data['destination_id'] = $id;
		$data["regions"] = $this->user_model->get_result('fh_world_regions','',array('region,wr_id'));
		$data["destinations"] = $this->user_model->get_row('fh_favorite_destinations',array('favorite_id'=>$id));
		$data['template'] ='backend/favDestination/edit';
		$this->load->view('templates/superadmin_template', $data);
	}
	public function update_destinations($id)
	{	
		if($this->input->post("action")==1)
		{
			$this->form_validation->set_rules('city','City','required');
		    $this->form_validation->set_rules('country','Country','required');
		    $this->form_validation->set_rules('world_region','World Region','required');
		    $this->form_validation->set_rules('url','URL','required');
		    $this->form_validation->set_rules('cover_photo', 'File', 'trim|xss_clean');
		   
		    if($this->form_validation->run()) 
		    {
 			  $tempArrImg = '';
		      $thumbImagearry = '';
 			if(!empty($_FILES) && $_FILES['cover_photo']['name']!=''){


		    
		      $path='/assets/uploads/destinations/';
		      $config['upload_path']    = $path;
			  $config['allowed_types']  = 'gif|jpg|png|svg';
			  // $config['max_size']       = '1000';
			  $config['min_width']      = '254';
			  $config['min_height']     = '260';
			  $config['max_width']      = '5200';
			  $config['max_height']     = '6000';
					 $_FILES['file']['name']     = $_FILES['cover_photo']['name'];
	                 $_FILES['file']['type']     = $_FILES['cover_photo']['type'];
	                 $_FILES['file']['tmp_name'] = $_FILES['cover_photo']['tmp_name'];
	                 $_FILES['file']['error']     = $_FILES['cover_photo']['error'];
	                 $_FILES['file']['size']     = $_FILES['cover_photo']['size'];
	                 $uploadPath = './assets/uploads/destinations/main/';
	                 $config['upload_path'] = $uploadPath;
	                 $config['allowed_types'] = 'jpg|jpeg|png|gif';
	                 $this->load->library('upload', $config);
	                 $this->upload->initialize($config);
	                
	                 if($this->upload->do_upload('file'))
	                 {	
	                 	$imageName = $path.$_FILES['cover_photo']['name'];
	                 	
		                $fileData = $this->upload->data();
						$config_imgp['source_path']      	= './assets/uploads/destinations/main/';
						$config_imgp['destination_path'] 	= './assets/uploads/destinations/';
						$config_imgp['width']            	= '260';
						$config_imgp['height']           	= '300';
						$config_imgp['file_name_source'] 	= $fileData['file_name'];
						$config_imgp['file_name'] 			= $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
						$thumbnail  = create_thumbnail($config_imgp);
						$config_imgs['source_path']      = './assets/uploads/destinations/';
						$config_imgs['destination_path'] = './assets/uploads/destinations/thumbnail/';
						$config_imgs['width']            = '100';
						$config_imgs['height']           = '100';
						$config_imgs['file_name_source'] = $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];
						$config_imgs['file_name'] 			 = $fileData['raw_name'].'-thumbnail-small'.$fileData['file_ext'];
						$thumbnail_small  = create_thumbnail($config_imgs);
						$thumbImage = $path.$config_imgp['file_name'];
					}
				}
		          	if(!empty($this->input->post('category')))
		          		{ 
		          			$category = $this->input->post('category');
		          		} else
		          		{
		          			$category=0;
		          		} 
		          	$data=array(
		               'user_id'        => superadmin_id(),
		               'city'           => $this->input->post('city'),
		               'country'     	=> $this->input->post('country'),
		               'order_by'     	=> $this->input->post('order_by'),
		               'world_region'  	=> $this->input->post('world_region'),
		               'url'     	    => $this->input->post('url'),
	        		);
 					if(!empty($imageName)){
	        		$data['photo'] = $imageName;
	        		$data['photo_thumbnail'] = $thumbImage;
	        		}
        			if($this->user_model->update('fh_favorite_destinations',$data,array('favorite_id'=>$id))){
	        			$this->session->set_flashdata('msg_success','Destination Data Updated successfully');
	        		}
	        }
			else
		    { 
		    	$this->session->set_flashdata('msg_error','Somthing Wrong With data');
			}
		}
		   if(!empty($this->input->post('category')))
			{
				$cat = $this->input->post('category');
				redirect('backend/favorite_destinations?category='.$cat);
			}else{

	            redirect('backend/favorite_destinations');
			}
	}
	public function change_approve($id="",$approved_by_admin="",$offset=""){
	   
	    $data[]='';
	    $data=array('approved_by_admin'=>$approved_by_admin);
	    
	    if($this->superadmin_model->update('fh_favorite_destinations',$data,array('favorite_id'=>$id)))    {
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');}
	    redirect($_SERVER['HTTP_REFERER']);
	}
	function change_all_status(){
		$status   = $this->input->post('status');
		$ids      = $this->input->post('row_id');
		$this->common_model->change_all_status('fh_favorite_destinations','favorite_id',$ids,$status);
		 $this->session->set_flashdata('msg_success','Status has been changed successfully');
		$default_arr=array('status'=>TRUE);
	    header('Content-Type: application/json');
        echo json_encode($default_arr);   
	}
}