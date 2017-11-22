<?php
//
// +---------------------------------------------------------------------------+
// | Theme Editor Plugin for Geeklog - The Ultimate Weblog                     |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/themedit/config.php                                       |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'config.php') !== FALSE) {
    die('This file can not be used on its own.');
}

global $_DB_table_prefix, $_TABLES;

/**
* set Plugin Table Prefix the Same as Geeklogs
*/
$_THM_table_prefix = $_DB_table_prefix;

/**
* Add to $_TABLES array the tables your plugin uses
*/
$_TABLES['thm_contents'] = $_THM_table_prefix . 'thm_contents';

$_THM_CONF = array();

/**
* Plugin info
*/
$_THM_CONF['pi_version'] = '1.1.5';						// Plugin Version
$_THM_CONF['gl_version'] = '1.4.0';						// GL Version plugin for
$_THM_CONF['pi_url']     = 'http://mystral-kk.net/';	// Plugin Homepage

//=========================================================
//  USER CONFIGURATION
//=========================================================

//-------------------------------------
//  Theme names and file names
//-------------------------------------

/**
* If you set $_THM_CONF['enable_all_themes'] to TRUE, all themes will be
* accessible from the Theme Editor Plugin, regardless of the value of
* $_THM_CONF['allowed_themes'] var.
*/
$_THM_CONF['enable_all_themes'] = FALSE;

/**
* If you set TRUE to $_THM_CONF['enable_all_files'], all files related to
* themes (*.thtml, *.css) will be accessible from the Theme Editor Plugin,
* regardless of the value of $_THM_CONF['allowed_files'] var
*/
$_THM_CONF['enable_all_files'] = FALSE;

/**
* Themes to be edited with this plugin
* @NOTE: theme names are case-sensitive
*/
$_THM_CONF['allowed_themes'] = array(
	'professional', 'ProfessionalCSS', 'WAIproCSS', 'mobile', 'mobile_3g',
);

/**
* Template files and CSS files to be edited with this plugin
* @NOTE: file names are case-sensitive
*/
$_THM_CONF['allowed_files'] = array(
	// CSS
	'style.css', 'custom.css', 'custom.sample.css', 'style_forum.css',
	
	// Site header and footer
	'header.thtml', 'footer.thtml',
	
	// Blocks
	'leftblocks.thtml', 'blockheader-left.thtml', 'blockfooter-left.thtml',
	'rightblocks.thtml', 'blockheader-right.thtml', 'blockfooter-right.thtml',
	
	// Story
	'storytext.thtml', 'featuredstorytext.thtml', 'archivestorytext.thtml',
	'article/article.thtml', 'article/printable.thtml',
	
	// Menu
	'menuitem.thtml', 'menuitem_last.thtml', 'menuitem_none.thtml',
	
	// List
	'list.thtml', 'listitem.thtml',
	
	// Login
	'loginform.thtml',
	
	// Profile
	'profiles/contactuserform.thtml', 'profiles/contactauthorform.thtml',
	'preferences/profile.thtml', 'users/profile.thtml',
	
	// Search
	'search/searchform.thtml', 'search/searchresults.thtml',
	
	// User submission
	'submit/submitevent.thtml', 'submit/submitloginrequired.thtml',
	
	// User
	'users/newpassword.thtml', 'users/getpasswordform.thtml',
	'users/loginform.thtml', 'users/registrationform.thtml',
	'users/storyrow.thtml', 'users/commentrow.thtml', 
);

/**
* If you'd like to see theme names and file names sorted alphabetically in
* their dropdown list, uncomment the next two lines.
*/
// sort($_THM_CONF['allowed_themes']);
// sort($_THM_CONF['allowed_files']);

/**
* When you add/remove a theme to/from $_THM_CONF['allowed_themes'], or
* a template file to/from $_THM_CONF['allowed_files'], Theme Editor plugin will
* detect it automatically.  When this option is set to 'auto', the plugin will
* update the data stored in databse automatically.  When set to 'manual', the
* plugin will display the information and 'UPDATE database' button.  When set
* to 'ignore', the plugin will do nothing about the change.
*/
$_THM_CONF['resync_database'] = 'manual';

//-------------------------------------
//  Image upload
//-------------------------------------

/**
* If set TRUE, you can upload images to theme/images/* directories
*/
$_THM_CONF['allow_upload'] = TRUE;

/**
* Thumbnail sizes in pixels
*/
$_THM_CONF['image_width']  = 120;

$_THM_CONF['image_height'] = 100;

/**
* Max column number of thumbnails
*/
$_THM_CONF['image_max_col'] = 6;

/**
* Max size of a file in bytes (1048576 bytes = 1M bytes) for uploading to the
* Web server
*/
$_THM_CONF['upload_max_size'] = 1048576;

/**
* Enable CSRF protection for GL-1.5.0+
*/
$_THM_CONF['enable_csrf_protection'] = TRUE;

//=========================================================
//  END OF USER CONFIGURATION
//=========================================================

//===============================================
// For GL-1.5.0+
//===============================================

/**
* Check and see if we need to load the plugin configuration
*/
if (version_compare(VERSION, '1.5') >= 0) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $themedit_config = config::get_instance();
    if ($themedit_config->group_exists('themedit')) {
        $temp = $themedit_config->get_config('themedit');
        if (is_array($temp) AND (count($temp) >= 1)) {
            $_THM_CONF = array_merge($_THM_CONF, $temp);
        }
    }
	
	unset($themedit_config);
}
