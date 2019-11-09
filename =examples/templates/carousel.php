<section class="test-section">
  <h1>Carousel</h1>
  <div class="carousel carousel--load carousel--cards">
    <div class="carousel__track">
      <?php get_template_part('templates/card'); ?>
      <?php get_template_part('templates/card'); ?>
      <?php get_template_part('templates/card'); ?>
      <?php get_template_part('templates/card'); ?>
      <?php get_template_part('templates/card'); ?>
    </div>
    <ul class="carousel__controls" aria-label="Content slider controls">
      <li class="carousel__control-list-item">
        <button role="button" aria-label="Previous" class="carousel__control carousel__control--prev"></button>
      </li>
      <li class="carousel__control-list-item">
        <button role="button" aria-label="Next" class="carousel__control carousel__control--next"></button>
      </li>
    </ul>
    <div role="tablist" class="carousel__dots"></div>
  </div>
</section>
