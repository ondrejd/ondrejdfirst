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
if( has_post_thumbnail() && get_theme_mod( 'ondrejdfirst_preview_show_thumbnail' ) ) {
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
<div <?php post_class( $extra_classes ); ?> id="post-<?php the_ID(); ?>" title="<?php the_title_attribute(); ?>">
	<?php if( get_theme_mod( 'ondrejdfirst_preview_show_thumbnail' ) ) : ?>
	<div class="preview-image" style="background-image: url( <?php the_post_thumbnail_url( 'ondrejdfirst_preview-image' ) ?> );">
		<?php the_post_thumbnail( 'ondrejdfirst_preview-image' ) ?>
	</div>
    <?php else : ?>
	<div class="preview-image"> </div>
    <?php endif ?>
	<header class="preview-header">
		<?php if ( is_sticky() ) : ?>
			<span class="sticky-post"><?php _e( 'Sticky', 'ondrejdfirst' ); ?></span>
		<?php endif; ?>
		<?php the_title( '<h2 class="title"><a href="'. get_the_permalink() .'">', '</a></h2>' ) ?>
		<?php if ( has_excerpt() ) : ?>
		<div class="preview-excerpt"><?php the_excerpt(); ?></div>
		<?php endif; ?>
		<div class="preview-category">
			<span class="dashicons dashicons-category"></span>
			<?php the_category( ' ' ) ?>
		</div>
		<div class="preview-tags"><?php
		$tags_arr = get_the_tags( '' );

		if( ! empty( $tags_arr ) && count( $tags_arr ) > 0 ) : ?>
			<span class="dashicons dashicons-tag" title="<?php _e( 'Tags', 'ondrejdfirst' ) ?>"></span>
		<?php
			$i = 1;
			foreach( $tags_arr as $tag ) :
				if( ( $tag instanceof WP_Term ) ) :
					echo '' .
						'<a href="' . get_tag_link( $tag->term_id ) . '" class="tag" title="' . $tag->description . '">' .
							$tag->name .
						'</a>' .
						( ( $i < count( $tags_arr ) ) ? ' | ' : '' );
				endif;
				$i++;
			endforeach;
		endif;

		?></div>
		<span class="preview-date">
            <span class="dashicons dashicons-calendar-alt" title="<?php _e( 'Date and time', 'ondrejdfirst' ) ?>"></span>
            <?php printf( __( '%s at %s', 'ondrejdfirst' ), get_the_date( 'j.n.Y' ), get_the_time( 'H:i' ) ) ?>
        </span>
	</header>
</div>
