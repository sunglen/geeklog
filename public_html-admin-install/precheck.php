<?php

// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | public_html/admin/install/precheck.php                                    |
// |                                                                           |
// | Part of Geeklog pre-installation check scripts                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2009 by the following authors:                         |
// |                                                                           |
// | Authors: mystral-kk - geeklog AT mystral-kk DOT net                       |
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

/**
* This script tests the file and directory permissions, thus addressing the
* most common errors / omissions when setting up a new Geeklog site ...
*
* @author   mystral-kk <geeklog AT mystral-kk DOT net>
* @date     2009-12-13
* @version  1.3.4
* @license  GPLv2 or later
*/
error_reporting(E_ALL);

define('LB', "\n");
define('DS', DIRECTORY_SEPARATOR);
define('PRECHECK_VERSION', '1.3.4');
define('THIS_SCRIPT', 'precheck.php');
define('MIN_PHP_VERSION', '4.1.0');
define('MIN_MYSQL_VERSION', '3.23.2');
define('OS_WIN', strcasecmp(substr(PHP_OS, 0, 3), 'WIN') === 0);

$_CONF = array();

if (!is_callable('file_get_contents')) {
	function file_get_contents($path) {
		$retval = '';
		
		if (($fp = fopen($fp, 'rb')) !== FALSE) {
			while (!feof($fp)) {
				$retval .= fread($fp, 8192);
			}
			
			fclose($fp);
		} else {
			$retval = FALSE;
		}
		
		return $retval;
	}
}

if (!is_callable('file_put_contents')) {
	function file_put_contents($filename, $data) {
		$retval = FALSE;
		
		if (($fh = @fopen($filename, 'r+b')) !== FALSE) {
			if (flock($fh, LOCK_EX)) {
				if (ftruncate($fh, 0)) {
					if (rewind($fh)) {
						$retval = fwrite($fh, $data);
					}
				}
			}
			
			@fclose($fh);
		}
		
		return $retval;
	}
}

class Precheck
{
	var $path_html;
	var $path;
	var $mode;
	var $step;
	var $fatal_error;
	var $warning;
	var $error;
	
	/**
	* Constructor
	*
	* @access  public
	*/
	function Precheck()
	{
		$this->fatal_error = $this->error = $this->warning = 0;
		$this->path_html = realpath(dirname(__FILE__) . DS . '..' . DS . '..' . DS); // 結果の末尾にセパレータはつかない
	}
	
	/**
	* Return HTML header and site header
	*
	* @access  public
	*/
	function getHeader()
	{
		$retval = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . LB
				. '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">' . LB
				. '<head>' . LB
				. '  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . LB
				. '  <meta http-equiv="Content-Style-Type" content="text/css" />' . LB
				. '  <meta http-equiv="Pragma" content="no-cache" />' . LB
				. '  <link href="precheck.css" rel="stylesheet" type="text/css" />' . LB;
		
		/**
		* Let's include JavaScript
		*/
		if ($this->step == 4) {
			$retval .= '  <script type="text/javascript" src="core.js"></script>' . LB
					.  '  <script type="text/javascript" src="precheck.js"></script>' . LB;
		}
		
		$retval .= '  <title>Precheck-'
				.  PRECHECK_VERSION . ' for Geeklog</title>' . LB
				.  '</head>' . LB
				.  '<body>' . LB
				.  '<div class="header-navigation-container">' . LB
				.  '   <div class="header-navigation-line">' . LB
				.  '       <a href="http://www.geeklog.jp/forum/index.php?forum=6" class="header-navigation">インストールで困ったら、こちらのサイトへ</a>&nbsp;&nbsp;&nbsp;' . LB
				.  '   </div>' . LB
				.  '</div>' . LB
				.  '<div class="header-logobg-container-inner">' . LB
				.  '    <a class="header-logo" href="http://www.geeklog.net/">' . LB
				.  '        <img src="layout/logo.png"  width="151" height="56" alt="Geeklog" />' . LB
				.  '    </a>' . LB
				.  '    <div class="header-slogan">The Ultimate Weblog System <br /><br />' . LB
				.  '    </div>' . LB
				.  '</div>' . LB
				.  '<div class="installation-container">' . LB
				.  '<div class="installation-body-container">' . LB;
		return $retval;
	}
	
