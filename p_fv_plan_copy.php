<?php
  // p_fv_plan_copy.php
  // 
  // FACHVERWALTER/IN
  // Kopiert alle UV einer "Zeile" (Kombination aus Fach/Stufe/Kursart/Zug) 
  // in eine andere Zeile (gleiches Fach, gleiche Stufe, andere Kursart, anderer Zug).
  // Schaltet danach wieder zum Plan zurück.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 14-APR-2012.
  // lr: fh, 19-AUG-2013, Fach für Sperre berücksichtigen.
  // lr: fh, 20-SEP-2013, Prüfen, ob Bearbeitungsrechte für das Fach vorliegen (numFachBearb statt numFachID). Neuer Kopier-Mechanismus.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2012";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_fv();         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearb=(empty($_SESSION['p_fach_id_bearb'])) ? '' : $_SESSION['p_fach_id_bearb'];
  $strSperrUser=p_sperre_bearb('I',true,false,$numFachBearb);    // prüfen, ob Sperre durch andere vorliegt.
  
  // Parameter einlesen:
  $strPlanPar=base64_decode(ut_get_webpar('splanpar'));    // diese werden nur 1:1 an das Plan-Darstellungsskript weitergereicht.
  $numKopieStufeID=ut_get_webpar_n('nstufe');      // Ziel-Angaben
  $numKopieKursartID=ut_get_webpar_n('nkurs');
  $numKopieZugID=ut_get_webpar_n('nzug');
  $numStufeID=ut_get_webpar_n('nstufeorg');     // Quell-Angabe
  $numKursartID=ut_get_webpar_n('nkursorg');
  $numZugID=ut_get_webpar_n('nzugorg');
  // Schulform muss aus $strPlanPar extrahiert werden.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
  $strGTitel=$strGAppTitel . " -  Unterrichtsvorhaben kopieren";

  // -------------------------------------------------------------
  // Fehler abfangen:
  if (($numFehler == 0) and ($numFachBearb == ''))
  {
     $numFehler=1;
     $strFehlercode='F0110';   // Fach oder Stufe konnte nicht festgestellt werden!
  }   
  else
  {
     $numFachBearbRecht=p_fv_fach();       
  } // IF: Bearbeitbares Fach angegeben?   

  if (($numFehler == 0) and ($numFachBearbRecht != $numFachBearb))
  {
     $numFehler=1;
     $strFehlercode='F0115';   // Für dieses Fach haben Sie keine Bearbeitungsrechte!
  } // IF: Rechte für dieses Fach?

  if ($numFehler == 0)
  {
     // Schulform feststellen:
     $numSchulformID = '';
     $numPos=strpos($strPlanPar,'nschulform=');
     if (($numPos !== false) and (substr($strPlanPar,$numPos,1) != '&'))
     {
       $numPos+=11;
       $numSchulformID=substr($strPlanPar,$numPos,strpos($strPlanPar,'&',$numPos)-$numPos);
     }  
     if ($numSchulformID == '')
     {
       $numSchulformID=(empty($_SESSION['p_auswahl']['nschulform'])) ? '' : $_SESSION['p_auswahl']['nschulform'];
     }

     if ($numSchulformID == '')
     {
       $numFehler=1;
       $strFehlercode='M0200'; // Bitte geben Sie eine Schulform an!
     } // IF: Schulform vorhanden?  
  } // IF: Fehler?
  
  if (($numFehler == 0) and ((empty($numFachBearb)) or ($numStufeID === '')))
  {
     $numFehler=1;
     $strFehlercode='F0110'; // Fach oder Stufe konnte nicht festgestellt werden!
  } // IF: Fehler / fehlende Parameter?

  if (($numFehler == 0) and (($numKopieKursartID === '') or ($numKopieZugID === '') or ($numKopieStufeID === '')))
  {
     $numFehler=1;
     $strFehlercode='F0111'; // Kursart / Zug für die Kopie konnte nicht festgestellt werden!
  } // IF: Fehler / fehlende Kopie-Parameter?
  
  
  if ($numFehler == 0) 
  {
    $numExistUVQuelle=db_get_value("COUNT(*)",$strGtabEinUnterrichtsvorhaben,
                                   "(schulform_id=$numSchulformID) and (fach_id=$numFachBearb) and 
                                    (stufe_id=$numStufeID) and (kursart_id=$numKursartID) and
                                    (zug_id=$numZugID)",$boolDEBUG);
    if ($numExistUVQuelle == 0)
    {
       $numFehler=1;
       $strFehlercode='F0112'; // Keine Unterrichtsvorhaben vorhanden, die kopiert werden könnten!
    } // IF: Keine Quell-UV?
  }   

  if ($numFehler == 0) 
  {
    // Prüfen, ob in Zielbereich UV vorhanden sind, dann nicht kopieren:
    $numExistUVZiel=db_get_value("COUNT(*)",$strGtabEinUnterrichtsvorhaben,
                                   "(schulform_id=$numSchulformID) and (fach_id=$numFachBearb) and 
                                    (stufe_id=$numKopieStufeID) and (kursart_id=$numKopieKursartID) and
                                    (zug_id=$numKopieZugID)",$boolDEBUG);
    if ($numExistUVZiel > 0)
    {
       $numFehler=1;
       $strFehlercode='F0113'; // In Zielbereich sind bereits Unterrichtsvorhaben vorhanden, daher Kopieren nicht möglich!
    } // IF: Keine Quell-UV?
  } // IF: Fehler?  


  // -------------------------------------------------------------
  if ($numFehler == 0)
  {
    // Alle UV der Quell-Zeile heraussuchen:
    $arrQuellUV=array();
    $strSQL="SELECT DISTINCT uv_id
               FROM $strGtabEinUnterrichtsvorhaben
              WHERE (schulform_id=$numSchulformID) 
                AND (fach_id=$numFachBearb)
                AND (stufe_id=$numStufeID) 
                AND (kursart_id=$numKursartID)
                AND (zug_id=$numZugID)";
    $stmtSQL = db_exec($strSQL,$boolDEBUG); 
    while (db_fetch_arr($stmtSQL,$arrSQL))
    {
      $arrQuellUV[]=$arrSQL['uv_id'];
    }
    
    // Jetzt alle UV durchgehen und deren Angaben für die Ziel-Zeile kopieren:
    foreach ($arrQuellUV as $numUVID)
    {
      $numUVIDKopie=db_get_value("MAX(uv_id)",$strGtabEinUnterrichtsvorhaben,'',$boolDEBUG) + 1;
      $strSQLIns="INSERT INTO $strGtabEinUnterrichtsvorhaben
                         (uv_id,schulform_id,fach_id,stufe_id,kursart_id,zug_id,
                          uv_titel,zeitbedarf_std,zeitbedarf_wochen,beginn_kw,ende_kw,
                          aenderung_user_id)
                  SELECT $numUVIDKopie,$numSchulformID,$numFachBearb,$numKopieStufeID,$numKopieKursartID,$numKopieZugID,  
                         uv_titel,zeitbedarf_std,zeitbedarf_wochen,beginn_kw,ende_kw,
                         $numUserID
                    FROM $strGtabEinUnterrichtsvorhaben
                   WHERE uv_id=$numUVID";
      db_exec($strSQLIns,$boolDEBUG);
      
      // Jetzt die Textfelder kopieren:
      $strSQLIns="INSERT INTO $strGtabEinUVTextfelder
                         (uv_id,textfeld_id,uv_text)
                  SELECT $numUVIDKopie,textfeld_id,uv_text
                    FROM $strGtabEinUVTextfelder
                   WHERE uv_id=$numUVID";
      db_exec($strSQLIns,$boolDEBUG);
    } // FOR-Schleife durch alle UV.
                  
    if (!$boolDEBUG)
    {
       // $strPlanURL='p_fv_plan.php?' . str_replace('&amp;','&',$strPlanPar);
       // header("location: $strPlanURL");
       // exit;
       // JS-Code zum Aktualisieren der Plan-Seite:
       echo "<script type='text/javascript'> \n";
       echo "opener.location.reload(true);\n";
       echo "window.close();\n"; // Sich selbst schließen
       echo "</script>\n";
    } // IF: Debug-Modus?  

  } // IF: Fehler aufgetreten?

  // -----------------------------------------------------------------------------------------------------
  
  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    include($strGIncPath . "p_gui_kopf_popup.inc.php");  // HTML-Seite aufbauen mit PopUpHeader.
    p_fehler_ausgabe($strFehlercode);
    echo "   </div> <!-- pcontainer --> \n";
    echo "  </div> <!-- pinhalt --> \n";
    echo " </body>\n";
    echo "</html>\n";
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------

  // Ende PHP.
?>