<?php
    class Dashboard extends CI_Model{
        public function get_accesses(){
            $id = $this->session->userdata('id');
            return $this->db->query("SELECT access_id FROM users_accesses WHERE user_id = ?", $this->security->xss_clean($id))->result_array();
        }
        
        public function get_all_users(){
            return $this->db->query("SELECT users.id, CONCAT(first_name,\" \",last_name) AS name, email, DATE_FORMAT(created_at, \"%b %D %Y\") AS created_at, title AS user_level FROM users INNER JOIN users_accesses ON users.id = users_accesses.user_id INNER JOIN accesses ON users_accesses.access_id = accesses.id ORDER BY users.id ASC;")->result_array();
        }

        public function get_users_info(){
            return $this->db->query("SELECT first_name, last_name, email FROM users WHERE id=? ", $this->session->userdata('id'))->row_array();
        }
    }
?>