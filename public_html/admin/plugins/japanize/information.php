<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | information.php 更新                                                      |
// +---------------------------------------------------------------------------+
// $Id: information.php
// public_html/admin/plugins/japanize/information.php
// 20080729 tsuchi AT geeklog DOT jp

//
// $Id: information.php

define ('THIS_SCRIPT', 'information.php');
define ('THIS_PLUGIN', 'japanize');

include_once('japanize_functions.php');


$display = '';
$display .= COM_siteHeader ('menu', $LANG_JPN['pinameadmin']);
if (isset ($_REQUEST['msg'])) {
    $display .= COM_showMessage (COM_applyFilter ($_REQUEST['msg'],
                                                  true), 'japanize');
}
$display.=ppNavbarjp($navbarMenu,$LANG_JPN_admin_menu['3']);

//
$T = new Template($_CONF['path'] . 'plugins/japanize/templates/admin');
$T->set_file ('admin','information.thtml');

$T->set_var( 'VERSION', "Geeklog".VERSION);

if (file_exists($_CONF['path'] .'release_jp.php')) {
    require_once ($_CONF['path'] .'release_jp.php');
    $T->set_var( 'release_jp', "日本語版".$release_jp);
    $T->set_var( 'release_no', $release_no);
    $T->set_var( 'release_date', "リリース日".$release_date);
}else{
    $T->set_var( 'release_jp', "");
    $T->set_var( 'release_no', "");
    $T->set_var( 'release_date', "");
}

$T->parse('output', 'admin');
$display.= $T->finish($T->get_var('output'));
//
$display.= COM_siteFooter ();

echo $display;

?>
