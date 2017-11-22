<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'custom_cellular.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Geeklog hack for cellular phones.
 * Copyright (c) 2006 - 2008 Tatsumi Imai(http://im-ltd.ath.cx)
 * License: GPL v2 or later
 * Time-stamp: <2009-03-09 03:13:44 imai>
 *
 * modified by:
 * Yoshinori Tahara - dengen (http://www.trybase.com/~dengen/log/)
 * Time-stamp: <2010-08-19 dengen>
 * 
 * modified by:
 * Sun Ge <2011-04-11>
 * 中国の携帯にも対応するため
 */

// 設定 ////////////////////////////////////////////////

$CUSTOM_MOBILE_CONF['debug'] = false;
$CUSTOM_MOBILE_CONF['use_mobile_content'] = true;   // モバイル用、PC用のコンテンツ変換を行う
$CUSTOM_MOBILE_CONF['force_2g_content'] = false;    // 強制的に2G用コンテンツを表示する
$CUSTOM_MOBILE_CONF['force_wm_as_pc'] = false;      // Windows MobileデバイスをPCとして認識する
$CUSTOM_MOBILE_CONF['force_cut_table'] = true;      // 強制的にテーブルを削除する
$CUSTOM_MOBILE_CONF['cut_comment'] = true;          // コメントを削除する
//$CUSTOM_MOBILE_CONF['convert_to_sjis'] = true;      // SJISに変換する
$CUSTOM_MOBILE_CONF['convert_to_sjis'] = false;      // SJISに変換しない
$CUSTOM_MOBILE_CONF['host_charset'] = "UTF-8";      // サーバはUTF-8
$CUSTOM_MOBILE_CONF['refresh_use_location'] = true; // refreshにLocationヘッダを使用する

/**
 * 画像の縮小用パラメータ
 */
$CUSTOM_MOBILE_CONF['resize_image'] = true;
$CUSTOM_MOBILE_CONF['image_size'] = 160;      // 縦または横の最大値
$CUSTOM_MOBILE_CONF['image_quality'] = 60;    // jpegの変換品質
$CUSTOM_MOBILE_CONF['image_quality_png'] = 9; // pngの変換品質

/**
 * 表示する記事の数(データ量制限のため)
 */
$CUSTOM_MOBILE_CONF['max_stories'] = 3;

/**
 * start_session()がコールされるたびにgc_probability/gc_divisorの確率で
 * gc_maxlifetimeを過ぎたセッションを破棄する。
 */
$CUSTOM_MOBILE_CONF['gc_maxlifetime'] = 1440; //
$CUSTOM_MOBILE_CONF['gc_probability'] = "1";  //
$CUSTOM_MOBILE_CONF['gc_divisor'] = "10";     //

$CUSTOM_MOBILE_CONF['force_use_html'] = false;          // 強制的にHTMLで表示する
//$CUSTOM_MOBILE_CONF['force_use_html'] = true;          // 強制的にHTMLで表示する
$CUSTOM_MOBILE_CONF['force_use_html_wm_opera'] = true;  // Windows MobileのOperaでは、強制的にHTMLで表示する
//$CUSTOM_MOBILE_CONF['use_hankaku_kana'] = true;         // <kana></kana>の全角カタカナを半角に置き換える
$CUSTOM_MOBILE_CONF['use_hankaku_kana'] = false;         // <kana></kana>の全角カタカナを半角に置き換えない
$CUSTOM_MOBILE_CONF['use_iphone_theme'] = false;        // iPhoneまたはiPodの専用テーマを使用する。（まだ無効）

// 設定はここまで //////////////////////////////////////

$CUSTOM_MOBILE_UA = 0;
$CUSTOM_MOBILE_UA_WMOPERA = 0; // Windows MobileのOperaか
$CUSTOM_MOBILE_UA_IPHONE = 0;  // iPhoneまたはiPodか

define("MOBILE_3G", 16);
define("MOBILE_UA_NOT_CELLULAR", 0);
define("MOBILE_UA_OTHER", 1);
define("MOBILE_UA_DOCOMO", 2);
define("MOBILE_UA_AU", 3);
define("MOBILE_UA_SOFTBANK", 4);
define("MOBILE_UA_WILCOM", 5);
define("MOBILE_UA_WM", 6);

define("MOBILE_UA_OTHER_3G", 17);    // MOBILE_3G + 1
define("MOBILE_UA_DOCOMO_3G", 18);   // MOBILE_3G + 2
define("MOBILE_UA_AU_3G", 19);       // MOBILE_3G + 3
define("MOBILE_UA_SOFTBANK_3G", 20); // MOBILE_3G + 4
define("MOBILE_UA_WILCOM_3G", 21);   // MOBILE_3G + 5
define("MOBILE_UA_WM_3G", 22);       // MOBILE_3G + 6

// 補助URL
define("RESIZER", "/imageresizer.php");
define("BLOCKS", $_CONF['site_url'] . "/mobileblocks.php");

define("IPHONE_THEME", 'mobile_iphone');

// ケータイ用テーマの設定
if (is_dir($_CONF['path_html'] . 'layout/mobile_xhtml')) {
    $CUSTOM_MOBILE_CONF['theme_html']  = 'mobile_xhtml';
    $CUSTOM_MOBILE_CONF['theme_xhtml'] = 'mobile_xhtml';
} else {
    $CUSTOM_MOBILE_CONF['theme_html']  = 'mobile';
    $CUSTOM_MOBILE_CONF['theme_xhtml'] = 'mobile';
    if (is_dir($_CONF['path_html'] . 'layout/mobile_3g')) {
        $CUSTOM_MOBILE_CONF['theme_xhtml'] = 'mobile_3g';
    }
}

// ユーザエージェントを解析して端末のタイプを判定する
function _mobile_parse_ua()
{
    global $CUSTOM_MOBILE_UA, $CUSTOM_MOBILE_CONF,
           $CUSTOM_MOBILE_UA_WMOPERA, $CUSTOM_MOBILE_UA_IPHONE;

    $agent = $_SERVER["HTTP_USER_AGENT"];

    /**
     * ケータイの判定基準を変えるには以下のif文を修正する
     */
    if(preg_match("/^(DoCoMo\/1|DoCoMo\/2)\.0/i", $agent)) {
        // DoCoMo
        $CUSTOM_MOBILE_UA = MOBILE_UA_DOCOMO;
    } else if(preg_match("/^(Softbank|J\-PHONE|Vodafone|MOT\-[CV]|Semulator)/i", $agent)) {
        // SoftBank
        $CUSTOM_MOBILE_UA = MOBILE_UA_SOFTBANK;
    } else if(preg_match("/(UP\.Browser|KDDI\-)/i", $agent)) {
        // AU
        $CUSTOM_MOBILE_UA = MOBILE_UA_AU;
    } else if(preg_match("/(DDIPOCKET|WILLCOM)/i", $agent)) {
        // Wilcom
        $CUSTOM_MOBILE_UA = MOBILE_UA_WILCOM;
    } else if(preg_match("/Windows *CE/i", $agent) ||
              preg_match("/Nokia/i", $agent) ||
              preg_match("/^$/", $agent) ||
              preg_match("/SHARP/i", $agent) ||
              preg_match("/MOT-/i", $agent) ||
              preg_match("/LG[\-\/]/", $agent) ||
              preg_match("/Opera Mini/i", $agent) ||
              preg_match("/MIDP-/i", $agent) ||
              preg_match("/UCWEB/i", $agent) ||
	      preg_match("/mobile/i", $agent) ||
              preg_match("/jigbrowserweb/i", $agent) ||
              preg_match("/NetFront/i", $agent) ||
              preg_match("/(Y!J-SRD\/1.0|Y!J-MBS\/1.0)/i", $agent)) {
        // その他ケータイと判定するもの
        $CUSTOM_MOBILE_UA = MOBILE_UA_OTHER;

        // Opera mobile の判定
        //if (preg_match("/Opera/i", $agent)) {
	if (preg_match("/Opera Mobile/i", $agent)) {
            $CUSTOM_MOBILE_UA_WMOPERA = 1;
        }
    } else if(preg_match("/(iPhone|iPod)/i", $agent)) {
        // iPhone または iPod
        $CUSTOM_MOBILE_UA = MOBILE_UA_NOT_CELLULAR;
        if ($CUSTOM_MOBILE_CONF['use_iphone_theme']) {
            $CUSTOM_MOBILE_UA = MOBILE_UA_OTHER;
            $CUSTOM_MOBILE_UA_IPHONE = 1;
        }
    } else {
        $CUSTOM_MOBILE_UA = MOBILE_UA_NOT_CELLULAR;
    }

    if($CUSTOM_MOBILE_UA > MOBILE_UA_NOT_CELLULAR) {
        // 3Gかどうかの判定
        /**
         * ここで3Gとは以下のものを示す。
         * DoCoMo: FOMAでHTML5.0以上
         * AU: WAP2.0対応
         * SoftBank: SoftBank 3Gシリーズ
         * その他: Windows Mobile, PDAのNetFront
         */
        if(preg_match("/Windows *CE/i", $agent) ||
           preg_match("/.*PDA;.*NetFront/i", $agent)){
            if($CUSTOM_MOBILE_CONF['force_wm_as_pc']) {
                $CUSTOM_MOBILE_UA = MOBILE_UA_NOT_CELLULAR;
            } else {
                $CUSTOM_MOBILE_UA = MOBILE_UA_WM_3G;
            }
        } else if (preg_match("/^DoCoMo\/2.0/i", $agent) ||
           preg_match("/^(Softbank|Vodafone|MOT\-[CV]|Semulator)/i", $agent) ||
           preg_match("/^KDDI\-/i", $agent)
           ) {
            $CUSTOM_MOBILE_UA = $CUSTOM_MOBILE_UA + MOBILE_3G;
        }
    }
    CUSTOM_MOBILE_debug("User Agent: " . $_SERVER["HTTP_USER_AGENT"]);
    CUSTOM_MOBILE_debug("CUSTOM_MOBILE_UA: $CUSTOM_MOBILE_UA");
}

// ユーザエージェントからケータイかどうか判定する
function CUSTOM_MOBILE_is_cellular()
{
    global $CUSTOM_MOBILE_UA;
    return ($CUSTOM_MOBILE_UA > MOBILE_UA_NOT_CELLULAR);
}

// ユーザエージェントから3G端末かどうか判定する
function CUSTOM_MOBILE_is_3g()
{
    global $CUSTOM_MOBILE_UA;
    return ($CUSTOM_MOBILE_UA > MOBILE_3G);
}

// テーブルが使える端末か判定する
function CUSTOM_MOBILE_is_table_enabled()
{
    global $CUSTOM_MOBILE_UA, $CUSTOM_MOBILE_UA_IPHONE;
    /**
     * ここでは以下のものをテーブルが使える端末と判定する
     * AUまたはSoftBankで3Gのもの
     * Wiondows Mobile
     * iPhone|iPod
     */
    return (
            $CUSTOM_MOBILE_UA == MOBILE_UA_OTHER_3G ||
            $CUSTOM_MOBILE_UA == MOBILE_UA_AU_3G ||
            $CUSTOM_MOBILE_UA == MOBILE_UA_SOFTBANK_3G ||
            $CUSTOM_MOBILE_UA_IPHONE == 1
            );
}

// GeeklogのセッションIDとIPアドレスをケータイ用のセッションに保存する
function CUSTOM_MOBILE_save_session($sessid, $remote_ip)
{
    global $CUSTOM_MOBILE_CONF;

    CUSTOM_MOBILE_debug("*** in CUSTOM_MOBILE_save_session");
    _mobile_session_check();
    CUSTOM_MOBILE_debug("SID: " . SID);
    if(SID != '' || SID != 'SID') {
        // $sessidをPHPのセッション変数に格納する
        $_SESSION['mobile_sid'] = $sessid;
        $_SESSION['remote_ip'] = $remote_ip;
        CUSTOM_MOBILE_debug("save sessid and remote_ip to mobile session: " . $sessid . ", " . $remote_ip);
    }
    CUSTOM_MOBILE_debug("*** leaving CUSTOM_MOBILE_save_session");
}

// ケータイ用のセッションをチェックし、必要に応じて初期化する
function _mobile_session_check()
{
    CUSTOM_MOBILE_debug("*** in session_check");
    session_start();
    CUSTOM_MOBILE_debug("SID: ". SID);
    // 端末から送られたセッションIDの正当性をチェックする
    if (!isset($_SESSION['_SESSION_CHECK'])) {
        // 正当なIDでなければ送られてきたセッションを破壊し、初期化する
        session_destroy();
        session_start();
        session_regenerate_id();
        CUSTOM_MOBILE_debug("new session created");
        CUSTOM_MOBILE_debug("SID: ". SID);
        // 正当性の保証として現在時刻を保存する
        $_SESSION['_SESSION_CHECK'] = time();
    }
    CUSTOM_MOBILE_debug("*** leaving session_check");
}

// ケータイ用セッションからGeeklogのセッションIDを読み出す
function CUSTOM_MOBILE_load_session()
{
    global $CUSTOM_MOBILE_CONF;

    CUSTOM_MOBILE_debug("*** in CUSTOM_MOBILE_load_session");
    CUSTOM_MOBILE_debug("SID: " . SID);
    $ret = null;
    if (! isset ($_COOKIE[$_CONF['cookie_session']])) {
        // Cookieにsession IDが設定されていない
        CUSTOM_MOBILE_debug("no session id found in cookie");
        CUSTOM_MOBILE_debug("session id: " . $_SESSION['mobile_sid']);
        if ( isset ($_SESSION['mobile_sid'])) {
            // ケータイセッションIDがPHPのセッション変数にセットされている
            CUSTOM_MOBILE_debug("session id found in mobile session: " .
                $_SESSION['mobile_sid']);
            $ret = $_SESSION['mobile_sid'];
        }
    }
    CUSTOM_MOBILE_debug("*** leaving CUSTOM_MOBILE_load_session");
    return $ret;
}

// ケータイ用セッションから接続時のIPアドレスを読み出す
function CUSTOM_MOBILE_load_ip()
{
    global $CUSTOM_MOBILE_CONF;

    CUSTOM_MOBILE_debug("*** in CUSTOM_MOBILE_load_ip");
    CUSTOM_MOBILE_debug("SID: " . SID);
    $ret = null;
    if ( isset ($_SESSION['remote_ip'])) {
        // IPがPHPのセッション変数にセットされている
        CUSTOM_MOBILE_debug("remote ip found in mobile session: " . $_SESSION['remote_ip']);
        $ret = $_SESSION['remote_ip'];
    }
    CUSTOM_MOBILE_debug("*** leaving CUSTOM_MOBILE_load_ip");
    return $ret;
}

// ケータイ用セッションを削除する(ログアウト時)
function CUSTOM_MOBILE_remove_session()
{
    $_old_session_id = session_id();
    $_SESSION = array();
    session_destroy();
    session_start();
    session_regenerate_id();
    $_old_session_file = session_save_path() . '/sess_' . $_old_session_id;
    if (file_exists($_old_session_file)) {
        //unlink($_old_session_file);
    }
}

// デバッグメッセージをerror.logに出力する
function CUSTOM_MOBILE_debug($msg)
{
    global $CUSTOM_MOBILE_CONF;

    if($CUSTOM_MOBILE_CONF['debug']) {
        COM_ErrorLog($msg,1);
    }
}

// iモードや他の多くの端末は'<meta http-equiv="refresh"... を正しく扱えない。
// そこでlib-commonのCOM_refresh()をハックする。
function CUSTOM_refresh($url)
{
    global $LANG05,$CUSTOM_MOBILE_CONF;
    if(CUSTOM_MOBILE_is_cellular()) {
        // ページ内リンクを探す
        $pos = strpos($url, '#');
        if($pos === false) {
            //CUSTOM_MOBILE_debug("not matched: " . $url);
            $link = "";
        } else {
            //CUSTOM_MOBILE_debug("matched: " . $url);
            $link = substr($url, $pos);
            $url = substr($url, 0, $pos);
        }
        if($CUSTOM_MOBILE_CONF['refresh_use_location']) {
            $sepa = '?';
            if (strpos($url, '?') > 0)
            {
                // 2009-02-19 Kunitsuji update
                $sepa = '&';
                //$sepa = '&amp;';
            }
	    //the following line will fix the mobile phone post error problem
	    //see http://code.google.com/p/geeklog-jp/source/detail?r=2527
	    //for details.
	    $url = str_replace('&amp;', '&', $url);
            $location_url = 'Location: ' . $url . $sepa . SID . $link;
            header( $location_url );
            exit;
        } else {
	  //$msg = mb_convert_encoding($LANG05['5'], 'sjis-win',
	  //                   mb_detect_encoding($LANG05['5'], "UTF-8,EUC-JP,JIS,sjis-win"));
	    $msg = $LANG05['5'];
            $sepa = '?';
            if (strpos($url, '?') > 0) {
                $sepa = '&amp;';
            }
            $location_url = $url . $sepa . SID . $link;
            return "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"" .
                "\"http://www.w3.org/TR/html4/loose.dtd\">\n" .
                "<html><head><title>$msg</title></head>" .
                "<body><a href=\"$location_url\">$msg</a></body></html>\n";
        }
    } else {
        return "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
    }
}

// ケータイ用のアウトプットハンドラ
function _mobile_output_handler($content, $status)
{
    global $CUSTOM_MOBILE_CONF, $CUSTOM_MOBILE_UA_WMOPERA;

    // テーブル削除用のパターン配列
    $_mobile_table = array (
        '@<\s*table[^>]*?>@si'  => '',
        '@<\s*/table[^>]*?>@si' => '',
        '@<\s*thead[^>]*?>@si'  => '',
        '@<\s*/thead[^>]*?>@si' => '',
        '@<\s*tbody[^>]*?>@si'  => '',
        '@<\s*/tbody[^>]*?>@si' => '',
        '@<\s*tfoot[^>]*?>@si'  => '',
        '@<\s*/tfoot[^>]*?>@si' => '',
        '@<\s*tr[^>]*?>@si'     => '',
        '@<\s*/tr[^>]*?>@si'    => '<br>',
        '@<\s*th[^>]*?>@si'     => '',
        '@<\s*/th[^>]*?>@si'    => '&nbsp;',
        '@<\s*td[^>]*?>@si'     => '',
        '@<\s*/td[^>]*?>@si'    => '&nbsp;',
    );

    // コメント削除用のパターン配列
    $_mobile_comment = array (
        '@<!--.*?-->@sm' => '',
        '@<!--@'         => '',
        '@-->@'          => '',
    );

    // 3Gケータイ専用コンテンツのパターン配列
    $_mobile_3g = array (
        // cut "div"
        '@<\s*div[^>]*?>@si'        => '',
        '@<\s*/div[^>]*?>@si'       => "<br>\n",
        // cut style
        '@style="[^"].*?"@i'        => '',
        // cut class
        '@class="[^"].*?"@i'        => '',
        // cut embed
        '@<embed[^>]*?></embed>@si' => '',
    );


    // ケータイ専用コンテンツのパターン配列
    $_mobile_content = array (
        '@<!--mobile_only@' => '',
        '@/mobile_only-->@' => '',
        '@<!--not_for_mobile-->.*?<!--/not_for_mobile-->@ms' => '',
    );

    // 画像タグのパターン配列
    $_mobile_images = array (
        '@<(\s*img.*?)width="[0-9]+?"([^>]*?)>@si'  => '<$1$2>',
        '@<(\s*img.*?)height="[0-9]+?"([^>]*?)>@si' => '<$1$2>',
    );

    if ($CUSTOM_MOBILE_UA_WMOPERA && $CUSTOM_MOBILE_CONF['force_use_html_wm_opera']) {
        // Windows Mobile の Opera で 強制的にHTMLを使う
        $CUSTOM_MOBILE_CONF['force_use_html'] = false;
    }

    if ($CUSTOM_MOBILE_CONF['theme_xhtml'] == 'mobile_xhtml' || $CUSTOM_MOBILE_CONF['theme_html'] == 'mobile_xhtml') {

        if ($CUSTOM_MOBILE_CONF['use_appl_xhtml'] && !$CUSTOM_MOBILE_CONF['force_use_html']) {
            $_mobile_content['@\<!--mobile_doctype--\>@'] = 
                             '<?xml version="1.0" encoding="UTF-8"?>' . LB
                           . '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" '
                           . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

            $_mobile_content['@\<!--mobile_html--\>@'] = 
                             '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">';
            
            $_mobile_content['@\<!--mobile_content_type--\>@'] = 
                             '<meta http-equiv="Content-Type" content="'
                           . 'application/xhtml+xml; charset=UTF-8" />';
        } else {
            $_mobile_content['@\<!--mobile_doctype--\>@'] = 
                             '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" '
                           . '"http://www.w3.org/TR/html4/loose.dtd">';

            $_mobile_content['@\<!--mobile_html--\>@'] = 
                             '<html lang="en">';

            $_mobile_content['@\<!--mobile_content_type--\>@'] = 
                             '<meta http-equiv="Content-Type" content="'
                                             . 'text/html; charset=UTF-8">';
        }
    }


    // モバイル用のコンテンツを表示、PC用のコンテンツを非表示
    // これは単独で一番先に実行する必要がある
    if ($CUSTOM_MOBILE_CONF['use_mobile_content']) {
        $content = preg_replace(
            array_keys($_mobile_content), array_values($_mobile_content), $content
        );
    }
    // コメントを削除
    // これは単独で2番目に実行する必要がある
    if ($CUSTOM_MOBILE_CONF['cut_comment']) {
        $content = preg_replace(
            array_keys($_mobile_comment), array_values($_mobile_comment), $content
        );
    }

    // テーブルを削除
    if ($CUSTOM_MOBILE_CONF['force_2g_content'] ||
       $CUSTOM_MOBILE_CONF['force_cut_table'] ||
       !CUSTOM_MOBILE_is_table_enabled()) {
        $content = preg_replace(
            array_keys($_mobile_table), array_values($_mobile_table), $content
        );
    }

    // 3G端末用コンテンツを削除
    if ($CUSTOM_MOBILE_CONF['force_2g_content']) {
        $content = preg_replace(
            array_keys($_mobile_3g), array_values($_mobile_3g), $content
        );
    }

    // 画像の縮小
    if ($CUSTOM_MOBILE_CONF['resize_image']) {
        //CUSTOM_MOBILE_debug("search: " . $_mobile_images[0][0]);
        $content = preg_replace(
            array_keys($_mobile_images), array_values($_mobile_images), $content
        );
        $content = preg_replace_callback('@<(\s*img.*?)src="([^"]*?)"([^>]*?)>@si',
                       'convert_images', $content);
    }

    // その他雑多な変換
    if ($CUSTOM_MOBILE_CONF['convert_to_sjis']) {
        $charset ='Shift_JIS';
    } else {
        $charset = $CUSTOM_MOBILE_CONF['host_charset'];
    }

    $search =
        array(// topic icon
              '@(<img .+?src=.+?/images/topics/.+? alt=")(.+?)"[^>]*?>@i',
              // charset
              '@charset=' . $CUSTOM_MOBILE_CONF['host_charset'] . '@i',
              // for phones can't treat ' />' xhtml notation
              //'@ */>@i',
              // cut script
              '@<script[^>]*?>.*?</script>@si',
              // 変換の結果生じた無駄なタグの削除
              '@<div>[\s\n]*</div>@i',
              '@<dt></dt>@i',
              '@<dd></dd>@i',
              '@<li></li>@i',
              '@^\s*<dl>([\s\n]*)</dl>@mi',
              '@^\s*<li>([\s\n]*)</li>@mi',
              '@\s*?&nbsp;@',
              '@\s*\n+@m',
//              '@((\s)*<br>)+@sm',
              '@^(\s)*<br>((\s)*<br>)+@sm',
              '@[^\s]+\s*<br>((\s)*<br>)+$@sm',
              '@<(input|meta|img|link|br|hr|area)([^>]*)(\s*/>)@mi',
              );

    $replace=
        array(// topic icon
              '$2',
              // charset
              'charset='. $charset,
              // for phones can't treat ' />' xhtml notation
              //'>',
              '',
              // 変換の結果生じた無駄なタグの削除
              '',
              '',
              '',
              '',
              '',
              '',
              '',
              "\n",
//              '<br' . XHTML . '>',
              '<br>',
              '<br><br>',
              '<' . strtolower('$1') . trim('$2') . '>',
              );

    if ($CUSTOM_MOBILE_CONF['use_appl_xhtml'] && !$CUSTOM_MOBILE_CONF['force_use_html']) {
        $search = array_merge($search, 
            array(
                  '@<(input|meta|img|link|br|hr|area)([^>]*)(\s*>(?!>))@mi',
                 )
        );

        $replace = array_merge($replace, 
            array(
                  '<' . strtolower('$1') . trim('$2') . XHTML . '>',
                 )
        );
    }

    $content = preg_replace($search, $replace, $content);

    if ($CUSTOM_MOBILE_CONF['theme_xhtml'] == 'mobile_xhtml' || $CUSTOM_MOBILE_CONF['theme_html'] == 'mobile_xhtml') {
        $search = array(
              '@<h1[^>]*>@i',
              '@</h1>@i',
              '@<h2[^>]*>@i',
              '@</h2>@i',
              '@<h3[^>]*>@i',
              '@</h3>@i',
              '@<div class="mobile_titlebar">(.+?)</div>@i',

              '@<ul([^>]*)>@i',
              '@<hr[^>]*>@i',
              '@\s+\(@i',
              '@\(N/A\)@i',
              '@<input type="checkbox" name="features\[\]" value="(.+?)"[^>]*?>@i', // グループの編集 - 権限 を整列させる
              '@<input type="file" dir="ltr" name="plugin" size="40"[^>]*?>@i', // プラグイン管理 - プラグインアップロードパスの入力フォーム
              
              '@<div>□<a href=".+(admin/configuration\.php|docs/japanese/index\.html|versionchecker\.php|/admin/plugins/dataproxy/index\.php).*">.*</a>\(.+\)</div>@',

              '@<img.*?usemap=[^>]*?><map[^>]*?>.*?</map>@i', // ブロックリストの画像によるフォーム
              '@<input type="checkbox" name="enabledblocks\[[^>]*?><input.*?_glsectoken[^>]*?>@si', // ブロックリストのチェックボックス
              '@<input type="checkbox" name="enabledfeeds\[[^>]*?><input.*?_glsectoken[^>]*?>@si',  // フィードリストのチェックボックス
              '@<input type="checkbox" name="enabledplugins\[[^>]*?><input.*?_glsectoken[^>]*?>@si',  // プラグインリストのチェックボックス
              '@<input type="checkbox" name="tagenable[^>]*?><input.*?name="tagChange"[^>]*?>@si',  // Autotagリストのチェックボックス

              '@<textarea name="replacement" cols="75" rows="5" wrap="virtual"[^>]*?>@si', // Autotagエディタのテキストエリア
              '@<textarea name="sp_content" style="([^"]*)"([^>]*?)>@si', // 静的ページのテキストエリア
              '@<p>请将附加的图像以自动标签标记。请仅在.*?的情况下点击。</p>@',

              '@<form(.+?)style="display:inline; float:right"([^>]*?)>@si', // 記事一覧
              '@<select name="topic" onchange="this.form.submit\(\)">(.*?)</select>@si', // 記事一覧

              '@<a href="([^"]*)">(次页|Next)</a>@si',
              '@<div class="pluginRow1" style="([^"]*)">@si', // 掲示板
              '@<div class="pluginRow2" style="([^"]*)">@si', // 掲示板
              '@<div class="pluginRow1">@si', // 掲示板
              '@<div class="pluginRow2">@si', // 掲示板
              '@<div><a href="([^"]*)" class="story-read-more-link">显示全文</a>\(.+ 词\) </div>@',
              '@\s*\|\s*@i',
              '@(\|)+@i',
              '@>\|</@',
              );

        $replace= array(
              '<div style="font-size:small; background-color:#ccf;"><b>',
              '</b></div>',
              '<div style="font-size:small; background-color:#ccf;"><b>',
              '</b></div>',
              '<div style="font-size:small; background-color:#ccf;"><b>',
              '</b></div>',
              '<div style="font-size:small; background-color:#ccf;">$1</div>',

              '<ul $1 style="padding-left:20px">',
              '<hr size="1" style="color:#ccc"' . XHTML . '>',
              '(',
              '(-)',
              '<br' . XHTML . '><input type="checkbox" name="features[]" value="$1"' . XHTML . '>',
              '<br' . XHTML . '><input type="file" dir="ltr" name="plugin" size="20"' . XHTML . '>',
              
              '',

              '',
              '',
              '',
              '',
              '',
              '<textarea name="replacement" cols="75" rows="5" wrap="virtual" style="width:95%">', // Autotagエディタのテキストエリア
              '<textarea name="sp_content" style="$1;width:95%"$2>', // 静的ページのテキストエリア
              '<p>格式为<br'.XHTML.'>[imageX]、<br'.XHTML.'>[imageX_right]、<br'.XHTML.'>[imageX_left]<br'.XHTML.'>（X为附加的图像的编号）</p>',

              '<form$1$2>', // 記事一覧
              '<select name="topic">$1</select><input type="submit" value="执行"'.XHTML.'>', // 記事一覧

              '<a href="$1" accesskey="#">$2(#)</a>',
              '<div class="pluginRow1" style="$1;background-color:#f7f7f7;">', // 掲示板
              '<div class="pluginRow2" style="$1;background-color:#e7e7e7;">', // 掲示板
              '<div class="pluginRow1" style="background-color:#f7f7f7;">', // 掲示板
              '<div class="pluginRow2" style="background-color:#e7e7e7;">', // 掲示板
              '<div>[<a href="$1" class="story-read-more-link">显示全文</a>]</div>',
              '|',
              '|',
              '></',
              );
        $content = preg_replace($search, $replace, $content);
    }

    // セッションIDの埋め込み
    if(SID != '' || SID != 'SID') {
        // Cookieが使える場合はSIDに''が設定されるため、埋め込みを行わない
        CUSTOM_MOBILE_debug("SID: " . SID);
        $content = _mobile_add_sessid($content);
    }

    //$content = mb_convert_encoding($content, 'sjis-win', mb_detect_encoding($content));
    //$content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content));
    
    if ($CUSTOM_MOBILE_CONF['theme_xhtml'] == 'mobile_xhtml' || $CUSTOM_MOBILE_CONF['theme_html'] == 'mobile_xhtml') {
        // パターン'[emoji:x]'を絵文字に置き換える。(暫定)
        $content = preg_replace_callback('@\[emoji:(.+?)\]@i',
                       create_function('$matches', 'return emoji($matches[1]);'), $content);

        // テキスト入力フォームのサイズを調節する
        $content = preg_replace_callback('@<input(.+?)type="text"(.+?)size="([^"]*?)"([^>]*?)>@si',
                       'convert_inputtextform', $content);

        // 全角カタカナを半角カタカナに置き換える
        if ($CUSTOM_MOBILE_CONF['use_hankaku_kana']) {
            $content = preg_replace_callback('@<kana>(.*?)</kana>@ms',
                           'convert_kana', $content);
        }
    }

    if ($CUSTOM_MOBILE_CONF['use_appl_xhtml'] && !$CUSTOM_MOBILE_CONF['force_use_html']) {
      //header('Content-Type: application/xhtml+xml; charset=Shift_JIS');
        header('Content-Type: application/xhtml+xml; charset=utf-8');
    } else {
      //header('Content-Type: application/xhtml+xml; charset=Shift_JIS');
        header('Content-Type: text/html; charset=utf-8');
    }

    return $content;
}

// iphone用のアウトプットハンドラ
function _iphone_output_handler($content, $status)
{
    // 今のところ何も工夫なし
    return $content;
}

// ページ内のURIにセッションIDを付加する
function _mobile_add_sessid($content)
{
    global $_CONF;

    // ページ内の<a>タグ、<form>タグのurlを抽出
    $pat1 = '!(<a\s+.*?href=)([\'"])([^\2]*?)(\2)!i';
    $pat2 = '!(<form\s+.*?action=)([\'"])([^\2]*?)(\2)!i';
    $search = array($pat1, $pat2,);
    // コールバック関数に渡してセッションIDを追加する
    return preg_replace_callback($search, _mobile_session_callback, $content);
}

// ページ内のURIにセッションIDを付加するためのコールバック関数
function _mobile_session_callback($matches)
{
    global $_CONF;
    $pat = $_CONF['site_url'];
    $ret = substr($matches[0], 0, -1);
    $delim = substr($matches[0], -1);

    // forumのバグ? cf: forum/createtopic.php line 342 & forum/viewtopic.php line 100.
    $ret = preg_replace('!true#\d+!', 'true', $ret);

    if(preg_match("!https*?:\/\/!", $ret)) {
        // 絶対アドレス
        if(!preg_match("!$pat!", $ret)) {
            // 外部サイトだったらそのまま返す
            return $ret . $delim;
        } else {
            ; // 自サイト
        }
    } else if(preg_match("![a-z]+:.+!", $ret)){
        // http以外のプロトコル
        return $ret . $delim;
    } else {
        ; // 相対アドレス
    }
    // ページ内リンクを探す
    $pos = strpos($ret, '#');
    if($pos === false) {
        //CUSTOM_MOBILE_debug("not matched: " . $ret);
        $link = "";
    } else {
        //CUSTOM_MOBILE_debug("matched: " . $ret);
        $link = substr($ret, $pos);
        $ret = substr($ret, 0, $pos);
    }
    // Softbank対応
    // Softbank(Vodafone)のアクセスポイントはpid, sid, uidなどを正しく扱わない。
    // そのためこれらをURLエンコードする。
    $search = array(
                    '@pid=@i',
                    '@sid=@i',
                    '@uid=@i',
                    );
    $replace = array(
                     '%70%69%64=',//pid
                     '%73%69%64=',//sid
                     '%75%69%64=',//uid
                     );
    $ret = preg_replace($search, $replace, $ret);

    // URLクエリのセパレータ
    $sep = strpos($ret, '?')?'&amp;':'?';
    // SIDを追加する
    $ret = $ret . $sep . htmlspecialchars(SID) . $link . $delim;
    //CUSTOM_MOBILE_debug("sid added: " . $ret);
    return $ret;
}

// stripslashes（配列対応版）
function _mobile_stripslashes_deep($data)
{
    if (is_array($data)) {
        return array_map('_mobile_stripslashes_deep', $data);
    } else {
        return stripslashes($data);
    }
}

// urldecode（配列対応版）
function _mobile_urldecode_deep($data)
{
    if (is_array($data)) {
        return array_map('_mobile_urldecode_deep', $data);
    } else {
        return urldecode($data);
    }
}

// 入力をURLデコードする
function _mobile_prepare_input(&$array)
{
    reset($array);
    $copy = $array;
    while (list($key, $val) = each($copy)) {
        if (get_magic_quotes_gpc()) {
            $key = _mobile_stripslashes_deep($key);
            $val = _mobile_stripslashes_deep($val);
        }
        $keyconv = urldecode($key);
        if( $key != $keyconv ) {
            unset($array[$key]);
        }
        $array[$keyconv] = _mobile_urldecode_deep($val);
    }
    reset($array);
}

// ブロック一覧の取得
function CUSTOM_MOBILE_getBlocks($side = 'left')
{
    global $_CONF, $_TABLES, $_USER, $LANG21, $topic, $page;

    $retval = '';

    // Get user preferences on blocks
    if( !isset( $_USER['noboxes'] ) || !isset( $_USER['boxes'] ))
    {
        if( !empty( $_USER['uid'] ))
        {
            $result = DB_query( "SELECT boxes,noboxes FROM {$_TABLES['userindex']} "
                               ."WHERE uid = '{$_USER['uid']}'" );
            list($_USER['boxes'], $_USER['noboxes']) = DB_fetchArray( $result );
        }
        else
        {
            $_USER['boxes'] = '';
            $_USER['noboxes'] = 0;
        }
    }

    $sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) AS date "
         . "FROM {$_TABLES['blocks']} WHERE is_enabled = 1";

    if( $side == 'left' )
    {
        $sql .= " AND onleft = 1";
    }
    else
    {
        $sql .= " AND onleft = 0";
    }

    if( !empty( $_USER['boxes'] ))
    {
        $BOXES = str_replace( ' ', ',', $_USER['boxes'] );

        $sql .= " AND (bid NOT IN ($BOXES) OR bid = '-1')";
    }

    $sql .= ' ORDER BY blockorder,title asc';

    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    // convert result set to an array of associated arrays
    $blocks = array();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $blocks[] = DB_fetchArray( $result );
    }

    // sort the resulting array by block order
    $column = 'blockorder';
    $sortedBlocks = $blocks;
    for( $i = 0; $i < sizeof( $sortedBlocks ) - 1; $i++ )
    {
        for( $j = 0; $j < sizeof( $sortedBlocks ) - 1 - $i; $j++ )
        {
            if( $sortedBlocks[$j][$column] > $sortedBlocks[$j+1][$column] )
            {
                $tmp = $sortedBlocks[$j];
                $sortedBlocks[$j] = $sortedBlocks[$j + 1];
                $sortedBlocks[$j + 1] = $tmp;
            }
        }
    }
    $blocks = $sortedBlocks;
    return $blocks;
}

