<?php

class PageDailyHistorical extends PageBase
{
	
	protected function runPage()
	{
		$offset = WebRequest::get("offset");
		if($offset === false)
		{
			$offset = 0;
		}
	
		$realoffset = $offset * 17;
	
		$params = array();
		$query = 'SELECT TIME(timestamp) AS x, generation as y FROM `solar`.`hourlydata` WHERE timestamp LIKE :yesterday;';

		for ($i = (-1 - $realoffset); $i > (-15 - $realoffset); $i--) {		
			$yesterday = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+ $i,date("Y"))) ;
			$params[] = $yesterday;
		}
		
		$graphs = PageBase::createGraph($query, $params, "day");
	
		$this->mSmarty->assign('graphlisttitle', "Last 14 days power generation");
		$this->mSmarty->assign('graphlist', $graphs);
		$this->mSmarty->assign('offset', $offset);
		$this->mSmarty->assign('content', 'GraphList.tpl');
	}
}