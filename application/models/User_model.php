<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
	public function insert($table_name='',  $data=''){
		$query=$this->db->insert($table_name, $data);
		if($query)
			return $this->db->insert_id();
			
		else
			return FALSE;		
	}
	public function get_result($table_name='', $id_array='',$columns=array()){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif; 
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;		
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}
	public function get_result_order_by($table_name='', $id_array='',$columns=array()){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif; 
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;	
		$this->db->order_by("order_by", "asc");	
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}
	public function get_row($table_name='', $id_array='',$columns=array()){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif; 
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}
	public function update($table_name='', $data='', $id_array=''){
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


	// all user login
	public function login($email,$password){	

		$data  = array('email'=>$email);	
		$this->db->where($data);
	    $query_get=$this->db->where($data)->from('users')->get(); 
		$count = $query_get->num_rows();
		$res   = $query_get->row_array();
		$salt  = $res['salt'];
		if($count==1){

			

			 $query = "SELECT * FROM `users` WHERE `email` ='".$email."' AND `password` = '".sha1($salt.sha1($salt.sha1($password)))."' ";
			
			$sql           = $this->db->query($query);
			$check_count   = $sql->num_rows();
			$result        = $sql->row();

			if($check_count == 1)
			{
				//p('fdsFD'); die;
				if($result->status==1){

					$user_data = array(
						'id' 			=> $sql->row()->user_id,
						'user_role' 	=> $sql->row()->user_role,
						'first_name' 	=> $sql->row()->first_name,
						'last_name'		=> $sql->row()->last_name,
						'email'			=> $sql->row()->email,
						'last_ip' 		=> $sql->row()->last_ip,
						'last_login' 	=> $sql->row()->last_login,
						'user_name' 	=> $sql->row()->first_name.' '.$sql->row()->last_name,
						//'user_name' 	=> $sql->row()->user_name,
						//'mobile' 		=> $sql->row()->mobile,
						//'country_code' 	=> $sql->row()->country_code,
						'logged_in' 	=> TRUE
					);

					$this->session->unset_userdata('user_info');
					$this->session->unset_userdata('superadmin_info');
					if($user_data['user_role']==0){
						$this->session->set_userdata('superadmin_info',$user_data);
					}else if($user_data['user_role']==1){
					$this->session->set_userdata('user_info',$user_data);	
					}

						

						/*---Store cart data in cart session--*/
						//$this->setCartData($user_data['id']);
						//$user_name = ucfirst(user_name());
						$user_name = ucfirst($user_data['user_name']);
						$this->session->set_flashdata('msg_success', 'Welcome '.$user_name.', You have logged in successfully');
					

					$this->update('users',array('last_ip' => $this->input->ip_address(),
							'last_login' => date('Y-m-d h:i:s')),array('user_id'=>$sql->row()->user_id));
					return TRUE;

				}else{
					$this->session->set_flashdata('msg_error', 'Your account is not activated yet. Please contact to administrator');
					return FALSE;
				}
			
			}else{
				$this->session->set_flashdata('msg_error', 'Incorrect Email Or Password');
				return FALSE;
			}	
		}else{
			$this->session->set_flashdata('msg_error', 'Incorrect Email Or Password');
			return FALSE;
		}
	}
		
	



	// all user login
	public function proxy_login($data=array()){	

		$query_get = $this->db->get_where('users',$data);
		$count = $query_get->num_rows();
		$res = $query_get->row_array();

		$status = $res['status'];
		$user_role = $res['user_role'];

		if($count==1){
			if($status==1){
				$user_data = array(
					'id' 				=> $res['user_id'],
					'user_role' 		=> $res['user_role'],
					'first_name' 		=> $res['first_name'],
					'last_name'			=> $res['last_name'],
					'email'				=> $res['email'],
					'last_ip' 			=> $res['last_ip'],
					'last_login' 		=> $res['last_login'],
					'user_name' 		=> $res['user_name'],
					'business_name' 	=> $res['business_name'],
					'confirmation_code' => $res['confirmation_code'],
					'mobile' 			=> $res['mobile'],
					'country_code' 		=> $res['country_code'],
					'logged_in' 		=> TRUE
				);
				return $user_data;
			}else{
				return FALSE;
			}	
		}else{
			return FALSE;
		}
	}

 public function blogs_list($offset='', $per_page='', $search='', $order_status=array()){

		$this->db->select('fba.*,fh_blog_article_type.type');
        if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;
		if(!empty($_GET)):
		if(!empty($_GET['user_id'])){
        	$this->db->where('fba.user_id',trim($_GET['user_id']));
	      }
	    if(!empty(isset($_GET['approved_by_admin'])  && $_GET['approved_by_admin']!='')){
        	$this->db->where('fba.approved_by_admin',trim($_GET['approved_by_admin']));
	      }
       //zero is treated as empty by ci
		if(isset($_GET['status']) && $_GET['status']!=''){
        	$this->db->where('fba.status',trim($_GET['status']));
	      }
        if(!empty($_GET['url'])){
        	$this->db->like('fba.url',trim($_GET['url']));
	      }

	    if(!empty($_GET['blog_title'])){
        	$this->db->like('fba.blog_title',trim($_GET['blog_title']));
	      }
	    endif;

		  
		$this->db->from('fh_blog_articles as fba');
		$this->db->join('fh_blog_article_type', 'fba.blog_article_type_id = fh_blog_article_type.blog_article_id');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			if(isset($_GET['order']))$this->db->order_by('blog_id',$_GET['order']);
			      else $this->db->order_by('blog_id','desc');
			$query = $this->db->get();
			
			if($query->num_rows()>0){
				return $query->result();
				}
			else{
				return FALSE;
			}
		}else{
			return $this->db->count_all_results();
		}
	}

	 public function all_user_blogs_list($offset='', $per_page='', $search='', $order_status=array()){

		$this->db->select('fba.blog_title,fba.blog_id,fba.order_by,fba.url,fba.created,fba.updated,fba.approved_by_admin,fba.cover_photo_thumbnail,fh_blog_article_type.type,users.user_id,users.first_name,users.last_name');
        if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;
		if(!empty($_GET['username']) ) {

			$str = $_GET['username'];
			 $diffrenceData = explode(" ", trim($str) );
			//print_r($diffrenceData);
			if(!empty($diffrenceData[0]) && !empty($diffrenceData[1])  ){ 

			 $this->db->like('users.first_name',$diffrenceData[0]);
			 $this->db->or_like('users.last_name',$diffrenceData[1]);
			}
			else if(!empty($diffrenceData[0])){
				$this->db->like('users.first_name',trim($_GET['username']));
				$this->db->or_like('users.last_name',trim($_GET['username']));
			}
		}
		if(!empty($_GET['user_id'])){

        	$this->db->where('fba.user_id',trim($_GET['user_id']));
	      }
       //zero is treated as empty by ci
		if(isset($_GET['status']) && $_GET['status']!=''){
        	$this->db->where('fba.status',trim($_GET['status']));
	      }
	    if(!empty($_GET['blog_title'])){
        	$this->db->like('fba.blog_title',trim($_GET['blog_title']));
	      } 
	     if(isset($_GET['approved_by_admin']) && $_GET['approved_by_admin']!=''){
        	$this->db->where('fba.approved_by_admin',trim($_GET['approved_by_admin']));
	      }
	      if(isset($_GET['article_type']) && $_GET['article_type']!=''){
        	$this->db->where('fba.blog_article_type_id',trim($_GET['article_type']));
	      }
	      if(!empty($_GET['order']) && $_GET['order']=='order_by_desc') {
	      	$this->db->order_by('fba.order_by','desc');
	      }
	      if(!empty($_GET['order']) && $_GET['order']=='order_by_acs') {
	      	$this->db->order_by('fba.order_by','asc');
	      }
		  
		 $this->db->from('fh_blog_articles as fba');
		 $this->db->join('fh_blog_article_type', 'fba.blog_article_type_id = fh_blog_article_type.blog_article_id');
		 $this->db->join ( 'users', 'users.user_id = fba.user_id');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			if(isset($_GET['order']))$this->db->order_by('fba.blog_id',$_GET['order']);
			      else $this->db->order_by('fba.order_by','acs');
			$query = $this->db->get();
			//echo $this->db->last_query(); die();
			
			if($query->num_rows()>0){
				return $query->result();
				}
			else{
				return FALSE;
			}
		}else{
			return $this->db->count_all_results();
		}
	}
	public function blog_type(){
		$this->db->select();
		$blogType = $this->db->get("fh_blog_article_type");
		return $blogType->result();

	}


    public function get_users($username) { 
		if(!empty($username)) {
		$this->db->select('first_name,last_name');       
        $this->db->order_by('first_name', 'asc');
        // $this->db->like("first_name", $username);
        $this->db->or_like(array('first_name' => $username, 'last_name' => $username));
        $this->db->from('users');
        $this->db->limit(10);
        return $this->db->get()->result_array();
       }
    }

	public function all_users_list()
	{
		 $users= $this->db->get('users');
        return $users->result_array();

	}
	public function one_user()
	{		$user_id = $_GET['user_id'];
		 $users= $this->db->get_where('users',array('user_id'=>$user_id));
        return $users->result_array();

	}
	
 
	

}
//user_model end