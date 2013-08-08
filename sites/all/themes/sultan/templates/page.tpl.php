<div class="header">
  <div class="container">
    <div class="row">
      <?php if (!empty($logo)): ?>
        <div class="span2">
          <a class="logo pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
          </a>
        </div>
      <?php endif; ?>
      <div class="span8 text-center">
        <?php if (!empty($site_name)): ?>
          <h1 id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" class="brand"><?php print $site_name; ?></a>
          </h1>
        <?php endif; ?>

        <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
          <div class="nav-collapse collapse">
            <nav role="navigation">
              <?php if (!empty($secondary_nav)): ?>
                <?php //print render($secondary_nav); ?>
              <?php endif; ?>
              <?php if (!empty($page['navigation'])): ?>
                <?php print render($page['navigation']); ?>
              <?php endif; ?>
              <?php if (!empty($primary_nav)): ?>
                <?php //print render($primary_nav); ?>
              <?php endif; ?>
            </nav>
          </div>
        <?php endif; ?>
      </div>
        <?php if (!empty($page['right_navigation'])): ?>
          <div class="span2 text-right">
            <?php print render($page['right_navigation']); ?>
          </div>
        <?php endif; ?>
    </div>
  </div>

  <div class="main-menu">
    <div class="wrapper1">
        <div class="wrapper2">
            <div class="container">
              <?php if (!empty($page['header_katalog'])): ?>
                <?php print render($page['header_katalog']); ?>
              <?php endif; ?>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- / HEADER -->

<!-- MAIN CONTAINER -->
<div class="main-container">
  <div class="container">

    <header role="banner" id="page-header">
      <?php if (!empty($site_slogan)): ?>
        <p class="lead"><?php print $site_slogan; ?></p>
      <?php endif; ?>

      <?php print render($page['header']); ?>
    </header> <!-- /#header -->

    <div class="row">

      <?php if (!empty($page['sidebar_first'])): ?>
        <aside class="span3" role="complementary">
          <?php print render($page['sidebar_first']); ?>

        </aside>  <!-- /#sidebar-first -->
      <?php endif; ?>  

      <div class="<?php print _bootstrap_content_span($columns); ?>">  
        <?php if (!empty($page['highlighted'])): ?>
          <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
        <?php endif; ?>
        <?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
        <a id="main-content"></a>
        

          <?php print render($title_prefix); ?>
          <?php if (!empty($title)): ?>
            <h1><?php print $title; ?></h1>
          <?php endif; ?>
          <?php print render($title_suffix); ?>


        <?php print $messages; ?>
        <?php if (!empty($tabs)): ?>
          <?php print render($tabs); ?>
        <?php endif; ?>
        <?php if (!empty($page['help'])): ?>
          <div class="well"><?php print render($page['help']); ?></div>
        <?php endif; ?>
        <?php if (!empty($action_links)): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print render($page['content']); ?>
      </div>

      <?php if (!empty($page['sidebar_second'])): ?>
        <aside class="span3" role="complementary">
          <?php print render($page['sidebar_second']); ?>
        </aside>  <!-- /#sidebar-second -->
      <?php endif; ?>

    </div>

  </div>  
</div>

<div class="push-footer"></div>

<div class="footer">
  <div class="container">
    <div class="row">
      <?php print render($page['footer']); ?>
    </div>
  </div>
</div>
