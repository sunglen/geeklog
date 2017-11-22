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
//@@@@@20050628 2.3用から　2.3.2_1.3.9用に改定
//@@@@@20051220 2.5RC1.3_1.3.11用に改定
//@@@@@20060327 $LANG_GF00['adminmenu'] 日本語版用に復活
//@@@@@20060427 $LANG_GF93['addmoderator']
//@@@@@20070104 2.6RC3用に更新(mystral-kk)
# Last Update 2007/02/05 by Ivy (Geeklog Japanese)
//@@@@@20070319 2.6RC4用に更新
//@@@@@20070326 2.6RC5(final)用に更新
//@@@@@20070925 2.7用に更新 $LANG_GF01['admin'],$LANG_GF93['vieworder'] 追加
//@@@@@20080721 2.7.1用に更新 $LANG_GF02['msg202']  追加

if (!defined('XHTML')) {
    define('XHTML', '');
}

$LANG_GF00 = array (
    'admin_only'        => '仅管理员。如果您是管理员，请先登录。',
    'plugin'            => '插件',
    'pluginlabel'       => '论坛',
    'searchlabel'       => '论坛',
    'statslabel'        => '全论坛发帖',
    'statsheading1'     => '论坛阅览数前十位的帖子',
    'statsheading2'     => '论坛回复数前十位的帖子',
    'statsheading3'     => '没有帖子',
    'searchresults'     => '论坛检索结果 %s',
    'useradminmenu'     => '论坛功能',
    'useradmintitle'    => '论坛用户设定',
    'access_denied'     => '拒绝访问',
    'access_denied_msg' => '该页仅供根用户访问。您的名字和ＩＰ地址已被记录。',
    'admin'             => '插件管理员',
    'install_header'    => '插件的安装/卸载',
    'installed'         => '插件与组件安装完毕。<p><em>敬请使用。<br' . XHTML . '><a href="mailto:langmail@sympatico.ca">Blaine</a></em>',
    'uninstalled'       => '插件未安装。',
    'install_success'   => '安装成功<p><b>下一步</b>:   <ol><li>使用论坛管理来创建您的论坛。<li>进行论坛的设定与个性设置。<li>至少创建一个论坛、一个目录。</ol> <p>请阅读<a href="%s">安装注意事项</a>。',





    'install_failed'    => '安装失败。 -- 请参考错误记录(error.log)来确定原因。',
    'uninstall_msg'     => '论坛插件已经卸载。',
    'install'           => '安装',
    'uninstall'         => '卸载',
    'enabled'           => '<br' . XHTML . '>插件已安装并有效化。<p>',
    'warning'           => '论坛卸载警告',
    'uploaderr'         => '文件上载错误'
);


$PLG_forum_MESSAGE1 = '论坛插件升级: 成功。';
$PLG_forum_MESSAGE2 = '论坛插件升级: 自动安装失败。请阅读插件文档。';

$LANG_GF01['LOGIN']          = '登录';
$LANG_GF01['FORUM']          = '论坛';
$LANG_GF01['ALL']            = '全部'; 
$LANG_GF01['YES']            = '是';
$LANG_GF01['NO']             = '否';
$LANG_GF01['NEW']            = '新到';
$LANG_GF01['PREV']           = '预览';
$LANG_GF01['NEXT']           = '次';
$LANG_GF01['ERROR']          = '错误!';
$LANG_GF01['CONFIRM']        = '确认';
$LANG_GF01['UPDATE']         = '更新';
$LANG_GF01['SAVE']           = '保存';
$LANG_GF01['CANCEL']         = '取消';
$LANG_GF01['CLOSE']          = '关闭';
$LANG_GF01['ON']             = '发帖日: ';
$LANG_GF01['ON2']            = '&nbsp;&nbsp;<b>On: </b>';
$LANG_GF01['IN']             = 'In: ';
$LANG_GF01['BY']             = '发帖人: ';
$LANG_GF01['RE']             = '回复: ';
$LANG_GF01['NA']             = 'N/A';
$LANG_GF01['DATE']           = '日期';
$LANG_GF01['VIEWS']          = '阅览数';
$LANG_GF01['REPLIES']        = '回复数';
$LANG_GF01['NAME']           = '名字:';
$LANG_GF01['DESCRIPTION']    = '说明: ';
$LANG_GF01['TOPIC']          = '话题';
$LANG_GF01['TOPICS']         = '投稿';
$LANG_GF01['TOPICSUBJECT']   = '话题';
$LANG_GF01['FROM']           = '从';
$LANG_GF01['REPLY']          = '新回复';
$LANG_GF01['PM']             = 'PM';
$LANG_GF01['HOME']           = '显示论坛';
$LANG_GF01['HOMEPAGE']       = '主页';
$LANG_GF01['SUBJECT']        = '标题';
$LANG_GF01['HELLO']          = '你好！ ';
$LANG_GF01['MEMBERS']        = '成员';
$LANG_GF01['MOVED']          = '移动';
$LANG_GF01['REMOVE']         = '移动&amp;删除';
$LANG_GF01['CURRENT']        = '最新';
$LANG_GF01['STARTEDBY']      = '最初的发帖人';
$LANG_GF01['POSTS']          = '帖子数';
$LANG_GF01['LASTPOST']       = '最新帖';
$LANG_GF01['POSTEDON']       = '发帖日';
$LANG_GF01['POSTEDBY']       = '发帖人';
$LANG_GF01['POSTEDON']       = '发帖日';
$LANG_GF01['PAGE']           = '页';
$LANG_GF01['PAGES']          = '页';
$LANG_GF01['ANONYMOUS']      = '匿名用户:';
$LANG_GF01['TODAY']          = '今天的';
$LANG_GF01['WELCOME']        = '欢迎 ';
$LANG_GF01['REGISTER']       = '注册';
$LANG_GF01['REGISTERED']     = '注册日';
$LANG_GF01['MOSTPOPULAR']    = '最高人气';
$LANG_GF01['ORDERBY']        = '排序:';
$LANG_GF01['ORDER']          = '顺序:';
$LANG_GF01['USER']           = '用户';
$LANG_GF01['GROUP']          = '组';
$LANG_GF01['ANON']           = '匿名用户: ';
$LANG_GF01['ADMIN']          = '管理者';
$LANG_GF01['AUTHOR']         = '发帖人';
$LANG_GF01['LOCATION']       = '场所';
$LANG_GF01['WEBSITE']        = '主页';
$LANG_GF01['EMAIL']          = '电邮';
$LANG_GF01['MOOD']           = '心情';
$LANG_GF01['NOMOOD']         = '-心情图标-';
$LANG_GF01['REQUIRED']       = '[要求]';
$LANG_GF01['OPTIONAL']       = '[可选]';
$LANG_GF01['SUBMIT']         = '提交';
$LANG_GF01['PREVIEW']        = '预览';
$LANG_GF01['NOTIFY']         = '请注意:';
$LANG_GF01['REMOVE']         = '解除';
$LANG_GF01['KEYWORDS']       = '关键词';
$LANG_GF01['EDIT']           = '编辑';
$LANG_GF01['DELETE']         = '删除';
$LANG_GF01['MESSAGE']        = '消息:';
$LANG_GF01['OPTIONS']        = '选项:';
$LANG_GF01['MISSINGSUBJECT'] = '无话题';
$LANG_GF01['MAY']            = '';
$LANG_GF01['IS']             = '是';
$LANG_GF01['FOR']            = '：';
$LANG_GF01['ARE']            = '';
$LANG_GF01['NOT']            = '非';
$LANG_GF01['YOU']            = '';
$LANG_GF01['HTML']           = 'HTML';
$LANG_GF01['FULLHTML']       = '全部HTML';
$LANG_GF01['WORDS']          = '单词';
$LANG_GF01['SMILIES']        = '表情符号';
$LANG_GF01['MIGRATE_NOW']    = '进行导入'; 
$LANG_GF01['FILTERLIST']     = '过滤列表';
$LANG_GF01['SELECTFORUM']    = '选择论坛';
$LANG_GF01['DELETEAFTER']    = '执行後删除';
$LANG_GF01['TITLE']          = '标题';
$LANG_GF01['COMMENTS']       = '评论'; 
$LANG_GF01['SUBMISSIONS']    = '已提交的';

