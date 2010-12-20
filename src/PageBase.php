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
		'Home' =>  '/',
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

	public static function createGraph($queries)
	{
		$qb = new QueryBrowser();
		
		$imagehashes = array();		
		
		foreach ($queries as $q) {
			$DataSet = new pData();
			$qResult = $qb->executeQueryToArray($q['query']);
			
			if(sizeof($qResult) > 0)
			{
			
				foreach($qResult as $row)
				{
					$DataSet->AddPoint($row['y'], $q['series'], $row['x']);
				}
	
				
				
				$DataSet->AddAllSeries();
				$DataSet->SetAbsciseLabelSerie();
				
				$chartname = md5(serialize($DataSet));
				$imagehashes[] = array($chartname, $q['series']);
				
				if(!file_exists($chartname))
				{
					$Test = new pChart(700,280);
					$Test->setFontProperties("graph/Fonts/tahoma.ttf",8);
					$Test->setGraphArea(50,30,680,200);
					$Test->drawFilledRoundedRectangle(7,7,693,273,5,240,240,240);
					$Test->drawRoundedRectangle(5,5,695,275,5,230,230,230);
					$Test->drawGraphArea(255,255,255,TRUE);
					$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,45,2);
					$Test->drawGrid(4,TRUE,230,230,230,50);
					
					// Draw the 0 line
					$Test->setFontProperties("graph/Fonts/tahoma.ttf",6);
					$Test->drawTreshold(0,143,55,72,TRUE,TRUE);
					
					// Draw the cubic curve graph
					$Test->drawFilledCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription(),.1,50);
					
					// Finish the graph
					$Test->setFontProperties("graph/Fonts/tahoma.ttf",10);
					$Test->drawTitle(50,22, $q['series'],50,50,50,585);
					$Test->Render("render/" . $chartname);
				}   
			}
		}		
		
		return $imagehashes;
		
	}
}
