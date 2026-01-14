<?php
if (!defined('WPINC')) {
    die;
}
use Automattic\WooCommerce\Blocks\Domain\Services\CheckoutFields;
use Automattic\WooCommerce\Blocks\Package;
use Automattic\WooCommerce\Blocks\Assets\AssetDataRegistry;

class ACO_WC_Checkout_Block {
    public function __construct() {
        add_action('woocommerce_blocks_loaded', [$this, 'init_block_support']);
        add_action('woocommerce_admin_order_data_after_order_details', [$this, 'display_fields_admin'], 20, 1);
        add_action('init', [$this, 'register_fields']); // Move field registration to init
    }

    public function init_block_support() {
        // Removed register_fields() from here to avoid early translation
        add_action('woocommerce_store_api_checkout_update_order_from_request', [$this, 'save_fields'], 10, 2);
        add_action('woocommerce_blocks_checkout_block_registration', [$this, 'update_default_fields_data_with_block'], 999);

        if (class_exists('Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema')) {
            require_once plugin_dir_path(__FILE__) . 'class-aco-wc-checkout-store-api.php';
            if (class_exists('ACO_WC_Checkout_Store_API')) {
                ACO_WC_Checkout_Store_API::init();
            } else {
                error_log('ACO_WC_Checkout_Store_API class not found');
            }
        }

        if (interface_exists('Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface')) {
            add_action('woocommerce_blocks_checkout_block_registration', [$this, 'register_block_integration']);
        }
    }

    public function get_fields() {
        return get_option('aco_wc_checkout_fields', []);
    }
public function register_fields() {
        if (!function_exists('woocommerce_register_additional_checkout_field')) {
            return;
        }
        $fields = $this->get_fields();
        $template = get_block_template('woocommerce/woocommerce//checkout', 'wp_template');
        if ($template && $template->content) {
            $blocks = parse_blocks($template->content);
            $field_order = $this->extract_field_order($blocks);
            if (!empty($field_order)) {
                $ordered_fields = [];
                foreach ($field_order as $index => $field_id) {
                    $field = array_filter($fields, fn($f) => $f['id'] === $field_id);
                    if (!empty($field)) {
                        $field_data = reset($field);
                        $field_data['index'] = $index * 10;
                        $ordered_fields[] = $field_data;
                    }
                }
                $fields = array_merge($ordered_fields, array_filter($fields, fn($f) => !in_array($f['id'], $field_order)));
            }
        }
        
        foreach ($fields as $field) {
           
            if (!isset($field['enable']) || $field['enable']) {
                if (isset($field['is_default']) && $field['is_default']) {
                    continue; // Skip default fields
                }
                $location = in_array($field['location'], ['contact', 'address']) ? $field['location'] : 'order';
                $options = [];
                if ($field['type'] === 'text') {
                    woocommerce_register_additional_checkout_field([
                        'id' => "checkout-field-editor-and-manager-for-woocommerce/{$field['id']}",
                        'label' => __($field['label'], 'checkout-field-editor-and-manager-for-woocommerce'),
                        'optionalLabel' => isset($field['optionalLabel']) ? __($field['optionalLabel'], 'checkout-field-editor-and-manager-for-woocommerce') : $field['label'] . ' (optional)',
                        'location' => $location,
                        'type' => $field['type'],
                        'required' => isset($field['required']) ? $field['required'] : false,
                        'index' => (int) $field['index'],
                        'attributes' => [
                            'autocomplete' => isset($field['autocomplete']) ? $field['autocomplete'] : '',
                            'aria-describedby' => isset($field['aria-describedby']) ? $field['aria-describedby'] : '',
                            'aria-label' => isset($field['aria-label']) ? $field['aria-label'] : '',
                            'pattern' =>  empty($field['pattern'])  ? '^.{1,100}$' : $field['pattern'],
                            'title' => isset($field['description']) ? $field['description'] : '',
                            'data-custom' => isset($field['dataCustom']) ? $field['dataCustom'] : '',
                        ],
                    ]);
                } elseif ($field['type'] === 'select') {
                    if (!empty($field['options']) && is_array($field['options'])) {
                        foreach ($field['options'] as $sub_field) {
                            $options[] = [
                                'value' => $sub_field['value'],
                                'label' => $sub_field['label'],
                            ];
                        }
                    }
                    $field_args = [
                        'id' => "checkout-field-editor-and-manager-for-woocommerce/{$field['id']}",
                        'label' => __($field['label'], 'checkout-field-editor-and-manager-for-woocommerce'),
                        'location' => $location,
                        'type' => 'select',
                        'required' => isset($field['required']) ? $field['required'] : false,
                        'index' => (int) $field['index'],
                        'options' => $options,
                    ];
                    // Only add placeholder if it exists and is non-empty
                    if (!empty($field['placeholder'])) {
                        $field_args['placeholder'] = __($field['placeholder'], 'checkout-field-editor-and-manager-for-woocommerce');
                    }
                    woocommerce_register_additional_checkout_field($field_args);
                } elseif ($field['type'] === 'checkbox') {
                    woocommerce_register_additional_checkout_field([
                        'id' => "checkout-field-editor-and-manager-for-woocommerce/{$field['id']}",
                        'label' => __($field['label'], 'checkout-field-editor-and-manager-for-woocommerce'),
                        'required' => isset($field['required']) ? $field['required'] : false,
                        'location' => $location,
                        'index' => (int) $field['index'],
                        'type' => 'checkbox',
                    ]);
                }
            }
        }
    }