	/**
	* Return site footer and HTMl footer
	*
	* @access  public
	* @return       string
	*/
	function getFooter()
	{
		$retval = '<p class="precheck-version">Geeklogインストール前チェック&nbsp;&nbsp;Ver' . PRECHECK_VERSION . '</p>' . LB
				. '</div>' . LB . '</div>' . LB . '</body>' . LB . '</html>' . LB;
		return $retval;
	}
	
	/**
	* Return navigation bar
	*
	* @access  public
	* @return       string
	*/
	function getNav()
	{
		$class1 = ($this->step == 1) ? 'hilight' : 'normal';
		$class2 = ($this->step == 2) ? 'hilight' : 'normal';
		$class3 = ($this->step == 3) ? 'hilight' : 'normal';
		$class4 = ($this->step == 4) ? 'hilight' : 'normal';
		
		$retval = '<ul class="navi">' . LB
				. '  <li class="' . $class1 . '">Step 1. db-config.phpパス確認</li>' . LB
				. '  <li class="' . $class2 . '">Step 2. インストールタイプ選択</li>' . LB
				. '  <li class="' . $class3 . '">Step 3. 初期診断</li>' . LB
				. '  <li class="' . $class4 . '">Step 4. データベース情報入力</li>' . LB
				. '</ul><br />' . LB;

		return $retval;
	}
	
	/**
	* Escape a string so we can print it as HTML
	*
	* @access  public
	* @param   str  string
	* @return       string
	*/
	function esc($str)
	{
		return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
	}
	
	/**
	* Display error info and warning info neatly
	*
	* @access  public
	* @param   msg  string
	* @return       string
	*/
	function displayErrorAndWarning($msg)
	{
		$retval  = '<span class="';
		if (($this->error == 0) AND ($this->warning == 0)) {
			$retval .= 'good">OK</span>';
		} else {
			$retval .= ($this->error > 0) ? 'bad' : 'none';
			$retval .= '">' . $this->error . '個のエラー</span>と';
			$retval .= '<span class="';
			$retval .= ($this->warning > 0) ? 'warning' : 'none';
			$retval .= '">' . $this->warning . '個の警告</span>';
		}
		
		if ($msg != '') {
			$retval .= '<br />';
		if (($this->error == 0) AND ($this->warning == 0)) {
				$retval .= '<p class="good">' . $msg . '</p>';
			} else {
				$retval .= $msg;
			}
		}
		
		return $retval;
	}
	
	/**
	* Guess the path to db-config.php
	*
	* @access  public
	* @return          mixed - string = path, FALSE = didn't find path
	*/
	function guessDbConfigPath()
	{
		global $_CONF;
		
		// Check if siteconfig.php exists and it is valid
		clearstatcache();
		$siteconfig = realpath(dirname(__FILE__) . '/../../siteconfig.php');
		if (file_exists($siteconfig)) {
			require_once $siteconfig;
			if (isset($_CONF['path'])
			 AND ($_CONF['path'] != '/path/to/Geeklog/')
			 AND file_exists($_CONF['path'] . 'db-config.php')) {
				return $_CONF['path'];
			}
		}
		
		// Check the parent directory of path_html
		$path = realpath(dirname(__FILE__) . '/../../../');
		clearstatcache();
		return file_exists($path . 'db-config.php') ? $path : FALSE;
	}
	
