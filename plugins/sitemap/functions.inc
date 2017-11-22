<?php
//
// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/sitemap/functions.inc                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2009 mystral-kk - geeklog AT mystral-k DOT net         |
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

/**
* Language file Include
*/
$langfile = $_CONF['path'] . 'plugins/sitemap/language/' . $_CONF['language'] . '.php';
clearstatcache();
if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once $_CONF['path'] . 'plugins/sitemap/language/english.php';
}

/**
* Include sitemap config file
*/
require_once $_CONF['path'] . 'plugins/sitemap/config.php';

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
* Universal Plugin:  Uncomment and fill in variables;
* 
* @return    array   Associative array of menu items to be added to menu
*
*/

function plugin_getmenuitems_sitemap() {
	global $_CONF;
	
    $menuitems = array();
	$menuitems[SITEMAP_str('menu_label')] = $_CONF['site_url'] . '/sitemap/index.php';
    return $menuitems;
}

/**
* Check to see if this Plugin uses comments
*
* @return   boolean true or false
*/

function plugin_commentsupport_sitemap() {
    return false;
}

/**
* This will put an option for the plugin in the command and control block on
* moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*/
function plugin_cclabel_sitemap() {
    global $_CONF;

	$pi_name   = SITEMAP_str('menu_label');
	$admin_url = $_CONF['site_admin_url'] . '/plugins/sitemap/index.php';
	$icon_url  = $_CONF['site_url'] . '/sitemap/images/sitemap.gif';

    return array($pi_name, $admin_url, $icon_url);
}

/**
* Returns the administrative option for this plugin
*
* @return   array   Array containing (plugin name, plugin admin url, # of items
*                   in plugin or '')
*/
function plugin_getadminoption_sitemap() {
	global $_CONF, $_TABLES;

	if (SEC_hasRights('sitemap.admin')) {
		$pi_name   = SITEMAP_str('menu_label');
		$admin_url = $_CONF['site_admin_url'] . '/plugins/sitemap/index.php';
		$num_items = '';
		return array($pi_name, $admin_url, $num_items);
	}
}

/**
* Returns the version for this plugin
*
* @return string VersionNo
*/
function plugin_chkVersion_sitemap() {
	global $_SMAP_CONF;
	
	return $_SMAP_CONF['pi_version'];
}

/**
* Returns the user option for this plugin
*
* @return   array   Array containing (plugin name, plugin user url, 0)
*/
function plugin_getuseroption_sitemap() {
}

/**
* Upgrade the plugin
*
* Universal Plugin:  modify/uncomment use it
*
* @return   boolean true (= success)
*/
function plugin_upgrade_sitemap() {
	global $_CONF, $_TABLES, $_SMAP_CONF, $VALUES_1_0_TO_1_0_1;

	$result = DB_query("SELECT pi_version FROM {$_TABLES['plugins']} WHERE (pi_name = 'sitemap')");
	$A = DB_fetchArray($result, false);
	$pi_version = $A['pi_version'];		// Version info stored in database
	
	// Do upgrading
	
	switch ($pi_version) {
		case '1.0':
			require_once $_CONF['path_html'] . 'admin/plugins/sitemap/sql-1.0_1.0.1.php';
			foreach ($VALUES_100_TO_101 as $table => $sqls) {
				COM_errorLog("Sitemap: inserting default data into $table table", 1);
				foreach ($sqls as $sql) {
					DB_query($sql, 1);
				}
			}
			break;
		
		case '1.0.1':
		case '1.0.2':
		case '1.0.3':
		case '1.1.0':
		case '1.1.1':
		case '1.1.2':
		case '1.1.3':	// This version doesn't exist
			require_once $_CONF['path_html'] . 'admin/plugins/sitemap/sql-1.0.1_1.1.4.php';
			COM_errorLog("Sitemap: inserting default data into table", 1);
			
			foreach ($DATA_101_TO_114 as $sql) {
				DB_query($sql, 1);
			}
			break;
		
		case '1.1.4':
			require_once $_CONF['path_html'] . 'admin/plugins/sitemap/sql-1.1.4_1.1.5.php';
			COM_errorLog("Sitemap: altering table structure", 1);
			
			foreach ($DATA_114_TO_115 as $sql) {
				DB_query($sql, 1);
			}
			break;

		case '1.1.5':
			require_once $_CONF['path_html'] . 'admin/plugins/sitemap/sql-1.1.5_1.1.6.php';
			COM_errorLog("Sitemap: inserting default data into $table table", 1);
			
			foreach ($VALUES_115_TO_116 as $table => $sqls) {
				COM_errorLog("Sitemap: inserting default data into $table table", 1);
				foreach ($sqls as $sql) {
					DB_query($sql, 1);
				}
			}
			break;
		
		case '1.1.6':
		case '1.1.7':
		case '1.1.8':
			// Nothing done from 1.1.6 -> 1.1.7
			// Nothing done from 1.1.7 -> 1.1.8
			// Nothing done from 1.1.8 -> 1.1.9
			break;
		
		default:
			COM_errorLog('Sitemap: upgrade procedure for version ' . $pi_version . ' is not implemented in plugin_upgrade_sitemap().');
			break;
	}
	
	// Update plugin info
	
	$result = DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = \"{$_SMAP_CONF['pi_version']}\" WHERE (pi_name = 'sitemap')");
	COM_errorLog(ucfirst("sitemap") . " plugin was successfully updated to version {$_SMAP_CONF['pi_version']}.");
	
	return true;
}

