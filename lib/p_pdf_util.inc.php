<?php
  // p_pdf_util.inc.php
  // PDF-Util-Funktionen, basiert auf der Klasse FPDF und definiert 
  // in der neuen Klasse PDF einige Methoden und Eigenschaften neu.
  //
  // DigSyLand http://www.digsyland.de/
  // Friedel Hosenfeld -- hosenfeld@digsyland.de
  //
  // Funktionen basieren auf den Original-Funktionen, den Tutorials und anderen Quellen.
  // www.fpdf.org
  //
  //
  //
  // Funktionen:
  //
  //  * Spezielle Funktionen der neuen Klasse PDF:
  //    - PDF($orientation='P', $unit='mm', $size='A4')
  //    - Header() 
  //    - Footer()
  //    - mcTabLineHeight($arrData,$arrWidths)
  //    - mcTabRow($arrData,$arrWidths,$arrHeaderDaten=array())
  //    - mcTabCheckPageBreak($h)
  //    - mcTabNbLines($w, $txt)
  //    - pdfBasicTable($arrHeader,$arrData)
  //    - ImprovedTable($header,$data)
  //    
  //    HTML-Parser-Funktionen:
  //    - WriteHTML($html)
  //    - OpenTag($tag, $attr)
  //    - CloseTag($tag)
  //    - SetStyle($tag, $enable)
  //    - PutLink($URL, $txt)
  //
  //    - MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false)
  //    - MultiCellMax($w, $h, $txt, $border=0, $align='J', $fill=false, $maxline=0)
  //
  //  * Funktionen außerhalb der Klasse:
  //    - pdfHTML_hex2dec($couleur = "#000000")
  //    - pdfHTML_px2mm($px)
  //    - pdfHTML_txtentities($html)
  //    - pdfMc_Replace($htmlText)
  //    - pdfMc_ReplaceArray($arrDataHTML)
  //    - pdfMcTab1(&$pdfObj,$arrHeader,$arrData,$arrFeldbreiten)
  //    - pdfMcTabFlex(&$pdfObj,$arrHeader,$arrData,$arrFeldbreiten,$numGesBreite=270,$arrDatenFarben=array(),$arrHeaderFarben=array())
  //    - pdf_farben_altern($arrDaten,$arrFarben=array('#DFE8F1','#FCF3E4'))
  //    - pdf_strip_tags($strHTMLText)
  //    - p_pdf_kopfzeile_wochen(&$pdfDoc,$numHorSeitNr,$numAnzPS)
  //
  // fh, 30-JAN-2007 - 08-SEP-2013.
  // lr: fh, 06-NOV-2013, MultiCellMax ergänzt.
  // lr: fh, 09-NOV-2013, p_pdf_kopfzeile_wochen ergänzt.
  // lr: fh, 10-NOV-2013, Header angepasst.
  // -----------------------------------------------------

class PDF extends FPDF
{

  var $numFooterHeight=-15;     // Höhe der Fußzeile.

  // CID:fh110901:Für HTML-Parser:  
  var $B;
  var $I;
  var $U;
  var $HREF;
  var $fontList;
  var $issetfont;
  var $issetcolor;

 // --------------------------------------------

 function PDF($orientation='P', $unit='mm', $size='A4')
 {
   // Für HTML-Parser aus http://www.fpdf.org/en/tutorial/tuto6.htm
   // ===============================================
   // lr: fh, 01-SEP-2011
    
    // Call parent constructor
    $this->FPDF($orientation,$unit,$size);
    // Initialization
    $this->B = 0;
    $this->I = 0;
    $this->U = 0;
    $this->HREF = '';

    $this->tableborder=0;
    $this->tdbegin=false;
    $this->tdwidth=0;
    $this->tdheight=0;
    $this->tdalign="L";
    $this->tdbgcolor=false;

    $this->oldx=0;
    $this->oldy=0;

    $this->fontlist=array("arial","times","courier","helvetica","symbol");
    $this->issetfont=false;
    $this->issetcolor=false;
    
    // $this->SetAutoPageBreak(true,$this->numFooterHeight);
    
 }


 // --------------------------------------------

 function Header()
 {
   // Diese Funktion überschreibt die (leere) Original-Funktion Header und muss
   // daher auch so heißen.
   // Sie gibt einige Header-Informationen im Seitenkopf aus.
   //
   // Parameter:
   //   keine
   // 
   // lr: fh, 22-OCT-2013 - 07-MAY-2013.
   // lr: fh, 10-NOV-2013, Schulname und -form.
   
   global $arrGMeta;
   global $strGtabKatSchulform;
   global $boolDEBUG;

   //Arial 8
   $this->SetFont('Arial','',14);
   //Move to the right
   //$this->Cell(20);

   // CID:fh131110:Schulnamen anzeigen, wenn vorhanden:
   $strSchulname = (empty($arrGMeta['schulname'])) ? '' : $arrGMeta['schulname'];

   // Schulformen: Wenn nur eine vorhanden ist, wird diese z.B. in Kopfzeile angezeigt:
   $numAnzSF=db_get_value("COUNT(*)",$strGtabKatSchulform,'',$boolDEBUG);
   $strSchulform='';
   if ($numAnzSF == 1)
   {
     $strSchulform= ', ' . db_get_value("MAX(schulform)",$strGtabKatSchulform,'',$boolDEBUG);
   } // IF: Nur eine Schulform?
   
   // Title
   $strTitelText="Jahrgangsplan " . $strSchulname . $strSchulform;
   $this->Cell(0,15,$strTitelText,1,0,'L');  
   // Cell(float w, [float h], [string txt], [mixed border], [integer ln], [string align], [integer fill], [mixed link])
   //Line break
   $this->Ln(20);
 } // Ende Header.
 
