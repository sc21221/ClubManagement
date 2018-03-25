<?php
/*************************************************************
 * PHP SEPA Implementation DirectDebit
 *
 * BETA Release
 *
 * Homepage: http://www.gama.de/cms/produkte/sepa/
 *
 *
 * Arten der SEPA Transaktionen:
 * ------------------------------------------------------------------------
 * 1.   SEPA Überweisung          n.a.
 * 2.1. SEPA Basis-Lastschrift    SEPADirectDebit       pain.008.002.02.xsd
 * 2.2. SEPA Firmen-Lastschrift   n.a.
 * 3.   SEPA Kartenzahlung        n.a.
 *
 *
 * @author Markus Garscha
 * @version 0.13 
 * @copyright gama consulting, 10 September, 2013
 * @package SEPA
 *
 *************************************************************/

/**
 * SEPA_CONVETER
 * Hilfsfunktionen zur Konvertierung von BLZ und Kontonummer in BIC und IBAN
 * Die Datei "blz.txt" muss in der aktuellen Version von der Bundesbank geladen werden.
 * http://www.bundesbank.de/Redaktion/DE/Standardartikel/Kerngeschaeftsfelder/Unbarer_Zahlungsverkehr/bankleitzahlen_download.html
 *
 * @package SEPA
 * @author Markus Garscha
 **/
class SEPA_CONVERTER {
  var $_filename;
  var $_list;

  var $_kto;
  var $_blz;

  // Constructor
  // 
  function __construct($blz_filename = "") {
    if ($blz_filename) {
      $this->_filename = $blz_filename;
    } else {
      $this->_filename = dirname(__FILE__) . "/blz.txt";
    }

    $this->_list = array();

    $data = file($this->_filename);
    foreach ($data as $line) {
      $blz                   = substr($line, 0, 8);
      $dl                    = substr($line, 8, 1);
      $bezeichnung           = substr($line, 9, 58);
      $plz                   = substr($line, 67, 5);
      $ort                   = substr($line, 72, 35);
      $kurzbezeichnung       = substr($line, 107, 27);
      $institutsnummer       = substr($line, 134, 5);
      $bic                   = substr($line, 139, 11);
      $pzmethode             = substr($line, 150, 2);
      $datensatznummer       = substr($line, 152, 6);
      $aenderungskennzeichen = substr($line, 158, 1);
      $loeschung             = substr($line, 159, 1);
      $nachfolgeblz          = substr($line, 160, 8);
      $ibanregel             = substr($line, 168, 6);

      $blz = trim($blz);
      $bic = trim($bic);

      if ($blz && $bic) {
        if ($this->_list[$blz]["bic"] && $this->_list[$blz]["bic"] != $bic) {
          $this->_list[$blz]["cnt"] += 1;
          $this->_list[$blz]["alt"] .= "," . $bic; 
        } else {
          $this->_list[$blz]["bic"] = $bic;
          $this->_list[$blz]["bez"] = $kurzbezeichnung;
          $this->_list[$blz]["cnt"] = 1;
          $this->_list[$blz]["alt"] = $bic;
        }
      }
    }
  }

  function stats() {
    $multiple = array();

    foreach($this->_list as $blz => $entry) {
      if ($entry["cnt"] > 1) {
        // $multiple[$entry["cnt"]]["cnt"] += 1;
        // $multiple[$entry["cnt"]]["blz"] .= $blz . "[".$entry["alt"]."],";
        $multiple["$blz"] = "$blz [".$entry["alt"]."]";
      }
    }
    sort($multiple);

    $s = "RECORDS......: " . count($this->_list) . "\n";
    $s .= print_r($multiple, true);

    return $s;
  }

  function getBLZ() {
    return $this->_blz;
  }

  function setBLZ($blz) {
    $this->_blz = str_pad($blz, 8, "0", STR_PAD_RIGHT);
  }

  function setKontonummer($kontonummer) {
    $this->_kto = str_pad($kontonummer, 10, "0", STR_PAD_LEFT);
  }

  function getBIC() {
    return $this->_list[$this->_blz]["bic"];
  }

  function hasMultipleBIC() {
    return ($this->_list[$this->_blz]["cnt"] > 1);
  }

