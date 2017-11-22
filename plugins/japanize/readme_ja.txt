--------------------------------------------------------------------------------
Geeklog 日本語化（japanize)プラグイン
tsuchi AT geeklog DOT jp
2008/09/27
--------------------------------------------------------------------------------
概要 ：Geeklog1.5 1.6 を日本人流にするプラグインです
       詳細については、管理画面をご参照ください
--------------------------------------------------------------------------------
ファイル構成
-japanize
  ├ admin
  │ ├ convertconfig_1.4.1jp_to_1.5.0.php
  │ ├ index.php
  │ ├ information.php
  │ ├ install.php
  │ ├ japanize_functions.php
  │ └ settings.php
  ├ custom
  │ └ custom_mail_japanize.php
  ├ doc
  │ 更新履歴ほかのドキュメント
  ├ language
  │ └ japanese_utf-8.php
  ├ lib
  │ └ ppNavbar.php
  ├ public_html
  │ ├ images
  │ │ └ japanize.png
  │ ├ disabledmsg.html
  │ ├ index.html
  │ └ memberlogin_help.php
  ├ sql
  │ ├ updates
  │ │ └ mysql_1.0.2_to_1.0.3.php
  │ ├ sql_japanize_1.php
  │ ├ sql_japanize_2.php
  │ ├ sql_japanize_3.php
  │ ├ sql_japanize_4.php
  │ ├ sql_japanize_5.php
  │ ├ sql_japanize_6.php
  │ ├ sql_japanize_7.php
  │ ├ sql_japanize_8.php
  │ ├ sql_japanize_105.php
  │ ├ sql_japanize_107.php
  │ └ sql_japanize_108.php
  │ templates
  │ ├ admin
  │ │ ├ index.thtml
  │ │ ├ information.thtml
  │ │ └ settings.thtml
  │ └custom-memberlogin.thtml
  ├ autoinstall.php
  ├ functions.inc
  ├ install_defaults.php
  ├ readme_ja.txt
  └ version.php


注1：custom-memberlogin.thtml
     指定されているテーマにcustom-memberlogin.thtmlがある場合は、そちらを
     使用します
注2：指定の言語ファイルがない場合はjapanese_utf-8.phpを使用します
--------------------------------------------------------------------------------
インストール方法
１．データベースおよびファイルのバックアップをとります。
２．標準的なプラグインのファイル配置に従い、ファイルをアップします。
    plugins/　以下に　japanize以下をアップ
    admin/plugins/japanize/以下に　admin以下のファイルを移動
    public_html/japanize/以下に　public_html以下のファイルを移動
３．Rootユーザーとしてログインし，プラグイン管理の画面でインストールを実行します
--------------------------------------------------------------------------------
アンインストール方法
１．データベースおよびファイルのバックアップをとります。
２．Rootユーザーとしてログインし，プラグイン管理の画面で削除を実行します。
３．アップしたファイルを削除します。
--------------------------------------------------------------------------------
通常のアップグレード方法
１．データベースおよびファイルのバックアップをとります。
２．標準的なプラグインのファイル配置に従い、ファイルをアップします。
    plugins/　以下に　japanize以下をアップ
    admin/plugins/japanize/以下に　admin以下のファイルを移動
    public_html/japanize/以下に　public_html以下のファイルを移動
３．Rootユーザーとしてログインし，プラグイン管理の画面で更新を実行します
--------------------------------------------------------------------------------
☆Gl1.6未満の日本語バージョンにインストールまたはアップグレードする場合の注意
    Gl1.6未満の日本語バージョンなどで、lib_custon.php 等で日本語メールを読
    み込んでいる場合は、
    require_once('custom/custom_mail_jp.php');　という行がある場合は
    この行をあらかじめ削除してください。
    残っている場合は
    Fatal error: Cannot redeclare custom_convertencoding() というエラーがでます
--------------------------------------------------------------------------------
