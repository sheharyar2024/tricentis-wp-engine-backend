<?php

new TricentisBackendAdvancedCustomFields();

/**
 * Class to keep track of hooks and filters tied into ACF plugin
 */

class TricentisBackendAdvancedCustomFields{

	function __construct(){
		add_action( 'acf/init', [ $this, '_options_page' ] );
		add_action( 'acf/load_field/name=gravity_form', [ $this, '_populate_gravity_form_options' ] );
		add_action( 'acf/fields/flexible_content/layout_title', [ $this, 'layout_title' ], 10, 4 );
		//add_filter( 'teeny_mce_buttons', [ $this, '_adjust_basic_toolbar' ], 100, 2 );	//acfpro/includes/fields/class-acf-field-wysiwyg.php
		//add_filter( 'acf/fields/wysiwyg/toolbars', [ $this, '_custom_toolbar' ] );	//acfpro/includes/fields/class-acf-field-wysiwyg.php

		//setting defaults for reused modular fields
		add_action( 'acf/load_field/name=hero', [ $this, 'modular_defaults' ] );
		add_action( 'acf/load_field/name=related_resources', [ $this, 'modular_defaults' ] );
		add_action( 'acf/load_field/name=key_outcomes', [ $this, 'modular_defaults' ] );
	}

	function _options_page(){

		acf_add_options_page(array(
			'page_title' 	=> 'Theme General Settings',
			'menu_title'	=> 'Theme Settings',
			'menu_slug' 	=> 'theme-general-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'show_in_graphql' => true,
		));

		/*acf_add_options_sub_page(array(
			'page_title' 	=> 'Resources',
			'menu_title'	=> 'Resources',
			'menu_slug' 	=> 'resources-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'show_in_graphql' => true,
			'parent_slug' => 'theme-general-settings',
		));*/

		acf_add_options_sub_page(array(
			'page_title' 	=> '404 Page Content',
			'menu_title'	=> '404 Page',
			'menu_slug' 	=> 'options-404-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'show_in_graphql' => true,
			'parent_slug' => 'theme-general-settings',
		));

		/*acf_add_options_sub_page(array(
			'page_title' 	=> 'Developer Settings',
			'menu_title'	=> 'Developer',
			'menu_slug' 	=> 'developer-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'show_in_graphql' => true,
			'parent_slug' => 'theme-general-settings',
		));*/

		acf_add_options_sub_page(array(
			'page_title' 	=> 'Marketo Settings',
			'menu_title'	=> 'Marketo',
			'menu_slug' 	=> 'marketo-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'show_in_graphql' => true,
			'parent_slug' => 'theme-general-settings',
		));

		acf_add_options_sub_page(array(
			'page_title' 	=> 'Plugin Settings',
			'menu_title'	=> 'Plugin Settings',
			'menu_slug' 	=> 'plugin-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'show_in_graphql' => true,
			'parent_slug' => 'theme-general-settings',
		));

	}

	/**
	 * Unwrap base field
	 */
	function modular_defaults( $field ){
		$this->post_type = get_post_type();
		$this->post_type_obj = get_post_type_object( $this->post_type );

		if( isset( $field['sub_fields'] ) ){
			$this->_recurse_subfields( $field );
		}

		return $field;
	}

	/**
	 * Unwrap sub fields and pass through a setting function
	 */
	function _recurse_subfields( &$field ){
		foreach( $field['sub_fields'] as &$subfield ){
			$this->_set_field_default( $subfield );
			if( isset( $subfield['sub_fields'] ) ){
				$this->_recurse_subfields( $subfield );
			}
		}
	}

	/**
	 * General setting function for defaults, pass to post specific handler
	 */
	function _set_field_default( &$field ){
		if( !isset( $field['default_value'] ) ){
			$field['default_value'] = '';
		}

		switch( $field['name'] ){
			case 'media_media_type':
				//this clone is based off original fields to set header to something that won't generate hidden errors on automatic save
				if( isset( $field['_clone'] ) && $field['_clone'] === 'field_602fedd46db27' ){
					$field['default_value'] = 'post_image';
				}
			break;
			case 'related_resources_allow_featured':
				$field['default_value'] = 0;
			break;
			case 'related_resources_allowed_types':
				$field['default_value'] = [ $this->post_type ];
			break;
			case 'related_resources_cta':
				$resources_url = get_field( 'resources_page', 'options' );
				$field['default_value'] = [
					'url' => add_query_arg( 'type', $this->post_type, $resources_url ) . '#ResourceArchive',
					'title' => sprintf( __( 'See All %s', 'tricentis-backend' ), $this->post_type_obj->labels->name ),
				];
			break;
			case 'title_text':	//note that this is clone specific since the seo title field is used a lot
			break;
			case 'title_type':	//note that this is clone specific since the seo title field is used a lot
			break;
		}

		$field['default_value'] = apply_filters( "tricentis-backend/modules/{$this->post_type}/default-value", $field['default_value'], $field );
	}

	/**
	 * Add options to gravity form select
	 * https://docs.gravityforms.com/api-functions/#get-forms
	 */
	function _populate_gravity_form_options( $field ){
		if( !class_exists( 'GFAPI' ) ){
			return $field;
		}

		$forms = GFAPI::get_forms( true, false );

		foreach( $forms as $form ){
			$field['choices'][$form['id']] = $form['title'];
		}

		return $field;
	}

	/**
	 * Alter buttons on existing basic toolbar
	 * advanced-custom-fields-pro/includes/fields/class-acf-field-wysiwyg.php::get_toolbars
	 */
	function _adjust_basic_toolbar( $buttons, $editor_id ){

		$buttons = array(
			'bold',
			'italic',
			'underline',
			'blockquote',
			'strikethrough',
			'bullist',
			'numlist',
			'alignleft',
			'aligncenter',
			'alignright',
			'undo',
			'redo',
			'link',
			'fullscreen',
		);

		return $buttons;
	}

	/**
	 * Custom toolbar example
	 * advanced-custom-fields-pro/includes/fields/class-acf-field-wysiwyg.php::get_toolbars
	 */
	function _custom_toolbar( $toolbars ){

		$buttons = array(
			'bold',
			'italic',
			'underline',
			'blockquote',
			'strikethrough',
			'bullist',
			'numlist',
			'alignleft',
			'aligncenter',
			'alignright',
			'undo',
			'redo',
			'link',
			'fullscreen',
		);

		$toolbars['Custom'] = array(
			1 => $buttons
		);

		return $toolbars;
	}

	/**
	 * Add more information to module in admin screen for more UX
	 * thumbnail image and module specific title for identification
	 */
	function layout_title( $title, $field, $layout, $i ){

		$ret = [
			'<div class="acf-nw-title">',
		];

		//add in any thumbnail image of this module
		if( file_exists( get_template_directory( ) . "/assets/img/modules/{$layout['name']}-thumbnail.png" ) ){
			$image = get_template_directory_uri() . "/assets/img/modules/{$layout['name']}-thumbnail.png";
			$ret[] = "<div class=\"acf-nw-title-thumbnail\"><div class=\"acf-nw-title-thumbnail-wrap\"><img src=\"{$image}\"></div></div>";
		}

		//standard title from ACF
		$ret[] = '<div class="acf-nw-title-general">'.$title.'</div>';

		//bring in heading field if present - this may depend on module specific instruction
		if( '' != ( $module_title = get_sub_field( 'title' ) ) ){
			if( '' != $module_title['text'] ){
				$ret[] = "<div class=\"acf-nw-title-specific\">{$module_title['text']}</div>";
			}
		}

		$ret[] = '</div>';

		return implode( "\n", $ret );
	}
}
