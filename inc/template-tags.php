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

function viral_social_share() {
	global $post;

	$post_url = get_permalink();
	$post_title = get_the_title();
	
	$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

	$twitterURL = 'https://twitter.com/intent/tweet?text='.$post_title.'&amp;url='.$post_url;
	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$post_url;
	$googleURL = 'https://plus.google.com/share?url='.$post_url;
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$post_url.'&amp;media='.$post_thumbnail[0].'&amp;description='.$post_title;
	$mailURL = 'mailto:?Subject='.$post_title.'&amp;Body='.$post_url;
	$whatsappURL = 'https://api.whatsapp.com/send?text=' . $post_title . ' - ' . $post_url;
	$telegramURL = 'https://t.me/share/url?url=' . $post_url . '&amp;text=' . $post_title;

	$content = '<div class="vl-share-buttons">';
	$content .= '<span>'. __( 'SHARE', 'viral' ) .'</span>';
	$content .= '<a title="'.__('Share on Facebook', 'viral').'" target="_blank" href="' . esc_url( $facebookURL ) . '" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Share on Twitter', 'viral').'" target="_blank" href="' . esc_url( $twitterURL ) .'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Share on GooglePlus', 'viral').'" target="_blank" href="' . esc_url( $googleURL ) . '" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Share on Pinterest', 'viral').'" target="_blank" href="' . esc_url( $pinterestURL ) . '" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Email', 'viral').'" target="_blank" href="' . esc_url( $mailURL ) . '"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Compartir en WhatsApp', 'indymedia').'" target="_blank" href="' . esc_url( $whatsappURL ) . '" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Compartir en Telegram', 'indymedia').'" target="_blank" href="' . esc_url( $telegramURL ) . '" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i></a>';
	$content .= '</div>';

	echo $content;
}