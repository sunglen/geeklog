<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// |                                                                           |
// | Geeklog configuration file.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2001-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs - tony AT tonybibbs DOT com                           |
// |          Dirk Haun  - dirk AT haun-online DOT de                          |
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
// | See the docs/install.html and docs/config.html files for more information |
// | on configuration.                                                         |
// +---------------------------------------------------------------------------+
// $Id: config.php,v 1.240 2006/12/30 17:43:18 dhaun Exp $
// +---------------------------------------------------------------------------+
// | (0) 日本語版独自設定                                                      |
// +---------------------------------------------------------------------------+
//HTTP入力文字エンコー ディングのデフォルト値
    ini_set('mbstring.http_input', 'pass');
    ini_set('mbstring.detect_order', 'UTF-8,EUC-JP,SJIS,JIS,ASCII');
    // 文字化けが直らない場合は，順番を適宜，変えてみてください
//HTTP出力文字エンコーディングのデフォルト値　PASS:無変換
    ini_set('mbstring.http_output', 'pass');
//内部文字エンコーディングのデフォルト
    ini_set('mbstring.internal_encoding', 'utf-8'); //utf-8の場合
    //ini_set('mbstring.internal_encoding', 'euc-jp'); //euc-jpの場合
//カレントの言語を設定 日本語
//    ini_set('mbstring.language', 'japanese');
//    mb_language('Japanese');//(PHP 4 >= 4.0.6, PHP 5)
//magic_quotes オフ
    ini_set('magic_quotes_sybase', 0);
    set_magic_quotes_runtime(0);
// +---------------------------------------------------------------------------+
// @@@@@2006/09/03 コメントの日本語化 FCKeditor ON/画像サムネール対応 RSSdir
//                 イベント表示期間変更
// @@@@@2006/11/14 Xreaサーバでutf-8で確認しています．
//                 PHP Version 4.4.4 MySQL - 4.0.26
// @@@@@2007/03/12 最終変更
// このファイルの最後で プラグイン userconfig 用の　userconfig_now.phpを読みこ
// んでいます。userconfig_now.phpが存在する場合は、そちらの設定になります。
// +---------------------------------------------------------------------------+
// 最低限修整しないといけないところ
//   1.☆アカウント    をあなたのアカウントに  置換
//   2.☆ドメイン      をあなたのドメインに    置換
//   3.$_DB_pass       データベースのパスワード
//   4.$_CONF['path']  config.phpの場所
// +---------------------------------------------------------------------------+

// 次の３つの修正は必須です．
// (1) データベース設定
// (2) パス設定
// (3) サイト設定
// その他の設定は任意で，いつでも変更できます．
// 必ず，設定する文字コードでconfig.phpファイルを更新してください．


// +---------------------------------------------------------------------------+
// | (1) データベース設定                                                      |
// +---------------------------------------------------------------------------+
//@@@@@
// ☆ データベース情報
// インストーラを実行する前にデータベースを作成しておく必要があります．
$_DB_host = 'cqopenrtc.db.6197845.hostedresource.com';   // ホストネームまたはIPアドレス(通常このまま)
$_DB_name = 'cqopenrtc';// データベース名
$_DB_user = 'cqopenrtc';// MySQLユーザ名
$_DB_pass = 'geekl0gAdmin';     // MySQLパスワード

// データベースの接頭文字列。同一データベース内に複数のGeekLogをインストールする
// 場合は、区別できるよう変更してください。そうでなければ、このままで。
$_DB_table_prefix = 'gl_';         // e.g. 'gl_'


// +---------------------------------------------------------------------------+
// | (2) パス設定                                                              |
// +---------------------------------------------------------------------------+
// Windowsユーザへの注意: '\'より '/'が安全です． 
// config.php が置かれているディレクトリパス．最後のスラッシュ（/）が必須
//@@@@@ 
//$_CONF['path']            = '/path/to/geeklog/'; 
// ☆絶対アドレスでconfig.phpの場所を設定する．最後のスラッシュ（/）が必須
$_CONF['path']            = '/home/content/45/6197845/html/cq/geekl0g/';

//@@@@@ 
// $_CONF['path_html']      = '/path/to/your/public_html/';
// ☆絶対アドレスでTopページの場所を設定する．最後のスラッシュ（/）が必須
$_CONF['path_html']     = '/home/content/45/6197845/html/cq/';


// +---------------------------------------------------------------------------+
// | (3) サイト設定                                                            |
// +---------------------------------------------------------------------------+

//@@@@@ 
// ☆URLでGeeklogのトップページ（index.php）の場所を設定．最後のスラッシュ（/）は不要
$_CONF['site_url']          = 'http://cq.openrtc.com';

// 管理画面のURL
$_CONF['site_admin_url']    = $_CONF['site_url'] . '/admin';
// ホスティングサービスによってはadminディレクトリは予約ディレクトリです．
// その場合には例えば"myadmin"のようにディレクトリ名を変更してください．

// ☆Geeklogのシステムから送るメールのFromになるアドレス
$_CONF['site_mail']         = 'sun@openrtc.com';

// ☆サイト名とサイトのスローガン ヘッダに表示されます．
//@@@@@☆
$_CONF['site_name']         = 'CQ读书沙龙';
$_CONF['site_slogan']       = '多给你一亿人的智慧';

// ****************************************************************************
// 以下の設定は初期にする必要はありません．
// インストール後に設定を変更できます．
// ****************************************************************************

// +---------------------------------------------------------------------------+
// | その他のパス設定                                                          |
// | すべて最後のスラッシュ（/）が必要                                         |
// +---------------------------------------------------------------------------+
// 以下の設定は，編集しないでください．
$_CONF['path_system']   = $_CONF['path'] . 'system/';
$_CONF['path_log']      = $_CONF['path'] . 'logs/';
$_CONF['path_language'] = $_CONF['path'] . 'language/';
$_CONF['backup_path']   = $_CONF['path'] . 'backups/';
$_CONF['path_data']     = $_CONF['path'] . 'data/';

// 画像ファイルを置くディレクトリへのパス．
// このディレクトリには，ユーザーアバターや記事の画像を含みます．
// もし，デフォルト以外のディレクトリに設定した場合には
// サブディレクトリ articles/, userphotos/ を追加してください．
$_CONF['path_images']   = $_CONF['path_html'] . 'images/';

// +---------------------------------------------------------------------------+
// | PEAR 設定                                                                 |
// | Geeklog は，メール送信に PEAR を利用しています．                          |
// | (下記の "メール設定Email Settings"参照).                                  |
// | Geeklog に対して，どこに PEAR パッケージがインストールされているかを設定．|
// +---------------------------------------------------------------------------+

