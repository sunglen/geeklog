<?php

###############################################################################
# english_utf-8.php
# This is the english language page for the Geeklog Autotags Plug-in!
#
# Copyright (C) 2006 Joe Mucchiello
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

$LANG_AUTO = array(
    'newpage' => 'New Page',
    'adminhome' => 'Admin Home',
    'tag' => 'Tag',
    'desc' => 'Description',
    'replacement' => 'Replace With',
    'enabled' => 'Enabled?',
    'function' => 'Replace using function?',
    'short_function' => 'Is Function?',
    'autotagseditor' => 'Autotags Editor',
    'autotagsmanager' => 'Autotags Manager',
    'edit' => 'Edit',
    'save' => 'save',
    'delete' => 'delete',
    'cancel' => 'cancel',
    
    'access_denied' => 'Access Denied',
    'access_denied_msg' => 'You are illegally trying access one of the Static Pages administration pages.  Please note that all attempts to illegally access this page are logged',
    'deny_msg' => 'Access to this page is denied.  Either the page has been moved/removed or you do not have sufficient permissions.',

    'php_msg_enabled' => 'If you check the function checkbox, when this tag is encountered the function named with the tag\'s name prefixed with phpautotags_ will be called to translate the tag. The <b>Replace With</b> text will be ignored.',
    'php_msg_disabled' => 'You must set the $_AUTO_CONF[\'allow_php\'] configuration setting to \'1\' and be in a group with the autotags.PHP feature in order to modify autotags that call a function to translate the tag.',
    
    'disallowed_tag' => 'The tag you have chosen is restricted and not available for use. Choose another tag.',
    'duplicate_tag' => 'The tag you have chosen is already in use. Please choose another tag name or edit the existing tag.',
    'no_tag_or_replacement' => 'You must at least fill in the <b>Tag</b> and <b>Replace With</b> fields.',

    'instructions' => 'To modify or delete an autotag, click on that tag\'s edit icon below. To create a new autotag, click on "Create New" above. <p>If there are tags you cannot edit or enable it is because these autotags are function based and you do not have access to the autotags.PHP feature or function based autotags are disabled in $_AUTO_CONF.<p>',
    'replace_explain' => 'Autotags take the form <b>[tag:parameter1 And the rest here is parameter2]</b>. In the replace with field you can type any valid HTML. You can include parameter1 and/or parameter2 in your replacement string by putting #1 and/or #2 in the Replace With field.'
                        .'<p>Autotags are commonly used to create links. A Replace With field of <b>&lt;a href="http://path.to.somewhere/#1"&gt;#2&lt;/a&gt;</b> when combined with this tag <b>[tag:foo This is a link]</b> will result in the string <b>&lt;a href="http://path.to.somewhere/foo"&gt;This is a link&lt;/a&gt;</b>'
                        .'<p>In addition to #1 and #2, #0 is the entire string after the first colon. #U is the base url of the website.',

    'php_not_activated' => 'The use of PHP in static pages is not activated. Please see the <a href="' . $_CONF['site_url'] . '/docs/english/staticpages.html#php">documentation</a> for details.',

    'edit' => 'Edit',

    'search' => 'Search',
    'submit' => 'Submit',
    
    'list_all_title' => 'List of Auto Tags',
    'window_close' => 'Close',
    'main_menulabel' => 'Autotag List',

    'descr_story' => 'Links to a story on this website. Title of story is link text: [story:story_id]',
    'descr_event' => 'Links to an event on this website. Title of the event is link text: [event:event_id]',
    'descr_calendar' => 'Links to a calendar entry on this website. Title of the entry is link text: [calendar:event_id]',
    'descr_link' => 'Links to a web resource on this website. Title of remote page is link text: [link:link_id]',
    'descr_staticpage' => 'Links to a staticpage on this website. Title of the page is link text: [staticpage:page_id]',
// Added since 1.02jp3
	'admin_label' => 'Autotags',
);

?>