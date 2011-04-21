<?php

$dbusername = "solar";
$dbpassword = "";
$dbhost = "dbmaster";
$dbschema = "solar";

// the web-accessible folder where index.php is stored
$baseFilePath = "/";

// the real file path where index.php is stored
$baseScriptPath = "/var/www/solar.helpmebot.org.uk/";

$baseIncludePath = "/var/www/solar.helpmebot.org.uk/src/";

require_once("config.inc.php");

$s_cacheDir = $baseScriptPath . '/smartycache/';
$s_compileDir = $baseScriptPath . '/smartycompile/';
$s_templateDir = $baseScriptPath . '/template/';
$s_configDir = $baseScriptPath . '/smartyconfig/';


require_once($baseIncludePath . 'PageBase.php');
require_once($baseIncludePath . 'PageMain.php');
require_once($baseIncludePath . 'QueryBrowser.php');
require_once($baseScriptPath . 'smarty/Smarty.class.php');
require_once("graph/pChart/pData.class");   
require_once("graph/pChart/pChart.class");