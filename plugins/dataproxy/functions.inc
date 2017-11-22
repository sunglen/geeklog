<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/functions.inc                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2008 mystral-kk - geeklog AT mystral-kk DOT net        |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

//define( 'DATAPROXY_DEBUG', true );

/**
* Language file Include
*/
$langfile = $_CONF['path'] . 'plugins/dataproxy/language/' . $_CONF['language'] . '.php';
clearstatcache();
if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once $_CONF['path'] . 'plugins/dataproxy/language/english.php';
}

/**
* Include dataproxy config file
*/
require_once $_CONF['path'] . 'plugins/dataproxy/config.php';
require_once $_CONF['path'] . 'plugins/dataproxy/dataproxy.php';

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* @return    array   Associative array of menu items to be added to menu
*/
function plugin_getmenuitems_dataproxy() {
    return array();
}

/**
* Check to see if this Plugin uses comments
*
* @return   boolean true or false
*/
function plugin_commentsupport_dataproxy() {
    return false;
}

/**
* Shows the statistics for the plugin on stats.php.  If $showsitestats is 1
* then we are to only print the overall stats in the 'site statistics' box
* otherwise we show the detailed stats for the plugin
*
* @param    int showsitestate   Flag to let us know which stats to get
* @return   string  returns formatted HTML to insert in stats page
*/
function plugin_showstats_dataproxy($showsitestats) {
	$retval = '';
    return $retval;
}

/**
* This will put an option for the plugin in the command and control block on
* moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*
*/
function plugin_cclabel_dataproxy() {
    global $_CONF;
	
	$pi_name   = DPXY_str('menu_label');
//	$admin_url = $_CONF['site_admin_url'] . '/plugins/dataproxy/index.php';
	$admin_url = '';
	$icon_url  = $_CONF['site_admin_url'] . '/plugins/dataproxy/images/dataproxy.gif';
	
    return array($pi_name, $admin_url, $icon_url);
}

/**
* Returns the administrative option for this plugin
*
* Adds the plugin to the Admin menu
*
* Universal Plugin:  Modify/Uncomment use it
*
* @return   array   Array containing (plugin name, plugin admin url, # of items in plugin or '')
*/
function plugin_getadminoption_dataproxy() {
	global $_CONF, $_TABLES;

	if (SEC_hasRights('dataproxy.admin')) {
		$pi_name   = DPXY_str('menu_label');
//		$admin_url = $_CONF['site_admin_url'] . '/plugins/dataproxy/index.php';
		$admin_url = '';
		$num_items = '';
//		$num_items = DB_count($_TABLES['table1']);
		return array($pi_name, $admin_url, $num_items);
	}
}

/**
* Returns the version for this plugin
*
* @return string VersionNo
*/
function plugin_chkVersion_dataproxy() {
	global $_DPXY_CONF;
	
	return $_DPXY_CONF['pi_version'];
}

/**
* Returns the user option for this plugin
*
* @return   array   Array containing (plugin name, plugin user url, 0)
*/
function plugin_getuseroption_dataproxy() {
	return array();
}

/**
* Upgrade the plugin
*
* @return   boolean true (= success)
*
*/
function plugin_upgrade_dataproxy() {
	global $_CONF, $_TABLES, $_DPXY_CONF;

	$result = DB_query("SELECT pi_version FROM {$_TABLES['plugins']} WHERE (pi_name = 'dataproxy')");
	$A = DB_fetchArray($result, false);
	$pi_version = $A['pi_version'];		// Version info stored in database
	
	// Do upgrading
	
// 	switch ($pi_version) {
// 		case '':
// 		break;
// 		
// 		case '':
// 		break;
// 		
// 	}
	
	// Update plugin info
	
	$result = DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = \"{$_DPXY_CONF['pi_version']}\" WHERE (pi_name = 'dataproxy')");
	COM_errorLog(ucfirst("dataproxy") . " plugin was successfully updated to version {$_DPXY_CONF['pi_version']}.");
	
	return true;
}