	/**
	* Check the default setting of PHP
	*
	* @access  public
	* @return       string
	*/
	function menuCheckPHPSettings()
	{
		$this->error = $this->warning = 0;
		$retval = '';
		$php6   = (version_compare(PHP_VERSION, '6') >= 0);
		
		// magic_quotes_gpc
		if (!$php6 AND @get_magic_quotes_gpc()) {
			$retval .= '<li><span class="warning">警告</span>&nbsp;<strong>magic_quotes_gpc</strong>がオンになっています。文字化けの原因になるので、<strong>httpd.conf</strong>か<strong>php.ini</strong>、<strong>.htaccess</strong>でオフにすることをお勧めします。[<a href="precheck.php?mode=info&amp;item=magic_quotes_gpc">詳しくはこちら</a>]。</li>' . LB;
			$this->warning ++;
		}
		
		// magic_quotes_runtime
		if (!$php6 AND @get_magic_quotes_runtime()) {
			$retval .= '<li><span class="warning">警告</span>&nbsp;<strong>magic_quotes_runtime</strong>がオンになっています。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>でオフにすることをお勧めします。[<a href="precheck.php?mode=info&amp;item=magic_quotes_runtime">詳しくはこちら</a>]。</li>' . LB;
			$this->warning ++;
		}
		
		if (!is_callable('ini_get')) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>ini_get()関数が無効になっているので、PHPの設定をチェックできませんでした。Webサーバの管理者に依頼して、<strong>php.ini</strong>の<strong>disabled_functions</strong>の設定値から<strong>ini_get</strong>を除外するよう依頼してください。</li>' . LB;
			$this->error ++;
		} else {
			// display_errors
			if (ini_get('display_errors')) {
				$retval .= '<li><span class="warning">警告</span>&nbsp;<strong>display_errors</strong>がオンになっています。エラー発生時に重要な情報を漏洩する原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>でオフにすることをお勧めします。[<a href="precheck.php?mode=info&amp;item=display_errors">詳しくはこちら</a>]。</li>' . LB;
				$this->warning ++;
			}
			
			// magic_quotes_sybase
			if (!$php6 AND @ini_get('magic_quotes_sybase')) {
				$retval .= '<li><span class="warning">警告</span>&nbsp;<strong>magic_quotes_sybase</strong>がオンになっています。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>でオフにすることをお勧めします。[<a href="precheck.php?mode=info&amp;item=magic_quotes_sybase">詳しくはこちら</a>]。</li>' . LB;
				$this->warning ++;
			}
			
			// mbstring.language
			$mbstring_language = ini_get('mbstring.language');
			if (strcasecmp($mbstring_language, 'japanese') != 0) {
				if (strcasecmp($mbstring_language, 'neutral') == 0) {
					$retval .= '<li><span class="warning">警告</span>&nbsp;<strong>mbstring.language</strong>に<strong>neutral</strong>が設定されています。文字化けするようなら、<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>Japanese</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_language">詳しくはこちら</a>]。</li>' . LB;
					$this->warning ++;
				} else {
					$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>mbstring.language</strong>に<strong>Japanese</strong>以外の言語が設定されているようです。文字化けの原因になるので、<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>Japanese</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_language">詳しくはこちら</a>]。</li>' . LB;
					$this->error ++;
				}
			}
			
			// mbstring.http_output
			$mbstring_http_output = ini_get('mbstring.http_output');
			if ((strcasecmp($mbstring_http_output, 'pass') != 0)
			 AND (strcasecmp($mbstring_http_output, 'utf-8') != 0)) {
				$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>mbstring.http_output</strong>に特定の文字セットが設定されているようです。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>pass</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_http_output">詳しくはこちら</a>]。</li>' . LB;
				$this->error ++;
			}
			
			$mbstring_encoding_translation = @ini_get('mbstring.encoding_translation');
			if ($mbstring_encoding_translation) {
				$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>mbstring.encoding_translation</strong>が<strong>On</strong>になっています。文字化けやセキュリティ低下の原因になるので、<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>Off</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_encoding_translation">詳しくはこちら</a>]。</li>' . LB;
				$this->error ++;
			}
			
			// mbstring.internal_encoding
			$mbstring_internal_encoding = ini_get('mbstring.internal_encoding');
			if (($mbstring_internal_encoding != '')
			 AND (strcasecmp($mbstring_internal_encoding, 'utf-8') != 0)) {
				$retval .= '<li><span class="warning">警告</span>&nbsp;<strong>mbstring.internal_encoding</strong>に特定の文字セットが設定されているようです。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>utf-8</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=mbstring_internal_encoding">詳しくはこちら</a>]。</li>' . LB;
				$this->warning ++;
			}
			
			// default_charset
			$default_charset = @ini_get('default_charset');
			if (($default_charset != '')
			 AND (strcasecmp($default_charset, 'utf-8') != 0)) {
				$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>default_charset</strong>に特定の文字セットが設定されているようです。文字化けの原因になるので、<strong>siteconfig.php</strong>か<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>\'\'</strong>（空文字列）か<strong>utf-8</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=default_charset">詳しくはこちら</a>]</li>' . LB;
				$this->error ++;
			}
			
			// register_globals
			if (!$php6 AND @ini_get('register_globals')) {
				$retval .= '<li><span class="warning">警告</span>&nbsp;<strong>register_globals</strong>が<strong>On</strong>になっています。セキュリティを低下させる原因になるので、<strong>httpd.conf</strong>、<strong>php.ini</strong>、<strong>.htaccess</strong>で<strong>Off</strong>に設定することをお勧めします。[<a href="precheck.php?mode=info&amp;item=register_globals">詳しくはこちら</a>]</li>' . LB;
				$this->warning ++;
			}
		}
		
