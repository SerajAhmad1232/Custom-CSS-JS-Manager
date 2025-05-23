<?php
if (!defined('ABSPATH')) exit;

// Enqueue CodeMirror assets and local themes
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook !== 'toplevel_page_custom-css-js') return;

    $plugin_version = '1.0.0';

    // Enqueue WP core CodeMirror
    wp_enqueue_code_editor(['type' => 'text/css']);
    wp_enqueue_script('code-editor');
    wp_enqueue_style('wp-codemirror');
    wp_enqueue_style('dashicons');

    // Load local CodeMirror themes
    $themes = ['dracula', 'monokai', 'material-darker', 'eclipse', 'neat'];
    foreach ($themes as $theme) {
        $theme_path = plugin_dir_path(__FILE__) . "../assets/css/codemirror/{$theme}.min.css";
        $theme_url  = plugin_dir_url(__FILE__) . "../assets/css/codemirror/{$theme}.min.css";
        if (file_exists($theme_path)) {
            wp_enqueue_style("cm-theme-{$theme}", $theme_url, [], '5.65.13');
        }
    }
});

// Render theme selector and initialize CodeMirror editors
add_action('admin_footer', function() {
    $screen = get_current_screen();
    if ($screen->id !== 'toplevel_page_custom-css-js') return;

    $themes = ['material-darker', 'dracula', 'monokai', 'eclipse', 'neat'];
    ?>
    <div style="margin-top: 20px;">
        <label for="theme-selector" style="font-weight: bold;">Select CodeMirror Theme:</label>
        <select id="theme-selector" style="margin-left: 10px;">
            <?php foreach ($themes as $theme): ?>
                <option value="<?php echo esc_attr($theme); ?>">
                    <?php echo esc_html(ucwords(str_replace('-', ' ', $theme))); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const defaultTheme = prefersDark ? 'material-darker' : 'eclipse';
        const storedTheme = localStorage.getItem('codemirrorTheme');
        const selectedTheme = storedTheme || defaultTheme;

        const themeSelector = document.getElementById('theme-selector');
        if (themeSelector) {
            themeSelector.value = selectedTheme;
        }

        const fields = {
            'global_css': 'css',
            'desktop_css': 'css',
            'tablet_css': 'css',
            'landscape_css': 'css',
            'mobile_css': 'css',
            'admin_css': 'css',
            'print_css': 'css',
            'global_js': 'javascript',
            'doc_ready_js': 'javascript'
        };

        const editors = {};

        for (const [id, mode] of Object.entries(fields)) {
            const textarea = document.querySelector(`textarea[name="${id}"]`);
            if (textarea) {
                editors[id] = wp.codeEditor.initialize(textarea, {
                    codemirror: {
                        mode: mode,
                        theme: selectedTheme,
                        lint: true,
                        gutters: ["CodeMirror-lint-markers"],
                        lineNumbers: true,
                        lineWrapping: true,
                        autoCloseBrackets: true,
                        matchBrackets: true,
                        styleActiveLine: true,
                        extraKeys: {
                            'F11': function(cm) { cm.setOption('fullScreen', !cm.getOption('fullScreen')); },
                            'Esc': function(cm) { if (cm.getOption('fullScreen')) cm.setOption('fullScreen', false); },
                            'Ctrl-Space': 'autocomplete'
                        }
                    }
                });
            }
        }

        if (themeSelector) {
            themeSelector.addEventListener('change', function () {
                const newTheme = this.value;
                localStorage.setItem('codemirrorTheme', newTheme);
                for (const editorKey in editors) {
                    if (editors[editorKey]?.codemirror) {
                        editors[editorKey].codemirror.setOption('theme', newTheme);
                    }
                }
            });
        }
    });
    </script>

    <style>
        .form-table th { display: none; }
        .form-table td { padding: 0 !important; }
        h2 span.dashicons { margin-right: 8px; vertical-align: middle; }
        #theme-selector { padding: 4px 8px; }
    </style>
    <?php
});
