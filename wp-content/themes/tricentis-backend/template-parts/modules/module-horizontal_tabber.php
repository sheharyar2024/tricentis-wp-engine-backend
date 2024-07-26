<?php
$unique_id = 'HTabber'.$args['module_id'];

$title_arr = get_sub_field( 'title' );
$title = $title_arr['text'];
?>
<div class="container-lg">
	<div class="row">
		<div class="col">
			<div class="horizontal-tabs" data-tabber data-tabber-automatic="true" aria-orientation="horizontal">
				<div class="mobile-button-container">
					<div class="tab-buttons" role="tablist" id="<?php echo $unique_id; ?>" aria-label="<?php echo esc_attr( $title ); ?>">
						<?php
						$i = 0;
						while( have_rows( 'tabs' ) ):
							the_row();
							$tablist_id = $unique_id .'_'. strtolower( preg_replace( '/[^-a-zA-Z]/', '' , get_sub_field( 'tab_title' ) ) );
						?>
							<button class="horizontal-tab-button" role="tab" tabindex="-1" id="<?php echo $tablist_id.'_tab_'.$i ?>" aria-controls="<?php echo $tablist_id.'_panel_'.$i ?>"><?php the_sub_field( 'tab_title' ); ?></button>
						<?php $i++; endwhile; ?>
						<div class="button-underline"></div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="panel-container">
							<?php
							$i = 0;
							while( have_rows( 'tabs' ) ):
								the_row();
								$tablist_id = $unique_id .'_'. strtolower( preg_replace( '/[^-a-zA-Z]/', '' , get_sub_field( 'tab_title' ) ) );
								include( get_template_directory().'/partials/horizontal-tab.php' );
								$i++;
							endwhile;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>