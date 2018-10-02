<?php
  // p_fv_plan_del_frage.php
  // 
  // Fachverwalter: PopUp-Fenster zur Auswahl der Zielzeile, wenn gesamte UV-Zeile gelöscht werden soll.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // lr, fh, 02-OCT-2012.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="02.10.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();                 // Session-ID und Variablen zuordnen.
  $boolFV=p_check_fv(false);         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearb=(empty($_SESSION['p_fach_id_bearb'])) ? '' : $_SESSION['p_fach_id_bearb'];
  $strSperrUser=p_sperre_bearb('I',$boolFV,false,$numFachBearb);    // prüfen, ob Sperre durch andere vorliegt.

  // Parameter einlesen:
  $strPlanPar=base64_decode(ut_get_webpar('splanpar'));    // diese werden nur 1:1 an das Plan-Darstellungsskript weitergereicht.
  $numStufeID=ut_get_webpar_n('nstufe');
  $numKursartID=ut_get_webpar_n('nkurs');
  $numZugID=ut_get_webpar_n('nzug');
  $strDelSessionCtl=ut_get_webpar('sctl');   // Kontroll-Code, um zu prüfen, ob der Session-Inhalt zu dem Aufruf passt.
  $arrDelInfo=(empty($_SESSION['p_fv_copy_info'])) ? array() : $_SESSION['p_fv_copy_info']; // Weitere Angaben aus der Session (Copy-Infos) holen!
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Löschen einer gesamten Unterichtsvorhaben-Zeile";

  // -------------------------------------------------------------
  // Fehlerprüfungen (und Parameter einlesen):
  // -------------------------------------------------------------

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


  if (($numFehler == 0) and ((empty($arrDelInfo['ctl'])) or ($arrDelInfo['ctl'] != $strDelSessionCtl)))
  {
     $numFehler=1;
     $strFehlercode='F0117';   // Angaben zum Löschen konnten nicht ermittelt werden. Bitte laden Sie den Plan erneut und starten dann die Löschfunktion!
  } // IF: Kontrollcode in Ordnung?


  if ($numFehler == 0)
  {
     p_sperre_bearb('S',true,true,$numFachBearb);    // Sperre einrichten, sonst Fehlermeldungsseite (sollte hier nicht passieren, da vorher Sperre geprüft wird.
     $_SESSION['p_fach_id_bearb']=$numFachBearb;     // Sicherheitshalber nochmal zuweisen.
  }   

  // Ende Fehlerprüfungen:
  // -------------------------------------------------------------

  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf_popup.inc.php");  // HTML-Seite aufbauen mit PopUpHeader.
  // -------------------------------------------------------------
  

  if ($numFehler == 0)
  {
     // Angaben aus der Session:
     $arrKataloge=$arrDelInfo['kataloge'];
     $strPlanPar=base64_encode($arrDelInfo['aufruf_url']);
     echo "<h2>Aktuelle Zeile mit Unterrichtsvorhaben unwiderruflich löschen?</h2>\n";
     echo "<p>Achtung, diese Aktion können Sie auch nicht mit 'Alle Änderungen dieser Sitzung rückgängig machen' widerrufen!</p>\n";
     echo "<h3>Aktuelle Kombination: ";
     echo $arrKataloge['fach'][$numFachBearb]['fach'] . ' ';
     echo $arrKataloge['stufe'][$numStufeID]['stufe'] . ' ';
     echo (empty($numKursartID)) ? '' : ($arrKataloge['kursart'][$numKursartID]['kursart'] . ' ');
     echo (empty($numZugID)) ? '' : $arrKataloge['zug'][$numZugID]['zug'];
     echo "</h3>\n";
     echo "<div>\n";  // Bearbeitungsbereich
     echo "<br /><br />\n";
    
    echo "<ul>\n";
    echo "<li><a href='p_fv_plan_del.php?nstufe=$numStufeID&nkurs=$numKursartID&nzug=$numZugID&splanpar='>JA, unwiderruflich löschen!</li>\n";
    echo "<br />\n";
    echo "<li><a href='' onclick='window.close();'>NEIN, nicht löschen!</li>\n";
    echo "</ul>\n";
      
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
  //include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  echo "   </div> <!-- pcontainer --> \n";
  echo "  </div> <!-- pinhalt --> \n";
  echo " </body>\n";
  echo "</html>\n";
  
  // -----------------------------------------------------
  // Ende PHP.
?>