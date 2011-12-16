<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Hotel
{
	private $managementMode = false;

	public function run()
	{
		$this->setupEnvironment();
		$this->main();
		$this->cleanupEnvironment();
	}
	

	public static function exceptionHandler($exception)
	{
		$errorDocument = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>The Blackfish Hotel</title>
		<style type="text/css">
			img{margin:2px 3px;}
			#content{display:block;float:left;margin-left:15px;}
			#error{display:block;clear:both;font-size:x-small;}
			p{margin:0px;padding:0px;}
		</style>
	</head>
	<body>
		<img src="$2$" class="style1" height="65" style="float: left" width="234" />
		<div id="content">
			<h1>Oops! Something went wrong!</h1>
			<p>We'll work on fixing this for you, so why not come back later?</p>
		</div>
		<div id="error">
			<h3>The technical info:</h3>
			<pre>$1$</pre>
		</div>
	</body>
</html>
HTML;
		$message = "Unhandled " . $exception;
		
		ob_end_clean();
		
		global $cWebPath;
		
		print str_replace('$1$', $message, 
			str_replace('$2$', $cWebPath . '/images/bflogo.png' , $errorDocument)
			);
		die;
	}
	
	private static function autoLoader($class_name)
	{
		global $cIncludePath;
		require_once($cIncludePath . "/" . $class_name . ".php");
	}	

	private function checkPhpExtensions()
	{
		global $cRequiredExtensions;
		
		foreach($cRequiredExtensions as $ext)
		{
			if(!extension_loaded($ext))
			{
				throw new ExtensionUnavailableException($ext);
			}
		}
	}
	
	private function setupEnvironment()
	{
		global $cIncludePath;

		set_exception_handler(array("Hotel","exceptionHandler"));
			
		session_start();
	
		// check all the required PHP extensions are enabled on this SAPI
		$this->checkPhpExtensions();
	
		// start output buffering before anything is sent to the browser.
		ob_start();
	
		// not caught by the autoloader :(
		require_once('smarty/Smarty.class.php');

		// many exceptions defined in one file, let's not clutter stuff. 
		// This ofc breaks the autoloading, so let's include them all now.
		// (Depends on some smarty stuff)
		require_once($cIncludePath . "/_Exceptions.php");
		
		spl_autoload_register("Hotel::autoLoader");
			
		// can we tidy up the output with tidy before we send it?
		if(extension_loaded("tidy"))
		{ // Yes!
		
			global $cUseTidy;
			if($cUseTidy)
			{
				// register a new function to hook into the output bit
				Hooks::register("BeforeOutputSend", function($params) {
						$tidy = new Tidy();
						global $cTidyOptions;
						return $tidy->repairString($params[0], $cTidyOptions, "utf8");
					});
			}
		}
				
		global $gCookieJar;
		$gCookieJar = array();
	}
	
	protected function cleanupEnvironment()
	{
		// discard any extra content
		ob_end_clean();
	}
	
	protected function main()
	{
		$basePage = "PageBase";
	
		// create a page...
		$page = $basePage::create();
		
		// ...and execute it.
		$page->execute();
	}
}