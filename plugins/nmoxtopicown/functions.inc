<?php
//
// +---------------------------------------------------------------------------+
// | nmoxtopicown Geeklog Plugin 1.0                                           |
// +---------------------------------------------------------------------------+
// | function.inc                                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by nmox                                                |
// |                                                                           |
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
// +---------------------------------------------------------------------------+

// this file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false){
    die ('This file can not be used on its own.');
}

if (!defined('XHTML')) {
    define('XHTML', '');
}

/**
* Language file Include
*/
$langfile = $_CONF['path'] . 'plugins/nmoxtopicown/language/' . $_CONF['language'] . '.php';
if (file_exists ($langfile))
{
	include_once ($langfile);
}
else
{
	include_once ($_CONF['path'] . 'plugins/nmoxtopicown/language/english.php');
}

require_once ($_CONF['path'] . 'plugins/nmoxtopicown/config.php');

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

function plugin_chkVersion_nmoxtopicown() {
	global $_NMOXTOPICOWN;

	return $_NMOXTOPICOWN['version'];
}

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
function plugin_getmenuitems_nmoxtopicown()
{
}

/**
* Check to see if this Plugin uses comments
*
* Geeklog is checking to see if this plugin supports comments, tell it no!
* NOTE: to support comments you must use the same date/time based ID for your
* widget.  In other words, to make primary keys for your plugin you should call
* makesid().  Comments are keyed off of that...it is a limitation on how geeklog
* does comments.
*
* @return   boolean true or false
*
*/
function plugin_commentsupport_nmoxtopicown()
{
	return false;
}

/**
* Shows the statistics for the plugin on stats.php.  If
* $showsitestats is 1 then we are to only print the overall stats in the 'site
* statistics' box otherwise we show the detailed stats for the plugin
*
* Universal Plugin:  Modify/uncomment use it
*
* @param    int showsitestate   Flag to let us know which stats to get
* @return   string  returns formatted HTML to insert in stats page
*
*/
function plugin_showstats_nmoxtopicown($showsitestats)
{
	$retval = '';
	return $retval;
}

function plugin_upgrade_nmoxtopicown ()
{
    global $_TABLES, $_NMOXTOPICOWN;

    $v = DB_getItem ($_TABLES['plugins'], 'pi_version', "pi_name = 'nmoxtopicown'");

    if ($v != $_NMOXTOPICOWN['version']) {
        // update version numbers
        DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_NMOXTOPICOWN['version']}', pi_gl_version = '1.4.1' WHERE pi_name = 'nmoxtopicown'");

        // check if version number was updated successfully
        $v = DB_getItem ($_TABLES['plugins'], 'pi_version', "pi_name = 'spamx'");
    }

    if ($v == $_NMOXTOPICOWN['version']) {
        return true;
    }

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
* @param    string   $installCheck     Defult is blank but if set, check if plugin is disabled first
* 
* @return   boolean True if successful false otherwise
*
*/  
function plugin_uninstall_nmoxtopicown($installCheck = '')
{
	global $_TABLES, $LANG_NMOXTOPICOWN,$_CONF;

	$pi_name  = 'nmoxtopicown';


	$grp_id = DB_getItem($_TABLES['vars'], 'value', "name = '{$pi_name}_admin'");
	DB_delete($_TABLES['plugins'],'pi_name','nmoxtopicown');
	DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id",1);
	$FEATURES = array ('nmoxtopicown.edit','nmoxtopicown.user');
	foreach ($FEATURES as $feature) {
		$feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$feature'");
		DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id",1);
		DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id",1);
	}
	DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$pi_name}_admin'");
	DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id",1);

	return true;
}

function plugin_getadminoption_nmoxtopicown(){
	global $_CONF, $_NMOXTOPICOWN, $_TABLES;

	if (SEC_hasRights ('nmoxtopicown.edit', 'OR')) {
		return array ($_NMOXTOPICOWN['nmoxtopicown'], $_CONF['site_admin_url'] . '/plugins/nmoxtopicown/index.php');
	}
}

function phpblock_nmoxtopicown(){
	return "@_@";
}
?>
