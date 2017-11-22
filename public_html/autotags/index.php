<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Autotags Geeklog Plugin 1.0                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is a simple end-user listing of all autotags in the system.          |
// +---------------------------------------------------------------------------+
// | Autotags Plugin Copyright (C) 2006 by the following authors:              |
// |          Joe Mucchiello    - jmucchiello AT yahoo DOT com                 |
// +---------------------------------------------------------------------------+
// | Based on the Universal Plugin and prior work by the following authors:    |
// |                                                                           |
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
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

require_once ('../lib-common.php');

/*
 *  The following functions are located inside if (!function_exists)
 *  statements for the benefit of plugin writers who wish to support
 *  this plugin. If the other plugin includes the proper function
 *  it will override the function listed here. Likewise, a site
 *  admin who wants to handle these values differently can create 
 *  these functions in the lib-custom.php and that version of the
 *  function will take precedence over the version below.
 */

if (!function_exists('plugin_autotag_description_geeklog'))
{
    function plugin_autotag_description_geeklog($tag)
    {
        global $LANG_AUTO;
        if ($tag == 'story' && isset($LANG_AUTO['descr_story']))
            return $LANG_AUTO['descr_story'];
        elseif ($tag == 'event' && isset($LANG_AUTO['descr_event']))
            return $LANG_AUTO['descr_event'];
    }
}

if (!function_exists('plugin_autotag_description_calendar'))
{
    function plugin_autotag_description_calendar($tag)
    {
        global $LANG_AUTO;
        if ($tag == 'calendar' && isset($LANG_AUTO['descr_calendar']))
            return $LANG_AUTO['descr_calendar'];
    }
}

if (!function_exists('plugin_autotag_description_links'))
{
    function plugin_autotag_description_links($tag)
    {
        global $LANG_AUTO;
        if ($tag == 'link' && isset($LANG_AUTO['descr_link']))
            return $LANG_AUTO['descr_link'];
    }
}

if (!function_exists('plugin_autotag_description_staticpages'))
{
    function plugin_autotag_description_staticpages($tag)
    {
        global $LANG_AUTO;
        if ($tag == 'staticpage' && isset($LANG_AUTO['descr_staticpage']))
            return $LANG_AUTO['descr_staticpage'];
    }
}

/*
 *  Generates a list of all active autotags with description.
 */
function list_all_tags()
{
    global $_CONF, $_AUTOTAGS;
    
    $A = PLG_collectTags();
    ksort($A);
    
    $display = '<TABLE WIDTH="90%"><TR><TD ALIGN="LEFT"><b>AutoTag</b></TD><TD ALIGN="LEFT"><b>Description</b></TD></TR>'."\n";
    foreach ($A as $tag => $module)
    {
        if (isset($_AUTOTAGS[$tag]))
        {
            $display .= "<TR><TD>$tag</TD><TD>{$_AUTOTAGS[$tag]['description']}</TD></TR>\n";
        }
        else 
        {
            $descr = '';
            $function = 'plugin_autotag_description_' . $module;
            if (function_exists($function))
                $descr = $function($tag);
            if (empty($descr))
            {
                if ($module == 'geeklog')
                    $descr = "Builtin autotag";
                else
                    $descr = "Part of the $module plugin";
            }
            $display .= "<TR><TD>$tag</TD><TD>$descr</TD></TR>\n";
        }
    }
    return $display;
}

$mode = '';
if (isset($_GET['mode'])) {
    $mode = COM_applyFilter($_GET['mode']);
}

$display = '';
if ($mode == 'popup') {
    // if you want to put the list of tags in a popup window, use
    // this mode.
    $display = '<html><body>'
                . '<div style="text-align:right"><a href="javascript:window.close()">'
                . $LANG_AUTO['window_close'] . '</a></div>';                
    $display .= list_all_tags();
    $display .= '</body></html>';
} else {
    $display .= COM_siteHeader('menu', $LANG_AUTO['list_all_title']);
    $display .= COM_startBlock($LANG_AUTO['list_all_title']);
    $display .= list_all_tags();
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
}

echo $display;

?>