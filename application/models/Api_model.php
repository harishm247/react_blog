<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api_model extends CI_Model {	
	public function insert($table_name='',  $data=''){
		$query=$this->db->insert($table_name, $data);
		
		if($query)
			return $this->db->insert_id();
		else
			return FALSE;		
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
		//p($order_by);die;
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
		return $query->result();
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

	public function login($email,$password){	
		$data  = array('email'=>$email,'status !=' =>2,'user_role' =>1);	
		$query_get = $this->db->get_where('users',$data);
		$count = $query_get->num_rows();
		$sql    = $query_get->row();
		
		if($count==1){
			$salt  = $sql->salt;
			$password=sha1($salt.sha1($salt.sha1($password)));
		
			//if (password_verify($password, $sql->password))
			if ($password == $sql->password)
			{ 
				if($sql->status!=2){
					if($sql->status==1){

						$user_data = array(
							'id' 			=> $sql->user_id,
							'first_name' 	=> $sql->first_name,
							'last_name'		=> $sql->last_name,
							'email'			=> $sql->email
						);

					$this->update('users',array('last_ip' => $this->input->ip_address(),
								'last_login' => date('Y-m-d h:i:s')),array('user_id'=>$sql->user_id));
					$response_array["user"] = $user_data;
					$response_array["status"] = TRUE;
					return $response_array;
						return TRUE;

					}else{
					$response_array["error_message"] = "Your account is not activated yet. Please contact to administrator";
					$response_array["status"] = FALSE;
					return $response_array;
					}
				}else{
				$response_array["error_message"] = "Your account is delete. Please contact to administrator";
				$response_array["status"] = FALSE;
				return $response_array;
				}	
			}else{
				$response_array["error_message"] = "Incorrect Password";
				$response_array["status"] = FALSE;
				return $response_array;
			}	
		}else{
			$response_array["error_message"] = "Email is not registered with us";
			$response_array["status"] = FALSE;
			return $response_array;
		}
	}


	public function blog($offset= 0, $per_page=PER_PAGE, $user=null, $searchString = null, $isCountNeeded = false,$category=null){
		$val="(case when (b.cover_photo IS NULL) then '".base_url()."assets/backend/image/blog-defult.png' else (CONCAT('".base_url()."',b.cover_photo))  end) as 	cover_photo";
		$va_to="(case when (b.cover_photo_thumbnail IS NULL) then '".base_url()."assets/backend/image/blog-defult.png' else (CONCAT('".base_url()."',b.cover_photo_thumbnail))  end) as cover_photo_thumbnail";
		if(!is_null($searchString)){
			$this->db->group_start();
			$this->db->like('b.blog_title',$searchString);	
			$this->db->or_where('bc.blog_article_type_id',$searchString);	
			$this->db->or_where('FIND_IN_SET("'.$searchString.'",b.blog_tag)>',0);
			$this->db->group_end();
		}
		if(!is_null($category)){
			
			$this->db->group_start();
			$this->db->where('b.blog_article_type_id',$category);	
			$this->db->group_end();
		}
		$this->db->order_by('b.blog_id','desc');
		if(!is_null($user)){
			//$this->db->where('b.created_by',trim($user));	
			$this->db->where('b.user_id',trim($user));
			//$this->db->where('b.status !=',2);	
		}
		$this->db->select('b.url,b.cover_photo_thumbnail,b.cover_photo,b.blog_id,b.approved_by_admin,b.order_by,b.user_id,b.blog_article_type_id,bc.type,b.blog_title,b.slug,DATE_FORMAT(b.date, "%m/%d/%Y") as date,DATE_FORMAT(b.created, "%m/%d/%Y %H:%i") as created,DATE_FORMAT(b.updated, "%m/%d/%Y %H:%i") as updated');
		$this->db->from('fh_blog_articles b');
		$this->db->join('fh_blog_article_type as bc','b.blog_article_type_id=bc.blog_article_id');
	//	$this->db->join('user_master as um','um.user_id=b.created_by');
		if($isCountNeeded === false){
			$this->db->order_by('b.order_by','ASC');
      		$this->db->limit($per_page,$offset);
      		$query = $this->db->get();
     		return $query->result();
   		}else{
    		return $this->db->count_all_results();
    	}
	}

	public function blogs_detail($blog_id,$slug){

		$val="(case when (b.cover_photo_thumbnail = NULL || b.cover_photo_thumbnail ='') then b.cover_photo_thumbnail else (CONCAT('".base_url()."',b.cover_photo))  end) as cover_photo_thumbnail";
		$this->db->select('b.blog_id,b.blog_article_type_id,b.blog_tag,b.blog_title,b.date,b.url,b.type_other,b.slug,DATE_FORMAT(updated, "%m/%d/%Y %H:%i:%S") as updated, '.$val);
		$this->db->from('fh_blog_articles b');
	//	$this->db->join('blog_category as bc','b.blog_category=bc.id','left');
		if(!is_null($blog_id)){
				$this->db->where('b.blog_id',trim($blog_id));	
		}elseif(!is_null($slug)){
			$this->db->where('b.slug',trim($slug));		
		}else{
			return FALSE;
		}
		$query = $this->db->get();
		return $query->row();
	}

	
	function create_unique_slug($string,$table,$field='slug',$key=NULL,$value=NULL){
   $checLang = $this->clean($string); 
   $slug = url_title($string); 
   if ($checLang!='') {
       $slug = strtolower($slug);
   }
   $i = 0;
   $params = array ();
   $params[$field] = $slug;
   
   if($key)$params["$key !="] = $value;
   
   while ($this->db->where($params)->get($table)->num_rows())
   { 
   if (!preg_match ('/-{1}[0-9]+$/', $slug ))
   $slug .= '-' . ++$i;
   else
   $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
   
   $params [$field] = $slug;
   } 
   return $slug; 
  } 
  public function clean($string) {
   return preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars.
  }
 

	public function get_count($table_name='', $id_array='',$columns=''){

		$this->db->select(count($columns));

		foreach ($id_array as $key => $value){
			$this->db->where($key, $value);
		}

		$query=$this->db->get($table_name);

		if($query->num_rows()>0)
			return $query->row();
		else
			return 0;

	}

	function create_invoice_id($table = 'payment', $field = 'invoice_id')
	{
			$invoiceId = 'PB-'.date('Y').'-'.str_pad(1, 4, 0, STR_PAD_LEFT).'-'.strtoupper($this->randomString(4));
			$params[$field] = $invoiceId;
			$i = 1;
			while ($this->db->where($params)->get($table)->num_rows())
		  {
		  	$invoiceId = 'PB-'.date('Y').'-'.str_pad(++$i, 4, 0, STR_PAD_LEFT).'-'.strtoupper($this->randomString(4));
		    $params [$field] = $invoiceId;
		  }
		  return $invoiceId;
	}
	public function randomString($length = 5)
	{
		$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$shuffledStr = str_shuffle($str);
		return substr($shuffledStr, 0, $length);
	}


	function create_tracking_id($table = 'package_master', $field = 'tracking_id')
	{
			$tracking_id = 'SENDI'.str_pad(1, 4, 0, STR_PAD_LEFT).strtoupper($this->randomStringTracking(4));
			$params[$field] = $tracking_id;
			$i = 1;
			while ($this->db->where($params)->get($table)->num_rows())
		  {
		  	$tracking_id = 'SENDI'.str_pad(++$i, 4, 0, STR_PAD_LEFT).strtoupper($this->randomStringTracking(4));
		    $params [$field] = $tracking_id;
		  }
		  return $tracking_id;
	}

	public function randomStringTracking($length = 5)
	{
		$str = '123456789';
		$shuffledStr = str_shuffle($str);
		return substr($shuffledStr, 0, $length);
	}

 	public function user_info($user){
  	$va_to="(case when (profile_thumbnail = NULL) then profile_thumbnail else (CONCAT('".base_url()."',profile_thumbnail))  end) as profile_thumbnail";
  	$this->db->select('um.first_name,um.last_name,um.city,um.country,um.about_me,um.languages_known , um.is_verified,'.$va_to);
  	$this->db->from('user_master um');
		$this->db->where('um.user_id',trim($user));
		$query = $this->db->get();
		return $query->row();
 	}

	// My Test function for creating first method in API
	public function abc($table_name,$user_status='')
	{
		$query = $this->db->select('*')
				 ->get_where($table_name);
		//echo $this->db->last_query();die();
		return $query->result();		 
	}
}


?>
