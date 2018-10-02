<?php
  // p_fv_plan.php
  // 
  // FACHVERWALTER/IN
  // Bearbeitung des aktuellen Plans durch Fachverwalter/in.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 20-DEC-2011.
  // lr: fh, 11-JAN-2012.
  // lr: fh, 19-JAN-2012.
  // lr: fh, 01-FEB-2012, Zurücksetzen von UV, Vorauswahl wird in Session abgelegt.
  // lr: fh, 02-FEB-2012, Kapselung in Funktionen, damit für den Plan nicht zuviel doppelt programmiert wird.
  // lr: fh, 27-MAR-2012, kleine Optimierungen.
  // lr: fh, 29-MAR-2012, Optimierung, um Textfelder korrekt auszugeben.
  // lr: fh, 13-APR-2012, Rückgängig-Funktion.
  // lr: fh, 15-APR-2012, Suchfunktion.
  // lr: cp, 15-OCT-2012, Container für die Positionierung   
  // lr: fh, 19-AUG-2013, Sperre vom Fach abhängig machen, daher erst Fach feststellen.
  // lr: fh, 14-SEP-2013, da nur noch ein Fach bearbeitet werden kann, muss die Bearbeitungskombination dafür nicht übergeben werden.
  // lr: fh, 22-OCT-2013, Link für neues UV, da bei "leerem" Plan sonst keines angelegt werden kann.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="22.10.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_fv();         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  
  // Für die Sperre muss zunächst das Fach ermittelt werden:
  $numFachBearb=ut_get_webpar_n('nfach_bearb');    // Nur noch das als Auswahl übergebene Fach ist wichtig. ut_get_webpar_n('nfach_bearb');
  // Abgleichen, ob für das ausgewählte Fach auch Bearbeitungsrechte vorhanden sind:
  $numFachBearbRecht=p_fv_fach();                // CID:fh130819:Fach heraussuchen, das bearbeitet werden darf.
  if ($numFachBearbRecht != $numFachBearb)
  {
    p_fehler_seite('F0115');  // Für dieses Fach haben Sie keine Bearbeitungsrechte!
    exit; // Skript verlassen
  } // IF: Rechte für dieses Fach?

  p_sperre_bearb('S',true,true,$numFachBearb);    // Sperre einrichten, sonst Fehlermeldungsseite
  if (!empty($numFachBearb))
  {
    $_SESSION['p_fach_id_bearb']=$numFachBearb;
  } // IF: Fach angegeben? Dann in Session ablegen.
  
  // Parameter einlesen:
  // siehe unten
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
  $strGTitel=$strGAppTitel . " -  Jahresplanung";

  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  $strGHeaderInclude="p_gui_plan.inc.php";       // Zusätzliche Include-Datei mit jQuery-Elementen.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  
  echo "<script type='text/javascript'>\n";
  echo "var numGUserID=" . $numUserID . ";\n"; // User-ID an JS übergeben.
  echo "</script>\n";
  
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen (und Parameter einlesen):
  // -------------------------------------------------------------
  if ($numFehler == 0)
  {
    list($numFehler,$strFehlercode,$arrFormparam)=p_read_auswahlform();
    if ($numFehler == 0)
    {
      // Ergebnis auf Einzelvariablen verteilen:
      list($numSF_ID,$strSchulform,$strSF_Kuerzel,
           $arrKatFaecher,$strFachCond,
           $arrKatStufen,$strStufenCond,
           $arrKatZuege,$strZugCond,
           $arrKatKursarten,$strKursartCond) = $arrFormparam;
         
      // CID:fh130914:zu bearbeitendes Fach:
      $numPlanFachID=$numFachBearb;
      // $_SESSION['p_auswahl']['nfach_bearb']=$numPlanFachID; // in Session merken für Vorauswahl.
    }// IF: Fehler beim Auslesen des Formulars?
  } // IF: Fehler?
  
  // Ende Fehlerprüfungen:
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    // Daten aus der DB auslesen:
    $strCond="$strFachCond $strStufenCond $strZugCond $strKursartCond"; // Abfragebedingung
    list($arrUV,$arrTextfelder)=p_dbread_uv($numSF_ID,$strCond,false);  

    // CID:fh130914:geändert: keine gesonderte Bearbeitungszeile mehr:
    /*
    $arrPlanIDs=array($numPlanFachID,$numPlanStufeID,$numPlanZugID,$numPlanKursartID);
    list($arrUV,$arrTextfelder)=p_dbread_uv($numSF_ID,$strCond,true,$arrPlanIDs);  //true: Daten für Bearbeitungszeile erzeugen.

    // Variablen der aktuellen Bearbeitungsauswahl:
    $strAktPlanStufe=$arrKatStufen[$numPlanStufeID]['stufe'];
    $strAktPlanZug=$arrKatZuege[$numPlanZugID]['zug'];
    $strAktPlanKursart=$arrKatKursarten[$numPlanKursartID]['kursart'];
    */
     echo "<div class='pfliesstext' style='height:270px;'>\n";  // <-- momentan ist hier die Höhe fest eingestellt, damit sich Layout nicht verschiebt
     // echo "<h2>Partitur</h2>\n";
     echo "<div id='zurueck'><a href='p_fv_ausw_plan.php'>zurück zur Auswahl</a></div>\n";
     if ($numPlanFachID > 0)
     {
       $strAktPlanFach=$arrKatFaecher[$numPlanFachID]['fach'];
       // echo "<h2>Bearbeitung: $strAktPlanFach<br />($strSchulform, Jahrgangsstufe: $strAktPlanStufe, Zug: $strAktPlanZug, Kursart: $strAktPlanKursart)</h2>\n";
       echo "<h2>Bearbeitung: $strAktPlanFach<br />($strSchulform)</h2>\n";
       echo "<p>Sie können derzeit das Fach '$strAktPlanFach' planen. </p>\n";
       /*
       echo "Für alle übrigen Fächer können Sie die Unterrichtsvorhaben ebenfalls verschieben, aber keine neuen
             Unterrichtsvorhaben einbringen. Dazu müssen Sie erst das entsprechende Fach zur Bearbeitung
             aktivieren. Aus Übersichtsgründen kann diese Möglichkeit immer nur für ein Fach aktiviert werden.</p>\n";
       */      
     } // IF: Aktuelles Fach festgelegt?
     
     echo "<p>Sie können die Einheiten mit der Maus in der Zeile des jeweiligen Faches verschieben.<p>\n";
     echo "<p>Wenn Sie auf den Titel klicken, öffnet sich ein PopUp-Fenster, das die einzelnen Angaben
              des Vorhabens anzeigt. Diese können Sie dort auch bearbeiten.</p>\n";

     // CID:fh131022:neues UV:
     $strWindowOpen=",\"puvwin\", \"toolbar=no,status=no,menubar=no,resizable=yes,scrollbars=yes, width=800,height=600\");puvwin.focus();return false;"; 
     $strNewURL="p_a_uv_show.php?nuvid=0&nbearbeiten=1&nneu=1&s_fach_id=$numFachBearb";
     $strNewLink = "<br /><a class='pbutton' href='$strNewURL' onClick='puvwin=window.open(\"$strNewURL\" $strWindowOpen' " .
                   "title='neues Unterrichtsvorhaben' border='0'>neues Unterrichtsvorhaben</a>"; 
     $strNewLink=str_replace('puvwin','neupuvwin',$strNewLink);
     echo $strNewLink;

     if ((isset($_SESSION['p_plan_uv_ausblend'])) and (count($_SESSION['p_plan_uv_ausblend']) > 0))
     {
       // CID:fh131022:Option zum Einblenden von ausgeblendeten Zeilen.
       $strWindowOpen=",\"puvwin\", \"toolbar=no,status=no,menubar=no,resizable=yes,scrollbars=yes, width=800,height=600\");puvwin.focus();return false;"; 
       $strEinblend="p_fv_plan_einblend.php";
       $strEinblend = "<br /><a class='pbutton' href='$strEinblend' onClick='puvwin=window.open(\"$strEinblend\" $strWindowOpen' ".
                      "title='Zeilen einblenden' border='0'>Ausgeblendete Zeilen einblenden</a>"; 
       $strEinblend=str_replace('puvwin','einblendwin',$strEinblend);
       echo $strEinblend;
     } // IF: Ausgeblendete UV?  

     // ------------------------------------------------
     // CID:fh131022:Plan drucken:
     $strWindowOpen=",\"puvwin\", \"toolbar=no,status=no,menubar=no,resizable=yes,scrollbars=yes, width=800,height=600\");puvwin.focus();return false;"; 
     $strDruckURL="p_a_druck_wahl.php";
     $strDruckLink = "<br /><a class='pbutton' href='$strDruckURL' onClick='puvwin=window.open(\"$strDruckURL\" $strWindowOpen' " .
                   "title='Plan ausdrucken' border='0'>Plan ausdrucken</a>"; 
     $strDruckLink=str_replace('puvwin','druckpuvwin',$strDruckLink);
     echo $strDruckLink;

     echo "<p><br /></p>\n"; // hier könnte ein weitere Einführungstext stehen

     echo "<div id='p_suche'><label for='ssuche'>Suche:</label>";
     echo "<input type='text' name='ssuche' id='ssuche' size='20' />\n";
     echo "<button class='pbutton' onclick='js_such_uv(\"" . $_SERVER['QUERY_STRING'] . "\");'>Suche starten</button></div>\n";
     
     $strResetURL='p_fv_plan_reset.php?'. $_SERVER['QUERY_STRING'];
     echo "<button class='pbutton rechts' onclick='window.location.href=\"$strResetURL\";'>Alle Änderungen dieser Sitzung rückgängig machen</button>\n";
     echo "</div>\n";
     // ------------------------------------------------

           
  } // IF: Fehler aufgetreten?

  // -----------------------------------------------------------------------------------------------------

  if ($numFehler == 0)
  {
     // Den Aufbau des Plans in Variablen legen, damit in einer Schleife sowohl die
     // noch nicht einsortierten als auch die bereits geplanten Unterrichtseinheiten aufgebaut werden können.
     // -----------------------------------------------------------------------------------------------------

     // Leer initialisieren:
     $strStageHeaderInit='';
     $strUVungeplantInit='';    // Bereich mit den noch nicht verplanten Einheiten
     // ----------------------------------------------

     $strUVungeplantInit .= "<div class='demo'> \n";

     // $strUVungeplantInit .= "<p>Hier befinden sich für das Fach $strAktPlanFach die Unterrichtsvorhaben, die noch nicht in den Plan aufgenommen wurden:<br />\n";
     // $strUVungeplantInit .= "</p>\n";
     // CID:fh130914: Bearbeitungszeile entfernt: $strUVungeplantInit .= "<div class='pspeicher' id='store'>\n";

     
     // ----------------------------------------------
     $strStageHeaderInit .= "<div id='stage'> \n";
     $strStageHeaderInit .= " <div class='header'> \n";
     
     // ------------------------------------------------
     // Plan erzeugen:
     // ------------------------------------------------
     $arrKataloge=array('fach'=>$arrKatFaecher,'stufe'=>$arrKatStufen,'zug'=>$arrKatZuege,'kursart'=>$arrKatKursarten);
     
     // CID:fh130914:geändert: keine gesonderte Bearbeitungszeile mehr: $numPlanFachID statt $arrPlanIDs.
     list($strStageHeader,$strUVPlan,$strZeilenKoepfe,$strUVungeplant)=
                                                      p_erzeuge_plan($arrUV,$arrTextfelder,$arrKataloge,true,$numPlanFachID);
     $strStageHeader = $strStageHeaderInit . $strStageHeader;
     $strUVungeplant = $strUVungeplantInit . $strUVungeplant;
     // ------------------------------------------------

     
     // --------------------
     // Ausgabe des Plans:
     echo $strUVungeplant;
     echo $strStageHeader;
     echo $strUVPlan;
     echo $strZeilenKoepfe;
     // --------------------

?>
</div><!-- End stage-->

<div class="divider">&nbsp;</div>

<div class="demo-description">
<p>
  <!-- Hier folgt noch Erläuterungstext ... -->
</p>
</div><!-- End demo-description -->


<?php
 } // IF: Fehler?

  
  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    p_fehler_ausgabe($strFehlercode);
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------


  // -----------------------------------------------------
  // Abschluss der Seite:
  include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  // -----------------------------------------------------
  // Ende PHP.
?>