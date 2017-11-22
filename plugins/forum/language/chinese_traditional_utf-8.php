<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog Forums Plugin 2.0 for Geeklog - The Ultimate Weblog               |
// | Official release date: Feb 7,2003                                         |
// +---------------------------------------------------------------------------+
// | japanese_utf-8.php                                                        |
// | Language defines for all text                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// | Geeklog Author: Tony Bibbs       - tony@tonybibbs.com                     |
// +---------------------------------------------------------------------------+
// | FORUM Plugin Authors                                                      |
// | Prototype & Concept    :  Mr.GxBlock of www.gxblock.com                   |
// | Co-Developed by Matthew and Blaine                                        |
// | Matthew DeWyer, contact: matt@mycws.com          www.cweb.ws              |
// | Blaine Lang,    contact: geeklog@langfamily.ca   www.langfamily.ca        |
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
//
# Tranlated by Geeklog Japanese group SaY and Ivy
//@@@@@20050628 2.3用□□　2.3.2_1.3.9用□改定
//@@@@@20051220 2.5RC1.3_1.3.11用□改定
//@@@@@20060327 $LANG_GF00['adminmenu'] 日本版用□活
//@@@@@20060427 $LANG_GF93['addmoderator']
//@@@@@20070104 2.6RC3用□更新(mystral-kk)
# Last Update 2007/02/05 by Ivy (Geeklog Japanese)
//@@@@@20070319 2.6RC4用□更新
//@@@@@20070326 2.6RC5(final)用□更新
//@@@@@20070925 2.7用□更新 $LANG_GF01['admin'],$LANG_GF93['vieworder'] 追加
//@@@@@20080721 2.7.1用□更新 $LANG_GF02['msg202']  追加

if (!defined('XHTML')) {
    define('XHTML', '');
}

$LANG_GF00 = array (
    'admin_only'        => '僅管理員。如果您是管理員，請先登錄。',
    'plugin'            => '插件',
    'pluginlabel'       => '論壇',
    'searchlabel'       => '論壇',
    'statslabel'        => '全論壇發帖',
    'statsheading1'     => '論壇閱覽數前十位的帖子',
    'statsheading2'     => '論壇回復數前十位的帖子',
    'statsheading3'     => '沒有帖子',
    'searchresults'     => '論壇檢索結果 %s',
    'useradminmenu'     => '論壇功能',
    'useradmintitle'    => '論壇用戶設定',
    'access_denied'     => '拒絕訪問',
    'access_denied_msg' => '該頁僅供根用戶訪問。您的名字和ＩＰ地址已被記錄。',
    'admin'             => '插件管理員',
    'install_header'    => '插件的安裝/卸載',
    'installed'         => '插件與組件安裝完畢。<p><em>敬請使用。<br' . XHTML . '><a href="mailto:langmail@sympatico.ca">Blaine</a></em>',
    'uninstalled'       => '插件未安裝。',
    'install_success'   => '安裝成功<p><b>下一步</b>:   <ol><li>使用論壇管理來創建您的論壇。<li>進行論壇的設定與個性設置。<li>至少創建一個論壇、一個目錄。</ol> <p>請閱讀<a href="%s">安裝注意事項</a>。',





    'install_failed'    => '安裝失敗。 -- 請參考錯誤記錄(error.log)來確定原因。',
    'uninstall_msg'     => '論壇插件已經卸載。',
    'install'           => '安裝',
    'uninstall'         => '卸載',
    'enabled'           => '<br' . XHTML . '>插件已安裝並有效化。<p>',
    'warning'           => '論壇卸載警告',
    'uploaderr'         => '文件上載錯誤'
);


$PLG_forum_MESSAGE1 = '論壇插件升級: 成功。';
$PLG_forum_MESSAGE2 = '論壇插件升級: 自動安裝失敗。請閱讀插件文檔。';

