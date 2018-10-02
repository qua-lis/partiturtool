<?php
  // p_aus_plan.php
  // 
  // Ausgabe des aktuellen Plans gemäß den Suchkriterien.
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
  // lr: fh, 02-FEB-2012, Aktualisierung und Synchronisierung mit bearbeitbaren Plan.
  // lr: fh, 29-MAR-2012, Optimierung, um Textfelder korrekt auszugeben.
  // lr: fh, 12-APR-2012, Bearbeitungssperre ggf. freigeben.
  // lr: fh, 26-APR-2012, Suche ergänzt.
  // lr: fh, 03-OCT-2012, Korrektur bei der Initialisierung des Katalogs "stufe".
  // lr: cp, 16-OCT-2012, Container für die Positionierung 
  // lr: fh, 14-SEP-2013, Korrekturen.
  // lr: fh, 10-NOV-2013, Kopfhöhe optimiert, Druck-Link eingebaut.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="10.11.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();               // Session-ID und Variablen zuordnen.
  $boolFachV=p_check_fv(false);    // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  p_sperre_bearb('F',$boolFachV,false);                   // eigene Sperre ggf. freigeben.

  // Parameter einlesen:
  // siehe unten
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Auswertung: Plan";

  // Status-Zeile ($strGStatus) ausgeben und Basis-Informationen ermitteln:
  // list($strGStatus,$strSchulnummer,$strSchulname,$strSchulort) = ls_status_info(0);
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  $strGHeaderInclude="p_gui_plan.inc.php";       // Zusätzliche Include-Datei mit jQuery-Elementen.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
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
      // CID:fh130914:an aktualisierte Version ohne Bearbeitungszeile angepasst.
      list($numSF_ID,$strSchulform,$strSF_Kuerzel,
           $arrKatFaecher,$strFachCond,
           $arrKatStufen,$strStufenCond,
           $arrKatZuege,$strZugCond,
           $arrKatKursarten,$strKursartCond) = $arrFormparam;
    }// IF: Fehler beim Auslesen des Formulars?
  } // IF: Fehler?
  
  // Ende Fehlerprüfungen.
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    // Daten aus der DB auslesen:
    $strCond="$strFachCond $strStufenCond $strZugCond $strKursartCond"; // Abfragebedingung
    list($arrUV,$arrTextfelder)=p_dbread_uv($numSF_ID,$strCond,false,array());  //true: Daten für Bearbeitungszeile erzeugen.

    echo "<div id='zurueck'><a href='p_aus_auswahl.php'>zurück zur Auswahl</a></div>\n";
    if ($boolFachV)
    {
      // Prüfen, ob Sperre für das Fach vorliegt, das man bearbeiten darf:
      $numFachBearb=p_fv_fach();
      $strSperrUser=p_sperre_bearb('I',true,false,$numFachBearb);           // prüfen, ob Sperre durch andere vorliegt.
      if ((!empty($numFachBearb)) and ($strSperrUser == ''))
      {
        echo "<div id='bearbeitung'>";
        echo "<a href='p_fv_ausw_plan.php'>Bearbeitung des Plans</a></div>\n";
      } // IF: Schreibrechte und nicht durch anderen User gesperrt? 
    } // IF: Fachverwalter?  

  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------


  if ($numFehler == 0)
  {
     // Plan erzeugen:
     // -------------

     if ((!isset($arrUV)) or (count($arrUV) == 0))
     {
       echo "<p><br /></p><p>Leider wurden zu Ihren Auswahlkriterien keine geplanten Unterrichtsvorhaben gefunden!";
     }
     else
     {
       echo "<div id='p_suche'><label for='ssuche'>Suche: </label>";
       echo "<input type='text' name='ssuche' id='ssuche' size='20' />\n";
       echo "<button class='pbutton' onclick='js_such_uv(\"" . $_SERVER['QUERY_STRING'] . "\");'>Suche starten</button></div>\n";
       // echo "<h2>Partitur</h2>\n";

      echo "<div class='pfliesstext' style='height:80px;'>\n";  // <-- momentan ist hier die Höhe fest eingestellt, damit sich Layout nicht verschiebt
      echo "<p id='auswahl'>Hier wird der aktuelle Plan für die gewünschte Auswahl dargestellt:</p>\n";

       // ------------------------------------------------
       // CID:fh131110:Plan drucken:
       $strWindowOpen=",\"puvwin\", \"toolbar=no,status=no,menubar=no,resizable=yes,scrollbars=yes, width=800,height=600\");puvwin.focus();return false;"; 
       $strDruckURL="p_a_druck_wahl.php?nnorel=1"; // nnorel=1: Plan muss nicht neu geladen werden
       $strDruckLink = "<br /><a class='pbutton' href='$strDruckURL' onClick='puvwin=window.open(\"$strDruckURL\" $strWindowOpen' " .
                     "title='Plan ausdrucken' border='0'>Plan ausdrucken</a>"; 
       $strDruckLink=str_replace('puvwin','druckpuvwin',$strDruckLink);
       echo $strDruckLink;

       if ((isset($_SESSION['p_plan_uv_ausblend'])) and (count($_SESSION['p_plan_uv_ausblend']) > 0))
       {
         // CID:fh131022:Option zum Einblenden von ausgeblendeten Zeilen.
         $strWindowOpen=",\"puvwin\", \"toolbar=no,status=no,menubar=no,resizable=yes,scrollbars=yes, width=800,height=600\");puvwin.focus();return false;"; 
         $strEinblend="p_fv_plan_einblend.php";
         $strEinblend = "<br /><a class='pbutton' href='$strEinblend' onClick='puvwin=window.open(\"$strEinblend\" $strWindowOpen' ".
                        "title='Zeilen einblenden' border='0'>Ausgeblendete Zeilen einblenden</a>"; 
         $strEinblend=str_replace('puvwin','einblendwin',$strEinblend);
         // echo "<div style='float:left;'>$strEinblend</div>\n";
         echo $strEinblend;
       } // IF: Ausgeblendete UV?  
       echo "</div>\n"; // Ende pfliesstext


        
       // Leer initialisieren:
       $strStageHeaderInit='';
       $strStageHeaderInit .= "<div class='demo'> \n";
       $strStageHeaderInit .= "<div id='stage'> \n";
       $strStageHeaderInit .= " <div class='header'> \n";

       // ------------------------------------------------
       // Plan erzeugen:
       // ------------------------------------------------
       $arrKataloge=array('fach'=>$arrKatFaecher,'stufe'=>$arrKatStufen,'zug'=>$arrKatZuege,'kursart'=>$arrKatKursarten);
       list($strStageHeader,$strUVPlan,$strZeilenKoepfe,$strUVungeplant)=
                                                        p_erzeuge_plan($arrUV,$arrTextfelder,$arrKataloge,false,array());
       $strStageHeader = $strStageHeaderInit . $strStageHeader;
       // ------------------------------------------------

       // --------------------
       // Ausgabe des Plans:
       echo $strStageHeader;
       echo $strUVPlan;
       echo $strZeilenKoepfe;
       // --------------------
    } // IF: Plandaten vorhanden?

?>
<div class="divider">&nbsp;</div>

</div><!-- End stage-->

<div class="divider">&nbsp;</div>

<div class="demo-description">
<p>
  
</p>
</div><!-- End demo-description -->
</div>

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
  include($strGIncPath . "p_gui_fuss_plan.inc.php");  // Fußblock.
  // -----------------------------------------------------
  // Ende PHP.
?>
