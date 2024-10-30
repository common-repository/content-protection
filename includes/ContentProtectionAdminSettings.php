<?php

if ( !class_exists('ContentProtectionAdminSettings') ) {

    /**
     * Class ContentProtectionAdminSettings
     */
    class ContentProtectionAdminSettings {

        /**
         * ContentProtectionAdminSettings constructor.
         */
        public function __construct() {
            $this->setupAdminMenu();
        }

        /**
         * Hooks into admin_menu
         */
        public function setupAdminMenu() {
            add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
        }

        /**
         * Register settings menu page(s)
         */
        public function addAdminMenu() {
            global $contentProtectionMenu;

            $contentProtectionMenu = add_menu_page(
                'Content Protection Settings',                 // Title, html meta tag
                'Content Protection',                              // Menu title, hardcoded style
                'edit_pages',                               // capability
                'content-protection-settings',                   // URL
                array( $this, 'adminMenuPageContent' ),     // output
                'dashicons-lock',                           // icon, uses default
                66                                          // position, showing on top of all others
            );

        }

        /**
         * Settings menu page content
         */
        public function adminMenuPageContent() {
            ?>
                <div class="container">
                    <div class="tx-wrapper">
                        <div class="row">
                            <div class="col-12 pt-4 pb-3">
                                <img src="<?php echo plugin_dir_url( THEMEXA_CONTENT_PROTECTION_FILE ); ?>assets/images/banner.png" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="ul-widget__head">
                                            <div class="ul-widget1__title">Protect Content</div>
                                            <hr>
                                        </div>
                                        <form method="post">
                                            <?php 
                                                if ( isset ( $_POST["tpc_general_restriction_type_submit"] ) && wp_verify_nonce( $_POST['tcp_nonce'], 'tcp_form_verification' ) ) {
                                                    if ( isset ( $_POST["tpc_general_restriction_type"] ) ) {
                                                        $restriction_type = sanitize_title($_POST["tpc_general_restriction_type"]);
                                                        switch ($restriction_type) {
                                                            case "all-content":
                                                                update_option( "tpc-general-restriction-type", sanitize_text_field("all-content") );
                                                                break;
                                                            case "selected-content":
                                                                update_option( "tpc-general-restriction-type", sanitize_text_field("selected-content") );
                                                                break;
                                                            case "all-except-selected-content":
                                                                update_option( "tpc-general-restriction-type", sanitize_text_field("all-except-selected-content") );
                                                                break;
                                                            case "no-content":
                                                                update_option( "tpc-general-restriction-type", sanitize_text_field("no-content") );
                                                                break;
                                                        }
                                                    }
                                                }
                                            ?>
                                            <div class="row ul-widget__body mt-5">
                                                <div class="col-3 pr-5">
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="tpc_general_restriction_type" value="all-content" <?php
                                                            if ( get_option("tpc-general-restriction-type") == "all-content" ) {
                                                                echo "checked";
                                                            }
                                                         ?>/>
                                                        <b><span class="ul-widget4__title">All Content</span></b>
                                                        <span class="checkmark"></span>
                                                        <p class="mt-2">Protect all content of your site including Page, Post, Custom Post Type, Category, Tag, Archive or anything.</p>
                                                    </label>
                                                </div>
                                                <div class="col-3 pr-5">
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="tpc_general_restriction_type" value="selected-content" <?php
                                                            if ( get_option('tpc-general-restriction-type') == 'selected-content' ) {
                                                                echo "checked";
                                                            }
                                                         ?>/>
                                                        <b><span class="radio-text">Selective</span></b>
                                                        <span class="checkmark"></span>
                                                        <p class="mt-2">Protect the content individually including Page, Post, Custom Post Type, Category, Tag, Archive or anything.</p>
                                                    </label>
                                                </div>
                                                <div class="col-3 pr-5">
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="tpc_general_restriction_type" value="all-except-selected-content" <?php
                                                        if ( get_option('tpc-general-restriction-type') == 'all-except-selected-content' ) {
                                                            echo "checked";
                                                        }
                                                        ?>/>
                                                        <b><span class="radio-text">All Except Selected</span></b>
                                                        <span class="checkmark"></span>
                                                        <p class="mt-2">All content will be protected except the selected options below.</p>
                                                    </label>
                                                </div>
                                                <div class="col-3 pr-5">
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="tpc_general_restriction_type" value="no-content" <?php
                                                            if ( get_option('tpc-general-restriction-type') == 'no-content' ) {
                                                                echo "checked";
                                                            }
                                                         ?>/>
                                                        <b><span class="radio-text">None</span></b>
                                                        <span class="checkmark"></span>
                                                        <p class="mt-2">Don't need to protect any content.</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php wp_nonce_field('tcp_form_verification', 'tcp_nonce'); ?>
                                            <button class="btn btn-success m-1" type="submit" name="tpc_general_restriction_type_submit">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="ul-widget__head">
                                            <div class="ul-widget1__title">Protect by Post Type</div>
                                            <hr>
                                        </div>
                                        <form method="post">
                                            <?php
                                                if ( isset ( $_POST["tpc_post_type_restrictions_submit"] ) && is_array( $_POST["tpc_post_type_restrictions"] )&& wp_verify_nonce( $_POST['tcp_nonce'], 'tcp_form_verification' ) ) {
                                                    $update_post_types = isset( $_POST["tpc_post_type_restrictions"] ) ? array_map( 'sanitize_title', (array) $_POST["tpc_post_type_restrictions"] ) : array();
                                                    $update_post_types = array_intersect( $update_post_types, get_post_types() );
                                                    update_option ( "tpc-post-type-restrictions", $update_post_types );
                                                }
                                            ?>
                                            <div class="row ul-widget__body">
                                                <?php
                                                $post_types = get_post_types();

                                                foreach ($post_types as $post_type_key => $post_type_value) {
                                                    ?>
                                                    <div class="col-4">
                                                        <label class="switch pr-5 switch-success mr-3 mt-4"><span> 
                                                            <?php echo ucwords( str_replace( '_', ' ', $post_type_value ) ); ?>
                                                            </span>
                                                            <input type="checkbox" name="tpc_post_type_restrictions[]" value="<?php echo $post_type_value; ?>" <?php 
                                                                    if (is_array(get_option( "tpc-post-type-restrictions"))) {
                                                                        if ( in_array($post_type_value, get_option( "tpc-post-type-restrictions"))) {
                                                                            echo "checked";
                                                                        } 
                                                                    }
                                                            ?>>
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <hr>
                                            <?php wp_nonce_field('tcp_form_verification', 'tcp_nonce'); ?>
                                            <button class="btn btn-success m-1" type="submit" name="tpc_post_type_restrictions_submit">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="ul-widget__head">
                                            <div class="ul-widget1__title">Where to Redirect?</div>
                                            <hr>
                                        </div>
                                        <form method="post">
                                            <?php 
                                                if ( isset( $_POST["redirect_url_submit"] ) && wp_verify_nonce( $_POST['tcp_nonce'], 'tcp_form_verification' ) ) {
                                                    if ( isset( $_POST["redirect_url"] ) ) {
                                                        $redirect = sanitize_title( $_POST["redirect_url"] );
                                                        update_option ( "redirect-url", $redirect );
                                                    }
                                                }

                                                if ( isset( $_POST["redirect_url_submit"] ) && wp_verify_nonce( $_POST['tcp_nonce'], 'tcp_form_verification' ) ) {
                                                    if ( isset( $_POST["custom_redirect_url"] ) ) {
                                                        $custom = sanitize_title( $_POST["custom_redirect_url"] );
                                                        update_option ( "custom-redirect-url", $custom );
                                                    }
                                                }

                                            ?>
                                            <div class="row ul-widget__body mt-5">
                                                <div class="col-6">
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="redirect_url" value="default_url" <?php 
                                                                if ( get_option ( "redirect-url" ) == "default_url") {
                                                                    echo "checked";
                                                                }
                                                        ?> />
                                                        <span class="ul-widget4__title">Default Login URL</span>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <div class="mr-3 mb-3">
                                                        <input class="form-control" id="default_url" type="url" placeholder="<?php echo wp_login_url(); ?>" name="default_login_url" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="radio radio-success ml-3">
                                                        <input type="radio" name="redirect_url" value="custom_url" <?php 
                                                                if ( get_option ( "redirect-url" ) == "custom_url") {
                                                                    echo "checked";
                                                                }
                                                        ?> />
                                                        <span class="radio-text">Custom Page Slug</span>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <div class="ml-3 mb-3 input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="custom-redirect-slug"><?php echo get_home_url(); ?>/</span>
                                                        </div>
                                                        <input class="form-control" id="custom_url" type="text" placeholder="custom-page-slug" name="custom_redirect_url" value="<?php
                                                             echo get_option("custom-redirect-url");
                                                        ?>" aria-describedby="custom-redirect-slug">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php wp_nonce_field('tcp_form_verification', 'tcp_nonce'); ?>
                                            <button class="btn btn-success m-1" type="submit" name="redirect_url_submit">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }

    }

}