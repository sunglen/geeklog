<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/custommenu/install.php                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 dengen - taharaxp AT gmail DOT com                |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett               -    twillett AT users DOT sourceforge DOT net  |
// | Blaine Lang               -    langmail AT sympatico DOT ca               |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                -    tony AT tonybibbs DOT com                  |
// | Modified by:                                                              |
// | mystral-kk                -    geeklog AT mystral-kk DOT net              |
// | dengen                    -    taharaxp AT gmail DOT com                  |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

require_once '../../../lib-common.php';

$base_path = $_CONF['path'] . 'plugins/custommenu/';

require_once $base_path . 'functions.inc';

// Plugin information
//
// ----------------------------------------------------------------------------
//
$pi_display_name = 'CustomMenu';
$pi_name         = 'custommenu';
$pi_version      = $_CMED_CONF['version'];    // Plugin Version
$gl_version      = $_CMED_CONF['gl_version']; // GL Version
$pi_url          = $_CMED_CONF['pi_url'];     // Plugin Homepage

// Name of the Admin group
$pi_admin = $pi_display_name . ' Admin';

// The plugin's groups - assumes first group to be the Admin group
$GROUPS = array();
$GROUPS[$pi_admin] = 'Has full access to ' . $pi_name . ' features';


// Security Feature(s) to add
// Fill in your security features here.
// You do not have to use these particular features.
// You can edit/add/delete them to fit your plugins security model.
$FEATURES = array();
$FEATURES['custommenu.admin'] = "CustomMenu Admin";

$MAPPINGS = array();
$MAPPINGS['custommenu.admin'] = array($pi_admin);

// (optional) data to pre-populate tables with
// Insert table name and sql to insert default data for your plugin.
// Note: '#group#' will be replaced with the id of the plugin's admin group.
$DEFVALUES = array(); // not used here - see plugin_postinstall


/**
 * Checks the requirements for this plugin and if it is compatible with this
 * version of Geeklog.
 *
 * @return   boolean     true = proceed with install, false = not compatible
 *
 */
function plugin_compatible_with_this_geeklog_version()
{
    if (!function_exists('COM_truncate') || !function_exists('MBYTE_strpos')) {
        return false;
    }

    //if (!function_exists('SEC_createToken')) {
    //    return false;
    //}

    return true;
}

if (GL_VERSION_15) {

    /**
    * Loads the configuration records for the GL Online Config Manager
    *
    * @return   boolean     true = proceed with install, false = an error occured
    *
    */
    function plugin_load_configuration()
    {
        global $_CONF, $base_path;

        require_once $_CONF['path_system'] . 'classes/config.class.php';
        require_once $base_path . 'install_defaults.php';

        return plugin_initconfig_custommenu();
    }

}

/**
* Plugin postinstall
*
* We're inserting our default here since it depends on other stuff that has
* to happen first ...
*
* @return   boolean     true = proceed with install, false = an error occured
*
*/
function plugin_postinstall()
{
    global $_CONF, $_TABLES, $pi_admin, $LANG01;

    if (GL_VERSION_15) {
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $plg_config = config::get_instance();
        $_PLG_CONF = $plg_config->get_config('custommenu');
    }

    $admin_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = '{$pi_admin}'");
    $blockadmin_id  = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Block Admin'");

    $DEFVALUES = array();
    $url = addslashes('[site_url]/');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('home',       'gldefault', 'variable', '" . $LANG01[90]  . "', 'LANG01[90]',                           '$url', 10, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/submit.php?type=story');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var, php_function, url, menuorder, owner_id, group_id, perm_anon) VALUES ('contribute', 'gldefault', 'php',      '" . $LANG01[71]  . "', 'LANG01[71]', 'phpmenuitem_contribute', '$url', 20, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/search.php');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('search',     'gldefault', 'variable', '" . $LANG01[75]  . "', 'LANG01[75]',                           '$url', 30, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/stats.php');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('stats',      'gldefault', 'variable', '" . $LANG01[76]  . "', 'LANG01[76]',                           '$url', 40, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/directory.php');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('directory',  'gldefault', 'variable', '" . $LANG01[117] . "', 'LANG01[117]',                          '$url', 50, 2, '#group#' ,2)";

    $url = addslashes('[site_url]/usersettings.php?mode=edit');
    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var,               url, menuorder, owner_id, group_id, perm_anon) VALUES ('prefs',      'gldefault', 'variable', '" . $LANG01[48]  . "', 'LANG01[48]',                           '$url', 60, 2, '#group#' ,0)";

    $DEFVALUES[] = "INSERT INTO " . $_TABLES['menuitems'] . " (mid, type, mode, label, label_var, php_function, url, menuorder, owner_id, group_id, perm_anon) VALUES ('login',      'custom',    'php',      '" . $LANG01[47]  . "', '',           'phpmenuitem_login',      '',     70, 2, '#group#' ,2)";

    foreach ($DEFVALUES as $sql) {
        $sql = str_replace('#group#', $admin_group_id, $sql);
        DB_query($sql, 1);
        if (DB_error()) {
            COM_error("SQL error in custommenu plugin postinstall, SQL: " . $sql);
            return false;
        }
    }

    return true;
}