$LANG_GF01['LOGIN']          = '登錄';
$LANG_GF01['FORUM']          = '論壇';
$LANG_GF01['ALL']            = '全部'; 
$LANG_GF01['YES']            = '是';
$LANG_GF01['NO']             = '否';
$LANG_GF01['NEW']            = '新到';
$LANG_GF01['PREV']           = '預覽';
$LANG_GF01['NEXT']           = '次';
$LANG_GF01['ERROR']          = '錯誤!';
$LANG_GF01['CONFIRM']        = '確認';
$LANG_GF01['UPDATE']         = '更新';
$LANG_GF01['SAVE']           = '保存';
$LANG_GF01['CANCEL']         = '取消';
$LANG_GF01['CLOSE']          = '關閉';
$LANG_GF01['ON']             = '發帖日: ';
$LANG_GF01['ON2']            = '&nbsp;&nbsp;<b>On: </b>';
$LANG_GF01['IN']             = 'In: ';
$LANG_GF01['BY']             = '發帖人: ';
$LANG_GF01['RE']             = '回復: ';
$LANG_GF01['NA']             = 'N/A';
$LANG_GF01['DATE']           = '日期';
$LANG_GF01['VIEWS']          = '閱覽數';
$LANG_GF01['REPLIES']        = '回復數';
$LANG_GF01['NAME']           = '名字:';
$LANG_GF01['DESCRIPTION']    = '說明: ';
$LANG_GF01['TOPIC']          = '主題';
$LANG_GF01['TOPICS']         = '投稿';
$LANG_GF01['TOPICSUBJECT']   = '主題';
$LANG_GF01['FROM']           = '從';
$LANG_GF01['REPLY']          = '新回復';
$LANG_GF01['PM']             = 'PM';
$LANG_GF01['HOME']           = '顯示論壇';
$LANG_GF01['HOMEPAGE']       = '主頁';
$LANG_GF01['SUBJECT']        = '題目';
$LANG_GF01['HELLO']          = '你好！ ';
$LANG_GF01['MEMBERS']        = '成員';
$LANG_GF01['MOVED']          = '移動';
$LANG_GF01['REMOVE']         = '移動&amp;刪除';
$LANG_GF01['CURRENT']        = '最新';
$LANG_GF01['STARTEDBY']      = '最初的發帖人';
$LANG_GF01['POSTS']          = '帖子數';
$LANG_GF01['LASTPOST']       = '最新帖';
$LANG_GF01['POSTEDON']       = '發帖日';
$LANG_GF01['POSTEDBY']       = '發帖人';
$LANG_GF01['POSTEDON']       = '發帖日';
$LANG_GF01['PAGE']           = '頁';
$LANG_GF01['PAGES']          = '頁';
$LANG_GF01['ANONYMOUS']      = '匿名用戶:';
$LANG_GF01['TODAY']          = '今天的';
$LANG_GF01['WELCOME']        = '歡迎 ';
$LANG_GF01['REGISTER']       = '注冊';
$LANG_GF01['REGISTERED']     = '注冊日';
$LANG_GF01['MOSTPOPULAR']    = '最高人氣';
$LANG_GF01['ORDERBY']        = '排序:';
$LANG_GF01['ORDER']          = '順序:';
$LANG_GF01['USER']           = '用戶';
$LANG_GF01['GROUP']          = '組';
$LANG_GF01['ANON']           = '匿名用戶: ';
$LANG_GF01['ADMIN']          = '管理者';
$LANG_GF01['AUTHOR']         = '發帖人';
$LANG_GF01['LOCATION']       = '場所';
$LANG_GF01['WEBSITE']        = '主頁';
$LANG_GF01['EMAIL']          = '電郵';
$LANG_GF01['MOOD']           = '心情';
$LANG_GF01['NOMOOD']         = '-心情圖標-';
$LANG_GF01['REQUIRED']       = '[要求]';
$LANG_GF01['OPTIONAL']       = '[可選]';
$LANG_GF01['SUBMIT']         = '提交';
$LANG_GF01['PREVIEW']        = '預覽';
$LANG_GF01['NOTIFY']         = '請注意:';
$LANG_GF01['REMOVE']         = '解除';
$LANG_GF01['KEYWORDS']       = '關鍵詞';
$LANG_GF01['EDIT']           = '編輯';
$LANG_GF01['DELETE']         = '刪除';
$LANG_GF01['MESSAGE']        = '消息:';
$LANG_GF01['OPTIONS']        = '選項:';
$LANG_GF01['MISSINGSUBJECT'] = '無主題';
$LANG_GF01['MAY']            = '';
$LANG_GF01['IS']             = '是';
$LANG_GF01['FOR']            = '：';
$LANG_GF01['ARE']            = '';
$LANG_GF01['NOT']            = '非';
$LANG_GF01['YOU']            = '';
$LANG_GF01['HTML']           = 'HTML';
$LANG_GF01['FULLHTML']       = '全部HTML';
$LANG_GF01['WORDS']          = '單詞';
$LANG_GF01['SMILIES']        = '表情符號';
$LANG_GF01['MIGRATE_NOW']    = '進行導入'; 
$LANG_GF01['FILTERLIST']     = '過濾列表';
$LANG_GF01['SELECTFORUM']    = '選擇論壇';
$LANG_GF01['DELETEAFTER']    = '執行後刪除';
$LANG_GF01['TITLE']          = '題目';
$LANG_GF01['COMMENTS']       = '評論'; 
$LANG_GF01['SUBMISSIONS']    = '已提交的';

$LANG_GF01['HTML_FILTER_MSG']  = '允許一部分的HTML';
$LANG_GF01['HTML_FULL_MSG']  = '允許全部的HTML';
$LANG_GF01['HTML_MSG']       = '允許HTML';
$LANG_GF01['CENSOR_PERM_MSG']= '檢查敏感詞';
$LANG_GF01['ANON_PERM_MSG']  = '看匿名用戶的帖子';
$LANG_GF01['POST_PERM_MSG1'] = '可以發帖';
$LANG_GF01['POST_PERM_MSG2'] = '匿名用戶可以發帖';
$LANG_GF01['CENSORED']       = '審查';
$LANG_GF01['ALLOWED']        = '許可';
$LANG_GF01['GO']             = '執行';
$LANG_GF01['STATUS']         = '狀態:';
$LANG_GF01['ONLINE']         = '在線';
$LANG_GF01['OFFLINE']        = '下線';
$LANG_GF01['back2parent']    = '子題目';
$LANG_GF01['forumname']      = '';
$LANG_GF01['category']       = '類別: ';
$LANG_GF01['loginreqview']   = '<b>為了參加論壇， 請注冊 %s </a> 或登錄 %s  </a>。</b>';
$LANG_GF01['loginreqpost']   = '<b>為了發帖，請注冊或登錄。</b>';
$LANG_GF01['searchresults']  = ' 檢索結果 <b>%s</b> %s ： <b>%s</b> 結果:</b><br' . XHTML . '><br' . XHTML . '>';
$LANG_GF01['feature_not_on'] = '機能未使能';
$LANG_GF01['nolastpostmsg']  = 'N/A';
$LANG_GF01['no_one']         = '沒有一個。';
$LANG_GF01['popular']        = '人氣順序列表';
$LANG_GF01['notify']         = '通知';
$LANG_GF01['PM']             = 'PM\'s';
$LANG_GF01['NEW_PM']         = '新PM';
$LANG_GF01['DELALL_PM']      = '全部刪除';
$LANG_GF01['DELOLDER_PM']    = '刪除舊的';
$LANG_GF01['members']        = '成員列表';
$LANG_GF01['save_sucess']    = '保存成功';
$LANG_GF01['trademark']      = '<br' . XHTML . '><center><b>Geeklog Forum Project version 2.0</b> &copy; 2002</b></center>';
$LANG_GF01['back2top']       = '返回首頁';
$LANG_GF01['POSTMODE']       = '發帖模式:';
$LANG_GF01['TEXTMODE']       = '文本模式';
$LANG_GF01['HTMLMODE']       = 'HTML模式';
$LANG_GF01['TopicPreview']   = '發帖預覽';
$LANG_GF01['moderator']      = '調整';
$LANG_GF01['admin']          = '管理者';
$LANG_GF01['DATEADDED']      = '注冊日';
$LANG_GF01['PREVTOPIC']      = '至前主題';
$LANG_GF01['NEXTTOPIC']      = '至後主題';
$LANG_GF01['CONTENT']        = '內容';
$LANG_GF01['QUOTE_begin']    = '[引用&nbsp;';
$LANG_GF01['QUOTE_by'   ]    = 'by:&nbsp;';
$LANG_GF01['RESYNC']         = "同步";
$LANG_GF01['RESYNCCAT']      = "同步分類論壇";  
$LANG_GF01['PROFILE']        = "概要";
$LANG_GF01['DELETECONFIRM']  = "確定刪除記錄嗎?";
$LANG_GF01['website']        = '主頁';
$LANG_GF01['EDITICON']       = '編輯';
$LANG_GF01['QUOTEICON']      = '引用';
$LANG_GF01['ProfileLink']    = '概要';
$LANG_GF01['WebsiteLink']    = '網站主頁';
$LANG_GF01['PMLink']         = 'PM';
$LANG_GF01['EmailLink']      = '電郵';
$LANG_GF01['FORUMSUBSCRIBE'] = '訂閱電郵通知';
$LANG_GF01['FORUMUNSUBSCRIBE'] = '取消電郵通知';
$LANG_GF01['FORUMSUBSCRIBE_TRUE'] = '本論壇的電郵通知:有效';
$LANG_GF01['FORUMSUBSCRIBE_FALSE'] = '本論壇的電郵通知:無效';
$LANG_GF01['NEWTOPIC']       = '新主題';
$LANG_GF01['SubscribeLink_TRUE']  = '本主題的電郵通知:有效';
$LANG_GF01['SubscribeLink_FALSE'] = '本主題的電郵通知:無效';
$LANG_GF01['SubscribeLink']  = '訂閱電郵通知';
$LANG_GF01['unSubscribeLink'] = '取消電郵通知';
$LANG_GF01['POSTREPLY']      = '發帖回復';
$LANG_GF01['SUBSCRIPTIONS']  = '發帖選項';
$LANG_GF01['TOP']            = '首頁';
$LANG_GF01['PRINTABLE']      = '打印版本';
$LANG_GF01['ForumProfile']   = '論壇選項';
$LANG_GF01['USERPREFS']      = '用戶設定';
$LANG_GF01['SPEEDLIMIT']     = '"您最近一次發帖是在 %s 秒之前。<br' . XHTML . '>到下一次發帖之前，請至少等待 %s 秒。"';
$LANG_GF01['ACCESSERROR']    = '訪問錯誤';
$LANG_GF01['LEGEND']         = '凡例';
$LANG_GF01['ACTIONS']        = '動作';
$LANG_GF01['DELETEALL']      = '刪除選中的全部記錄';
$LANG_GF01['DELCONFIRM']     = '確定要刪除選中的記錄？';
$LANG_GF01['DELALLCONFIRM']  = '確定要刪除選中的全部記錄？';
$LANG_GF01['STARTEDBY']      = '初始發帖';
$LANG_GF01['WARNING']        = '請注意';
$LANG_GF01['MODERATED']      = '調整: %s';
$LANG_GF01['NOTIFYNOT']      = 'NOT!';
$LANG_GF01['LASTREPLYBY']    = '最新回復:&nbsp;%s';
$LANG_GF01['UID']            = 'UID';
$LANG_GF01['ANON_POST_BEGIN'] = '匿名用戶發帖開始';
$LANG_GF01['ANON_POST_END']   = '匿名用戶閱覽終止';
$LANG_GF01['INDEXPAGE']      = '論壇索引';
$LANG_GF01['FEATURE']        = '機能';
$LANG_GF01['SETTING']        = '設定';
$LANG_GF01['MARKALLREAD']    = '全部標為已讀';
$LANG_GF01['MSG_NO_CAT']     = '類別或論壇未定義。';

