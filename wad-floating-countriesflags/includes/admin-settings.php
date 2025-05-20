<?php
// Add admin menu
add_action('admin_menu', 'wad_fcf_add_admin_menu');
add_action('admin_init', 'wad_fcf_settings_init');

function wad_fcf_add_admin_menu() {
    add_options_page(
        __('Floating Countries Flags', 'wad_floating_countriesflags'),
        __('Floating Flags', 'wad_floating_countriesflags'),
        'manage_options',
        'wad-floating-flags',
        'wad_fcf_options_page'
    );
}

function wad_fcf_settings_init() {
    register_setting('wad_fcf_pluginPage', 'wad_fcf_settings');

    add_settings_section(
        'wad_fcf_pluginPage_section',
        __('Floating Flags Settings', 'wad_floating_countriesflags'),
        'wad_fcf_settings_section_callback',
        'wad_fcf_pluginPage'
    );

    add_settings_field(
        'wad_fcf_position',
        __('Position on Screen', 'wad_floating_countriesflags'),
        'wad_fcf_position_render',
        'wad_fcf_pluginPage',
        'wad_fcf_pluginPage_section'
    );

    add_settings_field(
        'wad_fcf_flags',
        __('Country Flags', 'wad_floating_countriesflags'),
        'wad_fcf_flags_render',
        'wad_fcf_pluginPage',
        'wad_fcf_pluginPage_section'
    );
}

function wad_fcf_position_render() {
    $options = get_option('wad_fcf_settings');
    $position = isset($options['position']) ? $options['position'] : 'bottom-right';
    ?>
    <select name='wad_fcf_settings[position]'>
        <option value='bottom-left' <?php selected($position, 'bottom-left'); ?>><?php _e('Bottom Left', 'wad_floating_countriesflags'); ?></option>
        <option value='bottom-right' <?php selected($position, 'bottom-right'); ?>><?php _e('Bottom Right', 'wad_floating_countriesflags'); ?></option>
        <option value='bottom-center' <?php selected($position, 'bottom-center'); ?>><?php _e('Bottom Center', 'wad_floating_countriesflags'); ?></option>
        <!--<option value='top-center' <?php selected($position, 'top-center'); ?>><?php _e('Top Center', 'wad_floating_countriesflags'); ?></option>-->
    </select>
    <?php
}

function wad_fcf_flags_render() {
    $options = get_option('wad_fcf_settings');
    $flags = isset($options['flags']) ? $options['flags'] : array();
    
    // List of available country flags (ISO 3166-1 alpha-2 codes)
    $available_flags = array(
        'us' => 'United States',
        'gb' => 'United Kingdom',
        'ca' => 'Canada',
        'au' => 'Australia',
        'de' => 'Germany',
        'fr' => 'France',
        'it' => 'Italy',
        'es' => 'Spain',
        'jp' => 'Japan',
        'br' => 'Brazil',
        'in' => 'India',
        'cn' => 'China',
        'ru' => 'Russia',
        'mx' => 'Mexico',
        'za' => 'South Africa',
        'id' => 'Indonesia',
        'sa' => 'Saudi Arabia',
        'ir' => 'Iran'
    );
    
    echo '<div class="wad-fcf-flags-container">';
    foreach ($available_flags as $code => $name) {
        $enabled = isset($flags[$code]['enabled']) ? $flags[$code]['enabled'] : false;
        $url = isset($flags[$code]['url']) ? $flags[$code]['url'] : '';
        ?>
        <div class="wad-fcf-flag-item">
            <label>
                <input type="checkbox" name="wad_fcf_settings[flags][<?php echo $code; ?>][enabled]" value="1" <?php checked($enabled, true); ?> />
                <img src="https://flagcdn.com/16x12/<?php echo $code; ?>.png" alt="<?php echo $name; ?>" title="<?php echo $name; ?>">
                <?php echo $name; ?>
            </label>
            <input type="text" name="wad_fcf_settings[flags][<?php echo $code; ?>][url]" value="<?php echo esc_url($url); ?>" placeholder="<?php _e('URL for this flag', 'wad_floating_countriesflags'); ?>" style="width: 300px; margin-left: 20px;">
        </div>
        <?php
    }
    echo '</div>';
}

function wad_fcf_settings_section_callback() {
    echo __('Configure the position and which country flags to display.', 'wad_floating_countriesflags');
}

function wad_fcf_options_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Floating Countries Flags Settings', 'wad_floating_countriesflags'); ?></h1>
        
        <form action='options.php' method='post'>
            <?php
            settings_fields('wad_fcf_pluginPage');
            do_settings_sections('wad_fcf_pluginPage');
            submit_button();
            ?>
        </form>
        
        <div class="wad-fcf-donate">
            <h2><?php _e('Support This Plugin', 'wad_floating_countriesflags'); ?></h2>
            <p><?php _e('If you find this plugin useful, please consider making a donation to support further development.', 'wad_floating_countriesflags'); ?></p>
            <form action="https://www.paypal.com/donate" method="post" target="_top">
                <input type="hidden" name="business" value="habibieamrullah@gmail.com" />
                <input type="hidden" name="item_name" value="Donation for WAD Floating Countries Flags Plugin" />
                <input type="hidden" name="currency_code" value="USD" />
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
            </form>
        </div>
    </div>
    
    <style>
        .wad-fcf-flags-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background: #fff;
        }
        .wad-fcf-flag-item {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .wad-fcf-flag-item:last-child {
            border-bottom: none;
        }
        .wad-fcf-flag-item img {
            vertical-align: middle;
            margin-right: 5px;
        }
        .wad-fcf-donate {
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            max-width: 600px;
        }
    </style>
    <?php
}