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
    0 => 'Geeklog -- 安全的内容管理系统',
    1 => '安装支援',
    2 => '安全的内容管理系统',
    3 => '安装Geeklog',
    4 => '需要PHP %s以上',
    5 => '对不起，安装Geeklog需要PHP %s及以上（现在的版本是',
    6 => '）。请 <a href="http://www.php.net/downloads.php">升级PHP</a>或请您的主机提供商提供帮助。',
    7 => '找不到Geeklog文件',
    8 => '安装系统无法找到关键的Geeklog文件。可能它们已从既定的位置移走。请在下面的文本框中指定文件的路径：',
    9 => '欢迎！谢谢您选择Geeklog！',
    10 => '文件/目录',
    11 => '权限',
    12 => '推荐值',
    13 => '目前',
    14 => '',
    15 => 'Geeklog的标题（RSS）功能关闭。<code>backend</code>目录的测试无法实施。',
    16 => '移植',
    17 => '用户照片功能关闭。<code>userphotos</code>目录的测试无法实施。',
    18 => '文章中添加图像的功能关闭。<code>articles</code>目录的测试无法实施。',
    19 => 'Geeklog中，若干文件和目录需要拥有被Web服务器写入的权限。以下指出了必须更改权限的文件和目录。',
    20 => '注意！',
    21 => '除非您解决上述问题，您的站点将无法正常动作。在进入下一步之前，请做必要的修正。',
    22 => '不明',
    23 => '请选择安装种类：',
    24 => '全新安装',
    25 => '升级',
    26 => '无法更改：',
    27 => '。您确定文件能被Web服务器写入吗？',
    28 => 'siteconfig.php。该文件能被Web服务器写入吗？',
    29 => 'Geeklog站点',
    30 => '另一个俏皮的Geeklog站点',
    31 => '必要的设定信息',
    32 => '网站名',
    33 => '网站标语',
    34 => '数据库类型',
    35 => 'MySQL',
    36 => 'MySQL（支持InnoDB表）',
    37 => 'Microsoft SQL',
    38 => '错误',
    39 => '数据库主机名',
    40 => '数据库名',
    41 => '数据库用户名',
    42 => '数据库密码',
    43 => '数据库表的前缀',
    44 => '可选项目',
    45 => '网站的URL',
    46 => '（不要附加末尾的斜杠）',
    47 => 'Admin目录的路径',
    48 => '网站的电子邮件地址',
    49 => '网站的No-Reply（无需回复）电邮地址',
    50 => '安装',
    51 => '需要MySQL %s及以上',
    52 => '很遗憾，Geeklog需要MySQL %s及以上版本（目前的版本是 ',
    53 => '）。请<a href="http://dev.mysql.com/downloads/mysql/">自行升级MySQL</a>或请您的主机服务提供商帮助解决。',
    54 => '数据库信息不正确',
    55 => '对不起，您输入的数据库信息不正确。请返回修改。',
    56 => '无法连接到数据库',
    57 => '对不起，安装系统无法找到您指定的数据库。数据库尚未建立或您拼错了（大小写等）。请返回修改。',
    58 => '。该文件能被Web服务器写入吗？',
    59 => '注意：',
    60 => '使用中的MySQL版本不支持InnoDB表。放弃支持InnoDB，继续安装吗？',
    61 => '返回',
    62 => '下一步',
    63 => 'Geeklog的数据库已存在。系统无法在已存在的数据库上做全新安装。如要继续，请进行以下二选一操作：',
    64 => '手工操作： a)删除该数据库中所有Geeklog生成的表。 b)或删除该数据库，重建一个新的。 之后，点击下面的“重试“按钮。',
    65 => '点击下面的“升级“，执行数据库升级（到Geeklog的新版本）操作。',
    66 => '重试',
    67 => '在设定Geeklog的数据库过程中发生错误',
    68 => '数据库不是空的，请先删除数据库中的所有表，再重试。',
    69 => '升级Geeklog',
    70 => '开始前请备份目前的Geeklog数据库。因安装脚本会修改Geeklog的数据库，万一升级失败，您可以用备份来还原系统。我已经警告过你了哟。',
    71 => '请在下面选择选择当前的Geeklog的版本。安装脚本将从您输入的版本号开始一点一点地升级（即能够从任意的老版本开始升级到紧接着的下一版本：',
    72 => '）。',
    73 => '请注意，安装脚本不能升级Geeklog的Beta版或RC版。',
    74 => '数据库已为最新状态！',
    75 => '看来数据库已经是最新状态了。也许以前已经升级过。如果您觉得有必要再执行升级，请先将数据库用备份恢复到旧版本。',
    76 => '选择当前的Geeklog的版本',
    77 => '安装系统无法判定当前的Geeklog版本，请从以下列表中选择：',
    78 => '升级错误',
    79 => 'Geeklog在升级过程中发生错误。',
    80 => '更改',
    81 => '等一下！',
    82 => '必须更改下面列举的文件的权限。在更改之前Geeklog无法安装。',
    83 => '安装错误',
    84 => '路径 "',
    85 => '" 好像不对。请返回修改。',
    86 => '语言',
    87 => 'http://www.geeklog.net/forum/index.php?forum=1',
    88 => '请变更至含有以下文件的目录：',
    89 => '当前版本：',
    90 => '数据库为空？',
    91 => '数据库为空或输入的数据库信息不正确。也许您不是要升级而是要进行全新安装对吗。请返回修改。',
    92 => '使用UTF-8',
    93 => '成功',
    94 => '寻找正确路径的提示：',
    95 => '安装脚本的完整路径是：',
    96 => '安装脚本在这里正在找 %s ：',
    97 => '权限设定',
    98 => '高级用户',
    99 => '如果您能用命令行访问Web服务器（例如SSH）， 为节省时间起见，您可以复制并粘贴以下命令：',
    100 => '指定了无效的模式',
    101 => '步骤',
    102 => '输入配置信息',
    103 => '并追加配置插件',
    104 => '不正确的管理员目录路径',
    105 => '对不起，您输入的管理员目录路径不正确。请修改後重试。',
    106 => 'PostgreSQL',
    107 => '数据库的密码是必要的。',
    108 => '没有数据库驱动程序！'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => '安装完成',
    1 => 'Geeklog ',
    2 => ' 的安装完成！',
    3 => '恭喜。Geeklog',
    4 => '成功了。请注意阅读下面的信息。',
    5 => '要登录新Geeklog站点，请使用以下帐号：',
    6 => '用户名:',
    7 => 'Admin',
    8 => '密码:',
    9 => 'password',
    10 => '安全警告',
    11 => '请勿忘执行以下',
    12 => '项',
    13 => '删除或重命名 install 目录：',
    14 => '更改',
    15 => '的帐户密码。',
    16 => '设定',
    17 => '和',
    18 => '的权限为：',
    19 => '<strong>注意：</strong> 因安全模式已改变， 新的网站管理帐户已生成。 该帐户用户名是 <b>NewAdmin</b> ，密码是 <b>password</b> 。',
    20 => '安装',
    21 => '升级',
    22 => '已移植'
);

