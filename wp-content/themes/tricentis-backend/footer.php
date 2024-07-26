<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package TRICENTIS_BACKEND
 */

?>

	<?php do_action( 'tricentis-backend/footer-cta/display' ); ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container-lg">
			<div class="row">
				<div class="col d-flex justify-content-center">
					<div class="site-info">
						<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'tricentis-backend' ) ); ?>">
							<?php
							/* translators: %s: CMS name, i.e. WordPress. */
							printf( esc_html__( 'Proudly powered by %s', 'tricentis-backend' ), 'WordPress' );
							?>
						</a>
						<span class="sep"> | </span>
						<?php
						/* translators: 1: Theme name, 2: Theme author. */
						printf( esc_html__( 'Theme: %1$s by %2$s.', 'tricentis-backend' ), 'tricentis-backend', '<a href="https://narwhal.digital/">Narwhal Digital</a>' );
						?>
					</div><!-- .site-info -->
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
