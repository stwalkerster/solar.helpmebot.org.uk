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
		global $gDatabase;
	
		$params = array();
		$query = 'SELECT TIME(timestamp) AS x, generation as y FROM `solar`.`hourlydata` WHERE timestamp LIKE :yesterday;';

		for ($i = -1; $i > -29; $i--) {		
			$yesterday = date("Y-m-d", mktime(0,0,0,date("m"),date("d")+ $i,date("Y"))) ;
			$params[] = $yesterday;
		}
		
		$graphs = PageBase::createGraph($query, $params);
		
			
		$generationlist=array();
		$pdostmt = $gDatabase->prepare("SELECT * FROM dailydata ORDER BY date desc LIMIT 28;");
		$pdostmt->execute();
		foreach($pdostmt->fetchAll() as $row )
		{
			$generationlist[$row['date']] = $row['totalgenerated'];
		}
		
		$this->mSmarty->assign('graphlist', $graphs);
		$this->mSmarty->assign('generation', $generationlist);
	}
}