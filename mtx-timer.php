<?php
/**
 * Plugin Name:       Mtx Timer
 * Description:       A plugin to timer for posts in Gutenberg
 * Version:           0.1.0
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Author:            Marta Torre
 * Author URI:        https://en.martatorre.dev/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mtx-timer
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_mtx_timer_block_init() {
	register_block_type( __DIR__ . '/build', [
		'render_callback' => function( $attributes, $content ) {
			global $post;
			
			$post_content = wp_strip_all_tags( $post->post_content );
			$words_per_min = 255;
			$total_words = str_word_count( $post_content );
			$time = 'min (s)';
			$rawTime = $total_words / $words_per_min;
			$value = ceil( $rawTime );

			if( $rawTime < 1){

				$value = ceil( $rawTime * 60 );
				$time = 'sec (s) ';

			}
	
			return  str_replace( array('%value%', '%time%'), array( $value, $time), $content );
		}
	] );
}
add_action( 'init', 'create_block_mtx_timer_block_init' );

