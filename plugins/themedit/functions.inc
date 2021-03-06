<?php
//
// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/themedit/functions.inc                                    |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== FALSE) {
    die('This file can not be used on its own.');
}

/**
* Language file Include
*/
$langfile = $_CONF['path'] . 'plugins/themedit/language/' . $_CONF['language'] . '.php';

clearstatcache();
if (file_exists($langfile)) {
	include_once $langfile;
} else {
	include_once $_CONF['path'] . 'plugins/themedit/language/english.php';
}

/*
* Include themedit config file
*/
require_once $_CONF['path'] . 'plugins/themedit/config.php';

/**
* Define useful constants
*/
if (!defined('LB')) {
	define('LB', "\n");
}
if (!defined('XHTML')) {
	define('XHTML', '');
}
define('THEMEDIT_BASE_URL', $_CONF['site_admin_url'] . '/plugins/themedit');
if (version_compare(VERSION, '1.5') >= 0) {	// for GL-1.5 +
    define('THEMEDIT_GL15', TRUE);
}

/**
* Enables all files if $_THM_CONF['enable_all_files'] is TRUE
*/
if (isset($_THM_CONF['enable_all_files'])
 AND $_THM_CONF['enable_all_files'] == TRUE) {
	unset($_THM_CONF['allowed_files']);
	$_THM_CONF['allowed_files'] = array();
	$_THM_CONF['allowed_files'] = THM_getAllThemeFiles(
		$_CONF['path_themes'] . 'professional', TRUE
	);
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Checks to see if this Plugin uses comments
*/
function plugin_commentsupport_themedit() {
	return FALSE;
}

/**
* Returs ccpanel options
*/
function plugin_cclabel_themedit() {
	global $_CONF, $LANG_THM;
	
	if (SEC_hasRights('themedit.admin')) {
		$pi_name   = THM_str('cc_label');
		$admin_url = THEMEDIT_BASE_URL . '/index.php';
		$icon_url  = THEMEDIT_BASE_URL . '/images/themedit.gif';
		return array($pi_name, $admin_url, $icon_url);
	}
}

/**
* Returns the administrative option for this plugin
*/
function plugin_getadminoption_themedit() {
	global $_CONF, $_TABLES;
	
	if (SEC_hasRights('themedit.admin')) {
		$pi_name   = THM_str('cc_label');
		$admin_url = THEMEDIT_BASE_URL . '/index.php';
		$num_items = DB_count($_TABLES['thm_contents']);
		return array($pi_name, $admin_url, $num_items);
	}
}

/**
* Returns the version for this plugin
*/
function plugin_chkVersion_themedit() {
	global $_THM_CONF;
	
	return $_THM_CONF['pi_version'];
}

/**
* Upgrade the plugin
*/
function plugin_upgrade_themedit() {
	global $_CONF, $_TABLES, $_THM_CONF;
	
	$pi_version = DB_getItem(
		$_TABLES['plugins'], 'pi_version', "(pi_name = 'themedit')"
	);
	
	/**
	* Do upgrading
	*/
	
    /**
    * If the version of Themedit plugin is lower than 1.0.5 AND Geeklog version
	* is 1.5 or newer, then save config values into DB with config.class.php.
    */
    if ((version_compare($pi_version, '1.0.5') <= 0)
	 AND (version_compare(VERSION, '1.5') >= 0)) {
        require_once $_CONF['path'] . 'plugins/themedit/install_defaults.php';
        plugin_initconfig_themedit();
    }
	
	/**
	* Update plugin info
	*/
	$sql = "UPDATE {$_TABLES['plugins']} "
		 . "SET pi_version = '". $_THM_CONF['pi_version'] . "' "
		 . "WHERE (pi_name = 'themedit')";
	$result = DB_query($sql);
	COM_errorLog("Themedit plugin was successfully updated to version {$_THM_CONF['pi_version']}.");
	
	return TRUE;
}

/**
* Returns JavaScript to be inserted into the header
*/
function plugin_getheadercode_themedit() {
	global $_CONF;
	
	$header = '<meta http-equiv="Content-Script-Type" content="text/javascript"'
			. XHTML . '>' . LB
			. '<script type="text/javascript" src="' . THEMEDIT_BASE_URL
			. '/selection.js' . '"></script>' . LB;
	return $header;
}

/**
* Removes the datastructures for this plugin from the Geeklog database.
*
* @param    string   $installCheck   Default is blank but if set, check if
*                                    plugin is disabled first
* @return   boolean TRUE if successful FALSE otherwise
*/
function plugin_uninstall_themedit($installCheck = '') {
	global $_CONF, $_TABLES, $LANG_THM;
	
	$pi_name  = 'themedit';
	$FEATURES = array('themedit.admin');
	$TABLES   = array('thm_contents');
	
	/**
	* Check and see if plugin is still enabled - if so display warning and exit
	*/
	if (($installCheck != '')
	 AND DB_getItem($_TABLES['plugins'],'pi_enabled', 'pi_name = "' .$pi_name. '"')) {
		COM_errorLog('Plugin is installed and enabled.  Disable first if you want to de-install it', 1);
		$display .= COM_startBlock(THM_str('warning'))
				 .  THM_str('enabled')
				 .  COM_endBlock();
		echo $display;
		return FALSE;
	}
	
	/**
	* Unregister the plugin with Geeklog
	*/
	COM_errorLog('Attempting to unregister the themedit plugin from Geeklog', 1);
	DB_query("DELETE FROM {$_TABLES['plugins']} WHERE (pi_name = 'themedit')", 1);
	
	/**
	* Drop themedit tables
	*/
	foreach($TABLES as $table) {
		$t = $_TABLES["$table"];
		COM_errorLog("Removing Table {$t}", 1);
		DB_query("DROP TABLE {$t}", 1);
	}
	
	/**
	* Remove Security for this plugin
	*/
	$grp_id = DB_getItem($_TABLES['vars'], 'value', "name = '{$pi_name}_gid'");
	
	COM_errorLog("Removing {$pi_name} Admin Group", 1);
	DB_query("DELETE FROM {$_TABLES['groups']} WHERE (grp_id = '{$grp_id}')", 1);
	DB_query("DELETE FROM {$_TABLES['vars']} WHERE (name = '{$pi_name}_gid')");
	COM_errorLog("Removing root users from admin of {$pi_name}");
	DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id = '{$grp_id}')", 1);
	
	/**
	* Remove all the associated features -- access rights
	*/
	foreach ($FEATURES as $feature) {
		COM_errorLog("Removing {$feature} feature and rights to it", 1);
		$feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '{$feature}'");
		DB_query("DELETE FROM {$_TABLES['access']} WHERE (acc_ft_id = '{$feat_id}')", 1);
		DB_query("DELETE FROM {$_TABLES['features']} WHERE (ft_id = '{$feat_id}')", 1);
	}
	
    /**
    * Delete config info
    */
    if (defined('THEMEDIT_GL15')) {
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        
        $themedit_config = config::get_instance();
        if ($themedit_config->group_exists('themedit')) {
            $param_names = array(
				'sg_main', 'fs_main', 'enable_all_themes', 'enable_all_files',
				'allowed_themes', 'allowed_files', 'resync_database',
				'allow_upload', 'image_width', 'image_height', 'image_max_col',
				'upload_max_size', 'enable_csrf_protection',
            );
            
            foreach ($param_names as $param_name) {
                $themedit_config->del($param_name, 'themedit');
            }
        }
    }
	
	COM_errorLog('...success', 1);
	return TRUE;
}

