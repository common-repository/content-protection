<?php

if ( !class_exists('ContentProtectionSetupActions')) {

    /**
     * Class ContentProtectionSetupActions
     */
    class ContentProtectionSetupActions {

        /**
         * ContentProtectionSetupActions constructor.
         */
        public function __construct() {
            $this->setupActions();
        }

        /**
         * Register activation/deactivation hook
         */
        protected function setupActions() {
            register_activation_hook( THEMEXA_CONTENT_PROTECTION_FILE, array('SamplePlugin', 'activate' ) );
            register_deactivation_hook( THEMEXA_CONTENT_PROTECTION_FILE, array('SamplePlugin', 'deactivate' ) );
        }

        /**
         * Activation actions
         */
        public static function activate() {
            //Activation code goes here
        }

        /*
         * Deactivation actions
         */
        public static function deactivate() {
            //Deactivation code goes here
        }  
        
    }

}