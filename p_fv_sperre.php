<?php
  // p_fv_sperre.php
  // 
  // Hinweisseite, wenn die Bearbeitungsfunktionen zur Zeit gesperrt sind.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 12-APR-2011.
  // lr: fh, 19-AUG-2013, gesperrtes Fach angeben.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  
  // Parameter einlesen:
  $strUserName=ut_get_webpar('sun');    // Username, falls Sperre aktiv
  $numFachId=ut_get_webpar_n('nfach');  // Fach, das gesperrt ist.

  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  
  $strFach='';
  if (!empty($numFachId))
  {
    $strFach=db_get_value('fach',$strGtabKatFach,"(fach_id=$numFachId)",$boolDEBUG);
  } // IF: Fach angegeben?  

  $strGTitel=$strGAppTitel . " - $strFach Bearbeitungsfunktionen zur Zeit gesperrt";
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header:
  
  echo "<h3>Wichtiger Hinweis:</h3>\n";
  echo "<br /><br />\n";
  
  if ($strUserName != '')
  {
    echo "<p>Die Bearbeitungsfunktionen " .
         ((empty($strFach)) ? '' : " für Fach '$strFach' ") .
         " stehen zur Zeit nicht zur Verfügung,
             da diese durch den Nutzer bzw. die Nutzerin '$strUserName' 
             verwendet werden.</p>\n";
  }
  else
  {
    echo "<p>Die Bearbeitungsfunktionen stehen zur Zeit nicht zur Verfügung,
             da diese durch einen anderen Nutzer bzw. eine andere Nutzerin 
             verwendet werden.</p>\n";
  } // IF: Username angegeben?
  
  
  echo "<p>Die Bearbeitungsfunktionen für ein Fach können nur von einer Person zur Zeit genutzt werden,
           um Konflikte beim Speichern zu vermeiden.</p>\n";

  echo "<br /><br />\n";
  
  echo "<p><a href='javascript:history.back();'>zurück ...</a></p>\n";
  
  // -----------------------------------------------------
  // Abschluss der Seite:
  include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  // -----------------------------------------------------
  // Ende PHP.
?>