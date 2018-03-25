<?php

/*****************************************************************************
 * 
 * Implements the Class: 	CBeitrag
 * 
 *	tut was:
 *
 * Methods:
 *	- 
 *****************************************************************************
 * Author:			Reinhard Schiessl
 * E-mail:			reinhard.schiessl@handle-it.de
 * Date Created:	2003-01-08
 * Last Modified:	2003-01-08
 * Version:			1.0
 *****************************************************************************
 * Change Log:
 *						
 * Version 1.0
 *	+ initial release
 *
 *****************************************************************************/

require_once("DbBase.php");
require_once("DTA.php");
require_once("SEPA/class.SEPA.php");

class CBeitrag extends DbBase
{

	/**
	  * global variables
	  */
	
	 var $beitragsdaten ;
	 var $iBeitragCount = 0 ;
	 protected $db;

  /**
      * Constructor
      *
      * @param      void
      * @return     void
      * @access     public
      */
	function __construct()
  	{
	  	error_log("beitrag.class.php:: __construct()");
		
		$this->db = new DbBase();

		  // Call Constructor in DbBase
		parent::__construct();

		require_once './Log.php';
		error_log("beitrag.class.php:: nach require_once Log.php()");
		$log = Log::singleton('file', 'log/beitrag.log', 'beitrag.class.php', false, PEAR_LOG_INFO);
		
    	unset($this->beitragsdaten) ;
	  	$sql = "SELECT id,bezeichnung,bemerkung,alterVon1,alterBis1,beitrag1,alterVon2,alterBis2,beitrag2,alterVon3,alterBis3,beitrag3 from beitrag ORDER by id";
	  	error_log("beitrag.class.php:: sql=$sql");
	  	$log->log("CBeitrag()::__construct sql=$sql");
	  	$result = $this->db->query($sql);
	  	if( $result )
	  	{	    
			$this->iBeitragCount = 0 ;
			while ($row = $result->fetch_array(MYSQLI_BOTH))
			{
				$id =  strval( $row["id"] ) ;
				$this->beitragsdaten[$id]["bezeichnung"] = $row["bezeichnung"] ;
				$this->beitragsdaten[$id]["bemerkung"] = $row["bemerkung"] ;
				$this->beitragsdaten[$id]["alterVon1"] = $row["alterVon1"] ;
				$this->beitragsdaten[$id]["alterBis1"] = $row["alterBis1"] ;
				$this->beitragsdaten[$id]["beitrag1"] = $row["beitrag1"] ;
				$this->beitragsdaten[$id]["alterVon2"] = $row["alterVon2"] ;
				$this->beitragsdaten[$id]["alterBis2"] = $row["alterBis2"] ;
				$this->beitragsdaten[$id]["beitrag2"] = $row["beitrag2"] ;
				$this->beitragsdaten[$id]["alterVon3"] = $row["alterVon3"] ;
				$this->beitragsdaten[$id]["alterBis3"] = $row["alterBis3"] ;
				$this->beitragsdaten[$id]["beitrag3"] = $row["beitrag3"] ;
				$this->iBeitragCount++ ;
				$log->log("CBeitrag::__construct($id): alterVon1=" . $this->beitragsdaten[$id]["alterVon1"] . ", alterBis1=" . $this->beitragsdaten[$id]['alterBis1'] . ",beitrag1=" . $this->beitragsdaten[$id]['beitrag1']. "alterVon2=" . $this->beitragsdaten[$id]['alterVon2'] . ", alterBis2=" . $this->beitragsdaten[$id]['alterBis2'] . ",beitrag2=" . $this->beitragsdaten[$id]['beitrag2'] . ", alterVon3=" . $this->beitragsdaten[$id]['alterVon3'] . ", alterBis3=" . $this->beitragsdaten[$id]['alterBis3'] . ",beitrag3=" . $this->beitragsdaten[$id]['beitrag3']);
			}
	  	}
	}	

	function getBezeichnung( $i )
	{
		$a = array_keys( $this->beitragsdaten ) ;
		return $this->beitragsdaten[$a[$i]]['bezeichnung'];
	}
	
