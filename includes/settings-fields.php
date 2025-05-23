<?php
if (!defined('ABSPATH')) exit;

// Sanitization callback function
function custom_css_js_sanitize_code($input) {
    return wp_kses_post($input); // Allows safe HTML, CSS, JS
}

// Settings Fields
add_action('admin_init', function() {
    $fields = [
        'global_css'     => ['Global Custom CSS', 'dashicons-admin-site'],
        'desktop_css'    => ['Custom CSS for desktop', 'dashicons-desktop'],
        'tablet_css'     => ['Custom CSS for tablet', 'dashicons-tablet'],
        'landscape_css'  => ['Custom CSS for mobile landscape', 'dashicons-smartphone'],
        'mobile_css'     => ['Custom CSS for mobile', 'dashicons-smartphone'],
        'admin_css'      => ['Custom CSS for admin dashboard', 'dashicons-lock'],
        'print_css'      => ['Custom CSS for Print', 'dashicons-media-document'],
        'global_js'      => ['Global Custom JS', 'dashicons-editor-code'],
        'doc_ready_js'   => ['On document ready JS', 'dashicons-clock'],
    ];

    foreach ($fields as $key => [$label, $icon]) {
        register_setting('custom_css_js_group', $key, [
            'sanitize_callback' => 'custom_css_js_sanitize_code'
        ]);

        add_settings_section(
            "section_$key",
            "<span class='dashicons " . esc_attr($icon) . "'></span> " . esc_html($label),
            null,
            'custom-css-js'
        );

        add_settings_field($key, '', function() use ($key) {
            echo '<textarea name="' . esc_attr($key) . '" rows="8" cols="100" style="width:100%;">' . esc_textarea(get_option($key, '')) . '</textarea>';
        }, 'custom-css-js', "section_$key");
    }
});
