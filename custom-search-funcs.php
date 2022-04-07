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
    $specialities_labels = array(
		'name'               => _x( 'Expert Specialities', 'expert_speciality' ),
		'singular_name'      => _x( 'Expert Speciality', 'expert_speciality' ),
		'add_new'            => _x( 'Add New', 'Expert Speciality' ),
		'add_new_item'       => __( 'Add New Expert Speciality' ),
		'edit_item'          => __( 'Edit Expert Speciality' ),
		'new_item'           => __( 'New Expert Speciality' ),
		'all_items'          => __( 'All Expert Specialities' ),
		'view_item'          => __( 'View Expert Specialities' ),
		'search_items'       => __( 'Search Expert Specialities' ),
		'not_found'          => __( 'No Expert Specialities found' ),
		'not_found_in_trash' => __( 'No Expert Specialities found in the Trash' ),
		'menu_name'          => 'Expert Specialities',
	  );
	register_taxonomy(
		'experts_specialities',  // name of the taxonomy. 
		'experts',             // post type name
		array(
			'hierarchical' => true,
			'labels' => $specialities_labels, // custom labels
			'query_var' => true,
			'show_in_rest'  => true,
			'rewrite' => array(
				'slug' => 'expert_speciality',    // This controls the base slug that will display before each term
				'with_front' => false  // Don't display the category base before
			)
		)
	);
    $location_labels = array(
		'name'               => _x( 'Expert Locations', 'expert_locations' ),
		'singular_name'      => _x( 'Expert Location', 'expert_location' ),
		'add_new'            => _x( 'Add New', 'Expert Location' ),
		'add_new_item'       => __( 'Add New Expert Location' ),
		'edit_item'          => __( 'Edit Expert Location' ),
		'new_item'           => __( 'New Expert Location' ),
		'all_items'          => __( 'All Expert Locations' ),
		'view_item'          => __( 'View Expert Locations' ),
		'search_items'       => __( 'Search Expert Locations' ),
		'not_found'          => __( 'No Expert Locations found' ),
		'not_found_in_trash' => __( 'No Expert Locations found in the Trash' ),
		'menu_name'          => 'Expert Locations',
	  );
	register_taxonomy(
		'experts_locations',  // name of the taxonomy. 
		'experts',             // post type name
		array(
			'hierarchical' => true,
			'labels' => $location_labels, // custom labels
			'query_var' => true,
			'show_in_rest'  => true,
			'rewrite' => array(
				'slug' => 'expert_locations',    // This controls the base slug that will display before each term
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
    $vars[] .= 'speciality';
    $vars[] .= 'location_select';
    return $vars;
}
add_filter( 'query_vars', 'custom_search_query_vars_filter' );

/*=================================================
SEARCH QUERY
=================================================== */
function custom_search( $query ) {
    if ( is_post_type_archive( 'experts' ) && $query->is_main_query() && !is_admin() ) {

        $keyword = get_query_var( 'keyword', FALSE );
        $industry_select = strtolower(str_replace(' ', '-', get_query_var( 'industry_select', FALSE ) ));
        $speciality_select = strtolower(str_replace(' ', '-', get_query_var( 'speciality', FALSE ) ));
        $location_select = strtolower(str_replace(' ', '-', get_query_var( 'location_select', FALSE ) ));

        // Keywords query
        $keyword ? $keyword : $keyword = null;

        $query->set('s', $keyword);

        // Custom fields query
        //$meta_query_array = array('relation' => 'AND');
        //$status_list ? array_push($meta_query_array, array('key' => 'status_job', 'value' => '"' . $status_list . '"', 'compare' => 'LIKE') ) : null ;
        //$query->set( 'meta_query', $meta_query_array );
        

        // Build taxonomy array based on what's been filled out 

            $tax_query_array = array('relation' => 'AND');
            $location_select ? array_push($tax_query_array, array('taxonomy' => 'experts_locations', 'field' => 'slug', 'terms' => $location_select) ) : null ;
            $speciality_select ? array_push($tax_query_array, array('taxonomy' => 'experts_specialities', 'field' => 'slug', 'terms' => $speciality_select) ) : null ;
            $industry_select ? array_push($tax_query_array, array('taxonomy' => 'experts_industries', 'field' => 'slug', 'terms' => $industry_select) ) : null ;

        $query->set( 'tax_query', $tax_query_array);

    }
}
add_action( 'pre_get_posts', 'custom_search' );
