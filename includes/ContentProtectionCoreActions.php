<?php

if ( !class_exists('ContentProtectionCoreActions') ) {

    /**
     * Class ContentProtectionCoreActions
     */
    class ContentProtectionCoreActions
    {
        /**
         * ContentProtectionCoreActions constructor.
         */
        
        public function __construct() {
            $this->redirectAction();
        }

        public function redirectAction() {

            if ( empty( get_option( "tpc-general-restriction-type" ) ) ) {
                $contentProtectionScope = 'all-content';
            } else {
                $contentProtectionScope = get_option( "tpc-general-restriction-type" );
            }

            switch ( $contentProtectionScope ) {

                case "all-content":
                    add_action( 'wp_loaded', function(){
                        if ( !is_user_logged_in() && !($GLOBALS['pagenow'] === 'wp-login.php') ) {
                            if ( ( get_option( 'redirect-url' ) == 'custom_url' ) && !empty( get_option( "custom-redirect-url" ) ) ) {
                                global $post;
                                $post_slug = $post->post_name;
                                if ($post_slug != get_option( "custom-redirect-url" ) ){
                                    ?>
                                    <script type="text/javascript">
                                        window.location.replace( '<?php echo home_url('/') . get_option( "custom-redirect-url" ); ?>' );
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    window.location.replace( '<?php echo wp_login_url(); ?>' );
                                </script>
                                <?php
                            }
                        }
                    });
                    break;

                case "selected-content":
                    add_action( 'template_redirect', function(){
                        if ( !empty( get_option( "tpc-post-type-restrictions" ) ) ) {
                            if ( in_array( get_post_type(), get_option( "tpc-post-type-restrictions") ) && !is_user_logged_in() && !($GLOBALS['pagenow'] === 'wp-login.php') ) {
                                if ( ( get_option( 'redirect-url' ) == 'custom_url' ) && !empty( get_option( "custom-redirect-url" ) ) ) {
                                    global $post;
                                    $post_slug = $post->post_name;
                                    if ($post_slug != get_option( "custom-redirect-url" ) ){
                                        ?>
                                        <script type="text/javascript">
                                            window.location.replace( '<?php echo home_url('/') . get_option( "custom-redirect-url" ); ?>' );
                                        </script>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <script type="text/javascript">
                                        window.location.replace( '<?php echo wp_login_url(); ?>' );
                                    </script>
                                    <?php
                                }
                            }
                        }
                    });
                    break;

                case "all-except-selected-content":
                    add_action( 'template_redirect', function(){
                        if ( !empty( get_option( "tpc-post-type-restrictions" ) ) ) {
                            if ( !in_array( get_post_type(), get_option( "tpc-post-type-restrictions") ) && !is_user_logged_in() && !($GLOBALS['pagenow'] === 'wp-login.php') ) {
                                if ( ( get_option( 'redirect-url' ) == 'custom_url' ) && !empty( get_option( "custom-redirect-url" ) ) ) {
                                    global $post;
                                    $post_slug = $post->post_name;
                                    if ($post_slug != get_option( "custom-redirect-url" ) ){
                                        ?>
                                        <script type="text/javascript">
                                            window.location.replace( '<?php echo home_url('/') . get_option( "custom-redirect-url" ); ?>' );
                                        </script>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <script type="text/javascript">
                                        window.location.replace( '<?php echo wp_login_url(); ?>' );
                                    </script>
                                    <?php
                                }
                            }
                        }
                    });
                    break;

                case "no-content":
                    //
            }

        }

    }

}