<?php
/**
 * This module assumes the use of this plugin: https://wordpress.org/plugins/add-to-any/
 */
?>
<div class="container-lg">
	<div class="row">
		<div class="col">
			<div class="icon-container">
				<?php
				if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) {
					ADDTOANY_SHARE_SAVE_KIT(array('buttons' => array( 'facebook', 'twitter', 'linkedin' ),
				)); }
				?>
			</div>
		</div>
	</div>
</div>