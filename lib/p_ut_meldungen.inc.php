<?php
  // p_ut_meldungen.inc.php
  // Alle Funktionen zur Ausgabe von Fehler-, Warn- und Hinweismeldungen.
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  // Alle speziellen Funktionen des Projekts sollten mit
  //   p_ beginnen, um sie gleich zu finden.
  //
  // Funktionen:
  //
  //    p_fehler_text($strFehlercode,$strFehlerPar1="",$strFehlerPar2="")
  //    p_fehler_ausgabe($strFehlercode,$strFehlerPar1="",$strFehlerPar2="")
  //    p_fehler_seite($strFehlercode,$strFehlerPar1="",$strFehlerPar2="")
  //
  //
  // fh, 15-DEC-2011.
  // lr: fh, 13-APR-2012, p_fehler_seite.
  // lr: fh, 22-OCT-2013, p_fehler_seite ergänzt.
  // -------------------------------------------------------------

// -------------------------------------------
// p_ut_meldungen
// -------------------------------------------

// Einbinden der Nummern-Text-Umsetzungen:
require_once($strGIncPath . "p_ut_meldungen_texte.inc.php");


// ---------------------------------------------------

function p_fehler_text($strFehlercode,$strFehlerPar1="",$strFehlerPar2="")
{
  // Gibt Fehlertext zurück, bei dem der Code ausgewertet wird und Parameter ggf. ersetzt werden.
  //
  // Parameter:
  //    $strFehlercode      - Code für den Text der Fehlermeldung.
  //    $strFehlerPar1      - Ersetzungsparameter für Platzhalter %1 (optional).
  //    $strFehlerPar2      - Ersetzungsparameter für Platzhalter %2 (optional).
  //
  // fh, 15-DEC-2011.

  global $strGTitel;
  global $strGImgPath;  
  global $strGCSSPath;
  global $strGJSPath;
  global $strGIncPath;
  global $arrGMeldText;   // Globales Array mit Fehlertexten zu den Fehlercodes.

  $strFehlertext='';
  
  if (isset($arrGMeldText[$strFehlercode]))
  {
    $strFehlertext=$arrGMeldText[$strFehlercode];
    // Platzhalter ersetzen:
    $strFehlertext=str_replace("%1",$strFehlerPar1,$strFehlertext);
    $strFehlertext=str_replace("%2",$strFehlerPar2,$strFehlertext);
  }
  else
  {
    $strFehlertext="Undefinierter Fehler! (Code $strFehlercode)\n";
  }  // IF: Konnte Code zugeordnet werden?

  return ($strFehlertext);        // Fehlertext zurückgeben.
} // Ende p_fehler_text.

// ---------------------------------------------------

function p_fehler_ausgabe($strFehlercode,$strFehlerPar1="",$strFehlerPar2="")
{
  // Gibt Fehlermeldung gemäß übergebenen Code aus.
  // Dazu wird aber keine spezielle Seite aufgebaut.
  //
  // Parameter:
  //    $strFehlercode      - Code für den Text der Fehlermeldung.
  //    $strFehlerPar1      - Ersetzungsparameter für Platzhalter %1 (optional).
  //    $strFehlerPar2      - Ersetzungsparameter für Platzhalter %2 (optional).
  //
  // fh, 15-DEC-2011.

  $strFehlertext=p_fehler_text($strFehlercode,$strFehlerPar1,$strFehlerPar2);

  if ($strFehlertext != '')
  {
    echo " <br /><p class='error'><strong>Fehler!</strong><br />\n";
    echo " $strFehlertext\n</p><br />\n";
    echo " <br />\n";
  } // IF: Fehlertext vorhanden?  

} // Ende p_fehler_ausgabe.

// ---------------------------------------------------

function p_fehler_seite($strFehlercode,$strFehlerPar1="",$strFehlerPar2="")
{
  // Gibt Fehlermeldung gemäß übergebenen Code aus.
  // Dazu wird die Seite komplett aufgebaut.
  //
  // Parameter:
  //    $strFehlercode      - Code für den Text der Fehlermeldung.
  //    $strFehlerPar1      - Ersetzungsparameter für Platzhalter %1 (optional).
  //    $strFehlerPar2      - Ersetzungsparameter für Platzhalter %2 (optional).
  //
  // fh, 13-APR-2012.
  // lr: fh, 14-APR-2012, Ergänzung.
  // lr: fh, 22-OCT-2013, globale Variablen ergänzt.

  global $strGIncPath;
  global $strGStatus;
  global $strGTitel;
  global $strGCSSPath;
  global $strGJSPath;
  global $strGImgPath;
  global $strGtabKatSchulform;
  global $boolDEBUG;
  
  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.

  // Fehler ausgeben:
  p_fehler_ausgabe($strFehlercode,$strFehlerPar1,$strFehlerPar2);

  echo "<p><br /><a href='javascript:history.back();'>zurück ...</a><br /></p>\n";

  // -----------------------------------------------------
  // Abschluss der Seite:
  include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  // -----------------------------------------------------

} // Ende p_fehler_seite.

// ---------------------------------------------------


// ---------------------------------------------------
// Ende p_ut_meldungen.inc.php
// ---------------------------------------------------

