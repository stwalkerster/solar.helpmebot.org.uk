<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class Page404 extends PageBase
{
	protected function runPage()
	{
		$this->mHeaders[] = "HTTP/1.0 404 Not Found";
		$this->mPageTitle = "404 Not Found";
		$this->mSmarty->assign("content", "404page.tpl");
	}
}
