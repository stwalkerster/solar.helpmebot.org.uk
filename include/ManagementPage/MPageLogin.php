<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class MPageLogin extends ManagementPageBase
{
	protected function runPage()
	{
		$this->mBasePage = "home.tpl";
	}
}
