<?php
add_filter( 'post_gallery', 'indymedia_gallery_output', 10, 3);

function indymedia_gallery_output($output, $attr, $instance ) {
	global $post, $wp_locale;

	$id = intval( $attr['id'] );

	if ( ! empty( $attr['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $attr['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $attr['order'], 'orderby' => $attr['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $attr['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $attr['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $attr['order'], 'orderby' => $attr['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $attr['order'], 'orderby' => $attr['orderby'] ) );
	}
	if ( empty( $attachments ) ) {
		return '';
	}
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $attr['size'], true ) . "\n";
		}
		return $output;
	}
	
	$selector = "gallery-{$instance}";

	$slider = "<div id='$selector' class='gallery flexslider'><div class='slides'>";
	$carrousel = "<div id='$selector-carrousel' class='gallery-carrousel flexslider'><div class='slides'>";
	
	foreach ( $attachments as $id => $attachment ) {
		$slider .= "<div>";
		$carrousel .= "<div>";

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		$slider .= wp_get_attachment_image($id, $attr['size'], false, $attr );
		$carrousel .= wp_get_attachment_image($id, 'thumbnail', false, $attr );

		$slider .= "</div>";
		$carrousel .= "</div>";
	}

	$slider .= "</div></div>";
	$carrousel .= "</div></div>";

$script = "
<script type='text/javascript'>
jQuery(window).on('load',function() {
	jQuery('#$selector-carrousel').flexslider({
		selector: '.slides > div',
		animation: 'slide',
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 75,
		minItems: 4,
		maxItems: 8,
		itemMargin: 5,
		asNavFor: '#$selector'
	});

	jQuery('#$selector').flexslider({
		selector: '.slides > div',
		animation: 'slide',
		animationLoop: false,
		slideshow: false,
		controlNav: false,
		smoothHeight: true,
		sync: '#$selector-carrousel'	
	});
});
</script>
";

	$output = $loader . $slider . $carrousel . $script;

	return $output;
}