<?php
  // p_setup.php
  // 
  // Setup-Routine, um die Parameter der Konfigurationsdatei lib/p_sys_konfig_instanz.inc.php
  // abzufragen und einzutragen.
  //
  // Die Routine liest die Musterdatei p_sys_konfig_instanz.muster.inc.php ein und die
  // Variablen in p_conf_variablen.inc.php.
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
  // lr: fh, 26-NOV-2013, Erweiterung um SQL-Ausgabe.
  // lr: fh, 19-DEC-2013, SQL-Datei-Erzeugung korrigiert.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.12.2013";
  
  // PHP-Kopf, include-Dateien:
  require_once ("../lib/p_ut_allgemein.inc.php");  // Allgemeine Funktionen.
  require_once ("p_conf_util.inc.php");            // Hilfsfunktionen
  require_once ("p_conf_variablen.inc.php");       // Variablen zur Konfiguration.

  p_conf_head(); // Kopfbereich

  // ------------------------------------------------------
  // Weitere Variablen:
  $numFehler=0;
  $strFehlertext='';
  $numEingabeWarnung=0;
  $strEingabeWarntext='';    // Text mit Hinweisen zu den Eingaben.
  $strMusterdatei='p_sys_konfig_instanz.muster.inc.php';
  $strKonfigPfad="../lib/";
  $strKonfigDatei='p_sys_konfig_instanz.inc.php';
  $strSQLMuster='p_db_partituren_muster.sql';
  $strSQLDatei='create_partitur_db.sql';
  $arrEingaben=array();
  // ------------------------------------------------------
  // Einlesen aller Parameter:
  $numSpeicherung=ut_get_webpar_n('nspeichern');      // 1, wenn Parameter zum Speichern übergeben wurden. 
  if ($numSpeicherung == 1)
  {
    foreach ($arrGCfgVar as $numCfgId => $arrVarInfo)
    {
    
    } // FOR-Schleife durch alle Variablen aus p_conf_variablen.inc.php.
  } // IF: Wurden Parameter zum Speichern übergeben?

  // ------------------------------------------------------

  echo "<h1>Konfiguration der Partiturenanwendung</h1>\n";

  if ($numFehler == 0)
  {
     // Prüfen, ob Vorlagendatei vorhanden ist:
     if (!file_exists($strMusterdatei))
     {
       $numFehler=1;
       $strFehlertext="Die Musterdatei '$strMusterdatei' im aktuellen Verzeichnis '$strKonfigPfad' fehlt leider!<br />\n";
     } // IF: Fehlt Musterdatei?                 
  } // IF: Fehler?   
       
  if ($numFehler == 0)
  {
     // Prüfen, ob Datei schon vorhanden ist:
     if (file_exists($strKonfigPfad . $strKonfigDatei))
     {
       $numFehler=1;
       $strFehlertext="Die Konfigurationsdatei '$strKonfigDatei' im Verzeichnis '$strKonfigPfad' ist bereits vorhanden!<br />\n" .
                      "Daher kann das Setup aus SIcherheitsgründen nicht durchgeführt werden.<br />\n".
                      "Bitte passen Sie diese Datei entweder
                       per Hand an oder entfernen Sie die Datei, damit das Setup ausgeführt werden kann.<br />\n";
     } // IF: Konf-Datei bereits vorhanden?                 
  } // IF: Fehler?   

  // ----------------------------------------

  if ($numFehler == 0)
  {
     echo "<h2>Hinweis</h2>\n";
     echo "<p>Im Verlauf des Setup werden die Inhalte der Konfigurationsdatei '$strKonfigDatei' im Verzeichnis '$strKonfigPfad'
           aufgrund Ihrer Angaben zusammengestellt. Sie können diese Datei jederzeit später nachbearbeiten.
           </p>
           <p>Wenn diese Setup-Anwendung keine Schreibrechte auf das Verzeichnis '$strKonfigPfad' besitzt, wird Ihnen
            der Inhalt der Datei übermittelt, so dass Sie die Datei selbst anlegen können.
           </p>
           <p>
           Pflichtfelder sind durch einen Stern (*) gekennzeichnet! Diese dürfen nicht leer sein!
           </p>\n";
     echo "<br />\n";

     // Formular aufbauen:
     echo "<form name='frm_p_setup' id='frm_p_setup' action='" . $_SERVER['PHP_SELF']  . "' method='POST' >\n";
     echo "<input type='hidden' name='nspeichern' id='nspeichern' value='1' /><br />\n";     
     
     
     // Variablen und Eingabefelder:
     foreach ($arrGCfgVar as $numCfgId => $arrVarInfo)
     {
        $strFeldWarnung='';
        $strSymbol=$arrVarInfo['symbol'];               // Platzhalter
        $boolPflicht=(!empty($arrVarInfo['pflicht']));  // Pflichfeld
        $strLabel=$arrVarInfo['bez'];
        $strHinweis=(isset($arrVarInfo['hinweis'])) ? $arrVarInfo['hinweis'] : '';
        $strTag='s_' . str_replace('##','',$strSymbol);
        $strWert=(isset($arrVarInfo['default'])) ? $arrVarInfo['default'] : ''; // Default-Wert vorbelegen
        if ($numSpeicherung == 1)
        {
          $strWertPar=ut_get_webpar($strTag);
          $strWert=$strWertPar;
          if (($strWertPar === '') and ($boolPflicht))
          {
             $numEingabeWarnung++;
             $strFeldWarnung = "Das Feld '$strLabel' ist ein Pflichtfeld!";
             $strEingabeWarntext .= "++ $strFeldWarnung --";
          } //IF: Leeres Pflichtfeld?   
          $arrEingaben[$strSymbol]=$strWert;      // Wert speichern
        } // Wurden Werte gespeichert?
        
        echo "<label for='$strLabel' title='$strHinweis'>$strLabel:";
        echo ($boolPflicht) ? "<sup>(*)</sup>" : '';
        echo "</label><br />\n";
        if ((isset($arrVarInfo['sel'])) and (is_array($arrVarInfo['sel'])))
        {
          // Select-Liste:
          echo "<select name='$strTag' id='$strTag'>\n";
          foreach ($arrVarInfo['sel'] as $strOpt => $strOptText)
          {
            $strSelected=($strOpt == $strWert) ? " selected='selected' " : '';
            echo "<option value='$strOpt' $strSelected >$strOptText</option>\n";
          }
          echo "</select>\n";
          echo "<br />\n";
        }
        else
        {
          // Normales Input-Feld:
          echo "<input type='input' size='80' name='$strTag' id='$strTag' value='$strWert' /><br />\n";
        }  
        if (!empty($strFeldWarnung))
        {
          echo "<strong style='color:red;'>$strFeldWarnung</strong><br />\n";
        } // IF: Warnhinweis?
        echo "<br />\n";
        

     } // FOR-Schleife durch alle Variablen aus p_conf_variablen.inc.php.
     
     
     echo "<input type='submit' value='Konfigurationsdatei erzeugen' />\n";
     
     // Formular schließen:
     echo "</form >\n";
     
  } // IF: Fehler?   
            

  // ----------------------------------------

  if (($numFehler == 0) and ($numSpeicherung == 1) and (empty($strFeldWarnung)))
  {
    // Wenn keine Fehler vorkommen, Ausgabedatei erzeugen:
    // ----------------------------------------------------
    $strAusgabe='';
    $hndEingabe = fopen($strMusterdatei, "r");
    while (!feof($hndEingabe))
    {
       $strEingabeZeile=fgets($hndEingabe);
       if (strpos($strEingabeZeile,'##') !== '')
       {
          // Muster ersetzen:
          $strEingabeZeile=str_replace(array_keys($arrEingaben),array_values($arrEingaben),$strEingabeZeile);
       }  // IF: Muster vorhanden?
       
       $strAusgabe .= $strEingabeZeile;
       // echo "<pre>" . htmlspecialchars($strEingabeZeile,ENT_COMPAT,'ISO-8859-15') . "</pre>\n";
    } // Schleife durch Eingabedatei.
    fclose($hndEingabe);
    
    // Konfigurationsdatei erzeugen:
    $boolErzeugung=file_put_contents($strKonfigPfad . $strKonfigDatei,$strAusgabe);
    if ($boolErzeugung === false)
    {
      echo "<p><strong class='hinweis'>Die Erzeugung der Datei '" . $strKonfigPfad . $strKonfigDatei . "' hat leider nicht funktioniert!<br />
            Kopieren Sie bitte die unten angegebene Datei, oder laden Sie diese durch Betätigen von 'Herunterladen' in eine
            separate Datei herunter und legen dies im Verzeichnis '$strKonfigPfad' mit dem Dateinamen '$strKonfigDatei' ab.</strong></p>\n";
    }
    else
    {
      echo "<p><strong>Konfigurationsdatei '" . $strKonfigPfad . $strKonfigDatei . "' wurde erfolgreich erzeugt!</strong></p>\n";
    } // IF: Hat Datei-Erzeugung geklappt?
    
    echo "<form action='p_conf_download.php' method='POST'>\n";
    echo "Der Inhalt der Konfigurationsdatei:<br />\n";
    echo "<textarea name='sconf' cols='120' rows='10' />$strAusgabe</textarea><br />\n";
    echo "<input type='hidden' name='nart' value='1' />\n";   // Art der Datei
    echo "<input type='submit' value='Konfigurationsdatei herunterladen' />\n"; 
    echo "</form>\n";
  } // IF: Fehler?   
           

  // ----------------------------------------------------
  // SQL-Datei:           
  // ----------------------------------------------------
  if (($numFehler == 0) and ($numSpeicherung == 1) and (empty($strFeldWarnung)))
  {
    // Wenn keine Fehler vorkommen, auch SQL-Datei erzeugen:
    // ----------------------------------------------------
    $strAusgabeSQL='';
    $hndEingabeSQL = fopen($strSQLMuster, "r");
    $strSuche='##dbpraefix##';
    $strReplace=(empty($arrEingaben['##dbpraefix##'])) ? '' : $arrEingaben['##dbpraefix##'];
    while (!feof($hndEingabeSQL))
    {
       $strEingabeZeile=fgets($hndEingabeSQL);
       if (strpos($strEingabeZeile,'##dbpraefix##') !== '')
       {
          // Muster für Präfix ersetzen:
          $strEingabeZeile=str_replace($strSuche,$strReplace,$strEingabeZeile);
       }  // IF: Muster vorhanden?
       if (strpos($strEingabeZeile,$strSQLMuster) !== '')
       {
          // Muster für Dateinamen ersetzen:
          $strEingabeZeile=str_replace($strSQLMuster,$strSQLDatei,$strEingabeZeile);
       }  // IF: Muster vorhanden?
       
       $strAusgabeSQL .= $strEingabeZeile;
       // echo "<pre>" . htmlspecialchars($strEingabeZeile,ENT_COMPAT,'ISO-8859-15') . "</pre>\n";
    } // Schleife durch Eingabedatei.
    fclose($hndEingabeSQL);
    
    // Konfigurationsdatei erzeugen:
    $boolErzeugungSQL=@file_put_contents($strSQLDatei,$strAusgabeSQL);
    if ($boolErzeugungSQL === false)
    {
      echo "<p><strong class='hinweis'>Das SQL-Skript '$strSQLDatei' konnte nicht automatisch erzeugt werden.<br />
            Kopieren Sie bitte die unten angegebenen SQL-Befehle, oder laden Sie diese durch Betätigen von 'SQL-Skript herunterladen' in eine
            separate Datei herunter und führen Sie die Befehler auf der Datenbank aus.</strong></p>\n";
    }
    else
    {
      echo "<p><strong>Das SQL-Skript '$strSQLDatei' wurde erfolgreich im Setup-Verzeichnis erzeugt!</strong>
             <br />
             Bitte führen Sie dieses auf der Datenbank aus. 
             <br />
             Alternativ können Sie die untenstehenden Befehle kopieren oder das SQL-Skript herunterladen und ausführen.</p>\n";
    } // IF: Hat Datei-Erzeugung geklappt?
    
    echo "<form action='p_conf_download.php' method='POST'>\n";
    echo "Der Inhalt des SQL-Skripts:<br />\n";
    echo "<textarea name='sconf' cols='120' rows='10' />$strAusgabeSQL</textarea><br />\n";
    echo "<input type='hidden' name='nart' value='2' />\n";   // Art der Datei
    echo "<input type='submit' value='SQL-Skript herunterladen' />\n"; 
    echo "</form>\n";
  } // IF: Fehler?   
           

  // ----------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
     echo "<h2>Fehler</h2>\n";
     echo "<p><strong>Es ist ein Fehler aufgetreten:</strong></p>\n";
     echo "<br />\n";
     echo "<p>$strFehlertext</p>\n";
     echo "<br />\n";
  } // IF: Fehler aufgetreten   
  // ----------------------------------------


  // ------------------------------------------------------

  p_conf_foot(); // Fußbereich, Seitenende
  
?>
