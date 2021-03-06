<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | chinese_simplified_utf-8.php                                              |
// |                                                                           |
// | Chinese language file for the Geeklog installation script                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Mark Limburg       - mlimburg AT users DOT sourceforge DOT net   |
// |          Jason Whittenburg  - jwhitten AT securitygeeks DOT com           |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Randy Kolenko      - randy AT nextide DOT ca				       |
// |          Matt West          - matt AT mattdanger DOT net			       |
// |		  Samuel Maung Stone - sam AT stonemicro DOT com                   |
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

// +---------------------------------------------------------------------------+

$LANG_CHARSET = 'utf-8';

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANG_NAME[XX]: $LANG - variable name                                     |
// |                 NAME  - where array is used                               |
// |                 XX    - phrase id number                                  |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+
// install.php

$LANG_INSTALL = array(
    0 => 'Geeklog -- 安全的內容管理系統',
    1 => '安裝支援',
    2 => '安全的內容管理系統',
    3 => '安裝Geeklog',
    4 => '需要PHP %s以上',
    5 => '對不起，安裝Geeklog需要PHP %s及以上（現在的版本是',
    6 => '）。請 <a href="http://www.php.net/downloads.php">升級PHP</a>或請您的主機提供商提供幫助。',
    7 => '找不到Geeklog文件',
    8 => '安裝系統無法找到關鍵的Geeklog文件。可能它們已從既定的位置移走。請在下面的文本框中指定文件的路徑：',
    9 => '歡迎！謝謝您選擇Geeklog！',
    10 => '文件/目錄',
    11 => '權限',
    12 => '推薦值',
    13 => '目前',
    14 => '',
    15 => 'Geeklog的標題（RSS）功能關閉。<code>backend</code>目錄的測試無法實施。',
    16 => '移植',
    17 => '用戶照片功能關閉。<code>userphotos</code>目錄的測試無法實施。',
    18 => '文章中添加圖像的功能關閉。<code>articles</code>目錄的測試無法實施。',
    19 => 'Geeklog中，若幹文件和目錄需要擁有被Web服務器寫入的權限。以下指出了必須更改權限的文件和目錄。',
    20 => '注意！',
    21 => '除非您解決上述問題，您的站點將無法正常動作。在進入下一步之前，請做必要的修正。',
    22 => '不明',
    23 => '請選擇安裝種類：',
    24 => '全新安裝',
    25 => '升級',
    26 => '無法更改：',
    27 => '。您確定文件能被Web服務器寫入嗎？',
    28 => 'siteconfig.php。該文件能被Web服務器寫入嗎？',
    29 => 'Geeklog站點',
    30 => '另一個俏皮的Geeklog站點',
    31 => '必要的設定信息',
    32 => '網站名',
    33 => '網站標語',
    34 => '數據庫類型',
    35 => 'MySQL',
    36 => 'MySQL（支持InnoDB表）',
    37 => 'Microsoft SQL',
    38 => '錯誤',
    39 => '數據庫主機名',
    40 => '數據庫名',
    41 => '數據庫用戶名',
    42 => '數據庫密碼',
    43 => '數據庫表的前綴',
    44 => '可選項目',
    45 => '網站的URL',
    46 => '（不要附加末尾的斜槓）',
    47 => 'Admin目錄的路徑',
    48 => '網站的電子郵件地址',
    49 => '網站的No-Reply（無需回復）電郵地址',
    50 => '安裝',
    51 => '需要MySQL %s及以上',
    52 => '很遺憾，Geeklog需要MySQL %s及以上版本（目前的版本是 ',
    53 => '）。請<a href="http://dev.mysql.com/downloads/mysql/">自行升級MySQL</a>或請您的主機服務提供商幫助解決。',
    54 => '數據庫信息不正確',
    55 => '對不起，您輸入的數據庫信息不正確。請返回修改。',
    56 => '無法連接到數據庫',
    57 => '對不起，安裝系統無法找到您指定的數據庫。數據庫尚未建立或您拼錯了（大小寫等）。請返回修改。',
    58 => '。該文件能被Web服務器寫入嗎？',
    59 => '注意：',
    60 => '使用中的MySQL版本不支持InnoDB表。放棄支持InnoDB，繼續安裝嗎？',
    61 => '返回',
    62 => '下一步',
    63 => 'Geeklog的數據庫已存在。系統無法在已存在的數據庫上做全新安裝。如要繼續，請進行以下二選一操作：',
    64 => '手工操作： a)刪除該數據庫中所有Geeklog生成的表。 b)或刪除該數據庫，重建一個新的。 之後，點擊下面的“重試“按鈕。',
    65 => '點擊下面的“升級“，執行數據庫升級（到Geeklog的新版本）操作。',
    66 => '重試',
    67 => '在設定Geeklog的數據庫過程中發生錯誤',
    68 => '數據庫不是空的，請先刪除數據庫中的所有表，再重試。',
    69 => '升級Geeklog',
    70 => '開始前請備份目前的Geeklog數據庫。因安裝腳本會修改Geeklog的數據庫，萬一升級失敗，您可以用備份來還原系統。我已經警告過你了喲。',
    71 => '請在下面選擇選擇當前的Geeklog的版本。安裝腳本將從您輸入的版本號開始一點一點地升級（即能夠從任意的老版本開始升級到緊接著的下一版本：',
    72 => '）。',
    73 => '請注意，安裝腳本不能升級Geeklog的Beta版或RC版。',
    74 => '數據庫已為最新狀態！',
    75 => '看來數據庫已經是最新狀態了。也許以前已經升級過。如果您覺得有必要再執行升級，請先將數據庫用備份恢復到舊版本。',
    76 => '選擇當前的Geeklog的版本',
    77 => '安裝系統無法判定當前的Geeklog版本，請從以下列表中選擇：',
    78 => '升級錯誤',
    79 => 'Geeklog在升級過程中發生錯誤。',
    80 => '更改',
    81 => '等一下！',
    82 => '必須更改下面列舉的文件的權限。在更改之前Geeklog無法安裝。',
    83 => '安裝錯誤',
    84 => '路徑 "',
    85 => '" 好像不對。請返回修改。',
    86 => '語言',
    87 => 'http://www.geeklog.net/forum/index.php?forum=1',
    88 => '請變更至含有以下文件的目錄：',
    89 => '當前版本：',
    90 => '數據庫為空？',
    91 => '數據庫為空或輸入的數據庫信息不正確。也許您不是要升級而是要進行全新安裝對嗎。請返回修改。',
    92 => '使用UTF-8',
    93 => '成功',
    94 => '尋找正確路徑的提示：',
    95 => '安裝腳本的完整路徑是：',
    96 => '安裝腳本在這裡正在找 %s ：',
    97 => '權限設定',
    98 => '高級用戶',
    99 => '如果您能用命令行訪問Web服務器（例如SSH）， 為節省時間起見，您可以復制並粘貼以下命令：',
    100 => '指定了無效的模式',
    101 => '步驟',
    102 => '輸入配置信息',
    103 => '並追加配置插件',
    104 => '不正確的管理員目錄路徑',
    105 => '對不起，您輸入的管理員目錄路徑不正確。請修改後重試。',
    106 => 'PostgreSQL',
    107 => '數據庫的密碼是必要的。',
    108 => '沒有數據庫驅動程序！'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => '安裝完成',
    1 => 'Geeklog ',
    2 => ' 的安裝完成！',
    3 => '恭喜。Geeklog',
    4 => '成功了。請注意閱讀下面的信息。',
    5 => '要登錄新Geeklog站點，請使用以下帳號：',
    6 => '用戶名:',
    7 => 'Admin',
    8 => '密碼:',
    9 => 'password',
    10 => '安全警告',
    11 => '請勿忘執行以下',
    12 => '項',
    13 => '刪除或重命名 install 目錄：',
    14 => '更改',
    15 => '的帳戶密碼。',
    16 => '設定',
    17 => '和',
    18 => '的權限為：',
    19 => '<strong>注意：</strong> 因安全模式已改變， 新的網站管理帳戶已生成。 該帳戶用戶名是 <b>NewAdmin</b> ，密碼是 <b>password</b> 。',
    20 => '安裝',
    21 => '升級',
    22 => '已移植'
);

