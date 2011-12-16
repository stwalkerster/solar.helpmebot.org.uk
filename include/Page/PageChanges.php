<?php

class PageChanges extends PageBase
{
	protected function runPage()
	{
		$this->mSmarty->assign('content', 'Changes.tpl');
	}
}