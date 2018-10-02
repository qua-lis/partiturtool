<?php
  // p_a_zugriffsfehler.php
  // 
  // Fehlermeldungen, wenn keine ausreichenden Zugriffsrechte bestehen.
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
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="11.01.2012";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.

  // Parameter einlesen:
  // keine bisher 
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Zugriffsrechte fehlen";

  // Status-Zeile ($strGStatus) ausgeben und Basis-Informationen ermitteln:
  // list($strGStatus,$strSchulnummer,$strSchulname,$strSchulort) = ls_status_info(0);
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen:
  //    bisher noch keine
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    echo "<h2>Zugriffsrechte fehlen</h2>\n";
    echo "<p>Leider haben Sie für die gewählte Funktion keine ausreichenden Zugriffsrechte!</p>\n";
    echo "<p><br /></p>\n";
    echo "<p><a href='p_a_start.php'>Zur Start-Auswahl-Seite</a></p>\n";
           
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
