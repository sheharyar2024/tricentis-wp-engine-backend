<?php
//introduction section
$logo = get_field( 'logo' );
$download = get_field( 'download' );
$customer_name = get_field( 'customer_name' );
?>
<div class="module case-study-introduction">
	<div class="container-lg">
		<div class="row">
			<div class="col col-12">
				<?php if( $logo ): ?>
					<?php echo wp_get_attachment_image( $logo['ID'], 'full' ); ?>
				<?php endif; ?>

				<?php if( $download ): ?>
					<a href="<?php echo $download['url']; ?>" class="button button-primary" target="_blank"><?php _e( 'Download the Case Study', 'tricentis-backend' ); ?></a>
				<?php endif; ?>

				<?php the_field( 'challenge' ); ?>
				<div class="wysiwyg">
					<?php the_field( 'challenge_description' ); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$modules = array(
	'key_outcomes' => 'data_box',
	'main_content' => 'basic_text',
	'testimonials' => 'testimonial_slider',
	'secondary_content' => 'wysiwyg',
);

foreach( $modules as $field => $module ){
	TricentisBackendModuleHelper::fixed_module( $field, $module );
}
?>

<?php if( $download ): ?>
<div class="module case-study-download">
	<div class="container-lg">
		<div class="row">
			<div class="col col-12">
				<a href="<?php echo $download['url']; ?>" class="button button-primary" target="_blank"><?php _e( 'Download the Case Study', 'tricentis-backend' ); ?></a>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if( get_field( 'display_about_content' ) ): ?>
	<?php if( '' != $customer_name ): ?>
		<div class="module case-study-about-title">
			<div class="container-lg">
				<div class="row">
					<div class="col col-12">
						<?php _e( sprintf( 'About %s', $customer_name ), 'tricentis-backend' ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php
	TricentisBackendModuleHelper::fixed_module( 'about_content', 'wysiwyg' );
endif;

TricentisBackendModuleHelper::fixed_module( 'related_resources', 'resources_grid' );
?>

<?php if ( get_edit_post_link() ) : ?>
	<footer class="entry-footer">
		<?php
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'tricentis-backend' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
		?>
	</footer><!-- .entry-footer -->
<?php endif; ?>