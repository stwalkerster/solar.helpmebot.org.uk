<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class PageMain extends PageBase
{
	protected function runPage()
	{
		$this->mBasePage = "home.tpl";
	}
}
