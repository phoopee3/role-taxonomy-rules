<?php

// $rest_url = get_rest_url();

$roles = wp_roles();

$post_types = get_post_types( [], 'objects' );

$taxonomies = get_taxonomies( [], 'objects' );

// go through taxonomies and get the
// name, label, and object_type
$filtered_taxonomies = [];
foreach( $taxonomies as $taxonomy ) {
    $temp = [];
    $temp[$taxonomy->name] = new stdClass;
    $temp[$taxonomy->name]->label = $taxonomy->labels->singular_name;
    $temp[$taxonomy->name]->object_type = $taxonomy->object_type;
    $filtered_taxonomies[$taxonomy->name] = $temp[$taxonomy->name];
}
$taxonomies = $filtered_taxonomies;
?>
<style>
    .no-break {
        white-space: nowrap;
    }
    .va-top {
        margin-top: 6px;
        display: block;
    }
</style>
<form action="" method="post">
    <input type="hidden" name="action" value="create_rule">
    <table class="form-table">
        <tr>
            <td class="no-break">Pick a user role:</td>
            <td>
                <select name="rtr_user_role" id="user_role">
                    <option value=""></option>
                    <option value="*">Any</option>
                    <?php foreach( $roles->role_names as $key => $name ) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                    <?php } ?>
                </select>    
            </td>
        </tr>
        <tr>
            <td class="no-break">Pick a post type:</td>
            <td>
                <select name="rtr_post_type" id="post_type">
                    <option value=""></option>
                    <?php foreach( $post_types as $key => $post_type ) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $post_type->labels->singular_name; ?></option>
                    <?php } ?>
                </select>  
            </td>
        </tr>
        <tr>
            <td class="no-break">Pick a taxonomy:</td>
            <td>
                <select name="rtr_taxonomy" id="taxonomy">
                    <option value=""></option>
                    <?php foreach( $taxonomies as $key => $taxonomy ) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $taxonomy->label; ?></option>
                    <?php } ?>
                </select>  
            </td>
        </tr>
        <tr>
            <td class="no-break va-top">Select one or more terms:</td>
            <td id="terms">
            </td>
        </tr>
        <tr>
            <td colspan="2"><button class="button-primary">Save Changes</button></td>
        </tr>
    </table>
</form>

<script>
    // var rest_url = "<?php echo $rest_url; ?>";

    jQuery( document ).ready(function() {
        jQuery('#taxonomy').on('change',
            function() {
                updateTaxonomyTerms( jQuery( this ).val() );
            }
        );
    });

    function updateTaxonomyTerms( taxonomy ) {
        // clear out fields
        jQuery( '#terms' ).empty();

        // get terms from api
        // var api = `${rest_url}wp/v2/${taxonomy}`;

        jQuery.post(
            ajaxurl,
            {
                action: 'rtr_get_taxonomy',
                taxonomy: taxonomy
            },
            function( results ) {
                results = JSON.parse( results );
                // add the terms to the wrapper
                results.forEach( result => {
                    jQuery( '#terms' ).append( `<div><label><input type="checkbox" name="rtr_terms[]" value="${result.term_id}"> ${result.name}</label></div>` );
                } );
            }
        );
    }
</script>