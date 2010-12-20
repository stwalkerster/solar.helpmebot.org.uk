<?php

$smarty = new Smarty();
$smarty->template_dir = $s_templateDir;
$smarty->compile_dir = $s_compileDir;
$smarty->config_dir = $s_configDir;
$smarty->cache_dir = $s_cacheDir;

$smarty->display('main.tpl');