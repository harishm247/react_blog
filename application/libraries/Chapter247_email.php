<?php
/**
*
* Email Library 
*
*/
class Chapter247_email{ 
    private $config;
    private $param; 
    private $data_temp;
    private $param_email;
    private $result;
    function __construct()  {
        
        $CI =& get_instance();
        $CI->load->library(array('email','parser'));
        $CI->load->helper(array('email'));
            // $config['useragent']    = 'CodeIgniter';
            // $config['protocol']     = 'localhost';
            // $config['smtp_host']    = 'ssl://privatemail.com';
            // $config['smtp_user']    = 'Support@cazshop.io'; // Your gmail id
            // $config['smtp_pass']    = '*rBcPkUc9QmqX'; // Your gmail Password
            // $config['smtp_port']    = 25;
            // $config['wordwrap']     = TRUE;    
            // $config['wrapchars']    = 76;
            // $config['mailtype']     = 'html';
            // $config['charset']      = 'iso-8859-1';
            // $config['validate']     = FALSE;
            // $config['priority']     = 3;
            // $config['newline']      = "\r\n";
            // $config['crlf']         = "\r\n";
   
/*      $config = Array(
            'useragent' => 'CodeIgniter',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1',
            'ssl'       => 'true',
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'test.chapter247@gmail.com',
            'smtp_pass' => 'chapter247@',
            'smtp_port' => '587', 
            'wordwrap'  => TRUE,
            'wrapchars' => 76,
            'validate'  => FALSE,
            'priority'  => 3,
            'newline'   => "\r\n",
            'crlf'      => "\r\n"
            // 'protocol' => 'smtp',
            // 'smtp_host' => '',
            // 'smtp_port' => 25,
            // 'smtp_user' => '',
            // 'smtp_pass' => '',
         //   'mailtype'      => 'html',
         //   'charset'       => 'iso-8859-1',
            // 'ssl'          => 'true',
         //   'smtp_crypto'   => 'ssl'
        );*/    
        
        $config = Array(

                          'mailtype'  => 'html', 

                         'charset'   => 'iso-8859-1',

                        // 'ssl'        => 'true
                     );
        $CI->email->initialize($config);
    }
    function send_mail($param=array()){
        $CI =& get_instance();            
      //  echo "<pre>"; print_r($param);die();
        if(isset($param['template']) && !empty($param['template'])):
            
            if(!empty($param['template']['var_name']))
            $data_temp_body = $param['template']['var_name'];
        //print_r($param['template']['temp']); die();
            if(!empty($param['template']['temp']))
                $data_temp_body['email_message'] = $param['template']['temp']; 
               else $data_temp_body['email_message'] = 'Hello Custom Static';
        
       
            $email_body_template = $CI->parser->parse('templates/email/email_template', $data_temp_body, TRUE);
          //  echo "Prem"; print_r($email_body_template);die();
                $param['email_body_template'] = $email_body_template;
            endif;
            
       
        if(!empty($param['email'])) $param_email = $param['email']; else  $param_email=array();
      
        $CI->email->set_newline("\r\n"); 
        // from required
        if(isset($param_email['from']) && !empty($param_email['from'])):
            if(!empty($param_email['from_name']))
                $CI->email->from($param_email['from'],$param_email['from_name']);
            else
                $CI->email->from($param_email['from']);
        else:
            die("Sorry, Please provide 'to' variable.");
        endif;

        // to required
        if(isset($param_email['to']) && !empty($param_email['to'])):
           // $CI->email->to('abhilasha.chapter247@gmail.com');
            $CI->email->to($param_email['to']); 
        else:
            die("Sorry, Please provide 'to' variable.");
        endif;
        // cc optinal
         if(isset($param_email['cc']) && !empty($param_email['cc'])):
            $CI->email->cc($param_email['cc']);         
        endif; 
        // bcc optinal 
        if(isset($param_email['bcc']) && !empty($param_email['bcc'])):
            $CI->email->bcc($param_email['bcc']);        
        endif;
        // subject required
        if(isset($param_email['subject']) && !empty($param_email['subject'])):
            $data_temp_subject['email_message']=$param_email['subject'];
        
            $new_subject_arr=array_merge($data_temp_subject,$param['template']['var_name']);   
            $email_subject_template = $CI->parser->parse('templates/email/email/email_template', $new_subject_arr, TRUE);
            $CI->email->subject($email_subject_template);
        else:
            die("Sorry, Please provide 'subject' variable."); 
         endif;
       
        // template required
         //print_r($param['email_body_template']); die();
       if(isset($param['email_body_template']) && !empty($param['email_body_template'])):
             $CI->email->message($param['email_body_template']);            
        else:
            die("Sorry, Please provide 'template' variable.");      
         endif;
        // attachment optinal 
        if(isset($param_email['attach']) && !empty($param_email['attach'])):
            foreach ($param_email['attach'] as $row):
                $CI->email->attach($row['file']);
            endforeach;
         endif;

        $result = $CI->email->send();
        //echo $CI->email->print_debugger(); die;
        if($result)  
            return array('EMAIL_STATUS'=>$result,'EMAIL_MESSAGE'=>'Email Send Successfully.');
        else    
            return array('EMAIL_STATUS'=>$result,'EMAIL_MESSAGE'=>$CI->email->print_debugger());                        
                         
    }
    function get_email_template($template_id=''){
        $CI =& get_instance();           
        $CI ->load->database();     
        $query=$CI->db->get_where('email_templates',array('id'=>$template_id)); 
       // echo print_r($query); die();
        if($query->num_rows()>0)
            return $query->row();
        else
            return FALSE;
    }
    function html(){
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>   
</head>
<body>
<div id="container">
    <h1>HELLO Mr/Miss {name},</h1>
    <div id="body">
    <p>You are {age} year old.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>  
</div>
</body>
</html>';
    }
		public function set_email_templates($template_id = null)
	{
		if ($template_id==null) {
			return "Invalid template requested.";
		}
		$CI =& get_instance();			 
		$CI->load->database();		
		$query = $CI->db->get_where('email_templates', array('id'=>$template_id));	
		if ($query->num_rows()<=0) {
			return "Invalid template requested.";
		}
		$data = $query->row();
		$b = $this->body_field;
		$s = $this->subject_field;
		$this->template['subject'] = $data->$s;
		$this->template['body'] = $data->$b;
		return true;
	}
	public function set_language($lang_short)
	{
		switch ($lang_short) {
			case 'en':
				$this->subject_field = 'template_subject';
				$this->body_field = 'template_body';
				break;
			case 'ar':
				$this->subject_field = 'template_subject_hebrew';
				$this->body_field = 'template_body_hebrew';
				break;
			default:
				$this->subject_field = 'template_subject';
				$this->body_field = 'template_body';
				break;
		}
		return true;
	}
    public function valid_url($field)
    {
        $CI =& get_instance();

        $CI->form_validation->set_message('valid_url', 'The %s field must contain a valid url.');

        return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $field)) ? FALSE : TRUE;
    }
}