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

if( ! class_exists( 'OndrejdFirst_Cookies_Usage_Warning' ) ) :

    /**
     * Class that handles cookies usage warning.
     * @since 1.0.0
     */
    class OndrejdFirst_Cookies_Usage_Warning {

        /**
         * @var string COOKIE_NAME
         */
        const COOKIE_NAME = 'cookies_usage_confirmation';

        /**
         * Constructor.
         * @return void
         * @since 1.0.0
         */
        public function __construct() {
            add_action( 'admin_post_' . self::COOKIE_NAME, [$this, 'process'] );
            add_action( 'admin_post_nopriv_' . self::COOKIE_NAME, [$this, 'process'] );
            add_action( 'wp_ajax_' . self::COOKIE_NAME, [$this, 'process_ajax'] );
            add_action( 'wp_ajax_nopriv_' . self::COOKIE_NAME, [$this, 'process_ajax'] );
            add_action( 'wp_footer', [$this, 'render'] );
            add_action( 'wp_enqueue_scripts', [$this, 'enqueue_script'] );
        }

        /**
         * @internal Enqueue needed scripts.
         * @return void
         * @since 1.0.0
         */
        public function enqueue_script() {
            $js_file = 'assets/js/cookies-usage-warning.js';
            $js_path = get_template_directory() . '/' . $js_file;
            $js_uri  = get_template_directory_uri() . '/' . $js_file;

            if( file_exists( $js_path ) && is_readable( $js_path ) ) {
                wp_enqueue_script( 'cookies_usage_warning', $js_uri, ['jquery'] );
                wp_localize_script( 'cookies_usage_warning', 'ajax_object', [
                    'url'    => admin_url( 'admin-ajax.php' ),
                    'nonce'  => wp_create_nonce( 'cookies-usage-warning' ),
                    'action' => self::COOKIE_NAME,
                ] );
            }

            $css_file = 'assets/css/cookies-usage-warning.css';
            $css_path = get_template_directory() . '/' . $css_file;
            $css_uri  = get_template_directory_uri() . '/' . $css_file;

            if( file_exists( $css_path ) && is_readable( $css_path ) ) {
                wp_enqueue_style( 'cookies_usage_warning', $css_uri );
            }
        }

        /**
         * @internal Checks if user already did confirm the cookies usage warning.
         * @return boolean
         * @since 1.0.0
         */
        protected function check_cookie() {
            $confirmation = 0;

            if( isset( $_COOKIE[self::COOKIE_NAME] ) ) {
                $confirmation = intval( $_COOKIE[self::COOKIE_NAME] );
            }

            if( $confirmation == 1 ) {
                return true;
            }

            return false;
        }

        /**
         * @internal Sets cookie.
         * @return void
         * @since 1.0.0
         */
        protected function set_cookie() {
            setcookie( self::COOKIE_NAME, '1', ( time() + MONTH_IN_SECONDS ), COOKIEPATH, COOKIE_DOMAIN );
        }

        /**
         * @internal Handles form's submit.
         * @return void
         * @since 1.0.0
         */
        public function process() {
            $submit = filter_input( INPUT_POST, 'cookies-usage-warning' );
            $nonce = filter_input( INPUT_POST, 'cookies_usage_warning_nonce' );
            $referer = filter_input( INPUT_POST, '_wp_http_referer' );

            if( empty( $referer ) ) {
                $referer = '/';
            }

            if( ! empty( $submit ) && wp_verify_nonce( $nonce, 'cookies-usage-warning' ) ) {
                $this->set_cookie();
            }

            wp_redirect( $referer );
        }

        /**
         * @internal Handles AJAX form's submit.
         * @return void
         * @since 1.0.0
         */
        public function process_ajax() {
            $ret = [ 'success' => true ];

            if( false === check_ajax_referer( 'cookies-usage-warning', 'security' ) ) {
                $ret = [ 'error' => 'Security error!' ];
            } else {
                $this->set_cookie();
            }

            ob_clean();
            header( 'Content-Type: application/json' );
            echo json_encode( $ret );
            wp_die();
        }

        /**
         * Renders cookies usage warning.
         * @return void
         * @since 1.0.0
         */
        public function render() {
            if( $this->check_cookie() && ! is_customize_preview() ) {
                // No need to show cookies usage warning. Exiting...
                return;
            }

            include 'partials/cookies-usage-warning.php';
        }
    }
endif;

/**
 * @var OndrejdFirst_Cookies_Usage_Warning $OndrejdFirst_Cookies_Usage_Warning
 */
$OndrejdFirst_Cookies_Usage_Warning = new OndrejdFirst_Cookies_Usage_Warning();