 // --------------------------------------------

 //Page footer
 function Footer()
 {
   // Diese Funktion überschreibt die (leere) Original-Funktion Footer und muss
   // daher auch so heißen.
   // Sie gibt einige Fußzeilen-Informationen im Seitenfuß aus.
   //
   // Parameter:
   //   keine
   // 
   // lr: fh, 30-JAN-2007.
   // lr: fh, 26-MAR-2007, Fußzeilenhöhe aus Klassenvariablen.
   // lr: fh, 14-JUN-2007, Seitenfußtitel.
   
   global $strGPDFFooter;
     
    //Position at 1.5 cm from bottom ($numFooterHeight = 15).
    $this->SetY($this->numFooterHeight);
    //Arial italic 8
    $this->SetFont('Arial','I',8);

    if ((isset($strGPDFFooter)) and ($strGPDFFooter != ""))
    {
      // Seitenfußtitel (Bezeichnung des Abschnitts oder ähnliches, links):
      $this->Cell(40,10,$strGPDFFooter,0,0,'L');
    } // IF: Seitenfußtitel gesetzt?

    //Page number
    $this->Cell(0,10,'Seite '.$this->PageNo().'/{nb}',0,0,'C');
    // Für die Gesamtseitenzahl muss vorher AliasNbPages() aufgerufen worden sein.
    $this->Cell(0,10,date("d.m.y H:i",time()),0,0,'R');
 
 } // Ende Footer.

 // ---------------------------------------------------------------
 // Funktionen für Multi-Table
 // ---------------------------------------------------------------
 // Quelle: http://www.fpdf.de/downloads/addons/3/ Author: Olivier (olivier@fpdf.org) License: Freeware
 // Diese Funktionen wurden noch erweitert und angepasst.
 // Sie beginnen mit "mc" (Multicolumn).

 // ---------------------------------------------------------------

