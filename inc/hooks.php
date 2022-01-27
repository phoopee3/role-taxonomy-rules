<?php

// add a term to a post if it meets any of the defined rules
add_action( 'save_post', 'rtr_set_taxonomy', 10,3 );

function rtr_set_taxonomy( $post_id, $post, $update ) {
    // Only want to set if this is a new post!
    if ( $update ) {
        return;
    }

    // get the current user role
    $user = wp_get_current_user();
    $roles = ( array ) $user->roles;

    // get the post_type
    $post_type = $post->post_type;

    // get the rules
    $rtr_rules_json = get_option( 'rtr_rules', "[]" );
    $rtr_rules = json_decode( $rtr_rules_json, true );

    if ( count( $rtr_rules ) == 0 ) {
        return;
    }

    // loop over rules
    foreach ( $rtr_rules as $rule ) {
        // see if the user role matches the rule role
        if ( ( $rule['user_role'] == '*' ) || in_array( $rule['user_role'], $roles ) ) {
            // if so, see if the post matches the post type
            if ( $rule['post_type'] == $post_type ) {
                // if it does, add the term_id to the post
                wp_set_object_terms( $post_id, $rule['terms'], $rule['taxonomy'], true );
            }
        }
    }
}