$LANG_GF01['HTML_FILTER_MSG']  = '允许一部分的HTML';
$LANG_GF01['HTML_FULL_MSG']  = '允许全部的HTML';
$LANG_GF01['HTML_MSG']       = '允许HTML';
$LANG_GF01['CENSOR_PERM_MSG']= '检查敏感词';
$LANG_GF01['ANON_PERM_MSG']  = '看匿名用户的帖子';
$LANG_GF01['POST_PERM_MSG1'] = '可以发帖';
$LANG_GF01['POST_PERM_MSG2'] = '匿名用户可以发帖';
$LANG_GF01['CENSORED']       = '审查';
$LANG_GF01['ALLOWED']        = '许可';
$LANG_GF01['GO']             = '执行';
$LANG_GF01['STATUS']         = '状态:';
$LANG_GF01['ONLINE']         = '在线';
$LANG_GF01['OFFLINE']        = '下线';
$LANG_GF01['back2parent']    = '子题目';
$LANG_GF01['forumname']      = '';
$LANG_GF01['category']       = '类别: ';
$LANG_GF01['loginreqview']   = '<b>为了参加论坛， 请注册 %s </a> 或登录 %s  </a>。</b>';
$LANG_GF01['loginreqpost']   = '<b>为了发帖，请注册或登录。</b>';
$LANG_GF01['searchresults']  = ' 检索结果 <b>%s</b> %s ： <b>%s</b> 结果:</b><br' . XHTML . '><br' . XHTML . '>';
$LANG_GF01['feature_not_on'] = '机能未使能';
$LANG_GF01['nolastpostmsg']  = 'N/A';
$LANG_GF01['no_one']         = '没有一个。';
$LANG_GF01['popular']        = '人气顺序列表';
$LANG_GF01['notify']         = '通知';
$LANG_GF01['PM']             = 'PM\'s';
$LANG_GF01['NEW_PM']         = '新PM';
$LANG_GF01['DELALL_PM']      = '全部删除';
$LANG_GF01['DELOLDER_PM']    = '删除旧的';
$LANG_GF01['members']        = '成员列表';
$LANG_GF01['save_sucess']    = '保存成功';
$LANG_GF01['trademark']      = '<br' . XHTML . '><center><b>Geeklog Forum Project version 2.0</b> &copy; 2002</b></center>';
$LANG_GF01['back2top']       = '返回首页';
$LANG_GF01['POSTMODE']       = '发帖模式:';
$LANG_GF01['TEXTMODE']       = '文本模式';
$LANG_GF01['HTMLMODE']       = 'HTML模式';
$LANG_GF01['TopicPreview']   = '发帖预览';
$LANG_GF01['moderator']      = '调整';
$LANG_GF01['admin']          = '管理者';
$LANG_GF01['DATEADDED']      = '注册日';
$LANG_GF01['PREVTOPIC']      = '至前话题';
$LANG_GF01['NEXTTOPIC']      = '至後话题';
$LANG_GF01['CONTENT']        = '内容';
$LANG_GF01['QUOTE_begin']    = '[引用&nbsp;';
$LANG_GF01['QUOTE_by'   ]    = 'by:&nbsp;';
$LANG_GF01['RESYNC']         = "同步";
$LANG_GF01['RESYNCCAT']      = "同步分类论坛";  
$LANG_GF01['PROFILE']        = "概要";
$LANG_GF01['DELETECONFIRM']  = "确定删除记录吗?";
$LANG_GF01['website']        = '主页';
$LANG_GF01['EDITICON']       = '编辑';
$LANG_GF01['QUOTEICON']      = '引用';
$LANG_GF01['ProfileLink']    = '概要';
$LANG_GF01['WebsiteLink']    = '网站主页';
$LANG_GF01['PMLink']         = 'PM';
$LANG_GF01['EmailLink']      = '电邮';
$LANG_GF01['FORUMSUBSCRIBE'] = '订阅电邮通知';
$LANG_GF01['FORUMUNSUBSCRIBE'] = '取消电邮通知';
$LANG_GF01['FORUMSUBSCRIBE_TRUE'] = '本论坛的电邮通知:有效';
$LANG_GF01['FORUMSUBSCRIBE_FALSE'] = '本论坛的电邮通知:无效';
$LANG_GF01['NEWTOPIC']       = '发表新帖';
$LANG_GF01['SubscribeLink_TRUE']  = '本话题的电邮通知:有效';
$LANG_GF01['SubscribeLink_FALSE'] = '本话题的电邮通知:无效';
$LANG_GF01['SubscribeLink']  = '订阅电邮通知';
$LANG_GF01['unSubscribeLink'] = '取消电邮通知';
$LANG_GF01['POSTREPLY']      = '发表回复';
$LANG_GF01['SUBSCRIPTIONS']  = '发帖选项';
$LANG_GF01['TOP']            = '首页';
$LANG_GF01['PRINTABLE']      = '打印版本';
$LANG_GF01['ForumProfile']   = '论坛选项';
$LANG_GF01['USERPREFS']      = '用户设定';
$LANG_GF01['SPEEDLIMIT']     = '"您最近一次发帖是在 %s 秒之前。<br' . XHTML . '>到下一次发帖之前，请至少等待 %s 秒。"';
$LANG_GF01['ACCESSERROR']    = '访问错误';
$LANG_GF01['LEGEND']         = '凡例';
$LANG_GF01['ACTIONS']        = '动作';
$LANG_GF01['DELETEALL']      = '删除选中的全部记录';
$LANG_GF01['DELCONFIRM']     = '确定要删除选中的记录？';
$LANG_GF01['DELALLCONFIRM']  = '确定要删除选中的全部记录？';
$LANG_GF01['STARTEDBY']      = '初始发帖';
$LANG_GF01['WARNING']        = '请注意';
$LANG_GF01['MODERATED']      = '调整: %s';
$LANG_GF01['NOTIFYNOT']      = 'NOT!';
$LANG_GF01['LASTREPLYBY']    = '最新回复:&nbsp;%s';
$LANG_GF01['UID']            = 'UID';
$LANG_GF01['ANON_POST_BEGIN'] = '匿名用户发帖开始';
$LANG_GF01['ANON_POST_END']   = '匿名用户阅览终止';
$LANG_GF01['INDEXPAGE']      = '论坛索引';
$LANG_GF01['FEATURE']        = '机能';
$LANG_GF01['SETTING']        = '设定';
$LANG_GF01['MARKALLREAD']    = '全部标为已读';
$LANG_GF01['MSG_NO_CAT']     = '类别或论坛未定义。';

