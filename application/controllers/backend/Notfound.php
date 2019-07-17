<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notfound extends CI_Controller {

    public function index()
    {
       $data['title']='404 Not Foundsadfsad';
	   $data['template']='backend/dsfdsf404.php';
	    $this->load->view('templates/backend/',$data);
    }
}
