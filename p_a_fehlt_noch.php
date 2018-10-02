<?php
  // p_a_fehlt_noch.php
  // 
  // Platzhalter-Seite f�r fehlende Funktionen.
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

  // �nderungsdatum:
  $strGChangeDate="20.12.2011";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.

  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code f�r aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG �bernommen.

  $strGTitel=$strGAppTitel . " -  Diese Funktion ist noch nicht fertiggestellt";
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  // $strGMenue=ls_menu(8); // kein Men��.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header:
  
  // =========================================
  // HTML-Bereich f�r Text auf der Startseite:
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
  include($strGIncPath . "p_gui_fuss.inc.php");  // Fu�block.
  // -----------------------------------------------------
  // Ende PHP.
?>