// Language for bbcode toolbar
$LANG_GF01['CODE']           = '代码';
$LANG_GF01['FONTCOLOR']      = '文字色';
$LANG_GF01['FONTSIZE']       = '文字大小';
$LANG_GF01['CLOSETAGS']      = '关闭标签';
$LANG_GF01['CODETIP']        = '小提示: 选中的文字能立刻应用风格';
$LANG_GF01['TINY']           = '很小';
$LANG_GF01['SMALL']          = '小';
$LANG_GF01['NORMAL']         = '标准';
$LANG_GF01['LARGE']          = '大';
$LANG_GF01['HUGE']           = '很大';
$LANG_GF01['DEFAULT']        = '缺省';
$LANG_GF01['DKRED']          = '深红';
$LANG_GF01['RED']            = '红';
$LANG_GF01['ORANGE']         = '橙';
$LANG_GF01['BROWN']          = '棕';
$LANG_GF01['YELLOW']         = '黄';
$LANG_GF01['GREEN']          = '绿';
$LANG_GF01['OLIVE']          = '橄榄';
$LANG_GF01['CYAN']           = '水色';
$LANG_GF01['BLUE']           = '蓝';
$LANG_GF01['DKBLUE']         = '深蓝';
$LANG_GF01['INDIGO']         = '靛青';
$LANG_GF01['VIOLET']         = '紫';
$LANG_GF01['WHITE']          = '白';
$LANG_GF01['BLACK']          = '黑';

$LANG_GF01['b_help']         = "粗体: [b]text[/b]";
$LANG_GF01['i_help']         = "斜体: [i]text[/i]";
$LANG_GF01['u_help']         = "下划线: [u]text[/u]";
$LANG_GF01['q_help']         = "引用: [quote]text[/quote]";
$LANG_GF01['c_help']         = "代码显示: [code]code[/code]";
$LANG_GF01['l_help']         = "无数字列表: [list]text[/list]";
$LANG_GF01['o_help']         = "数字列表: [olist]text[/olist]";
$LANG_GF01['p_help']         = "[img]http://图像的url[/img]  或  [img w=100 h=200][/img]";
$LANG_GF01['w_help']         = "插入URL: [url]http://url[/url] 或 [url=http://url]URL文本[/url]";
$LANG_GF01['a_help']         = "关闭所有没有关闭的bbCode标签";
$LANG_GF01['s_help']         = "文字色: [color=red]text[/color]  小提示: 能指定 color=#FF0000 这样的形式";
$LANG_GF01['f_help']         = "文字大小: [size=x-small]小字[/size]";
$LANG_GF01['h_help']         = "请点击观看详细帮助";


