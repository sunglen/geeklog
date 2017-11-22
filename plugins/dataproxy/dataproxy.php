<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/dataproxy.php                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2010 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'dataproxy.php') !== false) {
    die('This file can not be used on its own.');
}

/**
* @class DataproxyDriver
* @description the parent class of all classes to retrieve data from plugins
*/
class DataproxyDriver
{

	/**
	* @access private
	*
	*/
	var $driver_name;
	var $uid;
	var $encoding;
	var $options;
	var $parent;
	var $startdate;
	var $enddate;
	var $_isGL170 = FALSE;
	
	/**
	* Constructor
	*
	* @param $parent    ref. to an object
	* @param $uid       int                0 (= Root), 1(= anon), user id
	* @param $encoding  string             encoding of the content
	* @param $options   array
	*/
	function DataproxyDriver(&$parent, $uid = 1, $encoding = 'utf-8',
			$options = array())
	{
		$this->parent = $parent;
		$this->_setUid($uid);
		$this->_setEncoding($encoding);
		$this->_setOptions($options);
		
		$gl_version = preg_replace("/[^0-9.]/", '', VERSION);
		
		if (version_compare($gl_version, '1.7.0') >= 0) {
			$this->_isGL170 = TRUE;
		}
	}
	
	function getDriverName()
	{
		return $this->driver_name;
	}
	
	function _setUid($uid)
	{
		$this->uid = $uid;
	}
	
	function _setEncoding($encoding)
	{
		$this->encoding = $encoding;
	}
	
	function _setOptions($options)
	{
		$this->options = $options;
	}
	
	function getAllDriverNames()
	{
		return $this->parent->getAllDriverNames();
	}
	
	function getAllSupportedDriverNames()
	{
		return $this->parent->getAllSupportedDriverNames();
	}
	
	function setDateStart($startdate)
	{
		$this->startdate = $startdate;
	}
	
	function getDateStart()
	{
		return $this->startdate;
	}
	
	function setDateEnd($enddate)
	{
		$this->enddate = $enddate;
	}
	
	function getDateEnd()
	{
		return $this->enddate;
	}
	
	/**
	* Returns the location of index.php of each plugin
	*
	* @note MUST BE OVERRIDDEN IN CHILD CLASSES WHEN THERE IS AN ENTRY POINT
	*
	* @return mixed uri(string) / false(no entrance)
	*/
	function getEntryPoint()
	{
		return false;
	}
	
	/**
	* Returns meta data of child categories
	*
	* @note MUST BE OVERRIDDEN IN CHILD CLASSES
	*
	* @param $pid       int/string/boolean: id of the parent category.  False
	*                   means the top category (with no parent)
	* @param $all_langs boolean: true = all languages, true = current language
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/	
	function getChildCategories($pid = false, $all_langs = false)
	{
		return array();
	}
	
	/**
	* @param $pid       int/string/boolean: id of the parent category.  False
	*                   means the top category (with no parent)
	* @param $all_langs boolean: true = all languages, true = current language
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	function _getChildCategoriesRecursive($pid = false, $all_langs = false)
	{
		$retval = array();
		
		$entries = $this->getChildCategories($pid, $all_langs);
		if (is_array($entries) AND count($entries) > 0) {
			foreach ($entries as $entry) {
				$retval[] = $entry;
				$retval = array_merge($retval, $this->getChildCategories($entry['id'], $all_langs));
			}
		}
		
		return $retval;
	}
	
	/**
	* @param $all_langs boolean: true = all languages, true = current language
	* @return array(
	*   'id'        => $id (string),
	*   'pid'       => $pid (string: id of its parent)
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	function getAllCategories($all_langs = false)
	{
		return $this->_getChildCategoriesRecursive(false, $all_langs);
	}
	
	/**
	* @param $all_langs boolean: true = all languages, true = current language
	*/
	function getAllCategoriesAsLinks($all_langs = false)
	{
		$retval = array();
		
		$entries = $this->getAllCategories($all_langs);
		if (is_array($entries) AND count($entries) > 0) {
			foreach ($entries as $entry) {
				$link = '';
				if ($entry['date'] !== false) {
					$link .= date($this->date_format, $entry['date']);
				}
				$link .= '<a href="' . $entry['uri'] . '">'
					  .  $this->escape($entry['title']) . '</a>' . LB;
				$retval[] = $link;
			}
		}
		
		return $retval;
	}
	
