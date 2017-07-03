<?php if(! defined('ABSPATH')){ return; }
if( ZN_HogashDashboard::isManagedApiKey() ){
	$apiKey = ZN_HogashDashboard::getManagedApiKey();
	if( ZN_HogashDashboard::isConnected() ){
		?>
		<div class="inline notice notice-success">
			<p>
				<?php _e('The theme has been registered and connected with the Hogash Dashboard. To change the API Key, please contact your site administrator.', 'zn_framework'); ?>
			</p>
		</div>
		<?php
	}
	else {
		$v = ZN_HogashDashboard::getThemeCheckOption();
		if( false == $v )
		{
			$result = ZN_HogashDashboard::connectTheme( $apiKey );
			if( isset($result['success']) )
			{
				if( ! $result['success']){
					echo '<div class="inline notice notice-error">';
					echo '<p>'.__('There was an error. Please contact your site administrator.', 'zn_framework').'</p>';
					echo '<p>'.__('Error:', 'zn_framework').' '.$result['data'].'</p>';
					echo '</div>';
				}
				else {
					ZN_HogashDashboard::saveManagedSettings( $apiKey );
					?>
					<div class="inline notice notice-success">
						<p>
							<?php _e('The theme has been registered and connected with the Hogash Dashboard. To change the API Key, please contact your site administrator.', 'zn_framework'); ?>
						</p>
					</div>
					<?php
				}
			}
		}
	}
}
else {
	include( ZNHGTFW()->getFwPath( '/inc/admin/tmpl/form-register-theme-tmpl.php' ));
}