// ブロックのアクセス権をチェックする
function block_hasAccess($A)
{
    if ( $A['type'] != 'dynamic' and
        SEC_hasAccess( $A['owner_id'], $A['group_id'], $A['perm_owner'],
                       $A['perm_group'], $A['perm_members'], $A['perm_anon'] ) == 0 ) {
        return false;
    }

    if ($A['name'] == 'user_block') {
        if (COM_isAnonUser()) {
            return false;
        }
    }
    
    if ($A['name'] == 'admin_block') {
        if (COM_isAnonUser()) {
            return false;
        }
        $plugin_options = PLG_getAdminOptions();
        $num_plugins = count( $plugin_options );
        if ( SEC_isModerator() 
             OR SEC_hasRights( 'story.edit,block.edit,topic.edit,user.edit,plugin.edit,user.mail,syndication.edit', 'OR' )
             OR ( $num_plugins > 0 )) {
            return true;
        } else {
            return false;
        }
    }
    
    return true;
}

// ブロックメニューの表示
function CUSTOM_MOBILE_blockMenu()
{
    $blockmenu .= "<h2 style=\"font-size:medium\">子菜单</h2>\n";
    $b = CUSTOM_MOBILE_getBlocks();
    $rb = CUSTOM_MOBILE_getBlocks('right');
    $b = array_merge($b, $rb);
    foreach($b as $A) {
        if (block_hasAccess($A)) {
            $blockmenu .= "<div>□<a href=\"" . BLOCKS . "?bid=". $A['bid'] . "\">" . $A['title'] . "</a></div>\n";
        }
    }
    $blockmenu .= '<hr'. XHTML . '>' . LB;
    return $blockmenu;
}


