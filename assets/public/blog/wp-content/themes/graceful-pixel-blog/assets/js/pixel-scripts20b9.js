/**
 * Graceful Pixel Blog Scripts
 *
 * Contains all JavaScript for the theme including:
 * - Trending ticker speed calculation
 * - Latest posts Owl Carousel initialization
 * - Post slider Owl Carousel initialization
 *
 * @package Graceful Pixel Blog
 */
( function ( $ ) {
	'use strict';

	/**
	 * Trending Ticker — dynamic speed based on pixels per second.
	 * Speed value is passed via wp_localize_script as gracefulTickerSettings.pxPerSec.
	 */
	function setTickerSpeed() {
		var track = document.getElementById( 'trending-ticker-track' );
		if ( ! track ) {
			return;
		}

		var pxPerSec = ( window.gracefulTickerSettings && window.gracefulTickerSettings.pxPerSec )
			? parseInt( window.gracefulTickerSettings.pxPerSec, 10 )
			: 150;

		// scrollWidth is double the real content width because items are duplicated.
		var trackWidth = track.scrollWidth / 2;
		var duration   = trackWidth / pxPerSec;

		track.style.animationDuration = duration.toFixed( 2 ) + 's';
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', setTickerSpeed );
	} else {
		setTickerSpeed();
	}

	var resizeTimer;
	window.addEventListener( 'resize', function () {
		clearTimeout( resizeTimer );
		resizeTimer = setTimeout( setTickerSpeed, 150 );
	} );

	/**
	 * Initialize Owl Carousel for Latest Posts Ticker
	 */
	$( document ).ready( function () {
		if ( $( '#graceful-latest-posts-ticker' ).length ) {
			$( '#graceful-latest-posts-ticker' ).owlCarousel( {
				items: 1,
				loop: true,
				margin: 0,
				autoplay: true,
				autoplayTimeout: 4000,
				autoplayHoverPause: true,
				nav: true,
				dots: true,
				navText: [
					'<span>&#8249;</span>',
					'<span>&#8250;</span>'
				],
				responsive: {
					0:    { items: 1 },
					768:  { items: 1 },
					1200: { items: 1 }
				}
			} );
		}

		/**
		 * Initialize Owl Carousel for Post Slider
		 */
		if ( $( '#graceful-post-slider' ).length ) {
			$( '#graceful-post-slider' ).owlCarousel( {
				loop: false,
				margin: 10,
				nav: true,
				dots: true,
				animateIn: 'fadeIn',
				animateOut: 'fadeOut',
				autoplay: false,
				margin: 40,
				autoHeight: true,
				responsive: {
					0: {
						items: 1
					},
					640: {
						items: 1
					},
					1000: {
						items: 1
					}
				}
			} );

			// Disable tabindex for prev/next in slider for accessibility.
			$( '#graceful-post-slider .owl-prev' ).attr( 'tabindex', '-1' );
			$( '#graceful-post-slider .owl-next' ).attr( 'tabindex', '-1' );
		}
	} );

}( jQuery ) );
