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


if( ! class_exists( 'OndrejdFirst_Login_Customize' ) ) :
    /**
     * Customizes login page.
     * @since 1.0.0
     */
    class OndrejdFirst_Login_Customize {

        /**
         * Constructor.
         * @return void
         * @since 1.0.0
         */
        public function __construct() {
            add_action( 'login_head', [$this, 'head'] );
        }

        /**
         * @internal Hook for "login_head" action.
         * @return void
         * @since 1.0.0
         */
        public function head() {
?>
<style type="text/css">
/* OndrejdFirst Theme Login Page */
</style>
<?php
        }
    }
endif;

/**
 * @var OndrejdFirst_Login_Customize $OndrejdFirst_Login_Customize
 */
$OndrejdFirst_Login_Customize = new OndrejdFirst_Login_Customize();