// ブロックの取得
function CUSTOM_MOBILE_getBlock($bid)
{
    global $_CONF, $_TABLES, $_USER, $LANG21;

    if(empty($bid)) {
        return NULL;
    }
    $sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) AS date "
        . "FROM {$_TABLES['blocks']} WHERE is_enabled = 1 "
        . "AND bid = {$bid}";
    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );
    if($nrows == 0) {
        exit("no block found.");
    } else if($nrows > 1) {
        exit("2 or more blocks found.");
    }
    $block = DB_fetchArray( $result );

    return $block;
}


function convert_images($matches)
{
    global $_CONF, $CUSTOM_MOBILE_CONF, $CUSTOM_MOBILE_UA;

    switch ($CUSTOM_MOBILE_UA) {
        case MOBILE_UA_DOCOMO;
        case MOBILE_UA_DOCOMO_3G;
            $type = 'gif';
            $quality = '';
            break;

        default;
            $type = 'png';
            $quality = $CUSTOM_MOBILE_CONF['image_quality_png'];
            break;
    }
    
    $str = $matches[3];
    if (preg_match('@(.*)style="([^"]*?)"(.*)@i', $str, $m)) {
        $str = $m[1] . 'style="border:none; ' . $m[2] . '"' . $m[3];
    } else {
        $str = ' style="border:none;"' . $str;
    }

    $retval = '<' . $matches[1] . 'src="' . $_CONF['site_url']
        . RESIZER . '?image=' . $matches[2] . '&amp;size='. $CUSTOM_MOBILE_CONF['image_size'];
    $retval .= '&amp;type=' . $type;
    $retval .= (!empty($quality)) ? '&amp;quality=' . $quality : '';
    $retval .= '&amp;site_url=' . $_CONF['site_url'] . '"' . $str . '>';

    return $retval;
}