$LANG_GF02['msg01']    = '对不起，您必须注册来参加论坛。 ';
$LANG_GF02['msg02']    = '对不起，您必须注册来参加论坛。';
$LANG_GF02['msg03']    = '';
$LANG_GF02['msg04']    = '';
$LANG_GF02['msg05']    = '<center><em>对不起，还没有创建话题。</em></center>';
$LANG_GF02['msg06']    = '自从您上次访问结束以后的新帖';
$LANG_GF02['msg07']    = '在线用户:';
$LANG_GF02['msg08']    = '<br' . XHTML . '><b>全部的注册用户的注册日时:</b> %s';
$LANG_GF02['msg09']    = '<br' . XHTML . '><b>全部的发帖日时:</b> %s <br' . XHTML . '>';
$LANG_GF02['msg10']    = '<b>全部的话题日时:</b> %s <br' . XHTML . '>';
$LANG_GF02['msg11']    = '返回论坛索引';
$LANG_GF02['msg12']    = '返回主页';
$LANG_GF02['msg13']    = '必须注册。您必须注册或登录来使用这项机能。';
$LANG_GF02['msg14']    = '对不起，您被禁止制作条目。<br' . XHTML . '>';
$LANG_GF02['msg15']    = '如果您觉得这是一个错误， 请联系<a href="mailto:%s?subject=Guestbook IP Ban">论坛管理者</a>。';
$LANG_GF02['msg16']    = '这些是最热门的帖子，您可以用阅览数或回复数来排序。';
$LANG_GF02['msg17']    = '消息编辑完成。';
$LANG_GF02['msg18']    = '错误! 没有输入必须项目或者长度过短。';
$LANG_GF02['msg19']    = '消息已发表';
$LANG_GF02['msg20']    = '回复已发表。';
$LANG_GF02['msg21']    = '没有执行权限。请<a href="javascript:history.back()">返回</a>或<a href="%s/users.php?mode=login">登录</a>。<br' . XHTML . '><br' . XHTML . '>'; 
$LANG_GF02['msg22']    = '- 论坛发帖通知';
$LANG_GF02['msg23a']   = "论坛[%s]中有来自%s会员的新回复。\n（话题发起：%s会员　论坛板块：%s）";
$LANG_GF02['msg23b']   = "新话题 '%s' 由\n%s 会员发表到 %s 论坛。\n（站点：%s）\n\n%s/forum/viewtopic.php?showtopic=%s\n";
$LANG_GF02['msg23c']   = "%s/forum/viewtopic.php?showtopic=%s&amp;lastpost=true\n";
$LANG_GF02['msg24']    = '线索: ';
$LANG_GF02['msg25']    = "\n";
$LANG_GF02['msg26']    = "\n※该话题设定为电邮通知。";
$LANG_GF02['msg27']    = "取消电邮通知\n: \n%s\n";
$LANG_GF02['msg28']    = '错误：无标题。';
$LANG_GF02['msg29']    = '您的署名会放在这里。';
$LANG_GF02['msg30']    = '返回首页';
$LANG_GF02['msg31']    = '<b>可编辑:</b>';
$LANG_GF02['msg32']    = '<b>编辑消息</b>';
$LANG_GF02['msg33']    = '发帖人: ';
$LANG_GF02['msg34']    = '电邮:';
$LANG_GF02['msg35']    = '网站:';
$LANG_GF02['msg36']    = '心情图标:';
$LANG_GF02['msg37']    = '消息:';
$LANG_GF02['msg38']    = '电邮通知';
$LANG_GF02['msg39']    = '<br' . XHTML . '>该新话题无话题回复。';
$LANG_GF02['msg40']    = '<br' . XHTML . '>已设定电邮通知。<br' . XHTML . '><br' . XHTML . '>';
$LANG_GF02['msg41']    = '<br' . XHTML . '>对话题 %s 的回复已设定电邮通知。<br' . XHTML . '><br' . XHTML . '>';
$LANG_GF02['msg42']    = '电邮通知已解除。';
$LANG_GF02['msg43']    = '确定要解除此电邮通知?.';
$LANG_GF02['msg44']    = '<p style="margin:0px; padding:5px;">当前您没有电邮通知。</p>';
$LANG_GF02['msg45']    = '检索论坛';
$LANG_GF02['msg46']    = '论坛关键词检索:';
$LANG_GF02['msg47']    = '可指定发帖人名:';
$LANG_GF02['msg48']    = '<br' . XHTML . '>请先安装Chatterblock插件。';
$LANG_GF02['msg49']    = '(阅读数 %s次) ';
$LANG_GF02['msg50']    = '署名 n/a';
$LANG_GF02['msg51']    = "%s\n\n<br" . XHTML . ">[编辑 %s by %s]";
$LANG_GF02['msg52']    = '确定:';
$LANG_GF02['msg53']    = '返回话题..';
$LANG_GF02['msg54']    = '帖子已被编辑。';
$LANG_GF02['msg55']    = '帖子已被删除。';
$LANG_GF02['msg56']    = 'IP地址已被禁止。';
$LANG_GF02['msg57']    = '置顶设定';
$LANG_GF02['msg58']    = '解除置顶设定';
$LANG_GF02['msg59']    = '一般';
$LANG_GF02['msg60']    = '新到';
$LANG_GF02['msg61']    = '置顶话题';
$LANG_GF02['msg62']    = '如有回复则电邮通知';
$LANG_GF02['msg63']    = '概要';
$LANG_GF02['msg64']    = '真的要删除话题 %s 标题: %s ?';
$LANG_GF02['msg65']    = '<br' . XHTML . '>这是一个子话题。因此它的所有回复也将被删除。';
$LANG_GF02['msg66']    = '确认删贴';
$LANG_GF02['msg67']    = '编辑论坛帖子';
$LANG_GF02['msg68']    = '注意: 禁止某人时需要特别小心。只有管理者才有权解除禁止。';
$LANG_GF02['msg69']    = '<br' . XHTML . '>本当にこのIPアドレスを禁止しますか: %s?';
$LANG_GF02['msg70']    = '确定禁止';
$LANG_GF02['msg71']    = '没有选择机能。请选择帖子来执行调整。<br' . XHTML . '>注意: 您必须作为协调人来使用这些机能。';
$LANG_GF02['msg72']    = '警告：您无权执行该调整操作。';
$LANG_GF02['msg74']    = '最近发表的 %s 条';
$LANG_GF02['msg75']    = '阅览数最多的 %s 篇话题';
$LANG_GF02['msg76']    = '回帖最多的 %s 篇话题';
$LANG_GF02['msg77']    = '<br' . XHTML . '><p style="padding-left: 10px;">对不起。请先登录。如果没有帐号的话请注册。</p>';
$LANG_GF02['msg78']    = '<br' . XHTML . '>此处无论坛。';
$LANG_GF02['msg81']    = '- 话题编辑通知';
$LANG_GF02['msg82']    = '<p>您的消息 "%s" 已被协调人 %s 编辑。</p>';
$LANG_GF02['msg83']    = '<br' . XHTML . '><br' . XHTML . '><p>请输入论坛的话题。</p>';
$LANG_GF02['msg84']    = '全部标为已读';
$LANG_GF02['msg85']    = '页:';
$LANG_GF02['msg86']    = '最新 %s 帖子　发贴人: ';
$LANG_GF02['msg87']    = '<br' . XHTML . '>警告：该话题已被锁定。<br' . XHTML . '>无法继续张贴。';
$LANG_GF02['msg88']    = '论坛成员列表';
$LANG_GF02['msg88b']   = '仅论坛活跃者';
$LANG_GF02['msg89']    = '电邮通知设定列表';
$LANG_GF02['msg100']   = '信息:';
$LANG_GF02['msg101']   = '规则:';
$LANG_GF02['msg102']   = '发帖凡例:';
$LANG_GF02['msg103']   = '论坛跳转:';
$LANG_GF02['msg104']   = '帖子消息';
$LANG_GF02['msg105']   = '编辑你的帖子';
$LANG_GF02['msg106']   = '选择论坛';
$LANG_GF02['msg107']   = '论坛凡例:';
$LANG_GF02['msg108']   = '有新帖的论坛';
$LANG_GF02['msg109']   = '被锁定的话题';
$LANG_GF02['msg110']   = '转向编辑页面...';
$LANG_GF02['msg111']   = '未读列表:';
$LANG_GF02['msg112']   = '显示未读';
$LANG_GF02['msg113']   = '显示未读';
$LANG_GF02['msg114']   = '已锁定';
$LANG_GF02['msg115']   = '置顶 新到';
$LANG_GF02['msg116']   = '锁定 新到';
$LANG_GF02['msg117']   = '检索网站';
$LANG_GF02['msg118']   = '检索论坛';
$LANG_GF02['msg119']   = '检索结果:';
$LANG_GF02['msg120']   = '人气排序 by';
$LANG_GF02['msg121']   = '时刻全部为 %s ， 现在的时刻是 %s';
$LANG_GF02['msg122']   = '人气话题条件';
$LANG_GF02['msg123']   = '人气话题所要求的发帖数';
$LANG_GF02['msg124']   = '每页的消息数';
$LANG_GF02['msg125']   = '仅供协调人: 消息列表页面';
$LANG_GF02['msg126']   = '检索行';
$LANG_GF02['msg127']   = '检索结果的显示行数';
$LANG_GF02['msg128']   = '成员数/页';
$LANG_GF02['msg129']   = '发帖人列表中一页显示的人数';
$LANG_GF02['msg130']   = '查看匿名用户帖子';
$LANG_GF02['msg131']   = '设定是否显示匿名用户的帖子';
$LANG_GF02['msg132']   = '电邮通知模式';
$LANG_GF02['msg133']   = '是否设定创建话题或回帖时自动电邮通知';
$LANG_GF02['msg134']   = '订阅电邮通知。';
$LANG_GF02['msg135']   = '在本论坛中的所有张贴都将电邮通知您。';
$LANG_GF02['msg136']   = '请选择发表论坛。';
$LANG_GF02['msg137']   = '如有回复则电邮通知。';
$LANG_GF02['msg138']   = '<b>订阅全部论坛</b>';
$LANG_GF02['msg139']   = '%s 继续请<a href="%s">点击</a>';
$LANG_GF02['msg140']   = '继续';
$LANG_GF02['msg141']   = '该页会自动返回。如果没有返回或不想等待请点击 <a href="%s">这里</a>';
$LANG_GF02['msg142']   = '邮件通知已开始。';
$LANG_GF02['msg143']   = '通知';
$LANG_GF02['msg144']   = '返回话题';
$LANG_GF02['msg145']   = '阅读话题';
$LANG_GF02['msg146']   = '电邮通知已解除。';
$LANG_GF02['msg147']   = '论坛印刷版';
$LANG_GF02['msg148']   = '<a href="javascript:history.back()">返回</a>';
$LANG_GF02['msg149']   = ' %s 发送及时消息。';
$LANG_GF02['msg150']   = '在您的帖子 %s 中';
$LANG_GF02['msg151']   = '最新话题';
$LANG_GF02['msg152']   = '人气话题';
$LANG_GF02['msg153']   = '人气回复';
$LANG_GF02['msg154']   = '最新话题';
$LANG_GF02['msg155']   = '没有帖子';
$LANG_GF02['msg156']   = '帖子数';
$LANG_GF02['msg157']   = '最新10条帖子';
$LANG_GF02['msg158']   = '最新10条帖子发贴人 ';
$LANG_GF02['msg159']   = '真的要删除这些选中的协调人的记录吗？';
$LANG_GF02['msg160']   = '显示最后一页';
$LANG_GF02['msg161']   = '返回成员列表';
$LANG_GF02['msg162']   = '点击<a href="%s">这里</a><br' . XHTML . '>返回论坛索引。默认自动转向您的帖子，如果您不想等待请点击 <a href="%s">这里</a>';
$LANG_GF02['msg163']   = '帖子已移动。';
$LANG_GF02['msg164']   = '全部标为已读';
$LANG_GF02['msg165']   = '<p>错误: 匹配的 <b>引用(QUOTE)</b> 标签丢失。无法生成指定格式。</p>';
$LANG_GF02['msg166']   = '错误: 无效话题或话题没有找到。';
$LANG_GF02['msg167']   = '通知选项';
$LANG_GF02['msg168']   = '设定为否将取消电邮通知';
$LANG_GF02['msg169']   = '返回成员列表';
$LANG_GF02['msg170']   = '最近发表';
$LANG_GF02['msg171']   = '论坛访问错误';
$LANG_GF02['msg172']   = '话题不存在，可能已删除。';
$LANG_GF02['msg173']   = '转向消息发表页面...';
$LANG_GF02['msg174']   = '无法禁止成员 - 不正确的或空的IP地址';
$LANG_GF02['msg175']   = '返回论坛列表';
$LANG_GF02['msg176']   = '选择成员';
$LANG_GF02['msg177']   = '所有成员';
$LANG_GF02['msg178']   = '仅子帖';
$LANG_GF02['msg179']   = '内容生成: %s 秒';
$LANG_GF02['msg180']   = '论坛张贴警告';
$LANG_GF02['msg181']   = '您作为协调人无法访问其他论坛。';
$LANG_GF02['msg182']   = '协调人确认';
$LANG_GF02['msg183']   = '新发贴: %s';
$LANG_GF02['msg184']   = '仅通知一次';
$LANG_GF02['msg185']   = '到您下次访问之前，您订阅的论坛和话题中，即使有多篇新帖发表，也仅电邮通知您一次。';
$LANG_GF02['msg186']   = '新标题';
$LANG_GF02['msg187']   = '<a href="%s">返回话题</a>';
$LANG_GF02['msg188']   = '跳转到最新的帖子。';
$LANG_GF02['msg189']   = '错误: 现在这篇帖子已不能再编辑了。';
$LANG_GF02['msg190']   = '安静编辑';
$LANG_GF02['msg191']   = '无法编辑。可能是允许编辑的时间窗口已经过去，或是您没有协调人权限。';
$LANG_GF02['msg192']   = '完毕。 导入%s个话题和%s个评论。';
$LANG_GF02['msg193']   = '将文章导入论坛的工具';  
$LANG_GF02['msg194']   = '没有新帖的论坛';
$LANG_GF02['msg195']   = '点击跳转到论坛';
$LANG_GF02['msg196']   = '查看主论坛索引';
$LANG_GF02['msg197']   = '标记已读';
$LANG_GF02['msg198']   = '更新论坛设置';
$LANG_GF02['msg199']   = '查看/删除论坛通知';
$LANG_GF02['msg200']   = '成员报告';
$LANG_GF02['msg201']   = '话题报告';
$LANG_GF02['msg202']   = '无新帖';

