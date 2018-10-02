<?php
  // p_a_uv_save.php
  // 
  // Speichern der aktuellen Unterrichtseinheit in einem PopUp-Fenster.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium f¸r Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // lr, fh, 19-JAN-2012.
  // lr: fh, 02-FEB-2012, neue UV kˆnnen angelegt werden.
  // lr: fh, 12-APR-2012, Bearbeitungssperre. UV-Infos vor dem Speichern in Session-Tabelle sichern.
  // lr: fh, 19-AUG-2013, Bearbeitungssperre auf ein Fach beziehen.
  // lr: fh, 20-SEP-2013, Wochenzeitbedarf nicht ‰nderbar, Sicherstellen, dass nur Fach $numFachBearb bearbeitet werden kann!
  // lr: fh, 11-NOV-2014, Korrektur: Existierende Werte f¸r tempor‰r angelegten Dummy-Eintrag nutzen.
  // -------------------------------------------------------------

  // ƒnderungsdatum:
  $strGChangeDate="11.11.2014";
  // -------------------------------------------------------------

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();                 // Session-ID und Variablen zuordnen.
  $boolFV=p_check_fv(false);         // Pr¸fung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearb=(empty($_SESSION['p_fach_id_bearb'])) ? '' : $_SESSION['p_fach_id_bearb'];
  p_sperre_bearb('S',$boolFV,true,$numFachBearb);  // Sperre einrichten, sonst Fehlermeldungsseite (sollte hier nicht passieren, da vorher Sperre gepr¸ft wird).

  // Parameter einlesen:
  $numUVID=ut_get_webpar_n('nuvid');
  $boolNeuUV=(ut_get_webpar_n('nneu') == 1);      // Wenn 1, dann wird neues Unterrichtsvorhaben angelegt.
  
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code f¸r aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG ¸bernommen.
  $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
  $strGTitel=$strGAppTitel . " -  Unterichtsvorhaben";

  // Basis-Informationen f¸r Statuszeile ermitteln:
  // $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf_popup.inc.php");  // HTML-Seite aufbauen mit PopUpHeader.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerpr¸fungen (und Parameter einlesen):
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
     if (!$boolFV)
     {
       $numFehler=1;
       $strFehlercode='F0100';   // Diese Funktion kann nur von Fachverwalter/innen genutzt werden!
     }
  } // IF: Fehler?   

  if (($numFehler == 0) and ($numFachBearb == ''))
  {
     $numFehler=1;
     $strFehlercode='F0110';   // Fach oder Stufe konnte nicht festgestellt werden!
  } // IF: Bearbeitbares Fach angegeben?   

  if (($numFehler == 0) and ($numFachBearb == ''))
  {
     $numFehler=1;
     $strFehlercode='F0110';   // Fach oder Stufe konnte nicht festgestellt werden!
  }   
  else
  {
     $numFachBearbRecht=p_fv_fach();       
  } // IF: Bearbeitbares Fach angegeben?   

  if (($numFehler == 0) and ($numFachBearbRecht != $numFachBearb))
  {
     $numFehler=1;
     $strFehlercode='F0115';   // F¸r dieses Fach haben Sie keine Bearbeitungsrechte!
  } // IF: Rechte f¸r dieses Fach?

  // Wurde UV angegeben?
  if (($numFehler == 0) and (!$boolNeuUV))
  {
    if (empty($numUVID))
    {
       $numFehler=1;
       $strFehlercode='M0206';   // Bitte geben Sie eine Unterrichtseinheit an!
    }
    else
    {
      // Titel heraussuchen:
      db_get_3values("uv_titel","zeitbedarf_wochen","uv_id",
                     $strGtabEinUnterrichtsvorhaben,"uv_id=$numUVID",$strUVTitel,$numZeitbedarfWo,$numUVIDDB,$boolDEBUG);
      if ($numUVIDDB != $numUVID)
      {
         $numFehler=1;
         $strFehlercode='M0201';   // Die angegebene Unterrichtseinheit ist ung¸ltig!
      } //IF: G¸ltige Unterrichtseinheit?
    }// IF: Unterrichtseinheit angegeben?                 
  } // IF: Fehler?  
  
  // Ende Fehlerpr¸fungen:
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    if ($boolNeuUV)
    {
      // Wenn neue UV angelegt werden muss, neue ID anlegen:
      $numUVID=db_get_value("MAX(uv_id)",$strGtabEinUnterrichtsvorhaben,'',$boolDEBUG) + 1;
      // CID:fh141111:Minimale Schulform etc. heraussuchen:
      $numDummySF=db_get_value("MIN(schulform_id)",$strGtabKatSchulform);
      $numDummyStufe=db_get_value("MIN(stufe_id)",$strGtabKatStufe);
      $numDummyZug=db_get_value("MIN(zug_id)",$strGtabKatZug);
      $numDummyKurs=db_get_value("MIN(kursart_id)",$strGtabKatKursart);
      // Einf¸gen mit Dummy-Ids:
      $strInsSQL="INSERT INTO $strGtabEinUnterrichtsvorhaben 
                              (uv_id,schulform_id,fach_id,stufe_id,zug_id,kursart_id,uv_titel) 
                       VALUES ($numUVID,$numDummySF,$numFachBearb,$numDummyStufe,$numDummyZug,$numDummyKurs,'unbenannt')";
      $boolSuccess=db_exec($strInsSQL,$boolDEBUG);
    }  
    else
    {
      // Wenn UV noch nicht in ƒnderungsspeicher, Angaben vor dem Speichern dort sichern:
      p_uv_retten($numUserID,$numUVID); // Sichert Daten aktueller UV in Sicherungstabelle.
    } // IF: Neues UV bzw. altes sichern?

    // Definition der Felder und Daten auslesen:
    // -----------------------------------------
    list($arrFld,$arrUVDaten,$arrDT)=p_felder_uv($numUVID); // Dort werden auch die Felder konfiguriert.

    // Update-Statements initialisieren:
    $strUpdateBasis='';
    // $arrInsertText=array();

    // Schleife durch alle Felder 
    $arrUVDaten=array('uv_id'=>$numUVID,'fach_id'=>$numFachBearb);   // Daten in Array ablegen, um Position des UV zu berechnen.
    foreach ($arrFld as $strAtt => $arrFldInfo)
    {
      $boolTextFeld=(!empty($arrFldInfo['textfeld_id'])); // Freies Textfeld aus Sondertabelle?
      $strTag="s_" . (($boolTextFeld) ? $arrFldInfo['textfeld_id'] : $strAtt); // Bei freien Textfeldern wird die ID verwendet.
      $strWert=ut_get_webpar($strTag);
      $strLabel=$arrFldInfo['lbl'];
      // CID:fh130920:Readonly-Felder nicht beachten:
      if ((empty($arrFldInfo['ro'])) and ($strAtt != 'beginn_kw') and ($strAtt != 'ende_kw'))
      {
        $arrUVDaten[$strAtt]=$strWert;
        if ($boolTextFeld)
        {
           $strDatTyp='string';
           $numDatLen=(empty($arrFldInfo['feldlaenge'])) ? 200 : $arrFldInfo['feldlaenge'];
        }
        else
        {
           $strDatTyp=$arrDT[$strAtt]['TYP'];
           $numDatLen=$arrDT[$strAtt]['LEN'];
        } // IF: Freies Textfeld oder aus Stammtabelle?
        $strWertF=($numDatLen > 60) ? p_ascii2html($strWert) : $strWert;    // ASCII-formatierten Text ggf. in HTML zur¸ckwandeln.
        if (($numDatLen > 0) and ($strDatTyp == 'string'))
        {
          $strWertF = substr($strWertF,0,$numDatLen); // Wert auf Maximalgrˆﬂe zur¸ckschneiden.
        }

        if ($boolTextFeld)
        {
           // Freies Textfeld:
           $numTFID=$arrFldInfo['textfeld_id'];
           $strDeleteSQL = "DELETE FROM $strGtabEinUVTextfelder WHERE uv_id=$numUVID and textfeld_id=$numTFID";
           $numSuccessDB=db_exec($strDeleteSQL,$boolDEBUG);
           if (($numSuccessDB) and ($strWertF != ''))
           {
             $strInsertSQL = "INSERT INTO $strGtabEinUVTextfelder(uv_id,textfeld_id,uv_text) " .
                             " VALUES ($numUVID,$numTFID,'$strWertF') ";
             $numSuccessDB=db_exec($strInsertSQL,$boolDEBUG);
           } // IF: DB-erfolgreich?

           // TODO: hier kˆnnte man noch DB-Fehler abfangen!
        }
        else
        {
          // Normales Eingabe-Feld
          // Unterscheidung nach Datentypen (bisher nur int und string, aber so l‰sst es sich ggf. erweitern
          switch ($strDatTyp)
          {
            case 'string':
              $strWertF="'$strWertF'";
              break;
            case 'int':
              // Integer, keine Kommas etc. erlaubt:
              $strWertF=intval($strWertF);
              break;
            default:
              // Flieﬂpunktzahl etc.
              $strWertF=str_replace(',','.',$strWertF); // Komma durch Punkt ersetzen.
              $strWertF=floatval($strWertF);  // Sicherheitshalber in Float umwandeln
          } // Ende der Fallunterscheidung.    

          $strUpdateBasis .= "$strAtt = $strWertF, ";

        } // IF: freies Textfeld oder Eingabefeld der Basis-Tabelle.
      } // IF: Nur-Lese-Feld?  
    } // FOR-Schleife durch alle Felder.  

    // Automatische Platzierung (Wochenstart und -Ende) berechnen:
    $numBeginnWo=ut_get_webpar_n('s_beginn_kw');
    $numEndeWo=ut_get_webpar_n('s_ende_kw');
    list($numBeginnWoNeu,$numEndeWoNeu,$strMeldungWo)=p_berechne_uv_pos($numBeginnWo,$numEndeWo,$arrUVDaten);
    $strUpdateBasis .= "beginn_kw = $numBeginnWoNeu, ende_kw = $numEndeWoNeu, ";
    
    
    // Ggf. Wochendauer ausrechnen und ablegen:
    $numEndeWoNeu=(($numEndeWoNeu > 0) and ($numEndeWoNeu < $numBeginnWoNeu)) ? ($numEndeWoNeu + 52) : $numEndeWoNeu;
    $numZeitBedWo=(($numEndeWoNeu > 0) and ($numBeginnWoNeu > 0)) ? ($numEndeWoNeu - $numBeginnWoNeu + 1) : '';
    if ($numZeitBedWo > 0)
    {
       $strUpdateBasis .= "zeitbedarf_wochen = $numZeitBedWo, ";
    } // IF: Wochenzeit ausgerechnet?   

    // Abspeichern der normalen Eingabefelder:
    $strUpdateBasis = "UPDATE $strGtabEinUnterrichtsvorhaben SET $strUpdateBasis aenderung_user_id=$numUserID" .
                      " WHERE uv_id=$numUVID ";
    $numSuccessDB=db_exec($strUpdateBasis,$boolDEBUG);                  

    if ($numSuccessDB)
    {
      echo "DB aktualisiert<br />\n\n";
    
      if (!$boolDEBUG)
      {
        // JS-Code zum Aktualisieren der Plan-Seite:
        echo "<script type='text/javascript'> \n";
        echo "opener.location.reload(true);\n";
        echo "window.close();\n"; // Sich selbst schlieﬂen
        if ($strMeldungWo != '')
        {
           echo "alert('$strMeldungWo');\n";
        } // IF: Hinweis ausgeben, wenn Position oder L‰nge ver‰ndert wurde.   
        echo "</script>\n";
      }  
    }
    else
    {
       $numFehler=1;
       $strFehlercode='F0200';   // SYS-F0200: Es ist ein Fehler beim Speichern in der Datenbank aufgetreten!
    } // IF: DB-Fehler?   
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
  //include($strGIncPath . "p_gui_fuss.inc.php");  // Fuﬂblock.
  echo "   </div> <!-- pcontainer --> \n";
  echo "  </div> <!-- pinhalt --> \n";
  echo " </body>\n";
  echo "</html>\n";
  
  // -----------------------------------------------------
  // Ende PHP.
?>