	function getBeitrag( $i , $alterMitglied)
	{
		if( $i >= 0 ) {
			$a = array_keys( $this->beitragsdaten ) ;
	  
			require_once './Log.php';
			$log = Log::singleton('file', 'log/beitrag.log', 'beitrag.class.php', false, PEAR_LOG_INFO);
			$log->log("getBeitrag($i,$alterMitglied): alterVon1=" . $this->beitragsdaten[$a[$i]]['alterVon1'] . ", alterBis1=" . $this->beitragsdaten[$a[$i]]['alterBis1'] . ",beitrag1=" . $this->beitragsdaten[$a[$i]]['beitrag1']. "alterVon2=" . $this->beitragsdaten[$a[$i]]['alterVon2'] . ", alterBis2=" . $this->beitragsdaten[$a[$i]]['alterBis2'] . ",beitrag2=" . $this->beitragsdaten[$a[$i]]['beitrag2'] . ", alterVon3=" . $this->beitragsdaten[$a[$i]]['alterVon3'] . ", alterBis3=" . $this->beitragsdaten[$a[$i]]['alterBis3'] . ",beitrag3=" . $this->beitragsdaten[$a[$i]]['beitrag3']);
			
				if( $alterMitglied >= $this->beitragsdaten[$a[$i]]['alterVon1'] &&
				$alterMitglied <= $this->beitragsdaten[$a[$i]]['alterBis1'] )
			return $this->beitragsdaten[$a[$i]]['beitrag1'];
			if( $alterMitglied >= $this->beitragsdaten[$a[$i]]['alterVon2'] &&
				$alterMitglied <= $this->beitragsdaten[$a[$i]]['alterBis2'] )
			return $this->beitragsdaten[$a[$i]]['beitrag2'];
			if( $alterMitglied >= $this->beitragsdaten[$a[$i]]['alterVon3'] &&
				$alterMitglied <= $this->beitragsdaten[$a[$i]]['alterBis3'] )
			return $this->beitragsdaten[$a[$i]]['beitrag3'];
		} else {
			return 0;
		}
	}
	
	function getBemerkung( $i )
	{
		$a = array_keys( $this->beitragsdaten ) ;
		return $this->beitragsdaten[$a[$i]]['bemerkung'];
	}
	
	function getId( $i )
	{
		$a = array_keys( $this->beitragsdaten ) ;
		return $a[$i];
	}
	
	function getIndexForId( $id )
	{
		$a = array_keys( $this->beitragsdaten ) ;
	  for( $i=0; $i < count($a); $i++) 
	  {
      if( $a[$i] == $id )#
        return $i;
    }
		return -1;
	}
	
	function getCount()
	{
		return $this->iBeitragCount ;
	}
	
	function getCombobox( $name )
	{
	  echo "<select name='$name' id='$name' count=$this->iBeitragCount size='1'>\n";
		for( $i=0 ; $i < $this->iBeitragCount ; $i++ )
		{
		  echo "<option value=\"" . $this->getId($i) . "\">" . $this->getId($i) . ": " . $this->getBezeichnung($i) . "(" . $this->getBeitrag($i) . "�)</option>\n" ;
		}
	  echo "<option value=\"0\"></option>\n";
	  echo "</select>\n";
	}
	
