<?php
/**
 * Social Share links
 * Adapted from:
 * @link https://10up.github.io/wp-component-library/component/social-share/index.html
 */

$imgurl = urlencode( esc_url( get_the_post_thumbnail_url() ));
$posturl = urlencode( esc_url( get_permalink() ));

?>

<div class="social-share">

  <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $posturl; ?>&t=<?= urlencode( $post->post_title ); ?>" target="_blank" rel="noopener noreferrer" class="button social-share__link ">
    <?php esc_html_e( 'Share on Facebook', 'sage' ); ?><span class="show-for-sr"><?php esc_html_e( '(opens new window)', 'sage' ); ?></span>
  </a>

  <a href="https://twitter.com/share?text=<?php the_title(); ?>&url=<?= $posturl; ?>" target="_blank" rel="noopener noreferrer" class="button social-share__link ">
    <?php esc_html_e( 'Share on Twitter', 'sage' ); ?>  <span class="show-for-sr"><?php esc_html_e( '(opens new window)', 'sage' ); ?></span>
  </a>

  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $posturl; ?>&title=<?php the_title(); ?>" target="_blank" rel="noopener noreferrer" class="button social-share__link ">
    <?php esc_html_e( 'Share on LinkedIn', 'sage' ); ?> <span class="show-for-sr"><?php esc_html_e( '(opens new window)', 'sage' ); ?></span>
  </a>

  <a href="http://www.pinterest.com/pin/create/bookmarklet/?url=<?= $posturl; ?><?php if(!empty($imgurl)): ?>&media=<?= $imgurl; endif; ?>&is_video=false&description=<?= urlencode( esc_attr( get_the_excerpt() ) ); ?>" target="_blank" rel="noopener noreferrer" class="button social-share__link ">
    <?php esc_html_e( 'Share on Pinterest', 'sage' ); ?> <span class="show-for-sr"><?php esc_html_e( '(opens new window)', 'sage' ); ?></span>
  </a>

</div>