// +---------------------------------------------------------------------------+
// migrate.php

$LANG_MIGRATE = array(
    0 => '在備份文件中加入了“DROP TABLE"的情況下，即使有同名的表也能被覆蓋。',
    1 => '在執行之前',
    2 => '請確定原站點的插件已經復制到新的服務器上。',
    3 => '請確定圖片目錄<code>public_html/images/articles/</code>， <code>public_html/images/topics/</code>和<code>public_html/images/userphotos/</code>已經被轉移到新服務器上。',
    4 => '從<strong>1.5.0</strong>以前的版本升級的場合， 請復制原<tt>config.php</tt>文件。移植後系統能參照該文件進行設定。',
    5 => '升級的場合，請勿照原樣上載theme。 請先使用缺省theme，直到確信移植完全成功了。',
    6 => '選擇備份文件',
    7 => '選擇文件...',
    8 => '從服務器上的backups目錄',
    9 => '從您的電腦',
    10 => '選擇文件...',
    11 => '未找到備份文件',
    12 => '該服務器的上載限制為',
    13 => '。 如果備份文件大于',
    14 => '或上載超時，請用FTP將備份文件上載到服務器上。',
    15 => '備份文件目錄不可被Web服務器寫入， 目錄權限需要設定為777。',
    16 => '移植',
    17 => '從備份文件移植',
    18 => '沒有選中備份文件。',
    19 => '未保存',
    20 => ' 至 ',
    21 => '文件',
    22 => '已經存在。 覆蓋已有的嗎？',
    23 => '是',
    24 => '否',
    25 => '',
    26 => '移植通知：',
    27 => '"',
    28 => '" 插件丟失且功能關閉。 您可以在任何時候重新安裝並啟用該插件。',
    29 => '圖片 "',
    30 => '" 的之中的 "',
    31 => '" 表在這裡 ',
    32 => '該數據庫文件中，存在一個或多個插件，移植腳本無法確定',
    33 => '目錄的位置和進行配置。因此插件被關閉。 您可以在任何時候重新安裝並啟用該插件。',
    34 => '該數據庫文件',
    35 => '中，存在用移植腳本無法配置目錄的插件信息。 詳細情況請參考<code>error.log</code>。',
    36 => '您可以在任何時候修正',
    37 => '移植完畢',
    38 => '移植作業完畢。 然而，安裝腳本發現了下面一些問題：',
    39 => '沒有找到PEAR。 在沒有PEAR的情況下， 無法處理壓縮的數據庫備份文件。',
    40 => '壓縮文件 \'%s\' 中似乎不含有任何SQL文件。',
    41 => '從壓縮的備份文件中解壓縮數據庫文件 \'%s\' 時發生錯誤。',
    42 => '備份文件 \'%s\' 不見了 ...',
    43 => '導入中止: 文件 \'%s\' 看起來不像是一個SQL類型的文件。',
    44 => '致命錯誤: 數據庫導入失敗。 無法繼續。',
    45 => '無法識別數據庫的版本，請手動升級。',
    46 => '',
    47 => '數據庫從版本 %s 升級到 %s 失敗。',
    48 => '存在一個或多個插件無法升級。請將這些插件關閉。',
    49 => '使用當前數據庫中的數據'
);

