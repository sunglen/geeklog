<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | japanize Plugin 1.0.3                                                     |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Tsuchi           - tsuchi AT geeklog DOT jp                      |
// +---------------------------------------------------------------------------+
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
* Autoinstall API functions for the japanize plugin
*
* @package japanize
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_japanize($pi_name)
{
    $pi_name         = 'japanize';
    $pi_display_name = 'Japanize';
    $pi_admin        = $pi_display_name . ' Admin';

    include_once 'version.php';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => $_JPN_CONF['version'],
        'pi_gl_version'   => '1.6.0',
        'pi_homepage'     => 'http://www.geeklog.jp/filemgmt/index.php?id=340',
    );

    //----------------------------------------------------------------
    // the plugin's groups - assumes first group to be the Admin group
    //----------------------------------------------------------------
    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );
    //----------------------------------------------------------------
    // the plugin's feature -
    //----------------------------------------------------------------
    $features = array(
        $pi_name . '.edit'    => 'Access to ' . $pi_display_name
                                  . '  editor'
    );
    //----------------------------------------------------------------
    // the plugin's mappings -
    //----------------------------------------------------------------
    $mappings = array(
        $pi_name . '.edit'     => array($pi_admin)
    );

    //----------------------------------------------------------------
    // the plugin's tables -
    //----------------------------------------------------------------
    $tables = array(
    );

    $inst_parms = array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings,
        'tables'    => $tables
    );

    return $inst_parms;
}
// ----------------------------------------------------------------
// config情報ロード：Return OK:true NG:false
// ----------------------------------------------------------------

function plugin_load_configuration_japanize($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_japanize();
}
// ----------------------------------------------------------------
// コアパッケージのチェック：Return OK:true NG:false
// ----------------------------------------------------------------
function plugin_compatible_with_this_version_japanize($pi_name)
{

    if (!function_exists('COM_truncate') || !function_exists('MBYTE_strpos')) {
        return false;
    }

    if (!function_exists('SEC_createToken')) {
        return false;
    }

    // CUSTOM_mail があるかどうかチェック！
    if( function_exists( 'custom_mail' )){
        return false;
    }

    return true;
}


// ----------------------------------------------------------------
// インストール時準備Return OK:true NG:false
// ----------------------------------------------------------------
//function plugin_postinstall_japanize($pi_name)
//{
//    return true;
//}

?>
