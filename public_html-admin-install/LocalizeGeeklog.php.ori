<?php

//==============================================================================
// *** インストール後 *** にGeeklog本家配布分のDBデータを日本語に
// ローカライズする・英語に戻すクラス
//
//       対象：Geeklog-1.5.0
//       作者：mystral-kk - geeklog AT mystral-kk DOT net
// ライセンス：GPL
// バージョン：2010-05-20
//     使用法：このファイルをrequire_onceしたのち、
//               $obj = new LocalizeGeeklog;
//               // 日本語化するとき
//               $obj->execute('ja');
//               // 英語に戻すときは上記の行の代わりに次の行を使用。
//               // $obj->execute('en');
//=============================================================================

global $_CONF, $_TABLES;

/**
* Loads config, because $_CONF is not set fully at this point of installation
*/
require_once '../../siteconfig.php';
require_once $_CONF['path_system'] . 'classes/config.class.php';

$temp_config =& config::get_instance();
$temp_config->set_configfile($_CONF['path'] . 'db-config.php');
$temp_config->load_baseconfig();
$temp_config->initConfig();
$_CONF = $temp_config->get_config('Core');

class LocalizeGeeklog
{
	/**
	* ローカライズモード
	* 現在は 'en', 'ja' のみ。
	*
	* @access private
	*/
	var $_mode;
	var $_supported_modes = array(
		'ja' => '日本語',
		'en' => 'English',
	);

	function LocalizeGeeklog($mode = 'ja')
	{
		$this->setMode($mode);
	}
	
	/**
	* ローカライズモードをセット
	*
	* @access public
	*/
	function setMode($mode) {
		$mode = strtolower($mode);
		
		if (!in_array($mode, array_keys($this->_supported_modes))) {
			$mode = 'ja';
		}
		$this->_mode = $mode;
	}
	
	/**
	* ローカライズモードを返す
	*
	* @access public
	*/
	function getMode()
	{
		return $this->_mode;
	}
	
	/**
	* サポートされているモードを返す
	*
	* @access public
	*/
	function getSupportedModes()
	{
		return $this->_supported_modes;
	}
	
	/**
	* ローカライズ用のデータ配列をセット
	*
	* @access public
	*/
	function setData($data)
	{
		if (is_array($data) AND (count($data) > 0)) {
			$this->_data = $data;
		}
	}
	
	/**
	* ローカライズ用のデータ配列を取得
	*
	* @access public
	*/
	function getData()
	{
		return $this->_data;
	}
	
	/**
	* ローカライズ実行
	*
	* @access public
	*/
	function execute($mode = '')
	{
		if (!in_array($mode, array_keys($this->_supported_modes))) {
			$mode = 'ja';
		}
		$this->setMode($mode);
		
		$this->_changeMain();
		$this->_changeLinks();
		$this->_changePingServices();
		$this->_changeStories();
		$this->_changeUsers();
		$this->_changeMisc();
		$this->_changeConfig();
	}
	