// +---------------------------------------------------------------------------+
// install-plugins.php

$LANG_PLUGINS = array(
    1 => '插件安裝',
    2 => '步驟',
    3 => '插件與addon組件極大地豐富了Geeklog的機能。 在缺省狀態下，Geeklog已經包含了一些可能對您有用的插件。',
    4 => '此外，您也可以上載其他的插件。',
    5 => '您上載的文件不是ZIP或GZip壓縮格式的插件文件。',
    6 => '您上載的插件已存在！',
    7 => '成功！',
    8 => '%s 插件上載成功。',
    9 => '上載插件',
    10 => '選擇插件文件',
    11 => '上載',
    12 => '選擇安裝插件',
    13 => '安裝',
    14 => '插件',
    15 => '版本',
    16 => '不明',
    17 => '注意',
    18 => '該插件必須在插件管理面板上手動啟用。',
    19 => '刷新',
    20 => '沒有新插件。'
);

// +---------------------------------------------------------------------------+
// bigdump.php

$LANG_BIGDUMP = array(
    0 => '開始導入',
    1 => ' 備份文件名 ',
    2 => ' 數據庫名：',
    3 => ' 數據庫主機名：',
    4 => 'seek不可 ',
    5 => 'open不可 ',
    6 => ' 導入。',
    7 => '預料外錯誤: 起始位置與偏移量為非數字值',
    8 => '處理中 文件:',
    9 => '無法移動文件指針至文件末尾。',
    10 => '無法移動文件指針至偏移值: ',
    11 => '在此行中止： ',
    12 => '。此處的current query來自csv文件，但',
    13 => '沒有被設置。',
    14 => '在此行中止：',
    15 => '。 此處的current query包含',
    16 => '行以上。如果您的導出文件的各查詢語句末尾，在換行前沒有加上分號（;），就會發生這種情況。還有一種可能是在您的導出文件中含擴展多個INSERT語句。請閱讀BigDump的FAQs來了解詳情。',
    17 => '錯誤發生的行號：',
    18 => '查詢: ',
    19 => 'MySQL: ',
    20 => '無法讀取文件指針的偏移量。',
    21 => '無法操作gzip格式壓縮的文件',
    22 => '處理狀況',
    23 => '該數據庫的移植正常完成！',
    24 => '待機中 ',
    25 => ' 毫秒</b> 至下一節開始...',
    26 => '導入中止',
    27 => '中止導入。',
    28 => '請稍等至導入完成。',
    29 => '出錯。',
    30 => '從頭開始',
    31 => '(在重新開始前，請DROP掉舊的表)'
);

