<?php

define('FPDF_FONTPATH','./font/');
require('./fpdf.php');
// require_once ("dbconn.inc.php");
require_once("./DbBase.php");
require_once("./verein.php");
require_once("./beitrag.class.php");
require_once('./Log.php');

define('REPORT_MITGLIEDER_LISTE','mitglieder');
define('REPORT_MITGLIEDER_KURZ','mitglieder_kurz');
define('REPORT_BEITRAG','beitrag');
define('REPORT_JUBI','jubi');
define('REPORT_GEBURTSTAG','geburtstag');
define('EURO', chr(128));

class PDF extends FPDF
{
	var $report_type = "";
	var $year = 0 ;
	var $CellWidth_Mitglied = array(18,50,55,40,50,30,30);
	var $CellWidth_Beitrag =  array(50,50,60,25);
	var $CellWidth_Geburtstag =  array(130,30,25) ;
	protected $db;
	
    public function __construct() { 

		error_log("DbBase::__Construct: vor new mysqli");
		$this->db = new DbBase();

		parent::__construct();
	}

	function Header()
	{
		//Title
		if( $this->report_type == REPORT_MITGLIEDER_LISTE )
		{
			$this->SetFont('Arial','',18);
			$this->Cell(0,6,'Mitgliederliste',0,1,'C');
			$this->Ln(10);

			$header=array('Nr','Name','Anschrift','Tel1 / Tel2','Fax/eMail','GebDat/EinDat', 'SonderDat/AusDat');
	
			// Colors, line width and bold font
			$this->SetFillColor(192,192,192);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','',10);
	
			//Header
			for($i=0;$i<count($this->CellWidth_Mitglied);$i++)
				$this->Cell($this->CellWidth_Mitglied[$i],7,$header[$i],1,0,'C',1);
			$this->Ln();
		}
		if( $this->report_type == REPORT_BEITRAG )
		{
			$header=array('Mitglied','Kontoinhaber','Beitragstext','Beitrag in '. EURO);

			$this->SetFont('Arial','',18);
			$this->Cell(0,6,'Beitragsliste',0,1,'C');
			$this->Ln(10);

			// Colors, line width and bold font
			$this->SetFillColor(192,192,192);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','',10);
	
			//Header
			for($i=0;$i<count($header);$i++)
					$this->Cell($this->CellWidth_Beitrag[$i],7,$header[$i],1,0,'C',1);
			$this->Ln();
		}
		
		if( $this->report_type == REPORT_GEBURTSTAG )
		{
			$header=array('Name','Geburtsdatum',iconv('UTF-8', 'windows-1252', 'Jubiläum'));

			$this->SetFont('Arial','',18);
			$this->Cell(0,6,'Geburtstagsliste ' . $this->year, 0, 1, 'C');
			$this->Ln(10);

			// Colors, line width and bold font
			$this->SetFillColor(192,192,192);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','',12);
	
			//Header
			for($i=0;$i<count($header);$i++)
					$this->Cell($this->CellWidth_Geburtstag[$i],7,$header[$i],1,0,'C',1);
			$this->Ln();
		}
		if( $this->report_type == REPORT_JUBI )
		{
			$header=array('Name','Eintrittsdatum',iconv('UTF-8', 'windows-1252', 'Jubiläum'));

			$this->SetFont('Arial','',18);
			$this->Cell(0,6,iconv('UTF-8', 'windows-1252', 'Jubiläumsliste ' . $this->year), 0, 1, 'C' );
			$this->Ln(10);

			// Colors, line width and bold font
			$this->SetFillColor(192,192,192);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('Arial','',12);
	
			//Header
			for($i=0;$i<count($header);$i++)
					$this->Cell($this->CellWidth_Geburtstag[$i],7,$header[$i],1,0,'C',1);
			$this->Ln();
		}

	//Ensure table header is output
		parent::Header();
	}

	//Page footer
  function Footer()
  {
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    
    $verein = new CVerein();
    $this->Cell(70,10,$verein->get("name") ,0,0,'L');
	
	//Page number
	$this->SetX($this->lMargin);
	$this->Cell(0,10,'Seite: '.$this->PageNo().'/{nb}' ,0,0, 'C' );
	
	$this->SetX($this->lMargin);
    $this->Cell(0,10,"Datum: ".date("d.m.Y"),0,0,'R');
    $this->Ln();
  }