/**
* Escapes a string for output
*/
function THM_esc($str) {
	global $LANG_CHARSET;
	
	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);
	return htmlspecialchars($str, ENT_QUOTES, $LANG_CHARSET);
}

function THM_str($index) {
	global $LANG_THM;
	
	if (isset($LANG_THM[$index])) {
		return THM_esc($LANG_THM[$index]);
	} else {
		COM_errorLog('Themedit: Debug::undefined index: ' . $index);
		return '(undefined)';
	}
}

/**
* Return template vars stored in DB
* @return: array of string: names of template vars
*/
function THM_getTemplateVars($theme, $filename) {
	global $_TABLES;
	
	$retval = array();
	
	$theme    = addslashes($theme);
	$filename = addslashes($filename);
	$sql = "SELECT thm_vars FROM {$_TABLES['thm_contents']} "
		 . "WHERE (thm_name = '{$theme}') AND (thm_filename = '{$filename}')";
	$result = DB_query($sql);
	if (!DB_error()) {
		$A = DB_fetchArray($result);
		if (!empty($A['thm_vars'])) {
			$retval = explode(',', $A['thm_vars']);
		}
	}
	
	return $retval;
}

/**
* Return template vars
* @param   $text  string    the contents of a template
* @return  array of string  names of template vars
*/
function THM_scanTemplateVars($text) {
	$retval = array();
	
	$result = preg_match_all('/\{([^}].*?)\}/', $text, $match);
	if ($result >= 1) {
		$retval = array_unique($match[1]);
		sort($retval);
	}
	
	return $retval;
}

