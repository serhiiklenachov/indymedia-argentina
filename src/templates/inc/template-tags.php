<?php

function viral_post_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on =  $time_string;

	$fuente = get_post_meta( get_the_ID(), 'fuente', true );

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'viral' ),
		'<span class="author vcard">' . esc_html( '' != $fuente ? $fuente : get_the_author() ) . '</span>'
	);

	echo '<div class="posted-on"><i class="fa fa-clock-o" aria-hidden="true"></i>' . $posted_on . '<span class="byline"> ' . $byline . '</span></div>'; // WPCS: XSS OK.

}
