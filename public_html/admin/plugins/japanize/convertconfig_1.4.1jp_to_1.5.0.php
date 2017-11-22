<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | userconfig_bak.php(userconfigプラグインのデータバックアップ)              |
// |  をGl1.5.0 のconfigテーブルに移行する処理                                 |
// +---------------------------------------------------------------------------+
// $Id: convertconfig_1.4.1_to_1.5.0.php
// public_html/admin/plugins/japanize/convertconfig_1.4.1jp_to_1.5.0.php
// 20080717 tsuchi AT geeklog DOT jp

//

define ('THIS_SCRIPT', 'convertconfig_1.4.1jp_to_1.5.0.php');
define ('THIS_PLUGIN', 'japanize');
//define ('THIS_SCRIPT', 'test.php');

include_once('japanize_functions.php');

function fncDisply()
{
    global $_CONF;

    $retval = "";
    $retval .= "<h1>Config 移行 </h1>".LB;

    if (file_exists($_CONF["path_data"]."userconfig_bak.php")) {
        $retval .= "userconfig_bak.php(userconfigプラグインのデータバックアップ)".LB;
        $retval .= "をconfigテーブルに移行します".LB;
        $retval .= "<form action="."'".THIS_SCRIPT."'"."method='post'>".LB;
        $retval .= "    <input type='submit' name='action' value='実行'>".LB;
        $retval .= "    <input type='submit' name='action' value='キャンセル'>".LB;
        $retval .= "</form>".LB;
    }else{
        $retval .= "userconfig_bak.php(userconfigプラグインのデータバックアップ)".LB;
        $retval .= "が存在しません".LB;
    }


    return $retval ;

}

