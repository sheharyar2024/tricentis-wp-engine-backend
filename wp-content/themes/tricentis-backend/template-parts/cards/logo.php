<?php
$title = get_the_title();
$website = get_field( 'website' );
$image = get_field( 'logo' );
$link = [
	'url' => $website,
	'target' => '_blank',
];
?>
<div class="logo">
	<?php if( '' !== $website ): ?>
		<a <?php echo tricentis_backend_link_attributes($link); ?>><?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?></a>
	<?php else: ?>
		<?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?>
	<?php endif; ?>
</div>