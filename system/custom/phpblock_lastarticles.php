<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'phpblock_lastarticles.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* 日付のフォーマットはPHPのdate()関数と同じ。
*/
if (!defined('LASTARTICLES_DATE_FORMAT')) {
	define('LASTARTICLES_DATE_FORMAT', '[Y-m-d]');
}

/***
*
* phpblock_lastarticles()
*
* Geeklog phpblock function to show the title and links of the latest articles
* 
* by Nakanishi
* modified by mystral-kk - geeklog AT mystral-kk DOT net
*
* 使用法：
*
* phpblock_lastarticles(行数, 先頭文字数);
*
* 次の2行を静的ページPHPで記述
*
* $exclude = array('cat1', 'cat2');  // 見せたくない記事カテゴリIDをリスト
* echo phpblock_lastarticles(10, 60, $exclude);
*
*/
function phpblock_lastarticles($numrows = 10, $length = 50, $exclude = array()) {
	$additional_sql = LASTARTICLES_createTopicSet($exclude, false);
	return phpblock_lastarticles_common($numrows, $length, $additional_sql);
}

/***
*
* phpblock_lastarticles2()
*
* Geeklog phpblock function to show the title and links of the latest articles
* 
* by T.Kinoshita
* modified by mystral-kk - geeklog AT mystral-kk DOT net
*
* phpblock_lastarticles2(行数,先頭文字数);
* 次の2行を静的ページPHPで記述
*
* $include = array('cat1', 'cat2');  // 見せたい記事カテゴリIDをリスト
* echo phpblock_lastarticles2(10, 60, $include);
*
*/
function phpblock_lastarticles2($numrows = 10, $length = 50, $include = array()) {
	$additional_sql = LASTARTICLES_createTopicSet($include, true);
	return phpblock_lastarticles_common($numrows, $length, $additional_sql);
}

/**
* Returns the currend encoding
*/
function LASTARTICLES_getEncoding() {
	global $_CONF, $LANG_CHARSET;
	
	static $encoding = null;
	
	if ($encoding === null) {
	    if (isset($LANG_CHARSET)) {
	        $encoding = $LANG_CHARSET;
	    } else if (isset($_CONF['default_charset'])) {
	        $encoding = $_CONF['default_charset'];
	    } else {
	        $encoding = 'utf-8';
	    }
	}
	
	return $encoding;
}

/**
* Escapes a string for HTML output
*/
function LASTARTICLES_esc($str) {
	$str = str_replace(
		array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
		array(   '<',    '>',     '&',      '"',      "'"),
		$str
	);
	return htmlspecialchars($str, ENT_QUOTES, LASTARTICLES_getEncoding());
}

/**
* utitility function to create a set of topic ids
*/
function LASTARTICLES_createTopicSet($topics = array(), $is_include = true) {
	if (count($topics) == 0) {
		return ' ';
	}
	
	$retval = " AND (s.tid ";
	
	if ($is_include != true) {
		$retval .= "NOT ";
	}
	$retval .= "IN (";
	$topics = array_map('addslashes', $topics);
	$topics = "'" . implode("', '", $topics) . "'";
	$retval .= $topics . ")) ";
	return $retval;
}

/**
* Common function to be called from phpblock_lastarticles() and
* phpblock_lastarticles2()
*/
function phpblock_lastarticles_common($numrows = 10, $length = 50, $additional_sql = '') {
	global $_CONF, $_TABLES;
	
	if (!defined('XHTML')) {
		define('XHTML', '');
	}
	
	$numrows = intval($numrows);
	if ($numrows < 1) {
		$numrows = 10;
	}
	$length = intval($length);
	if ($length < 1) {
		$length = 50;
	}
	
	$sql = "SELECT STRAIGHT_JOIN s.sid, s.tid, s.title, s.date, s.group_id, "
		 . "s.owner_id, s.perm_owner, s.perm_group, s.perm_members, "
		 . "s.perm_anon, t.topic "
		 . "FROM {$_TABLES['stories']} AS s, {$_TABLES['topics']} AS t "
		 . "WHERE (s.title <> '') AND (s.tid = t.tid) AND (s.draft_flag = 0) "
		 . "AND (s.date <= NOW()) " . COM_getTopicSQL('AND', 0, 't');
	if (function_exists('COM_getLangSQL')) {
		$sql .= COM_getLangSQL('sid', 'AND', 's');
	}
	$sql .= $additional_sql
		 . "ORDER BY s.date DESC "
		 . "LIMIT " . $numrows;
	$result = DB_query($sql);
	$retval = '';
	
	while (($A = DB_fetchArray($result)) !== false) {
		$retval .= date(LASTARTICLES_DATE_FORMAT, strtotime($A['date']))
				.  ' ' .  LASTARTICLES_esc($A['topic']) . '::'
				.  '<a class="new-story" href="'
				.  COM_buildUrl($_CONF['site_url'] . '/article.php?story='
				.  $A['sid']) . '">';
		$title = stripslashes($A['title']);
		$title = mb_strimwidth($title, 0, $length, '', LASTARTICLES_getEncoding());
		$retval .= LASTARTICLES_esc($title) . '</a>' . '<br' . XHTML . '>' . LB;
	}
	
	return $retval;
}
