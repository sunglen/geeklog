<?php

###############################################################################
# lang.php
# This is the english language page for the Geeklog File Mgmt Page Plug-in!
#
# Copyright (C) 2002 Blaine Lang
# blaine@portalparts.com
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
//
// Language variables used by the Plug-in API
# Simplified Chinese (UTF-8) language page for filemgmt plugin:
# plugins/filemgmt/language/chinese_simplified_utf-8.php
# 
# Last Modified: 2010-10-29 by Sun Ge <sun_ge@yahoo.cn>

$LANG_FM00 = array (
    'access_denied'     => '拒绝访问',
    'access_denied_msg' => '本页仅供Root用户访问。您的名字与IP地址已被记录。',
    'admin'             => '插件管理员',
    'install_header'    => '插件安装/卸载',
    'installed'         => '该插件和组件现已安装完毕。<p><i>请尽情使用。<br><a href="MAILTO:blaine@portalparts.com">Blaine</a></i>君上。',
    'uninstalled'       => '该插件没有被安装。',
    'install_success'   => '安装成功。<p><b>下一步是</b>: 
        <ol><li>点击文件管理来设定插件。</ol>
        <p>详细资料请参照<a href="%s">Install Notes</a>。',
    'install_failed'    => '安装失败。请参照错误记录。',
    'uninstall_msg'     => '该插件已被卸载。',
    'install'           => '安装',
    'uninstall'         => '卸载',
    'editor'            => '插件编辑器',
    'warning'           => '卸载前的警告',
    'enabled'           => '<p style="padding: 15px 0px 5px 25px;">该插件已被安装和启用。<br>如果想要卸载，请在此之前将该插件关闭。</p><div style="padding:5px 0px 5px 25px;"><a href="'.$_CONF['site_admin_url'].'/plugins.php">Plugin Editor</a></div',
    'WhatsNewLabel'    => '新到文件',
    'WhatsNewPeriod'   => '(%s日内)'
);

// Admin Navbar
$LANG_FM02 = array(
    'nav1'  => '设定',
    'nav2'  => '类别',
    'nav3'  => '添加文件',
    'nav4'  => '下载 (%s)',
    'nav5'  => '损坏的文件 (%s)'
);

$LANG_FILEMGMT= array(
    'newpage' => "新建",
    'adminhome' => "管理首页",
    'plugin_name' => "文件管理",
    'searchlabel' => "文件列表",
    'searchlabel_results' => "文件列表结果",
    'downloads' => "下载",
    'report' => "下载次数最多的",
    'usermenu1' => "下载",
    'usermenu2' => "&nbsp;&nbsp;最高排名",
    'usermenu3' => "文件上载",
    'admin_menu' => "文件管理",
    'writtenby' => "作者",
    'date' => "更新日",
    'title' => "标题",
    'content' => "内容",
    'hits' => "下载次数",
    'Filelisting' => "文件列表",
    'DownloadReport' => "单文件下载历史",
    'StatsMsg1' => "下载次数排名最高10位",
    'StatsMsg2' => "本站尚无文件管理插件用的定义文件，或者还没有人访问过那些定义文件。",
    'usealtheader' => "请使用Alt. Header。",
    'url' => "URL",
    'edit' => "编辑",
    'lastupdated' => "最新文件",
    'pageformat' => "页格式",
    'leftrightblocks' => "左・右组件",
    'blankpage' => "空白页",
    'noblocks' => "无组件",
    'leftblocks' => "左组件",
    'addtomenu' => '添加到菜单',
    'label' => '标签',
    'nofiles' => '文件数 (下载)',
    'save' => '保存',
    'preview' => '预览',
    'delete' => '删除',
    'cancel' => '取消',
    'access_denied' => '访问被拒绝',
    'invalid_install' => '有人试图非法访问文件管理插件的安装/卸载页面。用户ID: ',
    'start_install' => '尝试安装文件管理插件。',
    'start_dbcreate' => '尝试创建文件管理插件用的数据表。',
    'install_skip' => '... skipped as per filemgmt.cfg',
    'access_denied_msg' => '您试图非法访问文件管理插件的管理页。所有对该页非法访问的尝试都将被记录。',
    'installation_complete' => '安装完毕',
    'installation_complete_msg' => 'Geeklog用文件管理插件的数据结构都被成功导入数据库！万一想要卸载该插件，请阅读该插件付属的README文档。',
    'installation_failed' => '安装失败',
    'installation_failed_msg' => '文件管理插件的安装失败。请参阅error.log来查明原因。',
    'system_locked' => '系统已被锁住',
    'system_locked_msg' => '文件管理插件已被安装和锁住。如果想要卸载，请阅读付属的README文件。',
    'uninstall_complete' => '卸载完毕',
    'uninstall_complete_msg' => '文件管理插件引用的数据结构已从数据库中删除。<br><br>请手工删除文件存放处(repository)里的文件。',
    'uninstall_failed' => '卸载失败。',
    'uninstall_failed_msg' => '文件管理插件的卸载失败。请参阅error.log查明原因。',
    'install_noop' => '插件安装',
    'install_noop_msg' => '已执行文件管理插件的安装操作，但无事可做。<br><br>请确认插件的设定文件install.cfg。',
    'all_html_allowed' => '允许所有HTML标记',
    'no_new_files'  => '-',
    'no_comments'   => '-',
    'more'          => '<em>[显示全文]</em>'
);

