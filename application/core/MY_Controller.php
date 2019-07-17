<?php
class MY_Controller extends CI_Controller 
{
	public $response_array = array(
									"response_code" => 200,
									"data"          => array(),
									"message"       => "",
									"error"         => array()
									);

	public function initialize_user($x_api_key=NULL)
	{
		echo $x_api_key;
	}

	public function api_response()
	{
		$data  =array();
		$data['ResponseCode'] = $this->response_array['response_code'];
		$data['Data']         = $this->response_array['data'];
		$data['Message']      = $this->response_array['message'];
		$data['Error']        = $this->response_array['error'];

		$this->response($data,$data['ResponseCode'] );

	}

}