$LANG_GF02['msg300']   = '设定为不显示匿名用户的帖子。';

$LANG_GF02['StatusHeading']   = '信息';
$LANG_GF02['PostReply']   = '发表新回复';
$LANG_GF02['PostTopic']   = '发表新话题';
$LANG_GF02['EditTopic']   = '编辑话题';
$LANG_GF02['quietforum']  = '论坛中没有新话题。';

$LANG_GF03 = array (
    'welcomemsg'        => '欢迎，协调人',
    'title'             => '协调人机能:&nbsp;',
    'delete'            => '删除',
    'edit'              => '编辑',
    'move'              => '移动',
    'ban'               => 'IP地址禁止',
    'stick'             => '设定置顶',
    'unstick'           => '取消置顶',
    'movetopic'         => '移动&amp;删除',
    'movetopicmsg'      => '<br' . XHTML . '> 移动话题： <b>%s</b> ',
    'lockedpost'        => '追加回复',
    'split'             => '分割话题',
    'splittopicmsg'     => '<br' . XHTML . '>用该贴新建话题: "<b>%s</b>"<br' . XHTML . '><em>发帖人:</em>&nbsp;%s&nbsp; <em>原帖:</em>&nbsp;%s',
    'selectforum'       => '选择新论坛:',
    'splitheading'      => '分割线索选项:',
    'splitopt1'         => '移动从这里开始的全部帖子',
    'splitopt2'         => '仅移动这一个帖子'
);

