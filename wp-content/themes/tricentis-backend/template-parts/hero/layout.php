<?php
/**
 * Please note that there is logic to the display of this module in inc/automatic/module-hero.php
 */

$post_type = get_post_type();
$type = get_sub_field( 'type' );
/**
 * You may want to use some other information as default that would get replaced with the Hero module content
*/
$prehead_default = apply_filters( "tricentis-backend/hero/{$post_type}/prehead", '' );
switch( true ){
	case is_archive():
		$title_default = get_the_archive_title();
	break;
	case is_404():
		$title_default = get_field( '404_page_title', 'options' );
	break;
	default:
		$title_default = get_the_title();
	break;
}
$title_default = apply_filters( "tricentis-backend/hero/{$post_type}/title", get_the_title() );

?>
<div class="hero module module--hero module--hero--<?php echo $type; ?>">
	<?php TricentisBackendBackgroundOptionsField::display(); ?>

	<div class="container-lg">
		<div class="row">
			<div class="col col-12 col-lg-6">
				<div class="hero__text-section">
					<?php TricentisBackendSEOTextField::display( 'prehead', [ 'class' => 'prehead', 'default_text' => $prehead_default, ] ); ?>
					<?php TricentisBackendSEOTextField::display( 'title', [ 'default_text' =>  $title_default, ] ); ?>
					<?php if( '' != get_sub_field( 'description' ) ): ?>
						<div class="wysiwyg">
							<?php the_sub_field( 'description' ); ?>
						</div>
					<?php endif; ?>
					<?php TricentisBackendActionGroupField::display(); ?>
				</div>
			</div>
			<div class="col col-12 col-lg-6">
				<div class="hero__media-section">
					<?php TricentisBackendMediaGroupField::display(); ?>
				</div>
			</div>
		</div>
	</div>
</div>