	/**
	* Returns the info of the corresponding item
	*
	* @note MUST BE OVERRIDDEN IN CHILD CLASSES
	*
	* @param $all_langs boolean: true = all languages, true = current language
	* @return array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	*   'raw_data'  => raw data of the item (stripslashed)
	*)
	*/
	function getItemById($id, $all_langs = false)
	{
		return array();
	}
	
	/**
	* Returns meta data of items under a given category
	*
	* @note MUST BE OVERRIDDEN IN CHILD CLASSES
	*
	* @param $all_langs boolean: true = all languages, true = current language
	*
	* @return array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	*)
	*/
	function getItems($category, $all_langs = false)
	{
		return array();
	}
	
	/**
	* Returns meta data of items under a given date
	*
	* @note MUST BE OVERRIDDEN IN CHILD CLASSES
	*
	* @param $all_langs boolean: true = all languages, true = current language
	*
	* @return array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	*)
	*/
	function getItemsByDate($category = '', $all_langs = false)
	{
		return array();
	}
	
	/**
	* @param $all_langs boolean: true = all languages, true = current language
	*/
	function getItemsAsLinks($category = '', $all_langs = false)
	{
		$retval  = array();
		$entries = $this->getItems($category, $all_langs);
		if (is_array($entries) AND count($entries) > 0) {
			foreach ($entries as $entry) {
				$link = '';
				if ($entry['date'] !== false) {
					$link .= date($this->options['date_format'], $entry['date']);
				}
				$link .= '<a href="' . $entry['uri'] . '">'
					  .  $this->escape($entry['title']) . '</a>' . LB;
				$retval[] = $link;
			}
		}
		
		return $retval;
	}
	
	/**
	* @param $all_langs boolean: true = all languages, true = current language
	*/
	function getAllItems($all_langs = false)
	{
		$retval = $this->getItems(false, $all_langs);
		$cats   = $this->getAllCategories($all_langs);
		if (is_array($cats) AND count($cats > 0)) {
			foreach ($cats as $cat) {
				$retval = array_merge($retval, $this->getItems($cat['id'], $all_langs));
			}
		}
		
		return $retval;
	}
	
	/**
	* Escapes a string for display
	*
	* @param  $str string: a string to escape
	* @return      string: an escaped string
	*/
	function escape($str)
	{
		$str = str_replace(
			array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
			array(   '<',    '>',     '&',      '"',      "'"),
			$str
		);
		return htmlspecialchars($str, ENT_QUOTES, $this->encoding);
	}
	
	/**
	* Converts a string into UTF-8 if necessary
	*/
	function toUtf8($str)
	{
		if (strcasecmp($this->encoding, 'utf-8') != 0) {
			if (function_exists('mb_convert_encoding')) {
				$str = mb_convert_encoding($str, 'utf-8', $this->encoding);
			} else if (function_exists('iconv')) {
				$str = iconv($this->encoding, 'utf-8', $str);
			} else if (strcasecmp($this->encoding, 'iso-8859-1') == 0
			 AND function_exists('utf8_encode')) {
				$str = utf8_encode($str);
			} else {
				COM_errorLog('Dataproxy: Error!  No way to convert data into UTF-8.');
			}
		}
		
		return $str;
	}
	
