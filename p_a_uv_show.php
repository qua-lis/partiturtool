<?php
  // p_a_uv_show.php
  // 
  // Anzeige bzw. Bearbeitung der aktuellen Unterrichtseinheit in einem PopUp-Fenster.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // lr, fh, 19-JAN-2012.
  // lr: fh, 02-FEB-2012, Nur-Lese-Modus ergänzt, neue UV können angelegt werden.
  // lr: fh, 27-MAR-2012, Knopf zum Zurücksetzen der Kalenderwochen. Schulform immer korrekt belegen.
  // lr: fh, 29-MAR-2012, Knopf, um Kopie anzulegen. Pflichtfelder berücksichtigen.
  // lr: fh, 12-APR-2012, Bearbeitungssperre.
  // lr: fh, 26-APR-2012, Suchbegriff farbig hervorheben.
  // lr: fh, 19-AUG-2013, Fach bei Sperre berücksichtigen.
  // lr: fh, 14-SEP-2013, Druckfunktion.
  // lr: fh, 15-SEP-2013, Nur ein Fach bearbeitbar.
  // lr: fh, 20-SEP-2013, Wochenzeitbedarf nicht änderbar. URLs als Links.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="20.09.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  $boolFV=p_check_fv(false);         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearb=(empty($_SESSION['p_fach_id_bearb'])) ? '1' : $_SESSION['p_fach_id_bearb'];
  $strSperrUser=p_sperre_bearb('I',$boolFV,false,$numFachBearb);    // prüfen, ob Sperre durch andere vorliegt.

  // Parameter einlesen:
  $numUVID=ut_get_webpar_n('nuvid');
  $strSuchbegriff=ut_get_webpar('ssuche');              // Evtl. Suchbegriff, der mit der Klasse psuchtreffer hervorgehoben werden soll.
  $numNurLese=ut_get_webpar_n('nlese');                 // Wenn 1, dann nur im Lese-Modus öffnen.
  $numNurLese=($strSperrUser != '') ? 1 : $numNurLese;  // Wenn Sperre durch andere, nur Lese-Modus.
  $boolNeuUV=(ut_get_webpar_n('nneu') == 1);            // Wenn 1, dann wird neues Unterrichtsvorhaben angelegt.
  $boolBearb=((ut_get_webpar_n('nbearbeiten') == 1) and ($boolFV) and ($numNurLese != 1));  // Bearbeitungsmodus (= true) nur als Fachverwalter möglich
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Unterichtsvorhaben";

  if ($boolBearb)
  {
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
       $strFehlercode='F0115';   // Für dieses Fach haben Sie keine Bearbeitungsrechte!
    } // IF: Rechte für dieses Fach?
    
    if ($numFehler == 0)
    {
       p_sperre_bearb('S',true,true,$numFachBearb);    // Sperre einrichten, sonst Fehlermeldungsseite (sollte hier nicht passieren, da vorher Sperre geprüft wird.
       $_SESSION['p_fach_id_bearb']=$numFachBearb;     // Sicherheitshalber nochmal zuweisen.
    }   
  } // IF: Bearbeitungsmodus?

  // Basis-Informationen für Statuszeile ermitteln:
  $strGStatus= p_status_info();
  // -------------------------------------------------------------

  include($strGIncPath . "p_gui_kopf_popup.inc.php");  // HTML-Seite aufbauen mit PopUpHeader.
  // -------------------------------------------------------------
  
  // -------------------------------------------------------------
  // Fehlerprüfungen (und Parameter einlesen):
  // -------------------------------------------------------------
  
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
         $strFehlercode='M0201';   // Die angegebene Unterrichtseinheit ist ungültig!
      } //IF: Gültige Unterrichtseinheit?
    }// IF: Unterrichtseinheit angegeben?                 
  } // IF: Fehler?  
  
  // Ende Fehlerprüfungen:
  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    if ($boolNeuUV)
    {
      echo "<h2>Neues Unterrichtsvorhaben anlegen</h2>\n";
    } // IF: Neuer Datensatz? 

    // echo "<h2>Unterrichtsvorhaben</h2>\n";
    // echo "<h3>$strUVTitel</h3>\n";

    
    // Definition der Felder und Daten auslesen:
    // -----------------------------------------
    list($arrFld,$arrUVDaten,$arrDT)=p_felder_uv($numUVID); // Dort werden auch die Felder konfiguriert.

    $strHTMLClose="<form name='frm_wnd_close' class='pclose'>" .
                  "<input class='pbutprint' name='butprint' type='button' value=' Fenster drucken ' onclick='self.print();' />";
    $strHTMLClose.="<input name='butclose' type='button' value=' Fenster schließen ' onclick='self.close();' />" .
                  "</form>\n";
    
    
    if ($boolBearb)
    {
       // Im Bearbeitungsmodus Formular aufbauen:
       // ---------------------------------------
       echo "<div id='puvbearbeiten'>\n";  // Bearbeitungsbereich, für CSS-Markup.
       echo "<form name='frm_uv_edit.php' action='p_a_uv_save.php' method='POST' 
                   onsubmit='return js_fun_check_formpflicht(document.getElementById(\"spflicht\").value)' />\n";
       echo "<fieldset id='prahmen' acceskey='F'>\n";
       
    }
    else
    {
       // Anzeigemodus:
       // -------------
       echo $strHTMLClose; // Link zum Schließen des Fensters

       echo "<div id='puvanzeige'>\n";  // Anzeigebereich, für CSS-Markup.
       echo "<table width='640'>\n";
       echo "<tr>\n";
       echo "<th colspan='2'>Unterichtsvorhaben</th>\n";
       echo "</tr>\n";
       $strZeileClass="pzeile2";
    } // Anzeige oder Bearbeitungsmodus? 


    // Schleife durch alle Felder 
    $strPflichtfeldIDs='';
    foreach ($arrFld as $strAtt => $arrFldInfo)
    {
      if (($boolBearb) and ($strAtt == 'beginn_kw') and (!$boolNeuUV))
      {
        // Schaltfläche zum Zurücksetzen des UV:
        echo "<br /><input type='button' value='Unterrichtsvorhaben zurücksetzen' 
                           onclick='document.getElementById(\"s_beginn_kw\").value=\"\";document.getElementById(\"s_ende_kw\").value=\"\";'/><br />\n";
      } // Vor Kalenderwoche und nicht-neues UV?
      
      $strWert=(isset($arrUVDaten[$strAtt])) ? $arrUVDaten[$strAtt] : '' ;
      $strLabel=$arrFldInfo['lbl'];
      $strFeldTitel=$strLabel;
      $strZusatz=(empty($arrFldInfo['zus'])) ? '' : $arrFldInfo['zus'];

      if ($boolBearb)
      {
         // Bearbeitungsfelder:
         // -------------------
         $boolTextFeld=(!empty($arrFldInfo['textfeld_id'])); // Freies Textfeld aus Sondertabelle?
         $strTag="s_" . (($boolTextFeld) ? $arrFldInfo['textfeld_id'] : $strAtt); // Bei freien Textfeldern wird die ID verwendet.
         if ($boolNeuUV)
         {
           $strWert=ut_get_webpar($strTag);   // Wenn neuer Datensatz, können Daten als Parameter übergeben werden (Fach, ...)
         }  
         if ($boolTextFeld)
         {
           $strDatTyp='string';
           $numDatLen=(empty($arrFldInfo['feldlaenge'])) ? 200 : $arrFldInfo['feldlaenge'];
           if (!empty($arrFldInfo['pflichtfeld']))
           {
             $strLabel .= " <em>(Pflichtfeld!)</em>";
             $strPflichtfeldIDs .= "," . $strTag;
           }  
         }
         else
         {
           $strDatTyp=$arrDT[$strAtt]['TYP'];
           $numDatLen=$arrDT[$strAtt]['LEN'];
         } // IF: Freies Textfeld oder aus Stammtabelle?
         
         echo "<label for='$strTag'>$strLabel</label>";
         if ($strAtt=='fach_id')
         {
           // Fach nicht änderbar, da nur aktuelles Fach bearbeitbar:
           $strFachBearbBez=db_get_value('fach',$strGtabKatFach,"(fach_id=$numFachBearb)",$boolDEBUG);
           echo "$strFachBearbBez<br />\n";  
         }  
         elseif ($strAtt=='zeitbedarf_wochen')
         {
           // Zeitbedarf in Wochen wird ausgerechnet:
           $numBeginnWo=(empty($arrUVDaten['beginn_kw'])) ? 0 : $arrUVDaten['beginn_kw'];
           $numEndeWo=(empty($arrUVDaten['ende_kw'])) ? 0 : $arrUVDaten['ende_kw'];
           $numEndeWo=(($numEndeWo > 0) and ($numEndeWo < $numBeginnWo)) ? ($numEndeWo + 52) : $numEndeWo;
           $numZeitBedWo=(($numEndeWo > 0) and ($numBeginnWo > 0)) ? ($numEndeWo - $numBeginnWo + 1) : '';
           echo "$numZeitBedWo<br />\n";  
         }  
         elseif (isset($arrFldInfo['sel']))
         {
            if (($strAtt=='schulform_id') and ($strWert=='') and (!empty($_SESSION['p_auswahl']['nschulform'])))
            {
              $strWert=$_SESSION['p_auswahl']['nschulform'];
            } // Schulform aus Session übernehmen  
            $strSelectliste=p_frm_selectliste($arrFldInfo['sel'],'S',$strWert,$strTag);
            echo $strSelectliste;
            echo "<br />\n";
         } // IF: Select-Wert aus Werteliste?   
         elseif ($numDatLen > 60)
         {
           $strWertF=p_html2ascii($strWert);    // ASCII-Formatierter Text
           $numRows=round($numDatLen / 60,0) + 2;
           echo "<br />\n";
           echo "<textarea name='$strTag' id='$strTag' cols='75' rows='$numRows' title='$strFeldTitel'>$strWertF</textarea>\n";
           echo "<br /><span class='pformatierungsoptionen'>$strGConfFormatierungsoptionen</span><br /><br />\n";
         }
         else
         {
           $strMaxLen=($numDatLen > 0) ? " maxlength='$numDatLen' " : '';
           $numBreite=min(20,$numDatLen);
           echo "<input type='text' name='$strTag' id='$strTag' value='$strWert' size='$numBreite' $strMaxLen/>$strZusatz\n"; 
           echo "<br />\n";
         } // IF: Textarea oder Input-Feld?  
      }
      else
      {
         // Nur Anzeige in Tabelle:
         // -------------------
         $strZeileClass = ($strZeileClass=="pzeile2") ? "pzeile1" : "pzeile2";
         echo "<tr class='$strZeileClass'>";
         echo "<td class='pzeilentitel'>$strLabel</td>\n";
         if (isset($arrFldInfo['sel']))
         {
            $strWert=p_frm_selectliste($arrFldInfo['sel'],'A',$strWert,'');
         } // IF: Select-Wert aus Werteliste?   
         
         
         if (($strSuchbegriff != '') and (stripos($strWert,$strSuchbegriff) !== false))
         {
           $strWert=str_ireplace($strSuchbegriff,"<span class='psuchtreffer'>" . strtoupper($strSuchbegriff) . "</span>",$strWert);
         } // IF: Suchbegriff farbig hervorheben?  

         // Ggf. URLs anzeigen:
         $strWert=p_url_to_hyperlink($strWert);

         echo "<td>$strWert" . $strZusatz . "</td>";
         echo "</tr>\n";
      } 
    } // FOR-Schleife durch alle Felder.  

    if ($boolBearb)
    {
       // Im Bearbeitungsmodus Formular schließen:
       // ---------------------------------------
       echo "<br /><br />\n";
       echo "<input type='hidden' name='nuvid' id='nuvid' value='$numUVID' />\n"; // ID weitergeben.
       echo "<input type='hidden' name='spflicht' id='spflicht' value='" . substr($strPflichtfeldIDs,1) . "' />\n"; // Pflichtfelder
       echo "<input type='submit' value='Speichern' />\n";
       if (!$boolNeuUV)
       {
         // FEHLT NOCH echo "<input name='delete' type='submit' value=' Unwiderruflich Löschen ' onclick='return confirm('Wirklich löschen?')' />\n";
         echo "<input type='submit' value='Als Kopie speichern' onclick='document.getElementById(\"nuvid\").name=\"nneu\";document.getElementById(\"nuvid\").value=\"1\";' />\n";
       }  
       else
       {
         echo "<input type='hidden' name='nneu' id='nneu' value='1' />\n"; // weitergeben, ob neuer Datensatz
       } // IF: Neues UV?       
       echo "<input name='abort' type='button' value=' Abbrechen ' onclick='window.close();' />\n";
       echo "</fieldset>\n";
       echo "</form>\n";
    }
    else
    {
       // Anzeigemodus:
       // -------------
       if (($boolFV) and ($numNurLese != 1))
       {
          $strZeileClass = ($strZeileClass=="pzeile2") ? "pzeile1" : "pzeile2";
          echo "<tr class='$strZeileClass'>";
          echo "<td class='pzeilentitel'>Daten bearbeiten?</td>\n";
          echo "<td><a href='p_a_uv_show.php?nuvid=$numUVID&nbearbeiten=1'>" .
                "<img src='images/edit.gif' width='15' height='15' alt='Bearbeiten' title='Bearbeiten' border='0' /></a></td>";
          echo "</tr>\n";
       } // IF: Bearbeitungsrechte?
       echo "</table>\n";
       echo $strHTMLClose; // Link zum Schließen des Fensters

    } // Anzeige oder Bearbeitungsmodus? 
    
    echo "</div>\n";  // puvbearbeiten bzw. puvanzeige
    
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
  //include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
  echo "   </div> <!-- pcontainer --> \n";
  echo "  </div> <!-- pinhalt --> \n";
  echo " </body>\n";
  echo "</html>\n";
  
  // -----------------------------------------------------
  // Ende PHP.
?>
