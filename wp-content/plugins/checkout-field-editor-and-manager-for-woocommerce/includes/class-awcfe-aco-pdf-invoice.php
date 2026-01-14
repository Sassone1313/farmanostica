<?php

if (!defined('ABSPATH'))
		exit;

class AWCFE_Aco_Pdf_invoice
{

		/**
		 * @var    object
		 * @access  private
		 * @since    1.0.0
		 */
		private static $_instance = null;

		/**
		 * The version number.
		 * @var     string
		 * @access  public
		 * @since   1.0.0
		 */
		public $_version;
		private $_active = false;

		public function __construct()
		{

			$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
				if( isset($awcfe_aco_pdf['enable']) && $awcfe_aco_pdf['enable'] == 1){

						add_filter( 'apifw_invoice_custom_billing_fields', array($this, 'awcfe_aco_invoice_billing'), 10, 2 );
						add_filter( 'apifw_invoice_custom_shipping_fields', array($this, 'awcfe_aco_invoice_shipping'), 10, 2 );

						add_filter( 'apifw_ps_custom_billing_fields', array($this, 'awcfe_aco_ps_billing'), 10, 2 );
						add_filter( 'apifw_ps_custom_shipping_fields', array($this, 'awcfe_aco_ps_shipping'), 10, 2 );

						add_filter( 'apifw_dn_custom_billing_fields', array($this, 'awcfe_aco_dn_billing'), 10, 2 );
						add_filter( 'apifw_dn_custom_shipping_fields', array($this, 'awcfe_aco_dn_shipping'), 10, 2 );

						add_filter( 'apifw_dl_custom_billing_fields', array($this, 'awcfe_aco_dl_billing'), 10, 2 );
						add_filter( 'apifw_dl_custom_shipping_fields', array($this, 'awcfe_aco_dl_shipping'), 10, 2 );

						add_filter( 'apifw_cn_custom_billing_fields', array($this, 'awcfe_aco_cn_billing'), 10, 2 );
						add_filter( 'apifw_cn_custom_shipping_fields', array($this, 'awcfe_aco_cn_shipping'), 10, 2 );

						add_filter( 'apifw_sl_custom_shipping_fields', array($this, 'awcfe_aco_sl_shipping'), 10, 2 );

				}

		}

		/**
		 *
		 *
		 * Ensures only one instance of WCPA is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @see WordPress_Plugin_Template()
		 * @return Main WCPA instance
		 */
		public static function instance($file = '', $version = '1.0.0')
		{
				if (is_null(self::$_instance)) {
						self::$_instance = new self($file, $version);
				}
				return self::$_instance;
		}

		public function is_active()
		{
				return $this->_active !== false;
		}


		function awcfe_aco_invoice_billing( $custom_fields, $order_id ) {
	
			$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
			if( isset($awcfe_aco_pdf['invoice']) && $awcfe_aco_pdf['invoice'] != ''){
				$fields = $awcfe_aco_pdf['invoice'];
		$order = wc_get_order($order_id);
				$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
				$area = 'billing';
				if( isset($awcf_data[$area]) ){
					$awcf_data = $awcf_data[$area];
					$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
					return $items;
				}
			}

		}

		function awcfe_aco_invoice_shipping( $custom_fields, $order_id ) {

			$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
			if( isset($awcfe_aco_pdf['invoice']) && $awcfe_aco_pdf['invoice'] != ''){
				$fields = $awcfe_aco_pdf['invoice'];
				// $awcf_data = ($order_id, AWCFE_ORDER_META_KEY, true);
		$order = wc_get_order($order_id);
				$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
				$area = 'shipping';
				if( isset($awcf_data[$area]) ){
					$awcf_data = $awcf_data[$area];
					$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
					return $items;
				}
			}

		}

