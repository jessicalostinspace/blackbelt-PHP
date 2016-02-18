<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);
	}
	public function index()
	{
		
	}

	public function createUser($name, $alias, $email, $password, $birthday)
	{
		$query = "INSERT INTO users (name, alias, email, password, birthday, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
		// var_dump($query); exit;
		$encrypted_password = password_hash($password, PASSWORD_DEFAULT);
		return $this->db->query($query, array($name, $alias, $email, $encrypted_password, $birthday));
	}

	public function get_user_by_email($email)
	{
		$query = "SELECT * FROM users WHERE email = ?";
		return $this->db->query($query, array($email))->row_array();
	}

//get distinct pokes for profile
	public function getTotalPokes($id)
	{
		$query = "SELECT COUNT(distinct poker.id) AS number_pokes
					FROM pokes
					LEFT JOIN users AS poker
					ON pokes.poker_id = poker.id
					LEFT JOIN  users AS poked 
					ON pokes.poked_id = poked.id
					WHERE poked.id = ?";
		return $this->db->query($query, array($id))->result_array();
	}

	public function getPokes($poker_id, $poked_id)
	{
		$query = "SELECT poker.alias, poked.id, COUNT(pokes.id) AS number_pokes
					FROM pokes
					LEFT JOIN users AS poker
					ON pokes.poker_id = poker.id
					LEFT JOIN  users AS poked 
					ON pokes.poked_id = poked.id
					WHERE poker.id = ? AND poked.id = ?
					ORDER BY COUNT(pokes.id) DESC";
		return $this->db->query($query, array($poker_id, $poked_id))->result_array();
	}

	public function getFudge($poker_id, $poked_id)
	{
		$query = "SELECT poker.id, COUNT(pokes.id) AS number_pokes
					FROM pokes
					LEFT JOIN users AS poker
					ON pokes.poker_id = poker.id
					LEFT JOIN  users AS poked 
					ON pokes.poked_id = poked.id
					WHERE poker.id = ? AND poked.id = ?
					ORDER BY number_pokes DESC";
		return $this->db->query($query, array($poker_id, $poked_id))->result_array();
	}

	public function getUsers()
	{
		$query = "SELECT * FROM users";
		return $this->db->query($query)->result_array();
	}

	public function create_poke($poker_id, $poked_id)
	{
		$query = "INSERT INTO pokes (poker_id, poked_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
		return $this->db->query($query, array($poker_id, $poked_id));
	}

	public function getUsersPokes($id)
	{
		$query = "SELECT COUNT(pokes.id) AS number_pokes
					FROM pokes
					WHERE pokes.poked_id = ?";
					
		return $this->db->query($query, array($id))->row_array();
	}

}
