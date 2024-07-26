<?php
/**
 * Redirect API endpoint
 * Using get_all() function from  /wp-content/plugins/redirection/models/redirect/redirect.php
 */
if ( is_plugin_active('redirection/redirection.php' ) ) {

	require_once WP_PLUGIN_DIR.'/redirection/api/api.php';

	function init_redirect_func(){
		$redirect_obj = new Redirection_Api_Redirect_Custom("redirection/v1");
	}	
	add_action( 'rest_api_init', 'init_redirect_func');

	class Redirection_Api_Redirect_Custom extends Redirection_Api_Filter_Route {

		public function __construct( $namespace ) {
			register_rest_route( $namespace, '/getallredirects', array(
				$this->get_route( WP_REST_Server::READABLE, 'route_list_all', [ $this, 'permission_callback_manage' ] ),
			) );
		}

		public function permission_callback_manage( WP_REST_Request $request ) {
			return true;
		}

		public function route_list_all() {
			$items = [];
			$redirect_json = [];
			
			$rows = Red_Item::get_all();
			$total_items = count($rows);

			foreach ( $rows as $row ) {

				$redirect_json = $row->to_json();
				$redirect_json['action_data'] = $row->get_action_data();
				$match_data = $row->get_match_data();
				$redirect_json['flag_regex'] = $match_data['source']['flag_regex'];
				$redirect_json['flag_query'] = $match_data['source']['flag_query'];
				
				unset($redirect_json['id']);
				unset($redirect_json['match_data']);
				unset($redirect_json['title']);
				unset($redirect_json['hits']);
				unset($redirect_json['last_access']);
				unset($redirect_json['group_id']);
				unset($redirect_json['position']);

				$items[] = $redirect_json;
				
			}

			return ['data'=>['redirects' => $items]];

		}
	}
}else{
	function admin_warning($messages) {
    	
		$notice = <<<EOT
		<div class="notice notice-error">
			<p>Redirection plugin must be active for the rest api <b>wp-json/redirection/v1/getallredirects</b> call to work</p>
		</div>
		EOT;
		
		echo $notice;
	
	}
	add_action( 'admin_notices', 'admin_warning');
}
?>