// +---------------------------------------------------------------------------+
// Error Messages

$LANG_ERROR = array(
    0 => '上載文件大小超過了upload_max_filesize（定義在php.ini文件中）。 請使用其他方法，比如FTP來上載。',
    1 => '上載文件大小超過了MAX_FILE_SIZE（HTML表單中定義）。請使用其他方法，比如FTP來上載。',
    2 => '文件僅上載了一部分。',
    3 => '文件沒有上載。',
    4 => '臨時文件夾缺失。',
    5 => '寫磁盤錯誤。',
    6 => '由于文件擴展名的限制，上載中止。',
    7 => '文件大小超過了post_max_size（定義在php.ini文件中）。 請使用其他方法來上載您的數據庫文件，比如FTP。',
    8 => '錯誤',
    9 => '數據庫連接錯誤:',
    10 => '請檢查您的數據庫設定。'
);

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => '安裝幫助',
    'site_name' => '輸入您的網站名稱。今後可以更改。',
    'site_slogan' => '輸入您網站的標語（簡要描述）。今後可以更改。',
    'db_type' => '輸入數據庫的類型。請在MySQL、MySQL(InnoDB)和Microsoft SQL數據庫中選擇。如果您不能肯定選哪一個，請聯系您的主機服務提供商。</p><p class="indent"><strong>注意：</strong>InnoDB表也許可以優化大規模數據庫的性能，但會使備份變得困難。',
    'db_host' => '輸入數據庫的主機名（或IP地址）。',
    'db_name' => '輸入數據庫名。',
    'db_user' => '輸入數據庫用戶名。',
    'db_pass' => '輸入數據庫用戶密碼。',
    'db_prefix' => '輸入表名的前綴。如果您的數據庫中已經有了以“gl_”做前綴的表，請更改為一個獨一無二的前綴。在其他大多數情況下，沒有必要更改。',
    'site_url' => '輸入網站的URL。',
    'site_admin_url' => '輸入Admin目錄的URL。某些主機服務提供商預先設定了叫做admin的管理目錄，在這樣的情況下，請將Geeklog的admin目錄重命名，並修改一下該URL。 在其他大多數情況下沒有必要更改。',
    'site_mail' => '輸入網站管理員的email地址。該地址將作為Geeklog系統寄出email時的回復地址。',
    'noreply_mail' => '輸入網站管理員的No-Reply（不接受回復的）電郵地址。用戶注冊時，系統將使用該電郵地址通知用戶。',
    'utf8' => '指定網站的默認語言為UTF-8。 在國際化的大趨勢下，推薦使用。',
    'migrate_file' => '請選擇您要移植的備份文件（*.sql）。 您可以從"backups"目錄中選擇，或從您的電腦上載。 或者，也可以移植數據庫中當前的內容。',
    'plugin_upload' => '請選擇插件的壓縮文件（.zip、 .tar.gz、 .tgz格式）上載並安裝。'
);

// which texts to use as labels, so they don't have to be translated again
$LANG_LABEL = array(
    'site_name'      => $LANG_INSTALL[32],
    'site_slogan'    => $LANG_INSTALL[33],
    'db_type'        => $LANG_INSTALL[34],
    'db_host'        => $LANG_INSTALL[39],
    'db_name'        => $LANG_INSTALL[40],
    'db_user'        => $LANG_INSTALL[41],
    'db_pass'        => $LANG_INSTALL[42],
    'db_prefix'      => $LANG_INSTALL[43],
    'site_url'       => $LANG_INSTALL[45],
    'site_admin_url' => $LANG_INSTALL[47],
    'site_mail'      => $LANG_INSTALL[48],
    'noreply_mail'   => $LANG_INSTALL[49],
    'utf8'           => $LANG_INSTALL[92],
    'migrate_file'   => $LANG_MIGRATE[6],
    'plugin_upload'  => $LANG_PLUGINS[10]
);

?>
