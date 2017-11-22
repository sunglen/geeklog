<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | CustomMenu Editor Plugin for Geeklog                                      |
// +---------------------------------------------------------------------------+
// | plugins/custommenu/autoinstall.php                                        |
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

require_once 'config.php';

if (!defined('GL_VERSION_15')) {
    define('GL_VERSION_15', (version_compare(VERSION, '1.5') >= 0));
}

function plugin_autoinstall_custommenu($pi_name)
{
    global $_CMED_CONF;

    $pi_name         = 'custommenu';
    $pi_display_name = 'CustomMenu';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => $_CMED_CONF['version'],
        'pi_gl_version'   => $_CMED_CONF['gl_version'],
        'pi_homepage'     => $_CMED_CONF['pi_url']
    );

    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        $pi_name . '.admin'  => 'CustomMenu Admin'
    );

    $mappings = array(
        $pi_name . '.admin'  => array($pi_admin)
    );

    $tables = array(
        'menuitems',
    );

    $inst_parms = array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings,
        'tables'    => $tables
    );

    return $inst_parms;
}

function plugin_load_configuration_custommenu($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_custommenu();
}

function plugin_postinstall_custommenu($pi_name)
{
    global $_CONF, $_TABLES, $LANG01;

    $pi_admin = 'CustomMenu Admin';

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

    if (GL_VERSION_15) {
        // Set menu elements
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $c = config::get_instance();
        $c->set('menu_elements', array('custom'));

        CMED_addPluginsMenuitems();
    }

    return true;
}

function plugin_compatible_with_this_version_custommenu($pi_name)
{
    if (function_exists('COM_printUpcomingEvents')) {
        // if this function exists, then someone's trying to install the
        // plugin on Geeklog 1.4.0 or older - sorry, but that won't work
        return false;
    }   

    if (!function_exists('MBYTE_strpos')) {
        // the plugin requires the multi-byte functions
        return false; 
    }   

    return true;
}

/**
* Add Menuitems of the plugins
*/
function CMED_addPluginsMenuitems()
{
    global $_PLUGINS, $_TABLES, $_CMED_plugin_label_var;

    $SQLS = array();
    $num = DB_getItem($_TABLES['menuitems'], "MAX(menuorder)") + 10;
    $menuitems = array();
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'CustomMenu Admin'");
    foreach ($_PLUGINS as $pi_name) {
        if ($pi_name == 'staticpages') continue;
        if (DB_count($_TABLES['menuitems'], "mid", $pi_name) != 1) {
            $function = 'plugin_getmenuitems_' . $pi_name;
            if (function_exists($function)) {
                $menuitems = $function();
                if ((is_array($menuitems)) && (sizeof($menuitems) > 0)) {
                    $mid = $pi_name;
                    $url = addslashes(current($menuitems));
                    $label = addslashes(key($menuitems));
                    $label_var = (!empty($_CMED_plugin_label_var[$pi_name])) ? $_CMED_plugin_label_var[$pi_name] : '';
                    $label_var = addslashes($label_var);
                    $mode = (!empty($_CMED_plugin_label_var[$pi_name])) ? 'variable' : 'fixation';
                    
                    $SQLS[] = "INSERT INTO " . $_TABLES['menuitems'] 
                            . " (mid, is_enabled, type, mode, label, label_var, url, menuorder, owner_id, group_id) "
                            . "VALUES ('$mid', 1, 'plugin', '$mode', '$label', '$label_var', '$url', $num, 2, '$group_id')";
                    $num += 1;
                }
            }
        }
    }

    foreach ($SQLS as $sql) {
        DB_query($sql, 1);
        if (DB_error()) {
            return false;
        }
    }
}

