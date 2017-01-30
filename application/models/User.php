<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	public function validation()
	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("name", "Name", "trim|required|min_length[4]|max_length[45]");
		$this->form_validation->set_rules("alias", "Alias", "trim|required|is_unique[users.alias]|min_length[5]|max_length[20]");
		$this->form_validation->set_rules("email", "Email", "trim|required|is_unique[users.email]|valid_email");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[8]|max_length[20]");
		$this->form_validation->set_rules("confirm_password", "Confirm PW", "trim|required|matches[password]");
		$this->form_validation->set_rules("dob", "Date of Birth", 'callback_checkdob|required');

		if($this->form_validation->run() === TRUE)
		{
			return "valid";
		}
		else
		{
			return validation_errors();
		}		
	}
	public function register($post)
	{
			$salt = $salt = bin2hex(openssl_random_pseudo_bytes(22));
			$encpass = md5($post["password"]. "codingdojo" .$salt);
			$query = "INSERT INTO users (name, alias, email, salt, password, dob, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
			$values = array($post["name"], $post["alias"], $post["email"], $salt, $encpass, $post["dob"]);
			return $this->db->query($query, $values);
	}	
	public function get_user_by_email($email)
	{
		$query = "SELECT * FROM users WHERE email =?";
		$values = array($email);
		return $this->db->query($query, $values)->row_array();
	}
	public function login($post)
	{
		$user = $this->get_user_by_email($post["email"]);
		$postpassword = $this->input->post("password");
		$testsalt = $user["salt"];
		$testpassword = md5($postpassword. "codingdojo" .$testsalt);
		if($testpassword == $user["password"])
		{
			$loginsuccess = array(
									"user_id" =>$user["id"],
									"user_name" => $user["name"],
									"user_alias" => $user["alias"],
									"user_email" => $user["email"],
									"is_logged_in" => TRUE);
			return $loginsuccess;
		}
		else
		{
			$loginfail = "Invalid Email or Password";
			return $loginfail;
		}
	}
	public function get_all_users()
	{
		$query = "SELECT * FROM users WHERE id != ?";
		$values = array($this->session->User["user_id"]);
		$users = $this->db->query($query, $values)->result_array();

		for ($i=0; $i < COUNT($users) ; $i++) { 
			$query2 = "SELECT COUNT(pokes.id) AS 'numpokes' FROM pokes WHERE pokes.user_id=?";
			$values2 = array($users[$i]["id"]);
			$users[$i]["numpokes"] = $this->db->query($query2, $values2)->row_array();
		}
		return $users;
	}
	public function get_all_users_by_id2()
	{
		$query = "SELECT users.id FROM users";
		return $this->db->query($query)->result_array();	
	}	
}