// Language for bbcode toolbar
$LANG_GF01['CODE']           = '代碼';
$LANG_GF01['FONTCOLOR']      = '文字色';
$LANG_GF01['FONTSIZE']       = '文字大小';
$LANG_GF01['CLOSETAGS']      = '關閉標簽';
$LANG_GF01['CODETIP']        = '小提示: 選中的文字能立刻應用風格';
$LANG_GF01['TINY']           = '很小';
$LANG_GF01['SMALL']          = '小';
$LANG_GF01['NORMAL']         = '標準';
$LANG_GF01['LARGE']          = '大';
$LANG_GF01['HUGE']           = '很大';
$LANG_GF01['DEFAULT']        = '缺省';
$LANG_GF01['DKRED']          = '深紅';
$LANG_GF01['RED']            = '紅';
$LANG_GF01['ORANGE']         = '橙';
$LANG_GF01['BROWN']          = '棕';
$LANG_GF01['YELLOW']         = '黃';
$LANG_GF01['GREEN']          = '綠';
$LANG_GF01['OLIVE']          = '橄欖';
$LANG_GF01['CYAN']           = '水色';
$LANG_GF01['BLUE']           = '藍';
$LANG_GF01['DKBLUE']         = '深藍';
$LANG_GF01['INDIGO']         = '靛青';
$LANG_GF01['VIOLET']         = '紫';
$LANG_GF01['WHITE']          = '白';
$LANG_GF01['BLACK']          = '黑';

$LANG_GF01['b_help']         = "粗體: [b]text[/b]";
$LANG_GF01['i_help']         = "斜體: [i]text[/i]";
$LANG_GF01['u_help']         = "下劃線: [u]text[/u]";
$LANG_GF01['q_help']         = "引用: [quote]text[/quote]";
$LANG_GF01['c_help']         = "代碼顯示: [code]code[/code]";
$LANG_GF01['l_help']         = "無數字列表: [list]text[/list]";
$LANG_GF01['o_help']         = "數字列表: [olist]text[/olist]";
$LANG_GF01['p_help']         = "[img]http://圖像的url[/img]  或  [img w=100 h=200][/img]";
$LANG_GF01['w_help']         = "插入URL: [url]http://url[/url] 或 [url=http://url]URL文本[/url]";
$LANG_GF01['a_help']         = "關閉所有沒有關閉的bbCode標簽";
$LANG_GF01['s_help']         = "文字色: [color=red]text[/color]  小提示: 能指定 color=#FF0000 這樣的形式";
$LANG_GF01['f_help']         = "文字大小: [size=x-small]小字[/size]";
$LANG_GF01['h_help']         = "請點擊觀看詳細幫助";