/**
* Return the current contents of a given file stored on Web server
* @param  $theme     string  theme name
*         $filename  string  file name
* @return            string  the current contents of a given file
*/
function THM_getContents($theme, $filename) {
	global $_CONF, $_THM_CONF;
	
	$retval = '';
	$path = $_CONF['path_themes'] . $theme . '/' . $filename;
	clearstatcache();
	if (file_exists($path)) {
		$contents = @file_get_contents($path);
		if ($contents === FALSE) {
			$retval = '';
		} else {
			$retval = $contents;
		}
	} else {
		$retval = '';
	}
	
	return $retval;
}

/**
* Return the initial contents of a given file stored in DB
*
* @param  $theme     string  theme name
*         $filename  string  file name
* @return            string  the initial contents of a given file
*/
function THM_getInitalContents($theme, $filename) {
	global $_CONF, $_TABLES, $_THM_CONF;
	
	$contents = '';
	$theme    = addslashes($theme);
	$filename = addslashes($filename);
	
	$sql = "SELECT thm_init_contents "
		 . "FROM {$_TABLES['thm_contents']} "
		 . "WHERE (thm_name = '{$theme}') AND (thm_filename = '{$filename}')";
	$result = DB_query($sql);
	if (!DB_error()) {
		$A = DB_fetchArray($result);
		$contents = $A['thm_init_contents'];
	}
	
	return $contents;
}

/**
* Return allowed theme names, considering $_THM_CONF['allowed_themes']
*
* @return   array of string  theme names
*/
function THM_getAllowedThemes() {
	global $_CONF, $_THM_CONF;
	
	$retval = array();
	$themes = COM_getThemes(TRUE);
	if ($_THM_CONF['enable_all_themes']) {
		$retval = $themes;
	} else {
		foreach ($themes as $theme) {
			if (in_array($theme, $_THM_CONF['allowed_themes'])) {
				$retval[] = $theme;
			}
		}
	}
	
	return $retval;
}

/**
* Import the designated file and scan template vars in case of a template file
* and save the contents into database
*
* @return  boolean  TRUE = success, FALSE = otherwise
*/
function THM_importFile($theme, $filename) {
	global $_TABLES;
	
	$contents = THM_getContents($theme, $filename);
	if (preg_match("/\.thtml$/i", $filename)) {
		$vars = implode(',', THM_scanTemplateVars($contents));
	} else {
		$vars = '';
	}
	$theme    = addslashes($theme);
	$filename = addslashes($filename);
	$contents = addslashes($contents);
	$vars     = addslashes($vars);
	$sql = "INSERT INTO {$_TABLES['thm_contents']} "
		 . "(thm_name, thm_filename, thm_init_contents, thm_vars) "
		 . "VALUES ('{$theme}', '{$filename}', '{$contents}', '{$vars}')";
	$result = DB_query($sql);
	return !($result === FALSE);
}

/**
* Initialize themedit database -- populate the table with default file contents
*/
function THM_initDatabase() {
	global $_CONF, $_TABLES, $_THM_CONF;
	
	$themes = THM_getAllowedThemes();
	
	foreach ($themes as $theme) {
		foreach ($_THM_CONF['allowed_files'] as $filename) {
			THM_importFile($theme, $filename);
		}
	}
}

