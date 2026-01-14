<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!interface_exists('Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface')) {
    error_log('WooCommerce Blocks IntegrationInterface not found');
    return;
}

class ACO_WC_Checkout_Integration implements Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface {
    /**
     * Plugin settings.
     *
     * @var array
     */
    protected $settings = [];

    public function get_name() {
        return 'aco-financeira-wc-checkout-block';
    }

    public function initialize() {
        $this->settings = get_option($this->get_name() . '_settings', []);
        $this->register_scripts();
        add_filter('woocommerce_blocks_register_checkout_field', [$this, 'register_checkout_field'], 10, 2);
    }

    public function get_script_handles() {
        return ['aco-wc-checkout-frontend'];
    }

    public function get_editor_script_handles() {
        return [];
    }

    public function get_script_data() {
        return [];
    }

    private function register_scripts() {
        $script_path = 'block-assets/checkout/checkout-index.js'; // Verify this path
        $script_url = plugins_url($script_path, __DIR__);
        $script_asset_path = plugin_dir_path(__FILE__) . 'block-assets/checkout/checkout-index.asset.php';
        $script_full_path = plugin_dir_path(__FILE__) . $script_path;

        if (!file_exists($script_full_path)) {
            // error_log('Script file not found: ' . $script_full_path);
            // Fallback: Use a default version and dependencies
            $script_asset = ['dependencies' => ['wp-blocks', 'wp-element', 'wp-i18n'], 'version' => '1.0.0'];
        } else {
            $script_asset = file_exists($script_asset_path) 
                ? require $script_asset_path 
                : ['dependencies' => ['wp-blocks', 'wp-element', 'wp-i18n'], 'version' => filemtime($script_full_path)];
        }

        wp_register_script(
            'aco-wc-checkout-frontend',
            $script_url,
            $script_asset['dependencies'],
            $script_asset['version'],
            true
        );
    }

    public function register_checkout_field($field, $key) {
        if (!class_exists('ACO_WC_Checkout_Utils')) {
            error_log('ACO_WC_Checkout_Utils class not found');
            return $field;
        }

        $default_fields = ACO_WC_Checkout_Utils::get_core_fields();
        
        if (!is_array($default_fields) || !isset($default_fields[$key])) {
            return $field;
        }

        $customized_field = $default_fields[$key];
        $field = array_merge($field, [
            'label' => $customized_field['label'],
            'required' => $customized_field['required'],
            'type' => $customized_field['type'],
            'autocomplete' => $customized_field['autocomplete'] ?? '',
            'priority' => isset($customized_field['index']) ? $customized_field['index'] * 10 : 0,
        ]);
        
        return $field;
    }
}