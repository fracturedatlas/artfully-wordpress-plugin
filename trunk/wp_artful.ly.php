<?php
/*
 * Plugin Name: artfully-widget
 * Description: Adds a Shortcode to Wordpress Post/Page with an Event ID. You can easily include a Dynamic Event ID Shortcode into your WordPress's Blog Post/Page.
 * Version: 1.0.1
 */
?>
<?php
define('NME_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));

function nme_add_scripts() {
    wp_enqueue_script('artfully.js', 'https://artfully-production.s3.amazonaws.com/assets/artfully-v3.js', array('jquery'));
    wp_enqueue_style('artfully.css', 'https://artfully-production.s3.amazonaws.com/assets/themes/default.css');
}

add_action('wp_head', 'nme_add_scripts', 1);

add_shortcode('art-event', 'art_event_data');

function art_event_data($atts) {
    extract(shortcode_atts(array(
                'id' => '21',
                    ), $atts));
    wp_enqueue_script( 'artfully_event', NME_PLUGIN_URL.'/js/artfully-event.js', false, false, true);
    wp_localize_script( 'artfully_event', 'artfully_event', array('eventId' => $id) );
    return '<div id="artfully-event"></div>';
}

add_shortcode('art-donation', 'art_donation_data');

function art_donation_data($atts) {
    extract(shortcode_atts(array(
                'id' => '21',
                    ), $atts));
    wp_enqueue_script( 'artfully_donation', NME_PLUGIN_URL.'/js/artfully-donation.js', false, false, true);
    wp_localize_script( 'artfully_donation', 'artfully_donation', array('donationId' => $id) );
    return '<div id="donation"></div>';
}

add_action('admin_enqueue_scripts', 'nme_load_admin_script');

function nme_load_admin_script() {
    wp_register_script('artful_setting_js', NME_PLUGIN_URL . '/js/artful-setting.js', array('jquery'));
    wp_enqueue_script('artful_setting_js');
    wp_localize_script('artful_setting_js','plugin',array('directory' => NME_PLUGIN_URL));
}

add_action('admin_menu', 'nme_artful_menu');

function nme_artful_menu() {
    add_options_page('Artful.ly', 'Artful.ly', 'manage_options', 'artful-settings', 'nme_artful_options');
}

function nme_artful_options() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<div class="wrap" style="margin-top:20px; margin-left:20px;">';
    echo 'Hello! We hope using this plugin will help you integrate <a href="http://artful.ly" target="blank">artful.ly</a> into your site.<br/><br/>';
    echo 'All you need to get donations and events into your site is right below :<br/><br/>';
    echo '<strong>DONATIONS</strong><br/><br/><br/>';
    echo 'For donations, you can add a shortcode to your pages<br/><br/>';
    echo 'Here is a sample shortcode for donations : <strong>[art-donation id="organizationID"]</strong><br/><br/>';
    echo '* Make sure you replace "organizationID" with your actual Organization ID. Organization ID\'s can be found by logging into your <a href="http://artful.ly" target="blank">artful.ly</a> account<br/><br/><br/>';
    echo '<strong>EVENTS</strong><br/><br/>';
    echo 'For events, simply add<br/><br/>';
    echo '<strong>[art-event id="eventID"]</strong><br/><br/>';
    echo '* Make sure you replace "eventID" with your actual event ID. Event ID\'s can be found by logging into your <a href="http://artful.ly" target="blank">artful.ly</a> account<br/><br/><br/>';
    echo '<strong>NIFTY BUTTONS</strong><br/><br/><br/>';
    echo 'If you forget the shortcodes, don\'t worry - there\'s a handy button on every post and page to access your <a href="http://artful.ly" target="blank">artful.ly</a> content<br/><br/>';
    echo 'Simple, wasn\'t it :-)<br/><br/><br/><br/>';
    echo 'And of course, if you have any questions, please submit a support request via our helpdesk :<br/><br/>';
    echo '<a href="https://artfully.zendesk.com/home" target="blank">https://artfully.zendesk.com/home</a><br/><br/>';
    echo '--<br/><br/>';
    echo 'created by Fractured Atlas and Arrow Root Media';
    echo '</div>';
}

add_action('admin_notices', 'nme_art_notice');

function nme_art_notice() {
    if (get_option('art_activated') != 'true') {
        echo '<div class="updated">
                <p>Thanks for activating Artful.ly. Visit your <a href="http://artful.ly">Artful.ly</a> settings page for more info</p>
                </div>';
        add_option('art_activated', 'true');
    } else {
        
    }
}

add_action('init', 'nme_artful_tinymce_addbuttons');

function nme_artful_tinymce_addbuttons() {
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }
    add_filter("mce_external_plugins", "nme_artful_tinymce_addplugin");
    add_filter('mce_buttons', 'nme_artful_tinymce_registerbutton');
}

function nme_artful_tinymce_registerbutton($buttons) {
    array_push($buttons, 'separator', 'polls');
    return $buttons;
}

function nme_artful_tinymce_addplugin($plugin_array) {
    $plugin_array['polls'] = plugins_url('artfully-widget/lib/tinymce/plugins/polls/editor_plugin.js');
    return $plugin_array;
}

add_filter('plugin_action_links', 'nme_art_plugin_action_links', 10, 2);

function nme_art_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=artful-settings">Settings</a>';
        array_push($links, $settings_link);
    }
    return $links;
}
?>