  function getIBAN() {
    $temp = $this->_blz . $this->_kto;
    $checksum = $temp. "131400"; // Nummerncode für DE00, D=13, E=14
    //$modulo = (bcmod($checksum,"97"));
    $modulo = ($this->my_bcmod($checksum,"97"));
    $pz =str_pad ( 98 - $modulo, 2, "0",STR_PAD_LEFT);
    $this->_iban = "DE" . $pz . $temp;
    return $this->_iban;
  }
  
  // PHP on vserver.handle-it.de does not know bcmod
  function my_bcmod( $x, $y )
  {
  	// how many numbers to take at once? carefull not to exceed (int)
  	$take = 5;
  	$mod = '';
  
  	do
  	{
  		$a = (int)$mod.substr( $x, 0, $take );
  		$x = substr( $x, $take );
  		$mod = $a % $y;
  	}
  	while ( strlen($x) );
  
  	return (int)$mod;
  }
  
}

/**
 * SEPA_BASE Basisklasse
 *
 * @package SEPA
 * @author Markus Garscha
 **/
class SEPA_BASE {
  var $VERSION = "0.13";

  var $_IBAN_STRUCTURE = array( 
    "AL" => array('country' => 'Albanien', 'length' => 28),
    "AD" => array('country' => 'Andorra', 'length' => 24), 
    "AZ" => array('country' => 'Aserbaidschan', 'length' => 28),
    "BH" => array('country' => 'Bahrain', 'length' => 22),
    "BE" => array('country' => 'Belgien', 'length' => 16),
    "BA" => array('country' => 'Bosnien und Herzegowina', 'length' => 20), 
    "BR" => array('country' => 'Brasilien', 'length' => 29), 
    "BG" => array('country' => 'Bulgarien', 'length' => 22), 
    "CR" => array('country' => 'Costa Rica', 'length' => 21),
    "DK" => array('country' => 'Dänemark', 'length' => 18), 
    "DE" => array('country' => 'Deutschland', 'length' => 22),
    "DO" => array('country' => 'Dominikanische Republik', 'length' => 28),
    "EE" => array('country' => 'Estland', 'length' => 20), 
    "FO" => array('country' => 'Färöer', 'length' => 18),
    "FI" => array('country' => 'Finnland', 'length' => 18), 
    "FR" => array('country' => 'Frankreich', 'length' => 27),  
    "GF" => array('country' => 'Französisch-Guayana', 'length' => 27),
    "PF" => array('country' => 'Französisch-Polynesien', 'length' => 27),  
    "TF" => array('country' => 'Französische Süd- und Antarktisgebiete', 'length' => 27), 
    "GE" => array('country' => 'Georgien', 'length' => 22),
    "GI" => array('country' => 'Gibraltar', 'length' => 23),
    "GR" => array('country' => 'Griechenland', 'length' => 27),
    "GL" => array('country' => 'Grönland', 'length' => 18),
    "GP" => array('country' => 'Guadeloupe', 'length' => 27),
    "GT" => array('country' => 'Guatemala', 'length' => 28),
    "HK" => array('country' => 'Hong Kong', 'length' => 16),
    "IE" => array('country' => 'Irland', 'length' => 22),
    "IS" => array('country' => 'Island', 'length' => 26),
    "IL" => array('country' => 'Israel', 'length' => 23),
    "IT" => array('country' => 'Italien', 'length' => 27),
    "VG" => array('country' => 'Jungferninseln', 'length' => 24),
    "KZ" => array('country' => 'Kasachstan', 'length' => 20),
    "HR" => array('country' => 'Kroatien', 'length' => 21),
    "KW" => array('country' => 'Kuwait', 'length' => 30),
    "LV" => array('country' => 'Lettland', 'length' => 21),
    "LB" => array('country' => 'Libanon', 'length' => 28),
    "LI" => array('country' => 'Liechtenstein', 'length' => 21),
    "LT" => array('country' => 'Litauen', 'length' => 20),
    "LU" => array('country' => 'Luxemburg', 'length' => 20),
    "MT" => array('country' => 'Malta', 'length' => 31),
    "MA" => array('country' => 'Marokko', 'length' => 24),
    "MQ" => array('country' => 'Martinique', 'length' => 27),
    "MR" => array('country' => 'Mauretanien', 'length' => 27),
    "MU" => array('country' => 'Mauritius', 'length' => 30),
    "YT" => array('country' => 'Mayotte', 'length' => 27),
    "MK" => array('country' => 'Mazedonien', 'length' => 19),
    "MD" => array('country' => 'Moldawien', 'length' => 24),
    "MC" => array('country' => 'Monaco', 'length' => 27),
    "ME" => array('country' => 'Montenegro', 'length' => 22),
    "NC" => array('country' => 'Neukaledonien', 'length' => 27),
    "NL" => array('country' => 'Niederlande', 'length' => 18),
    "NO" => array('country' => 'Norwegen', 'length' => 15),
    "AT" => array('country' => 'Österreich', 'length' => 20),
    "PK" => array('country' => 'Pakistan', 'length' => 24),
    "PS" => array('country' => 'Palästinensische Autonomiegebiete', 'length' => 29),
    "PL" => array('country' => 'Polen', 'length' => 28),
    "PT" => array('country' => 'Portugal', 'length' => 25),
    "RE" => array('country' => 'Réunion', 'length' => 27),
    "RO" => array('country' => 'Rumänien', 'length' => 24),
    "BL" => array('country' => 'Saint-Barthélemy', 'length' => 27),
    "MF" => array('country' => 'Saint-Martin', 'length' => 27),
    "SM" => array('country' => 'San Marino', 'length' => 27),
    "SA" => array('country' => 'Saudi-Arabien', 'length' => 24),
    "SE" => array('country' => 'Schweden', 'length' => 24),
    "CH" => array('country' => 'Schweiz', 'length' => 21),
    "RS" => array('country' => 'Serbien', 'length' => 22),
    "SK" => array('country' => 'Slowakei', 'length' => 24),
    "SI" => array('country' => 'Slowenien', 'length' => 19),
    "ES" => array('country' => 'Spanien', 'length' => 24),
    "PM" => array('country' => 'St. Pierre und Miquelon', 'length' => 27),
    "CZ" => array('country' => 'Tschechien', 'length' => 24),
    "TN" => array('country' => 'Tunesien', 'length' => 24),
    "TR" => array('country' => 'Türkei', 'length' => 26),
    "HU" => array('country' => 'Ungarn', 'length' => 28),
    "AE" => array('country' => 'Vereinigte Arabische Emirate', 'length' => 23),
    "GB" => array('country' => 'Vereinigtes Königreich', 'length' => 22),
    "WF" => array('country' => 'Wallis und Futuna', 'length' => 27),
    "CY" => array('country' => 'Zypern', 'length' => 28)
  );

