<?php
if (!defined('ABSPATH')) exit;

// Admin Menu
add_action('admin_menu', function() {
    add_menu_page('Custom CSS/JS', 'Custom CSS/JS', 'manage_options', 'custom-css-js', 'custom_css_js_settings_page', 'dashicons-editor-code', 81);
});

// Settings Page
function custom_css_js_settings_page() {
    ?>
    <div class="wrap">
        <h1>Custom CSS & JS</h1>

        <div class="notice notice-info" style="padding:15px; margin-bottom:20px;">
            <p><strong>Usage Tips:</strong></p>
            <ul style="margin-left: 20px;">
                <li>To use jQuery code, wrap it in: <code>jQuery(function($){ ... });</code></li>
                <li>Or: <code>jQuery(document).ready(function($){ ... });</code></li>
                <li>Media query examples:
                    <ul>
                        <li><code>@media (min-width: 1025px) { ... }</code> — Desktop</li>
                        <li><code>@media (max-width: 1024px) and (min-width: 768px) { ... }</code> — Tablet</li>
                        <li><code>@media (max-width: 767px) and (min-width: 481px) { ... }</code> — Landscape Mobile</li>
                        <li><code>@media (max-width: 480px) { ... }</code> — Mobile</li>
                    </ul>
                </li>
            </ul>
        </div>

        <form method="post" action="options.php">
            <?php
            settings_fields('custom_css_js_group');
            do_settings_sections('custom-css-js');
            submit_button();
            ?>
        </form>

        <p style="margin-top:20px;">
            <label for="theme-selector"><strong>Code Editor Theme:</strong></label>
            <select id="theme-selector">
                <option value="default">Default</option>
                <option value="material-darker" selected>Material Darker</option>
                <option value="dracula">Dracula</option>
                <option value="monokai">Monokai</option>
                <option value="eclipse">Eclipse</option>
                <option value="neat">Neat</option>
            </select>
        </p>

        <hr>
        <h2>Backup / Restore</h2>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('custom_css_js_backup_action', 'custom_css_js_backup_nonce'); ?>
            <p>
                <input type="submit" name="custom_css_js_export" class="button button-primary" value="Export Settings">
                <input type="file" name="custom_css_js_import_file" accept=".json">
                <input type="submit" name="custom_css_js_import" class="button" value="Import Settings">
            </p>
        </form>
    </div>
    <?php
}