$LANG_GF02['msg01']    = '對不起，您必須注冊來參加論壇。 ';
$LANG_GF02['msg02']    = '對不起，您必須注冊來參加論壇。';
$LANG_GF02['msg03']    = '';
$LANG_GF02['msg04']    = '';
$LANG_GF02['msg05']    = '<center><em>對不起，還沒有創建主題。</em></center>';
$LANG_GF02['msg06']    = '自從您上次訪問結束以後的新帖';
$LANG_GF02['msg07']    = '在線用戶:';
$LANG_GF02['msg08']    = '<br' . XHTML . '><b>全部的注冊用戶的注冊日時:</b> %s';
$LANG_GF02['msg09']    = '<br' . XHTML . '><b>全部的發帖日時:</b> %s <br' . XHTML . '>';
$LANG_GF02['msg10']    = '<b>全部的主題日時:</b> %s <br' . XHTML . '>';
$LANG_GF02['msg11']    = '返回論壇索引';
$LANG_GF02['msg12']    = '返回主頁';
$LANG_GF02['msg13']    = '必須注冊。您必須注冊或登錄來使用這項機能。';
$LANG_GF02['msg14']    = '對不起，您被禁止制作條目。<br' . XHTML . '>';
$LANG_GF02['msg15']    = '如果您覺得這是一個錯誤， 請聯系<a href="mailto:%s?subject=Guestbook IP Ban">論壇管理者</a>。';
$LANG_GF02['msg16']    = '這些是最熱門的帖子，您可以用閱覽數或回復數來排序。';
$LANG_GF02['msg17']    = '消息編輯完成。';
$LANG_GF02['msg18']    = '錯誤! 沒有輸入必須項目或者長度過短。';
$LANG_GF02['msg19']    = '消息已張貼';
$LANG_GF02['msg20']    = '回復已張貼。';
$LANG_GF02['msg21']    = '沒有執行權限。請<a href="javascript:history.back()">返回</a>或<a href="%s/users.php?mode=login">登錄</a>。<br' . XHTML . '><br' . XHTML . '>'; 
$LANG_GF02['msg22']    = '- 論壇發帖通知';
$LANG_GF02['msg23a']   = "論壇[%s]中有來自%s會員的新回復。\n（主題發起：%s會員　論壇板塊：%s）";
$LANG_GF02['msg23b']   = "新主題 '%s' 由\n%s 會員張貼到 %s 論壇。\n（站點：%s）\n\n%s/forum/viewtopic.php?showtopic=%s\n";
$LANG_GF02['msg23c']   = "%s/forum/viewtopic.php?showtopic=%s&amp;lastpost=true\n";
$LANG_GF02['msg24']    = '線索: ';
$LANG_GF02['msg25']    = "\n";
$LANG_GF02['msg26']    = "\n※該主題設定為電郵通知。";
$LANG_GF02['msg27']    = "取消電郵通知\n: \n%s\n";
$LANG_GF02['msg28']    = '錯誤：無標題。';
$LANG_GF02['msg29']    = '您的署名會放在這裡。';
$LANG_GF02['msg30']    = '返回首頁';
$LANG_GF02['msg31']    = '<b>可編輯:</b>';
$LANG_GF02['msg32']    = '<b>編輯消息</b>';
$LANG_GF02['msg33']    = '發帖人: ';
$LANG_GF02['msg34']    = '電郵:';
$LANG_GF02['msg35']    = '網站:';
$LANG_GF02['msg36']    = '心情圖標:';
$LANG_GF02['msg37']    = '消息:';
$LANG_GF02['msg38']    = '電郵通知';
$LANG_GF02['msg39']    = '<br' . XHTML . '>該新主題無主題回復。';
$LANG_GF02['msg40']    = '<br' . XHTML . '>已設定電郵通知。<br' . XHTML . '><br' . XHTML . '>';
$LANG_GF02['msg41']    = '<br' . XHTML . '>對主題 %s 的回復已設定電郵通知。<br' . XHTML . '><br' . XHTML . '>';
$LANG_GF02['msg42']    = '電郵通知已解除。';
$LANG_GF02['msg43']    = '確定要解除此電郵通知?.';
$LANG_GF02['msg44']    = '<p style="margin:0px; padding:5px;">當前您沒有電郵通知。</p>';
$LANG_GF02['msg45']    = '檢索論壇';
$LANG_GF02['msg46']    = '論壇關鍵詞檢索:';
$LANG_GF02['msg47']    = '可指定發帖人名:';
$LANG_GF02['msg48']    = '<br' . XHTML . '>請先安裝Chatterblock插件。';
$LANG_GF02['msg49']    = '(參照數 %s次) ';
$LANG_GF02['msg50']    = '署名 n/a';
$LANG_GF02['msg51']    = "%s\n\n<br" . XHTML . ">[編輯 %s by %s]";
$LANG_GF02['msg52']    = '確定:';
$LANG_GF02['msg53']    = '返回主題..';
$LANG_GF02['msg54']    = '帖子已被編輯。';
$LANG_GF02['msg55']    = '帖子已被刪除。';
$LANG_GF02['msg56']    = 'IP地址已被禁止。';
$LANG_GF02['msg57']    = '置頂設定';
$LANG_GF02['msg58']    = '解除置頂設定';
$LANG_GF02['msg59']    = '一般';
$LANG_GF02['msg60']    = '新到';
$LANG_GF02['msg61']    = '置頂主題';
$LANG_GF02['msg62']    = '如有回復則電郵通知';
$LANG_GF02['msg63']    = '概要';
$LANG_GF02['msg64']    = '真的要刪除主題 %s 標題: %s ?';
$LANG_GF02['msg65']    = '<br' . XHTML . '>這是一個子話題。因此它的所有回復也將被刪除。';
$LANG_GF02['msg66']    = '確認刪貼';
$LANG_GF02['msg67']    = '編輯論壇帖子';
$LANG_GF02['msg68']    = '注意: 禁止某人時需要特別小心。只有管理者才有權解除禁止。';
$LANG_GF02['msg69']    = '<br' . XHTML . '>本當□□□IP□□□□□禁止□□□□: %s?';
$LANG_GF02['msg70']    = '確定禁止';
$LANG_GF02['msg71']    = '沒有選擇機能。請選擇帖子來執行調整。<br' . XHTML . '>注意: 您必須作為協調人來使用這些機能。';
$LANG_GF02['msg72']    = '警告：您無權執行該調整操作。';
$LANG_GF02['msg74']    = '最近張貼的 %s 條';
$LANG_GF02['msg75']    = '閱覽數最多的 %s 篇主題';
$LANG_GF02['msg76']    = '回帖最多的 %s 篇主題';
$LANG_GF02['msg77']    = '<br' . XHTML . '><p style="padding-left: 10px;">對不起。請先登錄。如果沒有帳號的話請注冊。</p>';
$LANG_GF02['msg78']    = '<br' . XHTML . '>此處無論壇。';
$LANG_GF02['msg81']    = '- 主題編輯通知';
$LANG_GF02['msg82']    = '<p>您的消息 "%s" 已被協調人 %s 編輯。</p>';
$LANG_GF02['msg83']    = '<br' . XHTML . '><br' . XHTML . '><p>請輸入論壇的主題。</p>';
$LANG_GF02['msg84']    = '全部標為已讀';
$LANG_GF02['msg85']    = '頁:';
$LANG_GF02['msg86']    = '最新 %s 帖子　張貼人: ';
$LANG_GF02['msg87']    = '<br' . XHTML . '>警告：該主題已被鎖定。<br' . XHTML . '>無法繼續張貼。';
$LANG_GF02['msg88']    = '論壇成員列表';
$LANG_GF02['msg88b']   = '僅論壇活躍者';
$LANG_GF02['msg89']    = '電郵通知設定列表';
$LANG_GF02['msg100']   = '信息:';
$LANG_GF02['msg101']   = '規則:';
$LANG_GF02['msg102']   = '發帖凡例:';
$LANG_GF02['msg103']   = '論壇跳轉:';
$LANG_GF02['msg104']   = '帖子消息';
$LANG_GF02['msg105']   = '編輯你的帖子';
$LANG_GF02['msg106']   = '選擇論壇';
$LANG_GF02['msg107']   = '論壇凡例:';
$LANG_GF02['msg108']   = '有新帖的論壇';
$LANG_GF02['msg109']   = '被鎖定的主題';
$LANG_GF02['msg110']   = '轉向編輯頁面...';
$LANG_GF02['msg111']   = '未讀列表:';
$LANG_GF02['msg112']   = '顯示未讀';
$LANG_GF02['msg113']   = '顯示未讀';
$LANG_GF02['msg114']   = '已鎖定';
$LANG_GF02['msg115']   = '置頂 新到';
$LANG_GF02['msg116']   = '鎖定 新到';
$LANG_GF02['msg117']   = '檢索網站';
$LANG_GF02['msg118']   = '檢索論壇';
$LANG_GF02['msg119']   = '檢索結果:';
$LANG_GF02['msg120']   = '人氣排序 by';
$LANG_GF02['msg121']   = '時刻全部為 %s ， 現在的時刻是 %s';
$LANG_GF02['msg122']   = '人氣主題條件';
$LANG_GF02['msg123']   = '人氣主題所要求的發帖數';
$LANG_GF02['msg124']   = '每頁的消息數';
$LANG_GF02['msg125']   = '僅供協調人: 消息列表頁面';
$LANG_GF02['msg126']   = '檢索行';
$LANG_GF02['msg127']   = '檢索結果的顯示行數';
$LANG_GF02['msg128']   = '成員數/頁';
$LANG_GF02['msg129']   = '發帖人列表中一頁顯示的人數';
$LANG_GF02['msg130']   = '查看匿名用戶帖子';
$LANG_GF02['msg131']   = '設定是否顯示匿名用戶的帖子';
$LANG_GF02['msg132']   = '電郵通知模式';
$LANG_GF02['msg133']   = '是否設定創建主題或回帖時自動電郵通知';
$LANG_GF02['msg134']   = '訂閱電郵通知。';
$LANG_GF02['msg135']   = '在本論壇中的所有張貼都將電郵通知您。';
$LANG_GF02['msg136']   = '請選擇張貼論壇。';
$LANG_GF02['msg137']   = '如有回復則電郵通知。';
$LANG_GF02['msg138']   = '<b>訂閱全部論壇</b>';
$LANG_GF02['msg139']   = '%s 繼續請<a href="%s">點擊</a>';
$LANG_GF02['msg140']   = '繼續';
$LANG_GF02['msg141']   = '該頁會自動返回。如果沒有返回或不想等待請點擊 <a href="%s">這裡</a>';
$LANG_GF02['msg142']   = '郵件通知已開始。';
$LANG_GF02['msg143']   = '通知';
$LANG_GF02['msg144']   = '返回主題';
$LANG_GF02['msg145']   = '參照主題';
$LANG_GF02['msg146']   = '電郵通知已解除。';
$LANG_GF02['msg147']   = '論壇印刷版';
$LANG_GF02['msg148']   = '<a href="javascript:history.back()">返回</a>';
$LANG_GF02['msg149']   = ' %s 發送及時消息。';
$LANG_GF02['msg150']   = '在您的帖子 %s 中';
$LANG_GF02['msg151']   = '最新主題';
$LANG_GF02['msg152']   = '人氣主題';
$LANG_GF02['msg153']   = '人氣回復';
$LANG_GF02['msg154']   = '最新主題';
$LANG_GF02['msg155']   = '沒有帖子';
$LANG_GF02['msg156']   = '帖子數';
$LANG_GF02['msg157']   = '最新10條帖子';
$LANG_GF02['msg158']   = '最新10條帖子張貼人 ';
$LANG_GF02['msg159']   = '真的要刪除這些選中的協調人的記錄嗎？';
$LANG_GF02['msg160']   = '顯示最後一頁';
$LANG_GF02['msg161']   = '返回成員列表';
$LANG_GF02['msg162']   = '點擊<a href="%s">這裡</a><br' . XHTML . '>返回論壇索引。默認自動轉向您的帖子，如果您不想等待請點擊 <a href="%s">這裡</a>';
$LANG_GF02['msg163']   = '帖子已移動。';
$LANG_GF02['msg164']   = '全部標為已讀';
$LANG_GF02['msg165']   = '<p>錯誤: 匹配的 <b>引用(QUOTE)</b> 標簽丟失。無法生成指定格式。</p>';
$LANG_GF02['msg166']   = '錯誤: 無效主題或主題沒有找到。';
$LANG_GF02['msg167']   = '通知選項';
$LANG_GF02['msg168']   = '設定為否將取消電郵通知';
$LANG_GF02['msg169']   = '返回成員列表';
$LANG_GF02['msg170']   = '最近張貼';
$LANG_GF02['msg171']   = '論壇訪問錯誤';
$LANG_GF02['msg172']   = '主題不存在，可能已刪除。';
$LANG_GF02['msg173']   = '轉向消息張貼頁面...';
$LANG_GF02['msg174']   = '無法禁止成員 - 不正確的或空的IP地址';
$LANG_GF02['msg175']   = '返回論壇列表';
$LANG_GF02['msg176']   = '選擇成員';
$LANG_GF02['msg177']   = '所有成員';
$LANG_GF02['msg178']   = '僅子帖';
$LANG_GF02['msg179']   = '內容生成: %s 秒';
$LANG_GF02['msg180']   = '論壇張貼警告';
$LANG_GF02['msg181']   = '您作為協調人無法訪問其他論壇。';
$LANG_GF02['msg182']   = '協調人確認';
$LANG_GF02['msg183']   = '新發貼: %s';
$LANG_GF02['msg184']   = '僅通知一次';
$LANG_GF02['msg185']   = '到您下次訪問之前，您訂閱的論壇和主題中，即使有多篇新帖張貼，也僅電郵通知您一次。';
$LANG_GF02['msg186']   = '新標題';
$LANG_GF02['msg187']   = '<a href="%s">返回主題</a>';
$LANG_GF02['msg188']   = '跳轉到最新的帖子。';
$LANG_GF02['msg189']   = '錯誤: 現在這篇帖子已不能再編輯了。';
$LANG_GF02['msg190']   = '安靜編輯';
$LANG_GF02['msg191']   = '無法編輯。可能是允許編輯的時間窗口已經過去，或是您沒有協調人權限。';
$LANG_GF02['msg192']   = '完畢。 導入%s個主題和%s個評論。';
$LANG_GF02['msg193']   = '將文章導入論壇的工具';  
$LANG_GF02['msg194']   = '沒有新帖的論壇';
$LANG_GF02['msg195']   = '點擊跳轉到論壇';
$LANG_GF02['msg196']   = '查看主論壇索引';
$LANG_GF02['msg197']   = '將全部類別標記為已讀';
$LANG_GF02['msg198']   = '更新論壇設置';
$LANG_GF02['msg199']   = '查看/刪除論壇通知';
$LANG_GF02['msg200']   = '成員報告';
$LANG_GF02['msg201']   = '主題報告';
$LANG_GF02['msg202']   = '無新帖';

