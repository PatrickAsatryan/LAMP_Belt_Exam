<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("User");
		$this->load->model("Poke");
	}

	public function index()
	{
		$mypokes = $this->Poke->current_user_num_pokes();
		$mydistinctpokers = $this->Poke->distinct_pokers();
		$users = $this->User->get_all_users();
		$this->load->view('/users/users_index', ["users" => $users, "mypokes" => $mypokes, "mydistinctpokers" => $mydistinctpokers]);
	}
	public function checkdob($dob)
	{
		if(strtotime($dob) > strtotime("now"))
		{
			$this->form_validation->set_message('checkdob', "The {field} field can not be later than today's date!");
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function register()
	{
		$validation = $this->User->validation($this->input->post());
		if($validation == "valid")
		{
			$this->User->register($this->input->post());
			redirect("/");
		}
		else
		{
			$this->session->set_flashdata("errors", $validation);
			redirect("/");
		}
	}
	public function login()
	{
		$result = $this->User->login($this->input->post());
		if($result == "Invalid Email or Password")
		{
			$this->session->set_flashdata("errors", $result);
			redirect("/");			
		}
		else
		{
			$this->session->set_userdata("User", $result);
			redirect("/users");
		}
	}
}
