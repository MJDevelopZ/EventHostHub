<?php
/*
* Enqueues child theme stylesheet, loading first the parent theme stylesheet.
*/
function themify_custom_enqueue_child_theme_styles() {
wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'themify_custom_enqueue_child_theme_styles' );

/* 
* BuddyPress Honeypot
*/
function add_honeypot() {
    echo '';
}
add_action('bp_after_signup_profile_fields','add_honeypot');
function check_honeypot() {
    if (!empty($_POST['system55'])) {
        global $bp;
        wp_redirect(home_url());
        exit;
    }
}
add_filter('bp_core_validate_user_signup','check_honeypot');

//Remove WP Admin Bar for all users except Admin
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
	}
}