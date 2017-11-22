<?php
// +---------------------------------------------------------------------------+
// | japanize_function 共通＆navbarMenu設定                                    |
// +---------------------------------------------------------------------------+
// $Id: index.php
// public_html/admin/plugins/japanize/japanize_function.php
// 20080729 tsuchi AT geeklog DOT jp
require_once('../../../lib-common.php');
$base_path = $_CONF['path'] . 'plugins/' . THIS_PLUGIN . '/';
$lib = $base_path . "lib/";
require_once ($lib . 'ppNavbar.php');


// 権限チェック
if (!SEC_hasRights('japanize.edit')) {
    $display="";
    $display .= COM_siteHeader('menu', $MESSAGE[30]);
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[35];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter();

    // Log attempt to error.log
    COM_accessLog("User {$_USER['username']} tried to illegally access the japanize administration screen.");

    echo $display;

    exit;
}

$navbarMenu = array(
    $LANG_JPN_admin_menu['1']   => $_CONF['site_admin_url'] .'/plugins/'.THIS_PLUGIN.'/index.php'
    ,$LANG_JPN_admin_menu['2']   => $_CONF['site_admin_url'] .'/plugins/'.THIS_PLUGIN.'/settings.php'
    ,$LANG_JPN_admin_menu['3']   => $_CONF['site_admin_url'] .'/plugins/'.THIS_PLUGIN.'/information.php'
    ,$LANG_JPN_admin_menu['4']   => $_CONF['site_admin_url'] .'/plugins/'.THIS_PLUGIN
        .'/convertconfig_1.4.1jp_to_1.5.0.php'
);


?>