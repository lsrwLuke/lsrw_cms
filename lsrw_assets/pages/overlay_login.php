
		<?php 
			if ( !isset( $_COOKIE[cookiename_login] ) ) {
				echo '<div class="lsrw_overlay">
			<form method="POST" action="' . root() . '" id="lsrw_loginform">
				<input type="hidden" name="action" value="login"/>
				<h1>' . get_option( 'sitename' ) . ' Panel Login</h1>
				<ul>
					<li>
						<input type="text" name="username" placeholder="Username" id="lsrw_loginform_username" required/>
						<label for="lsrw_loginform_username"><i class="fa fa-user"></i></label>
					</li>
					<li>
						<input type="password" name="password" placeholder="Password" id="lsrw_loginform_password" required/>
						<label for="lsrw_loginform_password"><i class="fa fa-key"></i></label>
					</li>
					<input type="checkbox" id="lsrw_loginform_remember" name="remember" class="lsrw_loginform_hidden"/>
					<li>
						<input type="text" disabled value="Remember Me?"/>
						<label for="lsrw_loginform_remember"><i class="fa fa-lock"></i></label>
					</li>
					<li>
						<input type="submit" value="Login" id="lsrw_loginform_login"/>
						<label for="lsrw_loginform_login"><i class="fa fa-sign-in"></i></label>
					</li>
				</ul>
			</form>
		</div>';
			}
		?>