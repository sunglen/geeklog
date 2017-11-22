<?php
// +---------------------------------------------------------------------------+
// | グループ詳細を日本語版化する                                              |
// +---------------------------------------------------------------------------+
// $Id: sql_japanize5.php
// もし万一エンコードの種類が  utf-8でない場合は、utf-8に変換してください。
// 最終更新日　2009/10/07 tsuchi AT geeklog DOT jp


$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'サイト管理者'
    WHERE grp_name = 'Root'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'すべてのユーザ'
    WHERE grp_name = 'All Users'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = '記事管理者'
    WHERE grp_name = 'Story Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'ブロック管理者'
    WHERE grp_name = 'Block Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = '話題管理者'
    WHERE grp_name = 'Topic Admin'
    ";


$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'ユーザ管理者'
    WHERE grp_name = 'User Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'プラグイン管理者'
    WHERE grp_name = 'Plugin Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'グループ管理者兼ユーザ管理者'
    WHERE grp_name = 'Group Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'メール管理者'
    WHERE grp_name = 'Mail Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'すべての登録ユーザ'
    WHERE grp_name = 'Logged-in Users'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'リモートユーザ'
    WHERE grp_name = 'Remote Users'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'フィード管理者'
    WHERE grp_name = 'Syndication Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'カレンダ管理者'
    WHERE grp_name = 'Calendar Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'リンク管理者'
    WHERE grp_name = 'Links Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'アンケート管理者'
    WHERE grp_name = 'Polls Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'スパム管理者'
    WHERE grp_name = 'spamx Admin'
    ";


$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = '静的ページ管理者'
    WHERE grp_name = 'Static Pages Admin'
    ";


$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = '日本語化管理者'
    WHERE grp_name = 'japanize Admin'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'ファイル管理者'
    WHERE grp_name = 'filemgmt Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = '掲示板管理者'
    WHERE grp_name = 'forum Admin'
    ";
//---

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'WebサービスAPIユーザ'
    WHERE grp_name = 'Webservices Users'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'コメント管理者'
    WHERE grp_name = 'Comment Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'コメント承認者'
    WHERE grp_name = 'Comment Submitters'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Autotags管理者'
    WHERE grp_name = 'Autotags Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'カスタムメニュー管理者'
    WHERE grp_name = 'CustomMenu Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'データプロクシー管理者'
    WHERE grp_name = 'DataProxy Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Dbman管理者'
    WHERE grp_name = 'dbman Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Mycaljp管理者'
    WHERE grp_name = 'Mycaljp Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'QR管理者'
    WHERE grp_name = 'nmoxqrblock Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = '話題譲渡管理者'
    WHERE grp_name = 'nmoxtopicown Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'サイトマップ管理者'
    WHERE grp_name = 'sitemap Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'カレンダ管理者'
    WHERE grp_name = 'Calendar Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'テーマエディタ管理者'
    WHERE grp_name = 'themedit Admin'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'GoogleMaps管理者'
    WHERE grp_name = 'GoogleMaps Admin'
    ";


?>
