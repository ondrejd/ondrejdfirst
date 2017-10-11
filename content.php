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


$extra_classes = 'post-preview tracker';

// Determine whether a fallback is needed for sizing
if( has_post_thumbnail() ) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'ondrejdfirst_preview-image' );
	if( $image ) {
		$aspect_ratio = $image[2] / $image[1];
		// Guaranteee a mininum aspect ratio of 3/4
		if( $aspect_ratio <= 0.75 ) {
			$extra_classes .= ' fallback-image';
		}
	}
} else {
	$extra_classes .= ' fallback-image';
}

?>

<a <?php post_class( $extra_classes ) ?> id="post-<?php the_ID() ?>" href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>">
	<div class="preview-image" style="background-image: url( <?php the_post_thumbnail_url( 'ondrejdfirst_preview-image' ) ?> );">
		<?php the_post_thumbnail( 'ondrejdfirst_preview-image' ) ?>
	</div>
	<header class="preview-header">
		<?php if ( is_sticky() ) : ?>
			<span class="sticky-post"><?php _e( 'Nálepka', 'ondrejdfirst' ) ?></span>
		<?php endif; ?>
		<?php the_title( '<h2 class="title">', '</h2>' ) ?>
	</header>
</a>
