<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | 日本語化プラグイン                                                        |
// +---------------------------------------------------------------------------+
// $Id: plugins/japanize/functions.inc
//2008/09/26 08:18 tsuchi AT geeklog DOT jp
//2009/10/13 Ver1.0.5用

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

$pi_name         = 'japanize';

//言語ファイル
$langfile = $_CONF['path'] . "plugins/{$pi_name}/language/"
          . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    require_once ($langfile);
} else {
    require_once ($_CONF['path'] . "plugins/{$pi_name}/language/japanese_utf-8.php");
}

include_once 'version.php';

// 日本語メール
require_once('custom/custom_mail_japanize.php');

// +-----------+
// | 専用関数  |
// +-----------+

/**
* 言語ファイル名を言語IDに変換
*/
function JAPANIZE_languageToLangId($language) {
    $retval = '';
    
    $lang_mappings = array(
        'afrikaans'           => 'af',
        'bosnian'             => 'bs',
        'bulgarian'           => 'bg',
        'catalan'             => 'ca',
        'chinese_simplified'  => 'zh-cn',
        'chinese_traditional' => 'zh',
        'croatian'            => 'hr',
        'czech'               => 'cs',
        'danish'              => 'da',
        'dutch'               => 'nl',
        'english'             => 'en',
        'estonian'            => 'et',
        'farsi'               => 'fa',
        'finnish'             => 'fi',
        'french_canada'       => 'fr-ca',
        'french_france'       => 'fr',
        'german'              => 'de',
        'german_formal'       => 'de',
        'hebrew'              => 'he',
        'hellenic'            => 'el',
        'indonesian'          => '',
        'italian'             => 'it',
        'japanese'            => 'ja',
        'korean'              => 'ko',
        'norwegian'           => 'no',
        'polish'              => 'pl',
        'portuguese'          => 'pt',
        'portuguese_brazil'   => 'pt-br',
        'romanian'            => 'ro',
        'russian'             => 'ru',
        'slovak'              => 'sk',
        'slovenian'           => 'sl',
        'spanish'             => 'es',
        'spanish_argentina'   => 'es',
        'swedish'             => 'sv',
        'turkish'             => 'tr',
        'ukrainian'           => 'uk',
    );
    
    if (isset($language)) {
        $lang = str_replace('_utf-8', '', $language);
        if (isset($lang_mappings[$lang])) {
            $retval = $lang_mappings[$lang];
        }
    }
    
    return $retval;
}

/**
* {html_attribute}に変数をセットする
*/
function JAPANIZE_setHtmlAttribute(&$template) {
    global  $_USER, $_CONF;
    
    $langId = COM_getLanguageId();
    
    if ($langId === '') {
        $langId = JAPANIZE_languageToLangId($_USER['language']);
        if ($langId === '') {
            // try to derive the language id from the locale
            $l = explode('.', $_CONF['locale']); // get rid of character set
            $langId = $l[0];
            $l = explode('@', $langId); // get rid of '@euro', etc.
            $langId = $l[0];
        }
    }
    
    if (!empty($langId)) {
        $l = explode('-', str_replace('_', '-', $langId));
        if ((count($l) === 1) AND (strlen($langId) === 2)) {
            // Do nothing
        } else if (count($l) === 2) {
            if (($l[0] === 'i') OR ($l[0] === 'x')) {
                $langId = implode('-', $l);
            } else if (strlen($l[0]) === 2) {
                $langId = implode('-', $l);
            } else {
                $langId = $l[0];
            }
        }
    }

    switch ($_CONF['doctype']) {
        case 'html401transitional':
        case 'html401strict':
            $html_attribute = ' lang="' . $langId . '"';
            break;

        case 'xhtml10transitional':
        case 'xhtml10strict':
            $html_attribute = ' xml:lang="' . $langId . '" lang="' . $langId . '"';
            break;

        default:
            $html_attribute = ' lang="' . $langId.'"';
            break;
    }
    
    $template->set_var( 'html_attribute', $html_attribute);
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation                                         |
// +---------------------------------------------------------------------------+


// +---------------------------------------------------------------------------+
// | 現在インストールされているバージョン取得                                  |
// | 書式 plugin_chkVersion_japanize                                           |
// +---------------------------------------------------------------------------+
function plugin_chkVersion_japanize ()
{
    global $_JPN_CONF;

    return $_JPN_CONF['version'];
}

// +---------------------------------------------------------------------------+
// | 機能  プラグイン更新:バージョンナンバーの更新                             |
// | 書式 plugin_upgrade_japanize                                              |
// +---------------------------------------------------------------------------+
function plugin_upgrade_japanize ()
{
    global $_TABLES, $_JPN_CONF;

    // the plugin needs these functions so complain when they doesn't exist
    if (!function_exists ('COM_truncate') ||
        !function_exists ('MBYTE_strpos')) {
        return 3002;
    }

    include ('upgrade.inc');        // Include the upgrade functions

    // no db changes - just update the version numbers
    DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_JPN_CONF['version']}', pi_gl_version = '" . VERSION . "' WHERE pi_name = 'japanize'");

    return true;
}

