<?php
// +---------------------------------------------------------------------------+
// | 初期ブロックタイトル等日本語化                                            |
// +---------------------------------------------------------------------------+
// $Id: sql_japanize6.php
// もし万一エンコードの種類が  utf-8でない場合は、utf-8に変換してください。
// 最終更新日　2008/09/02 tsuchi AT geeklog DOT jp


// (18) 初期ブロックタイトル等日本語化
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'ユーザ情報'
    WHERE name = 'user_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = '管理者専用メニュー'
    WHERE name = 'admin_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = '記事カテゴリ'
    WHERE name = 'section_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'アンケート'
    WHERE name = 'polls_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'イベント'
    WHERE name = 'events_block'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = '新着情報'
    WHERE name = 'whats_new_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'オンラインユーザ'
    WHERE name = 'whosonline_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = '過去記事'
    WHERE name = 'older_stories'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'Geeklogについて'
    ,content = '<p><b>ようこそ、Geeklogへ！</b><p>Geeklogについてのサポートは、 <a href=\"http://www.geeklog.jp\">Geeklog Japanese</a>へ。ドキュメントは <a href=\"http://wiki.geeklog.jp\">Geeklog Wiki ドキュメント</a>をどうぞ。'
    WHERE name = 'first_block'
    ";

?>
