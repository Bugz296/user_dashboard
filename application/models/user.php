<?php
    class User extends CI_Model{
        public function insert_user($inputs){
            /*  Enters this if statement if all input is valid  */
            /*  Check if Email exists in database   */
            if(!$this->validate_inputs($inputs) && !$this->select_by_email($inputs['email'])){ 
                /*  Prepares a query to add new user information    */ 
                $query = "INSERT INTO users (first_name, last_name, email, password, created_at) VALUES (?,?,?,?,?)";
                date_default_timezone_set("Singapore");
                $values = array($inputs['first_name'], $inputs['last_name'], $inputs['email'], md5($inputs['password']), date("Y/m/d H:i:s"));
                $this->db->query($query, $values);
                /* Counts how many rows are in db.users table and specifies the access level id then stores it in a variable   */
                if(count($this->select_all_users()) == 1){
                    $access_lvl = 9;
                }else{
                    $access_lvl = 0;
                }
                /*  Prepares a query to add in users_accesses table */
                $user = $this->select_by_email($inputs['email']);
                $query = "INSERT INTO users_accesses (user_id, access_id) VALUES (?,?)";
                $this->db->query($query, array($user['id'], $access_lvl));
                $msg = array("alert alert-success", "Successfully Added New User");
            }else{
                /*  Set returned Validation Errors */
                if($this->validate_inputs($inputs)){
                    $msg = $this->validate_inputs($inputs);
                }else{
                    $msg = array("alert alert-warning", "Please use another email");
                }
            }
            return $msg;
        }
        public function update_user_description($inputs){
            if($this->db->query("UPDATE users SET description = ? WHERE id = ?", array($this->security->xss_clean($inputs['description']), $inputs['id']))){
                $msg = array("alert alert-success", "Successfully Updated");
            }else{
                $msg = array("alert alert-warning", "Unable to Update Profile");
            }
            return $msg;
        }
        public function update_user_info($inputs){
            /*  Enters this if statement if all input is validated  */
            /*  Check if Email already exists in database   */
            $rules = array(
                array("email", "Email", "required|valid_email"),
                array("first_name", "First Name", "required|alpha"),
                array("last_name", "Last Name", "required|alpha")
            );
            if(!($msg = $this->validate($rules))){
                if((($inputs['email'] != $inputs['prev_email']) && !$this->select_by_email($inputs['email'])) || ($inputs['email'] == $inputs['prev_email'])){
                    /*  Prepares a query to update X information    */
                    $update_info_status = $this->db->query("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?", array($inputs['first_name'], $inputs['last_name'], $inputs['email'], $inputs['id']));
                    $update_user_lvl_status = $this->db->query("UPDATE users_accesses SET access_id = ? WHERE user_id = ?", array($inputs['user_level'], $inputs['id']));
                    if($update_info_status && $update_user_lvl_status){
                        $msg = array("alert alert-success", "Successfully Updated!");
                    }else{
                        $msg = array("alert alert-warning", "Unable to Update User!");
                    }
                }else{
                    $msg = array("alert alert-warning", "Please Use Another Email");
                }
            }
            return $msg;
        }
        
        public function update_user_password($inputs){
            /*  Enters this if statement if all input is validated  */
            /*  Check if Email already exists in database   */
            if(!$this->validate_user_password($inputs)){ 
                /*  Prepares a query update X's access in users_accesses table */
                $query = "UPDATE users SET password = ? WHERE id = ?";

                $this->db->query($query, array(md5($inputs['password']), $inputs['id']));
                $msg = array("alert alert-success", "Successfully Updated User Password");
            }else{
                /*  Set returned Validation Errors */
                $msg = $this->validate_user_password($inputs);
            }
            return $msg;
        }
        public function delete_user($user_id){
            $user_id = $this->security->xss_clean($user_id);
            $delete_user_access = $this->db->query("DELETE FROM users_accesses WHERE user_id = ?", $user_id);
            $delete_user_info = $this->db->query("DELETE FROM users WHERE id = ?", $user_id);
            if($delete_user_access && $delete_user_info){
                $msg = array("alert alert-success", "Successfully Removed User");
            }else if($delete_user_access){
                $msg = array("alert alert-warning", "Partial Successful! Removed User Access");
            }else if($delete_user_info){
                $msg = array("alert alert-warning", "Partial Successful! Removed User Info");
            }else{
                $msg = array("alert alert-warning", "Unable to Remove User");
            }
            return $msg;
        }
        public function validate_inputs($inputs){
            $this->form_validation->set_rules("email", "Email", "required|valid_email");
            $this->form_validation->set_rules("first_name", "First Name", "required|alpha");
            $this->form_validation->set_rules("last_name", "Last Name", "required|alpha");
            $this->form_validation->set_rules("password", "Password", "required|min_length[8]");
            //$this->form_validation->set_rules("password_confirmation", "Password Confirmation", "matches['password']");
            if($this->form_validation->run() == FALSE) {
                return array("alert alert-warning", validation_errors());
            }
        }

        public function validate($rules){
            foreach($rules as $rule){
                $this->form_validation->set_rules($rule[0], $rule[1], $rule[2]);
            }
            if($this->form_validation->run() == FALSE) {
                return array("alert alert-warning", validation_errors());
            }
        }

        public function validate_user_info($inputs){
            $this->form_validation->set_rules("email", "Email", "required|valid_email");
            $this->form_validation->set_rules("first_name", "First Name", "required|alpha");
            $this->form_validation->set_rules("last_name", "Last Name", "required|alpha");
            if($this->form_validation->run() == FALSE) {
                return array("alert alert-warning", validation_errors());
            }
        }
        public function validate_user_password($inputs){
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
            //$this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required|min_length[8]|matches["password"]');
            if($this->form_validation->run() == FALSE) {
                return array("alert alert-warning", validation_errors());
            }
        }

        public function message_user($recipient_id, $message){
            $message_user_status = $this->db->query("INSERT INTO messages (user_id, recipient_id, message, created_at) VALUES(?, ?, ?, NOW())", array($this->session->userdata('id'), $this->security->xss_clean($recipient_id), $this->security->xss_clean($message)));
            if($message_user_status){
                $msg = array("alert alert-success", "Message Posted!");
            }else{
                $msg = array("alert alert-warning", "Unable to Post Message!");
            }
            return $msg;
        }

        public function comment_user($msg_id, $comment){
            $comment_user_status = $this->db->query("INSERT INTO comments (message_id, comment, user_id, created_at) VALUES (?, ?, ?, NOW())", array($msg_id, $comment, $this->session->userdata('id')));
            if($comment_user_status){
                $msg = array("alert alert-success", "Comment Posted!");
            }else{
                $msg = array("alert alert-warning", "Unable to Post Comment!");
            }
            return $msg;
        }
        public function select_messages_by_id($recipient_id){
            return $this->db->query("SELECT messages.id AS messages_id, message, DATE_FORMAT(messages.created_at, \"%b %D %Y\") AS created_at, CONCAT(first_name,\" \",last_name) AS name, TIMESTAMPDIFF(MINUTE,messages.created_at, NOW()) AS time_diff FROM messages INNER JOIN users ON messages.user_id = users.id WHERE recipient_id = ? ORDER BY messages.created_at DESC;", array($this->security->xss_clean($recipient_id)))->result_array();
        }
        public function select_comments_by_id($msg_id){
            return $this->db->query("SELECT messages.id AS messages_id, comments.comment, DATE_FORMAT(messages.created_at, \"%b %D %Y\") AS created_at, CONCAT(first_name,\" \",last_name) AS name, TIMESTAMPDIFF(MINUTE,comments.created_at, NOW()) AS time_diff FROM comments RIGHT JOIN users ON comments.user_id = users.id INNER JOIN messages ON comments.message_id =messages.id WHERE messages.id = ? ORDER BY comments.created_at DESC;", array($this->security->xss_clean($msg_id)))->result_array();
        }
        public function select_by_email($email){
            $query = "SELECT * FROM users WHERE email = ?";
            return $this->db->query($query, $email)->row_array();
        }
        public function select_by_id($user_id){
            $query = "SELECT users.id, first_name, last_name, email, description, title AS user_level, accesses.id AS access_id, DATE_FORMAT(created_at, \"%b %D %Y\") AS created_at, description FROM users INNER JOIN users_accesses ON users.id = users_accesses.user_id INNER JOIN accesses ON users_accesses.access_id = accesses.id WHERE users.id = ?";
            return $this->db->query($query, $user_id)->row_array();
        }
        public function select_all_users(){
            return $this->db->query('SELECT * FROM users;')->result_array();
        }
        public function select_all_accesses(){
            return $this->db->query('SELECT * FROM accesses;')->result_array();
        }
        public function select_all_messages($user_id){
            return $this->db->query("SELECT * FROM messages WHERE recipient_id = ?", $this->security->xss_clean($user_id))->result_array();
        }
        public function signin($email, $password){
            $email = $this->security->xss_clean($email);
            $password = $this->security->xss_clean($password);
            $user_info = $this->select_by_email($email);
            if($user_info && $user_info['password'] == md5($password)){
                $this->session->set_userdata(array('id' => $user_info['id'], 'first_name' => $user_info['first_name'], 'last_name' => $user_info['last_name']));
                return array("alert alert-success", "Login Successful!");
            }else{
                return array("alert alert-warning", "Invalid username or Password. Please try again!");
            }
        }
    }
?>