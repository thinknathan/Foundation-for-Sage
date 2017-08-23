<header class="site-header">

  <div data-sticky-container>
    <div class="title-bar-small headroom" data-sticky data-sticky-on="small" data-options="marginTop:0;" data-headroom>
      <div class="container">
        <div class="title-bar-left">
          <h1 class="site-title">
            <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home">
              <?php bloginfo('name'); ?>
            </a>
          </h1>
          <p class="site-description">
            <?= get_bloginfo('description') ?>
          </p>
        </div>
        <div class="title-bar-right">
          <button class="menu-icon" type="button" data-open="offCanvas"></button>
        </div>
      </div>
    </div>
  </div>

  <div class="site-hero">
    <div class="container">
      <div class="column">
        <h1 class="site-title">
          <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php bloginfo('name'); ?>
          </a>
        </h1>
        <p class="site-description">
          <?= get_bloginfo('description') ?>
        </p>
      </div>
    </div>
  </div>
  <?php if (has_nav_menu('primary_navigation')): ?>
  <div data-sticky-container>
    <nav class="site-nav" data-sticky data-sticky-on="large" data-stick-to="top" data-margin-top="0" data-anchor="document">
      <div class="container">
        <?php Roots\Sage\Setup\top_nav(); ?>
      </div>
    </nav>
  </div>
  <?php endif; ?>

</header>
