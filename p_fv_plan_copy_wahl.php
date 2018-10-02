<?php
  // p_fv_plan_copy_wahl.php
  // 
  // Fachverwalter: PopUp-Fenster zur Auswahl der Zielzeile, wenn gesamte UV-Zeile kopiert werden soll.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // lr, fh, 20-SEP-2012.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="20.09.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();                 // Session-ID und Variablen zuordnen.
  $boolFV=p_check_fv(false);         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearb=(empty($_SESSION['p_fach_id_bearb'])) ? '' : $_SESSION['p_fach_id_bearb'];
  $strSperrUser=p_sperre_bearb('I',$boolFV,false,$numFachBearb);    // prüfen, ob Sperre durch andere vorliegt.

  // Parameter einlesen:
  // $strPlanPar=ut_get_webpar('splanpar');    // diese werden nur 1:1 an das Plan-Darstellungsskript weitergereicht, kommt aus der Session: aufruf_url
  // $numFachID=ut_get_webpar_n('nfach');      // wird derzeit nicht benötigt!
  $numStufeIDOrg=ut_get_webpar_n('nstufe');
  $numKursartIDOrg=ut_get_webpar_n('nkurs');
  $numZugIDOrg=ut_get_webpar_n('nzug');
  $strCopySessionCtl=ut_get_webpar('sctl');   // Kontroll-Code, um zu prüfen, ob der Session-Inhalt zu dem Aufruf passt.
  $arrCopyInfo=(empty($_SESSION['p_fv_copy_info'])) ? array() : $_SESSION['p_fv_copy_info']; // Weitere Angaben aus der Session holen!
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Kopieren einer Unterichtsvorhaben-Zeile";

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


  if (($numFehler == 0) and ((empty($arrCopyInfo['ctl'])) or ($arrCopyInfo['ctl'] != $strCopySessionCtl)))
  {
     $numFehler=1;
     $strFehlercode='F0116';   // Angaben zum Kopieren konnten nicht ermittelt werden. Bitte laden Sie den Plan erneut und starten dann die Kopierfunktion!
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
     $arrKataloge=$arrCopyInfo['kataloge'];
     $strPlanPar=base64_encode($arrCopyInfo['aufruf_url']);
     echo "<h2>Sie können die aktuelle Zeile mit Unterrichtsvorhaben kopieren</h2>\n";
     echo "<h3>Aktuelle Kombination: ";
     echo $arrKataloge['fach'][$numFachBearb]['fach'] . ' ';
     echo $arrKataloge['stufe'][$numStufeIDOrg]['stufe'] . ' ';
     echo (empty($numKursartIDOrg)) ? '' : ($arrKataloge['kursart'][$numKursartIDOrg]['kursart'] . ' ');
     echo (empty($numZugIDOrg)) ? '' : $arrKataloge['zug'][$numZugIDOrg]['zug'];
     echo "</h3>\n";

     echo "<p>Dabei können Sie nur eine Kurs-Kombination auswählen, für die bisher noch keine Unterrichtsvorhaben
              eingegeben wurden!
              <br />\n</p>\n";

    echo "<div>\n";  // Bearbeitungsbereic
    echo "<form name='frm_plan_copy.php' action='p_fv_plan_copy.php' method='POST'>\n";
    echo "<fieldset id='prahmen' acceskey='F'>\n";

    $arrVorauswahl=array();
    // Jahrgangsstufen:
    // ----------------
    $arrAuswahlTabStufe=array('idatt'=>'stufe_id','labelatt'=>'stufe','atts'=>'',
                             'tab'=>$strGtabKatStufe,'orderatts'=>'CAST(stufe AS UNSIGNED)'); // numerische Sortierung
    p_frm_auswahlspalte('Stufen','nstufe','pstufenwahl',$arrAuswahlTabStufe,$arrVorauswahl,'Jahrgang','nstufe_bearb',false,true);

    // Züge/Klassen:
    // ----------------
    // Wenn nur maximal einer vorhanden ist, wird hier keine zur Auswahl gestellt:
    $numAnzZug=db_get_value("COUNT(*)",$strGtabKatZug,'',$boolDEBUG);
    if ($numAnzZug > 1)
    {
       $arrAuswahlTabZug=array('idatt'=>'zug_id','labelatt'=>'zug','atts'=>'','tab'=>$strGtabKatZug,'orderatts'=>'zug'); 
       p_frm_auswahlspalte('Züge/Klassen','nzug','pzugwahl',$arrAuswahlTabZug,$arrVorauswahl,'Zug/Klasse','nzug_bearb',false,true);
    }// IF: Mehr als ein Zug?  

   // Kursarten:
   // ----------------
   // Wenn nur maximal eine vorhanden ist, wird hier keine zur Auswahl gestellt:
   $numAnzKursart=db_get_value("COUNT(*)",$strGtabKatKursart,'',$boolDEBUG);
   if ($numAnzKursart > 1)
   {
      $arrAuswahlTabKurs=array('idatt'=>'kursart_id','labelatt'=>'kursart','atts'=>'kursart_bezeichnung','tab'=>$strGtabKatKursart,'orderatts'=>'kursart'); 
      p_frm_auswahlspalte('Kursarten','nkurs','pkurswahl',$arrAuswahlTabKurs,$arrVorauswahl,'Kursart','nkurs_bearb',false,true);
   }// IF: Mehr als ein Kursart?  

       
    // Formular schließen:
    // ---------------------------------------
    echo "</fieldset>\n";
    echo "<br /><br />\n";
    echo "<input type='hidden' name='splanpar' id='splanpar' value='$strPlanPar' />\n"; // URL weitergeben.
    echo "<input type='hidden' name='nstufeorg' id='nstufeorg' value='$numStufeIDOrg' />\n"; // Quell-Parameter weiterreichen
    echo "<input type='hidden' name='nkursorg' id='nkursorg' value='$numKursartIDOrg' />\n";
    echo "<input type='hidden' name='nzugorg' id='nzugorg' value='$numZugIDOrg' />\n";
    echo "<input type='submit' value='Kopieren' />\n";
    echo "<input name='abort' type='button' value=' Abbrechen ' onclick='window.close();' />\n";
    echo "</form>\n";
    echo "</div>\n";  // Bearbeitungsbereich
    
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