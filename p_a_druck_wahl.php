<?php
  // p_a_druck_wahl.php
  // 
  // PopUp-Fenster zur Auswahl der Druck-Optionen
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
  // lr: fh, 04-NOV-2013, Anzahl Zeilen pro UV
  // lr: fh, 06-NOV-2013, weitere Ergänzung.
  // lr: fh, 09-NOV-2013, weitere Ergänzung.
  // lr: fh, 10-NOV-2013, Parameter: nnorel
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="10.11.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();                 // Session-ID und Variablen zuordnen.

  // Parameter einlesen:
  $numNoReload=ut_get_webpar_n('nnorel');   // Wenn 1, erfolgt kein Reload des Plans (im Präsentationsmodus wird der Plan nicht geändert)
                                            //         und beim Ausblenden von Zeilen wird derPlan automatisch neu geladen.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Drucken des Plans";

  // -------------------------------------------------------------
  // Fehlerprüfungen:
  // -------------------------------------------------------------
  // Keine bisher
  // Ende Fehlerprüfungen:
  // -------------------------------------------------------------

  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf_popup.inc.php");  // HTML-Seite aufbauen mit PopUpHeader.
  // -------------------------------------------------------------
  

  if ($numFehler == 0)
  {

     // Sicherheitshalber Originalplan neu laden (damit Session-Infos aktuell sind):
     if ($numNoReload != 1)
     {
       echo "<script type='text/javascript'> \n";
       echo "opener.location.reload(true);\n";
       echo "</script>\n";
     } // IF: Kein Reload des Plans?  

     // Angaben aus der Session:
     echo "<h2>Sie können den aktuellen Plan als PDF zum Abspeichern und Ausdrucken erzeugen</h2>\n";

     echo "<p>Bitte wählen Sie die entsprechenden Druck-Optionen:<br />\n</p>\n";

     echo "<form name='frm_plan_druck' action='p_a_druck.php' method='POST'>\n";
     echo "<fieldset id='prahmen' acceskey='F'>\n";

     $arrSel=array();
     $arrSel['ngroesse']=array('label'=>'Größe','werte'=>array(1=>'DIN A4',2=>'DIN A3',3=>'DIN A2',4=>'DIN A1'));
     $arrSel['sformat']=array('label'=>'Format','werte'=>array('L'=>'Querformat','P'=>'Hochformat'));
     $arrSel['nbteile']=array('label'=>'Breite: Aufteilung auf Seiten',
                              'werte'=>array(1=>'1 Seite',2=>'2 Seiten',3=>'3 Seiten',4=>'4 Seiten',
                                             5=>'5 Seiten',6=>'6 Seiten',7=>'7 Seiten',8=>'8 Seiten',));
     $arrSel['numfang']=array('label'=>'Ausgabeumfang',
                              'werte'=>array(1=>'Nur Titel',2=>'vollständig wie in Plan-Ansicht',3=>'alle Inhaltsfelder'));


     foreach ($arrSel as $strSelId => $arrSelInfo)
     {
       echo "<label for='$strSelId'>" . $arrSelInfo['label'] . "</label> ";
       echo "<select name='$strSelId' id='$strSelId' />";
       foreach ($arrSelInfo['werte'] as $strId => $strWert)
       {
         // Vorherige Wahl aus der Session holen:
         $strSelected = ((!empty($_SESSION['pdruck'][$strSelId])) and ($_SESSION['pdruck'][$strSelId]==$strId)) ? " selected='selected' " : '';
         echo "<option value='$strId' $strSelected>$strWert</option>\n";
       }
      echo "</select>\n";
      echo "<br /><br />\n";
    } // FOR-Schleife durch die Select-Felder  

    echo "<label for='nanzzeil'>Anzahl Zeilen pro UV:</label> ";
    $numAnzZeil=(!empty($_SESSION['pdruck']['nanzzeil']))  ? $_SESSION['pdruck']['nanzzeil'] : '';
    echo "<input type='text' name='nanzzeil' id='nanzzeil' size='5' value='$numAnzZeil' />\n";

    // Formular schließen:
    // ---------------------------------------
    echo "</fieldset>\n";
    echo "<br /><br />\n";
    echo "<input type='submit' value='PDF-Erzeugung starten' />\n";
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
