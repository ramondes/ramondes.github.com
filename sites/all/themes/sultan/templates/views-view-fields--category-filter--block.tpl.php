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
  <h4>
    <?php print $output['title_1']; ?>
  </h4>
  <div class="clearfix">
    <div class="price pull-left">
      <?php print $output['commerce_price']; ?>
    </div>
    <div class="btn-inverse pull-right">
      <?php print $output['add_to_cart_form']; ?>
    </div>
  </div>
</div>
