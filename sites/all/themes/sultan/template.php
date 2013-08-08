<?php

/**
 * Sultan theme wrapper function for the main_menu links
 */
function sultan_menu_tree__main_menu($vars) {
  return '<ul class="submenu">' . $vars['tree'] . '</ul>';
}

/**
 * Sultan theme wrapper function for the menu-catalog links
 */
function sultan_menu_tree__menu_catalog($vars) {
  return '<ul class="container text-center">' . $vars['tree'] . '</ul>';
}

function sultan_form_element_label(&$variables) {
  if (isset($variables['element']['#parents'][1]) && 
            $variables['element']['#parents'][1] == 'field_product_color' &&
            $variables['element']['#name'] = 'attributes[field_product_color]' &&
            ! isset($variables['element']['#options'])) {
    $element = $variables['element'];
    $t = get_t();
    if ((!isset($element['#title']) || $element['#title'] === '') && empty($element['#required'])) {
      return '';
    }
    $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';
    $title = filter_xss_admin($element['#title']);
    $attributes = array();
    if ($element['#title_display'] == 'after') {
      $attributes['class'] = 'option';
    }
    elseif ($element['#title_display'] == 'invisible') {
      $attributes['class'] = 'element-invisible';
    }
    if (!empty($element['#id'])) {
      $attributes['for'] = $element['#id'];
    }

    $style = '';
    if (isset($element['#return_value'])) {
      $term = taxonomy_term_load($element['#return_value']);
      $color = $term->field_color[LANGUAGE_NONE][0]['jquery_colorpicker'];
      $style = '<span style="background-color:#' . $color . '"></span>';
    }

    return " <label " . drupal_attributes($attributes) . ">$style" . $t('!title !required', array('!title' => $title, '!required' => $required)) . $element['#children'] . "</label>\n";
  }

  $element = $variables['element'];
// This is also used in the installer, pre-database setup.
  $t = get_t();

  // If title and required marker are both empty, output no label.
  if ((!isset($element['#title']) || $element['#title'] === '') && empty($element['#required'])) {
    return '';
  }

  // If the element is required, a required marker is appended to the label.
  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';

  $title = filter_xss_admin($element['#title']);

  $attributes = array();
  // Style the label as class option to display inline with the element.
  if ($element['#title_display'] == 'after') {
    $attributes['class'] = 'option';
  }
  // Show label only to screen readers to avoid disruption in visual flows.
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'] = 'element-invisible';
  }

  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }

  // The leading whitespace helps visually separate fields from inline labels.
  return ' <label' . drupal_attributes($attributes) . '>' . $t('!title !required', array('!title' => $title, '!required' => $required)) . "</label>\n";
}

function sultan_preprocess(&$vars, $hook) {
  // drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($hook,1)).'</pre>');
  if (strpos($hook, 'commerce_cart_add_to_cart_form_') === 0) {
    // drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($vars,1)).'</pre>');
  }
}


function sultan_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';
  // drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($element['#title'],1)).'</pre>');

  if ($element['#below']) {
    if (isset($element['#below']['#children'])) {
      drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($element['#below']['#children'],1)).'</pre>');
      $element['#below']['#children'] = str_replace(' class="container text-center"',"",$element['#below']['#children']);
      drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($element['#below']['#children'],1)).'</pre>');
    }
    $sub_menu = drupal_render($element['#below']);
    // drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($element['#below'],1)).'</pre>');
    
    // drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($element['#below'],1)).'</pre>');
  }

  if ($element['#original_link']['menu_name'] == 'menu-catalog') {
   // drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($variables,1)).'</pre>');
    if (! $element['#original_link']['p2']) {
      $new_title = $element['#title'];
      $new_title = '<span>' . $new_title . '</span>';
      // drupal_set_message('<pre><h5><i><u>Debug:</u></i></h5>'.check_plain(print_r($element['#localized_options'],1)).'</pre>');
      // $element['html'] = '<span>';
      $output = l2($new_title, $element['#href'], $element['#localized_options']);

      return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
    }
  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * perekritie standart l
 */
function l2($text, $path, array $options = array()) {
  global $language_url;
  static $use_theme = NULL;

  // Merge in defaults.
  $options += array(
    'attributes' => array(),
    'html' => FALSE,
  );

  // Append active class.
  if (($path == $_GET['q'] || ($path == '<front>' && drupal_is_front_page())) && (empty($options['language']) || $options['language']->language == $language_url->language)) {
    $options['attributes']['class'][] = 'active';
  }

  // Remove all HTML and PHP tags from a tooltip. For best performance, we act only
  // if a quick strpos() pre-check gave a suspicion (because strip_tags() is expensive).
  if (isset($options['attributes']['title']) && strpos($options['attributes']['title'], '<') !== FALSE) {
    $options['attributes']['title'] = strip_tags($options['attributes']['title']);
  }

  // Determine if rendering of the link is to be done with a theme function
  // or the inline default. Inline is faster, but if the theme system has been
  // loaded and a module or theme implements a preprocess or process function
  // or overrides the theme_link() function, then invoke theme(). Preliminary
  // benchmarks indicate that invoking theme() can slow down the l() function
  // by 20% or more, and that some of the link-heavy Drupal pages spend more
  // than 10% of the total page request time in the l() function.
  if (!isset($use_theme) && function_exists('theme')) {
    // Allow edge cases to prevent theme initialization and force inline link
    // rendering.
    if (variable_get('theme_link', TRUE)) {
      drupal_theme_initialize();
      $registry = theme_get_registry(FALSE);
      // We don't want to duplicate functionality that's in theme(), so any
      // hint of a module or theme doing anything at all special with the 'link'
      // theme hook should simply result in theme() being called. This includes
      // the overriding of theme_link() with an alternate function or template,
      // the presence of preprocess or process functions, or the presence of
      // include files.
      $use_theme = !isset($registry['link']['function']) || ($registry['link']['function'] != 'theme_link');
      $use_theme = $use_theme || !empty($registry['link']['preprocess functions']) || !empty($registry['link']['process functions']) || !empty($registry['link']['includes']);
    }
    else {
      $use_theme = FALSE;
    }
  }
  if ($use_theme) {
    return theme('link', array('text' => $text, 'path' => $path, 'options' => $options));
  }
  // The result of url() is a plain-text URL. Because we are using it here
  // in an HTML argument context, we need to encode it properly.
  return '<a href="' . check_plain(url($path, $options)) . '"' . drupal_attributes($options['attributes']) . '>' . ($options['html'] ? $text : $text) . '</a>';
}


function sultan_preprocess_page($variables){
  if (drupal_is_front_page()) {
    $path = drupal_get_path('theme', 'sultan');
    drupal_add_js($path . '/js/jquery-1.7.2.min.js');
    drupal_add_js($path . '/js/core.js');
  }
}