// サーバのPEAR（true:利用する false:利用しない）
// 通常falseを選んで，Geeklogが提供しているPEARを利用し，サーバのPEARを利用しません．
$_CONF['have_pear'] = false;

// $_CONF['have_pear'] = falseの場合，Geeklogが以下のディレクトリのPEARパッケージが必要です．
$_CONF['path_pear'] = $_CONF['path_system'] . 'pear/';

// +---------------------------------------------------------------------------+
// | メール設定                                                                |
// | Geeklog 1.3.9から，Geeklog ユーザーは PEAR::メールはPEAR::Mail            |
// | クラスでメールを送信できるようになりました．                              |
// | メールは，SMTP, sendmail, or PHP's mail() にて送信できます．              |
// +---------------------------------------------------------------------------+
// 通常は，変更する必要がありません

$_CONF['mail_settings'] = array (
    'backend' => 'mail',                    // 電子メールを送る方法を選ぶ．
                                            // 'smtp', 'sendmail',または 'mail'.
    'sendmail_path' => '/usr/sbin/sendmail', // 'sendmail'をbackendで選択した場合
                                            // sendmail binaryへのパス．
    'sendmail_args' => '',                  // 'sendmail'をbackendで選択した場合
                                            // sendmail binaryへの追加パラメータ
                                            // として利用されます．
    'host'     => 'smtpout.geektalks.cn',       // 'smtp' をbackendで選択した場合，
                                            // 利用するSMTP サーバー
    'port'     => '25',                     // 'smtp' をbackendで選択した場合，
                                            // 利用するSMTP サーバーにおける
                                            // ポートナンバー
    'auth'     => true,                    // smtp' をbackendで選択した場合
                                            // true:SMTPサーバが認証要求
                                            // false:SMTPサーバが認証要求しない
    'username' => 'cq@geektalks.cn',          // 'smtp' をbackendで選択した場合
                                            // SMTP アカウント名
    'password' => ''           // 'smtp' をbackendで選択した場合
                                            // SMTPアカウントのパスワード．
);

// +---------------------------------------------------------------------------+
// | その他のデータベース設定                                                  |
// | データベースのタイプとバックアップ設定                                    |
// +---------------------------------------------------------------------------+

$_DB_dbms = 'mysql'; // 'mysql' または 'mssql' (Microsoft SQL Server)


// MySQLのみのオプション

// Geeklogデータベースバックアップオプション
// 一般的にレンタルサーバでは，モジュール版mysqldumpが使えないので
// 日本語版ではデフォルトを1から0へ変更しています．
$_CONF['allow_mysqldump']   = 0;      // 1:機能オン 0:機能オフ

// 以下の設定は$_CONF['allow_mysqldump']=1の場合に必要です．
// Geeklog データベースバックアップのためのmysqldump ユーティリティへのパス
// (Windows ユーザは ".exe"を追加!)
$_DB_mysqldump_path = '/usr/bin/mysqldump';

// Geeklog ユーザーのバックアップの追加オプションをmysqldump
// に含ませることができる．
$_CONF['mysqldump_options'] = '-Q';


// +---------------------------------------------------------------------------+
// | サイト設定                                                                |
// | Geeklogサイトを定義します．                                               |
// +---------------------------------------------------------------------------+
//$_CONF['theme']          = 'ProfessionalCSS';  // サイトのデフォルトのテーマ名．
//$_CONF['theme']          = 'small_studio';  // サイトのデフォルトのテーマ名．
$_CONF['theme']          = 'professional';  // サイトのデフォルトのテーマ名．

// メニューバーに表示するメニュー要素を指定．
// （利用するテーマが{menu_elements}変数をメニューバーの表示に使っているとき）
// 'home','contribute','calendar','search','directory','prefs'
// ,'plugins','custom'
// どの組み合わせでも可能．
// 'plugins' は{plg_menu_elements} 変数と同じ．
// 'custom' は，CUSTOM_menuEntries 関数の返す文字列を表示．
// （詳細はlib-custom.php参照）
// , に注意 
$_CONF['menu_elements'] = array
(
    'home',         // ホーム へのリンク
    'contribute',   // 記事の新規作成へのリンク
    'calendar',     // カレンダ表示へのリンク
    'search',       // 検索オプションへのリンク
    'stats',        // ステータス情報 
    'directory',    // 記事の一覧
    'prefs',        // アカウント情報
    'plugins',      // プラグイン {plg_menu_elements} 変数と同じ．
    'custom'     // CUSTOM_menuEntries 関数の返す文字列を表示．
    //（詳細はlib-custom.php参照）
);

// 編集不可．固定
$_CONF['layout_url']        = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
$_CONF['path_themes']       = $_CONF['path_html'] . 'layout/';
$_CONF['path_layout']       = $_CONF['path_themes'] . $_CONF['theme'] . '/';

// ユーザの新規登録拒否　false:許可　true:拒否（管理者のみ登録可能）
$_CONF['disable_new_user_registration'] = false;

// オプション設定 (1:許可する 0:許可しない)
$_CONF['allow_user_themes']   = 0; // ユーザのテーマ選択
$_CONF['allow_user_language'] = 1; // ユーザの言語選択
$_CONF['allow_user_photo']    = 1; // ユーザのアバタ

// ユーザが自分でユーザ名を変更（1:変更できる 0:変更できない）
$_CONF['allow_username_change'] = 0;

// ユーザが自分でアカウントを削除（1:削除できる 0:削除できない）
$_CONF['allow_account_delete']  = 1;

// マイアカウントで読みたくない投稿者名を選択オプションを隠す（1:隠す 0:隠さない）
$_CONF['hide_author_exclusion'] = 0;

// ユーザ名表示の際に，本名を表示する．(1:本名表示 0:ユーザ名表示)
$_CONF['show_fullname'] = 0; 

// リモートログイン サービス名プルダウン表示（1: 表示できる 0: 表示しない）
$_CONF['show_servicename'] = true;

// +---------------------------------------------------------------------------+
// | カスタムユーザ登録フォームとアカウント詳細をサポート．                    |
// | lib-custom.phpで，カスタム関数をあらかじめセットしておく必要があります．  |
// | users.php, usersettings.php and admin/user.php も連動させます．           |
// +---------------------------------------------------------------------------+
$_CONF['custom_registration'] = false;        // true:カスタムコードを利用する．

