<?php
  // p_fv_plan_ausblend.php
  // 
  // Fachverwalter/normaler Anwender: PopUp-Fenster zum Ausblenden einer ganzen Zeile, Fenster schließt sich selbst.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // lr: fh, 22-OCT-2012.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="22.10.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();                 // Session-ID und Variablen zuordnen.

  // Parameter einlesen:
  $strPlanPar=base64_decode(ut_get_webpar('splanpar'));    // diese werden nur 1:1 an das Plan-Darstellungsskript weitergereicht.
  $numFachID=ut_get_webpar_n('nfach');
  $numStufeID=ut_get_webpar_n('nstufe');
  $numKursartID=ut_get_webpar_n('nkurs');
  $numZugID=ut_get_webpar_n('nzug');
  $strSessionCtl=ut_get_webpar('sctl');   // Kontroll-Code, um zu prüfen, ob der Session-Inhalt zu dem Aufruf passt.
  $arrInfo=(empty($_SESSION['p_fv_copy_info'])) ? array() : $_SESSION['p_fv_copy_info']; // Weitere Angaben aus der Session (Copy-Infos) holen!
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Ausblenden einer gesamten Unterichtsvorhaben-Zeile";

  // -------------------------------------------------------------
  // Fehlerprüfungen (und Parameter einlesen):
  // -------------------------------------------------------------

  if (($numFehler == 0) and ($numFachID == ''))
  {
     $numFehler=1;
     $strFehlercode='F0110';   // Fach oder Stufe konnte nicht festgestellt werden!
  } // IF: Fach angegeben?   


  if (($numFehler == 0) and ((empty($arrInfo['ctl'])) or ($arrInfo['ctl'] != $strSessionCtl)))
  {
     $numFehler=1;
     $strFehlercode='F0119';   // Stufe / Kursart / Zug konnte nicht festgestellt werden!
  } // IF: Kontrollcode in Ordnung?
  // Ende Fehlerprüfungen:
  // -------------------------------------------------------------


  if ($numFehler == 0)
  {
     // Angaben aus der Session:
     $arrAusblend=(isset($_SESSION['p_plan_uv_ausblend'])) ? $_SESSION['p_plan_uv_ausblend'] : array();
     
     // $arrAusblend[]=array('fach'=>$numFachID,'stufe'=>$numStufeID,'kursart'=>$numKursartID,'zug'=>$numZugID);
     $arrAusblend[]=array($numFachID,$numStufeID,$numKursartID,$numZugID);
     
     $_SESSION['p_plan_uv_ausblend']=$arrAusblend;  // Ausgeblendete UV wieder in Session ablegen.
     
     if (!$boolDEBUG)
     {
        // JS-Code zum Aktualisieren der Plan-Seite:
        echo "<script type='text/javascript'> \n";
        echo "opener.location.reload(true);\n";
        echo "window.close();\n"; // Sich selbst schließen
        echo "</script>\n";
     } // IF: Debug-Modus?  
     
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------


  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    p_fehler_seite($strFehlercode);
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------

  // -----------------------------------------------------
  // Ende PHP.
?>