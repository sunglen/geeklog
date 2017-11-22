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
    'access_denied'     => '拒絕訪問',
    'access_denied_msg' => '本頁僅供Root用戶訪問。您的名字與IP地址已被記錄。',
    'admin'             => '插件管理員',
    'install_header'    => '插件安裝/卸載',
    'installed'         => '該插件和組件現已安裝完畢。<p><i>請盡情使用。<br><a href="MAILTO:blaine@portalparts.com">Blaine</a></i>君上。',
    'uninstalled'       => '該插件沒有被安裝。',
    'install_success'   => '安裝成功。<p><b>下一步是</b>: 
        <ol><li>點擊文件管理來設定插件。</ol>
        <p>詳細資料請參照<a href="%s">Install Notes</a>。',
    'install_failed'    => '安裝失敗。請參照錯誤記錄。',
    'uninstall_msg'     => '該插件已被卸載。',
    'install'           => '安裝',
    'uninstall'         => '卸載',
    'editor'            => '插件編輯器',
    'warning'           => '卸載前的警告',
    'enabled'           => '<p style="padding: 15px 0px 5px 25px;">該插件已被安裝和啟用。<br>如果想要卸載，請在此之前將該插件關閉。</p><div style="padding:5px 0px 5px 25px;"><a href="'.$_CONF['site_admin_url'].'/plugins.php">Plugin Editor</a></div',
    'WhatsNewLabel'    => '新到文件',
    'WhatsNewPeriod'   => '(%s日內)'
);

// Admin Navbar
$LANG_FM02 = array(
    'nav1'  => '設定',
    'nav2'  => '類別',
    'nav3'  => '添加文件',
    'nav4'  => '下載 (%s)',
    'nav5'  => '損壞的文件 (%s)'
);

$LANG_FILEMGMT= array(
    'newpage' => "新建",
    'adminhome' => "管理首頁",
    'plugin_name' => "文件管理",
    'searchlabel' => "文件列表",
    'searchlabel_results' => "文件列表結果",
    'downloads' => "下載",
    'report' => "下載次數最多的",
    'usermenu1' => "下載",
    'usermenu2' => "&nbsp;&nbsp;最高排名",
    'usermenu3' => "文件上載",
    'admin_menu' => "文件管理",
    'writtenby' => "作者",
    'date' => "更新日",
    'title' => "標題",
    'content' => "內容",
    'hits' => "下載次數",
    'Filelisting' => "文件列表",
    'DownloadReport' => "單文件下載歷史",
    'StatsMsg1' => "下載次數排名最高10位",
    'StatsMsg2' => "本站尚無文件管理插件用的定義文件，或者還沒有人訪問過那些定義文件。",
    'usealtheader' => "請使用Alt. Header。",
    'url' => "URL",
    'edit' => "編輯",
    'lastupdated' => "最新文件",
    'pageformat' => "頁格式",
    'leftrightblocks' => "左·右組件",
    'blankpage' => "空白頁",
    'noblocks' => "無組件",
    'leftblocks' => "左組件",
    'addtomenu' => '添加到菜單',
    'label' => '標簽',
    'nofiles' => '文件數 (下載)',
    'save' => '保存',
    'preview' => '預覽',
    'delete' => '刪除',
    'cancel' => '取消',
    'access_denied' => '訪問被拒絕',
    'invalid_install' => '有人試圖非法訪問文件管理插件的安裝/卸載頁面。用戶ID: ',
    'start_install' => '嘗試安裝文件管理插件。',
    'start_dbcreate' => '嘗試創建文件管理插件用的數據表。',
    'install_skip' => '... skipped as per filemgmt.cfg',
    'access_denied_msg' => '您試圖非法訪問文件管理插件的管理頁。所有對該頁非法訪問的嘗試都將被記錄。',
    'installation_complete' => '安裝完畢',
    'installation_complete_msg' => 'Geeklog用文件管理插件的數據結構都被成功導入數據庫！萬一想要卸載該插件，請閱讀該插件付屬的README文檔。',
    'installation_failed' => '安裝失敗',
    'installation_failed_msg' => '文件管理插件的安裝失敗。請參閱error.log來查明原因。',
    'system_locked' => '系統已被鎖住',
    'system_locked_msg' => '文件管理插件已被安裝和鎖住。如果想要卸載，請閱讀付屬的README文件。',
    'uninstall_complete' => '卸載完畢',
    'uninstall_complete_msg' => '文件管理插件引用的數據結構已從數據庫中刪除。<br><br>請手工刪除文件存放處(repository)裡的文件。',
    'uninstall_failed' => '卸載失敗。',
    'uninstall_failed_msg' => '文件管理插件的卸載失敗。請參閱error.log查明原因。',
    'install_noop' => '插件安裝',
    'install_noop_msg' => '已執行文件管理插件的安裝操作，但無事可做。<br><br>請確認插件的設定文件install.cfg。',
    'all_html_allowed' => '允許所有HTML標記',
    'no_new_files'  => '-',
    'no_comments'   => '-',
    'more'          => '<em>[顯示全文]</em>'
);

