        <div class="container">
            <h3>All Users</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>User Level</th>
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
                    </tr>
<?php           } ?>
                </tbody>
            </table>
		</div>
	</body>
</html>