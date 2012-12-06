<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Theme Options
 * @category Model
 * @author Michael Krasnow <mike@c5rockstars.com>
 * @copyright  Copyright (c) 2010-2011 C5Rockstars. (http://www.c5rockstars.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
class Social extends Object {

	/**
	 * Add a new social network
	 * @param string $handle
	 * @param string $name
	 * @param string $value
	 * @return Social
	 */
	public function add($handle, $name, $value = null) {
		if(!Social::handleExists($handle)) {
			$db = Loader::db();
			$db->Execute('insert into ThemeOptionsSocialIDs (handle, name, value) values (?, ?, ?)', array(Social::CleanHandle($handle), $name, $value));
			$sID = $db->Insert_ID();
			Events::fire('on_social_network_added', Social::getByID($sID));
			return Social::getByID($sID);
		}
		throw new Exception(t('A Social Network with that handle already exists!'));
	}
	
	/**
	 * Delete a social network
	 */
	public function delete() {
		Events::fire('on_social_network_deleted', Social::getByID($this->sID));
		$db = Loader::db();
		$db->Execute('delete from ThemeOptionsSocialIDs where sID = ?', $this->sID);
	}
	
	/**
	 * Set the value for a social network
	 * @param string $value
	 */
	public function setValue($value) {
		$db = Loader::db();
		$db->Execute('update ThemeOptionsSocialIDs set value = ? where sID = ?', array($value, $this->sID));
	}
		
	/**
	 * Set the handle for a social network
	 * @param string $handle
	 */
	public function setHandle($handle) {
		if($this->sID) {
			$db = Loader::db();
			$db->Execute('update ThemeOptionsSocialIDs set handle = ? where sID = ?', array(Social::CleanHandle($handle), $this->sID));
		}
	}
		
	/**
	 * Set the name for a social network
	 * @param string $name
	 */
	public function setName($name) {
		if($this->sID) {
			$db = Loader::db();
			$db->Execute('update ThemeOptionsSocialIDs set name = ? where sID = ?', array($name, $this->sID));
		}
	}
	
	/**
	 * Get the object for a social network by handle
	 * @param string $handle
	 * @return Social
	 */
	public function getByHandle($handle) {
		$db = Loader::db();
		$row = $db->GetRow("select * from ThemeOptionsSocialIDs where handle = ?", array(Social::CleanHandle($handle)));
		if ($row) {
			$sID = $row['sID'];
			return Social::getByID($sID);
		}
	}
	
	/**
	 * Get the object for a social network by id
	 * @param string $sID
	 * @return Social
	 */
	public function getByID($sID) {
		$db = Loader::db();
		$row = $db->GetRow("select * from ThemeOptionsSocialIDs where sID = ?", array($sID));
		if ($row) {
			$sn = new Social();
			$sn->setPropertiesFromArray($row);
			return $sn;
		}
	}
	
	/**
	 * @access private
	 */	
	private function handleExists($handle) {
		$db = Loader::db();
		$r = $db->GetOne("select count(sID) from ThemeOptionsSocialIDs where handle = ?", array(Social::CleanHandle($handle)));
		return $r > 0;
	}
	
	/**
	 * @access private
	 */	
	private function CleanHandle($handle) {
		$clean = preg_replace("/[^0-9A-Za-z-_]/", "", trim($handle));
		return $clean;
	}

	public function getID() {return $this->sID;}
	public function getName() {return $this->name;}
	public function getHandle() {return $this->handle;}
	public function getValue() {return $this->value;}
	
	/**
	 * Get a list of all the social network object
	 * @return array $networks
	 */
	public function getNetworkList() {
		$db = Loader::db();
		$networks = array();
		$r = $db->Execute('select sID from ThemeOptionsSocialIDs order by sID asc');
		while ($row = $r->FetchRow()) {
			$networks[] = Social::getByID($row['sID']);
		}
		return $networks;
	}

}