	/**
	 * überprüfe ISO Date, z.B. 2013-08-13
	 * 
	 * @param string $date zu prüfendes Datum
	 * @return boolean true wenn ISO Date
	 **/
  function verifyISODate($date) {
    return preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $parts); 
  }

	/**
	 * überprüfe ISO DateTime, z.B. 2011-10-02T23:25:42
	 * 
	 * @param string $ts zu prüfendes Datum
	 * @return boolean true wenn ISO DateTime
	 **/
  function verifyISODateTime($ts) {
    return preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})$/', $ts, $parts);
  }

	/**
	 * überprüfe IBAN, z.B. 
	 * 
	 * @param string $iban zu prüfende IBAN
   * @return boolean true wenn gültige IBAN
   *
   * TODO: Längenprüfung abhängig vom Land
   *
	 **/
  function verifyIBAN($iban) {
    // 1. Erste 4 Zeichen (Ländercode und Prüfziffer) an das Ende verschieben
    // 2. Zeichen nach Konversionstabelle in Zahlen umwandeln
    // 3. Resultierende Zahl mod 97 (BigNumber Operation!) muss 1 ergeben
    $iban_pre = substr( $iban,4 )
        . strval( ord( $iban{0} )-55 ) // ASCII Wert des Zeichens - 55
        . strval( ord( $iban{1} )-55 ) // ASCII Wert des Zeichens - 55
        . substr( $iban, 2, 2 );
    for( $i = 0; $i < strlen($iban_pre); $i++) {
      if(ord( $iban_pre{$i} )>64 && ord( $iban_pre{$i} )<91) {
        $iban_pre = substr($iban_pre,0,$i) . strval( ord( $iban_pre{$i} )-55 ) . substr($iban_pre,$i+1);
      }
    }
    $rest=0;
    for ( $pos=0; $pos<strlen($iban_pre); $pos+=7 ) {
        $part = strval($rest) . substr($iban_pre,$pos,7);
        $rest = intval($part) % 97;
    }
    $pz = sprintf("%02d", 98-$rest);
    if ( substr($iban,2,2)=='00')
        return substr_replace( $iban, $pz, 2, 2 );
    else
        return ($rest==1) ? true : false;
  }

	/**
	 * überprüfe BIC, z.B. 
	 * 
	 * @param string $bic zu prüfende BIC
	 * @return boolean true wenn gültige BIC
	 **/
  function verifyBIC($bic) {
    return preg_match('/^([a-zA-Z]){4}([a-zA-Z]){2}([0-9a-zA-Z]){2}([0-9a-zA-Z]{3})?$/', $bic, $parts);
  }

   function verifyRestrictedIdSEPA2($id) {
     return preg_match('/^([A-Za-z0-9+?\/\-:(.,\']){1,35}$/', $id , $parts); 
   }


  /**
   * Konvertiere Text nach EPC 2009 Standard
   *
   * @param string $text der zu konvertierende Text
   * @param integer $max maximale Laenge des konvertierten Testes
   * @return string konvertierter Text
   **/
  function str2epc($text, $maxlen=999) {
    /*
     * EPC 2009
     * abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789':?,-(+.)/Leerzeichen
     */

    $pat[0] = '/ä/';
    $rep[0] = 'ae';
    $pat[1] = '/Ä/';
    $rep[1] = 'AE';
    $pat[2] = '/ö/';
    $rep[2] = 'oe';
    $pat[3] = '/Ö/';
    $rep[3] = 'OE';
    $pat[4] = '/ü/';
    $rep[4] = 'ue';
    $pat[5] = '/Ü/';
    $rep[5] = 'UE';
    $pat[6] = '/ß/';
    $rep[6] = 'ss';
    $pat[7] = '/[^a-zA-Z0-9:?,\-(+.)]/u';
    $rep[7] = ' ';
    
    return substr(preg_replace($pat, $rep, $text), 0, $maxlen);
  }
}

