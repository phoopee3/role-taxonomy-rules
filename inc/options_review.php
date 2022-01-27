<?php

$roles = wp_roles();

// set up the anyone role
$roles->role_names['*'] = 'Anyone';

$post_types = get_post_types( [], 'objects' );

$taxonomies = get_taxonomies( [], 'objects' );

$used_taxonomies = [];

// get the current rules
$rtr_rules_json = get_option( 'rtr_rules', "[]" );
$rtr_rules = json_decode( $rtr_rules_json );

if ( count( $rtr_rules ) == 0 ) {
    echo "There are no rules";
} else {
    $idx = 0;
    foreach( $rtr_rules as $rule ) {
        // check if we have used the taxonomy mentioned
        if ( !$used_taxonomies[$rule->taxonomy] ) {
            // get the terms for this taxonomy
            $temp_terms = get_terms( [
                'taxonomy' => $rule->taxonomy,
                'hide_empty' => false,
            ] );
            foreach( $temp_terms as $temp_term ) {
                $used_taxonomies[$rule->taxonomy][$temp_term->term_id] = $temp_term;
            }
            $used_taxonomies[$rule->taxonomy]['name'] = $taxonomies[$rule->taxonomy]->labels->singular_name;
        }
        echo "<div class='has-row-actions'>";
        echo "When a <strong>{$roles->role_names[$rule->user_role]}</strong> writes a <strong>{$post_types[$rule->post_type]->labels->singular_name}</strong>, add the ";
        if ( count( $rule->terms ) == 1 ) {
            echo "term <strong>{$used_taxonomies[$rule->taxonomy]['name']}</strong> / <strong>{$used_taxonomies[$rule->taxonomy][$rule->terms[0]]->name}</strong> ";
        } else {
            echo "rules ";
            $t = [];
            foreach( $rule->terms as $term ) {
                $t[] = "<strong>{$used_taxonomies[$rule->taxonomy]['name']}</strong> / <strong>{$used_taxonomies[$rule->taxonomy][$term]->name}</strong>";
            }
            echo implode( ', ', $t ) . " ";
        }
        echo "to the post";
        echo "<span class='row-actions'><span class='trash'><a href='#' data-idx='{$idx}'>Delete</a></span></span>";
        echo "</div>";
        $idx++;
    }
}
?>
<script>
    jQuery( document ).ready(function() {
        jQuery( 'a[data-idx]' ).on( 'click', function( e ) {
            e.preventDefault();
            jQuery.post(
                '',
                { action: 'delete_rule', idx : jQuery( this ).data( 'idx' ) },
                function ( results ) {
                    window.location.reload();
                }
            );
        } );
    });
</script>
<style>
    .row-actions {
        margin-left: 10px;
    }
    .has-row-actions:hover .row-actions {
        left:0;
    }
</style>