$PLG_filemgmt_MESSAGE1 = '文件管理插件的安裝中斷。<br>文件: plugins/filemgmt/filemgmt.php 不可寫。';
$PLG_filemgmt_MESSAGE3 = '該插件需要 Geeklog Version 1.4 及以後的版本。升級中斷。';
$PLG_filemgmt_MESSAGE4 = '該插件 version 1.5 用的代碼未被檢出。升級中斷。';
$PLG_filemgmt_MESSAGE5 = '文件管理插件的升級中斷。<br>現在的插件版本不是1.3。';


// Language variables used by the plugin - general users access code.

define("_MD_THANKSFORINFO","感謝您提供此信息。我們將立刻調查您的請求。");
define("_MD_BACKTOTOP","返回下載首頁");
define("_MD_THANKSFORHELP","非常感謝您維護本目錄的完整性。");
define("_MD_FORSECURITY","出于安全的考慮，您的用戶名和IP地址將被臨時性記錄。");

define("_MD_SEARCHFOR","檢索對象");
define("_MD_MATCH","一致");
define("_MD_ALL","全部");
define("_MD_ANY","任意一個");
define("_MD_NAME","名字");
define("_MD_DESCRIPTION","說明");
define("_MD_SEARCH","檢索");

define("_MD_MAIN","Main");
define("_MD_SUBMITFILE","提供文件");
define("_MD_POPULAR","次數");
define("_MD_NEW","New");
define("_MD_TOPRATED","最高排名");

define("_MD_NEWTHISWEEK","本週的新建文件");
define("_MD_UPTHISWEEK","本週被更新的文件");

define("_MD_POPULARITYLTOM","下載次數 (最少到最多)");
define("_MD_POPULARITYMTOL","下載次數 (最多到最少)");
define("_MD_TITLEATOZ","標題(A to Z)");
define("_MD_TITLEZTOA","標題(Z to A)");
define("_MD_DATEOLD","日期(舊文件在前)");
define("_MD_DATENEW","日期(新文件在前)");
define("_MD_RATINGLTOH","評價(最低到最高)");
define("_MD_RATINGHTOL","評價(最高到最低)");

define("_MD_NOSHOTS","無縮略圖");
define("_MD_EDITTHISDL","編輯下載文件");

define("_MD_LISTINGHEADING","<b>文件列表: 數據庫中有%s個文件。</b>");
define("_MD_LATESTLISTING","<b>最新列表:</b>");
define("_MD_DESCRIPTIONC","說明:");
define("_MD_EMAILC","Email: ");
define("_MD_CATEGORYC","類別: ");
define("_MD_LASTUPDATEC","最新更新: ");
define("_MD_DLNOW","請下載！");
define("_MD_VERSION","版本");
define("_MD_SUBMITDATE","日期");
define("_MD_DLTIMES","下載 %s 次");
define("_MD_FILESIZE","文件大小");
define("_MD_SUPPORTEDPLAT","支持的平台");
define("_MD_HOMEPAGE","主頁");
define("_MD_HITSC","下載次數: ");
define("_MD_RATINGC","評價: ");
define("_MD_ONEVOTE","1 投票");
define("_MD_NUMVOTES","(%s)");
define("_MD_NOPOST","無");
define("_MD_NUMPOSTS","投票數: %s");
define("_MD_COMMENTSC","評論: ");
define ("_MD_ENTERCOMMENT", "寫評論");
define("_MD_RATETHISFILE","評價該文件");
define("_MD_MODIFY","編輯");
define("_MD_REPORTBROKEN","報告文件破損");
define("_MD_TELLAFRIEND","告訴朋友");
define("_MD_VSCOMMENTS","讀評論/寫評論");
define("_MD_EDIT","編輯");

define("_MD_THEREARE","數據庫中有 %s 個文件。");
define("_MD_LATESTLIST","最新列表");

