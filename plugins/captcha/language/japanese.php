<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v4 Plugin                                                         |
// +---------------------------------------------------------------------------+
// | This is the Japanese language page for the CAPTCHA Plugin                 |
// +---------------------------------------------------------------------------|
// | Copyright (C) 2002,2005,2006,2007 by the following authors:               |
// |                                                                           |
// | Author: mystral-kk    - geeklog AT mystral-kk DOT net                     |
// |         Hiroron       - hiroron AT hiroron DOT com                        |
// +---------------------------------------------------------------------------|
// |                                                                           |
// | If you translate this file, please consider uploading a copy at           |
// |    http://www.mediagallery.org so others can benefit from your            |
// |    translation.  Thank you!                                               |
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

$LANG_CP00 = array (
    'menulabel'         => 'CAPTCHA',
    'plugin'            => 'CAPTCHA',
    'access_denied'     => 'アクセス拒否',
    'access_denied_msg' => 'このページにアクセスすることはできません。ユーザ名とIPアドレスは記録させていただきました。',
    'admin'             => 'CAPTCHA 管理画面',
    'install_header'    => 'CAPTCHAプラグイン インストール',
    'installed'         => 'CAPTCHAプラグインはインストールされました。',
    'uninstalled'       => 'CAPTCHAプラグインはインストールされていません。',
    'install_success'   => 'CAPTCHAプラグインはインストールされました。<br /><br /><a href="%s">管理画面</a>をご覧ください。',
    'install_failed'    => 'インストールに失敗しました。 -- エラーログをご覧ください。',
    'uninstall_msg'     => 'プラグインはアンインストールされました。',
    'install'           => 'インストール',
    'uninstall'         => 'アンインストール',
    'warning'           => '警告! プラグインはまだ有効です。',
    'enabled'           => 'プラグイン無効',
    'readme'            => 'CAPTCHAプラグインをインストール・アンインストールします。',
    'installdoc'        => "<a href=\"{$_CONF['site_admin_url']}/plugins/captcha/install_doc.html\">インストールドキュメント</a>",
    'overview'          => 'CAPTCHAはGeeklogプラグインです。セキュリティアップのためのものです。<br /><br />A CAPTCHA (an acronym for "Completely Automated Public Turing test to tell Computers and Humans Apart", trademarked by Carnegie Mellon University) is a type of challenge-response test used in computing to determine whether or not the user is human.  By presenting a difficult to read graphic of letters and numbers, it is assumed that only a human could read and enter the characters properly.  By implementing the CAPTCHA test, it should help reduce the number of Spambot entries on your site.',
    'details'           => 'CAPTCHAプラグインでCAPTCHA画像はTrue Type fonts(TTF)に対応したGDまたはImageMagick画像ライブラリで作成されます。ホスティングプロバイダにTTFがサポートされている確認してください。',
    'preinstall_check'  => 'CAPTCHAプレインストールチェック:',
    'geeklog_check'     => 'Geeklog 1.4.1 以上で動作します。現バージョン：<b>%s</b>.',
    'php_check'         => 'PHP v4.3.0以上 現バージョン：<b>%s</b>.',
    'preinstall_confirm' => "CAPTCHAインストールの詳細は，<a href=\"{$_CONF['site_admin_url']}/plugins/captcha/install_doc.html\">インストールマニュアル</a>を。",
    'refresh'			=> '<a href="' . $_CONF['site_url'] . '/users.php?mode=new">新イメージ</a>',
    'captcha_help'		=> 'テキストを入力してください。大文字と小文字に注意してください。',
    'bypass_error'		=> "CAPTCHA処理を行います。",
    'bypass_error_blank' => "テキストを入力してください。",
    'entry_error'		=> 'CAPTCHAテキストが合致しませんでした。再度入力してください。<b>大文字と小文字に注意してください。</b>',
    'captcha_info'      => 'CAPTCHAプラグインはあなたのGeeklogサイトをSpamBotsから守ります。',
    'enabled_header'    => '現在のCAPTCHA設定',
    'view_logfile'      => 'CAPTCHA ログ閲覧',
    'log_viewer'        => 'Geeklog ログビューワ',
    'setting_all'       => 'すべて',
    'setting_general'   => '基本',
    'setting_auth_sister' => '妹認証',
    'on'                => 'On',
    'off'               => 'Off',
    'anonymous_only'    => 'ゲストユーザのみ対象とする',
    'enable_comment'    => 'コメント',
    'enable_story'      => '記事投稿',
    'enable_registration' => 'アカウント登録',
    'enable_contact'    => 'コンタクト',
    'enable_emailstory' => '記事メール送信',
    'enable_forum'      => '掲示板',
    'enable_mediagallery' => 'メディアギャラリ (Postcards)',
    'captcha_alt'       => '画像認証',
    'save'              => '保存',
    'cancel'            => 'キャンセル',
    'success'           => 'コンフィギュレーションオプションは保存されました。',
    'gfx_driver'        => 'グラフィックドライバー',
    'gfx_format'        => 'グラフィックフォーマット',
    'convert_path'      => 'ImageMagick変換ユーティリティへのフルパス',
    'gd_libs'           => 'GDライブラリ',
    'gd_sister_libs'    => 'GDライブラリ(妹認証)',
    'imagemagick'       => 'ImageMagick',
    'static_images'     => '固定画像利用',
    'image_set'			=> '固定画像セット',
    'debug'             => 'デバッグ',
    'configuration'     => 'CAPTCHAコンフィギュレーション',
    'integration'       => 'CAPTCHA設定',
    'reload'            => '再表示',
    'reload_failed'     => '申し訳ありません。認証用画像がロードされませんでした。',
    'reload_too_many'   => '認証用画像の再表示は５回までです。',
    'session_expired'   => 'あなたのCAPTCHAセッションの期限が切れました。再度トライしてください。',
    'remoteusers'       => 'すべてのリモートユーザを対象とする',
);

$PLG_captcha_MESSAGE1 = 'CAPTCHAプラグインはインストールされました。';
$PLG_captcha_MESSAGE2 = 'CAPTCHAプラグインのインストールに失敗しました。エラーログをチェックしてください。';

$LANG_CP10 = array (
    'auth_sister'       => '妹認証の設定',
    'auth_sister_package' => '妹(パッケージ)の設定',
    'sister_mes_a'      => 'メッセージ先頭に付加する文字列',
    'sister_mes_b'      => 'メッセージ最後に付加する文字列',
    'sister_len_min'    => '回答文の最小文字数',
    'sister_len_max'    => '回答文の最大文字数',
    'sister_outlen'     => '文字数範囲外のエラー文',
    'sister_image'      => '妹画像ファイル',
    'new_sister_image'  => 'あたらしく妹画像をアップロードする',
    'sister_font'       => 'TTFフォント',
    'new_sister_font'   => 'あたらしくTTFフォントをアップロードする',
    'sister_fsize'      => '文字サイズ',
    'sister_fx'         => '文字のX座標',
    'sister_fy'         => '文字のY座標',
    'sister_words'      => '妹の辞書',
    'sister_css'        => '妹のスタイルシート',
);

?>