 function mcTabLineHeight($arrData,$arrWidths)
 {
   // Berechnet die Zeilenhöhe eine Datenzeile.
   // Ausgegliedert aus mcTabRow.
   //
   // Parameter:
   //   $arrData        - Array mit den Daten zu einer Tabellenzeile.
   //   $arrWidths      - Array mit Breite der einzelnen Spalten in mm.
   //
   // Rückgabe:
   //   $h              - Zeilenhöhe in mm.
   //
   // lr: fh, 26-MAR-2007.
    
    // Calculate the height of the row:
    $nb=0;
    for($i=0;$i<count($arrData);$i++)
    {
      $nb=max($nb, $this->mcTabNbLines($arrWidths[$i], $arrData[$i]));
    } // Ende der FOR-Schleife.  
    $h=5*$nb;
    
    return $h;      // Höhe zurückliefern.
  } // Ende mcTabLineHeight.   

// ---------------------------------------------------------------

function mcTabRow($arrData,$arrWidths,$arrHeaderDaten=array(),$arrZeileFarben=array(),$arrHeaderFarben=array())
{
  // Erzeugt eine Tabellenzeile.
  //
  // Parameter:
  //   $arrData        - Array mit den Daten zu einer Tabellenzeile.
  //   $arrWidths      - Array mit Breite der einzelnen Spalten in mm.
  //   $arrHeaderDaten - (Optional) Array mit einer Kopfzeile zu Beginn jeder neuen Seite.
  //   $arrDatenFarben - (Optional) Array mit Farbangaben (als array (R,G,B) oder Hexcode mit #
  //   $arrHeaderFarben - (Optional) Array mit Farbangaben der Headerzeile(als array (R,G,B) oder Hexcode mit #
  //
  // Rückgabe:
  //   keine
  //
  // lr: fh, 26-MAR-2007.
   
  // Calculate the height of the row:
  $h=$this->mcTabLineHeight($arrData,$arrWidths);
    
  // Issue a page break first if needed:
  if (($this->mcTabCheckPageBreak($h)) and (count($arrHeaderDaten) > 1))
  {
    // Wenn ein Seitenwechsel erfolgte und eine Headerzeile angegeben wurde, 
    // wird zunächst die Headerzeile ausgegeben.
    $this->SetFont('Arial','B',10);
    $this->mcTabRow($arrHeaderDaten,$arrWidths,array(),$arrHeaderFarben);
    $this->SetFont('Arial','',8);
  } // IF: Seitenwechsel und Header-Zeile?
  
  // Draw the cells of the row:
  for($i=0;$i<count($arrData);$i++)
  {
      $w=$arrWidths[$i];
      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';  // Ausrichtung festlegen
      //Save the current position
      $x=$this->GetX();
      $y=$this->GetY();
      //Print the text
      // CID:fh110901:Einige Tags ersetzen:
      // $strCellContent = pdfMc_Replace($arrData[$i]);
      $strCellContent = $arrData[$i]; // Doch lieber im Vorfeld ersetzen!
      $numFill=0; // Farbfüllung (1=ja, 0=nein)
      if (!empty($arrZeileFarben[$i]))
      {
        $numFill=1; // Farbfüllung (1=ja, 0=nein)
        $strFarbe=$arrZeileFarben[$i];
        if (is_array($strFarbe))
        {
          $arrFarbeRGB=$strFarbe;
          $this->SetFillColor($arrFarbeRGB[0],$arrFarbeRGB[1],$arrFarbeRGB[2]);
        }
        elseif (substr($strFarbe,0,1)=='#')
        { 
           $arrFarbeRGB=pdfHTML_hex2dec($strFarbe);
           $this->SetFillColor($arrFarbeRGB['R'],$arrFarbeRGB['G'],$arrFarbeRGB['B']);
        }
        else
        {
          $numFill=0;
        }
      } // IF: Farbwert übergeben?  
      $this->MultiCell($w, 5, $strCellContent, 0, $a,$numFill);
      //Draw the border, den Rahmen erst später ziehe, um ggf. Füllung zu überschreiben.
      $this->Rect($x, $y, $w, $h);
      //Put the position to the right of the cell
      $this->SetXY($x+$w, $y);
  } // FOR-Schleife durch alle Tabellenzellen.
  
  //Go to the next line
  $this->Ln($h);
} // Ende mcTabRow

// ---------------------------------------------------------------

function mcTabCheckPageBreak($h)
{
  // Prüft, ob ein Seitenumbruch notwendig ist.
  // Dabei wird die Höhe der Fußzeile ($this->numFooterHeight) berücksichtigt.
  // Gibt True zurück, wenn Seitenwechsel erfolgte.
  //
  // Parameter:
  //   $h               - Zeilenhöhe in mm.
  //
  // Rückgabe:
  //   $boolPageBreak   - true, wenn Seitenwechsel, sonst false.
  //
  // lr: fh, 26-MAR-2007.
    
  $boolPageBreak=false;
    
  // If the height h would cause an overflow, add a new page immediately:
  if(($this->GetY()+ $h - $this->numFooterHeight) > $this->PageBreakTrigger)
  {
    $this->AddPage($this->CurOrientation);
    $boolPageBreak=true;
  } // IF: Seitenwechsel nötig?
    
  return $boolPageBreak;
} // Ende mcTabRowCheckPageBreak

// ---------------------------------------------------------------

function mcTabNbLines($w, $txt)
{
  // Computes the number of lines a MultiCell of width w will take.
  // Berechnet die Anzahl der Zeilen, die eine MultiCell mit der angegebenen Breite w benötigt.
  //
  // Parameter:
  //   $w           - Breite der Zelle in mm.
  //   $txt         - Darzustellender Text.
  //
  // Rückgabe:
  //   $nl          - Anzahl der Zeilen.
  //
  // lr: fh, 26-MAR-2007.
  //
  
  $cw=&$this->CurrentFont['cw'];
  if($w==0)
  {
    $w=$this->w-$this->rMargin-$this->x;
  }  
  $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
  $s=str_replace("\r", '', $txt);
  $nb=strlen($s);
  if($nb>0 and $s[$nb-1]=="\n")
  {
    $nb--;
  }  
  $sep=-1;
  $i=0;
  $j=0;
  $l=0;
  $nl=1;
  while($i<$nb)
  {
     $c=$s[$i];
     if($c=="\n")
     {
       $i++;
       $sep=-1;
       $j=$i;
       $l=0;
       $nl++;
       continue;
     }
     if($c==' ')
       $sep=$i;
     $l+=$cw[$c];
     if($l>$wmax)
     {
       if($sep==-1)
       {
         if($i==$j)
           $i++;
       }
       else
         $i=$sep+1;
       $sep=-1;
       $j=$i;
       $l=0;
       $nl++;
     }
     else
       $i++;
  }
 
  // Anzahl der Zeilen zurückgeben:
  return $nl;
} // Ende mcTabNbLines

// ------------------------------------------------------------------------------

  // Simple table
  function pdfBasicTable($arrHeader,$arrData)
  {
      $numGesBreite=200;   // Gesamtseitenbreite minus Ränder (A4 = 210mm gesamt);
      $numZellBreite=floor($numGesBreite/count($arrData));

      //Header
      $this->SetFont('Arial','B',10);
      foreach($arrHeader as $strSpaltenkopf)
      {
          $this->Cell($numZellBreite,7,$strSpaltenkopf,1);
      }    
      $this->Ln();

      //Data
      $this->SetFont('Arial','',8);
      foreach($arrData as $arrZeile)
      {
        foreach($arrZeile as $strZelle)
        {
          // $this->Cell($numZellBreite,6,$strZelle,1);
          $this->MultiCell($numZellBreite,6,$strZelle,1);
        }  
        $this->Ln();  // Neue Zeile.
      } // FOR-Schleife durch alle Zeilen.
  } // Ende pdfBasicTable.

// ---------------------------------------------------------------

//Better table
function ImprovedTable($header,$data)
{
    //Column widths
    $w=array(40,35,40,45);
    //Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Closure line
    $this->Cell(array_sum($w),0,'','T');
}

  // ---------------------------------------------------
  
  
  // ===============================================
  // HTML-Parser aus http://www.fpdf.org/en/tutorial/tuto6.htm
  // ===============================================
  // lr: fh, 01-SEP-2011
  // lr: fh, 07-SEP-2013, Seitenumbruch bei Bedarf einfügen.

