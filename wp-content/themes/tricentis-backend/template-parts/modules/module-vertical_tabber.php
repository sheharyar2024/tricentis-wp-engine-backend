<?php
$unique_id = 'VTabber'.$args['module_id'];

$title_arr = get_sub_field( 'title' );
$title = $title_arr['text'];
?>
<div class="container-lg">
	<div class="row">
		<div class="col col-12">
			<?php TricentisBackendSEOTextField::display( 'prehead', [ 'class' => 'prehead' ]); ?>
			
			<?php TricentisBackendSEOTextField::display(); ?>
			
			<?php if( '' != get_sub_field( 'description' ) ): ?>
				<div class="wysiwyg">
					<?php the_sub_field( 'description' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="row vertical-tabs" data-tabber data-tabber-automatic="true" aria-orientation="vertical">
		<div class="col col-12 col-md-2">
			<div class="mobile-button-container">
				<div class="tab-buttons" role="tablist" id="<?php echo $unique_id; ?>" aria-label="<?php echo esc_attr( $title ); ?>">
					<?php
					$i = 0;
					while( have_rows( 'tabs' ) ):
						the_row();
						$tablist_id = $unique_id .'_'. strtolower( preg_replace( '/[^-a-zA-Z]/', '' , get_sub_field( 'tab_title' ) ) );
						?>
						<button class="vertical-tab-button" tabindex="-1" role="tab" id="<?php echo $tablist_id.'_tab_'.$i ?>" aria-controls="<?php echo $tablist_id.'_panel_'.$i ?>"><?php the_sub_field( 'tab_title' ); ?></button>
					<?php $i++; endwhile; ?>
				</div>
			</div>
		</div>
		<div class="col col-12 col-md-10">
			<div class="panel-container">
				<?php
				$i = 0;
				while( have_rows( 'tabs' ) ):
					the_row();
					$tablist_id = $unique_id .'_'. strtolower( preg_replace( '/[^-a-zA-Z]/', '' , get_sub_field( 'tab_title' ) ) );
					include( get_template_directory().'/partials/vertical-tab.php' );
					$i++;
				endwhile;
				?>
			</div>
		</div>
	</div>
</div>