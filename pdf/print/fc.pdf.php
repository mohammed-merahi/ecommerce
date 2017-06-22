<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
require_once('tcpdf_include.php');

$police = 'times';

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
// $pdf->SetHeaderData('logo.png', 30, '', '', array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/fra.php')) {
	require_once(dirname(__FILE__).'/lang/fra.php');
	$pdf->setLanguageArray($l);
}

//---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
// $pdf->SetFont($police, '', 11, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
// $pdf->AddPage();

// set text shadow effect
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// extend TCPF with custom functions
class MYPDF extends TCPDF {

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(0);
        $this->SetFont($police, 'B');
        // Header
        $this->SetFillColor(237,237,237);
        $w = array(10, 15, 90, 15, 30,30);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C', 1);
        }
        $this->Ln();

        //Color and font restoration
        $this->SetFillColor(250,250,250);
        //$this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont($police);
        // Data
        $fill = 0;


/*****************************************************************************************/

		//connexion à la base de données

		include('../../db.php');
		$code = filter_var( $_GET['id'] , FILTER_SANITIZE_STRING);
		$query = "SELECT codeart, designation, qte, prix_org FROM ventes WHERE num_piece='$code' AND piece='FC' ";
        
		$rows = mysql_query ($query);
        //echo $query;exit;

		$j = 0;
		while( $row = mysql_fetch_assoc($rows) ){
            if( $j == 0 ){
                    $B = 'TB';
            }else
                $B = 'TB';

            $this->Cell($w[0], 6, $j+1, $B, 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['codeart'], $B, 0, 'L', $fill);
            $this->Cell($w[2], 6, $row['designation'], $B, 0, 'L', $fill);		
            $this->Cell($w[3], 6, $row['qte'], $B, 0, 'R', $fill);		
            $this->Cell($w[4], 6, number_format( $row['prix_org'],2,',',' '), $B, 0, 'R', $fill);
            $this->Cell($w[5], 6, number_format( $row['prix_org'] * $row['qte'],2,',',' '), $B, 0, 'R', $fill);
            
            $this->Ln();
            $fill=!$fill;
			$j++;
        }     
        
            //totaux
            $this->SetFillColor(255,255,255);
            $query = "SELECT    fcs.date as fcs_date,
                                clients.raison as raison,
                                clients.adresse,
                                clients.ville, 
                                clients.pays,
                                clients.departement,
                                clients.telephone,
                                clients.mail,
                                clients.mobile,
                                fcs.total_ht,
                                fcs.total_tva,
                                fcs.remise,
                                fcs.remisep,
                                fcs.timbre,
                                taxe_supp
                            FROM fcs 
                            LEFT JOIN clients ON fcs.codeclient=clients.codeclient 
                            WHERE fcs.code='$code' ";
        
            $rows = mysql_query($query);
            
            while( $row = mysql_fetch_assoc($rows) ){
                //les totaux
                $net_ht    = $row['total_ht'];
                $total_ht  = $net_ht + $row['remise'];
                $tot_ttc   = $net_ht + $row['total_tva'];
                $taxe_supp = $row['taxe_supp'];
                $net       = $tot_ttc + $row['timbre'] + $taxe_supp;  
                
                //Total HT
                $this->Cell($w[0], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[1], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[2], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[3], 8, '', '', 0, 'L', $fill);
                $this->SetFont($police, 'B', 10);
                $this->Cell($w[4], 8, 'Total HT', $B, 0, 'L', $fill);
                $this->SetFont($police, '', 10);
                $this->Cell($w[5], 8, number_format( $total_ht,2,',',' ') . ' DA', $B, 0, 'R', $fill);                
                $this->Ln();
                $fill=!$fill;
                //Remise
                $this->Cell($w[0], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[1], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[2], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[3], 8, '', '', 0, 'L', $fill);
                $this->SetFont($police, 'B', 10);
                $this->Cell($w[4], 8, 'Remise (' . number_format($row['remisep'], 2,',',' ') . '%)' , $B, 0, 'L', $fill);
                $this->SetFont($police, '', 10);
                $this->Cell($w[5], 8, number_format( $row['remise'],2,',',' ') . ' DA', $B, 0, 'R', $fill);                
                $this->Ln();
                $fill=!$fill;
                //Net HT
                $this->Cell($w[0], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[1], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[2], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[3], 8, '', '', 0, 'L', $fill);
                $this->SetFont($police, 'B', 10);
                $this->Cell($w[4], 8, 'Net HT', $B, 0, 'L', $fill);
                $this->SetFont($police, '', 10);
                $this->Cell($w[5], 8, number_format( $net_ht,2,',',' ') . ' DA', $B, 0, 'R', $fill);                
                $this->Ln();
                $fill=!$fill;
                //Total TVA
                $this->Cell($w[0], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[1], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[2], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[3], 8, '', '', 0, 'L', $fill);
                $this->SetFont($police, 'B', 10);
                $this->Cell($w[4], 8, 'Total TVA', $B, 0, 'L', $fill);
                $this->SetFont($police, '', 10);
                $this->Cell($w[5], 8, number_format( $row['total_tva'],2,',',' ') . ' DA', $B, 0, 'R', $fill);                
                $this->Ln();
                $fill=!$fill;
                //Total TTC
                $this->Cell($w[0], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[1], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[2], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[3], 8, '', '', 0, 'L', $fill);
                $this->SetFont($police, 'B', 10);
                $this->Cell($w[4], 8, 'Total TTC', $B, 0, 'L', $fill);
                $this->SetFont($police, '', 10);
                $this->Cell($w[5], 8, number_format( $tot_ttc,2,',',' ') . ' DA', $B, 0, 'R', $fill);                
                $this->Ln();
                $fill=!$fill;
                //Timbre fiscal
                if( $row['timbre'] != 0 ){
                    $this->Cell($w[0], 8, '', '', 0, 'L', $fill);
                    $this->Cell($w[1], 8, '', '', 0, 'L', $fill);
                    $this->Cell($w[2], 8, '', '', 0, 'L', $fill);
                    $this->Cell($w[3], 8, '', '', 0, 'L', $fill);
                    $this->SetFont($police, 'B', 10);
                    $this->Cell($w[4], 8, 'Timbre fiscal', $B, 0, 'L', $fill);
                    $this->SetFont($police, '', 10);
                    $this->Cell($w[5], 8, number_format( $row['timbre'],2,',',' ') . ' DA', $B, 0, 'R', $fill);                
                    $this->Ln();
                    $fill=!$fill;
                }
                //Taxe supp
                if( $taxe_supp != 0 ){
                    $this->Cell($w[0], 8, '', '', 0, 'L', $fill);
                    $this->Cell($w[1], 8, '', '', 0, 'L', $fill);
                    $this->Cell($w[2], 8, '', '', 0, 'L', $fill);
                    $this->Cell($w[3], 8, '', '', 0, 'L', $fill);
                    $this->SetFont($police, 'B', 10);
                    $this->Cell($w[4], 8, 'Taxe supp', $B, 0, 'L', $fill);
                    $this->SetFont($police, '', 10);
                    $this->Cell($w[5], 8, number_format( $taxe_supp,2,',',' ') . ' DA', $B, 0, 'R', $fill);                
                    $this->Ln();
                    $fill=!$fill;
                }
                //Net à payer
                $this->Cell($w[0], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[1], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[2], 8, '', '', 0, 'L', $fill);
                $this->Cell($w[3], 8, '', '', 0, 'L', $fill);
                $this->SetFont($police, 'B', 10);
                $this->Cell($w[4], 8, 'Net à payer', $B, 0, 'L', $fill);
                $this->SetFont($police, '', 10);
                $this->Cell($w[5], 8, number_format( $net,2,',',' ') . ' DA', $B, 0, 'R', $fill);                
                $this->Ln();
                $fill=!$fill;            
                //reglements
                // Header
                $this->SetY( $this->GetY() - 47 );
                $this->SetFillColor(237,237,237);
                $w = array(7, 20, 20, 20, 20);
                $header = array("N°","Date","Modalité","Montant","N° chèque");
                $num_headers = count($header);
                for($i = 0; $i < $num_headers; ++$i) {
                    $this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C', 1);
                }
                $this->Ln();
                
                
                $query = "SELECT    reglements_pieces.id,
                                    reglements_pieces.regler,
                                    reglements.date as date_reg,
                                    reglements.mode,
                                    reglements.num_cheque
                            FROM fcs 		
                            LEFT JOIN reglements_pieces ON fcs.code=reglements_pieces.num_piece
                            LEFT JOIN reglements        ON reglements.code=reglements_pieces.num_reg
                            WHERE fcs.code='$code' 
                                AND reglements_pieces.piece='FC'";
                $rows = mysql_query($query);
            
                $this->SetFillColor(250,250,250);
                while( $row = mysql_fetch_assoc($rows) ){
                    $this->Cell($w[0], 8, $row['id'], $B, 0, 'L', $fill);
                    $this->Cell($w[1], 8, date('d-m-Y', strtotime($row['date_reg'])), $B, 0, 'L', $fill);
                    $this->Cell($w[2], 8, $row['mode'], $B, 0, 'C', $fill);
                    $this->Cell($w[3], 8, number_format($row['regler'], 2,',',' '), $B, 0, 'R', $fill);
                    $this->Cell($w[4], 8, $row['num_cheque'], $B, 0, 'L', $fill);
                    $this->Ln();
                    $fill=!$fill;
                }
                
                
                include('../../ChiffresEnLettres.php');
                $lettre = new chiffreEnLettre();
                $this->SetY( $this->GetY() + 36 );
                $this->SetFont($police, 'B', 12);
                $this->Cell($w[4], 8, "Arrêter la présente facture à la somme de : ", '', 0, 'L', $fill);
                $this->SetY( $this->GetY() + 6 );
                $this->SetFont($police, '', 10);
                $this->Cell($w[4], 8, ucfirst( $lettre->ConvNumberLetter($net, 1, 0) ), '', 0, 'L', $fill);
                
            }
                        
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetTitle("Facture");