/**
 * SEPADirectDebit
 * Implementierung der SEPA Basis-Lastschrift
 *
 * defaults:
 * - Einmallastschrit (Typ: OOFF)
 * - Fälligkeitsdatum heute + 5 Tage
 *
 * @package SEPA
 * @author Markus Garscha
 **/
class SEPADirectDebit extends SEPA_BASE {
  var $_pmtinf;

  function __construct() {
    $this->_pmtinf = new SEPAPaymentInfo();
    $this->_pmtinf->setSequenceType("OOFF");
    $this->_pmtinf->setRequestedCollectionDate(date('Y-m-d', strtotime('+5 days')));
  }

  /**
   * Setzen des Squenztyps 
   *
   * @param string $type
   *        "FRST" Wiederkehrend: Erster Einzug einer Lastschrift regelmässiger Lastschriften
   *        "RCUR" Wiederkehrend: Folgelastschrift reglemässiger Lastschriften
   *        "FNAL" Wiederkehrend: Letztmalige Lastschrift regelmässiger Lastschriften
   *        "OOFF" Einmalige Lastschrift
   **/
  function setSequenceType($type) {
    return $this->_pmtinf->setSequenceType($type);
  }
  
  /**
   * Setzen des Fälligkeitsdatums 
   *
   * @param string $date Datum im ISO Format 'YYYY-MM-DD'
   **/
  function setRequestedCollectionDate($date) {
    return $this->_pmtinf->setRequestedCollectionDate($date);
  }
  
  function getControlSum() {
    return $this->_pmtinf->getControlSum();
  }

  function getNumberOfTransactions() {
    return $this->_pmtinf->getNumberOfTransactions();
  }

  function getPaymentId() {
    return $this->_pmtinf->getPaymentId();
  }

  /**
   * Setzen des Keditor Namen 
   *
   * @param string $name Name UTF8 kodiert, max. 70 Zeichen 
   **/
  function setCreditorName($name) {
    $this->_pmtinf->setCreditorName($name);
  }