define("_MD_REQUESTMOD","下載文件編輯");
define("_MD_FILE","文件");
define("_MD_FILEID","文件ID: ");
define("_MD_FILETITLE","標題: ");
define("_MD_DLURL","下載URL: ");
define("_MD_HOMEPAGEC","主頁: ");
define("_MD_VERSIONC","版本: ");
define("_MD_FILESIZEC","文件大小: ");
define("_MD_NUMBYTES","%s 字節");
define("_MD_PLATFORMC","平台: ");
define("_MD_CONTACTEMAIL","聯絡E-mail: ");
define("_MD_SHOTIMAGE","縮略圖: ");
define("_MD_SENDREQUEST","發送請求");

define("_MD_VOTEAPPRE","感投票。");
define("_MD_THANKYOU","感謝您在 %s 投票。"); // %s is your site name
define("_MD_VOTEFROMYOU","您自己的輸入將幫助其他的訪問者判斷需要下載哪個文件。");
define("_MD_VOTEONCE","同一文件只接受一次投票。");
define("_MD_RATINGSCALE","評價基準是 1 (最低)到 10 (最高)。");
define("_MD_BEOBJECTIVE","請客觀評價。如果每個都是 1 或 10 ，這樣的排名顯得毫無作用。");
define("_MD_DONOTVOTE","您不能對自己提供的文件投票。");
define("_MD_RATEIT","提交評價");

define("_MD_INTFILEAT","%s 的熱點下載"); // %s is your site name
define("_MD_INTFILEFOUND","%s 上找到的熱點下載。"); // %s is your site name

define("_MD_RECEIVED","感謝您提供下載信息。");
define("_MD_WHENAPPROVED","您將收到一封批準電郵。");
define("_MD_SUBMITONCE","請只執行一次。");
define("_MD_APPROVED", "您提供的文件已被批準。");
define("_MD_ALLPENDING","所有的文件信息都處于未驗證狀態。");
define("_MD_DONTABUSE","用戶名與IP地址已被記錄。");
define("_MD_TAKEDAYS","您提供的文件/腳本可能要花費幾天時間才會被添加到我們的數據庫中。");

define("_MD_RANK","級別");
define("_MD_CATEGORY","類別");
define("_MD_HITS","下載次數");
define("_MD_RATING","評價");
define("_MD_VOTE","投票");

define("_MD_SEARCHRESULT4","檢索結果 <b>%s</b>:");
define("_MD_MATCHESFOUND","%s 件一致。");
define("_MD_SORTBY","排序基準:");
define("_MD_TITLE","標題");
define("_MD_DATE","日期");
define("_MD_POPULARITY","人氣");
define("_MD_CURSORTBY","文件排序基準: ");
define("_MD_FOUNDIN","找到:");
define("_MD_PREVIOUS","上一個");
define("_MD_NEXT","下一個");
define("_MD_NOMATCH","沒有與檢索條件一致的。");

define("_MD_TOP10","%s 最高10位"); // %s is a downloads category name
define("_MD_CATEGORIES","類別");

define("_MD_SUBMIT","提交");
define("_MD_CANCEL","取消");

define("_MD_BYTES","Bytes");
define("_MD_ALREADYREPORTED","您已提交了一個破損文件報告。");
define("_MD_MUSTREGFIRST","您沒有執行該操作的權限。<br>請登錄或注冊。");
define("_MD_NORATING","沒有選擇評價。");
define("_MD_CANTVOTEOWN","您不能對自己提供的文件投票。<br>所有的投票都將被記錄和討論。");

// Language variables used by the plugin - Admin code.

