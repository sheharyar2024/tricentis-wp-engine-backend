<?php
if( !is_admin() ){
	return;
}

/**
 * This file is used to limit the number of filters on the front end of the site.
 */
include( get_template_directory() . '/inc/optional/filters-admin.php' );