// +---------------------------------------------------------------------------+
// | リモートログイン機能                                                      |
// |                                                                           |
// | 他のサービスにアカウントがあってログインしている時には                    |
// | Geeklogサイトにも同時に自動ログイン．                                     |
// | 現在サポートされているサービスはBloogerとLiveJournal．                    |
// | 特定のサービスを使っての自動ログインを有効にするために，                  |
// | system/classes/authenticationディレクトリに認証のためのクラスファイルを   |
// | 用意する必要があります．                                                  |
// | Bloggerでは有効にしてLiveJournalでは無効にする（または逆）場合，          |
// | 単に必要としないサービスのクラスファイルを削除してください．              |
// +---------------------------------------------------------------------------+
// Blogger.comやLiveJournalの登録ユーザーのリモートログイン
// リモートログイン機能（true:有効　登録しなくてもログインできる　falese:無効）
$_CONF['remoteauthentication'] = false;

// +---------------------------------------------------------------------------+
// | Spam-X の実行モードを設定．                                               |
// | 128:コメントを無視してホームページへリダイレクト．                        |
// |   8:メール管理者メッセージ                                                |
// | 136:(128+8) 無視してメール管理者メッセージ                                |
// +---------------------------------------------------------------------------+
$_CONF['spamx'] = 128;        // コメントを無視してホームページへリダイレクト．

// +---------------------------------------------------------------------------+
// | 管理画面のメニューをアルファベット順にソート．                            |
// +---------------------------------------------------------------------------+
//@@@@@＜日本語版独自設定＞
// 管理者メニューのソート（true:ABC順にソートする false:ソートしない）
$_CONF['sort_admin'] = false;

// +---------------------------------------------------------------------------+
// | エディタの画像ライブラリ $_CONF['site_url'] (スラッシュ/なし)からのパス   |
// +---------------------------------------------------------------------------+
$_CONF_FCK['imagelibrary'] = '/images/library/';

// +---------------------------------------------------------------------------+
// | ロケール設定                                                              |
// +---------------------------------------------------------------------------+
//@@@@@＜日本語版独自設定＞
// 言語ファイル選択．language/に設置した言語ファイルから選択．
// 多言語サポート機能を利用する場合には，UTF-8モードにする必要があります．
//$_CONF['language']        = 'japanese';       // EUC
//$_CONF['language']          = 'japanese_utf-8'; // UTF-8
$_CONF['language']          = 'chinese_simplified_utf-8'; // UTF-8

//$_CONF['default_charset'] = 'iso-8859-1';     // EUC
$_CONF['default_charset'] = 'utf-8';            // UTF-8

//$_CONF['locale']          = 'en_GB';
//$_CONF['locale']          = 'C';              //Windows用
//$_CONF['locale']          = 'ja_JP';          //japanese用
//$_CONF['locale']            = 'ja_JP.UTF-8';    //japanese utf-8用 
$_CONF['locale']            = 'zh_CN.UTF-8';

// 日付表示
//                             2005年8月17日(水) 14:44 JST
//$_CONF['date']              = '%Y年%B%e日(%a) %H:%M %Z';
//   サーバにより，ロケール機能が未実装あるいは指定されたロケールが存在しない場合
//   日本語が使えません．そのときは次の設定を使用
$_CONF['date']            = '%Y/%m/%d %I:%M %p';
//$_CONF['date']            = '%Y年%B%e日(%a) %I:%M %p %Z';
//                             2005年8月17日(水) 10:44 午前 JST

//%A - 現在のロケールに基づく完全な曜日の名前     (例:日曜日)
//%B - 現在のロケールに基づく完全な月の名前       (例:2月)
//%a - 現在のロケールに基づく短縮された曜日の名前 (例:日)
//%b - 現在のロケールに基づく短縮された月の名前   (例: 2月)
//%d - 日付を10進数で．(01から31) 
//%e - 月単位の日付を10進数で表したもの．
//     日付が1桁の場合は，前に 空白を一つ付けます．(' 1'-'31') 
//%Y - 世紀を含む年を 10進数で表現 
//%m - 月を10進数で表現 (01から12) 
//%H - 時間を24時間表示の10進数で(01から23までの範囲)
//%I - 時間を12時間表示の10進数で(01から12までの範囲) 
//%M - 分を10進数で表現 
//%p - 指定した時間により 'am' または 'pm' ，
//     または 現在のロケールに対応した文字列 
//%Z - タイムゾーンまたはその名前または短縮形 
//%x - 時間を除いた日付を現在のロケールに基づき表現します．(例:2001年02月18日)
//%X - 日付を除いた時間を現在のロケールに基づき表現します．(19時32分01秒)
//$_CONF['daytime']         = '%m/%d %I:%M%p';
$_CONF['daytime']         = '%m/%d %H:%M %Z';

// 日付短縮形
//@@@@@日本語版では'%x' から '%Y年%B%e日' (例:2006年4月 1日) に変更しています．
//$_CONF['shortdate']       = '%x';
//$_CONF['shortdate']       = '%Y年%B%e日';
//↓日本語が使えない時はこちらを使用(例:2006/04/01) 
$_CONF['shortdate']       = '%Y/%m/%d';

// 日付のみ
//@@@@@日本語版では'%d-%b' から '%B%e日' (例:4月 1日) に変更しています．
//$_CONF['dateonly']        = '%d-%b';
//$_CONF['dateonly']        = '%B%e日';
//↓日本語が使えない時はこちらを使用(例:04/01) 
$_CONF['dateonly']        = '%m/%d';

// 時刻のみ
//$_CONF['timeonly']        = '%I:%M%p';
$_CONF['timeonly']        = '%H:%M %Z';

$_CONF['week_start']      = 'Sun'; // 週の開始曜日（日曜日: 'Sun' or 月曜日: 'Mon'）
$_CONF['hour_mode']       = 12;    // 時間制（12: 12時間制 24: 24時間制）

// 数値表示形式
$_CONF['thousand_separator'] = ",";  // 桁区切り カンマのテキスト
$_CONF['decimal_separator']  = ".";  // 小数点のテキスト
$_CONF['decimal_count']      = "2";  // 小数点以下の桁数

// 多言語サポート
// マルチリンガルサイトを構築できます．
// このセクションは/* */によってコメントアウト（無効化）されています．
// 下記内容を理解した上で有効にしてください．

/*
// 重要！
// 1) $_CONF['language_files'] と $_CONF['languages'] 配列は対応しています．
// 2) ２つの配列でショートカットは共通です．
// 3) すべてのショートカットの文字数は同じです．例）２文字

// マルチ言語のショートカットIDは次のように利用されます．
// 英語例） /article.php/introduction_en ，ドイツ語例）/article.php/introduction_de


// サポートしている言語☆
// ショートカットから Geeklog言語ファイルへのマッピング (拡張子'.php'抜き)
$_CONF['language_files'] = array (
    'sc' => 'chinese_simplified_utf-8',
    'tc' => 'chinese_traditional_utf-8',
    'ja' => 'japanese_utf-8',
    'en' => 'english_utf-8',
    'de' => 'german_formal_utf-8'
);

// サポート言語の表示名
// ドロップダウンメニューで表示される言語名
$_CONF['languages'] = array (
    'sc' => '简体汉字',
    'tc' => '繁體漢字',
    'ja' => '日本語',
    'en' => 'English',
    'de' => 'Deutsch'
);
*/


