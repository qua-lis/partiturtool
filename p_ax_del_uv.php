<?php
  // p_ax_del_uv.php
  // 
  // AJAX: Löschen eines Unterrichtsvorhabens aus der Datenbank.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 02-JUL-2011.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="02.07.2012";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Achtung, hier keine Session, daher noch keine Prüfung der Berechtigung.
  // Man könnte die Session-ID mit übergeben und in der DB überprüfen.

  // Parameter einlesen:
  $strUVID=ut_get_webpar('suvid');        // ID des Elements mit Unterrichtsvorhaben in der Datenbank als
                                          // zusammengesetzter String, z.B.: uv_F5_S1_K6_Z0_UV60, die DB-ID steht hinter UV
  $numUserID=ut_get_webpar_n('nuid');     // User-ID, die mangels Session als Parameter übergeben werden muss.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numSuccess=0;                              // Rückgabecode: 0 - ok, 1 - Fehler ist aufgetreten.
  if ($boolDEBUG) {trigger_error("start p_ax_del_uv.php"); } 

  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if ($numFehler == 0)
  {
    // User-ID prüfen:
    $numUserIDDB=db_get_value("user_id",$strGtabSysUser,"user_id=$numUserID",$boolDEBUG);
    if (($numUserIDDB == 0) or ($numUserIDDB != $numUserID))
    {
      $numFehler=1;
    } // IF: Gültiger Username?  
  } // IF: Fehler?  
  
  if ($numFehler == 0)
  {
     $numUVID=substr($strUVID,strrpos($strUVID,'_UV')+3);
     if (!is_numeric($numUVID))
     {
       $numFehler=1; // Keine vernünftige ID.
     }   
  } // IF: Fehler?  

  // -------------------------------------------------------------

  if ($numFehler == 0)
  {

    // Wenn UV noch nicht in Änderungsspeicher, Angaben vor dem Speichern dort sichern:
    // p_uv_retten($numUserID,$numUVID); // Sichert Daten aktueller UV in Sicherungstabelle.
      // Das Wiederherstellen wird allerdings momentan nicht unterstützt, daher hier weglassen ...

    // Erst aus der Textfelder-Tabelle löschen:
    $strSQLDel1="DELETE FROM $strGtabEinUVTextfelder
                  WHERE uv_id=$numUVID";
    $boolSuccess=db_exec($strSQLDel1,$boolDEBUG);

    if ($boolSuccess)
    {
      // Jetzt aus der UV-Tabelle löschen:
      $strSQLDel2="DELETE FROM $strGtabEinUnterrichtsvorhaben
                    WHERE uv_id=$numUVID";
      $boolSuccess=db_exec($strSQLDel2,$boolDEBUG);
    }  // IF: Löschen erfolgreich?

    
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