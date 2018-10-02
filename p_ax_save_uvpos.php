<?php
  // p_ax_save_uvpos.php
  // 
  // AJAX: Abspeichern der aktuellen Position eines Unterrichtsvorhabens in der Datenbank.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 23-DEC-2011.
  // lr: fh, 01-FEB-2012, Erweiterung zum Zurücksetzen des Unterrichtsvorhabens (nxpos=0).
  // lr. fh, 27-MAR-2012, Offset angepasst.
  // lr: fh, 13-APR-2012, UV-Infos vor dem Speichern in Session-Tabelle sichern.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="13.04.2012";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Achtung, hier keine Session, daher noch keine Prüfung der Berechtigung.
  // Man könnte die Session-ID mit übergeben und in der DB überprüfen.

  // Parameter einlesen:
  $numXPos=ut_get_webpar_n('nxpos');      // X-Position in Pixeln, wenn 0, dann in den Ablagebereich zurück (Beginn, Ende = 0)
  $strBreite=ut_get_webpar('sbreite');    // Breite der UV in Pixeln mit px dahinter.
  $numBreite=str_replace('px','',$strBreite);   // px entfernen.
  $strUVID=ut_get_webpar('suvid');        // ID des Elements mit Unterrichtsvorhaben in der Datenbank als
                                          // zusammengesetzter String, z.B.: uv_F5_S1_K6_Z0_UV60, die DB-ID steht hinter UV
  $numUserID=ut_get_webpar_n('nuid');     // User-ID, die mangels Session als Parameter übergeben werden muss.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numSuccess=0;                              // Rückgabecode: 0 - ok, 1 - Fehler ist aufgetreten.
  if ($boolDEBUG) {trigger_error("start p_ax_save_uvpos.php"); } 

  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if ($numFehler == 0)
  {
    if (($numXPos != 0) and (!is_numeric($numBreite)))
    {
      $numFehler=1;
    }
    else
    {
      $numUVID=substr($strUVID,strrpos($strUVID,'_UV')+3);
      if (!is_numeric($numUVID))
      {
        $numFehler=1; // Keine vernünftige ID.
      }   
    } // IF: Positionsangabe > 0
  } // IF: Fehler?  
      
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {

    // CID:fh120413:Wenn UV noch nicht in Änderungsspeicher, Angaben vor dem Speichern dort sichern:
    p_uv_retten($numUserID,$numUVID); // Sichert Daten aktueller UV in Sicherungstabelle.

    if ($numXPos == 0)
    {
      // In den Ablagebereich zurück (Beginn, Ende = 0)
      if ($boolDEBUG) {trigger_error("AX Reset $strUVID $numUVID"); } 
     
      $strSQLUpd="UPDATE $strGtabEinUnterrichtsvorhaben
                     SET beginn_kw=0,
                         ende_kw=0,
                         aenderung_user_id=$numUserID
                   WHERE uv_id=$numUVID";
      $boolSuccess=db_exec($strSQLUpd,$boolDEBUG);
    }
    else
    {
      // Zu speichernde Daten berechnen:
      // $numStartPos=$numWoEinheit * ($numBeginn - 1) + $numLiOffset;
      // Das muss mal in Konfigurationsdatei, siehe auch p_erzeuge_plan
      $numWoEinheit=40;   // Pixel pro Woche
      $numLiOffset=153; // 53    // Basis-Offset links.
      $numRandBreite=13;  // Randbreite in Pixeln, die bei der Dauer abgezogen werden muss.
      $numBeginn=(($numXPos -  $numLiOffset) / $numWoEinheit) + 1;   
      $numDauer=($numBreite + $numRandBreite) / $numWoEinheit;
      $numEnde=$numBeginn + $numDauer - 1; // - eine Woche, da die End-Woche mitgerechnet wird
    
      if ($boolDEBUG) {trigger_error("$numBeginn=(($numXPos -  $numLiOffset) / $numWoEinheit) + 1"); } 
     
      $strSQLUpd="UPDATE $strGtabEinUnterrichtsvorhaben
                     SET beginn_kw=$numBeginn,
                         ende_kw=$numEnde,
                         zeitbedarf_wochen=$numDauer,
                         aenderung_user_id=$numUserID
                   WHERE uv_id=$numUVID";
      $boolSuccess=db_exec($strSQLUpd,$boolDEBUG);
    }  
    
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