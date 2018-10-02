<?php
  // p_conf_download.php
  // 
  // Herunterladen der Konfigurationsdatei p_sys_konfig_instanz.inc.php, die
  // von Setup-Routine, um die Parameter der  erzuegt wurde.
  //
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 25-NOV-2013.
  // lr: fh, 26-NOV-2013, Erweiterung.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="26.11.2013";
  
  // PHP-Kopf, include-Dateien:
  require_once ("../lib/p_ut_allgemein.inc.php");  // Allgemeine Funktionen.
  require_once ("p_conf_util.inc.php");            // Hilfsfunktionen

  $strKonfInhalt=ut_get_webpar('sconf');
  $numDateiArt=ut_get_webpar_n('nart');           // 1 - Konfig-Datei, 2 - SQL-Skript.
  
  $strKonfigDatei='p_sys_konfig_instanz.inc.php';
  $strSQLDatei='create_partitur_db.sql';
  
  if (!empty($strKonfInhalt))
  {
    switch ($numDateiArt)
    {
      case 1:
        // Konfig-Datei:
        p_conf_file_header('.php',$strKonfigDatei);
        echo htmlspecialchars_decode($strKonfInhalt,ENT_QUOTES); // ,ENT_COMPAT);
        break;
      case 2:
        // SQL-Skript:
        p_conf_file_header('.sql',$strSQLDatei);
        echo htmlspecialchars_decode($strKonfInhalt,ENT_QUOTES); // ,ENT_COMPAT);
        break;
    } // Ende Fallunterscheidung    
  } // IF: Wurde Inhalt übergeben?
?>  