// タイムゾーンハック

// サーバがことなるタイムゾーンに置かれているとき，
// タイムゾーンをここで調整．GMTより6時間前ならこのように設定．
//
//  safe_modeがonのときには作動しません．
//
// Geeklog本家掲示板参照 geeklog.net:
// http://www.geeklog.net/forum/viewtopic.php?showtopic=21232
//$_CONF['timezone'] = 'China/Beijing'; // e.g. GMT+0800
//$_CONF['timezone'] = 'Etc/GMT+8'; // 
$_CONF['timezone'] = 'Etc/UTC'; // e.g. GMT


// +---------------------------------------------------------------------------+
// | サイトステータス設定                                                      |
// | 緊急にサイトを閉じるときに利用                                            |
// +---------------------------------------------------------------------------+
//@@@@@＜日本語版独自設定＞
// サイトの状態（true:有効 false:休止）
$_CONF['site_enabled'] = true; 

// サイトを休止したときのメッセージ
// 'http:' からはじまる文字を設定するとリダイレクト設定されます．
// 日本語版ではリダイレクト設定に変更しています。
//$_CONF['site_disabled_msg'] = 'Geeklog Site is down. Please come back soon.';
$_CONF['site_disabled_msg'] = $_CONF['site_url'].'/disabledmsg.html';

// サイトがtrueのとき，PHPエラーが発生したとき，'詳しい'デバッグ情報が表示されます．
// true: 開発中のときだけtrueに設定してください．
//$_CONF['rootdebug'] = true;
$_CONF['rootdebug'] = false;

// +---------------------------------------------------------------------------+
// | セッション設定                                                            |
// |                                                                           |
// | cookie_ip                                                                 |
// |1:乱数のセッションID．                                                     |
// |  ユーザーのIPアドレスを含む乱数のセッションIDを設定できる．               |
// |  よりセキュアだが，ダイヤルアップユーザーは毎回ログインを要求される．     |
// |0:IPアドレスのセッションID                                                 |
// +---------------------------------------------------------------------------+

$_CONF['cookie_session']                = 'gl_session';
$_CONF['cookie_name']                   = 'geeklog';
$_CONF['cookie_password']               = 'password';
$_CONF['cookie_theme']                  = 'theme';
$_CONF['cookie_language']               = 'language';

$_CONF['cookie_ip']                     = 0;
$_CONF['default_perm_cookie_timeout']   = 28800; //秒数(28800 = 8 hours).
$_CONF['session_cookie_timeout']        = 7200;

$_CONF['cookie_path']                   = '/';   //ドメイン下のGeeklogパス
$_CONF['cookiedomain']                  = '';//☆ 例 '.example.com'

// クッキー指定方法補足．('site_url'を基本にします．)
// （例1）www.☆ドメインがGeeklogのルートになる場合
//      $_CONF['cookie_path']='/';
//      $_CONF['cookiedomain'] = 'www.☆ドメイン';
// （例2）www.☆ドメイン/aaa/がGeeklogのルートになる場合
//      $_CONF['cookie_path']='/aaa/';
//      $_CONF['cookiedomain'] = 'www.☆ドメイン';
// （例3）ローカルで動かすとき
//      $_CONF['cookiedomain'] = '';


$_CONF['cookiesecure']                  = 0;  // 1: HTTPSを使っている 0: 使っていない

// 最後にログインしたときの情報（true: 保存する false: 保存しない）
$_CONF['lastlogin']                     = true;


// +---------------------------------------------------------------------------+
// | PDFコンバージョン: この機能は現在使われていません．                       |
// +---------------------------------------------------------------------------+

$_CONF['ostype']    = PHP_OS;

// 注意: PDFコンバージョンはこのバージョンでリリースされていないのでこのまま．
$_CONF['pdf_enabled'] = 0;


// +---------------------------------------------------------------------------+
// | 検索の設定                                                                |
// +---------------------------------------------------------------------------+

// 1ページあたりの検索結果件数
$_CONF['num_search_results'] = 10;


// +---------------------------------------------------------------------------+
// | 各種Geeklog設定                                                           |
// | geeklogはいろいろな設定で稼動します．                                     |
// +---------------------------------------------------------------------------+

// ログイン要求：登録ユーザのみへのサービスにするかどうかの設定

$_CONF['loginrequired'] = 0; // 1:すべての投稿にログインが必要 
                             // 0:指定された投稿だけにログインが必要

//$_CONF['loginrequired'] = 0に設定した場合は
//以下でログインが必要な作業を指定します．
$_CONF['submitloginrequired']     = 0;  // 1:記事・イベント投稿
$_CONF['commentsloginrequired']   = 0;  // 1:コメント投稿
$_CONF['calendarloginrequired']   = 0;  // 1:カレンダー表示
$_CONF['statsloginrequired']      = 0;  // 1:サイトステータス表示
$_CONF['searchloginrequired']     = 0;  // 1:検索の表示
$_CONF['profileloginrequired']    = 0;  // 1:他人のプロファイルの閲覧
$_CONF['emailuserloginrequired']  = 0;  // 1:他のユーザーにメール送信
$_CONF['emailstoryloginrequired'] = 0;  // 1:記事をメールで送る機能
$_CONF['directoryloginrequired']  = 0;  // 1:記事一覧表示

// 管理者の承認制度

// 管理者が投稿承認作業（1:承認待ちリストで管理者が投稿承認 0:直接稿実行）
$_CONF['storysubmission'] = 1;     // 記事投稿承認制度
$_CONF['usersubmission']  = 0;     // ユーザー登録承認制度

// 管理者メニューの承認待ちリストにドラフトモードの記事一覧を表示．
$_CONF['listdraftstories'] = 0;

// 新しく投稿または新規ユーザーが登録されたとき，管理者あてメール$_CONF['site_mail']へ通知される
// 'story', 'comment', 'trackback', 'pingback', and 'user'
$_CONF['notification'] = array // ＜日本語版独自設定＞
    (
        'story'
        , 'comment'
        , 'trackback'
        , 'pingback'
        , 'user'
    );

$_CONF['postmode']      = 'html';  // デフォルトの投稿モード'html'または'plaintext'＜日本語版独自設定＞
$_CONF['speedlimit']    = 45;      // 最小実行間隔（秒数）アタックを防ぐのに有効．
$_CONF['skip_preview']  = 0;       // 記事・コメント（0:プレビューして投稿 1:プレビューなしで投稿）


