<?php

/**
 * redirect functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package redirect
 */
add_action('after_setup_theme', 'redirect_setup');
function redirect_setup()
{
    load_theme_textdomain('redirect', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'redirect')));
}

function add_redirect_theme_page()
{
    add_theme_page("Redirect Theme Settings", "Redirect Theme Settings", "manage_options", "theme-options", "theme_option_page", null, 99);
}
add_action('admin_menu', 'add_redirect_theme_page');


function theme_option_page()
{
?>
    <div class="wrap">
        <h1>Redirect Theme Settings v0.0.1 <span style="font-size: small;">Developed By Mohamed Riyas</span></h1>

        <form method="post" action="options.php">
            <?php
            // display settings field on theme-option page
            settings_fields("theme-options-grp");
            // display all sections for theme-options page
            do_settings_sections("theme-options");
            submit_button();
            ?>
        </form>
    </div>
<?php }

function theme_section_description()
{
    echo '<p>Settings for Redirect Theme</p>';
}
function options_callback()
{
    $options = get_option('redirect_frontend');
    echo '<input name="redirect_frontend" id="redirect_frontend" type="checkbox" value="1" class="code" ' . checked(1, $options, false) . ' /> Redirect the wordpress frontend to custom domain.';
}
function display_redirection_url_element()
{
?>
    <input type="text" name="redirection_url" id="redirection_url" size="50" value="<?php echo get_option('redirection_url'); ?>" />
<?php
}
function methods_callback()
{
    $method = get_option('redirect_method');
    echo '<select name="redirect_method" id="redirect_method"><option value="" ' . selected(0, $method, false) . '>Select</option><option value="301" ' . selected(301, $method, false) . '>301 - Permanent</option><option value="302" ' . selected(302, $method, false) . '>302 - Temporary</option></select>';
}
function display_powered_by()
{
?>
    <h4>Powered By REV Media Group</h4>
<?php
}
function test_theme_settings()
{
    add_option('redirect_frontend', 0); // add theme option to database
    add_settings_section(
        'first_section',
        'Redirection Settings',
        'theme_section_description',
        'theme-options'
    );
    add_settings_field(
        'redirect_frontend',
        'Redirect Frontend',
        'options_callback',
        'theme-options',
        'first_section'
    ); //add settings field to the “first_section”
    register_setting('theme-options-grp', 'redirect_frontend');
    add_settings_field('redirection_url', 'Redirection URL', 'display_redirection_url_element', 'theme-options', 'first_section');
    register_setting('theme-options-grp', 'redirection_url');
    add_settings_field(
        'redirect_method',
        'Redirection Method',
        'methods_callback',
        'theme-options',
        'first_section'
    ); //add settings field to the “first_section”
    register_setting('theme-options-grp', 'redirect_method');
    add_settings_field('powered_by', '', 'display_powered_by', 'theme-options', 'first_section');
    register_setting('theme-options-grp', 'powered_by');
}
add_action('admin_init', 'test_theme_settings');


global $pagenow;
if (isset($_GET['activated']) && $pagenow == 'themes.php') {
    wp_redirect(admin_url('themes.php?page=theme-options'));
    exit;
}
