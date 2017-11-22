<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Geeklog Dbman Plugin for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/dbman/install.php                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------+
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// +---------------------------------------------------------------------------+

/**
* Dbman plugin installation file
*/

require_once('../../../lib-common.php');
if (version_compare(VERSION, '1.5') >= 0) {
    require_once($_CONF['path'] . 'plugins/dbman/install_defaults.php');
} else {
    require_once($_CONF['path'] . 'plugins/dbman/config.php');
}
require_once($_CONF['path'] . 'plugins/dbman/functions.inc');

/**
* Dbman plugin install variables
*/
$pi_name         = 'dbman';							// Plugin name
$pi_display_name = 'dbman';							// Plugin display name
$pi_version      = $_DBMAN_CONF['version'];			// Plugin Version
$gl_version      = '1.4.0';							// GL Version plugin for
$pi_url          = 'http://mystral-kk.net/';		// Plugin Homepage

/**
* Security Feature to add
*/
$NEW_FEATURES = array();
$NEW_FEATURES['dbman.edit'] = 'Dbman Admin';

$display = '';

/**
* Only let Root users access this page
*/
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the Dbman install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
    $display = COM_siteHeader()
             . COM_startBlock(DBMAN_str('access_denied'))
             . DBMAN_str('access_denied_msg')
             . COM_endBlock()
             . COM_siteFooter();
    echo $display;
    exit;
}


/**
* Install Dbman Plugin
* @return	boolean	TRUE if successful False otherwise
*/
function plugin_install_dbman() {
    global $_CONF, $_TABLES, $NEW_FEATURES, $pi_name, $pi_display_name,
           $pi_version, $gl_version, $pi_url, $_DBMAN_CONF;
    
    /**
    * Register the plugin with Geeklog
    */
    COM_errorLog("Attempting to install the $pi_display_name Plugin", 1);
    
    /**
    * Create the plugin admin security group
    */
    COM_errorLog("Attempting to create $pi_name admin group", 1);
    $sql = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
         . "VALUES ('{$pi_name} Admin', 'Users in this group can administer the {$pi_name} plugin')";
    DB_query($sql, 1);
    if (DB_error()) {
        plugin_uninstall_dbman();
        return false;
    }
    COM_errorLog('... success', 1);
    $group_id = DB_insertId();
    
    /**
    * Save the grp id for later uninstall
    */
    COM_errorLog('About to save group_id to vars table for use during uninstall', 1);
    $sql = "INSERT INTO {$_TABLES['vars']} VALUES ('{$pi_name}_gid', '{$group_id}')";
    DB_query($sql, 1);
    if (DB_error()) {
        plugin_uninstall_dbman();
        return false;
    }
    COM_errorLog('... success',1);
    
    // Add plugin Features
    foreach ($NEW_FEATURES as $feature => $desc) {
        COM_errorLog("Adding $feature feature", 1);
        $sql = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
             . "VALUES ('{$feature}', '{$desc}')";
        DB_query($sql, 1);
        if (DB_error()) {
            COM_errorLog("Failure adding $feature feature",1);
            plugin_uninstall_dbman();
            return false;
        }
        
        $feat_id = DB_insertId();
        COM_errorLog("Success", 1);
        COM_errorLog("Adding $feature feature to admin group", 1);
        $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) "
             . "VALUES ('{$feat_id}', '{$group_id}')";
        DB_query($sql, 1);
        if (DB_error()) {
            COM_errorLog("Failure adding {$feature} feature to admin group", 1);
            plugin_uninstall_dbman();
            return false;
        }
        
        COM_errorLog("... success", 1);
    }
    
    /**
    * OK, now give Root users access to this plugin now!
    * NOTE: Root group should always be 1
    */
    COM_errorLog("Attempting to give all users in Root group access to $pi_name admin group", 1);
    $sql = "INSERT INTO {$_TABLES['group_assignments']} "
         . "VALUES ('{$group_id}', NULL, 1)";
    DB_query($sql, 1);
    if (DB_error()) {
        plugin_uninstall_dbman();
        return false;
    }
    
    /**
    * silently delete an existing entry
    */
    DB_delete($_TABLES['plugins'], 'pi_name', $pi_name);
    $sql = "INSERT INTO {$_TABLES['plugins']} "
         . "(pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
         . "VALUES ('{$pi_name}', '{$pi_version}', '{$gl_version}', '{$pi_url}', 1)";
    DB_query($sql, 1);
    
    if (DB_error ()) {
        $uninstall_plugin_dbman();
        return false;
    }
    
    /**
    * Add config info
    */
    if (version_compare(VERSION, '1.5') >= 0) {
        require_once $_CONF['path'] . 'plugins/dbman/install_defaults.php';
        plugin_initconfig_dbman();
    }
    
    /**
    * Finish
    */
    COM_errorLog("Succesfully installed the $pi_display_name Plugin!", 1);
    return TRUE;
}

/**
* Main Function
*/

if (!defined('XHTML')) {
    define('XHTML', '');
}
$display = COM_siteHeader();
$T = new Template($_CONF['path'] . 'plugins/' . $pi_name . '/templates');
$T->set_file('install', 'install.thtml');
$T->set_var('xhtml', XHTML);
$T->set_var('install_header', DBMAN_str('install_header'));
$T->set_var('admin_url', $_CONF['site_admin_url'] . '/plugins/' . $pi_name);

if (isset($_GET['action'])) {
    $action = COM_applyFilter($_GET['action']);
} else if (isset($_POST['action'])) {
    $action = COM_applyFilter($_POST['action']);
} else {
    $action = '';
}

if ($action == 'install') {
    if (plugin_install_dbman()) {
        echo COM_refresh( $_CONF['site_admin_url'] . '/plugins.php?msg=44' );
        exit;
    } else {
        $T->set_var('installmsg1', DBMAN_str('install_failed'));
    }
} else if ($action == "uninstall") {
    if (plugin_uninstall_dbman()) {
        $T->set_var('installmsg1', DBMAN_str('uninstall_msg'));
    } else {
        $T->set_var('installmsg1', DBMAN_str('uninstall_failed'));
    }
}

if (DB_count($_TABLES['plugins'], 'pi_name', 'dbman') == 0) {
    $T->set_var('installmsg2', DBMAN_str('uninstalled'));
    $T->set_var('btnmsg', DBMAN_str('install'));
    $T->set_var('action', 'install');
} else {
    $T->set_var('installmsg2', DBMAN_str('installed'));
    $T->set_var('btnmsg', DBMAN_str('uninstall'));
    $T->set_var('action', 'uninstall');
}
$T->parse('output', 'install');
$display .= $T->finish($T->get_var('output'))
         .  COM_siteFooter();

echo $display;
