<?php
  // p_a_druck.php
  // 
  // Erzeugt PDF-Datei
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // lr: fh, 22-OCT-2012.
  // lr: fh, 03-NOV-2012.
  // lr: fh, 04-NOV-2012, Anzahl Zeilen pro UV.
  // lr: fh, 06-NOV-2013.
  // lr: fh, 09-NOV-2013, Kopfzeilen- und Spalten auf jeder Seite
  // lr: fh, 10-NOV-2013, Auswahl in Session merken, inhaltlicher Umfang der Textfelder wird ausgewertet.
  // -------------------------------------------------------------

  ini_set('display_errors', '0'); // Fehlermeldungen nicht ausgeben, da PDF dann nicht erzeugt werden kann.

  // Änderungsdatum:
  $strGChangeDate="10.11.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 
  require_once ('fpdf/fpdf.php');                         //  PDF-Bibliothek FPDF.
  require_once ('lib/p_pdf_util.inc.php');                //  PDF-Utils.

  // Session initialisieren:
  p_session_start();                 // Session-ID und Variablen zuordnen.

  // Parameter einlesen:
  $numGroesse=ut_get_webpar_n('ngroesse');                 // Code der Größe, 1=>'DIN A4',2=>'DIN A3',3=>'DIN A2',4=>'DIN A1'
  $_SESSION['pdruck']['ngroesse']=$numGroesse;             // In Session merken.
  $strFormat=ut_get_webpar('sformat');                     // Hochformat (P) oder Querformat (L)
  $_SESSION['pdruck']['sformat']=$strFormat;               // In Session merken.
  $numBSeiten=ut_get_webpar_n('nbteile');                  // Wie viele Seiten in der Breite?
  $_SESSION['pdruck']['nbteile']=$numBSeiten;              // In Session merken.
  $numUmfang=ut_get_webpar_n('numfang');                   // Ausgabeumfang (wie viel von jedem UV?)
  $_SESSION['pdruck']['numfang']=$numUmfang;               // In Session merken.
  $numAnzZpUV=ut_get_webpar_n('nanzzeil');                 // Anzahl Zeilen pro UV
  $numAnzZpUV=($numAnzZpUV < 1) ? 1 : $numAnzZpUV;
  $_SESSION['pdruck']['nanzzeil']=$numAnzZpUV;             // In Session merken.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Drucken des Plans";
  $boolTitelJedeSeite=true;   // Soll die Titelzeile auf jeder Seite gedruckt werden?
  $boolTitelSpalteAlle=true;  // Soll Titelspalte auf jeder Seite gedruckt werden?

  // -------------------------------------------------------------
  // Fehlerprüfungen:
  // -------------------------------------------------------------
  // Keine bisher
  
  // TODO: Formate und andere Parameter prüfen
  
  // Ende Fehlerprüfungen:
  // -------------------------------------------------------------


  if ($numFehler == 0)
  {
    // ------------------------------------------------------------------
    // Kataloge einlesen (um Fachbezeichnungen etc. auszugeben)
    $arrKat['fach']=p_read_katalog('fach');    
    $arrKat['stufe']=p_read_katalog('stufe');
    $arrKat['zug']=p_read_katalog('zug');
    $arrKat['kurs']=p_read_katalog('kurs');
    
    // ------------------------------------------------------------------
    // PDF initialisieren:
    // ------------------------------------------------------------------
    
    // Papiergrößen: 1=>'DIN A4',2=>'DIN A3',3=>'DIN A2',4=>'DIN A1'));
    $arrGroessen=array(1=>array(210,297),2=>array(297,420),3=>array(420,594),4=>array(594,841));
    $arrPapiermasse=$arrGroessen[$numGroesse]; // in mm
    //$pdfDoc=new PDF('L','mm','A4');                           // L Landscape=Quer, P Portrait
    $pdfDoc=new PDF($strFormat,'mm',$arrPapiermasse);           // L Landscape=Quer, P Portrait
    $pdfDoc->AliasNbPages();                                    // Alias für Gesamtseitenzahl setzen.
    $pdfDoc->SetAutoPageBreak(true);
    $pdfDoc->AddPage();
    // ------------------------------------------------------------------

    // Kein Fehler bisher, also Aufbau der Ausgabe.
    // --------------------------------------------
    // Hier könnte man noch einen Text schreiben, müsste aber bei Kopfzeile immer berücksichtigt werden.
    // $pdfDoc->SetFont('Arial','B',14);
    // $pdfDoc->Cell(12,0,$strGTitel);
    // $strEinlText = "<h2>Sie können den aktuellen Plan als PDF zum Abspeichern und Ausdrucken erzeugen</h2>\n";
    // $pdfDoc->WriteHTML($strEinlText);
    $pdfDoc->SetFont('Arial','',10);

    
    // Breite einzelner UV und andere Maße ausrechnen (abrunden):
    // ----------------------------------------------------------
    $numBPar=($strFormat == 'P') ? 0 : 1;   // Bei Querformat Höhe und Breite vertauschen.
    $numSpAnzGesamt = ($boolTitelSpalteAlle) ? (54 + $numBSeiten) : 54; // Seiten addieren für Beschriftungsspalte + Reserve
    $numAnzPS=round($numSpAnzGesamt/$numBSeiten);     // Anzahl Spalten pro Seite (Breite)
    $numAnzPSUV=($boolTitelSpalteAlle) ? ($numAnzPS - 1) : $numAnzPS;   // Anzahl UV pro Seite (ohne Titelspalte)
    $numB=round($arrPapiermasse[$numBPar] / $numAnzPS - 0.5); 
    $numUVHoehe=40;
    $numZHoehe=4;     // Höhe pro Zeile.
    
   

    // Druckinfos aus Session holen:
    // ----------------------------------------------------------
    $arrDruckzeilen=(!empty($_SESSION['p_druckzeilen'])) ? $_SESSION['p_druckzeilen'] : '';
    // TEST: $arrDruckzeilen=array();
    $numY=$pdfDoc->GetY();
    if (!empty($arrDruckzeilen))
    {
       $arrDZInfo=array();
       $arrSeiteninfo=array();
       // -------------------------------------------------------------------------------------

       $numAnzDZ=0; // Anzahl Druckzeilen.

       // 1. Schleife durch alle Druckzeilen zum Verteilen der UV auf die horizontalen Seiten:
       foreach ($arrDruckzeilen as $numDZ => $arrZeile)
       {
         $numAnzDZ=$numDZ;
         $arrDZInfo[$numDZ]=$arrZeile[0]['uvinfos'];      // Einmal pro Druckzeile Infos zu Fach etc. ablegen.
         // Schleife durch alle UV einer Druckzeile:
         foreach ($arrZeile as $numUV => $arrUVDruck)
         {
           // DEBUG:  echo "<pre>"; print_r($arrUVDruck); echo "</pre>\n";
           $numBeginn=$arrUVDruck['beginn'];
           if ($numBeginn > 0)
           {
             $numHorSeitNr=floor($numBeginn/$numAnzPSUV);  // Horizontale Seitennummer.  
             
             $numEnde=$arrUVDruck['ende'];
             $numEnde=min($numEnde,$numAnzPSUV * ($numHorSeitNr + 1) - 1);
             $numUVID=$arrUVDruck['nuvid'];
             $strTitel=$arrUVDruck['titel'];
             $arrUVInfos=$arrUVDruck['uvinfos'];
             $arrTextfelder=$arrUVDruck['uvtf'];
             // DEBUG: echo "<pre>"; print_r($arrUVDruck['uvtf']); echo "</pre>\n";
             // Text der UV zusammenstellen:
             $strUVText=pdf_strip_tags($strTitel);
             
             if ($numUmfang > 1)
             {
               // Nicht nur den Titel [1], sondern wie in Plan [2] oder alle Felder [3]:
               $strUVText .= "\n";
               if ($numUmfang == 2)
               {
                 // Alle Felder, die im Plan auch angezeigt werden, diese können aus der Session genommen werden:
                 foreach ($arrTextfelder as $strTextfeld => $arrTFInfo)
                 {
                    // $arrTFInfo: [textfeld] => schwerpunkte, [textfeld_label] => Inhaltliche Schwerpunkte, [plananzeige] => 1, [reihenfolge] => 200
                    if ((!empty($arrUVInfos[$strTextfeld])) and (!empty($arrTFInfo['plananzeige'])))
                    {
                       $strUVText .= $arrTFInfo['textfeld_label'] . ":\n";
                       $strUVText .= pdf_strip_tags($arrUVInfos[$strTextfeld]) . "\n";
                    }// IF: Angaben vorhanden?
                 } // FOR-Schleife durch alle Textfelder. 
               }
               elseif ($numUmfang == 3)
               {
                 // Alle Inhaltsfelder (auch die ohne planzeige=1), diese müssen aus der Datenbank ausgelesen werden:
                 list($arrUVFelder,$arrUVDaten,$arrUVDT)=p_felder_uv($numUVID);
                 // Alle Felder ausgeben:
                 foreach ($arrUVDaten as $strTextfeld => $strTextfeldwert)
                 {
                    // Prüfen, ob es auch ein freies Textfeld ist (textfeld_id):
                    if ((!empty($strTextfeldwert)) and (isset($arrUVFelder[$strTextfeld]['textfeld_id'])))
                    {
                       $strUVText .= $arrUVFelder[$strTextfeld]['lbl'] . ":\n";  // $strUVText .= $strTextfeld . ":\n";
                       $strUVText .= pdf_strip_tags($strTextfeldwert) . "\n";
                    }// IF: Angaben vorhanden?
                 } // FOR-Schleife durch alle Textfelder. 
               } // IF: Alle Inhalte oder nur die aus Plan-Anzeige?  
             } // IF: Nur Titel?   
             
             if (($boolTitelSpalteAlle) and ($numHorSeitNr > 0))
             {
               $numX=(($numBeginn - ($numHorSeitNr * $numAnzPSUV) + 1) * $numB); // Platz für Kopfspalte reservieren
             }
             else
             {
               $numX=(($numBeginn - ($numHorSeitNr * $numAnzPSUV)) * $numB);
             } // IF: Soll Zeilenkopf auf jeder Seite erscheinen?  
             $numBreite=($numEnde - $numBeginn + 1) * $numB;
             
             // Daten in Seitenarray speichern:
             $arrSeiteninfo[$numHorSeitNr][$numDZ][$numUV]=array($numX,$numBreite,$strUVText);
             $numX+=$numBreite;
             
             // Wenn eine UV nicht ganz in der Breite passt, diese auf der folgenden Seite wiederholen:
             if ($arrUVDruck['ende'] > $numEnde)
             {
               $numBreite_nS=($arrUVDruck['ende'] - (($numHorSeitNr + 1) * $numAnzPSUV) + 1) * $numB; // Rest-Breite auf der nächsten Seite
               $numStartX = ($boolTitelSpalteAlle) ? $numB : 0; // Platz für Kopfspalte reservieren?
               $arrSeiteninfo[($numHorSeitNr + 1)][$numDZ][$numUV]=array($numStartX,$numBreite_nS,$strUVText);
             } // IF: auf der nächsten Seite weiter?
           } // IF: Passt UV noch auf die Seite?  
         } // FOR-Schleife durch alle UV?  
       } // FOR-Schleife durch alle Druckzeilen.  
       
       // -------------------------------------------------------------------------------------
 
       // -------------------------------------------------------------------------------------
       // Jetzt die Schleifen zur Ausgabe alle Seiten mit Schleife durch horizontale Seiten:
       // -------------------------------------------------------------------------------------
       for ($numHorSeitNr = 0; $numHorSeitNr < count($arrSeiteninfo);$numHorSeitNr++)
       {
         // Kopfinfo (Wochennummern) ausgeben:
         // ----------------------------------
         if ($numHorSeitNr > 0)
         {
           // Bei allen außer der ersten horizontalen Seite, Seitenumbruch:
           $pdfDoc->AddPage($pdfDoc->CurOrientation);
         }
         
         p_pdf_kopfzeile_wochen($pdfDoc,$numHorSeitNr,$numAnzPSUV,$numB,$boolTitelSpalteAlle); // Kopfzeile mit Wochennummern ausgeben.

         // Line break
         $pdfDoc->Ln(20);
         $numY=$pdfDoc->GetY();
         // Ende Kopfinfo
         // --------------
         
         // Schleife durch die Druckzeilen:
         for ($numDZ=1; $numDZ<=$numAnzDZ; $numDZ++)
         {
           $numX=0;     // $pdfDoc->GetX();
           // trigger_error("numY: $numY");
           // Prüfen, ob das Seitenende erreicht wäre, dann einen Seitenumbruch auslösen, Toleranz einer Zeile ergänzen:
           // If the height h would cause an overflow, add a new page immediately:
           if(($pdfDoc->GetY() + (($numZHoehe * $numAnzZpUV) * 2)  - $pdfDoc->numFooterHeight) > $pdfDoc->PageBreakTrigger)
           {
             $pdfDoc->AddPage($pdfDoc->CurOrientation);
             $boolPageBreak=true;
             $numY=$pdfDoc->GetY();
           } // IF: Seitenwechsel nötig?
           
           if (($numY < 40) and ($boolTitelJedeSeite))
           {
             p_pdf_kopfzeile_wochen($pdfDoc,$numHorSeitNr,$numAnzPSUV,$numB,$boolTitelSpalteAlle); // Kopfzeile mit Wochennummern ausgeben.
             $pdfDoc->Ln(20);
             $numY=$pdfDoc->GetY();
           } // IF: Soll auf jeder Seite Kopfzeile ausgegeben werden?   
          
           if  (($numHorSeitNr == 0) or ($boolTitelSpalteAlle))
           {
              // Zeilenkopf (Fach, ...) ausgeben:
              // --------------------------------
              $arrZInfo=$arrDZInfo[$numDZ];
              $strFach=(empty($arrKat['fach'][$arrZInfo['fach_id']])) ? '' : ($arrKat['fach'][$arrZInfo['fach_id']]['fach'] . "\n");
              $strStufe=(empty($arrKat['stufe'][$arrZInfo['stufe_id']])) ? '' : ($arrKat['stufe'][$arrZInfo['stufe_id']]['stufe'] . "\n");
              // leere Züge und Kursarten nicht ausgeben:
              $strZug=((empty($arrZInfo['zug_id'])) or (empty($arrKat['zug'][$arrZInfo['zug_id']]))) ? '' : ($arrKat['zug'][$arrZInfo['zug_id']]['zug'] . "\n");
              $strKurs=((empty($arrZInfo['kursart_id'])) or (empty($arrKat['kurs'][$arrZInfo['kursart_id']]))) ? '' : ($arrKat['kurs'][$arrZInfo['kursart_id']]['kursart'] . "\n");
              // DEBUG echo "<pre>"; print_r($arrZeile[0]); echo "</pre>\n";
              $strUVText=$strFach . $strStufe . $strZug . $strKurs;
              $pdfDoc->SetXY($numX, $numY);
              $numBreite = $numB;
              $pdfDoc->SetFont('Arial','B',10); // Fettdruck
              $pdfDoc->MultiCellMax($numBreite, $numZHoehe, $strUVText, 0, 'L' ,false,$numAnzZpUV); // Ohne Rand
              $pdfDoc->SetFont('Arial','',10); // Normal
              $pdfDoc->Rect($numX, $numY, $numBreite,($numAnzZpUV * $numZHoehe), 'D');              // Rechteck extra zeichnen.
              $numX+=$numBreite;
              $pdfDoc->SetXY($numX, $numY);
           }
           
           if (isset($arrSeiteninfo[$numHorSeitNr][$numDZ]))
           {
             $arrHorUVInfo=$arrSeiteninfo[$numHorSeitNr][$numDZ];
             // Schleife durch alle UV einer Druckzeile:
             foreach ($arrHorUVInfo as $numUV => $arrCellInfo)
             {
                $numX=$arrCellInfo[0];
                $pdfDoc->SetXY($numX, $numY);
                $numBreite=$arrCellInfo[1];
                $strUVText=$arrCellInfo[2];
                $pdfDoc->MultiCellMax($numBreite, $numZHoehe,$strUVText, 0, 'L' ,false,$numAnzZpUV); // ohne Rand
                $pdfDoc->Rect($numX, $numY, $numBreite,($numAnzZpUV * $numZHoehe), 'D');              // Rechteck extra zeichnen.
                $numX+=$numBreite;
                $pdfDoc->SetXY($numX, $numY);
             } // FOR-Schleife durch alle auf diesem Seitenstreifen und dieser Druckzeile. 
           } // IF: Daten vorhanden? 
          $numY += ($numZHoehe * $numAnzZpUV); // Höhe für nächste Zeile setzen
         } // FOR-Schleife durch die Druckzeilen.  
       } // FOR-Schleife durch die horizontalen Seiten  

    } // IF: Druckzeilen in Session vorhanden?
    
    
  } // IF: Fehler?
  // ---------------------


  if ($numFehler == 0)
  {
    // -----------------------------------------------------------------------
    // PDF-Doc ausgeben:
    // -----------------------------------------------------------------------
    $pdfDoc->Output("partitur_plan.pdf","D");
    // -----------------------------------------------------------------------
  } // IF: Fehler?
  // ---------------------


  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    p_fehler_seite($strFehlercode);
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------

  // -----------------------------------------------------
  // Ende PHP.
?>
