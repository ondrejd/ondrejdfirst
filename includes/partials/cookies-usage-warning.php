<?php
/**
 * @author Ondřej Doněk <ondrejd@gmail.com>
 * @link https://github.com/ondrejd/https://github.com/ondrejd/ondrejdfirst for the canonical source repository
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 * @package ondrejdfirst
 * @since 1.0.0
 * @todo Add wpnonce!
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<div class="cookies-usage-warning" id="cookies_usage_warning--cont">
    <p><?php _e( 'Tato stránka používá cookies za účelem zlepšení uživatelského prostředí. Podmínky pro uchovávání nebo přístup ke cookies je možné nastavit ve vašem prohlížeči.', 'ondrejdfirst' ) ?></p>
    <form action="<?php echo admin_url( 'admin-post.php' ) ?>" id="cookies_usage_warning--form" method="post">
        <input type="hidden" name="action" value="cookies_usage_warning">
        <?php wp_nonce_field( 'cookies-usage-warning', 'cookies_usage_warning_nonce' ) ?>
        <input name="cookies-usage-warning" type="submit" value="<?php _e( 'Rozumím', 'ondrejdfirst' ) ?>" class="button button-primary">
    </form>
</div>
