<?php 
$icon = get_sub_field( 'icon' );
echo wp_get_attachment_image( $icon['ID'], 'small' );