	/**
	* Cleans a URL
	*
	* @note This function removes the strings 'JavaScript:', '<script>', 
	*       '</script>', or 'document.write' in a given URL.  This might be
	*       a bit too strict.
	*/
	function cleanUrl($url)
	{
		/**
		* Decodes HTML entities
		*/
		
		// %dd --> chr(0xdd)
		$url = preg_replace('/%([\dA-F]{2})/ie', "chr(hexdec('\\1'))", $url);
		
		// \xdd --> chr(0xdd)
		$url = preg_replace('/\\\\x([\dA-F]{2})/ie', "chr(hexdec('\\1'))", $url);
		
		// \udddd --> chr(0xdddd)
		$url = preg_replace('/\\\\u([\dA-F]{4})/ie', "chr(hexdec('\\1'))", $url);
		
		// &[lL][tT](;) --> &
		$search  = array('/&lt;?/i', '/&gt;?/i', '/&quot;?/i', '/&raquo;?/i');
		$replace = array('<', '>', '"', "'");
		$url = preg_replace($search, $replace, $url);
		
		// &#\d{1,7}(;) --> d
		$url = preg_replace('/&#(\d{1,7});?/e', "chr('\\1')", $url);
		
		// &#x[0-9a-fA-F]{1,7}(;) --> d
		$url = preg_replace('/&#x([\dA-F]{1,7});?/ie', "chr(hexdec('\\1'))", $url);
		
		/**
		* Starts cleaning
		*/
		
		// Removes control codes
		$url = preg_replace('/[\x00-\x20\x7F\xAD]/', '', $url);
		
		// '+' --> ' '
		$url = str_replace('+', ' ', $url);
		
		// Removes 'JavaScript:'
		$url = preg_replace('/J\s*A\s*V\s*A\s*S\s*C\s*R\s*I\s*P\s*T\s*/i', '', $url);
		
		/**
		* Maybe, the follwoing three functions are not necessary to sanitize
		* URLs
		*/
		// Removes '<script>'
		$url = preg_replace('/<SCRIPT[^>]*>/i', '', $url);
		
		// Removes '</script>'
		$url = preg_replace('/<\/SCRIPT>/i', '', $url);
		
		// Removes 'document.write'
		$url = preg_replace('/DOCUMENT\.WRITE/i', '', $url);
		
		return $url;
	}
}

/**
* @class Dataproxy
*/
class Dataproxy
{
	var $uid;
	var $encoding;
	var $options;
	var $startdate;
	var $enddate;
	
	/**
	* Dataproxy drivers are loaded in the following order
	*
	* @caution NEW DRIVERS must be added to the following list
	*
	*/
	var $supported_drivers = array(
			'article', 'comments', 'trackback',
			'staticpages', 'calendar', 'links', 'polls',
			'dokuwiki', 'forum', 'filemgmt', 'faqman', 'mediagallery',
			'calendarjp', 'download',
		);
	
	/**
	* References to each loaded driver
	*/
	var $article;
	var $comments;
	var $trackback;
	var $staticpages;
	var $calendar;
	var $links;
	var $polls;
	var $dokuwiki;
	var $forum;
	var $filemgmt;
	var $faqman;
	var $mediagallery;
	var $calendarjp;
	var $download;
	
	/**
	* References to the loaded drivers (the same as the above, but in an array
	* e.g.  $drivers['article'] = the reference to the article object
	*/
	var $drivers = array();
	
