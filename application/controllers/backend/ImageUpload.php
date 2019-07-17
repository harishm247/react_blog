<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class ImageUpload extends CI_Controller
{
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		$this->load->model('user_model');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen');
	} 
	public function index ()
	{	 
	    if(isset($_POST['fileSubmit'])){
			$this->form_validation->set_message('check_image', 'Please select cover image');
			if(!empty($_FILES['cover_photo']['name']))
			{
				$config['upload_path']   = './assets/uploads/blog';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_width']     = '5200';
				$config['max_height']    = '6000';
				$config['min_width']     = '260';
				$config['min_height']    = '300';
				$config['file_name']     = $_FILES['cover_photo']['name'];
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('cover_photo')){
					echo $this->upload->display_errors();
				}
				else
				{
					$fileData = $this->upload->data();
					echo "<pre>"; print_r($fileData); 
					echo $fileData['image_width']."<br>";
					echo $fileData['image_height'];
					//die();
					if($filedata['image_width'] < $config['min_width']){
						echo "True";
					}
					else{
						echo "False";
					}

					$config_imgp['source_path']      = './assets/uploads/blog/';
					$config_imgp['destination_path'] = './assets/uploads/blog/thumbnail/';
					$config_imgp['width']            = '260';
					$config_imgp['height']           = '300';
					$config_imgp['file_name_source'] = $fileData['file_name'];
					$config_imgp['file_name'] 		 = $fileData['raw_name'].'-thumbnail'.$fileData['file_ext'];

					$data['image_name'] = '/assets/uploads/blog/thumbnail/'.$config_imgp['file_name'];
					$thumbnail  = create_thumbnail($config_imgp);
					$insert = $this->common_model->insert("image",$data);
					$this->session->set_userdata('check_image',array('image'=>'assets/uploads/blog/'.$fileData['file_name'],'thumbnail'=>'assets/uploads/blog/thumbnail/'.$thumbnail['file_name']));
				}
			}
		}
		$data["getImage"] = $this->common_model->get_result("image");
		$data['template']	= 'backend/worldRegion/imageUpload';
        $this->load->view('templates/superadmin_template',$data);
	}
}
?>