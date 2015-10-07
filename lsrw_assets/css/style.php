<?php
	header("Content-type: text/css; charset: UTF-8");
	$Require_Files = array( 'functions.php', 'config.php' );
	foreach ( $Require_Files as $Require_File ) {
		if ( file_exists( "../$Require_File" ) ) {
			require( "../$Require_File" );
		}
	}
?>
@import url( "./font-awesome.min.css" );

.lsrw_loginform_hidden {
	display: none;
}

.lsrw_overlay {
	width: 100%;
	height: 100%;
	background-color: rgba( 0, 0, 0, 0.5 );
	position: fixed;
	top: 0;
	left: 0;
}

.lsrw_overlay > #lsrw_loginform {
	display: block;
	margin: auto;
	position: relative;
	top: 50%;
	transform: translateY(-50%);
	background-color: #FFF;
	width: 40vw;
	height: 40vw;
	border-radius: 10px;
	overflow: hidden;
	padding: 50px;
	box-sizing: border-box;
	border: 10px solid <?php echo get_option( 'formcolor_valid' ); ?>;
	box-shadow: 0 0 20px #000;
}

.lsrw_overlay > #lsrw_loginform > h1 {
	margin-top: 0;
	text-align: center;
}

.lsrw_overlay > #lsrw_loginform > ul {
	padding: 0;
	margin: 0;
	list-style: none;
	width: 80%;
	height: 100%;
	margin: auto;
}

.lsrw_overlay > #lsrw_loginform > ul > li {
	line-height: 1;
	display: flex;
	border-radius: 10px;
	overflow: hidden;
	border: 1px solid #888;
	margin-bottom: 0.5em;
	box-shadow: 0 1px 0px #000;
}

.lsrw_overlay > #lsrw_loginform > ul > li:hover {
	background-color: rgba( 0, 0, 0, 0.1 );
}

.lsrw_overlay > #lsrw_loginform > ul > li > label {
	display: block;
	float: left;
	width: 1em;
	background-color: <?php echo get_option( 'formcolor_invalid' ); ?>; 
	text-align: center;
	line-height: 1.1em;
	padding: 10px;
	cursor: pointer;
	border: inherit;
	border-top: 0;
	border-right: 0;
	border-bottom: 0;
	color: #FFF;
	text-shadow: 0 0 2px #000;
	font-size: 1.3em;
	height: 100%;
}

.lsrw_overlay > #lsrw_loginform > ul > li > input {
	flex: 1;
	border: 0;
	padding: 10px;
	line-height: inherit;
	font: inherit;
	background-color: transparent;
	font-size: 0.9em;
}

.lsrw_overlay > #lsrw_loginform > ul > li > input[type=submit] {
	background-color: <?php echo get_option( 'formcolor_valid' ); ?>;
	cursor: pointer;
	font-weight: bold;
	color: #FFF;
	text-shadow: 0 0 2px #000;
}

.lsrw_overlay > #lsrw_loginform > ul > li > input[type=submit] + label {
	border-left: 0;
}

.lsrw_overlay > #lsrw_loginform > ul > li > input:valid + label, .lsrw_overlay > #lsrw_loginform > ul > input[type=checkbox]:checked + li > label {
	background-color: <?php echo get_option( 'formcolor_valid' ); ?>; 
}

.lsrw_overlay > #lsrw_loginform > ul > li > :-moz-ui-invalid:not(output) {
	box-shadow: 0 0 0;
}

.lsrw_overlay > #lsrw_loginform > ul > li > input:invalid + label {
	background-color: <?php echo get_option( 'formcolor_invalid' ); ?>; 
}

.lsrw_overlay > #lsrw_loginform > ul > li > input[disabled=""] {
	text-align: center;
}