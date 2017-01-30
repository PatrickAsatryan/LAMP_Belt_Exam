<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poke extends CI_Model {

	public function newpoke($userid, $pokerid)
	{
		$query = "INSERT INTO pokes (user_id, poker_id) VALUES (?, ?)";
		$values = array($userid, $pokerid);
		return $this->db->query($query, $values);
	}
	public function current_user_num_pokes()
	{
		$query = "SELECT COUNT(DISTINCT(pokes.poker_id)) AS mypokes FROM users JOIN pokes ON pokes.poker_id = users.id JOIN users AS users2 ON users2.id = pokes.user_id WHERE users2.id=?";
		$values = array($this->session->User["user_id"]);
		return $this->db->query($query, $values)->row_array();
	}
	public function distinct_pokers()
	{
		$query = "SELECT DISTINCT(pokers.alias) FROM pokes JOIN users ON users.id = pokes.poker_id JOIN users AS pokers ON pokers.id = users.id WHERE pokes.user_id=?";
		$values = array($this->session->User["user_id"]);
		$pokers = $this->db->query($query, $values)->result_array();

		for ($i=0; $i < COUNT($pokers); $i++) { 
			$query2 = "SELECT COUNT(pokers.alias) AS 'pokers.id' FROM pokes JOIN users ON users.id = pokes.poker_id JOIN users AS pokers ON pokers.id = users.id WHERE pokes.user_id=? AND pokers.alias = ?";
			$values2 = array($this->session->User["user_id"], $pokers[$i]["alias"]);
			$pokers[$i]["pokers.id"] = $this->db->query($query2, $values2)->row_array();
		}
		return $pokers;
	}
	public function distinct_pokers_total_each()
	{
		$query = "SELECT DISTINCT(pokers.alias) FROM pokes JOIN users ON users.id = pokes.poker_id JOIN users AS pokers ON pokers.id = users.id WHERE pokes.user_id=?";
		$values = array($this->session->User["user_id"]);
		return $this->db->query($query, $values)->result_array();
	}	
	public function get_all_my_pokes()
	{
		$query = "SELECT users.name AS Poker, users2.name as Pokee FROM users JOIN pokes ON pokes.poker_id = users.id JOIN users AS users2 ON users2.id = pokes.user_id WHERE users2.id=?";
		$values = array($this->session->User["user_id"]);
		return $this->db->query($query, $values)->result_array();
	}
}