	function getSepaFile($b1,$b2,$errors)
	{
		require_once 'classes/Log.php';
		$log  = &Log::singleton('file', 'log/beitrag.log', 'beitrag.class.php', false, PEAR_LOG_INFO);
		$log->log("starting beitrag.class.php::getSepaFile($b1,$b2)");
	
		$records = array();
		$summary = array();
		$errors = array();
		$filename = "";
		$hasErrors = FALSE;
		 
		require_once("verein.php");
		$verein = new CVerein();
	
		$sql = $this->getBeitragSql("0",$b1,$b2);
		$log->log("vor mysql_query(".$sql.")");
		$result = mysql_query($sql);
		if( $result )
		{
			try 
			{
				$sepa = new SEPADirectDebit();
				$sepa->setCreditorName($verein->get("name"));
				$sepa->setCreditorID($verein->get("CreditorID"));
				$sepa->setCreditorIBAN($verein->get("IBAN"));
				$sepa->setCreditorBIC($verein->get("BIC"));
	
				$Count = 0;
				$gesamtsumme = 0;
				while ($row=mysql_fetch_array($result,MYSQL_BOTH))
				{
					$inhaber = $row["kontoinhaber"] ;
					$beitrag = $this->getBeitrag($this->getIndexForId($row["beitrag_id"]), $row["mitgl_alter"]); //$row["beitrag"] ;
					if( $beitrag > 0 )
					{
						$buchtext = $row['bezeichnung'] . ": " . $row['nachname'] . ", " . $row['vorname'] . " (" . $row['id'] . ")";
						try {
							$sepa->addTransaction(	$inhaber, 
													"MusikvereinDenkendorf-Mitglied-" . $row["id"], 
													date("Y-m-d") , // "2011-12-06",
													$row["BIC"], 
													$row["IBAN"], 
													$beitrag, 
													$buchtext);
							
							$mnr = $row["id"];
							$mvn = $row["vorname"];
							$mnn = $row["nachname"];
							$log->log("Sepa->addTransaction(Inhaber: $inhaber, Text: $buchtext ): {Nr: $mnr} , {Vorname: $mvn} , {Nachname: $mnn} , {BIC: " . $row['BIC'] . "} , {IBAN: " . $row['IBAN'] . "},{Beitrag: $beitrag}");
							$Count++ ;
							$gesamtsumme += $beitrag;
							$records[] = array('name' => "$mnn, $mvn" ,'blz' => $row["BIC"], 'ktonr' => $row["IBAN"], 'zweck' => $buchtext, 'betrag' => $beitrag );
						}
						catch (Exception $exception)
						{
							$errors[] = "Fehler bei $buchtext : " . $exception->getMessage();
							$log->log("SEPA: Exception: $errors");
							$hasErrors = TRUE;
						}						
					}
				}
				$log->log("Sepa: all Transactions added");
			}
			catch (Exception $exception)
			{
				$errors[] = $exception->getMessage();
				$log->log("SEPA: Exception: $errors");
				$hasErrors = TRUE;
			}
			mysql_free_result($result);		
				
			if ($sepa->isValid()) 
			{
				$log->log("SEPA: before saveFile");
				$filename = 'DTA/SEPA_' . date("y-m-d_H-i-s") . '.XML' ;
				$sepa->toFile($filename);
				$log->log("SEPA: saveFile(" . $filename . ")");
				$summary = array(
						"anzahlAbbuchungen"   => $Count,
						"gesamtsumme" => number_format($gesamtsumme, 2, ',', ''),
						"begleitzettel" => $sepa->toTXT()
				);
			}
			else
			{
				$log->log("DTA: Fehler beim Erstellen");
				$log->log("DTA: Fehler beim Erstellen: ".json_encode($sepa->getErrors()));
			}
		}
		$jsonText = '({"total":"' . $Count .
		'","success":"' . (($sepa->isValid() && $hasErrors == FALSE)?1:0) .
		'","dtaFile":"' . $filename .
		'","records":' . json_encode($records) .
		',"summary":' . json_encode($summary) .
		',"errors":'  . json_encode($errors) .
		'})';
		$log->log("SEPA-Datei: return: " . $jsonText);
		return $jsonText;
	}
	
	
	function getDTAFile($b1,$b2,$errors)
	{
	  require_once 'classes/Log.php';
	  $log  = &Log::singleton('file', 'log/beitrag.log', 'beitrag.class.php', false, PEAR_LOG_INFO);
	  $log->log("starting beitrag.class.php::getDTAFile($b1,$b2)");

	  $records = array();
	  $summary = array();
	  $filename = "";
	  
	  require_once("verein.php");
	  $verein = new CVerein();

/*    $sql = "SELECT mitglied.id,nachname,vorname,kontoinhaber,bank,blz,kontonummer,mitglied_beitrag.beitrag_id, beitrag.bezeichnung ";
    $sql .= " FROM mitglied";
    $sql .= " LEFT JOIN mitglied_beitrag ON mitglied.id = mitglied_beitrag.mitglied_id";
    $sql .= " LEFT JOIN beitrag ON mitglied_beitrag.beitrag_id = beitrag.id";
    $sql .= " WHERE REKZ = '0' ";
    $sql .= " AND ( mitglied_beitrag.beitrag_id >= '" ;
    $sql .= strval($b1);
    $sql .= "' AND mitglied_beitrag.beitrag_id <= '" ;
    $sql .= strval($b2) . "' )";
    $sql .= " ORDER BY kontoinhaber"; */
    $sql = $this->getBeitragSql("0",$b1,$b2);
	  $log->log("sql=$sql");
	  
	  $result = mysql_query($sql);
	  if( $result )
	  {
	  	$dta = new DTA(DTA_DEBIT);
	  	$dta->setAccountFileSender(array('name'=>$verein->get("name"),
	  																	 'bank_code'=>$verein->get("blz"),
	  																	 'account_number'=>$verein->get("ktonr")));
	  	$Count = 0;
	  	$gesamtsumme = 0;
	    while ($row=mysql_fetch_array($result,MYSQL_BOTH))
	    {
		    $inhaber = $dta->makeValidString($row["kontoinhaber"]) ;
		    $ktonr = $dta->makeValidString($row["kontonummer"]) ;
		    $blz = $dta->makeValidString($row["blz"]) ;
		    $bank = $dta->makeValidString($row["bank"]) ;
		    $beitrag = $this->getBeitrag($this->getIndexForId($row["beitrag_id"]), $row["mitgl_alter"]); //$row["beitrag"] ;
		    if( $beitrag > 0 )
		    {
					$mnr = $row["id"];
					$mvn = $row["vorname"];
					$mnn = $row["nachname"];
		    		$debitor = array('name'=>$inhaber,
  		    								 'bank_code'=>$blz,
  		    								 'account_number'=>$ktonr);
					$buchtext = array($row['bezeichnung'],$row['nachname'] . ", " . $row['vorname'] , "Mitgliedsnr:" . $row['id'],
							"Bisherige Einzugsermaechti-",
							"gung gilt ab 1. Feb 2014",
							"als SEPA-Mandat. Unsere",
							"Glaeubiger-Ident-Nr lautet:",
							$verein->get("CreditorID"),
							"Ihre Mandatsreferenz lautet",
							"Mitgliedsnr-" . $mnr,
							"Ab 15.1.15 rufen wir " ,
							$beitrag . "EUR ab 1.Banktag zum",
							"1.2.15 bis auf weiteres ab"
					);
		      if( !$dta->addExchange($debitor, $beitrag , $buchtext ) )
  				{
  					$errors[] = "DTA: Fehler beim anhängen von Mitglied: {$mnr} , {$mvn} , {$mnn},{BLZ=$blz},{KtoNr=$ktonr},{Beitrag=$beitrag}" ;
  					$log->log("DTA: Fehler beim anhängen von Mitglied: {$mnr} , {$mvn} , {$mnn} , {BLZ=$blz} , {KtoNr=$ktonr},{Beitrag=$beitrag}");
  				}
  				else 
  				{
  				  $log->log("dta->addExchange(Inhaber: $inhaber, Text: $buchtext ): {Nr: $mnr} , {Vorname: $mvn} , {Nachname: $mnn} , {BLZ: $blz} , {KtoNr: $ktonr},{Beitrag: $beitrag}");
  				}
  				$Count++ ;
					$gesamtsumme += $beitrag;
				}
	    }
	    mysql_free_result($result);

			if( !$errors)
			{
				$filename = 'DTA/DTAUS_' . date("y-m-d_H-i-s") . '.TXT' ;
				$dta->saveFile($filename);
				$log->log("DTA: saveFile(" . $filename . ")");
				
				$ktoSumme = doubleval (0.0) ;
				$blzSumme = doubleval (0.0) ;
				$tdClass = "trEven";
				
				$Count=0 ;
				foreach ($dta->exchanges as $exchange) 
				{
          $purpose = "";
    		  foreach ($exchange['purposes'] as $purp) 
	        {
	            $purpose .= $purp . "\n";
	        }
				  $record = array(
            "name"   => $exchange['receiver_name'],
            "blz"    => $exchange['receiver_bank_code'],
            "ktonr"  => $exchange['receiver_account_number'],
	        	"zweck"  => $purpose,
	          "betrag" => number_format($exchange['amount']/100, 2, ',', '')
	        );
					$ktoSumme += doubleval($exchange['receiver_account_number']);
					$blzSumme += doubleval($exchange['receiver_bank_code']);
					$records[] = $record;
					$Count++ ;
  		  }
				
				$begleitzettel = "BEGLEITZETTEL\n";
				$begleitzettel .= "\nErstellungsdatum:               " . date("d.m.Y") ;
        $begleitzettel .= "\nAnzahl der Datensätze C:        " . $Count ;
				$begleitzettel .= "\nSumme in € der Datensätze C:    " . number_format($gesamtsumme, 2, ',', '') ;
				$begleitzettel .= "\nAusführungsdatum:               " . date("d.m.Y") ;
				$begleitzettel .= "\nKontrollsumme der Kontonummern: " . $ktoSumme ;
				$begleitzettel .= "\nKontonummer des Absenders:      " . $verein->get("ktonr");
				$begleitzettel .= "\nName des Absenders:             " . $verein->get("name") ;
				$begleitzettel .= "\nDiskettenempfänger:             " . $verein->get("bank") . "&nbsp;&nbsp;&nbsp;" . $verein->get("blz") ;
				$summary = array(
				  "anzahlAbbuchungen"   => $Count,
				  "gesamtsumme" => number_format($gesamtsumme, 2, ',', ''),
				  "begleitzettel" => $begleitzettel
				);
			}
			else
			{
				$log->log("DTA: Fehler beim Erstellen: ".json_encode($errors));
			}
	  }
		$jsonText = '({"total":"' . $Count . 
             '","success":"' . (!$errors?1:0) .
						 '","dtaFile":"' . $filename .
             '","records":' . json_encode($records) .
             ',"summary":' . json_encode($summary) .
             ',"errors":'  . json_encode($errors) .
    			 '})'; 
		$log->log("DTA-Datei: return: " . $jsonText);
    return $jsonText;
	}
	
