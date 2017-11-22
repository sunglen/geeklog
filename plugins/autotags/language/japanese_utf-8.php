<?php

###############################################################################
# japanese_utf-8.php
# This is the japanese language page for the Geeklog Autotags Plug-in!
#
# Copyright (C) 2006 Joe Mucchiello
# Tranlated by Ivy (Geeklog Japanese)
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
# Last Update 2008/01/14 by Ivy (Geeklog Japanese)

$LANG_AUTO = array(
    'newpage' => '新規ページ',
    'adminhome' => '管理者HOME',
    'tag' => 'タグ名（英数字）',
    'desc' => 'タグの説明',
    'replacement' => '置換文字列',
    'enabled' => '有効:',
    'function' => '関数で置換する:',
    'short_function' => '関数',
    'autotagseditor' => '自動タグエディタ',
    'autotagsmanager' => '自動タグマネージャ',
    'edit' => '編集',
    'save' => '保存',
    'delete' => '削除',
    'cancel' => 'キャンセル',
    
    'access_denied' => 'アクセスが拒否されました。',
    'access_denied_msg' => '静的ページの管理者用ページに不正にアクセスしています。このアクセスは記録されますのでご了承ください。',
    'deny_msg' => 'このページへのアクセスが拒否されました。ページが削除あるいはリネームされたのかも知れませんし、またはアクセス権がないのかもしれません。',

    'php_msg_enabled' => 'これをチェックすると、phpautotags_ という接頭辞付きのタグ名を名前とする関数とこのタグが出会ったとき、関数はコールされタグを置換します。次の <b>置換文字列</b> フィールド内の文字列は無視されます。',
    'php_msg_disabled' => 'タグを置換するための関数をコールする自動タグを編集するためには、config.php 中の変数 $_AUTO_CONF[\'allow_php\'] を \'1\' に設定し、さらに autotags.PHP 権限をグループに与える必要があります。',
    
    'disallowed_tag' => '選択したタグは使えません。他を選んでください。',
    'duplicate_tag' => '選択したタグはすでに選ばれています。他のタグを選ぶか、タグを編集してください。',
    'no_tag_or_replacement' => '<b>タグ</b>と<b>置換文字列</b>フィールドは必ず入力してください。',

    'instructions' => '<p>自動タグの編集・削除は、タグの編集アイコンをクリックしてください。新規作成は、上の"新規作成"をクリックしてください。編集できないか、有効にできないタグがある場合は、それらは関数ベースのタグであり、あなたに autotags.PHP 権限がないか、変数 $_AUTO_CONF により関数ベースの自動タグが無効になっています。</p>',
    'replace_explain' => '自動タグの記述形式は <b>[tag:parameter1 parameter2]</b> です。<br' . XHTML . '>置換文字列フィールドにはHTMLを記述できます。<br' . XHTML . '>置換文字列フィールドの文字列中に <b>#1</b> や <b>#2</b> を記述することにより、<b>parameter1</b> や <b>parameter2</b> を含めることができます。</p>'
                        .'<p>自動タグは、一般的にリンクを作成するために使用されます。<br' . XHTML . '>タグ <b>[tag:foo This is a link]</b> が、置換文字列フィールドの文字列<br' . XHTML . '> <b>&lt;a href="http://path.to.somewhere/#1"&gt;#2&lt;/a&gt;</b> <br' . XHTML . '>に関連付けられているとき、そのタグは文字列<br' . XHTML . '> <b>&lt;a href="http://path.to.somewhere/foo"&gt;This is a link&lt;/a&gt;</b><br' . XHTML . '>に置換されます。</p>'
                        . '<p>#1 と #2 に加えて、<b>#0</b> は最初のコロンの後の全文字列です。 <b>#U</b> はサイトのベースURLです。</p>',

    'php_not_activated' => '静的ページでPHPが有効になっていません。詳しくは<a href="' . $_CONF['site_url'] . '/docs/japanese/staticpages.html#php">ドキュメント</a>をご覧ください。',

    'edit' => '編集',

    'search' => '検索',
    'submit' => '投稿',
    
    'list_all_title' => '自動タグリスト',
    'window_close' => 'クローズ',
    'main_menulabel' => '自動タグリスト',

    'descr_story' => 'このサイトの記事の自動タグ: [story:story_id]',
    'descr_event' => 'このサイトのイベントの自動タグ: [event:event_id]',
    'descr_calendar' => 'このサイトのカレンダの自動タグ: [calendar:event_id]',
    'descr_link' => 'このサイトのリンクの自動タグ: [link:link_id]',
    'descr_staticpage' => 'このサイトの静的ページの自動タグ: [staticpage:page_id]',
// Added since 1.02jp3
	'admin_label' => '自動タグ',
);

?>