<?php

if ( is_admin() ) {
    add_action( 'wp_ajax_rtr_get_taxonomy', 'rtr_ajax_get_taxonomy' );
}

function rtr_ajax_get_taxonomy() {

    $taxonomy    = $_POST['taxonomy'];

    $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ) );

    echo json_encode( $terms, JSON_NUMERIC_CHECK );

	wp_die(); // this is required to terminate immediately and return a proper response
}