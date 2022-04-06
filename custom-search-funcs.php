<?php 

function expert_cpt() {
	$labels = array(
	  'name'               => _x( 'Experts', 'expert' ),
	  'singular_name'      => _x( 'Expert', 'expert' ),
	  'add_new'            => _x( 'Add New', 'Expert' ),
	  'add_new_item'       => __( 'Add New Expert' ),
	  'edit_item'          => __( 'Edit Expert' ),
	  'new_item'           => __( 'New Expert' ),
	  'all_items'          => __( 'All Expert' ),
	  'view_item'          => __( 'View Experts' ),
	  'search_items'       => __( 'Search Experts' ),
	  'not_found'          => __( 'No Experts found' ),
	  'not_found_in_trash' => __( 'No Experts found in the Trash' ),
	  'menu_name'          => 'Experts',
	);
	$args = array(
	  'labels'              => $labels,
	  'description'         => 'Expert Witnesses',
	  'public'              => true,
	  'publicly_queryable'  => true,
	  'menu_position'       => 5,
	  'menu_icon'           => 'dashicons-businessman',
	  'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
	  'rewrite'             => array( 'slug' => 'experts' ),
	  'has_archive'         => true,
	  'show_in_rest' 		=> true,
	  'taxonomies'  => array( 'types' )
	);
	register_post_type( 'experts', $args ); 
  }
  add_action( 'init', 'expert_cpt' );

  function experts_taxonomy() {
	$industries_labels = array(
		'name'               => _x( 'Expert Industries', 'expert_industries' ),
		'singular_name'      => _x( 'Expert Industry', 'expert_industry' ),
		'add_new'            => _x( 'Add New', 'Expert Industry' ),
		'add_new_item'       => __( 'Add New Expert Industry' ),
		'edit_item'          => __( 'Edit Expert Industry' ),
		'new_item'           => __( 'New Expert Industry' ),
		'all_items'          => __( 'All Expert Industries' ),
		'view_item'          => __( 'View Expert Industries' ),
		'search_items'       => __( 'Search Expert Industries' ),
		'not_found'          => __( 'No Expert Industries found' ),
		'not_found_in_trash' => __( 'No Expert Industries found in the Trash' ),
		'menu_name'          => 'Expert Industries',
	  );
	register_taxonomy(
		'experts_industries',  // name of the taxonomy. 
		'experts',             // post type name
		array(
			'hierarchical' => true,
			'labels' => $industries_labels, // custom labels
			'query_var' => true,
			'show_in_rest'  => true,
			'rewrite' => array(
				'slug' => 'expert_industry',    // This controls the base slug that will display before each term
				'with_front' => false  // Don't display the category base before
			)
		)
	);
 }
 add_action( 'init', 'experts_taxonomy');

 // Disable Gutenberg on the back end.
add_filter( 'use_block_editor_for_post', '__return_false' );

/*=================================================
CUSTOM QUERY
=================================================== */
function custom_search_query_vars_filter( $vars ) {

    $vars[] .= 'keyword';
    $vars[] .= 'industry_select';
    return $vars;
}
add_filter( 'query_vars', 'custom_search_query_vars_filter' );

/*=================================================
SEARCH QUERY
=================================================== */
function custom_search( $query ) {
    if ( is_archive('experts') && $query->is_main_query() && !is_admin() ) {

        $keyword = get_query_var( 'keyword', FALSE );
        $industry_select = get_query_var( 'industry_select', FALSE );

        // Keywords query
        $keyword ? $keyword : $keyword = null;

        $query->set('s', $keyword);

        // Custom fields query
        // $meta_query_array = array('relation' => 'AND');
        // $status_list ? array_push($meta_query_array, array('key' => 'status_job', 'value' => '"' . $status_list . '"', 'compare' => 'LIKE') ) : null ;
        // $query->set( 'meta_query', $meta_query_array );
        
        // Taxonomies query
        $tax_query_array = array('relation' => 'OR');

        $industry_select ? array_push($tax_query_array, array('taxonomy' => 'experts_industries', 'field' => 'term_id', 'terms' => $industry_select) ) : null ;

        $query->set( 'tax_query', $tax_query_array);
    }
}
add_action( 'pre_get_posts', 'custom_search' );
