<?php
	if ( isset( $Panel_File ) ) {
		ob_start();
		require( $Panel_File );
		$Panel_CustomMenu = $Menu;
		ob_end_clean();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>LsrW Panel | <?php echo ucwords( str_replace( '_', ' ', $_GET['page'] ) ); ?></title>
		<link rel="stylesheet" media="all" href="<?php echo root( true ) . 'pages/lsrw_style.php'; ?>"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	</head>
	<body>
		<header id="lsrw_header">
			<a href="<?php echo root(); ?>">View Site</a>
		</header>
		<div id="lsrw_panel">
			<aside id="lsrw_topmenu">
				<header class="lsrw_panel_header">Quick Actions</header>
				<ul><?php 
					if ( isset( $LsrW_Panel_Menu ) and is_array( $LsrW_Panel_Menu ) ) {
						foreach ( $LsrW_Panel_Menu as $LsrW_Panel_Menu_Item ) {
							if ( is_array( $LsrW_Panel_Menu_Item ) ) {
								echo "\n\t\t\t\t\t<ul>";
								foreach ( $LsrW_Panel_Menu_Item as $LsrW_Panel_Menu_Item_List ) {
									$LsrW_Panel_Menu_Item_List = explode( '|', $LsrW_Panel_Menu_Item_List );
#									if ( in_array( $LsrW_Panel_Menu_Item_List[2], $CurrentUser -> permissions ) ) {
										echo "\n\t\t\t\t\t\t" . '<li><a href="' . $LsrW_Panel_Menu_Item_List[0] . '">' . $LsrW_Panel_Menu_Item_List[1] . '</a></li>';
#									}
								}
								echo "\n\t\t\t\t\t</ul>";
							} elseif ( substr( $LsrW_Panel_Menu_Item, 0, 1 ) == '#' ) {
								echo "\n\t\t\t\t</ul>\n\t\t\t\t" . '<header class="lsrw_panel_header">' . trim( $LsrW_Panel_Menu_Item, '#' ) . "</header>\n\t\t\t\t<ul>";
							} else {
								$LsrW_Panel_Menu_Item = explode( '|', $LsrW_Panel_Menu_Item );
#								if ( in_array( $LsrW_Panel_Menu_Item[2], $CurrentUser -> permissions ) ) {
									echo "\n\t\t\t\t\t" . '<li><a href="' . $LsrW_Panel_Menu_Item[0] . '">' . $LsrW_Panel_Menu_Item[1] . '</a></li>';
#								}
							}
						}
					}
				?>
				
				</ul>
			</aside>
			<?php 
				if ( isset( $Panel_File ) ) {
					require( $Panel_File );
				}
			?>
			
		</div>
	</body>
</html>