<?php 
$category = isset( $_GET['category'] )? $_GET['category'] : '';
$role = isset( $_GET['role'] )? $_GET['role'] : '';
$type = isset( $_GET['type'] )? $_GET['type'] : '';
?>
<div class="module module--resource-archive resource-archive">
	<div class="container-lg" id="ResourceArchive">
		<form method="get"
			data-target=".js-archive-target"
			data-ajax="<?php echo admin_url( 'admin-ajax.php?action=tricentis-backend/advanced-archive-post' ); ?>"
			data-archive="<?php echo get_the_ID(); ?>"
			class="js-ajax js-autosubmit"
		>
			<input class="js-input-archive" type="hidden" name="category" value="<?php echo esc_attr( $category ); ?>">
			<input class="js-input-archive" type="hidden" name="role" value="<?php echo esc_attr( $role ); ?>">
			<input class="js-input-archive" type="hidden" name="type" value="<?php echo esc_attr( $type ); ?>">

			<div class="resource-archive__filters">
				<?php if( $args['display_type_filter'] ): ?>
					<div class="resource-archive__filter-container">
						<?php echo AdvancedArchive()->type_filter(); ?>
					</div>
				<?php endif; ?>

				<?php
					foreach( $args['filters'] as $taxonomy => $filter ):
						$html = AdvancedArchive()->taxonomy_filter( $filter );
						if( '' !== $html ):
				?>
						<div class="resource-archive__filter-container">
							<?php echo $html; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>

				<?php if( $args['display_search_filter'] ): ?>
					<div class="resource-archive__search-container">
						<?php echo AdvancedArchive()->search_filter(); ?>
						<button class="d-none" type="submit"><?php _e( 'Submit', 'tricentis-backend' ); ?></button>
					</div>
				<?php endif; ?>

			</div>

			<input type="hidden" name="rpage" value="1">

		</form>

		<div class="js-archive-target">
