<?php

/**
 * Google tag manager code
 * Hooks into wp head and wp body actions for display.  wp_head should always work, but wp_open_body in header.php is also important
 */
new TricentisBackendGoogleTagManager();

class TricentisBackendGoogleTagManager{

	protected $id = 'GTM-XXXXXXX';

	function __construct(){
		if( 'GTM-XXXXXXX' == $this->id ){
			return;
		}
		add_action( 'wp_head', [ $this, 'head' ] );
		add_action( 'wp_body_open', [ $this, 'body' ] );
	}

	/**
	 * Add opening tag, this is also where you might want to prepopulate the data layer
	 */
	function head(){
?>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $this->id; ?>');</script>
<!-- End Google Tag Manager -->

<?php
	}

	/**
	 * Add body tracking code
	 */
	function body(){
?>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $this->id; ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php
	}
}