$LANG_GF04 = array (
    'label_forum'             => '论坛的概要',
    'label_location'          => '场所',
    'label_aim'               => 'AIM用户名',
    'label_yim'               => 'YIM用户名',
    'label_icq'               => 'ICQ用户名',
    'label_msnm'              => 'MSN用户名',
    'label_interests'         => '爱好',
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
    1   => '统计',
    2   => '设定',
    3   => '论坛管理',
    4   => '协调人',
    5   => '转换',
    6   => '消息',
    7   => '禁止IP地址'
);

/* User Functions Navbar */
$LANG_GF07 = array (
    1   => '显示论坛',
    2   => '用户设定',
    3   => '人气话题',
    4   => '电邮通知列表',
    5   => '成员列表'
);



/* Forum User Features */
$LANG_GF08 = array (
    1   => '话题电邮通知',
    2   => '论坛电邮通知',
    3   => '话题电邮通知的例外'
);


$LANG_GF90 = array (
    'viewforums'        => '索引',
    'stats'             => '统计',
    'settings'          => '设定',
    'boardadmin'        => '论坛',
    'migrate'           => '转换',
    'mods'              => '协调人',
    'messages'          => '消息',
    'ipman'             => '禁止IP地址'
);

$LANG_GF91 = array (
    'gfstats'            => '论坛的统计',
    'statsmsg'           => '现在:',
    'totalcats'          => '合计 类别数:',
    'totalforums'        => '合计 论坛数:',
    'totaltopics'        => '合计 话题数:',
    'totalposts'         => '合计 发表数:',
    'totalviews'         => '合计 阅览数:',
    'avgpmsg'            => '平均发表数:',
    'category'           => '类别:',
    'forum'              => '论坛:',
    'topic'              => '话题:',
    'avgvmsg'            => '平均阅览数:'
);

