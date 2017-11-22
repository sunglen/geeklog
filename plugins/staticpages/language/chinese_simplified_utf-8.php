<?php

###############################################################################
# chinese_simplified_utf-8.php
# This is the Chinese Simplified Unicode (utf-8) language set
# for the Geeklog Static Page Plug-in!
#
# Last updated January 10, 2006
#
# Copyright (C) 2005 Samuel M. Stone
# sam@stonemicro.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => '新建页面',
    'adminhome' => '管理主页',
    'staticpages' => '静态页',
    'staticpageeditor' => '静态页编辑器',
    'writtenby' => '作者',
    'date' => '更新日期',
    'title' => '标题',
    'page_title' => '网页标题',
    'content' => '内容',
    'hits' => '阅览数',
    'staticpagelist' => '静态页管理',
    'url' => '网址',
    'edit' => '编辑',
    'lastupdated' => '更新日期',
    'pageformat' => '网页格式',
    'leftrightblocks' => '页眉、页脚、左右组件',
    'blankpage' => '整页显示（无页眉、页脚、组件）',
    'noblocks' => '无组件（有页眉、页脚）',
    'leftblocks' => '页眉、页脚、左组件（无右组件）',
    'addtomenu' => '页眉菜单',
    'label' => '菜单名',
    'nopages' => '此系统无静态页',
    'save' => '保存',
    'preview' => '预览',
    'delete' => '删除',
    'cancel' => '取消',
    'access_denied' => '对不起，请先登录。',
    'access_denied_msg' => '若勾选，在无访问权限的情况下，将自动转向登录页面。若不勾选，则显示“无此权限”的消息。',
    'all_html_allowed' => '可使用全部HTML标签',
    'results' => '静态页的检索结果',
    'author' => '作者',
    'no_title_or_content' => '请填入<b>标题</b>和<b>内容</b>。',
    'no_such_page_anon' => '请登录。',
    'no_page_access_msg' => "发生该问题是因为您没有登录，或者您还不是本站（{$_CONF['site_name']}）的成员。请<a href=\"{$_CONF['site_url']}/users.php?mode=new\">注册成为用户</a> 来取得适当的访问权限。",
    'php_msg' => 'PHP: ',
    'php_warn' => '<br' . XHTML .'>注意: 该选项有效後，您的页面中所含的PHP代码将会执行。要使用静态页PHP，请首先在管理页面“小组：静态页管理（Static Page Admin）”中，选中权限“staticpages.PHP”。使用PHP的场合，请使用通常不返回（return）的“执行PHP”模式。在使用PHP时请注意这些细微之处。',
    'exit_msg' => '登录要求: ',
    'exit_info' => '若勾选，则在没有阅览权限的情况下，转向登录页面。<br' . XHTML .'>    若不勾选，则显示“无此权限”的消息。',
    'deny_msg' => '页面访问被拒绝。页面已被移动或删除，或无访问权限。',
    'stats_headline' => '静态页（头10个）',
    'stats_page_title' => '网页标题',
    'stats_hits' => '阅览数',
    'stats_no_hits' => '无静态页或无人点击过。',
    'id' => 'ID',
    'duplicate_id' => '指定ID已被使用，请使用别的ID。',
    'instructions' => '要编辑、删除静态页，请点击编辑图标；要复制静态页，请点击复制图标。要创建静态页，请点击“新建”。',
    'centerblock' => '中心区域: ',
    'centerblock_msg' => '若勾选，将显示于首页或主题首页的中心区域。',
    'topic' => '主题: ',
    'position' => '显示区域: ',
    'all_topics' => '所有',
    'no_topic' => '仅主页',
    'position_top' => '页面的最上部',
    'position_feat' => '置顶文章的下方',
    'position_bottom' => '页面的下方',
    'position_entire' => '整页',
    'head_centerblock' => '中组件',
    'centerblock_no' => '否',
    'centerblock_top' => '上部',
    'centerblock_feat' => '置顶文章',
    'centerblock_bottom' => '下部',
    'centerblock_entire' => '整页',
    'inblock_msg' => '限制于组件内: ',
    'inblock_info' => '显示标题，内容限制于组件框内。',
    'title_edit' => '编辑',
    'title_copy' => '复制此页',
    'title_display' => '显示此页',
    'select_php_none' => '不执行PHP',
    'select_php_return' => '执行PHP (return)',
    'select_php_free' => '执行PHP',
    'php_not_activated' => "静态页中未激活PHP。详细情况请浏览<a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">关联文档（英文）</a> 。",
    'printable_format' => '打印格式',
    'copy' => '复制',
    'limit_results' => '缩小范围检索',
    'search' => '检索',
    'submit' => '提交',
    'no_new_pages' => '-',
    'pages' => '页',
    'comments' => '评论',
    'draft' => '草稿',
    'draft_yes' => '是',
    'draft_no' => '否'
);

$PLG_staticpages_MESSAGE15 = '您的评论已经提交，请等待管理员的审核。';
$PLG_staticpages_MESSAGE19 = '静态页已保存';
$PLG_staticpages_MESSAGE20 = '静态页已删除';
$PLG_staticpages_MESSAGE21 = '该页不存在。要创建页面，请填写下面的表格。如果您是误操作至此，请点击取消按钮返回。';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = '不支持插件升级。';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => '静态页',
    'title' => '静态页设定'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => '允许PHP',
    'sort_by' => '中组件排序',
    'sort_menu_by' => '菜单项排序',
    'sort_list_by' => '管理列表排序',
    'delete_pages' => '删除页面时同时删除所有者',
    'in_block' => '将页面限制于组件内',
    'show_hits' => '显示阅览数',
    'show_date' => '显示日期',
    'filter_html' => '过滤HTML',
    'censor' => '敏感词审查',
    'default_permissions' => '默认权限',
    'aftersave' => '页面保存後的重定向',
    'atom_max_items' => 'Webservices Feed中的最大页面数',
    'meta_tags' => '激活元数据标签',
    'comment_code' => '新建页面时默认',
    'draft_flag' => '新建页面时默认为草稿',
    'newstaticpagesinterval' => '静态页为“新到”的时间段',
    'hidenewstaticpages' => '是否隐藏“新到”的静态页',
    'title_trim_length' => '标题的最大长度',
    'includecenterblocks' => '包括设为中组件的静态页',
    'includephp' => '包括含PHP静态页',
    'includesearch' => '检索静态页',
    'includesearchcenterblocks' => '包括设为中组件的静态页',
    'includesearchphp' => '包括含PHP的静态页'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => '主设定'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => '静态页的主设定',
    'fs_whatsnew' => '“新到信息”组件',
    'fs_search' => '检索结果',
    'fs_permissions' => '默认权限（【0】所有者 【1】小组 【2】成员 【3】匿名）'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('是' => 1, '否' => 0),
    1 => array('是' => true, '否' => false),
    2 => array('日期' => 'date', '页ID' => 'id', '标题' => 'title'),
    3 => array('日期' => 'date', '页ID' => 'id', '标题' => 'title', '标签' => 'label'),
    4 => array('日期' => 'date', '页ID' => 'id', '标题' => 'title', '作者' => 'author'),
    5 => array('隐藏' => 'hide', '显示（以修改日期）' => 'modified', '显示（以创建日期）' => 'created'),
    9 => array('显示该页面' => 'item', '显示静态页管理页面' => 'list', '显示主页' => 'home', '显示网站管理页面' => 'admin'),
    12 => array('不可访问' => 0, '只读' => 2, '读写' => 3),
    17 => array('允许评论' => 0, '禁止评论' => -1)
);

?>
