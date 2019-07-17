<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {	
	public function insert($table_name='',  $data=''){
		$query=$this->db->insert($table_name, $data);
		
		if($query)
		
			return $this->db->insert_id();
		else
			return FALSE;		
	}
	
	public function _checkUserId($id="")
	{
		$this->db->select('user_id'); 
		$this->db->from('users');
		$this->db->where('user_id',$id);
		$query = $this->db->get();
		//print_r($query); 
		if($query->num_rows()>0){
			//echo "Hello"; die();
				return TRUE;
				}
			else{
				//echo "Hello1";die();
				return FALSE;
			}
	}

	public function get_usersInfo($offset='', $per_page='', $search='', $order_status=array()){
		$this->db->select('users.*');
        if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;
         $this->db->where('user_role!=',0);

		if(!empty($_GET['name']) ) {

			$str = $_GET['name'];
			 $diffrenceData = explode(" ", trim($str) );
			//print_r($diffrenceData);
			if(!empty($diffrenceData[0]) && !empty($diffrenceData[1])  ){ 

			 $this->db->like('users.first_name',$diffrenceData[0]);
			 $this->db->or_like('users.last_name',$diffrenceData[1]);
			}
			else if(!empty($diffrenceData[0])){
				$this->db->like('users.first_name',trim($_GET['name']));
				$this->db->or_like('users.last_name',trim($_GET['name']));
			}
		}
		if(!empty($_GET['email'])) {
			$this->db->like('users.email',trim($_GET['email']));
		}
		if(!empty($_GET['order']) && $_GET['order']=='order_by_desc') {
			$this->db->order_by('users.order_by','desc');
		}
		if(!empty($_GET['order']) && $_GET['order']=='order_by_acs') {
			$this->db->order_by('users.order_by','asc');
		}
		if(isset($_GET['status']) && $_GET['status']!='') {
			$this->db->where('users.status',trim($_GET['status']));
		}
		$this->db->from('users');

		if($offset>=0 && $per_page>0){ 
			$this->db->limit($per_page,$offset);
			if(isset($_GET['order']))$this->db->order_by('users.user_id',$_GET['order']);
			      else $this->db->order_by('users.order_by','asc');
			$query = $this->db->get();
			
			
			if($query->num_rows()>0){
				 return $query->result();
				 //$this->db->last_query(); die();
				}
			else{
				return FALSE;
			}
		}else{
			return $this->db->count_all_results();
		}
	}


	public function get_recent_users()
	{
		$this->db->select("*");
		$this->db->from("users");
		$this->db->limit(5);
		$this->db->order_by('user_id',"DESC");
		if($query = $this->db->get()):
			return $result = $query->result();
		endif;
	}
	

	public function get_result_using_findInSet($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit='',$findInSet = array(),$groupBy=''){
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
		if(!empty($findInSet)):
			$where = "FIND_IN_SET('".$findInSet[0]."', ".$findInSet[1].")";  
			$this->db->where($where); 
		endif;
		if(!empty($groupBy)):
			$this->db->group_by($groupBy);
		endif;
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}
	public function get_result_pagination($table_name='', $id_array='',$columns=array(),$order_by=array(),$join=array(),$offset='',$per_page='',$search=''){
		// print_r($id_array);
		// die;
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
		if(!empty($join)):		
			foreach ($join as $value){
				$this->db->join($value['table'],$value['condition'],$value['type']);
			}
		endif;	
		if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;	
		$this->db->from($table_name);
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
	public function get_result($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit='',$custom='',$search=array()){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif;
		if(!empty($order_by)):	
			if(sizeof($order_by)==1)
					$this->db->order_by($order_by[0]);
			else	
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
		if(!empty($custom)):	
			$this->db->where($custom);
		endif;
		if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
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
		//echo $this->db->last_query();

		if($query->num_rows()>0)
			return $query->row();
		else
			return 0;
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


	public function getCatgoryNames($cats=''){

		$this->db->select('cat.category_name');
		$this->db->where_in('cat.category_id',$cats);
		$this->db->from('category as cat');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$reg = $query->result_array();
			$resultdata = $this->implode_all(',', $reg);
			return $resultdata;
		}else{
			return FALSE;
		}
	}

	function implode_all($glue, $arr){            
	    for ($i=0; $i<count($arr); $i++) {
	        if (@is_array($arr[$i])) 
	            $arr[$i] = $this->implode_all ($glue, $arr[$i]);
	    }            
	    return implode($glue, $arr);
	}

	public function users($role='',$offset='', $per_page=''){
	
		$this->db->select('u.*');
		$this->db->from('users as u');
		if(!empty($_GET)){
			if(!isset($_GET['user_id']) || !isset($_GET['name']) || !isset($_GET['email']) || !isset($_GET['contact']) || !isset($_GET['order'])){
			 		redirect('user');
			}
			if($_GET['user_id']){
			 $this->db->where('u.id', $this->input->get('user_id'));	
			}
			if($_GET['name']){			              
			     $this->db->like('u.user_name',trim($this->input->get('name')),'both');	
			}
		
			if($_GET['email']){
			 $this->db->like('u.email', trim($this->input->get('email')));	
			}

			if($_GET['contact']){
			 $this->db->where('u.mobile', trim($this->input->get('contact')));	
			}
			if($_GET['order']){
			if($this->input->get('order')==2 || $this->input->get('order')==3){
			$order = 'ASC';	
			   }else{
			   	$order = 'DESC';
			   }
			   if($this->input->get('order')==1 || $this->input->get('order')==2){
					$column_name = 'u.id';	
			   }else{
					$column_name = 'u.name';
			   }
			  	 $this->db->order_by($column_name,$order);
			}
		}
		$this->db->where('u.user_role',$role);
		if($offset>=0 && $per_page>0){

			$this->db->limit($per_page,$offset);
			$this->db->order_by('u.id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0)
			return $query->result();
			else
			return FALSE;
		}else{
		
			return $this->db->count_all_results();
		}
	}

	public function password_check($data=''){  
		$query = $this->db->get_where('users',$data);
 		if($query->num_rows()>0)
			return TRUE;
		else{
			//$this->form_validation->set_message('password_check', 'The %s field can not match');
			return FALSE;
		}
	}

	public function get_message_thread($message_id = '', $user_id = '') {
        $this->db->where('user_id', $user_id);
        $this->db->where('support_id', $message_id);
        $this->db->or_where('parent_id', $message_id);
        $this->db->order_by('support_id', 'asc');
        $query = $this->db->get('support');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;
    }

    public function get_unread_msg($message_id = '', $user_id = '') {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 0);
        $this->db->where('user_role', 2);
        $this->db->where("(`support_id`=" . $message_id . " OR `parent_id`=" . $message_id . ")");

        $query = $this->db->get('support');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;
    }
	

    public function get_message_user($message_id = '') {
        $this->db->where('support_id', $message_id);
        $this->db->or_where('parent_id', $message_id);
        $query = $this->db->get('support');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;
    }

	public function email_templates($offset='', $per_page='', $search){

		if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

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

	public function getUsersInfo($userRole='', $offset='',$per_page='',$search=''){
		$this->db->select('us.*');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		$this->db->from('users as us');
		$this->db->order_by("us.user_id","desc");
		$this->db->where("us.user_role", $userRole);

		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}


	public function numbertodash($number='')
    {
       $hash='';
       for ($i=0; $i < $number; $i++)
       {
           $hash=$hash."&ensp;&ensp;";
       }
       return $hash;
    }



	public function getAccessToken($user_id='')
	{
		if(!empty($user_id)){
			$resultUser = $this->get_row('users',array('user_id'=>$user_id),array('skipped','confirmation_code'));
			if(!empty($resultUser) && $resultUser->confirmation_code=='verified'){
				if(!empty($resultUser->skipped) && $resultUser->skipped!='null' && $resultUser->skipped!=null){
					$skipped = json_decode($resultUser->skipped);
					if($skipped->status==1){
						return TRUE;
					}else{
						return FALSE;
					}
				}else{
					return FALSE;
				}	
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function count_rows($tablename='',$where='',$fields='',$orwhere='')
	    {
	        $this->db->select($fields);
	        if(!empty($where))
	        {
	        	 $this->db->where($where); 
	        }
	        if(!empty($orwhere)){
	        	$this->db->group_start();
	            $this->db->or_where($orwhere); 
	            $this->db->group_end();
	        } 
	        $query = $this->db->get($tablename);
	        return $query->num_rows();
	}


	function change_all_status($table_name,$col_name,$ids,$status){
		$data=array('approved_by_admin'=>$status);
		$this->db->where_in($col_name,$ids);
		if($status==2){
			$this->db->delete($table_name);
		}
		else{
			$this->db->update($table_name,$data);
		}
		$default_arr=array('status'=>TRUE);
	}

	function change_publish_status($table_name,$col_name,$ids,$status){
		$data=array('status'=>$status);
		$this->db->where_in($col_name,$ids);
			return $this->db->update($table_name,$data);
		$default_arr=array('status'=>TRUE);
	}

	function influencer_user(){
		$this->db->select('user_id');
		$influencer_user = $this->db->get("fh_influencer_info");
		return $influencer_user->result();
		//$influencer_user;
	}

	function change_user_status($table_name,$col_name,$ids,$status){
		
		$data=array('status'=>$status);
		$this->db->where_in($col_name,$ids);
		if($status==2){
			$this->db->delete('users');
		}
		else{

		$this->db->update($table_name,$data);
		}
		$default_arr=array('status'=>TRUE);
	}
	
	function change_notification_status($table_name,$col_name,$ids,$status){
		
		$data=array('status'=>$status);
		$this->db->where_in($col_name,$ids);
		if($status==2){
			$this->db->delete('contactus_notification');
		}
		else{

		$this->db->update($table_name,$data);
		}
		$default_arr=array('status'=>TRUE);
	}

	public function get_result_count($table_name='', $id_array='',$field='*'){
		$this->db->select($field);
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;	
		$query=$this->db->get($table_name);
		return $query->num_rows();
	}
	public function get_influence_count()
	{
		$this->db->select("user_id");
		$query=$this->db->get('fh_influencer_info');
		return $query->num_rows();
	}
	public function get_total_count()
	{
		$this->db->select('user_id');
		$query=$this->db->get('users');
		return $query->num_rows();
	}

	public function get_email($lang,$id){
		if($lang == 'french'){
			$this->db->select('id,template_name,template_subject_french as template_subject,template_body_french as template_body,template_subject_admin,template_body_admin,template_created,template_updated');
		}else{
			$this->db->select('id,template_name,template_subject,template_body,template_subject_admin,template_body_admin,template_created,template_updated');
		}
		$this->db->where('id',$id);
		
		$query=$this->db->get('email_templates');
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}
	// autosuugetion model search for user  ## Prem ##
	public function autosuggetion_user($table_name,$username) { 
		if(!empty($username)) {
		$this->db->select('first_name,last_name');       
        $this->db->order_by('first_name', 'asc');
        // $this->db->like("first_name", $username);
        $this->db->or_like(array('first_name' => $username, 'last_name' => $username));
        $this->db->from('users');
        $this->db->join($table_name,"$table_name.user_id = users.user_id");
        $this->db->group_by('users.first_name');
        $this->db->limit(10);
        return $this->db->get()->result_array();
       }
    }
}
