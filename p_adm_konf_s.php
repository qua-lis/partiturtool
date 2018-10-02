<?php
  // p_adm_konf_s.php
  // 
  // ADMIN
  // Speichern von Bearbeitungen in Konfigurationstabellen.
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
  // lr: fh, 12-APR-2012, Sperre.
  // lr: fh, 03-OCT-2012, bei leeren Parameterwerten (z.B. Checkboxen) das Attribut auf NULL setzen.
  // lr: fh, 19-AUG-2013, keine Sperre mehr für Admins.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_adm();         // Prüfung, ob als Admin angemeldet.
  // p_sperre_bearb('S',true,true);    // Sperre einrichten, sonst Fehlermeldungsseite

  // Parameter einlesen:
  $strKonfK=ut_get_webpar('skonf');         // Kürzel für die zu bearbeitende Konfiguration.
                                            // Konfigurationsbereiche werden aus $arrGKatalogKonf entnommen (siehe p_sys_konfig_allg.inc.php).
  $numVollst=ut_get_webpar_n('nvollst');    // Flag, dass Seite vollständig geladen wurde.
  $numAnzZ=ut_get_webpar('nanz');           // Anzahl der Datenzeilen
  // weitere Parameter in der Analyse-Schleife.

  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Konfiguration";

  
  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if (($numFehler == 0) and (($strKonfK == '') or (!isset($arrGKatalogKonf[$strKonfK]))))
  {
    $numFehler = 1;
    $strFehlercode='A0110'; // Kein gültiger Konfigurationsbereich ausgewählt!
  }

  if (($numFehler == 0) and ($numVollst != 1))
  {
    $numFehler = 1;
    $strFehlercode='A0111'; // Bitte warten Sie, bis die Seite vollständig geladen ist, bevor Sie Änderungen vornehmen!
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
    $arrDT=db_table_attribs($arrKonfData['tab']); // Datentypen der Tabelle.
    
    // DEBUG:
    ut_printr_dbg($arrDT,"Datentypen:");
    $numAnzUpd=0;
    
    // Daten einlesen:
    for ($numZ = 1;$numZ <= $numAnzZ;$numZ++)
    {
      $strTagPfx='s_' . $numZ . '_';
      $strTag=$strTagPfx . $strIDAtt;
      if ($boolDEBUG) { echo "<p>Tag: $strTag, IDAtt: $strIDAtt</p>\n"; }
      $numID=ut_get_webpar($strTag);
      $boolUpdate=($numID != ''); // Kann auch 0 sein, da bestimmte Einträge 0 als Id vorsehen!
      $boolNichtLeer=false;        // Flag, ob Datensatz nicht leer ist.
      $strUpdate='';

      foreach ($arrAtts as $strAtt => $strLabel)
      {
        $strTag=$strTagPfx . $strAtt;
        $strWert=ut_get_webpar($strTag);
        
        $strUpdWert = 'NULL';  // Standardmäßig auf Leer-Setzen initalisieren, damit auch das Leeren von Werten durchgeführt werden kann.
        if ($strWert != '')
        {
          if ($boolDEBUG) { echo "<p>ID: $numID, Att: $strAtt, Wert: $strWert</p>\n"; }
          $boolNichtLeer=true;
          $strDTyp=$arrDT[$strAtt]['TYP'];
          
          switch ($strDTyp)
          {
            case 'string':
              // String:
              $strUpdWert="'" . substr($strWert,0,$arrDT[$strAtt]['LEN']) . "'"; // in Anführungszeichen und Länge ggf. abschneiden;
              break;
            case 'int':
              // Ganzzahl:
              $strUpdWert = (is_numeric($strWert)) ? $strWert : 0;
              break;
            default:
              $strUpdWert = $strWert;
          } // Ende der Fallunterscheidung nach Datentyp.
          
         } // IF: Wert leer?
         $strUpdate .= ",$strAtt=$strUpdWert ";
       } // FOR-Schleife durch alle Attribute.
       
       if ($boolNichtLeer)
       {
         if (!$boolUpdate)
         {
           $numID=p_erzeuge_id($arrKonfData['tab'],$strIDAtt,$arrKonfData['notnullatts']);
           if ($numID == 0)
           {
             $numFehler = 1;
             $strFehlercode='A0200'; // SYS-A0200: Es ist ein Fehler beim Anlegen einer neuen ID in der Datenbank aufgetreten!
             break;
           }
         }// IF: Neue ID erzeugen?
         
         $strSQLUpd="UPDATE " . $arrKonfData['tab'] . " SET " . substr($strUpdate,1)  .
                    " WHERE $strIDAtt=$numID";
         db_exec($strSQLUpd,$boolDEBUG);
         $numAnzUpd++;
       } // IF: Datensatz nicht leer?
    } // FOR-Schleife durch alle Datensätze.
    
    
    if ($numAnzUpd > 0)
    {
      p_log(3110,"Konf: $strKonfK ($numAnzUpd DS)"); // Log-Eintrag.
    } // IF: Wurden Datensätze aktualisiert?
    
    // Zur Eingabeseite zurück:
    if ( ($numFehler==0) and (!$boolDEBUG))
    {
      header("location: p_adm_konf.php?skonf=$strKonfK");
      exit;
    }  
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------

  
  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
     // Basis-Informationen für Statuszeile ermitteln:
     $strGStatus= p_status_info();
     // -------------------------------------------------------------
 
     include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
     // -------------------------------------------------------------
     p_fehler_ausgabe($strFehlercode);
 
    echo "<ul>\n";
    echo " <li><a href='p_adm_auswahl.php'>zurück zur Auswahlseite</a></li> \n";
    echo "</ul>  \n";
    // -----------------------------------------------------
    // Abschluss der Seite:
    include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
    // -----------------------------------------------------
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------

  // Ende PHP.
?>
