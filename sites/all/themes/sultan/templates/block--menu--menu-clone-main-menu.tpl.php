<div id="<?php print $block_html_id; ?>" class="span5 <?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <h2<?php print $title_attributes; ?>><?php print $title; ?></h2>
  <?php endif;?>
  <?php print render($title_suffix); ?>

  <?php print $content ?>
<p class="copy">
                      2013 Sultan ©<br>
                        Всі права захищено
                    </p>
</div>