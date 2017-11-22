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
    'newpage' => '新建頁面',
    'adminhome' => '管理主頁',
    'staticpages' => '靜態頁',
    'staticpageeditor' => '靜態頁編輯器',
    'writtenby' => '作者',
    'date' => '更新日期',
    'title' => '標題',
    'page_title' => '網頁標題',
    'content' => '內容',
    'hits' => '閱覽數',
    'staticpagelist' => '靜態頁管理',
    'url' => '網址',
    'edit' => '編輯',
    'lastupdated' => '更新日期',
    'pageformat' => '網頁格式',
    'leftrightblocks' => '頁眉、頁腳、左右組件',
    'blankpage' => '整頁顯示（無頁眉、頁腳、組件）',
    'noblocks' => '無組件（有頁眉、頁腳）',
    'leftblocks' => '頁眉、頁腳、左組件（無右組件）',
    'addtomenu' => '頁眉菜單',
    'label' => '菜單名',
    'nopages' => '此系統無靜態頁',
    'save' => '保存',
    'preview' => '預覽',
    'delete' => '刪除',
    'cancel' => '取消',
    'access_denied' => '對不起，請先登錄。',
    'access_denied_msg' => '若勾選，在無訪問權限的情況下，將自動轉向登錄頁面。若不勾選，則顯示“無此權限”的消息。',
    'all_html_allowed' => '可使用全部HTML標簽',
    'results' => '靜態頁的檢索結果',
    'author' => '作者',
    'no_title_or_content' => '請填入<b>標題</b>和<b>內容</b>。',
    'no_such_page_anon' => '請登錄。',
    'no_page_access_msg' => "發生該問題是因為您沒有登錄，或者您還不是本站（{$_CONF['site_name']}）的成員。請<a href=\"{$_CONF['site_url']}/users.php?mode=new\">注冊成為用戶</a> 來取得適當的訪問權限。",
    'php_msg' => 'PHP: ',
    'php_warn' => '<br' . XHTML .'>注意: 該選項有效後，您的頁面中所含的PHP代碼將會執行。要使用靜態頁PHP，請首先在管理頁面“小組：靜態頁管理（Static Page Admin）”中，選中權限“staticpages.PHP”。使用PHP的場合，請使用通常不返回（return）的“執行PHP”模式。在使用PHP時請注意這些細微之處。',
    'exit_msg' => '登錄要求: ',
    'exit_info' => '若勾選，則在沒有閱覽權限的情況下，轉向登錄頁面。<br' . XHTML .'>    若不勾選，則顯示“無此權限”的消息。',
    'deny_msg' => '頁面訪問被拒絕。頁面已被移動或刪除，或無訪問權限。',
    'stats_headline' => '靜態頁（頭10個）',
    'stats_page_title' => '網頁標題',
    'stats_hits' => '閱覽數',
    'stats_no_hits' => '無靜態頁或無人點擊過。',
    'id' => 'ID',
    'duplicate_id' => '指定ID已被使用，請使用別的ID。',
    'instructions' => '要編輯、刪除靜態頁，請點擊編輯圖標；要復制靜態頁，請點擊復制圖標。要創建靜態頁，請點擊“新建”。',
    'centerblock' => '中心區域: ',
    'centerblock_msg' => '若勾選，將顯示于首頁或主題首頁的中心區域。',
    'topic' => '主題: ',
    'position' => '顯示區域: ',
    'all_topics' => '所有',
    'no_topic' => '僅主頁',
    'position_top' => '頁面的最上部',
    'position_feat' => '置頂文章的下方',
    'position_bottom' => '頁面的下方',
    'position_entire' => '整頁',
    'head_centerblock' => '中組件',
    'centerblock_no' => '否',
    'centerblock_top' => '上部',
    'centerblock_feat' => '置頂文章',
    'centerblock_bottom' => '下部',
    'centerblock_entire' => '整頁',
    'inblock_msg' => '限制于組件內: ',
    'inblock_info' => '顯示標題，內容限制于組件框內。',
    'title_edit' => '編輯',
    'title_copy' => '復制此頁',
    'title_display' => '顯示此頁',
    'select_php_none' => '不執行PHP',
    'select_php_return' => '執行PHP (return)',
    'select_php_free' => '執行PHP',
    'php_not_activated' => "靜態頁中未激活PHP。詳細情況請瀏覽<a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">關聯文檔（英文）</a> 。",
    'printable_format' => '打印格式',
    'copy' => '復制',
    'limit_results' => '縮小範圍檢索',
    'search' => '檢索',
    'submit' => '提交',
    'no_new_pages' => '-',
    'pages' => '頁',
    'comments' => '評論',
    'draft' => '草稿',
    'draft_yes' => '是',
    'draft_no' => '否'
);

$PLG_staticpages_MESSAGE15 = '您的評論已經提交，請等待管理員的審核。';
$PLG_staticpages_MESSAGE19 = '靜態頁已保存';
$PLG_staticpages_MESSAGE20 = '靜態頁已刪除';
$PLG_staticpages_MESSAGE21 = '該頁不存在。要創建頁面，請填寫下面的表格。如果您是誤操作至此，請點擊取消按鈕返回。';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = '不支持插件升級。';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => '靜態頁',
    'title' => '靜態頁設定'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => '允許PHP',
    'sort_by' => '中組件排序',
    'sort_menu_by' => '菜單項排序',
    'sort_list_by' => '管理列表排序',
    'delete_pages' => '刪除頁面時同時刪除所有者',
    'in_block' => '將頁面限制于組件內',
    'show_hits' => '顯示閱覽數',
    'show_date' => '顯示日期',
    'filter_html' => '過濾HTML',
    'censor' => '敏感詞審查',
    'default_permissions' => '默認權限',
    'aftersave' => '頁面保存後的重定向',
    'atom_max_items' => 'Webservices Feed中的最大頁面數',
    'meta_tags' => '激活元數據標簽',
    'comment_code' => '新建頁面時默認',
    'draft_flag' => '新建頁面時默認為草稿',
    'newstaticpagesinterval' => '靜態頁為“新到”的時間段',
    'hidenewstaticpages' => '是否隱藏“新到”的靜態頁',
    'title_trim_length' => '標題的最大長度',
    'includecenterblocks' => '包括設為中組件的靜態頁',
    'includephp' => '包括含PHP靜態頁',
    'includesearch' => '檢索靜態頁',
    'includesearchcenterblocks' => '包括設為中組件的靜態頁',
    'includesearchphp' => '包括含PHP的靜態頁'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => '主設定'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => '靜態頁的主設定',
    'fs_whatsnew' => '“新到信息”組件',
    'fs_search' => '檢索結果',
    'fs_permissions' => '默認權限（【0】所有者 【1】小組 【2】成員 【3】匿名）'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('是' => 1, '否' => 0),
    1 => array('是' => true, '否' => false),
    2 => array('日期' => 'date', '頁ID' => 'id', '標題' => 'title'),
    3 => array('日期' => 'date', '頁ID' => 'id', '標題' => 'title', '標簽' => 'label'),
    4 => array('日期' => 'date', '頁ID' => 'id', '標題' => 'title', '作者' => 'author'),
    5 => array('隱藏' => 'hide', '顯示（以修改日期）' => 'modified', '顯示（以創建日期）' => 'created'),
    9 => array('顯示該頁面' => 'item', '顯示靜態頁管理頁面' => 'list', '顯示主頁' => 'home', '顯示網站管理頁面' => 'admin'),
    12 => array('不可訪問' => 0, '只讀' => 2, '讀寫' => 3),
    17 => array('允許評論' => 0, '禁止評論' => -1)
);

?>