// +---------------------------------------------------------------------------+
// | 機能  プラグインアンインストール    1.5.0用                               |
// | 書式 plugin_getadminoption_japanize                                       |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
function plugin_autouninstall_japanize ()
{
    // (1) 削除するテーブル
    $out['tables']=array();
    // (2) 削除するグループ名
    $out['groups'][]='japanize Admin';
    // (3) 削除するfeatures
    $out['features'][]='japanize.edit';
    $out['features'][]='japanize.moderate';
    $out['features'][]='japanize.submit';
    // (4) 削除するphp_blocks
    $out['php_blocks']=array();
    // (5) 削除する vars */
    $out['vars']=array('japanize_custommail');

    return $out;
}

/**
* ☆★現在のユーザは権利があるのをチェック
*
* @return        boolean       Returns true if moderator
*
*/
function plugin_ismoderator_japanize()
{
    //return SEC_hasRights ('japanize.moderate');
    return true;
}





// +---------------------------------------------------------------------------+
// | 機能  プラグインのアイコン取得                                            |
// | 書式 plugin_geticon_japanize                                              |
// +---------------------------------------------------------------------------+

function plugin_geticon_japanize ()
{
    global $_CONF;

    return $_CONF['site_url'] . '/japanize/images/japanize.png';
}

// +---------------------------------------------------------------------------+
// | 機能  管理画面メニュ                                                      |
// | 書式 plugin_cclabel_japanize                                              |
// +---------------------------------------------------------------------------+
function plugin_cclabel_japanize()
{
    global $_CONF;

    if (SEC_hasRights('japanize.edit')) {
        return array(
            'japanize'
            ,$_CONF['site_admin_url'] . "/plugins/japanize/index.php"
            ,plugin_geticon_japanize ()
            );
    }

    return "";

}

// +---------------------------------------------------------------------------+
// | 機能  管理者メニュ表示 　                                                 |
// | 書式 plugin_getadminoption_japanize                                       |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:管理者メニュリンク                                             |
// +---------------------------------------------------------------------------+
function plugin_getadminoption_japanize()
{
    global $_CONF, $_TABLES;
    global $LANG_JPN;

    if (SEC_hasRights ('japanize.edit') ){
        return array (
                      $LANG_JPN['piname']
                      ,$_CONF['site_admin_url'] . '/plugins/japanize/index.php'
                      );
    }
    return "";

}

// +---------------------------------------------------------------------------+
// | 機能  テンプレート変数設定                                                |
// | 書式 plugin_templatesetvars_japanize                                      |
// +---------------------------------------------------------------------------+
//  2006/10/16 Geeklog Japanese ivy added
//  2007/05/14 Geeklog Japanese kino changed
//  2007.8.26 Ivy added
//  2007/12/22 Geeklog Japanese Ivy changed
//  2008/06/11 Geeklog Japanese Tsuchi modify custom_templatesetvars
function plugin_templatesetvars_japanize($templatename, &$template) {
    global  $LANG01, $LANG_JPN;
    global  $_USER,$_CONF;
    global  $topic;
    global  $page;


    switch ($templatename) {
        case 'header':

            //Frontpageの場合は 'sub' そうでなければ  'home'
            if( COM_isFrontpage() ){
                $home_id='sub';
            } else {
                $home_id='home';
            }

            //ログインしている時
            if (isset($_USER['uid']) && $_USER['uid'] > 1) {
                $login_status='member';
                $prof_url = "{$_CONF['site_url']}/users.php?mode=profile&amp;uid={$_USER['uid']}";
                $welcome_msg_jp = "{$LANG01[67]}";
                $welcome_msg_jp .= ' ' . COM_getDisplayName()." ".$LANG_JPN['keisyo'];
                $memberlogin = "<a href='{$_CONF['site_url']}/users.php?mode=logout' >{$LANG01[19]}</a> ";
            //ログインしていない時
            } else {
                $login_status='guest';
                $prof_url = "{$_CONF['site_url']}/";
                $welcome_msg_jp = "";

                if (file_exists($_CONF['path_layout'] . 'custom-memberlogin.thtml')) {
                    $tmpl = new Template ($_CONF['path_layout']);
                } else {
                    $tmpl = new Template ($_CONF['path'] . "plugins/japanize/templates/");
                }
                $tmpl->set_file(array('member_login' => 'custom-memberlogin.thtml'));
                $tmpl->set_var( 'site_url', $_CONF['site_url']);
                $tmpl->parse ('output', 'member_login');
                $memberlogin = $template->finish ($tmpl->get_var ('output'));

            }

            //記事ID:topic_id
            $template->set_var( 'topic_id', $topic );
            //静的ページID:sp_id
            $template->set_var( 'sp_id', $page );
            //home_id ('home','sub')
            $template->set_var( 'home_id', $home_id );
            //ログイン状態:login_status ('member','guest')
            $template->set_var( 'login_status', $login_status );
            //ようこそメッセージ:welcome_msg_jp
            $template->set_var( 'welcome_msg_jp', $welcome_msg_jp );
            //プロフィールのURL:prof_url_jp
            $template->set_var( 'prof_url_jp', $prof_url );
            //メンバーログイン:memberlogin　(ログインHTML,ログアウトHTML)
            $template->set_var( 'memberlogin', $memberlogin);

            //html_attribute 暫定処置
            JAPANIZE_setHtmlAttribute($template);
    }
}


?>