function fncSubmit($config)
{
    global $_CONF;

    //実行
    if (file_exists($_CONF["path_data"]."userconfig_bak.php")) {
        require_once( $_CONF["path_data"]."userconfig_bak.php" );

        $config->set('site_name', $_CONF['site_name']);
        $config->set('site_slogan', $_CONF['site_slogan']);

        $config->set('theme', $_CONF['theme']);

        $config->set('menu_elements', $_CONF['menu_elements']);


        $config->set('site_mail', $_CONF['site_mail']);

        $config->set('disable_new_user_registration', $_CONF['disable_new_user_registration']);
        $config->set('disable_autolinks', $_CONF['disable_autolinks']);

        $config->set('loginrequired', $_CONF['loginrequired']);

        $config->set('submitloginrequired', $_CONF['submitloginrequired']);
        $config->set('commentsloginrequired', $_CONF['commentsloginrequired']);
        $config->set('statsloginrequired', $_CONF['statsloginrequired']);
        $config->set('searchloginrequired', $_CONF['searchloginrequired']);
        $config->set('profileloginrequired', $_CONF['profileloginrequired']);
        $config->set('emailuserloginrequired', $_CONF['emailuserloginrequired']);
        $config->set('emailstoryloginrequired', $_CONF['emailstoryloginrequired']);
        $config->set('directoryloginrequired', $_CONF['directoryloginrequired']);

        $config->set('storysubmission', $_CONF['storysubmission']);
        $config->set('usersubmission', $_CONF['usersubmission']);

        $config->set('allow_user_themes', $_CONF['allow_user_themes']);
        $config->set('allow_username_change', $_CONF['allow_username_change']);
        $config->set('allow_account_delete', $_CONF['allow_account_delete']);

        $config->set('hide_author_exclusion', $_CONF['hide_author_exclusion']);

        $config->set('advanced_editor', $_CONF['advanced_editor']);
        $config->set('notification', $_CONF['notification']);
        $config->set('listdraftstories', $_CONF['listdraftstories']);

        $config->set('maximagesperarticle', $_CONF['maximagesperarticle']);
        $config->set('limitnews', $_CONF['limitnews']);
        $config->set('innews', $_CONF['innews']);

        $config->set('contributedbyline', $_CONF['contributedbyline']);
        $config->set('hideviewscount', $_CONF['hideviewscount']);

        $config->set('hideemailicon', $_CONF['hideemailicon']);
        $config->set('hideprintericon', $_CONF['hideprintericon']);
        $config->set('allow_page_breaks', $_CONF['allow_page_breaks']);

        $config->set('article_image_align', $_CONF['article_image_align']);

        $config->set('show_topic_icon', $_CONF['show_topic_icon']);
        $config->set('max_image_width', $_CONF['max_image_width']);
        $config->set('max_image_height', $_CONF['max_image_height']);
        $config->set('max_topicicon_width', $_CONF['max_topicicon_width']);
        $config->set('max_topicicon_height', $_CONF['max_topicicon_height']);
        $config->set('postmode', $_CONF['postmode']);

        $config->set('showstorycount', $_CONF['showstorycount']);
        $config->set('showsubmissioncount', $_CONF['showsubmissioncount']);
        $config->set('hide_home_link', $_CONF['hide_home_link']);

        $config->set('hidenewstories', $_CONF['hidenewstories']);
        $config->set('hidenewcomments', $_CONF['hidenewcomments']);
        $config->set('hidenewtrackbacks', $_CONF['hidenewtrackbacks']);
        $config->set('hidenewplugins', $_CONF['hidenewplugins']);


        $config->set('default_permissions_block', $_CONF['default_permissions_block']);
        $config->set('default_permissions_story', $_CONF['default_permissions_story']);
        $config->set('default_permissions_topic', $_CONF['default_permissions_topic']);

        $config->set('censormode', $_CONF['censormode']);
        $config->set('censorreplace', $_CONF['censorreplace']);
        $config->set('censorlist', $_CONF['censorlist']);

        $config->set('allow_domains', $_CONF['allow_domains']);

        $config->set('url_rewrite', $_CONF['url_rewrite']);

        $config->set('date', $_CONF['date']);

        $config->set('daytime', $_CONF['daytime']);
        $config->set('shortdate', $_CONF['shortdate']);
        $config->set('dateonly', $_CONF['dateonly']);
        $config->set('timeonly', $_CONF['timeonly']);
        $config->set('week_start', $_CONF['week_start']);

        $config->set('image_lib', $_CONF['image_lib']);
        $config->set('keep_unscaled_image', $_CONF['keep_unscaled_image']);
        $config->set('trackback_enabled', $_CONF['trackback_enabled']);

        $config->set('pingback_enabled', $_CONF['pingback_enabled']);
        $config->set('ping_enabled', $_CONF['ping_enabled']);
        $config->set('trackback_code', $_CONF['trackback_code']);
        $config->set('trackbackspeedlimit', $_CONF['trackbackspeedlimit']);
        $config->set('backend', $_CONF['backend']);
        $config->set('rdf_file', $_CONF['rdf_file']);

        $config->set('rdf_limit', $_CONF['rdf_limit']);
        $config->set('rdf_storytext', $_CONF['rdf_storytext']);
        $config->set('syndication_max_headlines', $_CONF['syndication_max_headlines']);

        $config->set('commentspeedlimit', $_CONF['commentspeedlimit']);
        $config->set('comment_limit', $_CONF['comment_limit']);
        $config->set('comment_code', $_CONF['comment_code']);

        $config->set('check_trackback_link', $_CONF['check_trackback_link']);
        $config->set('multiple_trackbacks', $_CONF['multiple_trackbacks']);
        $config->set('pingback_self', $_CONF['pingback_self']);

        $config->set('hour_mode', $_CONF['hour_mode']);
        $config->set('rootdebug', $_CONF['rootdebug']);
        $config->set('disallow_domains', $_CONF['disallow_domains']);

        $config->set('title_trim_length', $_CONF['title_trim_length']);
        $config->set('draft_flag', $_CONF['draft_flag']);
        $config->set('frontpage', $_CONF['frontpage']);
        $config->set('hide_no_news_msg', $_CONF['hide_no_news_msg']);
        $config->set('hide_main_page_navigation', $_CONF['hide_main_page_navigation']);
        $config->set('onlyrootfeatures', $_CONF['onlyrootfeatures']);

        $config->set('newstoriesinterval', $_CONF['newstoriesinterval']);
        $config->set('newcommentsinterval', $_CONF['newcommentsinterval']);
        $config->set('newtrackbackinterval', $_CONF['newtrackbackinterval']);
        $config->set('page_break_comments', $_CONF['page_break_comments']);

        $config->set('show_right_blocks', $_CONF['show_right_blocks']);

            //language_flag
            //  $_CONF['languages']=null;
            //  $_CONF['language_files']=null;

            //$_CONF['calendarloginrequired']

            //$_CONF['eventsubmission']

            //$_CONF['personalcalendars']
            //$_CONF['showupcomingevents']
            //$_CONF['upcomingeventsrange']
            //$_CONF['event_types']
            //$_CONF['default_permissions_event']

            //$_CONF['locale']


    //-----

    }
    return "実行しました!";
}


// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+
$action ="";
if (isset ($_REQUEST['action'])) {
    $action = COM_applyFilter($_REQUEST['action'],false);
}


$display = '';
$display .= COM_siteHeader ('menu', $LANG_JPN['pinameadmin']);
if (isset ($_REQUEST['msg'])) {
    $display .= COM_showMessage (COM_applyFilter ($_REQUEST['msg'],
                                                  true), 'japanize');
}

$display.=ppNavbarjp($navbarMenu,$LANG_JPN_admin_menu['4']);

// 初期表示
if  ($action ==""){
    $display.=fncDisply();
// 実行
}elseif ($action =="実行"){
    $display.=fncSubmit($config);
}else{
    $display .="キャンセルしました!";
}

$display.= COM_siteFooter ();

echo $display;


?>
