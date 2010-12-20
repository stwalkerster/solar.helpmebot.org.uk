<?php
require_once("config.inc.php");

// the web-accessible folder where index.php is stored
$baseFilePath = "/";

// the real file path where index.php is stored
$baseScriptPath = "/var/www/solar/";

$baseIncludePath = "/var/www/solar/src/";


$s_cacheDir = $baseScriptPath . '/smartycache/';
$s_compileDir = $baseScriptPath . '/smartycompile/';
$s_templateDir = $baseScriptPath . '/template/';
$s_configDir = $baseScriptPath . '/smartyconfig/';

function __autoload($class)
{
	global $baseIncludePath;
	require_once($baseIncludePath.$class.".php");
}

require_once($baseScriptPath . 'smarty/Smarty.class.php');