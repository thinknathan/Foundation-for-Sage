<?php use Roots\Sage\Setup ?>
<?php use Roots\Sage\Assets ?>

<header class="site-header">
  <div data-sticky-container>
    
    <!-- Title Bar for small screens -->
    <div class="site-title-bar-small headroom" data-sticky data-stick-to="top" data-sticky-on="small" data-options="marginTop:0;" data-headroom data-tolerance="5" data-offset="200">
      <div class="site-title-bar-small-inner">
        
        <div class="site-title-bar-left">
          <h1 class="site-title">
            <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home">
              <img src="<?= Assets\asset_path('images/logo.svg') ?>" width="100" height="40" alt="<?php bloginfo('name'); ?>" class="site-title-logo">
            </a>
          </h1>
        </div>
        
        <div class="site-title-bar-right">
          <button class="menu-button" type="button" data-open="offCanvas">Menu <span class="menu-icon"></span></button>
        </div>
        
      </div> <!-- /.site-title-bar-small-inner -->
    </div> <!-- /.site-title-bar-small -->
    
  </div> <!-- /data-sticky-container -->
  
  <div data-sticky-container>
 
    <!-- Full Navigation for large screens -->
    <div class="site-navigation-full" data-sticky data-stick-to="top" data-options="marginTop:0;" data-top-anchor="100">
      <div class="site-navigation-full-inner">

        <div class="site-logo-section">
          <h1 class="site-title">
            <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home">
              <img src="<?= Assets\asset_path('images/logo.svg') ?>" width="200" height="80" alt="<?php bloginfo('name'); ?>" class="site-title-logo">
            </a>
          </h1>
        </div>

        <div class="site-links-section">
          <nav class="site-nav">
            <?php Setup\top_nav(); ?>
          </nav>
        </div>

      </div> <!-- /.site-navigation-full-inner -->
    </div> <!-- /.site-navigation-full -->
    
  </div> <!-- /data-sticky-container -->
</header>
