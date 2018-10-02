<?php
  // p_adm_konf_del.php
  // 
  // ADMIN
  // Löschen von Einträgen aus Konfigurationstabellen, mit Nachfrage (Skript ruft sich selbst auf).
  //
  // Parameter:
  //      skonf     Kürzel für die zu bearbeitende Konfiguration.
  //      nid       Id-Wert des Schlüsselattributs für den zu löschenden Eintrag
  //      nconfirm  Bestätigung des Löschens: 0 - Bestätigung anfragen, 1 - Löschen bestätigt.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 03-OCT-2012.
  // lr: fh, 19-AUG-2013, keine Sperre mehr für Admins.
  // lr: fh, 22-OCT-2013, untergeordnete UV auch löschen.
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
  $strKonfK=ut_get_webpar('skonf');          // Kürzel für die zu bearbeitende Konfiguration.
                                             // Konfigurationsbereiche werden aus $arrGKatalogKonf entnommen (siehe p_sys_konfig_allg.inc.php).
  $numConfirm=ut_get_webpar_n('nconfirm');   // Bestätigung des Löschens: 0 - Bestätigung anfragen, 1 - Löschen bestätigt.
  $numID=ut_get_webpar('nid');               // Id-Wert des Schlüsselattributs für den zu löschenden Eintrag
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Konfiguration, Eintrag löschen";


  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if (($numFehler == 0) and (($strKonfK == '') or (!isset($arrGKatalogKonf[$strKonfK]))))
  {
    $numFehler = 1;
    $strFehlercode='A0110'; // Kein gültiger Konfigurationsbereich ausgewählt!
  }

  if (($numFehler == 0) and ($numID == 0))
  {
    $numFehler = 1;
    $strFehlercode='A0117'; // Kein gültiger Konfigurationseintrag gewählt!
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
            " WHERE $strIDAtt='$numID' " .
               $arrKonfData['orderby'];
    $stmtSQL = db_exec($strSQL,$boolDEBUG); 
    if (db_fetch_arr($stmtSQL,$arrSQL))
    {
      $numAnzZ++;
      $arrDaten=$arrSQL;
    } // DB-Schleife durch die Konfigurationseinträge.
    
    // Wenn keine Einträge gefunden wurden, Fehlermeldung ausgeben:
    if ($numAnzZ < 1)
    {
      $numFehler = 1;
      $strFehlercode='A0118'; // Konfigurationseintrag wurde nicht gefunden!
    }
  }// IF: Fehler    
      
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    if ($numConfirm == 0)
    {
      // Nachfragen, ob der Eintrag gelöscht werden soll:
      echo "<h2>Möchten Sie folgenden Eintrag tatsächlich löschen?</h2>\n";
      echo "<br />\n";
    
      foreach ($arrAtts as $strAtt => $strLabel)
      {
        echo "<label>$strLabel:</label> ";
        echo $arrDaten[$strAtt];
        echo "<br />\n";
      }
      
      echo "<br />Betroffene Unterrichtsvorhaben werden ebenfalls unwiderruflich gelöscht!<br /><br />\n";
      
      echo "<br />\n";
      echo "<p><ul>\n";
      $strDelPar="&skonf=$strKonfK&nid=" . urlencode($numID);
      echo "<li><a href='p_adm_konf_del.php?nconfirm=1" . $strDelPar ."'>JA, diesen Eintrag unwiderruflich löschen!</a></li>";
      echo "<br />\n";
      echo "<li><a href='p_adm_konf.php?skonf=$strKonfK'>NEIN, diesen Eintrag NICHT löschen!</a></li>";
      echo "</ul></p>\n";
    }
    else
    {
      // Bestätigung liegt vor, Eintrag löschen:
      // ---------------------------------------
      $boolSuccess=true;
      // CID:fh131022:Untergeordnete Objekte löschen.
      if ($strKonfK == 'textfeld')
      {
        // Wenn ein Textfeld gelöscht wird, die entsprechenden Einträge löschen:
        $strSQLDel1="DELETE FROM $strGtabEinUVTextfelder WHERE $strIDAtt='$numID'";
        $boolSuccess=db_exec($strSQLDel1,$boolDEBUG);
      }
      else
      {
        // Zunächst alle Textfeld-Einträge löschen, die mit zu löschenden UV verbunden sind:
        $strSQLDel1="DELETE FROM $strGtabEinUVTextfelder
                          WHERE uv_id IN
                               (SELECT DISTINCT uv_id FROM $strGtabEinUnterrichtsvorhaben
                                 WHERE $strIDAtt='$numID')";
        $boolSuccess = db_exec($strSQLDel1,$boolDEBUG); 

        if ($boolSuccess)
        {
          // Jetzt alle UV löschen:
          $strSQLDel1="DELETE FROM $strGtabEinUnterrichtsvorhaben
                             WHERE $strIDAtt='$numID'";
          $boolSuccess = db_exec($strSQLDel1,$boolDEBUG); 
        } // IF: Vorher erfolgreich?  
        
        if (($boolSuccess) and ($strKonfK == 'fach'))
        {
          // Bei Fach auch die Zuordnung der Fachverwalter löschen:
          $strSQLUpdDel="UPDATE $strGtabSysUser SET fach_id = NULL WHERE fach_id=$numID";
          $boolSuccess = db_exec($strSQLUpdDel,$boolDEBUG); 
        } // IF: Soll Fach gelöscht werden?  
      } // IF: Textfeld oder anderes Feld löschen?

      if ($boolSuccess)
      {
        // Eigentlichen Eintrag löschen:
        // ---------------------------------------
        $strSQLDel="DELETE FROM " . $arrKonfData['tab'] . " WHERE $strIDAtt='$numID' ";
        $boolSuccess=db_exec($strSQLDel,$boolDEBUG);
      } // IF: Vorige Lösch-Aktionen erfolgreich?  
      
      if ($boolSuccess)
      {
        echo "<h2>Der Eintrag mit der ID '$numID' wurde erfolgreich gelöscht!</h2>\n";
        echo "<p>";
        echo "<a href='p_adm_konf.php?skonf=$strKonfK'>zurück zu dem Konfigurationsbereich</a>";
        echo "</p>\n";
        p_log(3120,"Konf: $strKonfK (ID: $numID )"); // Log-Eintrag.
      }
      else
      {
        echo "<br />\n";
        echo "<h2>Der Eintrag mit der ID '$numID' konnte nicht gelöscht werden (Datenbank-Fehler)!</h2>\n";
        echo "<p>Bitte versuchen Sie es erneut und entfernen Sie alle Datensätze, in denen dieser Eintrag noch benutzt wird!</p>\n";
        echo "<p>";
        echo "<a href='p_adm_konf.php?skonf=$strKonfK'>zurück zu dem Konfigurationsbereich</a>";
        echo "</p>\n";
        p_log(8120,"Konf: $strKonfK (ID: $numID )"); // Log-Eintrag.
      }
    } // IF: Bestätigung liegt vor.  
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------

  
  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    p_fehler_ausgabe($strFehlercode);
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------

  echo "<br />\n";
  echo "<ul>\n";
  echo " <li><a href='p_adm_auswahl.php'>zurück zur Auswahlseite</a></li> \n";
  echo "</ul>  \n";


  // -----------------------------------------------------
  // Abschluss der Seite:
  include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  // -----------------------------------------------------
  // Ende PHP.
?>
