<?php
	# LsrW CMS - Version 9.0.0
	
	class User {
		public function __construct( $target = null, $value = null ) {
			$db = get_database();
			$columns = "user_id,user_name,user_permissions,user_display,user_email,user_twitter,user_twitter_id,user_url,user_role,user_created";
			if ( isset( $target ) ) {
				if ( is_numeric( $target ) ) {
					if ( !( $statement = $db -> prepare( "SELECT $columns FROM " . table_users . " WHERE user_id = ?" ) ) ) {
						die( $db -> error );
					} elseif ( !$statement -> bind_param( 'i', $target ) ) {
						die( $db -> error );
					}
				} elseif ( isset( $value ) ) {
					if ( in_array( $target, explode( ",", $columns ) ) or in_array( "user_" . $target, explode( ",", $columns ) ) ) {
						if ( !in_array( $target, explode( ",", $columns ) ) ) {
							$target = "user_" . $target;
						}
						if ( !( $statement = $db -> prepare( "SELECT $columns FROM " . table_users . " WHERE $target = ?" ) ) ) {
							die( $db -> error );
						} elseif ( !$statement -> bind_param( 's', $value ) ) {
							die( $db -> error );
						}
					} else {
						return false;
					}
				} else {
					if ( !( $statement = $db -> prepare( "SELECT $columns FROM " . table_users . " WHERE user_name = ?" ) ) ) {
						die( $db -> error );
					} elseif ( !$statement -> bind_param( 's', $target ) ) {
						die( $db -> error );
					}
				}
			} else {
				if ( !( $statement = $db -> prepare( "SELECT $columns FROM " . table_users ) ) ) {
					die( $db -> error );
				}
			}
			if ( !$statement -> execute() ) {
				die( $db -> error );
			} elseif ( !$statement -> bind_result( $user_id, $user_name, $user_permissions, $user_display, $user_email, $user_twitter, $user_twitter_id, $user_url, $user_role, $user_created ) ) {
				die( $db -> error );
			} else {
				$this -> exists = $this -> result = $this -> twitter = $this -> twitter_id = $this -> id = $this -> name = $this -> permissions = $this -> email = $this -> url = $this -> role = $this -> created = array();
				while ( $statement -> fetch() ) {
					$this -> id[] = $user_id;
					$this -> name[] = $user_name;
					$this -> permissions[] = explode( ",", $user_permissions );
					$this -> display[] = $user_display;
					$this -> email[] = $user_email;
					$this -> twitter[] = $user_twitter;
					$this -> twitter_id[] = $user_twitter_id;
					$this -> url[] = $user_url;
					$this -> role[] = $user_role;
					$this -> created[] = new Date( $user_created );
					$this -> result[] = array(
						'id' => $user_id,
						'name' => $user_name,
						'permissions' => explode( ",", $user_permissions ),
						'display' => $user_display,
						'email' => $user_email,
						'twitter' => $user_twitter,
						'twitter_id' => $user_twitter_id,
						'url' => $user_url,
						'role' => $user_role,
						'created' => new Date( $user_created ),
					);
					if ( isset( $user_id ) ) {
						$this -> exists[] = true;
					} else {
						$this -> exists[] = false;
					}
				}
				if ( count( $this -> id ) == 1 ) {
					$this -> id = $this -> id[0];
					$this -> name = $this -> name[0];
					$this -> permissions = $this -> permissions[0];
					$this -> display = $this -> display[0];
					$this -> email = $this -> email[0];
					$this -> twitter = $this -> twitter[0];
					$this -> twitter_id = $this -> twitter_id[0];
					$this -> url = $this -> url[0];
					$this -> role = $this -> role[0];
					$this -> created = $this -> created[0];
					$this -> exists = $this -> exists[0];
					$this -> result = $this -> result[0];
				}
			}
		}
		
		public function change( $attributes, $values = null ) {
			$db = get_database();
			if ( $this -> exists ) {
				if ( !is_array( $attributes ) ) {
					$attributes = array( $attribute => $values );
				}
				foreach ( array_keys( $attributes ) as $key ) {
					if ( strpos( $key, 'user_' ) === false ) {
						$attribute = "user_$key";
					} else {
						$attribute = $key;
					}
					$value = $attributes[$key];
					if ( in_array( $attribute, explode( ",", $columns ) ) or in_array( "user_$attribute", explode( ",", $columns ) ) or ( strpos( $attribute, 'pass' ) !== false ) ) {
						if ( is_array( $value ) ) {
							$value = implode( ",", $value );
						} elseif ( strpos( $attribute, 'pass' ) !== false ) {
							$value = password_hash( $value, PASSWORD_DEFAULT );
						}
						if ( !( $statement = $db -> prepare( "UPDATE " . table_users . " SET $attribute = ? WHERE user_id = ?" ) ) ) {
							die( $db -> error );
						} elseif ( !$statement -> bind_param( 'si', $value, $this -> id ) ) {
							die( $db -> error );
						} elseif ( !$statement -> execute() ) {
							die( $db -> error );
						}
					}
				}
			}
		}
		
		public function password_is( $try ) {
			$db = get_database();
			if ( $this -> exists ) {
				if ( !( $statement = $db -> prepare( "SELECT user_pass FROM " . table_users . " WHERE user_id = ?" ) ) ) {
					die( $db -> error );
				} elseif ( !$statement -> bind_param( 'i', $this -> id ) ) {
					die( $db -> error );
				} elseif( !$statement -> execute() ) {
					die( $db -> error );
				} elseif ( !$statement -> bind_result( $user_pass ) ) {
					die( $db -> error );
				} else {
					while ( $statement -> fetch() ) {
						if ( $try == $user_pass ) {
							$this -> change( 'user_pass', $try );
						} elseif ( password_verify( $try, $user_pass ) ) {
							return true;
						} else {
							return false;
						}
					}
				}
			}
		}
	}

	class Page {
		public function __construct( $target = null, $value = null ) {
			$db = get_database();
			$columns = 'page_id,page_author,page_created,page_content,page_title,page_shorten,page_status,page_comment_status,page_type,page_modified,page_modified_author,page_parent,page_comment_count,page_keywords,page_description';
			if ( isset( $target ) ) {
				if ( is_numeric( $target ) ) {
					if ( !( $statement = $db -> prepare( "SELECT $columns FROM " . table_pages . " WHERE page_id = ?" ) ) ) {
						die( $db -> error );
					} elseif ( !$statement -> bind_param( 'i', $target ) ) {
						die( $db -> error );
					}
				} elseif ( isset( $value ) ) {
					if ( in_array( $target, explode( ",", $columns ) ) or in_array( "page_" . $target, explode( ",", $columns ) ) ) {
						if ( !( $statement = $db -> prepare( "SELECT $columns FROM " . table_pages . " WHERE " . $target . " = ?" ) ) ) {
							die( $db -> error );
						} elseif ( !$statement -> bind_param( 's', $value ) ) {
							die( $db -> error );
						}
					} else {
						return false;
					}
				}
			} else {
				if ( !( $statement = $db -> prepare( "SELECT $columns FROM " . table_pages ) ) ) {
					die( $db -> error );
				}
			}
			if ( !$statement -> execute() ) {
				die( $db -> error );
			} elseif ( !$statement -> bind_result( $page_id, $page_author, $page_created, $page_content, $page_title, $page_shorten, $page_status, $page_comment_status, $page_type, $page_modified, $page_modified_author, $page_parent, $page_comment_count, $page_keywords, $page_description ) ) {
				die( $db -> error );
			} else {
				$this -> exists = $this -> result = $this -> id = $this -> author = $this -> created = $this -> content = $this -> title = $this -> shorten = $this -> status = $this -> comment_status = $this -> type = $this -> modified = $this -> modified_author = $this -> parent = $this -> comment_count = $this -> keywords = $this -> description = array();
				while ( $statement -> fetch() ) {
					$this -> id[] = $page_id;
					$this -> author[] = new User( $page_author );
					$this -> created[] = new Date( $page_created );
					$this -> content[] = $page_content;
					$this -> title[] = $page_title;
					$this -> shorten[] = $page_shorten;
					$this -> status[] = $page_status;
					$this -> comment_status[] = $page_comment_status;
					$this -> type[] = $page_type;
					$this -> modified[] = new Date( $page_modified );
					$this -> modified_author[] = new User( $page_modified_author );
					$this -> parent[] = $page_parent;
					$this -> comment_count[] = $page_comment_count;
					$this -> keywords[] = explode( ",", $page_keywords );
					$this -> description[] = $page_description;
					$this -> result[] = array(
						'id' => $page_id,
						'author' => new User( $page_author ),
						'created' => new Date( $page_created ),
						'content' => $page_content,
						'title' => $page_title,
						'shorten' => $page_shorten,
						'status' => $page_status,
						'comment_status' => $page_comment_status,
						'type' => $page_type,
						'modified' => new Date( $page_modified ),
						'modified_author' => new User( $page_modified_author ),
						'parent' => $page_parent,
						'comment_count' => $page_comment_count,
						'keywords' => explode( ",", $page_keywords ),
						'description' => $page_description
					);
					if ( isset( $page_id ) ) {
						$this -> exists[] = true;
					} else {
						$this -> exists[] = false;
					}
				}
				if ( count( $this -> result ) == 1 ) {
					$this -> id = $this -> id[0];
					$this -> author = $this -> author[0];
					$this -> created = $this -> created[0];
					$this -> content = $this -> content[0];
					$this -> title = $this -> title[0];
					$this -> shorten = $this -> shorten[0];
					$this -> status = $this -> status[0];
					$this -> comment_status = $this -> comment_status[0];
					$this -> type = $this -> type[0];
					$this -> modified = $this -> modified[0];
					$this -> modified_author = $this -> modified_author[0];
					$this -> parent = $this -> parent[0];
					$this -> comment_count = $this -> comment_count[0];
					$this -> keywords = $this -> keywords[0];
					$this -> description = $this -> description[0];
					$this -> exists = $this -> exists[0];
					$this -> result = $this -> result[0];
				}
			}
		}
			
		public function change( $attributes, $values = null ) {
			$db = get_database();
			if ( $this -> exists ) {
				if ( !is_array( $attributes ) ) {
					$attributes = array( $attribute => $values );
				}
				if ( isset( $_COOKIE[cookiename_login] ) ) {
					$attributes = array_merge( $attributes, array(
						'modified' => date( "Y-m-d H:i:s" ),
						'modified_author' => current_user
					) );
				}
				foreach ( array_keys( $attributes ) as $key ) {
					if ( strpos( $key, 'page_' ) === false ) {
						$attribute = "page_$key";
					} else {
						$attribute = $key;
					}
					$value = $attributes[$key];
					if ( in_array( $attribute, explode( ",", $columns ) ) or in_array( "page_$attribute", explode( ",", $columns ) ) or ( strpos( $attribute, 'pass' ) !== false ) ) {
						if ( is_array( $value ) ) {
							$value = implode( ",", $value );
						} elseif ( strpos( $attribute, 'pass' ) !== false ) {
							$value = password_hash( $value, PASSWORD_DEFAULT );
						}
						if ( !( $statement = $db -> prepare( "UPDATE " . table_pages . " SET $attribute = ? WHERE page_id = ?" ) ) ) {
							die( $db -> error );
						} elseif ( !$statement -> bind_param( 'si', $value, $this -> id ) ) {
							die( $db -> error );
						} elseif ( !$statement -> execute() ) {
							die( $db -> error );
						}
					}
				}
			}
		}
	}
	
	class Custom {
		public function __construct( $type = 'both' ) {
			if ( $type == 'themes' ) {
				$list = scandir( find_directory() . 'custom/themes/' );
			} elseif ( $type == 'plugins' ) {
				$list = scandir( find_directory() . 'custom/plugins/' );
			} else {
				$list = array_merge( list_custom( 'themes' ), list_custom( 'plugins' ) );
			}
			$n = 0;
			foreach ( $list as $items ) {
				if ( strpos( $items, '.' ) !== false ) {
					unset( $list[$n] );
				}
				++$n;
			}
			
			$this -> type = $type;
			$this -> list = array_values( $list );
			
			$custom_pages = array();
			$custom_locations = array();
			foreach ( $this -> list as $custom_item ) {
				if ( $this -> type == 'both' ) {
					if ( in_array( $custom_item, scandir( find_directory() . 'custom/themes/' ) ) ) {
						if ( in_array( 'pages', array( find_directory() . 'custom/themes/' . $custom_item . '/' ) ) ) {
							$custom_pages = array_merge( $custom_pages, scandir( find_directory() . 'custom/themes/' . $custom_item . '/pages/' ) );
							foreach ( array_diff( scandir( find_directory() . 'custom/themes/' . $custom_item . '/pages/' ), array( '.', '..' ) ) as $item ) {
								$custom_locations[] = find_directory() . 'custom/themes/' . $custom_item . '/pages/';
							}
						}
					} else {
						if ( in_array( 'pages', scandir( find_directory() . 'custom/plugins/' . $custom_item . '/' ) ) ) {
							$custom_pages = array_merge( $custom_pages, scandir( find_directory() . 'custom/plugins/' . $custom_item . '/pages/' ) );
							foreach ( array_diff( scandir( find_directory() . 'custom/plugins/' . $custom_item . '/pages/' ), array( '.', '..' ) ) as $item ) {
								$custom_locations[] = find_directory() . 'custom/plugins/' . $custom_item . '/pages/';
							}
						}
					}
				} else {
					if ( in_array( 'pages', scandir( find_directory() . 'custom/' . $this -> type . '/' . $custom_item . '/' ) ) ) {
						$custom_pages = array_merge( $custom_pages, scandir( find_directory() . 'custom/' . $this -> type . '/' . $custom_item . '/pages/' ) );
						foreach ( array_diff( scandir( find_directory() . 'custom/' . $this -> type . '/' . $custom_item . '/pages/' ), array( '.', '..' ) ) as $item ) {
							$custom_locations[] = find_directory() . 'custom/plugins/' . $custom_item . '/pages/';
						}
					}
				}
			}
			$this -> pages = array_values( array_diff( $custom_pages, array( '.', '..' ) ) );
			$this -> locations = $custom_locations;
		}
		
		public function location( $name ) {
			if ( is_numeric( $name ) ) {
				$array = $this -> locations;
				return $array[$name];
			} else {
				if ( strpos( $name, '.php' ) === false ) {
					$name .= '.php';
				}
				if ( in_array( $name, $this -> pages ) ) {
					$found = -1;
					$n = 0;
					while ( $found == -1 ) {
						if ( $this -> pages[$n] == $name ) {
							$found = $n;
						}
						++$n;
					}
					return $this -> locations[$found] . $name;
				}
			}
		}
	}
	
	class Date {
		public function __construct( $date = 'NOW', $format = null ) {
			if ( $date == 'NOW' ) {
				$date = date( "Y-m-d H:i:s" );
			}
			if ( isset( $date ) ) {
				$this -> raw = $date;
				$this -> timestamp = strtotime( $date );
				if ( isset( $format ) ) {
					$this -> format( $format );
				} else {
					$this -> output = $this -> raw;
				}
			}
		}
	
		public function format( $format ) {
			$this -> output = date( $format, $this -> timestamp );
			return $this -> output;
		}
	}
?>