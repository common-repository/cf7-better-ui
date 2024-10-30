<?php
/*
Plugin Name: Better UI for Contact Form 7
Description: Tiny plugin which improves UI for Contact Form 7
Author: Roman Kovalchik
Author URI: https://portfolio.kovalchik.com.ua/
Version: 1.0
*/

class CF7_BETTER_UI {

  public function __construct() {

    define('CF7_BETTER_UI_PLUGIN_DIR', dirname(__FILE__) . '/' );
    define('CF7_BETTER_UI_OPTIONS_FIELD_NAME', 'cf7-better-ui-options');
    
    // get existing settings
    $this->settings = array();
    $this->getSettings();

    // form loaders html & color css
    $this->loaders = array();
    $this->formLoaders();

    // loader sizes for transform scale
    $this->sizes = array(
      'small' => 0.5,
      'medium' => 0.7,
      'large' => 1
    );

    // add assets
    add_action('wp_enqueue_scripts', array($this, 'cf7BetterUIAssets') );
    add_action('admin_enqueue_scripts', array($this, 'cf7BetterUIAssetsAdmin') );

    // create custom plugin settings menu
    add_action('admin_menu', array($this, 'cf7BetterUiCreateMenu') );

    // deactivation hook
    register_deactivation_hook( __FILE__, array($this, 'cf7BetterUiDeactivation') );
  }

  // each loader has unique html and color styles
  public function formLoaders() {
    $this->loaders['facebook'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-facebook"><div></div><div></div><div></div></div>',
      'style' => '.cf7-better-ui-loader.lds-facebook div { background: color_holder }'
    );
    $this->loaders['ring'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-ring"><div></div><div></div><div></div><div></div></div>',
      'style' => '.cf7-better-ui-loader.lds-ring div { border-color: color_holder transparent transparent transparent; }'
    );
    $this->loaders['ripple'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-ripple"><div></div><div></div></div>',
      'style' => '.cf7-better-ui-loader.lds-ripple div { border-color: color_holder; }'
    );
    $this->loaders['spinner'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
      'style' => '.cf7-better-ui-loader.lds-spinner div:after { background: color_holder }'
    );
    $this->loaders['dual_ring'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-dual-ring"></div>', 
      'style' => '.cf7-better-ui-loader.lds-dual-ring:after { border-color: color_holder transparent color_holder transparent; }'
    );
    $this->loaders['ellipsis'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-ellipsis"><div></div><div></div><div></div><div></div></div>', 
      'style' => '.cf7-better-ui-loader.lds-ellipsis div { background: color_holder }'
    );
    $this->loaders['default'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>', 
      'style' => '.cf7-better-ui-loader.lds-default div { background: color_holder }'
    );
    $this->loaders['roller'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>', 
      'style' => '.cf7-better-ui-loader.lds-roller div:after { background: color_holder }'
    );
    $this->loaders['heart'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-heart"><div></div></div>', 
      'style' => '.cf7-better-ui-loader.lds-heart div, .cf7-better-ui-loader.lds-heart div:before, .cf7-better-ui-loader.lds-heart div:after { background: color_holder }'
    );
    $this->loaders['grid'] = array(
      'html' => '<div class="cf7-better-ui-loader lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>', 
      'style' => '.cf7-better-ui-loader.lds-grid div { background: color_holder }'
    );
  }

  // plugin deactivation
  public function cf7BetterUiDeactivation() {
    delete_option( 'cf7-better-ui-loader' );
    delete_option( 'cf7-better-ui-color' );
    delete_option( 'cf7-better-ui-size' );
  }

  // fill the array with settings from the database
  public function getSettings() {
    $this->settings['loader'] = get_option('cf7-better-ui-loader', 'facebook');
    $this->settings['color'] = get_option('cf7-better-ui-color', '#353535');
    $this->settings['size'] = get_option('cf7-better-ui-size', 'medium');
  }

  public function cf7BetterUIAssets() {
    wp_enqueue_style( 'cf7-better-ui-styles', plugins_url( 'assets/css.min.css', __FILE__ ) );
    wp_enqueue_script( 'cf7-better-ui-scripts', plugins_url( 'assets/js/main.js', __FILE__ ), array( 'jquery' ) );
    wp_localize_script( 'cf7-better-ui-scripts', 'CF7BetterUIData',
      array(
        'color' => $this->settings['color'],
        'loader' => $this->settings['loader'],
        'size' => $this->settings['size'],
        'loaders' => json_encode($this->loaders),
        'sizes' => json_encode($this->sizes)
       )
    );
  }

  public function cf7BetterUIAssetsAdmin() {
    wp_enqueue_style( 'cf7-better-ui-styles', plugins_url( 'assets/css.min.css', __FILE__ ) );
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'cf7-better-ui-admin-scripts', plugins_url('assets/admin/admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    wp_localize_script( 'cf7-better-ui-admin-scripts', 'CF7BetterUIAdmin',
      array( 
        'color' => $this->settings['color'],
        'loader' => $this->settings['loader'],
        'size' => $this->settings['size'],
        'loaders' => json_encode($this->loaders),
        'sizes' => json_encode($this->sizes)
       )
    );
  }

  public function cf7BetterUiCreateMenu() {
    // create new top-level menu
    add_menu_page('CF7 Better UI', 'CF7 Better UI', 'administrator', 'cf7-better-ui', array($this, 'cf7BetterUiPageContent') );

    // add settings link
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), function ( $links ) {
      array_unshift($links, '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=cf7-better-ui') ) .'">Settings</a>' );
      return $links;
    });
  
    // register settings
    add_action( 'admin_init', array($this, 'cf7BetterUiRegisterSettings') );
  }

  // register settings
  public function cf7BetterUiRegisterSettings() {
    register_setting( CF7_BETTER_UI_OPTIONS_FIELD_NAME, 'cf7-better-ui-loader', 'sanitize_text_field');
    register_setting( CF7_BETTER_UI_OPTIONS_FIELD_NAME, 'cf7-better-ui-color', 'sanitize_text_field');
    register_setting( CF7_BETTER_UI_OPTIONS_FIELD_NAME, 'cf7-better-ui-size', 'sanitize_text_field');
  }

  // plugin page content
  public function cf7BetterUiPageContent() { include_once (CF7_BETTER_UI_PLUGIN_DIR . 'includes/plugin-page.php'); }

}

new CF7_BETTER_UI();

?>