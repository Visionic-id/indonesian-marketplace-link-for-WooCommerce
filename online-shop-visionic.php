<?php
/*
 * Plugin Name: Indonesian Marketplace Olshop Link for WooCommerce
 * Description: Indonesian Online Shop Link for WooCommerce, By visionic.id
 * Author: Visionic.id
 * Version: 1.0
 * Author URI: https://visionic.id
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 * */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    Class Visi_Olshop {

        public function __construct() {
            add_action('woocommerce_before_add_to_cart_form', array(&$this, 'content_after_addtocart_button'));
            add_filter('woocommerce_product_data_tabs', array(&$this, 'custom_tab'));
            add_action('woocommerce_product_data_panels', array(&$this, 'custom_tab_panel'));
            add_action('woocommerce_process_product_meta_simple', array(&$this, 'save_linkolshop_option_fields'));
            add_action('woocommerce_process_product_meta_variable', array(&$this, 'save_linkolshop_option_fields'));
        }

        function content_after_addtocart_button() {
            global $post;

            // get this plugin URL
            $plugin_url = plugin_dir_url(__FILE__);

            // get Marketplace URL
            $tokopedia = get_post_meta($post->ID, 'link_tokopedia', true);
            $bukalapak = get_post_meta($post->ID, 'link_bukalapak', true);
            $shopee = get_post_meta($post->ID, 'link_shopee', true);
            $instagram = get_post_meta($post->ID, 'link_instagram', true);

            if (!empty($tokopedia) || !empty($bukalapak) || !empty($shopee) || !empty($instagram))
                echo '<br />';

            if (!empty($tokopedia))
                echo `<a href="${$tokopedia}" class="btn btn-tokopedia"><img src="${$plugin_url}icon/tokopedia.png" width="50px" class="img-icon"/></a>`;

            if (!empty($bukalapak))
                echo `<a href="${$bukalapak}" class="btn btn-bukalapak"><img src="${$plugin_url}icon/bukalapak.png" width="50px" class="img-icon"/></a>`;

            if (!empty($shopee))
                echo `<a href="${$shopee}" class="btn btn-shopee"><img src="${$plugin_url}icon/shopee.png" width="50px" class="img-icon"/></a>`;

            if (!empty($instagram))
                echo `<a href="${$instagram}" class="btn btn-instagram"><img src="${$plugin_url}icon/instagram.png" width="50px" class="img-icon"/></a>`;
        }

        function custom_tab($tabs) {
            $tabs['custom_tab'] = array(
                'label' => __('Link Olshop', 'sibiz_link_olshop'),
                'target' => 'link_olshop_panel',
                'class' => array(),
            );

            return $tabs;
        }

        function custom_tab_panel() {
            ?>

            <div id="link_olshop_panel" class="panel woocommerce_options_panel">

                <div class="options_group">
                    <?php
                    woocommerce_wp_text_input(array('id' => 'link_tokopedia',
                        'label' => __('Link Tokopedia', 'textdomain'),
                            )
                    );

                    woocommerce_wp_text_input(
                            array(
                                'id' => 'link_bukalapak',
                                'label' => __('Link Bukalapak', 'textdomain'),
                            )
                    );

                    woocommerce_wp_text_input(
                            array(
                                'id' => 'link_shopee',
                                'label' => __('Link Shopee', 'textdomain'),
                            )
                    );

                    woocommerce_wp_text_input(
                            array(
                                'id' => 'link_instagram',
                                'label' => __('Link Instagram', 'textdomain'),
                            )
                    );
                    ?>
                </div>

            </div>

            <?php
        }

        function save_linkolshop_option_fields($post_id) {

            if (isset($_POST['link_tokopedia'])) :
                update_post_meta($post_id, 'link_tokopedia', $_POST['link_tokopedia']);
            endif;

            if (isset($_POST['link_bukalapak'])) :
                update_post_meta($post_id, 'link_bukalapak', $_POST['link_bukalapak']);
            endif;

            if (isset($_POST['link_shopee'])) :
                update_post_meta($post_id, 'link_shopee', $_POST['link_shopee']);
            endif;

            if (isset($_POST['link_instagram'])) :
                update_post_meta($post_id, 'link_instagram', $_POST['link_instagram']);
            endif;
        }

    }

    $visi_olshop = new Visi_Olshop();
}