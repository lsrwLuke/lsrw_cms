<?php
	# Establish Core Files
	$core_files = array( 'functions.php', 'classes.php', 'config.php' );
	foreach ( $core_files as $core_file ) {
		if ( file_exists( $root . "lsrw_assets/$core_file" ) ) {
			require_once( $root . "lsrw_assets/$core_file" );
		} else {
			die( "<code><b>Missing File:</b> $root" . "lsrw_assets/$core_file</code>" );
		}
	}
	if ( theme_file_exists( 'config.php' ) ) {
		require( theme_file( 'config.php' ) );
	}
	
	# Establish Current User
	if ( isset( $_COOKIE[cookiename_login] ) ) {
		$CurrentUser = new User( $_COOKIE[cookiename_login] );
		if ( $CurrentUser -> role == 'default' ) {
			$CurrentUser -> change( 'user_role', get_option( 'default_role' ) );
		}
		if ( count( $CurrentUser -> permissions ) == 0 ) {
			$CurrentUser -> change( 'user_permissions', get_option( 'permissions_' . $CurrentUser -> role ) );
		}
	}
	
	# Establish Current Page (& Form Actions)
	if ( isset( $_POST['action'] ) ) {
		if ( $_POST['action'] == 'login' ) {
			$User = new User( $_POST['username'] );
			if ( $User -> password_is( $_POST['password'] ) ) {
				if ( isset( $_POST['remember'] ) ) {
					setcookie( cookiename_login, $User -> id, time() + 30 * 24 * 60 * 60, '/' );
				} else{ 
					setcookie( cookiename_login, $User -> id, 0, '/' );
				}
				header( "Location: " . root() );
			} else {
				header( "Location: " . root() );
			}
		}
	} else {
		# Determine Page ID
		if ( isset( $_GET['id'] ) ) {
			$load_page = $_GET['id'];
		} else {
			$load_page = get_option( 'homepage', '0' );
		}
		
		# Load Page from ID
		if ( page_exists( $load_page ) ) {
			$Page = new Page( $load_page );
			if ( theme_file_exists( 'header_' . $Page -> type . '.php' ) ) {
				require( theme_file( 'header_' . $Page -> type . '.php' ) );
			} elseif ( theme_file_exists( 'header.php' ) ) {
				require( theme_file( 'header.php' ) );
			} elseif ( theme_file_exists( 'header_' . $Page -> type . '.php', 'default' ) ) {
				require( theme_file( 'header_' . $Page -> type . '.php', 'default' ) );
			} elseif( theme_file_exists( 'header.php', 'default' ) ) {
				require( theme_file( 'header.php', 'default' ) );
			} else {
				die( "<code><b>Missing Theme File:</b> header.php</code>" );
			}
			if ( isset( $_GET['page'] ) ) {
				if ( file_exists( root( true ) . 'pages/overlay_' . $_GET['page'] . '.php' ) ) {
					require( root( true ) . 'pages/overlay_' . $_GET['page'] . '.php' );
				} else {
					echo "<code><b>Bad Request:</b> " . $_GET['page'] . "</code>";
				}
			}
			if ( theme_file_exists( $Page -> type . '.php' ) ) {
				require( theme_file( $Page -> type . '.php' ) );
			} elseif( theme_file_exists( 'page.php' ) ) {
				require( theme_file( 'page.php' ) );
			} elseif( theme_file_exists( $Page -> type . '.php', 'default' ) ) {
				require( theme_file( $Page -> type . '.php', 'default' ) );
			} elseif ( theme_file_exists( 'page.php', 'default' ) ) {
				require( theme_file( 'page.php', 'default' ) );
			} else {
				die( "<code><b>Missing Theme File:</b> page.php" );
			}
			if ( theme_file_exists( 'footer_' . $Page -> type . '.php' ) ) {
				require( theme_file( 'footer_' . $Page -> type . '.php' ) );
			} elseif ( theme_file_exists( 'footer.php' ) ) {
				require( theme_file( 'footer.php' ) );
			} elseif ( theme_file_exists( 'footer_' . $Page -> type . '.php', 'default' ) ) {
				require( theme_file( 'footer_' . $Page -> type . '.php', 'default' ) );
			} elseif ( theme_file_exists( 'footer.php', 'default' ) ) {
				require( theme_file( 'footer.php', 'default' ) );
			} else {
				die( "<code><b>Missing Theme File:</b> footer.php</code>" );
			}
		} elseif ( theme_file_exists( '404.php' ) ) {
			require( theme_file( '404.php' ) );
		} elseif( theme_file_exists( '404.php', 'default' ) ) {
			require( theme_file( '404.php', 'default' ) );
		} else {
			die( "<code><b>Missing File:</b> 404.php</code>" );
		}
	}
?>