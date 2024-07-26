<?php
while( have_rows( 'vertical_tab' ) ):
	the_row();
?>
<div class="vertical-tab-panel" role="tabpanel" tabindex="-1" id="<?php echo $tablist_id.'_panel_'.$i ?>" aria-labelledby="<?php echo $tablist_id.'_tab_'.$i ?>">

	<?php TricentisBackendSEOTextField::display( 'prehead', [ 'class' => 'prehead' ]); ?>

	<?php TricentisBackendSEOTextField::display(); ?>

	<?php if( '' !== get_sub_field( 'description' ) ): ?>
		<div class="wysiwyg">
			<?php the_sub_field( 'description' ); ?>
		</div>
	<?php endif; ?>

	<?php TricentisBackendButtonGroupField::display(); ?>

</div>
<?php endwhile; ?>
