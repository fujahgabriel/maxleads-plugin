<?php

/**
 * Plugin Name: MaxLeads 
 * Plugin URI: https://www.maxleads.co/
 * Description: Maxleads help boost your conversions in an instant.  This plugin is to help install the script on your web page.
 * Version: 1.0
 * Author: Fujah Gabriel
 * Author URI: http://github.com/fujahgabriel
 **/

defined('ABSPATH') or die('Nope!');

class Maxleads
{
	/**
	 * The security nonce
	 *
	 * @var string
	 */
	private $_nonce = 'maxleads_admin';
	/**
	 * The option name
	 *
	 * @var string
	 */
	private $option_name = 'maxleads_data';
	/**
	 * Maxleads constructor.
	 *
	 * The main plugin actions registered for WordPress
	 */
	public function __construct()
	{
		add_action('wp_footer',                 array($this, 'addFooterCode'));
		// Admin page calls
		add_action('admin_menu',                array($this, 'addAdminMenu'));

		//add_action('admin_enqueue_scripts',     array($this, 'addAdminScripts'));
	}
	/**
	 * Returns the saved options data as an array
	 *
	 * @return array
	 */
	private function getData()
	{
		return get_option($this->option_name, array());
	}

	/**
	 * Adds the Maxleads label to the WordPress Admin Sidebar Menu
	 */
	public function addAdminMenu()
	{
		add_menu_page(
			__('MaxLeads', 'maxleads'),
			__('MaxLeads', 'maxleads'),
			'manage_options',
			'maxleads',
			array($this, 'adminLayout'),
			'dashicons-testimonial'
		);
	}
	/**
	 * Outputs the Admin Dashboard layout containing the form with all its options
	 *
	 * @return void
	 */
	public function adminLayout()
	{
		$data = $this->getData();

		if (isset($_POST["maxleads_install_script"])) {

			$store = array('maxleads_install_script' => $_POST["maxleads_install_script"]);
			update_option($this->option_name, $store);
			echo __('Saved!', 'maxleads');
			die();
		}
		echo '
		<style>
		* {
		  box-sizing: border-box;
		}
		
		input[type=text], select, textarea {
		  width: 100%;
		  padding: 12px;
		  border: 1px solid #ccc;
		  border-radius: 4px;
		  resize: vertical;
		}
		
		label {
		  padding: 12px 12px 12px 0;
		  display: inline-block;
		}
		
		input[type=submit] {
		  background-color: #4CAF50;
		  color: white;
		  padding: 12px 20px;
		  border: none;
		  border-radius: 4px;
		  cursor: pointer;
		  float: right;
		}
		
		input[type=submit]:hover {
		  background-color: #45a049;
		}
		
		.container {
		  border-radius: 5px;
		  background-color: #f2f2f2;
		  padding: 20px;
		}
		
		.col-25 {
		  float: left;
		  width: 25%;
		  margin-top: 6px;
		}
		
		.col-75 {
		  float: left;
		  width: 75%;
		  margin-top: 6px;
		}
		
		/* Clear floats after the columns */
		.row:after {
		  content: "";
		  display: table;
		  clear: both;
		}
		
		/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
		@media screen and (max-width: 600px) {
		  .col-25, .col-75, input[type=submit] {
			width: 100%;
			margin-top: 0;
		  }
		}
		</style>
			<h1>Maxleads Settings</h1>
			<p>Copy your install code here and save it</p>
			<hr>
			<form method="POST" action="">';

		//settings_fields('maxleads_all_options');

		echo '
			<div class="col-75">
			<div class="form-group">
				<label for="maxleads_test_option">Install Code</label><textarea name="maxleads_install_script" id="maxleads_install_script" class="form-control" rows="10">' . str_replace("\\","",$data["maxleads_install_script"]) . ' </textarea>
				</div>';

		submit_button();

		echo '</div></form>';
	}

	/**
     * Add the web app code to the page's footer
     *
     * 
     * We use the options saved from the admin page
     *
     *
     */
	public function addFooterCode()
    {
		$data = $this->getData();

		if ( ! is_admin() ) {
		echo str_replace("\\","",$data["maxleads_install_script"]);
		}
	}
}

/*
 * Starts our plugin class, easy!
 */
new Maxleads();
