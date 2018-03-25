<?php
/*****************************************************************************
 * 
 * Implements the Class: 	CVerein
 * 
 *	tut was:
 *   Stammdaten des Vereins
 *
 * Methods:
 *	- 
 *****************************************************************************
 * Author:			Reinhard Schiessl
 * E-mail:			reinhard.schiessl@handle-it.de
 * Date Created:	2005-03-07
 * Last Modified:	2005-03-07
 * Version:			1.0
 *****************************************************************************
 * Change Log:
 *						
 * Version 1.0
 *	+ initial release
 *
 *****************************************************************************/

require_once("DbBase.php");

class CVerein extends DbBase
{

	/**
	  * global variables
	  */

  var $_daten;
  protected $db;
  	  
	  /**
      * Constructor
      *
      * @param      void
      * @return     void
      * @access     public
      */
	public function __construct()
  	{
		// Call Constructor in DbBase
		parent::__construct();

		$this->db = new DbBase();

	    unset($this->beitragsdaten) ;
		$sql = "SELECT * from verein";
		$result = $this->db->query($sql);
		if( $result )
		{
			if ($row = $result->fetch_array(MYSQLI_BOTH))
			{
				$this->_daten["name"] = $row["name"] ;
				$this->_daten["zusatz"] = $row["zusatz"] ;
				$this->_daten["vorstand"] = $row["vorstand"] ;
				$this->_daten["strasse"] = $row["strasse"] ;
				$this->_daten["plz"] = $row["plz"] ;
				$this->_daten["ort"] = $row["ort"] ;
				$this->_daten["land"] = $row["land"] ;
				$this->_daten["email"] = $row["email"] ;
				$this->_daten["tel1"] = $row["telefon1"] ;
				$this->_daten["tel2"] = $row["telefon2"] ;
				$this->_daten["fax"] = $row["telefax"] ;
				$this->_daten["blz"] = $row["blz"] ;
				$this->_daten["ktonr"] = $row["kontonummer"] ;
				$this->_daten["bank"] = $row["bank"] ;
				$this->_daten["BIC"] = $row["BIC"] ;
				$this->_daten["IBAN"] = $row["IBAN"] ;
				$this->_daten["CreditorID"] = $row["CreditorID"] ;
			}
		}
	}

	function get( $field )
	{
		return $this->_daten[$field];
	}
	
}	// eof class 
?>