// remove default header/footer
$pdf->setPrintHeader(false);
// ---------------------------------------------------------

// set font
$pdf->SetFont($police, '', 10);

// add a page
$pdf->AddPage('P', 'A4');

// column titles
$header = array('#', 'Code', 'Désignation', 'Qté', 'PU HT', 'Montant HT');

include('../../db.php');
$code = filter_var( $_GET['id'] , FILTER_SANITIZE_STRING);

$pdf->SetFont($police, '', 14);
$html = "<br><br><br><br><table><tr><td></td><td><b>Facture N° " . $code . "</b></td><td>" . "</td></tr></table><br><br><br><br>";
$pdf->writeHTML($html, true, false, true, false, '');

//partie societe
//LOGO ----------------------------------------------------------------
$query2 = "SELECT id,
                 photo,
                 extention
            FROM mylogo";     //echo $query2;
$res2 = mysql_query( $query2 );
while( $a = mysql_fetch_assoc($res2) ){                            
    $res11 = $a['photo'];                            
    $img = gzuncompress( $res11 );
    $file =  'logo_img' . $a['extention'];
    file_put_contents($file, $img);                            
    //echo "<br><img class='col-md-6 col-sm-6 col-xs-6' src='$file' ><br>";
}

$pdf->SetXY(10, 15);
$pdf->Image($file, '', '', 25, 25, '', '', 'T', false, 300, '', false, false, 0, false, false, false);//0 pour la bordure
// $pdf->ImageSVG($file='images/logo.svg', $x=15, $y=20, $w=15, $h=15, $link='', $align='', $palign='', $border=0, $fitonpage=false);

