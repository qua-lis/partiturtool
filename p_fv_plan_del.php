<?php
  // p_fv_plan_del.php
  // 
  // FACHVERWALTER/IN
  // Löscht alle UV einer "Zeile" (Kombination aus Fach/Stufe/Kursart/Zug) 
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
  // fh, 02-OCT-2013.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="02.10.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_fv();         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearb=(empty($_SESSION['p_fach_id_bearb'])) ? '' : $_SESSION['p_fach_id_bearb'];
  $strSperrUser=p_sperre_bearb('I',true,false,$numFachBearb);    // prüfen, ob Sperre durch andere vorliegt.
  
  // Parameter einlesen:
  $strPlanPar=base64_decode(ut_get_webpar('splanpar'));    // diese werden nur 1:1 an das Plan-Darstellungsskript weitergereicht.
  $numStufeID=ut_get_webpar_n('nstufe');      
  $numKursartID=ut_get_webpar_n('nkurs');
  $numZugID=ut_get_webpar_n('nzug');
  // Schulform muss aus $strPlanPar extrahiert werden.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
  $strGTitel=$strGAppTitel . " -  Unterrichtsvorhaben löschen";

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

  if (($numFehler == 0) and (($numKursartID === '') or ($numZugID === '') or ($numStufeID === '')))
  {
     $numFehler=1;
     $strFehlercode='F0111'; // Kursart / Zug für die Kopie konnte nicht festgestellt werden!
  } // IF: Fehler / fehlende Kopie-Parameter?
  
  
  if ($numFehler == 0) 
  {
    $numExistUV=db_get_value("COUNT(*)",$strGtabEinUnterrichtsvorhaben,
                                   "(schulform_id=$numSchulformID) and (fach_id=$numFachBearb) and 
                                    (stufe_id=$numStufeID) and (kursart_id=$numKursartID) and
                                    (zug_id=$numZugID)",$boolDEBUG);
    if ($numExistUV == 0)
    {
       $numFehler=1;
       $strFehlercode='F0118'; // Keine Unterrichtsvorhaben vorhanden, die gelöscht werden könnten!
    } // IF: Keine Quell-UV?
  }   

  // -------------------------------------------------------------
  if ($numFehler == 0)
  {
    // Zunächst alle abhängigen Datensätze löschen (Textfeld-Inhalte):
    $strSQLDel="DELETE FROM $strGtabEinUVTextfelder
                      WHERE uv_id IN
                           (SELECT DISTINCT uv_id FROM $strGtabEinUnterrichtsvorhaben
                             WHERE (schulform_id=$numSchulformID) 
                               AND (fach_id=$numFachBearb)
                               AND (stufe_id=$numStufeID) 
                               AND (kursart_id=$numKursartID)
                               AND (zug_id=$numZugID))";
    $stmtSQL = db_exec($strSQLDel,$boolDEBUG); 
                           
    // Jetzt die Unterrichtsvorhaben selbst löschen:
    $strSQLDel="DELETE FROM $strGtabEinUnterrichtsvorhaben
                 WHERE (schulform_id=$numSchulformID) 
                   AND (fach_id=$numFachBearb)
                   AND (stufe_id=$numStufeID) 
                   AND (kursart_id=$numKursartID)
                   AND (zug_id=$numZugID)";
    $stmtSQL = db_exec($strSQLDel,$boolDEBUG); 

    // Wochenstundenzahl löschen:
    $strSQLDel="DELETE FROM $strGtabEinWochenStd
                 WHERE (schulform_id=$numSchulformID) 
                   AND (fach_id=$numFachBearb)
                   AND (stufe_id=$numStufeID) 
                   AND (kursart_id=$numKursartID)
                   AND (zug_id=$numZugID)";
    $stmtSQL = db_exec($strSQLDel,$boolDEBUG); 
    
    if (!$boolDEBUG)
    {
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