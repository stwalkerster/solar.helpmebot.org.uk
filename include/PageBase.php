<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

abstract class PageBase
{
	// array of extra (per-page) javascript files to add
	protected $mScripts = array();

	// array of extra (per-page) CSS stylesheets to add
	protected $mStyles = array();

	protected $mSmarty;

	// message containing the title of the page
	protected $mPageTitle = "Solar Power Generation Statistics";

	// base template to use
	protected $mBasePage = "base.tpl";

	// main menu
	protected $mMainMenu = array(
		/* Format:
			"Class name" => array(
				"title" => "Message name to display",
				"link" => "Link to show",
				),
			*/		
		"PageMain" => array(
			"title" => "Home",
			"link" => "/",
			),
		"PageDaily" => array(
			"title" => "Daily",
			"link" => "/Daily",
			),
		);
		
	// array of HTTP headers to add to the request.
	protected $mHeaders = array();

	protected function setupPage()
	{
		$this->mSmarty = new Smarty();


		$this->addSystemCssJs();
	}
	
	protected function finalSetup()
	{
		global $cGlobalScripts;
		$scripts = array_merge($cGlobalScripts, $this->mScripts);
		$this->mSmarty->assign("scripts",$scripts);

		global $cGlobalStyles;
		$styles = array_merge($cGlobalStyles, $this->mStyles);
		$this->mSmarty->assign("styles",$styles);

		$this->mSmarty->assign("pagetitle", $this->mPageTitle);

		// setup the current page on the menu, but only if the current page 
		// exists on the main menu in the first place
		if(array_key_exists(get_class($this), $this->mMainMenu))
		{
			$this->mMainMenu[get_class($this)]["current"] = true;
		}
		$this->mSmarty->assign("mainmenu", $this->mMainMenu);

		global $cWebPath, $cScriptPath;
		$this->mSmarty->assign("cWebPath", $cWebPath);
		$this->mSmarty->assign("cScriptPath", $cScriptPath);
		
		// sidebar
		global $gDatabase;
		$generationlist=array();
		$pdostmt = $gDatabase->prepare("SELECT * FROM dailydata ORDER BY date desc LIMIT 28;");
		$pdostmt->execute();
		foreach($pdostmt->fetchAll() as $row )
		{
			$generationlist[$row['date']] = $row['totalgenerated'];
		}
		$this->mSmarty->assign('generation', $generationlist);
	}
	
	/**
	 * Adds the "global" CSS / JS for this part of the system.
	 *
	 * This differs for the management side of the system, hence is overridden over there.
	 * This method is just to make it easier to override.
	 */
	protected function addSystemCssJs()
	{
		global $cWebPath;
		// $mStyles[] = $cWebPath . "/style/main.css";
		
	}
	
	public function execute()
	{
		// set up the page
		$this->setupPage();

		// "run" the page - allow the user to make any customisations to the
		// current state
		$this->runPage();

		// perform any final setup for the page, overwriting any user 
		// customisations which aren't allowed, and anything that potentially 
		// needs to be rebuilt/updated.
		$this->finalSetup();

		try
		{
			// get the page content
			$content = $this->mSmarty->fetch($this->mBasePage);
		}
		catch(SmartyException $ex)
		{
			if(strpos($ex->getMessage(), "Unable to load template file") !== false)
			{
				// throw our own exception so the stack trace comes back here.
				throw new SmartyTemplateNotFoundException(
					$ex->getMessage(),
					$ex->getCode()
					);
			}
		}
		
		// set any HTTP headers
		foreach($this->mHeaders as $h)
		{
			header($h);
		}
		
		// send the cookies to make the client smile and go mmmmm nom nom
		WebRequest::sendCookies();
		
		// send the output
		WebRequest::output($content);
	}

	protected abstract function runPage();

	public static function create()
	{
		// use "Main" as the default
		$page = "Main";

		// check the requested page title for safety and sanity
		
		$pathinfo = explode('/', WebRequest::pathInfo());
		$pathinfo = array_values(array_filter($pathinfo));
		if(
			count($pathinfo) >= 1 &&
			$pathinfo[0] != "" &&  // not empty
			(!ereg("[^a-zA-Z0-9]", $pathinfo[0])) // contains only alphanumeric chars
		)
		{
			$page = $pathinfo[0];
		}
		
		// okay, the page title should be reasonably safe now, let's try and make the page
		
		$pagename = "Page" . $page;
		
		global $cIncludePath;
		$filepath = $cIncludePath . "/Page/" . $pagename . ".php";
		
		if(file_exists($filepath))
			require_once($filepath);
		else
		{	// oops, couldn't find the requested page, let's fail gracefully.
			$pagename = "Page404";
			$filepath = $cIncludePath . "/Page/" . $pagename . ".php";
			require_once($filepath);
		}	

		if(class_exists($pagename))
		{
			$pageobject = new $pagename;
			
			if(get_parent_class($pageobject) == "PageBase")
				return $pageobject;
			else	// defined, but doesn't inherit properly, so we can't guarentee stuff will work.
				throw new Exception();
		}
		else // file exists, but the class "within" doesn't, this is a problem as stuff isn't where it should be.
			throw new Exception();
	}
	
	public static function createGraph($query, $parameters)
	{
		global $gDatabase;
		
		$q = $gDatabase->prepare($query);

		$imagehashes = array();

		foreach ($parameters as $p) {
			$DataSet = new pData();
			
			$modP = $p . "%";
			
			$q->bindParam(":yesterday", $modP);
			$q->execute();
			$qResult = $q->fetchAll();
			
			if(sizeof($qResult) > 0)
			{

				foreach($qResult as $row)
				{
					$DataSet->AddPoint($row['y'], $p, $row['x']);
				}

				$DataSet->AddPoint(
				array(
				"00:00", "", "", "", "", "",
				"01:00", "", "", "", "", "",
				"02:00", "", "", "", "", "",
				"03:00", "", "", "", "", "",
				"04:00", "", "", "", "", "",
				"05:00", "", "", "", "", "",
				"06:00", "", "", "", "", "",
				"07:00", "", "", "", "", "",
				"08:00", "", "", "", "", "",
				"09:00", "", "", "", "", "",
				"10:00", "", "", "", "", "",
				"11:00", "", "", "", "", "",
				"12:00", "", "", "", "", "",
				"13:00", "", "", "", "", "",
				"14:00", "", "", "", "", "",
				"15:00", "", "", "", "", "",
				"16:00", "", "", "", "", "",
				"17:00", "", "", "", "", "",
				"18:00", "", "", "", "", "",
				"19:00", "", "", "", "", "",
				"20:00", "", "", "", "", "",
				"21:00", "", "", "", "", "",
				"22:00", "", "", "", "", "",
				"23:00", "", "", "", "", "",
				),"XLabel");

				$DataSet->AddSerie($p);
				$DataSet->SetAbsciseLabelSerie("XLabel");

				$chartname = md5(serialize($DataSet));
				$imagehashes[] = array($chartname, $p);

				if(!file_exists($chartname . ".png"))
				{
					$Test = new pChart(500,280);
					$Test->setFontProperties("graph/Fonts/tahoma.ttf",8);
					$Test->setGraphArea(50,30,480,200);
					$Test->setFixedScale(0,3, 12);
					$Test->drawFilledRoundedRectangle(7,7,493,273,5,240,240,240);
					$Test->drawRoundedRectangle(5,5,495,275,5,230,230,230);
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
					$Test->drawTitle(50,22, $p,50,50,50,585);
					$Test->Render("render/" . $chartname . ".png");
				}
			}
		}

		return $imagehashes;

	}
}
