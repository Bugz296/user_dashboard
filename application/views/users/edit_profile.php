        <div class="container first">
			<h3>Edit Profile</h3>
            <div id="edit-form">
                <form action="/users/edit_user/<?= $data['user_info']['id'] ?>" method="post" class="edit-form">
			        <h5>Edit Information</h5>
                    <input type="hidden" name="action" value="user_info">
                    <input type="hidden" name="profile" value="true">
                    <input type="hidden" name="prev_email" value="<?= $data['user_info']['email'] ?>">
                    <label for="email">Email Address:</label>
                    <input type="text" name="email" id="email" value="<?= $data['user_info']['email'] ?>">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name" value="<?= $data['user_info']['first_name'] ?>">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" value="<?= $data['user_info']['last_name'] ?>"></br>
                    <input type="submit" value="Save" class="pull-right btn btn-success">
                </form>
                <form action="/users/edit_user/<?= $data['user_info']['id'] ?>" method="post" class="edit-form change-pass">
			        <h5>Change Password</h5>
                    <label for="password">Password</label>
                    <input type="hidden" name="action" value="user_password">
                    <input type="hidden" name="profile" value="true">
                    <input type="password" name="password" id="password"><br>
                    <label for="password_confirmation">Password Confirmation</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"><br>
                    <input type="submit" value="Update Password" class="pull-right btn btn-success">
                </form>
            </div>
            <div class="edit-form desc-box">
                <form action="/users/edit_user/<?= $data['user_info']['id'] ?>" method="post" >
			        <h5>Edit Description</h5>
                    <input type="hidden" name="action" value="user_description">
                    <input type="hidden" name="profile" value="true">
                    <textarea name="description"><?= $data['user_info']['description'] ?></textarea><br>
                    <input type="submit" value="Save" class="pull-right btn btn-success">
                </form>
            </div>
		</div>
	</body>
</html>