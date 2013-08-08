<div class="price">
  <?php foreach ($items as $delta => $item) : ?>
    <?php 
      $a = array();
      $a = explode(' ', $item['#markup']);
      if (strpos($a[0], '.00')) {
        $a[0] = explode('.', $a[0]);
        $a[0] = $a[0][0];
      }
    ?>
    <?php print $a[0];?>
    <span><?php print $a[1];?></span>
  <?php endforeach; ?>
</div>