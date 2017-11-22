<?php
// +--------------------------------------------------------------------------+
// | Media Gallery Plugin for glFusion CMS                                    |
// +--------------------------------------------------------------------------+
// | $Id:: rss.php 5847 2010-04-09 13:16:50Z mevans0263                      $|
// | Set configuration options for Media Gallery Plugin.                      |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2005-2010 by the following authors:                        |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+
//

require_once '../../../lib-common.php';
require_once '../../auth.inc.php';
require_once $_CONF['path'] . 'plugins/mediagallery/include/rssfeed.php';
require_once $_MG_CONF['path_admin'] . 'navigation.php';


// $display = '';

// Only let admin users access this page
if (!SEC_hasRights('mediagallery.config')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the Media Gallery Configuration page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR'],1);
    $display  = COM_siteHeader();
    $display .= COM_startBlock($LANG_MG00['access_denied']);
    $display .= $LANG_MG00['access_denied_msg'];
    $display .= COM_endBlock();
    $display .= COM_siteFooter(true);
    echo $display;
    exit;
}

//MG_initAlbums();

function MG_editRSS( ) {
    global $_CONF, $_MG_CONF, $_TABLES, $_USER, $LANG_MG00, $LANG_MG01;

    $retval = '';
    $T = new Template($_MG_CONF['template_path']);
    $T->set_file ('admin','rssedit.thtml');
    $T->set_var('site_url', $_CONF['site_url']);
    $T->set_var('site_admin_url', $_CONF['site_admin_url']);
    $T->set_var('xhtml',XHTML);
    $rss_full_select = '<input type="checkbox" name="rss_full_enabled" value="1" ' . ($_MG_CONF['rss_full_enabled'] ? ' checked="checked"' : '') .'/>';

    $rss_type_select =  "<select name='rss_feed_type'>";
    $rss_type_select .= "<option value='RSS2.0'"  . ($_MG_CONF['rss_feed_type'] == "RSS2.0" ? ' selected="selected"' : "") . ">RSS2.0</option>";
    $rss_type_select .= "<option value='RSS1.0'"  . ($_MG_CONF['rss_feed_type'] == "RSS1.0" ? ' selected="selected"' : "") . ">RSS1.0</option>";
    $rss_type_select .= "<option value='RSS0.91'" . ($_MG_CONF['rss_feed_type'] == "RSS0.91" ? ' selected="selected"' : "") . ">RSS0.91</option>";
    $rss_type_select .= "<option value='PIE0.1'"  . ($_MG_CONF['rss_feed_type'] == "PIE0.1" ? ' selected="selected"' : "") . ">PIE0.1</option>";
    $rss_type_select .= "<option value='OPML'"    . ($_MG_CONF['rss_feed_type'] == "OPML" ? ' selected="selected"' : "") . ">OPML</option>";
    $rss_type_select .= "<option value='ATOM'"    . ($_MG_CONF['rss_feed_type'] == "ATOM" ? ' selected="selected"' : "") . ">ATOM</option>";
    $rss_type_select .= "<option value='ATOM0.3'" . ($_MG_CONF['rss_feed_type'] == "ATOM0.3" ? ' selected="selected"' : "") . ">ATOM0.3</option>";
    $rss_type_select .= "</select>";

    $hide_email_select = '<input type="checkbox" name="hide_email" value="1" ' . ($_MG_CONF['hide_author_email'] ? ' checked="checked"' : '') .'/>';

    $rss_ignore_empty_select = '<input type="checkbox" name="rss_ignore_empty" value="1" ' . ($_MG_CONF['rss_ignore_empty'] ? ' checked="checked"' : '') .'/>';
    $rss_anonymous_only_select = '<input type="checkbox" name="rss_anonymous_only" value="1" ' . ($_MG_CONF['rss_anonymous_only'] ? ' checked="checked"' : '') .'/>';

    $T->set_var(array(
        'lang_rss_options'          => $LANG_MG01['rss_options'],
        'lang_rss_full'             => $LANG_MG01['rss_full'],
        'lang_rss_type'             => $LANG_MG01['rss_type'],
        'lang_rss_ignore_empty'     => $LANG_MG01['rss_ignore_empty'],
        'lang_rss_anonymous_only'   => $LANG_MG01['rss_anonymous_only'],
        'lang_rss_feed_name'        => $LANG_MG01['rss_feed_name'],
        'lang_save'                 => $LANG_MG01['save'],
        'lang_cancel'               => $LANG_MG01['cancel'],
        'lang_reset'                => $LANG_MG01['reset'],
        'rss_full_select'           => $rss_full_select,
        'rss_type_select'           => $rss_type_select,
        'hide_email_select'         => $hide_email_select,
        'lang_hide_email'           => $LANG_MG01['hide_email'],
        'rss_ignore_empty_select'   => $rss_ignore_empty_select,
        'rss_anonymous_only_select' => $rss_anonymous_only_select,
        'rss_feed_name'             => $_MG_CONF['rss_feed_name'],
        's_form_action'             => $_MG_CONF['admin_url'] . 'rss.php'
    ));

    $T->parse('output', 'admin');
    $retval .= $T->finish($T->get_var('output'));
    return $retval;
}

