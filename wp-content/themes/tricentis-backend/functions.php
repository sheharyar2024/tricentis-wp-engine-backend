<?php
/**
 * Tricentis Backendfunctions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package TRICENTIS_BACKEND
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Make sure ACF is activated
 */
if( !is_admin() && !function_exists( 'get_field' ) ){
	add_filter( 'wp_php_error_message', function( $message ){
		return 'Please activate Advanced Custom Fields to use this theme.';
	} );
	@trigger_error( "ACF not activated.", E_USER_ERROR );
	die;
}

if ( ! function_exists( 'tricentis_backend_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tricentis_backend_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Narwhal Boilerplate, use a find and replace
		 * to change 'tricentis-backend' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tricentis-backend', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'product-megamenu' => esc_html__( 'Product Mega Menu', 'tricentis-backend' ),
				'solutions-megamenu' => esc_html__( 'Solutions Mega Menu', 'tricentis-backend' ),
				'service-megamenu' => esc_html__( 'Services Mega Menu', 'tricentis-backend' ),
				'resources-megamenu' => esc_html__( 'Resources Mega Menu', 'tricentis-backend' ),
				'pricing-megamenu' => esc_html__( 'Pricing Mega Menu', 'tricentis-backend' ),
				'main-menu' => esc_html__( 'Primary', 'tricentis-backend' ),
				'top-menu' => esc_html__( 'Top Menu', 'tricentis-backend' ),
				'footer-menu' => esc_html__( 'Footer Menu', 'tricentis-backend' ),
				'secondary-footer-menu' => esc_html__( 'Secondary Footer Menu', 'tricentis-backend' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'tricentis_backend_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);

		
		//Disable Gutenberg Completely and use classic editor
		add_filter('use_block_editor_for_post', '__return_false', 10);
		add_filter('use_block_editor_for_post_type', '__return_false', 10);

	}
endif;
add_action( 'after_setup_theme', 'tricentis_backend_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tricentis_backend_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'tricentis_backend_content_width', 1080 );
}
add_action( 'after_setup_theme', 'tricentis_backend_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tricentis_backend_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'tricentis-backend' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'tricentis-backend' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
//add_action( 'widgets_init', 'tricentis_backend_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tricentis_backend_scripts() {
	//we don't need the block editor css
	wp_dequeue_style( 'wp-block-library' );

	$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

	if ( apply_filters( 'use_build_assets', strstr( $url, '.local' ) ) ) {
		// all local development and armyofbees.net
		$root_url = get_template_directory_uri() . '/assets/build/';
		$root_path = get_template_directory() . '/assets/build/';
		$min = '';
	} else {
		//all pantheon and production
		$root_url = get_template_directory_uri() . '/assets/dist/';
		$root_path = get_template_directory() . '/assets/dist/';
		$min = '.min';
	}
	//wp_enqueue_style ( 'tricentis-backend-style', $root_url . 'style' . $min . '.css',  array(), filemtime( $root_path . 'style' . $min . '.css' ) );
	$css = $root_url . 'style' . $min . '.css?'.filemtime( $root_path . 'style' . $min . '.css' );
	echo '<link rel="preload" as="style" href="'.$css.'" onload="this.rel=\'stylesheet\'">';

	wp_enqueue_script( 'tricentis-backend-vendor-js', $root_url.'vendor_scripts'.$min.'.js', array('jquery'), filemtime( $root_path.'vendor_scripts'.$min.'.js' ), true );
	wp_enqueue_script( 'tricentis-backend-app-js', $root_url.'app_scripts'.$min.'.js', array( 'tricentis-backend-vendor-js' ), filemtime( $root_path.'app_scripts'.$min.'.js' ), true );

	wp_localize_script( 'tricentis-backend-app-js', 'TricentisBackend', [
		'ajax' => admin_url( 'admin-ajax.php' ),
	] );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tricentis_backend_scripts' );

function tricentis_backend_admin_scripts() {
	$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

	if ( apply_filters( 'use_build_assets', strstr( $url, '.local' ) ) ) {
		// all local development and armyofbees.net
		$root_url = get_template_directory_uri() . '/assets/build/';
		$root_path = get_template_directory() . '/assets/build/';
		$min = '';
	} else {
		//all pantheon and production
		$root_url = get_template_directory_uri() . '/assets/dist/';
		$root_path = get_template_directory() . '/assets/dist/';
		$min = '.min';
	}

	wp_enqueue_style( 'tricentis-backend-admin-style', $root_url . 'admin' . $min . '.css',  array(), filemtime( $root_path . 'admin' . $min . '.css' ) );
	wp_enqueue_script( 'tricentis-backend-admin-script', $root_url . 'admin_scripts' . $min . '.js', array("jquery"), filemtime( $root_path . 'admin_scripts' . $min . '.js' ) );
}
add_action( 'admin_enqueue_scripts', 'tricentis_backend_admin_scripts' );

/**
 * Functionality to visualy hide the Default Template from the Page post type
 * the option element is hardcoded by WP in this function meta-boxes.php:page_attributes_meta_box()
 */
add_action('admin_head', 'tricentis_custom_admin_css');
function tricentis_custom_admin_css() {
  echo '<style>
  .postbox select#page_template option[value=default] {
	display: none;
  }
  </style>';
}

/**
 * Functionality to set a new default template for "Add new page" action
 */
function set_default_page_template() {
    global $post;

    if (
		'page' == $post->post_type
		// Uncomment if needed
        // && 0 != count(get_page_templates($post))
        // && get_option('page_for_posts') != $post->ID // Not the page for listing posts
        && '' == $post->page_template // Only when page_template is not set
    ) {
        $post->page_template = "templates/modules.php";
    }
}
add_action('add_meta_boxes', 'set_default_page_template', 1);

/**
 * Automatically loaded theme features
 * If adding a new feature that should always be on, just drop the file into the directory below.
 * If your feature needs special priority, you may want to include it separately as this is not loaded in specific order
 */
$iterator = new RecursiveDirectoryIterator( __DIR__ . '/inc/automatic' );
foreach ( new RecursiveIteratorIterator( $iterator ) as $file ) {
	if ( $file->getExtension() === 'php' ) {
		require $file;
	}
}

add_filter( 'wpseo_schema_person', 'schema_change_person', 11, 2 );

/**
 * Changes the Yoast SEO Person schema.
 *
 * @param array             $data    The Schema Person data.
 * @param Meta_Tags_Context $context Context value object.
 *
 * @return array $data The Schema Person data.
 */
function schema_change_person( $data, $context ) {
	$personName = 'Tricentis Team';
	if (isset($data['name'])) {
		$data['name'] = $personName;
	}
	if (isset($data['image']) && isset($data['image']['caption'])) {
		$data['image']['caption'] = $personName;
	}

    return $data;
}

add_filter( 'wpseo_enhanced_slack_data', 'wp_kama_wpseo_opengraph_author_facebook_filter', 10, 2 );
function wp_kama_wpseo_opengraph_author_facebook_filter( $data, $presentation ){
	$personName = 'Tricentis Team';
	if (isset($data['Written by'])) {
		$data['Written by'] = $personName;
	}

	return $data;
}

/*
Scripts to limit taxonomy choice to only one
*/

add_action( 'init', 'register_resource_type_taxonomy' );
function register_resource_type_taxonomy() {

	$enable_editing_for_resource_types = get_field('enable_editing_for_resource_types', 'options');

	switch($enable_editing_for_resource_types) {
		case 1:
			$role_slug = 'administrator';
		break;
		default:
			$role_slug = 'administrator';
		break;
	}

	$args = array(
		'label'             => __( 'Resource Type' ),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		//'meta_box_cb'       => 'resource_type_meta_box', // see callback function below
		'show_in_graphql' => true,
		'show_in_rest' => true,
		'graphql_single_name' => 'resourceType',
		'graphql_plural_name' => 'resourceTypes',
		'capabilities'      => array(
			'assign_terms' => $role_slug,
			'edit_terms'   => $role_slug,
			'manage_terms' => $role_slug,
		),
	);

	$post_types_to_populate = array(
		'resource', 
		//'post'
		//'case_study'
	);

	register_taxonomy( 'resource_type', $post_types_to_populate, $args );
}

//callback function for meta_box_cb declaration above, limits selection to only one.
function resource_type_meta_box( $post ) {
	$terms = get_terms( 'resource_type', array( 'hide_empty' => false ) );

	$post  = get_post();
	$types = wp_get_object_terms( $post->ID, 'resource_type', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
	$name  = '';

    if ( ! is_wp_error( $rating ) ) {
    	if ( isset( $types[0] ) && isset( $types[0]->name ) ) {
			$name = $types[0]->name;
	    }
    }
	echo '<select name="resource_type">';
	foreach ( $terms as $term ) {
?>		   
			<option <?php selected( $term->name, $name ); ?>  value="<?php esc_attr_e( $term->name ); ?>"><?php echo $term->name ?></option>			
<?php
    }
	echo '</select>';
}

// custom script to save the "single only" taxonomy
add_action( 'save_post_resource', 'save_resource_type_meta_box' );
function save_resource_type_meta_box( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['resource_type'] ) ) {
		return;
	}

	$types = sanitize_text_field( $_POST['resource_type'] );
	
	// Validation
	if ( empty( $types ) ) {
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post_resource', 'save_resource_type_meta_box' );

		$postdata = array(
			'ID'          => $post_id,
			'post_status' => 'draft',
		);
		wp_update_post( $postdata );
	} else {
		$term = get_term_by( 'name', $types, 'resource_type' );
		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			wp_set_object_terms( $post_id, $term->term_id, 'resource_type', false );
		}
	}
}


