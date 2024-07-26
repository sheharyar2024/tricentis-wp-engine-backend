<?php
/**
 * Please note that there is logic to the display of this module in inc/automatic/module-alert.php
 */
?>
<div class="alert">
	<div class="container-lg">
		<div class="row">
			<div class="col">
				<?php
				the_sub_field( 'message' );
				TricentisBackendActionGroupField::display();
				?>
			</div>
		</div>
	</div>
</div>
