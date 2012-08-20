<?php

/*
Plugin Name: Github Contributors Short Code
Plugin URI: http://pippinsplugins.com/github-contributors-plugin/
Description: Displays a list of all contributors of any project/repo on Github
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
Contributors: mordauk
Version: 1.0.1
*/


function pw_get_github_contributors( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'username' => 'Automattic',
			'repo'     => '_s'
		), $atts )
	);

	$transient_key = md5( 'pw_gh_contribs' . print_r( $atts, true ) );

	$contributors = get_transient( $transient_key );
	if ( false === $contributors )
		$contributors = pw_get_github_contributors_query( $username, $repo, $transient_key );

	if ( ! is_array( $contributors ) )
		return '';

	$contrib_list = sprintf( '<div id="pw_github_contributors" class="pw_gh_%s">',
		esc_attr( strtolower( $username ) . '_' . strtolower( str_replace('-', '_', $repo ) ) )
	);

	foreach ( $contributors as $contributor ) {
		$contrib_list .= '<div class="pw_gh_contributor" style="width: 120px; display: inline-block;">';
		$contrib_list .= sprintf( '<a href="%s" title="%s">',
			esc_url( 'https://github.com/' . $contributor->login ),
			esc_html( sprintf( __('View %s', 'pw_github'), $contributor->login ) )
		);
		$contrib_list .= sprintf( '<img src="%s" width="80" height="80"/>', esc_url( $contributor->avatar_url ) );
		$contrib_list .= sprintf( '<p class="pw_gh_name">%s</p>', esc_html( $contributor->login ) );
		$contrib_list .= '</a>';
		$contrib_list .= '</div>';
	}

	$contrib_list .= '</div>';

	return $contrib_list;
}
add_shortcode( 'github_contributors', 'pw_get_github_contributors' );

function pw_get_github_contributors_query( $username, $repo, $transient_key ) {
	$response = wp_remote_get( "https://api.github.com/repos/{$username}/{$repo}/contributors" );

	if ( is_wp_error( $response ) ) {
		set_transient( $transient_key, '', 3600 );
		return flase;
	}

	$contributors = json_decode( wp_remote_retrieve_body( $response ) );
	if ( ! is_array( $contributors ) ) {
		set_transient( $transient_key, '', 3600 );
		return false;
	}

	set_transient( $transient_key, $contributors, 3600 );
	return $contributors;
}