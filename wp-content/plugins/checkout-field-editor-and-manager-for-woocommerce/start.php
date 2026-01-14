<?php
/*
 * Plugin Name: Checkout Field Editor and Manager for WooCommerce
 * Version: 3.0.0
 * Description: WooCommerce checkout field editor and manager helps to manage checkout fields in WooCommerce
 * Author: Acowebs
 * Author URI: http://acowebs.com
 * Requires at least: 4.0
 * Tested up to: 6.8
 * Text Domain: checkout-field-editor-and-manager-for-woocommerce
 * WC requires at least: 4.0.0
 * WC tested up to: 10.2
 */

define('AWCFE_TOKEN', 'awcfe');
define('AWCFE_VERSION', '3.0.0');
define('AWCFE_FILE', __FILE__);
define('AWCFE_EMPTY_LABEL', 'awcfe_empty_label');
define('AWCFE_ORDER_META_KEY', '_awcfe_order_meta_key');// use _ not show in backend
define('AWCFE_FIELDS_KEY', 'awcfe_fields');
define('AWCFE_PLUGIN_NAME', 'WooCommerce checkout field editor and manager');
define('AWCFE_STORE_URL', 'https://api.acowebs.com');

require_once(realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes/helpers.php');

if (!function_exists('awcfe_init')) {

    function awcfe_init()
    {
        $plugin_rel_path = basename(dirname(__FILE__)) . '/languages'; /* Relative to WP_PLUGIN_DIR */
        load_plugin_textdomain('checkout-field-editor-and-manager-for-woocommerce', false, $plugin_rel_path);
    }

}

if (!function_exists('awcfe_autoloader')) {

    function awcfe_autoloader($class_name)
    {
        if (0 === strpos($class_name, 'AWCFE')) {
            $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
            $class_file = 'class-' . str_replace('_', '-', strtolower($class_name)) . '.php';
            require_once $classes_dir . $class_file;
        }
    }

}

if (!function_exists('AWCFE')) {

    function AWCFE()
    {
        $instance = AWCFE_Backend::instance(__FILE__, AWCFE_VERSION);
        return $instance;
    }

}
add_action('plugins_loaded', 'awcfe_init');
spl_autoload_register('awcfe_autoloader');
if (is_admin()) {
    AWCFE();
}
new AWCFE_Api();

new AWCFE_Front_End(__FILE__, AWCFE_VERSION);


add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );


add_action( 'before_woocommerce_init', function() {
    if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, false );
    }
} );


//block compatibility code.....
if (!function_exists('is_woocommerce_active')) {
	
    function is_woocommerce_active() {
        $active_plugins = (array) get_option('active_plugins', array());
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins) || class_exists('WooCommerce');
    }
}

if (is_woocommerce_active()) {
    // Include core classes

    
   
add_action('init', function() {
    load_plugin_textdomain('aco-wc-checkout-block', false, dirname(plugin_basename(__FILE__)) . '/languages/');
});

require_once plugin_dir_path(__FILE__) . 'includes/class-aco-wc-checkout-utils.php';

function aco_wc_checkout_block_activate() {
    if (!get_option('aco_wc_checkout_fields')) {
        update_option('aco_wc_checkout_fields', ACO_WC_Checkout_Utils::get_core_fields());
        error_log('ACO: Initialized aco_wc_checkout_fields with core fields');
    }
}
register_activation_hook(__FILE__, 'aco_wc_checkout_block_activate');

if (is_woocommerce_active()) {
    require_once plugin_dir_path(__FILE__) . 'includes/class-aco-wc-checkout-block.php';
    require_once plugin_dir_path(__FILE__) . 'includes/class-aco-wc-checkout-admin.php';
    require_once plugin_dir_path(__FILE__) . 'includes/class-aco-wc-checkout-store-api.php';

    add_action('before_woocommerce_init', function () {
        if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
        }
    });


    function run_aco_wc_checkout_block() {
        new ACO_WC_Checkout_Block();
        new ACO_WC_Checkout_Admin();
        ACO_WC_Checkout_Store_API::init();
    }
    add_action('plugins_loaded', 'run_aco_wc_checkout_block');
}
}
