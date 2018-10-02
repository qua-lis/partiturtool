<?php
  // p_sys_konfig_instanz.inc.php
  // Initialisierung der Instanz-abhängigen Konfigurations-Variablen.
  // 
  // Ueber die Variable strKonf wird die zu verwendende Umgebung eingestellt.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 15-DEC-2011.
  // lr: fh, 17-FEB-2012, Testserver ergänzt.
  // lr: fh, 14-SEP-2103, $arrGMeta.
  // -------------------------------------------------------------
  // Zur Kenntlichmachung der globalen Variablen wird ein G verwendet:
  // -------------------------------------------------------------
  

  // Hier wird die zu verwendende Umgebung eingestellt:
  $strKonf = "standard";  // Standard-Konfiguration
  // $strKonf = "sample"; // Beispiel-Konfiguration
  
  // --------------------------------------------------------------------------------
  // Variablen in Abhaengigkeit von $strKonf setzen:
  // --------------------------------------------------------------------------------
  switch ($strKonf)
  {
    case "standard":
      // Standard-Konfiguration
      // --------------------------------------------------------------------------------

      // --------------------------------------------------------------------------------
      // Datenbank-Variablen:
      $strGDBtype="mysql";            // auch "oracle" und andere DBs moeglich, fuer zukuenftige Erweiterungen
      $strGDBSID="";                  // Nur für Oracle relevant.
      $strGDBHost ="##dbhost##";
      $strGDBName="##dbname##";       // Schema bzw. DB-Name in MySQL in etwa dem DBNamen.
      $strGDBUser="##dbuser##";
      $strGDBPass="##dbpass##";
      $strGDBTabPraefix ="##dbpraefix##";         // Optional kann hier ein Praefix für die Anwendung eingestellt werden,
                                                  // der allen Tabellennamen vorangestellt wird.
      $strGPWKlar='##pwcodierung##';              // (Wie) sollen Klartext-Kennworte abgelegt werden: b64 - base64-kodiert (nicht lesbar, aber entschlüsselbar)
                                                  // 'klar' - unverschlüsselt als Klartext, '' (leer) - gar nicht abspeichern!
      // --------------------------------------------------------------------------------
      // Angaben zum GUI, Verzeichnisse, Darstellungsoptionen
      $strGImgPath="images";       // Relativ zum Applikations-Verzeichnis.
      $strGCSSPath="css";
      $strGJSPath="js";
      $strGGUICharset="##guicharset##"; // Zeichensatz, der im Header angegeben wird.

      // --------------------------------------------------------------------------------
      // System-Informationen:
      $strGOpSystem="##opsystem##";               // Betriebssystem, entweder "linux" oder "win" (wichtig fuer System-Befehle und Pfade). 
      $strGAppType="##apptype##";                 // Typ der Applikation: "dev" - Entwicklung / Test, "prod" - Produktivversion.
      $strGAppText="##apptext##";                 // Frei wählbarer Text zur Identifizierung des Systems.
      $strGAppTitel="##apptitel##";               // Frei konfigurierbarer Titel der Applikation
      $strGAppFuss="##appfuss##";

      // --------------------------------------------------------------------------------
      // Meta-Informationen zur Anzeige, z.B. Schulname
      $arrGMeta['schulname']='##meta_schulname##';
      $arrGMeta['schulnummer']='##meta_schulnummer##';
      
      // --------------------------------------------------------------------------------
      // Weitere globale Parameter:
      $boolGDEBUG=false;          // wenn true, werden globale Debug-Angaben ausgegeben.
      $boolDEBUG=$boolGDEBUG;     // dies ist die lokale Debug-Variable, die hier initialisiert wird.
      $numGLogLevel=5;            // Loglevel von 0 - 5 (0: kein Logging, 5 alles wird mitgeloggt).
      break;

    // Ende "standard"      
    // -------------------------------------------------
    case "sample":
      // Beispielkonfiguration
      // --------------------------------------------------------------------------------

      // --------------------------------------------------------------------------------
      // Datenbank-Variablen:
      $strGDBtype="mysql";            // auch "oracle" und andere DBs moeglich
      $strGDBSID="";                  // Nur für Oracle relevant.
      $strGDBUser="partitur";
      $strGDBPass="XXXXXXX";
      $strGDBName="partitur";         // Schema bzw. DB-Name in MySQL in etwa dem DBNamen.
      $strGDBHost ="localhost";
      $strGDBTabPraefix ="";          // Optional kann hier ein Praefix für die Anwendung eingestellt werden,
                                      // der allen Tabellennamen vorangestellt wird.
      $strGPWKlar='';                 // (Wie) sollen Klartext-Kennworte abgelegt werden: b64 - base64-kodiert (nicht lesbar, aber entschlüsselbar)
                                      // 'klar' - unverschlüsselt als Klartext, '' (leer) - gar nicht abspeichern!
      // --------------------------------------------------------------------------------
      // Angaben zum GUI, Verzeichnisse, Darstellungsoptionen
      $strGImgPath="images";       // Relativ zum Applikations-Verzeichnis.
      $strGCSSPath="css";
      $strGJSPath="js";
      $strGGUICharset="utf-8"; // Zeichensatz, der im Header angegeben wird.

      // --------------------------------------------------------------------------------
      // System-Informationen:
      $strGOpSystem="win";                // Betriebssystem, entweder "linux" oder "win" (wichtig fuer System-Befehle und Pfade). 
      $strGAppType="dev";                 // Typ der Applikation: "dev" - Entwicklung / Test, "prod" - Produktivversion.
      $strGAppText="Entwicklungssystem";  // Frei wählbarer Text zur Identifizierung des Systems.
      $strGAppTitel="Jahrgangspartituren"; // Frei konfigurierbarer Titel der Applikation
      $strGAppFuss="&copy; Ministerium f&uuml;r Schule und Weiterbildung des Landes Nordrhein-Westfalen";

      // --------------------------------------------------------------------------------
      // Meta-Informationen zur Anzeige, z.B. Schulname
      $arrGMeta['schulname']='Testschule';
      $arrGMeta['schulnummer']='850875';
     
      
      // --------------------------------------------------------------------------------
      // Weitere globale Parameter:
      $boolGDEBUG=false;          // wenn true, werden globale Debug-Angaben ausgegeben.
      $boolDEBUG=$boolGDEBUG;     // dies ist die lokale Debug-Variable, die hier initialisiert wird.
      $numGLogLevel=5;            // Loglevel von 0 - 5 (0: kein Logging, 5 alles wird mitgeloggt).
      break;

    // Ende "sample"      
  } // SWITCH.    
  // Ende der Variablen-Belegung in Abhaengigkeit von $strKonf.
  // ----------------------------------------------------------------
?>

