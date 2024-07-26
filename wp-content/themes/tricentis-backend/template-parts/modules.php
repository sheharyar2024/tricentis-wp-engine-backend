<?php
	$module_id = 0;
	while( have_rows( 'modules' ) ):
		the_row();
		$module = get_row_layout();

		include( get_template_directory().'/partials/module-begin.php' );
		get_template_part( 'template-parts/modules/module', $module, [ 'module_id' => $module_id ] );
		include( get_template_directory().'/partials/module-end.php' );

		$module_id++;
	endwhile;