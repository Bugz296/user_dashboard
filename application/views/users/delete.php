        <div class="container first">
			<h3>Delete User ID: <?= $data['user_info']['id'] ?></h3>
			<h3>Are you sure you want to delete this user?</h3>
            <form action="/users/delete_user/<?= $data['user_info']['id'] ?>" method="post">
                <input type="hidden" name="action" value="<?= $data['user_info']['id'] ?>">
                <h5>Email Address: <?= $data['user_info']['email'] ?></h5>
                <h5>Name: <?= $data['user_info']['first_name']." ".$data['user_info']['last_name'] ?></h5>
                <a href="/dashboard" class="btn btn-info">No</a>
                <input type="submit" value="Yes, I want to delete it." class="btn btn-danger">
            </form>
		</div>
	</body>
</html>