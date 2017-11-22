<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v4 Plugin                                                         |
// +---------------------------------------------------------------------------+
// | admin/install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Author: Mark R. Evans - mevans@ecsnet.com                                 |
// |         Hiroron       - hiroron AT hiroron DOT com                        |
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
//

require_once('../../../lib-common.php');
require_once($_CONF['path'] . '/plugins/captcha/config.php');
require_once($_CONF['path'] . '/plugins/captcha/functions.inc');

$pi_name = 'captcha';                 // Plugin name  Must be 15 chars or less
$pi_version = $_CP_CONF['version'];   // Plugin Version
$gl_version = '1.4.1';                // GL Version plugin for
$pi_url = 'http://hiroron.com';       // Plugin Homepage

$base_path = $_CONF['path'] . 'plugins/'.$pi_name.'/';

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the CAPTCHA install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
    $display = COM_siteHeader();
    $display .= COM_startBlock($LANG_CP00['access_denied']);
    $display .= $LANG_CP00['access_denied_msg'];
    $display .= COM_endBlock();
    $display .= COM_siteFooter(true);
    echo $display;
    exit;
}

function plugin_install_captcha()
{
    global $pi_name, $pi_version, $gl_version, $pi_url;
    global $_TABLES, $_CONF, $LANG_CP00, $_DB_dbms, $base_path;

    COM_errorLog("Attempting to install the $pi_name Plugin",1);
    $uninstall_plugin = 'plugin_uninstall_' . $pi_name;

    $_SQL = array ();
    $_DEFVALUES = array ();
    if (file_exists ($base_path . 'sql/' . $_DB_dbms . '_install.php')) {
        require_once ($base_path . 'sql/' . $_DB_dbms . '_install.php');
    }

    // Create the plugin's table(s)
    if (count ($_SQL) > 0) {
        $use_innodb = false;
        if (($_DB_dbms == 'mysql') &&
            (DB_getItem ($_TABLES['vars'], 'value', "name = 'database_engine'")
                == 'InnoDB')) {
            $use_innodb = true;
        }
        foreach ($_SQL as $sql) {
            $sql = str_replace ('#group#', $admin_group_id, $sql);
            if ($use_innodb) {
                $sql = str_replace ('MyISAM', 'InnoDB', $sql);
            }
            DB_query ($sql);
            if (DB_error ()) {
                COM_errorLog ('Error creating table', 1);
                $uninstall_plugin ();
                return false;
            }
        }
    }

    // Pre-populate tables or run any other SQL queries
    COM_errorLog ('Inserting default data', 1);
    if (count ($_DEFVALUES) > 0) {
        foreach ($_DEFVALUES as $sql) {
            $sql = str_replace ('#group#', $admin_group_id, $sql);
            DB_query ($sql, 1);
            if (DB_error ()) {
                $uninstall_plugin ();
                return false;
            }
        }
    }

    // Register the plugin with Geeklog
    COM_errorLog("Registering $pi_name plugin with Geeklog", 1);
    DB_delete($_TABLES['plugins'],'pi_name',$pi_name);
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('$pi_name', '$pi_version', '$gl_version', '$pi_url', 1)");

    if (DB_error()) {
        COM_errorLog("Failure registering $pi_name plugin with Geeklog");
        $uninstall_plugin();
        return false;
        exit;
    }

    // Create initial log entry
    CAPTCHA_errorLog("CAPTCHA Plugin Successfully Installed");
    COM_errorLog("Successfully installed the $pi_name Plugin!",1);

    return true;
}

/*
* Main Function
*/

$action = COM_applyFilter($_POST['action']);

$display = COM_siteHeader();
$T = new Template($_CONF['path'] . 'plugins/'.$pi_name.'/templates');
$T->set_file('install', 'install.thtml');
$T->set_var('install_header', $LANG_CP00['install_header']);
$T->set_var('img',$_CONF['site_url'] . '/'.$pi_name.'/'.$pi_name.'.png');
$T->set_var('cgiurl', $_CONF['site_admin_url'] . '/plugins/'.$pi_name.'/install.php');
$T->set_var('admin_url', $_CONF['site_admin_url'] . '/plugins/'.$pi_name.'/index.php');

if ($action == 'install') {
    $install_plugin = 'plugin_install_' . $pi_name;
    if ($install_plugin()) {
        $installMsg = sprintf($LANG_CP00['install_success'],$_CONF['site_admin_url'] . '/plugins/'.$pi_name.'/index.php');
        $T->set_var('installmsg1',$installMsg);
    } else {
       	echo COM_refresh ($_CONF['site_admin_url'] . '/plugins.php?msg=72');
    }
} else if ($action == "uninstall") {
    $uninstall_plugin = 'plugin_uninstall_' . $pi_name;
    $uninstall_plugin('installed');
    $T->set_var('installmsg1',$LANG_CP00['uninstall_msg']);
}

if (DB_count($_TABLES['plugins'], 'pi_name', $pi_name) == 0) {
    $T->set_var('installmsg2', $LANG_CP00['uninstalled']);
    $T->set_var('readme', $LANG_CP00['readme']);
    $T->set_var('btnmsg', $LANG_CP00['install']);
    $T->set_var('action','install');

    $gl_version = VERSION;
    $php_version = phpversion();

    $glver = sprintf($LANG_CP00['geeklog_check'],$gl_version);
    $phpver = sprintf($LANG_CP00['php_check'],$php_version);
    $T->set_var(array(
        'lang_overview'     => $LANG_CP00['overview'],
        'lang_details'      => $LANG_CP00['details'],
        'cp_requirements'   => $LANG_CP00['preinstall_check'],
        'gl_version'        => $glver,
        'php_version'       => $phpver,
        'install_doc'       => $LANG_CP00['preinstall_confirm'],
    ));
} else {
    echo COM_refresh($_CONF['site_url'] . '/index.php?msg=1&amp;plugin='.$pi_name);
    exit;
}
$T->parse('output','install');
$display .= $T->finish($T->get_var('output'));
$display .= COM_siteFooter(true);

echo $display;

?>
