<form method="POST" action="<?php echo root( false ) . '?page=panel_home'; ?>">
	<input type="hidden" name="action" value="login"/>
	<input type="text" name="username" id="username"/>
	<input type="password" name="password" id="password"/>
	<input type="submit" value="Login"/>
</form>