/**
* Save the file on the web
*
* @return  boolean  TRUE = success, FALSE = fail
*/
function THM_saveFile($theme, $filename, $contents) {
	global $_CONF;
	
	$path = $_CONF['path_themes'] . $theme . '/' . $filename;
	$fh = @fopen($path, 'wb');
	if ($fh === FALSE) {
		return FALSE;
	}
	
	$result1 = fwrite($fh, $contents);
	$result2 = fclose($fh);
	if (($result1 === FALSE) OR ($result1 != strlen($contents))
	 OR ($result2 === FALSE)) {
		return FALSE;
	}
	
	return TRUE;
}

/**
* Initialize the contnets on the web with the data stored in DB
*/
function THM_initFile($theme, $filename) {
	$contents = THM_getInitalContents($theme, $filename);
	return THM_saveFile($theme, $filename, $contents);
}

/**
* Returns if a file is writable
*/
function THM_isWritable($theme, $filename) {
	global $_CONF;
	
	$path = $_CONF['path_themes'] . $theme . '/' . $filename;
	clearstatcache();
	$retval = is_writable($path);
# 	if ($retval) {
# 		$path_parts = pathinfo($path);
# 		clearstatcache();
# 		$retval = is_writable($path_parts['dirname']);
# 	}
	
	return $retval;
}

/**
* Returns if themes and/or files are added and/or removed
*
* @TODO  this function doesn't work well when themes are deleted from
*        $_THM_CONF['allowed_themes'].
*/
function THM_isAddedOrRemoved() {
	global $_CONF, $_TABLES, $_THM_CONF;
	
	$retval = array();
	$retval['added']   = array();
	$retval['removed'] = array();
	$themes = THM_getAllowedThemes();
	
	foreach ($themes as $theme) {
		$theme = addslashes($theme);
		$sql = "SELECT thm_filename FROM {$_TABLES['thm_contents']} "
			 . "WHERE (thm_name = '{$theme}')";
		$result = DB_query($sql);
		if (DB_error()) {
			exit;
		} else {
			$db_files = array();
			while (($A = DB_fetchArray($result)) !== FALSE) {
				$db_files[] = $A['thm_filename'];
			}
		}
		
		foreach ($_THM_CONF['allowed_files'] as $filename) {
			$path = $_CONF['path_themes'] . $theme . '/' . $filename;
			clearstatcache();
			if (file_exists($path)) {
				// file exists, but not in DB
				if (!in_array($filename, $db_files)) {
					$retval['added'][] = array('theme' => $theme, 'file' => $filename);
				}
			} else {
				// the file no longer exits but the corresponding DB record still remains
				if (in_array($filename, $db_files)) {
					$retval['removed'][] = array('theme' => $theme, 'file' => $filename);
				}
			}
		}
	}
	
	return $retval;
}

/**
* Update all files and/or database according to $_THM_CONF['allowed_themes']
* and $_THM_CONF['allowed_files']
*/
function THM_updateAll() {
	global $_CONF, $_TABLES;

	$diff = THM_isAddedOrRemoved();
	
	/**
	* Add new files into database
	*/
	foreach ($diff['added'] as $added) {
		$theme = $added['theme'];
		$file  = $added['file'];
		THM_importFile($theme, $file);
	}
	
	/**
	* Delete old files from database
	*/
	foreach ($diff['removed'] as $removed) {
		$theme = $removed['theme'];
		$file  = $removed['file'];
		$theme = addslashes($theme);
		$file  = addslashes($file);
		$sql = "DELETE FROM {$_TABLES['thm_contents']} "
			 . "WHERE (thm_name = '{$theme}') AND (thm_filename = '{$file}')";
		DB_query($sql);
	}
	
	COM_errorLog('Themedit: Updated the information stored in the database successfully.');
	echo COM_refresh(THEMEDIT_BASE_URL . '/index.php');
}

/**
* Returns the preview HTML by letting public_html/index.php do the job
*/
function THM_getPreview() {
	global $_CONF, $_TABLES;
	
	ob_start();
	require_once $_CONF['path_html'] . 'index.php';
	$retval = ob_get_contents();
	ob_end_clean();
	return $retval;
}

