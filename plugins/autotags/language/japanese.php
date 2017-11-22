<?php

###############################################################################
# japanese.php
# This is the japanese(EUC-JP) language page for the Geeklog Autotags Plug-in!
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
    'newpage' => '�����ڡ���',
    'adminhome' => '������HOME',
    'tag' => '����̾�ʱѿ�����',
    'desc' => '����������',
    'replacement' => '�ִ�ʸ����',
    'enabled' => 'ͭ��:',
    'function' => '�ؿ����ִ�����:',
    'short_function' => '�ؿ�',
    'autotagseditor' => '��ư�������ǥ���',
    'autotagsmanager' => '��ư�����ޥ͡�����',
    'edit' => '�Խ�',
    'save' => '��¸',
    'delete' => '���',
    'cancel' => '����󥻥�',
    
    'access_denied' => '�������������ݤ���ޤ�����',
    'access_denied_msg' => '��Ū�ڡ����δ������ѥڡ����������˥����������Ƥ��ޤ������Υ��������ϵ�Ͽ����ޤ��ΤǤ�λ������������',
    'deny_msg' => '���Υڡ����ؤΥ������������ݤ���ޤ������ڡ�����������뤤�ϥ�͡��व�줿�Τ����Τ�ޤ��󤷡��ޤ��ϥ����������¤��ʤ��Τ��⤷��ޤ���',

    'php_msg_enabled' => '���������å�����ȡ�phpautotags_ �Ȥ�����Ƭ���դ��Υ���̾��̾���Ȥ���ؿ��Ȥ��Υ������в�ä��Ȥ����ؿ��ϥ����뤵�쥿�����ִ����ޤ������� <b>�ִ�ʸ����</b> �ե���������ʸ�����̵�뤵��ޤ���',
    'php_msg_disabled' => '�������ִ����뤿��δؿ��򥳡��뤹�뼫ư�������Խ����뤿��ˤϡ�config.php ����ѿ� $_AUTO_CONF[\'allow_php\'] �� \'1\' �����ꤷ������� autotags.PHP ���¤򥰥롼�פ�Ϳ����ɬ�פ�����ޤ���',
    
    'disallowed_tag' => '���򤷤������ϻȤ��ޤ���¾������Ǥ���������',
    'duplicate_tag' => '���򤷤������Ϥ��Ǥ����Ф�Ƥ��ޤ���¾�Υ��������֤����������Խ����Ƥ���������',
    'no_tag_or_replacement' => '<b>����</b>��<b>�ִ�ʸ����</b>�ե�����ɤ�ɬ�����Ϥ��Ƥ���������',

    'instructions' => '<p>��ư�������Խ�������ϡ��������Խ���������򥯥�å����Ƥ������������������ϡ����"��������"�򥯥�å����Ƥ����������Խ��Ǥ��ʤ�����ͭ���ˤǤ��ʤ�������������ϡ������ϴؿ��١����Υ����Ǥ��ꡢ���ʤ��� autotags.PHP ���¤��ʤ������ѿ� $_AUTO_CONF �ˤ��ؿ��١����μ�ư������̵���ˤʤäƤ��ޤ���</p>',
    'replace_explain' => '��ư�����ε��ҷ����� <b>[tag:parameter1 parameter2]</b> �Ǥ���<br' . XHTML . '>�ִ�ʸ����ե�����ɤˤ�HTML�򵭽ҤǤ��ޤ���<br' . XHTML . '>�ִ�ʸ����ե�����ɤ�ʸ������� <b>#1</b> �� <b>#2</b> �򵭽Ҥ��뤳�Ȥˤ�ꡢ<b>parameter1</b> �� <b>parameter2</b> ��ޤ�뤳�Ȥ��Ǥ��ޤ���</p>'
                        .'<p>��ư�����ϡ�����Ū�˥�󥯤�������뤿��˻��Ѥ���ޤ���<br' . XHTML . '>���� <b>[tag:foo This is a link]</b> �����ִ�ʸ����ե�����ɤ�ʸ����<br' . XHTML . '> <b>&lt;a href="http://path.to.somewhere/#1"&gt;#2&lt;/a&gt;</b> <br' . XHTML . '>�˴�Ϣ�դ����Ƥ���Ȥ������Υ�����ʸ����<br' . XHTML . '> <b>&lt;a href="http://path.to.somewhere/foo"&gt;This is a link&lt;/a&gt;</b><br' . XHTML . '>���ִ�����ޤ���</p>'
                        . '<p>#1 �� #2 �˲ä��ơ�<b>#0</b> �Ϻǽ�Υ����θ����ʸ����Ǥ��� <b>#U</b> �ϥ����ȤΥ١���URL�Ǥ���</p>',

    'php_not_activated' => '��Ū�ڡ�����PHP��ͭ���ˤʤäƤ��ޤ��󡣾ܤ�����<a href="' . $_CONF['site_url'] . '/docs/japanese/staticpages.html#php">�ɥ������</a>��������������',

    'edit' => '�Խ�',

    'search' => '����',
    'submit' => '���',
    
    'list_all_title' => '��ư�����ꥹ��',
    'window_close' => '������',
    'main_menulabel' => '��ư�����ꥹ��',

    'descr_story' => '���Υ����Ȥε����μ�ư����: [story:story_id]',
    'descr_event' => '���Υ����ȤΥ��٥�Ȥμ�ư����: [event:event_id]',
    'descr_calendar' => '���Υ����ȤΥ������μ�ư����: [calendar:event_id]',
    'descr_link' => '���Υ����ȤΥ�󥯤μ�ư����: [link:link_id]',
    'descr_staticpage' => '���Υ����Ȥ���Ū�ڡ����μ�ư����: [staticpage:page_id]',
// Added since 1.02jp3
	'admin_label' => '��ư����',
);

?>