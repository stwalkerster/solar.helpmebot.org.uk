<?php

class PageDaily extends PageBase
{
	
	protected function runPage()
	{
	
		$params = array();
		$query = 'SELECT TIME(timestamp) AS x, generation as y FROM `solar`.`hourlydata` WHERE timestamp LIKE :yesterday;';

		for ($i = -1; $i > -29; $i--) {		
			$yesterday = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+ $i,date("Y"))) ;
			$params[] = $yesterday;
		}
		
		$graphs = PageBase::createGraph($query, $params, "day");
	
		$this->mSmarty->assign('graphlisttitle', "Last 28 days power generation");
		$this->mSmarty->assign('graphlist', $graphs);
		$this->mSmarty->assign('content', 'MainPage.tpl');
	}
}