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

 add_action( 'enqueue_block_assets', 'enqueue_custom_checkout_field' );
 function enqueue_custom_checkout_field() {
     if ( is_checkout() && function_exists( 'is_checkout_block' ) && is_checkout_block() ) {
         wp_enqueue_script(
             'custom-checkout-block',
             get_stylesheet_directory_uri() . '/assets/js/checkout-custom.js',
             [ 'wp-i18n', 'wp-element', 'wp-hooks', 'wc-blocks-checkout' ],
             '1.0',
             true
         );
     }
 }

// Sauvegarde la date dans la commande
add_action( 'woocommerce_checkout_create_order', 'sauvegarder_date_retrait_blocks', 10, 2 );
function sauvegarder_date_retrait_blocks( $order, $data ) {
    if ( isset( $data['date_retrait'] ) ) {
        $order->update_meta_data( '_date_retrait', sanitize_text_field( $data['date_retrait'] ) );
    }
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'afficher_date_retrait_admin', 10, 1 );
function afficher_date_retrait_admin($order){
    $date = $order->get_meta( '_date_retrait' );
    if ( $date ) {
        echo '<p><strong>Date de retrait :</strong> ' . esc_html( $date ) . '</p>';
    }
}

add_action('woocommerce_store_api_checkout_order_processed', function( $order, $request ) {
    if ( empty( $request['date_retrait'] ) ) {
        throw new \WC_REST_Exception( 'woocommerce_invalid_date_retrait', __( 'Veuillez choisir une date de retrait.' ), 400 );
    }
}, 10, 2 );