  /**
   * Setzen der Gläubiger ID (Beantragung Deutschen Bundesbank) 
   *
   * @param string $id
   **/
  function setCreditorId($id) {
    $this->_pmtinf->setCreditorId($id);
  }

  function setCreditorIBAN($iban) {
    $this->_pmtinf->setCreditorIBAN($iban);
  }

  function setCreditorBIC($bic) {
    $this->_pmtinf->setCreditorBIC($bic);
  }

  function addTransactionArray($data) {
    $fields = array("name", "mandat_id", "mandat_datum", "bic", "iban", "betrag", "verwendungszweck");

    foreach ($fields as $field) {
      if (array_key_exists($field,$data) ) {
        if (empty($data[$field])) {
          throw new Exception("Der Parameter wurde übergeben, ist aber leer: " . $field);
        }
      } else {
          throw new Exception("Fehlender Parameter: " . $field);
      }
    }

    $t = new SEPA_DD_Transaction();
    $t->setName($data["name"]);
    $t->setMandateId($data["mandat_id"]);
    $t->setMandateSignatureDate($data["mandat_datum"]);
    $t->setBIC($data["bic"]);
    $t->setIBAN($data["iban"]);
    $t->setAmount($data["betrag"]);
    $t->setInfo($data["verwendungszweck"]);

    if ($data["zahlungsid"] > "") $t->setEndToEndId($data["zahlungsid"]);

    $this->_pmtinf->addTransaction($t);

    return $t;
 
  }

  function addTransaction($name, $mandat_id, $mandat_datum, $bic, $iban, $betrag, $verwendungszweck, $zahlungsid="") {
    $t = new SEPA_DD_Transaction();
    $t->setName($name);
    $t->setMandateId($mandat_id);
    $t->setMandateSignatureDate($mandat_datum);
    $t->setBIC($bic);
    $t->setIBAN($iban);
    $t->setAmount($betrag);
    $t->setInfo($verwendungszweck);

    if ($zahlungsid > "") $t->setEndToEndId($zahlungsid);

    $this->_pmtinf->addTransaction($t);

    return $t;
  }

  function _createXML() {
    $_version = $this->VERSION;

    $_ns = 'urn:iso:std:iso:20022:tech:xsd:pain.008.002.02';

    $_timestamp = date('Y-m-d', time()) . "T" . date('H:i:s', time());
    $_msgid = substr("GAMASEPA $_version $_timestamp",0,34);
    $_initiatorname = "Markus Garscha";

    $doc = new DomDocument('1.0', 'UTF-8');
    $root = $doc->createElementNS($_ns, 'Document');
    $root = $doc->appendChild($root);
    $root->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
    $root->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'schemaLocation', 'urn:iso:std:iso:20022:tech:xsd:pain.008.002.02 pain.008.002.02.xsd');

    $root = $root->appendChild($doc->createElementNS($_ns, 'CstmrDrctDbtInitn'));

    $hdr = $root->appendChild($doc->createElementNS($_ns,'GrpHdr'));

    $hdr->appendChild($doc->createElementNS($_ns,'MsgId', $_msgid));
    $hdr->appendChild($doc->createElementNS($_ns,'CreDtTm', $_timestamp));
    $hdr->appendChild($doc->createElementNS($_ns,'NbOfTxs', $this->_pmtinf->getNumberOfTransactions()));
    $initgpty = $hdr->appendChild($doc->createElementNS($_ns,'InitgPty'));
    $initgpty->appendChild($doc->createElementNS($_ns,'Nm', $_initiatorname));

    $root->appendChild($this->_pmtinf->createXMLNode($doc, $_ns));

