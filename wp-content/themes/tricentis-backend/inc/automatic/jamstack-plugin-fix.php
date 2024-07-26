<?php

/**
 * Jamstack plugin has a problem. Unix or Linux based system are case sensitive. Post method comparison fails due to case sensitify. We used strtolower function and then compared it with 'post'
 */
if( !function_exists('is_plugin_active') ) {		
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( is_plugin_active( 'jamstack-preview-and-deployments/jamstack-preview-and-deployments.php' ) ) {
    function jamstack_fix()
    {
        $url = jamstackPreviewAndDeploymentsGetWebhookUrl();
        $method = jamstackPreviewAndDeploymentsGetWebhookMethod();
        if (strtolower($method) == 'post') {
            return wp_safe_remote_post($url);
        }
        wp_safe_remote_get($url);
    }
    add_action('jamstack_preview_deployments_deploy_webhook', 'jamstack_fix', 5);


    /** 
     * Add deployment status image in admin bar
    */
    function jamstackPreviewAndDeploymentsGetStatus()
    {
        $options = jamstackPreviewAndDeploymentsGetOptions();
        return !empty($options['deployment_badge_url']) ? $options['deployment_badge_url'] : null;
    }
    function JamstackPreviewAndDeploymentsStatus($bar)
    {
        $title = 'Deployment Status';
        $deployment_status_image = jamstackPreviewAndDeploymentsGetStatus();

        if($deployment_status_image != null)
        {
            $title = sprintf( '<img src="%s" class="deploye-status-image" style="margin-top:5px;"/>', $deployment_status_image );
        }

        $bar->add_node(
            array(
                'id' => 'jamstack-preview-deployments-status',
                'parent' => 'top-secondary',
                'href' => '',
                'title' => $title,
                'meta' => [
                    'class' => 'jamstack-preview-deployments-status'
                ]
            )
        );
    }
    add_action('admin_bar_menu', 'JamstackPreviewAndDeploymentsStatus', 60);
    
}