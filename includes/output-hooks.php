<?php
if (!defined('ABSPATH')) exit;

// Frontend Output
add_action('wp_head', function() {
    echo '<style>';
    echo esc_html(get_option('global_css'));
    echo '@media (min-width: 1025px) {' . esc_html(get_option('desktop_css')) . '}';
    echo '@media (max-width: 1024px) and (min-width: 768px) {' . esc_html(get_option('tablet_css')) . '}';
    echo '@media (max-width: 767px) and (min-width: 481px) {' . esc_html(get_option('landscape_css')) . '}';
    echo '@media (max-width: 480px) {' . esc_html(get_option('mobile_css')) . '}';
    echo '</style>';
    echo '<style media="print">' . esc_html(get_option('print_css')) . '</style>';
});

// Admin CSS
add_action('admin_head', function() {
    echo '<style>' . esc_html(get_option('admin_css')) . '</style>';
});

// Frontend JS Output
add_action('wp_footer', function() {
    echo '<script>' . esc_js(get_option('global_js'));
    echo 'jQuery(document).ready(function($) {' . esc_js(get_option('doc_ready_js')) . '});';
    echo '</script>';
});
