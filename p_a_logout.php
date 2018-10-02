<?php
  // p_a_logout.php
  // 
  // Abmelden vom System, Sitzung löschen
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 11-JAN-2012.
  // lr: fh, 12-APR-2012, Bearbeitungssperre ggf. freigeben.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="12.04.2012";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_sperre_bearb('F',true,false);                   // eigene Sperre ggf. freigeben.

  // Parameter einlesen:
  // keine bisher
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Abmeldung (Logout)";

  // Session-Variablen löschen:
  // --------------------------
  session_unset(); 
  session_destroy();

  // Status-Zeile ($strGStatus) ausgeben und Basis-Informationen ermitteln:
  // list($strGStatus,$strSchulnummer,$strSchulname,$strSchulort) = ls_status_info(0);
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen (und Parameter einlesen):
  // -------------------------------------------------------------
  
  // Wurde Schulform angegeben?
  if ($numFehler == 0)
  {
    echo "<h2>Abmeldung</h2>\n";
    echo "<p>Sie haben sich vom System abgemeldet.</p>\n";
    
    echo "<br />\n";

    echo "<p><a href='p_a_start.php'>Zur Start-Auswahl-Seite</a></p>\n";
    echo "<p>Dort können Sie sich erneut anmelden.</p>\n";

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
