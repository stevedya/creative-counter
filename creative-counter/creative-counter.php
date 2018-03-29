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
defined('ABSPATH') or die('No script kiddies please!');

//load scripts
require_once(plugin_dir_path(__FILE__) . '/includes/creative-counter-scripts.php');

function creative_counter_shortcode()
{
    $myStats = get_option('creative_counter_options');


    $result = "<div id='creative-counter'>";

    foreach ($myStats as $stat) {

        $result .= "\t<div id='creative-counter-col'>";
        $result .= "\t<span class='counter'>" . $stat->params->statAmount . "</span>";
        $result .= "\t<span class='stat-name'>" . $stat->params->statName . "</span>";
        $result .= "\t</div>";

    }

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
{ ?>


    <div class="wrap">
        <table>
            <tr>
                <th>
                    Stat
                </th>
                <th>
                    Name
                </th>
                <th>
                    Amount
                </th>
                <th>
                    Remove
                </th>
            </tr>
            <tr>
                <?php //Retrieving from the database
                $myStats[] = '';
                $myStats = get_option('creative_counter_options');
                foreach ($myStats as $stat) { ?>
                <td>
                    <?php echo $stat->name; ?>
                </td>
                <td>
                    <?php echo $stat->params->statName; ?>
                </td>
                <td>
                    <?php echo $stat->params->statAmount; ?>
                </td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="stat_id" value="<?php echo $stat->params->statId ?>">
                        <input type="submit" name="stat_id_submit" class="button button-primary" value="Remove Stat">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        <h2>Creative Counter</h2>
        <p>Enter your new stat here.</p>
        <form action="" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter The Stat Name">
            <label for="number">Number</label>
            <input type="number" name="number" placeholder="Stat Amount">
            <input type="hidden" name="stat_id" value="<?php echo uniqid(rand()); ?>">
            <input type="submit" name="submit_stat_update" class="button button-primary" value="Add Stat">
            <p>Refresh the page after adding the stat</p>
        </form>
        <br>
    </div>

    <?php

    if (array_key_exists('submit_stat_update', $_POST)) {

        //Post to database!!
        $stat = new stdClass();
        $stat->name = "Stat";
        $stat->params->statId = $_POST['stat_id'];
        $stat->params->statName = $_POST['name'];
        $stat->params->statAmount = $_POST['number'];

        $myStats[$stat->params->statId = $_POST['stat_id']] = $stat;

        update_option('creative_counter_options', $myStats);

        ?>
        <div id="settings-error-settings-updated" class="updated settings-error notice is-dismissible">
            <strong>Stats have been saved!</strong>
        </div>
        <?php
    } ?>

    <form action="" method="post">
        <input type="submit" name="delete_stats" class="button button-primary" value="Delete All Stats">
    </form>

    <?php
    //remove one
    if (isset($_POST['stat_id_submit'])) {
        unset($myStats[$_POST['stat_id']]);
        update_option('creative_counter_options', $myStats);
    }

    // delete all in the array
    if (isset($_POST['delete_stats'])) {
        $myStats = get_option('creative_counter_options');
        $myStats = array();
        update_option('creative_counter_options', $myStats);
    }
    ?>
    <!--    --><?php //print_r($myStats);
    ?>
    <?php
}

add_action('admin_menu', 'creative_counter_admin_menu');

?>