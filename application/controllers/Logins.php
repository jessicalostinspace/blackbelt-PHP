<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logins extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login');
		$this->output->enable_profiler(TRUE);
	}
	public function index()
	{	
		$this->load->view('main');
	}

	public function create()
	{	
		//Get users posted data
		$name = $this->input->post('name');
		$alias = $this->input->post('alias');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$confirm_password = $this->input->post('confirm_password');
		$birthday = $this->input->post('birthday');

		//Form Validation
		$this->load->library("form_validation");
		$this->form_validation->set_rules("name", "Name", "trim|required");
		$this->form_validation->set_rules("alias", "alias", "trim|required");
		$this->form_validation->set_rules("email", "Email", "valid_email|trim|required|is_unique[users.email]");
		$this->form_validation->set_rules("password", "Password", "min_length[8]|required|matches[confirm_password]");
		$this->form_validation->set_rules("confirm_password", "Password", "min_length[8]|required");


		if($this->form_validation->run() === FALSE)
		{
		     // $this->view_data["errors"] = validation_errors();
		     $this->session->set_flashdata('errors', validation_errors());
		     redirect('/logins');
		}
		else
		{
		     //--------SUCCESSFUL REGISTRATION-----------

			//Store new user info in database
			$this->Login->createUser($name, $alias, $email, $password, $birthday);

			//Get user from database by email
			$user_info = $this->Login->get_user_by_email($email);

			//Save user info in session, redirect to profile
			$user = array(
					'id' => $user_info['id'],
					'name' => $user_info['name'],
					'alias' => $user_info['alias'],
					'email' => $user_info['email'],
					'birthday' => $user_info['birthday'],
					'logged_in' => TRUE
				);

			$this->session->set_userdata($user);
			redirect('/logins/profile');
		}

	}

	public function login()
	{	
		//Get users posted email and password
		$email = $this->input->post('login_email');
		$password = $this->input->post('password');

		//Get user info from Database
		$user_info = $this->Login->get_user_by_email($email);

		//See if user data in database matches users posted data
		if($user_info && password_verify($password, $user_info['password']))
		{
			//Save user info in session, redirect to profile
			$user = array(
				'id' => $user_info['id'],
				'name' => $user_info['name'],
				'alias' => $user_info['alias'],
				'email' => $user_info['email'],
				'birthday' =>$user_info['birthday'],
				'logged_in' => TRUE
				);
			$this->session->set_userdata($user);
			redirect('logins/profile');
		}
		else if($user_info['password'] != $password)
		{
			//Store error that says email does not match password
			$this->session->set_flashdata('errors', "Password is incorrect!");
			redirect('logins');
		}
		else
		{
			//Store error that says user is not registered
			$this->session->set_flashdata('errors', "User is not registered!");
			redirect('logins');
		}

	}

	public function profile()
	{
		$user_data = $this->session->all_userdata();

		$profilePokes = $this->Login->getTotalPokes($this->session->userdata('id'));
		// var_dump(array(
		// 									'user_data' => $user_data, 
		// 									'pokes' => $pokes)
		// 									);exit;

		$all_users = $this->Login->getUsers();

		$individualPokes = array();
		foreach($all_users as $users)
		{

		$individualPokes[] = $this->Login->getPokes($users['id'], $this->session->userdata('id'));
		$pokeHistory[$users['id']] = $this->Login->getUsersPokes($users['id']);
		}

		// var_dump($individualPokes);die;
		// uasort($individualPokes[0], function($a, $b) {
		//     return $b[0]['number_pokes'] <=> $a[0]['number_pokes'];
		// }
		// );

		// var_dump($individualPokes);die;
		// var_dump(array(
		// 									'user_data' => $user_data, 
		// 									'profilePokes' => $profilePokes,
		// 									'individualPokes' => $individualPokes,
		// 									'all_users' => $all_users));exit;

		$this->load->view('profile', array(
											'user_data' => $user_data, 
											'profilePokes' => $profilePokes,
											'individualPokes' => $individualPokes,
											'pokeHistory' => $pokeHistory,
											'all_users' => $all_users)
											);
	}	

	public function poke($poked_id)
	{
		$poker_id = $this->session->userdata('id');
		$this->Login->create_poke($poker_id, $poked_id);
		redirect('/logins/profile');
	}


	public function logout()
	{	
		$this->session->sess_destroy();
		redirect('logins');
	}	
}



