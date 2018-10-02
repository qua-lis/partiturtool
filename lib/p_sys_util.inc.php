<?php
  // p_sys_util.inc.php
  // Util-Funktionen für das Projekt.
  // Bindet diverse weitere Bibliotheken ein.
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  // Alle speziellen Funktionen des Projekts sollten mit
  //   p_ beginnen, um sie gleich zu finden.
  //
  // Funktionen:
  //
  //  * Spezielle p (Partituren)
  //  * Allgemeine ut (UTil)
  //
  //
  // fh, 15-DEC-2011.
  // -------------------------------------------------------------


// ---------------------------------------------------
// Einbindung der Bibliotheken:
// ---------------------------------------------------
global $strIncPath;

require_once($strIncPath . "p_ut_meldungen.inc.php");          //  Alle Funktionen zur Ausgabe von Fehler-, Warn- und Hinweismeldungen.
require_once($strIncPath . "p_ut_allgemein.inc.php");          //  Allgemeine Util-Funktionen (Einlesen und prüfen von Parametern, Kennwort-Erzeugung, EMail...).

// ---------------------------------------------------


// ---------------------------------------------------
// Ende p_sys_util.inc.php
// ---------------------------------------------------

?>