$LANG_GF02['msg300']   = '設定為不顯示匿名用戶的帖子。';

$LANG_GF02['StatusHeading']   = '信息';
$LANG_GF02['PostReply']   = '張貼新回復';
$LANG_GF02['PostTopic']   = '張貼新主題';
$LANG_GF02['EditTopic']   = '編輯主題';
$LANG_GF02['quietforum']  = '論壇中沒有新主題。';

$LANG_GF03 = array (
    'welcomemsg'        => '歡迎，協調人',
    'title'             => '協調人機能:&nbsp;',
    'delete'            => '刪除',
    'edit'              => '編輯',
    'move'              => '移動',
    'ban'               => 'IP地址禁止',
    'stick'             => '設定置頂',
    'unstick'           => '取消置頂',
    'movetopic'         => '移動&amp;刪除',
    'movetopicmsg'      => '<br' . XHTML . '> 移動主題： <b>%s</b> ',
    'lockedpost'        => '追加回復',
    'split'             => '分割主題',
    'splittopicmsg'     => '<br' . XHTML . '>用該貼新建主題: "<b>%s</b>"<br' . XHTML . '><em>發帖人:</em>&nbsp;%s&nbsp; <em>原帖:</em>&nbsp;%s',
    'selectforum'       => '選擇新論壇:',
    'splitheading'      => '分割線索選項:',
    'splitopt1'         => '移動從這裡開始的全部帖子',
    'splitopt2'         => '僅移動這一個帖子'
);

