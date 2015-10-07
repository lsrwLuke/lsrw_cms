<?php
	header("Content-type: text/css; charset: UTF-8");
	$Require_Files = array( 'functions.php', 'config.php' );
	foreach ( $Require_Files as $Require_File ) {
		if ( file_exists( '../' . $Require_File ) ) {
			require( '../' . $Require_File );
		}
	}
	$lsrw_menu_color = get_option( 'admin_color1' );
?>
html, body {
	margin: 0;
	background-color: #AAA;
	height: 100%;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 10pt;
}

a, label.trigger {
	color: <?php echo $lsrw_menu_color; ?>;
	text-decoration: none;
	cursor: pointer;
}

a:hover, label.trigger:hover {
	text-decoration: underline;
}

ul {
	padding-left: 2em;
	list-style-type: disc;
	line-height: 1.5em;
}

input.trigger {
	display: none;
}

.lsrw_panel_content {
	padding: 10px;
}

.lsrw_panel_header {
	width: 100%;
	background-color: <?php echo $lsrw_menu_color; ?>;
	padding: 10px;
	text-align: center;
	box-sizing: border-box;
	color: #FFF;
	text-shadow: 0 1px 1px #000;
	font-weight: bold;
	font-size: 1.1em;
}

#lsrw_header {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	background-color: <?php echo $lsrw_menu_color; ?>;
	display: flex;
	font-size: 1.1em;
	box-shadow: 0 0 2px #000;
	color: #FFF;
	text-shadow: 0 1px 1px #000;
	font-weight: bold;
	z-index: 90000;
}

#lsrw_header > a {
	padding: 10px;
	text-align: center;
	flex: 1;
	color: inherit;
}

#lsrw_header > a:hover {
	background-color: rgba(0, 0, 0, 0.1);
	text-decoration: none;
}

#lsrw_panel {
	padding: 5px;
	padding-top: 44px;
	box-sizing: border-box;
	display: flex;
	min-height: 100%;
}

#lsrw_topmenu, #lsrw_main, #lsrw_sidemenu {
	flex: 4;
	margin: 5px;
	background-color: #FFF;
	box-shadow: 0 0 2px #000;
	border-radius: 10px;
	overflow: hidden;
}

#lsrw_topmenu, #lsrw_sidemenu {
	flex: 1;
}

#cke_editor, .lsrw_form > input {
	border: 2px solid #0090FF;
	border-radius: 5px;
	overflow: hidden;
}

.lsrw_form > h2:first-of-type {
	margin-top: 0;
}

.lsrw_form > input {
	padding: 20px;
	width: 100%;
	box-sizing: border-box;
}

.lsrw_form > input[type=submit]:hover {
	background-color: #DDD;
	cursor: pointer;
}