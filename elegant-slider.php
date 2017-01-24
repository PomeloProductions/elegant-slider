<?php
/*
   Plugin Name: Elegant Slider
   Plugin URI: https://github.com/pomeloproductions/elegant-slider
   Version: 2.0.0
   Author: Pomelo Productions
   Description:  Easy to use Slider plugin
   Text Domain: elegant-slider
   License: GPLv3
  */

/// This slider has been built upon Huge It Slider source
namespace ElegantSlider;

use WordWrap;

function hasWordWrap() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'word-wrap/word-wrap.php' ) ) {
        add_action( 'admin_notices', '\ElegantSlider\showInstallErrorMessage' );

        deactivate_plugins( plugin_basename( __FILE__ ) );

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}
add_action( 'admin_init', '\ElegantSlider\hasWordWrap' );

function showInstallErrorMessage(){
    echo '<div class="error"><p>Sorry, but Elegant Slider requires Word Wrap to be installed and active.</p></div>';
}

function autoload($className) {
    $fileName = str_replace("ElegantSlider\\", "", $className);
    $fileName = str_replace("\\", "/", $fileName);
    if(file_exists(__DIR__ . "/classes/" . $fileName . ".php"))
        require(__DIR__ . "/classes/" . $fileName . ".php");
}

spl_autoload_register(__NAMESPACE__ . "\\autoload");


include_once(__DIR__ . '/../word-wrap/word-wrap.php');
WordWrap::init(basename(__DIR__));