// +---------------------------------------------------------------------------+
// | アドバンストエディタ（WYSIWYGエディタ）であるリッチテキストエディタ       |
// | 「FCKエディタ」をサポートするカスタムテンプレートを，                     |
// | コメント投稿(comment.php),記事投稿(submit.php),管理者記事編集(admin/story.php),|
// | 静的ページ編集(admin/plugins/staticpages/index.php)で適用．               |
// | 注意：適用させる場合にはデフォルトの投稿モードをhtmlモードにすること      |
// +---------------------------------------------------------------------------+
//@@@@@＜日本語版独自設定＞
// FCKeditor (WYSIWYGエディタ).（true:使用する false:使用しない）
$_CONF['advanced_editor'] = true;

// +---------------------------------------------------------------------------+
// | Geeklog CRON またはスケジュールタスク関数の設定                           |
// | プラグインは runScheduledTask API 自動タスクを利用可能．                  |
// | lib-custom.phpのCUSTOM_runScheduledTask functionに関数を自由に追加．      |
// +---------------------------------------------------------------------------+
$_CONF['cron_schedule_interval']        = 86400;   // スケジュール間隔．
// 一定時間ごとにデータベースをバックアップするなどの作業のために設定される．


// 話題（記事カテゴリ）の設定

// 話題のソート（alpha:アルファベット順 sortnum:ソート番号順）
$_CONF['sortmethod'] = 'sortnum';

// 話題ブロック　記事件数（1:表示する 0:表示しない）
$_CONF['showstorycount'] = 1;

//@@@@@＜日本語版独自設定＞
// 話題ブロック　記事投稿件数（1:表示する 0:表示しない）
$_CONF['showsubmissioncount'] = 0;

//@@@@@＜日本語版独自設定＞
// 話題ブロックに"Home"へのリンク表示（1:隠す 0:隠さない）
$_CONF['hide_home_link'] = 1;


// Who's Onlineブロックの設定

// ユーザーオンラインにどのくらいの時間残しておくか
$_CONF['whosonline_threshold'] = 300; // 単位：秒数

//@@@@@＜日本語版独自設定＞
// ユーザーオンラインブロックでログインユーザ名を表示
// ゲストユーザに対して表示（0:表示する 1:表示しない オンラインユーザー数のみ表示）
$_CONF['whosonline_anonymous'] = 1;


// デイリーダイジェスト設定

// デイリーダイジェスト（1:記事をメールで配信する 0:配信しない）
// シェルスクリプトとしてcronとPHPの使用が必要なので注意してください．
$_CONF['emailstories'] = 0;

// 送信文字（0:タイトルと新しい記事へのリンクのみ 1:最初の書き出しまで n:最初のn文字
$_CONF['emailstorieslength'] = 1;

// デイリーダイジェスト新規ユーザーの初期設定（1:受け取る 0:受け取らない）
$_CONF['emailstoriesperdefault'] = 0;

// 投稿許可ドメイン設定
// ユーザ投稿が可能な場合，投稿の承認待ちをしないドメインのリスト
//（自動承認されます）
$_CONF['allow_domains'] = '';    // 例 'mycompany.com,myothercompany.com'

// 投稿拒否ドメイン設定
// ユーザ投稿が可能な場合，投稿を拒否するドメインのリスト
$_CONF['disallow_domains'] = ''; // 例 'somebaddomain.com,anotherbadone.com'

// 新着期間の設定（秒数）
$_CONF['newstoriesinterval']   =  86400; // 24時間 新着記事の期間
$_CONF['newcommentsinterval']  = 172800; // 48時間 新着コメントの期間
$_CONF['newtrackbackinterval'] = 172800; // 48時間 新着Trackbackコメント期間

// What's Newブロック表示設定
$_CONF['hidenewstories']    = 0;         // 新着情報から記事の欄を隠す
$_CONF['hidenewcomments']   = 0;         // 新着情報からコメントの欄を隠す
$_CONF['hidenewtrackbacks'] = 0;         // 新着情報からトラックバックの欄を隠す
$_CONF['hidenewplugins']    = 0;         // 新着情報からプラグインの欄を隠す

// 新着情報ブロックでのタイトル長の制限
$_CONF['title_trim_length'] = 20;

// トラックバック（true:許可 false:不可）
$_CONF['trackback_enabled'] = true;

// ピングバック（true: 許可 false:不可）
$_CONF['pingback_enabled'] = true;

// ピング（true: 許可 false:不可）
$_CONF['ping_enabled'] = true;

// 記事作成の際のトラックバックデフォルト設定（0:許可する -1:許可しない）
$_CONF['trackback_code'] = 0;

// 同じソースからのトラックバックとピングバックの扱いについて
// （0:最初の投稿のみ有効 1:オーバーライト 2:すべて有効）
$_CONF['multiple_trackbacks'] = 0;

// トラックバック・ピングバック　連続したスパム投稿を受け付けないための間隔制限．（秒数）
$_CONF['trackbackspeedlimit'] = 300;

// トラックバックの整合性チェック
// 　0:チェックしない,
// 　1:自サイト$_CONF['site_url']からでないかチェック
// 　2:フル URLをチェック
// 　4:送信元IPアドレスチェック
// 　チェック項目は数字を加算, 例）2 + 4 = 6 とすると  URL + IPチェック
$_CONF['check_trackback_link'] = 2;

// ピングバックは自動的に記事からリンクされたすべてのＵＲＬに行われる．
// このオプションでセルフピングバックが設定される．
// （0:スキップ 1:速度制限を設けて許可 2:すべて許可）
$_CONF['pingback_self'] = 0;

// 管理者メニューにドキュメントへのリンクを表示（1:表示する 0:表示しない）
$_CONF['link_documentation'] = 1;


// 記事設定
$_CONF['maximagesperarticle']   =  5;    // 記事で設定できる最大画像ファイル数
$_CONF['limitnews']             = 10;    // 記事の1ページあたりの表示数
$_CONF['minnews']               =  1;    // 記事の最小数
$_CONF['contributedbyline']     =  1;    // ユーザー名を公開検索できるようにする(1:する 0:しない)

// 話題の右の(2/1)のカウント表示
$_CONF['hideviewscount']        = 1;      // 閲覧回数（1:隠す 0:隠さない）
$_CONF['hideemailicon']         = 0;      // 記事を友人に送るアイコン（1:隠す 0:隠さない）
$_CONF['hideprintericon']       = 0;      // 記事を印刷するアイコン（1:隠す 0:隠さない）
$_CONF['allow_page_breaks']     = 1;      // 記事にページブレーク自動タグ[page_break]の配置を許可
                                          // （1:許可する 0:許可しない）

