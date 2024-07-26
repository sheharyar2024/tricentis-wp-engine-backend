<?php
while( have_rows( 'horizontal_tab' ) ):
	the_row();
?>
<div class="horizontal-tab-panel" role="tabpanel" tabindex="-1" id="<?php echo $tablist_id.'_panel_'.$i ?>" aria-labelledby="<?php echo $tablist_id.'_tab_'.$i ?>">

	<div class="row content">
		<div class="col col-12">

			<?php TricentisBackendSEOTextField::display( 'prehead', [ 'class' => 'prehead' ]); ?>

			<?php TricentisBackendSEOTextField::display(); ?>

			<?php if( '' !== get_sub_field( 'description' ) ): ?>
				<div class="wysiwyg">
					<?php the_sub_field( 'description' ); ?>
				</div>
			<?php endif; ?>

			<?php TricentisBackendActionGroupField::display(); ?>

		</div>
	</div>

</div>
<?php endwhile; ?>