    private function extract_field_order($blocks) {
        $order = [];
        foreach ($blocks as $block) {
            if (strpos($block['blockName'], 'aco-wc-checkout/field-') === 0) {
                $field_id = $block['attrs']['fieldId'] ?? '';
                if ($field_id) {
                    $order[] = $field_id;
                }
            }
            if (!empty($block['innerBlocks'])) {
                $order = array_merge($order, $this->extract_field_order($block['innerBlocks']));
            }
        }
        return array_unique($order);
    }

    public function save_fields(\WC_Order $order, \WP_REST_Request $request) {
        $request_data = $request['extensions']['checkout-field-editor-and-manager-for-woocommerce'] ?? [];
        $fields = $this->get_fields();
        foreach ($fields as $field) {
            $value = $request_data[$field['id']] ?? '';
            if (!empty($value)) {
                $sanitized_value = $field['type'] === 'number' ? (float) $value : sanitize_text_field($value);
                $order->update_meta_data("_aco_wc_{$field['id']}", $sanitized_value);
            }
        }
        $order->save();
    }

    public function display_fields_admin($order) {
        $fields = $this->get_fields();
        foreach ($fields as $field) {
            $value = $order->get_meta("_aco_wc_{$field['id']}", true);
            if (!empty($value)) {
                echo '<p style="clear: both; margin: 0 !important;"></p>';
                echo '<p><strong>' . esc_html__($field['label'], 'checkout-field-editor-and-manager-for-woocommerce') . ':</strong> ' . esc_html($value) . '</p>';
            }
        }
    }

    public function enqueue_frontend_scripts() {
        if (!is_checkout()) {
            return;
        }
        $script_path = plugin_dir_path(__FILE__) . '../blocks-assets/checkout/checkout-index.js';
        $script_asset_path = plugin_dir_path(__FILE__) . '../blocks-assets/checkout/checkout-index.asset.php';
        $script_asset = file_exists($script_asset_path) 
            ? require $script_asset_path 
            : ['dependencies' => [], 'version' => file_exists($script_path) ? filemtime($script_path) : '1.0.0'];

        wp_enqueue_script(
            'aco-wc-checkout-frontend',
            plugins_url('blocks-assets/checkout/checkout-index.js', __DIR__),
            $script_asset['dependencies'],
            $script_asset['version'],
            true
        );
    }

    public function register_block_integration($integration_registry) {
        if (file_exists(plugin_dir_path(__FILE__) . 'class-aco-wc-checkout-integration.php')) {
            require_once plugin_dir_path(__FILE__) . 'class-aco-wc-checkout-integration.php';
            if (class_exists('ACO_WC_Checkout_Integration')) {
                $integration_registry->register(new ACO_WC_Checkout_Integration());
            } else {
                error_log('ACO_WC_Checkout_Integration class not defined in class-aco-wc-checkout-integration.php');
            }
        } else {
            error_log('File class-aco-wc-checkout-integration.php not found');
        }
    }

    public function update_default_fields_data_with_block($integration_registry) {
        if (!class_exists('Automattic\WooCommerce\Blocks\Package') || !class_exists('Automattic\WooCommerce\Blocks\Assets\AssetDataRegistry')) {
            error_log('WooCommerce Blocks classes not found.');
            return;
        }

        $checkout_fields = Package::container()->get(CheckoutFields::class);
        $asset_data_registry = Package::container()->get(AssetDataRegistry::class);
        
        // Get default fields with any customizations applied
        $default_address_fields = ACO_WC_Checkout_Utils::get_core_fields();

        // Get additional custom fields
        $additional_fields = array_filter(
            $checkout_fields->get_additional_fields(),
            function ($field) use ($default_address_fields) {
                return !isset($default_address_fields[$field['id']]);
            }
        );

        // Ensure default fields have proper structure for the checkout block
        foreach ($default_address_fields as $key => &$field) {

            if (!isset($field['enable']) || $field['enable']) {
                $field['id'] = isset($field['id']) ? $field['id'] : $key;
                $field['label'] = isset($field['label']) ? $field['label'] : '';
                $field['optionalLabel'] = isset($field['optionalLabel']) ? $field['optionalLabel'] : $field['label'] . ' (optional)';
                $field['required'] = isset($field['required']) ? $field['required'] : false;
                $field['hidden'] = isset($field['hidden']) ? $field['hidden'] : false;
                $field['index'] = isset($field['index']) ? (int)$field['index'] : 0;
            }
        }

        $merged_fields = array_merge($default_address_fields, $additional_fields);
        $asset_data_registry->add('defaultFields', $merged_fields);
    }
}