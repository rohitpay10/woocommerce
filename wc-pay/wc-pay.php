<?php
/*
 Plugin Name: Pay10 Gateway for WooCommerce
 Plugin URI: http://www.pay10.com/
 Description: Pay10 PG WooCommerce integration
 Version: 2.0
 Author: Rohit Kumar Singh <support@pay10.com>
 Author URI: http://www.pay10.com
 */

 add_action('plugins_loaded', 'woocommerce_pay_init', 0);

/**
 * [woocommerce_pay_init description]
 * @return [type] [description]
 */
function woocommerce_pay_init()
{
    if (! class_exists('WC_Payment_Gateway')) {
        return;
    }
    class WC_Gateway_Pay extends WC_Payment_Gateway
    {
        public function __construct()
        {
            global $woocommerce;
            $this->id           = 'pay';
            $this->method_title = __('Pay10 Payment Gateway', 'woocommerce');
            $this->icon         = apply_filters('woocommerce_pay_icon', plugins_url().'/wc-pay/images/logo.png');
            $this->method_description = __('Take payments from your customers via multiple modes.', 'woocommerce');//added in 2023
            $this->has_fields   = false;

            // Load the form fields and settings.
            $this->init_form_fields();
            $this->init_settings();

            $this->title                = $this->settings['title'];
            $this->description          = $this->settings['description'];
            $this->success_message      = $this->settings['success_message'];
            $this->failure_message      = $this->settings['failure_message'];
            $this->pay_id               = $this->settings['pay_id'];
            $this->salt                 = $this->settings['salt'];
            $this->currency_code        = $this->settings['currency_code'];
            $this->mode                 = $this->settings['mode'];
            $this->merchant_hosted_key = $this->settings['merchant_hosted_key'];

            if($this->settings['mode']=='no'){
              $this->pg_request_url       = 'https://secure.pay10.com/pgui/jsp/paymentrequest';
              }
            else{
              $this->pg_request_url       = 'https://uat.pay10.com/pgui/jsp/paymentrequest';
              }
            
            // Actions
            add_action('init', array( $this, 'check_pay_response' ));
            add_action('woocommerce_api_wc_gateway_pay', array( $this, 'check_pay_response' ));
            add_action('woocommerce_receipt_pay', array(&$this, 'receipt_page'));

            if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=')) {
                add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options' ));
            } else {
                add_action('woocommerce_update_options_payment_gateways', array($this, 'process_admin_options' ));
            }
        }

        // Generates the HTML for the admin settings page
        public function admin_options()
        {
            echo '<h3>Pay10 Payment Gateway</h3>';
            echo '<p>Pay10 Payment Gateway is a payment product which makes it extremely safe and easy to pay online.</p>';
            echo '<table class="form-table">';
            $this->generate_settings_html();
            echo '</table>';
        }

        // Get list of pages
        public function get_pages($title = false, $indent = true)
        {
            $wp_pages = get_pages('sort_column=menu_order');
            $page_list = array();
            if ($title) {
                $page_list[] = $title;
            }
            foreach ($wp_pages as $page) {
                $prefix = '';
                if ($indent) {
                    $has_parent = $page->post_parent;
                    while ($has_parent) {
                        $prefix .= ' - ';
                        $next_page = get_post($has_parent);
                        $has_parent = $next_page->post_parent;
                    }
                }
                $page_list[$page->ID] = $prefix . $page->post_title;
            }
            return $page_list;
        }

        /**
         * Check for page by name and return if exist else return false
         * @param  [type] $pagename [description]
         * @return [type]           [description]
         */
        public function get_page_by_name($pagename)
        {
            $pages = get_pages(array('post_type' => 'page','post_status' => 'publish'));
            foreach ($pages as $page) {
                if ($page->post_name == $pagename) {
                    return $page;
                }
            }
            return false;
        }

        // process current payment
        public function process_payment($order_id)
        {
            global $woocommerce;
            $order = new WC_Order($order_id);
            $this->return_url = trailingslashit(home_url()).'?wc-api=WC_Gateway_Pay&order_id='.$order->id;
            $this->init_settings();

            require_once dirname(__FILE__).'/PTPGModule.php';
            $transaction_request = new PTPGModule();

            /* Setting all values here */
            $transaction_request->setPayId($this->pay_id);
            $transaction_request->setPgRequestUrl($this->pg_request_url);
            $transaction_request->setSalt($this->salt);
            $transaction_request->setReturnUrl($this->return_url);
            $transaction_request->setCurrencyCode(356);
            $transaction_request->setTxnType('SALE');
            $transaction_request->setOrderId(date('dmyHis').rand(100,999)."_".$order->id);
            $transaction_request->setCustEmail($order->billing_email);
            $transaction_request->setCustName($order->billing_first_name.' '.$order->billing_last_name);
            $transaction_request->setCustStreetAddress1($order->billing_address_1);
            $transaction_request->setCustCity($order->billing_city);
            $transaction_request->setCustState($order->billing_state);
            $transaction_request->setCustCountry($order->billing_country);
            $transaction_request->setCustZip($order->billing_postcode);
            $transaction_request->setCustPhone($order->billing_phone);
            $transaction_request->setAmount($order->order_total * 100); // convert to Rupee from Paisa
            $transaction_request->setProductDesc($order->customer_note);
            $transaction_request->setCustShipStreetAddress1($order->shipping_address_1);
            $transaction_request->setCustShipCity($order->shipping_city);
            $transaction_request->setCustShipState($order->shipping_state);
            $transaction_request->setCustShipCountry($order->shipping_country);
            $transaction_request->setCustShipZip($order->shipping_postcode);
            $transaction_request->setCustShipPhone($order->billing_phone);
            $transaction_request->setCustShipName($order->billing_first_name.' '.$order->billing_last_name);

            // Generate postdata and redirect form
            $postdata = $transaction_request->createTransactionRequest();
            $output['messages'] = "<form id=\"payForm\" name=\"payForm\" method=\"post\" action=\"$this->pg_request_url\">";
            foreach ($postdata as $key => $value) {
                $output['messages'] .= "<input type=\"hidden\" name=\"$key\" value=\"$value\" />";
            }
            $output['messages'] .= "<p>Please wait.. Redirecting to payment page.</p></form>"; 
            $output['messages'] .= "<script language=\"javascript\" type=\"text/javascript\">";
            $output['messages'] .= "document.getElementById('payForm').submit();</script>";
            $output['result'] = "success";
            echo json_encode($output);
            exit();
        }

        // check response from payment gateway
        public function check_pay_response()
        {
            global $wpdb, $woocommerce;
            $order_id = $_GET['order_id'];
            $order = new WC_Order($order_id);
            $response = array_filter($_REQUEST);
            $checkout_page = $this->get_page_by_name('checkout');
            $cart_page = $this->get_page_by_name('cart');

            require_once dirname(__FILE__).'/PTPGModule.php';
            $transaction_request = new PTPGModule();
            //echo $this->merchant_hosted_key;exit;
            $transaction_request->setSalt($this->salt);
            $transaction_request->setMerchantHostedKey($this->merchant_hosted_key);
            $string = $transaction_request->aes_decryption($_POST['ENCDATA']);
            $response = $transaction_request->split_decrypt_string($string);

            /* WooCommerce update order */
            if (isset($response['RESPONSE_CODE'])) {
                if ($response['RESPONSE_CODE'] == '000' && $response['STATUS'] == 'Captured') {
                    $order->add_order_note('Order ID: ' . $order_id . '. ' . $response['RESPONSE_MESSAGE'] . '. Transaction Reference: ' . $response['TXN_ID'] . '.PG Order ID: ' . $response['ORDER_ID']);
                    $order->payment_complete();
                    $woocommerce->cart->empty_cart();
                    wc_add_notice($this->success_message, 'success');
                    $redirect = add_query_arg('key', $order->order_key, add_query_arg('order', $order_id, get_permalink($checkout_page->ID)));
                    wp_redirect($redirect);
                    exit;
                } else {
                    $order->update_status('Failed');
                    $order->add_order_note('Order ID: ' . $order_id . '. ' . $response['RESPONSE_MESSAGE'] . '. error:' . $response['RESPONSE_CODE']. '.PG Order ID: ' . $response['ORDER_ID']);
                    wc_add_notice($this->failure_message, 'error');
                    $redirect = add_query_arg('pay_for_order', 'true', add_query_arg('order', $order->order_key, add_query_arg('order_id', $order_id, get_permalink($cart_page->ID))));
                    wp_redirect($redirect);
                    exit;
                }
            } else {
                $order->update_status('Failed');
                wc_add_notice('Error validating transaction', 'error');
                $redirect = add_query_arg('pay_for_order', 'true', add_query_arg('order', $order->order_key, add_query_arg('order_id', $order_id, get_permalink($cart_page->ID))));
                wp_redirect($redirect);
                exit;
            }
        }

        // form fields for plugin
        public function init_form_fields()
        {
            $this->form_fields = array(
                'enabled' => array(
                    'title'   => __( 'Enable/Disable', 'woocommerce' ), 
                    'type'    => 'checkbox', 
                    'label'   => __( 'Enable Pay10 Gateway', 'woocommerce' ), 
                    'default' => 'yes'
                ), 
                'mode' => array(
                    'title'   => __('Testing', 'woocommerce'),
                    'type'    => 'checkbox',
                    'label'   => __('Enable Testing', 'woocommerce'),
                    'default' => 'no'
                ),
                'title' => array(
                    'title'       => __('Title', 'woocommerce'),
                    'type'        => 'text',
                    'description' => __('This controls the title which the user sees during checkout.', 'woocommerce'),
                    'default'     => __('Pay10 Gateway', 'woocommerce'),
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => __('Description', 'woocommerce'),
                    'type'        => 'textarea',
                    'description' => __('This controls the description which the user sees during checkout.', 'woocommerce'),
                    'default'     => __("Payment gateway", 'woocommerce'),
                    'desc_tip'    => true,
                ),
                'pay_id' => array(
                    'title'       => __('Pay ID', 'woocommerce'),
                    'type'        => 'text',
                    'description' => __('Please enter your Pay ID.', 'woocommerce'),
                    'default'     => ''
                ),
                'salt' => array(
                    'title'       => __('Salt', 'woocommerce'),
                    'type'        => 'text',
                    'description' => __('Please enter your secret salt.', 'woocommerce'),
                    'default'     => ''
                ),
                'merchant_hosted_key' => array(
                    'title'       => __('Merchant Hosted Key', 'woocommerce'),
                    'type'        => 'text',
                    'description' => __('Please enter merchant hosted key', 'woocommerce'),
                    'default'     => ''
                ),
                'success_message' => array(
                    'title'       => __('Success message', 'woocommerce'),
                    'type'        => 'text',
                    'description' => __('Message shown after successful transaction.', 'woocommerce'),
                    'default'     => 'Thank you for shopping with us. Your account has been charged and your transaction is successful. We will be shipping your order to you soon.',
                    'desc_tip'    => true,
                ),
                'failure_message' => array(
                    'title'       => __('Failure message', 'woocommerce'),
                    'type'        => 'text',
                    'description' => __('Message shown after failed transaction.', 'woocommerce'),
                    'default'     => 'Transaction Failed. Try again!!!',
                    'desc_tip'    => true,
                ),
            );
        } //
    }

    function add_pay_gateway($methods)
    {
        $methods[] = 'WC_Gateway_Pay';
        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'add_pay_gateway');
}
