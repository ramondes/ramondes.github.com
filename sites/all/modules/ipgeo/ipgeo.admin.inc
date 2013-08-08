<?php

/**
 * @file
 * ipgeo administration.
 */

/**
 * Main administrative page.
 */
function ipgeo_admin_page() {

  $build['search_ip_form'] = drupal_get_form('ipgeo_search_ip_form');
  $build['search_settings_form'] = drupal_get_form('ipgeo_search_settings_form');

  $header = array(
    array('data' => 'Начальный адрес', 'field' => 'begin'),
    array('data' => 'Конечный адрес',  'field' => 'end'),
    array('data' => 'Город',           'field' => 'city'),
    array('data' => 'Субъект',         'field' => 'subject'),
    array('data' => 'Округ',           'field' => 'fo'),
    array('data' => 'Код страны',      'field' => 'country'),
  );
  
  $query = db_select('ipgeo_blocks', 'ipb')
    ->extend('PagerDefault')
    ->extend('TableSort')
    ->fields('ipb', array('begin', 'end', 'country'))
    ->fields('ipr', array('rid', 'city', 'subject', 'fo'));
  $query->leftJoin('ipgeo_regions', 'ipr', 'ipb.rid = ipr.rid'); 
  
  $results = $query
    ->limit(50)
    ->orderByHeader($header)
    ->execute();
  $rows = array();
  foreach ($results as $result) {
    $rows[] = array(
      long2ip($result->begin),
      long2ip($result->end),
      $result->city,
      $result->subject,
      $result->fo,
      $result->country,
    );
  };

  $build['ipgeo_table'] = array(
    '#theme' => 'table',
    '#header' => $header,
    '#rows' => $rows,
    '#empty' => "Ничего не найдено.",
  );
  $build['ipgeo_pager'] = array('#theme' => 'pager');

  return $build;
}

/**
 * Menu callback; import IP blocks.
 */
function ipgeo_import_page() {
  $path = drupal_get_path('module', 'ipgeo');
  $build['ipgeo_import']['#prefix'] = '<ul>';
  $build['ipgeo_import']['#markup'] = '<li>Импорт IP блоков пока не реализован, поэтому их не обходимо загрузить в ручную.</li>';
  $build['ipgeo_import']['#markup'] .= '<li>Данные для импорта находятся в директории <em>' . $path . '/base</em>.</li>';
  $build['ipgeo_import']['#markup'] .= '<li>Актуальную базу можно скачать <a href="http://ipgeobase.ru/cgi-bin/Archive.cgi">здесь</a>.</li>';
  $build['ipgeo_import']['#suffix'] = '</ul>';
  return $build;
}

/**
 * IP search form builder.
 */
function ipgeo_search_settings_form() {
  $form['wrapper'] = array(
    '#type' => 'fieldset',
    '#title' => 'Настройки',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['wrapper'] ['ipgeo_data_source'] = array(
    '#type' => 'radios',
    '#title' => 'Источник данных',
    '#options' => array(
      'database' => 'Локальный – данные будут загружаться из локальной базы данных',
      'xml' => 'Удалённый – данные будут загружаться с помощью xml сервиса ipgeo.ru',
      ),
    '#default_value' => variable_get('ipgeo_data_source', 'database'),
  );
  $form['wrapper'] ['sbmt'] = array(
    '#type' => 'submit',
    '#value' => 'Сохранить',
  );
  $form['#submit'] = array('system_settings_form_submit');
  return $form;
}

/**
 * IP search form builder.
 */
function ipgeo_search_ip_form() {
  $form['#prefix'] = '<div class="container-inline">';
  $form['#suffix'] = '</div>';
  $form['ip'] = array(
    '#type' => 'textfield',
    '#title' => 'IP адрес',
    '#size' => 15,
    '#element_validate' => array('ipgeo_ip_element_validate'),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Проверить',
  );
  return $form;
}

/**
 * Element validate callback.
 */
function ipgeo_ip_element_validate($element, &$form_state) {
  if (!ipgeo_ip_validate(trim($element['#value']))) {
    form_error($element, 'IP адрес ввдён не корректно');  
  }
}

/**
 * IP search form submit.
 */
function ipgeo_search_ip_form_submit($form, &$form_state) {
  $ip = trim($form_state['values']['ip']);
  timer_start('ipgeo');
  $region = ipgeo_get_region($ip, TRUE);
  $duration = timer_read('ipgeo');
  if ($region) {
    $mode = variable_get('ipgeo_data_source', 'database') == 'database' ? 'локальный' : 'удалённый';
    $region_data = implode(' / ', (array)$region);
    $message = "Обработка завершена за $duration мс ($mode источник данных)<br/>";
    $message .= "<strong>$ip</strong> -&gt; $region_data<br/>";
    $message .= "<a href=\"http://ipgeobase.ru/?address=$ip\" target=\"_blank\">Проверить этот адрес на ipgeo.ru</a>";
    drupal_set_message($message);
  }
  else {
    drupal_set_message("IP адрес <strong>$ip</strong> не найден", 'warning');
  }
}
