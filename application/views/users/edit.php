        <div class="container first">
            <a href="/dashboard" class="pull-right"><h4>Return to Dashboard</h4></a>
			<h3>Edit user #<?= $data['user_info']['id'] ?></h3>
            <div id="edit-form">
                <form action="/users/edit_user/<?= $data['user_info']['id'] ?>" method="post" class="edit-form">
			        <h5>Edit Information</h5>
                    <input type="hidden" name="action" value="user_info">
                    <input type="hidden" name="prev_email" value="<?= $data['user_info']['email'] ?>">
                    <label for="email">Email Address:</label>
                    <input type="text" name="email" id="email" value="<?= $data['user_info']['email'] ?>">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name" value="<?= $data['user_info']['first_name'] ?>">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" value="<?= $data['user_info']['last_name'] ?>">
                    <label for="user_level">User Level:</label>
                    <select id="user_level" name="user_level">
<?php           foreach($data['accesses'] as $access){
                    $selected = "";
                    if($data['user_info']['access_id'] == $access['id']){
                        $selected = "selected";
                    }?>
                        <option value="<?= $access['id'] ?>" <?= $selected ?>><?= $access['title'] ?></option>
<?php           } ?>
                    </select><br>
                    <input type="submit" value="Save" class="pull-right btn btn-success">
                </form>
                <form action="/users/edit_user/<?= $data['user_info']['id'] ?>" method="post" class="edit-form change-pass">
			        <h5>Change Password</h5>
                    <label for="password">Password</label>
                    <input type="hidden" name="action" value="user_password">
                    <input type="password" name="password" id="password"><br>
                    <label for="password_confirmation">Password Confirmation</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"><br>
                    <input type="submit" value="Update Password" class="pull-right btn btn-success">
                </form>
            </div>
		</div>
	</body>
</html>