<?php
/**
 * FIX - Fatal error: Uncaught Exception: Supplied nav_menu_item value missing property: description in /Users/abd/Local Sites/tricentis-be/app/public/wp-includes/customize/class-wp-customize-nav-menu-item-setting.php
 */
add_filter('wp_get_nav_menu_items', 'my_wp_get_nav_menu_items', 10, 3);
function my_wp_get_nav_menu_items($items, $menu, $args) {
    foreach($items as $key => $item)
        $items[$key]->description = '';

    return $items;
}


function remove_editor_from_post()
{
    global $post;

    if( ! is_a($post, 'WP_Post') ) {
        return;
    }

    remove_post_type_support('post', 'editor');
}

add_action('admin_enqueue_scripts', 'remove_editor_from_post');

/*
add_action( 'admin_init', 'update_post_meta_values' );

function update_post_meta_values()
{
    //$current_user = wp_get_current_user();
    //if(isset($_GET['update_acf']) && $_GET['update_acf'] == 1&& $current_user->exists() && $current_user->user_email == 'it@narwhal.digital'):
    if(isset($_GET['update_acf']) && $_GET['update_acf'] == 1 && is_user_logged_in()):

        $post = 'post';
        if(isset($_GET['post_type']) && !empty($_GET['post_type'])){
            $post = $_GET['post_type'];
        }
        
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => $post,
        );

        // The Query
        $the_query = new WP_Query( $args );
        
        // The Loop
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $post_id = get_the_ID();
                $title = get_the_title();
                //echo '<div>' . get_the_ID() . get_the_title() . '</div>';

                update_post_meta( $post_id, 'resource_section_background_type', 'pattern');
                update_post_meta( $post_id, '_resource_section_background_type', 'field_629142a8f5dbb_field_62a3c58b03a44_field_62b0b9baa3069');

                update_post_meta( $post_id, 'resource_section_background_pattern', 'tricentis_blue_pattern');
                update_post_meta( $post_id, '_resource_section_background_pattern', 'field_629142a8f5dbb_field_62a3c58b03a44_field_62b0b9baa3076');
                              
            }
        }
    endif;
    // Restore original Post Data 
    wp_reset_postdata();

}
*/
/*
add_action( 'admin_init', 'update_post_meta_values' );

function update_post_meta_values()
{
    //$current_user = wp_get_current_user();
    //if(isset($_GET['update_acf']) && $_GET['update_acf'] == 1&& $current_user->exists() && $current_user->user_email == 'it@narwhal.digital'):
    if(isset($_GET['update_acf']) && $_GET['update_acf'] == 1 && is_user_logged_in()):

        $post = 'post';
        if(isset($_GET['post_type']) && !empty($_GET['post_type'])){
            $post = $_GET['post_type'];
        }
        
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => $post,
        );

        // The Query
        $the_query = new WP_Query( $args );
        
        // The Loop
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $post_id = get_the_ID();
                $title = get_the_title();
                //echo '<div>' . get_the_ID() . get_the_title() . '</div>';
                if($post != 'resource'){
                    if( ! get_post_meta( $post_id, 'hero_minimal_background_type', true ) &&  isset($_GET['bg_acf']) && $_GET['bg_acf'] == 1 ) {

                        update_post_meta( $post_id, 'hero_minimal_background_type', 'pattern');
                        update_post_meta( $post_id, '_hero_minimal_background_type', 'field_62695cff46417_field_62601a86982c2_field_625b43893e82f');

                        //blaze_pattern for blog post and tricentis_blue_pattern for pages
                        update_post_meta( $post_id, 'hero_minimal_background_pattern', 'blaze_pattern');
                        if($post == 'post'){
                            update_post_meta( $post_id, 'hero_minimal_background_pattern', 'blaze_pattern');
                        }else{
                            update_post_meta( $post_id, 'hero_minimal_background_pattern', 'tricentis_blue_pattern');
                        }
                        update_post_meta( $post_id, '_hero_minimal_background_pattern', 'field_62695cff46417_field_62601a86982c2_field_625ea4ebaef73');
                    }
                    if( ! get_post_meta( $post_id, 'hero_type', true ) &&  isset($_GET['title_acf']) && $_GET['title_acf'] == 1) {

                        update_post_meta( $post_id, 'hero_type', 'minimal');
                        update_post_meta( $post_id, '_hero_type', 'field_62695c0221586');

                        update_post_meta( $post_id, 'hero_minimal_title_text', $title);
                        update_post_meta( $post_id, '_hero_minimal_title_text', 'field_62695cff46417_field_62d97bc21069f_field_5e442501341a1');
                    }
                }else if($post == 'resource'){
                    if( ! get_post_meta( $post_id, 'header_background_type', true ) &&  isset($_GET['bg_acf']) && $_GET['bg_acf'] == 1 ) {
                        
                        update_post_meta( $post_id, 'header_background_type', 'pattern');
                        update_post_meta( $post_id, '_header_background_type', 'field_62f6b8e9fed86_field_625e9906a42b0');

                        update_post_meta( $post_id, 'header_background_pattern', 'tricentis_blue_pattern');
                        update_post_meta( $post_id, '_header_background_pattern', 'field_62f6b8e9fed86_field_625e9906a42b5');

                    }
                    if( ! get_post_meta( $post_id, 'header_prehead_text', true ) &&  isset($_GET['title_acf']) && $_GET['title_acf'] == 1) {

                        update_post_meta( $post_id, 'header_prehead_text', $title);
                        update_post_meta( $post_id, '_header_prehead_text', 'field_62f6b8801b01a_field_5e442501341a1');
                    }

                }                
            }
        }
    endif;
    // Restore original Post Data 
    wp_reset_postdata();

}
*/