// +---------------------------------------------------------------------------+
// migrate.php

$LANG_MIGRATE = array(
    0 => '在备份文件中加入了“DROP TABLE"的情况下，即使有同名的表也能被覆盖。',
    1 => '在执行之前',
    2 => '请确定原站点的插件已经复制到新的服务器上。',
    3 => '请确定图片目录<code>public_html/images/articles/</code>， <code>public_html/images/topics/</code>和<code>public_html/images/userphotos/</code>已经被转移到新服务器上。',
    4 => '从<strong>1.5.0</strong>以前的版本升级的场合， 请复制原<tt>config.php</tt>文件。移植後系统能参照该文件进行设定。',
    5 => '升级的场合，请勿照原样上载theme。 请先使用缺省theme，直到确信移植完全成功了。',
    6 => '选择备份文件',
    7 => '选择文件...',
    8 => '从服务器上的backups目录',
    9 => '从您的电脑',
    10 => '选择文件...',
    11 => '未找到备份文件',
    12 => '该服务器的上载限制为',
    13 => '。 如果备份文件大于',
    14 => '或上载超时，请用FTP将备份文件上载到服务器上。',
    15 => '备份文件目录不可被Web服务器写入， 目录权限需要设定为777。',
    16 => '移植',
    17 => '从备份文件移植',
    18 => '没有选中备份文件。',
    19 => '未保存',
    20 => ' 至 ',
    21 => '文件',
    22 => '已经存在。 覆盖已有的吗？',
    23 => '是',
    24 => '否',
    25 => '',
    26 => '移植通知：',
    27 => '"',
    28 => '" 插件丢失且功能关闭。 您可以在任何时候重新安装并启用该插件。',
    29 => '图片 "',
    30 => '" 的之中的 "',
    31 => '" 表在这里 ',
    32 => '该数据库文件中，存在一个或多个插件，移植脚本无法确定',
    33 => '目录的位置和进行配置。因此插件被关闭。 您可以在任何时候重新安装并启用该插件。',
    34 => '该数据库文件',
    35 => '中，存在用移植脚本无法配置目录的插件信息。 详细情况请参考<code>error.log</code>。',
    36 => '您可以在任何时候修正',
    37 => '移植完毕',
    38 => '移植作业完毕。 然而，安装脚本发现了下面一些问题：',
    39 => '没有找到PEAR。 在没有PEAR的情况下， 无法处理压缩的数据库备份文件。',
    40 => '压缩文件 \'%s\' 中似乎不含有任何SQL文件。',
    41 => '从压缩的备份文件中解压缩数据库文件 \'%s\' 时发生错误。',
    42 => '备份文件 \'%s\' 不见了 ...',
    43 => '导入中止: 文件 \'%s\' 看起来不像是一个SQL类型的文件。',
    44 => '致命错误: 数据库导入失败。 无法继续。',
    45 => '无法识别数据库的版本，请手动升级。',
    46 => '',
    47 => '数据库从版本 %s 升级到 %s 失败。',
    48 => '存在一个或多个插件无法升级。请将这些插件关闭。',
    49 => '使用当前数据库中的数据'
);

