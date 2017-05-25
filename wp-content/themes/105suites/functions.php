<?php

function theme_enqueue_styles() {
    wp_enqueue_style( '105suites-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// [suites_slider]
function suites_slider( $atts )
{
	$suites = new WP_Query( array( 
		'post_type' => 'avada_portfolio',
		'post_status'	=> 'publish',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy'	=> 'portfolio_category',
				'field'	=> 'id',
				'terms' => 38,
			)
		)
	) );

	$html = '<div class="Suites__container">';

	if( $suites->have_posts() )
	{
		$html .= '<div class="Suites__flexslider" id="Suites__slider">';
		$html .= '<ul class="slides">';

		while( $suites->have_posts() )
		{
			$suites->the_post();

			$html .= '<li class="slide">';
				$html .= '<div class="Card">';
					$html .= '<a href='.get_post_permalink().'>';
						$html .= '<img src='.get_the_post_thumbnail_url().' />';
					$html .= '</a>';
					$html .= '<div class="Card__content">';
						$html .= '<h4 class="Card__title">';
							$html .= '<a href='.get_post_permalink().'>'.get_the_title().'</a>';
						$html .= '</h4>';

						$html .= '<div class="Card__info">';
							$html .= get_field('hover_info');
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
			$html .= '</li>';
		}		

		$html .= '</ul>';
		$html .= '</div>';

		// Custom navigation
		$html .= '<div class="suites-navigation">';
			$html .= '<a href="#" class="flex-prev"><i class="fa fa-chevron-left"></i></a>';
				$html .= '<div class="suites-control-container"></div>';
			$html .= '<a href="#" class="flex-next"><i class="fa fa-chevron-right"></i></a>';
		$html .= '</div>';

		$html .= '</div>'; // Suites__container
		
		/* Restore original Post Data */
		wp_reset_postdata();		
	}

	return $html;
}

add_shortcode( 'suites_slider', 'suites_slider' );

// [services_slider]
function services_slider( $atts )
{
	$suites = new WP_Query( array( 
		'post_type' => 'avada_portfolio',
		'post_status'	=> 'publish',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy'	=> 'portfolio_category',
				'field'	=> 'id',
				'terms' => 39, // Services category
			)
		)
	) );

	$html = '<div class="Suites__container Services__container">';

	if( $suites->have_posts() )
	{
		$html .= '<div class="Suites__flexslider" id="Services__slider">';
		$html .= '<ul class="slides">';

		while( $suites->have_posts() )
		{
			$suites->the_post();

			$html .= '<li class="slide">';
					$html .= '<img src='.get_the_post_thumbnail_url(get_the_ID(), array(80,80)).' />';
			$html .= '</li>';
		}		

		$html .= '</ul>';
		$html .= '</div>';

		// Custom navigation
		$html .= '<div class="suites-navigation services-navigation">';
			$html .= '<a href="#" class="flex-prev"><i class="fa fa-chevron-left"></i></a>';
				$html .= '<div class="suites-control-container"></div>';
			$html .= '<a href="#" class="flex-next"><i class="fa fa-chevron-right"></i></a>';
		$html .= '</div>';

		$html .= '</div>'; // Services__container
		
		/* Restore original Post Data */
		wp_reset_postdata();		
	}

	return $html;
}

add_shortcode( 'services_slider', 'services_slider' );

/**
 * Custom main.min.js
 */
function suites_js()
{
	wp_deregister_script( 'avada' );
	wp_register_script( '105suites-script', '/wp-content/themes/105suites/dist/js/app.js', array( 'avada' ), false, false );
	wp_enqueue_script( '105suites-script' );
	// wp_register_script( '105suites-booking-form', '/wp-content/themes/105suites/dist/js/BookingForm.js', array( 'avada' ), false, false );
	// wp_enqueue_script( '105suites-booking-form' );
}

// Hook into the 'wp_enqueue_scripts' suites_js
add_action( 'wp_enqueue_scripts', 'suites_js' );

