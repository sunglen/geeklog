<?php
// +---------------------------------------------------------------------------+
// | グループ詳細を英語に戻す                                                  |
// +---------------------------------------------------------------------------+
// $Id: sql_japanize105.php
// もし万一エンコードの種類が  utf-8でない場合は、utf-8に変換してください。
// 最終更新日　2009/10/07 tsuchi AT geeklog DOT jp

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to the site'
    WHERE grp_name = 'Root'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Group that a typical user is added to'
    WHERE grp_name = 'All Users'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to story features'
    WHERE grp_name = 'Story Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to block features'
    WHERE grp_name = 'Block Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to topic features'
    WHERE grp_name = 'Topic Admin'
    ";


$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to topic features'
    WHERE grp_name = 'User Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to plugin features'
    WHERE grp_name = 'Plugin Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to plugin features'
    WHERE grp_name = 'Group Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Can use Mail Utility'
    WHERE grp_name = 'Mail Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'All registered members'
    WHERE grp_name = 'Logged-in Users'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can have authenticated against a remote server.'
    WHERE grp_name = 'Remote Users'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Can create and modify web feeds for the site'
    WHERE grp_name = 'Syndication Admin'
    ";



$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to calendar features'
    WHERE grp_name = 'Calendar Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to links features'
    WHERE grp_name = 'Links Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to polls features'
    WHERE grp_name = 'Polls Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the Spam-X plugin'
    WHERE grp_name = 'spamx Admin'
    ";


$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Can administer static pages'
    WHERE grp_name = 'Static Page Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to japanize features'
    WHERE grp_name = 'japanize Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the filemgmt plugin'
    WHERE grp_name = 'filemgmt Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the forum plugin'
    WHERE grp_name = 'forum Admin'
    ";
//---

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Can use the Webservices API (if restricted)'
    WHERE grp_name = 'Webservices Users'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Can moderate comments'
    WHERE grp_name = 'Comment Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Can submit comments'
    WHERE grp_name = 'Comment Submitters'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the Autotags plugin'
    WHERE grp_name = 'Autotags Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to custommenu features'
    WHERE grp_name = 'CustomMenu Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to DataProxy features'
    WHERE grp_name = 'DataProxy Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the dbman plugin'
    WHERE grp_name = 'dbman Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the filemgmt plugin'
    WHERE grp_name = 'filemgmt Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the forum plugin'
    WHERE grp_name = 'forum Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to Japanize features'
    WHERE grp_name = 'Japanize Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to Links features'
    WHERE grp_name = 'Links Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to Mycaljp features'
    WHERE grp_name = 'Mycaljp Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the nmoxqrblock plugin'
    WHERE grp_name = 'nmoxqrblock Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the nmoxtopicown plugin'
    WHERE grp_name = 'nmoxtopicown Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to Polls features'
    WHERE grp_name = 'Polls Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the sitemap plugin'
    WHERE grp_name = 'sitemap Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to Calendar features'
    WHERE grp_name = 'Calendar Admin'
    ";

$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the Spam-X plugin'
    WHERE grp_name = 'spamx Admin'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the Static Pages plugin'
    WHERE grp_name = 'Static Pages Admin'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Users in this group can administer the themedit plugin'
    WHERE grp_name = 'themedit Admin'
    ";
$_SQL[] = "
    UPDATE   {$_TABLES['groups']} SET
    grp_descr = 'Has full access to GoogleMaps features'
    WHERE grp_name = 'GoogleMaps Admin'
    ";



?>