	function setReport($Report)
	{
		$this->report_type = $Report ;
	}

	function setYear($year)
	{
		$this->year = $year ;
	}

	// Mitglieder Tabelle
	function Table_Mitglieder()
	{
		$header=array('Nr','Name','Anschrift','Tel1 / Tel2','Fax/eMail','GebDat/EinDat');
		// $w=array(10,45,44,30,30,30);

		//Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',8);
		
		//Data
		$query = "Select memberId,anrede,titel,zusatz,nachname,vorname,strasse,plz,ort,telefon1,telefon2,telefax,email,gebdat,eindat,sonderdat,ausdat from mitglied order by nachname";
		$res = $this->db->query($query) 
		 	or die('Error: '.mysql_error()."<BR>Query: $query");
		$log  = Log::singleton('file', 'log/mv.log', 'listen_liste.php', false, PEAR_LOG_INFO);
	  	$log->log("SQL = '$query'");
		$fill=0;
		$iCount = 0 ;
		while($row = $res->fetch_array(MYSQLI_BOTH))
		{
			$this->Cell($this->CellWidth_Mitglied[0],6,$row['memberId'],'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[1],6,$row['anrede'] . " " . $row['titel'] . " " . $row['zusatz'],'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[2],6,iconv('UTF-8', 'windows-1252', $row['strasse']),'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[3],6,$row['telefon1'],'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[4],6,$row['telefax'],'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[5],6,substr($row['gebdat'],8,2) . "." . substr($row['gebdat'],5,2) . "." . substr($row['gebdat'],0,4),'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[6],6,substr($row['sonderdat'],8,2) . "." . substr($row['sonderdat'],5,2) . "." . substr($row['sonderdat'],0,4),'LR',0,'L',$fill);
			$this->Ln();
			$this->Cell($this->CellWidth_Mitglied[0],6,'','LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[1],6,iconv('UTF-8', 'windows-1252', $row['nachname']) . ", " . iconv('UTF-8', 'windows-1252', $row['vorname']),'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[2],6,$row['plz'] . " " . $row['ort'],'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[3],6,$row['telefon2'],'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[4],6,$row['email'],'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[5],6,substr($row['eindat'],8,2) . "." . substr($row['eindat'],5,2) . "." . substr($row['eindat'],0,4),'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Mitglied[6],6,substr($row['ausdat'],8,2) . "." . substr($row['ausdat'],5,2) . "." . substr($row['ausdat'],0,4),'LR',0,'L',$fill);
			$this->Ln();
			$fill=!$fill;
			$iCount++;
		}
		$this->SetFillColor(220,220,220);
		$this->Cell($this->CellWidth_Mitglied[0],6,'',1,0,'L',$fill);
		$this->Cell($this->CellWidth_Mitglied[1],6,"$iCount Mitglieder",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Mitglied[2],6,"",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Mitglied[3],6,"",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Mitglied[4],6,"",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Mitglied[5],6,"",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Mitglied[6],6,"",1,0,'L',$fill);
		$this->Ln();
	}
	// Beitrags Tabelle
	function Table_Beitrag()
	{
		$header=array('Name','Beitragstext','Beitrag in EUR');

		//Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',10);
		
		//Data
		$Beitrag = new CBeitrag() ;
		$query = $Beitrag->getBeitragSql("","","");

		// echo $query;
		$res= $this->db->query($query);
		$log  = Log::singleton('file', 'log/beitrag.log', 'listen_liste.php', false, PEAR_LOG_INFO);
		$log->log("SQL = '$query'");
    	$fill=0;
		$old_id = "" ;
		$beitrag_summe = array();
		$beitrag_text = array();
		while($row= $res->fetch_array(MYSQLI_BOTH))
		{
			$id = $row['memberId'];
			$beitrag_id = $row['beitrag_id'];
			$alterMitglied = $row['mitgl_alter'];
			$beitragwert = $Beitrag->getBeitrag($Beitrag->getIndexForId($beitrag_id),$alterMitglied);
			$log->log("Mitglied: $id beitrag_id=$beitrag_id, alterMitglied=$alterMitglied, beitragwert=$beitragwert");
			
			if ($old_id != $id )
			{
				$fill=!$fill;
				$this->Cell($this->CellWidth_Beitrag[0],6,iconv('UTF-8', 'windows-1252', $row['nachname']) . ", " . iconv('UTF-8', 'windows-1252', $row['vorname']) . ' (' . $alterMitglied . ')','LR',0,'L',$fill);
				$this->Cell($this->CellWidth_Beitrag[1],6, iconv('UTF-8', 'windows-1252', $row['kontoinhaber']),'LR',0,'L',$fill);
			}
			else
			{
				$this->Cell($this->CellWidth_Beitrag[0],6,"",'LR',0,'L',$fill);
				$this->Cell($this->CellWidth_Beitrag[1],6,"",'LR',0,'L',$fill);
			}
			$this->Cell($this->CellWidth_Beitrag[2],6,iconv('UTF-8', 'windows-1252', $row['bezeichnung']),'LR',0,'L',$fill);
			$this->Cell($this->CellWidth_Beitrag[3],6,sprintf('%8.2f ' . EURO, $beitragwert),'LR',0,'R',$fill);
			$this->Ln();
			$old_id = $id ;

			if( !isset($beitrag_summe[$beitrag_id]) )
			  $beitrag_summe[$beitrag_id] = 0 ;
			$beitrag_summe[$beitrag_id] += $beitragwert;
			if( !isset($beitrag_text[$beitrag_id]) )
				$beitrag_text[$beitrag_id] = $row['bezeichnung'] ;
		}
		// Summen ausgeben
		$s = 0.0;
		$this->SetFillColor(220,220,220);
		foreach( $beitrag_summe as $t => $s)
		{
			if( $s > 0 )
			{
				$this->Cell($this->CellWidth_Beitrag[0],6,"",1,0,'L',true);
				$this->Cell($this->CellWidth_Beitrag[1],6,"Gesamt",1,0,'L',true);
				$this->Cell($this->CellWidth_Beitrag[2],6,$beitrag_text[$t],1,0,'L',true);
				$this->Cell($this->CellWidth_Beitrag[3],6,sprintf('%8.2f ' . EURO,$s),1,0,'R',true);
				$this->Ln();
			}
		}
	}

