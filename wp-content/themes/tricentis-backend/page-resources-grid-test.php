<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TRICENTIS_BACKEND
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
    <div class="container-lg">
		<?php
		while ( have_posts() ) :
			the_post();


			// $type = 'case_study';

			// $posts = [];
			// $output = [];
	
			// $args = array(
			// 	'numberposts' => -1,
			// 	'post_type'   => $type
			//   );
	
			//   $posts[] = get_posts($args);
	
			// foreach ($posts[0] as $post) {
	
			// 	$output[] = array(
			// 		'ID' => $post->ID,
			// 		'title' => $post->post_title,
			// 		'excerpt' => $post->post_excerpt,
			// 		'content' => $post->post_content,
			// 		'slug' => $post->post_name,
			// 		'featured_image' => get_the_post_thumbnail_url($post->ID, 'full'),
			// 		'company_logo_url' => get_field('company_logo', $post->ID)['url'],
			// 		'company_logo_alt' => get_field('company_logo', $post->ID)['alt'],
			// 		'url' => get_the_permalink($post->ID),
			// 		'blurb' => get_field('blurb', $post->ID),
			// 		'key_outcomes' => get_field('key_outcomes', $post->ID),
			// 		'overview' => get_field('overview', $post->ID),
			// 		'company_facts' => get_field('company_facts', $post->ID),
			// 	);

			// }
			
			$id = 2541;

			$personas_catch = get_field('resources_auxiliary_fields_and_data', $id)['persona_repeater'];
			$initiative_catch = get_field('resources_auxiliary_fields_and_data', $id)['initiative_repeater'];


				$final_personas = [];
				foreach ($personas_catch as $persona):

					$final_personas[] = str_replace(' ', '_', strtolower($persona['persona_catch']));

				endforeach;
				
				$final_initiatives = [];
				foreach ($personas_catch as $persona):

					$final_personas[] = str_replace(' ', '_', strtolower($persona['persona_catch']));

				endforeach;


			$gated_fields_update = array(
				'persona' => $final_personas
				
			);

			update_field('gated_details', $gated_fields_update, $id);

			$personas_default = get_field('gated_details', $id)['persona'];
			

			$all_fields = get_fields($id);

			//update_field('gated_details', $id)['persona'];

			// foreach($personas_catch as $persona) :

			// 	update_field('display_contact_form', 0, $id);

			// endforeach;

			echo '<pre>';
            print_r($personas_default);
			echo '</pre>';

			echo '<pre>';
           // print_r($all_fields);
			echo '</pre>';


	


		//print_r($terms);
			
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();


