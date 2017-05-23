<?php
/**
 * YouTube URLs utility class.
 *
 * @package WordPress
 * @subpackage StrathcomCMS
 */

/**
 * YouTube URLs utility class.
 */
class YouTubeURL {
	const VIDEO_ID_REGEXP = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
	const EMBED_URL_TEMPLATE = 'http://www.youtube.com/embed/%s%s';

	/**
	 * Retrieves video ID from YouTube URL.
	 *
	 * @param string $youtube_url YouTube URL to parse.
	 *
	 * @return string|null
	 */
	public static function parse_video_id( $youtube_url ) {
		$match = array();
		if ( preg_match( self::VIDEO_ID_REGEXP, $youtube_url, $match ) ) {
			return $match[1];
		}

		return null;
	}
}