/**
* Returns a directory tree with the current directory name stressed
*/
function THM_getDirTree($theme, $selected_dir = '/images') {
	global $_CONF, $_USER, $_TABLES;
	
	/**
	* Checks for '..' in case of the directory-traversal attack
	*/
	if (strpos($selected_dir, '..') !== FALSE) {
		COM_errorLog("Themedit: someone tried directory-traversal attack on THM_getDirTree(): User ID = {$_USER['uid']}");
		return '';
	}
	
	$retval   = '<ul>' . LB;
	$cgi_path = THEMEDIT_BASE_URL . '/upload.php';
	
	/**
	* images/
	*/
	$retval .= '<li>';
	if ($selected_dir == '/images') {
		$retval .= "<strong>{$theme}/images</strong>";
	} else {
		$url = THM_buildURL(
					$cgi_path,
					array(
						'path'  => '/images',
						'theme' => $theme
					)
				);
		$retval .= '<a href="' . $url . '">' . THM_esc($theme) . '/images<a>';
	}
	$retval .= '<br' . XHTML . '>' . LB;
	$retval .= '<ul>' . LB;
	
	/**
	* images/admin/
	*/
	$retval .= '<li>' . LB;
	if ($selected_dir == '/images/admin') {
		$retval .= '<strong>/admin</strong>';
	} else {
		$url = THM_buildURL(
					$cgi_path,
					array(
						'path'  => '/images/admin',
						'theme' => $theme
					)
				);
		$retval .= '<a href="' . $url . '">/admin</a>';
	}
	$retval .= '</li>' . LB;
	
	/**
	* images/buttons/
	*/
	$retval .= '<li>' . LB;
	if ($selected_dir == '/images/buttons') {
		$retval .= '<strong>/buttons</strong>';
	} else {
		$url = THM_buildURL(
					$cgi_path,
					array(
						'path'  => '/images/buttons',
						'theme' => $theme
					)
				);
		$retval .= '<a href="' . $url . '">/buttons</a>';
	}
	$retval .= '</li>' . LB;

	/**
	* images/icons/
	*/
	$retval .= '<li>' . LB;
	if ($selected_dir == '/images/icons') {
		$retval .= '<strong>/icons</strong>';
	} else {
		$url = THM_buildURL(
					$cgi_path,
					array(
						'path'  => '/images/icons',
						'theme' => $theme
					)
				);
		$retval .= '<a href="' . $url . '">/icons</a>';
	}
	$retval .= '</li>' . LB;
	
	$retval .= '</ul>' . LB;
	$retval .= '</li>' . LB;
	$retval .= '</ul>' . LB;
	return $retval;
}

/**
* Gets all theme-related files (*.thtml, *.css)
*
* @param  string  $path  the name of the path
* @return array of file names
*/
function THM_getAllThemeFiles($path, $top_level = FALSE) {
	global $_CONF;
	
	$retval = array();
	
	$dh = @opendir($path);
	if ($dh !== FALSE) {
		while (($entry = readdir($dh)) !== FALSE) {
			$this_path = $path . '/' . $entry;
			if (is_dir($this_path)) {
				if (($entry != '.') AND ($entry != '..')) {
					$retval = array_merge($retval, THM_getAllThemeFiles($this_path, FALSE));
				}
			} else {
				if (preg_match("/\.(thtml|css)$/i", $this_path)) {
					$retval[] = $this_path;
				}
			}
		}
	}
	closedir($dh);
	
	if ($top_level) {
		for ($i = 0; $i < count($retval); $i ++) {
			$retval[$i] = substr(
							$retval[$i],
							strlen($_CONF['path_themes'] . 'professional/')
						);
		}
	}
	
	return $retval;
}

/**
* Builds a URL with a query string
*/
function THM_buildURL($url, $params = array()) {
	$retval = $url;
	
	if (count($params) >= 1) {
		$temp = array();
		
		foreach ($params as $key => $value) {
			$temp[] = $key . '=' . rawurlencode($value);
		}
		
		$retval .= '?' . implode('&amp;', $temp);
	}
	
	return $retval;
}

