<?php

class Znb_Yoast_Integration extends Znb_Integration{

	/**
	 * Check if we can load this integration or not
	 * @return [type] [description]
	 */
	static public function can_load(){
		return defined( 'WPSEO_VERSION' ) && is_admin();
	}

	function initialize(){
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts') );
	}

	/**
	 * Load the js file that will add the PB content to Yoast
	 * @param  sctring $hook The current page hook
	 * @since 1.0.0
	 */
	function load_scripts( $hook ){
		if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_enqueue_script( 'znb-yoast-integration-js', ZNB()->assetsUrl('js/admin') .'yoast-integration.js', 'jquery', ZNB()->version, true );
		}
	}

}