  function WriteHTML($html)
  {
    // HTML parser
    // $html = str_replace("\n",' ',$html);
    // Verschiedene Ersetzungen:
    $arrSR["\r\n"]=" ";
    $arrSR["\n"]=" ";
    $arrSR["\t"]=" ";
    $arrSR["   "]=" "; // Überflüssige Leerzeichen eliminieren.
    $arrSR["  "]=" ";
    $arrSR["<br /> "]="<br />";
    $arrSR["<h2>"]="<br /><br /><h2>";
    $arrSR["</h2> <p>"]="</h2>";
    $arrSR["</h2>"]="</h2><br />";  // Abstand hinter H-Überschriften.
    $arrSR["<h3>"]="<br /><h3>";
    $arrSR["</h3> <p>"]="</h3>";
    $arrSR["</h3>"]="</h3><br />";  // Abstand hinter H-Überschriften.
    $arrSR["&#x25CF;"]=chr(149);         // Bullets
    $arrSR["&#8222;"]="";
    $arrSR["&#8220;"]="";
    $arrSR["&#039;"]="'";
    
    list($arrSearch,$arrReplace)=array(array(),array());
    foreach ($arrSR as $strSearch => $strReplace)
    {
      $arrSearch[]=$strSearch;
      $arrReplace[]=$strReplace;
    }  
    // trigger_error($html);
    $html = str_replace($arrSearch,$arrReplace,$html);
    // DEBUG: 
    // trigger_error($html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //explodes the string
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            elseif($this->tdbegin) {
                if(trim($e)!='' && $e!="&nbsp;") {
                    $this->Cell($this->tdwidth,$this->tdheight,$e,$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
                }
                elseif($e=="&nbsp;") {
                    $this->Cell($this->tdwidth,$this->tdheight,'',$this->tableborder,'',$this->tdalign,$this->tdbgcolor);
                }
            }
            else
            {
             // CID:fh130907:Ggf. Seitenumbruch einfügen:
             if ($this->GetY() > (280 + $this->numFooterHeight - 45))
             { 
               $this->AddPage(); // Abfrage sichert Seitenubruch im Toleranzbereich (45 mm)
             } // IF: Seitenumbruch fällig?

             $this->Write(5,stripslashes(pdfHTML_txtentities($e)));
             // -----------------------------------
            }    
        }
        else
        {
            //Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
  }

  // ---------------------------------------------------

  function OpenTag($tag, $attr)
  {
      // Ergänzt aus: http://www.fpdf.org/en/script/script42.php
      // Table-Elemente aus: http://www.fpdf.org/en/script/script50.php
      //          
      // lr: fh, 01-SEP-2011, Optimierungen, weitere Tags.
      // lr: fh, 16-SEP-2011, Erweiterung um li, aus: http://www.fpdf.org/en/script/script53.php
      // lr: fh, 06-SEP-2013, Abmaße von Bildern ermitteln.
      // lr: fh, 08-SEP-2013, Zu breite Bilder verkleinern (auf DIN A4 hochkant fest eingestellt).
      //    
      // Opening tag
      
    switch($tag){
        case 'B':
        case 'I':
        case 'U':
        case 'STRONG':
        case 'EM':
        case 'H2':
        case 'H3':
            $this->SetStyle($tag,true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
              // CID:fh130906:ggf. Abmaße ermitteln.
             if(isset($attr['SRC']))
             {
               if ((isset($attr['WIDTH']) || isset($attr['HEIGHT']))) 
               {
                  if(!isset($attr['WIDTH']))
                            $attr['WIDTH'] = 0;
                  if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
               }
               else
               {
                 // Abmaße ermitteln:
                 $strImgFile=$attr['SRC'];
                 if (file_exists($strImgFile))
                 {
                   list($attr['WIDTH'],$attr['HEIGHT'])=getimagesize($strImgFile);  
                 }
                 else
                 {
                   trigger_error("Bild-Datei $strImgFile nicht gefunden!");
                 } // IF: Existiert Bild-Datei?
               } // IF: Höhe/Breite angegeben?
               $numX=$this->GetX();
               $numY=$this->GetY();
               $numWidth=pdfHTML_px2mm($attr['WIDTH']);
               $numHeight=pdfHTML_px2mm($attr['HEIGHT']);
               if ($numWidth > 170)
               {
                 // Wenn Bild zu breit wird (DIN A4 hochkant), es etwas kleiner darstellen:
                 $numFaktor=170 / $numWidth ;
                 $numWidth=$numWidth * $numFaktor;
                 $numHeight=$numHeight * $numFaktor;
               } // IF: Bild zu breit?
               $this->Image($attr['SRC'],$numX, $numY, $numWidth, $numHeight);
               // CID:fh130907:Position hinter das Ende des Bildes setzen:
               $this->SetXY($numX,$numY + $numHeight);

              /*
              // CID:fh130906:Original-Code:
              if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                              if(!isset($attr['WIDTH']))
                                  $attr['WIDTH'] = 0;
                              if(!isset($attr['HEIGHT']))
                                  $attr['HEIGHT'] = 0;
                              $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), pdfHTML_px2mm($attr['WIDTH']), pdfHTML_px2mm($attr['HEIGHT']));
              */
            }
            break;
        case 'LI':
            // aus: http://www.fpdf.org/en/script/script53.php
            $this->Ln(5);
            $this->SetTextColor(190,0,0);
            $this->Write(5,'     » ');
            // $this->mySetTextColor(-1);
            $this->SetTextColor(0,0,0);
            break;
        case 'TR':
        case 'BLOCKQUOTE':
        case 'BR':
            $this->Ln(5);
            break;
        case 'P':
            $this->Ln(10);
            break;
        case 'FONT':
            if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                $coul=pdfHTML_hex2dec($attr['COLOR']);
                $this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            break;
        case 'TABLE': // TABLE-BEGIN
            if( !empty($attr['BORDER']) ) $this->tableborder=$attr['BORDER'];
            else $this->tableborder=0;
            break;
        case 'TR': //TR-BEGIN
            break;
        case 'TD': // TD-BEGIN
            if( !empty($attr['WIDTH']) ) $this->tdwidth=($attr['WIDTH']/4);
            else $this->tdwidth=40; // Set to your own width if you need bigger fixed cells
            if( !empty($attr['HEIGHT']) ) $this->tdheight=($attr['HEIGHT']/6);
            else $this->tdheight=6; // Set to your own height if you need bigger fixed cells
            if( !empty($attr['ALIGN']) ) {
                $align=$attr['ALIGN'];        
                if($align=='LEFT') $this->tdalign='L';
                if($align=='CENTER') $this->tdalign='C';
                if($align=='RIGHT') $this->tdalign='R';
            }
            else $this->tdalign='L'; // Set to your own
            if( !empty($attr['BGCOLOR']) ) {
                $coul=pdfHTML_hex2dec($attr['BGCOLOR']);
                    $this->SetFillColor($coul['R'],$coul['G'],$coul['B']);
                    $this->tdbgcolor=true;
                }
            $this->tdbegin=true;
            break;

        case 'HR':
            if( !empty($attr['WIDTH']) )
                $Width = $attr['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.2);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(1);
            break;
    }
  }
  // ---------------------------------------------------

  function CloseTag($tag)
  {
      // Ergänzt aus: http://www.fpdf.org/en/script/script42.php
      //          
      // lr: fh, 01-SEP-2011, Optimierungen, weitere Tags.
      // Closing tag

      $arrStyleTags=array('B','I','U','STRONG','EM','H2','H3');
      if(in_array($tag,$arrStyleTags))
          $this->SetStyle($tag,false);
      if($tag=='A')
          $this->HREF = '';
      if($tag=='FONT')
      {
         if ($this->issetcolor==true) 
         {
            $this->SetTextColor(0);
         }
         if ($this->issetfont) 
         {
            $this->SetFont('arial');
            $this->issetfont=false;
         }
      }
      if($tag=='TD') 
      { // TD-END
          $this->tdbegin=false;
          $this->tdwidth=0;
          $this->tdheight=0;
          $this->tdalign="L";
          $this->tdbgcolor=false;
      }
      if($tag=='TR') { // TR-END
        $this->Ln();
      }
      if($tag=='TABLE') { // TABLE-END
        //$this->Ln();
         $this->tableborder=0;
      }
      
  }

  // ---------------------------------------------------

  function SetStyle($tag, $enable)
  {
      // Modify style and select corresponding font
      $strTag=$tag;
      $strTag=str_replace(array('STRONG','H2','H3','EM'),array('B','B','B','I'),$strTag);
      $this->$strTag += ($enable ? 1 : -1);
      $style = '';
      foreach(array('B', 'I', 'U') as $s)
      {
          if($this->$s>0)
              $style .= $s;
      }
      
      // Header?
      if (substr($tag,0,1)=='H')
      {
        // Header:
        if ($enable)
        {
          // Wieder Font größer machen:
          $this->SetFont('',$style,12);
        }
        else
        {
          // Wieder Standard-Font-Größe:
          $this->SetFont('',$style,10);
        }  
      }
      else
      {
        $this->SetFont('',$style);
      } // IF: Header mit Größenänderung?  
  }

  // ---------------------------------------------------

  function PutLink($URL, $txt)
  {
      // Put a hyperlink
      $this->SetTextColor(0,0,255);
      $this->SetStyle('U',true);
      $this->Write(5,$txt,$URL);
      $this->SetStyle('U',false);
      $this->SetTextColor(0);
  }
  // ---------------------------------------------------
  
  // ================================================
  // Ende der HTML-Parser-Funktionen
  // ================================================
  
    /************************************************************
    *                                                           *
    *    MultiCell with bullet (array)                          *
    *                                                           *
    *    Requires an array with the following  keys:            *
    *                                                           *
    *        Bullet -> String or Number                         *
    *        Margin -> Number, space between bullet and text    *
    *        Indent -> Number, width from current x position    *
    *        Spacer -> Number, calls Cell(x), spacer=x          *
    *        Text -> Array, items to be bulleted                *
    *                                                           *
    ************************************************************/
    // lr: fh, 05-SEP-2011, aus: http://www.fpdf.org/en/script/script56.php
    // Beispiel: $test1['bullet'] = chr(149); $test1['margin'] = ' '; $test1['indent'] = 0; $test1['spacer'] = 0;

    function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false)
    {
        if (!is_array($blt_array))
        {
            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
            exit;
        }
                
        //Save x
        $bak_x = $this->x;
        
        for ($i=0; $i<sizeof($blt_array['text']); $i++)
        {
            //Get bullet width including margin
            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
            
            // SetX
            $this->SetX($bak_x);
            
            //Output indent
            if ($blt_array['indent'] > 0)
                $this->Cell($blt_array['indent']);
            
            //Output bullet
            $this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);
            
            //Output text
            $this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
            
            //Insert a spacer between items if not the last item
            if ($i != sizeof($blt_array['text'])-1)
                $this->Ln($blt_array['spacer']);
            
            //Increment bullet if it's a number
            if (is_numeric($blt_array['bullet']))
                $blt_array['bullet']++;
        }
    
        //Restore x
        $this->x = $bak_x;
    }

// ------------------------------------------------------------------------------------------

  function MultiCellMax($w, $h, $txt, $border=0, $align='J', $fill=false, $maxline=0)
  {
    // Wie Multicell aber mit optionaler Zeilenbegrenzung ($maxline).
    // Falls der Text nicht mehr passt, wird der Rest wieder zurückgegeben und kann
    // so ggf. wieder in einer weiteren MultiCell ausgegeben werden.
    // Output text with automatic or explicit line breaks, at most $maxline lines
    // Quelle: http://www.fpdf.org/en/script/script16.php
    // Author: Jean-Marie Gervais
    // License: FPDF 
    // lr: fh, 06-NOV-2013.
    
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
      $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 && $s[$nb-1]=="\n")
      $nb--;
    $b=0;
    if($border)
    {
      if($border==1)
      {
        $border='LTRB';
        $b='LRT';
        $b2='LR';
      }
      else
      {
        $b2='';
        if(is_int(strpos($border,'L')))
          $b2.='L';
        if(is_int(strpos($border,'R')))
          $b2.='R';
        $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
      }
    }
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $ns=0;
    $nl=1;
    while($i<$nb)
    {
      //Get next character
      $c=$s[$i];
      if($c=="\n")
      {
        //Explicit line break
        if($this->ws>0)
        {
          $this->ws=0;
          $this->_out('0 Tw');
        }
        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
        $i++;
        $sep=-1;
        $j=$i;
        $l=0;
        $ns=0;
        $nl++;
        if($border && $nl==2)
          $b=$b2;
        if($maxline && $nl>$maxline)
          return substr($s,$i);
        continue;
      }
      if($c==' ')
      {
        $sep=$i;
        $ls=$l;
        $ns++;
      }
      $l+=$cw[$c];
      if($l>$wmax)
      {
        //Automatic line break
        if($sep==-1)
        {
          if($i==$j)
            $i++;
          if($this->ws>0)
          {
            $this->ws=0;
            $this->_out('0 Tw');
          }
          $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
        }
        else
        {
          if($align=='J')
          {
            $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
            $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
          }
          $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
          $i=$sep+1;
        }
        $sep=-1;
        $j=$i;
        $l=0;
        $ns=0;
        $nl++;
        if($border && $nl==2)
          $b=$b2;
        if($maxline && $nl>$maxline)
        {
          if($this->ws>0)
          {
            $this->ws=0;
            $this->_out('0 Tw');
          }
          return substr($s,$i);
        }
      }
      else
        $i++;
    }
    //Last chunk
    if($this->ws>0)
    {
      $this->ws=0;
      $this->_out('0 Tw');
    }
    if($border && is_int(strpos($border,'B')))
      $b.='B';
    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
    $this->x=$this->lMargin;
    return '';
  } // Ende MultiCellMax


} // Ende der Klassendefinition.
// ------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------