	// Beitrags Tabelle
	function Table_Geburtstag($current_year)
	{
		//Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		
		if( $current_year < 2000 )
		  $current_year = date('Y');
		  
		//Data
		$query = "SELECT nachname,vorname,year(gebdat) AS jahr, gebdat FROM mitglied"; 
		$query .= " WHERE gebdat != '0000-00-00'";
		$query .= " ORDER BY DAYOFYEAR( gebdat ) ";
		$res = $this->db->query($query);
		$log  = Log::singleton('file', 'log/mv.log', 'listen_liste.php', false, PEAR_LOG_INFO);
	  	$log->log("SQL = '$query'");

		$fill   = 0;
		$iCount = 0;
		while($row = $res->fetch_array(MYSQLI_BOTH))
		{
			$year = $row['jahr']; 
			$yd = $current_year - $year;
			if( (($yd % 10 == 0) && ($yd >=50)) ||
			    (($yd % 5 == 0) && ($yd >=80)) )
			{
				$this->SetFont('Arial','',12);
				$this->Cell($this->CellWidth_Geburtstag[0],6,iconv('UTF-8', 'windows-1252', $row['nachname']) . ", " . iconv('UTF-8', 'windows-1252', $row['vorname']),'LR',0,'L',$fill);
				$this->Cell($this->CellWidth_Geburtstag[1],6,substr($row['gebdat'],8,2) . "." . substr($row['gebdat'],5,2) . "." . substr($row['gebdat'],0,4),'LR',0,'R',$fill);
				$this->SetFont('Arial','b',14);
				$this->Cell($this->CellWidth_Geburtstag[2],6,$yd,'LR',0,'R',$fill);
				$this->Ln();
				$fill=!$fill;
				$iCount++;
			}
		}
		$this->SetFillColor(220,220,220);
		$this->Cell($this->CellWidth_Geburtstag[0],6,"$iCount runde Geburtstage",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Geburtstag[1],6,"",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Geburtstag[2],6,"",1,0,'L',$fill);
		$this->Ln();
}


