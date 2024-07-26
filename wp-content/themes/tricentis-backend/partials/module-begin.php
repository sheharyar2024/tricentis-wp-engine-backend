<?php
/**
 * This template contains logic for features common to every module such as background and padding handling
 * The acf fields are handled below, but a module could set specific settings by passing the module_settings array in the correct format
 * For example the footer cta module could set specific padding and not allow admin control
 */

if( !isset( $module_classes ) ){
	$module_classes = [
		'module',
		"module--{$module}",
	];
}

if( !isset( $module_settings ) ){
	$module_settings = [];
}

$module_settings += [
	/**
	 * Define background related classes - appearance tab
	 */
	'background' => get_sub_field( 'background_options' ),

	/**
	 * Define padding related classes - appearance tab
	 */
	'padding' => get_sub_field( 'padding' ),

	/**
	 * Developer tab options
	 */
	'id' => get_sub_field( 'anchor' ),
	'additional_classes' => esc_attr( get_sub_field( 'additional_classes' ) ),
];
extract( $module_settings );

//map background choices into module classes
$module_classes[] = TricentisBackendBackgroundOptionsField::classes();

//map padding choices into module classes
if( is_array( $padding ) ){
	$padding_top = $padding['top'];
	if( '' == $padding_top ){
		$padding_top = 'default';
	}
	$padding_bottom = $padding['bottom'];
	if( '' == $padding_bottom ){
		$padding_bottom = 'default';
	}

	$module_classes[] = 'padding';
	$module_classes[] = "padding--top-{$padding_top}";
	$module_classes[] = "padding--bottom-{$padding_bottom}";
}

if( '' !== $id ){
	$id = "id='{$id}'";
}

$module_classes[] = $additional_classes;

$classes = implode( ' ', $module_classes );

echo "<div {$id} class='{$classes}'>";

TricentisBackendBackgroundOptionsField::display();
