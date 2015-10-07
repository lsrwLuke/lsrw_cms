<?php
	function get_database() {
		$db = new mysqli( db_host, db_user, db_pass, db_name );
		if ( $db -> errno ) {
			die( $db -> error );
		} else {
			return $db;
		}
	}
	
	function custom_is( $type, $name ) {
		if ( $type == 'theme' ) {
			$type = 'themes';
		} elseif ( $type == 'plugin' ) {
			$type = 'plugins';
		}
		if ( in_array( $name, scandir( root( true ) . $type . '/' ) ) ) {
			return true;
		} else {
			return false;
		}
	}
	
	function list_custom( $type = 'all' ) {
		if ( $type == 'themes' ) {
			$custom_list = scandir( root( true ) . 'themes/' );
		} elseif ( $type == 'plugins' ) {
			$custom_list = scandir( root( true ) . 'plugins/' );
		} else {
			$custom_list = array_merge( list_custom( 'themes' ), list_custom( 'plugins' ) );
		}
		return array_diff( $custom_list, array( '.', '..' ) );
	}
	
	function list_custom_pages( $type = 'all' ) {
		$pages = array();
		foreach ( list_custom( $type ) as $custom_item ) {
			if ( custom_is( 'theme', $custom_item ) ) {
				if ( file_exists( root( true ) . 'themes/' . $custom_item . '/pages/' ) ) {
					foreach ( scandir( root( true ) . 'themes/' . $custom_item . '/pages/' ) as $found_item ) {
						if ( $found_item != '.' and $found_item != '..' ) {
							$pages[str_replace( '.php', '', $found_item )] = root( true ) . 'themes/' . $custom_item . '/pages/' . $found_item;
						}
					}
				}
			} elseif( custom_is( 'plugin', $custom_item ) ) {
				if ( file_exists( root( true ) . 'plugins/' . $custom_item . '/pages/' ) ) {
					foreach ( scandir( root( true ) . 'plugins/' . $custom_item . '/pages/' ) as $found_item ) {
						if ( $found_item != '.' and $found_item != '..' ) {
							$pages[str_replace( '.php', '', $found_item )] = root( true ) . 'plugin/' . $custom_item . '/pages/' . $found_item;
						}
					}
				}
			} else {
				return false;
			}
		}
		return $pages;
	}
	
	function create_page( $author, $title, $content = '', $parent = 0, $status = 'default', $comment_status = 'default', $type = 'page', $password = '', $keywords = 'generate', $description = '' ) {
		$db = get_database();
		$shorten = ellipse( $content, 100 );
		if ( $keywords == 'generate' ) {
			$keywords = generate_keywords( $content );
		}
		if ( !( $createPage = $db -> prepare( "INSERT INTO " . table_pages . "( page_author, page_content, page_title, page_shorten, page_status, page_comment_status, page_password, page_type, page_modified_author, page_parent, page_comment_count, page_keywords, page_description ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )" ) ) ) {
			report_error( "Page Object, Error 2", "Prepare Failed - " . $db -> error );
		} elseif ( !$createPage -> bind_param( 'isssssssiiiss', $author, $content, $title, $shorten, $status, $comment_status, $password, $type, $author, $parent, $comment_count = 0, $keywords, $description ) ) {
			report_error( "Page Object, Error 2", "Bind Param Failed - " . $db -> error );
		} elseif ( !$createPage -> execute() ) {
			report_error( "Page Object, Error 2", "Execute Failed - " . $db -> error );
		} else {
			return true;
		}
	}
	
	function ellipse( $content, $no_chars, $crop_content = '...' ) {
		$content = trim( preg_replace( '/\s\s+/', ' ', $content ) );
		$no_chars = $no_chars - strlen( $crop_content );
		$buff = strip_tags( $content );
		if ( strlen($buff) > $no_chars ) {
			$cut_index = strpos( $buff,' ',$no_chars );
			$buff = str_replace( ' ...', '...', substr( $buff, 0, ( $cut_index===false? $no_chars: $cut_index+1 ) ) . $crop_content );
		}
		return $buff;
	}
	
	function generate_keywords( $content, $limit = '3', $length = '4' ) {
		$keywords = '';
		foreach ( array_count_values( str_word_count( str_replace( array( ' used ', ' much ',  'nbsp', ' nbsp ', ' something ', ' that ', ' does ', 'that', ' that ', ' have ',' with', ' this ', ' from ', ' they ', ' will ', ' would ', ' there ', ' their ', ' what ', ' about ', ' which ', ' when ', ' make ', ' like ', ' time ', ' just ', ' know ', ' take ', ' person ', ' into ', ' year ', ' your ', ' good ', ' some ', ' could ', ' them ', ' other ', ' than ', ' then ', ' look ', ' only ', ' come ', ' over ', ' think ', ' also ', ' back ', ' after ', ' work ', ' first ', ' well ', ' even ', ' want ', ' because ', ' these ', ' give ', ' most ' ), ' ', strip_tags( $content ) ), 1 ) ) as $keyword => $frequency ) {
			if ( $frequency >= '3' and strlen( $keyword ) >= '4' and strlen( $keyword ) <= '10' and strpos( $keywords, $keyword ) === false ) {
				$keywords .= strtolower( $keyword ).', ';
			}
		}
		return trim( $keywords, ', ' );
	}
	
	function create_table( $table_sql ) {
		$db = get_database();
		if ( !$createTable = $db -> prepare( $table_sql ) ) {
			die( $db -> error );
		} elseif ( !$createTable -> execute() ) {
			die( $db -> error );
		} else {
			return true;
		}
	}
	
	function create_user( $username, $password, $role = 'default', $email = '', $url = '', $display = '' ) {
		$db = get_database();
		if ( isset( $username, $password ) ) {
			if ( $display == '' ) {
				$display = $username;
			}
			$user = new User( $username );
			if ( $user -> exists ) {
				return false;
			} else {
				if ( !( $createUser = $db -> prepare( "INSERT INTO " . table_users . "( user_name, user_pass, user_display, user_email, user_url, user_role ) VALUES ( ?, ?, ?, ?, ?, ? )" ) ) ) {
					die( $db -> error );
				} elseif ( !$createUser -> bind_param( 'ssssss', $username, password_hash( $password, PASSWORD_DEFAULT ), $display, $email, $url, $role ) ) {
					die( $db -> error );
				} elseif ( !$createUser -> execute() ) {
					die( $db -> error );
				} else {
					return true;
				}
			}
		}
	}
	
	function create_theme( $name, $version, $designer ) {
		$Custom = new Custom( 'themes', $name );
	}
	
	function page_exists( $id ) {
		$Page = new Page( $id );
		if ( $Page -> exists ) {
			return true;
		} else {
			return false;
		}
	}
	
	function root( $include = false, $file = 'lsrw_assets' ) {
		$scandir_directory = './';
		while ( !in_array( $file, scandir( $scandir_directory ) ) ) {
			if ( $scandir_directory == './' ) {
				$scandir_directory = '../';
			} else {
				$scandir_directory .= '../';
			}
		}
		if ( $include ) {
			$scandir_directory .= $file . '/';
		}
		return $scandir_directory;
	}
	
	function get_option( $option_name = null, $option_ifnull = false ) {
		$db = get_database();
		$result = array();
		if ( isset( $option_name ) ) {
			if ( !( $statement = $db -> prepare( "SELECT option_id, option_name, option_value FROM lsrw_options WHERE option_name = ?" ) ) ) {
				die( $db -> error );
			} elseif ( !$statement -> bind_param( 's', $option_name ) ) {
				die( $db -> error );
			}	
		} else {
			if ( !( $statement = $db -> prepare( "SELECT option_id, option_name, option_value FROM lsrw_options" ) ) ) {
				die( $db -> error );
			}
		}
		if ( !$statement -> execute() ) {
			die( $db -> error );
		} elseif ( !$statement -> bind_result( $option_id, $option_name, $option_value ) ) {
			die( $db -> error );
		} else {
			while ( $statement -> fetch() ) {
				$result[] = array(
					'id' => $option_id,
					'name' => $option_name,
					'value' => $option_value
				);
			}
			if ( count( $result ) == 1 ) {
				if ( isset( $result[0]['value'] ) and $result[0]['value'] != '' ) {
					$result = $result[0]['value'];
				} else {
					$result = $option_ifnull;
				}
			}
			return $result;
		}
	}
	
	function set_option( $option_name, $option_value ) {
		$db = get_database();
		if ( get_option( 'homepage' ) !== false ) {
			if ( !( $statement = $db -> prepare( "INSERT INTO lsrw_options (option_name, option_value) VALUES (?,?)" ) ) ) {
				die( $db -> error );
			} elseif ( !$statement -> bind_param( 'ss', $option_name, $option_value ) ) {
				die( $db -> error );
			}
		} else {
			if ( !( $statement = $db -> prepare( "UPDATE lsrw_options SET option_value = ? WHERE option_name = ?" ) ) ) {
				die( $db -> error );
			} elseif ( !$statement -> bind_param( 'ss', $option_value, $option_name ) ) {
				die( $db -> error );
			}
		}
		if ( !( $statement -> execute() ) ) {
			die( $db -> error );
		} else {
			return true;
		}
	}
	
	function theme_file( $file_name = '', $theme = 'current' ) {
		if ( $theme == 'current' ) {
			$theme = get_option( 'current_theme' );
		}
		return root( true ) . 'themes/' . $theme . '/' . $file_name;
	}
	
	function theme_file_exists( $file_name, $theme = 'current' ) {
		if ( $theme == 'current' ) {
			$theme = get_option( 'current_theme' );
		}
		if ( file_exists( root( true ) . 'themes/' . $theme . '/' . $file_name ) ) {
			return true;
		} else {
			return false;
		}
	}
?>