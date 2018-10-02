<?php
  // p_fv_plan_einblend.php
  // 
  // Fachverwalter: PopUp-Fenster zum Einblenden ausgeblendeter Zeilen.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // lr: fh, 22-OCT-2013.
  // lr: fh, 10-NOV-2013, kleine Optimierung.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="10.11.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();                 // Session-ID und Variablen zuordnen.

  // Parameter einlesen:
  // keine
  $arrInfo=(empty($_SESSION['p_fv_copy_info'])) ? array() : $_SESSION['p_fv_copy_info']; // Weitere Angaben aus der Session (Copy-Infos) holen!
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Einblenden von ausgeblendeten Unterichtsvorhaben-Zeilen";

  // -------------------------------------------------------------
  // Fehlerprüfungen (und Parameter einlesen):
  // -------------------------------------------------------------

  if (($numFehler == 0) and ((!isset($_SESSION['p_plan_uv_ausblend'])) or (count($_SESSION['p_plan_uv_ausblend']) == 0)))
  {
     $numFehler=1;
     $strFehlercode='F0120';   // Keine Unterrichtsvorhaben vorhanden, die eingeblendet werden könnten
  } // IF: Einblendbare UV?  
  // Ende Fehlerprüfungen:
  // -------------------------------------------------------------

  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf_popup.inc.php");  // HTML-Seite aufbauen mit PopUpHeader.
  // -------------------------------------------------------------
  

  if ($numFehler == 0)
  {
     echo "<h2>$strGTitel</h2>\n";
     echo "<p>Bitte wählen Sie durch Anklicken die Zeile aus, die Sie einblenden möchten!</p>\n";
     // Angaben aus der Session:
     $arrKataloge=$arrInfo['kataloge'];
     
     echo "<table>\n";
     echo "<tr><th>Fach</th><th>Jahrgangsstufe</th><th>Kursart</th><th>Zug</th><th>Einblenden?</th></tr>\n";
     $arrAusblend=$_SESSION['p_plan_uv_ausblend'];
     foreach ($arrAusblend as $numABId => $arrABKeys)
     {
       // Aufbau des Arrays:      $arrAusblend[]=array($numFachID,$numStufeID,$numKursartID,$numZugID);
       echo "<tr>\n";
       $strFach=(empty($arrKataloge['fach'][$arrABKeys[0]]['fach'])) ? " kein Fach angegeben " : $arrKataloge['fach'][$arrABKeys[0]]['fach'];
       echo "<td>" . $strFach . "</td>";
       echo "<td class='zentriert'>" . $arrKataloge['stufe'][$arrABKeys[1]]['stufe'] . "</td>";
       echo "<td>" . $arrKataloge['kursart'][$arrABKeys[2]]['kursart'] . "</td>";
       echo "<td>" . $arrKataloge['zug'][$arrABKeys[3]]['zug'] . "</td>";
       echo "<td><a class='pbutton' href='p_fv_plan_einblend_z.php?nabid=$numABId'>Einblenden</a></td>";
       echo "</tr>\n";
     }
     echo "</table>\n";
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------


  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    p_fehler_ausgabe($strFehlercode);
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------


  echo "<form>\n";
  echo "<input name='abort' type='button' value=' Schließen ' onclick='window.close();' />\n";
  echo "</form>\n";

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