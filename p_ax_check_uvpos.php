<?php
  // p_ax_check_uvpos.php
  // 
  // AJAX:
  // Prüft anhand der übergebenen Position, ob Kollision
  // mit anderem UV besteht und gibt sonst die bisherige Position zurück,
  // damit das UV zurückbewegt werden kann.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 02-JUL-2012.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="02.07.2012";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 


  // Parameter einlesen:
  $numXPos=ut_get_webpar_n('nxpos');      // X-Position in Pixeln, wenn 0, dann in den Ablagebereich zurück (Beginn, Ende = 0)
  $strBreite=ut_get_webpar('sbreite');    // Breite der UV in Pixeln mit px dahinter.
  $numBreite=str_replace('px','',$strBreite);   // px entfernen.
  $strUVID=ut_get_webpar('suvid');        // ID des Elements mit Unterrichtsvorhaben in der Datenbank als
                                          // zusammengesetzter String, z.B.: uv_F5_S1_K6_Z0_UV60, die DB-ID steht hinter UV
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strErgebnis=0;                             // Rückgabecode: 0 - ok, sonst Links-Wert und Breite der alten Position
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

    if ($numXPos > 0)
    {
      // Zu speichernde Daten berechnen:
      // $numStartPos=$numWoEinheit * ($numBeginn - 1) + $numLiOffset;
      // Das muss mal in Konfigurationsdatei, siehe auch p_erzeuge_plan
      $numWoEinheit=40;   // Pixel pro Woche
      $numLiOffset=153; // 53    // Basis-Offset links.
      $numRandBreite=13;  // Randbreite in Pixeln, die bei der Dauer abgezogen werden muss.
      $numBeginn=round((($numXPos -  $numLiOffset) / $numWoEinheit) + 1);   
      $numDauer=round(($numBreite + $numRandBreite) / $numWoEinheit);
      $numEnde=$numBeginn + $numDauer - 1; // - eine Woche, da die End-Woche mitgerechnet wird
    
      if ($boolDEBUG) {trigger_error("$numBeginn=(($numXPos -  $numLiOffset) / $numWoEinheit) + 1"); } 
      
      // Prüfen, ob es andere UV gibt, die sich mit den Daten überschneiden 
      // (gleiche Kombination aus Fach, Zug, ):
      $numAnzKoll=db_get_value("COUNT(*)",
                               "$strGtabEinUnterrichtsvorhaben teu1,
                                $strGtabEinUnterrichtsvorhaben teu2",
                               "     teu1.schulform_id=teu2.schulform_id
                                 AND teu1.fach_id=teu2.fach_id
                                 AND teu1.stufe_id=teu2.stufe_id
                                 AND teu1.kursart_id=teu2.kursart_id
                                 AND teu1.zug_id=teu2.zug_id
                                 AND teu1.uv_id = $numUVID
                                 AND teu1.uv_id != teu2.uv_id
                                 AND (    ((teu2.ende_kw >= $numBeginn) and (teu2.ende_kw <= $numEnde))
                                       OR ((teu2.beginn_kw >= $numBeginn) and (teu2.beginn_kw <= $numEnde))
                                       OR ((teu2.beginn_kw <= $numBeginn) and (teu2.ende_kw >= $numEnde)) )"); // , $boolDEBUG);
      if ($numAnzKoll > 0)
      {
        if ($boolDEBUG) {trigger_error("numAnzKoll: $numAnzKoll "); } 
        // bisherige Start und Dauer heraussuchen:
        db_get_2values("beginn_kw","zeitbedarf_wochen",$strGtabEinUnterrichtsvorhaben,"uv_id = $numUVID",
                       $numBeginnAlt,$numDauerAlt,$boolDEBUG);
        // Left und Width zurückrechnen:
        $numXPosAlt=$numWoEinheit * ($numBeginnAlt - 1) + $numLiOffset;
        $numBreiteAlt =  ($numDauerAlt * $numWoEinheit) - $numRandBreite;
        $strErgebnis=$numXPosAlt . '|' . $numBreiteAlt;
     }  
     else
     {
       $strErgebnis=0;
     }  
   } // IF: Position > 0?  
    
  } // IF: Fehler?  
  
  echo $strErgebnis;
  // -----------------------------------------------------
  // Ende PHP.
?>