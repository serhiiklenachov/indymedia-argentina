<?php

class WP_Deduplicator {
	private static $published = array();

	public static function add( $post = null ) {
		$post = get_post( $post );
		if ( !in_array( $post->ID, self::$published ) )
			array_push( self::$published, $post->ID );
	}
	
	public static function get() {
		return self::$published;
	}
}