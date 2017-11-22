<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'upgrade.inc') !== false) {
    die('This file can not be used on its own.');
}

//-----------------------------------------------------------------------------------
$curversion = DB_getItem($_TABLES['plugins'],'pi_version',"pi_name = 'japanize'");

$wk = explode('_', $curversion);
$curversion2 =$wk[0];

IF ($curversion2=="1.0.2") {
    profile_upgrade("mysql_1.0.2_to_1.0.3","1.0.3");
}

//-----------------------------------------------------------------------------------

// *****
function profile_upgrade($file,$upver) {
    global $_TABLES;
    global $_CONF;

    $_SQL =array();
    require_once ($_CONF['path']."plugins/japanize/sql/updates/{$file}.php");

    for ($i = 1; $i <= count($_SQL); $i++) {
        $w=current($_SQL);
        DB_query(current($_SQL));
        next($_SQL);

    }
    if (DB_error()) {
        COM_errorLog("error profile {$upver} versionup ",1);
        return false;
    }

    COM_errorLog("Success - profile {$upver} versionup",1);

    return 0;

}

?>