/**
* Removes the datastructures for this plugin from the Geeklog database.
*
* @param    string   $installCheck     Default is blank but if set, check if
*                                      plugin is disabled first
* @return   boolean True if successful false otherwise
*/
function plugin_uninstall_sitemap($installCheck = '') {
    global $_TABLES;

    // $FEATURES and $TABLES have to be changed accodrding to your plugin
    $pi_name  = 'sitemap';
    $FEATURES = array('sitemap.admin');
    $TABLES   = array('smap_config');
    
    // Check and see if plugin is still enabled - if so display warning and exit
    if ($installCheck != '' AND DB_getItem($_TABLES['plugins'], 'pi_enabled', 'pi_name = "' . $pi_name . '"')) {
	    COM_errorLog("Plugin is installed and enabled. Disable first if you want to de-install it", 1);
		$display .= COM_startBlock(SITEMAP_str('warning'))
				 .  SITEMAP_str('enabled')
				 .  COM_endBlock();
		echo $display;
		return false;
	}
    	
	// Ok to proceed and delete plugin

    // Unregister the plugin with Geeklog
    COM_errorLog('Attempting to unregister the sitemap plugin from Geeklog', 1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE (pi_name = 'sitemap')", 1);

    // Drop sitemap tables
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
        $feat_id = DB_getItem($_TABLES['features'], 'ft_id', "(ft_name = '$feature')");
        DB_query("DELETE FROM {$_TABLES['access']} WHERE (acc_ft_id = '{$feat_id}')", 1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE (ft_id = '{$feat_id}')", 1);
    }
        
    COM_errorLog('...success', 1);
    return true;
}

/**
* Loads vars from DB into $_SMAP_CONF[]
*/
function SITEMAP_loadConfig() {
	global $_TABLES, $_SMAP_CONF;
	
	$sql = "SELECT * FROM {$_TABLES['smap_config']}";
	$result = DB_query($sql);
	if (DB_error()) {
		COM_errorLog('SITEMAP_loadConfig: cannot load config.');
		exit;
	}
	
	while (($A = DB_fetchArray($result)) !== false) {
		list($name, $value) = $A;
		if ($value == 'true') {
			$value = true;
		} else if ($value == 'false') {
			$value = false;
		}
		
		if ($name == 'date_format') {
			$value = substr($value, 1, -1);
		} else if (substr($name, 0, 6) == 'order_') {
			$value = (int) $value;
		}
		
		$_SMAP_CONF[$name] = $value;
	}
}

/**
* Saves vars into DB from $_SMAP_CONF[]
*/
function SITEMAP_saveConfig() {
	global $_TABLES, $_SMAP_CONF;
	
	foreach ($_SMAP_CONF as $name => $value) {
		if ($value === true) {
			$value = 'true';
		} else if ($value === false) {
			$value = 'false';
		}
		
		// To prevent MySQL from trimming trailing spaces
		if ($name == 'date_format') {
			$value = '[' . $value . ']';
		}
		
		$name  = addslashes($name);
		$value = addslashes($value);
		
		$sql = "UPDATE {$_TABLES['smap_config']} "
			 . "SET value = '{$value}' "
			 . "WHERE (name = '{$name}')";
		$result = DB_query($sql);
		if (DB_error()) {
			COM_errorLog('SITEMAP_saveConfig: cannot save config.');
		}
	}
}

/**
* Returns encoding
*/
function SITEMAP_getEncodingt() {
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
* Escapes a string for HTML output
*/
function SITEMAP_escape($str) {
	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);
	return htmlspecialchars($str, ENT_QUOTES, SITEMAP_getEncodingt());
}

function SITEMAP_str($index, $noesc = false) {
	global $LANG_SMAP;
	
	if (isset($LANG_SMAP[$index])) {
		if ($noesc) {
			return $LANG_SMAP[$index];
		} else {
			return SITEMAP_escape($LANG_SMAP[$index]);
		}
	} else {
		COM_errorLog('SITEMAP_str: undefined index "' . $index . '".');
		return '(undefined)';
	}
}

/**
* Strips slashes if magic_quotes_gpc is on
*/
function SITEMAP_stripslashes($var) {
	if (get_magic_quotes_gpc()) {
		if (is_array($var)) {
			return array_map('SITEMAP_stripslashes', $var);
		} else {
			return stripslashes($var);
		}
	} else {
		return $var;
	}
}

/**
* Converts a timestamp into ISO8601 format
*/
function SITEMAP_convertDate($timestamp) {
	global $_SMAP_CONF;
	
	$retval = date('Y-m-d', $timestamp) . 'T'
			. date('H:i:s', $timestamp) . $_SMAP_CONF['time_zone'];
	return $retval;
}

/**
* Writes a Google Sitemap
*/
function SITEMAP_write($filename, $sitemap) {
	global $_CONF, $_SMAP_CONF;
	
	$retval = false;
	
	/**
	* for Google Mobile Sitemap
	*/
	if (preg_match("/mobile/i", $filename)) {
		$sitemap = str_replace(
			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
			'<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">',
			$sitemap
		);
		$sitemap = str_replace(
			'</url>',
			'  <mobile:mobile/>' . "\n" . '  </url>',
			$sitemap
		);
	}
	
	$path = $_CONF['path_html'] . basename($filename);
	clearstatcache();
	if (!file_exists($path)) {
		$fh = @fopen($path, 'wb');
		if ($fh === false) {
			COM_errorLog('Sitemap: cannot create Google sitemap file.  Please create the file "' . $path . '" manually.');
			return false;
		}
	} else {
		$fh = @fopen($path, 'r+b');
		if ($fh === false) {
			COM_errorLog('Sitemap: Google sitemap file is NOT writable: ' . $path);
			return false;
		}
	}
	
	if (flock($fh, LOCK_EX) === true) {
		ftruncate($fh, 0);
		rewind($fh);
		$result = @fwrite($fh, $sitemap);
		if (($result === false) OR ($result != strlen($sitemap))) {
			COM_errorLog('Sitemap: cannot write into Google sitemap file fully: ' . $path);
		}
		
		@flock($fh, LOCK_UN);
		$retval = true;
	} else {
		COM_errorLog('Sitemap: cannot write-lock Google sitemap file: ' . $path);
	}
	
	@fclose($fh);
	
	return $retval;
}

/**
* Creates a Google Sitemap
*/
function SITEMAP_createGoogleSitemap() {
	global $_CONF, $_SMAP_CONF;
	
	$retval = false;
	
	// Loads config
	SITEMAP_loadConfig();
	
	// Header
	$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . LB
			 . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . LB;
	
	// Collects items
	$dataproxy  =& new Dataproxy(1);
	$drivers    = $dataproxy->getAllDriverNames();
	$sp_excepts = explode(' ', $_SMAP_CONF['sp_except']);
	
	foreach ($drivers as $driver) {
		if (($driver == 'trackback') OR ($driver == 'comments')
		 OR ($_SMAP_CONF['gsmap_' . $driver] === false)) {
			continue;
		}
		
		$items = $dataproxy->$driver->getAllItems(true);
		if (count($items) == 0) {
			continue;
		}
		
		foreach ($items as $item) {
			if ($driver == 'staticpages') {
				if (SITEMAP_isExcepted($item['id'], $sp_excepts)) {
					continue;
				}
				
				$temp = $dataproxy->$driver->getItemById($item['id']);
				$raw  = $temp['raw_data'];
				if ((($_SMAP_CONF['sp_type'] == 1) AND ($raw['sp_centerblock'] != 1))
				 OR (($_SMAP_CONF['sp_type'] == 2) AND ($raw['sp_centerblock'] == 1))) {
					continue;
				}
			}
			
			$sitemap .= '  <url>' . LB
					 .  '    <loc>' . $item['uri'] . '</loc>' . LB;
			
			if ($item['date'] !== false) {
				$sitemap .= '    <lastmod>' . SITEMAP_convertDate( $item['date'] ) . '</lastmod>' . LB;
			} else {
				$sitemap .= '    <lastmod>' . SITEMAP_convertDate(time()) . '</lastmod>' . LB;
			}
			
			$sitemap .= '    <changefreq>' . $_SMAP_CONF['freq_' . $driver]
					 . '</changefreq>' . LB;
			$priority = (float) $_SMAP_CONF['priority_' . $driver];
			if (($priority != 0.5) AND ($priority >= 0.0) AND ($priority <= 1.0)) {
				$sitemap .= '    <priority>' . $priority . '</priority>' . LB;
			}
			
			$sitemap .= '  </url>' . LB;
		}
	}
	
	// Footer
	$sitemap .= '</urlset>' . LB;
	
	// Writes the Google Sitemap
	foreach (explode(';', $_SMAP_CONF['google_sitemap_name']) as $filename) {
		$retval = ($retval OR !SITEMAP_write($filename, $sitemap));
	}
	
	return !$retval;
}

/**
* Check if a given static page id is excepted
*
* @param  string   id          a static page id
* @param  string   sp_excepts  an array of regular expressions WITH delimiters
*                              being '/'
* @return boolean  TRUE = excepted, FALSE = otherwise
*/
function SITEMAP_isExcepted($id, $sp_excepts) {
	foreach ($sp_excepts as $except) {
		if (strlen($except) > 0) {
			if ($except[0] != '/') {
				$except = '/' . $except . '/';
			}
			if (preg_match($except , $id)) {
				return TRUE;
			}
		}
	}
	
	return FALSE;
}

/**
* callback function for the pseudo cron job 
*/
function plugin_runScheduledTask_sitemap() {
	SITEMAP_createGoogleSitemap();
}

/**
* callback function when a new item was saved
*/
function plugin_itemsaved_sitemap($id, $type) {
	SITEMAP_createGoogleSitemap();
}
