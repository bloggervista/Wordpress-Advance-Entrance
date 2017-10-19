<?php
add_shortcode('entrance',function($atts){
	global $post;
	extract(shortcode_atts(["post_id"=>$post->ID],$atts));
})
?>