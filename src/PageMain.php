<?php
/**************************************************************************
*                     Wikipedia Account Request System                    *
***************************************************************************
*                                                                         *
* Conceptualised by Incubez (author: X!) and ACC (author: SQL and others) *
*                                                                         *
* Please refer to /LICENCE for more info.                                 *
*                                                                         *
**************************************************************************/

/**************************************************************************
* Please note: This file was originally written by Simon Walker for a     *
* university assignment, and may need adapting for purpose.               *
*                                                                         *
* DO NOT CHANGE THE EXISTING INTERFACE OF THIS CLASS unless you really    *
* know what you're doing.                                                 *
**************************************************************************/

class PageMain extends PageBase
{
	function __construct()
	{
	}
	
	function runPage()
	{
		$queries = array();
		for ($i = -1; $i > -8; $i--) {
			
			$yesterday =date("yyyy-MM-dd", mktime(0,0,0,date("M"),date("d")+ $i,date("yyyy")));
			$query = 'SELECT * FROM `solar`.`hourlydata` WHERE timestamp LIKE "'.$yesterday.'%";';
			echo $query . "<br />\n";
			$queries[] = array("query"=>$query,"series"=>$yesterday);
		}
		
		$graphs = PageBase::createGraph($queries);
		print_r($graphs);
		$this->smarty->assign('graphlist', $graphs);
		$this->smarty->assign('content', 'MainPage.tpl');
	}
}