function mass_update_posts() {

	// script for matching branch offices to their IDs, just in case
	// $args_branch = array(
	// 	'numberposts' => -1,
	// 	'post_type'   => 'branch_office'
	//   );
	   
	//   $branch_offices = get_posts( $args_branch );
	
	//   $branch_office_ids_array = [];
	
	// foreach ($branch_offices as $office) :
	
	// 	$branch_office_ids_array[] = array(
	// 		'office' => $office->post_title,
	// 		'ID' => $office->ID
	// 	);
	
	// endforeach;
 
		
	$args = array(	'post_type'=> 'loan_officer', //whatever post type you need to update 
					'name' => 'tracy-covarrubias', 
					//'p' => 2290,
					'posts_per_page'   => -1);
		
	$my_posts = get_posts($args);
	
	foreach($my_posts as $key => $my_post){

		$meta_values = get_post_meta( $my_post->ID);
		foreach($meta_values as $meta_key => $meta_value ){

			//$city_catch = get_field('city_catch', $my_post->ID);

			// $personal_state_array = get_field('state', $my_post->ID);
			// update_field('state_supplemental_dropdown', $personal_state_array['label'], $my_post->ID);
			
			
			//update_field('home_office', $branch_id_final, $my_post->ID);
			//update_field('hero', $featured_image_array_updates, $my_post->ID);
			// update_field('display_resources', 1, $my_post->ID);
			//update_field('related_resources', $related_resources_array_updates, $my_post->ID);

			// update_field('display_cta', 1, $my_post->ID);
			// update_field('cta', $cta_array_updates, $my_post->ID);
			// update_field('footer_cta_settings', 'off', $my_post->ID);

			//update_field('display_types_of_loans_tabber', 1, $my_post->ID);
			//update_field('types_of_loans_tabber', $types_of_loans_tabber_array, $my_post->ID);

			// update_field('display_contact_form', 0, $my_post->ID);
			// update_field('display_awards', 0, $my_post->ID);
			// update_field('display_scroller', 0, $my_post->ID);
			// update_field('display_icon_grid', 0, $my_post->ID);

			// $persona_catch = get_field('')


			
			$title = get_the_title($my_post->ID);

			// Yoast SEO Field updates
			update_post_meta($my_post->ID, '_yoast_wpseo_focuskw', $title);
			update_post_meta($my_post->ID, '_yoast_wpseo_metadesc', $metadesc_loanofficer);
			


		}
	}
}
//add_action( 'init', 'mass_update_posts' );


// if we want to add deep links to each resource type into the admin menu, uncomment this function's code.
add_action('admin_menu', 'add_custom_link_into_appearnace_menu');
function add_custom_link_into_appearnace_menu() {
		// global $submenu;

		// $permalink = 'edit.php?post_type=resource&resource_type=articles';
		
		// $terms = get_terms( 'resource_type', array(
		// 	'hide_empty' => false,
		// ) );

		// foreach ($terms as $term) :
		// 	$submenu['edit.php?post_type=resource'][] = array( '• ' . $term->name, 'manage_options', 'edit.php?post_type=resource&resource_type='.$term->slug );
		// endforeach;

	}

/*
Registering custom endpoints for marketo:
See /inc/automatic/rest-endpoints.php
*/

/**
 * Load cron/task Helper
 */
 //require get_template_directory() . '/inc/optional/tasks.php';

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/optional/custom-header.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/optional/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/optional/jetpack.php';
}