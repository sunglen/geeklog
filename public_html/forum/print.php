<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.6 for Geeklog - The Ultimate Weblog               |
// | Release date: Oct 30,2006                                                 |
// +---------------------------------------------------------------------------+
// | print.php                                                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001,2002,2003 by the following authors:               |
// | Geeklog Author: Tony Bibbs       - tony@tonybibbs.com                     |
// +---------------------------------------------------------------------------+
// | Plugin Authors                                                            |
// | Blaine Lang,                  blaine@portalparts.com, www.portalparts.com |
// | Version 1.0 co-developer:     Matthew DeWyer, matt@mycws.com              |
// | Prototype & Concept :         Mr.GxBlock, www.gxblock.com                 |
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

require_once '../lib-common.php'; // Path to your lib-common.php
require_once $CONF_FORUM['path_include'] . 'gf_format.php';
require_once $CONF_FORUM['path_include'] . 'bbcode/stringparser_bbcode.class.php';

if (!in_array('forum', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

function gf_FormatForPrint( $str, $postmode='html' ) {
    global $CONF_FORUM;

    // Handle Pre ver 2.5 quoting and New Line Formatting - consider adding this to a migrate function
    if ($CONF_FORUM['pre2.5_mode']) {
        if ( stristr($showtopic['comment'],'[code') == false ) {
            $showtopic['comment'] = str_replace('<pre>','[code]',$showtopic['comment']);
            $showtopic['comment'] = str_replace('</pre>','[/code]',$showtopic['comment']);
        }
        $showtopic['comment'] = str_replace(array("<br />\r\n","<br />\n\r","<br />\r","<br />\n","<br>\r\n","<br>\n\r","<br>\r","<br>\n"), '<br' . XHTML . '>', $showtopic['comment'] );
        $showtopic['comment'] = preg_replace("/\[QUOTE\sBY=\s(.+?)\]/i","[QUOTE] Quote by $1:",$showtopic['comment']);
        /* Reformat code blocks - version 2.3.3 and prior */
        $showtopic['comment'] = str_replace( '<pre class="forumCode">', '[code]', $showtopic['comment'] );
        $showtopic['comment'] = preg_replace("/\[QUOTE\sBY=(.+?)\]/i","[QUOTE] Quote by $1:",$showtopic['comment']);
    }
    
    $str = gf_formatTextBlock($str,$postmode,'preview');
    
    $str = str_replace('{','&#123;',$str);
    $str = str_replace('}','&#125;',$str);

    // we don't have a stylesheet for printing, so replace our div with the style...
    $str = str_replace('<div class="quotemain">','<div style="border: 1px dotted #000;border-left: 4px solid #8394B2;color:#465584;  padding: 4px;  margin: 5px auto 8px auto;">',$str);
    return $str;
}

// Pass thru filter any get or post variables to only allow numeric values and remove any hostile data
$id = COM_applyFilter($_REQUEST['id'],true);

$display = '';

//Check is anonymous users can access
if ($CONF_FORUM['registration_required'] && $_USER['uid'] < 2) {
    $display .= COM_siteHeader();
    $display .= COM_startBlock();
    $display .= alertMessage($LANG_GF02['msg01'],$LANG_GF02['msg171']);
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    COM_output($display);
    exit;
}

//Check is anonymous users can access
if ($id == 0 OR DB_count($_TABLES['gf_topic'],"id","$id") == 0) {
//    $display .= COM_siteHeader();
//    $display .= forum_statusMessage($LANG_GF02['msg166'], $_CONF['site_url'] . "/forum/index.php?forum=$forum",$LANG_GF02['msg166']);
//    $display .= COM_siteFooter();
    $display = COM_refresh($_CONF['site_url'] . "/forum/index.php?msg=2&amp;forum=$forum");
    COM_output($display);
    exit;
}

$forum = DB_getItem($_TABLES['gf_topic'],"forum","id='{$id}'");
$query = DB_query("SELECT grp_name from {$_TABLES['groups']} groups, {$_TABLES['gf_forums']} forum WHERE forum.forum_id='{$forum}' AND forum.grp_id=groups.grp_id");
list ($groupname) = DB_fetchArray($query);
if (!SEC_inGroup($groupname) AND $grp_id != 2) {
    $display .= COM_siteHeader();
    $display .= alertMessage($LANG_GF02['msg02'],$LANG_GF02['msg171']);
    $display .= COM_siteFooter();
    COM_output($display);
    exit;
}

$result = DB_query("SELECT * FROM {$_TABLES['gf_topic']} WHERE (id='$id')");
$A = DB_fetchArray($result);

$A["name"] = COM_getDisplayName($A["uid"]);
$A["name"] = htmlspecialchars($A["name"],ENT_QUOTES,$CONF_FORUM['charset']);

$A["subject"] = COM_checkWords($A["subject"]);
$A["subject"] = htmlspecialchars($A["subject"],ENT_QUOTES,$CONF_FORUM['charset']);

$A['comment'] = gf_FormatForPrint( $A['comment'], $A['postmode'] );
$A['comment'] = str_replace('<br />', '<br>', $A['comment'] );

$date = strftime($CONF_FORUM['default_Datetime_format'], $A['date']);
$display .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
    <meta http-equiv=\"Content-Style-Type\" content=\"text/css\">
    <title>{$_CONF['site_name']} - {$LANG_GF02['msg147']} [{$A['id']}]</title>
    <style type=\"text/css\">
    <!--
    body { font-size:small; }
    table { font-size:small; }
    h1 { font-size:x-large; }
    h2 { font-size:medium; }
    -->
    </style>
</head>
<body>
    <h1>{$LANG_GF01['SUBJECT']}: {$A['subject']}</h1>
    <div style=\"margin-bottom:1em;\">
        <p>
        <b>{$LANG_GF01['POSTEDON']}:</b> $date<br>
        <b>{$LANG_GF01['BY']}</b> {$A['name']}<br>
        </p>
    </div>
    <div>{$A['comment']}</div>";

$result2 = DB_query("SELECT * FROM {$_TABLES['gf_topic']} WHERE (pid='$id')");
while ($B = DB_fetchArray($result2)) {
    $date = strftime($CONF_FORUM['default_Datetime_format'], $B['date']);
    $B["name"] = COM_getDisplayName($B["uid"]);
    $B['comment'] = gf_FormatForPrint( $B['comment'], $B['postmode'] );
    $B['comment'] = str_replace('<br />', '<br>', $B['comment'] );
    $display .= "
    <hr>
    <div style=\"margin-bottom:1em;\">
        <h2>{$B['subject']}</h2>
        <p>
        <b>{$LANG_GF01['POSTEDON']}:</b> $date<br>
        <b>{$LANG_GF01['BY']}</b> {$B['name']}<br>
        </p>
    </div>
    <div>{$B['comment']}</div>";
}

$display .= "
    <hr>
    <p>{$_CONF['site_name']} - {$LANG_GF01['FORUM']}<br>
    <a href=\"{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$A['id']}\">{$_CONF['site_url']}/forum/viewtopic.php?showtopic={$A['id']}</a>
    </p>
</body>
</html>";

COM_output($display);
?>