		if ($retval != '') {
			$retval = '<ul>' . LB . $retval . '</ul>' . LB;
		}
		
		return $retval;
	}
	
	/**
	* Check write permissions of paths
	*
	* @access  public
	* @return       string
	*/
	function menuCheckWritable()
	{
		$this->error = $this->warning = 0;
		$retval = '';
		$path = $this->path;
//		$path_html = realpath(dirname(__FILE__) . '/../../');
		$path_html = $this->path_html;
		
		// path_html/siteconfig.php
		clearstatcache();
		if (!is_writable($path_html . DS . 'siteconfig.php')) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>公開領域/siteconfig.php</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		// path/db-config.php
		clearstatcache();
		if (!is_writable($path . 'db-config.php')) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>非公開領域/db-config.php</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		// path/data
		clearstatcache();
		if (!is_writable($path . 'data' . DS)) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>非公開領域/data</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		// path/backups
		clearstatcache();
		if (!is_writable($path . 'backups' . DS)) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>非公開領域/backups</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		// path/logs/error.log
		clearstatcache();
		if (!is_writable($path . 'logs' . DS . 'error.log')) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>非公開領域/logs/error.log</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		// path/logs/access.log
		clearstatcache();
		if (!is_writable($path . 'logs' . DS . 'access.log')) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>非公開領域/logs/access.log</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		// path/logs/spamx.log
		clearstatcache();
		if (!is_writable($path . 'logs' . DS . 'spamx.log')) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>非公開領域/logs/spamx.log</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		// path_html/backend/geeklog.rss
		clearstatcache();
		if (!is_writable($path_html . DS . 'backend' . DS . 'geeklog.rss')) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>公開領域/backend/geeklog.rss</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		// path_html/backend
		clearstatcache();
		if (!is_writable($path_html . DS . 'backend' . DS)) {
			$retval .= '<li><span class="bad">エラー</span>&nbsp;<strong>公開領域/backend</strong>が書き込み禁止になっています。</li>' . LB;
			$this->error ++;
		}
		
		if ($retval != '') {
			$retval = '<ul>' . LB . $retval . '</ul>' . LB;
		}
		
		return $retval;
	}
	
	/**
	* Return a string of information
	*
	* @access  public
	* @param   item    string
	* @return          string
	*/
	function getInfo($item)
	{
		$retval = '<div class="infobox">' . LB;
		
		switch ($item) {
			case 'magic_quotes_gpc':	// INI_PERDIR
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>magic_quotes_gpc = Off</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_flag magic_quotes_gpc Off</code>' . LB;
				break;
				
			case 'magic_quotes_runtime':	// INI_ALL
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>magic_quotes_runtime = Off</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_flag magic_quotes_runtime Off</code>' . LB
						.  '<p>（<strong>siteconfig.php</strong>で設定する場合）</p>' . LB
						.  '<code>@set_magic_quotes_runtime(FALSE);</code>' . LB;
				break;
			
			case 'display_errors':	// INI_ALL
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>display_errors = Off</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_flag display_errors Off</code>' . LB
						.  '<p>（<strong>siteconfig.php</strong>で設定する場合）</p>' . LB
						.  '<code>@ini_set(\'display_errors\', FALSE);</code>' . LB;
				break;
			
			case 'magic_quotes_sybase':	// INI_ALL
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>magic_quotes_sybase = Off</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_flag magic_quotes_sybase Off</code>' . LB
						.  '<p>（<strong>siteconfig.php</strong>で設定する場合）</p>' . LB
						.  '<code>@ini_set(\'magic_quotes_sybase\', FALSE);</code>' . LB;
				break;
			
			case 'mbstring_language':	// INI_PERDIR
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>mbstring.language = Japanese</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_value mbstring.language Japanese</code>' . LB;
				break;
			
			case 'mbstring_http_output':	// INI_ALL
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>mbstring.http_output = pass</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_value mbstring.http_output pass</code>' . LB
						.  '<p>（<strong>siteconfig.php</strong>で設定する場合）</p>' . LB
						.  '<code>@ini_set(\'mbstring.http_output\', \'pass\');</code>' . LB;
				break;
			
			case 'mbstring_encoding_translation':	// INI_PERDIR
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>mbstring.encoding_translation = Off</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_flag mbstring.encoding_translation Off</code>' . LB;
				break;
				
			case 'mbstring_internal_encoding':	// INI_ALL
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>mbstring.internal_encoding = utf-8</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_value mbstring.internal_encoding utf-8</code>' . LB
						.  '<p>（<strong>siteconfig.php</strong>で設定する場合）</p>' . LB
						.  '<code>@ini_set(\'mbstring.internal_encoding\', \'utf-8\');</code>' . LB;
				break;
			
			case 'default_charset':	// INI_ALL
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>default_charset = utf-8</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_value default_charset utf-8</code>' . LB
						.  '<p>（<strong>siteconfig.php</strong>で設定する場合）</p>' . LB
						.  '<code>@ini_set(\'default_charset\', \'utf-8\');</code>' . LB;
				break;
			
			case 'register_globals':	// INI_PERDIR
				$retval .= '<p>（<strong>php.ini</strong>で設定する場合）</p>' . LB
						.  '<code>register_globals = Off</code>' . LB
						.  '<p>（<strong>.htaccess</strong>で設定する場合）</p>' . LB
						.  '<code>php_flag register_globals Off</code>' . LB;
				break;
				
			default:
				$retval = '?';
		}
		
		$retval .= '</div>' . LB
				.  '<p><a href="javascript:history.back()" title="JavaScriptをOffにしている場合は、ブラウザの「戻る」ボタンで戻ってください">元のページに戻る</a></p>' . LB;
		return $retval;
	}
	
	/**
	* Write the system path into "siteconfig.php"
	*
	* @access  public
	* @return  boolean  TRUE = success, FALSE = otherwise
	*/
	function writeSiteconfig()
	{
		$siteconfig = realpath(dirname(__FILE__) . '/../../siteconfig.php');
		clearstatcache();
		if (file_exists($siteconfig)) {
			$content = file_get_contents($siteconfig);
			if ($content !== FALSE) {
				if (OS_WIN) {
					$path = str_replace("//", "/", $this->path);
				    $path = str_replace("'", "\\'", $path);
				} else {
				    $path = str_replace("'", "\\'", $this->path);
				}
				$content = str_replace('/path/to/Geeklog/', $path, $content);
				if (file_put_contents($siteconfig, $content) !== FALSE) {
					return TRUE;
				}
			}
		}
		
		return FALSE;
	}
	
	/**
	* Step 0: Check PHP settings
	*
	* @access  private
	*/
	function _step0()
	{
		$retval = '';
		if (version_compare(PHP_VERSION, MIN_PHP_VERSION) < 0) {
			$retval .= '<p><span class="bad">エラー</span>&nbsp;PHPのバージョンが低すぎます。最低でも' . MIN_PHP_VERSION . 'が必要です。</p>' . LB;
			$this->fatal_error ++;
		}
		
		$extensions = get_loaded_extensions();
		$extensions = array_map('strtolower', $extensions);
		if (!in_array('mysql', $extensions) AND !in_array('mssql', $extensions)) {
			$retval .= '<p><span class="bad">エラー</span>&nbsp;PHPにデータベースを利用する機能が組み込まれていません。</p>' . LB;
			$this->fatal_error ++;
		}
		
		if (!in_array('mbstring', $extensions)) {
			$retval .= '<p><span class="bad">エラー</span>&nbsp;PHPに日本語処理関数(mbstring)が組み込まれていません。</p>' . LB;
			$this->fatal_error ++;
		}
		
		if ($retval != '') {
			$retval = '<h1 class="heading">Step 0. PHPの設定確認</h1>' . LB
					. '<p>致命的なエラーが見つかったため、インストールできません。表示されたエラーを解決してから、もう一度チェックし直してください。</p>' . LB
					. $retval;
		}
		
		return $retval;
	}
	
	/**
	* Step 1: Guess the path to "db-config.php"
	*
	* @access  private
	*/
	function _step1()
	{
		$this->path = $this->guessDbConfigPath();
		if ($this->path != '') {
			header('Location: ' . THIS_SCRIPT . '?path=' . rawurlencode($this->path));
			exit;
		} else {
			$retval = '<h1 class="heading">Step 1. db-config.phpのパス確認</h1>' . LB
					. '<p>db-config.php の場所がわかりません。</p><p style="margin:20px 0">'
					. '<a class="big-button" href="fb.php">ファイルブラウザで探す</a></p>' . LB;
		}
		
		return $retval;
	}
	
	/**
	* Step 2: Select install type
	*
	* @access  private
	*/
	function _step2()
	{
		$path = rawurlencode($this->path);

		$retval = '<h1 class="heading">Step 2. インストールタイプを選択してください：</h1>' . LB
				. '<p style="margin:20px 0">' . LB
				. '<a class="big-button" href="' . THIS_SCRIPT . '?step=3&amp;mode=install&amp;path='
				. $path . '">' . $this->esc('新規インストール') . '</a>&nbsp;'
				. '<a class="big-button" href="' . THIS_SCRIPT . '?step=3&amp;mode=upgrade&amp;path='
				. $path . '">' . $this->esc('アップグレード') . '</a>&nbsp;'
				. '<a class="big-button" href="' . THIS_SCRIPT . '?step=3&amp;mode=migrate&amp;path='
				. $path . '">' . $this->esc('移行') . '</a></p>' . LB;

		return $retval;
	}
	
	/**
	* Check PHP settings and path permissions
	*
	* @access  private
	*/
	function _step3()
	{
		$retval = '<h1 class="heading">Step 3. 初期診断：</h1>' . LB
				. '<ol>' . LB
				. '<li><strong>PHPの設定チェック</strong>：'
				. $this->displayErrorAndWarning($this->menuCheckPHPSettings())
				. '</li>' . LB;
		$this->fatal_error += $this->error;
		
		if (($this->mode == 'install') || ($this->mode == 'migrate')) {
			$retval .= '<li><strong>ディレクトリ・パスが書き込み可かどうかのチェック</strong>：'
					.  $this->displayErrorAndWarning($this->menuCheckWritable())
					.  '</li>' . LB;
			$this->fatal_error += $this->error;
		}
		
		$retval .= '</ol>' . LB
				.  '<h2 class="heading">診断結果：</h2>' . LB;
		if ($this->fatal_error > 0) {
			$retval .= '<p>致命的なエラーが見つかったため、インストールできません。表示されたエラーを解決してから、もう一度チェックし直してください。なお、警告の部分はとりあえず無視しても構いませんが、いったんインストールに成功したら、修正してください。</p><p style="margin:20px 0"><a class="big-button" href="' . THIS_SCRIPT . '">チェックし直す</a></p>' . LB;
		} else {

			if ($this->mode == 'install') {
				$target = 'precheck.php?mode=install&amp;step=4&amp;path='
						. rawurlencode($this->path);
			} else if ($this->mode == 'migrate') {
				$target = 'migrate.php?'
						. "dbconfig_path=" . rawurlencode($this->path . 'db-config.php')
						. "&amp;public_html_path=" . rawurlencode($this->path_html)
						. "&amp;language=japanese_utf-8";
			} else {
				global $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix, $_DB_dbms;
				
				require_once $this->path . 'db-config.php';
				$target = 'index.php?mode=upgrade&amp;language=japanese_utf-8'
						. '&amp;dbconfig_path='
						. rawurlencode($this->path . 'db-config.php');
			}
			
			$retval .= '<p>致命的なエラーはなさそうなので、インストールできます。続行するには、下の「続行する」をクリックしてください。</p>' . LB
					.  '<form action="' . $target. '" method="post">' . LB
					.  '<p><input class="submit button big-button" type="submit" name="submit" value="続行する" /></p>' . LB;

			if ($this->mode == 'upgrade') {
				$retval .= '<input type="hidden" name="db_host" value="'
						.  $_DB_host . '" />' . LB
						.  '<input type="hidden" name="db_name" value="'
						.  $_DB_name . '" />' . LB
						.  '<input type="hidden" name="db_user" value="'
						.  $_DB_user . '" />' . LB
						.  '<input type="hidden" name="db_pass" value="'
						.  $_DB_pass . '" />' . LB
						.  '<input type="hidden" name="db_prefix" value="'
						.  $_DB_table_prefix . '" />' . LB
						.  '<input type="hidden" name="db_type" value="'
						.  $_DB_dbms . '" />' . LB;
			}

			
			$retval .= '</form>' . LB;
		}
		
		return $retval;
	}
	
	/**
	* Step 4. Check DB settings
	*
	* @access  private
	*/
	function _step4()
	{
		$this->writeSiteconfig();
		$mode     = $this->mode;
		$language = 'japanese_utf-8';
		$path     = rawurlencode($this->path . 'db-config.php');
		$params   = "mode={$mode}&amp;language={$language}&amp;dbconfig_path={$path}&amp;display_step=2";
		$retval = <<<EOD
<div id="container">
	<h1 class="heading">Step 4. データベース情報入力</h1>
	<form action="index.php?{$params}" method="post">
	<fieldset>
	<legend>情報</legend>
	<p><label class="lbl right">データベースの種類：</label>&nbsp;
		<select id="db_type" name="db_type">
			<option value="mysql" selected="selected">MySQL</option>
			<option value="mysql-innodb">MySQL (InnoDB)</option>
			<option value="mssql">Microsoft SQL</option>
		</select>
	</p>
	<p><label class="lbl right">データベースのホスト名：</label>&nbsp;
		<input type="text" id="db_host" name="db_host" size="30" maxlength="30" value="localhost" />
	</p>
	<p><label class="lbl right">データベース名：</label>&nbsp;
		<input type="text" id="db_name" name="db_name" size="30" maxlength="30" />
	</p>
	<p><label class="lbl right">データベースのユーザ名：</label>&nbsp;
		<input type="text" id="db_user" name="db_user" size="30" maxlength="30" />
	</p>
	<p><label class="lbl right">データベースのパスワード：</label>&nbsp;
		<input type="password" id="db_pass" name="db_pass" size="30" maxlength="30" />
	</p>
	<p><label class="lbl right">データベースの接頭子：</label>&nbsp;
		<input type="text" id="db_prefix" name="db_prefix" size="30" maxlength="30" value="gl_" />
	</p>
	<p><label class="lbl right">UTF-8を使用する：</label>&nbsp;
		<input id="utf8on" type="radio" name="utf8" value="on" checked="checked" />はい
		<input id="utf8off" type="radio" name="utf8" value="off" />いいえ
	</p>
	</fieldset>
	<p>
		<input id="install_submit" class="submit button big-button" type="submit" value="インストーラへ" />
	</p>
	</form>
</div>
EOD;
		return $retval;
	}
	
	/**
	* Try to look up DB tables
	*
	* @access  public
	* @param   string  $_GET['type'], $_GET['host'], $_GET['user'],
	*                  $_GET['name'], $_GET['pass']
	* @return  string  DB names separated by a semicolon when success,
	*                  otherwise '-ERR'.
	*/
	function lookupDb()
	{
		$retval = array();
		$err    = '-ERR';
		
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$host = isset($_GET['host']) ? $_GET['host'] : '';
		$user = isset($_GET['user']) ? $_GET['user'] : '';
		$pass = isset($_GET['pass']) ? $_GET['pass'] : '';
		if ($host == 'localhost') {
			$host = '127.0.0.1';
		}
		
		if (($type == 'mysql') OR ($type == 'mysql-innodb')) {
			if (($db = @mysql_connect($host, $user, $pass)) === FALSE) {
				return $err;
			}
			
			$v = mysql_get_server_info($db);
			if (version_compare($v, MIN_MYSQL_VERSION) < 0) {
				$err .= 'MySQLのバージョン(<strong>' . $v . '</strong>)が低すぎます。最低でも<strong>' . MIN_MYSQL_VERSION . '</strong>が必要です。';
				return $err;
			}
			
			if (($result = @mysql_list_dbs($db)) === FALSE) {
				return $err;
			}
			
			while (($A = mysql_fetch_object($result)) !== FALSE) {
				$retval[] = $A->Database;
			}
			
			$retval = implode(';', $retval);
			if ($retval == '') {
				$err .= 'データベースが作成されていません。phpMyAdminなどを利用して、データベースを作成してください。';
			}
			
			return $retval;
		} else {
			if (($db = @mssql_connect($host, $user, $pass)) === FALSE) {
				return $err;
			}
			
			
			
			return '';
		}
	}
	
	/**
	* Return the number of tables in a given database
	*
	* @access  public
	* @param   string  $_GET['type'], $_GET['host'], $_GET['user'],
	*                  $_GET['name'], $_GET['pass'], $_GET['prefix']
	* @return  string  '-ERR' = DB error, otherwise a string representong the
	*                  number of tables the given DB has
	*/
	function countTable()
	{
		$err = '-ERR';
		
		$type   = isset($_GET['type']) ? $_GET['type'] : '';
		$host   = isset($_GET['host']) ? $_GET['host'] : '';
		$user   = isset($_GET['user']) ? $_GET['user'] : '';
		$pass   = isset($_GET['pass']) ? $_GET['pass'] : '';
		$name   = isset($_GET['name']) ? $_GET['name'] : '';
		$prefix = isset($_GET['prefix']) ? $_GET['prefix'] : '';
		if ($host == 'localhost') {
			$host = '127.0.0.1';
		}
		
		if (($type == 'mysql') OR ($type == 'mysql-innodb')) {
			if (($db = @mysql_connect($host, $user, $pass)) === FALSE) {
				return $err;
			}
			
			if (mysql_select_db($name, $db) === FALSE) {
				return $err;
			}
			
			// '_' is a wild character in MySQL, so we have to escape it with '\'
			$prefix = str_replace('_', '\\_', $prefix);
			if (($result = mysql_query("SHOW TABLES LIKE '{$prefix}%'", $db)) === FALSE) {
				return $err;
			} else {
				$num = mysql_num_rows($result);
			}
			
			if ($num === FALSE) {
				return $err;
			} else {
				return (string) $num;
			}
		} else {
			if (($db = @mssql_connect($host, $user, $pass)) === FALSE) {
				return $err;
			}
			
			
			
			return $err;
		}
	}
}

