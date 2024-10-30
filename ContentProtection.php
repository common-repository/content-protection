<?php
/**
 * Plugin Name: Content Protection
 * Version: 1.0
 * Description: WordPress Content Protection Plugin
 * Author: Themexa
 * Author URI: https://themexa.com
 * Plugin URI:  https://themexa.com/content-protection
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Path to plugin file
 */
define( 'THEMEXA_CONTENT_PROTECTION_FILE', __FILE__ );

/**
 * Current plugin version.
 */
define( 'THEMEXA_CONTENT_PROTECTION', '1.0' );

if ( !class_exists('ContentProtection') ) {

    /**
     * Class SamplePlugin
     */
    class ContentProtection{

        /**
         * ProtectContent constructor.
         */
        public function __construct() {
            add_action( 'plugins_loaded', array( $this, 'init' ) );
        }

        /**
         * Initialize plugin
         */
        public function init() {
            include_once 'includes/ContentProtectionAdminSettings.php';
            include_once 'includes/ContentProtectionAdminAssets.php';
            include_once 'includes/ContentProtectionSetupActions.php';
            include_once 'includes/ContentProtectionCoreActions.php';

            new ContentProtectionAdminSettings();
            new ContentProtectionAdminAssets();
            new ContentProtectionSetupActions();
            new ContentProtectionCoreActions();
        }
    
    }

}

new ContentProtection();