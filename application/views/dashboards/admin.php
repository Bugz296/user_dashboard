        <div class="container">
            <h3>Manage Users</h3>
            <a href="/users/new" class="pull-right"><h4>ADD USER</h4></a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>User Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
<?php           foreach($all_users as $user){ ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><a href="/users/show/<?= $user['id'] ?>"><?= $user['name'] ?></a></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['created_at'] ?></td>
                        <td><?= $user['user_level'] ?></td>
                        <td><a href="/users/edit/<?= $user['id'] ?>">edit</a> | <a href="/users/delete/<?= $user['id'] ?>">remove</a></td>
                    </tr>
<?php           } ?>
                </tbody>
            </table>
		</div>
	</body>
</html>