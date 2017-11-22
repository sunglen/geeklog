<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | index.php 更新                                                            |
// +---------------------------------------------------------------------------+
// $Id: index.php
// public_html/admin/plugins/japanize/index.php
// 20100421 tsuchi AT geeklog DOT jp
// 20100421 一括更新から（６）(6)サンプルアンケートをはずす
// 20100421POLLSが有効のときのみ(6)サンプルアンケート　ボタン表示 (fncEdit)

define ('THIS_SCRIPT', 'index.php');
define ('THIS_PLUGIN', 'japanize');
//define ('THIS_SCRIPT', 'test.php');

include_once('japanize_functions.php');


// +---------------------------------------------------------------------------+
// | 機能  テーブル更新実行                                                    |
// | 書式 fncCmdExec ($no)                                                     |
// +---------------------------------------------------------------------------+
// | 引数 $no:                                                                 |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:戻り画面＆メッセージ                                           |
// +---------------------------------------------------------------------------+
function fncCmdExec ($no)
{
    global $_TABLES,$_CONF;
    $_SQL =array();
    //require_once ("sql/sql_japanize_{$no}.php");
    require_once ($_CONF['path']."plugins/japanize/sql/sql_japanize_{$no}.php");

    for ($i = 1; $i <= count($_SQL); $i++) {
        $w=current($_SQL);
        DB_query(current($_SQL));
        next($_SQL);
    }

}

// +---------------------------------------------------------------------------+
// | 機能  初期画面表示                                                        |
// | 書式 fncEdit ()                                                           |
// +---------------------------------------------------------------------------+

function fncEdit ()
{
    global $_CONF;
    global $LANG04,$LANG_ADMIN;
    global $_TABLES;
    global $_PLUGINS;

    $retval = '';
    $T = new Template($_CONF['path'] . 'plugins/japanize/templates/admin');
    $T->set_file ('admin','index.thtml');


    $T->set_var('gltoken_name', CSRF_TOKEN);
    $T->set_var('gltoken', SEC_createToken());
    $T->set_var ( 'xhtml', XHTML );

    $this_script=$_CONF['site_admin_url']."/plugins/".THIS_PLUGIN."/".THIS_SCRIPT;
    $T->set_var ( 'this_script', $this_script );


    if  (in_array("polls", $_PLUGINS)) {
        $T->set_var ( 'type6', "submit" );
    }else{
        $T->set_var ( 'type6', "hidden" );
    }

    $T->set_var ('lang_submit', $LANG04[9]);
    $T->set_var ('lang_cancel',$LANG_ADMIN['cancel']);

    $japanize_custommail=DB_getItem($_TABLES['vars'],"value","name='japanize_custommail'");
    if ($japanize_custommail==1){
        $T->set_var ('japanize_custommail_value',"(現在、Geeklog Japanese推奨値です)");
    }else{
        $T->set_var ('japanize_custommail_value',"(現在、オリジナル設定です)");
    }

    $T->parse('output', 'admin');
    $retval .= $T->finish($T->get_var('output'));

    return $retval;

}

// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+
$mode="";
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode'], false);
}

if ((substr($mode,0,3)=="cmd") OR (substr($mode,0,3)=="ALL")){
    if (!SEC_checkToken()){
        COM_accessLog("User {$_USER['username']} tried to illegally and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
        exit;
    }
}

$display = '';
$display .= COM_siteHeader ('menu', $LANG_JPN['pinameadmin']);
if (isset ($_REQUEST['msg'])) {
    $display .= COM_showMessage (COM_applyFilter ($_REQUEST['msg'],
                                                  true), 'japanize');
}

$display.=ppNavbarjp($navbarMenu,$LANG_JPN_admin_menu['1']);

if (substr($mode,0,3)=="cmd") {
    $no=trim($mode,"cmd");
    fncCmdExec($no);

    $url=$_CONF['site_admin_url'] . "/plugins/".THIS_PLUGIN."/".THIS_SCRIPT;
    $url.="?msg={$no}";
    echo COM_refresh($url);

}elseif (substr($mode,0,3)=="ALL") {
    for ($no = 1; $no <= 8; $no++) {
        if ($no<>6){
            fncCmdExec($no);
            $var = 'PLG_japanize_MESSAGE'. $no;
            $display .=$$var."<br>";
        }
    }
    $display .= COM_siteFooter ();
}else{// 初期表示、一覧表示
    $display .=fncEdit();
    $display .= COM_siteFooter ();
}


echo $display;

?>
