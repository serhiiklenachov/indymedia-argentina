<?php

function viral_social_links() {
	$telegram = get_theme_mod('viral_social_telegram');
	$whatsapp = get_theme_mod('viral_social_whatsapp');
	$facebook = get_theme_mod('viral_social_facebook');
	$twitter = get_theme_mod('viral_social_twitter');
	$pinterest = get_theme_mod('viral_social_pinterest');
	$youtube = get_theme_mod('viral_social_youtube');
	$linkedin = get_theme_mod('viral_social_linkedin');
	$instagram = get_theme_mod('viral_social_instagram');

	if($telegram)
		echo '<a class="vl-telegram" href="'.esc_url( $telegram ).'" target="_blank"><i class="fa fa-telegram"></i></a>';

	if($whatsapp)
		echo '<a class="vl-whatsapp" href="'.esc_url( $whatsapp ).'" target="_blank"><i class="fa fa-whatsapp"></i></a>';

	if($facebook)
		echo '<a class="vl-facebook" href="'.esc_url( $facebook ).'" target="_blank"><i class="fa fa-facebook"></i></a>';

	if($twitter)
		echo '<a class="vl-twitter" href="'.esc_url( $twitter ).'" target="_blank"><i class="fa fa-twitter"></i></a>';

	if($pinterest)
		echo '<a class="vl-pinterest" href="'.esc_url( $pinterest ).'" target="_blank"><i class="fa fa-pinterest"></i></a>';

	if($youtube)
		echo '<a class="vl-youtube" href="'.esc_url( $youtube ).'" target="_blank"><i class="fa fa-youtube"></i></a>';

	if($linkedin)
		echo '<a class="vl-linkedin" href="'.esc_url( $linkedin ).'" target="_blank"><i class="fa fa-linkedin"></i></a>';

	if($instagram)
		echo '<a class="vl-instagram" href="'.esc_url( $instagram ).'" target="_blank"><i class="fa fa-instagram"></i></a>';
}

function viral_social_share( $title = true ) {
	global $post;

	$post_url = get_permalink();
	$post_title = get_the_title();
	
	$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

	$twitterURL = 'https://twitter.com/intent/tweet?text='.$post_title.'&amp;url='.$post_url;
	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$post_url;
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$post_url.'&amp;media='.$post_thumbnail[0].'&amp;description='.$post_title;
	$mailURL = 'mailto:?Subject='.$post_title.'&amp;Body='.$post_url;
	$whatsappURL = 'https://api.whatsapp.com/send?text=' . $post_title . ' - ' . $post_url;
	$telegramURL = 'https://t.me/share/url?url=' . $post_url . '&amp;text=' . $post_title;

	$content = '<div class="vl-share-buttons">';
	if ( $title ) {
		$content .= '<span>'. __( 'SHARE', 'viral' ) .'</span>';
	}
	$content .= '<a title="'.__('Share on Facebook', 'viral').'" target="_blank" href="' . esc_url( $facebookURL ) . '" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Share on Twitter', 'viral').'" target="_blank" href="' . esc_url( $twitterURL ) .'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Share on Pinterest', 'viral').'" target="_blank" href="' . esc_url( $pinterestURL ) . '" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Email', 'viral').'" target="_blank" href="' . esc_url( $mailURL ) . '"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Compartir en WhatsApp', 'cta_rosario').'" target="_blank" href="' . esc_url( $whatsappURL ) . '" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>';
	$content .= '<a title="'.__('Compartir en Telegram', 'cta_rosario').'" target="_blank" href="' . esc_url( $telegramURL ) . '" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i></a>';
	$content .= '</div>';

	echo $content;
}