	/**
	* Constructor
	*
	* @param $uid       int     0 (= Root), 1(= anon), user id
	* @param $encoding  string  encoding of the content
	* @param $options   array
	*/
	function Dataproxy($uid = 1, $encoding = '', $options = array())
	{
		global $_CONF, $_PLUGINS, $LANG_CHARSET, $_DPXY_CONF;
		
		if (count($options) == 0) {
			$options = $_DPXY_CONF;
		}
		if (empty($encoding)) {
			if (isset($LANG_CHARSET)) {
				$encoding = $LANG_CHARSET;
			} else if (isset($_CONF['default_charset'])) {
				$encoding = $_CONF['default_charset'];
			} else {
				$encoding = 'iso-8859-1';
			}
		}
		
		// Initializes settings
		$this->setUid($uid);
		$this->setEncoding($encoding);
		$this->setOptions($options);
		
		// Loads drivers whose driver exists and plugin is enabled
		$base_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'drivers';
		$enabled_plugins = array_merge(
			$_PLUGINS, array('article', 'comments', 'trackback')
		);
		
		foreach ($this->supported_drivers as $driver) {
			$path = $base_path . DIRECTORY_SEPARATOR . $driver . '.class.php';
			clearstatcache();
			if (is_file($path) AND in_array($driver, $enabled_plugins)) {
				require_once $path;
				$class_name = 'Dataproxy_' . $driver;
				$obj = new $class_name(
					$this, $this->uid, $this->encoding, $this->options
				);
				$this->$driver = $obj;
				$this->drivers[$driver] = $obj;
			}
		}
	}
	
	function setUid($uid)
	{
		$this->uid = $uid;
		
		if (count($this->drivers) > 0) {
			foreach ($this->drivers as $driver) {
				$driver->setUid($uid);
			}
		}
	}
	
	function getUid()
	{
		return $this->uid;
	}
	
	function setEncoding($encoding)
	{
		$this->encoding = $encoding;
		
		if (count($this->drivers) > 0) {
			foreach ($this->drivers as $driver) {
				$driver->setEncoding($encoding);
			}
		}
	}
	
	function getEncoding()
	{
		return $this->encoding;
	}
	
	function setOptions($options)
	{
		$this->options = $options;
		
		if (count($this->drivers) > 0) {
			foreach ($this->drivers as $driver) {
				$driver->setOptions($options);
			}
		}
	}
	
	function getOptions()
	{
		return $this->options;
	}
	
	function setDateStart($datestart = '')
	{
		if (!empty($datestart)) {
			$delim = substr($datestart, 4, 1);
			if (!empty($delim)) {
				$DS = explode($delim, $datestart);
				$this->startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
			}
		}
		
		if (count($this->drivers) > 0) {
			foreach ($this->drivers as $driver) {
				$driver->setDateStart($this->startdate);
			}
		}
	}
	
	function getDateStart()
	{
		return $this->startdate;
	}
	
	function setDateEnd($dateend = '')
	{
		if (!empty($dateend)) {
			$delim = substr($dateend, 4, 1);
			if (!empty($delim)) {
				$DE = explode($delim, $dateend);
				$this->enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
			}
		}
		
		if (count($this->drivers) > 0) {
			foreach ($this->drivers as $driver) {
				$driver->setDateEnd($this->enddate);
			}
		}
	}
	
	function getDateEnd()
	{
		return $this->enddate;
	}
	
# 	/**
# 	* Returns the reference to the given driver
# 	*/
# 	function &getDriver($driver_name) {
# 		if (array_key_exists($driver_name, $this->drivers)) {
# 			return $this->drivers[$driver_name];
# 		} else {
# 			trigger_error('Unknown driver: ' . $driver_name . '.', E_USER_ERROR);
# 		}
# 	}
	
	/**
	* Returns an array of all loaded driver names
	*/
	function getAllDriverNames()
	{
		return array_keys($this->drivers);
	}
	
	/**
	* Returns an array of all supported driver names
	*/
	function getAllSupportedDriverNames()
	{
		return $this->supported_drivers;
	}
	
	/**
	* Escapes a string for display
	*
	* @param  $str string: a string to escape
	* @return      string: an escaped string
	*/
	function escape($str)
	{
		$str = str_replace(
			array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
			array(   '<',    '>',     '&',      '"',      "'"),
			$str
		);
		return htmlspecialchars($str, ENT_QUOTES, $this->encoding);
	}
}
