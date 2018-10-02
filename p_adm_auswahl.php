<?php
  // p_adm_auswahl.php
  // 
  // ADMIN
  // Auswahl der Funktionen für Admins.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 27-MAR-2012.
  // lr: fh, 12-APR-2012, Sperre.
  // lr: fh, 19-AUG-2013, Sperre für Admins entfernt.
  // lr: fh, 29-SEP-2013, Aktuelle Fachverwalter-Sperren anzeigen.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="29.09.2012";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_adm();         // Prüfung, ob als Admin angemeldet.
  p_sperre_bearb('F',true,false);                  // eigene Sperre ggf. freigeben.
  ##$strSperrUser=p_sperre_bearb('I',true,false);    // prüfen, ob Sperre durch andere vorliegt.

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
    echo "<h2>Funktionen für Administratorinnen und Administratoren</h2>\n";
    
    /*
    if ($strSperrUser != '')
    {
       echo "<br /><p>Da der Nutzer/die Nutzerin '$strSperrUser' zur Zeit eine Bearbeitungsfunktion
                      nutzt, stehen für Sie einige Funktionen nicht zur Verfügung, um Konflikte zu 
                      vermeiden.</p><br />\n";
    } // IF: Sperre?                
    */
    
    $numSperren=p_adm_check_sperren();
    if ($numSperren > 0)
    {
       echo "<br /><p>Hinweis:<br />
                      Derzeit " .
                      (($numSperren == 1) ? "ist ein/e Fachverwalter/in" : "sind $numSperren Fachverwalter/innen") .
                      " aktiv. Bitte beachten Sie dieses, falls Sie die aktuelle Konfiguration ändern!<br />\n";
       echo "<a href='p_adm_session_list.php'>Aktuelle Bearbeitungssitzungen</a> (mit Möglichkeit, diese zu beenden).<br />\n";                      
       echo "</p><br />\n";
    } // IF: Sperre?                
    
                   
    echo "<p>Bitte wählen Sie:</p>\n";
           
    echo "<ul class='padmwahl'>\n";
    echo " <li><a href='p_aus_auswahl.php'>Präsentation und Auswertung der vorliegenden Daten</a></li> \n";

    /* CID:fh130819:Admins dürfen den Plan nicht mehr bearbeiten:
    if ($strSperrUser == '')
    {
      // Wenn Sperre vorliegt, diese Funktionen nicht anbieten:
      echo " <li><a href='p_fv_ausw_plan.php'>Bearbeitung des Plans</a></li> \n";
      echo " <li>Konfiguration:<ul>";
      // Konfigurationsbereiche werden aus $arrGKatalogKonf entnommen (siehe p_sys_konfig_allg.inc.php).
      foreach ($arrGKatalogKonf as $strKonfK => $strLabel)
      {
        echo "<li><a href='p_adm_konf.php?skonf=$strKonfK'>$strLabel</a></li>\n";
      } // FOR-Schleife durch alle Konfigurationsoptionen.  
      echo "</ul></li> \n";
    } // IF: Sperre?  
    */

      echo " <li>Konfiguration:<ul>";
      // Konfigurationsbereiche werden aus $arrGKatalogKonf entnommen (siehe p_sys_konfig_allg.inc.php).
      foreach ($arrGKatalogKonf as $strKonfK => $strLabel)
      {
        echo "<li><a href='p_adm_konf.php?skonf=$strKonfK'>$strLabel</a></li>\n";
      } // FOR-Schleife durch alle Konfigurationsoptionen.  
      echo "</ul></li> \n";

    echo " <li>Verwaltung der Nutzer/innen:<ul>";
    echo "    <li><a href='p_adm_user_list.php'>Liste der Nutzer/innen</a></li>\n";
    echo "    <li><a href='p_adm_user_edit.php'>Neue/n Nutzer/in anlegen</a></li>\n";
    echo "</ul></li> \n";
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