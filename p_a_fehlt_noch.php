<?php
  // p_a_fehlt_noch.php
  // 
  // Platzhalter-Seite für fehlende Funktionen.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 20-DEC-2011.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="20.12.2011";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.

  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.

  $strGTitel=$strGAppTitel . " -  Diese Funktion ist noch nicht fertiggestellt";
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  // $strGMenue=ls_menu(8); // kein Menü´.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header:
  
  // =========================================
  // HTML-Bereich für Text auf der Startseite:
  // =========================================
?>
 <p>
   Diese Funktion ist leider derzeit noch nicht fertiggestellt worden.
 </p>


<?php
  // =========================================
  // Ende HTML-Bereich
  // =========================================
  // -----------------------------------------------------
  // Abschluss der Seite:
  include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  // -----------------------------------------------------
  // Ende PHP.
?>