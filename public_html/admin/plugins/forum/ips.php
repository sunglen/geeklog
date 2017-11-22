<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.6 for Geeklog - The Ultimate Weblog               |
// | Release date: Oct 30,2006                                                 |
// +---------------------------------------------------------------------------+
// | ips.php                                                                   |
// | Program to administrate IP access/restriction to forum                    |
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

include_once 'gf_functions.php';

$ip    = COM_applyFilter($_REQUEST['ip']);
$forum = COM_applyFilter($_REQUEST['forum'],true);
$op    = COM_applyFilter($_REQUEST['op']);

$display = '';
$display .= COM_siteHeader();

// Debug Code to show variables
$display .= gf_showVariables();

$msg = '';
if (isset($_GET['msg'])) {
    $msg = COM_applyFilter($_GET['msg'], true);
}
if ($msg==1) {
    $display .= COM_showMessageText($LANG_GF96['ipbanned']);
}
if ($msg==2) {
    $display .= COM_showMessageText($LANG_GF96['ipunbanned']);
}

$display .= COM_startBlock($LANG_GF96['gfipman']);
$display .= forum_Navbar($navbarMenu,$LANG_GF06['7']);

if (($op == 'banip') && ($ip != '')) {
    if ($_POST['sure'] == 'yes') {
        DB_query("INSERT INTO {$_TABLES['gf_banned_ip']} (host_ip) VALUES ('$ip')");
//        $display .= forum_statusMessage($LANG_GF96['ipbanned'],$_CONF['site_admin_url'] .'/plugins/forum/ips.php',$LANG_GF96['ipbanned']);
//        $display .= COM_endBlock();
//        $display .= adminfooter();
//        $display .= COM_siteFooter();
        $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/ips.php?msg=1');
        COM_output($display);
        exit;
    }

    if ($_POST['sure'] != 'yes') {
        $ips_unban = new Template($CONF_FORUM['path_layout'] . 'forum/layout/admin');
        $ips_unban->set_file (array ('ips_unban'=>'ips_unban.thtml'));
        $ips_unban->set_var ('xhtml', XHTML);
        $ips_unban->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/ips.php');
        $ips_unban->set_var ('deletenote1', sprintf($LANG_GF93['deleteforumnote1'], $forumname));
        $ips_unban->set_var ('deletenote2', $LANG_GF93['deleteforumnote21']);
        $ips_unban->set_var ('mode', banip);
        $ips_unban->set_var ('sure', yes);
        $ips_unban->set_var ('ip', $ip);
        $ips_unban->set_var ('msg1', $LANG_GF96['banip']);
        $ips_unban->set_var ('msg2', sprintf($LANG_GF96['banipmsg'], $ip));
        $ips_unban->set_var ('ban', $LANG_GF96['ban']);
        $ips_unban->set_var('gltoken_name', CSRF_TOKEN);
        $ips_unban->set_var('gltoken', SEC_createToken());
        $ips_unban->parse ('output', 'ips_unban');
        $display .= $ips_unban->finish ($ips_unban->get_var('output'));
        $display .= COM_endBlock();
        $display .= adminfooter();
        $display .= COM_siteFooter();
        COM_output($display);
        exit;
    }

} elseif (($op == 'banip') && ($ip == '')) {
    $messagetemplate = new Template($CONF_FORUM['path_layout'] . 'forum/layout/admin');
    $messagetemplate->set_file (array ('messagetemplate'=>'message.thtml'));
    $messagetemplate->set_var ('xhtml', XHTML);
    $messagetemplate->set_var ('message', $LANG_GF01['ERROR']);
    $messagetemplate->set_var ('transfer', $LANG_GF96['specip']);
    $messagetemplate->parse ('output', 'messagetemplate');
    $display .= $messagetemplate->finish ($messagetemplate->get_var('output'));
    $display .= COM_endBlock();
    $display .= adminfooter();
    $display .= COM_siteFooter(true);
    COM_output($display);
    exit;
}

if (($op == 'unban') && ($ip != '') && SEC_checkToken()) {
    DB_query ("DELETE FROM {$_TABLES['gf_banned_ip']} WHERE (host_ip='$ip')");
//    $display .= forum_statusMessage($LANG_GF96['ipunbanned'],$_CONF['site_admin_url'] .'/plugins/forum/ips.php',$LANG_GF96['ipunbanned']);
//    $display .= COM_endBlock();
//    $display .= adminfooter();
//    $display .= COM_siteFooter();
    $display = COM_refresh($_CONF['site_admin_url'] .'/plugins/forum/ips.php?msg=2');
    COM_output($display);
    exit;
}


if (!empty($forum)) {
    $theforum = "WHERE forum='$forum'"; // no use $theform ?
} else {
    $theforum = '';
}


if ($op == '') {
    $bannedsql = DB_query("SELECT * FROM {$_TABLES['gf_banned_ip']} ORDER BY host_ip DESC");
    $bannum = DB_numRows($bannedsql);
    $p = new Template($CONF_FORUM['path_layout'] . 'forum/layout/admin');
    $p->set_file (array ('page' => 'banip_mgmt.thtml', 'records' => 'ip_records.thtml'));
    $p->set_var ('xhtml', XHTML);
    if ($bannum == 0) {
        $p->set_var ('alertmessage', $LANG_GF96['noips']);
        $p->set_var ('showalert','');
    } else {
        $p->set_var ('showalert','none');
    }
    $p->set_var ('phpself', $_CONF['site_admin_url'] .'/plugins/forum/ips.php');
    $p->set_var ('LANG_IP',$LANG_GF96['ipbanned']);
    $p->set_var ('LANG_Actions', $LANG_GF01['ACTIONS']);
    $i = 1;
    while($A = DB_fetchArray($bannedsql)) {
        $p->set_var ('ip', $A['host_ip']);
        $p->set_var ('unban', $LANG_GF96['unban']);
        $p->set_var ('csscode', $i);
        $p->parse ('ip_records', 'records',true);
        $i = ($i == 1 ) ? 2 : 1;
    }
    $p->set_var('gltoken_name', CSRF_TOKEN);
    $p->set_var('gltoken', SEC_createToken());
    $p->parse ('output', 'page');
    $display .= $p->finish ($p->get_var('output'));
}

$display .= COM_endBlock();
$display .= adminfooter();
$display .= COM_siteFooter();
COM_output($display);
?>