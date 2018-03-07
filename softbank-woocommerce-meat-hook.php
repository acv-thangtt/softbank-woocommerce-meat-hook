<?php
/**
 * Plugin Name: Softbank WooCommerce Meat Hook
 * Plugin URI: http://fixbugtodie.com
 * Description: Softbank WooCommerce Meat Hook
 * Version: 1.0.0
 * Author: fixbugtodie
 * Author URI: http://fixbugtodie.com
 * Requires at least: 4.4
 * Tested up to: 4.9.4
 *
 * Text Domain: softbank-woocommerce-meat-hook
 * Domain Path: /languages/
 * Docs: https://developer.sbpayment.jp
 *
 * @package FixBugToDie
 * @category WooCommerce
 * @author fixbugtodie
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'spgfw_request_get_pagecon_url', function () {
	return 'http://stbfep.sps-system.com/MerchantPayResultRecieveSuccess.jsp';
} );

add_action( 'spgfw_after_get_response_by_method_redirect', function ( $order, $sb_key, $sb_val ) {
	if ( SPGFW_COMPLETED === $sb_key ) {
		global $spgfw;

		$order_id    = $order->get_id();
		$tracking_id = isset( $_REQUEST['res_tracking_id'] ) ? esc_attr( $_REQUEST['res_tracking_id'] ) : '';

		if ( $tracking_id ) {
			update_post_meta( $order_id, $spgfw->acf_tracking_id(), $tracking_id );
		}
	}
}, 10, 3 );