$PLG_filemgmt_MESSAGE1 = '文件管理插件的安装中断。<br>文件: plugins/filemgmt/filemgmt.php 不可写。';
$PLG_filemgmt_MESSAGE3 = '该插件需要 Geeklog Version 1.4 及以后的版本。升级中断。';
$PLG_filemgmt_MESSAGE4 = '该插件 version 1.5 用的代码未被检出。升级中断。';
$PLG_filemgmt_MESSAGE5 = '文件管理插件的升级中断。<br>现在的插件版本不是1.3。';


// Language variables used by the plugin - general users access code.

define("_MD_THANKSFORINFO","感谢您提供此信息。我们将立刻调查您的请求。");
define("_MD_BACKTOTOP","返回下载首页");
define("_MD_THANKSFORHELP","非常感谢您维护本目录的完整性。");
define("_MD_FORSECURITY","出于安全的考虑，您的用户名和IP地址将被临时性记录。");

define("_MD_SEARCHFOR","检索对象");
define("_MD_MATCH","一致");
define("_MD_ALL","全部");
define("_MD_ANY","任意一个");
define("_MD_NAME","名字");
define("_MD_DESCRIPTION","说明");
define("_MD_SEARCH","检索");

define("_MD_MAIN","Main");
define("_MD_SUBMITFILE","提供文件");
define("_MD_POPULAR","次数");
define("_MD_NEW","New");
define("_MD_TOPRATED","最高排名");

define("_MD_NEWTHISWEEK","本周的新建文件");
define("_MD_UPTHISWEEK","本周被更新的文件");

define("_MD_POPULARITYLTOM","下载次数 (最少到最多)");
define("_MD_POPULARITYMTOL","下载次数 (最多到最少)");
define("_MD_TITLEATOZ","标题(A to Z)");
define("_MD_TITLEZTOA","标题(Z to A)");
define("_MD_DATEOLD","日期(旧文件在前)");
define("_MD_DATENEW","日期(新文件在前)");
define("_MD_RATINGLTOH","评价(最低到最高)");
define("_MD_RATINGHTOL","评价(最高到最低)");

define("_MD_NOSHOTS","无缩略图");
define("_MD_EDITTHISDL","编辑下载文件");

define("_MD_LISTINGHEADING","<b>文件列表: 数据库中有%s个文件。</b>");
define("_MD_LATESTLISTING","<b>最新列表:</b>");
define("_MD_DESCRIPTIONC","说明:");
define("_MD_EMAILC","Email: ");
define("_MD_CATEGORYC","类别: ");
define("_MD_LASTUPDATEC","最新更新: ");
define("_MD_DLNOW","请下载！");
define("_MD_VERSION","版本");
define("_MD_SUBMITDATE","日期");
define("_MD_DLTIMES","下载 %s 次");
define("_MD_FILESIZE","文件大小");
define("_MD_SUPPORTEDPLAT","支持的平台");
define("_MD_HOMEPAGE","主页");
define("_MD_HITSC","下载次数: ");
define("_MD_RATINGC","评价: ");
define("_MD_ONEVOTE","1 投票");
define("_MD_NUMVOTES","(%s)");
define("_MD_NOPOST","无");
define("_MD_NUMPOSTS","投票数: %s");
define("_MD_COMMENTSC","评论: ");
define ("_MD_ENTERCOMMENT", "写评论");
define("_MD_RATETHISFILE","评价该文件");
define("_MD_MODIFY","编辑");
define("_MD_REPORTBROKEN","报告文件破损");
define("_MD_TELLAFRIEND","告诉朋友");
define("_MD_VSCOMMENTS","读评论/写评论");
define("_MD_EDIT","编辑");

define("_MD_THEREARE","数据库中有 %s 个文件。");
define("_MD_LATESTLIST","最新列表");

