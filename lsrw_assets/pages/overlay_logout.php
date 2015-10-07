<?php
	if ( isset( $_COOKIE[cookiename_login] ) ) {
		setcookie( cookiename_login, 0, time() -42 );
		header( "Location: " . root() );
	}
?>