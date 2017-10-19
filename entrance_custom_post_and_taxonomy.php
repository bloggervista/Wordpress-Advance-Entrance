<?php
add_action( 'init', function () {
    $labels = array(
        'name'                => _x( 'Entrances', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Entrance', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Entrance', 'text_domain' ),
        'name_admin_bar'      => __( 'Entrance', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Entrance:', 'text_domain' ),
        'all_items'           => __( 'All Entrances', 'text_domain' ),
        'add_new_item'        => __( 'Add New Entrance', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'new_item'            => __( 'New Entrance', 'text_domain' ),
        'edit_item'           => __( 'Edit Entrance', 'text_domain' ),
        'update_item'         => __( 'Update Entrance', 'text_domain' ),
        'view_item'           => __( 'View Entrance', 'text_domain' ),
        'search_items'        => __( 'Search Entrance', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $rewrite = array(
        'slug'                => 'entrance',
        'with_front'          => true,
        'pages'               => true,
        'feeds'               => true,
    );
    $args = array(
        'label'               => __( 'entrance', 'text_domain' ),
        'description'         => __( 'Add question related to entrance', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'custom-fields','page-attributes'),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-book',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,      
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'page',
    );
    register_post_type( 'entrance', $args );

}, 0 );


add_action( 'init', function() {

    $labels = array(
        'name'                       => _x( 'Objective Questions', 'Taxonomy General Name', 'Shirshak' ),
        'singular_name'              => _x( 'Objective Question', 'Taxonomy Singular Name', 'Shirshak' ),
        'menu_name'                  => __( 'Objective Question', 'Shirshak' ),
        'all_items'                  => __( 'All Items', 'Shirshak' ),
        'parent_item'                => __( 'Parent Item', 'Shirshak' ),
        'parent_item_colon'          => __( 'Parent Item:', 'Shirshak' ),
        'new_item_name'              => __( 'New Item Name', 'Shirshak' ),
        'add_new_item'               => __( 'Add New Item', 'Shirshak' ),
        'edit_item'                  => __( 'Edit Item', 'Shirshak' ),
        'update_item'                => __( 'Update Item', 'Shirshak' ),
        'view_item'                  => __( 'View Item', 'Shirshak' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'Shirshak' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'Shirshak' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'Shirshak' ),
        'popular_items'              => __( 'Popular Items', 'Shirshak' ),
        'search_items'               => __( 'Search Items', 'Shirshak' ),
        'not_found'                  => __( 'Not Found', 'Shirshak' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => false,
    );
    register_taxonomy( 'objective_questions', array( 'entrance' ), $args );

}, 0);
add_action("init",function(){
    if (get_option('entrance_taxonomy_inserted')) {
     return;
    }
    $subject = wp_insert_term('Subjects', 'objective_questions', ['slug'=>'subject']);
    wp_insert_term('Physics', 'objective_questions', ['parent' => $subject['term_id'],'slug'=>'physics']);
    wp_insert_term('Chemistry', 'objective_questions', ['parent' => $subject['term_id'],'slug'=>'chemistry']);
    wp_insert_term('Biology', 'objective_questions', ['parent' => $subject['term_id'],'slug'=>'biology']);
    wp_insert_term('Mathematics', 'objective_questions', ['parent' => $subject['term_id'],'slug'=>'mathematics']);
    wp_insert_term('English', 'objective_questions', ['parent' => $subject['term_id'],'slug'=>'english']);
    
    $institutes = wp_insert_term('Institutes', 'objective_questions',["slug"=>"xii"]); 
    wp_insert_term('IOE', 'objective_questions', ['parent' => $institutes['term_id'],'slug'=>'ioe']);
    wp_insert_term('IOM', 'objective_questions', ['parent' => $institutes['term_id'],'slug'=>'iom']);
    wp_insert_term('MOE', 'objective_questions', ['parent' => $institutes['term_id'],'slug'=>'moe']);
    wp_insert_term('KU', 'objective_questions', ['parent' => $institutes['term_id'],'slug'=>'ku']);
    wp_insert_term('NIT', 'objective_questions', ['parent' => $institutes['term_id'],'slug'=>'nit']);
    wp_insert_term('IIT', 'objective_questions', ['parent' => $institutes['term_id'],'slug'=>'iit']);
    wp_insert_term('MIT', 'objective_questions', ['parent' => $institutes['term_id'],'slug'=>'mit']);
    add_option("entrance_taxonomy_inserted",time());

})
?>