<?php

class PageMain extends PageBase
{
	
	protected function runPage()
	{
		$this->mSmarty->assign('content', 'main.tpl');
	}
}