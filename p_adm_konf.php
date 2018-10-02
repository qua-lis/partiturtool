<?php
  // p_adm_konf.php
  // 
  // ADMIN
  // Bearbeitung von Konfigurationstabellen.
  //
  // Parameter:
  //      skonf     Kürzel für die zu bearbeitende Konfiguration.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 27-MAR-2012.
  // lr: fh, 29-MAR-2012, Katalog-Infos aus p_sys_konfig_allg.inc.php.
  // lr: fh, 12-APR-2012, Auswahllisten berücksichtigen, Sperre.
  // lr: fh, 03-OCT-2012, Lösch-Links.
  // lr: fh, 19-AUG-2013, keine Sperre mehr für Admins.
  // lr: fh, 22-OCT-2013, Colorpicker.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="22.10.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_adm();        // Prüfung, ob als Admin angemeldet.
  // p_sperre_bearb('S',true,true);    // Sperre einrichten, sonst Fehlermeldungsseite

  // Parameter einlesen:
  $strKonfK=ut_get_webpar('skonf');   // Kürzel für die zu bearbeitende Konfiguration.
                                      // Konfigurationsbereiche werden aus $arrGKatalogKonf entnommen (siehe p_sys_konfig_allg.inc.php).
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Konfiguration";
  $numLeerZ=4;                                // Leerzeilen für neue Einträge.


  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------
  $strGHeaderInclude="p_gui_adm_konf.inc.php";   // Zusätzliche Include-Datei mit jQuery-Elementen.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if (($numFehler == 0) and (($strKonfK == '') or (!isset($arrGKatalogKonf[$strKonfK]))))
  {
    $numFehler = 1;
    $strFehlercode='A0110'; // Kein gültiger Konfigurationsbereich ausgewählt!
  }
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    
    // -------------------------------------------------------
    $arrKonfData=$arrGKatalogData[$strKonfK]; // Variablen nach Art des Katalogs, Belegung siehe Konfigurationsskript.
    // -------------------------------------------------------
    $strIDAtt=$arrKonfData['idatt'];
    $arrAtts=$arrKonfData['atts'];
    $strAttList=$strIDAtt . ',' . implode(',',array_keys($arrAtts));               
    
    $arrDaten=array();
    $numAnzZ=0;
    $strSQL="SELECT DISTINCT $strAttList
               FROM " . $arrKonfData['tab'] . " " .
               $arrKonfData['orderby'];
    $stmtSQL = db_exec($strSQL,$boolDEBUG); 
    while (db_fetch_arr($stmtSQL,$arrSQL))
    {
      $numAnzZ++;
      $arrDaten[$numAnzZ]=$arrSQL;
    } // DB-Schleife durch die Konfigurationseinträge.
    
    $numAnzZ += $numLeerZ;    // Gesamtzahl der Datenzeilen inkl. Leerzeilen.

    // Eingabe-Formular aufbauen:
    // --------------------------
    echo "<form name='frm_p_konf' id='frm_p_konf' method='post' action='p_adm_konf_s.php'>\n";
    
    // Eingabetabelle aufbauen:
    echo "<table>";
    echo "<thead>\n";
    echo "<tr><th>ID</th>";
    foreach ($arrAtts as $strAtt => $strLabel)
    {
      echo "<th>$strLabel</th>";
    }
    echo "<th>Löschen?</th>";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    for ($numZ = 1;$numZ <= $numAnzZ;$numZ++)
    {
      $strTagPfx='s_' . $numZ . '_';
      echo "<tr><td>";
      $strTag=$strTagPfx . $strIDAtt;
      if (isset($arrDaten[$numZ]))
      {
        $numID=$arrDaten[$numZ][$strIDAtt];
        $strTag=$strTagPfx . $strIDAtt;
        echo "<input type='text' value='$numID' id='$strTag' name='$strTag' readonly='readonly' />\n";
      }
      else
      {
        $numID='';
        echo "(neu)";
        echo "<input type='hidden' value='' id='$strTag' name='$strTag'/>\n"; // Wichtig: Wert muss leer sein, nicht 0(!), da 0 vorkommen kann als ID!
      }
      echo "</td>";
      foreach ($arrAtts as $strAtt => $strLabel)
      {
        $strTag=$strTagPfx . $strAtt;
        $strWert=(isset($arrDaten[$numZ][$strAtt])) ? $arrDaten[$numZ][$strAtt] : '';
        // $strDesign=(($strAtt=='fach_farbe') and ($strWert != '')) ? " class='pcolorpicker' style='background:$strWert;' " : '';  // Bei Farb-Angaben, diese darstellen.
        $strDesign=($strAtt=='fach_farbe') ? " class='pcolorpicker' style='background:$strWert;' " : '';  // Bei Farb-Angaben, diese darstellen.
        echo "<td $strDesign>";
        if ((isset($arrKonfData['chkatts'])) and (in_array($strAtt,$arrKonfData['chkatts'])))
        {
          $strChecked=($strWert == 1) ? " checked='checked' " : '';
          echo "<input type='checkbox' value='1' id='$strTag' name='$strTag' $strChecked />\n";  // Checkbox
        }
        elseif ((isset($arrKonfData['sel'][$strAtt])) and (count($arrKonfData['sel'][$strAtt]) > 0))
        {
          // Select-Liste:
          echo "<select id='$strTag' name='$strTag' />\n";
          echo "<option value=''></option>\n";
          foreach ($arrKonfData['sel'][$strAtt] as $strSelOpt)
          {
            $strSelected=($strSelOpt == $strWert) ? " selected='selected' " : "";
            $strOptDesign=(($strAtt=='fach_farbe') and ($strSelOpt != '')) ? " style='background:$strSelOpt;' " : '';  // Bei Farb-Angaben, diese darstellen.
            echo "<option $strOptDesign value='$strSelOpt' $strSelected>$strSelOpt</option>\n";
          }// FOR-Schleife durch alle Sel-Optionen.  
          echo "</select>\n";
        } // IF: Als Checkbox darstellen?  
        else
        {
          echo "<input type='text' value='$strWert' id='$strTag' name='$strTag' />\n";
        } // IF: Als Checkbox darstellen?  
        echo "</td>";
      } // FOR-Schleife durch alle Attribute.
      
      // CID:fh121003:Lösch-Link:
      echo "<td>";
      if (($numID != '') and ($numID != 0))
      {
        // Schlüsselwert vorhanden (auch Einträge mit ID 0 sollen nicht gelöscht werden, da reserviert):
        $strDelPar="&skonf=$strKonfK&nid=" . urlencode($numID);
        echo "<a href='p_adm_konf_del.php?nconfirm=0" . $strDelPar ."'>Löschen?</a>";
      } // IF: Schlüsselwert?  
      echo "</td>";
      
      echo "</tr>\n";
    } // FOR-Schleife durch alle Datensätze.
    
    echo "</tbody>\n";
    echo "</table>\n";

    // Form-Abschluss:
    // --------------
    echo "<br class='pclear' />\n";
    echo " <input type='hidden' value='$numAnzZ' id='nanz' name='nanz'/>\n"; 
    echo " <input type='hidden' value='$strKonfK' id='skonf' name='skonf'/>\n"; 
    echo " <input type='hidden' value='1' id='nvollst' name='nvollst'/>\n";  // Flag, dass Seite vollständig geladen wurde.
    echo " <input class='pbutton' type='submit' id='psubmit' value='Speichern'  /> \n";
    echo " <br /> \n";
    // Formular schließen.
    echo "</form> \n";
    
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------

  echo "<ul>\n";
  echo " <li><a href='p_adm_auswahl.php'>zurück zur Auswahlseite</a></li> \n";
  echo "</ul>  \n";
  
  
  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    p_fehler_ausgabe($strFehlercode);
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------


  // -----------------------------------------------------
  // Abschluss der Seite:
  include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  // -----------------------------------------------------
  // Ende PHP.
?>
