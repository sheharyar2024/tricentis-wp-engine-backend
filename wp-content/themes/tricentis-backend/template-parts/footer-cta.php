<?php
/**
 * Please note that there is logic to the display of this module in inc/automatic/module-footer-cta.php
 */
$module = 'footer_cta';
include( get_template_directory().'/partials/module-begin.php' );
?>
<div class="footer-cta">
	<div class="container-lg">
		<div class="row">
			<div class="col col-12 col-md-6">
				<?php TricentisBackendSEOTextField::display(); ?>
			</div>
			<div class="col col-12 col-md-6">
				<?php TricentisBackendActionGroupField::display(); ?>
			</div>
		</div>
	</div>
</div>
<?php
include( get_template_directory().'/partials/module-end.php' );