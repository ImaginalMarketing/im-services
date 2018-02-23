<?php
/*
Plugin Name: IM Services Manager
Plugin URI: https://github.com/ImaginalMarketing/im-services-manager/
Version: 2.0
Author: Michael Milstead
Description: A simple <em>Services</em> custom post type with categories and custom meta. Use the shortcode <code>[im-services item="sample-slug" category="sample-category" location="sample-location"]</code> to output basic tables with prices and descriptions. Tables can be targeted by any combination of a <code>#imst-sample-category</code> ID and <code>.im_service_table</code> class for easy CSS styling. Supports basic text descriptions for posts as well as categories. This plugin is currently dependent on the "Taxonomy Meta" Plugin which was included with this package.
GitHub Plugin URI: https://github.com/ImaginalMarketing/im-services-manager/

*/


require_once( 'BFIGitHubPluginUploader.php' );
if ( is_admin() ) {
    new BFIGitHubPluginUpdater( __FILE__, 'ImaginalMarketing', "im-services" );
}



///// A D D   C S S   T O   H E A D E R 
////////////////////////////

function wptuts_styles_with_the_lot()
{
    // Register the style like this for a plugin:
    wp_register_style( 'service-styles', plugins_url( '/css/styles.css', __FILE__ ), array(), '1.0', 'all' );
    // or
    // Register the style like this for a theme:
    //wp_register_style( 'service-styles', get_template_directory_uri() . '/css/styles.css', array(), '1.0', 'all' );
 
    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style( 'service-styles' );
}
add_action( 'wp_enqueue_scripts', 'wptuts_styles_with_the_lot' );

///// C U S T O M  A D M I N  F O R  A C F  T A B L E
////////////////////////////

function imservices_acf_styles() {
    wp_enqueue_style( 'admin-acf-styles', plugins_url( '/css/acf_styles.css', __FILE__ ), array(), '1.0', 'all' );
}
add_action('acf/input/admin_head', 'imservices_acf_styles');

function imservices_enqueue_scripts() {

    wp_enqueue_script( 'my-admin-js', plugins_url( '/js/acf_update.js', __FILE__ ), array(), '1.0.0', true );

}

add_action('acf/input/admin_enqueue_scripts', 'imservices_enqueue_scripts');


///// P O S T   T Y P E
///// + T A X O N O M Y
////////////////////////////


function services_post_type() {
	$labels = array(
		'name'                => _x( 'Services', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Service', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Services', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Service:', 'text_domain' ),
		'all_items'           => __( 'All Services', 'text_domain' ),
		'view_item'           => __( 'View Service', 'text_domain' ),
		'add_new_item'        => __( 'Add New Service', 'text_domain' ),
		'add_new'             => __( 'Add New Service', 'text_domain' ),
		'edit_item'           => __( 'Edit Service', 'text_domain' ),
		'update_item'         => __( 'Update Service', 'text_domain' ),
		'search_items'        => __( 'Search Services', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'service', 'text_domain' ),
		'description'         => __( 'Service and category management', 'text_domain' ),
		'labels'              => $labels,
		'menu_icon'           => 'dashicons-hammer',
		'supports'            => array( 'title', 'page-attributes' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
     	'exclude_from_search' => true
	);
	register_post_type( 'service', $args );
}
add_action( 'init', 'services_post_type', 0 );

// custom taxonomy
add_action( 'init', 'create_servecat_hierarchical_taxonomy', 0 );
function create_servecat_hierarchical_taxonomy() {
  $labels = array(
    'name' => _x( 'Service Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Service Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Service Categories' ),
    'all_items' => __( 'All Service Categories' ),
    'parent_item' => __( 'Parent Service Category' ),
    'parent_item_colon' => __( 'Parent Service Category:' ),
    'edit_item' => __( 'Edit Service Category' ), 
    'update_item' => __( 'Update Service Category' ),
    'add_new_item' => __( 'Add New Service Category' ),
    'new_item_name' => __( 'New Service Category Name' ),
    'menu_name' => __( 'Manage Service Categories' ),
  ); 	
  register_taxonomy('servicecategories',array('service'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'servicecategories' ),
  ));
}
// custom taxonomy
add_action( 'init', 'create_serveloc_hierarchical_taxonomy', 0 );
function create_serveloc_hierarchical_taxonomy() {
  $labels = array(
    'name' => _x( 'Shop Locations', 'taxonomy general name' ),
    'singular_name' => _x( 'Shop Location', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Shop Locations' ),
    'all_items' => __( 'All Shop Locations' ),
    'parent_item' => __( 'Parent Shop Location' ),
    'parent_item_colon' => __( 'Parent Shop Location:' ),
    'edit_item' => __( 'Edit Shop Location' ), 
    'update_item' => __( 'Update Shop Location' ),
    'add_new_item' => __( 'Add New Shop Location' ),
    'new_item_name' => __( 'New Shop Location Name' ),
    'menu_name' => __( 'Manage Shop Locations' ),
  ); 	
  register_taxonomy('servicelocations',array('service'), array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'servicelocations' ),
  ));
}


