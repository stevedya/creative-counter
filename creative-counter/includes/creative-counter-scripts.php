<?php
/**
 * Created by PhpStorm.
 * User: Steve
 * Date: 3/23/2018
 * Time: 1:44 AM
 */

// Add scripts

function creative_counter_add_scripts() {
    // Add main css
    wp_enqueue_style('creative-counter-style', plugins_url() . '/creative-counter/css/style.css');
    // Add main js
    wp_enqueue_script('creative-counter-script', plugins_url() . '/creative-counter/js/main.js');
    wp_enqueue_script('waypoint', 'http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js');
    wp_enqueue_script('counterup', plugins_url() . '/creative-counter/js/jquery.counterup.min.js');
}

add_action('wp_enqueue_scripts', 'creative_counter_add_scripts');