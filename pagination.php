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

if( get_the_posts_pagination() ) : ?>
	<div class="post-pagination section-inner group">
		<?php if ( get_previous_posts_link() ) : ?>
		<div class="previous-posts-link">
			<h4 class="title"><?php previous_posts_link( __( 'Novější', 'ondrejdfirst' ) ); ?></h4>
		</div>
		<?php endif; ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="next-posts-link">
			<h4 class="title"><?php next_posts_link( __( 'Starší', 'ondrejdfirst' ) ); ?></h4>
		</div>
		<?php endif; ?>
	</div>
<?php

endif;
