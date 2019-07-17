<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class All_users_blog extends CI_Controller
{
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		$this->load->model('user_model');
		//$this->load->library('form_validation');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); //check login authentication
	} 
	public function index($offset="")
	{
		$search=array();
		$sort = "DESC";
		$data['title']='All article List';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
       
        $config=backend_pagination(); 
        $config['base_url']   = base_url().'backend/all_users_blog/index';
        $config['total_rows'] = $this->user_model->all_user_blogs_list(0,0,$search,$sort);
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
		$data['blogType']= $this->user_model->all_users_list();
		$data['influencerUsers']= $this->common_model->get_result('fh_influencer_info','', array('user_id'));
		
		$data['offset']=$offset;
		
		$data['blogs']=$this->user_model->all_user_blogs_list($offset,PER_PAGE,$search,$sort);
		if(!empty($_POST["submitOrder"]) && $_POST["submitOrder"]==1){ 
			//print_r($_POST);die();
			for ($i=0; $i < count($_POST['main_id']); $i++) {     
	                $order_data['order_by'] = $_POST['order_by'][$i];   
	                $this->superadmin_model->update('fh_blog_articles',$order_data,array('blog_id'=>$_POST['main_id'][$i]));
	        }
	            $this->session->set_flashdata('msg_success','Order updated successfully.');
	                redirect('backend/all_users_blog');
		}

		$data['blogType']=$this->user_model->blog_type();
		 $this->pagination->initialize($config);
        $data['pagination']	= $this->pagination->create_links();
		//$data['user_info'] 	= $user_info;
        $data['template']	= 'backend/blogs/blogs_list';
        $data['offset']		= $offset;
        $this->load->view('templates/superadmin_template',$data);
	}
	function change_all_status(){
		$status   = $this->input->post('status');
		$ids      = $this->input->post('row_id');
		$this->common_model->change_all_status('fh_blog_articles','blog_id',$ids,$status);
		$default_arr=array('approved_by_admin'=>TRUE);
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');
        echo json_encode($default_arr);   
	}
	function article_type_status(){
		 $status  = $this->input->post('status');
		 $ids     = $this->input->post('row_id');
		$status   = $this->common_model->change_publish_status('fh_blog_article_type','blog_article_id',$ids,$status);
		if(!empty($status)){
			$this->session->set_flashdata('msg_success','Status Changed succsessfully');
		}
			$default_arr=array('status'=>TRUE);
    	
	}
	public function blog_type()
	{
		$data['title']='Article type';
		if(!empty($this->input->post('blogTypeSubmit'))){
			$this->form_validation->set_rules('type', 'Type', 'required'); 
			$this->form_validation->set_rules('order_by', 'Order By', 'required');
			if ($this->form_validation->run() == TRUE){ 
				$article["type"] = $this->input->post("type");
				$article["order_by"] = $this->input->post("order_by");
				if(!empty($this->user_model->insert("fh_blog_article_type",$article)))
				{
					 $this->session->set_flashdata('msg_success','Articles type added succsessfully');
					  redirect('backend/all_users_blog/blog_type');
				}
				else
				{
					$this->session->set_flashdata('msg_error','Something went wrong! Please try again');
				}
			}else{

			}
		}

		if($this->input->post('type_action') == 2){    
	      $this->form_validation->set_rules('type[]', 'Type', 'required'); 
		  $this->form_validation->set_rules('order_by[]', 'Order By', 'required');
			if($this->form_validation->run() == TRUE){  
	        	for ($i=0; $i < count($_POST['main_id']); $i++) {          
	                $category_data['type'] = $_POST['type'][$i];             
	                $category_data['order_by'] = $_POST['order_by'][$i];   
	                $this->superadmin_model->update('fh_blog_article_type',$category_data,array('blog_article_id'=>$_POST['main_id'][$i]));
	            }
	                $this->session->set_flashdata('msg_success','Article type updated successfully.');
	                redirect('backend/all_users_blog/blog_type');
	        }
	        else{
	        }
        }
		
		$data["articleTypeData"] = $this->user_model->get_result_order_by("fh_blog_article_type");
		$data['template']	= 'backend/blogs/blogs_type';
        $this->load->view('templates/superadmin_template',$data);
	}

	public function change_approve($id="",$approved_by_admin="",$offset=""){
	    $data[]='';
	    $data=array('status'=>$approved_by_admin);
	    if($this->superadmin_model->update('fh_blog_article_type',$data,array('blog_article_id'=>$id)))    {
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');}
	    redirect($_SERVER['HTTP_REFERER']);
	} 
}

?>