/**
* Creates a menu with an optional icon and optional text below
* this is used in the admin screens but may be used elsewhere also.
*
* @param    string  $text  instructions to be displayed
* @return   string         HTML output of function
*
*/
function THM_createMenu($current_menu = 'list', $text = '', $noesc = TRUE) {
    global $_CONF, $_THM_CONF;
    
    $THM_MENU = array(
        'admin' => array(
                    'url'  => $_CONF['site_admin_url'],
                    'text' => THM_str('menu_admin_home'),
        ),
        'file'  => array(
                    'url'  => THEMEDIT_BASE_URL . '/index.php?cmd=file',
                    'text' => THM_str('menu_file'),
        ),
        'image' => array(
                    'url'  => THEMEDIT_BASE_URL . '/index.php?cmd=image',
                    'text' => THM_str('menu_image'),
        ),
    );
    
    if ($_THM_CONF['allow_restore'] == FALSE) {
        unset($THM_MENU['restore']);
    }
    $admin_templates = new Template($_CONF['path'] . 'plugins/themedit/templates');
    $admin_templates->set_file (
        array ('top_menu' => 'topmenu.thtml')
    );
    
    $menu_fields = array();
    $attr = array(
        'class' => 'admin-menu-item'
    );
    
    foreach ($THM_MENU as $key => $value) {
        if ($key != $current_menu) {
            $menu_fields[] = '<a href="' . $value['url']
                           . '" class="admin-menu-item">' . $value['text'] . '</a>';
        } else {
            $menu_fields[] = '<strong>' . $value['text'] . '</strong>';
        }
    }
    
    $admin_templates->set_var('icon', THEMEDIT_BASE_URL . '/images/themedit.gif');
    $admin_templates->set_var('menu_fields', implode(' | ', $menu_fields));
    if ($noesc) {
        $admin_templates->set_var('lang_instructions', THM_esc($text));
    } else {
        $admin_templates->set_var('lang_instructions', $text);
    }
    $admin_templates->set_var('xhtml', XHTML);
    $admin_templates->parse('top_menu', 'top_menu');
    $retval = $admin_templates->finish($admin_templates->get_var('top_menu'));
    
    return $retval;
}

function THM_list($header_arr, $data_arr) {
    $retval = '<table class="admin-list-table">' . LB
            . '<tr style="background: #ffffff;">' . LB;
    
    foreach ($header_arr as $header) {
        $retval .= '<th class="admin-list-headerfield">' . $header . '</th>' . LB;
    }
    
    $retval .= '</tr>' . LB;
    $class = 'pluginRow1';
    
    foreach ($data_arr as $row) {
        $retval .= '<tr class="' . $class . '" onmouseover="className=\'pluginRollOver\';" onmouseout="className=\'' . $class . '\';">' . LB;

        foreach ($row as $cell) {
            $retval .= '<td class="admin-list-field">' . $cell . '</td>' . LB;
        }
        
        $retval .= '</tr>' . LB;
        $class = ($class == 'pluginRow1' ? 'pluginRow2' : 'pluginRow1');
    }
    
    $retval .= '</table>' . LB;
    return $retval;
}

function THM_form() {
    return '<form action="' . THEMEDIT_BASE_URL . '/index.php" method="post">' . LB;
}

function THM_checkbox($name, $id, $value, $label, $checked = TRUE) {
    $retval = '<input type="checkbox" id="' . $id . '" name="' . $name
            . '" value="' . $value . '"';
    if ($checked) {
        $retval .= ' checked="checked"';
    }
    
    $retval .= XHTML . '><label for="' . $id . '">' . $label . '</label>';
    return $retval;
}

function THM_radio($name, $id, $value, $label, $checked = TRUE) {
    $retval = '<input type="radio" id="' . $id . '" name="' . $name
            . '" value="' . $value . '"';
    if ($checked) {
        $retval .= ' checked="checked"';
    }
    
    $retval .= XHTML . '><label for="' . $id . '">' . THM_esc($label) . '</label>';
    return $retval;
}
