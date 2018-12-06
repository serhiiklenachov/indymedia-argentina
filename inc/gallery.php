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

	$slide = reset($attachments);

	$attr = ( trim( $slide->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$slide->ID" ) : '';
	$image_data = wp_get_attachment_image_src( $slide->ID, 'full', false );

	$slider .= "<li><a href='" . $image_data[0] . "'>" . wp_get_attachment_image( $slide->ID, 'full', false, $attr ) . "</a></li>";
	$carrousel .= "<li>" . wp_get_attachment_image($slide->ID, 'thumbnail', false, $attr ) . "</li>";

	$slider .= "</ul></div>";
	$carrousel .= "</ul></div>";

	next($attachments);

	$leftMain = array();
	$leftNav = array();
	while (list($key, $slide) = each($attachments)) {
		$imageMain = wp_get_attachment_image_src($slide->ID, 'full', false);
		array_push($leftMain, $imageMain[0]);
		$imageNav = wp_get_attachment_image_src($slide->ID, 'thumbnail', false);
		array_push($leftNav, $imageNav[0]);
	}

$script = "
<script type='text/javascript'>
jQuery(window).on('load',function() {
	var leftMain = " . json_encode($leftMain) . ";
	var leftNav = " . json_encode($leftNav) . ";

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
		start: function() { loadLeftImages(); }
	});

	function loadLeftImages() {
		var srcNav = leftNav.shift();
		var srcMain = leftMain.shift();

		var sliderNav = jQuery('#$selector-carrousel').data('flexslider');
		var sliderMain = jQuery('#$selector').data('flexslider');

		if (srcMain != undefined) {
			imgNav = jQuery('<img />');
			imgMain = jQuery('<img />');

			imgMain.on('load', function() {
				var slideNav = jQuery('<li />');
				slideNav.append(imgNav);

				var slideMain = jQuery('<li />');
				var linkMain = jQuery('<a href=' + srcMain + ' />');
				linkMain.append(imgMain);
				slideMain.append(linkMain);

				sliderNav.addSlide(slideNav);
				sliderMain.addSlide(slideMain);

				loadLeftImages();
			});

			imgNav.attr('src', srcNav);
			imgMain.attr('src', srcMain);
		}
	}
});
</script>
";

	$output = $slider . $carrousel . $script;

	return $output;
}