$_CONF['page_break_comments']   = 'last'; // コメントの表示位置
                                          // （'first':最初 'last':最後, 'all':全ページ）

$_CONF['article_image_align']   = 'right';// 話題アイコン表示位置（'right':右 'left':左）

// 新規記事作成デフォルト
$_CONF['show_topic_icon']       = 1;      // 話題アイコン（1:表示する 0:表示しない）
$_CONF['draft_flag']            = 0;      // ドラフトフラグ（0:オフ 1:オン）
$_CONF['frontpage']             = 1;      // トップページにも表示（1:表示する 0:表示しない）

$_CONF['hide_no_news_msg']      = 0;      // 話題に記事がない場合のメッセージ（1:隠す 0:隠さない）
$_CONF['hide_main_page_navigation'] = 0;  // "google paging"をトップページから削除（1:削除する 0:削除しない）

// 記事を注目記事にできるユーザの範囲（1:ルートユーザのみできる 0:だれでも）
$_CONF['onlyrootfeatures'] = 0;

// テーマ拡張設定
// 　true:常時右のブロックを表示させて３カラム表示
// 　false:サブページ表示で右のブロックを隠す
$_CONF['show_right_blocks'] = false;
// ここで修正するとすべてのテーマに影響するので，テーマのfunctions.phpに記述してください．

// 注目記事
// 0:ホームのみ最初の記事が注目記事
// 1:全ページで最初の記事が注目記事
$_CONF['showfirstasfeatured']   = 0;

// 左ブロックエリアの変数{left_blocks}をフッタ（footer.thtml）で使う．
// 　ヘッダ（header.thtml）で{left_blocks}は利用できなくなります．
// 　フッタで，{left_blocks}{right_blocks}両方が使えるようになります．
// 　（0:左ブロック変数をヘッダで使う 1:左ブロック変数をフッタで使う）
$_CONF['left_blocks_in_footer'] = 0;
// ここで修正するとすべてのテーマに影響するので，テーマのfunctions.phpに記述してください．

// +---------------------------------------------------------------------------+
// | RSSフィード設定                                                           |
// |                                                                           |
// | フィード作成のデフォルトを設定                    ．                      |
// +---------------------------------------------------------------------------+

// RSSファイル作成（1:作成する 2:作成しない）
$_CONF['backend']       = 1;

// RSSファイルディレクトリ指定とデフォルトのファイル名
$_CONF['rdf_file']      = $_CONF['path_html'] . 'backend/geeklog.rss';

// フィードに出力される記事の最大件数または対象となる時間。
// この設定が数値であれば、フィードに含まれる記事の最大数。
$_CONF['rdf_limit']     = 10;   // 記事の件数の場合は数字（例 10） 時間の場合（例 24h）

// 書き出しモード（1:すべての冒頭文 2以上:冒頭文を文字数制限付きで 0:冒頭文なし）
$_CONF['rdf_storytext'] = 1;

//@@@@@＜日本語版独自設定＞
// RSS ファイル登録時のデフォルト言語タイプ
$_CONF['rdf_language']  = 'ja';

// ポータルブロック RSSフィード読み込み数制限（0:無制限 1以上:最大数）
$_CONF['syndication_max_headlines'] = 0; 
// 　ブロックメニューごとに最大数を別途設定できます．


// Copyrightに表記する年．指定されていなければ，現在の年を表示．通常コメントアウト
// $_CONF['copyrightyear'] = '2007';


// 画像オプション設定

//@@@@@＜日本語版独自設定＞
// $_CONF['image_lib']を'imagemagick', 'netpbm',または 'gdlib' に設定すると，指定より大きな
// 画像をリサイズしてアップロードし，画像のサムネイルを自動作成します．
// もしリサイズしたくないときはこのままにしてください．ただし，指定より大きな画像の場合には，
// 警告が表示されて記事を正しく設置できません．
// 'gdlib'推奨
$_CONF['image_lib'] = 'gdlib';    // （'netpbm', 'imagemagick', 'gdlib'）

// 'imagemagick'を選んだら次のようなパスを指定してください。
// 注意: ImageMagick version 5.4.9 以上で
//$_CONF['path_to_mogrify']       = '/path/to/mogrify';

// 'netpbm' を選んだら次のようなパスを指定してください。
// 注意: NETPBM, Gallery package http://sourceforge.net/projects/galleryから
// 最新バージョンをダウンロードしてください。そこからnetpbmターボールを抜き出し，
// 展開して netpbmディレクトリを作成しアップしてください。 
// 唯一の問題は，その中で必要なのはgiftopnm,jpegtopnm, pngtopnm, ppmtogif, 
// pnmtojpeg, pnmtopng とpnmscaleだけだということです。
//$_CONF['path_to_netpbm']        = '/path/to/netpbm/';

// 画像のアップロードエラーをエラーログに記述。（true:記述 ）
// $_CONF['debug_image_upload'] = true;

// オリジナルスケールの画像
// （1:保存 0:保存しない）＜日本語版独自設定＞
//   保存すると，サムネールからオリジナル画像へリンクされます．
//   注意:サーバーの大きなスペースを取られます．
$_CONF['keep_unscaled_image']   = 1; 

// オリジナルスケールの画像を保存するとき(keep_unscaled_image参照),
// 記事の中で，サムネイル自動タグ[imageX]と共にオリジナル画像自動タグ[unscaledX]を選択できる．
// 1:選択できる 0:選択できない
$_CONF['allow_user_scaling']    = 1;

// 記事　画像設定
//@@@@@＜日本語版独自設定＞
// 画像最大幅．この幅を超えるとアップロードできないか，あるいはリサイズされる．
// (上記 $_CONF['image_lib'] の設定による．)＜日本語版独自設定＞
$_CONF['max_image_width']       = 160;     // 横幅　ピクセル以下
$_CONF['max_image_height']      = 120;     // 高さ　ピクセル以下
$_CONF['max_image_size']        = 1048576; // 1048576 = 1MB

// トピックアイコン設定
// トピックアイコンの最大幅．この幅を超えるとアップロードできないか，
// あるいはリサイズされる． (上記 $_CONF['image_lib'] の設定による．)
$_CONF['max_topicicon_width']   = 128;      // 横幅　ピクセル以下
$_CONF['max_topicicon_height']  = 128;      // 高さ　ピクセル以下
$_CONF['max_topicicon_size']    = 65536;   // 65536 = 64KB