function convert_inputtextform($matches)
{
    $size = $matches[3];
    if ($matches[3] > 32) {
        $size = 32;
    }
    $retval = '<input' . $matches[1] . 'type="text"' . $matches[2] . 'size="' . $size . '"' . $matches[4] . '>';

    return $retval;
}

// 「全角カタカナ」を「半角カタカナ」に変換
// 「全角」英数字を「半角」に変換
function convert_kana($matches)
{
    return mb_convert_kana($matches[1], 'ak', 'sjis-win');
}

// [EMOJI TRANS FUNCTION Ver4.0]
// emoji_trans.php - 2009/02/17
// Copyright (C) DSPT.NET
// http://www.dspt.net/

// 絵文字変換表
$emoji_data = $_CONF['path_html'] . "emoji/table.tsv";

// PC用絵文字格納フォルダ
$img_dir = $_CONF['site_url'] . "/emoji/images/";

// 変換表を配列に格納
$emoji_array = array();
$emoji_array[] = "";
if (file_exists($emoji_data)) {
    $contents = @file($emoji_data);
    if ($contents != false) {
        foreach ($contents as $line) {
            $emoji_array[] = explode("\t", rtrim($line));
        }
    }
}

// 携帯キャリアに合わせて絵文字を出力
function emoji($data)
{
    global $CUSTOM_MOBILE_UA, $emoji_array, $img_dir;

    if (empty($emoji_array)) return '';
    $retval = '';
    if(preg_match('/[0-9]{1,3}/', $data) && 0 < $data && $data < 254) {
        switch ($CUSTOM_MOBILE_UA) {
            case MOBILE_UA_DOCOMO;
            case MOBILE_UA_DOCOMO_3G;
                if (!empty($emoji_array[$data][1])) {
                    $retval = '&#x' . $emoji_array[$data][1] . ';';
                }
                break;

            case MOBILE_UA_AU;
            case MOBILE_UA_AU_3G;
                if (!empty($emoji_array[$data][1])) {
                    $retval = '&#x' . $emoji_array[$data][2] . ';';
                }
                break;

            case MOBILE_UA_SOFTBANK;
            case MOBILE_UA_SOFTBANK_3G;
                if (!empty($emoji_array[$data][1])) {
                    $retval = '&#x' . $emoji_array[$data][3] . ';';
                }
                break;

            default;
                $retval = '<img src="' . $img_dir . $emoji_array[$data][0]
                        . '.gif" width="12" height="12" style="border:none;" alt=""' . XHTML . '>';
                break;
        }
    }

    return $retval;
}


