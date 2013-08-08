/*
 Adding jstree settings to the selected menus
 */

(function ($) {
    Drupal.behaviors.drupalJstree = {
        attach:function (context, settings) {

            //menus to add the script to
            var menus = settings.jstreeMenus;

            //jstree theme type select
            var themeSelect = settings.jstreeThemeSelect;

            //custom theme path, if set
            var customThemePath = settings.jstreeCustomThemePath;
            //custom theme name, if set
            var customThemeName = settings.jstreeCustomThemeName;

            //Themes shipped with the script
            var scriptThemes = settings.jstreeScriptThemes;

            //Custom jstree script
            var customScript = settings.jstreeCustomScript;

            var scriptPath = settings.jstreeLibraryPath;

            //set std values
            var url = false
            var themeName = "default"

            //set url/theme name dependend on theme select method from setting
            if (themeSelect == 'custom') {
                url = customThemePath;
                themeName = customThemeName;
            }

            if(themeSelect == 'default')
            {
               url = scriptPath + '/themes/' + scriptThemes + '/style.css';
               themeName = scriptThemes
            }

            //info: just write absolute urls into url or js aggregation kills style
            //@todo this seems not really good but works

            //loop through all menu ids
            $.each(menus, function (index, value) {
                $(value).jstree({
                    "themes":{
                        "theme": themeName,
                        "url": 'http://' + document.domain + '/' + url,
                        "dots":true,
                        "icons":true
                    },
                    //set the cookie to be global
                    "cookies" : {
                      "cookie_options": { path: '/' }
                    },
                    "plugins":[ "themes", "html_data", "cookies" ]
                });
            });
        }
    }
}(jQuery));






