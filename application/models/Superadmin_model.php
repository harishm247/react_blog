<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Superadmin_model extends CI_Model {
	public function insert($table_name='',  $data=''){
		$query=$this->db->insert($table_name, $data);
		if($query)
			return  $this->db->insert_id();
		else
			return FALSE;
	}
	public function get_result($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit=''){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif;
		if(!empty($order_by)):
			$this->db->order_by($order_by[0], $order_by[1]);
		endif;
		if(!empty($id_array)):
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		if(!empty($limit)):
			$this->db->limit($limit);
		endif;
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}
	public function get_row($table_name='', $id_array='',$columns=array(),$order_by=array()){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif;
		if(!empty($id_array)):
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		if(!empty($order_by)):			
			$this->db->order_by($order_by[0], $order_by[1]);
		endif; 
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}
	public function update($table_name='', $data='', $id_array=''){
		//echo "Fee"; print_r($data['approved_by_admin']); die();
		if(!empty($id_array)):
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		return $this->db->update($table_name, $data);
		
	}
	public function delete($table_name='', $id_array=''){
		  return $this->db->delete($table_name, $id_array);
	}
	public function get_result_with_pagination($offset='', $per_page='',$tablename){
		$this->db->from($tablename);
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$this->db->order_by('id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}
	public function get_result_with_pagination_msg($offset='', $per_page='',$tablename){
		$this->db->where('parent_id',0);
		$this->db->from($tablename);
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$this->db->order_by('id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}

 	function is_email_available($email)  
     {  
       $this->db->where('email', $email);  
       $query = $this->db->get("users");  
       if($query->num_rows() > 0)  
       {  
            return true;  
       }  
       else  
       {  
            return false;  
       }  
     } 
	public function email_templates($offset='', $per_page=''){
		$this->db->from('email_templates');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$this->db->order_by('id','asc');
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}
	
	public function pages($offset='', $per_page=''){
		$this->db->from('pages');
		
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$this->db->order_by('page_id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}



	public function faq_category($offset='', $per_page=''){
       
        if(!empty($_GET)){
        
      
	 
		if($_GET['store_cat_id']){
			 $this->db->where('faq_category_id', $this->input->get('store_cat_id'));	
		}
		if($_GET['category_name']){	
		   $this->db->like('category_name', trim($this->input->get('category_name')));
		}		
		
		if($_GET['status']){
			if($this->input->get('status')==0){
				$this->db->where('status',0);
			}else{
				$this->db->where('status', $this->input->get('status'));	
			}
		}
		if($_GET['order']){
			if($this->input->get('order')==1 || $this->input->get('order')==3){
				$order = 'ASC';	
		   }else{
		     	$order = 'DESC';
		   }
		   if($this->input->get('order')==1 || $this->input->get('order')==2){
				$column_name = 'faq_category_id';	
		   }else{
		 	  	$column_name = 'category_name';
		   }
		   $this->db->order_by($column_name,$order);
		}
	   }else{
	   	   $this->db->order_by('faq_category_id','DESC');
	   }


		$this->db->from('faq_category');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}
	

	public function faq($offset='', $per_page=''){
       
        if(!empty($_GET)){
			if($_GET['question']){	
			   $this->db->like('question', trim($this->input->get('question')));
			}		
			
			if($_GET['status']){
				if($this->input->get('status')==0){
					$this->db->where('status',0);
				}else{
					$this->db->where('status', $this->input->get('status'));	
				}
			}
	   	}else{
	   	   	$this->db->order_by('faq_id','DESC');
	   	}
		$this->db->from('faq');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}
	/* slider image upload */
	
	public function slider_images($offset='', $per_page=''){
		$this->db->from('slider_images');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$this->db->order_by('slider_images.slider_images_id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			$query = $this->db->get();
			return $query->num_rows();
		}
	}
	

	public function get_contactus($offset='', $per_page='')
    {
		if(!empty($_GET)){
			if(!isset($_GET['subject']) || !isset($_GET['support_id']) || !isset($_GET['sort_starred']) || !isset($_GET['order']) || !isset($_GET['userrole'])){
				redirect('backend/support/user_contactus');
			}				
			
			if($_GET['subject']){
				$this->db->where('reason',$_GET['subject']);
			}

			if($_GET['support_id']){
				$this->db->where('support_id',$_GET['support_id']);
			}
			
			if($_GET['sort_starred']){
				if($_GET['sort_starred']==1){						
					 $this->db->where('mark_important',1);
				}else{
					$this->db->where('mark_important',0);
				}
			}

			if($_GET['order']){
				if($_GET['order']==1){						
					 $this->db->order_by('support_id','ASC');
				}else{
					 $this->db->order_by('support_id','DESC');
				}
			}
			if(isset($_GET['userrole'])){
				    $this->db->like('support.user_role', $_GET['userrole']);
					//$this->db->where('user_role',$_GET['userrole']);
				
			}
		}
        $this->db->where('parent_id','0');
		$this->db->where('mark_complete',0);
		$this->db->DISTINCT('support_id');
		$this->db->from('support');
		if($offset>=0 && $per_page>0) {
			$this->db->limit($per_page,$offset);
			$this->db->order_by('support_id','desc');
			$query = $this->db->get();
			//echo $this->db->last_query();
			//die;
			if($query->num_rows()>0)
			return $query->result();
			else
			return FALSE;
		}else{
			return $this->db->count_all_results();
		}
    }

    public function get_complete_contact_us($offset='', $per_page='')
    {
		if(!empty($_GET)){
			if(!isset($_GET['subject']) || !isset($_GET['support_id']) || !isset($_GET['sort_starred']) || !isset($_GET['order'])){
				redirect('backend/support/user_contactus');
			}				
			
			if($_GET['subject']){
				$this->db->where('reason',$_GET['subject']);
			}

			if($_GET['support_id']){
				$this->db->where('support_id',$_GET['support_id']);
			}
			
			if($_GET['sort_starred']){
				if($_GET['sort_starred']==1){						
					 $this->db->where('mark_important', 1);
				}else{
					$this->db->where('mark_important', 0);
				}
			}

			if($_GET['order']){
				if($_GET['order']==1){						
					 $this->db->order_by('support_id','ASC');
				}else{
					 $this->db->order_by('support_id','DESC');
				}
			}
		}

		$this->db->where('parent_id','0');
		$this->db->where('mark_complete',1);
		$this->db->DISTINCT('support_id');
		$this->db->from('support');
		if($offset>=0 && $per_page>0) {
			$this->db->limit($per_page,$offset);
			$this->db->order_by('support_id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
    }

    public function get_unread_request($message_id){         
		$this->db->where('support_id',$message_id);
		$this->db->or_where('parent_id',$message_id);
		$this->db->where('status',0);
		$query=$this->db->get('support');
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}

	public function update_support_msg($message_id) {
		$data = array('status' => 1);
		$this->db->where('support_id',$message_id);
		$this->db->or_where('parent_id',$message_id);
		$this->db->where('user_role',1);
		$this->db->update('support', $data);

	}

	public function get_unread_msg($message_id='')
	{
		$this->db->where('status',0);
		$this->db->where('user_role',1);
		$this->db->where("(`support_id`=".$message_id." OR `parent_id`=".$message_id.")");
		
		$query=$this->db->get('support');

		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}

	public function get_message_thread($message_id='')
	{
		$this->db->where('support_id',$message_id);
		$this->db->or_where('parent_id',$message_id);
		$query=$this->db->get('support');

		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;

	}

	public function update_msg_thread($message_id='')
	{
		$data = array(
               'status' => 1,
            );

		$this->db->where("`user_role` = 1 AND `status` = 0 AND (`support_id`=".$message_id." OR `parent_id`=".$message_id.")");
		$this->db->update('support', $data); 
	}

	public function checkimg($tablename='',$id=''){
		$query= $this->db->get_where($tablename, array('slider_images_id' => $id));
		return $query->row();
	}


	public function get_statistics($table_name='', $user_role='', $status=''){    	   
		$query1 = $this->db->query('SELECT count(*) as total_rows FROM '.$table_name.' WHERE status='.$status.' AND user_role='.$user_role);
		if($query1){
			return $query1->row();
		}else{
			return false;
		}  
    }
     public function email_templates_model($offset='', $per_page=''){
    	$this->db->from('email_templates');
    	if ($this->input->get('title')) 
    	{
    		$this->db->like('template_name',trim($this->input->get('title')));
    	}

    	$this->db->order_by('id','ASC');
    	if($offset>=0 && $per_page>0)
    	{
    		$this->db->limit($per_page,$offset);
    		$this->db->order_by('id','asc');
    		$query = $this->db->get();
    		if($query->num_rows()>0)
    			return $query->result();
    		else
    			return FALSE;
    	}
    	else
    	{
    		return $this->db->count_all_results();
    	}
    }


}