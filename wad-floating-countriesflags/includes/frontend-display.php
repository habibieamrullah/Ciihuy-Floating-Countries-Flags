<?php
// Enqueue frontend styles and scripts
add_action('wp_enqueue_scripts', 'wad_fcf_enqueue_scripts');

function wad_fcf_enqueue_scripts() {
    wp_enqueue_style(
        'wad-fcf-style',
        WAD_FCF_PLUGIN_URL . 'assets/css/frontend.css',
        array(),
        WAD_FCF_VERSION
    );
    
    wp_enqueue_script(
        'wad-fcf-script',
        WAD_FCF_PLUGIN_URL . 'assets/js/frontend.js',
        array('jquery'),
        WAD_FCF_VERSION,
        true
    );
}

// Add the floating flags to the footer
add_action('wp_footer', 'wad_fcf_display_flags');

function wad_fcf_display_flags() {
    $options = get_option('wad_fcf_settings');
    if (empty($options['flags'])) return;
    
    $position = isset($options['position']) ? $options['position'] : 'bottom-right';
    $enabled_flags = array();
    
    foreach ($options['flags'] as $code => $flag) {
        if (!empty($flag['enabled']) && !empty($flag['url'])) {
            $enabled_flags[$code] = $flag;
        }
    }
    
    if (empty($enabled_flags)) return;
    ?>
    <div class="wad-fcf-container wad-fcf-<?php echo esc_attr($position); ?>">
        <div class="wad-fcf-flags">
            <?php foreach ($enabled_flags as $code => $flag): ?>
                <a href="<?php echo esc_url($flag['url']); ?>" target="_blank" class="wad-fcf-flag" title="<?php echo esc_attr(ucfirst($code)); ?>">
                    <img src="https://flagcdn.com/32x24/<?php echo $code; ?>.png" alt="<?php echo $code; ?>">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}