<?php
/*
 * Plugin Name: WooCommerce Übersee payment option
 * Plugin URI: 
 * Description: WooCommerce Übersee payment option
 * Author: Sherin
 * Author URI: 
 * Version: 1.0.1
 *

 /*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter( 'woocommerce_payment_gateways', 'artf_add_gateway_class' );
function artf_add_gateway_class( $gateways ) {
	$gateways[] = 'WC_Ubersee_Gateway'; // your class name is here
	return $gateways;
}
 
/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action( 'init', 'artf_init_gateway_class' );
function artf_init_gateway_class() {
 
	class WC_Ubersee_Gateway extends WC_Payment_Gateway {
 
 		/**
 		 * Class constructor, more about it in Step 3
 		 */
 		public function __construct() {
 
				$this->id = 'ubersee'; // payment gateway plugin ID
				$this->icon = ''; // URL of the icon that will be displayed on checkout page near your gateway name
				$this->has_fields = true; // in case you need a custom credit card form
				$this->method_title =  __( 'Übersee Gateway', 'artifiche' );
				$this->method_description =  __( 'Description of Übersee payment gateway', 'artifiche' ); // will be displayed on the options page

				// gateways can support subscriptions, refunds, saved payment methods,
				// but in this tutorial we begin with simple payments
				$this->supports = array(
				'products'
				);

				// Method with all the options fields
				$this->init_form_fields();

				// Load the settings.
				$this->init_settings();
				$this->title = $this->get_option( 'title' );
				$this->description = $this->get_option( 'description' );
				$this->enabled = $this->get_option( 'enabled' );
				$this->testmode = 'yes' === $this->get_option( 'testmode' );
				$this->private_key = $this->testmode ? $this->get_option( 'test_private_key' ) : $this->get_option( 'private_key' );
				$this->publishable_key = $this->testmode ? $this->get_option( 'test_publishable_key' ) : $this->get_option( 'publishable_key' );

				// This action hook saves the settings
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

				// We need custom JavaScript to obtain a token
				add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );
 
 		}
 
		/**
 		 * Plugin options, we deal with it in Step 3 too
 		 */
 		public function init_form_fields(){
 
				$this->form_fields = array(
			'enabled' => array(
				'title'       => __( 'Enable/Disable', 'artifiche' ),
				'label'       => __( 'Enable Übersee', 'artifiche' ),
				'type'        => 'checkbox',
				'description' => '',
				'default'     => 'no'
			),
			'title' => array(
				'title'       => __( 'Title', 'artifiche' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'artifiche' ),
				'default'     => __( 'Übersee', 'artifiche' ),
				'desc_tip'    => true,
			),
			'description' => array(
				'title'       => __( 'Description', 'artifiche' ),
				'type'        => 'textarea',
				'description' => __( 'This controls the description which the user sees during checkout.', 'artifiche' ),
				'default'     => __( 'Übersee: bitte um Anfrage, gesonderte Oﬀerte je nach Land.', 'artifiche' ),
			),
			
		);
 
	 	}
 
		/**
		 * You will need it if you want your custom credit card form, Step 4 is about it
		 */
		// public function payment_fields() {
 
		
 
		// }
 
		/*
		 * Custom CSS and JS, in most cases required only when you decided to go with a custom credit card form
		 */
	 	public function payment_scripts() {
 
			// we need JavaScript to process a token only on cart/checkout pages, right?
			if ( ! is_cart() && ! is_checkout() && ! isset( $_GET['pay_for_order'] ) ) {
				return;
			}
		 
			// if our payment gateway is disabled, we do not have to enqueue JS too
			if ( 'no' === $this->enabled ) {
				return;
			}
 
	 	}
 
		/*
 		 * Fields validation, more in Step 5
		 */
		public function validate_fields() {
 
		
 
		}
 
		/*
		 * We're processing the payments here, everything about it is in Step 5
		 */
		public function process_payment( $order_id ) {
 
			$order = wc_get_order( $order_id );

		if ( $order->get_total() > 0 ) {
			// Mark as processing or on-hold (payment won't be taken until delivery).
			$order->update_status( apply_filters( 'woocommerce_ubersee_process_payment_order_status', $order->has_downloadable_item() ? 'on-hold' : 'processing', $order ), __( 'Payment to be made upon delivery.', 'woocommerce' ) );
		} else {
			$order->payment_complete();
		}

		// Remove cart.
		

		$found = false;
		$product_array = array();
		// Loop through cart items
		foreach( WC()->cart->get_cart() as $cart_item ) {
		$product_id = $cart_item['product_id'];
		array_push( $product_array, $product_id );
		}
		$products = implode( ',', $product_array );

		$length = count( $product_array );

		$key = ( $length > 1 ) ? 'mpid' : 'pid';

		$chosen_shipping_rates = WC()->session->get( 'chosen_shipping_methods' );

		// When 'local delivery' has been chosen as shipping rate
		if ( in_array( 'flat_rate:4', $chosen_shipping_rates ) )
		$found = true; 

		WC()->cart->empty_cart();
		$kontakt_url = get_permalink(get_field( 'set_contact_page', 'option' ));
		// Return thankyou redirect.
		return array(
			'result'   => 'success',
			//'redirect' => $this->get_return_url( $order ),
			'redirect' => $kontakt_url.'?'. $key .'='.$products,
		);

		
	 	}
 
		/*
		 * In case you need a webhook, like PayPal IPN etc
		 */
		public function webhook() {
 
		
 
	 	}
 	}
}