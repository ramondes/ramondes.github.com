<?php
/*
 * Admin settings page
 */

function jstree_admin_settings_form($form, &$form_state) {

  $form = array();

  $menus = _jstree_menu_menus();

  $form['jstree_forms_ids'] = array(
    '#type' => 'textarea',
    '#title' => t('Form CSS IDs'),
    '#rows' => 3,
    '#cols' => 40,
    '#default_value' => variable_get('jstree_forms_ids', '#primary-menu-bar nav'),
    '#description' => t('Enter the CSS IDs/class of the menu containing the UL. One per line. SAMPLE: #block-menu-menu-texturen .content'),
  );

  $form['jstree_id_list'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Add ids to the following menus'),
    '#options' => $menus,
    '#default_value' => variable_get('jstree_id_list', array()),
    '#description' => t('Jstree cookie plugin requires the li element to have a id (or it will not work). Some modules like taxonomy_menu do not add an id. You can enable id adding here. The id will only be added if there isn´t already an id.'),
  );

  //Theme usage
  $form['jstree']['jstree_theme_select'] = array(
    '#type' => 'radios',
    '#title' => 'Chose Theme usage',
    '#default_value' => variable_get('jstree_theme_select', 'default'),
    '#options' => array(
      'default' => t('Use themes bundled with the script'),
      'custom' => t('Specify custom theme'),
    ),
    '#description' => '',

  );

  //a custom theme
  $form['jstree_custom_theme'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom theme'),
    '#collapsible' => FALSE,
    '#states' => array(
      'visible' => array (
        ':input[name="jstree_theme_select"]' => array('value' => 'custom'),
      )
    )
  );

  $form['jstree_custom_theme']['jstree_custom_theme_name'] = array(
    '#type' => 'textfield',
    '#title' => t('Name of the Skin'),
    '#default_value' => variable_get('jstree_custom_theme_name', ''),
    '#description' => t('The name of the skin. This is used to set the css class. Normally you name it after the skinfolder. Example themes can be found inside the scripts folder.'),
  );

  $form['jstree_custom_theme']['jstree_custom_theme_path'] = array(
    '#type' => 'textfield',
    '#title' => t('Path to custom theme folder'),
    '#default_value' => variable_get('jstree_custom_theme_path', ''),
    '#description' => t("If you want to use a custom theme, set the path here. Example sites/all/themes/adaptivetheme/adaptivetheme_subtheme/MYSKIN/style.css'. <strong>NO LEADING SLASH</strong>"),

  );

  //the standard themes shipped with the script
  $form['jstree_themes'] = array(
    '#type' => 'fieldset',
    '#title' => t('Standard themes'),
    '#collapsible' => FALSE,
    '#states' => array(
      'visible' => array (
        ':input[name="jstree_theme_select"]' => array('value' => 'default'),
      )
    )
  );

  $form['jstree_themes']['jstree_script_themes'] = array(
    '#type' => 'select',
    '#title' => t('Themes bundled with the script itself'),
    '#default_value' => variable_get('jstree_script_themes', 'classic'),
    '#options' => array (
     'classic' => 'Classic',
     'apple' => 'Apple',
     'default' => 'Default',
     ),
    '#description' => t('Select a default theme that shipps with jstree'),
  );

  //users can add a custom jstree (strip plugins)
  $form['jstree_custom_script'] = array(
      '#type' => 'textfield',
      '#title' => t('Path to custom jstree (stripped plugins for smaller size)'),
      '#default_value' => variable_get('jstree_custom_script', ''),
      '#description' => t("If you want to reduce the filesize of the script, you can manually remove plugins from jquery.jstree.js. <strong>ONLY if you know what you are doing. Most people should leave this field empty</strobg>"),
  );

  return system_settings_form($form);
}


/**
 * Helper function to get avaliable menus
 *
 * @return $menu_names
 *  array with avaliable menus
 *
 */

function _jstree_menu_menus() {
  if (function_exists('menu_get_menus')) {
    // If the menu module is enabled, list custom menus.
    $menus = menu_get_menus();
  }
  else {
    // Otherwise, list only system menus.
    $menus = menu_list_system_menus();
  }

  // If the book module is enabled, also include book menus.
  if (function_exists('book_get_books')) {
    foreach (book_get_books() as $bid => $link) {
      $menus["book-toc-$bid"] = t('Book: %title', array('%title' => $link['title']));
    }
  }

  // menu_get_names() filters out empty menus, and adds any menus not found using the above calls (edge case).
  foreach (menu_get_names() as $menu) {
    $menu_names[$menu] = isset($menus[$menu]) ? $menus[$menu] : t('Other menu: %menu', array('%menu' => $menu));
  }

  return $menu_names;
}



