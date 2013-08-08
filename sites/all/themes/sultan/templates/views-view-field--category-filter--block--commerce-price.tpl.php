<?php
  $a = array();
  $a = explode(' ', $output);
  if (strpos($a[0], '.00')) {
    $a[0] = explode('.', $a[0]);
    $a[0] = $a[0][0];
  }
?>
<div class="price">
  <?php print $a[0];?>
  <span><?php print $a[1];?></span>
</div>