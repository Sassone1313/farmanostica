<?php
if (!defined('WPINC')) {
    die;
}

class ACO_WC_Checkout_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        
    }

  public function add_admin_menu() {
    add_menu_page(
        __('WooCommerce Checkout Fields Editor', 'checkout-field-editor-and-manager-for-woocommerce'),
        __('Checkout Fields', 'checkout-field-editor-and-manager-for-woocommerce'),
        'manage_woocommerce',
        'aco-wc-checkout-block',
        [$this, 'render_admin_page'],
        'dashicons-admin-generic'
    );

     // Hide it visually using admin CSS
    add_action('admin_head', function () {
        echo '<style>#toplevel_page_aco-wc-checkout-block { display: none !important; }</style>';
    });
    
}



    public function render_admin_page() {
        echo '<div id="aco-wc-checkout-admin-root"></div>';
    }

    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_aco-wc-checkout-block') {
            return;
        }

        wp_enqueue_script('wp-api-fetch');

        $script_path = plugin_dir_path(__FILE__) . '../block-assets/admin/admin-index.js';
        $script_asset_path = plugin_dir_path(__FILE__) . '../block-assets/admin/admin-index.asset.php';
        
        // Ensure $script_asset is always defined
        $script_asset = ['dependencies' => ['wp-api-fetch'], 'version' => '1.0.0'];
        if (file_exists($script_asset_path)) {
            $script_asset = require $script_asset_path;
        } elseif (file_exists($script_path)) {
            $script_asset['version'] = filemtime($script_path);
        } else {
            error_log('ACO WC Checkout: Admin script or asset file not found at ' . $script_path);
        }

        wp_enqueue_script(
            'aco-wc-checkout-admin',
            plugins_url('block-assets/admin/admin-index.js', __DIR__),
            array_merge($script_asset['dependencies'], ['wp-api-fetch']),
            $script_asset['version'],
            true
        );

        // Re-add CSS if needed
        $style_path = plugin_dir_path(__FILE__) . '../block-assets/admin/admin-index.css';
        if (file_exists($style_path)) {
            wp_enqueue_style(
                'aco-wc-checkout-admin-style',
                plugins_url('block-assets/admin/admin-index.css', __DIR__),
                [],
                filemtime($style_path)
            );
        }

        wp_localize_script(
            'aco-wc-checkout-admin',
            'acoWcCheckoutSettings',
            [
                'nonce' => wp_create_nonce('wp_rest'),
                'restUrl' => rest_url('aco-wc-checkout/v1/settings'),
            ]
        );
    }
}