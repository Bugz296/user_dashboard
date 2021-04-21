<?php
    class Dashboards extends CI_Controller{
        public function index(){
            $this->login_check();
            $user_accesses = $this->dashboard->get_accesses();
            if($user_accesses[0]['access_id'] == 9){
                redirect('/dashboard/admin');
            }else{
                redirect('/dashboards/user');
            }
        }
        public function admin(){
            $all_users = $this->dashboard->get_all_users();
            $this->load->view('partials/navbar', array('title'=>'Admin Dashboard'));
            $this->load->view('dashboards/admin', array('all_users' => $all_users));
        }
        public function user(){
            $all_users = $this->dashboard->get_all_users();
            $this->load->view('partials/navbar', array('title'=>'User Dashboard'));
            $this->load->view('dashboards/user', array('all_users' => $all_users));
        }

        public function login_check(){
            if(!$this->session->userdata('id')){
                redirect('/users/signin');
            }
        }
    }
?>