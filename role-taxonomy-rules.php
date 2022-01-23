<?php
/*
Plugin Name: Role taxonomy rules
Description: Set a taxonomy term on a post type if certain rules are met
Version: 1.1.1
Author: Jason Lawton <jason@jasonlawton.com>
*/

define( 'RTR_PLUGIN_NAME', 'Role Taxonomy Rules' );
define( 'RTR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'RTR_MENU_SLUG', 'role-taxonomy-rules' );
define( 'RTR_MENU_POSITION', 100);

require_once( 'inc/helpers.php' );
require_once( 'inc/hooks.php' );
require_once( 'inc/init.php' );
require_once( 'inc/ajax.php' );