define("_MD_REQUESTMOD","下载文件编辑");
define("_MD_FILE","文件");
define("_MD_FILEID","文件ID: ");
define("_MD_FILETITLE","标题: ");
define("_MD_DLURL","下载URL: ");
define("_MD_HOMEPAGEC","主页: ");
define("_MD_VERSIONC","版本: ");
define("_MD_FILESIZEC","文件大小: ");
define("_MD_NUMBYTES","%s 字节");
define("_MD_PLATFORMC","平台: ");
define("_MD_CONTACTEMAIL","联络E-mail: ");
define("_MD_SHOTIMAGE","缩略图: ");
define("_MD_SENDREQUEST","发送请求");

define("_MD_VOTEAPPRE","感謝投票。");
define("_MD_THANKYOU","感谢您在 %s 投票。"); // %s is your site name
define("_MD_VOTEFROMYOU","您自己的输入将帮助其他的访问者判断需要下载哪个文件。");
define("_MD_VOTEONCE","同一文件只接受一次投票。");
define("_MD_RATINGSCALE","评价基准是 1 (最低)到 10 (最高)。");
define("_MD_BEOBJECTIVE","请客观评价。如果每个都是 1 或 10 ，这样的排名显得毫无作用。");
define("_MD_DONOTVOTE","您不能对自己提供的文件投票。");
define("_MD_RATEIT","提交评价");

define("_MD_INTFILEAT","%s 的热点下载"); // %s is your site name
define("_MD_INTFILEFOUND","%s 上找到的热点下载。"); // %s is your site name

define("_MD_RECEIVED","感谢您提供下载信息。");
define("_MD_WHENAPPROVED","您将收到一封批准电邮。");
define("_MD_SUBMITONCE","请只执行一次。");
define("_MD_APPROVED", "您提供的文件已被批准。");
define("_MD_ALLPENDING","所有的文件信息都处于未验证状态。");
define("_MD_DONTABUSE","用户名与IP地址已被记录。");
define("_MD_TAKEDAYS","您提供的文件/脚本可能要花费几天时间才会被添加到我们的数据库中。");

define("_MD_RANK","级别");
define("_MD_CATEGORY","类别");
define("_MD_HITS","下载次数");
define("_MD_RATING","评价");
define("_MD_VOTE","投票");

define("_MD_SEARCHRESULT4","检索结果 <b>%s</b>:");
define("_MD_MATCHESFOUND","%s 件一致。");
define("_MD_SORTBY","排序基准:");
define("_MD_TITLE","标题");
define("_MD_DATE","日期");
define("_MD_POPULARITY","人气");
define("_MD_CURSORTBY","文件排序基准: ");
define("_MD_FOUNDIN","找到:");
define("_MD_PREVIOUS","上一个");
define("_MD_NEXT","下一个");
define("_MD_NOMATCH","没有与检索条件一致的。");

define("_MD_TOP10","%s 最高10位"); // %s is a downloads category name
define("_MD_CATEGORIES","类别");

define("_MD_SUBMIT","提交");
define("_MD_CANCEL","取消");

define("_MD_BYTES","Bytes");
define("_MD_ALREADYREPORTED","您已提交了一个破损文件报告。");
define("_MD_MUSTREGFIRST","您没有执行该操作的权限。<br>请登录或注册。");
define("_MD_NORATING","没有选择评价。");
define("_MD_CANTVOTEOWN","您不能对自己提供的文件投票。<br>所有的投票都将被记录和讨论。");

// Language variables used by the plugin - Admin code.

