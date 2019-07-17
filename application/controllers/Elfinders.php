<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Elfinders extends CI_Controller {

	public function index(){
		$this->load->view('elfinders');
	}

	public function init(){
		$this->load->helper('path');

		$opts = array(
		// 'debug' => true,
		'roots' => array(
		  array(
		    'driver' => 'LocalFileSystem',
		    'path'   => set_realpath('assets/uploads'),
		    'URL'    => site_url('assets/uploads') . '/',
		    'uploadOverwrite'=>FALSE,
		    'tmbPath'=>set_realpath('assets/uploads').'/thumb',
		    'tmbURL' =>site_url('assets/uploads') . '/thumb/',
		    'tmbSize' =>220,
		    // more elFinder options here
		  )
		)
		);
		$this->load->library('elfinder_lib', $opts);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */