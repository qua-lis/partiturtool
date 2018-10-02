<?php
  // p_adm_session_list.php
  // 
  // ADMIN
  // Liste der aktuellen Sperren durch Fachverwalter/innen.
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
  // fh, 29-SEP-2013.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="29.09.2013";

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
  $strGTitel=$strGAppTitel . " -  Liste der aktiven Bearbeitungssitzungen";


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
                    tsu.fach_id,tkf.fach,tss.sessionende,tss.session_id
               FROM $strGtabSysSperren tss
              INNER JOIN $strGtabSysUser tsu
                 ON tss.user_id=tsu.user_id
               LEFT JOIN $strGtabKatFach tkf
                 ON tss.fach_id=tkf.fach_id
              ORDER BY tss.sessionende";
    $stmtSQL = db_exec($strSQL,$boolDEBUG); 
    while (db_fetch_arr($stmtSQL,$arrSQL))
    {
      $arrDaten[]=$arrSQL;
    } // DB-Schleife durch die Konfigurationseinträge.
    
    echo "<p>Sie können einzelne Bearbeitungssperren löschen, wenn Sie sicher sind, dass diese
          auf einer Systemfehlfunktion beruhen oder noch erhalten geblieben sind, weil der/die
          entsprechende Fachverwalter/in sich eventuell nicht ordnungsgemäß abgemeldet hat.
          <br />
          Derzeit werden Sperren automatisch nach $intGSessionTimeout Minuten aufgehoben.
          <br />
          </p><br />\n";
       
          

    // Tabelle aufbauen:
    echo "<table>";
    echo "<thead>\n";
    echo "<tr><th>User_ID</th>";
    echo "<th>Anmeldename</th>";
    echo "<th>Vor- und Zuname</th>";
    echo "<th>Typ</th>";
    echo "<th>Fach</th>";
    echo "<th>Sitzungsende</th>";
    echo "<th>Sperre löschen?</th>";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    foreach ($arrDaten as $arrSessionInfo)
    {
      $numUserID=$arrSessionInfo['user_id'];
      $strSperrSessionID=$arrSessionInfo['session_id'];
      $strDelURL="<a href='p_adm_session_del.php?ssessionid=$strSperrSessionID'>";
      echo "<tr>";
      echo "<td>$numUserID</td>";
      echo "<td>" . $arrSessionInfo['anmeldename'] . "</td>";
      echo "<td>" . $arrSessionInfo['vollname'] . "</td>";
      $strATyp=$arrSessionInfo['anmeldetyp'];
      echo "<td>" . $arrGLoginTypen[$strATyp] . "</td>";
      $strFach=(($strATyp == 'F') and (!empty($arrSessionInfo['fach']))) ? $arrSessionInfo['fach'] : '&nbsp;';
      echo "<td>" . $strFach . "</td>";
      $strEndZeit=date('d.m.Y H:i',$arrSessionInfo['sessionende']);
      echo "<td>" . $strEndZeit . "</td>";
      echo "<td>" . $strDelURL . "löschen?</a></td>";
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
