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

	$slider = "<div id='$selector' class='gallery flexslider'><ul class='slides'>";
	$carrousel = "<div id='$selector-carrousel' class='gallery-carrousel flexslider'><ul class='slides'>";
	
	foreach ( $attachments as $id => $attachment ) {
		$slider .= "<li>";
		$carrousel .= "<li>";

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		$slider .= wp_get_attachment_image($id, 'medium_large', false, $attr );
		$carrousel .= wp_get_attachment_image($id, 'thumbnail', false, $attr );

		$slider .= "</li>";
		$carrousel .= "</li>";
	}

	$slider .= "</ul></div>";
	$carrousel .= "</ul></div>";

	$loader = "<div class='$selector-loader loading'><h3>Cargando galería...</h3></div>";

$script = "
<script type='text/javascript'>
jQuery(window).on('load',function() {

	jQuery('#$selector-carrousel').flexslider({
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
		animation: 'slide',
		animationLoop: false,
		slideshow: false,
		controlNav: false,
		smoothHeight: true,
		sync: '#$selector-carrousel',
		start: function(slider) {
			jQuery('.$selector-loader').hide();
		}
	});
});
</script>
";

	$output = $loader . $slider . $carrousel . $script;

	return $output;
}