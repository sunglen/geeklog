<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | CAPTCHA Plugin v4                                                         |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Hiroron           - hiroron AT hiroron DOT com                   |
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

/**
* Autoinstall API functions for the CAPTCHA plugin
*
* @package CAPTCHA
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_captcha($pi_name)
{
    $pi_name         = 'captcha';
    $pi_display_name = 'CAPTCHA';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '4.0.2',
        'pi_gl_version'   => '1.4.1',
        'pi_homepage'     => 'http://hiroron.com/'
    );

    $tables = array(
        'cp_config',
        'cp_sessions'
    );

    $inst_parms = array(
        'info'      => $info,
        'tables'    => $tables
    );

    return $inst_parms;
}

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*
*/
function plugin_compatible_with_this_version_captcha($pi_name)
{
    global $_CONF, $_DB_dbms;

    // check if we support the DBMS the site is running on
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
            . $_DB_dbms . '_install.php';
    if (! file_exists($dbFile)) {
        return false;
    }

    if (! function_exists('SEC_getGroupDropdown')) {
        return false;
    }

    if (! function_exists('SEC_createToken')) {
        return false;
    }

    if (! function_exists('COM_showMessageText')) {
        return false;
    }

    if (! function_exists('COM_setLangIdAndAttribute')) {
        return false;
    }

    return true;
}

/**
* Plugin postinstall
*
* We're inserting our default data here since it depends on other stuff that
* has to happen first ...
*
* @return   boolean     true = proceed with install, false = an error occured
*
*/
function plugin_postinstall_captcha($pi_name)
{
    global $_TABLES;

    $CP_SQL = array();
    $CP_SQL[] = "INSERT INTO `{$_TABLES['cp_config']}` (`config_name`, `config_value`) VALUES ('anonymous_only', '1'), ('remoteusers','0'), ('debug', '0'), ('enable_comment', '0'), ('enable_contact', '0'), ('enable_emailstory', '0'), ('enable_forum', '0'), ('enable_registration', '0'), ('enable_story', '0'), ('gfxDriver', '3'), ('gfxFormat', 'jpg'), ('gfxPath', '');";

    foreach ($CP_SQL as $sql) {
        DB_query($sql, 1);
        if (DB_error()) {
            COM_error("SQL error in CAPTCHA plugin postinstall, SQL: " . $sql);
            return false;
        }
    }

    return true;
}

?>