    return $doc;
  }

  function isValid() {
    $doc = $this->_createXML();
    return $doc->schemaValidate(dirname(__FILE__) . '/pain.008.002.02.xsd');
  }

  function getErrors() {
    libxml_use_internal_errors(true);
    $doc = $this->_createXML();
    if (!$doc->schemaValidate(dirname(__FILE__) . '/pain.008.002.02.xsd')) {
      foreach (libxml_get_errors() as $error) {
        switch ($error->level) {
        case LIBXML_ERR_WARNING:
          $e .= "WARNING $error->code: ";
          break;
        case LIBXML_ERR_ERROR:
          $e .= "ERROR $error->code: ";
          break;
        case LIBXML_ERR_FATAL:
          $e .= "FATAL $error->code: ";
          break;
        }
        $e .= trim(preg_replace('(\{urn:iso[^\}]+\})','',$error->message)) . "\n"; 
      }
      return $e;
    }

    return FALSE;
  }

  function toXml() {
    $doc = $this->_createXML();

    $doc->formatOutput = true;
    return $doc->saveXML();
  }

  function toFile($filename = null) {
    if (!$filename) 
      $filename = "SEPA_" . date("Ymd", time()) . "_" . $this->getPaymentId() . ".xml";
    $doc = $this->_createXML();
    return $doc->save($filename);
  }

  function toTXT() {
    $txt = "--------------------------------------------------------------" . "\n";
    $txt .= "GAMA DIRECT DEBIT " . $this->VERSION . "\n";
    $txt .= "--------------------------------------------------------------" . "\n";
    $txt .= "Payment ID ........: " . $this->getPaymentId()  . "\n";
    $txt .= "Transaktionen .....: " . $this->getNumberOfTransactions()  . "\n";
    $txt .= "Kontrollsumme .....: " . $this->getControlSum() . "\n";
    $txt .= "--------------------------------------------------------------" . "\n";

    foreach ($this->_pmtinf->_transactions as $t) {
      $txt .= $t->toTXT();
      $txt .= "--------------------------------------------------------------" . "\n";
    }

    return $txt;
  }

}

/**
 * SEPAPaymentInfo
 * Subklasse der SEPA Basis-Lastschrift
 *
 * @package SEPA
 * @author Markus Garscha
 **/
class SEPAPaymentInfo extends SEPA_BASE {
  var $_PmtInfId;
  var $_SeqTp;
  var $_CdtrNm;
  var $_CdtrId;
  var $_CdtrIBAN;
  var $_CdtrBIC;
  var $_ReqdColltnDt;

  var $_transactions = array();

  function __construct() {
    $this->_PmtInfId = substr("G" . md5(mt_rand(0,32) . time()), 0, 8);
  }

  function getPaymentId() {
    return $this->_PmtInfId;
  }

  function getCreditorName() {
    return $this->_CdtrNm;
  }

  function setCreditorName($name) {
    $this->_CdtrNm = $this->str2epc($name, 70);
  }

  function getCreditorId() {
    return $this->_CdtrId;
  }

  function setCreditorId($id) {
    $this->_CdtrId = substr($id, 0, 69);  // TODO: String Len
  }

  function getCreditorIBAN() {
    return $this->_CdtrIBAN;
  }

  function setCreditorIBAN($iban) {
    if ($this->verifyIBAN($iban)) 
      $this->_CdtrIBAN = $iban;  
    else
      throw new Exception("Ungültige IBAN: " . $iban);
  }

  function getCreditorBIC() {
    return $this->_CdtrBIC;
  }

  function setCreditorBIC($bic) {
    if ($this->verifyBIC($bic)) 
      $this->_CdtrBIC = $bic;  
    else
      throw new Exception("Ungültige BIC: " . $bic);
  }

  // TYP:
  //   "FRST" Wiederkehrend: Erster Einzug einer Lastschrift regelmässiger Lastschriften
  //   "RCUR" Wiederkehrend: Folgelastschrift reglemässiger Lastschriften
  //   "FNAL" Wiederkehrend: Letztmalige Lastschrift regelmässiger Lastschriften
  //   "OOFF" Einmalige Lastschrift
  function setSequenceType($type) {
    $type = strtoupper($type);
    if (!in_array($type, array('FRST', 'RCUR', 'FNAL', 'OOFF'))) {
      throw new Exception("Invalid Sequence Type: $type");
    }
    $this->_SeqTp = $type;
  }

  function getSequenceType() {
    return $this->_SeqTp;
  }

  function getRequestedCollectionDate() {
    return $this->_ReqdColltnDt;
  }

