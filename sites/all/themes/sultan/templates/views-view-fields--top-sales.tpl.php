<?php
  $output= array();
  foreach ($fields as $id => $field) {
    switch ($id) {
      case 'field_product_photos':
        $output[$id] = '<div class="prw">' . $field->content . '</div>';
        break;
      case 'commerce_price':
        $output[$id] = '<div class="price">' . $field->content . '</div>';
        break;
      default:
        $output[$id] = $field->content;
        break;
    }
  }
?>

<?php print $output['field_product_photos']; ?>
<div class="info-bar">
  <?php print $output['title_1']; ?>
  <?php print $output['commerce_price']; ?>
  <?php print $output['add_to_cart_form']; ?>
</div>