	// Beitrags Tabelle
	function Table_Jubi($current_year)
	{
		//Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		
		if( $current_year < 2000 )
		  $current_year = date('Y');
		
		  //Data
		$query = "SELECT nachname,vorname,year(eindat) AS jahr, eindat FROM mitglied"; 
		$query .= " WHERE eindat != '0000-00-00'";
		$query .= " ORDER BY DAYOFYEAR( eindat ) ";
		$res = $this->db->query($query);
		$log  = Log::singleton('file', 'log/mv.log', 'listen_liste.php', false, PEAR_LOG_INFO);
	  	$log->log("SQL = '$query'");
	
		$fill   = 0;
		$iCount = 0;
		while($row = $res->fetch_array(MYSQLI_BOTH))
		{
			$year = $row['jahr']; 
			$yd = $current_year - $year;
			if( ($yd % 5 == 0) && ($yd >=15) )
			{
				$this->SetFont('Arial','',12);
				$this->Cell($this->CellWidth_Geburtstag[0],6,iconv('UTF-8', 'windows-1252', $row['nachname']) . ", " . iconv('UTF-8', 'windows-1252', $row['vorname']),'LR',0,'L',$fill);
				$this->Cell($this->CellWidth_Geburtstag[1],6,substr($row['eindat'],8,2) . "." . substr($row['eindat'],5,2) . "." . substr($row['eindat'],0,4),'LR',0,'R',$fill);
				$this->SetFont('Arial','b',14);
				$this->Cell($this->CellWidth_Geburtstag[2],6,$yd,'LR',0,'R',$fill);
				$this->Ln();
				$fill=!$fill;
				$iCount++;
			}
		}
		$this->SetFillColor(220,220,220);
		$this->Cell($this->CellWidth_Geburtstag[0],6,"$iCount runde Geburtstage",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Geburtstag[1],6,"",1,0,'L',$fill);
		$this->Cell($this->CellWidth_Geburtstag[2],6,"",1,0,'L',$fill);
		$this->Ln();
	}

}

	$report_type = $_REQUEST['liste'];
	$Jahr = isset($_REQUEST['year'])?$_REQUEST['year']:"" ; 

	// Delete old reports
	$tmpdir = getcwd()."/tmp/";
	$log  = Log::singleton('file', 'log/mv.log', 'listen_liste.php', false, PEAR_LOG_INFO);
	$log->log("temp dir = $tmpdir");
	if( !is_dir($tmpdir) )
		mkdir($tmpdir);
	if ($handle = opendir($tmpdir)) 
	{
		while (false !== ($file = readdir($handle))) 
		{
			if( is_file($tmpdir.$file) )
				unlink($tmpdir.$file);
		}
		closedir($handle); 
	}

	$pdf=new PDF();
	$pdf->setYear($Jahr);
	$pdf->AliasNbPages();
	$pdf->setReport($report_type);

	if( $report_type == 'mitglieder' )
	{
		$pdf->AddPage('L', 'A4');
		$pdf->Table_Mitglieder();
	}
	if( $report_type == 'beitrag' )
	{
		$pdf->AddPage('P', 'A4');
		$pdf->Table_Beitrag();
	}
	if( $report_type == 'geburtstag' )
	{
		$pdf->AddPage('P', 'A4');
		$pdf->Table_Geburtstag($Jahr);
	}
	if( $report_type == 'jubi' )
	{
		$pdf->AddPage('P', 'A4');
		$pdf->Table_Jubi($Jahr);
	}
	
	$file = tempnam($tmpdir,'lst');
	rename($file,$file.'.pdf');
	$file.='.pdf';    
	$pdf->Output($file,'I');
	// $file = basename($file);
	// echo "<HTML><SCRIPT>document.location='./tmp/$file';</SCRIPT></HTML>";
	
	exit();
