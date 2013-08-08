Currently used plugins
--------------------------------
"plugins":[ "themes", "html_data", "cookies" ]


Original script
---------------------------------
http://www.jstree.com/



ATTENTION
------------------------------------
Caution when adding classes like

OK:
$variables['element']['#attributes']['class'][] = 'drupal-jstree';

NOT OK, KILL SCRIPT in some way
$variables['element']['#attributes']['class'][] = 'jstree';

be secure and do not interfere with the class names
