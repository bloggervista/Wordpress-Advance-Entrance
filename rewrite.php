<?php 
add_filter('query_vars', function ($vars) {
    $vars[]="entrance_result";
    return $vars;
});
add_action('generate_rewrite_rules', function($wp_rewrite) {
  $theme_name =  wp_get_theme();
    global $wp_rewrite;
     $new_rules = array(
        '^result/([0-9]+$)'=>'index.php?entrance_result=' . $wp_rewrite->preg_index(1)
    );  
    $wp_rewrite->rules = $new_rules+$wp_rewrite->rules ;
});
add_action("template_redirect", function () {
    global $wp;
    global $wp_query, $wp_rewrite;
    if(!empty($wp_query->query_vars["entrance_result"])):
    	require "single_result.php"; 
    	die();
    endif;
});
?>