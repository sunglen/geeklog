<?php
//
// +---------------------------------------------------------------------------+
// | Data Proxy Plugin for Geeklog - The Ultimate Weblog                       |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/dataproxy/drivers/polls.class.php                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'polls.class.php') !== false) {
    die('This file can not be used on its own.');
}

class Dataproxy_polls extends DataproxyDriver
{
	var $driver_name = 'polls';
	
	/*
	* Returns the location of index.php of each plugin
	*/
	function getEntryPoint()
	{
		global $_CONF;
		
		return $_CONF['site_url'] . '/polls/index.php';
	}
	
	/**
	* Returns array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string),
	*   'raw_data'  => raw data of the item (stripslashed)
	* )
	*/
	function getItemById($id, $all_langs = false)
	{
	    global $_CONF, $_TABLES;
		
		$retval = array();
		
		if (version_compare(VERSION, '1.5.0') >= 0) {
			$sql = "SELECT * "
				 . "FROM {$_TABLES['polltopics']} "
				 . "WHERE (pid = '" . addslashes($id) . "') ";
			if ($this->uid > 0) {
				$sql .= COM_getPermSQL('AND', $this->uid);
			}
			$result = DB_query($sql);
			if (DB_error()) {
				return $retval;
			}
			
			if (DB_numRows($result) == 1) {
				$A = DB_fetchArray($result, false);
				$A = array_map('stripslashes', $A);
				
				$retva['id']         = $id;
				$retval['title']     = $A['topic'];
				$retval['uri']       = $_CONF['site_url']
									 . '/polls/index.php?pid=' . urlencode($id);
				
				if ($this->_isGL170) {
					$retval['date'] = strtotime($A['modified']);
				} else {
					$retval['date'] = strtotime($A['date']);
				}
				
				$retval['image_uri'] = false;
				$retval['raw_data']  = $A;
			}
		} else {
			$sql = "SELECT * "
				 . "FROM {$_TABLES['pollquestions']} "
				 . "WHERE (qid = '" . addslashes($id) . "') ";
			if ($this->uid > 0) {
				$sql .= COM_getPermSQL('AND', $this->uid);
			}
			$result = DB_query($sql);
			if (DB_error()) {
				return $retval;
			}
			
			if (DB_numRows($result) == 1) {
				$A = DB_fetchArray($result, false);
				$A = array_map('stripslashes', $A);
				
				$retva['id']         = $id;
				$retval['title']     = $A['question'];
				$retval['uri']       = $_CONF['site_url']
									 . '/polls/index.php?qid=' . urlencode($id)
									 . '&amp;aid=-1';
				$retval['date']      = strtotime($A['date']);
				$retval['image_uri'] = false;
				$retval['raw_data']  = $A;
			}
		}
		
		return $retval;
	}
	
	/**
	* Returns an array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	function getItems($category, $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (version_compare(VERSION, '1.5.0') >= 0) {
			if ($this->_isGL170) {
				$sql = "SELECT pid, topic, UNIX_TIMESTAMP(modified) AS day "
					 . "FROM {$_TABLES['polltopics']} ";
			} else {
				$sql = "SELECT pid, topic, UNIX_TIMESTAMP(date) AS day "
					 . "FROM {$_TABLES['polltopics']} ";
			}
			
			if ($this->uid > 0) {
				$sql .= COM_getPermSQL('WHERE', $this->uid);
			}
			$sql .= " ORDER BY pid";
			$result = DB_query($sql);
			if (DB_error()) {
				return $entries;
			}
			
			while (($A = DB_fetchArray($result, false)) !== false) {
				$entry = array();
				$entry['id']        = $A['pid'];
				$entry['title']     = stripslashes($A['topic']);
				$entry['uri']       = $_CONF['site_url'] . '/polls/index.php?pid='
									. urlencode($entry['id']);
				$entry['date']      = $A['day'];
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		} else {
			$sql = "SELECT qid, question, UNIX_TIMESTAMP(date) AS day "
				 . "FROM {$_TABLES['pollquestions']} ";
			if ($this->uid > 0) {
				$sql .= COM_getPermSQL('WHERE', $this->uid);
			}
			$sql .= " ORDER BY qid";
			$result = DB_query($sql);
			if (DB_error()) {
				return $entries;
			}
		
			while (($A = DB_fetchArray($result, false)) !== false) {
				$entry = array();
				$entry['id']        = $A['qid'];
				$entry['title']     = stripslashes($A['question']);
				$entry['uri']       = $_CONF['site_url'] . '/polls/index.php?qid='
									. urlencode($entry['id']) . '&amp;aid=-1';
				$entry['date']      = $A['day'];
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		}
		
		return $entries;
	}
	
	/**
	* Returns an array of (
	*   'id'        => $id (string),
	*   'title'     => $title (string),
	*   'uri'       => $uri (string),
	*   'date'      => $date (int: Unix timestamp),
	*   'image_uri' => $image_uri (string)
	* )
	*/
	function getItemsByDate($category = '', $all_langs = false)
	{
		global $_CONF, $_TABLES;
		
		$entries = array();
		
		if (empty($this->startdate) OR empty($this->enddate)) {
			return $entries;
		}
		
		$sql_date = "AND (UNIX_TIMESTAMP(date) BETWEEN '$this->startdate' AND '$this->enddate') ";
		
		if (version_compare(VERSION, '1.5.0') >= 0) {
			if ($this->_isGL170) {
				$sql = "SELECT pid, topic, UNIX_TIMESTAMP(modified) AS day "
					 . "FROM {$_TABLES['polltopics']} "
					 . "WHERE (1 = 1) "
					 . "AND (UNIX_TIMESTAMP(modified) BETWEEN '$this->startdate' AND '$this->enddate') ";
			} else {
				$sql = "SELECT pid, topic, UNIX_TIMESTAMP(date) AS day "
					 . "FROM {$_TABLES['polltopics']} "
					 . "WHERE (1 = 1) " . $sql_date;
			}
			if ($this->uid > 0) {
				$sql .= COM_getPermSQL('AND', $this->uid);
			}
			$sql .= " ORDER BY pid";
			$result = DB_query($sql);
			if (DB_error()) {
				return $entries;
			}
			
			while (($A = DB_fetchArray($result, false)) !== false) {
				$entry = array();
				$entry['id']        = $A['pid'];
				$entry['title']     = stripslashes($A['topic']);
				$entry['uri']       = $_CONF['site_url'] . '/polls/index.php?pid='
									. urlencode($entry['id']);
				$entry['date']      = $A['day'];
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		} else {
			$sql = "SELECT qid, question, UNIX_TIMESTAMP(date) AS day "
				 . "FROM {$_TABLES['pollquestions']} "
				 . "WHERE (1 = 1) " . $sql_date;
			if ($this->uid > 0) {
				$sql .= COM_getPermSQL('AND', $this->uid);
			}
			$sql .= " ORDER BY qid";
			$result = DB_query($sql);
			if (DB_error()) {
				return $entries;
			}
		
			while (($A = DB_fetchArray($result, false)) !== false) {
				$entry = array();
				$entry['id']        = $A['qid'];
				$entry['title']     = stripslashes($A['question']);
				$entry['uri']       = $_CONF['site_url'] . '/polls/index.php?qid='
									. urlencode($entry['id']) . '&amp;aid=-1';
				$entry['date']      = $A['day'];
				$entry['image_uri'] = false;
				$entries[] = $entry;
			}
		}
		
		return $entries;
	}
}