// ユーザエージェントを確認
_mobile_parse_ua();

$CUSTOM_MOBILE_CONF['use_appl_xhtml'] = true;
if ($CUSTOM_MOBILE_UA == MOBILE_UA_DOCOMO_3G) {
    // ユーザエージェントが'application/xhtml+xml'を解釈できる場合はtrueを設定する。
    $CUSTOM_MOBILE_CONF['use_appl_xhtml'] = preg_match('/application\/xhtml\+xml/', $_SERVER['HTTP_ACCEPT']);
}

CUSTOM_MOBILE_debug("HTTP_ACCEPT: " . $_SERVER['HTTP_ACCEPT']);

// メインルーチン
if (CUSTOM_MOBILE_is_cellular() && $CUSTOM_MOBILE_UA_IPHONE == 0) {
    // セッション管理の初期化(Cookieを使わない)
    ini_set('session.use_cookies', false);
    ini_set('session.use_only_cookies', false);
    ini_set('session.use_trans_sid', true);
    ini_set('session.gc_probability', "1");
    ini_set('session.gc_divisor', "10");
    ini_set('session.gc_maxlifetime', "691200");

    // ケータイ用のテーマを使用
    if ($CUSTOM_MOBILE_CONF['use_appl_xhtml'] && !$CUSTOM_MOBILE_CONF['force_use_html']) {
        $_CONF['theme']    = $CUSTOM_MOBILE_CONF['theme_xhtml'];
        $_POST['usetheme'] = $CUSTOM_MOBILE_CONF['theme_xhtml'];
        $_USER['theme']    = $CUSTOM_MOBILE_CONF['theme_xhtml'];
        define('XHTML', ' /');
    } else {
        $_CONF['theme']    = $CUSTOM_MOBILE_CONF['theme_html'];
        $_POST['usetheme'] = $CUSTOM_MOBILE_CONF['theme_html'];
        $_USER['theme']    = $CUSTOM_MOBILE_CONF['theme_html'];
        define('XHTML', '');
    }

    // 各種デフォルト値を変更
    $_CONF['limitnews'] = $CUSTOM_MOBILE_CONF['max_stories'];
    $_CONF['advanced_editor'] = false;
    $_CONF['hideprintericon'] = 1;
    $_CONF['hideemailicon'] = 1;
    $_CONF['hideviewscount'] = 1;
    $_CONF['show_topic_icon'] = 1;
    $_CONF['postmode'] = 'text';
    //$_CONF['hide_main_page_navigation'] = 1;
    $_CONF['trackback_enabled'] = 0;
    $_CONF['pingback_enabled'] = 0;
    $_CONF['ping_enabled'] = 0;

    /*
    $CONF_FORUM_MOBILE['show_topics_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_posts_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_messages_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_searches_perpage'] = "5";
    $CONF_FORUM_MOBILE['use_autorefresh'] = "0";
    */
    $CONF_FORUM['default_Datetime_format'] = '%y/%m/%d %H:%M';
    $CONF_FORUM['default_Topic_Datetime_format'] = '%y/%m/%d %H:%M';
    $CONF_FORUM['show_topicreview'] = "0";

    // メッセージを短く
    $_CONF['date'] = ' %Y/%m/%d %I:%M %p';
    $LANG12[9] = "";
    $LANG12[19] = "";

    // ADMIN_list()のクエリの上限を設定
    $_REQUEST['query_limit'] = 5;

    $token = ''; // Default to no token.

    /*
     * 記事投稿で一部の端末はrefererを返さないため
     * SEC_checkToken()が偽になる
     * これを避けるためrefererを設定する
     */
    if(array_key_exists(CSRF_TOKEN, $_GET)) {
        $token = COM_applyFilter($_GET[CSRF_TOKEN]);
    } else if(array_key_exists(CSRF_TOKEN, $_POST)) {
        $token = COM_applyFilter($_POST[CSRF_TOKEN]);
    }
    CUSTOM_MOBILE_debug("token: $token");
    CUSTOM_MOBILE_debug("referer: " . $_SERVER['HTTP_REFERER']);
    if(trim($token) != '' && $_SERVER['HTTP_REFERER'] =='') {
        $sql = "SELECT ((DATE_ADD(created, INTERVAL ttl SECOND) < NOW()) AND ttl > 0) "
            . "as expired, owner_id, urlfor FROM "
            . "{$_TABLES['tokens']} WHERE token='$token'";
        $tokens = DB_Query($sql);
        if(DB_numRows($tokens) == 1) {
            $tokendata = DB_fetchArray($tokens);
            CUSTOM_MOBILE_debug("urlfor: " . $tokendata['urlfor']);
            $_SERVER['HTTP_REFERER'] = $tokendata['urlfor'];
        }
    }

    ini_set("url_rewriter.tags", "a=href,area=href,frame=src,fieldset=");
    session_start();

    // 入力をURLデコードする
    _mobile_prepare_input($_POST);
    _mobile_prepare_input($_GET);
    _mobile_prepare_input($_REQUEST);

    if($CUSTOM_MOBILE_CONF['convert_to_sjis']) {
        mb_convert_variables($CUSTOM_MOBILE_CONF['host_charset'],"sjis-win", $_POST, $_GET, $_REQUEST);
                                       //mb_detect_encoding($key, "sjis-win,UTF-8,EUC-JP,JIS"));

        // 出力をシフトJISに変換
        ini_set('mbstring.internal_encoding', $CUSTOM_MOBILE_CONF['host_charset']);
        ini_set('mbstring.encoding_translation', '0');
        ini_set('mbstring.http_output', 'pass');
        ini_set('mbstring.http_input', 'pass');
    }

    ob_start('_mobile_output_handler');
}

