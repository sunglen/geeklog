<?php
//
// +---------------------------------------------------------------------------+
// | nmoxqrblock Geeklog Plugin 1.0                                       |
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

/**
* Language file Include
*/
$langfile = $_CONF['path'] . 'plugins/nmoxqrblock/language/' . $_CONF['language'] . '.php';
if (file_exists ($langfile))
{
	include_once ($langfile);
}
else
{
	include_once ($_CONF['path'] . 'plugins/nmoxqrblock/language/english.php');
}

require_once ($_CONF['path'] . 'plugins/nmoxqrblock/config.php');

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

function plugin_chkVersion_nmoxqrblock() {
	global $_NMOXQRBLOCK;

	return $_NMOXQRBLOCK['version'];
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
function plugin_getmenuitems_nmoxqrblock()
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
function plugin_commentsupport_nmoxqrblock()
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
function plugin_showstats_nmoxqrblock($showsitestats)
{
	$retval = '';
	return $retval;
}

function plugin_upgrade_nmoxqrblock ()
{
    global $_TABLES, $_NMOXQRBLOCK;

    $v = DB_getItem ($_TABLES['plugins'], 'pi_version', "pi_name = 'nmoxqrblock'");

    if ($v != $_NMOXQRBLOCK['version']) {
        // update version numbers
        DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_NMOXQRBLOCK['version']}', pi_gl_version = '1.4.1' WHERE pi_name = 'nmoxqrblock'");

        // check if version number was updated successfully
        $v = DB_getItem ($_TABLES['plugins'], 'pi_version', "pi_name = 'spamx'");
    }

    if ($v == $_NMOXQRBLOCK['version']) {
        return true;
    }

    return true;
}

function plugin_enablestatechange_nmoxqrblock ($enable)
{
	global $_TABLES;

	$is_enabled = $enable ? 1 : 0;

	// toggle nmoxqrblock block
	DB_query ("UPDATE {$_TABLES['blocks']} SET is_enabled = $is_enabled WHERE (type = 'phpblock') AND (phpblockfn = 'phpblock_nmoxqrblock')");
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
function plugin_uninstall_nmoxqrblock($installCheck = '')
{
	global $_TABLES, $LANG_NMOXQRBLOCK,$_CONF;

	$pi_name  = 'nmoxqrblock';


	$grp_id = DB_getItem($_TABLES['vars'], 'value', "name = '{$pi_name}_admin'");
	DB_delete($_TABLES['plugins'],'pi_name','nmoxqrblock');
	DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id",1);
	$FEATURES = array ('nmoxqrblock.edit','nmoxqrblock.user');
	foreach ($FEATURES as $feature) {
		$feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$feature'");
		DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id",1);
		DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id",1);
	}
	DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$pi_name}_admin'");
	DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id",1);
    DB_query("DELETE FROM {$_TABLES['blocks']} WHERE name='nmoxqrblock'",1);

	return true;
}

function plugin_getadminoption_nmoxqrblock(){
	/*
	global $_CONF, $_NMOXQRBLOCK, $_TABLES;

	if (SEC_hasRights ('nmoxqrblock.edit', 'OR')) {
		return array ($_NMOXQRBLOCK['nmoxqrblock'], $_CONF['site_admin_url'] . '/plugins/nmoxqrblock/index.php');
	}
	*/
}

function phpblock_nmoxqrblock() {
	global $_TABLES,$_CONF,$_NMOXQRBLOCK;
	$agent = $_SERVER["HTTP_USER_AGENT"];
	if($agent == "" ||
		//preg_match("/^Mozilla\/5\.0/i", $agent) || // Firefox (for debug)
		preg_match("/^(DoCoMo\/1|DoCoMo\/2)\.0/i", $agent) ||
		preg_match("/^(J\-PHONE|Vodafone|MOT\-[CV]|Vemulator)/i", $agent) ||
		preg_match("/^(UP\.Browser|KDDI\-)/i", $agent) ||
		preg_match("/DDIPOCKET/i", $agent)){
		$html="";
	}else{
		$html="
		<div class='block-box'>
		<img alt='QR code' width='".$_NMOXQRBLOCK["size"]."' height='".$_NMOXQRBLOCK["size"]."' src='".$_CONF["site_url"]."/nmoxqrblock/qr_img.php?t=".$_NMOXQRBLOCK["type"]."&amp;d=".urlencode(COM_buildURL(COM_getCurrentURL()))."'>
		</div>
		";
	}
	return $html;
}
?>