  // Fälligkeitsdatum
  //
  // Im Vergleich zur deutschen DTA Lastschrift sit die SEPA Lastschrift nicht per Sicht fällig,
  // sondern muss mit einerer entsprechenden Vorlauffrist bei der Bank des Debitors vorliegen 
  // und daher auch rechtzeitig durch den Kreditor versandt werden.
  //
  // Die einzuhaltenden Vorlauffristen vor Fälligkeit sind:
  // 5 Bankarbeitstage bei FRST und OOFF = 7 (inkl. Wochenende)
  // 2 Bankarbeitstage bei RCUR und FNAL = 5 (inkl. Wochenende) 
  //
  function setRequestedCollectionDate($date) {
    if ($this->verifyISODate($date))
      $this->_ReqdColltnDt = $date;
    else 
      throw new Exception("Ungültiges ISO Datum: ". $date);

  }

  function getControlSum() {
    $sumCents = 0;
    foreach ($this->_transactions as $t) {
      $sumCents += $t->getAmountCents();
    }

    return sprintf("%01.2f", ($sumCents / 100));
  }

  function getNumberOfTransactions() {
    return count($this->_transactions);
  }

  function addTransaction($transaction) {
    $this->_transactions[] = $transaction;
  }

  function createXMLNode($doc, $ns) {
    $pmt = $doc->createElementNS($ns, "PmtInf");

    $pmt->appendChild($doc->createElementNS($ns,'PmtInfId', $this->getPaymentId()));
    $pmt->appendChild($doc->createElementNS($ns,'PmtMtd', 'DD'));
    $pmt->appendChild($doc->createElementNS($ns,'NbOfTxs', $this->getNumberOfTransactions()));
    $pmt->appendChild($doc->createElementNS($ns,'CtrlSum', $this->getControlSum()));
    $pmttpinf = $pmt->appendChild($doc->createElementNS($ns,'PmtTpInf'));
    $pmttpinf->appendChild($doc->createElementNS($ns,'SvcLvl'))->appendChild($doc->createElementNS($ns, 'Cd', 'SEPA'));
    $pmttpinf->appendChild($doc->createElementNS($ns,'LclInstrm'))->appendChild($doc->createElementNS($ns, 'Cd', 'CORE'));
    $pmttpinf->appendChild($doc->createElementNS($ns,'SeqTp', $this->getSequenceType()));
    $pmt->appendChild($doc->createElementNS($ns,'ReqdColltnDt', $this->getRequestedCollectionDate()));
    $pmt->appendChild($doc->createElementNS($ns,'Cdtr'))->appendChild($doc->createElementNS($ns, 'Nm', $this->getCreditorName()));
    $pmt->appendChild($doc->createElementNS($ns,'CdtrAcct'))->appendChild($doc->createElementNS($ns, 'Id'))->appendChild($doc->createElementNS($ns, 'IBAN', $this->getCreditorIBAN()));
    $pmt->appendChild($doc->createElementNS($ns,'CdtrAgt'))->appendChild($doc->createElementNS($ns, 'FinInstnId'))->appendChild($doc->createElementNS($ns, 'BIC', $this->getCreditorBIC()));
    $pmt->appendChild($doc->createElementNS($ns,'ChrgBr', 'SLEV'));
    $crdr = $pmt->appendChild($doc->createElementNS($ns,'CdtrSchmeId'))->appendChild($doc->createElementNS($ns, 'Id'))->appendChild($doc->createElementNS($ns, 'PrvtId'))->appendChild($doc->createElementNS($ns, 'Othr'));
    $crdr->appendChild($doc->createElementNS($ns,'Id', $this->getCreditorId()));
    $crdr->appendChild($doc->createElementNS($ns,'SchmeNm'))->appendChild($doc->createElementNS($ns,'Prtry','SEPA'));

    foreach ($this->_transactions as $t) {
      $pmt->appendChild($t->createXMLNode($doc, $ns));
    }

    return $pmt;
  } 
}

/**
 * SEPA_DD_Transaction
 * Subklasse der SEPA SEPAPaymentInfo
 *
 * @package SEPA
 * @author Markus Garscha
 **/
class SEPA_DD_Transaction extends SEPA_BASE {
  var $_amountCents = 0;
  var $_EndToEndId;
  var $_MandateId;
  var $_MandateSignatureDate;
  var $_BIC;
  var $_IBAN;
  var $_DbtrNm;
  var $_RmtInf; // remittanceInformation

  function __construct() {
    $this->_EndToEndId = substr(md5(mt_rand(0,32) . time()), 0, 8);
  }

  function getAmountCents() {
    return $this->_amountCents;
  }