function MG_saveRSS( ) {
    global $_CONF, $_MG_CONF, $_TABLES, $_USER, $_POST;

    $rss_full_enabled   = isset($_POST['rss_full_enabled']) ? COM_applyFilter($_POST['rss_full_enabled'],true) : 0;
    $rss_feed_type      = COM_applyFilter($_POST['rss_feed_type']);
    $rss_ignore_empty   = isset($_POST['rss_ignore_empty']) ? COM_applyFilter($_POST['rss_ignore_empty'],true) : 0;
    $rss_anonymous_only = isset($_POST['rss_anonymous_only']) ? COM_applyFilter($_POST['rss_anonymous_only'],true) : 0;
    $rss_feed_name      = COM_applyFilter($_POST['rss_feed_name']);
    $hide_email         = isset($_POST['hide_email']) ? COM_applyFilter($_POST['hide_email'],true) : 0;

    DB_save($_TABLES['mg_config'],"config_name, config_value","'rss_full_enabled','$rss_full_enabled'");
    DB_save($_TABLES['mg_config'],"config_name, config_value","'rss_feed_type','$rss_feed_type'");
    DB_save($_TABLES['mg_config'],"config_name, config_value","'rss_ignore_empty','$rss_ignore_empty'");
    DB_save($_TABLES['mg_config'],"config_name, config_value","'rss_anonymous_only','$rss_anonymous_only'");
    DB_save($_TABLES['mg_config'],"config_name, config_value","'rss_feed_name','$rss_feed_name'");
    DB_save($_TABLES['mg_config'],"config_name, config_value","'hide_author_email','$hide_email'");

    $_MG_CONF['rss_full_enabled'] = $rss_full_enabled;

    MG_buildFullRSS();

    echo COM_refresh($_MG_CONF['admin_url'] . 'index.php?msg=6');
    exit;
}

/**
* Main
*/

$display = '';
$mode = '';

if (isset ($_POST['mode'])) {
    $mode = COM_applyFilter($_POST['mode']);
} else if (isset ($_GET['mode'])) {
    $mode = COM_applyFilter($_GET['mode']);
}

$display = COM_siteHeader();
$T = new Template($_MG_CONF['template_path']);
$T->set_file (array ('admin' => 'administration.thtml'));

$T->set_var(array(
    'site_admin_url'    => $_CONF['site_admin_url'],
    'site_url'          => $_MG_CONF['site_url'],
    'mg_navigation'     => MG_navigation(),
    'lang_admin'        => $LANG_MG00['admin'],
    'version'           => $_MG_CONF['pi_version'],
    'xhtml'             => XHTML,
));

if ($mode == $LANG_MG01['save'] && !empty ($LANG_MG01['save'])) {   // save the config
    $T->set_var(array(
        'admin_body'    => MG_saveRSS(),
        'mg_navigation' => MG_navigation()
    ));
} elseif ($mode == $LANG_MG01['cancel']) {
    echo COM_refresh ($_MG_CONF['admin_url'] . 'index.php');
    exit;
} else {
    $T->set_var(array(
        'admin_body'    => MG_editRSS(),
        'title'         => $LANG_MG01['rss_options'],
        'lang_help'     => '<img src="' . MG_getImageFile('button_help.png') . '" style="border:none;" alt="?"' . XHTML . '>',
        'help_url'      => $_MG_CONF['site_url'] . '/docs/usage.html#RSS_Feed_Options',
    ));
}

$T->parse('output', 'admin');
$display .= $T->finish($T->get_var('output'));
$display .= COM_siteFooter();
echo $display;
exit;
?>