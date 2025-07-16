<?php
/**
 * Govart Bakery theme Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Govart Bakery theme
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_GOVART_BAKERY_THEME_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'govart-bakery-theme-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_GOVART_BAKERY_THEME_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


/**
 * --- AJOUTER LE CHAMP DATE DE RETRAIT WOOCOMMERCE ---
 */

 add_action( 'enqueue_block_assets', 'enqueue_custom_checkout_field_script' );

 function enqueue_custom_checkout_field_script() {
     if ( is_checkout() && function_exists( 'is_checkout_block_rendering' ) && is_checkout_block_rendering() ) {
         wp_enqueue_script(
             'govart-checkout-custom',
             get_stylesheet_directory_uri() . '/assets/js/checkout-custom.js',
             [ 'wp-i18n', 'wp-element', 'wp-hooks', 'wc-blocks-checkout' ],
             '1.0',
             true
         );
     }
 }

