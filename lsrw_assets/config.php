<?php
	# Define Database Configuration	

	if ( !defined( 'db_host' ) ) {
		# Database Info Config
		define( 'db_host', 'localhost' );
		define( 'db_user', 'root' );
		define( 'db_pass', '' );
		define( 'db_name', 'lsrwcms_db' );
		
		# Table Name Config
		define( 'table_options', 'lsrw_options' );
		define( 'table_pages', 'lsrw_pages' );
		define( 'table_themes', 'lsrw_themes' );
		define( 'table_users', 'lsrw_users' );
		
		# Cookie Name Config
		define( 'cookiename_login', 'lsrw_login' );
	}
	
	# Establish Core Tables
	
	$lsrw_tables = array();
	$lsrw_tables_sqls = array(
		"CREATE TABLE IF NOT EXISTS " . table_users . " (
			user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			user_name VARCHAR(64) NOT NULL UNIQUE,
			user_pass VARCHAR(255) NOT NULL,
			user_permissions TEXT NOT NULL,
			user_display VARCHAR(64),
			user_email VARCHAR(100),
			user_twitter VARCHAR(64),
			user_twitter_id VARCHAR(64),
			user_url VARCHAR(100),
			user_role VARCHAR(30) NOT NULL,
			user_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		)",
			
		"CREATE TABLE IF NOT EXISTS " . table_pages . " (
			page_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			page_author INT NOT NULL,
			page_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			page_content LONGTEXT NOT NULL,
			page_title TEXT NOT NULL,
			page_shorten TEXT NOT NULL,
			page_status VARCHAR(30) NOT NULL,
			page_comment_status VARCHAR(30) NOT NULL,
			page_password VARCHAR(255) NOT NULL,
			page_type VARCHAR(10) NOT NULL,
			page_modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			page_modified_author INT NOT NULL,
			page_parent INT NOT NULL,
			page_comment_count INT NOT NULL,
			page_keywords TEXT NOT NULL,
			page_description TEXT NOT NULL
		)",
			
		"CREATE TABLE IF NOT EXISTS " . table_options . " (
			option_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			option_name VARCHAR(64) NOT NULL UNIQUE,
			option_value VARCHAR(64) NOT NULL
		)",
			
		"CREATE TABLE IF NOT EXISTS " . table_themes . " (
			theme_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			theme_name VARCHAR(64) NOT NULL UNIQUE,
			theme_version INT NOT NULL,
			theme_designer VARCHAR(64) NOT NULL,
			theme_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
		)"
	);
	
 	# Create Core lsrw_[stuff] Tables
 	
	foreach ( $lsrw_tables_sqls as $lsrw_tables_sql ) {
		$lsrw_tables[] = explode( ' ', $lsrw_tables_sql )[5];
		create_table( $lsrw_tables_sql );
	}
	
	$default_options = array(
		'homepage' => '1',
		'current_theme' => 'default',
		'default_role' => 'user',
		'permissions_admin' => 'permission2',
			
		# Panel Interface Settings
		'formcolor_label' => '#0090FF',
		'formcolor_valid' => '#73CC33',
		'formcolor_invalid' => '#FF0000',
		
		# General Settings
		'site_name' => 'Site Name',
		'site_root' => 'localhost/cms2/',
		'site_type' => 'blog',
		'site_rating' => 'general',
	);
	foreach ( $default_options as $key => $value ) {
		if ( !get_option( $key ) ) {
			set_option( $key, $value );
			if ( $key == 'current_theme' ) {
				create_page( '1', 'Hello World!', '<h1>Hello World</h1> Welcome to your <b>first page</b>.', '0', 'default', 'disabled', 'page', '', '', 'First LsrW Page' );
				create_user( 'username', 'password', 'admin' );
			}
		}
	}
	
	$LsrW_Panel_Menu = array(
		'?page=panel_home|View Panel Home|all',
		'?page=profile|Your Profile|view_profile',
		'?page=add_new_page|Add New Page|add_pages',
		'?page=add_new_media|Add New Media|upload_media',
		'?page=add_new_user|Add New User|add_users',
		'?page=signout|Sign Out|signout',
		'#Pages',
		'?page=view_pages|View Pages|view_pages',
		'?page=add_new_page|Add New Page|add_pages',
		'?page=view_categories|View Categories|view_categories',
		'?page=view_tags|View Tags|view_tags',
		'#Media',
		'?page=view_media|View Media|view_media',
		'?page=upload_media|Add New Media|upload_media',
		'?page=view_media_categories|View Media Categories|view_media_categories',
		'?page=view_media_tags|View Media Tags|view_media_tags',
		'?page=media_options|Media Options|media_options',
		'#Comments',
		'?page=view_comments|View Comments|view_comments',
		'?page=comment_options|Comment Options|comment_options',
		'#Users',
		'?page=view_users|View Users|view_users',
		'?page=add_new_user|Add New User|add_user',
		'?page=profile|Your Profile|view_profile',
		'?page=custom_login|Customize Login|custom_login',
		'?page=manage_signups|Manage Sign Ups|manage_signups',
		'?page=permissions|Permissions|manage_permissions',
		'#Appearence',
		'?page=themes|View Themes|view_themes',
		'?page=add_new_theme|Add New Theme|add_themes',
		'?page=edit_theme|Edit Theme|edit_theme',
		'?page=theme_options|Theme Options|edit_theme',
		'?page=widgets|Edit Widgets|edit_widgets',
		'?page=menus|Edit Menus|edit_menus',
		'#Plugins',
		'?page=plugins|View Plugins|view_plugins',
		'?page=add_new_plugin|Add New Plugin|add_plugins',
		'#Notes',
		'?page=view_notes|View Notes|view_notes',
		'?page=add_new_note|Add New Note|add_notes',
		'#Tools',
		'?page=statistics|View Statistics|view_stats',
		'#Options',
		'?page=general_options|Site Options|general_options',
		'?page=content_options|Content Options|content_options',
		'?page=sharing_options|Sharing Options|sharing_options'
	);
?>