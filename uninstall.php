<?php
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit;
	if ( get_option( 'sticky_anything_options' ) != false ) {
		delete_option( 'sticky_anything_options' );
	}
?>
