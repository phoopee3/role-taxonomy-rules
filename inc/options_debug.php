<?php

$rtr_rules_json = get_option( 'rtr_rules', "[]" );
// parse the option to an array
$rtr_rules = json_decode( $rtr_rules_json, true );
dump( $rtr_rules );

?>
