<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {	
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
		$data  = array('email'=>$email,'status !=' =>2,'user_role' =>'user');	
		$query_get = $this->db->get_where('user_master',$data);
		$count = $query_get->num_rows();
		$sql = $query_get->row();
		if($count==1){
			if (password_verify($password, $sql->password))
			{ 
				if($sql->status!=2){
					if($sql->status==1){

						$user_data = array(
							'id' 			=> $sql->user_id,
							'first_name' 	=> $sql->first_name,
							'last_name'		=> $sql->last_name,
							'email'			=> $sql->email
						);

					$this->update('user_master',array('last_ip' => $this->input->ip_address(),
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
			$response_array["error_message"] = "Incorrect Email";
			$response_array["status"] = FALSE;
			return $response_array;
		}
	}


	public function blog($offset= 0, $per_page=PER_PAGE, $user=null, $searchString = null, $isCountNeeded = false,$category=null){

		$val="(case when (b.featured_image IS NULL) then '".base_url()."assets/backend/image/blog-defult.png' else (CONCAT('".base_url()."',b.featured_image))  end) as featured_image";
		$va_to="(case when (b.featured_thumbnail IS NULL) then '".base_url()."assets/backend/image/blog-defult.png' else (CONCAT('".base_url()."',b.featured_thumbnail))  end) as featured_thumbnail";
		$val_user ="(case when (um.profile_thumbnail_small IS NULL) then '".base_url()."assets/backend/image/blog-defult.png' else (CONCAT('".base_url()."',um.profile_thumbnail_small))  end) as profile_thumbnail_small";

		if(!is_null($searchString)){
			$this->db->group_start();
			
			$this->db->like('b.blog_title',$searchString);	
	
			$this->db->or_where('bc.category_name',$searchString);	
	
			$this->db->or_where('FIND_IN_SET("'.$searchString.'",b.blog_tag)>',0);
			$this->db->group_end();
		}
		if(!is_null($category)){
			
			$this->db->group_start();
			$this->db->where('b.blog_category',$category);	
			$this->db->group_end();
		}
		$this->db->order_by('b.blog_id','desc');
		if(!is_null($user)){
			$this->db->where('b.created_by',trim($user));	
			$this->db->where('b.status !=',2);	
		}else{
			$this->db->where('b.status',1);	
		}
		
		$this->db->select('b.blog_id,b.name,b.email,b.blog_title,b.blog_small_content,b.blog_tag,'.$val.','.$va_to.','.$val_user.',bc.category_name,b.created_at,b.status,b.slug,b.blog_category as  category_id,');
		$this->db->from('blog b');
		$this->db->join('blog_category as bc','b.blog_category=bc.id');
		$this->db->join('user_master as um','um.user_id=b.created_by');
		if($isCountNeeded === false){
      $this->db->limit($per_page,$offset);
      $query = $this->db->get();
     	return $query->result();
   	}else{
      return $this->db->count_all_results();
    }

	}

	public function blogs_detail($blog_id,$slug){

		$val="(case when (b.featured_image = NULL) then b.featured_image else (CONCAT('".base_url()."',b.featured_image))  end) as featured_image";
		$this->db->select('b.blog_id, b.name, b.email,b.blog_title,b.blog_content, b.blog_small_content,b.blog_tag,'.$val.', bc.category_name,bc.id as category_id,b.status,b.approved_at,b.slug');
		$this->db->from('blog b');
		$this->db->join('blog_category as bc','b.blog_category=bc.id','left');
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

	public function package($offset= 0, $per_page=PER_PAGE, $user=null, $searchString = null, $isCountNeeded = false){

		if(!is_null($searchString)){
			$this->db->group_start();
			$this->db->like('p.departure_location',$searchString);	
			$this->db->or_like('p.destination_location',$searchString);	
			$this->db->or_like('um.first_name',$searchString);
			$this->db->group_end();
		}
		$this->db->order_by('p.package_id','desc');
		$this->db->select('p.package_id,p.delivery_urgency,p.departure_location,p.destination_location,p.delivery_period,p.drop_off_location,p.pickup_location,p.types_of_package,p.created_at,pm.package_description,pm.recipient_information,pm.cost,pm.package_information,um.first_name,um.last_name,p.number_of_package,p.is_confirmed,p.status,p.tour_id');
		$this->db->from('package_master p');
		$this->db->join('package_meta as pm','p.package_id=pm.package_id','left');
		$this->db->join('user_master as um','um.user_id=p.created_by');
		$this->db->where('p.created_by',trim($user));
		$this->db->where_not_in('p.status',[0,2]);	
		if($isCountNeeded === false){
      $this->db->limit($per_page,$offset);
      $query = $this->db->get();
     	return $query->result();
   	}else{
      return $this->db->count_all_results();
    }

	}

	public function package_details($package){
		$this->db->select('p.package_id,p.delivery_urgency,p.departure_location,p.destination_location,p.delivery_period,p.drop_off_location,p.pickup_location,p.types_of_package,p.created_at,pm.package_description,pm.recipient_information,pm.cost,pm.package_information,um.first_name,um.last_name,p.number_of_package,p.destination_latitude,p.destination_longitude,p.departure_latitude,p.departure_longitude,p.parcel_image,p.is_confirmed');
		$this->db->from('package_master p');
		$this->db->join('package_meta as pm','p.package_id=pm.package_id','left');
		$this->db->join('user_master as um','um.user_id=p.created_by');
		$this->db->where('p.package_id',trim($package));
		$this->db->where_not_in('p.status',[0,2]);	
		$query = $this->db->get();
		return $query->row();
  }

  public function package_details_info($package){
  	$this->db->select('p.departure_location,p.destination_location');
  	$this->db->from('package_master p');
		$this->db->join('package_meta as pm','p.package_id=pm.package_id','left');
		$this->db->join('user_master as um','um.user_id=p.created_by');
		$this->db->where('p.package_id',trim($package));
		$query = $this->db->get();
		return $query->row();
  }

  public function tour($offset= 0, $per_page=PER_PAGE, $user=null, $searchString = null, $isCountNeeded = false){
  
		if(!is_null($searchString)){
			$this->db->group_start();
			$this->db->like('t.departure_city',$searchString);	
			$this->db->or_like('t.destination_city',$searchString);	
			$this->db->or_like('um.first_name',$searchString);
			$this->db->group_end();
		}
		$this->db->order_by('t.tour_id','desc');
		$this->db->select('t.tour_id,t.departure_city,t.departure_date,t.destination_city,t.arrival_datetime,t.destination_citizenship,t.travel_by,t.travelling_details,t.created_at,t.stay_time,t.additional_information,um.first_name,um.last_name,t.status');
		$this->db->from('user_tours t');
		$this->db->join('user_master as um','um.user_id=t.created_by');
		$this->db->where('t.created_by',trim($user));
		$this->db->where_not_in('t.status',[0,2]);
		if($isCountNeeded === false){
      $this->db->limit($per_page,$offset);
      $query = $this->db->get();
     	return $query->result();
   	}else{
      return $this->db->count_all_results();
    }
	}

	public function tour_details($tour_id){
	
		$this->db->order_by('t.tour_id','desc');
		$this->db->select('t.tour_id,t.departure_city,t.departure_date,t.destination_city,t.arrival_datetime,t.destination_citizenship,t.travel_by,t.travelling_details,t.created_at,t.stay_time,t.additional_information,um.first_name,um.last_name,t.status,t.destination_latitude,t.destination_longitude,t.departure_latitude,t.departure_longitude,is_international,is_flexible,international_status');
		$this->db->from('user_tours t');
		$this->db->join('user_master as um','um.user_id=t.created_by');
		$this->db->where('t.tour_id',trim($tour_id));
		$query = $this->db->get();
		return $query->row();
	}

	public function package_search($offset= 0, $per_page=PER_PAGE, $user=null, $lat, $lon, $latD, $lonD, $isCountNeeded = false){
		$this->db->select('p.package_id,p.delivery_urgency,p.departure_location,p.destination_location,p.drop_off_location,p.pickup_location,p.types_of_package,p.created_at,um.first_name,um.last_name,p.created_by as receiver_id,p.delivery_period,p.number_of_package, ( 6371 * acos( cos(radians('.$lat.')) * cos( radians(`destination_latitude`)) *
		  	cos( radians( p.destination_longitude ) - radians('.$lon.')) + sin( radians('.$lat.')) * sin( radians( p.destination_latitude ))
		    )) AS destination_distance, ( 6371 * acos( cos(radians('.$latD.')) * cos( radians(p.departure_latitude)) *
		  	cos( radians( p.departure_longitude ) - radians('.$lonD.')) + sin( radians('.$latD.')) * sin( radians( p.departure_latitude ))
		    )) AS departure_distance');
	
		$this->db->from('package_master p');
		$this->db->join('user_master as um','um.user_id=p.created_by');
		$this->db->where('p.status',1);
		$this->db->having('destination_distance <', 150);
		$this->db->having('departure_distance <', 150);
		$this->db->order_by('destination_distance','asc');	
		if($isCountNeeded === false){
      $this->db->limit($per_page,$offset);
      $query = $this->db->get();
     	return $query->result();
   	}else{
   		$query = $this->db->get();
      return count($query->result());
    }

	}

	public function tour_search($offset= 0, $per_page=PER_PAGE, $user=null, $lat, $lon, $latD, $lonD, $isCountNeeded = false){
		$this->db->select('t.tour_id,t.departure_city,t.departure_date,t.destination_city,t.arrival_datetime,t.destination_citizenship,t.travel_by,t.travelling_details,t.created_at,t.stay_time,t.additional_information,um.first_name,um.last_name,t.status,t.created_by as receiver_id, ( 6371 * acos( cos(radians('.$lat.')) * cos( radians(t.destination_latitude)) *
		  	cos( radians(t.destination_longitude) - radians('.$lon.')) + sin( radians('.$lat.')) * sin( radians( t.destination_latitude )) )) AS destination_distance, ( 6371 * acos( cos(radians('.$latD.')) * cos( radians(t.departure_latitude)) *
		  	cos( radians(t.departure_longitude) - radians('.$lonD.')) + sin( radians('.$latD.')) * sin( radians( t.departure_latitude)) )) AS departure_distance');
		
		$this->db->from('user_tours t');
		$this->db->having('destination_distance <', 150);
		$this->db->having('departure_distance <', 150);
		$this->db->join('user_master as um','um.user_id=t.created_by');
		$this->db->where('t.status',1);
		$this->db->order_by('destination_distance','asc');	
		if($isCountNeeded === false){
      $this->db->limit($per_page,$offset);
      $query = $this->db->get();
     	return $query->result();
   	}else{
   		$query = $this->db->get();
      return count($query->result());
    }
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
  /**************************
  Created By: Sonu Bamniya
  Created At: 06 Oct, 2018 05:00 PM
  **************************/
	public function get_converstation_list($user_id, $type){
  	$package_messages = array();
  	$tour_messages = array();
  	if (!in_array($type, [0, 1, 2])) {
  		return [];
  	}
  	$val="(case when (mme.sender_id = ".$user_id.") then true else (false) end) as is_sender";
		
		if ($type == 2 || $type == 1) {
			$this->db->select('max(me.message_meta_id) as message_meta_id, mm.*, pm.departure_location as location_from, pm.destination_location as location_to, 1 as type,(select message from message_meta where message_meta_id = max(me.message_meta_id)) as message,(select '.$val.' from message_meta as mme where message_meta_id = max(me.message_meta_id)) as is_sender,mm.sender_read_count as read_count,um.first_name as sender_first_name, um.last_name as sender_last_name, um2.first_name as receiver_first_name, um2.last_name as receiver_last_name,');
			$this->db->from('package_master pm');
			$this->db->join('message_master mm', 'mm.package_id = pm.package_id', 'inner');
			$this->db->join('message_meta me', 'mm.message_id = me.message_id', 'inner');
			$this->db->join('user_master as um2','um2.user_id =mm.receiver_id');
			$this->db->join('user_master as um','um.user_id =mm.sender_id');
			$this->db->where('pm.created_by', $user_id);
			$this->db->where('mm.is_accepted !=',2);
			$this->db->group_by('me.message_id');
			$this->db->group_by('pm.package_id');
			$query = $this->db->get();
			$package_messages = $query->result();
		}

		if ($type == 2 || $type == 0) {
			$this->db->select('max(me.message_meta_id) as message_meta_id,mm.*, ut.departure_city as location_from, ut.destination_city as location_to, 0 as type,(select message from message_meta where message_meta_id = max(me.message_meta_id)) as message,(select '.$val.' from message_meta as mme where message_meta_id = max(me.message_meta_id)) as is_sender,mm.sender_read_count as read_count,um.first_name as sender_first_name, um.last_name as sender_last_name, um2.first_name as receiver_first_name, um2.last_name as receiver_last_name,');
			$this->db->from('user_tours ut');
			$this->db->join('message_master mm', 'mm.tour_id = ut.tour_id', 'inner');
			$this->db->join('message_meta me', 'mm.message_id = me.message_id', 'inner');
			$this->db->join('user_master as um2','um2.user_id =mm.receiver_id');
			$this->db->join('user_master as um','um.user_id =mm.sender_id');
			$this->db->where('mm.is_accepted !=',2);
			$this->db->where('ut.user_id', $user_id);
			$this->db->group_by('ut.tour_id');
			$this->db->group_by('me.message_id');
			$query = $this->db->get();
			$tour_messages = $query->result();
		}
		$message_array = array_merge($package_messages, $tour_messages);
		usort($message_array, function($a, $b){
		    if     ($a->created_at == $b->created_at) return 0;
		    return ($a->created_at <  $b->created_at) ? 1 : -1;
		});

		return $message_array;
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


	/**************************
	Created By: Sohit JAIN - Chapter247
	Created At: 08-10-2018 11:00 AM
	**************************/



	public function get_support($user_id){
		$val="(case when (s.subject = 1) then '".feedback_subject_status(1)."' when (s.subject = 2) then '".feedback_subject_status(2)."' when (s.subject = 3) then '".feedback_subject_status(3)."' when (s.subject = 4) then '".feedback_subject_status(4)."' else ('')  end) as subject_name";
			$this->db->select('s.support_id, s.ticket_no, s.subject,s.message,s.mark_complete,created,'.$val);
			$this->db->from('support s');
			$this->db->where('s.user_id', $user_id);
			$this->db->where('s.parent_id',0);
			$this->db->order_by('s.support_id','desc');	
			$query = $this->db->get();
			return $query->result();
	} 

	public function get_support_message($support_id,$user_id,$ticket_id){
		$val="(case when (s.user_role = 1) then true when (s.user_role = 2) then false else ('')  end) as is_sender";
			$this->db->select('s.support_id,s.message,s.created,mark_complete,'.$val);
			$this->db->from('support s');
			$this->db->group_start();
			$this->db->where('s.parent_id',$support_id);
			$this->db->or_where('s.parent_id',0);
			$this->db->group_end();
			$this->db->where('s.user_id',$user_id);
			$this->db->where('s.ticket_no',$ticket_id);
			$query = $this->db->get();
			return $query->result();
	}

	public function get_message_master_list($package_id,$tour_id,$type,$user_id){
		$val="(case when (mm.receiver_id = ".$user_id.") then um.first_name when (mm.sender_id = ".$user_id.") then um2.first_name else ('')  end) as first_name";
		$val2="(case when (mm.receiver_id = ".$user_id.") then um.last_name when (mm.sender_id = ".$user_id.") then um2.last_name else ('')  end) as last_name";

		// $val1="(case when (mm.sender_id = ".$user_id.") then true when (mm.receiver_id = ".$user_id.") then false else ('')  end) as is_sender";
		$val1="(case when (mme.sender_id = ".$user_id.") then true else (false) end) as is_sender";
		$list='';
		if($type==0){
			$list='ut.departure_city as location_from, ut.destination_city as location_to';
		}elseif($type == 1){
			$list='pm.departure_location as location_from, pm.destination_location as location_to';
		}

		$this->db->select('max(me.message_meta_id) as message_meta_id, mm.message_id,mm.sender_id,mm.receiver_id,mm.created_at,is_accepted,'.$val.','.$val2.','.$list.', (select message from message_meta where message_meta_id = max(me.message_meta_id)) as message, (select '.$val1.' from message_meta as mme where mme.message_meta_id = max(me.message_meta_id)) as is_sender ,mm.is_confirmed as is_my_confirmed,ut.is_confirmed as confirmed_tour,pm.is_confirmed as confirmed_package,mm.package_id,mm.tour_id,pm.token');
		$this->db->from('message_master mm');
		$this->db->join('user_master as um2','um2.user_id =mm.receiver_id');
		$this->db->join('user_master as um','um.user_id =mm.sender_id');
		$this->db->join('message_meta as me','me.message_id = mm.message_id');
		$this->db->join('user_tours as ut','ut.tour_id =mm.tour_id');
		$this->db->join('package_master as pm','pm.package_id =mm.package_id');
		$this->db->where('mm.is_accepted !=', 2);
		$this->db->group_by('me.message_id');
		$this->db->order_by('me.message_meta_id','ASC');

		if($type==0){
			$this->db->where('mm.tour_id',$tour_id);
			
		}elseif($type == 1){
			$this->db->where('mm.package_id',$package_id);
		
		}
		else{
			return [];
		}
			$this->db->group_start();
			$this->db->where('mm.sender_id',$user_id);
			$this->db->or_where('mm.receiver_id',$user_id);
			$this->db->group_end();
		$query = $this->db->get();
	//	echo $this->db->last_query(); die;
		return $query->result();


	}

	public function message_master_get($package_id,$tour_id,$type,$sender_id,$receiver_id){
		$this->db->select('mm.message_id,mm.sender_id,mm.receiver_id,mm.is_accepted,mm.message_id,receiver_read_count,sender_read_count');
		$this->db->from('message_master mm');
		$this->db->where('mm.package_id',$package_id);
		$this->db->where('mm.tour_id',$tour_id);
		$this->db->group_start();
			$this->db->where('mm.sender_id',$receiver_id);
			$this->db->or_where('mm.receiver_id',$receiver_id);
		$this->db->group_end();
		$this->db->group_start();
			$this->db->where('mm.sender_id',$sender_id);
			$this->db->or_where('mm.receiver_id',$sender_id);
		$this->db->group_end();
		$query = $this->db->get();
		return $query->row();
	}

	

	public function message_list($offset= 0, $per_page=0, $user=null, $message_id = 0){
		$val="(case when (me.sender_id = ".$user.") then true else (false)  end) as is_sender";
		$this->db->select('me.message,me.created,'.$val);
		$this->db->from('message_meta me');
		$this->db->where('me.message_id',$message_id);
		$this->db->order_by('created','desc');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			
			$messages_meta =  $query->result();
		
			usort($messages_meta, function($a, $b){
			    if     ($a->created == $b->created) return 0;
			    return ($a->created <  $b->created) ? -1 : 1;
			});
			return $messages_meta;
		}else{
			return $this->db->count_all_results();
		}
	}

}


?>