		function awcfe_display_aco_pdf_items( $invoiceF, $awcf_data){

			if ($awcf_data) {
				$outString = '';
				foreach ($awcf_data as $key => $val) {

				 if (in_array($val['name'], $invoiceF)) {

								if ($val['type'] == 'file' ) {
										$file_det = json_decode($val['value'], true);
										if ($file_det["url"]) {
												if ($file_det["type"] == "image/jpg" || $file_det["type"] == "image/png" || $file_det["type"] == "image/gif" || $file_det["type"] == "image/jpeg") {
														$file_cnt = '<a href="' . $file_det["url"] . '" class="awcfe-file-items" target="_blank"><img src="' . $file_det["url"] . '" alt="' . $file_det["filename"] . '" style="max-height: 60px;" > <span>' . $file_det["filename"] . '</span></a>';
												} else {
														$file_cnt = '<a href="' . $file_det["url"] . '" class="awcfe-file-items" target="_blank"><img src="' . plugin_dir_url(__DIR__) . 'assets/images/text.png" alt="' . $file_det["filename"] . '" style="max-height: 60px;" > <span>' . $file_det["filename"] . '</span></a>';
												}
												//$outString .= $val['label'], $file_cnt;
												$outString .= '<br/>'.$file_cnt;
										}
								} else {
										if ($val['type'] == 'header' || $val['type'] == 'paragraph' ||$val['type'] == 'htmlf') {
												$outString .= '<br/>'.$val['value'];
										}
										if (!empty($val['value'])) {
												if (is_array($val['value'])) {
														$outString .= '<br/>'.esc_attr(implode(', ', $val['value']));
												} else {
														$outString .= '<br/>'.$val['value'];
												}
										}
								}

					}

				}

				if( $outString ){ return $outString; }

			}

		}


			function awcfe_aco_ps_billing( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['packing']) && $awcfe_aco_pdf['packing'] != ''){
						$fields = $awcfe_aco_pdf['packing'];
						// $awcf_data = get_post_meta($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'billing';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}

			function awcfe_aco_ps_shipping( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['packing']) && $awcfe_aco_pdf['packing'] != ''){
						$fields = $awcfe_aco_pdf['packing'];
						// $awcf_data = ($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'shipping';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}


			function awcfe_aco_dn_billing( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['delivery']) && $awcfe_aco_pdf['delivery'] != ''){
						$fields = $awcfe_aco_pdf['delivery'];
						// $awcf_data = get_post_meta($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'billing';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}

			function awcfe_aco_dn_shipping( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['delivery']) && $awcfe_aco_pdf['delivery'] != ''){
						$fields = $awcfe_aco_pdf['delivery'];
						// $awcf_data = ($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'shipping';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}


			function awcfe_aco_dl_billing( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['dispatch']) && $awcfe_aco_pdf['dispatch'] != ''){
						$fields = $awcfe_aco_pdf['dispatch'];
						// $awcf_data = get_post_meta($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'billing';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}

			function awcfe_aco_dl_shipping( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['dispatch']) && $awcfe_aco_pdf['dispatch'] != ''){
						$fields = $awcfe_aco_pdf['dispatch'];
						// $awcf_data = get_post_meta($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'shipping';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}

			function awcfe_aco_cn_billing( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['credit']) && $awcfe_aco_pdf['credit'] != ''){
						$fields = $awcfe_aco_pdf['credit'];
						// $awcf_data = get_post_meta($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'billing';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}

			function awcfe_aco_cn_shipping( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['credit']) && $awcfe_aco_pdf['credit'] != ''){
						$fields = $awcfe_aco_pdf['credit'];
						// $awcf_data = get_post_meta($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'shipping';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}

			function awcfe_aco_sl_shipping( $custom_fields, $order_id ) {

					$awcfe_aco_pdf = get_option('awcfe_aco_pdf');
					if( isset($awcfe_aco_pdf['shipping']) && $awcfe_aco_pdf['shipping'] != ''){
						$fields = $awcfe_aco_pdf['shipping'];
						// $awcf_data = get_post_meta($order_id, AWCFE_ORDER_META_KEY, true);
			$order = wc_get_order($order_id);
						$awcf_data = $order->get_meta(AWCFE_ORDER_META_KEY, true);
						$area = 'shipping';
						if( isset($awcf_data[$area]) ){
							$awcf_data = $awcf_data[$area];
							$items = $this->awcfe_display_aco_pdf_items($fields, $awcf_data);
							return $items;
						}
					}

				}


		/**
		 * Cloning is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __clone()
		{
				_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __wakeup()
		{
				_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
		}

}
