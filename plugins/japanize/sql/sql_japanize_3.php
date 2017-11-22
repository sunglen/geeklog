<?php
// +---------------------------------------------------------------------------+
// | 日本語Pingサイトを追加する                                                |
// |                                                                           |
// +---------------------------------------------------------------------------+
// $Id: sql_japanize3.php
// もし万一エンコードの種類が  utf-8でない場合は、utf-8に変換してください。
//@@@@@20080903 「ドリコムRSS」 ウェブサイト変更
// 最終更新日　2007/09/03 tsuchi AT geeklog DOT jp

//http://www.blogpeople.net/
$_SQL[] = "
    DELETE FROM {$_TABLES['pingservice']} Where 
    site_url = 'http://www.blogpeople.net/'
    ";
$_SQL[] = "
    INSERT INTO {$_TABLES['pingservice']} 
    (pid, name, site_url, ping_url, method, is_enabled)
    VALUES (NULL, 'BlogPeople',  'http://www.blogpeople.net/'
    ,'http://www.blogpeople.net/servlet/weblogUpdates', 'weblogUpdates.ping', 1)
    ";
//http://ping.bloggers.jp/
$_SQL[] = "
    DELETE FROM {$_TABLES['pingservice']} Where
    site_url = 'http://ping.bloggers.jp/'
    ";
$_SQL[] = "
    INSERT INTO {$_TABLES['pingservice']} 
    (pid, name, site_url, ping_url, method, is_enabled)
    VALUES (NULL, 'ping.bloggers.jp', 'http://ping.bloggers.jp/'
    , 'http://ping.bloggers.jp/rpc/', 'weblogUpdates.ping', 1)
    ";
//http://ping.rss.drecom.jp/ 
//@@@@@20080903 ウェブサイト変更
$_SQL[] = "
    DELETE FROM {$_TABLES['pingservice']} Where
    site_url = 'http://www.myblog.jp/'
    ";
$_SQL[] = "
    DELETE FROM {$_TABLES['pingservice']} Where
    site_url = 'http://rss.drecom.jp/'
    ";
$_SQL[] = "
    INSERT INTO {$_TABLES['pingservice']} 
    (pid, name, site_url, ping_url, method, is_enabled)
    VALUES (NULL, 'ドリコムRSS', 'http://rss.drecom.jp/'
    , 'http://ping.rss.drecom.jp/', 'weblogUpdates.ping', 1)
    ";
//http://blog.goo.ne.jp/
$_SQL[] = "
    DELETE FROM {$_TABLES['pingservice']} Where
    site_url = 'http://blog.goo.ne.jp/'
    ";
$_SQL[] = "
    INSERT INTO {$_TABLES['pingservice']} 
    (pid, name, site_url, ping_url, method, is_enabled)
    VALUES (NULL, 'ｇoo　ブログ', 'http://blog.goo.ne.jp/'
    , 'http://blog.goo.ne.jp/XMLRPC', 'weblogUpdates.ping', 1)
    ";

//3.ピング送信先に Googleブログ検索 テクノラティ 追加
//Googleブログ検索 拡張ピング
$_SQL[] = "
    DELETE FROM {$_TABLES['pingservice']} Where
    site_url = 'http://blogsearch.google.co.jp/'
    ";
$_SQL[] = "
    INSERT INTO {$_TABLES['pingservice']} 
    (pid, name, site_url, ping_url, method, is_enabled)
    VALUES (NULL, 'Googleブログ検索', 'http://blogsearch.google.co.jp/'
    , 'http://blogsearch.google.co.jp/ping/RPC2', 'weblogUpdates.extendedPing', 1)
    ";
//テクノラティ
$_SQL[] = "
    DELETE FROM {$_TABLES['pingservice']} Where
    site_url = 'http://www.technorati.jp/'
    ";
$_SQL[] = "
    INSERT INTO {$_TABLES['pingservice']} 
    (pid, name, site_url, ping_url, method, is_enabled)
    VALUES (NULL, 'テクノラティ', 'http://www.technorati.jp/'
    , 'http://rpc.technorati.jp/rpc/ping', 'weblogUpdates.ping', 1)
    ";

?>
