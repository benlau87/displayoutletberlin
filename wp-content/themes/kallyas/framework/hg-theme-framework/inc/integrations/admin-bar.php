<?php

class ZnHgTFw_AdminBarIntegration{
	function __construct(){
		// Add theme options to admin Bar
		add_action( 'admin_bar_menu', array( $this, 'addThemeOptionsAdminBar' ), 100 );
	}

	/**
	 * Add the theme Options menu entry in the admin bar
	 * @param $wp_admin_bar
	 * @hooked to admin_bar_menu
	 * @see functions.php
	 */
	function addThemeOptionsAdminBar( $wp_admin_bar )
	{
		if ( is_user_logged_in() )
		{
			if ( current_user_can( 'administrator' ) )
			{
				$mainMenuArgs = array(
					'id' => 'znhgtfw-theme-options-menu-item',
					'title' => ZNHGTFW()->getThemeName() . ' ' . __( 'Options', 'zn_framework' ),
					'href' => admin_url( 'admin.php?page=zn-about' ),
					'meta' => array(
						'class' => 'znhgtfw-theme-options-menu-item'
					)
				);
				$wp_admin_bar->add_node( $mainMenuArgs );

				// Set parent
				$parentMenuID = $mainMenuArgs[ 'id' ];

				// Add the theme's pages
				$pages = ZNHGTFW()->getComponent('utility')->get_theme_options_pages();

				//[since 4.12]  Add node for Dashboard and its submenus
				$wp_admin_bar->add_node( array(
					'parent' => 'znhgtfw-theme-options-menu-item',
					'id' => 'znhgtfw-theme-options-submenu-item-dashboard',
					'title' => __( 'Dashboard', 'zn_framework' ),
					'href' => admin_url( 'admin.php' ) . '?page=zn-about',
				) );
				$wp_admin_bar->add_node( array(
					'parent' => 'znhgtfw-theme-options-submenu-item-dashboard',
					'id' => 'znhgtfw-theme-options-submenu-item-dashboard-register',
					'title' => __( 'Theme Registration', 'zn_framework' ),
					'href' => admin_url( 'admin.php' ) . '?page=zn-about#zn-about-tab-registration-dashboard',
				) );
				$wp_admin_bar->add_node( array(
					'parent' => 'znhgtfw-theme-options-submenu-item-dashboard',
					'id' => 'znhgtfw-theme-options-submenu-item-dashboard-addons',
					'title' => __( 'Theme Addons', 'zn_framework' ),
					'href' => admin_url( 'admin.php' ) . '?page=zn-about#zn-about-tab-addons-dashboard',
				) );
				$wp_admin_bar->add_node( array(
					'parent' => 'znhgtfw-theme-options-submenu-item-dashboard',
					'id' => 'znhgtfw-theme-options-submenu-item-dashboard-demos',
					'title' => __( 'Theme Demos', 'zn_framework' ),
					'href' => admin_url( 'admin.php' ) . '?page=zn-about#zn-about-tab-dummy_data-dashboard',
				) );


				if ( !empty( $pages ) )
				{
					foreach ( $pages as $slug => $entry )
					{
						$menuID = 'znhgtfw-theme-options-menu-item-' . $slug;
						$menuUrl = admin_url( 'admin.php?page=zn_tp_' . $slug );
						$title = isset($entry[ 'title' ]) ? $entry[ 'title' ] : '';
						$submenuArgs = array(
							'parent' => $parentMenuID,
							'id' => $menuID,
							'title' => $title,
							'href' => $menuUrl,
						);
						$wp_admin_bar->add_node( $submenuArgs );

						// check for submenus
						if ( isset( $entry[ 'submenus' ] ) && !empty( $entry[ 'submenus' ] ) )
						{
							foreach ( $entry[ 'submenus' ] as $item )
							{
								// Let's avoid duplicates
								if ( strcasecmp( $title, $item[ 'title' ] ) == 0 )
								{
									continue;
								}

								$submenuArgs = array(
									'parent' => $menuID,
									'id' => 'znhgtfw-theme-options-submenu-item-' . $item[ 'slug' ],
									'title' => $item[ 'title' ],
									'href' => $menuUrl . '#' . $item[ 'slug' ],
								);
								$wp_admin_bar->add_node( $submenuArgs );
							}
						}
					}
				}
			}
		}
	}
}

return new ZnHgTFw_AdminBarIntegration();
