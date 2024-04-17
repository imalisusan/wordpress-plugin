<?php

/**
 * @package  ImaliPlugin
 */

/**
 * Plugin Name: Imali Plugin.
 * Plugin URI: http://imali.com/plugin
 * Description: This is my first plugin that does a checkout.
 * Version:1.0.0
 * Author:susan Imali
 * Author URI: http://imali.com
 * License: GPLV2 or later
 * Text Domain: Susan-checkout plugin
 */

/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

use Inc\Activate;
use Inc\Deactivate;


if (!class_exists('ImaliPlugin')) {

    class ImaliPlugin
    {

        /**
         * @var string
         */
        public string $plugin;

        /**
         * constructor
         */
        function __construct()
        {
            $this->plugin = plugin_basename(__FILE__);
        }

        /**
         * Returns the admin Actions
         * @return void
         */
        function register(): void
        {
            add_action('admin_enqueue_scripts', array($this, 'enqueue'));

            add_action('admin_menu', array($this, 'add_admin_pages'));

            add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
        }

        /**
         * Create a settings options on the plugin
         * @param $links
         * @return mixed
         */
        public function settings_link($links): mixed
        {
            $settings_link = '<a href="options-general.php?page=imali-plugin">Settings</a>';
            $links[] = $settings_link;
            return $links;
        }

        /**
         * The control panel for the plugin
         * @return void
         */
        public function add_admin_pages(): void
        {
            add_menu_page('Imali Plugin', 'Imali', 'manage_options', 'imali-plugin', array($this, 'admin_index'), 'dashicons-store', 110);
        }

        /**
         * The template
         * @return void
         */
        public function admin_index(): void
        {
            require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
        }

        protected function create_post_type(): void
        {
            add_action('init', array($this, 'custom_post_type'));
        }

        function custom_post_type(): void
        {
            register_post_type('checkout', ['public' => true, 'label' => 'Checkouts']);
        }

        /**
         * The assets
         * @return void
         */
        function enqueue(): void
        {
            // enqueue all our scripts
            wp_enqueue_style('mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__));
            wp_enqueue_script('mypluginscript', plugins_url('/assets/myscript.js', __FILE__));
        }

        

        function activate(): void
        {
            Activate::activate();
        }

        function deactivate(): void
        {
            Deactivate::deactivate();
        }

        // Fetch weather information from OpenWeatherMap API
        public function get_weather_info() {
            // Make API call to OpenWeatherMap API using wp_remote_get
            $api_url = 'http://api.openweathermap.org/data/2.5/weather?q=your_city&appid=your_api_key';
            $response = wp_remote_get($api_url);
            if (!is_wp_error($response)) {
                $body = wp_remote_retrieve_body($response);
                $weather_data = json_decode($body, true);
                return $weather_data;
            }
            return false;
        }

        // Hook to add weather information to checkout page
        public function add_weather_to_checkout() {
            $weather_data = $this->get_weather_info();
            if ($weather_data) {
                // Display weather information on checkout page
            }
        }

        

        
    }
    add_action('woocommerce_checkout_before_customer_details', 'add_weather_to_checkout');

    $imaliPlugin = new ImaliPlugin();
    $imaliPlugin->register();

    // activation
    register_activation_hook(__FILE__, array($imaliPlugin, 'activate'));

    // deactivation

    register_deactivation_hook(__FILE__, array($imaliPlugin, 'deactivate'));

}