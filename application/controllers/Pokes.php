<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pokes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Poke");
	}

	public function index()
	{
		$this->load->view('/users/users_index');
	}
	public function newpoke()
	{
		$poke = $this->input->post();
		$this->Poke->newpoke($poke["userid"], $poke["pokerid"]);
	}
}
