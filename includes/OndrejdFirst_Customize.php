<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/ondrejdfirst for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package ondrejdfirst
 * @since 1.0.0
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'OndrejdFirst_Customize' ) ) :
    /**
     * Class for dealing with WordPress Theme Customizer.
     * @since 1.0.0
     */
    class OndrejdFirst_Customize {
        /**
         * Registers our customizations.
         * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        public static function register( $wp_customize ) {
            // Updates "Static Front Page" section
            $wp_customize->get_section( 'static_front_page' )->active_callback = function() {
                return ( is_front_page() );
            };
            // Make built-in controls use live JS preview
            $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
            $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
            $wp_customize->get_setting( 'show_on_front' )->transport = 'postMessage';
            // Updates "Colors" section
            self::register_section_colors( $wp_customize );
            // Create "Theme Options" section
            self::register_section_theme_options( $wp_customize );
            // Create "Blog Page Display" section
            self::register_section_blog_page_display( $wp_customize );
            // Create "Login Page Display" section
            self::register_section_login_page_display( $wp_customize );
            // Create "WooCommerce" section
            self::register_woocommerce_support( $wp_customize );
        }

        /**
         * @internal Updates "Colors" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         * @todo Udělat tři profily, první světlý (...|...|...|...),
         *       druhý světle fialový (#750743|#44002a|#ffffff|#e77243),
         *       třetí tmavě fialový (#750743|#44002a|...|...);
         *       dle zvoleného profilu nastavit i zvolené barvy
         *       (včetně defaultních hodnot). Původní "Hamilton's Dark Mode"
         *       úplně zrušit.
         */
        private static function register_section_colors( $wp_customize ) {
            $wp_customize->remove_control( 'background_color' );

            // Color mode
            $wp_customize->add_setting( 'ondrejdfirst_color_mode', [
                'capability' 		=> 'edit_theme_options',
                'default'           => 'white',
                'transport'         => 'postMessage',
                'sanitize_callback' => function ( $value ) {
                    if( ! in_array( $value, ['white','ubuntu','ubuntu_dark'] ) ) {
                        return 'white';
                    }
                    return $value;
                },
            ] );
            $wp_customize->add_control( 'ondrejdfirst_color_mode', [
                'type'        => 'radio',
                'section'     => 'colors',
                'label'       => __( 'Color model', 'ondrejdfirst' ),
                'description' => __( 'Select color model you prefer.', 'ondrejdfirst' ),
                'priority'    => 11,
                'choices'     => [
                    'white'       => __( 'White', 'ondrejdfirst' ),
                    'ubuntu'      => __( 'Ubuntu', 'ondrejdfirst' ),
                    'ubuntu_dark' => __( 'Ubuntu Dark', 'ondrejdfirst' ),
                ],
            ] );

            /*include( get_template_directory() . '/includes/OndrejdFirst_ColorMode_Customize_Control.php' );
            include( get_template_directory() . '/includes/OndrejdFirst_New_Menu_Customize_Control.php' );
            $wp_customize->add_control( new OndrejdFirst_ColorMode_Customize_Control(
                $wp_customize, 'ondrejdfirst_color_mode2', [
                    'setting' => 'ondrejdfirst_color_mode',
                    'section'     => 'colors',
                    'label'       => __( 'Color model', 'ondrejdfirst' ),
                    'description' => __( 'Select color model you prefer.', 'ondrejdfirst' ),
                    'priority'    => 11,
                    'choices'     => [
                        'white'       => __( 'White', 'ondrejdfirst' ),
                        'ubuntu'      => __( 'Ubuntu', 'ondrejdfirst' ),
                        'ubuntu_dark' => __( 'Ubuntu Dark', 'ondrejdfirst' ),
                    ],
                ]
            ) );
            $wp_customize->add_control( new OndrejdFirst_New_Menu_Customize_Control(
                $wp_customize, 'ondrejdfirst_color_mode3', [
                    'setting'     => 'ondrejdfirst_color_mode',
                    'section'     => 'colors',
                    'label'       => __( 'XXX', 'ondrejdfirst' ),
                    'description' => __( 'Description of XXX', 'ondrejdfirst' ),
                ]
            ) );*/
        }

        /**
         * @internal Updates "Theme Options" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_theme_options( $wp_customize ) {
            $wp_customize->add_section( 'ondrejdfirst_options', [
                'title'              => __( 'Theme Options', 'ondrejdfirst' ),
                'priority'           => 35,
                'capability'         => 'edit_theme_options',
                'description'        => __( 'Customize the <strong>OndrejdFirst</strong> theme settings.', 'ondrejdfirst' ),
                'description_hidden' => true,
            ] );

            // Always show preview titles
            $wp_customize->add_setting( 'ondrejdfirst_alt_nav', [
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage',
            ] );
            $wp_customize->add_control( 'ondrejdfirst_alt_nav', [
                'type' 			=> 'checkbox',
                'section' 		=> 'ondrejdfirst_options',
                'label' 		=> __( 'Show Primary Menu in the Header', 'ondrejdfirst' ),
                'description' 	=> __( 'Replace the navigation toggle in the header with the Primary Menu on desktop.', 'ondrejdfirst' ),
                'priority'      => 10,
            ] );

            // Site description
            $wp_customize->add_setting( 'ondrejdfirst_site_description', [
                'capability' 		=> 'edit_theme_options',
                'default'           => false,
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( 'ondrejdfirst_site_description', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_options',
                'label'       => __( 'Site description', 'ondrejdfirst' ),
                'description' => __( 'Check if you want to show site description just below the site title.', 'ondrejdfirst' ),
                'priority'    => 11,
            ] );

            // Cookie warning
            $wp_customize->add_setting( 'ondrejdfirst_cookies_warning', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'transport'			=> 'postMessage',
            ] );
            $wp_customize->add_control( 'ondrejdfirst_cookies_warning', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_options',
                'label'       => __( 'Cookies warning', 'ondrejdfirst' ),
                'description' => __( 'Check to show cookies warning which is required in some countries.', 'ondrejdfirst' ),
                'priority'    => 12,
            ] );

            // Three columns
            $wp_customize->add_setting( 'ondrejdfirst_three_columns', [
                'capability' 		=> 'edit_theme_options',
                'default'           => true,
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage',
            ] );
            $wp_customize->add_control( 'ondrejdfirst_three_columns', [
                'type' 			=> 'checkbox',
                'section' 		=> 'ondrejdfirst_options',
                'label' 		=> __( 'Three Columns', 'ondrejdfirst' ),
                'description' 	=> __( 'Check to use three columns in the post grid on desktop.', 'ondrejdfirst' ),
                'priority'      => 13,
            ] );

            // Set the home page title
            $wp_customize->add_setting( 'ondrejdfirst_home_title', [
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'			=> 'postMessage',
            ] );
            $wp_customize->add_control( 'ondrejdfirst_home_title', [
                'type' 			=> 'textarea',
                'section' 		=> 'ondrejdfirst_options',
                'label' 		=> __( 'Front page title', 'ondrejdfirst' ),
                'description' 	=> __( 'The title you want shown on the front page when the "Front page displays" setting is set to "Your latest posts" in Settings > Reading.', 'ondrejdfirst' ),
                'priority'      => 30,
            ] );

            // Show home page title
            $wp_customize->add_setting( 'ondrejdfirst_show_home_title', [
                'capability' 		=> 'edit_theme_options',
                'default'           => false,
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'			=> 'postMessage',
            ] );
            $wp_customize->add_control( 'ondrejdfirst_show_home_title', [
                'type' 			=> 'checkbox',
                'section' 		=> 'ondrejdfirst_options',
                'label' 		=> __( 'Show front page title', 'ondrejdfirst' ),
                'priority'      => 31,
            ] );

            // Set the home page description
            $wp_customize->add_setting( 'ondrejdfirst_home_description', [
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'			=> 'postMessage',
            ] );
            $wp_customize->add_control( 'ondrejdfirst_home_description', [
                'type' 			=> 'textarea',
                'section' 		=> 'ondrejdfirst_options',
                'label' 		=> __( 'Front page description', 'ondrejdfirst' ),
                'description' 	=> __( 'The description below the title on the front page. Unlike title in description you can use <abbr title="Hyper Text Markup Language">HTML</abbr> not just text- so be carefull.', 'ondrejdfirst' ),
                'priority'      => 32,
            ] );

            // Show home page description
            $wp_customize->add_setting( 'ondrejdfirst_show_home_description', [
                'capability' 		=> 'edit_theme_options',
                'default'           => false,
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'			=> 'postMessage',
            ] );
            $wp_customize->add_control( 'ondrejdfirst_show_home_description', [
                'type' 			=> 'checkbox',
                'section' 		=> 'ondrejdfirst_options',
                'label' 		=> __( 'Show front page description', 'ondrejdfirst' ),
                'priority'      => 33,
            ] );
        }

        /**
         * @internal Creates "Blog Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_blog_page_display( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'ondrejdfirst_blog_page_display', [
                'title'              => __( 'Blog Page Display', 'ondrejdfirst' ),
                'priority'           => 120,
                'capability'         => 'edit_theme_options',
                'description'        => __( 'Settings for how to display the <strong>Blog Page</strong>.', 'ondrejdfirst' ),
                'description_hidden' => true,
                'active_callback'    => function() { return ( is_home() && ! is_front_page() ); },
            ] );

            // Preview content: show categories
            $wp_customize->add_setting( 'ondrejdfirst_preview_show_category', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_preview_show_category', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_blog_page_display',
                'label'       => __( 'Show category', 'ondrejdfirst' ),
                'description' => __( 'Check to show post categories inside the posts previews.', 'ondrejdfirst' ),
            ] );

            // Preview content: show date and time
            $wp_customize->add_setting( 'ondrejdfirst_preview_show_date', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_preview_show_date', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_blog_page_display',
                'label'       => __( 'Show date', 'ondrejdfirst' ),
                'description' => __( 'Check to show date and time in posts previews.', 'ondrejdfirst' ),
            ] );

            // Preview content: show excerpt
            $wp_customize->add_setting( 'ondrejdfirst_preview_show_excerpt', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_preview_show_excerpt', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_blog_page_display',
                'label'       => __( 'Show excerpt', 'ondrejdfirst' ),
                'description' => __( 'Check to show post excerpt inside the posts previews.', 'ondrejdfirst' ),
            ] );

            // Preview content: show tags
            $wp_customize->add_setting( 'ondrejdfirst_preview_show_tags', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_preview_show_tags', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_blog_page_display',
                'label'       => __( 'Show tags', 'ondrejdfirst' ),
                'description' => __( 'Check to show tags inside the posts previews.', 'ondrejdfirst' ),
            ] );

            // Show blog filter
            $wp_customize->add_setting( 'ondrejdfirst_blog_filter', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_blog_filter', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_blog_page_display',
                'label'       => __( 'Show blog filter', 'ondrejdfirst' ),
                'description' => __( 'Check to show filter on <strong>Blog Page</strong> above the grid with posts.', 'ondrejdfirst' ),
            ] );
        }

        /**
         * @internal Creates "Login Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_login_page_display( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'ondrejdfirst_login_page', [
                'title'              => __( 'Login Page Display', 'ondrejdfirst' ),
                'priority'           => 125,
                'capability'         => 'edit_theme_options',
                'description'        => __( 'Settings for how to display the <strong>Login Page</strong> (show <a href="#" class="wp-login-page-link">Login Page</a>).', 'ondrejdfirst' ),
                'description_hidden' => true,
                'active_callback'    => function() {
                    return ( filter_input( INPUT_GET, 'url' ) ==  get_bloginfo( 'url' ) .'/wp-login.php' );
                },
            ] );

            // Show WordPress logo
            $wp_customize->add_setting( 'ondrejdfirst_login_logo', [
                'default'           => true,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_login_logo', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_login_page',
                'label'       => __( 'Show logo', 'ondrejdfirst' ),
                'description' => __( 'Check to show <strong>WordPress</strong> or custom logo above the login form.', 'ondrejdfirst' ),
            ] );

            //....
        }

        /**
         * @internal Registers all what is neccessary for our WooCommerce support.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_woocommerce_support( $wp_customize ) {
            // Our WooCommerce-aimed settings takes these sections:
            self::register_section_woocommerce_shop( $wp_customize );
            self::register_section_woocommerce_cart( $wp_customize );
            self::register_section_woocommerce_checkout( $wp_customize );
            self::register_section_woocommerce_account( $wp_customize );
            self::register_section_woocommerce_product( $wp_customize );
        }

        /**
         * @internal Creates "Shop Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_shop( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'ondrejdfirst_woocommerce_shop', [
                'title'              => __( 'Shop Page Display', 'ondrejdfirst' ),
                'priority'           => 130,
                'capability'         => 'edit_theme_options',
                'description'        => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Shop</em> page.', 'ondrejdfirst' ),
                'description_hidden' => true,
                'active_callback'    => function() {
                    if( function_exists( 'is_shop' ) ) {
                        return is_shop();
                    } else {
                        return false;
                    }
                },
            ] );

            // Show shop pages title
            $wp_customize->add_setting( 'ondrejdfirst_wc_pages_title', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_pages_title', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_shop',
                'label'       => __( 'Pages title', 'ondrejdfirst' ),
                'description' => __( 'Check to show titles on <strong>WooCommerce</strong> pages.', 'ondrejdfirst' ),
            ] );

            // Breadcrumbs
            $wp_customize->add_setting( 'ondrejdfirst_wc_breadcrumbs', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_breadcrumbs', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_shop',
                'label'       => __( 'Breadcrumbs', 'ondrejdfirst' ),
                'description' => __( 'Check to show breadcrumbs on <strong>WooCommerce</strong> pages.', 'ondrejdfirst' ),
            ] );

            // Result count
            $wp_customize->add_setting( 'ondrejdfirst_wc_result_count', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_result_count', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_shop',
                'label'       => __( 'Result count', 'ondrejdfirst' ),
                'description' => __( 'Check to show result count on <strong>WooCommerce</strong> page <em>Shop</em>.', 'ondrejdfirst' ),
            ] );

            // Sidebar
            $wp_customize->add_setting( 'ondrejdfirst_wc_sidebar', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_sidebar', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_shop',
                'label'       => __( 'Sidebar', 'ondrejdfirst' ),
                'description' => __( 'Check to show sidebar on <strong>WooCommerce</strong> page <em>Shop</em>. But consider other options because this theme does not use sidebars commonly.', 'ondrejdfirst' ),
            ] );

            // Fancy orderby
            $wp_customize->add_setting( 'ondrejdfirst_wc_fancy_order_select', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_fancy_order_select', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_shop',
                'label'       => __( 'Fancy orderby select', 'ondrejdfirst' ),
                'description' => __( 'Check to show fancy <em>orderby</em> select on <em>Shop</em> page instead of the default one (plain <em>select</em> input).', 'ondrejdfirst' ),
            ] );

            // Use one-page shop
            $wp_customize->add_setting( 'ondrejdfirst_wc_one_page', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_one_page', [
                'type'            => 'checkbox',
                'section'         => 'ondrejdfirst_woocommerce_shop',
                'label'           => __( 'One-page shop', 'ondrejdfirst' ),
                'description'     => __( 'Check to turn your <em>Shop</em> page with pagination into one page with all your products (<strong>requires One-Page Shop Plugin</strong>).', 'ondrejdfirst' ),
            ] );
        }

        /**
         * @internal Creates "Cart Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_cart( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'ondrejdfirst_woocommerce_cart', [
                'title'              => __( 'Cart Page Display', 'ondrejdfirst' ),
                'priority'           => 131,
                'capability'         => 'edit_theme_options',
                'description'        => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Cart</em> page.', 'ondrejdfirst' ),
                'description_hidden' => true,
                'active_callback'    => function() {
                    if( function_exists( 'is_cart' ) ) {
                        return is_cart();
                    } else {
                        return false;
                    }
                },
            ] );

            // Show coupon
            $wp_customize->add_setting( 'ondrejdfirst_wc_cart_show_coupon', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_cart_show_coupon', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_cart',
                'label'       => __( 'Show coupon', 'ondrejdfirst' ),
                'description' => __( 'Check to show coupon field on <strong>Cart Page</strong> below the list of purchased items.', 'ondrejdfirst' ),
            ] );
        }

        /**
         * @internal Creates "Checkout Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_checkout( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'ondrejdfirst_woocommerce_checkout', [
                'title'              => __( 'Checkout Page Display', 'ondrejdfirst' ),
                'priority'           => 132,
                'capability'         => 'edit_theme_options',
                'description'        => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Checkout</em> page.', 'ondrejdfirst' ),
                'description_hidden' => true,
                'active_callback'    => function() {
                    if( function_exists( 'is_checkout' ) ) {
                        return is_checkout();
                    } else {
                        return false;
                    }
                },
            ] );

            // Show coupon
            $wp_customize->add_setting( 'ondrejdfirst_wc_checkout_show_coupon', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_checkout_show_coupon', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_checkout',
                'label'       => __( 'Show coupon', 'ondrejdfirst' ),
                'description' => __( 'Check to show coupon field on <strong>Cart Page</strong> below the list of purchased items.', 'ondrejdfirst' ),
            ] );

            // Show shipping choice
            $wp_customize->add_setting( 'ondrejdfirst_wc_checkout_shipping_choice', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_checkout_shipping_choice', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_checkout',
                'label'       => __( 'Shipping choice', 'ondrejdfirst' ),
                'description' => __( 'Check to show shipping choice form on <strong>Checkout Page</strong> as before on <strong>Cart Page</strong> page.', 'ondrejdfirst' ),
            ] );
        }

        /**
         * @internal Creates "Account Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_account( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'ondrejdfirst_woocommerce_account', [
                'title'              => __( 'Account Page Display', 'ondrejdfirst' ),
                'priority'           => 130,
                'capability'         => 'edit_theme_options',
                'description'        => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Account</em> page.', 'ondrejdfirst' ),
                'description_hidden' => true,
                'active_callback'    => function() {
                    if( function_exists( 'is_account_page' ) ) {
                        return is_account_page();
                    } else {
                        return false;
                    }
                },
            ] );

            // Hide dashboard
            $wp_customize->add_setting( 'ondrejdfirst_wc_account_hide_dashboard', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_account_hide_dashboard', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_account',
                'label'       => __( 'Hide Dashboard', 'ondrejdfirst' ),
                'description' => __( 'Check to hide <strong>Dashboard</strong> on <strong>Account Page</strong> so the first pane become <strong>Orders</strong>.', 'ondrejdfirst' ),
            ] );
        }

        /**
         * @internal Creates "Product Page Display" section in Theme Customizer.
         * @param WP_Customize_Manager $wp_customize
         * @return void
         * @since 1.0.0
         */
        private static function register_section_woocommerce_product( $wp_customize ) {
            // Add section self
            $wp_customize->add_section(	'ondrejdfirst_woocommerce_product', [
                'title'              => __( 'Product Page Display', 'ondrejdfirst' ),
                'priority'           => 130,
                'capability'         => 'edit_theme_options',
                'description'        => __( 'Settings for how to display <strong>WooCommerce</strong> <em>Account</em> page.', 'ondrejdfirst' ),
                'description_hidden' => true,
                'active_callback'    => function() {
                    if( function_exists( 'is_product' ) ) {
                        return is_product();
                    } else {
                        return false;
                    }
                },
            ] );

            // Hide count input
            $wp_customize->add_setting( 'ondrejdfirst_wc_product_count_input', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_product_count_input', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_product',
                'label'       => __( 'Count input', 'ondrejdfirst' ),
                'description' => __( 'Check to show product count input on <strong>Product Page</strong>.', 'ondrejdfirst' ),
            ] );

            // Hide categories
            $wp_customize->add_setting( 'ondrejdfirst_wc_product_categories', [
                'default'           => false,
                'capability' 		=> 'edit_theme_options',
                'sanitize_callback' => [__CLASS__, 'sanitize_checkbox'],
                'transport'			=> 'postMessage'
            ] );
            $wp_customize->add_control( 'ondrejdfirst_wc_product_categories', [
                'type'        => 'checkbox',
                'section'     => 'ondrejdfirst_woocommerce_product',
                'label'       => __( 'Categories', 'ondrejdfirst' ),
                'description' => __( 'Check to show product categories on <strong>Product Page</strong>.', 'ondrejdfirst' ),
            ] );
        }

        /**
         * @internal Registers our JavaScript for the live preview.
         * @return void
         * @since 1.0.0
         */
        public static function preview_init() {
            wp_enqueue_script(
                'ondrejdfirst-theme-customizer-preview',
                get_stylesheet_directory_uri() . '/assets/js/customizer-preview.js',
                ['jquery', 'customize-preview', 'masonry'],
                null,
                true
            );
        }

        /**
         * @internal Registers our JavaScript for the customizer controls.
         * @return void
         * @since 1.0.0
         */
        public static function controls_enqueue_scripts() {
            wp_enqueue_script(
                'ondrejdfirst-theme-customizer-controls',
                get_stylesheet_directory_uri() . '/assets/js/customizer-controls.js',
                ['customize-controls', 'jquery'],
                null,
                true
            );
        }

        /**
         * @internal Outputs required CSS style into the WP header.
         * @return void
         * @since 1.0.0
         * @uses get_theme_mod
         */
        public static function header_output() {
?>
<style type='text/css'>
/* Site description */
.site-description { display: <?php echo ( get_theme_mod( 'ondrejdfirst_site_description' ) ) ? 'block' : 'none'; ?>; }
/* Cookie warning */
#cookies-usage-warning--cont { display: <?php echo ( get_theme_mod( 'ondrejdfirst_cookies_warning' ) ) ? 'block' : 'none'; ?>; }
/* Front Page Title */
#ondrejdfirst_home_title--header { display: <?php echo ( get_theme_mod( 'ondrejdfirst_show_home_title' ) ) ? 'block' : 'none'; ?>; }
/* Front Page Description */
#ondrejdfirst_home_description { display: <?php echo ( get_theme_mod( 'ondrejdfirst_show_home_description' ) ) ? 'block' : 'none'; ?>; }
/* Preview Content: Category */
.preview-header .preview-category { display: <?php echo ( get_theme_mod( 'ondrejdfirst_preview_show_category' ) ) ? 'block' : 'none'; ?>; }
/* Preview Content: Date and Time */
.preview-header .preview-date { display: <?php echo ( get_theme_mod( 'ondrejdfirst_preview_show_date' ) ) ? 'block' : 'none'; ?>; }
/* Preview Content: Excerpt */
.preview-header .preview-excerpt { display: <?php echo ( get_theme_mod( 'ondrejdfirst_preview_show_excerpt' ) ) ? 'block' : 'none'; ?>; }
/* Preview Content: Tags */
.preview-header .preview-tags { display: <?php echo ( get_theme_mod( 'ondrejdfirst_preview_show_tags' ) ) ? 'block' : 'none'; ?>; }
/* Show blog filter */
#ondrejdfirst_blog_filter { display: <?php echo ( get_theme_mod( 'ondrejdfirst_blog_filter' ) ) ? 'block' : 'none'; ?>; }
/* WC General: Page title */
.ondrejdfirst-wc-content-wrapper .page-title { display: <?php echo ( get_theme_mod( 'ondrejdfirst_wc_pages_title' ) ) ? 'block' : 'none'; ?>; }
/* WC General: Breadcrumbs */
.ondrejdfirst-wc-content-wrapper .woocommerce-breadcrumb { display: <?php echo ( get_theme_mod( 'ondrejdfirst_wc_breadcrumbs' ) ) ? 'block' : 'none'; ?>; }
/* WC General: Result count */
.ondrejdfirst-wc-content-wrapper .woocommerce-result-count { display: <?php echo ( get_theme_mod( 'ondrejdfirst_wc_result_count' ) ) ? 'block' : 'none'; ?>; }
/* WC Shop: Fancy Orderby */
.woocommerce-ordering select[name="orderby"] { display: <?php echo ( get_theme_mod( 'ondrejdfirst_wc_fancy_order_select' ) ) ? 'none' : 'block'; ?>; }
#ondrejdfirst-ordering { display: <?php echo ( get_theme_mod( 'ondrejdfirst_wc_fancy_order_select' ) ) ? 'block' : 'none'; ?>; }
/* WC Shop: Sidebar */
#sidebar { display: <?php echo ( get_theme_mod( 'ondrejdfirst_wc_sidebar' ) ) ? 'block' : 'none'; ?>; }
</style>
<?php
        }

        /**
         * @internal Sanitizes checkbox values.
         * @param boolean $checked
         * @return boolean
         * @since 1.0.0
         */
        public static function sanitize_checkbox( $checked ) {
            return ( ( isset( $checked ) && true == $checked ) ? true : false );
        }
    }
endif;

// Register our customizer extension
add_action( 'customize_register', ['OndrejdFirst_Customize', 'register'], 99 );
add_action( 'customize_preview_init', ['OndrejdFirst_Customize', 'preview_init'] );
add_action( 'customize_controls_enqueue_scripts', ['OndrejdFirst_Customize', 'controls_enqueue_scripts'] );
add_action( 'wp_head' , ['OndrejdFirst_Customize' , 'header_output'] );
