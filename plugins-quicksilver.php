<?php
require_once('wp-load.php');

$env = $_ENV['PANTHEON_ENVIRONMENT'];
$plugin_settings = get_field('plugin_settings', 'option');
$env_index = array_search($env, array_column($plugin_settings, 'environment'));

if($env !== 'live' && isset($env_index)) {
	$options = $plugin_settings[$env_index];
	$jamstack_options = get_option('JamstackPreviewAndDeploymentsOptionsKey');
	$jamstack_options['jamstack_preview_endpoint'] = $options['jamstack_preview_endpoint'];
	$jamstack_options['deployment_badge_url'] = $options['jamstack_deployment_badge_url'];
	$jamstack_options['webhook_url'] = $options['jamstack_webhook_url'];
	
	update_option('JamstackPreviewAndDeploymentsOptionsKey', $jamstack_options, true);
	update_option('stellate_service_name', $options['stellate_service_name'], true);
	update_option('stellate_purging_token', $options['stellate_purging_token'], true);
} else {
	deactivate_plugins( '/jamstack-preview-and-deployments/jamstack-preview-and-deployments.php');
	deactivate_plugins( '/stellate/wp-stellate.php'); 
}