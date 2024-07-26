</div>

<?php
	echo paginate_links( [
		'type' => 'list',
		'base' => add_query_arg( 'rpage', '%#%', $args['base_url'] ),
		'format' => '?rpage=%#%',
		'add_fragment' => '#ResourceArchive',
		'current' => max( 1, $args['resources']->query_vars['paged'] ),
		'total' => $args['resources']->max_num_pages,
	] );
?>