	/**
	* GDライブラリがインストールされているかチェック
	*
	* @access public
	* @return boolean  true = installed, false = otherwise
	*/
	function isGDInstalled()
	{
		if (is_callable('gd_info') OR is_callable('imagegd')
		 OR is_callable('imagegd2')) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	* 更新メイン
	*
	* @access protected
	*/
	function _changeMain()
	{
		global $_TABLES;
		
		foreach ($this->_data as $table => $rows) {
			if (DB_checkTableExists($table)) {
				foreach ($rows as $R) {
					$sql = "UPDATE " . $_TABLES[$table] . " "
						 . "SET " . $R['target'] . " = '"
						 . addslashes($R[$this->_mode]) . "' "
						 . "WHERE (" . $R['field'] . " = '" . addslashes($R['value'])
						 . "')";
					if (isset($R['field2']) AND isset($R['value2'])) {
						$sql .= " AND (" . $R['field2'] . " = '"
							 .  addslashes($R['value2']) . "')";
					}
					
					DB_query($sql);
				}
			}
		}
	}
	

	/**
	* リンク
	*
	* 1. Geeklog Sitesの説明
	* 2. 日本語化するときにGeeklog.jpを追加、戻すときにGeeklog.jpを削除
	*
	* @access protected
	*/
	function _changeLinks()
	{
		global $_TABLES;
		
		if (!DB_checkTableExists('links')) {
			return;
		}
		
		$sqls = array();
		
		if ($this->_mode == 'ja') {
			$sqls[] = "UPDATE {$_TABLES['linkcategories']} "
					. "SET description = '" . addslashes('Geeklog関係のサイト') . "' "
					. "WHERE (cid = '" . addslashes('geeklog-sites') . "')";
			if (DB_count($_TABLES['links'], 'lid', 'geeklog.jp') == 0) {
				$sqls[] = "INSERT INTO {$_TABLES['links']} "
					 	. "(lid, cid, url, description, title, hits, date, "
						. "owner_id, group_id, perm_owner, perm_group, "
						. "perm_members, perm_anon) "
						. "VALUES ('geeklog.jp', 'geeklog-sites', "
						. "'http://www.geeklog.jp/', '"
						. addslashes('Geeklog 日本公式サイト') . "', '"
						. addslashes('Geeklog Japanese') . "', 0, NOW(), 1, 5, "
						. "3, 3, 2, 2);";
			}
		} else if ($this->_mode == 'en') {
			$sqls[] = "UPDATE {$_TABLES['linkcategories']} "
					. "SET description = '"
					. addslashes('Sites using or related to the Geeklog CMS') . "' "
					. "WHERE (cid = '" . addslashes('geeklog-sites') . "')";
			$sqls[] = "DELETE FROM {$_TABLES['links']} "
					. "WHERE (lid = 'geeklog.jp')";
		}
		
		if (count($sqls) > 0) {
			foreach ($sqls as $sql) {
				DB_query($sql);
			}
		}
	}

	/**
	* 更新ピング
	*
	* 日本語化するときのサイト = (BlogPeople, ping.bloggers.jp, ドリコムRSS,
								  gooブログ, Googleブログ検索, テクノラティ)
	* 英語に戻すときのサイト   = (Ping-O-Matic)
	*
	* @access protected
	*/
	function _changePingServices()
	{
		global $_TABLES;
		
		$sqls = array();
		
		if ($this->_mode == 'ja') {
			$sqls[] = "DELETE FROM {$_TABLES['pingservice']} "
					. "WHERE (name = 'Ping-O-Matic')";
			if (DB_count($_TABLES['pingservice'], 'name', 'BlogPeople') == 0) {
				$sqls[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
						. "site_url, ping_url, method, is_enabled) VALUES "
						. "(0, 'BlogPeople', 'http://www.blogpeople.net/', "
						. "'http://www.blogpeople.net/servlet/weblogUpdates', "
						. "'weblogUpdates.ping', 1)";
			}
			if (DB_count($_TABLES['pingservice'], 'name', 'ping.bloggers.jp') == 0) {
				$sqls[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
						. "site_url, ping_url, method, is_enabled) VALUES "
						. "(0, 'ping.bloggers.jp', 'http://ping.bloggers.jp/', "
						. "'http://ping.bloggers.jp/rpc/', "
						. "'weblogUpdates.ping', 1)";
			}
			if (DB_count($_TABLES['pingservice'], 'name', 'ドリコムRSS') == 0) {
				$sqls[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
						. "site_url, ping_url, method, is_enabled) VALUES "
						. "(0, 'ドリコムRSS', 'http://rss.drecom.jp/', "
						. "'http://ping.rss.drecom.jp/', "
						. "'weblogUpdates.ping', 1)";
			}
			if (DB_count($_TABLES['pingservice'], 'name', 'gooブログ') == 0) {
				$sqls[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
						. "site_url, ping_url, method, is_enabled) VALUES "
						. "(0, 'gooブログ', 'http://blog.goo.ne.jp/', "
						. "'http://blog.goo.ne.jp/XMLRPC', "
						. "'weblogUpdates.ping', 1)";
			}
			if (DB_count($_TABLES['pingservice'], 'name', 'Googleブログ検索') == 0) {
				$sqls[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
						. "site_url, ping_url, method, is_enabled) VALUES "
						. "(0, 'Googleブログ検索', 'http://blogsearch.google.co.jp/', "
						. "'http://blogsearch.google.co.jp/ping/RPC2', "
						. "'weblogUpdates.extendedPing', 1)";
			}
		} else if ($this->_mode == 'en') {
			if (DB_count($_TABLES['pingservice'], 'name', 'Ping-O-Matic') == 0) {
				$sqls[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, "
						. "site_url, ping_url, method, is_enabled) VALUES "
						. "(0, 'Ping-O-Matic', 'http://pingomatic.com/', "
						. "'http://rpc.pingomatic.com/', "
						. "'weblogUpdates.ping', 1)";
			}
			
			$sqls[] = "DELETE FROM {$_TABLES['pingservice']} "
					. "WHERE (name IN ('BlogPeople', 'ping.bloggers.jp', "
					. "'ドリコムRSS', 'gooブログ', 'Googleブログ検索'))";
		}
		
		if (count($sqls) > 0) {
			foreach ($sqls as $sql) {
				DB_query($sql);
			}
		}
	}
	
	/**
	* 記事
	*
	* @access protected
	*/
	function _changeStories()
	{
		global $_CONF, $_TABLES;
		
		$sqls = array();
		
		if ($this->_mode == 'en') {
			$sqls[] = "UPDATE {$_TABLES['stories']} "
					. "SET title = 'Welcome to Geeklog!', "
					. "introtext = '" . addslashes("<p>Welcome and let me be the first to congratulate you on installing Geeklog. Please take the time to read everything in the <a href=\"docs/english/index.html\">docs directory</a>. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.</p>\n<p>To log into your new Geeklog site, please use this account:</p>\n<p>Username: <b>Admin</b><br />\nPassword: <b>password</b></p><p><b>And don't forget to <a href=\"{$_CONF['site_url']}/usersettings.php?mode=edit\">change your password</a> after logging in!</b></p>")
					. "' "
					. "WHERE (sid = 'welcome')";
			$sqls[] = "UPDATE {$_TABLES['storysubmission']} "
					. "SET title = 'Are you secure?', "
					. "introtext = '" . addslashes("<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\n\n<ol>\n<li>Change the default password for the Admin account.</li>\n<li>Remove the install directory (you won\'t need it any more).</li>\n</ol>") . "' "
					. "WHERE (sid = 'security-reminder')";
		} else if ($this->_mode == 'ja') {
			$sqls[] = "UPDATE {$_TABLES['stories']} "
					. "SET title = '" . addslashes('Geeklogへようこそ!') . "', "
					. "introtext = '" . addslashes("<p>無事インストールが完了したようですね。おめでとうございます。できれば、<a href=\"docs/japanese/index.html\">docs ディレクトリ</a>のすべての文書に一通り目を通しておいてください。Geeklogはユーザを中心としたセキュリティモデルを実装しています。Geeklogを管理・運用するにはこの仕組みを理解する必要があります。</p>\n<p>サイトにログインするには、次のアカウントを使用してください:</p>\n<p>ユーザ名: <strong>Admin</strong><br />\nパスワード: <strong>password</strong></p><p><strong>ログインしたら、忘れずに<a href=\"{$_CONF['site_url']}/usersettings.php?mode=edit\">パスワードを変更</a>してください。</strong></p><p>Geeklogのサポートは、<a href=\"http://www.geeklog.jp\">Geeklog Japanese</a>へ。追加ドキュメントは <a href=\"http://wiki.geeklog.jp\">Geeklog Wiki ドキュメント</a>をどうぞ。</p>")
					. "' "
					. "WHERE (sid = 'welcome')";
			$sqls[] = "UPDATE {$_TABLES['storysubmission']} "
					. "SET title = '" . addslashes('セキュリティを確認してください。')
					. "', "
					. "introtext = '" . addslashes("<p>インストールが終了したら、次のことを実行してセキュリティを高めてください。</p><ol>\n<li>Adminアカウントのパスワードを変更する。</li>\n<li>installディレクトリを削除する（もう必要ありません）。</li>\n</ol>") . "' "
					. "WHERE (sid = 'security-reminder')";
		}
		
		foreach ($sqls as $sql) {
			DB_query($sql);
		}
	}
	
	/**
	* ユーザ定義＆データ
	*
	* @access protected
	*/
	function _changeUsers()
	{
		global $_TABLES;
		
		$sqls = array();
		
		if ($this->_mode == 'en') {
			$sqls[] = "ALTER TABLE {$_TABLES['users']} "
					. "MODIFY username VARCHAR(16) ";
			$sqls[] = "UPDATE {$_TABLES['users']} "
					. "SET username = 'Anonymous', fullname= 'Anonymous' "
					. "WHERE (uid = 1)";
			$sqls[] = "UPDATE {$_TABLES['users']} "
					. "SET fullname= 'Geeklog SuperUser', homepage='http://www.geeklog.net/' "
					. "WHERE (uid = 2)";
		} else if ($this->_mode == 'ja'){
			$sqls[] = "ALTER TABLE {$_TABLES['users']} "
					. "MODIFY username VARCHAR(108) ";
			$sqls[] = "UPDATE {$_TABLES['users']} "
					. "SET username = 'ゲストユーザ', fullname= 'ゲストユーザ' "
					. "WHERE (uid = 1)";
			$sqls[] = "UPDATE {$_TABLES['users']} "
					. "SET fullname= 'サイト管理者', homepage='' "
					. "WHERE (uid = 2)";
		}
		
		foreach ($sqls as $sql) {
			DB_query($sql);
		}
	}
	
	/**
	* その他
	*
	* @access protected
	*/
	function _changeMisc()
	{
		global $_TABLES;
		
		$sqls = array();
		
		if ($this->_mode == 'en') {
			$sqls[] = "ALTER TABLE {$_TABLES['syndication']} "
					. "ALTER language SET DEFAULT 'en-gb'";
			$sqls[] = "ALTER TABLE {$_TABLES['users']} "
					. "MODIFY username VARCHAR(16)";
			if (DB_checkTableExists('events')) {
				$sqls[] = "ALTER TABLE {$_TABLES['events']} "
						. "MODIFY zipcode VARCHAR(5)";
				$sqls[] = "ALTER TABLE {$_TABLES['eventsubmission']} "
						. "MODIFY zipcode VARCHAR(5)";
				$sqls[] = "ALTER TABLE {$_TABLES['personal_events']} "
						. "MODIFY zipcode VARCHAR(5)";
			}
		} else if ($this->_mode == 'ja') {
			// シンジケーションの言語の初期値
			$sqls[] = "ALTER TABLE {$_TABLES['syndication']} "
					. "ALTER language SET DEFAULT 'ja'";
			// ユーザ名を108バイト（全角36文字くらい）に
			$sqls[] = "ALTER TABLE {$_TABLES['users']} "
					. "MODIFY username VARCHAR(108)";
			if (DB_checkTableExists('events')) {
				// イベントの郵便番号を8桁に
				$sqls[] = "ALTER TABLE {$_TABLES['events']} "
						. "MODIFY zipcode VARCHAR(8)";
				$sqls[] = "ALTER TABLE {$_TABLES['eventsubmission']} "
						. "MODIFY zipcode VARCHAR(8)";
				$sqls[] = "ALTER TABLE {$_TABLES['personal_events']} "
						. "MODIFY zipcode VARCHAR(8)";
			}
		}
		
		foreach ($sqls as $sql) {
			DB_query($sql);
		}
	}
	
	/**
	* コンフィギュレーション
	*
	* @access protected
	*/
	function _changeConfig()
	{
		global $_CONF, $_TABLES;
		
		require_once $_CONF['path_system'] . 'classes/config.class.php';
		$c = config::get_instance();
		
		if ($this->_mode == 'en') {
			// サイト一時閉鎖メッセージ
			$c->set('site_disabled_msg', 'Geeklog Site is down. Please come back soon.');
			
			// 言語＆多言語
			$c->set_default('rdf_language','en-gb');
			$c->set('language','english');
# 			$c->set(
# 				'language_files',
# 				array(
# 					'en' => 'english_utf-8',
# 					'de' => 'german_formal_utf-8'
# 				)
# 			);
# 			$c->set(
# 				'languages',
# 				array(
# 					'en' => 'English',
# 					'de' => 'Deutsch'
# 				)
# 			);
			
			// ロケール
			$c->set('locale', 'en_GB');
			$c->set('rdf_language', 'en-gb');
			$c->set('date', '%A, %B %d %Y @ %I:%M %p %Z');
			$c->set('daytime', '%m/%d %I:%M%p');
			$c->set('shortdate', '%x');
			$c->set('dateonly', '%d-%b');
			$c->set('timeonly', '%I:%M%p');
			$c->set('hour_mode', 12);
			$c->set('timezone', 'Etc/GMT-6');
			
			// HTMLフィルタ
			$c->set(
				'user_html',
				array(
					'a'      => array('href' => 1, 'title' => 1, 'rel' => 1),
					'b'      => array(),
					'br'     => array(),
					'code'   => array(),
					'em'     => array(),
					'hr'     => array(),
					'i'      => array(),
					'li'     => array(),
					'ol'     => array(),
					'p'      => array(),
					'pre'    => array(),
					'strong' => array(),
					'tt'     => array(),
					'ul'     => array(),
				)
			);
			$c->set(
				'admin_html',
				array (
					'p'      => array('class' => 1, 'id' => 1, 'align' => 1),
					'div'    => array('class' => 1, 'id' => 1),
					'span'   => array('class' => 1, 'id' => 1),
					'table'  => array(
									'class' => 1, 'id' => 1, 'width' => 1,
									'border' => 1, 'cellspacing' => 1,
									'cellpadding' => 1
								),
					'tr'     => array(
									'class' => 1, 'id' => 1, 'align' => 1,
									'valign' => 1
								),
					'th'     => array(
									'class' => 1, 'id' => 1, 'align' => 1,
									'valign' => 1, 'colspan' => 1, 'rowspan' => 1
								),
					'td'     => array(
									'class' => 1, 'id' => 1, 'align' => 1,
									'valign' => 1, 'colspan' => 1, 'rowspan' => 1
								),
				)
			);
			
			// 検閲モード
			$c->set('censormode', 1);
			
			// カレンダプラグイン
			$c->set(
				'event_types',
				array(
					'Anniversary', 'Appointment', 'Birthday', 'Business',
					'Education', 'Holiday', 'Meeting', 'Miscellaneous',
					'Personal', 'Phone Call', 'Special Occasion', 'Travel',
					'Vacation'
				),
				'calendar'
			);
			$c->set('hour_mode', 12, 'calendar');
			
			// 画像関係
			$c->set('keep_unscaled_image', 0);	// 元画像を残す = false
			$c->set('image_lib', '', 'Core');
			
			// 記事関係
			$c->set('advanced_editor', false);
			
			// 管理者関係
			$c->set('sort_admin', true);
			
		} else if ($this->_mode == 'ja') {
			// サイト一時閉鎖メッセージ
			$c->set('site_disabled_msg', $_CONF['site_url'] . '/disabledmsg.html');
			
			// 言語＆多言語
			$c->set_default('rdf_language','ja');	// 'ja-JP'の方がよいかも
			$c->set('language','japanese_utf-8');
# 			$c->set(
# 				'language_files',
# 				array(
# 					'ja' => 'japanese_utf-8',
# 					'en' => 'english_utf-8',
# 					'de' => 'german_formal_utf-8'
# 				)
# 			);
# 			$c->set(
# 				'languages',
# 				array(
# 					'ja' => '日本語',
# 					'en' => 'English',
# 					'de' => 'Deutsch'
# 				)
# 			);
			
			// ロケール
			if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
				$c->set('locale', 'C');
				$c->set('date', '%Y年%b月%d日(%a) %H:%M');
				$c->set('daytime', '%b %d %H:%M');
				$c->set('shortdate', '%x');
				$c->set('dateonly', '%b %d');
			} else {
				if (strtoupper(substr(PHP_OS, 0, 7)) == 'FREEBSD') {
					$c->set('locale', 'ja_JP');
				} else {
					$c->set('locale', 'ja_JP.UTF-8');
				}
				$c->set('date', '%Y年%B%e日(%a) %H:%M %Z');
				$c->set('daytime', '%m/%d %H:%M %Z');
				$c->set('shortdate', '%Y年%B%e日');
				$c->set('dateonly', '%B%e日');
			}
			
			$c->set('rdf_language', 'ja');
			$c->set('timeonly', '%H:%M %Z');
			$c->set('hour_mode', 24);
			$c->set('timezone', 'Asia/Tokyo');
			
			// HTMLフィルタ
			$c->set(
				'user_html',
				array(
					'a'          => array('href' => 1, 'title' => 1, 'rel' => 1),
					'b'          => array(),
					'blockquote' => array(),
					'br'         => array('clear' => 1),
					'code'       => array(),
					'div'        => array('class' => 1, 'id' => 1),
					'em'         => array(),
					'font'       => array('color' => 1),
					'h'          => array(),
					'hr'         => array(),
					'i'          => array(),
					'li'         => array(),
					'ol'         => array(),
					'p'          => array('lang' => 1),
					'pre'        => array(),
					'strong'     => array(),
					'tt'         => array(),
					'ul'         => array(),
				)
			);
			$c->set(
				'admin_html',
				array (
					'a'        => array(
									'href' => 1, 'title' => 1, 'id'   => 1,
									'lang' => 1, 'name'  => 1, 'type' => 1,
									'rel'  => 1
								),
					'br'       => array('style' => 1),
					'caption'  => array('style' => 1),
					'div'      => array('style' => 1),
					'embed'    => array(
									'align'       => 1, 'height'  => 1, 'loop' => 1,
									'pluginspage' => 1, 'quality' => 1, 'src'  => 1,
									'type'        => 1, 'width'   => 1
								),
					'h1'       => array('class' => 1, 'id' => 1, 'style' => 1),
					'h2'       => array('class' => 1, 'id' => 1, 'style' => 1),
					'h3'       => array('class' => 1, 'id' => 1, 'style' => 1),
					'h4'       => array('class' => 1, 'id' => 1, 'style' => 1),
					'h5'       => array('class' => 1, 'id' => 1, 'style' => 1),
					'h6'       => array('class' => 1, 'id' => 1, 'style' => 1),
					'hr'       => array('align' => 1, 'class' => 1, 'id' => 1),
					'img'      => array(
									'align'  => 1, 'alt'    => 1, 'border'   => 1,
									'dir'    => 1, 'height' => 1, 'hspace'   => 1,
									'id'     => 1, 'lang'   => 1, 'longdesc' => 1,
									'src'    => 1, 'style'  => 1, 'title'    => 1,
									'valign' => 1, 'vspace' => 1, 'width'    => 1
								),
					'noscript' => array(),
					'object'   => array(
									'align' => 1, 'classid' => 1, 'codebase' => 1,
									'data'  => 1, 'height'  => 1, 'type'     => 1,
									'width' => 1
								),
					'ol'       => array('class' => 1, 'style' => 1),
					'p'        => array(
									'align' => 1, 'class' => 1, 'id' => 1
								),
					'param'    => array('name' => 1, 'value' => 1),
					'script'   => array(
									'language' => 1, 'src' => 1, 'type' => 1
								),
					'span'     => array('class' => 1, 'id' => 1, 'lang' => 1),
					'table'    => array(
									'border'      => 1, 'cellpadding' => 1,
									'cellspacing' => 1, 'class'       => 1,
									'id'          => 1, 'width'       => 1
								),
					'tbody'    => array(),
					'td'       => array(
									'align'  => 1, 'class'   => 1, 'colspan' => 1,
									'id'     => 1, 'rowspan' => 1, 'valign'  => 1
								),
					'th'       => array(
									'align'  => 1, 'class'   => 1, 'colspan' => 1,
									'id'     => 1, 'rowspan' => 1, 'valign'  => 1
								),
					'tr'       => array(
									'align'  => 1, 'class'   => 1, 'id'      => 1, 
									'valign' => 1
								),
					'ul'       => array('class' => 1, 'style' => 1),
				)
			);
			
			// 検閲モード
			$c->set('censormode', 0);
			
			// カレンダプラグイン
			$c->set(
				'event_types',
				array(
					'記念日', '約束', '誕生日', '打ち合わせ', 'セミナー',
					'休日', '会議', '用事', '個人の用事', '電話', '特別な行事',
					'旅行', '休暇'
				),
				'calendar'
			);
			$c->set('hour_mode', 24, 'calendar');
			
			// 画像関係
			$c->set('keep_unscaled_image', 1);	// 元画像を残す = true
			if ($this->isGDInstalled()) {
				$c->set('image_lib', 'gdlib', 'Core');
			}
			
			// 記事関係
			$c->set('advanced_editor', true);
			
			// 管理者関係
			$c->set('sort_admin', false);
		}
	}
	
	//=====================================================
	// ローカライズ用データ
	//
	// @access private
	//=====================================================
	
	var $_data = array(
		/**
		* ブロックタイトル・内容
		*/
		'blocks' => array(
			array(
				'field'  => 'name',
				'value'  => 'user_block',
				'target' => 'title',
				'en'     => 'User Functions',
				'ja'     => 'ユーザ情報',
			),
			array(
				'field'  => 'name',
				'value'  => 'admin_block',
				'target' => 'title',
				'en'     => 'Admins Only',
				'ja'     => '管理者専用メニュー',
			),
			array(
				'field'  => 'name',
				'value'  => 'section_block',
				'target' => 'title',
				'en'     => 'Topics',
				'ja'     => '記事カテゴリ',
			),
# 			array(
# 				'field'  => 'name',
# 				'value'  => 'polls_block',
# 				'target' => 'title',
# 				'en'     => 'Poll',
# 				'ja'     => 'アンケート',
# 			),
			array(
				'field'  => 'name',
				'value'  => 'events_block',
				'target' => 'title',
				'en'     => 'Events',
				'ja'     => 'イベント',
			),
			array(
				'field'  => 'name',
				'value'  => 'whats_new_block',
				'target' => 'title',
				'en'     => 'What\'s New',
				'ja'     => '新着情報',
			),
			array(
				'field'  => 'name',
				'value'  => 'first_block',
				'target' => 'title',
				'en'     => 'About Geeklog',
				'ja'     => 'Geeklogについて',
			),
			array(
				'field'  => 'name',
				'value'  => 'whosonline_block',
				'target' => 'title',
				'en'     => 'Who\'s Online',
				'ja'     => 'オンラインユーザ',
			),
			array(
				'field'  => 'name',
				'value'  => 'older_stories',
				'target' => 'title',
				'en'     => 'Older Stories',
				'ja'     => '過去記事',
			),
			array(
				'field'  => 'name',
				'value'  => 'first_block',
				'target' => 'content',
				'en'     => '<p><b>Welcome to Geeklog!</b></p><p>If you\'re already familiar with Geeklog - and especially if you\'re not: There have been many improvements to Geeklog since earlier versions that you might want to read up on. Please read the <a href=\"docs/changes.html\">release notes</a>. If you need help, please see the <a href=\"docs/support.html\">support options</a>.</p>',
				'ja'     => '<p><strong>Geeklogへようこそ!</strong></p><p>Geeklogのサポートは、<a href="http://www.geeklog.jp">Geeklog Japanese</a>へ。ドキュメントは <a href="http://wiki.geeklog.jp">Geeklog Wikiドキュメント</a>をどうぞ。</p>',
			),
		),
		
		/**
		* コメントコード
		*/
		'commentcodes' => array(
			array(
				'field'  => 'code',
				'value'  => 0,
				'target' => 'name',
				'en'     => 'Comments Enabled',
				'ja'     => 'コメントを許可する',
			),
			array(
				'field'  => 'code',
				'value'  => -1,
				'target' => 'name',
				'en'     => 'Comments Disabled',
				'ja'     => 'コメントを許可しない',
			),
			array(
				'field'  => 'code',
				'value'  => 1,
				'target' => 'name',
				'en'     => 'Comments Closed',
				'ja'     => 'コメント受付終了',
			),
		),
		
		/**
		* コメント表示モード
		*/
		'commentmodes' => array(
			array(
				'field'  => 'mode',
				'value'  => 'flat',
				'target' => 'name',
				'en'     => 'Flat',
				'ja'     => '一覧表示',
			),
			array(
				'field'  => 'mode',
				'value'  => 'nested',
				'target' => 'name',
				'en'     => 'Nested',
				'ja'     => '入れ子表示',
			),
			array(
				'field'  => 'mode',
				'value'  => 'threaded',
				'target' => 'name',
				'en'     => 'Threaded',
				'ja'     => 'スレッド表示',
			),
			array(
				'field'  => 'mode',
				'value'  => 'nocomment',
				'target' => 'name',
				'en'     => 'No Comments',
				'ja'     => '表示しない',
			),
		),
		
		/**
		* クッキー保存期間
		*/
		'cookiecodes' => array(
			array(
				'field'  => 'cc_value',
				'value'  => 0,
				'target' => 'cc_descr',
				'en'     => '(don\'t)',
				'ja'     => '保存しない',
			),
			array(
				'field'  => 'cc_value',
				'value'  => 3600,
				'target' => 'cc_descr',
				'en'     => '1 Hour',
				'ja'     => '1時間',
			),
			array(
				'field'  => 'cc_value',
				'value'  => 7200,
				'target' => 'cc_descr',
				'en'     => '2 Hours',
				'ja'     => '2時間',
			),
			array(
				'field'  => 'cc_value',
				'value'  => 10800,
				'target' => 'cc_descr',
				'en'     => '3 Hours',
				'ja'     => '3時間',
			),
			array(
				'field'  => 'cc_value',
				'value'  => 28800,
				'target' => 'cc_descr',
				'en'     => '8 Hours',
				'ja'     => '8時間',
			),
			array(
				'field'  => 'cc_value',
				'value'  => 86400,
				'target' => 'cc_descr',
				'en'     => '1 Day',
				'ja'     => '1日',
			),
			array(
				'field'  => 'cc_value',
				'value'  => 604800,
				'target' => 'cc_descr',
				'en'     => '1 Week',
				'ja'     => '1週間',
			),
			array(
				'field'  => 'cc_value',
				'value'  => 2678400,
				'target' => 'cc_descr',
				'en'     => '1 Month',
				'ja'     => '1ヶ月',
			),
		),
		
		/**
		* イベント投稿
		*/
		'eventsubmission' => array(
			array(
				'field'  => 'eid',
				'value'  => '2006051410130162',
				'target' => 'title',
				'en'     => 'Geeklog installed',
				'ja'     => 'Geeklogインストール完了!',
			),
			array(
				'field'  => 'eid',
				'value'  => '2006051410130162',
				'target' => 'description',
				'en'     => 'Today, you successfully installed this Geeklog site.',
				'ja'     => 'Geeklogのインストールが完了しました。',
			),
			array(
				'field'  => 'eid',
				'value'  => '2006051410130162',
				'target' => 'location',
				'en'     => 'Your webserver',
				'ja'     => 'Webサーバ',
			),
		),
		
		/**
		* 注目記事コード
		*/
		'featurecodes' => array(
			array(
				'field'  => 'code',
				'value'  => 0,
				'target' => 'name',
				'en'     => 'Not Featured',
				'ja'     => '通常記事',
			),
			array(
				'field'  => 'code',
				'value'  => 1,
				'target' => 'name',
				'en'     => 'Featured',
				'ja'     => '注目記事',
			),
		),
		
		/**
		* 権限コード
		*/
		'features' => array(
			array(
				'field'  => 'ft_name',
				'value'  => 'story.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to story editor',
				'ja'     => '記事を編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'story.moderate',
				'target' => 'ft_descr',
				'en'     => 'Ability to moderate pending stories',
				'ja'     => '承認待ちの記事を承認・却下する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'links.moderate',
				'target' => 'ft_descr',
				'en'     => 'Ability to moderate pending links',
				'ja'     => '承認待ちのリンクを承認・却下する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'links.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to links editor',
				'ja'     => 'リンクを編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'user.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to user editor',
				'ja'     => 'ユーザを編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'user.delete',
				'target' => 'ft_descr',
				'en'     => 'Ability to delete a user',
				'ja'     => 'ユーザを削除する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'user.mail',
				'target' => 'ft_descr',
				'en'     => 'Ability to send email to members',
				'ja'     => 'メンバーにEメールを送信する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'calendar.moderate',
				'target' => 'ft_descr',
				'en'     => 'Ability to moderate pending events',
				'ja'     => '承認待ちのイベントを承認・却下する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'calendar.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to event editor',
				'ja'     => 'イベントを編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'block.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to block editor',
				'ja'     => 'ブロックを編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'topic.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to topic editor',
				'ja'     => '話題を編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'polls.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to polls editor',
				'ja'     => 'アンケートを編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'plugin.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to plugin editor',
				'ja'     => 'プラグインを編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'group.edit',
				'target' => 'ft_descr',
				'en'     => 'Ability to edit groups',
				'ja'     => 'グループを編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'group.delete',
				'target' => 'ft_descr',
				'en'     => 'Ability to delete groups',
				'ja'     => 'グループを削除する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'block.delete',
				'target' => 'ft_descr',
				'en'     => 'Ability to delete a block',
				'ja'     => 'ブロックを削除する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'staticpages.edit',
				'target' => 'ft_descr',
				'en'     => 'Ability to edit a static page',
				'ja'     => '静的ページを編集する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'staticpages.delete',
				'target' => 'ft_descr',
				'en'     => 'Ability to delete a static page',
				'ja'     => '静的ページを削除する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'story.submit',
				'target' => 'ft_descr',
				'en'     => 'May skip the story submission queue',
				'ja'     => '承認待ちなしで記事を掲載する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'links.submit',
				'target' => 'ft_descr',
				'en'     => 'May skip the links submission queue',
				'ja'     => '承認待ちなしでリンクを掲載する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'calendar.submit',
				'target' => 'ft_descr',
				'en'     => 'May skip the event submission queue',
				'ja'     => '承認待ちなしでイベントを掲載する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'staticpages.PHP',
				'target' => 'ft_descr',
				'en'     => 'Ability use PHP in static pages',
				'ja'     => '静的ページでPHPを使用する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'spamx.admin',
				'target' => 'ft_descr',
				'en'     => 'Full access to Spam-X plugin',
				'ja'     => 'Spam-Xプラグインを管理する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'story.ping',
				'target' => 'ft_descr',
				'en'     => 'Ability to send pings, pingbacks, or trackbacks for stories',
				'ja'     => '記事の更新ピング、ピングバック、トラックバックを送信する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'syndication.edit',
				'target' => 'ft_descr',
				'en'     => 'Access to Content Syndication',
				'ja'     => 'フィードを管理する権限',
			),
			array(
				'field'  => 'ft_name',
				'value'  => 'webservices.atompub',
				'target' => 'ft_descr',
				'en'     => 'May use Atompub Webservices (if restricted)',
				'ja'     => 'Atompubウェブサービスル使用する権限',
			),
		),
		
		/**
		* フロントページコード
		*/
		'frontpagecodes' => array(
			array(
				'field'  => 'code',
				'value'  => 0,
				'target' => 'name',
				'en'     => 'Show Only in Topic',
				'ja'     => '各話題にのみ表示する',
			),
			array(
				'field'  => 'code',
				'value'  => 1,
				'target' => 'name',
				'en'     => 'Show on Front Page',
				'ja'     => 'ホームにも表示する',
			),
		),
		
		/**
		* グループ
		*/
		'groups' => array(
			array(
				'field'  => 'grp_name',
				'value'  => 'Root',
				'target' => 'grp_descr',
				'en'     => 'Has full access to the site',
				'ja'     => 'サイト管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'All Users',
				'target' => 'grp_descr',
				'en'     => 'Group that a typical user is added to',
				'ja'     => 'すべてのユーザ',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Story Admin',
				'target' => 'grp_descr',
				'en'     => 'Has full access to story features',
				'ja'     => '記事管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Block Admin',
				'target' => 'grp_descr',
				'en'     => 'Has full access to block features',
				'ja'     => 'ブロック管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Links Admin',
				'target' => 'grp_descr',
				'en'     => 'Has full access to links features',
				'ja'     => 'リンクプラグイン管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Topic Admin',
				'target' => 'grp_descr',
				'en'     => 'Has full access to topic features',
				'ja'     => '話題管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Calendar Admin',
				'target' => 'grp_descr',
				'en'     => 'Has full access to calendar features',
				'ja'     => 'カレンダ管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Polls Admin',
				'target' => 'grp_descr',
				'en'     => 'Has full access to polls features',
				'ja'     => 'アンケート管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'User Admin',
				'target' => 'grp_descr',
				'en'     => 'Has full access to user features',
				'ja'     => 'ユーザ管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Plugin Admin',
				'target' => 'grp_descr',
				'en'     => 'Has full access to plugin features',
				'ja'     => 'プラグイン管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Group Admin',
				'target' => 'grp_descr',
				'en'     => 'Is a User Admin with access to groups, too',
				'ja'     => 'グループ管理者兼ユーザ管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Mail Admin',
				'target' => 'grp_descr',
				'en'     => 'Can use Mail Utility',
				'ja'     => 'メール管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Logged-in Users',
				'target' => 'grp_descr',
				'en'     => 'All registered members',
				'ja'     => 'すべての登録ユーザ',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Static Page Admin',
				'target' => 'grp_descr',
				'en'     => 'Can administer static pages',
				'ja'     => '静的ページプラグイン管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'spamx Admin',
				'target' => 'grp_descr',
				'en'     => 'Users in this group can administer the Spam-X plugin',
				'ja'     => 'Spam-Xプラグイン管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Remote Users',
				'target' => 'grp_descr',
				'en'     => 'Users in this group can have authenticated against a remote server.',
				'ja'     => 'リモート認証ユーザ',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Syndication Admin',
				'target' => 'grp_descr',
				'en'     => 'Can create and modify web feeds for the site',
				'ja'     => 'フィード管理者',
			),
			array(
				'field'  => 'grp_name',
				'value'  => 'Webservices Users',
				'target' => 'grp_descr',
				'en'     => 'Can use the Webservices API (if restricted)',
				'ja'     => 'WebサービスAPIユーザ',
			),
		),
		
		/**
		* リンクカテゴリ
		*/
		'linkcategories' => array(
			array(
				'field'  => 'cid',
				'value'  => 'geeklog-sites',
				'target' => 'category',
				'en'     => 'Geeklog Sites',
				'ja'     => 'Geeklogサイト',
			),
		),
		
		/**
		* メールダイジェスト
		*/
		'maillist' => array(
			array(
				'field'  => 'code',
				'value'  => 0,
				'target' => 'name',
				'en'     => 'Don\'t Email',
				'ja'     => 'メールダイジェストを送信しない',
			),
			array(
				'field'  => 'code',
				'value'  => 1,
				'target' => 'name',
				'en'     => 'Email Headlines Each Night',
				'ja'     => 'メールダイジェストを送信する',
			),
		),
		
		/**
		* アンケートの選択肢
		*/
# 		'pollanswers' => array(
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 0,
# 				'field2' => 'aid',
# 				'value2' => 1,
# 				'target' => 'answer',
# 				'en'     => 'MS SQL support',
# 				'ja'     => 'Microsoft SQLサーバのサポート',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 0,
# 				'field2' => 'aid',
# 				'value2' => 2,
# 				'target' => 'answer',
# 				'en'     => 'Multi-language support',
# 				'ja'     => '多言語サポート',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 0,
# 				'field2' => 'aid',
# 				'value2' => 3,
# 				'target' => 'answer',
# 				'en'     => 'Calendar as a plugin',
# 				'ja'     => 'カレンダのプラグイン化',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 0,
# 				'field2' => 'aid',
# 				'value2' => 4,
# 				'target' => 'answer',
# 				'en'     => 'SLV spam protection',
# 				'ja'     => 'SLVによるスパム防御',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 0,
# 				'field2' => 'aid',
# 				'value2' => 5,
# 				'target' => 'answer',
# 				'en'     => 'Mass-delete users',
# 				'ja'     => 'ユーザ一括削除',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 0,
# 				'field2' => 'aid',
# 				'value2' => 6,
# 				'target' => 'answer',
# 				'en'     => 'Other',
# 				'ja'     => 'その他',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 1,
# 				'field2' => 'aid',
# 				'value2' => 1,
# 				'target' => 'answer',
# 				'en'     => 'Story-Images',
# 				'ja'     => '記事で画像を扱える',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 1,
# 				'field2' => 'aid',
# 				'value2' => 2,
# 				'target' => 'answer',
# 				'en'     => 'User-Rights handling',
# 				'ja'     => 'ユーザ権限管理',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 1,
# 				'field2' => 'aid',
# 				'value2' => 3,
# 				'target' => 'answer',
# 				'en'     => 'The Support',
# 				'ja'     => 'サポート体制',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 1,
# 				'field2' => 'aid',
# 				'value2' => 4,
# 				'target' => 'answer',
# 				'en'     => 'Plugin Availability',
# 				'ja'     => 'プラグイン',
# 			),
# 		),
		
		/**
		* アンケートの質問事項
		*/
# 		'pollquestions' => array(
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 0,
# 				'field2' => 'pid',
# 				'value2' => 'geeklogfeaturepoll',
# 				'target' => 'question',
# 				'en'     => 'What is the best new feature of Geeklog?',
# 				'ja'     => 'Geeklogの新機能で一番良いものは?',
# 			),
# 			array(
# 				'field'  => 'qid',
# 				'value'  => 1,
# 				'field2' => 'pid',
# 				'value2' => 'geeklogfeaturepoll',
# 				'target' => 'question',
# 				'en'     => 'What is the all-time best feature of Geeklog?',
# 				'ja'     => 'Geeklogの機能で今も変わらず一番良い機能は?',
# 			),
# 		),
# 		
# 		/**
# 		* アンケートの話題
# 		*/
# 		'polltopics' => array(
# 			array(
# 				'field'  => 'pid',
# 				'value'  => 'geeklogfeaturepoll',
# 				'target' => 'topic',
# 				'en'     => 'Tell us your opinion about Geeklog',
# 				'ja'     => 'Geeklogについてお答えください。',
# 			),
# 		),
		
		/**
		* 投稿モード
		*/
		'postmodes' => array(
			array(
				'field'  => 'code',
				'value'  => 'plaintext',
				'target' => 'name',
				'en'     => 'Plain Old Text',
				'ja'     => 'テキスト',
			),
			array(
				'field'  => 'code',
				'value'  => 'html',
				'target' => 'name',
				'en'     => 'HTML Formatted',
				'ja'     => 'HTML',
			),
		),
		
		/**
		* 並べ換えモード
		*/
		'sortcodes' => array(
			array(
				'field'  => 'code',
				'value'  => 'ASC',
				'target' => 'name',
				'en'     => 'Oldest First',
				'ja'     => '昇順',
			),
			array(
				'field'  => 'code',
				'value'  => 'DESC',
				'target' => 'name',
				'en'     => 'Newest First',
				'ja'     => '降順',
			),
		),
		
		/**
		* ステータスコード
		*/
		'statuscodes' => array(
			array(
				'field'  => 'code',
				'value'  => 1,
				'target' => 'name',
				'en'     => 'Refreshing',
				'ja'     => '更新中',
			),
			array(
				'field'  => 'code',
				'value'  => 0,
				'target' => 'name',
				'en'     => 'Normal',
				'ja'     => '通常',
			),
			array(
				'field'  => 'code',
				'value'  => 10,
				'target' => 'name',
				'en'     => 'Archive',
				'ja'     => 'アーカイブ',
			),
		),
		
		/**
		* フィードの初期値
		*/
		'syndication' => array(
			array(
				'field'  => 'type',
				'value'  => 'geeklog',
				'target' => 'charset',
				'en'     => 'iso-8859-1',
				'ja'     => 'utf-8',
			),
			array(
				'field'  => 'type',
				'value'  => 'geeklog',
				'target' => 'language',
				'en'     => 'en-gb',
				'ja'     => 'ja',			// 'ja-JP'の方がよいかも
			),
		),
		
		/**
		* 話題
		*/
		'topics' => array(
			array(
				'field'  => 'tid',
				'value'  => 'General',
				'target' => 'topic',
				'en'     => 'General News',
				'ja'     => 'おしらせ',
			),
		),
		
		/**
		* トラックバックコード
		*/
		'trackbackcodes' => array(
			array(
				'field'  => 'code',
				'value'  => 0,
				'target' => 'name',
				'en'     => 'Trackback Enabled',
				'ja'     => 'トラックバック許可',
			),
			array(
				'field'  => 'code',
				'value'  => -1,
				'target' => 'name',
				'en'     => 'Trackback Disabled',
				'ja'     => 'トラックバック拒否',
			),
		),
	);
}
