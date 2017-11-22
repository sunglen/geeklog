<?php
// +---------------------------------------------------------------------------+
// | CAPTCHA v4 Plugin                                                         |
// +---------------------------------------------------------------------------+
// | This is the Japanese language page for the CAPTCHA Plugin                 |
// +---------------------------------------------------------------------------|
// | Copyright (C) 2002,2005,2006,2007 by the following authors:               |
// |                                                                           |
// | Author: mystral-kk    - geeklog AT mystral-kk DOT net                     |
// |         Hiroron       - hiroron AT hiroron DOT com                        |
// +---------------------------------------------------------------------------|
// |                                                                           |
// | If you translate this file, please consider uploading a copy at           |
// |    http://www.mediagallery.org so others can benefit from your            |
// |    translation.  Thank you!                                               |
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

$LANG_CP00 = array (
    'menulabel'         => 'CAPTCHA',
    'plugin'            => 'CAPTCHA',
    'access_denied'     => '������������',
    'access_denied_msg' => '���Υڡ����˥����������뤳�ȤϤǤ��ޤ��󡣥桼��̾��IP���ɥ쥹�ϵ�Ͽ�����Ƥ��������ޤ�����',
    'admin'             => 'CAPTCHA ��������',
    'install_header'    => 'CAPTCHA�ץ饰���� ���󥹥ȡ���',
    'installed'         => 'CAPTCHA�ץ饰����ϥ��󥹥ȡ��뤵��ޤ�����',
    'uninstalled'       => 'CAPTCHA�ץ饰����ϥ��󥹥ȡ��뤵��Ƥ��ޤ���',
    'install_success'   => 'CAPTCHA�ץ饰����ϥ��󥹥ȡ��뤵��ޤ�����<br /><br /><a href="%s">��������</a>��������������',
    'install_failed'    => '���󥹥ȡ���˼��Ԥ��ޤ����� -- ���顼����������������',
    'uninstall_msg'     => '�ץ饰����ϥ��󥤥󥹥ȡ��뤵��ޤ�����',
    'install'           => '���󥹥ȡ���',
    'uninstall'         => '���󥤥󥹥ȡ���',
    'warning'           => '�ٹ�! �ץ饰����Ϥޤ�ͭ���Ǥ���',
    'enabled'           => '�ץ饰����̵��',
    'readme'            => 'CAPTCHA�ץ饰����򥤥󥹥ȡ��롦���󥤥󥹥ȡ��뤷�ޤ���',
    'installdoc'        => "<a href=\"{$_CONF['site_admin_url']}/plugins/captcha/install_doc.html\">���󥹥ȡ���ɥ������</a>",
    'overview'          => 'CAPTCHA��Geeklog�ץ饰����Ǥ����������ƥ����åפΤ���Τ�ΤǤ���<br /><br />A CAPTCHA (an acronym for "Completely Automated Public Turing test to tell Computers and Humans Apart", trademarked by Carnegie Mellon University) is a type of challenge-response test used in computing to determine whether or not the user is human.  By presenting a difficult to read graphic of letters and numbers, it is assumed that only a human could read and enter the characters properly.  By implementing the CAPTCHA test, it should help reduce the number of Spambot entries on your site.',
    'details'           => 'CAPTCHA�ץ饰�����CAPTCHA������True Type fonts(TTF)���б�����GD�ޤ���ImageMagick�����饤�֥��Ǻ�������ޤ����ۥ��ƥ��󥰥ץ�Х�����TTF�����ݡ��Ȥ���Ƥ����ǧ���Ƥ���������',
    'preinstall_check'  => 'CAPTCHA�ץ쥤�󥹥ȡ�������å�:',
    'geeklog_check'     => 'Geeklog 1.4.1 �ʾ��ư��ޤ������С������<b>%s</b>.',
    'php_check'         => 'PHP v4.3.0�ʾ� ���С������<b>%s</b>.',
    'preinstall_confirm' => "CAPTCHA���󥹥ȡ���ξܺ٤ϡ�<a href=\"{$_CONF['site_admin_url']}/plugins/captcha/install_doc.html\">���󥹥ȡ���ޥ˥奢��</a>��",
    'refresh'			=> '<a href="' . $_CONF['site_url'] . '/users.php?mode=new">�����᡼��</a>',
    'captcha_help'		=> '�ƥ����Ȥ����Ϥ��Ƥ�����������ʸ���Ⱦ�ʸ������դ��Ƥ���������',
    'bypass_error'		=> "CAPTCHA������Ԥ��ޤ���",
    'bypass_error_blank' => "�ƥ����Ȥ����Ϥ��Ƥ���������",
    'entry_error'		=> 'CAPTCHA�ƥ����Ȥ����פ��ޤ���Ǥ������������Ϥ��Ƥ���������<b>��ʸ���Ⱦ�ʸ������դ��Ƥ���������</b>',
    'captcha_info'      => 'CAPTCHA�ץ饰����Ϥ��ʤ���Geeklog�����Ȥ�SpamBots������ޤ���',
    'enabled_header'    => '���ߤ�CAPTCHA����',
    'view_logfile'      => 'CAPTCHA ������',
    'log_viewer'        => 'Geeklog ���ӥ塼��',
    'setting_all'       => '���٤�',
    'setting_general'   => '����',
    'setting_auth_sister' => '��ǧ��',
    'on'                => 'On',
    'off'               => 'Off',
    'anonymous_only'    => '�����ȥ桼���Τ��оݤȤ���',
    'enable_comment'    => '������',
    'enable_story'      => '�������',
    'enable_registration' => '�����������Ͽ',
    'enable_contact'    => '���󥿥���',
    'enable_emailstory' => '�����᡼������',
    'enable_forum'      => '�Ǽ���',
    'enable_mediagallery' => '��ǥ��������� (Postcards)',
    'captcha_alt'       => '����ǧ��',
    'save'              => '��¸',
    'cancel'            => '����󥻥�',
    'success'           => '����ե�����졼����󥪥ץ�������¸����ޤ�����',
    'gfx_driver'        => '����ե��å��ɥ饤�С�',
    'gfx_format'        => '����ե��å��ե����ޥå�',
    'convert_path'      => 'ImageMagick�Ѵ��桼�ƥ���ƥ��ؤΥե�ѥ�',
    'gd_libs'           => 'GD�饤�֥��',
    'gd_sister_libs'    => 'GD�饤�֥��(��ǧ��)',
    'imagemagick'       => 'ImageMagick',
    'static_images'     => '�����������',
    'image_set'			=> '����������å�',
    'debug'             => '�ǥХå�',
    'configuration'     => 'CAPTCHA����ե�����졼�����',
    'integration'       => 'CAPTCHA����',
    'reload'            => '��ɽ��',
    'reload_failed'     => '����������ޤ���ǧ���Ѳ��������ɤ���ޤ���Ǥ�����',
    'reload_too_many'   => 'ǧ���Ѳ����κ�ɽ���ϣ���ޤǤǤ���',
    'session_expired'   => '���ʤ���CAPTCHA���å����δ��¤��ڤ�ޤ��������٥ȥ饤���Ƥ���������',
    'remoteusers'       => '���٤ƤΥ�⡼�ȥ桼�����оݤȤ���',
);

