<?php

/*
Plugin Name: Github Contributors Short Code
Plugin URI: http://pippinsplugins.com/
Description: Displays a list of all contributors of any project/repo on Github
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
Version: 1.0
*/


function pw_get_github_contributors( $atts, $content = null ) {	
	extract( shortcode_atts( array(
			'username' => 'Automattic',
			'repo' => '_s'
		), $atts )
	);

    $transient_key = 'pw_gh_' . $username . '_' . $repo;

    $contributors = get_transient( $transient_key );
    if ( false === $contributors ) {
     
	    $response = wp_remote_get( 'https://api.github.com/repos/' . $username . '/' . $repo . '/contributors' );
	    if ( is_wp_error( $response ) )
	        return array();

	    $contributors = json_decode( wp_remote_retrieve_body( $response ) );
	    if ( ! is_array( $contributors ) )
	        return ''; // show nothing.

	    set_transient( $transient_key, $contributors, 3600 );

	}
	if( is_array( $contributors ) ) { 
	    $contrib_list = '<div id="pw_github_contributors" class="pw_gh_' . strtolower( $username ) . '_' . strtolower( str_replace('-', '_', $repo ) ) . '">';
	    foreach( $contributors as $contributor ) {
	    	$contrib_list .= '<div class="pw_gh_contributor" style="width: 120px; display: inline-block;">';
	    		$contrib_list .= '<a href="https://github.com/' . $contributor->login . '" title="' . sprintf( __('View %s', 'pw_github'), $contributor->login ) . '">';
	    			$contrib_list .= '<img src="' . $contributor->avatar_url . '" width="80" height="80"/>';
	    			$contrib_list .= '<p class="pw_gh_name">' . $contributor->login . '</p>';
	    		$contrib_list .= '</a>';
	    	$contrib_list .= '</div>';
	    }
	    $contrib_list .= '</div>';

	    return $contrib_list;
	}
}
add_shortcode('github_contributors', 'pw_get_github_contributors');