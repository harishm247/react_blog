<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Common extends CI_Controller {
	public function __construct(){ 
		parent::__construct(); 
        $this->load->model('superadmin_model');
		$this->load->model('common_model');
		//if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); //check login authentication
	} 
	public function change_status($table='',$col='',$value='',$status='') {
        if($table=='' || $col=='' || $value=='' || $status=='') redirect($_SERVER['HTTP_REFERER']);
        $update_status= array('status'=>$status);
        if($this->superadmin_model->update($table,$update_status,array($col=>$value))){
            if($table=='users'){
               $getUserRole = $this->common_model->get_row($table, array($col=>$value), array('user_role'));
                if(!empty($getUserRole)){
                    if($table=='users' && $col=='user_id' && $getUserRole->user_role==1){
                        $msg = ($status==1) ? "Seller activated successfully" : "Seller deactivated successfully";
                    }else if($table=='users' && $col=='user_id' && $getUserRole->user_role==2){
                        $msg = ($status==1) ? "Customer activated successfully" : "Customer deactivated successfully";
                    }else{
                        $msg = "Status updated successfully";
                    }
                }else{
                    $msg = "Status updated successfully";
                } 
            }else{
                $msg = "Status updated successfully";
            }
            $this->session->set_flashdata('msg_success', $msg);
        }else {
            $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function change_adminstatus($table='',$col='',$value='',$statuscol='',$status='') {
        if($table=='' || $col=='' || $value=='' || $status=='') redirect($_SERVER['HTTP_REFERER']);
        $update_status= array($statuscol=>$status);
		if($this->superadmin_model->update($table,$update_status,array($col=>$value))) {
            $this->session->set_flashdata('msg_success','Status updated successfully');
        }else {
            $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function delete($table='',$col='',$value=''){ 
       
		if($table=='' || $col=='' || $value=='') redirect($_SERVER['HTTP_REFERER']);
		$data = $this->common_model->get_row($table, array($col => $value));
		if (!$data) redirect($_SERVER['HTTP_REFERER']); 
		if ($this->common_model->delete($table, array($col => $value))){ 
			$this->session->set_flashdata('msg_success', 'Data deleted successfully'); 
		}else{ 
			$this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
		} 
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function autocomplete()
	{
		if(!empty($_GET) && !empty($_GET['attribute_code']) &&  $data=$this->common_model->get_row('attributes',array('attribute_code'=>$_GET['attribute_code']),array('attribute_value'))){
			$data=json_decode($data->attribute_value);
			$input=$_GET['query'];
			$result = array_filter($data, function ($item) use ($input) {
			    if (stripos($item, $input) !== false) {
			        return true;
			    }
			    return false;
			});
			echo json_encode(array_values($result));
		}
	}
// autosuugetion Controller search for user  ## Prem ##
    public function autosuggetion_user(){
        $username=$this->input->post('keyword');
        $table_name=$this->input->post('table_name');
        if($username):
        $data=$this->common_model->autosuggetion_user($table_name,$username); 
        echo "<ul  id='user-list'>";
        foreach ($data as $key => $value) { ?>
                
        <li onClick="selectCountry('<?php echo ucfirst($value["first_name"])." ".ucfirst($value["last_name"]); ?>');"><?php echo ucfirst($value["first_name"])." ".ucfirst($value["last_name"]); ?></li>
        <?php } 
        echo "</ul>";
        endif;
    }


}
	