<!DOCTYPE html>
<html>
	<head>
		<title><?php echo get_option( 'site_name' ) . ' | ' . $Page -> title ?></title>
		<meta charset="utf-8"/>
		<meta name="generator" content="LsrWCMS v9.1"/>
		<meta name="designer" content="<?php echo $Theme['author']; ?>"/>
		<meta name="keywords" content="<?php echo implode( ",", $Page -> keywords ); ?>"/>
		<meta name="news_keywords" content="<?php echo implode( ",", $Page -> keywords ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="rating" content="<?php echo get_option( 'site_rating' ); ?>"/>
		<meta name="description" content="<?php echo $Page -> description; ?>"/>
		<meta name="twitter:card" content="summary_large_image"/>
		<meta name="twitter:site" content="@lsrwLuke"/>
		<meta name="twitter:site:id" content="255277253"/>
		<meta name="twitter:creator" content="<?php echo $Page -> author -> twitter; ?>"/>
		<meta name="twitter:creator:id" content="<?php echo $Page -> author -> twitter_id; ?>"/>
		<meta name="twitter:title" content="<?php echo $Page -> title; ?>"/>
		<meta name="twitter:description" content="<?php echo $Page -> description; ?>"/>
		<meta itemprop="name" content="<?php echo get_option( 'site_name' ); ?>"/>
		<meta itemprop="description" content="<?php echo $Page -> description; ?>"/>
		<meta property="og:description" content="<?php echo $Page -> description; ?>"/>
		<meta property="og:title" content="<?php echo get_option( 'site_name' ) . ' | ' . $Page -> title ?>"/>
		<meta property="og:url" content="<?php echo get_option( 'site_root' ); ?>"/>
		<meta property="og:site_name" content="<?php echo get_option( 'site_name' ); ?>"/>
		<meta property="og:type" content="<?php echo get_option( 'site_type' ); ?>"/>
		<meta property="business:contact_data:email" content="luke@lsrw.co.uk"/>
		<meta property="business:contact_data:website" content="<?php echo get_option( 'site_root' ); ?>"/>
		<link href="<?php echo root( true ) . 'css/style.php'; ?>" rel="stylesheet"/>
	</head>
	<body>