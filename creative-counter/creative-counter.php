<?php
/**
 *Plugin Name: Creative Counter
 * Version: 0.0.1
 *Description: This is a plugin for displaying statistics that count up.
 *Author: Steven Stein
 *Author URI: https://www.stevensteinwand.com
 *
 */

//Make secure?
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//load scripts
require_once(plugin_dir_path(__FILE__). '/includes/creative-counter-scripts.php');

function creative_counter_shortcode()
{
    $name = get_option('creative_counter_names');
    $number = get_option('creative_counter_numbers');
    $result =  "<div id='creative-counter'>";
    $result .=  "\t<div id='creative-counter-col'>";
    $result .= "\t<span class='counter'>" . $number . "</span>";
    $result .= "\t<span class='stat-name'>" . $name . "</span>";
    $result .= "\t</div>";
    $result .= "</div>";

    return $result;
}

add_shortcode('creative-counter', 'creative_counter_shortcode');


/*
*  Admin Menu
*
*  This function will hold the init settings for the admin menu
*
*/
function creative_counter_admin_menu()
{
    //The sidebar in admin & options
    add_menu_page('Counter', 'Counter', 'manage_options', 'creative-counter-admin-menu', 'creative_counter_settings_page', '
dashicons-dashboard', 200);
}

/*
*  Settings Page
*
*  This function will hold the settings and layout for the settings page
*
*/
function creative_counter_settings_page()
{
    //Post to database!!
    if(array_key_exists('submit_stat_update', $_POST)) {
        update_option('creative_counter_names', $_POST['name']);
        update_option('creative_counter_numbers', $_POST['number']);
        ?>
        <div id="settings-error-settings-updated" class="updated settings-error notice is-dismissible">
            <strong>Stats have been saved!</strong>
        </div>
        <?php
    }
    //Retrieving from the database
    //Say none if there is none
    $name = get_option('creative_counter_names', '');
    $number = get_option('creative_counter_numbers', '');

    ?>
    <div class="wrap">
        <h2>Creative Counter</h2>
        <form action="" method="post">
            <div class="stat-cell">
                <h3>Stat One</h3>
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Enter The Stat Name" value="<?php print $name; ?>">
                <label for="number">Number</label>
                <input type="number" name="number" placeholder="Stat Amount" value="<?php print $number ?>">
            </div>
            <div class="stat-cell">
                <h3>Stat Two</h3>
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Enter The Stat Name" value="<?php print $name; ?>">
                <label for="number">Number</label>
                <input type="number" name="number" placeholder="Stat Amount" value="<?php print $number ?>">
            </div>
            <div class="stat-cell">
                <h3>Stat Three</h3>
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Enter The Stat Name" value="<?php print $name; ?>">
                <label for="number">Number</label>
                <input type="number" name="number" placeholder="Stat Amount" value="<?php print $number ?>">
            </div>
            <input type="submit" name="submit_stat_update" class="button button-primary" value="Save Stats">
        </form>

    </div>
    <?php
}

add_action('admin_menu', 'creative_counter_admin_menu');

?>