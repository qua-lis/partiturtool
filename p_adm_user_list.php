<?php
  // p_adm_user_list.php
  // 
  // ADMIN
  // Liste der Nutzer/innen
  //
  // Parameter:
  //      keine
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 29-MAR-2012.
  // lr: fh, 19-AUG-2013, bei Fachverwalter/innen Fach anzeigen.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_adm();         // Prüfung, ob als Admin angemeldet.

  // Parameter einlesen:
  // keine bisher.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Liste der Nutzerinnen und Nutzer";


  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen:
  // keine bisher
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    $arrDaten=array();
    $strSQL="SELECT DISTINCT tsu.user_id,tsu.anmeldename,tsu.vollname,tsu.anmeldetyp,
                    tsu.fach_id,tkf.fach
               FROM $strGtabSysUser tsu
               LEFT JOIN $strGtabKatFach tkf
                 ON tsu.fach_id=tkf.fach_id
              ORDER BY tsu.anmeldename";
    $stmtSQL = db_exec($strSQL,$boolDEBUG); 
    while (db_fetch_arr($stmtSQL,$arrSQL))
    {
      $arrDaten[]=$arrSQL;
    } // DB-Schleife durch die Konfigurationseinträge.
    

    echo "<ul><li><a href='p_adm_user_edit.php'>Neue/n Nutzer/in anlegen</a></li></ul>\n";
    echo "<br /> &nbsp; <br />\n";

    // Tabelle aufbauen:
    echo "<table>";
    echo "<thead>\n";
    echo "<tr><th>User_ID</th>";
    echo "<th>Anmeldename</th>";
    echo "<th>Vor- und Zuname</th>";
    echo "<th>Typ</th>";
    echo "<th>Fach</th>";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    foreach ($arrDaten as $arrUserInfo)
    {
      $numUserID=$arrUserInfo['user_id'];
      $strEditURL="<a href='p_adm_user_edit.php?nuserid=$numUserID'>";
      echo "<tr>";
      echo "<td>$strEditURL" . $numUserID . "</a></td>";
      echo "<td>$strEditURL" . $arrUserInfo['anmeldename'] . "</a></td>";
      echo "<td>" . $arrUserInfo['vollname'] . "</td>";
      $strATyp=$arrUserInfo['anmeldetyp'];
      echo "<td>" . $arrGLoginTypen[$strATyp] . "</td>";
      $strFach=(($strATyp == 'F') and (!empty($arrUserInfo['fach']))) ? $arrUserInfo['fach'] : '&nbsp;';
      echo "<td>" . $strFach . "</td>";
      echo "</tr>\n";
    } // FOR-Schleife durch alle Datensätze.
    
    echo "</tbody>\n";
    echo "</table>\n";
    echo "<br /> &nbsp; <br />\n";
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------

  echo "<ul>\n";
  echo " <li><a href='p_adm_auswahl.php'>zurück zur Auswahlseite</a></li> \n";
  echo "</ul>  \n";
  
  
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