// アバター画像設定
// ユーザー画像（アバター画像）設定 この幅を超えるとアップロードできないか，
// あるいはリサイズされる． (上記 $_CONF['image_lib'] の設定による．)
$_CONF['max_photo_width']       = 128;     // 横幅　ピクセル以下
$_CONF['max_photo_height']      = 128;     // 高さ　ピクセル以下
$_CONF['max_photo_size']        = 65536;   // 65536 = 64KB

// true:もしユーザーが写真をアップしなければアバター画像はgravatar.com 
// からリクエストされる．
//  (アップロードされた画像はいつも優先されます．)
// このモードをONにするとサイトの表示が遅くなる場合があるので注意．
$_CONF['use_gravatar'] = false;

// gravatar.comではアバターの"movie-style"レーティング(G, PG, R, X)を提供します.
// 'R'は，G, PG, Rのレーティングを使えます．(Xではなく).
// $_CONF['gravatar_rating'] = 'R';

// 最大画像ピクセル
// $_CONF['force_photo_width'] = 75;

// アバターがないときに表示されるデフォルト画像
// $_CONF['default_photo'] = 'http://example.com/default.jpg';

// コメント設定
$_CONF['commentspeedlimit']     = 45;    // コメントの投稿の最小間隔（秒数）
$_CONF['comment_limit']         = 100;   // 同時に可能なコメントの数

// デフォルトコメント表示モード（'threaded','nested', 'nocomments', 'flat'）
//@@@@@＜日本語版独自設定＞
$_CONF['comment_mode']          = 'flat';

// 記事新規作成デフォルト設定（0:コメント許可 -1:コメント不可）
$_CONF['comment_code']          = 0;     // 

// ユーザログイン設定
// 次にパスワード変更要求を送信するまでにまたなければならない時間
$_CONF['passwordspeedlimit'] = 300;  // seconds = 5 minutes

// パスワード要求間隔（秒数） 連続して要求できない．
$_CONF['login_attempts']   = 3;      // 試行できるログイン回数．
$_CONF['login_speedlimit'] = 300;    // 設定回数失敗後，再開可能まち時間（秒数）


// HTML タグのパラメータチェック

//@@@@@＜日本語版独自設定＞
// *** 以下のタグを許すとアタックされる危険があります．
// *** 注意するタグ: <img> <span> <marquee> <script> <embed> <object> <iframe>

// 一般ユーザが投稿時に使えるHTMLタグと属性．

$_CONF['user_html'] = array (
    'a'    => array('href' => 1, 'title' => 1, 'rel' => 1),
    'b'    => array(),
    'blockquote'=> array(),
    'br'   => array('clear' => 1),
    'code' => array(),
    'div'   => array('class' => 1),
    'font' => array('color' => 1),
    'em'   => array(),
    'hr'   => array(),
    'i'    => array(),
    'li'   => array(),
    'ol'   => array(),
    'p'    => array('lang' => 1),
    'pre'  => array(),
    'strong'  => array(),
    'tt'   => array(),
    'ul'   => array()
);

// 管理ユーザーが投稿時に使えるHTMLタグと属性．user_htmlにマージされます．＜日本語版独自設定＞
$_CONF['admin_html'] = array (
    'a'     => array('href' => 1, 'title' => 1, 'id' => 1, 'lang' => 1, 'name' => 1, 'type' => 1, 'rel' => 1),
    'br'   => array('clear' => 1,'style' => 1),
    'caption'   => array('style' => 1),
    'div'   => array('class' => 1, 'id' => 1, 'style' => 1),
    'embed'      => array('src' => 1, 'loop' => 1, 'quality' => 1, 'width' => 1, 'height' => 1, 'type' => 1, 'pluginspage' => 1, 'align' => 1),
    'h1'   => array('class' => 1, 'id' => 1, 'style' => 1),
    'h2'   => array('class' => 1, 'id' => 1, 'style' => 1),
    'h3'   => array('class' => 1, 'id' => 1, 'style' => 1),
    'h4'   => array('class' => 1, 'id' => 1, 'style' => 1),
    'h5'   => array('class' => 1, 'id' => 1, 'style' => 1),
    'h6'   => array('class' => 1, 'id' => 1, 'style' => 1),
    'hr'     => array('class' => 1, 'id' => 1, 'align' => 1),
    'img'   => array('src' => 1, 'width' => 1, 'height' => 1, 'vspace' => 1, 'hspace' => 1, 'dir' => 1, 'align' => 1, 'valign' => 1, 'border' => 1, 'lang' => 1, 'longdesc' => 1, 'title' => 1, 'id' => 1, 'alt' => 1, 'style' => 1),
    'noscript'   => array(),
    'object'     => array('type' => 1,'data' => 1,'classid' => 1, 'codebase' => 1, 'width' => 1, 'height' => 1, 'align' => 1),
    'ol'     => array('class' => 1, 'style' => 1),
    'p'     => array('class' => 1, 'id' => 1, 'align' => 1, 'lang' => 1),
    'param'      => array('name' => 1, 'value' => 1),
    'script'     => array('src' => 1, 'language' => 1, 'type' => 1),
    'span'  => array('class' => 1, 'id' => 1, 'lang' => 1),
    'table' => array('class' => 1, 'id' => 1, 'width' => 1, 'border' => 1, 'cellspacing' => 1, 'cellpadding' => 1),
    'tbody'    => array(),
    'td'    => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1),
    'th'    => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1),
    'tr'    => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1),
    'ul'     => array('class' => 1, 'style' => 1)
);

