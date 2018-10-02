<?php
  // p_fv_auswahl.php
  // 
  // FACHVERWALTER/IN
  // Auswahl der Funktionen für den/die Fachverwalter/in.
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
  // lr: fh, 12-APR-2012, Sperre.
  // lr: fh, 19-AUG-2013, nur Sperre für bearbeitbares Fach prüfen.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_fv();         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  p_sperre_bearb('F',true,false);                                // eigene Sperre ggf. freigeben.
  $numFachBearb=p_fv_fach();                                     // CID:fh130819:Fach heraussuchen, das bearbeitet werden darf.
  $strSperrUser=p_sperre_bearb('I',true,false,$numFachBearb);    // prüfen, ob Sperre durch andere vorliegt.

  // Parameter einlesen:
  // keine bisher 
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Funktion auswählen";

  // Basis-Informationen für Statuszeile ermitteln:
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
    echo "<h2>Funktionen für Fachverwalter/innen</h2>\n";
    if ($strSperrUser != '')
    {
       echo "<br /><p>Da der Nutzer/die Nutzerin '$strSperrUser' zur Zeit eine Bearbeitungsfunktion
                      nutzt, können Sie derzeit den Plan nicht bearbeiten, sondern nur auswerten.</p><br />\n";
    } // IF: Sperre?                

    echo "<p>Bitte wählen Sie:</p>\n";
           
    echo "<ul>\n";
    echo " <li><a href='p_aus_auswahl.php'>Präsentation und Auswertung der vorliegenden Daten</a></li> \n";
    if ($strSperrUser == '')
    {
      echo " <li><a href='p_fv_ausw_plan.php'>Bearbeitung des Plans</a></li> \n";
    }  
    echo "</ul>  \n";
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