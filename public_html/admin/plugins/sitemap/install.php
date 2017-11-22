<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/sitemap/install.php                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2008 mystral-kk - geeklog AT mystral-k DOT net         |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
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
require_once 'sql.php';
require_once $_CONF['path'] . 'plugins/sitemap/config.php';
require_once $_CONF['path'] . 'plugins/sitemap/functions.inc';

$pi_name    = 'sitemap';               		// Plugin name  Must be 15 chars or less
$pi_version = $_SMAP_CONF['pi_version'];	// Plugin Version
$gl_version = $_SMAP_CONF['gl_version'];	// GL Version plugin for
$pi_url     = $_SMAP_CONF['pi_url'];		// Plugin Homepage

// Security Feature(s) to add

$NEWFEATURE = array();
$NEWFEATURE['sitemap.admin'] = "sitemap Admin";

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the sitemap install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
    $display = COM_siteHeader()
			 . COM_startBlock(SITEMAP_str('access_denied'))
			 . SITEMAP_str('access_denied_msg')
			 . COM_endBlock()
			 . COM_siteFooter();
    echo $display;
    exit;
}
 
/**
* Puts the datastructures for this plugin into the Geeklog database
*
* Note: Corresponding uninstall routine is in functions.inc
* 
* @return   boolean True if successful False otherwise
*
*/

function plugin_install_sitemap() {
    global $pi_name, $pi_version, $gl_version, $pi_url, $NEWTABLE, $DEFVALUES,
		   $NEWFEATURE, $_TABLES, $_CONF, $VALUES_1_0_TO_1_0_1;
	
    COM_errorLog("Attempting to install the {$pi_name} Plugin", 1);
	
    // Create the Plugins Tables
    foreach ($NEWTABLE as $table => $sql) {
        COM_errorLog("Creating {$table} table", 1);
        DB_query($sql, 1);
        if (DB_error()) {
            COM_errorLog("Error Creating {$table} table", 1);
            plugin_uninstall_sitemap();
            return false;
        }
        COM_errorLog("Success - Created {$table} table", 1);
    }
    
    // Insert Default Data
    foreach ($DEFVALUES as $table => $sqls) {
        COM_errorLog("Inserting default data into {$table} table", 1);
		
		foreach ($sqls as $sql) {
            DB_query($sql, 1);
            if (DB_error()) {
                COM_errorLog("Error inserting default data into {$table} table", 1);
                plugin_uninstall_sitemap();
                return false;
            }
		}
		
        COM_errorLog("Success - inserting data into {$table} table", 1);
    }
    
    // Create the plugin admin security group
    COM_errorLog("Attempting to create {$pi_name} admin group", 1);
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
        . "VALUES ('{$pi_name} Admin', 'Users in this group can administer the {$pi_name} plugin')", 1);
    if (DB_error()) {
        plugin_uninstall_sitemap();
        return false;
    }
    COM_errorLog('...success', 1);
    $group_id = DB_insertId();
    
    // Save the grp id for later uninstall
    COM_errorLog('About to save group_id to vars table for use during uninstall', 1);
    DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('{$pi_name}_gid', '{$group_id}')", 1);
    if (DB_error()) {
        plugin_uninstall_sitemap();
        return false;
    }
    COM_errorLog('...success', 1);
    
    // Add plugin Features
    foreach ($NEWFEATURE as $feature => $desc) {
        COM_errorLog("Adding {$feature} feature", 1);
        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
            . "VALUES ('{$feature}','{$desc}')", 1);
        if (DB_error()) {
            COM_errorLog("Failure adding {$feature} feature", 1);
            plugin_uninstall_sitemap();
            return false;
        }
        $feat_id = DB_insertId();
        COM_errorLog("Success", 1);
        COM_errorLog("Adding {$feature} feature to admin group", 1);
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ('{$feat_id}', '{$group_id}')");
        if (DB_error()) {
            COM_errorLog("Failure adding {$feature} feature to admin group", 1);
            plugin_uninstall_sitemap();
            return false;
        }
        COM_errorLog("Success", 1);
    }        
    
    // OK, now give Root users access to this plugin now! NOTE: Root group should always be 1
    COM_errorLog("Attempting to give all users in Root group access to {$pi_name} admin group", 1);
    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES ('{$group_id}', NULL, 1)");
    if (DB_error()) {
        plugin_uninstall_sitemap();
        return false;
    }
	
    // Register the plugin with Geeklog
    COM_errorLog("Registering {$pi_name} plugin with Geeklog", 1);
    DB_delete($_TABLES['plugins'], 'pi_name', 'sitemap');
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('{$pi_name}', '{$pi_version}', '{$gl_version}', '{$pi_url}', 1)");

    if (DB_error()) {
        plugin_uninstall_sitemap();
        return false;
    }

    COM_errorLog("Succesfully installed the {$pi_name} Plugin!", 1);
	
	// Create a Google sitemap
	if (SITEMAP_createGoogleSitemap() === true) {
	    COM_errorLog("Succesfully created a Google sitemap!", 1);
	}
	
    return true;
}

/**
* Main Function
*/

$action = COM_applyFilter($_GET['action']);
if ($action == 'install') {
    if (plugin_install_sitemap()) {
		// Redirects to the plugin editor
		echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=44');
		exit;
    } else {
		$install_msg = SITEMAP_str('install_fail');
    }
} else if ($action == 'uninstall') {
	if (plugin_uninstall_sitemap('installed')) {
		// Redirects to the plugin editor
		echo COM_refresh( $_CONF['site_admin_url'] . '/plugins.php?msg=45' );
		exit;
	} else {
		$install_msg = SITEMAP_str('uninstall_fail');
	}
}

$display = COM_siteHeader();
$T = new Template($_CONF['path'] . 'plugins/sitemap/templates');
$T->set_file('install', 'install.thtml');
$T->set_var('install_header', SITEMAP_str('install_header'));
$T->set_var('isntall_msg', SITEMAP_str('install_msg'));
$T->parse('output','install');
$display .= $T->finish($T->get_var('output'))
		 .  COM_siteFooter();

echo $display;