// +---------------------------------------------------------------------------+
// install-plugins.php

$LANG_PLUGINS = array(
    1 => '插件安装',
    2 => '步骤',
    3 => '插件与addon组件极大地丰富了Geeklog的机能。 在缺省状态下，Geeklog已经包含了一些可能对您有用的插件。',
    4 => '此外，您也可以上载其他的插件。',
    5 => '您上载的文件不是ZIP或GZip压缩格式的插件文件。',
    6 => '您上载的插件已存在！',
    7 => '成功！',
    8 => '%s 插件上载成功。',
    9 => '上载插件',
    10 => '选择插件文件',
    11 => '上载',
    12 => '选择安装插件',
    13 => '安装',
    14 => '插件',
    15 => '版本',
    16 => '不明',
    17 => '注意',
    18 => '该插件必须在插件管理面板上手动启用。',
    19 => '刷新',
    20 => '没有新插件。'
);

// +---------------------------------------------------------------------------+
// bigdump.php

$LANG_BIGDUMP = array(
    0 => '开始导入',
    1 => ' 备份文件名 ',
    2 => ' 数据库名：',
    3 => ' 数据库主机名：',
    4 => 'seek不可 ',
    5 => 'open不可 ',
    6 => ' 导入。',
    7 => '预料外错误: 起始位置与偏移量为非数字值',
    8 => '处理中 文件:',
    9 => '无法移动文件指针至文件末尾。',
    10 => '无法移动文件指针至偏移值: ',
    11 => '在此行中止： ',
    12 => '。此处的current query来自csv文件，但',
    13 => '没有被设置。',
    14 => '在此行中止：',
    15 => '。 此处的current query包含',
    16 => '行以上。如果您的导出文件的各查询语句末尾，在换行前没有加上分号（;），就会发生这种情况。还有一种可能是在您的导出文件中含扩展多个INSERT语句。请阅读BigDump的FAQs来了解详情。',
    17 => '错误发生的行号：',
    18 => '查询: ',
    19 => 'MySQL: ',
    20 => '无法读取文件指针的偏移量。',
    21 => '无法操作gzip格式压缩的文件',
    22 => '处理状况',
    23 => '该数据库的移植正常完成！',
    24 => '待机中 ',
    25 => ' 毫秒</b> 至下一节开始...',
    26 => '导入中止',
    27 => '中止导入。',
    28 => '请稍等至导入完成。',
    29 => '出错。',
    30 => '从头开始',
    31 => '(在重新开始前，请DROP掉旧的表)'
);