$LANG_GF04 = array (
    'label_forum'             => '論壇的概要',
    'label_location'          => '場所',
    'label_aim'               => 'AIM用戶名',
    'label_yim'               => 'YIM用戶名',
    'label_icq'               => 'ICQ用戶名',
    'label_msnm'              => 'MSN用戶名',
    'label_interests'         => '愛好',
    'label_occupation'        => '工作',
);

/* Settings for Additional User profile - Instant Messenging links */
$LANG_GF05 = array (
    'aim_link'               => '&nbsp;<a href="aim:goim?screenname=',
    'aim_linkend'            => '>',
    'aim_hello'              => '&amp;message=Hi.+Are+you+there?',
    'aim_alttext'            => 'AIM:&nbsp;',
    'icq_link'               => '&nbsp;',
    'icq_alttext'            => 'ICQ #:&nbsp;',
    'msn_link'               => '&nbsp;<a href="javascript:MsgrApp.LaunchIMUI(',
    'msn_linkend'            => ')">',
    'msn_alttext'            => 'Messenger:&nbsp;',
    'yim_link'               => '&nbsp;<a href="ymsgr:sendIM?',
    'yim_linkend'            => '">',
    'yim_alttext'            => 'YIM:&nbsp;',
);


/* Admin Navbar */
$LANG_GF06 = array (
    1   => '統計',
    2   => '設定',
    3   => '論壇管理',
    4   => '協調人',
    5   => '轉換',
    6   => '消息',
    7   => '禁止IP地址'
);

/* User Functions Navbar */
$LANG_GF07 = array (
    1   => '顯示論壇',
    2   => '用戶設定',
    3   => '人氣主題',
    4   => '電郵通知列表',
    5   => '成員列表'
);



/* Forum User Features */
$LANG_GF08 = array (
    1   => '主題電郵通知',
    2   => '論壇電郵通知',
    3   => '主題電郵通知的例外'
);


$LANG_GF90 = array (
    'viewforums'        => '索引',
    'stats'             => '統計',
    'settings'          => '設定',
    'boardadmin'        => '論壇',
    'migrate'           => '轉換',
    'mods'              => '協調人',
    'messages'          => '消息',
    'ipman'             => '禁止IP地址'
);

$LANG_GF91 = array (
    'gfstats'            => '論壇的統計',
    'statsmsg'           => '現在:',
    'totalcats'          => '合計 類別數:',
    'totalforums'        => '合計 論壇數:',
    'totaltopics'        => '合計 主題數:',
    'totalposts'         => '合計 張貼數:',
    'totalviews'         => '合計 閱覽數:',
    'avgpmsg'            => '平均張貼數:',
    'category'           => '類別:',
    'forum'              => '論壇:',
    'topic'              => '主題:',
    'avgvmsg'            => '平均閱覽數:'
);

