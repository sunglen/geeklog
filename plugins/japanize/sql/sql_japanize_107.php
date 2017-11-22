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
    title = 'User Functions'
    WHERE name = 'user_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'Admins Only'
    WHERE name = 'admin_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'Topics'
    WHERE name = 'section_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'Poll'
    WHERE name = 'polls_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'Events'
    WHERE name = 'events_block'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'What''s New'
    WHERE name = 'whats_new_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'Who''s Online'
    WHERE name = 'whosonline_block'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'Older Stories'
    WHERE name = 'older_stories'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['blocks']} SET 
    title = 'About Geeklog'
    ,content = '<p><b>Welcome to Geeklog!</b></p><p>If you''re already familiar with Geeklog - and especially if you''re not: There have been many improvements to Geeklog since earlier versions that you might want to read up on. Please read the <a href=\"docs/changes.html\">release notes</a>. If you need help, please see the <a href=\"docs/support.html\">support options</a>.</p>'
    WHERE name = 'first_block'
    ";

?>