if(function_exists("register_field_group"))
{
///// ACF REPEATER TABLE FIELDS
register_field_group(array (
        'id' => 'acf_services',
        'title' => 'Services',
        'fields' => array (
            array (
                'key' => 'field_57ae1dae95d5c',
                'label' => 'Services',
                'name' => 'services',
                'type' => 'repeater',
                'sub_fields' => array (
                    array (
                        'key' => 'field_57ae268472278',
                        'label' => 'Subcategory Title',
                        'name' => 'serv_subcategory_title',
                        'type' => 'text',
                        'column_width' => 100,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_57ae26b072279',
                        'label' => 'Subcategory description',
                        'name' => 'serv_subcategory_description',
                        'type' => 'wysiwyg',
                        'column_width' => 100,
                        'default_value' => '',
                        'toolbar' => 'basic',
                        'media_upload' => 'no',
                    ),
                    array (
                        'key' => 'field_57ae26dd7227a',
                        'label' => 'Subcategory Services',
                        'name' => 'subcategory_services',
                        'type' => 'table',
                        'column_width' => 100,
                        'use_header' => 0,
                    ),
                    array (
                        'key' => 'field_591dd1c0c5caf',
                        'label' => 'Subcategory Disclaimer',
                        'name' => 'subcategory_disclaimer',
                        'type' => 'wysiwyg',
                        'column_width' => '',
                        'default_value' => '',
                        'toolbar' => 'full',
                        'media_upload' => 'yes',
                    ),
                ),
                'row_min' => 1,
                'row_limit' => '',
                'layout' => 'row',
                'button_label' => 'Add Service Subcategory',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'service',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
}
// Function to clean the title to use in ID for css purposes.
    function clean($string) {
       $string = str_replace(' ', '-', strtolower($string)); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
       return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
///// S H O R T C O D E
////////////////////////////
function wp_services_list($atts = [], $content = null, $tag = ''){
    // paramater to grab category id input from the user
    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    // override default attributes with user attributes
    $servicepage_atts = shortcode_atts([
        'category'  => NULL,
        'location'  => NULL,
        'item'      => NULL,
    ], $atts, $tag);

    $location = esc_html__($servicepage_atts['location'], 'im-services');
    $category = esc_html__($servicepage_atts['category'], 'im-services');
    $item = esc_html__($servicepage_atts['item'], 'im-services');
    // are there locations? if not, ignore that taxonomy or else you get blank tables
    if  (($item != NULL) && ($category != NULL)) {
        // gather posts into array
        $args = array(
            'post_type' => 'service',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'name' => $item,
            'tax_query'=>array(
                array('taxonomy'=>'servicecategories',
                        'field'=>'slug',
                        'terms'=>$category
                    )
                )
            );
    } elseif ($item != NULL) {
        // gather posts into array
        $args = array(
            'post_type' => 'service',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'name' => $item,
            );
    } elseif ($location != NULL) {
        // gather posts into array
        $args = array(
            'post_type' => 'service',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'tax_query'=>array(array('taxonomy'=>'servicelocations',
                        'field'=>'slug',
                        'terms'=>$location
                        ),
                        array('taxonomy'=>'servicecategories',
                        'field'=>'slug',
                        'terms'=>$category
                        ))
            );
    } else {
        // gather posts into array
        $args = array(
            'post_type' => 'service',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'tax_query'=>array(array('taxonomy'=>'servicecategories',
                        'field'=>'slug',
                        'terms'=>$category
                        ))
            );
    }
    $postArray = get_posts( $args );
    // echo '<pre>';
    // print_r($postArray);
    // echo '</pre>';
    // get current category
    $getservices = query_posts(array('post_type' => 'service', 'taxonomy' => 'servicecategories', 'term' => $category, 'orderby' => 'menu_order', 'order' => 'ASC','posts_per_page' => -1));
    global $post;
    foreach ($getservices as $post) {
        $terms = get_the_terms( $post->ID, 'servicecategories' ) ;
        if ( $terms && ! is_wp_error( $terms ) ) : 
            $service_cats = array();
            foreach ( $terms as $term ) {
                $service_category['name'] = $term->name;
                $service_category['description'] = $term->description;
                $service_category['id'] = $term->term_id;
            }
        endif;
    }

    // let's start displaying stuff
    // $num_col will help count the columns and add blank cells in case different items have a different number of levels
    // check if the repeater field has rows of data
   ob_start(); //Turn on output buffering
   
foreach($postArray as $post) {
     
    $post_title = get_the_title($post->ID);
    echo '<div id="im_service_table-'.clean($post_title).'">';
    if( have_rows('services') ):
        // loop through the rows of data
        while ( have_rows('services') ) : the_row(); 
            if(get_sub_field('serv_subcategory_title')) {
                $cat_title = get_sub_field('serv_subcategory_title');
            } else {
                $cat_title = get_the_title($post->ID);
            };
            echo '<div id="services_'. clean($cat_title) .'" class="serv_wrapper">';
        if(get_sub_field('serv_subcategory_title')) : echo '<h3 class="im-services-subhead">'; the_sub_field('serv_subcategory_title'); echo '</h3>'; else: endif; 

         if(get_sub_field('serv_subcategory_description')) : echo '<div class="serv_subcat_desc">'; the_sub_field('serv_subcategory_description'); echo '</div>'; else: endif; 
            
            $table = get_sub_field( 'subcategory_services' );

            if ( $table ) {

            
            if ( $table['header'] ) {
                echo '<table class="im-services hide-for-medium service_levels '; echo clean($cat_title); echo '" border="0">';
                if ( $table['header'] ) {
                    $header = array();
                    foreach ( $table['header'] as $th ) {
                            $header[] = $th['c'];
                    }
                }

                echo '<tbody>';

                    foreach ( $table['body'] as $tr ) {

                            // determine colspan for descriptions
                            $count = 0;
                            $col = count($tr);
                            $items = array();
                            foreach ( $tr as $td ) {
                                $items[] = $td['c'];
                                // detect description per modifier
                                if (substr( $td['c'], 0, 2 ) === "++") {
                                    $description = substr($td['c'], 2);
                                    echo '<tr>';
                                    echo '<td class="serv-desc" colspan="2">';
                                        echo $description;
                                    echo '</td>';
                                    echo '</tr>';
                                    break;
                                } elseif ($count == 0) {
                                    echo '<tr>';
                                    echo '<td class="serv-title" colspan="2">';
                                        echo $items[$count];
                                    echo '</td>';
                                    echo '</tr>';
                                } else {
                                    echo '<tr>';
                                    echo '<td class="serv-header">';
                                        echo $header[$count];
                                    echo '</td>';
                                    echo '<td class="serv-price">';
                                        echo $items[$count];
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                $count++;
                            }
                    }

                echo '</tbody>';
            echo '</table>';
            echo '<table class="im-services show-for-medium service_levels '; echo clean($cat_title); echo '" border="0">';

                if ( $table['header'] ) {

                    echo '<thead>';

                        echo '<tr>';

                            foreach ( $table['header'] as $th ) {

                                echo '<th>';
                                    echo $th['c'];
                                echo '</th>';
                            }

                        echo '</tr>';

                    echo '</thead>';
                }

                echo '<tbody>';

                    foreach ( $table['body'] as $tr ) {

                        echo '<tr>';

                            // determine colspan for descriptions
                            $col = count($tr);
                            $i = 1;
                            foreach ( $tr as $td ) {

                                if($i == 1) {
                                    $td_class = 'serv-title';
                                } else { $td_class = 'serv-price'; }
                                // detect description per modifier
                                if (substr( $td['c'], 0, 2 ) === "++") {
                                    $description = substr($td['c'], 2);
                                    echo '<td class="serv-col serv-desc" colspan="'.$col.'">';
                                        echo $description;
                                    echo '</td>';
                                    break;
                                } else {
                                    echo '<td class="serv-col '.$td_class.'">';
                                        echo $td['c'];
                                    echo '</td>';
                                }
                                $i++;
                            }

                        echo '</tr>';
                    }

                echo '</tbody>';

            echo '</table>';
        } else {
            echo '<table class="im-services '; echo clean($cat_title); echo '" border="0">';
                echo '<tbody>';

                    foreach ( $table['body'] as $tr ) {

                        echo '<tr>';

                            // determine colspan for descriptions
                            $col = count($tr);
                            $j = 1;
                            foreach ( $tr as $td ) {
                                if($j == 1) {
                                    $td_class = 'serv-title';
                                } else { $td_class = 'serv-price'; }
                                // detect description per modifier
                                print_r(get_field('description'));
                                if (substr( $td['c'], 0, 2 ) === "++") {
                                    $description = substr($td['c'], 2);
                                    echo '<td class="serv-col serv-desc" colspan="'.$col.'">';
                                        echo $description;
                                    echo '</td>';
                                    break;
                                } else {
                                    echo '<td class="serv-col '.$td_class.'">';
                                        echo $td['c'];
                                    echo '</td>';
                                }
                                $j++;
                            }

                        echo '</tr>';
                    }

                echo '</tbody>';
            echo '</table>';
        }
        }
    if(get_sub_field('subcategory_disclaimer')) : echo '<div class="serv_subcat_disclaimer">'; the_sub_field('subcategory_disclaimer'); echo '</div>'; else: endif; 
        echo '</div>';
        echo $cat_id;
        endwhile;
        
    else : // no rows found
    endif;
    echo '</div>';
    }
    // just one loop is fine, thanks
    
    wp_reset_query();
    // Get current buffer contents and delete current output buffer
    $returnString = ob_get_clean();
    return $returnString;

    
}
add_shortcode('im-services', 'wp_services_list');





///// A D M I N
///// C L E A N U P
////////////////////////////
// delete permalink under wordpress post title
add_filter( 'get_sample_permalink_html', 'wpse_125800_sample_permalink' );
function wpse_125800_sample_permalink( $return ) {

    if( get_post_type() === 'service' ) {
        $return = '';
    }

    return $return;
}
// remove View/Preview buttons
add_filter( 'page_row_actions', 'wpse_125800_row_actions', 10, 2 );
add_filter( 'post_row_actions', 'wpse_125800_row_actions', 10, 2 );
function wpse_125800_row_actions( $actions, $post ) {
    if( get_post_type() === 'service' ) {
        unset( $actions['inline hide-if-no-js'] );
        unset( $actions['view'] );
    }
    return $actions;
}
// Simplify publish box
global $pagenow;
if ( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) {
    add_action( 'admin_head', 'wpse_125800_custom_publish_box' );
    function wpse_125800_custom_publish_box() {
        if( !is_admin() )
            return;
        if( get_post_type() === 'service' ) {
            $style = '';
            $style .= '<style type="text/css">';
            $style .= '#edit-slug-box, #minor-publishing-actions, #visibility, .num-revisions, .curtime';
            $style .= '{display: none; }';
            $style .= '</style>';
            echo $style;
        }
    }
}
add_filter( 'post_updated_messages', 'rw_post_updated_messages' );
// Set some custom status messages
function rw_post_updated_messages( $messages ) {
    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );
    $messages['service'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => __( 'Service item updated.' ),
        2  => __( 'Custom field updated.' ),
        3  => __( 'Custom field deleted.'),
        4  => __( 'Service item updated.' ),
        /* translators: %s: date and time of the revision */
        5  => isset( $_GET['revision'] ) ? sprintf( __( 'Service item restored to revision from %s' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => __( 'Service item published.' ),
        7  => __( 'Service item saved.' ),
        8  => __( 'Service item submitted.' ),
        9  => sprintf(
            __( 'Service item scheduled for: <strong>%1$s</strong>.' ),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )
        ),
        10 => __( 'Service item draft updated.' )
    );
    return $messages;
}

?>