define("_MD_RATEFILETITLE","请记录您的文件评价。");
define("_MD_ADMINTITLE","文件管理　管理者菜单");
define("_MD_UPLOADTITLE","文件管理 - 上载文件");
define("_MD_CATEGORYTITLE","列表 - 类别");
define("_MD_DLCONF","下载设定");
define("_MD_GENERALSET","文件管理设定");
define("_MD_ADDMODFILENAME","上载文件");
define ("_MD_ADDCATEGORYSNAP", "画像: <small>(可选，仅顶层类别用)</small>");
define ("_MD_ADDIMAGENOTE", "(画像高度限制 50)");
define("_MD_ADDMODCATEGORY","<b>类别:</b> 类别增加/修改/删除");
define("_MD_DLSWAITING","等待下载许可");
define("_MD_BROKENREPORTS","破损文件报告");
define("_MD_MODREQUESTS","下载信息修正要求");
define("_MD_EMAILOPTION","文件被批准时的发送电邮: ");
define("_MD_COMMENTOPTION","允许评论:");
define("_MD_SUBMITTER","提供者: ");
define("_MD_DOWNLOAD","下载");
define("_MD_FILELINK","显示全文");
define("_MD_SUBMITTEDBY","文件提供: ");
define("_MD_APPROVE","批准");
define("_MD_DELETE","删除");
define("_MD_NOSUBMITTED","无新提交的下载文件");
define("_MD_ADDMAIN","增加主类别");
define("_MD_TITLEC","标题: ");
define("_MD_CATSEC", "可访问用户类别: ");
define("_MD_IMGURL","<br>画像文件名 <font size='-2'> (位于 filemgmt_data/category_snaps - 画像高度限制 50)</font>");
define("_MD_ADD","增加");
define("_MD_ADDSUB","增加子类别");
define("_MD_IN","于");
define("_MD_ADDNEWFILE","上载新文件");
define("_MD_MODCAT","修改类别");
define("_MD_MODDL","变更下载信息");
define("_MD_USER","用户");
define("_MD_IP","IP地址");
define("_MD_USERAVG","用户评价的平均值");
define("_MD_TOTALRATE","全部评价");
define("_MD_NOREGVOTES","非注册用户投票");
define("_MD_NOUNREGVOTES","没有非注册用户的投票");
define("_MD_VOTEDELETED","投票数据已被删除。");
define("_MD_NOBROKEN","无破损文件。");
define("_MD_IGNOREDESC","忽略(忽略该报告，仅删除该报告条目)");
define("_MD_DELETEDESC","删除(删除<b>报告的下载文件条目</b>，并非真实文件)");
define("_MD_REPORTER","报告提出者");
define("_MD_FILESUBMITTER","文件提供者");
define("_MD_IGNORE","忽略");
define("_MD_FILEDELETED","文件已被删除。");
define("_MD_FILENOTDELETED","记录已被删除，但文件未被删除。<p>有多项记录指向同一个文件。</p>");
define("_MD_BROKENDELETED","破损文件的报告已被删除。");
define("_MD_USERMODREQ","用户下载信息修改要求");
define("_MD_ORIGINAL","原始");
define("_MD_PROPOSED","提案");
define("_MD_OWNER","所有者: ");
define("_MD_NOMODREQ","无下载修改要求。");
define("_MD_DBUPDATED","数据库已被更新。");
define("_MD_MODREQDELETED","已删除修改要求。");
define("_MD_IMGURLMAIN","画像(画像高度限制 50): ");
define("_MD_PARENT","父类别:");
define("_MD_SAVE","保存变更");
define("_MD_CATDELETED","类别已被删除。");
define("_MD_WARNING","警告: 您确定删除该类别与类别内的全部文件/评论吗？");
define("_MD_YES","是");
define("_MD_NO","否");
define("_MD_NEWCATADDED","已添加新类别。");
define("_MD_CONFIGUPDATED","设定已被保存。");
define("_MD_ERROREXIST","错误: 您提供的下载信息已存在于数据库中。");
define("_MD_ERRORNOFILE","错误: 在数据库中找不到文件。");  
define("_MD_ERRORTITLE","错误: 请输入标题。");
define("_MD_ERRORDESC","错误: 请输入说明。");
define("_MD_NEWDLADDED","新下载文件已被添加到数据库中。");
define("_MD_NEWDLADDED_DUPFILE","警告: 文件重复。新下载文件已被添加到数据库中。");
define("_MD_NEWDLADDED_DUPSNAP","警告: Snap重复。新下载文件已被添加到数据库中。");
define("_MD_HELLO","您好，%s");
define("_MD_WEAPPROVED","我们已经批准了您提供的下载文件。文件名: ");
define("_MD_THANKSSUBMIT","谢谢您。");
define("_MD_UPLOADAPPROVED","您上载的文件已被批准。");
define("_MD_DLSPERPAGE","每页显示的文件数: ");
define("_MD_HITSPOP","下载多少次算有人气: ");
define("_MD_DLSNEW","首页上显示的文件数: ");
define("_MD_DLSSEARCH","检索结果中的下载文件数: ");
define("_MD_TRIMDESC","列表: ");
define("_MD_DLREPORT","限制访问下载报告");
define("_MD_WHATSNEWDESC","开启「最新下载」:");
define("_MD_SELECTPRIV","仅允许登录的用户访问: ");
define("_MD_ACCESSPRIV","允许匿名的浏览者访问: ");
define("_MD_UPLOADSELECT","允许登录的用户上载: ");
define("_MD_UPLOADPUBLIC","允许匿名用户上载: ");
define("_MD_USESHOTS","显示类别画像: ");
define("_MD_IMGWIDTH","画像宽度: ");
define("_MD_MUSTBEVALID","缩略图必须是在 %s 目录内的有效画像文件(例如 shot.gif)。如果没有画像文件请保持空白。");
define("_MD_REGUSERVOTES","登录用户的投票(投票总数: %s)");
define("_MD_ANONUSERVOTES","未登录用户的投票(投票总数: %s)");
define("_MD_YOURFILEAT","您对 %s 的文件提供"); // this is an approved mail subject. %s is your site name
define("_MD_VISITAT","请浏览我们在 %s 下载区域。");
define("_MD_DLRATINGS","下载评价(投票总数: %s)");
define("_MD_CONFUPDATED","设定已被更新。");
define("_MD_NOFILES","无文件。");   

