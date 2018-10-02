<?php
  // p_fv_ausw_plan.php
  //
  // FACHVERWALTER/IN
  // Auswahl der Kriterien für die Planung (anzuzeigende Fächer etc. + zu bearbeitendes Fach).
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
  // lr: fh, 01-FEB-2012, Auswahloptionen werden in der Session abgelegt, außerdem per JS automatisch abgewählt.
  // lr: fh, 02-FEB-2012, Kapselung der Auswahl zur Weiterverwendung.
  // lr: fh, 02-JUL-2012, 
  // lr: fh, 19-AUG-2013, nur bearbeitbares Fach sperren.
  // lr: fh, 14-SEP-2013, Nur bearbeitbares Fach anzeigen, Auswahl zur Bearbeitung nicht mehr erforderlich.
  // lr: fh, 22-OCT-2013, Erweiterungen.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="22.10.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php");

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_fv();         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearb=p_fv_fach();        // CID:fh130819:Fach heraussuchen, das bearbeitet werden darf.
  p_sperre_bearb('S',true,true,$numFachBearb);    // Sperre einrichten, sonst Fehlermeldungsseite

  // Parameter einlesen:
  // keine bisher


  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Auswahl der Kriterien zur Planung";
  $_SESSION['p_plan_uv_ausblend']=array();    // Ausgeblendete UV zurücksetzen.
  
  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  $strGHeaderInclude="p_gui_auswahl.inc.php";       // Zusätzliche Include-Datei mit jQuery-Elementen.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------

  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if ($numFachBearb == '')
  {
    $numFehler=1;
    $strFehlercode='F0114';  // Für Sie wurde noch kein Fach zur Bearbeitung freigegeben.<br />Bitte wenden Sie sich an die Systemadministration!
  }
  else
  {
    // Fachbezeichnung heraussuchen:
    $strFachBearbBez=db_get_value('fach',$strGtabKatFach,"(fach_id=$numFachBearb)",$boolDEBUG);
  }
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    echo "<h2>Kritieren zur Planung, Fach: $strFachBearbBez</h2>\n";
    echo "<p>Bitte geben Sie zunächst an, welche Kombinationen Sie sehen und bearbeiten möchten:</p>\n";

    // Auswahl-Formular aufbauen:
    // --------------------------  
    // Get hier besser als post, damit Parameter beim Reload wieder zur Verfügung stehen.
    echo "<form name='frm_p_ausw_plan' id='frm_p_ausw_plan' method='get' action='p_fv_plan_start.php'>\n";

    $arrVorauswahl=(isset($_SESSION['p_auswahl'])) ? $_SESSION['p_auswahl'] : ''; // Vorauswahl der Optionen aus der Session holen.
    $strBearbWahl='';                   // Variable zur Anzeige der Bearbeitungsoptionen.
    $strBearbWahl .= p_frm_auswahlform($arrVorauswahl,$numFachBearb); // Spalten des Formulars ausgeben.
    echo $strBearbWahl;


    // --------------------------------------------------------------------
    // Zeile zur Auswahl der zu bearbeitenden Unterrichtsvorhaben aufbauen:
    /*
      Nicht mehr erforderlich, da ja nur noch ein Fach bearbeitet werden kann
    echo "<br class='pclear' />\n";
    echo "<h2>Zu bearbeitende Fachkombination</h2>\n";
    echo "<p>Bitte wählen Sie nun aus, welche Fachkombinationen Sie bearbeiten möchten:</p>\n";
    echo "<div class='pauswahlzeile'>\n";
    echo $strBearbWahl;
    echo "</div>\n";  // pauswahlzeile
    echo "<p><br /></p>\n";
    */
    // --------------------------------------------------------------------

    // Form-Abschluss:
    // --------------
    echo "<br class='pclear' />\n";
    echo "<br />\n";
    echo " <input class='pbutton' type='submit' id='psubmit' value='Plan bearbeiten'  tabindex='3' /> \n";
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