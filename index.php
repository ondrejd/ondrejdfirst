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
		<?php if ( is_home() && $paged == 0 ) : ?>
		<header id="ondrejdfirst_home_title--header" class="page-header fade-block">
			<div>
				<h2 id="ondrejdfirst_home_title" class="title">
                    <?php echo esc_html( get_theme_mod( 'ondrejdfirst_home_title' ) ) ?>
                    <small id="ondrejdfirst_home_description"><?php echo get_theme_mod( 'ondrejdfirst_home_description' ) ?></small>
                </h2>
			</div>
		</header>
		<?php elseif ( is_archive() ) : ?>
		<header class="page-header fade-block">
			<div>
				<h2 class="title"><?php the_archive_title() ?></h2>
				<?php the_archive_description() ?>
			</div>
		</header>
		<?php elseif ( is_search() && have_posts() ) : ?>
		<header class="page-header fade-block">
			<div>
				<h2 class="title"><?php printf( __( 'Vyhledávání: %s', 'ondrejdfirst' ), '&ldquo;' . get_search_query() . '&rdquo;' ) ?></h2>
				<p><?php global $found_posts; printf( __( 'Bylo nalezeno odpovídajících výsledků: %s.', 'ondrejdfirst' ), $wp_query->found_posts ) ?></p>
			</div>
		</header>
		<?php elseif ( is_search() ) : ?>
		<div class="section-inner">
			<header class="page-header fade-block">
				<div>
					<h2 class="title"><?php _e( 'Výsledky vyhledávání', 'ondrejdfirst' ) ?></h2>
					<p><?php global $found_posts; printf( __( 'Na váš vyhledávací dotaz "%s" nebyly nalezeny žádné odpovídající položky.', 'ondrejdfirst' ), get_search_query() ) ?></p>
				</div>
			</header>
		</div>
		<?php endif;

		if ( have_posts() ) : ?>
		<div class="posts" id="posts">
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content' );
			endwhile; ?>
		</div>
		<?php endif; ?>
	</div>
<?php

get_template_part( 'pagination' );
get_footer();