/**
* Upgrade the custommenu plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function CMED_upgrade()
{
    global $_CONF, $_TABLES, $_CMED_CONF;

    // the plugin needs these function so complain when they don't exist
    if (!function_exists('COM_truncate') || !function_exists('MBYTE_strpos')) {
        return 3002;
    }

    $pi_version = DB_getItem($_TABLES['plugins'], 'pi_version', "(pi_name = 'custommenu')");

    if ((version_compare($pi_version, '0.2.0') < 0) && (GL_VERSION_15)) {
        require_once $_CONF['path'] . 'plugins/custommenu/install_defaults.php';
        plugin_initconfig_custommenu();
    }

    if (version_compare($pi_version, '0.3.0') < 0) {
        $sql = "ALTER TABLE {$_TABLES['menuitems']} "
             . "ADD COLUMN pattern varchar(255) default NULL,"
             . "ADD COLUMN is_preg tinyint(1) NOT NULL default '0'";
        DB_query($sql);
    }

    if (version_compare($pi_version, '0.4.0') < 0) {
        $sql = "ALTER TABLE {$_TABLES['menuitems']} "
             . "ADD COLUMN pmid varchar(40) NOT NULL default '',"
             . "ADD COLUMN class_name varchar(48) default NULL";
        DB_query($sql);
    }

    if (version_compare($pi_version, '0.4.1') < 0) {
        require_once $_CONF['path'] . 'plugins/custommenu/install_defaults.php';
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $c = config::get_instance();
        $n = DB_count($_TABLES['conf_values'], "name", 'menu_render');
        if ($n == 0) {
            $c->add('menu_render', $_CMED_DEFAULT['menu_render'], 'select', 0, 0, 10, 20, true, 'custommenu');
        }
        $n = DB_count($_TABLES['conf_values'], "name", 'prefix_id');
        if ($n == 0) {
            $c->add('prefix_id', $_CMED_DEFAULT['prefix_id'], 'text', 0, 0, 0, 30, true, 'custommenu');
        }
        DB_query("UPDATE {$_TABLES['conf_values']} SET sort_order = 40 WHERE name = 'default_permissions'");
    }

    // Update the version numbers
    DB_query("UPDATE {$_TABLES['plugins']} "
           . "SET pi_version = '{$_CMED_CONF['version']}', pi_gl_version = '1.4.1' "
           . "WHERE pi_name = 'custommenu'");

    return true;
}

/**
* Removes the datastructures for this plugin from the Geeklog database.
* This routine will get called from the Plugin install program if user select De-Install or if Delete is used in the Plugin Editor.
* The Plugin Installer will also call this routine upon and install error to remove anything it has created.
* The Plugin installer will pass the optional parameter which will then double check that plugin has first been disabled. 
* 
* For this plugin, this routine will also remove the Block definition.
* 
* Returns True if all Plugin related data is removed without error
*
* @param    string   $installCheck     Default is blank but if set, check if plugin is disabled first
* 
* @return   boolean True if successful false otherwise
*
*/
function CMED_uninstall ( $installCheck = '' )
{
    global $_CONF, $_TABLES, $LANG_CMED;

    $pi_name  = 'custommenu';
    $pi_admin = 'CustomMenu Admin';

    // $FEATURES and $TABLES have to be changed accodrding to your plugin
    $FEATURES = array ('custommenu.admin');
    $TABLES   = array ('menuitems');
    
    // Check and see if plugin is still enabled - if so display warning and exit
    if ( $installCheck != '' && DB_getItem ( $_TABLES['plugins'], 'pi_enabled', 'pi_name = "' . $pi_name . '"' ) ) {
        COM_errorLog ( "Plugin is installed and enabled. Disable first if you want to de-install it", 1 );
        $display .= COM_startBlock ( $LANG_CMED['warning'] );
        $display .= $LANG_CMED['enabled'];
        $display .= COM_endBlock ();
        echo $display;
        return false;
        exit;
    }
        
    // Ok to proceed and delete plugin

    // Drop CustomMenu tables
    foreach ( $TABLES as $table ) {
        $t = $_TABLES["$table"];
        COM_errorLog ('Dropping $table table', 1);
        DB_query ( "DROP TABLE $t", 1 );
        COM_errorLog ('...success', 1);
    }
    foreach ( $TABLES as $table ) {
        unset($_TABLES["$table"]);
    }

    // Remove Security for this plugin
    $grp_id = DB_getItem ($_TABLES['groups'], 'grp_id',"grp_name = '$pi_admin'");
    if (!empty ($grp_id)) {
        // Remove CustomMenu Admin group from all other groups
        COM_errorLog ('Attempting to remove $pi_admin group from all groups' , 1);
        DB_query ("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id");
        COM_errorLog ('...success', 1);

        // Remove the CustomMenu Admin group
        COM_errorLog('Attempting to remove the $pi_admin Group', 1);
        DB_query ("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id");
        COM_errorLog('...success', 1);
    }
    
    // Remove related features
    foreach ($FEATURES as $f) {
        $feat_id = DB_getItem ($_TABLES['features'], 'ft_id', "ft_name = '$f'");
        if (!empty ($feat_id)) {
            COM_errorLog ("Attempting to remove $f rights from all groups", 1);
            DB_query ("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id");
            COM_errorLog ('...success', 1);

            COM_errorLog ("Attempting to remove the $f feature", 1);
            DB_query ("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id");
            COM_errorLog ('...success', 1);
        }
    }

    if (GL_VERSION_15) {
        // Remove config table data for this plugin
        COM_errorLog ("Attempting to remove config table records for group_name: $pi_name", 1);
        DB_query ("DELETE FROM {$_TABLES['conf_values']} WHERE group_name = '$pi_name'");
        COM_errorLog ('...success', 1);
    }

    // Unregister the plugin with Geeklog
    // Always attempt to remove these entries or lib-common.php would still
    // try and read our functions.inc file ...
    COM_errorLog ('Attempting to unregister the $pi_name plugin from Geeklog', 1);
    DB_query ("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = '$pi_name'");
    COM_errorLog ('...success',1);

    // Restore menu elements
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    $c = config::get_instance();
    $c->restore_param('menu_elements', 'Core');

    COM_errorLog ('Finished uninstalling the $pi_name plugin.', 1);

    return true;
}
?>
