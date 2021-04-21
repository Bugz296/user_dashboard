        <div class="container first">
			<h3>Sign in</h3>
            <form action="/users/signin_user" method="post">
                <input type="hidden" name="action" value="signin">
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"><br>
                <input type="submit" value="Sign In">
            </form>
            <a href="/users/register">Don't have an account? Register</a>
		</div>
	</body>
</html>