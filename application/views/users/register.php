<?php
    $recent_input = $this->session->tempdata('recent_input');
    if(!$recent_input){
        $recent_input['email'] = "";
        $recent_input['first_name'] = "";
        $recent_input['last_name'] = "";
    } ?>
        <div class="container first">
			<h3>Register</h3>
            <form action="/users/register_user" method="post">
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email" value="<?= $recent_input['email'] ?>">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" value="<?= $recent_input['first_name'] ?>">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="<?= $recent_input['last_name'] ?>">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"><br>
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" name="password_confirmation" id="password_confirmation"><br>
                <input type="submit" value="Sign In">
            </form>
            <a href="signin">Already have an account? Login</a>
		</div>
	</body>
</html>