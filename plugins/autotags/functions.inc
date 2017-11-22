<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Autotags Plugin 1.0                                                       |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// +---------------------------------------------------------------------------+
// | Autotags Plugin Copyright (C) 2006 by the following authors:              |
// |          Joe Mucchiello    - jmucchiello AT yahoo DOT com                 |
// +---------------------------------------------------------------------------+
// | Based on the Universal Plugin and prior work by the following authors:    |
// |                                                                           |
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

if (!defined('XHTML')) {
	define('XHTML', '');
}

$langfile = $_CONF['path'] . 'plugins/autotags/language/'
          . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    include_once ($langfile);
} else {
    include_once ($_CONF['path'] . 'plugins/autotags/language/english.php');
}

require_once ($_CONF['path'] . 'plugins/autotags/config.php');

$_AUTOTAGS = Array();
/*
 *  Populates the $_AUTOTAGS global array with list of enabled
 *  autotags. Does not contain autotags from other plugins.
 *
 *  When autotags are in use, they can generate a lot of little calls
 *  to the DB server. This array is hopefully faster. It certainly is
 *  easier to code array accesses than DB accesses.
 */
function loadAutotags()
{
    global $_TABLES, $_AUTOTAGS, $_AUTO_CONF;
    
    if (isset($_AUTO_CONF['loaded']) && $_AUTO_CONF['loaded'] == 1)
        return;
    
    $sql = "SELECT * FROM {$_TABLES['autotags']} WHERE is_enabled = 1";
    $result = DB_query($sql);
    $num = DB_numrows($result);
    for ($i = 0; $i < $num; ++$i)
    {
        $A = DB_fetchArray($result);
        $_AUTOTAGS[$A['tag']] = $A;
    }
    $_AUTO_CONF['loaded'] = 1;
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

function plugin_chkVersion_autotags()
{
    global $_AUTO_CONF;

    return $_AUTO_CONF['version'];
}

function plugin_upgrade_autotags()
{
    global $_AUTO_CONF, $_TABLES;
    
    $dbver = DB_getItem ($_TABLES['plugins'], 'pi_version', "pi_name = '$pi_name'");
    if ($dbver != $_AUTO_CONF['version'])
    {
        DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_AUTO_CONF['version']}' WHERE pi_name = 'autotags'");
        if (!DB_getItem($_TABLES['autotags'], '1', "tag = 'lang'")) {
            DB_query("INSERT INTO {$_TABLES['autotags']} (tag, is_enabled, is_function, description, replacement) VALUES ('lang', 0, 1, 'Provides access to the $LANG family of variables', NULL)");
        }
    }
    return TRUE;
}