	function getBeitragSql($rekz,$b1,$b2)
	{
    $sql = "SELECT mitglied.memberId,nachname,vorname,strasse,plz,ort,kontoinhaber,blz,kontonummer,bank,BIC,IBAN,";
    $sql .= "mitglied_beitrag.beitrag_id, beitrag.bezeichnung, ";
    $sql .= "if( gebdat is null, 0,((YEAR(NOW())-YEAR(gebdat)) - (MONTH(NOW())<MONTH(gebdat)) - (DAYOFMONTH(NOW())<DAYOFMONTH(gebdat) AND MONTH(NOW())=MONTH(gebdat)))) mitgl_alter";
    $sql .= " FROM mitglied";
    $sql .= " LEFT JOIN mitglied_beitrag ON mitglied.memberId = mitglied_beitrag.memberId";
    $sql .= " LEFT JOIN beitrag ON mitglied_beitrag.beitrag_id = beitrag.id";
    $sql .= " WHERE beitrag_id is not null ";
		if( $rekz != "" )
			$sql .= " AND REKZ = '$rekz' ";
		if( $b1 != "" )
			$sql .= " AND (mitglied_beitrag.beitrag_id >= '$b1')" ;
		if( $b2 != "" )
			$sql .= " AND (mitglied_beitrag.beitrag_id <= '$b2')" ;
    $sql .= " ORDER BY mitglied.nachname,mitglied.vorname,beitrag_id";
		return $sql;
	}
		
}	// eof class 
?>
