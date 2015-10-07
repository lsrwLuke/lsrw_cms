<?php
	$root = './';
	while ( !in_array( 'lsrw_assets', scandir( $root ) ) ) {
		if ( $root == './' ) {
			$root = '../';
		} else {
			$root .= '../';
		}
	}
	require( $root . 'lsrw_assets/page.php' );
?>