<?php
/*
 * Foundation Card element
 * Add `.card-image-first` to swap order of photo and title section
 * Remove `.card-single-link` to make only the anchor part of the card clickable

 ===================================

 More elements you may want to add:

  <div class="card-avatar">
    <?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
  </div>
  <p class="card-meta">
    Posted <time datetime="<?= get_the_date('c'); ?>"><?= get_the_date('F j, Y'); ?></time>
  </p>
  <p class="card-meta">
    Modified <time datetime="<?= get_the_modified_date('c'); ?>"><?= get_the_modified_date('F j, Y'); ?></time>
  </p>

 ===================================

 */

 use Roots\Sage\Util;

 // Encode the title as a base36 number for use as a unique ID
 $card_id = intval(get_the_title(), 36);

?>

<div class="card card-<?= esc_attr( get_post_type() ) ?> card-single-link">
  <div class="card-section card-section-head">

    <h2 class="card-title h3">
      <a class="card-title-link" href="<?php the_permalink() ?>" aria-describedby="card-button-<?= $card_id ?>"><?= Util\snip(get_the_title(), '9', 'words'); ?></a>
    </h2>

    <p class="card-meta">
      By <?php the_author() ?>
    </p>
  </div>

  <div class="card-image">
    <?php the_post_thumbnail('card-thumbnail'); ?>
  </div>

  <div class="card-section">
    <p class="card-meta">
      <?= Util\snip(get_the_content(), '15', 'words'); ?>
    </p>
  </div>

  <div class="card-section">
    <div class="button-group">
      <span class="button" aria-hidden="true" id="card-button-<?= $card_id ?>">Read More</span>
    </div>
  </div>
</div>
