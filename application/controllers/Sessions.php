<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller {


	public function index()
	{
		$this->load->view('/sessions/sessions_index');
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect("/");
	}
}
