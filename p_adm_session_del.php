<?php
  // p_adm_session_del.php
  // 
  // ADMIN
  // Übergebene Bearbeitungssperre aufheben.
  //
  // Parameter:
  //      ssessionid  ID der zu löschenden Sitzung.
  //      nconfirm    Bestätigung des Löschens: 0 - Bestätigung anfragen, 1 - Löschen bestätigt.
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
  p_session_start();     // Session-ID und Variablen zuordnen.
  p_check_adm();         // Prüfung, ob als Admin angemeldet.

  // Parameter einlesen:
  $strDelSessionID=ut_get_webpar('ssessionid');   // ID der zu löschenden Sitzung.
  $numConfirm=ut_get_webpar_n('nconfirm');        // Bestätigung des Löschens: 0 - Bestätigung anfragen, 1 - Löschen bestätigt.
  
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
  if (($numFehler == 0) and (empty($strDelSessionID)))
  {
     $numFehler=1;
     $strFehlercode='A0119';    // "Sitzungs-ID wurde nicht angegeben!";
  }

  if ($numFehler == 0)
  {
     $strDelSessionIDDB=db_get_value('session_id',$strGtabSysSperren,"session_id='$strDelSessionID'",$boolDEBUG);
     if ((empty($strDelSessionIDDB)) or ($strDelSessionIDDB != $strDelSessionID))
     {
       $numFehler=1;
       $strFehlercode='A0120';    // "Die angegebene Sitzungs-ID ist ungültig!";
     } // IF: Stimmt die Sitzungs-ID?  
  } // IF: Fehler?
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    // Daten zu der Sitzung heraussuchen:
    $strSQL="SELECT DISTINCT tsu.user_id,tsu.anmeldename,tsu.vollname,tsu.anmeldetyp,
                    tsu.fach_id,tkf.fach,tss.sessionende,tss.session_id
               FROM $strGtabSysSperren tss
              INNER JOIN $strGtabSysUser tsu
                 ON tss.user_id=tsu.user_id
               LEFT JOIN $strGtabKatFach tkf
                 ON tss.fach_id=tkf.fach_id
              WHERE tss.session_id='$strDelSessionID'";
    $stmtSQL = db_exec($strSQL,$boolDEBUG); 
    db_fetch_arr($stmtSQL,$arrSessionInfo);
    
    echo "<h2>Bearbeitungssitzung/-sperre löschen</h2>\n";
 
    echo "<dl>\n";
    echo "<dt>Anmeldename: </dt><dd>" .  $arrSessionInfo['anmeldename'] . "</dd>\n";
    echo "<dt>Vor- und Zuname: </dt><dd>" .  $arrSessionInfo['vollname'] . "</dd>\n";
    echo "<dt>Fach: </dt><dd>" .  $arrSessionInfo['fach'] . "</dd>\n";
    echo "</dl>\n";

    if ($numConfirm == 0)
    {
      // Nachfragen, ob der Eintrag gelöscht werden soll:
      echo "<h3>Möchten Sie die genannte Bearbeitungssperre tatsächlich löschen?</h3>\n";

      echo "<br />\n";
      echo "<p><ul>\n";
      echo "<li><a href='p_adm_session_del.php?nconfirm=1&ssessionid=$strDelSessionID'>JA, diesen Sperre löschen!</a></li>";
      echo "<br />\n";
      echo "<li><a href='p_adm_session_list.php'>NEIN, diese Sperre NICHT löschen!</a></li>";
      echo "</ul></p>\n";
    }
    else
    {
      // Bestätigung liegt vor, Eintrag löschen:
      $strSQLDel="DELETE FROM $strGtabSysSperren WHERE session_id='$strDelSessionID' ";
      $boolSuccess=db_exec($strSQLDel,$boolDEBUG);
      
      if ($boolSuccess)
      {
        echo "<h2>Die Bearbeitungssperre wurde erfolgreich gelöscht!</h2>\n";
        echo "<p>";
        echo "<a href='p_adm_auswahl.php'>zurück zur Admin-Auswahl</a>";
        echo "</p>\n";
        p_log(3310,"Sitzung $strDelSessionID, User: " . $arrSessionInfo['anmeldename'] . ", Fach:"  . $arrSessionInfo['fach']); // Log-Eintrag.
      }
      else
      {
        echo "<br />\n";
        echo "<h2>Die Bearbeitungssperre konnte nicht gelöscht werden (Datenbank-Fehler)!</h2>\n";
        echo "<p>Evtl. wurde die Sitzung bereits beendet.</p>\n";
        echo "<ul>";
        echo "<li><a href=p_adm_session_list.php'>zurück zur Auflistung der Sperren</a></li>";
        echo "<li><a href='p_adm_auswahl.php'>zurück zur Admin-Auswahl</a></li>";
        echo "</ul>\n";
        p_log(8130,"Sitzung $strDelSessionID, User: " . $arrSessionInfo['anmeldename'] . ", Fach:"  . $arrSessionInfo['fach']); // Log-Eintrag.
      }
    } // IF: Bestätigung liegt vor.  
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