$PLG_captcha_MESSAGE1 = 'CAPTCHA�ץ饰����ϥ��󥹥ȡ��뤵��ޤ�����';
$PLG_captcha_MESSAGE2 = 'CAPTCHA�ץ饰����Υ��󥹥ȡ���˼��Ԥ��ޤ��������顼��������å����Ƥ���������';

$LANG_CP10 = array (
    'auth_sister'       => '��ǧ�ڤ�����',
    'auth_sister_package' => '��(�ѥå�����)������',
    'sister_mes_a'      => '��å�������Ƭ���ղä���ʸ����',
    'sister_mes_b'      => '��å������Ǹ���ղä���ʸ����',
    'sister_len_min'    => '����ʸ�κǾ�ʸ����',
    'sister_len_max'    => '����ʸ�κ���ʸ����',
    'sister_outlen'     => 'ʸ�����ϰϳ��Υ��顼ʸ',
    'sister_image'      => '������ե�����',
    'new_sister_image'  => '�����餷��������򥢥åץ��ɤ���',
    'sister_font'       => 'TTF�ե����',
    'new_sister_font'   => '�����餷��TTF�ե���Ȥ򥢥åץ��ɤ���',
    'sister_fsize'      => 'ʸ��������',
    'sister_fx'         => 'ʸ����X��ɸ',
    'sister_fy'         => 'ʸ����Y��ɸ',
    'sister_words'      => '��μ���',
    'sister_css'        => '��Υ������륷����',
);

?>