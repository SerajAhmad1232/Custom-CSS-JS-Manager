<?php
if (!defined('ABSPATH')) exit;

add_action('admin_init', function () {
    if (!current_user_can('manage_options')) return;

    if (isset($_POST['custom_css_js_export']) && check_admin_referer('custom_css_js_backup_action', 'custom_css_js_backup_nonce')) {
        $options = [
            'global_css', 'desktop_css', 'tablet_css', 'landscape_css',
            'mobile_css', 'admin_css', 'print_css', 'global_js', 'doc_ready_js'
        ];

        $data = [];
        foreach ($options as $option) {
            $data[$option] = get_option($option, '');
        }

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="custom-css-js-backup-' . gmdate('Y-m-d_H-i-s') . '.json"');
        echo wp_json_encode($data);
        exit;
    }

    if (isset($_POST['custom_css_js_import']) && check_admin_referer('custom_css_js_backup_action', 'custom_css_js_backup_nonce')) {
        if (!empty($_FILES['custom_css_js_import_file']['tmp_name'])) {
            $tmp_name = sanitize_text_field($_FILES['custom_css_js_import_file']['tmp_name']);

            if (is_uploaded_file($tmp_name)) {
                $imported_data = file_get_contents($tmp_name);
                $json_data = json_decode($imported_data, true);

                if (is_array($json_data)) {
                    foreach ($json_data as $key => $value) {
                        update_option($key, wp_kses_post($value));
                    }
                    add_action('admin_notices', function () {
                        echo '<div class="notice notice-success"><p>' . esc_html__('Custom CSS/JS settings imported successfully.', 'custom-css-js-manager') . '</p></div>';
                    });
                } else {
                    add_action('admin_notices', function () {
                        echo '<div class="notice notice-error"><p>' . esc_html__('Invalid JSON file.', 'custom-css-js-manager') . '</p></div>';
                    });
                }
            }
        }
    }
});
