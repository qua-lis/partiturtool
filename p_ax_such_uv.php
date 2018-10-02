<?php
  // p_ax_such_uv.php
  // 
  // AJAX: Suche nach Unterrichtsvorhaben in der Datenbank auf der Basis eines Suchbegriffs und der derzeit angezeigten UV.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 15-APR-2012.
  // lr: fh, 14-SEP-2013, Anpassung an neue Plan-Struktur (keine Bearbeitungszeile).
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="14.09.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Achtung, hier keine Session, daher noch keine Prüfung der Berechtigung.
  // Man könnte die Session-ID mit übergeben und in der DB überprüfen.

  // Parameter einlesen:
  $strSuchbegriff=ut_get_webpar('ssuche');      // Suchbegriff.
  // Weitere Parameter werden 1:1 aus Get-Aufruf des Plans weitergeleitet.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numSuccess=0;                              // Rückgabecode: 0 - ok, 1 - Fehler ist aufgetreten.
  if ($boolDEBUG) {trigger_error("start p_ax_such_uv.php");trigger_error(serialize($_REQUEST)); } 
  $arrResult=array();


  // -------------------------------------------------------------
  // Fehlerprüfungen:
  /*
    Keine bisher
  if ($numFehler == 0)
  {
  } // IF: Fehler?  
  */
      
  // -------------------------------------------------------------

  if (($numFehler == 0) and ($strSuchbegriff != ''))
  {

    list($numFehler,$strFehlercode,$arrFormparam)=p_read_auswahlform();
    if ($numFehler == 0)
    {
      // Ergebnis auf Einzelvariablen verteilen:
      list($numSF_ID,$strSchulform,$strSF_Kuerzel,
           $arrKatFaecher,$strFachCond,
           $arrKatStufen,$strStufenCond,
           $arrKatZuege,$strZugCond,
           $arrKatKursarten,$strKursartCond) = $arrFormparam;
    }
    elseif ($boolDEBUG)
    {
      {trigger_error("Fehler: $strFehlercode"); } 
    }// IF: Fehler beim Auslesen des Formulars?
    

    if ($numFehler == 0)
    {
      // Abfragebedingung zur Abfrage der Daten aus der DB:
      $strCond="$strFachCond $strStufenCond $strZugCond $strKursartCond";
      
      if ($boolDEBUG) {trigger_error("Abfragebedingung: $strCond"); } 
      

      // Daten aus der DB auslesen:
      $arrUV=array();
      $strSuchtext='%' . strtolower($strSuchbegriff) . '%';
      // Zunächst ohne Textfelder:
      $strSQL="SELECT DISTINCT tuv.uv_id,tuv.fach_id,
                               tuv.stufe_id,tuv.kursart_id,tuv.zug_id
             FROM $strGtabEinUnterrichtsvorhaben AS tuv
            WHERE (tuv.schulform_id=$numSF_ID)
              AND (LOWER(tuv.uv_titel) LIKE '$strSuchtext' )
                  $strCond";
      $stmtSQL = db_exec($strSQL,$boolDEBUG); 
      while (db_fetch_arr($stmtSQL,$arrSQL))
      {
        $numUVID=$arrSQL['uv_id'];
        $strDivTag='F' . $arrSQL['fach_id'] . '_S' .  $arrSQL['stufe_id'] . '_K' . $arrSQL['kursart_id'] . '_Z' . $arrSQL['zug_id'];
        $strUVTag='uv_' . $strDivTag . '_UV' . $numUVID;  
        $arrUV[$numUVID]=$strUVTag;
      }
      
      // Jetzt die Schleife durch die Textfelder mit einem INNER JOIN
      $strSQL="SELECT DISTINCT tuv.uv_id,tuv.schulform_id,tuv.fach_id,
                               tuv.stufe_id,tuv.kursart_id,tuv.zug_id
             FROM $strGtabEinUnterrichtsvorhaben AS tuv
             INNER JOIN $strGtabEinUVTextfelder AS ttf
                ON tuv.uv_id=ttf.uv_id
            WHERE (tuv.schulform_id=$numSF_ID)
              AND (LOWER(ttf.uv_text) LIKE '$strSuchtext' )
                  $strCond";
      $stmtSQL = db_exec($strSQL,$boolDEBUG); 
      while (db_fetch_arr($stmtSQL,$arrSQL))
      {
        $numUVID=$arrSQL['uv_id'];
        if (!isset($arrUV[$numUVID]))
        {
          $strDivTag='F' . $arrSQL['fach_id'] . '_S' .  $arrSQL['stufe_id'] . '_K' . $arrSQL['kursart_id'] . '_Z' . $arrSQL['zug_id'];
          $strUVTag='uv_' . $strDivTag . '_UV' . $numUVID;  
          $arrUV[$numUVID]=$strUVTag;
        } // IF: Schon vorhanden?  
      } 

      if ($boolDEBUG) {trigger_error("UV:" . serialize($arrUV)); } 
      
      if (count($arrUV) > 0)
      {
         // $arrResult=array_values($arrUV); // Alle Array-Werte (IDs der UV-DIVs) numerisch durchnumerieren.
         $arrResult=$arrUV;
      }   
   } // IF: Fehler?
 } // IF: Suchbegriff vorhanden?   

  // Ergebnis zurückgeben:
  $strResult=json_encode($arrResult);
  // trigger_error($strResult);
  echo $strResult;
   
  // -----------------------------------------------------
  // Ende PHP.
?>