$pdf->SetFont($police, '', 11);
$html =
"<br><br><br><br><br><br><table>
<tr><td>
	<p>";
	
$query1 = "SELECT   raison, 
                    statut, 
                    adresse, 
                    ville, 
                    departement, 
                    pays,
                    telephone,
                    mobile,
                    mail
                FROM mysociete";  
$res1  = mysql_query($query1);
while( $i1 = mysql_fetch_assoc($res1) ){
    $raison  = $i1['raison'];   
    $statut  = $i1['statut'];   
    $adresse = $i1['adresse'];   
    $ville   = $i1['ville'];   
    $dep     = $i1['departement'];   
    $pays    = $i1['pays'];   
    $tel     = $i1['telephone'];   
    $mobile  = $i1['mobile'];   
    $mail    = $i1['mail'];   
}

$html .= "<strong>" . $raison  . "</strong>" . 
         "<br>" . $adresse .
         "<br>" . $ville   . ", " . $dep . ", " . $pays . 
         "<br>Téléphone: " . $tel     .
         "<br>Mobile: " . $mobile  .
         "<br>Email: " . $mail;

//partie client
$code = filter_var( $_GET['id'] , FILTER_SANITIZE_STRING);
//le numero du client
$query = "SELECT    fcs.date as fcs_date,
                    clients.raison as raison,
                    clients.adresse,
                    clients.ville, 
                    clients.pays,
                    clients.departement,
                    clients.telephone,
                    clients.mail,
                    clients.mobile,
                    fcs.total_ht,
                    fcs.total_tva,
                    fcs.remise,
                    fcs.remisep,
                    fcs.timbre
                FROM fcs 
                LEFT JOIN clients ON fcs.codeclient=clients.codeclient 
                WHERE fcs.code='$code' ";

$res = mysql_query ($query);

while( $r = mysql_fetch_assoc($res) ){
	$raison  = $r['raison'];
	$adresse = $r['adresse'];
	$ville   = $r['ville'];
	$pays    = $r['pays'];
	$dep     = $r['departement'];
	$tel     = $r['telephone'];
	$mail    = $r['mail'];
	$mobile  = $r['mobile'];
}

$html .= "</p><br>
</td>
<td></td>
<td>
	<p>
	<b>Client</b><hr>" .
	$raison . '<br>' .
	$adresse . '<br>' .
	$ville . ' ' . $pays . '<br>' .
	'Tél :'     . $tel    . '<br>' .
	'Mobile : ' . $mobile . '<br>' .
	'Email : '  . $mail   . '<br>' . "</p>
</td></tr>" .
"</table>"; 

$pdf->writeHTML($html, true, false, true, false, '');
// EOD;
// $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->SetFont($police, '', 11);
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output( 'FC_' . $code . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