if ($CUSTOM_MOBILE_UA_IPHONE == 1) {

    $CUSTOM_MOBILE_CONF['use_hankaku_kana'] = false;
    
    // セッション管理の初期化(Cookieを使わない)
    ini_set('session.use_cookies', false);
    ini_set('session.use_only_cookies', false);
    ini_set('session.use_trans_sid', true);
    ini_set('session.gc_probability', "1");
    ini_set('session.gc_divisor', "10");
    ini_set('session.gc_maxlifetime', "691200");

    // iPhone(iPod)用のテーマを使用
    if (is_dir($_CONF['path_html'] . 'layout/' . IPHONE_THEME)) {
        $_CONF['theme']    = IPHONE_THEME;
        $_POST['usetheme'] = IPHONE_THEME;
        $_USER['theme']    = IPHONE_THEME;
        define('XHTML', ' /');
    }

    // 各種デフォルト値を変更
    $_CONF['limitnews'] = $CUSTOM_MOBILE_CONF['max_stories'];
    $_CONF['advanced_editor'] = false;
    $_CONF['hideprintericon'] = 1;
    $_CONF['hideemailicon'] = 1;
    $_CONF['hideviewscount'] = 1;
    $_CONF['show_topic_icon'] = 1;
    $_CONF['postmode'] = 'text';
    //$_CONF['hide_main_page_navigation'] = 1;
    $_CONF['trackback_enabled'] = 0;
    $_CONF['pingback_enabled'] = 0;
    $_CONF['ping_enabled'] = 0;

    /*
    $CONF_FORUM_MOBILE['show_topics_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_posts_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_messages_perpage'] = "5";
    $CONF_FORUM_MOBILE['show_searches_perpage'] = "5";
    $CONF_FORUM_MOBILE['use_autorefresh'] = "0";
    */
    $CONF_FORUM['default_Datetime_format'] = '%y/%m/%d %H:%M';
    $CONF_FORUM['default_Topic_Datetime_format'] = '%y/%m/%d %H:%M';
    $CONF_FORUM['show_topicreview'] = "0";

    // メッセージを短く
    $_CONF['date'] = ' %Y/%m/%d %I:%M %p';
    $LANG12[9] = "";
    $LANG12[19] = "";

    // ADMIN_list()のクエリの上限を設定
    $_REQUEST['query_limit'] = 5;

    $token = ''; // Default to no token.

    ini_set("url_rewriter.tags", "a=href,area=href,frame=src,fieldset=");
    session_start();

    // 入力をURLデコードする
    _mobile_prepare_input($_POST);
    _mobile_prepare_input($_GET);
    _mobile_prepare_input($_REQUEST);

    ob_start('_iphone_output_handler');
}
