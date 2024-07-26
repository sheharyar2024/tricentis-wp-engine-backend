<div class="container-lg">
	<div class="row">
		<?php
		/* Start the Loop */
		while ( have_posts() ) :
		the_post();

		/*
		* Include the Post-Type-specific template for the content.
		* If you want to override this in a child theme, then include a file
		* called content-___.php (where ___ is the Post Type name) and that will be used instead.
		*/
		if( is_singular() ){
			get_template_part( 'template-parts/content', get_post_type() );
		}else{
			get_template_part( 'template-parts/cards/card', get_post_type() );
		}

		endwhile;
		?>
	</div>

	<div class="row">
		<div class="col">
			<?php the_posts_navigation(); ?>
		</div>
	</div>
</div>
