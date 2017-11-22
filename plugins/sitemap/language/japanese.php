<?php

// +---------------------------------------------------------------------------+
// | Sitemap Plugin for Geeklog - The Ultimate Weblog                          |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/sitemap/language/japanese.php                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2008 mystral-kk - geeklog AT mystral-k DOT net         |
// |                                                                           |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------|
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

if (strpos(strtolower($_SERVER['PHP_SELF']), 'japanese.php') !== FALSE) {
	die('This file cannot be used on its own.');
}

$LANG_SMAP = array(
    'plugin'            => 'sitemap�ץ饰����',
	'access_denied'     => '���������ϵ��ݤ���ޤ�����',
	'access_denied_msg' => '���Υڡ����˥��������Ǥ���Τϡ�Root�桼�������Ǥ������ʤ��Υ桼��̾��IP���ɥ쥹�ϵ�Ͽ����ޤ�����',
	'admin'		        => 'sitemap�ץ饰�������',
	'install_header'	=> 'sitemap�ץ饰����Υ��󥹥ȡ���/���󥤥󥹥ȡ���',
	'install_success'	=> 'sitemap�ץ饰����Υ��󥹥ȡ�����������ޤ�����',
	'install_fail'  	=> 'sitemap�ץ饰����Υ��󥹥ȡ���˼��Ԥ��ޤ������ܺ٤ϥ��顼��(error.log)��������������',
	'uninstall_success'	=> 'sitemap�ץ饰����Υ��󥤥󥹥ȡ�����������ޤ�����',
	'uninstall_fail'    => 'sitemap�ץ饰����Υ��󥤥󥹥ȡ���˼��Ԥ��ޤ������ܺ٤ϥ��顼��(error.log)��������������',
	'uninstall_msg'		=> 'sitemap�ץ饰����ϥ��󥤥󥹥ȡ��뤵��ޤ�����',
	'menu_label'        => '�����ȥޥå�',
	'sitemap'           => '�����ȥޥå�',
	'submit'            => '����',
	'all'               => '���٤�',
	'article'           => '����',
	'comments'          => '������',
	'trackback'         => '�ȥ�å��Хå�',
	'staticpages'       => '��Ū�ڡ���',
	'calendar'          => '������',
	'links'             => '���',
	'polls'             => '���󥱡���',
	'dokuwiki'          => 'DokuWiki',
	'forum'             => '�Ǽ���',
	'filemgmt'          => '�ե��������',
	'faqman'            => 'FAQ',
	'mediagallery'      => '��ǥ���������',
	'calendarjp'        => '������jp',
	'download'          => '���������',
	'sitemap_setting'   => '�����ȥޥåפ�����',
	'sitemap_setting_misc' => '�����ȥޥåפ�ɽ������',
	'order'             => 'ɽ����',
	'up'                => '���',
	'down'              => '����',
	'anon_access'       => '�����ȥ桼���Υ�����������Ĥ���',
	'sitemap_in_xhtml'  => 'XHTML�Ǻ�������',
	'date_format'       => '���դη���',
	'desc_date_format'  => '�����դη����פǻ��Ѥ���ѥ�᡼���ϡ�PHP��<a href="http://www.php.net/manual/ja/function.date.php">date()�ؿ�</a>��format�ѥ�᡼����Ʊ���Ǥ���',
	'sitemap_items'     => '�����ȥޥåפ˷Ǻܤ������',
	'gsmap_setting'     => 'Google�����ȥޥåפ�����',
	'file_creation'     => '�ե��������������',
	'google_sitemap_name' => '�ե�����̾��',
	'time_zone'         => '�����ॾ����',
	'update_now'        => '���ޤ�����������',
	'last_updated'      => '���󹹿�����',
	'unknown'           => '����',
	'desc_filename'     => '<strong>�֥ե�����̾��</strong>�ˤϡ�Google�����ȥޥåפΥե�����̾����ꤷ�ޤ������ߥ����Ƕ��ڤä�ʣ������Ǥ��ޤ�����Х����ѤΥ����ȥޥå�̾�� mobile.xml �Ȥ��Ƥ���������',
	'desc_time_zone'    => '<strong>�֥����ॾ�����</strong>�ˤϡ�Geeklog�����֤��Ƥ��륵���ФΥ����ॾ�����<a href="http://ja.wikipedia.org/wiki/ISO_8601">ISO 8601</a>�η���((+|-)hh:mm)�ǻ��ꤷ�ޤ����㡧+09:00������ˡ�+01:00�ʥѥ�ˡ�+01:00�ʥ٥���ˡ�+00:00�ʥ��ɥ�ˡ�-05:00�ʥ˥塼�衼���ˡ�-08:00�ʥ��󥸥��륹��',
	'gsmap_items'       => 'Google�����ȥޥåפ˷Ǻܤ������',
	'item_name'         => '����̾',
	'freq'              => '�����ֳ�',
	'always'            => '��˹���',
	'hourly'            => '1���֤�1�󹹿�',
	'daily'             => '1����1�󹹿�',
	'weekly'            => '1���֤�1�󹹿�',
	'monthly'           => '1�����1�󹹿�',
	'yearly'            => '1ǯ��1�󹹿�',
	'never'             => '�������ʤ�',
	'priority'          => 'ͥ����',
	'desc_freq'         => '<strong>�ֹ����ֳ֡�</strong>�ϡ����ܤ��ɤ줯�餤�����٤ǹ�������뤫�Ȥ��������褽���ܰ¤�Google�Υ�����˻ؼ����ޤ����ֹ������ʤ��פ����򤷤Ƥ⡢Google�Υ�����ϤȤ��ɤ���󤷤Ƥ��ޤ���',
	'desc_priority'     => '<strong>��ͥ���١�</strong>�ϡ����ܤ�ͥ���٤�<strong>0.0</strong>�ʺ���ˤ���<strong>1.0</strong>�ʺǹ�ˤ��ϰϤǻ��ꤷ�Ƥ��������������ͤ�<strong>0.5</strong>�Ǥ���',
	
	// Since version 1.1.4
	'common_setting'    => '���̤�����',
	'sp_setting'        => '��Ū�ڡ���������',
	'sp_type'           => '�����ȥޥåפ˷Ǻܤ��륿����',
	'sp_type0'          => '���٤�',
	'sp_type1'          => '���󥿡��֥�å���ɽ�������ڡ����Τ�',
	'sp_type2'          => '���󥿡��֥�å���ɽ������ʤ��ڡ����Τ�',
	'sp_except'         => '��������ڡ���ID������ɽ���ġ�Ⱦ�ѥ��ڡ����Ƕ��ڤ��',
);
