<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function index(){
		$this->login_check();
		$this->load->view('partials/navbar', array('title'=>'Home Page'));
		$this->load->view('index');
	}
	public function signin(){
		$this->login_check();
		$this->load->view('partials/navbar', array('title'=>'Sign in'));
		$this->load->view('users/signin');
	}
	public function register(){
		$this->login_check();
		$this->load->view('partials/navbar', array('title'=>'Register'));
		$this->load->view('users/register');
	}
	public function new(){
		$this->load->view('partials/navbar', array('title'=>'New User'));
		$this->load->view('users/new');
	}
	public function edit($user_id){
		$this->load->view('partials/navbar', array('title'=>'Edit User'));
		$data['user_info'] = $this->user->select_by_id($user_id);
		$data['accesses'] = $this->user->select_all_accesses();
		$this->load->view('users/edit', array('data'=>$data));
	}
	public function edit_profile(){
		$this->load->view('partials/navbar', array('title'=>'Edit Profile'));
		$data['user_info'] = $this->user->select_by_id($this->session->userdata('id'));
		$data['accesses'] = $this->user->select_all_accesses();
		$this->load->view('users/edit_profile', array('data'=>$data));
	}
	public function delete($user_id){
		$this->load->view('partials/navbar', array('title'=>'Delete User'));
		$data['user_info'] = $this->user->select_by_id($user_id);
		if($data['user_info']){
			$data['accesses'] = $this->user->select_all_accesses();
			$this->load->view('users/delete', array('data'=>$data));
		}else{
			redirect('/dashboard');
		}
	}
	public function show($user_id){
		$this->load->view('partials/navbar', array('title'=>'User Information'));
		$messages = $this->user->select_messages_by_id($user_id);
		$comments = array();
		foreach($messages as $message){
			$comments[$message['messages_id']] = $this->user->select_comments_by_id($message['messages_id']);
		}print_r($comments);
		$this->load->view('users/show', array(
			'user_details' => $this->user->select_by_id($user_id), 
			'messages' => $messages, 
			'comments' => $comments));
	}
	public function register_user(){
		$user_details = $this->input->post();
		$insert_user_status = $this->user->insert_user($user_details);
		if($insert_user_status[0] != "alert alert-success"){
			$this->session->set_tempdata('recent_input', $user_details, 3);
		}
		$this->session->set_tempdata('msg', $insert_user_status, 3);
		if($this->session->userdata('id')){
			redirect('/users/new');
		}else{
			redirect('/users/register');
		}
	}
	public function signin_user(){
		$login_credentials = $this->input->post();
		if($login_credentials['action'] && $login_credentials['action'] == "signin"){
			$signin_status = $this->user->signin($login_credentials['email'], $login_credentials['password']);
			$this->session->set_tempdata('msg', $signin_status, 3);
			if($signin_status[0] == "alert alert-success"){
				$this->login_check();
			}else{
				redirect('/users/signin');
			}
		}
	}
	
	public function edit_user($user_id){
		$user_details = $this->input->post();
		$user_details['id'] = $user_id;
		if($user_details['action'] && $user_details['action'] == 'user_info'){
			$update_user_status = $this->user->update_user_info($user_details);
		}else if($user_details['action'] && $user_details['action'] == 'user_password'){
			$update_user_status = $this->user->update_user_password($user_details);
		}else if($user_details['action'] && $user_details['action'] == 'user_description'){
			$update_user_status = $this->user->update_user_description($user_details);
		}
		$this->session->set_tempdata('msg', $update_user_status, 3);
		if($user_details['profile']){
			redirect('/users/edit');
		}
		redirect('/users/edit/'.$user_id);
	}

	public function delete_user(){
		$action = $this->input->post('action');
		if($action && ($delete_user_status = $this->user->delete_user($action))){
			$this->session->set_tempdata('msg', $delete_user_status, 3);
			redirect('/dashboard');
		}else{
			$this->session->set_tempdata('msg', $delete_user_status, 3);
			redirect('/users/delete/'.$user_id);
		}
	}

	public function message_user(){
		$user_input = $this->input->post();
		if($user_input && ($message_user_status = $this->user->message_user($user_input['action'], $user_input['message']))){

		}
		$this->session->set_tempdata('msg', $message_user_status, 3);
		redirect('/users/show/'.$user_input['action']);
	}

	public function comment_user($user_id){
		$user_input = $this->input->post();
		if($user_input && ($comment_user_status = $this->user->comment_user($user_input['messages_id'], $user_input['comment']))){
		}
		$this->session->set_tempdata('msg', $comment_user_status , 3);
		redirect('/users/show/'.$user_id);
	}
	public function signout_user(){
		$this->session->unset_userdata('id');
		redirect('/users/signin');
	}
	public function login_check(){
		if($this->session->userdata('id')){
			redirect('/dashboard');
		}
	}
}