/**
* Removes the datastructures for this plugin from the Geeklog database.
*
* @param    string   $installCheck   Default is blank but if set, check if
*                                    plugin is disabled first
* @return   boolean True if successful false otherwise
*
*/
function plugin_uninstall_dataproxy($installCheck = '') {
    global $_TABLES, $LANG_DPXY;

    // $FEATURES and $TABLES have to be changed accodrding to your plugin
    $pi_name  = 'dataproxy';
    $FEATURES = array('dataproxy.admin');
    $TABLES   = array('dpxy_notify');
    
    // Check and see if plugin is still enabled - if so display warning and exit
    if (($installCheck != '')
	 AND DB_getItem($_TABLES['plugins'], 'pi_enabled', 'pi_name = "' . $pi_name . '"')) {
	    COM_errorLog("Plugin is installed and enabled.  Disable first if you want to de-install it", 1);
		$display .= COM_startBlock(DPXY_str('warning'))
				 .  DPXY_str('enabled')
				 . COM_endBlock();
		echo $display;
		return false;
	}
    
	// Ok to proceed and delete plugin
	
    // Unregister the plugin with Geeklog
    COM_errorLog('Attempting to unregister the dataproxy plugin from Geeklog', 1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE (pi_name = 'dataproxy')", 1);
	
    // Drop dataproxy tables
    foreach ($TABLES as $table) {
        $t = $_TABLES[$table];
        COM_errorLog("Removing Table {$t}", 1);
        DB_query("DROP TABLE {$t}", 1);
    }
	
    // Remove Security for this plugin
    $grp_id = DB_getItem($_TABLES['vars'], 'value', "name = '{$pi_name}_gid'");
    
    COM_errorLog("Removing {$pi_name} Admin Group", 1);
    DB_query("DELETE FROM {$_TABLES['groups']} WHERE (grp_id = '{$grp_id}')", 1);
    DB_query("DELETE FROM {$_TABLES['vars']} WHERE (name = '{$pi_name}_gid')");
    COM_errorLog("Removing root users from admin of {$pi_name}");
    DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id = '{$grp_id}')", 1);
    
    // Remove all the associated features -- access rights
    foreach ($FEATURES as $feature) {
        COM_errorLog("Removing {$feature} feature and rights to it", 1);
        $feat_id = DB_getItem($_TABLES['features'], 'ft_id', "(ft_name = '{$feature}')");
        DB_query("DELETE FROM {$_TABLES['access']} WHERE (acc_ft_id = '{$feat_id}')", 1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE (ft_id = '{$feat_id}')", 1);
    }
        
    COM_errorLog('...success', 1);
    return true;
}

/**
* Returns the current encoding
*/
function DPXY_encoding() {
	global $_CONF, $LANG_CHARSET;
	
	static $encoding = null;
	
	if ($encoding === null) {
		if (isset($LANG_CHARSET)) {
			$encoding = $LANG_CHARSET;
		} else if (isset($_CONF['default_charset'])) {
			$encoding = $_CONF['default_charset'];
		} else {
			$encoding = 'iso-8859-1';
		}
	}
	
	return $encoding;
}

/**
* Returns a string escaped for output
*/
function DPXY_esc($str) {
	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);
	return htmlspecialchars($str, ENT_QUOTES, DPXY_encoding());
}

/**
* Returns a lang var, escaped if necessary
*/
function DPXY_str($index, $noesc = false) {
	global $LANG_DPXY;
	
	if (isset($LANG_DPXY[$index])) {
		if ($noesc) {
			return $LANG_DPXY[$index];
		} else {
			return DPXY_esc($LANG_DPXY[$index]);
		}
	} else {
		COM_errorLog('DPXY_str: undefined index "' . $index . '".');
		return '(undefined)';
	}
}

/**
* This function is called when an item is about to be saved.  Currently, only
* 'article' seems to be supported.
*
* @param $type string  type of the item, e.g. 'article'
* @param $id   string  unique ID of the item
*/
function plugin_itemsaved_dataproxy($id, $type) {
	
	if (defined('DATAPROXY_DEBUG')) {
		COM_errorLog("plugin_itemsaved_dataproxy('{$id}', '{$type}')");
	}
	
	return false;
}

/**
* The interval between runs is determined by $_CONF['cron_schedule_interval']
*
*/
function plugin_runScheduledTask_dataproxy() {
	if (defined('DATAPROXY_DEBUG')) {
		COM_errorLog('plugin_runScheduledTask_dataproxy:');
	}
}