//=============================================================================
// MAIN
//=============================================================================

/**
* step 1. Check the path to "db-config.php"
*	v
* step 2. Select install type
*   v
* step 3. Check PHP settings and path permissions -- upgrade --+
*   v                                                          |
* step 4. Check DB settings                                    |
*   v                                                          |
* step 5. Redirect to public_html/admin/install/index.php <----+
*/

// Get the request vars
$step = 0;
if (isset($_GET['step'])) {
	$step = intval($_GET['step']);
} else if (isset($_POST['step'])) {
	$step = intval($_POST['step']);
}
if (($step < 1) OR ($step > 4)) {
	$step = 0;
}

$mode = '';
if (isset($_GET['mode'])) {
	$mode = $_GET['mode'];
} else if (isset($_POST['mode'])) {
	$mode = $_POST['mode'];
}
if (!in_array($mode, array('install', 'upgrade', 'migrate', 'info', 'lookupdb', 'counttable'))) {
	$step = 2;
}

$path = '';
if (isset($_GET['path'])) {
	$path = $_GET['path'];
} else if (isset($_POST['path'])) {
	$path = $_POST['path'];
}
if ($path == '') {
	$step = 0;
} else {
	$path = str_replace("\\", '/', $path);
	$path = rawurldecode($path);
}

