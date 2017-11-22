<?php

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Initialize Navigation Manager plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_NAVM_CONF if available (e.g. from
* an old config.php), uses $_NAVM_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_forum()
{
    return true;
}

?>