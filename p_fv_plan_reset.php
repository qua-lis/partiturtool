<?php
  // p_fv_plan_reset.php
  // 
  // FACHVERWALTER/IN
  // Setzt alle Änderungen, die in der Sitzung gemacht wurden, auf den ursprünglichen Zustand zurück.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 13-APR-2012.
  // lr: fh, 19-AUG-2013, Bearbeitungssperre auf ein Fach beziehen.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_fv();         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearb=(empty($_SESSION['p_fach_id_bearb'])) ? '' : $_SESSION['p_fach_id_bearb'];
  p_sperre_bearb('S',true,true,$numFachBearb);      // Sperre einrichten, sonst Fehlermeldungsseite
  
  // Parameter einlesen:
  // diese werden nur 1:1 an das Plan-Darstellungsskript weitergereicht.
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
  $strGTitel=$strGAppTitel . " -  Änderungen zurücksetzen";

  // -------------------------------------------------------------
  if ($numFehler == 0)
  {
    // Sitzungswiederherstellungsdaten aus der DB auslesen:
    $arrDatRestore=array();
    $strSQL="SELECT * FROM $strGtabSysAendSess WHERE user_id=$numUserID";
    $stmtSQL = db_exec($strSQL,$boolDEBUG); 
    while (db_fetch_arr($stmtSQL,$arrSQL))
    {
      $arrDatRestore[$arrSQL['uv_id']]=$arrSQL;
    }
    
    if (count($arrDatRestore) > 0)
    {
      foreach ($arrDatRestore as $numUVID => $arrUVData)
      {
        $strSQLUpd="UPDATE $strGtabEinUnterrichtsvorhaben
                       SET schulform_id = " . $arrUVData['schulform_id'] . ",
                           fach_id = " . $arrUVData['fach_id'] . ",
                           stufe_id = " . $arrUVData['stufe_id'] . ",
                           kursart_id = " . $arrUVData['kursart_id'] . ",
                           zug_id  = " . $arrUVData['zug_id'] . ",
                           zeitbedarf_std  = " . $arrUVData['zeitbedarf_std'] . ",
                           zeitbedarf_wochen  = " . $arrUVData['zeitbedarf_wochen'] . ",
                           beginn_kw  = " . $arrUVData['beginn_kw'] . ",
                           ende_kw  = " . $arrUVData['ende_kw'] . ",
                           aenderung_user_id  = " . $arrUVData['aenderung_user_id'] . ",
                           aenderung_zeitstempel  = '" . $arrUVData['aenderung_zeitstempel'] . "'
                    WHERE uv_id=$numUVID";
        db_exec($strSQLUpd,$boolDEBUG);
      } // FOR-Schleife durch alle Wh-Infos.  
      
      // Alle Wiederherstellungsdaten löschen:
      $strSQLDel="DELETE FROM $strGtabSysAendSess WHERE user_id = $numUserID";
      db_exec($strSQLDel,$boolDEBUG);
    } // IF: Wiederherstellungsdaten vorhanden?  
    
    if (!$boolDEBUG)
    {
       $strPlanURL='p_fv_plan.php?' . $_SERVER['QUERY_STRING'];
       header("location: $strPlanURL");
       exit;
    }   

  } // IF: Fehler aufgetreten?

  // -----------------------------------------------------------------------------------------------------
  
  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    p_fehler_seite($strFehlercode);
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------

  // Ende PHP.
?>