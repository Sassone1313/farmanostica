<?php
if (!defined('WPINC')) {
    die;
}

class ACO_WC_Checkout_Store_API {
    private static $extend;
    const IDENTIFIER = 'checkout-field-editor-and-manager-for-woocommerce';

    public static function init() {
        self::$extend = Automattic\WooCommerce\StoreApi\StoreApi::container()->get('Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema');
        self::extend_store();
        self::register_rest_endpoints();
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
    }

    public static function extend_store() {
        if (is_callable([self::$extend, 'register_endpoint_data'])) {
            self::$extend->register_endpoint_data([
                'endpoint'        => 'checkout',
                'namespace'       => self::IDENTIFIER,
                'schema_callback' => [self::class, 'extend_checkout_schema'],
                'schema_type'     => ARRAY_A,
            ]);
        }
    }

    public static function extend_checkout_schema() {
        $fields = get_option('aco_wc_checkout_fields', []);
        $schema = [];
        foreach ($fields as $field) {
            if (!isset($field['enable']) || $field['enable']) {
                $schema[$field['id']] = [
                    'description' => sprintf(__('%s added during checkout', 'checkout-field-editor-and-manager-for-woocommerce'), $field['label']),
                    'type'        => $field['type'] === 'number' ? ['number', 'null'] : ['string', 'null'],
                    'context'     => ['view', 'edit'],
                    'readonly'    => true,
                    'arg_options' => ['validate_callback' => function ($value) use ($field) {
                        return $field['type'] === 'number' ? (is_numeric($value) || is_null($value)) : (is_string($value) || is_null($value));
                    }],
                ];
            }
        }
        return $schema;
    }

    public static function register_rest_endpoints() {
        add_action('rest_api_init', function () {
            register_rest_route('aco-wc-checkout/v1', '/settings', [
                'methods' => 'GET',
                'callback' => [self::class, 'get_settings'],
                'permission_callback' => function () {
                    return current_user_can('manage_woocommerce');
                },
            ]);

            register_rest_route('aco-wc-checkout/v1', '/settings', [
                'methods' => 'POST',
                'callback' => [self::class, 'save_settings'],
                'permission_callback' => function () {
                    return current_user_can('manage_woocommerce');
                },
            ]);
        });
    }

    public static function get_settings() {
        return get_option('aco_wc_checkout_fields', []);
    }

    public static function save_settings(WP_REST_Request $request) {
        $fields = $request->get_param('fields');
        if (is_array($fields)) {
            update_option('aco_wc_checkout_fields', $fields);
        }
        return ['success' => true];
    }

    public static function register_routes() {
        // Add new endpoint for default fields
        register_rest_route('aco-wc-checkout/v1', '/default-fields', [
            'methods' => 'GET',
            'callback' => [__CLASS__, 'get_default_fields'],
            'permission_callback' => function () {
                return current_user_can('manage_woocommerce');
            },
        ]);

        register_rest_route('aco-wc-checkout/v1', '/default-fields', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'update_default_field'],
            'permission_callback' => function () {
                return current_user_can('manage_woocommerce');
            },
        ]);

        // New endpoint for resetting custom fields
        register_rest_route('aco-wc-checkout/v1', '/reset_custom-fields', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'reset_custom_fields'],
            'permission_callback' => function () {
                return current_user_can('manage_woocommerce');
            },
        ]);

        // New endpoint for resetting default fields
        register_rest_route('aco-wc-checkout/v1', '/reset_default-fields', [
            'methods' => 'POST',
            'callback' => [__CLASS__, 'reset_default_fields'],
            'permission_callback' => function () {
                return current_user_can('manage_woocommerce');
            },
        ]);
    }


    // Reset custom fields (deletes aco_wc_checkout_fields option)
    public static function reset_custom_fields() {
        $result = delete_option('aco_wc_checkout_fields');
        if ($result) {
            return new WP_REST_Response(['success' => true, 'message' => 'Custom fields deleted successfully'], 200);
        } else {
            return new WP_Error('delete_failed', 'Failed to delete custom fields', ['status' => 500]);
        }
    }

    // Reset default fields (deletes aco_wc_checkout_default_fields option)
    public static function reset_default_fields() {
        $result = delete_option('aco_wc_checkout_default_fields');
        if ($result) {
            return new WP_REST_Response(['success' => true, 'message' => 'Default fields deleted successfully'], 200);
        } else {
            return new WP_Error('delete_failed', 'Failed to delete default fields', ['status' => 500]);
        }
    }

    public static function update_default_field(WP_REST_Request $request) {
    $fields = $request->get_param('fields');
    $id = $request->get_param('id');
    $field = $request->get_param('field');
    $default_fields = get_option('aco_wc_checkout_default_fields', []);

    // Support batch update
    if (is_array($fields)) {
        foreach ($fields as $item) {
            if (isset($item['id'])) {
                $fid = $item['id'];
                $default_fields[$fid] = array_merge($default_fields[$fid] ?? [], $item);
            }
        }
        update_option('aco_wc_checkout_default_fields', $default_fields);
        return new WP_REST_Response(['success' => true, 'updated' => count($fields)], 200);
    }

    // Fallback: single field update (legacy)
    if ($id && $field) {
        $default_fields[$id] = array_merge($default_fields[$id] ?? [], $field);
        update_option('aco_wc_checkout_default_fields', $default_fields);
        return new WP_REST_Response(['success' => true], 200);
    }

    return new WP_Error('invalid_params', 'Missing field ID or data', ['status' => 400]);
}


    public static function get_default_fields() {
        if (!class_exists('ACO_WC_Checkout_Utils')) {
            return new WP_Error('missing_class', 'Required class not found', ['status' => 500]);
        }

        $core_fields = ACO_WC_Checkout_Utils::get_core_fields();
        $custom_fields = get_option('aco_wc_checkout_default_fields', []);

       
        // Merge custom changes with core fields
        foreach ($custom_fields as $id => $customizations) {
            if (isset($core_fields[$id])) {
                $core_fields[$id] = array_merge($core_fields[$id], $customizations);
            }
        }

        return new WP_REST_Response($core_fields, 200);
    }
}