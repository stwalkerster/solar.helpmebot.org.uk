<?php

/**
 * Base page class
 *
 * @author Simon Walker
 *
 */
abstract class PageBase
{
	var $title = "Solar Power Generation Statistics";

	var $menu = array(
		'menuHome' => array(
			'link' => '/',
			'text' => 'Home',
		),
	);

	var $smarty;
	/**
	 * Page-specific code, performing the logic required on a page-specific level.
	 */
	abstract function runPage();

	/**
	 * Actually runs the page.
	 */
	function execute()
	{
		$this->smarty = new Smarty();

		global $s_templateDir, $s_compileDir, $s_configDir, $s_cacheDir, $s_configFile;

		$this->smarty->template_dir = $s_templateDir;
		$this->smarty->compile_dir = $s_compileDir;
		$this->smarty->config_dir = $s_configDir;
		$this->smarty->cache_dir = $s_cacheDir;

		$this->runPage();

		// assign settings that depend on a value that can be changed by the implemented page
		$this->smarty->assign('menu', $this->menu);
		$this->smarty->assign('documenttitle', $this->title);
		$this->smarty->assign('pagetitle', $this->title);

		$this->smarty->display('main.tpl');
	}

	/**
	 * Create a specific page, based on the Request URL
	 */
	static function create()
	{
		global $baseIncludePath;

		// calculate the name that the page definition should be at.
		$pageName = "Page" . PageBase::getPageName();

		// check the page definition actually exists...
		if(file_exists( $baseIncludePath . $pageName . ".php"))
		{	// ... and include it. If I'd not checked it existed, all code from this point on would fail.
			require_once( $baseIncludePath . $pageName . ".php");
		}
		else
		{
			// page definition doesn't exist, let's continue but showing the main page instead.
			$pageName = "PageMain";
			require_once( $baseIncludePath . $pageName . ".php");
		}

		// now I've brought the page definition class file into the script, let's actually check that
		// page definition class exists in that file.
		if(class_exists($pageName))
		{
			// create the page object
			$page = new $pageName;

			// check the newly created page object has inherits from PageBase class
			if(get_parent_class($page)=="PageBase")
			{
				// return the new page object
				return $page;
			}
			else
			{
				// oops. this is our class, named correctly, but it's a bad definition.
				die();
			}
		}
		else
		{
			// file exists, but no definition of the class
			die();
		}

	}

	static function getPageName()
	{
		if(!isset($_SERVER['PATH_INFO']))
			return 'Main';
			
		$pathInfo = $_SERVER['PATH_INFO'];
		$page = trim($pathInfo ,'/');
		if($page == "")
			return "Main";
			
		$pa = explode('/', $page);
			
		return $pa[0];
	}


}
