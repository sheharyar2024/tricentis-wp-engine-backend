<?php
$title = get_field( 'title' );
if( '' == $title ){
	$title = get_the_title();
}
?>
<div class="case-study-summary" role="group">
	<div class="row">
		<div class="col col-12 col-md-5">
			<?php echo $title; ?>
			<div class="wysiwyg">
				<?php the_excerpt(); ?>
			</div>
			<a href="<?php the_permalink(); ?>"><?php _e( 'Read More', 'tricentis-backend' ); ?><span class="screen-reader-text"><?php _e( 'About', 'tricentis-backend' ); ?> <?php echo $title; ?></span></a>
		</div>
		<div class="col col-12 col-md-7">
			<?php if( have_rows( 'key_results' ) ): ?>
				<ul>
				<?php while( have_rows( 'key_results' ) ): the_row(); ?>
					<li><?php the_sub_field( 'result' ); ?></li>
				<?php endwhile; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</div>
