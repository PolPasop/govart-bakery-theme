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

// Ajouter un champ "Date de retrait" au checkout WooCommerce
/*
add_action( 'woocommerce_after_order_notes', 'ajouter_champ_date_retrait' );
function ajouter_champ_date_retrait( $checkout ) {
    echo '<div id="date_retrait_field"><h3>' . __('Date de retrait') . '</h3>';

    woocommerce_form_field( 'date_retrait', array(
        'type'          => 'date',
        'class'         => array('form-row-wide'),
        'label'         => __('Choisissez votre date de retrait'),
        'required'      => true,
    ), $checkout->get_value( 'date_retrait' ));

    echo '</div>';
}
*/


echo '<div style="border:2px solid red; padding:10px;">Test hook actif</div>';



// Valider le champ à la commande
add_action('woocommerce_checkout_process', 'verifier_date_retrait');
function verifier_date_retrait() {
    if ( empty( $_POST['date_retrait'] ) ) {
        wc_add_notice( __( 'Merci de choisir une date de retrait.' ), 'error' );
    }
}

// Sauvegarder la date de retrait dans la commande
add_action( 'woocommerce_checkout_update_order_meta', 'enregistrer_date_retrait' );
function enregistrer_date_retrait( $order_id ) {
    if ( ! empty( $_POST['date_retrait'] ) ) {
        update_post_meta( $order_id, '_date_retrait', sanitize_text_field( $_POST['date_retrait'] ) );
    }
}

// Afficher la date de retrait dans l'admin
add_action( 'woocommerce_admin_order_data_after_billing_address', 'afficher_date_retrait_admin', 10, 1 );
function afficher_date_retrait_admin($order){
    $date = get_post_meta( $order->get_id(), '_date_retrait', true );
    if ($date) {
        echo '<p><strong>Date de retrait :</strong> ' . esc_html( $date ) . '</p>';
    }
}

add_action( 'woocommerce_after_order_notes', 'ajouter_champ_date_retrait' );
function ajouter_champ_date_retrait( $checkout ) {
    echo '<div style="border:2px solid red;padding:10px;">HOOK actif</div>';
    // ... le reste du champ
}