// Settings.php 
$LANG_GF92 = array (
    'gfsettings'         => '设定',
    'gensettings'        => '一般',
    'gensettings'        => '一般',
    'topicsettings'      => '话题发表设定',
    'blocksettings'      => '站点组件(forum_newposts)',
    'ranksettings'       => '排位说明设定',
    'htmlsettings'       => 'HTML设定',
    'avsettings'         => '头像设定',
    'ranksettings'       => '排位设定',
    'savesettings'       => '    保存变更    ', 
    'allowhtml'          => 'HTML使用',
    'allowhtmldscp'      => '发帖时允许HTML的使用。如果设定为否，则只能使用纯文本模式发帖，但bbcode仍然有效。',//'Enable HTML to be used in posts. If set to NO then users will only be able to post in TEXT Mode but still use bbcode'
    'glfilter'           => 'HTML过滤器',
    'glfilterdscp'       => '使用Geeklog本身的HTML过滤器',
    'censor'             => '审查',
    'censordscp'         => '审查（使用Geeklog本身的设查功能）',
    'showmoods'          => '心情图标',
    'showmoodsdscp'      => '使用',
    'allowsmilies'       => '表情图标',
    'allowsmiliesdscp'   => '使用',
    'allownotify'        => '允许通知:',
    'allownotifydscp'    => '允许话题更新时的电邮通知',
    'showiframe'         => '显示话题内容',
    'showiframedscp'     => '当回复话题的时候，在下面显示话题的内容',
    'autorefresh'        => '自动刷新',
    'autorefreshdscp'    => '提交後自动刷新',
    'refreshdelay'       => '刷新延迟时间（秒）',
    'refreshdelaydscp'   => '指定自动刷新的情况下，刷新的延迟时间（以秒计）',
    'xtrausersettings'   => '论坛的用户设定',
    'xtrausersettingsdscp'    => '允许可选的额外用户设定',
    'titleleng'          => '标题的长度',
    'titlelengdscp'      => '能够输入的标题的最大长度（字符数）',
    'topicspp'           => '每页显示的话题数',
    'topicsppdscp'       => '在各论坛的话题索引页面，一页显示的话题数',
    'postspp'            => '每页显示的帖子数',
    'postsppdscp'        => '在各话题页面，一页显示的帖子数',
    'regview'            => '允许阅览',
    'regviewdscp'        => '需要注册才能阅览帖子',
    'regpost'            => '允许发帖',
    'regpostdscp'        => '需要注册才能发帖',
    'imgset'             => '图像集合',
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
    'setsave'            => '设定已保存',
    'setsavemsg'         => '设定已保存。',
    'allownotify'        => '电邮通知',
    'allownotifydscp'    => '是否允许电邮通知',
    'defaultmode'        => '默认张贴模式',
    'defaultmodedscp'    => '要将HTML模式设为默认，请选择是。<br' . XHTML . '>要将纯文本模式设为默认（比较安全），请选择否。',
    'cbsettings'         => '中组件设定',
    'cbenable'           => '显示中组件',
    'cbenabledscp'       => '显示中组件',
    'cbhomepage'         => '仅首页',
    'cbhomepagedscp'     => '仅显示在第一页',
    'cbposition'         => '位置',
    'cbpositiondscp'     => '显示位置',
    'position'           => '位置 ', 
    'all_topics'         => '全部',
    'no_topic'           => '仅主页',
    'position_top'       => '页眉',
    'position_feat'      => '在置顶帖之后',
    'position_bottom'    => '页脚',
    'messagespp'         => '每页的消息数',
    'messagesppdscp'     => '消息管理页面 - 每页的消息行数',
    'searchespp'         => '检索结果',
    'searchesppdscp'     => '检索结果中每页的记录数',
    'minnamelength'      => '名字的最短长度',
    'minnamedscp'        => '成员名或匿名用户名需要的最小字符数',
    'mincommentlength'   => '最小文本长度',
    'mincommentdscp'     => '帖子内容的最小字符数',
    'minsubjectlength'   => '最小标题长度',
    'minsubjectdscp'     => '标题的最小字符数',
    'popular'            => '人气话题',
    'populardscp'        => '人气话题帖需要的最小阅览数',
    'convertbreak'       => '转换新行符号',
    'convertbreakdscp'   => '将新行符号转换为HTML标签(&lt;br&gt;)',
    'speedlimit'         => '发帖时间间隔限制',
    'speedlimitdscp'     => '为防止垃圾帖，限制发帖的间隔时间，以秒计',
    'cb_subjectsize'     => '标题长度',
    'cb_subjectsizedscp' => '显示的标题的字符数',
    'cb_numposts'        => '发帖数',
    'cb_numpostsdscp'    => '在中组件中显示的帖子数',
    'sb_subjectsize'     => '标题长度',
    'sb_subjectsizedscp' => '显示的标题的字符数',
    'sb_numposts'        => '发帖数',
    'sb_numpostsdscp'    => '在最新发表组件中显示的帖子数',
    'sb_latestposts'     => '最新帖',
    'sb_latestpostsdscp' => '仅显示每个话题中最新的一篇帖子',
    'userdatefmt'        => '日期格式',
    'userdatefmtdscp'    => '遵从用户设定的日期/时间格式',
    'spamxplugin'        => 'Spam-X插件',
    'spamxplugindscp'    => '在张贴前使用Spam-X插件来过滤掉可能的垃圾帖',
    'pmplugin'           => 'PM插件',
    'pmplugindscp'       => '私人消息插件已安装并且应该已有效化',
    'smiliesplugin'      => '表情符号插件',
    
    'smiliesplugindscp'  => '使用表情符号插件或外部函数来处理表情符号',
    'geshiformat'        => '代码格式',
    'geshiformatdscp'    => '使用GeSHi代码格式机能',
    'edit_timewindow'    => '编辑的时间窗口',
    'edit_timewindowdscp' => '允许用户编辑其帖子的时间窗口，以分钟计'

);