define("_MD_DIRFILES","保存文件的目录：");
define("_MD_DIRTHUMBS","保存文件缩略图的目录：");
define("_MD_DIRCATTHUMBS","保存类别缩略图的目录：");
define("_MD_URLFILES","文件的URL：");
define("_MD_URLTHUMBS","文件缩略图的URL：");
define("_MD_URLCATTHUMBS","类别缩略图的URL：");
define("_MD_MODOPT","选项：");
define("_MD_OPTUPDATE","更新注册日期");

// Additional Geeklog Defines
define("_MD_NOVOTE","还未被评价。");
define("_IFNOTRELOAD","如果页面没有被自动载入，请点击<a href='%s'>这里</a>。");
define("_GL_ERRORNOACCESS","错误: 无法访问此文档存储区。");
define("_GL_ERRORNOUPLOAD","错误: 您没有上载文件的权限。");
define("_GL_ERRORNOADMIN","错误: 该机能被限制使用。");
define("_GL_NOUSERACCESS","无法访问文档存储区。");
define("_MD_ERRUPLOAD","文件管理: 无法上载。请检查文件存储目录的读写权限。");
define("_MD_DLFILENAME","文件名: ");
define("_MD_REPLFILENAME","替代文件: ");
define("_MD_SCREENSHOT","画像");
define("_MD_SCREENSHOT_NA","&nbsp;");
define("_MD_COMMENTSWANTED","欢迎评论");
define("_MD_CLICK2SEE","请点击: ");
define("_MD_CLICK2DL","请点击下载: ");
define("_MD_ORDERBY","排序: ");
define("_MD_ORDERBY","排序: ");
define("_MD_ORDERBY","排序: ");

define("_MD_DLTEMPFILE","下载以便预览：");
define("_MD_TEMPFILE","临时文件");
define("_MD_SUBMITNOTIFY","文件提供的通知");

// Localization of the Admin Configuration UI
$LANG_configsections['filemgmt'] = array(
    'label' => '文件管理',
    'title' => '文件管理的设定'
);

$LANG_confignames['filemgmt'] = array(
    'mydownloads_popular'         => '热门文件的阅览数阀值',
    'mydownloads_newdownloads'    => '首页上新到文件的显示数',
    'mydownloads_perpage'         => '每页显示的文件数',

    'mydownloads_dlreport'        => '限制阅览下载履历',
    'mydownloads_trimdesc'        => '在文件列表中显示一部分说明',
    'mydownloads_whatsnew'        => '显示新到信息列表',

    'mydownloads_selectpriv'      => '允许 \'Logged-In Users\' 下载',
    'mydownloads_uploadselect'    => '允许 Logged-In 上载',
    'mydownloads_publicpriv'      => '允许匿名访客下载',
    'mydownloads_uploadpublic'    => '允许匿名访客上载',

    'mydownloads_useshots'        => '显示类别图标',
    'mydownloads_shotwidth'       => '缩略图宽',
    'filemgmt_Emailoption'        => '当文件被批准时发送电邮',

    'filemgmt_FileStore'       => '下载文件',
    'filemgmt_SnapStore'       => '下载文件缩略图',
    'filemgmt_SnapCat'         => '目录缩略图',
    'filemgmt_FileStoreURL'    => '下载文件',
    'filemgmt_FileSnapURL'     => '下载文件缩略图',
    'filemgmt_SnapCatURL'      => '目录缩略图',
);

$LANG_configsubgroups['filemgmt'] = array(
    'sg_main' => '主设定'
);

$LANG_fs['filemgmt'] = array(
    'fs_main'            => '文件管理的主设定',
    'fs_path'            => '文件仓库路径',
    'fs_url'             => '文件仓库的URL'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['filemgmt'] = array(
    0 => array('是' => 1, '否' => 0)
);

?>
