<?php
  // p_a_login.php
  // 
  // Anmeldung am System (als Fachverwalter/in bzw. als Admin)
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 15-DEC-2011.
  // lr: fh, 11-JAN-2012.
  // lr: fh, 30-SEP-2013, Anmeldung als Lehrkraft.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="30.09.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  // p_session_start();    // Session-ID und Variablen zuordnen.

  // Parameter einlesen:
  $numLoginTyp=ut_get_webpar_n_def("nltyp",1);  // Anmelde-Typ 1 - Fachverwalter/in, 2 - Admin, 3 - Lehrkraft
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $numLoginTyp=(empty($arrGLoginTypCodes[$numLoginTyp])) ? 3 : $numLoginTyp; // Nur gültige zulassen.
  $strLoginTyp=$arrGLoginTypen[$arrGLoginTypCodes[$numLoginTyp]];
  $strGTitel=$strGAppTitel . " -  Anmeldung als $strLoginTyp";

  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  // $strGMenue=ls_menu(8); // kein Menü´.
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen:
  //    bisher noch keine
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    echo "<p>Tragen Sie hier bitte Ihren Anmeldenamen und das zugehörige Kennwort ein,
             um sich an der Anwendung anzumelden:</p>\n";
           
    // Login-Formular aufbauen:
    echo "<form name='frm_p_login' id='frm_p_login' method='post' action='p_a_login_chk.php'>\n";
    echo "<div class='pschmal'>\n";

    echo " <label for='susername'>Anmeldename: </label>\n";
    echo " <input class='pinput' type='text' name='susername'  id='susername' tabindex='1' />\n";
    echo " <br />\n";

    echo " <label for='skennwort'>Kennwort: </label>\n";
    echo " <input class='pinput' type='password' name='skennwort' id='skennwort' tabindex='2' />\n";
    echo " <input type='hidden' name='nltyp' id='nltyp' value='$numLoginTyp' />\n";
    echo " <br /><br />\n";

    echo " <input class='pbutton' type='submit' id='psubmit' value='Anmelden'  tabindex='3' /> \n";
    echo " <br /> \n";
    echo "</div>\n"; // pschmal
    // Formular schließen.
    echo "</form> \n";
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
  include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  // -----------------------------------------------------
  // Ende PHP.
?>
