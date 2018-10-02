<?php
  // p_ax_speicher_wostd.php
  // 
  // AJAX: Speichern einer Wochenstundenzahl in der Datenbank.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 30-SEP-2013.
  //  TODO: ggf. Sicherheitsprüfung, bisher noch nicht eingebaut!
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="30.09.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Achtung, hier keine Session, daher noch keine Prüfung der Berechtigung.
  // Man könnte die Session-ID mit übergeben und in der DB überprüfen.

  // Parameter einlesen:
  $numSF_ID=ut_get_webpar_n('nsf');        // Schulform-ID
  $numFachID=ut_get_webpar_n('nfach');     // Fach-ID
  $numStufeID=ut_get_webpar_n('nstufe');   // Stufe-ID
  $numZugID=ut_get_webpar_n('nzug');       // Zug-ID
  $numKursartID=ut_get_webpar_n('nkurs');  // Kurs-ID
  $numWoStd=ut_get_webpar_n('nwostd');     // Wochenstunden-Zahl.
  
  // TODO:$numUserID=ut_get_webpar_n('nuid');     // User-ID, die mangels Session als Parameter übergeben werden muss.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numSuccess=0;                              // Rückgabecode: 0 - ok, 1 - Fehler ist aufgetreten.
  if ($boolDEBUG) {trigger_error("start p_ax_speicher_wostd.php"); } 

  // -------------------------------------------------------------
  // Fehlerprüfungen:
  /*
  if ($numFehler == 0)
  {
    // User-ID prüfen:
    $numUserIDDB=db_get_value("user_id",$strGtabSysUser,"user_id=$numUserID",$boolDEBUG);
    if (($numUserIDDB == 0) or ($numUserIDDB != $numUserID))
    {
      $numFehler=1;
    } // IF: Gültiger Username?  
  } // IF: Fehler?  
  */
  
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
     // Prüfen, ob schon Eintrag existiert:
     $numExist=db_get_value('COUNT(wochenstunden)',$strGtabEinWochenStd,
                            "(schulform_id=$numSF_ID) and (fach_id=$numFachID) and (stufe_id=$numStufeID) ".
                            "and (kursart_id=$numKursartID) and (zug_id=$numZugID)",$boolDEBUG);
     if ($numExist)
     {
       // Update:
       $strSQLUpdIns="UPDATE $strGtabEinWochenStd
                         SET wochenstunden=$numWoStd
                       WHERE (schulform_id=$numSF_ID) 
                         AND (fach_id=$numFachID) 
                         AND (stufe_id=$numStufeID) 
                         AND (kursart_id=$numKursartID) 
                         AND (zug_id=$numZugID)";
     }
     else
     {
       // Insert:
       $strSQLUpdIns="INSERT INTO $strGtabEinWochenStd 
                             (schulform_id,fach_id,stufe_id,kursart_id,zug_id,wochenstunden)
                      VALUES ($numSF_ID,$numFachID,$numStufeID,$numKursartID,$numZugID,$numWoStd)";
     }        
     $boolSuccess=db_exec($strSQLUpdIns,$boolDEBUG);

    if ($boolSuccess)
    {
      $numSuccess=1;
    }
    else
    {
      $numFehler=1;
    }  
  } // IF: Fehler?  
  
  echo $numSuccess;
  // -----------------------------------------------------
  // Ende PHP.
?>