//
// ----------------------------------------------------------------------------
//
// The code below should be the same for most plugins and usually won't
// require modifications.

$langfile = $base_path . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $base_path . 'language/english.php';
}
require_once $base_path . 'functions.inc';


// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_accessLog("Someone has tried to illegally access the custommenu install/uninstall page.  "
                . "User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR", 1);
    $display = COM_siteHeader('menu', $LANG_ACCESS['accessdenied'])
             . COM_startBlock($LANG_ACCESS['accessdenied'])
             . $LANG_ACCESS['plugin_access_denied_msg']
             . COM_endBlock()
             . COM_siteFooter();

    echo $display;
    exit;
}


function plugin_uninstall_wrapper()
{
    global $pi_name;

    if (!GL_VERSION_15) {
        $uninstall_plugin = 'plugin_uninstall_' . $pi_name;
        uninstall_plugin();
    } else {
        PLG_uninstall($pi_name);
    }
}

/**
* Puts the datastructures for this plugin into the Geeklog database
*
*/
function plugin_install_now()
{
    global $_CONF, $_TABLES, $_USER, $_DB_dbms,
           $GROUPS, $FEATURES, $MAPPINGS, $DEFVALUES, $base_path,
           $pi_name, $pi_display_name, $pi_version, $gl_version, $pi_url;

    COM_errorLog("Attempting to install the $pi_display_name plugin", 1);


    // create the plugin's groups
    $admin_group_id = 0;
    foreach ($GROUPS as $name => $desc) {
        COM_errorLog("Attempting to create $name group", 1);

        $grp_name = addslashes($name);
        $grp_desc = addslashes($desc);
        DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) VALUES ('$grp_name', '$grp_desc')", 1);
        if (DB_error()) {
            plugin_uninstall_wrapper();

            return false;
        }

        // replace the description with the new group id so we can use it later
        $GROUPS[$name] = DB_insertId();

        // assume that the first group is the plugin's Admin group
        if ($admin_group_id == 0) {
            $admin_group_id = $GROUPS[$name];
        }
    }
    
    // Create the plugin's table(s)
    $_SQL = array();
    if (file_exists($base_path . 'sql/' . $_DB_dbms . '_install.php')) {
        require_once $base_path . 'sql/' . $_DB_dbms . '_install.php';
    }

    if (count($_SQL) > 0) {
        $use_innodb = false;
        if (($_DB_dbms == 'mysql') &&
            (DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'")
                == 'InnoDB')) {
            $use_innodb = true;
        }
        foreach ($_SQL as $sql) {
            $sql = str_replace('#group#', $admin_group_id, $sql);
            if ($use_innodb) {
                $sql = str_replace('MyISAM', 'InnoDB', $sql);
            }
            DB_query($sql);
            if (DB_error()) {
                COM_errorLog('Error creating table', 1);
                plugin_uninstall_wrapper();

                return false;
            }
        }
    }
    
    // Add the plugin's features
    COM_errorLog("Attempting to add $pi_display_name feature(s)", 1);

    foreach ($FEATURES as $feature => $desc) {
        $ft_name = addslashes($feature);
        $ft_desc = addslashes($desc);
        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
                 . "VALUES ('$ft_name', '$ft_desc')", 1);
        if (DB_error()) {
            plugin_uninstall_wrapper();

            return false;
        }

        $feat_id = DB_insertId();

        if (isset($MAPPINGS[$feature])) {
            foreach ($MAPPINGS[$feature] as $group) {
                COM_errorLog("Adding $feature feature to the $group group", 1);
                DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, {$GROUPS[$group]})");
                if (DB_error()) {
                    plugin_uninstall_wrapper();

                    return false;
                }
            }
        }
    }

    // Add plugin's Admin group to the Root user group
    // (assumes that the Root group's ID is always 1)
    COM_errorLog("Attempting to give all users in the Root group access to the $pi_display_name's Admin group", 1);

    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES "
             . "($admin_group_id, NULL, 1)");
    if (DB_error()) {
        plugin_uninstall_wrapper();

        return false;
    }

    // Pre-populate tables or run any other SQL queries
    COM_errorLog('Inserting default data', 1);
    foreach ($DEFVALUES as $sql) {
        $sql = str_replace('#group#', $admin_group_id, $sql);
        DB_query($sql, 1);
        if (DB_error()) {
            plugin_uninstall_wrapper();

            return false;
        }
    }

    // Load the online configuration records
    if (function_exists('plugin_load_configuration')) {
        if (!plugin_load_configuration()) {
            plugin_uninstall_wrapper();

            return false;
        }
    }

    // Finally, register the plugin with Geeklog
    COM_errorLog("Registering $pi_display_name plugin with Geeklog", 1);

    // silently delete an existing entry
    DB_delete($_TABLES['plugins'], 'pi_name', $pi_name);

    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) VALUES "
        . "('$pi_name', '$pi_version', '$gl_version', '$pi_url', 1)");

    if (DB_error()) {
        plugin_uninstall_wrapper();

        return false;
    }

    // give the plugin a chance to perform any post-install operations
    if (function_exists('plugin_postinstall')) {
        if (!plugin_postinstall()) {
            plugin_uninstall_wrapper();

            return false;
        }
    }

    if (GL_VERSION_15) {
        // Set menu elements
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $c = config::get_instance();
        $c->set('menu_elements', array('custom'));

        require_once $_CONF['path'] . 'plugins/custommenu/autoinstall.php';
        CMED_addPluginsMenuitems();
    }

    COM_errorLog("Successfully installed the $pi_display_name plugin!", 1);

    return true;
}