define("_MD_RATEFILETITLE","請記錄您的文件評價。");
define("_MD_ADMINTITLE","文件管理　管理者菜單");
define("_MD_UPLOADTITLE","文件管理 - 上載文件");
define("_MD_CATEGORYTITLE","列表 - 類別");
define("_MD_DLCONF","下載設定");
define("_MD_GENERALSET","文件管理設定");
define("_MD_ADDMODFILENAME","上載文件");
define ("_MD_ADDCATEGORYSNAP", "畫像: <small>(可選，僅頂層類別用)</small>");
define ("_MD_ADDIMAGENOTE", "(畫像高度限制 50)");
define("_MD_ADDMODCATEGORY","<b>類別:</b> 類別增加/修改/刪除");
define("_MD_DLSWAITING","等待下載許可");
define("_MD_BROKENREPORTS","破損文件報告");
define("_MD_MODREQUESTS","下載信息修正要求");
define("_MD_EMAILOPTION","文件被批準時的發送電郵: ");
define("_MD_COMMENTOPTION","允許評論:");
define("_MD_SUBMITTER","提供者: ");
define("_MD_DOWNLOAD","下載");
define("_MD_FILELINK","顯示全文");
define("_MD_SUBMITTEDBY","文件提供: ");
define("_MD_APPROVE","批準");
define("_MD_DELETE","刪除");
define("_MD_NOSUBMITTED","無新提交的下載文件");
define("_MD_ADDMAIN","增加主類別");
define("_MD_TITLEC","標題: ");
define("_MD_CATSEC", "可訪問用戶類別: ");
define("_MD_IMGURL","<br>畫像文件名 <font size='-2'> (位于 filemgmt_data/category_snaps - 畫像高度限制 50)</font>");
define("_MD_ADD","增加");
define("_MD_ADDSUB","增加子類別");
define("_MD_IN","于");
define("_MD_ADDNEWFILE","上載新文件");
define("_MD_MODCAT","修改類別");
define("_MD_MODDL","變更下載信息");
define("_MD_USER","用戶");
define("_MD_IP","IP地址");
define("_MD_USERAVG","用戶評價的平均值");
define("_MD_TOTALRATE","全部評價");
define("_MD_NOREGVOTES","非注冊用戶投票");
define("_MD_NOUNREGVOTES","沒有非注冊用戶的投票");
define("_MD_VOTEDELETED","投票數據已被刪除。");
define("_MD_NOBROKEN","無破損文件。");
define("_MD_IGNOREDESC","忽略(忽略該報告，僅刪除該報告條目)");
define("_MD_DELETEDESC","刪除(刪除<b>報告的下載文件條目</b>，並非真實文件)");
define("_MD_REPORTER","報告提出者");
define("_MD_FILESUBMITTER","文件提供者");
define("_MD_IGNORE","忽略");
define("_MD_FILEDELETED","文件已被刪除。");
define("_MD_FILENOTDELETED","記錄已被刪除，但文件未被刪除。<p>有多項記錄指向同一個文件。</p>");
define("_MD_BROKENDELETED","破損文件的報告已被刪除。");
define("_MD_USERMODREQ","用戶下載信息修改要求");
define("_MD_ORIGINAL","原始");
define("_MD_PROPOSED","提案");
define("_MD_OWNER","所有者: ");
define("_MD_NOMODREQ","無下載修改要求。");
define("_MD_DBUPDATED","數據庫已被更新。");
define("_MD_MODREQDELETED","已刪除修改要求。");
define("_MD_IMGURLMAIN","畫像(畫像高度限制 50): ");
define("_MD_PARENT","父類別:");
define("_MD_SAVE","保存變更");
define("_MD_CATDELETED","類別已被刪除。");
define("_MD_WARNING","警告: 您確定刪除該類別與類別內的全部文件/評論嗎？");
define("_MD_YES","是");
define("_MD_NO","否");
define("_MD_NEWCATADDED","已添加新類別。");
define("_MD_CONFIGUPDATED","設定已被保存。");
define("_MD_ERROREXIST","錯誤: 您提供的下載信息已存在于數據庫中。");
define("_MD_ERRORNOFILE","錯誤: 在數據庫中找不到文件。");  
define("_MD_ERRORTITLE","錯誤: 請輸入標題。");
define("_MD_ERRORDESC","錯誤: 請輸入說明。");
define("_MD_NEWDLADDED","新下載文件已被添加到數據庫中。");
define("_MD_NEWDLADDED_DUPFILE","警告: 文件重復。新下載文件已被添加到數據庫中。");
define("_MD_NEWDLADDED_DUPSNAP","警告: Snap重復。新下載文件已被添加到數據庫中。");
define("_MD_HELLO","您好，%s");
define("_MD_WEAPPROVED","我們已經批準了您提供的下載文件。文件名: ");
define("_MD_THANKSSUBMIT","謝謝您。");
define("_MD_UPLOADAPPROVED","您上載的文件已被批準。");
define("_MD_DLSPERPAGE","每頁顯示的文件數: ");
define("_MD_HITSPOP","下載多少次算有人氣: ");
define("_MD_DLSNEW","首頁上顯示的文件數: ");
define("_MD_DLSSEARCH","檢索結果中的下載文件數: ");
define("_MD_TRIMDESC","列表: ");
define("_MD_DLREPORT","限制訪問下載報告");
define("_MD_WHATSNEWDESC","開啟「最新下載」:");
define("_MD_SELECTPRIV","僅允許登錄的用戶訪問: ");
define("_MD_ACCESSPRIV","允許匿名的瀏覽者訪問: ");
define("_MD_UPLOADSELECT","允許登錄的用戶上載: ");
define("_MD_UPLOADPUBLIC","允許匿名用戶上載: ");
define("_MD_USESHOTS","顯示類別畫像: ");
define("_MD_IMGWIDTH","畫像寬度: ");
define("_MD_MUSTBEVALID","縮略圖必須是在 %s 目錄內的有效畫像文件(例如 shot.gif)。如果沒有畫像文件請保持空白。");
define("_MD_REGUSERVOTES","登錄用戶的投票(投票總數: %s)");
define("_MD_ANONUSERVOTES","未登錄用戶的投票(投票總數: %s)");
define("_MD_YOURFILEAT","您對 %s 的文件提供"); // this is an approved mail subject. %s is your site name
define("_MD_VISITAT","請瀏覽我們在 %s 下載區域。");
define("_MD_DLRATINGS","下載評價(投票總數: %s)");
define("_MD_CONFUPDATED","設定已被更新。");
define("_MD_NOFILES","無文件。");   

