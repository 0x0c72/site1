<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
    	'name' => 'Sidebar Left',
        'before_widget' => '<div class="sidebar-box"><div class="sidebar-box-top"><div class="sidebar-box-bottom">',
        'after_widget' => '</div></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
    	'name' => 'Sidebar Right',
        'before_widget' => '<div class="sidebar-box"><div class="sidebar-box-top"><div class="sidebar-box-bottom">',
        'after_widget' => '</div></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
?>