// MAIN
$display = '';

if (SEC_checkToken()) {
    if ($_REQUEST['action'] == 'uninstall') {
        $uninstall_plugin = 'plugin_uninstall_' . $pi_name;
        if ($uninstall_plugin()) {
            $display = COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=45');
        } else {
            $display = COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=73');
        }
    } else if (DB_count($_TABLES['plugins'], 'pi_name', $pi_name) == 0) {
        // plugin not installed

        if (plugin_compatible_with_this_geeklog_version()) {
            if (plugin_install_now()) {
                $display = COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=44');
            } else {
                $display = COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=72');
            }
        } else {
            // plugin needs a newer version of Geeklog
            $display .= COM_siteHeader('menu', $LANG32[8])
                     . COM_startBlock($LANG32[8])
                     . '<p>' . $LANG32[9] . '</p>'
                     . COM_endBlock()
                     . COM_siteFooter();
        }
    } else {
        // plugin already installed
        $display .= COM_siteHeader('menu', $LANG01[77])
                 . COM_startBlock($LANG32[6])
                 . '<p>' . $LANG32[7] . '</p>'
                 . COM_endBlock()
                 . COM_siteFooter();
    }
} else {
    $display = COM_refresh($_CONF['site_admin_url'].'/plugins.php');
}

echo $display;

?>