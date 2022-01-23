<?php

add_action( 'admin_menu', 'rtr_add_admin_menu' );

function rtr_add_admin_menu() {
    add_menu_page(
        'Role Taxonomy Rules', // page title
        'Role Taxonomy Rules', // menu title
        'manage_categories', // capability
        RTR_MENU_SLUG, // menu slug
        'rtr_options_page', // function
        'dashicons-randomize', // icon
        RTR_MENU_POSITION // position
    );
}

function rtr_options_page() {
    require_once( trailingslashit( RTR_PLUGIN_PATH ) . 'inc/options.php' );
}