$p = new Precheck;
$p->mode = $mode;
$p->step = $step;
$p->path = $path;

if ($mode == 'lookupdb') {
	$result = $p->lookupDb();
    header('Content-Type: text/html; charset=utf-8');
	echo $result;
	exit;
} else if ($mode == 'counttable') {
	$result = $p->countTable();
    header('Content-Type: text/plain; charset=utf-8');
	echo $result;
	exit;
}

header('Content-Type: text/html; charset=utf-8');

$display = $p->getHeader();
if ($mode == 'info') {
	$display .= $p->getInfo($_GET['item']);
} else {
//	$display .= $p->getNav();
	
	switch ($step) {
		case 0: // Check PHP setting
			$temp = $p->_step0();
			if ($temp != '') {
				$display .= $temp;
				break;
			}
			
			/* Fall through intentionally */
			
		case 1:	// Check the path to "db-config.php"
		    $p->step = 1;
		    $display .= $p->getNav();
			$display .= $p->_step1();
			break;
		
		case 2:	// Select install type
		    $display .= $p->getNav();
			$display .= $p->_step2();
			break;
		
		case 3:	// Check PHP settings and path permissions
		    $display .= $p->getNav();
			$display .= $p->_step3();
			break;
		
		case 4:	// Check DB settings
		    $display .= $p->getNav();
			$display .= $p->_step4();
			break;
	}
}

$display .= $p->getFooter();
echo $display;
