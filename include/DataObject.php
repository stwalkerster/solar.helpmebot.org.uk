<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

/**
 * DataObject is the base class for all the database access classes. Each "DataObject" holds one record from the database, and
 * provides functions to allow loading from and saving to the database.
 *
 *
 */
abstract class DataObject
{
	protected $id;

	protected $isNew;
	
	/**
	 * Retrieves a data object by it's row ID.
	 */
	public abstract static function getById($id);

	/**
	 * Saves a data object to the database, either updating or inserting a record.
	 */
	public abstract function save();
	
	public function getId()
	{
		return $this->id;
	}
}
