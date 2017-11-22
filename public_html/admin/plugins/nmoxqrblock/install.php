<?php
// +---------------------------------------------------------------------------+
// | nmoxqrblock Geeklog Plugin 1.0                                       |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
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
//
global $_TABLES,$_USER, $_NMOXQRBLOCK,$LANG_NMOXQRBLOCK,$_CONF;
require_once('../../../lib-common.php');
require_once($_CONF['path'] . 'plugins/nmoxqrblock/config.php');
require_once($_CONF['path'] . 'plugins/nmoxqrblock/functions.inc');

//
// Universal plugin install variables
// Change these to match your plugin
//

$pi_name    = 'nmoxqrblock';             // Plugin name  Must be 15 chars or less
$pi_version = $_NMOXQRBLOCK['version'];  // Plugin Version
$gl_version = '1.4.1';                  // GL Version plugin for
$pi_url     = 'http://nmox.com/'; // Plugin Homepage

//
// Default data
// Insert table name and sql to insert default data for your plugin.
//

$NEWFEATURE = array();
$NEWFEATURE['nmoxqrblock.edit']="nmoxqrblock Admin";
$NEWFEATURE['nmoxqrblock.user']="nmoxqrblock User";

// Default data

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
	// Someone is trying to illegally access this page
	COM_errorLog("Someone has tried to illegally access the nmoxqrblock install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
	$display = COM_siteHeader();
	$display .= COM_startBlock($LANG_NMOXQRBLOCK['access_denied']);
	$display .= $LANG_NMOXQRBLOCK['access_denied_msg'];
	$display .= COM_endBlock();
	$display .= COM_siteFooter(true);
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
function plugin_install_now()
{
    global $pi_name, $pi_version, $gl_version, $pi_url, $NEWFEATURE;
    global $_TABLES,$_CONF,$LANG_NMOXQRBLOCK;

    
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
        . "VALUES ('$pi_name Admin', 'Users in this group can administer the $pi_name plugin')",1);
    if (DB_error()) {
    	COM_errorLog('failed insert groups table',1);
        plugin_uninstall_nmoxqrblock();
        return false;
        exit;
    }
    $group_id = DB_insertId();
    
    DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('{$pi_name}_admin', '$group_id')",1);
    if (DB_error()) {
    	COM_errorLog('failed insert vars table',1);
        plugin_uninstall_nmoxqrblock();
        return false;
        exit;
    }
    
    foreach ($NEWFEATURE as $feature => $desc) {
        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
            . "VALUES ('$feature','$desc')",1);
        if (DB_error()) {
    		COM_errorLog('failed insert feature table',1);
            plugin_uninstall_nmoxqrblock();
            return false;
            exit;
        }
        $feat_id = DB_insertId();
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, $group_id)");
        if (DB_error()) {
    		COM_errorLog('failed insert access table',1);
            plugin_uninstall_nmoxqrblock();
            return false;
            exit;
        }
    }        
    
    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES ($group_id, NULL, 1)");
    if (DB_error()) {
    	COM_errorLog('failed insert group_assignments table',1);
        plugin_uninstall_nmoxqrblock();
        return false;
        exit;
    }

    DB_delete($_TABLES['plugins'],'pi_name','nmoxqrblock');
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('$pi_name', '$pi_version', '$gl_version', '$pi_url', 1)");
    if (DB_error()) {
    	COM_errorLog('failed insert plugin table',1);
        plugin_uninstall_nmoxqrblock();
        return false;
        exit;
    }

	$rc=DB_query("select count(*) as c from ".$_TABLES['blocks']." where tid='".$LANG_NMOXQRBLOCK["title_block"]."'");
	if($rc["c"]<1){
		DB_query("insert into ".$_TABLES['blocks']."
		(is_enabled,name,type,title,tid,blockorder,onleft,phpblockfn,owner_id,group_id)
		values
		(1,'nmoxqrblock','phpblock','".$LANG_NMOXQRBLOCK["title_block"]."','all',90,1,'phpblock_nmoxqrblock',2,".$group_id.")",1);
	    if (DB_error()) {
	    	COM_errorLog('failed insert blocks table',1);
	        plugin_uninstall_nmoxqrblock();
	        return false;
	        exit;
	    }
	}


    return true;
}

/*
* Main Function
*/

$display = '';

if ($_REQUEST['action'] == 'uninstall') {
    $uninstall_plugin = 'plugin_uninstall_' . $pi_name;
    if ($uninstall_plugin ()) {
        $display = COM_refresh ($_CONF['site_admin_url']
                                . '/plugins.php?msg=45');
    } else {
        $display = COM_refresh ($_CONF['site_admin_url']
                                . '/plugins.php?msg=73');
    }
} else if (DB_count ($_TABLES['plugins'], 'pi_name', $pi_name) == 0) {
    // plugin not installed
    if (plugin_install_now ()) {
        $display = COM_refresh ($_CONF['site_admin_url']
                                . '/plugins.php?msg=44');
    } else {
        $display = COM_refresh ($_CONF['site_admin_url']
                                . '/plugins.php?msg=72');
    }
} else {
    // plugin already installed
    $display .= COM_siteHeader ('menu', $LANG01[77])
             . COM_startBlock ($LANG32[6])
             . '<p>' . $LANG32[7] . '</p>'
             . COM_endBlock ()
             . COM_siteFooter();
}

echo $display;
?>