  function getAmountEuros() {
    return sprintf("%01.2f", ($this->getAmountCents() / 100));
  }

  function setAmount($amount) {
    $amount+= 0;
    if (is_float($amount)) {
      $amount= (integer)($amount * 100);
    }

    $this->_amountCents = $amount;
  }

  function getEndToEndId() {
    return $this->_EndToEndId;
  }

  function setEndToEndId($id) {
    $this->_EndToEndId = $id;
  }

  function getMandateId() {
    return $this->_MandateId;
  }

  // Mandatsreferenz:
  // Ein individuell vergebenes Kennzeichen eines Mandates, z.B. Rechnungs-Nr oder Kunden-Nr.
  function setMandateId($id) {
    if ($this->verifyRestrictedIdSEPA2($id)) 
      $this->_MandateId = $id;
    else
      throw new Exception("Ungültige MandatsId: " . $id);
  }

  function getMandateSignatureDate() {
    return $this->_MandateSignatureDate;
  }

  function setMandateSignatureDate($date) {
    // TODO: Check ISO Date Formate "YYYY-MM-DD"
    $this->_MandateSignatureDate = $date;
  }

  function getName() {
    return $this->_DbtrNm;
  }

  function setName($name) {
    $this->_DbtrNm = $this->str2epc($name,70);
  }

  function getBIC() {
    return $this->_BIC;
  }

  function setBIC($bic) {
    if ($this->verifyBIC($bic)) 
      $this->_BIC= $bic;
    else
      throw new Exception("Ungültige BIC: " . $bic);
  }

  function getIBAN() {
    return $this->_IBAN;
  }

  function setIBAN($iban) {
    if ($this->verifyIBAN($iban)) 
      $this->_IBAN= $iban;
    else
      throw new Exception("Ungültige IBAN: " . $iban);
  }

  function getInfo() {
    return $this->_RmtInf;
  }

  function setInfo($info) {
    $this->_RmtInf = substr($info,0,140);
  }

  function createXMLNode($doc, $ns) {
    $dbt = $doc->createElementNS($ns, "DrctDbtTxInf");

    $dbt->appendChild($doc->createElementNS($ns,'PmtId'))->appendChild($doc->createElementNS($ns,'EndToEndId', $this->getEndToEndId()));
    $dbt->appendChild($doc->createElementNS($ns,'InstdAmt', $this->getAmountEuros()))->setAttribute('Ccy', 'EUR');

    // Mandat, Einzugsermächtigung
    $mndt1 = $dbt->appendChild($doc->createElementNS($ns,'DrctDbtTx'))->appendChild($doc->createElementNS($ns,'MndtRltdInf'));
    $mndt1->appendChild($doc->createElementNS($ns,'MndtId', $this->getMandateId()));
    $mndt1->appendChild($doc->createElementNS($ns,'DtOfSgntr', $this->getMandateSignatureDate()));

    $dbt->appendChild($doc->createElementNS($ns,'DbtrAgt'))->appendChild($doc->createElementNS($ns, 'FinInstnId'))->appendChild($doc->createElementNS($ns, 'BIC', $this->getBIC()));
    $dbt->appendChild($doc->createElementNS($ns,'Dbtr'))->appendChild($doc->createElementNS($ns, 'Nm', $this->getName()));
    $dbt->appendChild($doc->createElementNS($ns,'DbtrAcct'))->appendChild($doc->createElementNS($ns, 'Id'))->appendChild($doc->createElementNS($ns, 'IBAN', $this->getIBAN()));
    $info = $dbt->appendChild($doc->createElementNS($ns,'RmtInf'));
    $info->appendChild($doc->createElementNS($ns, 'Ustrd', $this->getInfo()));

    return $dbt;
  }

  function toTXT() {
    $s = "ID ................: " . $this->getEndToEndId() . "\n";
    $s .= "Name ..............: " . $this->getName() . "\n";
    $s .= "BIC ...............: " . $this->getBIC() . "\n";
    $s .= "IBAN ..............: " . $this->getIBAN() . "\n";
    $s .= "Mandat ............: " . $this->getMandateId() . "\n";
    $s .= "Betrag ............: " . $this->getAmountEuros() . "\n";
    $s .= "VWZ ...............: " . $this->getInfo() . "\n";

    return $s;
  } 

}


?>
