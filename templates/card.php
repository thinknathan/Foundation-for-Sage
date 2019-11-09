<?php
/*
 * Foundation Card element
 * Add `.card--image-first` to swap order of photo and title section
 * Remove `.card--single-link` to make only the anchor part of the card clickable

 ===================================

 More elements you may want to add:

  <div class="card__avatar">
    <?php echo get_avatar( get_the_author_meta( 'ID' ) , 32 ); ?>
  </div>
  <p class="card__meta">
    Posted <time datetime="<?= get_the_date('c'); ?>"><?= get_the_date('F j, Y'); ?></time>
  </p>
  <p class="card__meta">
    Modified <time datetime="<?= get_the_modified_date('c'); ?>"><?= get_the_modified_date('F j, Y'); ?></time>
  </p>

 ===================================

 */

 use Roots\Sage\Util;

 // Encode the title as a base36 number for use as a unique ID
 $card_id = intval(get_the_title(), 36);

?>

<div class="card card--<?= esc_attr( get_post_type() ) ?> card--single-link">
  <div class="card__section card__section--head">

    <h2 class="card__title h3">
      <a class="card__title-link" href="<?php the_permalink() ?>" aria-describedby="card__button-<?= $card_id ?>"><?= Util\snip(get_the_title(), '9', 'words'); ?></a>
    </h2>

    <p class="card__meta card__meta--head">
      By <?php the_author() ?>
    </p>
  </div>

  <div class="card__image">
    <?php the_post_thumbnail('card__thumbnail'); ?>
  </div>

  <div class="card__section">
    <p class="card__meta">
      <?= Util\snip(get_the_content(), '15', 'words'); ?>
    </p>
  </div>

  <div class="card__section">
    <div class="button-group">
      <span class="button" aria-hidden="true" id="card__button-<?= $card_id ?>">Read More</span>
    </div>
  </div>
</div>
