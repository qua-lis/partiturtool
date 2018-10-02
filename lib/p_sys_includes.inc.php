<?php
  // p_sys_includes.inc.php
  // Lädt alle notwendigen Include-Dateien am Anfang aller Skripte.
  //
  // Änderungen bei der Einbindung müssen dann nur hier erfolgen.
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
  // -------------------------------------------------------------


  $strGIncPath="lib/";      // Pfad zu den Include-Dateien.

  // Instanz-abghängige Konfiguration:
  // --------------------------------------------------------------------------------
  require($strGIncPath . 'p_sys_konfig_instanz.inc.php');            //  Instanz-abhängige Konfigurations-Variablen initialisieren.

  // Versionsinformationen:
  // --------------------------------------------------------------------------------
  require($strGIncPath . 'p_sys_version.inc.php');                   //  Aktuelle Versionsnummer.

  // --------------------------------------------------------------------------------
  // Weitere Variablen aus Zusatz-Konfigurationsdatei (allgemeine Konfiguration):
  require_once($strGIncPath . 'p_sys_konfig_allg.inc.php');           // Tabellen-Bezeichner etc. 

  // --------------------------------------------------------------------------------
  require_once($strGIncPath . 'p_sys_db_util.inc.php');             //  Datenbank-Ansteuerung.

  // --------------------------------------------------------------------------------
  require_once($strGIncPath . 'p_sys_util.inc.php');                 //  Weitere Applikations-abhängige Funktionen.

