<?php
  // p_adm_user_edit.php
  // 
  // ADMIN
  // Nutzer/innen bearbeiten / neu einrichten.
  //
  // Parameter:
  //      nuserid     ID des Users
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 29-MAR-2012.
  // lr: fh, 19-AUG-2013, für Typ F Fachauswahl angeben.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_adm();         // Prüfung, ob als Admin angemeldet.

  // Parameter einlesen:
  $numUserID=ut_get_webpar_n('nuserid');      // ID des zu bearbeitenden Users, 0 wenn neuer User.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Nutzer/in und Nutzer bearbeiten";


  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  $strGHeaderInclude="p_gui_adm_user_edit.inc.php";       // Zusätzliche Include-Datei mit jQuery-Elementen.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if (($numFehler == 0) and ($numUserID != 0))
  {
    $numExist=db_get_value("COUNT(*)",$strGtabSysUser,"user_id=$numUserID",$boolDEBUG);
    if ($numExist == 0)
    {
      $numFehler = 1;
      $strFehlercode='A0112'; // Sie haben keine gültige Nutzer-Kennung ausgewählt!
    }
  } // IF:Fehler?  

  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    $arrDaten=array();
    if ($numUserID == 0)
    {
      echo "<h2>Neue Nutzer/innen-Kennung anlegen</h2>\n";
    }
    else
    {
      echo "<h2>Nutzer/innen-Kennung bearbeiten</h2>\n";
      $strSQL="SELECT * 
                 FROM $strGtabSysUser
                WHERE user_id=$numUserID";
      $stmtSQL = db_exec($strSQL,$boolDEBUG); 
      if (db_fetch_arr($stmtSQL,$arrSQL))
      {
        $arrDaten=$arrSQL;
      } // DB-Abfrage der Nutzerdaten.
    } // IF: Neuer Datensatz?    
    
    // Eingabe-Formular aufbauen:
    // --------------------------
    echo "<form name='frm_p_user_edit' id='frm_p_user_edit' method='post' action='p_adm_user_edit_s.php'>\n";

    echo "<div class='pschmal'>\n";
    echo "<label for='user_id'>User_ID (automatisch)</label>\n";
    echo "<input type='text' size='10' name='user_id' id='user_id' value='$numUserID' readonly='readonly' /><br />\n";
    $strAnmeldename=(empty($arrDaten['anmeldename'])) ? '' : $arrDaten['anmeldename'];
    echo "<label for='anmeldename'>Anmeldename</label>\n";
    echo "<input type='text' size='30' name='anmeldename' id='anmeldename' value='$strAnmeldename' maxlength='100' /><br />\n";
    $strVollname=(empty($arrDaten['vollname'])) ? '' : $arrDaten['vollname'];
    echo "<label for='vollname'>Vor- und Zuname</label>\n";
    echo "<input type='text' size='50' name='vollname' id='vollname' value='$strVollname' maxlength='150'/><br />\n";
    
    $strATyp=(empty($arrDaten['anmeldetyp'])) ? '' : $arrDaten['anmeldetyp'];
    echo "<label for='anmeldetyp'>Kennungstyp</label>\n";
    echo "<select name='anmeldetyp' id='anmeldetyp' >\n";
    foreach ($arrGLoginTypen as $strTyp => $strTypName)
    {
      $strSelected=($strTyp == $strATyp) ? " selected='selected' " : '';
      if (($strTyp!='A') or ($strSelected!='') or (!isset($boolGAdminAnlegen)) or ($boolGAdminAnlegen))
      {
        echo "<option value='$strTyp' $strSelected>$strTypName</option>\n";
      } // IF: Admins nur anlegen, wenn $boolGAdminAnlegen, bestehende Admins dürfen aber bleiben ...
    }
    echo "</select><br />\n";

    // Bereich wird per jQuery aus-/eingeblendet, je nachdem, ob anmeldetyp = F:
    echo "<div id='div_fach_id'>\n";
    $numFachId=(empty($arrDaten['fach_id'])) ? '' : $arrDaten['fach_id'];
    
    // Falls anmeldetyp = F, Hinweis ausgeben, wenn noch kein Fach eingetragen wurde:
    if (($strATyp == 'F') and ($numFachId == ''))
    {
      echo "<div class='pfarbighervorgehoben'>Bitte ordnen Sie für Fachverwalter/innen ein Fach zu, das bearbeitet werden darf!</div>\n";
    } // IF: Kein Fach ausgewählt?
    
    echo "<label for='fach_id'>Fach</label>\n";
    $strFachSelect=p_frm_selectliste(array('fach_id','fach',$strGtabKatFach),'S',$numFachId,'fach_id',true);
    echo $strFachSelect;
    echo "<br />\n";
    echo "</div>\n";  // Ende div_fach_id
    
    

    $strKennwort=(empty($arrDaten['kennwort_crypt'])) ? '' : $arrDaten['kennwort_crypt'];
    echo "<label for='kennwort1'>Kennwort</label>\n";
    echo "<input type='password' size='50' name='kennwort1' id='kennwort1' value='$strKennwort' maxlength='100'/><br />\n";
    echo "<label for='kennwort2'>Kennwort-Wiederholung</label>\n";
    echo "<input type='password' size='50' name='kennwort2' id='kennwort2' value='$strKennwort' maxlength='100'/><br />\n";

    echo "</div>\n";
    
    echo "</tbody>\n";
    echo "</table>\n";
    echo "<br /> &nbsp; <br />\n";

    echo " <input class='pbutton' type='submit' id='psubmit' value='Speichern'  /> \n";
    echo " <br /> \n";
    // Formular schließen.
    echo "</form> \n";
    
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------

  echo "<ul>\n";
  echo " <li><a href='p_adm_user_list.php'>zurück zur Liste der Nutzer/innen</a></li> \n";
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
