<?php
if ( isset( $_POST['action'] ) ) {
    switch( $_POST['action'] ) {
        case 'create_rule':
            // get the option
            $rtr_rules_json = get_option( 'rtr_rules', "[]" );
            if ( $rtr_rules_json == null ) {
                $rtr_rules_json = "[]";
            }
            // parse the option to an array
            $rtr_rules = json_decode( $rtr_rules_json, true );
            $rtr_rule = [
                "user_role" => $_POST['rtr_user_role'],
                "post_type" => $_POST['rtr_post_type'],
                "taxonomy" => $_POST['rtr_taxonomy'],
                "terms" => $_POST['rtr_terms'],
            ];
            // append the posted data
            $new_rtr_rules = array_merge( $rtr_rules, [$rtr_rule] );
            // convert back to json
            $rtr_rules_json = json_encode( $new_rtr_rules, JSON_NUMERIC_CHECK );
            // save option
            update_option( 'rtr_rules', $rtr_rules_json );
            $tab = 'options';
            break;
        case 'delete_rule':
            if ( !isset( $_POST['idx'] ) || !is_numeric( $_POST['idx'] ) ) { echo 0; exit; }

            $rtr_rules_json = get_option( 'rtr_rules', "[]" );
            if ( $rtr_rules_json == null ) {
                $rtr_rules_json = "[]";
            }
            $rtr_rules = json_decode( $rtr_rules_json, true );

            if ( count( $rtr_rules ) == 0 ) { echo 0; exit; }
            
            // splice out the rule to remove
            $foo = array_splice( $rtr_rules, $_POST['idx'], 1 );

            // convert back to json
            $rtr_rules_json = json_encode( $rtr_rules, JSON_NUMERIC_CHECK );
            // save option
            update_option( 'rtr_rules', $rtr_rules_json );
            echo 1;
            exit;
            break;
    }
}
?>

<div class="wrap">
    <h1><?php echo RTR_PLUGIN_NAME; ?></h1>

    <?php
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

    ?>
    <nav class="nav-tab-wrapper">
    <a href="?page=<?php echo RTR_MENU_SLUG; ?>" class="nav-tab <?php if ( null === $tab ) : ?>nav-tab-active<?php endif; ?>">Create Rule</a>
    <a href="?page=<?php echo RTR_MENU_SLUG; ?>&tab=review" class="nav-tab <?php if ( 'review' === $tab ) : ?>nav-tab-active<?php endif; ?>">Review Rules</a>
    <!-- <a href="?page=<?php echo RTR_MENU_SLUG; ?>&tab=debug" class="nav-tab <?php if ( 'debug' === $tab ) : ?>nav-tab-active<?php endif; ?>">Debug</a> -->
    </nav>

    <div class="tab-content">
        <?php switch( $tab ) :
        case 'review':
            include( trailingslashit( RTR_PLUGIN_PATH ) . 'inc/options_review.php' );
            break;
        // case 'debug':
        //     include( trailingslashit( RTR_PLUGIN_PATH ) . 'inc/options_debug.php' );
        //     break;
        default:
            include( trailingslashit( RTR_PLUGIN_PATH ) . 'inc/options_create.php' );
            break;
        endswitch; ?>
    </div>
</div>