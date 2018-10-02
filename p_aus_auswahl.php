<?php
  // p_aus_auswahl.php
  // 
  // Auswahl der Auswertungsoptionen.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 20-DEC-2011.
  // lr: fh, 02-FEB-2012, Konsolidierung des Auswahldialogs.
  // lr: fh, 12-APR-2012, Parameter per GET übergeben, damit leichter aus URL kopierbar. Sperre ggf. freigeben.
  // lr: fh, 22-OCT-2013, Erweiterungen.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="22.10.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();                                      // Session-ID und Variablen zuordnen.
  $boolFachV=p_check_fv(false);                           // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  p_sperre_bearb('F',$boolFachV,false);                   // eigene Sperre ggf. freigeben.

  // Parameter einlesen:
  // keine bisher 
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Auswertung auswählen";
  $_SESSION['p_plan_uv_ausblend']=array();    // Ausgeblendete UV zurücksetzen.

  // Status-Zeile ($strGStatus) ausgeben und Basis-Informationen ermitteln:
  // list($strGStatus,$strSchulnummer,$strSchulname,$strSchulort) = ls_status_info(0);
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  $strGHeaderInclude="p_gui_auswahl.inc.php";       // Zusätzliche Include-Datei mit jQuery-Elementen.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen:
  //    bisher noch keine
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    echo "<h2>Auswahl</h2>\n";
    echo "<p>Bitte geben Sie die Kriterien für die Auswertung an:</p>\n";
           
    // Auswahl-Formular aufbauen:
    // --------------------------
    echo "<form name='frm_p_auswertung' id='frm_p_auswertung' method='get' action='p_aus_plan.php'>\n";

    $arrVorauswahl=(isset($_SESSION['p_auswahl'])) ? $_SESSION['p_auswahl'] : ''; // Vorauswahl der Optionen aus der Session holen.           
    p_frm_auswahlform($arrVorauswahl); // Spalten des Formulars ausgeben.
    
    // Form-Abschluss:
    // --------------
    echo "<br class='pclear' />\n";
    echo " <input class='pbutton' type='submit' id='psubmit' value='Anzeigen'  tabindex='3' /> \n";
    echo " <br /> \n";
    // Formular schließen.
    echo "</form> \n";
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------
  
  
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