define("_MD_DIRFILES","保存文件的目錄：");
define("_MD_DIRTHUMBS","保存文件縮略圖的目錄：");
define("_MD_DIRCATTHUMBS","保存類別縮略圖的目錄：");
define("_MD_URLFILES","文件的URL：");
define("_MD_URLTHUMBS","文件縮略圖的URL：");
define("_MD_URLCATTHUMBS","類別縮略圖的URL：");
define("_MD_MODOPT","選項：");
define("_MD_OPTUPDATE","更新注冊日期");

// Additional Geeklog Defines
define("_MD_NOVOTE","還未被評價。");
define("_IFNOTRELOAD","如果頁面沒有被自動載入，請點擊<a href='%s'>這裡</a>。");
define("_GL_ERRORNOACCESS","錯誤: 無法訪問此文檔存儲區。");
define("_GL_ERRORNOUPLOAD","錯誤: 您沒有上載文件的權限。");
define("_GL_ERRORNOADMIN","錯誤: 該機能被限制使用。");
define("_GL_NOUSERACCESS","無法訪問文檔存儲區。");
define("_MD_ERRUPLOAD","文件管理: 無法上載。請檢查文件存儲目錄的讀寫權限。");
define("_MD_DLFILENAME","文件名: ");
define("_MD_REPLFILENAME","替代文件: ");
define("_MD_SCREENSHOT","畫像");
define("_MD_SCREENSHOT_NA","&nbsp;");
define("_MD_COMMENTSWANTED","歡迎評論");
define("_MD_CLICK2SEE","請點擊: ");
define("_MD_CLICK2DL","請點擊下載: ");
define("_MD_ORDERBY","排序: ");
define("_MD_ORDERBY","排序: ");
define("_MD_ORDERBY","排序: ");

define("_MD_DLTEMPFILE","下載以便預覽：");
define("_MD_TEMPFILE","臨時文件");
define("_MD_SUBMITNOTIFY","文件提供的通知");

// Localization of the Admin Configuration UI
$LANG_configsections['filemgmt'] = array(
    'label' => '文件管理',
    'title' => '文件管理的設定'
);

$LANG_confignames['filemgmt'] = array(
    'mydownloads_popular'         => '熱門文件的閱覽數閥值',
    'mydownloads_newdownloads'    => '首頁上新到文件的顯示數',
    'mydownloads_perpage'         => '每頁顯示的文件數',

    'mydownloads_dlreport'        => '限制閱覽下載履歷',
    'mydownloads_trimdesc'        => '在文件列表中顯示一部分說明',
    'mydownloads_whatsnew'        => '顯示新到信息列表',

    'mydownloads_selectpriv'      => '允許 \'Logged-In Users\' 下載',
    'mydownloads_uploadselect'    => '允許 Logged-In 上載',
    'mydownloads_publicpriv'      => '允許匿名訪客下載',
    'mydownloads_uploadpublic'    => '允許匿名訪客上載',

    'mydownloads_useshots'        => '顯示類別圖標',
    'mydownloads_shotwidth'       => '縮略圖寬',
    'filemgmt_Emailoption'        => '當文件被批準時發送電郵',

    'filemgmt_FileStore'       => '下載文件',
    'filemgmt_SnapStore'       => '下載文件縮略圖',
    'filemgmt_SnapCat'         => '目錄縮略圖',
    'filemgmt_FileStoreURL'    => '下載文件',
    'filemgmt_FileSnapURL'     => '下載文件縮略圖',
    'filemgmt_SnapCatURL'      => '目錄縮略圖',
);

$LANG_configsubgroups['filemgmt'] = array(
    'sg_main' => '主設定'
);

$LANG_fs['filemgmt'] = array(
    'fs_main'            => '文件管理的主設定',
    'fs_path'            => '文件倉庫路徑',
    'fs_url'             => '文件倉庫的URL'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['filemgmt'] = array(
    0 => array('是' => 1, '否' => 0)
);

?>