// アドバンストエディタ用．管理ユーザーが使ってもよいHTMLタグと属性．user_htmlにマージされます．＜日本語版独自設定＞
if ($_CONF['advanced_editor']) {
    $_CONF['admin_html']['a'] = array('href' => 1, 'title' => 1, 'id' => 1, 'lang' => 1, 'name' => 1, 'type' => 1, 'rel' => 1);
    $_CONF['admin_html']['br'] = array('clear' => 1,'style' => 1);
    $_CONF['admin_html']['caption'] = array('style' => 1);
    $_CONF['admin_html']['div'] = array('class' => 1, 'id' => 1, 'style' => 1);
    $_CONF['admin_html']['embed'] = array('src' => 1, 'loop' => 1, 'quality' => 1, 'width' => 1, 'height' => 1, 'type' => 1, 'pluginspage' => 1, 'align' => 1);
    $_CONF['admin_html']['h1'] = array('class' => 1, 'id' => 1, 'style' => 1);
    $_CONF['admin_html']['h2'] = array('class' => 1, 'id' => 1, 'style' => 1);
    $_CONF['admin_html']['h3'] = array('class' => 1, 'id' => 1, 'style' => 1);
    $_CONF['admin_html']['h4'] = array('class' => 1, 'id' => 1, 'style' => 1);
    $_CONF['admin_html']['h5'] = array('class' => 1, 'id' => 1, 'style' => 1);
    $_CONF['admin_html']['h6'] = array('class' => 1, 'id' => 1, 'style' => 1);
    $_CONF['admin_html']['hr'] = array('class' => 1, 'id' => 1, 'align' => 1);
    $_CONF['admin_html']['img'] = array('src' => 1, 'width' => 1, 'height' => 1, 'vspace' => 1, 'hspace' => 1, 'dir' => 1, 'align' => 1, 'valign' => 1, 'border' => 1, 'lang' => 1, 'longdesc' => 1, 'title' => 1, 'id' => 1, 'alt' => 1, 'style' => 1);
    $_CONF['admin_html']['noscript'] = array();
    $_CONF['admin_html']['object'] = array('type' => 1,'data' => 1,'classid' => 1, 'codebase' => 1, 'width' => 1, 'height' => 1, 'align' => 1);
    $_CONF['admin_html']['ol'] = array('class' => 1, 'style' => 1);
    $_CONF['admin_html']['p'] = array('class' => 1, 'id' => 1, 'align' => 1, 'lang' => 1);
    $_CONF['admin_html']['param'] = array('name' => 1, 'value' => 1);
    $_CONF['admin_html']['script'] = array('src' => 1, 'language' => 1, 'type' => 1);
    $_CONF['admin_html']['span' ] = array('class' => 1, 'id' => 1, 'lang' => 1);
    $_CONF['admin_html']['table'] = array('class' => 1, 'id' => 1, 'width' => 1, 'border' => 1, 'cellspacing' => 1, 'cellpadding' => 1);
    $_CONF['admin_html']['tbody'] = array();
    $_CONF['admin_html']['td'] = array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1);
    $_CONF['admin_html']['th'] = array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1);
    $_CONF['admin_html']['tr'] = array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1);
    $_CONF['admin_html']['ul'] = array('class' => 1, 'style' => 1);
}


//@@@@@＜日本語版独自設定＞
// HTMLフィルター
// 1:すべてのRootグループのユーザに，HTMLフィルターを無効にする．
//   すべてのRootグループのユーザが信頼できる場合にのみこのモードを
//   設定してください．Cross Site Scripting等に注意を払ってあなたの
//   リスクで設定してください．
// 0:すべてのユーザに，HTMLフィルターを適用する．
//   アドバンストエディタ
$_CONF['skip_html_filter_for_root'] = 1;
// 

// list of protocols that are allowed in links
// 自動リンクされるプロトコル
$_CONF['allowed_protocols'] = array ('http', 'https', 'ftp');

// disables autolinks if set to 1
// 記事のＵＲＬ自動リンク
$_CONF['disable_autolinks'] = 0;    // 0:URLの自動リンク実行 1:不可

//@@@@@＜日本語版独自設定＞
// バッドワードチェック
$_CONF['censormode']    = 0;
$_CONF['censorreplace'] = '*censored*';
$_CONF['censorlist']    = array('fuck','cunt','fucker','fucking','pussy','cock','c0ck',' cum ','twat','clit','bitch','fuk','fuking','motherfucker');


// IP検索サポート
//
// $_CONF['ip_lookup']にIPアドレス検索サービスのURLが設定されていれば
// Geeklog はIPアドレスをクリックすることで訪問者がどこから来たかがわかります。
// リモートサービスや，Tom WilletのNettoolsプラグインのような機能です。
// URLの中の '*'が置き換わります。
// Tom WilletのNettoolsプラグインがインストールされているならコメントアウトしてください．
// $_CONF['ip_lookup'] = $_CONF['site_url'] . '/nettools/whois.php?domain=*';


// URLリライト
// Geeklog は，シンプルで使いやすいURLリライト機能をもっています． 
// URLリライト機能により，クローラーと親和性が高くなります．
// (すなわち，検索エンジンのインデックス取得に有利でSEOに効果的です．) 
// この機能は，記事と静的ページプラグインで機能します．
// Note: Apacheの全バージョン対応(Linuxと Windows はテストOK).
//       IISはPHP CGI bugのため不可
$_CONF['url_rewrite'] = false;    // false:機能オフ true:機能オン
//$_CONF['url_rewrite'] = true;    // false:機能オフ true:機能オン

// 管理者の新規作成の際のパーミッションのデフォルトを設定．
// 所有者，グループ，メンバ，ゲストユーザごとに，次の値を設定できます．
// 3 = R:閲覧 + E:編集(所有者，グループのみ)
// 2 = R:閲覧のみ
// 0 = どちらも許可しない
//   ※1 編集のみのモードは利用できません．
$_CONF['default_permissions_block'] = array (3, 2, 2, 2); // ブロック
$_CONF['default_permissions_story'] = array (3, 2, 2, 2); // 記事
$_CONF['default_permissions_topic'] = array (3, 2, 2, 2); // 話題


// 便利なGeeklog専用の定義　改行や，バージョン名

if (!defined ('LB')) {
    define('LB',"\n");
}
if (!defined ('VERSION')) {
    define('VERSION', '1.4.1');
}

//@@@@@＜中国語版独自設定＞
$_STATES = array
    (
    '--'=>'请选择',
    '01'=>'北京市',
    '02'=>'天津市',
    '03'=>'河北省',
    '04'=>'山西省',
    '05'=>'内蒙古自治区',
    '06'=>'辽宁省',
    '07'=>'吉林省',
    '08'=>'黑龙江省',
    '09'=>'上海市',
    '10'=>'江苏省',
    '11'=>'浙江省',
    '12'=>'安徽省',
    '13'=>'福建省',
    '14'=>'江西省',
    '15'=>'山东省',
    '16'=>'河南省',
    '17'=>'湖北省',
    '18'=>'湖南省',
    '19'=>'广东省',
    '20'=>'广西壮族自治区',
    '21'=>'海南省',
    '22'=>'重庆市',
    '23'=>'四川省',
    '24'=>'贵州省',
    '25'=>'云南省',
    '26'=>'西藏自治区',
    '27'=>'陕西省',
    '28'=>'甘肃省',
    '29'=>'青海省',
    '30'=>'宁夏回族自治区',
    '31'=>'新疆维吾尔自治区',
    '32'=>'香港特别行政区',
    '33'=>'澳门特别行政区',
    '34'=>'台湾',
    '35'=>'海外'
    );

//@@@@@20070602update ---->
//プラグイン　userconfig 用
if (file_exists($_CONF["path_data"]."userconfig_now.php")) {
    require_once( $_CONF["path_data"]."userconfig_now.php" );
}
//@@@@@20070602update<----


?>
