<?php
/* Redirects to profile upon login, and upon logout redirects to activity page unless changed */
function bp_help_redirect_to_profile(){
 global $bp_unfiltered_uri;

 $bphelp_my_front_page = 'activity';  // WARNING: make sure you replace 'activity' in this line to the same thing you set dashboard/settings/reading front page to.

 if ( !is_user_logged_in() && ( $bp_unfiltered_uri[0] != $bphelp_my_front_page ) ) 
  bp_core_redirect( get_option('home') );

 elseif( is_user_logged_in() && ( $bp_unfiltered_uri[0] == $bphelp_my_front_page ) )
	bp_core_redirect( get_option('home') . '/members/' . bp_core_get_username( bp_loggedin_user_id() ) . '/profile' );

}
	
add_action( 'wp', 'bp_help_redirect_to_profile', 3 );

?>