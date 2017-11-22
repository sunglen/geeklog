<?php

// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/themedit/install.php                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2010 - geeklog AT mystral-kk DOT net                   |
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
require_once $_CONF['path'] . 'plugins/themedit/config.php';
require_once $_CONF['path'] . 'plugins/themedit/functions.inc';

$pi_name    = 'themedit';               // Plugin name  Must be 15 chars or less
$pi_version = $_THM_CONF['pi_version'];	// Plugin Version
$gl_version = $_THM_CONF['gl_version'];	// GL Version plugin for
$pi_url     = $_THM_CONF['pi_url'];		// Plugin Homepage

//
// $NEWTABLE contains table name(s) and sql to create it(them)
// Fill it in and you are ready to go.
// Note: you must put the table names in the uninstall routine in functions.inc 
// and in the $_TABLES array in config.php.
// Note: Be sure to replace table1, table2 with the actual names of your tables.
// and the table definition with the definition of your table
//

$NEWTABLE = array();
$NEWTABLE['thm_contents'] = "CREATE TABLE " . $_TABLES['thm_contents'] . "("
						  . "thm_id INT(10) unsigned NOT NULL AUTO_INCREMENT,"
						  . "thm_name VARCHAR(20) NOT NULL DEFAULT '',"
						  . "thm_filename VARCHAR(100) NOT NULL DEFAULT '',"
						  . "thm_init_contents LONGTEXT NOT NULL,"
						  . "thm_vars TEXT NOT NULL,"
						  . "PRIMARY KEY  thm_id(thm_id)"
						  . ") TYPE=MyISAM";


//
// Security Feature to add
// Fill in your security features here
// Note you must add these features to the uninstall routine in function.inc so that they will
// be removed when the uninstall routine runs.
// You do not have to use these particular features.  You can edit/add/delete them
// to fit your plugins security model
//

$NEWFEATURE = array();
$NEWFEATURE['themedit.admin'] = "themedit Admin";

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the themedit install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
    $display = COM_siteHeader()
			 . COM_startBlock(THM_str('access_denied'))
			 . THM_str('access_denied_msg')
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
* @return   boolean TRUE if successful FALSE otherwise
*/
function plugin_install_themedit() {
    global $pi_name, $pi_version, $gl_version, $pi_url, $NEWTABLE, $DEFVALUES,
		   $NEWFEATURE, $_TABLES, $_CONF;
	
    COM_errorLog("Attempting to install the {$pi_name} Plugin", 1);
	
    // Create the Plugins Tables
    
    foreach ($NEWTABLE as $table => $sql) {
        COM_errorLog("Creating {$table} table", 1);
        DB_query($sql,1);
        if (DB_error()) {
            COM_errorLog("Error Creating {$table} table", 1);
            plugin_uninstall_themedit();
            return FALSE;
            exit;
        }
        COM_errorLog("Success - Created {$table} table",1);
    }
    
	// Initialize themedit database
	
	THM_initDatabase();
	
    // Create the plugin admin security group

    COM_errorLog("Attempting to create {$pi_name} admin group", 1);
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
        . "VALUES ('{$pi_name} Admin', 'Users in this group can administer the {$pi_name} plugin')", 1);
    if (DB_error()) {
        plugin_uninstall_themedit();
        return FALSE;
        exit;
    }
    COM_errorLog('...success', 1);
    $group_id = DB_insertId();
    
    // Save the grp id for later uninstall
    COM_errorLog('About to save group_id to vars table for use during uninstall', 1);
    DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('{$pi_name}_gid', '{$group_id}')", 1);
    if (DB_error()) {
        plugin_uninstall_themedit();
        return FALSE;
        exit;
    }
    COM_errorLog('...success', 1);
    
    // Add plugin Features
	
    foreach ($NEWFEATURE as $feature => $desc) {
        COM_errorLog("Adding {$feature} feature", 1);
        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
            . "VALUES ('{$feature}','{$desc}')", 1);
        if (DB_error()) {
            COM_errorLog("Failure adding {$feature} feature", 1);
            plugin_uninstall_themedit();
            return FALSE;
            exit;
        }
        $feat_id = DB_insertId();
        COM_errorLog("Success", 1);
        COM_errorLog("Adding {$feature} feature to admin group", 1);
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ('{$feat_id}', '{$group_id}')");
        if (DB_error()) {
            COM_errorLog("Failure adding {$feature} feature to admin group", 1);
            plugin_uninstall_themedit();
            return FALSE;
            exit;
        }
        COM_errorLog('Success', 1);
    }        
    
    /**
	* OK, now give Root users access to this plugin now!
	* NOTE: Root group should always be 1
	*/
    COM_errorLog("Attempting to give all users in Root group access to {$pi_name} admin group", 1);
    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES ('{$group_id}', NULL, 1)");
    if (DB_error()) {
        plugin_uninstall_themedit();
        return FALSE;
        exit;
    }
	
    // Register the plugin with Geeklog
	
    COM_errorLog("Registering {$pi_name} plugin with Geeklog", 1);
    DB_delete($_TABLES['plugins'],'pi_name','themedit');
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('{$pi_name}', '{$pi_version}', '{$gl_version}', '{$pi_url}', 1)");

    if (DB_error()) {
        plugin_uninstall_themedit();
        return FALSE;
        exit;
    }
	
    /**
    * Add config info
    */
    if (version_compare(VERSION, '1.5') >= 0) {
        require_once $_CONF['path'] . 'plugins/themedit/install_defaults.php';
        plugin_initconfig_themedit();
    }
	
    COM_errorLog("Succesfully installed the {$pi_name} Plugin!", 1);
    return TRUE;
}

/**
* Main Function
*/
$display = COM_siteHeader();
$T = new Template($_CONF['path'] . 'plugins/themedit/templates');
$T->set_file('install', 'install.thtml');
$T->set_var('xhtml', XHTML);
$T->set_var('install_header', THM_str('install_header'));
$T->set_var('img', $_CONF['site_admin_url'] . '/plugins/themedit/images/themedit.gif');
$T->set_var('cgiurl', $_CONF['site_admin_url'] . '/plugins/themedit/install.php');
$T->set_var('admin_url', $_CONF['site_admin_url'] . '/plugins/themedit/index.php');

$action = COM_applyFilter($_POST['action']);
if ($action == 'install') {
    if (plugin_install_themedit()) {
		echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=44');
		exit;
//        $T->set_var('installmsg1', $LANG_THM['install_success']);
    } else {
        $T->set_var('installmsg1', THM_str('install_failed'));
    }
} else if ($action == "uninstall") {
   plugin_uninstall_themedit('installed');
   $T->set_var('installmsg1', THM_str('uninstall_msg'));
}

if (DB_count($_TABLES['plugins'], 'pi_name', 'themedit') == 0) {
    $T->set_var('installmsg2', THM_str('uninstalled'));
    $T->set_var('readme', THM_str('readme'));
    $T->set_var('site_admin_url', $_CONF['site_admin_url']);
    $T->set_var('installdoc', THM_str('installdoc'));
    $T->set_var('installdoc_ja', THM_str('installdoc_ja'));
	$T->set_var('btnmsg', THM_str('install'));
	$T->set_var('action','install');
} else {
    $T->set_var('installmsg2', THM_str('installed'));
	$T->set_var('btnmsg', THM_str('uninstall'));
	$T->set_var('action','uninstall');
}
$T->parse('output','install');
$display .= $T->finish($T->get_var('output'))
		 .  COM_siteFooter();

echo $display;