// Settings.php 
$LANG_GF92 = array (
    'gfsettings'         => '設定',
    'gensettings'        => '一般',
    'gensettings'        => '一般',
    'topicsettings'      => '主題張貼設定',
    'blocksettings'      => '站點組件(forum_newposts)',
    'ranksettings'       => '排位說明設定',
    'htmlsettings'       => 'HTML設定',
    'avsettings'         => '頭像設定',
    'ranksettings'       => '排位設定',
    'savesettings'       => '    保存變更    ', 
    'allowhtml'          => 'HTML使用',
    'allowhtmldscp'      => '發帖時允許HTML的使用。如果設定為否，則只能使用純文本模式發帖，但bbcode仍然有效。',//'Enable HTML to be used in posts. If set to NO then users will only be able to post in TEXT Mode but still use bbcode'
    'glfilter'           => 'HTML過濾器',
    'glfilterdscp'       => '使用Geeklog本身的HTML過濾器',
    'censor'             => '審查',
    'censordscp'         => '審查（使用Geeklog本身的設查功能）',
    'showmoods'          => '心情圖標',
    'showmoodsdscp'      => '使用',
    'allowsmilies'       => '表情圖標',
    'allowsmiliesdscp'   => '使用',
    'allownotify'        => '允許通知:',
    'allownotifydscp'    => '允許主題更新時的電郵通知',
    'showiframe'         => '顯示主題內容',
    'showiframedscp'     => '當回復主題的時候，在下面顯示主題的內容',
    'autorefresh'        => '自動刷新',
    'autorefreshdscp'    => '提交後自動刷新',
    'refreshdelay'       => '刷新延遲時間（秒）',
    'refreshdelaydscp'   => '指定自動刷新的情況下，刷新的延遲時間（以秒計）',
    'xtrausersettings'   => '論壇的用戶設定',
    'xtrausersettingsdscp'    => '允許可選的額外用戶設定',
    'titleleng'          => '標題的長度',
    'titlelengdscp'      => '能夠輸入的標題的最大長度（字符數）',
    'topicspp'           => '每頁顯示的主題數',
    'topicsppdscp'       => '在各論壇的主題索引頁面，一頁顯示的主題數',
    'postspp'            => '每頁顯示的帖子數',
    'postsppdscp'        => '在各主題頁面，一頁顯示的帖子數',
    'regview'            => '允許閱覽',
    'regviewdscp'        => '需要注冊才能閱覽帖子',
    'regpost'            => '允許發帖',
    'regpostdscp'        => '需要注冊才能發帖',
    'imgset'             => '圖像集合',
    'lev1'               => '水平 1',
    'lev1dscp'           => '排位 1',
    'lev2'               => '水平 2',
    'lev2dscp'           => '排位 2',
    'lev3'               => '水平 3',
    'lev3dscp'           => '排位 3',
    'lev4'               => '水平 4',
    'lev4dscp'           => '排位 4',
    'lev5'               => '水平 5',
    'lev5dscp'           => '排位 5',
    'setsave'            => '設定已保存',
    'setsavemsg'         => '設定已保存。',
    'allownotify'        => '電郵通知',
    'allownotifydscp'    => '是否允許電郵通知',
    'defaultmode'        => '默認張貼模式',
    'defaultmodedscp'    => '要將HTML模式設為默認，請選擇是。<br' . XHTML . '>要將純文本模式設為默認（比較安全），請選擇否。',
    'cbsettings'         => '中組件設定',
    'cbenable'           => '顯示中組件',
    'cbenabledscp'       => '顯示中組件',
    'cbhomepage'         => '僅首頁',
    'cbhomepagedscp'     => '僅顯示在第一頁',
    'cbposition'         => '位置',
    'cbpositiondscp'     => '顯示位置',
    'position'           => '位置 ', 
    'all_topics'         => '全部',
    'no_topic'           => '僅主頁',
    'position_top'       => '頁眉',
    'position_feat'      => '在置頂帖之後',
    'position_bottom'    => '頁腳',
    'messagespp'         => '每頁的消息數',
    'messagesppdscp'     => '消息管理頁面 - 每頁的消息行數',
    'searchespp'         => '檢索結果',
    'searchesppdscp'     => '檢索結果中每頁的記錄數',
    'minnamelength'      => '名字的最短長度',
    'minnamedscp'        => '成員名或匿名用戶名需要的最小字符數',
    'mincommentlength'   => '最小文本長度',
    'mincommentdscp'     => '帖子內容的最小字符數',
    'minsubjectlength'   => '最小標題長度',
    'minsubjectdscp'     => '標題的最小字符數',
    'popular'            => '人氣主題',
    'populardscp'        => '人氣主題帖需要的最小閱覽數',
    'convertbreak'       => '轉換新行符號',
    'convertbreakdscp'   => '將新行符號轉換為HTML標簽(&lt;br&gt;)',
    'speedlimit'         => '發帖時間間隔限制',
    'speedlimitdscp'     => '為防止垃圾帖，限制發帖的間隔時間，以秒計',
    'cb_subjectsize'     => '標題長度',
    'cb_subjectsizedscp' => '顯示的標題的字符數',
    'cb_numposts'        => '發帖數',
    'cb_numpostsdscp'    => '在中組件中顯示的帖子數',
    'sb_subjectsize'     => '標題長度',
    'sb_subjectsizedscp' => '顯示的標題的字符數',
    'sb_numposts'        => '發帖數',
    'sb_numpostsdscp'    => '在最新張貼組件中顯示的帖子數',
    'sb_latestposts'     => '最新帖',
    'sb_latestpostsdscp' => '僅顯示每個主題中最新的一篇帖子',
    'userdatefmt'        => '日期格式',
    'userdatefmtdscp'    => '遵從用戶設定的日期/時間格式',
    'spamxplugin'        => 'Spam-X插件',
    'spamxplugindscp'    => '在張貼前使用Spam-X插件來過濾掉可能的垃圾帖',
    'pmplugin'           => 'PM插件',
    'pmplugindscp'       => '私人消息插件已安裝並且應該已有效化',
    'smiliesplugin'      => '表情符號插件',
    
    'smiliesplugindscp'  => '使用表情符號插件或外部函數來處理表情符號',
    'geshiformat'        => '代碼格式',
    'geshiformatdscp'    => '使用GeSHi代碼格式機能',
    'edit_timewindow'    => '編輯的時間窗口',
    'edit_timewindowdscp' => '允許用戶編輯其帖子的時間窗口，以分鐘計'

);

