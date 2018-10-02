<?php
  // p_a_start.php
  // 
  // Startseite.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 15-DEC-2011.
  // lr: fh, 29-MAR-2012, Session behalten.
  // lr: fh, 12-APR-2012, Bearbeitungssperre ggf. freigeben.
  // lr: fh, 30-SEP-2013, Anmeldung als Lehrkraft.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="30.09.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_sperre_bearb('F',true,false);                   // eigene Sperre ggf. freigeben.

  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.

  $strGTitel=$strGAppTitel . " -  Startseite";
  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header:
  
  // =========================================
  // HTML-Bereich für Text auf der Startseite:
  // =========================================
?>
 <h2>Herzlich willkommen bei der Anwendung 'Jahrgangspartituren'</h4>
 <p>
   Hier kann jetzt ein kurzer Einführungs- und Erläuterungstext erscheinen.
 </p>
 <p>
   <h3>Einsatzzweck</h3>
   <ul>
    <li>Unterstützung des Planungsprozesses insbesondere für die fächerübergreifende Synchronisation von  
      fachlichen Unterrichtseinheiten auf der Grundlage schulinterner Lehrpläne (Planungstool)</li>
    <li>Darstellung der Verteilung fachlicher Unterrichtseinheiten auf die 
        Kalenderwochen eines Schuljahres (Präsentationstool)</li>
   </ul>
   
   
   <h3>Adressaten</h3>
   Das Partiturtool 
   <ul>
    <li>ist Bestandteil des Lehrplannavigators im Bildungsportal und wird mit den Daten
        der schulinternen Musterlehrpläne bestückt (Schulformen, Fächer, Jahrgangsstufen, Kursformen)</li>
    <li>kann von Schulen auf ihren Webservern im Intra- oder Internet verwendet werden (Fächer, Jahrgangsstufen, Klassen / Kurse)</li>
   </ul> 
 </p>
 
 <p>
  <h3>Start-Auswahl</h3>
  Sie haben die Wahl zwischen drei Stufen der Nutzung:
 </p>

  <ul>
    <li><a href="p_aus_auswahl.php">Präsentation und Auswertung der vorliegenden Daten</a></li>
    <li><a href="p_a_login.php?nltyp=3">Anmeldung als Lehrkraft, um auch nicht-öffentliche Angaben zu sehen</a></li>    
    <li><a href="p_a_login.php?nltyp=1">Anmeldung als Fachverwalter/in, um Unterrichtseinheiten zu erfassen und zu planen</a></li>
    <li><a href="p_a_login.php?nltyp=2">Anmeldung als Administrator/in zur Konfiguration der Anwendung</a></li>
  </ul>  


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