// +---------------------------------------------------------------------------+
// Error Messages

$LANG_ERROR = array(
    0 => '上载文件大小超过了upload_max_filesize（定义在php.ini文件中）。 请使用其他方法，比如FTP来上载。',
    1 => '上载文件大小超过了MAX_FILE_SIZE（HTML表单中定义）。请使用其他方法，比如FTP来上载。',
    2 => '文件仅上载了一部分。',
    3 => '文件没有上载。',
    4 => '临时文件夹缺失。',
    5 => '写磁盘错误。',
    6 => '由于文件扩展名的限制，上载中止。',
    7 => '文件大小超过了post_max_size（定义在php.ini文件中）。 请使用其他方法来上载您的数据库文件，比如FTP。',
    8 => '错误',
    9 => '数据库连接错误:',
    10 => '请检查您的数据库设定。'
);

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => '安装帮助',
    'site_name' => '输入您的网站名称。今后可以更改。',
    'site_slogan' => '输入您网站的标语（简要描述）。今后可以更改。',
    'db_type' => '输入数据库的类型。请在MySQL、MySQL(InnoDB)和Microsoft SQL数据库中选择。如果您不能肯定选哪一个，请联系您的主机服务提供商。</p><p class="indent"><strong>注意：</strong>InnoDB表也许可以优化大规模数据库的性能，但会使备份变得困难。',
    'db_host' => '输入数据库的主机名（或IP地址）。',
    'db_name' => '输入数据库名。',
    'db_user' => '输入数据库用户名。',
    'db_pass' => '输入数据库用户密码。',
    'db_prefix' => '输入表名的前缀。如果您的数据库中已经有了以“gl_”做前缀的表，请更改为一个独一无二的前缀。在其他大多数情况下，没有必要更改。',
    'site_url' => '输入网站的URL。',
    'site_admin_url' => '输入Admin目录的URL。某些主机服务提供商预先设定了叫做admin的管理目录，在这样的情况下，请将Geeklog的admin目录重命名，并修改一下该URL。 在其他大多数情况下没有必要更改。',
    'site_mail' => '输入网站管理员的email地址。该地址将作为Geeklog系统寄出email时的回复地址。',
    'noreply_mail' => '输入网站管理员的No-Reply（不接受回复的）电邮地址。用户注册时，系统将使用该电邮地址通知用户。',
    'utf8' => '指定网站的默认语言为UTF-8。 在国际化的大趋势下，推荐使用。',
    'migrate_file' => '请选择您要移植的备份文件（*.sql）。 您可以从"backups"目录中选择，或从您的电脑上载。 或者，也可以移植数据库中当前的内容。',
    'plugin_upload' => '请选择插件的压缩文件（.zip、 .tar.gz、 .tgz格式）上载并安装。'
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