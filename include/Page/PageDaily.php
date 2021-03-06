<?php

class PageDaily extends PageBase
{
	
	protected function runPage()
	{
	
	
		$params = array();
		$query = 'SELECT TIME(timestamp) AS x, generation as y FROM `solar`.`hourlydata` WHERE timestamp LIKE :yesterday;';

		for ($i = (-1 ); $i > (-8); $i--) {		
			$yesterday = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+ $i,date("Y"))) ;
			$params[] = $yesterday;
		}
		
		$graphs = PageBase::createGraph($query, $params, "daybig", 900,504);
	
		$this->mSmarty->assign('graphlisttitle', "Last 7 days power generation");
		$this->mSmarty->assign('graphlist', $graphs);
		$this->mSmarty->assign('content', 'GraphList.tpl');
	}
}