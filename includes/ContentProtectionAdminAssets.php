<?php

if ( !class_exists('ContentProtectionAdminAssets') ) {

    /**
     * Class ContentProtectionAdminAssets
     */
    class ContentProtectionAdminAssets {

        /**
         * ContentProtectionAdminAssets constructor.
         */
        public function __construct() {
            $this->setupAssets();
        }

        /**
         * Enqueue scripts and styles
         */
        public function setupAssets() {
            add_action( "admin_enqueue_scripts", array( $this, 'protectContentScripts' ) );
            add_action( "admin_enqueue_scripts", array( $this, 'protectContentStyles' ) );
        }

        /**
         * @param $hook
         * Enqueue scripts
         */
        public function protectContentScripts($hook) {
            global $contentProtectionMenu;

            if( $hook != $contentProtectionMenu ) {
                return;
            }

            wp_enqueue_script( 'content-protection-script', plugin_dir_url( __DIR__ ) . 'assets/js/script.js' );
        }

        /**
         * @param $hook
         * Enqueue styles
         */
        public function protectContentStyles($hook) {
            global $contentProtectionMenu;

            if( $hook != $contentProtectionMenu ) {
                return;
            }

            wp_enqueue_style( 'content-protection-style', plugin_dir_url( __DIR__ ) . 'assets/css/themexa.css' );
        }

    }

}