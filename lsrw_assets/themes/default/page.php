
		<a href="?page=login">Login</a><br/>
		<a href="?page=logout">Logout</a>

		<?php
			if ( isset( $CurrentUser ) ) {
				echo '<h2>Current User Information</h2>
		<pre>';
				print_r( $CurrentUser );
				echo '</pre>';
			}
			if ( isset( $Page ) ) {
				echo '<h2>Current Page Information</h2>
		<pre>';
				print_r( $Page );
				echo '</pre>';
			}
		?>