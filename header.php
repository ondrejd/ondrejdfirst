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

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
        <link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
        <header class="section-inner site-header group">
			<?php if ( function_exists( 'the_custom_logo' ) && get_theme_mod( 'custom_logo' ) ) :
				$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
				$logo_url = $logo[0];

				$width = $logo[1];
				$height = $logo[2];

				// Determine which height logo we need the mobile nav to adjust for
				$adjusted_height = $height < 100 ? $height : 100;
				?>
				<style>
					.site-nav {
						padding-top: <?php echo $adjusted_height + 160; ?>px;
					}
					@media ( max-width: 620px ) {
						.site-nav {
							padding-top: <?php echo $adjusted_height + 100; ?>px;
						}
					}
				</style>
				<a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>" class="custom-logo" style="background-image: url( <?php echo $logo_url; ?> );">
					<img src="<?php echo $logo_url; ?>" />
				</a>
			<?php elseif ( is_singular() ) : ?>
				<h2 class="site-title">
					<a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php bloginfo( 'name' ); ?></a>
					<small class="site-description"><?php bloginfo( 'description' ); ?></small>
				</h2>
			<?php else : ?>
				<h2 class="site-title">
					<a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php bloginfo( 'name' ); ?></a>
					<small class="site-description"><?php bloginfo( 'description' ); ?></small>
				</h2>
			<?php endif; ?>

			<div class="nav-toggle">
				<div class="bar"></div>
				<div class="bar"></div>
				<div class="bar"></div>
			</div>

			<ul class="alt-nav">
				<?php
				if ( has_nav_menu( 'primary-menu' ) ) :
					wp_nav_menu( array(
						'container' 		=> '',
						'items_wrap' 		=> '%3$s',
						'theme_location' 	=> 'primary-menu',
					) );
				else :
					wp_list_pages( array(
						'container' => '',
						'title_li' 	=> ''
					) );
				endif;
				?>
			</ul>

        </header> <!-- header -->

		<nav class="site-nav">
			<div class="section-inner menus group">
				<?php
				if ( has_nav_menu( 'primary-menu' ) ) :
					wp_nav_menu( [
						'container' 		=> '',
						'theme_location' 	=> 'primary-menu'
					] );
				else : ?>
					<ul><?php
						wp_list_pages( [
							'container' => '',
							'title_li' 	=> ''
						] );
					?></ul><?php
				endif;

				if ( has_nav_menu( 'secondary-menu' ) ) {
					wp_nav_menu( [
						'container' 		=> '',
						'theme_location' 	=> 'secondary-menu'
					] );
				}
				?>
			</div>
			<?php get_template_part( 'footer-content' ) ?>
		</nav>
