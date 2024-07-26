<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package TRICENTIS_BACKEND
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'no-js' ); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'tricentis-backend' ); ?></a>

	<?php
		//this action will not work in another acf module scope unless you use the build action first
		//Look in the TricentisBackendAlert for more information
		do_action( 'tricentis-backend/alert/display' );
	?>

	<header id="masthead" class="site-header">
		<div class="container-lg">
			<div class="row">
				<div class="col">
					<div class="site-branding">
						<?php
						the_custom_logo();
						if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
						else :
							?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
						endif;
						$tricentis_backend_description = get_bloginfo( 'description', 'display' );
						if ( $tricentis_backend_description || is_customize_preview() ) :
							?>
							<p class="site-description"><?php echo $tricentis_backend_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>
					</div><!-- .site-branding -->
				</div>
				<div class="col d-flex justify-content-end">
					<nav id="site-navigation" class="main-navigation">
						<button class="menu-toggle d-md-none" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'tricentis-backend' ); ?></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
						?>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">

		<?php do_action( 'tricentis-backend/hero/display' ); ?>