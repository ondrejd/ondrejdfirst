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

get_header();

?>
<div class="section-inner">
	<header class="page-header section-inner thin">
		<div>
			<h1 class="title"><?php _e( 'Chyba 404', 'ondrejdfirst' ) ?></h1>
			<p><?php _e( 'Stránka, kterou hledáte, nebyla nalezena. To může být způsobeno různými věcmi - přejmenováním stránky, smazáním nebo dokonce požadovaná stránka nikdy neexistovala.', 'ondrejdfirst' ) ?></p>
			<div class="meta">
				<a href="<?php echo esc_url( home_url() ) ?>"><?php _e( 'Na úvodní stranu', 'ondrejdfirst' ) ?></a>
			</div>
		</div>
	</header>
</div>
<?php

get_footer();
