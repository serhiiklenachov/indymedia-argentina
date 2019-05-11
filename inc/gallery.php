<?php
add_filter( 'post_gallery', 'indymedia_gallery_output', 10, 3);

function indymedia_gallery_output($output, $attr, $instance ) {
  global $post, $wp_locale;

  $attr = array_merge(
    array(
      'id'    => $post->ID,
      'order' => 'date'
    ),
    $attr
  );

	if ( ! empty( $attr['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $attr['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $attr['order'], 'orderby' => $attr['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $attr['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $attr['id'], 'exclude' => $attr['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $attr['order'], 'orderby' => $attr['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $attr['id'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $attr['order'], 'orderby' => $attr['orderby'] ) );
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

	$selector = uniqid('gallery_');

	$slider = "<div id='$selector' class='gallery flexslider'><ul class='slides'>";
	$carrousel = "<div id='$selector-carrousel' class='gallery-carrousel flexslider'><ul class='slides'>";

	$slide = reset($attachments);

	$attr = ( trim( $slide->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$slide->ID" ) : '';

	$slider .= "<li>" . wp_get_attachment_image( $slide->ID, 'medium_large', false, $attr ) . "</li>";
	$carrousel .= "<li>" . wp_get_attachment_image($slide->ID, 'thumbnail', false, $attr ) . "</li>";

	$slider .= "</ul></div>";
	$carrousel .= "</ul></div>";

	next($attachments);

	$leftMain = array();
	$leftNav = array();
	while (list($key, $slide) = each($attachments)) {
		$imageMain = wp_get_attachment_image_src($slide->ID, 'medium_large', false);
		array_push($leftMain, $imageMain[0]);
		$imageNav = wp_get_attachment_image_src($slide->ID, 'thumbnail', false);
		array_push($leftNav, $imageNav[0]);
	}

$script = "
<script type='text/javascript'>
jQuery(window).on('load',function() {
	var {$selector}_leftMain = " . json_encode($leftMain) . ";
	var {$selector}_leftNav = " . json_encode($leftNav) . ";

	jQuery('#$selector-carrousel').flexslider({
		animation: 'slide',
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 75,
		minItems: 4,
		maxItems: 8,
		itemMargin: 5,
		asNavFor: '#$selector',
		controlsContainer: '.flex-container'
	});

	jQuery('#$selector').flexslider({
		animation: 'slide',
		animationLoop: false,
		slideshow: false,
		controlNav: false,
		smoothHeight: true,
		sync: '#$selector-carrousel',
		start: function() { {$selector}_loadLeftImages(); },
		controlsContainer: '.flex-container'
	});

	function {$selector}_loadLeftImages() {
		var {$selector}_srcNav = {$selector}_leftNav.shift();
		var {$selector}_srcMain = {$selector}_leftMain.shift();

		var {$selector}_sliderNav = jQuery('#$selector-carrousel').data('flexslider');
		var {$selector}_sliderMain = jQuery('#$selector').data('flexslider');

		if ({$selector}_srcMain != undefined) {
			{$selector}_imgNav = jQuery('<img />');
			{$selector}_imgMain = jQuery('<img />');

			{$selector}_imgMain.on('load', function() {
				var {$selector}_slideNav = jQuery('<li />');
				{$selector}_slideNav.append({$selector}_imgNav);

				var {$selector}_slideMain = jQuery('<li />');
				{$selector}_slideMain.append({$selector}_imgMain);

				{$selector}_sliderNav.addSlide({$selector}_slideNav);
				{$selector}_sliderMain.addSlide({$selector}_slideMain);

				{$selector}_loadLeftImages();
			});

			{$selector}_imgNav.attr('src', {$selector}_srcNav);
			{$selector}_imgMain.attr('src', {$selector}_srcMain);
		}
	}
});
</script>
";

	$output = $slider . $carrousel . $script;

	return $output;
}