// Board Admin
$LANG_GF93 = array (
    'gfboard'            => '論壇管理',
    'vieworder'          => '查看排序',
    'addcat'             => '增加類別',
    'addforum'           => '增加論壇',
    'order'              => '順序:',
    'catorder'           => '類別的順序',
    'forumorder'         => '論壇的順序',
    'catadded'           => '已增加類別。',
    'catdeleted'         => '已刪除類別。',
    'catedited'          => '已更新類別。',
    'forumadded'         => '已增加論壇。',
    'forumaddError'      => '增加論壇出錯。',
    'forumdeleted'       => '論壇已刪除。',
    'forumedited'        => '論壇已更新。',
    'forumordered'       => '論壇的順序已更新。',
    'transfer'           => '轉向論壇索引..',
    'vieworder'          => '查看順序',
    'back'               => '返回',
    'addnote'            => '注意: 這些變量可以編輯。',
    'editnote'           => '編輯論壇的詳細: ',
    'editforumnote'      => '集: <b>"%s"</b>',
    'deleteforumnote1'   => '真的要刪除論壇&nbsp;<b>"%s"</b>&nbsp;嗎 ?',
    'editcatnote'        => '編輯: <b>"%s"</b>',
    'deletecatnote1'     => '真的要刪除類別&nbsp;<b>"%s"</b>&nbsp;嗎 ?',
    'deletecatnote2'     => '此類別下所有的論壇和主題已被刪除。',
    'undercat'           => '類別:',
    'deleteforumnote2'   => '此論壇下所有的主題已被刪除。',
    'groupaccess'        => '組: ',
    'rebuild'            => '重建最新張貼表格',
    'action'             => '動作',
    'forumdescription'   => '論壇說明',
    'posts'              => '發帖數',
    'ordertitle'         => '順序',
    'ModDel'             => '刪除',
    'ModEdit'            => '編輯',
    'ModMove'            => '移動',
    'ModStick'           => '置頂',
    'ModBan'             => '禁止',
    'addmoderator'       => "增加協調人",
    'delmoderator'       => "刪除選中的協調人\n",
    'moderatorwarning'   => '<b>注意：找不到論壇。</b><br' . XHTML . '><br' . XHTML . '>在增加協調人之前，請先創建類別並且至少創建一個論壇。',
    'private'           => '私人論壇',
    'filtertitle'       => '顯示協調人信息',
    'addmessage'        => '增加新的協調人',
    'allowedfunctions'  => '允許權限',
    'userrecords'       => '用戶記錄',
    'grouprecords'      => '組記錄',
    'filterview'        => '過濾查看',
    'readonly'           => '只讀論壇',
    'readonlydscp'       => '僅供協調人張貼的論壇',
    'hidden'             => '隱藏論壇',
    'hiddendscp'         => '論壇不顯示在論壇索引中',
    'hideposts'          => '隱藏新帖',
    'hidepostsdscp'      => '新帖子不在新張貼組件和RSS Feed中顯示'

);

$LANG_GF94 = array (
    'mod_title'          => '論壇協調人',
    'createmod'          => '創建協調人',
    'deletemod'          => '刪除協調人',
    'currentmods'        => '現在的協調人:',
    'moderates'          => '調整',
    'deletemsg'          => '(注意: 點擊此按鈕將立刻刪除。)',
    'username'           => '用戶名:',
    'forforum'           => '論壇用:',
    'modper'             => '訪問權限:',
    'candelete'          => '可以刪除:',
    'canban'             => '可以禁止:',
    'canedit'            => '可以編輯:',
    'canmove'            => '可以移動:',
    'canstick'           => '可以置頂:',
    'addsuc'             => '已增加協調人記錄。',
    'editsuc'            => '已變更協調人記錄。',
    'removesuc'          => '已刪除協調人: ',
    'removesuc2'         => '已從全部論壇刪除協調人記錄。',
    'modexists'          => '協調人已存在。',
    'modexistsmsg'       => '錯誤: 該協調人已經注冊。',
    'transfer'           => '...',
    'removemodnote1'     => '要解任以下協調人嗎？ %s 示板：%s',
    'removemodnote2'     => '一旦解任協調人，他們將不能再管理論壇。',
    'removemodnote3'     => '要從所有論壇解任以下協調人嗎？ %s',
    'removemodnote4'     => '一旦解任協調人，他們將不能再管理任何論壇。',
    'allforums'          => '全部論壇'
);


$LANG_GF95 = array (
    'header1'           => '論壇板塊消息。',
    'header2'           => '論壇板塊消息&nbsp;&raquo;&nbsp;%s',
    'notyet'            => '該機能尚未實現。',
    'delall'            => '全部刪除',
    'delallmsg'         => '確定刪除所有消息？: %s?',
    'underforum'        => '<b> %s (ID #%s)',
    'moderate'          => '調整',
    'nomess'            => '尚未張貼消息。'
);

$LANG_GF96 = array (
    'gfipman'            => '禁止IP地址',
    'ban'                => '禁止',
    'noips'              => '<p style="margin: 0px; padding: 5px;">還沒有被禁止的IP地址!</p>',
    'unban'              => '取消禁止',
    'ipbanned'           => '已禁止IP地址',
    'banip'              => '確定禁止IP地址',
    'banipmsg'           => '確定要禁止嗎？IP %s?',
    'specip'             => '請明確指定要禁止的IP地址!',
    'ipunbanned'         => '已解除禁止。'
);

// IM.php
$LANG_GF97 = array (
    'msgsent'            => '消息已送出!',
    'msgsave'            => '您發往 %s 的消息已送出。',
    'msgreturn'          => '前往您的收件箱',
    'msgerror'           => '消息未被送出。請點擊<a href="javascript:history.back()">返回</a>，確定您已經填寫了所有項目。',
    'msgdelok'           => '已刪除。',
    'msgdelsuccess'      => '消息已刪除。',
    'msgdelerr'          => '消息未被刪除。請點擊<a href=\"javascript:history.back()\">返回</a>，選中您要刪除的條目。',
    'msgpriv'            => '私人消息',
    'msgprivnote1'       => '您有 %s 件私人消息',
    'msgprivnote2'       => '您有 %s 件私人消息',
    'msgto'              => '至用戶名:',
    'msgmembers'         => '成員列表：'
);


$PLG_forum_MESSAGE1 = '論壇插件升級成功。';
$PLG_forum_MESSAGE5 = '論壇插件升級失敗。請查看錯誤記錄(error.log)。';

?>