function plugin_uninstall_autotags($steps = '')
{
    global $_TABLES;

    // Uninstalls the autotags plugin

    if (empty($steps) OR $steps['createtable'] == 1) {
        // Remove the staticpage table
        COM_errorLog('Dropping autotags table',1);
        DB_query("DROP TABLE {$_TABLES['autotags']}");
        COM_errorLog('...success',1);
    }

    // Remove security for this plugin

    // Remove the static page admin group
    $grp_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Autotags Admin'");

    if (empty($steps) OR $steps['insertgroup'] == 1) {
        COM_errorLog('Attempting to remove the Autotags Admin Group', 1);
        DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id");
        COM_errorLog('...success',1);
    }

    // Remove related features
    $featurelist = Array();
    
    $result = DB_query("SELECT ft_id FROM {$_TABLES['features']} WHERE ft_name like 'autotags.%'");
    $num = DB_numrows($result);
    for ($i = 0; $i < $num; ++$i)
    {
        $row = DB_fetchArray($result);
        $featurelist[] = $row['ft_id'];
    }
    $admin_id = '(' . implode(',', $featurelist) . ')';

    if (empty($steps) OR $steps['addedadmintogroup'] == 1) {
        // Remove access to those features
        COM_errorLog('Attempting to remove rights to autopage.admin from all groups',1);
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id in $admin_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['addedrootuserstogroup'] == 1) {
        // Remove root users from the group
        COM_errorLog('Attempting to remove root users from admin of static pages');
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['insertedfeatureedit'] == 1) {
        COM_errorLog('Attempting to remove the autotags.admin feature',1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id in $admin_id");
        COM_errorLog('...success',1);
    }

    // Unregister the plugin with Geeklog
    // Always attempt to remove these entries or lib-common.php would still
    // try and read our functions.inc file ...
    COM_errorLog('Attempting to unregister the plugin from Geeklog',1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'autotags'");
    COM_errorLog('...success',1);

    COM_errorLog('leaving plugin_uninstall_autotags',1);

    return true;
}

function plugin_commentsupport_autotags()
{
    return false;
}

function plugin_cclabel_autotags()
{
    global $_CONF;

    if (SEC_hasRights ('autotags.admin')) {
        return array('Autotags',
                $_CONF['site_admin_url'] . '/plugins/autotags/index.php',
                plugin_geticon_autotags ());
    }

    return false;
}

function plugin_getadminoption_autotags()
{
    global $_CONF, $_TABLES, $LANG_AUTO;

    if (SEC_hasRights ('autotags.admin')) {
        $result = DB_query ("SELECT count(*) AS cnt FROM {$_TABLES['autotags']}");
        $A = DB_fetchArray ($result);
        $total_pages = $A['cnt'];
        return array(htmlspecialchars($LANG_AUTO['admin_label'], ENT_QUOTES), $_CONF['site_admin_url'] . '/plugins/autotags/index.php', $total_pages);
    }
}

function plugin_getmenuitems_autotags()
{
    global $_AUTO_CONF, $LANG_AUTO;

    $menuitems = array();
    
    if ($_AUTO_CONF['link_in_menu'] == 1)
    {
        $menulabel = $LANG_AUTO['main_menulabel'];
        $menuurl = $_CONF['site_url'] . "/autotags/index.php";

        $menuitems["$menulabel"] = $menuurl;
    }
    return $menuitems;
}

function plugin_geticon_autotags ()
{
    global $_CONF;

    return $_CONF['site_admin_url'] . '/plugins/autotags/images/autotags.png';
}

function plugin_getListField_autotags($fieldname, $fieldvalue, $A, $icon_arr) {
    global $_CONF, $_AUTO_CONF, $LANG_ACCESS;

    switch($fieldname) {
        case "edit":
            if ($A['is_function'] && (!SEC_hasRights('autotags.PHP') || $_AUTO_CONF['allow_php'] == 0))
                $retval = '';
            else 
                $retval = "<a href=\"{$_CONF['site_admin_url']}/plugins/autotags/index.php?mode=edit&amp;tag={$A['tag']}\">{$icon_arr['edit']}</a>";
            break;
        case "tag":
            $retval = $A['tag'];
            break;
        case "description":
            $retval = stripslashes ($A['description']);
            break;
        case 'is_function':
            $retval = ($A['is_function'] == 1) ? $LANG_ACCESS['yes'] : $LANG_ACCESS['no'];
            break;
        case 'is_enabled':
            if ($A['is_function'] && (!SEC_hasRights('autotags.PHP') || $_AUTO_CONF['allow_php'] == 0))
            {
                $retval = ($A['is_enabled'] == 1) ? $LANG_ACCESS['yes'] : $LANG_ACCESS['no'];
            } else {
                $switch = ($A['is_enabled'] == 1) ? 'checked="checked"' : '';
                   
                $retval = "<form action=\"{$_CONF['site_admin_url']}/plugins/autotags/index.php\" method=\"post\">"
                         ."<input type=\"checkbox\" name=\"tagenable\" onclick=\"submit()\" value=\"{$A['tag']}\" $switch" . XHTML . ">"
                         ."<input type=\"hidden\" name=\"tagChange\" value=\"{$A['tag']}\"" . XHTML . "></form>";
            }
            break;
        default:
            $retval = $fieldvalue;
            break;
    }
    return $retval;
}

/**
* Why we are here.
*
*/
function plugin_autotags_autotags ($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES, $_AUTOTAGS;

    loadAutotags();
    if ($op == 'tagname' ) {
        return array_keys($_AUTOTAGS);
    } else if ($op == 'parse') {
        $p1 = $autotag['parm1'];
        $p2 = $autotag['parm2'];
        
        if (empty($p2)) $p2 = $p1;
        
        if (isset($_AUTOTAGS[$autotag['tag']]))
        {
            $record = $_AUTOTAGS[$autotag['tag']];
            if ($record['is_function'] == 1)
            {
                $function = 'phpautotags_'.$autotag['tag'];
                if (function_exists($function))
                {
                    $replace = $function($p1, $p2, $autotag['tagstr']);
                    $content = str_replace($autotag['tagstr'], $replace, $content);
                }
            } else {
                $p0 = substr($autotag['tagstr'], strlen($autotag['tag']) + 2);
                $p0 = substr($p0, 0, strlen($p0)-1);
                $replace = Array('#U', '#1', '#2', '#0');
                $with = Array($_CONF['site_url'], $p1, $p2, $p0);
                
                $subject = $record['replacement'];
                $subject = str_replace($replace, $with, $subject);
                $content = str_replace($autotag['tagstr'], $subject, $content);
            }
        }
        return $content;
    }
}

/**
* Get path for the template files.
*
* @param    string  $path   subdirectory within the base template path
* @return   string          full path to template directory
*
*/
function autotags_templatePath ($path = '')
{
    global $_CONF;

    if (empty ($path)) {
        $layout_path = $_CONF['path_layout'] . 'autotags';
    } else {
        $layout_path = $_CONF['path_layout'] . 'autotags' . '/' . $path;
    }

    if (is_dir ($layout_path)) {
        $retval = $layout_path;
    } else {
        $retval = $_CONF['path'] . 'plugins/autotags/templates';
        if (!empty ($path)) {
            $retval .= '/' . $path;
        }
    }

    return $retval;
}

/*
 *  Sample function-based autotags. These functions are only available
 *  if $_AUTO_CONF['allow_php'] == 1 and the administrator possesses the
 *  autotags.PHP feature. They are disabled by default.
 *
 */

function phpautotags_topic($p1, $p2, $fulltag)
{
    global $_TABLES, $_CONF;
    
    $topic = DB_getItem($_TABLES['topics'], 'topic', "tid = '$p1'" . COM_getTopicSQL('AND'));
    // Comment out the line above and uncomment the line below if you 
    // don't care whether or not users can see the names of topic they
    // cannot access.
//    $topic = DB_getItem($_TABLES['topics'], 'topic', "tid = '$p1'");
    
    if (empty($topic))
        return "<B>Unknown Topic</B>";
    $topic = stripslashes($topic);
    return "<a href=\"{$_CONF['site_url']}/index.php?topic=" . urlencode($p1) . "\">" . htmlspecialchars($topic, ENT_QUOTES) . "</a>";

}

function phpautotags_cipher($p1, $p2, $fulltag)
{
    $code = "abcdefghijklmnopqrstuvwxyz";
    $key = Array();
    $len = strlen($p1);
    for ($i = 0; $i < $len; ++$i)
        $key[$p1[$i]] = $code[$i];

    $result = '';
    $len = strlen($p2);
    for ($i = 0; $i < $len; ++$i)
    {
        $c = strtolower($p2[$i]);
        $upper = $c != $p2[$i];
        if (!isset($key[$c]))
            $result .= $p2[$i];
        else if ($upper)
            $result .= strtoupper($key[$c]);
        else
            $result .= $key[$c];
    }
    return $result;
}

function phpautotags_lang($p1, $p2, $fulltag)
{
    if (empty($p1) || empty($p2)) {
        return '';
    }
    
    $lang = "LANG$p1";
    if (!is_array($GLOBALS[$lang])) {
        $lang = "LANG_$p1";
    }
    if (is_array($GLOBALS[$lang]) && isset($GLOBALS[$lang][$p2])) {
        return $GLOBALS[$lang][$p2];
    }
    return '{$LANG'.$p1.'['.$p2.']}';
}

?>