// ------------------------------------------------------------------------------------------

//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function pdfHTML_hex2dec($couleur = "#000000")
{
    // Für HTML-Parser, aus: http://www.fpdf.org/en/script/script50.php
    // lr: fh, 01-SEP-2011.
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['G']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

// ------------------------------------------------------------------------------------------

//conversion pixel -> millimeter in 72 dpi
function pdfHTML_px2mm($px)
{
    // Für HTML-Parser, aus: http://www.fpdf.org/en/script/script50.php
    // lr: fh, 01-SEP-2011.
    return $px*25.4/72;
}

// ------------------------------------------------------------------------------------------

function pdfHTML_txtentities($html)
{   
    // Für HTML-Parser, aus: http://www.fpdf.org/en/script/script50.php
    // lr: fh, 01-SEP-2011.
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}

// ------------------------------------------------------------------------------------------


function pdfMc_Replace($htmlText)
{
   // Ersetzt einige HTML-Tags, die in Tabellen lästig sind.
   // lr: fh, 01-SEP-2011.
   // lr: fh, 16-SEP-2011, <li>, <ul> ergänzt.

   // Verschiedene Ersetzungen:
   $arrSR["<em>"]="";
   $arrSR["</em>"]="";
   $arrSR["\r\n"]=" ";
   // $arrSR["\r\n"]="\n";
   // $arrSR["\n"]=" ";
   $arrSR["<br>"]="\n";
   $arrSR["<br />"]="\n";
   // $arrSR["<ul>"]="\n";
   // $arrSR["</ul>"]="\n";
   $arrSR["<li>"]="  " . chr(149) . " ";
   // $arrSR["</li>"]="\n";
   $arrSR["   "]=" "; // Überflüssige Leerzeichen eliminieren.
   $arrSR["  "]=" ";
   $arrSR["\n  "]="\n";
   $arrSR["\n "]="\n";
   $arrSR["&#x25CF;"]=chr(149);         // Bullets
   $arrSR["&#8222;"]="";
   $arrSR["&#8220;"]="";
   $arrSR["&lt;"]="<";  // CID:fh131106:neu
   list($arrSearch,$arrReplace)=array(array(),array());
   foreach ($arrSR as $strSearch => $strReplace)
   {
     $arrSearch[]=$strSearch;
     $arrReplace[]=$strReplace;
   }  
   // trigger_error("VORHER:" . $htmlText);
   $htmlText = str_replace($arrSearch,$arrReplace,$htmlText);
   $htmlText = str_replace("  "," ",$htmlText);
   // trigger_error("NACHHER:" . $htmlText);
   
   return($htmlText);
} // ENDE  pdfMc_Replace  

// ------------------------------------------------------------------------------------------

function pdfMc_ReplaceArray($arrDataHTML)
{
   // Ersetzt in allen Array-Zellen des zweidimensionalen Arrays die entsprechenden HTML-Tags.
   // lr: fh, 01-SEP-2011.

   $arrCleanData=$arrDataHTML; 
   foreach ($arrDataHTML as $numIdx1 => $arrA1)
   {
     foreach ($arrA1 as $numIdx2 => $strCellContent)
     {
        $arrCleanData[$numIdx1][$numIdx2]=pdfMc_Replace($strCellContent);
     } // Innere FOR-Schleife.
   } // Äußere FOR-Schleife  
   
   return($arrCleanData);
} // ENDE  pdfMc_ReplaceArray  

// ------------------------------------------------------------------------------------------

function pdfMcTab1(&$pdfObj,$arrHeader,$arrData,$arrFeldbreiten)
{
  // Funktion zur Erzeugung einer Tabelle, die sich automatisch über
  // mehrere Seiten verteilt.
  // Leider musste diese Funktion außerhalb der PDF-Klasse definiert werden,
  // so dass das PDF-Objekt als Parameter (per Reference) übergeben wird.
  //
  // Parameter:
  //   &$pdfObj         - PDF-Objekt (by Reference).
  //   $arrHeader       - Array mit den Daten der Kopfzeile (als Tabellenzeile).
  //   $arrData         - Array mit den Daten zu einer Tabellenzeile.
  //   $arrFeldbreiten  - Array mit Breite der einzelnen Spalten in px.
  //
  // Rückgabe:
  //   keine
  //
  // fh, 30-JAN-2007, Anpassung des Beispielcodes.
  // lr: fh, 31-JAN-2007, Feldbreiten als Parameter.  
  // lr: fh, 16-JUN-2007, Summenzeilen fett darstellen.
      
  $numGesBreite=270;   // Gesamtseitenbreite minus Ränder (A4 hoch = 210mm , A4 quer 290mm gesamt);
  // $numZellBreite=floor($numGesBreite/count($arrData));
  // $arrWidths=array_fill(0,(count($arrData)+2),$numZellBreite);
  // Breitenarray gemäß Feldbreiten auf Gesamtbreite beziehen:

  $numFeldGesamt=array_sum($arrFeldbreiten) + 10;   // Die 10mm Offset sind für die Zeilennummer in der 1. Spalte.
  $numFaktor=($numGesBreite / $numFeldGesamt);  // Faktor zum Umrechnung Pixel in mm.
  foreach ($arrFeldbreiten as $intIdx => $numFeldbreite)
  {
    $arrWidths[$intIdx]=($numFeldbreite * $numFaktor);
  } // FOR-Schleife durch Feldbreiten.  

  array_unshift($arrWidths,10);     // Breite der 1. Spalte vorne anhängen.
      
      
  // Headerzeile zuerst darstellen:
  $pdfObj->SetFont('Arial','B',10);
  $pdfObj->mcTabRow($arrHeader,$arrWidths);
  // $pdfObj->Ln();  // Leerzeile?
      
  // Eigentliche Datenzeilen:
  $pdfObj->SetFont('Arial','',8);
  foreach($arrData as $arrZeile)
  {
    // Header-Angaben als 3. Parameter, um auf jeder Seite eine Header-Zeile zu haben:
    if ($arrZeile[0]=="")
    {
      // Summenzeile (erste Spalte leer) fett darstellen:
      $pdfObj->SetFont('Arial','B',8);
    }
    else
    {
      // Normale Zeile:
      $pdfObj->SetFont('Arial','',8);
    }
    $pdfObj->mcTabRow($arrZeile,$arrWidths,$arrHeader);
  } // FOR-Schleife durch alle Zeilen.
} // Ende pdfMcTab1.

// ---------------------------------------------------

function pdfMcTabFlex(&$pdfObj,$arrHeader,$arrData,$arrFeldbreiten,$numGesBreite=270,$arrDatenFarben=array(),$arrHeaderFarben=array())
{
  // Funktion zur Erzeugung einer Tabelle, die sich automatisch über
  // mehrere Seiten verteilt.
  // Leider musste diese Funktion außerhalb der PDF-Klasse definiert werden,
  // so dass das PDF-Objekt als Parameter (per Reference) übergeben wird.
  // Im Gegensatz zu pdfMcTab1 keine Nr-Spalte vorne und keine feste Gesamtbreite.
  //
  // Parameter:
  //   &$pdfObj         - PDF-Objekt (by Reference).
  //   $arrHeader       - Array mit den Daten der Kopfzeile (als Tabellenzeile).
  //   $arrData         - Array mit den Daten zu einer Tabellenzeile.
  //   $arrFeldbreiten   - Array mit Breite der einzelnen Spalten in px.
  //   $numGesBreite    - optional: Gesamtseitenbreite minus Ränder (A4 hoch = 210mm , A4 quer 290mm gesamt);
  //   $arrDatenFarben  - optional:Array mit Farbangaben, eine Farbe pro Zelle (Array mit Zeilen-Arrays - wie Daten).
  //   $arrHeaderFarben  - optional:Array mit Farbangaben für die Header-Zeile, eine Farbe pro Zelle
  //
  // Rückgabe:
  //   keine
  //
  // lr: fh, 01-SEP-2011, Angepasst von pdfMcTab1
  // lr: fh, 05-SEP-2011, $arrDatenFarben, $arrHeaderFarben.
  
      
  // $numGesBreite=270;   // Gesamtseitenbreite minus Ränder (A4 hoch = 210mm , A4 quer 290mm gesamt);
  // $numZellBreite=floor($numGesBreite/count($arrData));
  // $arrWidths=array_fill(0,(count($arrData)+2),$numZellBreite);
  // Breitenarray gemäß Feldbreiten auf Gesamtbreite beziehen:

  $numFeldGesamt=array_sum($arrFeldbreiten) + 10;   // Die 10mm Offset sind für die Zeilennummer in der 1. Spalte.
  $numFaktor=($numGesBreite / $numFeldGesamt);  // Faktor zum Umrechnung Pixel in mm.
  foreach ($arrFeldbreiten as $intIdx => $numFeldbreite)
  {
    $arrWidths[$intIdx]=($numFeldbreite * $numFaktor);
  } // FOR-Schleife durch Feldbreiten.  

  // Headerzeile zuerst darstellen:
  $pdfObj->SetFont('Arial','B',10);
  $pdfObj->mcTabRow($arrHeader,$arrWidths,array(),$arrHeaderFarben);
  // $pdfObj->Ln();  // Leerzeile?
      
  // Eigentliche Datenzeilen:
  $pdfObj->SetFont('Arial','',8);
  foreach($arrData as $numZIdx => $arrZeile)
  {
    // Header-Angaben als 3. Parameter, um auf jeder Seite eine Header-Zeile zu haben:
    if ($arrZeile[0]=="")
    {
      // Summenzeile (erste Spalte leer) fett darstellen:
      $pdfObj->SetFont('Arial','B',8);
    }
    else
    {
      // Normale Zeile:
      $pdfObj->SetFont('Arial','',8);
    }
    $arrZeilenFarben=(empty($arrDatenFarben[$numZIdx])) ? array() : $arrDatenFarben[$numZIdx];
    $pdfObj->mcTabRow($arrZeile,$arrWidths,$arrHeader,$arrZeilenFarben,$arrHeaderFarben);
  } // FOR-Schleife durch alle Zeilen.
} // Ende pdfMcTabFlex.

// ---------------------------------------------------


function pdf_farben_altern($arrDaten,$arrFarben=array('#DFE8F1','#FCF3E4'))
{
  // Generiert ein Array mit alternierend eingefärbten Zeilen
  // auf der Basis des Daten-Arrays.
  // Gut zu verwenden mit pdfMcTabFlex
  //
  // Parameter:
  //    $arrDaten   -   Array mit den Datensätzen, nur die Dimensionen werden benötigt.
  //    $arrFarben  -   (optional) Array mit den Angaben der alternierenden Farben
  // 
  // fh, 16-SEP-2011.

  $strFarbe='';
  $arrDatenFarben=array();
  foreach ($arrDaten as $arrDummy)
  {
     $numAnzSp=count($arrDummy);
     $strFarbe=($strFarbe == $arrFarben[1]) ? $arrFarben[0] : $arrFarben[1];
     $arrDatenFarben[]=array_fill(0,$numAnzSp,$strFarbe);
  } // FOR-Schleife durch die Zeilen des Arrays.   
  
  return ($arrDatenFarben);
} // Ende pdf_farben_altern.

// ------------------------------------------------------------------------------------------

function pdf_strip_tags($strHTMLText)
{
  // Ersetzt einige HTML-Tags mit Hilfe von pdfMc_Replace
  // und entfernt dann die übrigen HTML-Tags mit strip_tags.
  //
  // fh, 06-NOV-2013.
  
  $strPDFText=strip_tags(pdfMc_Replace($strHTMLText));
  
  return ($strPDFText);
} // Ende pdf_strip_tags.
  
  

// ------------------------------------------------------------------------------------------

function p_pdf_kopfzeile_wochen(&$pdfDoc,$numHorSeitNr,$numAnzPS,$numB,$boolTitelSpalteAlle=false)
{
  // Gibt Kopfzeile mit Wochennnummern aus.
  //
  // fh, 09-NOV-2013.
  $numX=0;     // $pdfDoc->GetX();
  $numY=$pdfDoc->GetY();
  $pdfDoc->SetXY($numX, $numY);
  $numEndWoche=min((($numHorSeitNr + 1) * $numAnzPS - 1),52); // Nichts über 52 ausgeben.
  $pdfDoc->SetFont('Arial','B',10); // Fettdruck
  for ($numWoche = ($numHorSeitNr * $numAnzPS) ;$numWoche<=$numEndWoche;$numWoche++)
  {
     if (($boolTitelSpalteAlle) and ($numWoche > 0) and ($numWoche == ($numHorSeitNr * $numAnzPS)))
     {
       $strLabel = "Fach/...";
       $pdfDoc->MultiCell($numB, 10, $strLabel, 1, 'L' ,false);
       $numX+=$numB;
       $pdfDoc->SetXY($numX, $numY);
     } // Soll Titelspalte auf jeder Seite gedruckt werden?  
     $strLabel=($numWoche == 0) ? "Fach/..." : $numWoche; // Beschriftung der Wochen
     $pdfDoc->MultiCell($numB, 10, $strLabel, 1, 'L' ,false);
     $numX+=$numB;
     // $pdfDoc->Rect($x, $y, $w, $h);
     $pdfDoc->SetXY($numX, $numY);
  } // FOR-Schleife durch die Wochen.
  $pdfDoc->SetFont('Arial','',10); // Normal, ohne Fett
} // Ende p_pdf_kopfzeile_wochen    

// ---------------------------------------------------
// Ende p_pdf_util.inc.php
// ---------------------------------------------------

?>