// Board Admin
$LANG_GF93 = array (
    'gfboard'            => '论坛管理',
    'vieworder'          => '查看排序',
    'addcat'             => '增加类别',
    'addforum'           => '增加论坛',
    'order'              => '顺序:',
    'catorder'           => '类别的顺序',
    'forumorder'         => '论坛的顺序',
    'catadded'           => '已增加类别。',
    'catdeleted'         => '已删除类别。',
    'catedited'          => '已更新类别。',
    'forumadded'         => '已增加论坛。',
    'forumaddError'      => '增加论坛出错。',
    'forumdeleted'       => '论坛已删除。',
    'forumedited'        => '论坛已更新。',
    'forumordered'       => '论坛的顺序已更新。',
    'transfer'           => '转向论坛索引..',
    'vieworder'          => '查看顺序',
    'back'               => '返回',
    'addnote'            => '注意: 这些变量可以编辑。',
    'editnote'           => '编辑论坛的详细: ',
    'editforumnote'      => '編集: <b>"%s"</b>',
    'deleteforumnote1'   => '真的要删除论坛&nbsp;<b>"%s"</b>&nbsp;吗 ?',
    'editcatnote'        => '编辑: <b>"%s"</b>',
    'deletecatnote1'     => '真的要删除类别&nbsp;<b>"%s"</b>&nbsp;吗 ?',
    'deletecatnote2'     => '此类别下所有的论坛和话题已被删除。',
    'undercat'           => '类别:',
    'deleteforumnote2'   => '此论坛下所有的话题已被删除。',
    'groupaccess'        => '组: ',
    'rebuild'            => '重建最新发表表格',
    'action'             => '动作',
    'forumdescription'   => '论坛说明',
    'posts'              => '发帖数',
    'ordertitle'         => '顺序',
    'ModDel'             => '删除',
    'ModEdit'            => '编辑',
    'ModMove'            => '移动',
    'ModStick'           => '置顶',
    'ModBan'             => '禁止',
    'addmoderator'       => "增加协调人",
    'delmoderator'       => "删除选中的协调人\n",
    'moderatorwarning'   => '<b>注意：找不到论坛。</b><br' . XHTML . '><br' . XHTML . '>在增加协调人之前，请先创建类别并且至少创建一个论坛。',
    'private'           => '私人论坛',
    'filtertitle'       => '显示协调人信息',
    'addmessage'        => '增加新的协调人',
    'allowedfunctions'  => '允许权限',
    'userrecords'       => '用户记录',
    'grouprecords'      => '组记录',
    'filterview'        => '过滤查看',
    'readonly'           => '只读论坛',
    'readonlydscp'       => '仅供协调人发表的论坛',
    'hidden'             => '隐藏论坛',
    'hiddendscp'         => '论坛不显示在论坛索引中',
    'hideposts'          => '隐藏新帖',
    'hidepostsdscp'      => '新帖子不在最新发表组件和RSS Feed中显示'

);

$LANG_GF94 = array (
    'mod_title'          => '论坛协调人',
    'createmod'          => '创建协调人',
    'deletemod'          => '删除协调人',
    'currentmods'        => '现在的协调人:',
    'moderates'          => '调整',
    'deletemsg'          => '(注意: 点击此按钮将立刻删除。)',
    'username'           => '用户名:',
    'forforum'           => '论坛用:',
    'modper'             => '访问权限:',
    'candelete'          => '可以删除:',
    'canban'             => '可以禁止:',
    'canedit'            => '可以编辑:',
    'canmove'            => '可以移动:',
    'canstick'           => '可以置顶:',
    'addsuc'             => '已增加协调人记录。',
    'editsuc'            => '已变更协调人记录。',
    'removesuc'          => '已删除协调人: ',
    'removesuc2'         => '已从全部论坛删除协调人记录。',
    'modexists'          => '协调人已存在。',
    'modexistsmsg'       => '错误: 该协调人已经注册。',
    'transfer'           => '...',
    'removemodnote1'     => '要解任以下协调人吗？ %s 掲示板：%s',
    'removemodnote2'     => '一旦解任协调人，他们将不能再管理论坛。',
    'removemodnote3'     => '要从所有论坛解任以下协调人吗？ %s',
    'removemodnote4'     => '一旦解任协调人，他们将不能再管理任何论坛。',
    'allforums'          => '全部论坛'
);


$LANG_GF95 = array (
    'header1'           => '论坛板块消息。',
    'header2'           => '论坛板块消息&nbsp;&raquo;&nbsp;%s',
    'notyet'            => '该机能尚未实现。',
    'delall'            => '全部删除',
    'delallmsg'         => '确定删除所有消息？: %s?',
    'underforum'        => '<b> %s (ID #%s)',
    'moderate'          => '调整',
    'nomess'            => '尚未发表消息。'
);

$LANG_GF96 = array (
    'gfipman'            => '禁止IP地址',
    'ban'                => '禁止',
    'noips'              => '<p style="margin: 0px; padding: 5px;">还没有被禁止的IP地址!</p>',
    'unban'              => '取消禁止',
    'ipbanned'           => '已禁止IP地址',
    'banip'              => '确定禁止IP地址',
    'banipmsg'           => '确定要禁止吗？IP %s?',
    'specip'             => '请明确指定要禁止的IP地址!',
    'ipunbanned'         => '已解除禁止。'
);

// IM.php
$LANG_GF97 = array (
    'msgsent'            => '消息已送出!',
    'msgsave'            => '您发往 %s 的消息已送出。',
    'msgreturn'          => '前往您的收件箱',
    'msgerror'           => '消息未被送出。请点击<a href="javascript:history.back()">返回</a>，确定您已经填写了所有项目。',
    'msgdelok'           => '已删除。',
    'msgdelsuccess'      => '消息已删除。',
    'msgdelerr'          => '消息未被删除。请点击<a href=\"javascript:history.back()\">返回</a>，选中您要删除的条目。',
    'msgpriv'            => '私人消息',
    'msgprivnote1'       => '您有 %s 条私人消息',
    'msgprivnote2'       => '您有 %s 条私人消息',
    'msgto'              => '至用户名:',
    'msgmembers'         => '成员列表：'
);


$PLG_forum_MESSAGE1 = '论坛插件升级成功。';
$PLG_forum_MESSAGE5 = '论坛插件升级失败。请查看错误记录(error.log)。';

?>