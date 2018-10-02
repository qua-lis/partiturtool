<?php
  // p_ut_allgemein.inc.php
  // Allgemeine Util-Funktionen (Einlesen und prüfen von Parametern, ...).
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // Alle speziellen Funktionen des Projekts sollten mit
  //   p_ beginnen, um sie gleich zu finden.
  // 
  // 
  // Funktionen:
  //
  //  * Spezielle p (Partituren)
  //    p_session_start()
  //    p_status_info()
  //    p_session_neu()
  //    p_log($numLogAktion,$strAktionPar='')
  //    p_check_fv($boolExit=true)
  //    p_check_lehrkraft($boolExit=true)
  //    p_check_adm($boolExit=true)
  //    p_cb_array_key_cmp($a,$b)
  //    p_ascii2html($strText) 
  //    p_html2ascii($strText) 
  //    p_zeilenumbruecheraus ($strText) 
  //    p_felder_uv($numUVID)
  //    p_frm_selectliste($arrSelect,$strModus='A',$numAktWert='',$strTagID='',$boolLeerWert=false)
  //    p_frm_auswahlspalte($strTitel,$strTagPrefix,$strInputClass,$arrAuswahlTab,$arrVorauswahl,$strLabelBearb,$strIDBearb)
  //    p_frm_auswahlform($arrVorauswahl,$numFachBearb=0)
  //    p_read_auswahl($strTagPrefix,$arrAuswahlTab,$strIDBearb,$strFehlerCodeMissing,$boolPruefAnzahl=false)
  //    p_read_auswahlform()
  //    p_dbread_uv($numSF_ID,$strCond,$boolBearb=false,$arrPlanIDs=array())
  //    p_erzeuge_plan($arrUV,$arrKataloge,$boolBearb=false,$arrPlanIDs=array())
  //    p_erzeuge_id($strTab,$strIDAtt,$arrNotNullDef=array())
  //    p_sperre_bearb($strModus='F',$boolFachV=true,$boolFehlerseite=false,$numFachId='')
  //    p_fv_fach()
  //    p_berechne_uv_pos($numBeginnWo,$numEndeWo,$arrUVDaten)
  //    p_url_to_hyperlink($strText)
  //    p_adm_check_sperren()
  //    p_read_katalog($strKatTyp)
  //
  //  * Allgemeine ut (UTil)
  //    ut_get_webpar($strParamName)
  //    ut_get_webpar_def($strParamName,$strDefaultWert)
  //    ut_get_webpar_n($strParamName)
  //    ut_get_webpar_n_def($strParamName,$numDefaultWert)
  //    ut_get_webpar_arr($strParamName)
  //    ut_loadAvg()
  //    ut_check_php_version ($version)
  //    ut_printr_dbg($arrObj,$strLabel='',$boolDirektDebug=false)
  //
  // fh, 15-DEC-2011.
  // lr. fh, 20-DEC-2011, p_session_start, p_session_neu, ut_printr_dbg.
  // lr: fh, 11-JAN-2011, weitere Funktionen.
  // lr: fh, 19-JAN-2011, Erweiterungen.
  // lr: fh, 02-FEB-2012, Ergänzung einiger Funktionen zum Aufbau des Plans.
  // lr: ks, 07-MAR-2012, Markup, Design geändert, Klassen ergänzt  
  // lr: fh, 27-MAR-2012, p_check_adm, p_erzeuge_id. Konsoldierung der verschiedenen Layout-Ansätze.
  // lr: fh, 29-MAR-2012, p_erzeuge_plan: Einarbeitung der Änderungen von C.Peters. Weitere Optimierungen.
  // lr: fh, 12-APR-2012, p_erzeuge_plan geändert. p_sperre_bearb neu.
  // lr: fh, 14-APR-2012, p_erzeuge_plan geändert.
  // lr: fh, 26-APR-2012, p_erzeuge_plan geändert.
  // lr: fh, 02-JUL-2012, p_erzeuge_plan geändert (Zeilentitel, Lösch-Link).
  // lr: fh, 31-OCT-2012, p_erzeuge_plan (Link zur Bearbeitungs-Aktivierung) ergänzt.
  // lr: fh, 17-DEC-2012, p_ascii2html korrigiert.
  // lr: fh, 19-AUG-2013, p_frm_selectliste,p_sperre_bearb,p_check_fv angepasst,p_frm_auswahlform. p_fv_fach neu.
  // lr: fh, 14-SEP-2013, p_frm_auswahlform angepasst.
  // lr: fh, 20-SEP-2013, p_felder_uv angepasst. p_berechne_uv_pos, p_url_to_hyperlink neu.
  // lr: fh, 29-SEP-2013, p_adm_check_sperren neu.
  // lr: fh, 30-SEP-2013, p_check_lehrkraft neu, p_dbread_uv, p_felder_uv angepasst.
  // lr: fh, 02-OCT-2013, p_erzeuge_plan angepasst.
  // lr: fh, 22-OCT-2013, p_erzeuge_plan angepasst.
  // lr: fh, 06-NOV-2013, p_read_katalog.
  // lr: fh, 10-NOV-2013, p_erzeuge_plan angepasst.
  // lr: fh, 24-NOV-2013, p_status_info angepasst (Login-Name), p_cb_array_key_cmp, p_erzeuge_plan (Sortierung).
  // -------------------------------------------------------------
  

// ----------------------------------------------
// Projekt-spezifische Funktionen p_ (Partituren)
// -----------------------------------------------

// Newline-Konstante für ut_SendMail und ut_TextEncode:
define("XNL","\r\n") ; // CONSTANT Newline CR

$varGSortKrit=array();  // Globale Variablen,
$varGFirstKey='';
// -------------------------------------------

function p_session_start()
{
  // Start-Ablaufzeit der aktuellen Session wird einmalig initialisiert. 
  //
  // fh, 20-DEC-2011.

  global $strGSessionName;

  // Um NOTICE-Meldungen bei neueren PHP-Versionen zu verhindern, wird Existenz von Session geprueft.
  if (!isset($_SESSION['p_session_ende']))
  {
    session_name($strGSessionName);
    session_start();
  }  
  
  // Ende: p_session_start.
}

// -------------------------------------------

function p_session_neu()
{
  // Wird nur zu Beginn einer neuen Session gleich nach dem Einloggen aufgerufen.
  // Setzt Start-Ablaufzeit der aktuellen Session. 
  //
  // fh, 20-DEC-2011.

  global $strGSessionName;
  global $intGSessionTimeout;

  session_name($strGSessionName);
  session_start();
  $_SESSION['p_session_ende']=time() + $intGSessionTimeout * 60;
  
  // Ende: p_session_neu.
}

// ---------------------------------------------------

function p_status_info()
{
  // Prüft, ob eine Session besteht und gibt den Anmeldestatus
  // sowie ggf. aktuelle Daten der Session zurück.
  //
  //
  // Parameter:
  //  keine bisher
  // 
  // Rückgabewert:
  //  Aktueller Status (angemeldet als ...), wenn angemeldet, sonst Nicht-angemeldet-Status.
  //      
  //
  // lr: fh, 15-DEC-2011.
  // lr: fh, 11-JAN-2012.
  // lr: fh, 29-MAR-2012, Link zur Start-Auswahl.
  // cp, 15-OCT-2012
  // lr: fh, 30-SEP-2013, $arrGLoginTypKonf.
  // lr: fh, 24-NOV-2013, Login-Name ergänzt
  
  // Zuordnung der LoginTyp-Bezeichnung und der jeweiligen Auswahlseite:
  global $arrGLoginTypKonf;
  
  $strStatus="";
  
  $strLoginTypKuerzel=(empty($_SESSION['p_logintyp'])) ? '' : $_SESSION['p_logintyp'];
  $strLoginName=(empty($_SESSION['p_username']))  ? '' : ("<br />" . $_SESSION['p_username']);

  $strStart = " <a href='p_a_start.php'>Startseite</a>"; 
  
  if ($strLoginTypKuerzel == '')
  {
    $strStatus="<ul><li><strong>Nicht angemeldet</strong></li><li>$strStart</li>\n";
  }
  else
  {
    $strLoginTypBez=$arrGLoginTypKonf[$strLoginTypKuerzel][0];
    $strStatus = "<ul><li><strong>Sie sind angemeldet als $strLoginTypBez $strLoginName</strong></li><li>$strStart</li>\n";
    $strStatus .= "<li><a href='" . $arrGLoginTypKonf[$strLoginTypKuerzel][1] . "'>Funktionsauswahl</a></li>\n"; 
    $strStatus .= "<li><a href='p_a_logout.php'>Abmelden</a></li></ul>"; 
  } // IF: Angemeldet?

  
  return ($strStatus);
  
 } // Ende p_status_info.  
  
  
// ---------------------------------------------------

function p_log($numLogAktion,$strAktionPar='')
{
  // Protokolliert Zugriff in Log-Tabelle.
  // Ob überhaupt und was protokolliert wird, wird in der
  // globalen Variablen  $numGLogLevel (0: kein Logging, 5 alles wird mitgeloggt) festgelegt.
  //
  // Parameter:
  //  $numLogAktion   Aktionscode, der auch den Mindestlog-Level angibt.
  //  $strAktionPar   optionaler Parameter, der in Log-Tabelle protokolliert wird.
  // 
  // fh, 20-DEC_2011.

  global $numGLogLevel;
  global $strGtabSysLog;
  global $arrGLogAkt;   // Array der vorgesehenen Log-Aktionen.
  global $boolDEBUG;
  
  if (isset($arrGLogAkt[$numLogAktion]))
  {
    $numAktLogLevel=$arrGLogAkt[$numLogAktion][0];
  }
  else
  {
    $numAktLogLevel=0; // Wenn unbekannt, Level auf 0 setzen.
  } // IF: Vorgesehene Log-Aktion?
  
  if ($numGLogLevel >= $numAktLogLevel)
  {
    // Nur Protokollieren, wenn gewünschtem Loglevel entsprechend:
    $strSessionID=(empty($_SESSION['p_session_id'])) ? '-' : $_SESSION['p_session_id'];
    $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
    $strLoginTypKuerzel=(empty($_SESSION['p_logintyp'])) ? '-' : $_SESSION['p_logintyp'];
    $strBrowser=substr($_SERVER['HTTP_USER_AGENT'],0,100);
    $strIPAdr=substr($_SERVER['REMOTE_ADDR'],0,15);
    $strLogParam=(empty($strAktionPar)) ? "NULL" : "'" . substr($strAktionPar,0,100) . "'";
    
    $strSQL="INSERT INTO $strGtabSysLog 
                         (sessionid,user_id,anmeldetyp,aktion_code,browser,ipadresse,logparam)
                  VALUES ('$strSessionID',$numUserID,'$strLoginTypKuerzel',$numLogAktion,
                          '$strBrowser','$strIPAdr',$strLogParam)";  
    db_exec($strSQL,$boolDEBUG);                       
                          
  } //IF: Soll Aktion protokolliert werden?  

} // Ende p_log

// ---------------------------------------------------

function p_check_fv($boolExit=true)
{
  // Prüfung, ob als Fachverwalter/in angemeldet.
  //
  // Parameter:
  //    $boolExit   wenn true, wird auf Fehlerseite verzweigt, sonst nur true/false zurückgegeben.
  //
  // Rückgabewert:
  //  true, wenn Zugriffsrechte bestehen, sonst wird zu einer Fehlermeldungsseite verzweigt.
  //
  // fh, 11-JAN-2012.
  // lr: fh, 19-JAN-2012, $boolExit ergänzt.
  // lr: fh, 19-AUG-2013, nur noch true zurückgeben, wenn tatsächlich Fachverwalter, nicht als Admin!

  $boolFW=false;
  
  // Entweder Fachverwalter/in oder Admin:
  $boolFW=( (!empty($_SESSION['p_logintyp'])) and ($_SESSION['p_logintyp']=='F'));
  //         and (($_SESSION['p_logintyp']=='F') or ($_SESSION['p_logintyp']=='A')));
         
  if ((!$boolFW) and ($boolExit))
  {
    // Keine ausreichende Zugriffsrechte, daher auf Hinweisseite verzweigen:
    header("location: p_a_zugriffsfehler.php");
    exit;
  } // IF: Zugriffsrechte vorhanden?  
  
  return($boolFW); // Ergebnis zurückgeben (nur relevant, wenn $boolExit = false).
  
  // Ende: p_check_fv.
}

// ---------------------------------------------------

function p_check_lehrkraft($boolExit=true)
{
  // Prüfung, ob mindestens als Lehrkraft angemeldet (Fachverwalter/in und Admin geht auch).
  //
  // Parameter:
  //    $boolExit   wenn true, wird auf Fehlerseite verzweigt, sonst nur true/false zurückgegeben.
  //
  // Rückgabewert:
  //  true, wenn Zugriffsrechte bestehen, sonst wird zu einer Fehlermeldungsseite verzweigt, wenn $boolExit true.
  //
  // fh, 30-SEP-2013.

  $boolLk=false;
  
  // Entweder Lehrkraft, Fachverwalter/in oder Admin:
  $boolLk=( (!empty($_SESSION['p_logintyp'])) and (in_array($_SESSION['p_logintyp'],array('L','F','A'))));
         
  if ((!$boolLk) and ($boolExit))
  {
    // Keine ausreichende Zugriffsrechte, daher auf Hinweisseite verzweigen:
    header("location: p_a_zugriffsfehler.php");
    exit;
  } // IF: Zugriffsrechte vorhanden?  
  
  return($boolLk); // Ergebnis zurückgeben (nur relevant, wenn $boolExit = false).
  
  // Ende: p_check_lehrkraft.
}

// ---------------------------------------------------

function p_check_adm($boolExit=true)
{
  // Prüfung, ob als Admin angemeldet.
  //
  // Parameter:
  //    $boolExit   wenn true, wird auf Fehlerseite verzweigt, sonst nur true/false zurückgegeben.
  //
  // Rückgabewert:
  //  true, wenn Zugriffsrechte bestehen, sonst wird zu einer Fehlermeldungsseite verzweigt.
  //
  // fh, 27-MAR-2012.

  $boolAdm=false;
  
  // Admin?
  $boolAdm=(    (!empty($_SESSION['p_logintyp'])) and ($_SESSION['p_logintyp']=='A'));
         
  if ((!$boolAdm) and ($boolExit))
  {
    // Keine ausreichende Zugriffsrechte, daher auf Hinweisseite verzweigen:
    header("location: p_a_zugriffsfehler.php");
    exit;
  } // IF: Zugriffsrechte vorhanden?  
  
  return($boolAdm); // Ergebnis zurückgeben (nur relevant, wenn $boolExit = false).
  
  // Ende: p_check_adm.
}


// ---------------------------------------------------

function p_cb_array_key_cmp($a,$b)
{
  // Callback-Funktion, die zum Sortieren von Arrays mit uksort eingesetzt werden kann.
  // uksort sortiert ein Array nach den Schlüsseln.
  // Hier ist die Besonderheit, dass mit der globalen Variable $varGFirstKey 
  // der Schlüssel übermittelt wird, der immer ganz nach vorne sortiert werden soll.
  //
  // Parameter:
  //    $a,$b   - die beiden zu vergleichenden Schlüssel
  //
  // Rückgabewert:
  //  $numCmp   0, wenn gleich, -1, wenn $a kleiner als $b, +1 sonst
  //
  // fh, 11-JAN-2012.
  // lr: fh, 02-FEB-2012, Korrektur, um auch 0 zu berücksichtigen.
  // lr: fh, 14-SEP-2013, Wenn globales Sortier-Array $varGSortKrit definiert ist, dieses zur Sortierung nehmen.
  // lr: fh, 24-NOV-2013, kleine Korrektur.

  global $varGFirstKey;
  global $varGSortKrit;
  
  $numCmp=0;
  
  if (!empty($varGFirstKey))
  {
    // Abgleich mit Start-Schlüssel:
    if ($a == $varGFirstKey)
    {
      $numCmp = -1;
    }
    elseif ($b == $varGFirstKey)
    {
      $numCmp = 1;
    }
    else
    {
      if ((isset($varGSortKrit)) and (count($varGSortKrit) > 0))
      {
        // Sortierarray zum Abgleich nehmen:
        $numCmp=($varGSortKrit[0][$a][$varGSortKrit[1]] < $varGSortKrit[0][$b][$varGSortKrit[1]]) ? -1 
                 : (($varGSortKrit[0][$a][$varGSortKrit[1]] > $varGSortKrit[0][$b][$varGSortKrit[1]]) ? 1 : 0);
      }
      else
      {
        $numCmp=($a < $b) ? -1 : (($a > $b) ? 1 : 0);
      } // IF: Sortier-Array?  
    }
  }
  else
  {
    // Kein Start-Schlüssel definiert:
    if ((isset($varGSortKrit)) and (count($varGSortKrit) > 0) and (isset($varGSortKrit[0][$a])) and (isset($varGSortKrit[0][$b])))
    {
      // Sortierarray zum Abgleich nehmen:
      $numCmp=($varGSortKrit[0][$a][$varGSortKrit[1]] < $varGSortKrit[0][$b][$varGSortKrit[1]]) ? -1 
               : (($varGSortKrit[0][$a][$varGSortKrit[1]] > $varGSortKrit[0][$b][$varGSortKrit[1]]) ? 1 : 0);
    }
    else
    {
      $numCmp=($a < $b) ? -1 : (($a > $b) ? 1 : 0);
    } // IF: Sortier-Array?  
  }
  return ($numCmp);

  // Ende: p_cb_array_key_cmp.
}


// ---------------------------------------------------

function p_ascii2html($strText) 
{
  // Hilfsfunktion, übernommen aus Partituren-Prototyp.
  // wandelt cr/lf-Sequenzen in html <br /> um.
  // wandelt proprietäre ASCII-Formate # kursiv, ## fett,  ### unterstrichen, *** Übershrift --Listenpunkt in HTML_Pendants um.
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // 
  //
  // Parameter:
  //    $strText    ASCII-Text mit festgelegten Formatierungszeichen
  //
  // Rückgabewert:
  //  $strTextneu   Text, in dem Formatierungszeichen in HTML-Formatierung umgesetzt wurde.
  //

  $strTextneu = $strText;
  // Überschrift h3
  $strTextneu = preg_replace('/\*\*\*(.*?)\*\*\*/','<h6>$1</h6>',$strTextneu);
  // Unterstreichungen, farbig, fett, kursiv  ###  ##  #
  $strTextneu = preg_replace('/###(.*?)###/','<u>$1</u>',$strTextneu);
  $strTextneu = preg_replace('/\*\*(.*?)\*\*/','<span class=\"pfarbighervorgehoben\">$1</span>',$strTextneu);
  $strTextneu = preg_replace('/##(.*?)##/','<b>$1</b>',$strTextneu);
  $strTextneu = preg_replace('/#(.*?)#/','<em>$1</em>',$strTextneu);
  // Listenpunkt --
  $strTextneu = preg_replace('/-- (.*?)(\\n|\\z)/','<ul><li>$1</li></ul>', $strTextneu);
  $strTextneu = preg_replace('/<\/ul>(.*?)<ul>/','$1',$strTextneu); // aufeinanderfolgende <ul>-Tags raus
  // Zeilenumbrüche nach html codieren
  $strTextneu = nl2br($strTextneu);

  return ($strTextneu);
  
  // Ende p_ascii2html
}

// ---------------------------------------------------

function p_html2ascii($strText) 
{
  // Hilfsfunktion, übernommen aus Partituren-Prototyp.
  // wandelt html <br /> bzw. <br> bzw. <br/> in cr/lf-Sequenzen um.
  // wandelt html-Tags h<x>, <b>, <em>, <u> wieder in die proprietäre ASCII-Codierung um.
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // 
  //
  // Parameter:
  //    $strText    Text, ggf. mit HTML-Formatierungen
  //
  // Rückgabewert:
  //  $strTextneu   ASCII-Text mit festgelegten Formatierungszeichen 
  //
  // lr: fh, 17-DEC-2012, Erweiterung damit abgeschnittene Tags nicht unauswertbar werden.
  
  $strTextneu = $strText;
  $strTextneu=str_replace('<br />','',$strTextneu);
  $strTextneu=str_replace('<br/>','',$strTextneu);
  $strTextneu=str_replace('<br>','',$strTextneu);
  $strTextneu=preg_replace('/<h\d>(.*?)<\/h\d>/', '***$1***', $strTextneu);
  $strTextneu=preg_replace('/<u>(.*?)<\/u>/', '###$1###', $strTextneu);
  $strTextneu=preg_replace('/<span class=\"farbig_hervorgehoben\">(.*?)<\/span>/', '**$1**', $strTextneu);
  $strTextneu=preg_replace('/<b>(.*?)<\/b>/', '##$1##', $strTextneu);
  $strTextneu=preg_replace('/<em>(.*?)<\/em>/', '#$1#', $strTextneu);
  // <ul> entfernen
  $strTextneu=preg_replace('/<ul>(.*?)<\/ul>/', '$1', $strTextneu);
  // <li>-Tag 2. Ordnung --> **Listenpunkt
  $strTextneu=preg_replace('/<li><li>(.*?)<\/li><\/li>/', '** $1', $strTextneu);
  // <li>-Tag --> --Listenpunkt
  $strTextneu=preg_replace('/<li>(.*?)<\/li>/', '-- $1', $strTextneu);

  // CID:fh121217:Überzählige <ul> löschen:
  $strTextneu=str_replace('<ul>','', $strTextneu);
  $strTextneu=str_replace('</ul>','', $strTextneu);
  // Überzählige <li> umwandeln:
  $strTextneu=str_replace('<li>','-- ', $strTextneu);
  // Überzählige </li> löschen:
  $strTextneu=str_replace('</li>','', $strTextneu);

  return ($strTextneu);
  
  // Ende p_html2ascii
}

// ---------------------------------------------------

function p_zeilenumbruecheraus ($strText) 
{
  // Hilfsfunktion, übernommen aus Partituren-Prototyp.
  // entfernt alle Zeilenumbrüche.
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // 
  //
  // Parameter:
  //    $strText    Text, ggf. mit (HTML-)-Zeilenumrbüchen
  //
  // Rückgabewert:
  //  $strTextneu   Text ohne Zeilenumrüche
  //

  $strTextneu = $strText;
  $strTextneu=str_replace('<br />','',$strTextneu);
  $strTextneu=str_replace('<br/>','',$strTextneu);
  $strTextneu=str_replace('<br>','',$strTextneu);
  $strTextneu=str_replace('\n','',$strTextneu);
  return ($strTextneu);
  
  // Ende p_zeilenumbruecheraus
}

// ---------------------------------------------------

function p_felder_uv($numUVID)
{
  // Liest die Feld-Konfigurationen und aktuelle Daten für ein Unterrichtsvorhaben aus.
  // Dies wird für die Anzeige und Bearbeitung eines Unterrichtsvorhabens genutzt.
  //
  // Parameter:
  //  $numUVID        ID des Unterrichtsvorhabens.
  // 
  // fh, 19-JAN-2012.
  // lr: fh, 20-SEP-2013, Eigenschaft ro für Read-Only ergänzt.
  // lr: fh, 30-SEP-2013, berücksichtigen, dass einige Felder nur für Lehrkräfte sichtbar sind (nicht für alle).

  global $boolDEBUG;
  global $strGtabKfgUVTextfelder;
  global $strGtabEinUnterrichtsvorhaben;
  global $strGtabEinUVTextfelder;
  global $strGtabKatSchulform;
  global $strGtabKatFach;
  global $strGtabKatStufe;
  global $strGtabKatZug;
  global $strGtabKatKursart;
  
  
  // Definition der Felder:
  // -----------------------------------
  // Parameter:
  //  lbl - Beschriftung
  //  srt - interne Sortiernummer
  //  zus - (optional) Zusatz zum Inhalt (Einheit wie KW etc.)
  //  sel - (optional) Definition zur Erstellung einer Select-Liste
  //      Indizes: ID-Feld, Anzeige-Feld, Katalogtabelle
  //  ro  - (optional) Read-Only (1/0)
  $arrFld['uv_titel']=array('lbl'=>'Thema','srt'=>10);
  $arrFld['zeitbedarf_std']=array('lbl'=>'Zeitbedarf in Stunden','srt'=>30,'zus'=>' Stunde(n)');
  $arrFld['beginn_kw']=array('lbl'=>'Kalenderwoche: Beginn','srt'=>35,'zus'=>'. KW');
  $arrFld['ende_kw']=array('lbl'=>'Kalenderwoche: Ende','srt'=>40,'zus'=>'. KW');
  $arrFld['zeitbedarf_wochen']=array('lbl'=>'Zeitbedarf in Wochen','srt'=>45,'zus'=>' Woche(n)','ro'=>1);
  
  $arrFld['schulform_id']=array('lbl'=>'Schulform','srt'=>900,
         'sel'=>array('schulform_id','schulform',$strGtabKatSchulform));
  $arrFld['fach_id']=array('lbl'=>'Fach','srt'=>905,
         'sel'=>array('fach_id','fach',$strGtabKatFach),'ro'=>1);
  $arrFld['stufe_id']=array('lbl'=>'Stufe','srt'=>910,
         'sel'=>array('stufe_id','stufe',$strGtabKatStufe));
  $arrFld['kursart_id']=array('lbl'=>'Kursart','srt'=>915,
         'sel'=>array('kursart_id','kursart',$strGtabKatKursart));
  $arrFld['zug_id']=array('lbl'=>'Zug','srt'=>920,
         'sel'=>array('zug_id','zug',$strGtabKatZug));

  // Übrige (Text-)Felder werden direkt in der Datenbank verwaltet:
  $boolLk=p_check_lehrkraft(false);    // Prüfen, ob mindestens als Lehrkraft angemeldet.
  $strSQL="SELECT textfeld_id,textfeld,
                  textfeld_label as lbl,
                  textfeld_beschreibung,textfeld_bem,feldlaenge,
                  pflichtfeld,plananzeige,nur_lehrkraefte,
                  reihenfolge as srt
             FROM $strGtabKfgUVTextfelder
             ORDER BY reihenfolge";
  $stmtSQL = db_exec($strSQL,$boolDEBUG); 
  while (db_fetch_arr($stmtSQL,$arrSQL))
  {
    if (($boolLk) or (empty($arrSQL['nur_lehrkraefte'])))
    {
      $strAtt=$arrSQL['textfeld'];
      $arrFld[$strAtt]=$arrSQL;
    } // IF: als Lehrkraft angemeldet oder Feld für alle sichtbar?    
  } // DB-Schleife durch die konfigurierbaren Textfelder  


  // Felder nach 'srt' sortieren:
  foreach ($arrFld as $strAtt => $FeldInfo) 
  {
    $arrSort[$strAtt]  = $FeldInfo['srt'];
  }
  array_multisort($arrSort, SORT_ASC, $arrFld);

  $arrDT=db_table_attribs($strGtabEinUnterrichtsvorhaben); // Datentypen und andere Attribut-Informationen in Array auslesen.  TYP, LEN, FLAGS 
  // -------------------------------
  // Daten aus der DB auslesen:
  // -------------------------------
  $arrUVDaten=array();
  $strSQL="SELECT * 
             FROM $strGtabEinUnterrichtsvorhaben AS tuv
            WHERE uv_id=$numUVID";
  $stmtSQL = db_exec($strSQL,$boolDEBUG); 
  db_fetch_arr($stmtSQL,$arrUVDaten);

  // Jetzt die Daten aus den zusätzlichen Textfeldern auslesen:
  $strSQL="SELECT DISTINCT tfk.textfeld,tfe.textfeld_id,tfe.uv_text,tfk.nur_lehrkraefte ,tfk.reihenfolge
             FROM $strGtabEinUVTextfelder AS tfe
            INNER JOIN $strGtabKfgUVTextfelder as tfk
               ON tfe.textfeld_id=tfk.textfeld_id
            WHERE tfe.uv_id=$numUVID
            ORDER BY tfk.reihenfolge";
  $stmtSQL = db_exec($strSQL,$boolDEBUG); 
  while (db_fetch_arr($stmtSQL,$arrSQL))
  {
    if (($boolLk) or (empty($arrSQL['nur_lehrkraefte'])))
    {
      $strAtt=$arrSQL['textfeld'];
      $arrUVDaten[$strAtt]=$arrSQL['uv_text'];
    } // IF: als Lehrkraft angemeldet oder Feld für alle sichtbar?  
  } // DB-Schleife durch die Inhalte der konfigurierbaren Textfelder  

  ut_printr_dbg($arrUVDaten,"UV:");  // DEBUG!
  // -------------------------------

  // Array aus Feldinfos, Daten und Datentypen zurückgeben:
  return (array($arrFld,$arrUVDaten,$arrDT));

  // Ende p_felder_uv
}

// ---------------------------------------------------

function p_frm_selectliste($arrSelect,$strModus='A',$numAktWert='',$strTagID='',$boolLeerWert=false)
{
  // Erzeugt wahlweise eine Selectliste (Modus S) oder 
  // zeigt den aktuellen Wert-Eintrag zu einer Select-Liste an.
  //
  // Parameter:
  //  $arrSelect      Array zur Definition einer Selectliste, siehe p_felder_uv
  //                  Indizes: ID-Feld, Anzeige-Feld, Katalogtabelle
  //  $strModus       (optional, default A) wenn A nur Anzeige des aktuellen Eintrags, S-Select-Liste
  //  $numAktWert     (optional) aktueller Wert
  //  $strTagID       (optional) Tag für Select-Liste (nur für Modus S relevant).
  //  $boolLeerWert   (optional) Soll Leerwert angeboten werden? (default: false).
  // 
  // fh, 19-JAN-2012
  // lr: fh, 19-AUG-2013, $boolLeerWert ergänzt.

  global $boolDEBUG;
  
  list($strIDFeld,$strAnzeigeFeld,$strTab)=$arrSelect;
  
  $strSelectErg='';
  
  if ($strModus=='A')
  {
    if ($numAktWert != '')
    {
      $strSelectErg=db_get_value($strAnzeigeFeld,$strTab,"$strIDFeld='$numAktWert'",$boolDEBUG);
    }// IF: Gibt es einen aktuellen Wert?
  }
  else
  {
    // Selectliste zum Bearbeiten erzeugen:
    $strSelectErg .= "<select name='$strTagID' id='$strTagID'>";
    if ($boolLeerWert)
    {
      $strSelectErg .=  "<option value=''></option>";
    } // IF: Soll Leerwert angeboten werden?
    
    // Werte aus der Datenbank entnehmen:
    $strSQL="SELECT DISTINCT $strIDFeld as idfeld,$strAnzeigeFeld as anzeigefeld
             FROM $strTab
             ORDER BY $strAnzeigeFeld";
    $stmtSQL = db_exec($strSQL,$boolDEBUG); 
    while (db_fetch_arr($stmtSQL,$arrSQL))
    {
      $strSelected=($arrSQL['idfeld'] == $numAktWert) ? " selected='selected' " : '';
      $strSelectErg .=  "<option value='" . $arrSQL['idfeld'] . "' $strSelected>" . 
                        $arrSQL['anzeigefeld'] . "</option>";
    } // DB-Schleife durch die Select-Liste
    $strSelectErg .= "</select>\n";
    
  }
  
  return ($strSelectErg); // Select-Ergebnis zurückgeben

  // Ende p_frm_selectliste
}

// ---------------------------------------------------

function p_frm_auswahlspalte($strTitel,$strTagPrefix,$strInputClass,$arrAuswahlTab,$arrVorauswahl,$strLabelBearb,$strIDBearb,$boolAlle=true,$boolRadio=false)
{
  // Erzeugt für ein Formular eine Auswahlspalte für Fächer, Kursarten etc.
  // zeigt den aktuellen Wert-Eintrag zu einer Select-Liste an.
  //
  // Parameter:
  //  $strTitel         Titel der Spalte
  //  $strTagPrefix     Präfix der Ids/Namen der Checkboxen
  //  $strInputClass    CSS-Klasse der Checkboxen
  //  $arrAuswahlTab    Array mit Parametern für die Datenbank-Abfrage der einzelnen Elemente
  //  $arrVorauswahl    Array mit Vorbelegungswerten der Parameter
  //  $strLabelBearb    Label für das Element Bearbeitungsauswahlzeile
  //  $strIDBearb       ID/Name des Bearbeitungsinputfeldes (im Allgemeinen $strTagPrefix . '_bearb')
  //  $boolAlle         (optional) wenn true, wird die Option "alle" zusätzlich angezeigt.
  //  $boolRadio        (optional) wenn true, Radio-Felder statt Checkboxen.
  //  
  // fh, 02-FEB-2012.
  // lr: fh, 20-SEP-2013, $boolAlle und $boolRadio zur Verwendung in Kopierauswahl.
  

  global $boolDEBUG;
  $strBearbFeld='';     // Feld zur Auswahl der Bearbeitungszeile.
  
  echo "<div class='pblocklinks'>\n";
  echo "<h3>$strTitel</h3>\n";
    
  $strBearbFeld .= "<div class='pblockauswahl'>"; // Variable zur Anzeige der Bearbeitungsoptionen.
  $strBearbFeld .= "<label for='$strIDBearb'>$strLabelBearb: </label> ";
  $strBearbFeld .= "<select name='$strIDBearb' id='$strIDBearb' />";

  $arrAktVorauswahl=(isset($arrVorauswahl[$strTagPrefix])) ? $arrVorauswahl[$strTagPrefix] : '';
  $numAktBearbVorauswahl=(isset($arrVorauswahl[$strIDBearb])) ? $arrVorauswahl[$strIDBearb] : '';

  if ($boolAlle)
  {
    $strTag=$strTagPrefix .'_X';
    $strChecked=(empty($arrAktVorauswahl)) ? " checked='checked' " : '';
    echo "<input type='checkbox' name='$strTag' id='$strTag' $strChecked value='1' />";
    echo "<label for='$strTag'>Alle $strTitel</label><br />\n";
  } // IF: Soll die Auswahl "alle" mit angeboten werden?  
  
  // Elemente der Abfrage aus $arrAuswahlTab zusammenstellen:
  list($strIDAtt,$strLabelAtt,$strAtts,$strTab,$strOrderBy)=
       array($arrAuswahlTab['idatt'],$arrAuswahlTab['labelatt'],$arrAuswahlTab['atts'],
             $arrAuswahlTab['tab'],$arrAuswahlTab['orderatts']);
  
  $strAtts=(empty($strAtts)) ? '' : ",$strAtts"; // Zusatzattribute sind optional.
  $strSQL="SELECT DISTINCT $strIDAtt, $strLabelAtt  $strAtts
                 FROM $strTab
                ORDER BY $strOrderBy"; 
  $stmtSQL = db_exec($strSQL,$boolDEBUG); 
  while (db_fetch_arr($stmtSQL,$arrSQL))
  {
    $numID=$arrSQL[$strIDAtt];
    $strTag=$strTagPrefix . '_' . $numID;
    $strChecked=((!empty($arrAktVorauswahl)) and (in_array($numID,$arrAktVorauswahl))) ? " checked='checked' " : '';
    if ($boolRadio)
    {
      // Optionsfeld statt Checkbox, dann einheitlicher Name $strTagPrefix, Wert $numID.
      echo "<input class='$strInputClass' type='radio' name='$strTagPrefix' id='$strTag' value='$numID' $strChecked />";
    }
    else
    {
      // Checkbox (Standard): 
      echo "<input class='$strInputClass' type='checkbox' name='$strTag' id='$strTag' value='1' $strChecked />";
    } // IF: Radio- oder Checkbox?   
    echo "<label for='$strTag'>" . $arrSQL[$strLabelAtt] . "</label><br />\n";

    $strSelected=((isset($numAktBearbVorauswahl)) and ($numAktBearbVorauswahl==$numID)) ? " selected='selected' " : '';
    $strBearbFeld .= "<option value='$numID' $strSelected>" . $arrSQL[$strLabelAtt] . "</option>";
       
  } // DB-Schleife durch die Elemente der Auswahlliste.           
  echo "</div>\n";
  $strBearbFeld .= "</select></div>\n";
  
  return ($strBearbFeld); // Den String für die Bearbeitungszeile zurückgeben.
  // Ende p_frm_auswahlspalte
}

// ---------------------------------------------------

function p_frm_auswahlform($arrVorauswahl,$numFachBearb=0)
{
  // Erzeugt das Auswahl-Formular zur Bestimmung der anzuzeigenden Unterrichtsvorhaben.
  //
  // Parameter:
  //  $arrVorauswahl    Array mit Vorbelegungswerten der Parameter
  //  $numFachBearb     (optional) Das Fach, das bearbeitet werden darf.
  // 
  // fh, 02-FEB-2012
  // lr: fh, 19-AUG-2013, $numFachBearb ergänzt, nur noch erlaubtes Fach bearbeitbar.
  // lr: fh, 14-SEP-2013, wenn $numFachBearb > 0, dann Auswahl zur Bearbeitung, Fach nicht zur Auswahl anzeigen.

  global $boolDEBUG;
  global $strGtabKatSchulform,$strGtabKatFach,$strGtabKatStufe,$strGtabKatZug,$strGtabKatKursart;
  
  
  $strBearbZeile='';  // Zeile mit Bearbeitungsoptionen.

  // Schulform:
  // ----------
  // Schulformen: Wenn nur eine vorhanden ist, wird hier keine zur Auswahl gestellt:
  $numSF=db_get_value("COUNT(*)",$strGtabKatSchulform,'',$boolDEBUG);
    
  if ($numSF > 1)
  {
     echo "<div class='pblocklinks'>\n";
     echo "<h3>Schulform</h3>\n";
      
     $boolChecked=false; 
     $strSQL="SELECT DISTINCT schulform_id,schulform,schulformkuerzel
                FROM $strGtabKatSchulform 
              ORDER BY schulform"; 
     $stmtSQL = db_exec($strSQL,$boolDEBUG); 
     while (db_fetch_arr($stmtSQL,$arrSQL))
     {
        $numSF_ID=$arrSQL['schulform_id'];
        $strTag='nschulform_' . $numSF_ID;
        $numWertVorauswahl=(isset($arrVorauswahl['nschulform'])) ? $arrVorauswahl['nschulform'] : '';
        if (($numSF_ID == $numWertVorauswahl) or ((!$boolChecked) and ($numWertVorauswahl == '')))
        {
          $strChecked=" checked='checked' ";
          $boolChecked=true;
        }
        else
        {
          $strChecked='';
        } // IF: Aktuellen Eintrag checken?  
        echo "<input type='radio' name='nschulform' id='$strTag' value='$numSF_ID' $strChecked />";
        echo "<label for='$strTag'>" . $arrSQL['schulform'] . "</label><br />\n";
         
     } // DB-Schleife durch die Schulformen.           
     echo "</div>\n";
   } // IF: Mehr als eine Schulform?

   // Fächer:
   // ----------
   $arrAuswahlTabFach=array('idatt'=>'fach_id','labelatt'=>'fach','atts'=>'fachkuerzel,fach_farbe,fachreihenfolge',
                            'tab'=>$strGtabKatFach,'orderatts'=>'fachreihenfolge,fach');

   if ($numFachBearb > 0)
   {
      // Als verstecktes Feld, das Fach zur Anzeige und zur Bearbeitung angeben:
      echo  "<input type='hidden' name='nfach_$numFachBearb' id='nfach_$numFachBearb' value='1'/>";
      $strBearbFeld = "<input type='hidden' name='nfach_bearb' id='nfach_bearb' value='$numFachBearb'/>";
      /* Auswahl nicht mehr erforderlich:
      // CID:fh130819:Es darf nur noch ein Fach bearbeitet werden:
      // $strBearbZeile .= p_frm_auswahlspalte('Fächer','nfach','pfachwahl',$arrAuswahlTabFach,$arrVorauswahl,'Fach','nfach_bearb');
      $strBearbFeld = "<div class='pblockauswahl'>"; // Variable zur Anzeige der Bearbeitungsoptionen.
      $strFachBearb=db_get_value('fach',$strGtabKatFach,"(fach_id=$numFachBearb)",$boolDEBUG);
      // $strBearbFeld .= "<label for='nfach_bearb'>Fach: </label>$strFachBearb";
      $strBearbFeld .= $strFachBearb;
      $strBearbFeld .= "<input type='hidden' name='nfach_bearb' id='nfach_bearb' value='$numFachBearb'/>";
      $strBearbFeld .= "</div>\n";
      */
      $strBearbZeile .= $strBearbFeld;
   }
   else
   {
     // Nur Auswahl zur Anzeige:
     p_frm_auswahlspalte('Fächer','nfach','pfachwahl',$arrAuswahlTabFach,$arrVorauswahl,'Fach','nfach_bearb');
   } // IF: bearbeitbares Fach angegeben?   

   // Jahrgangsstufen:
   // ----------------
   $arrAuswahlTabStufe=array('idatt'=>'stufe_id','labelatt'=>'stufe','atts'=>'',
                             'tab'=>$strGtabKatStufe,'orderatts'=>'CAST(stufe AS UNSIGNED)'); // numerische Sortierung
   // $strBearbZeile .= 
   p_frm_auswahlspalte('Stufen','nstufe','pstufenwahl',$arrAuswahlTabStufe,$arrVorauswahl,'Jahrgang','nstufe_bearb');

   // Züge/Klassen:
   // ----------------
   // Wenn nur maximal einer vorhanden ist, wird hier keine zur Auswahl gestellt:
   $numAnzZug=db_get_value("COUNT(*)",$strGtabKatZug,'',$boolDEBUG);
    
   if ($numAnzZug > 1)
   {
       $arrAuswahlTabZug=array('idatt'=>'zug_id','labelatt'=>'zug','atts'=>'','tab'=>$strGtabKatZug,'orderatts'=>'zug'); 
       // $strBearbZeile .= 
       p_frm_auswahlspalte('Züge/Klassen','nzug','pzugwahl',$arrAuswahlTabZug,$arrVorauswahl,'Zug/Klasse','nzug_bearb');
   }// IF: Mehr als ein Zug?  

   // Kursarten:
   // ----------------
   // Wenn nur maximal eine vorhanden ist, wird hier keine zur Auswahl gestellt:
   $numAnzKursart=db_get_value("COUNT(*)",$strGtabKatKursart,'',$boolDEBUG);
    
   if ($numAnzKursart > 1)
   {
      $arrAuswahlTabKurs=array('idatt'=>'kursart_id','labelatt'=>'kursart','atts'=>'kursart_bezeichnung','tab'=>$strGtabKatKursart,'orderatts'=>'kursart'); 
      // $strBearbZeile .= 
      p_frm_auswahlspalte('Kursarten','nkurs','pkurswahl',$arrAuswahlTabKurs,$arrVorauswahl,'Kursart','nkurs_bearb');
   }// IF: Mehr als ein Kursart?  

  return ($strBearbZeile); // Bearbeitungszeile als String zurückgeben.
  // Ende p_frm_auswahlform
}

// ---------------------------------------------------

function p_read_auswahl($strTagPrefix,$arrAuswahlTab,$strFehlerCodeMissing,$boolPruefAnzahl=false)
{
  // Liest Eingaben für ein Auswahlelement zum Aufbau des Plans ein.
  //
  // Parameter:
  //  $strTagPrefix           Präfix der Ids/Namen der Checkboxen
  //  $arrAuswahlTab          Array mit Parametern für die Datenbank-Abfrage der einzelnen Elemente
  //  $strFehlerCodeMissing   Fehlercode für fehlende Angabe
  //  $boolPruefAnzahl        (optional, default: false), wenn true, wird geprüft, ob überhaupt mehr als ein Element zur Auswahl steht.
  // 
  // Aus Parametern entfernt:
  //    $strIDBearb             ID/Name des Bearbeitungsinputfeldes (im Allgemeinen $strTagPrefix . '_bearb')
  // Aus Ausgabe entfernt: $numPlanID
  // 
  // fh, 02-FEB-2012
  // lr: fh, 14-SEP-2013, Bearbeitungsfelder sind nicht mehr erforderlich, da keine gesonderte Bearbeitungszeile ($strIDBearb, $numPlanID entfernt).

  global $boolDEBUG;
  $numFehler=0;
  $strFehlercode='';
  
  $strListe='';
  $strCond = '';
  $arrKat=array();
  $_SESSION['p_auswahl'][$strTagPrefix]=array();
    
  // $numPlanID=ut_get_webpar_n($strIDBearb); // Element, das bearbeitet werden soll.
  // $_SESSION['p_auswahl'][$strIDBearb]=$numPlanID; // in Session merken für Vorauswahl:

  // Elemente der Abfrage aus $arrAuswahlTab zusammenstellen:
  list($strIDAtt,$strLabelAtt,$strAtts,$strTab,$strOrderBy)=
       array($arrAuswahlTab['idatt'],$arrAuswahlTab['labelatt'],$arrAuswahlTab['atts'],
             $arrAuswahlTab['tab'],$arrAuswahlTab['orderatts']);
  
  $strAtts=(empty($strAtts)) ? '' : ",$strAtts"; // Zusatzattribute sind optional.
  
  if ($boolPruefAnzahl) 
  {
    $numAnz=db_get_value("COUNT(*)",$strTab,'',$boolDEBUG);
  } // IF: Soll geprüft werden, ob überhaupt Elemente zur Auswahl stehen?

  // Prüfen, welche Elemente angekreut sind und gleichzeitig Liste aufbauen:
  $strSQL="SELECT DISTINCT $strIDAtt, $strLabelAtt  $strAtts, $strOrderBy
                 FROM $strTab
                ORDER BY $strOrderBy"; 
  $stmtSQL = db_exec($strSQL,$boolDEBUG); 
  while (db_fetch_arr($stmtSQL,$arrSQL))
  {
     $numID=$arrSQL[$strIDAtt];
     $arrKat[$numID]=$arrSQL;
     $numCheck=ut_get_webpar_n($strTagPrefix . '_' . $numID);
     // if (($numCheck > 0) or ($numPlanID == $numID))
     if ($numCheck > 0)
     {
       $strListe .=",$numID";
       if ($numCheck > 0)
       {
          $_SESSION['p_auswahl'][$strTagPrefix][]=$numID; // in Session merken für Vorauswahl:
       }  
     } // IF: Element angekreuzt?   
  } // DB-Schleife durch die Elemente.   
  ut_printr_dbg($arrKat,"$strTagPrefix:");  // DEBUG!
      
  if ((ut_get_webpar_n($strTagPrefix . '_X') > 0) or (($boolPruefAnzahl) and ($numAnz < 2)))
  {
     $strCond='';  // 'Alle' ausgewählt, keine weiteren Untersuchungen erforderlich
                   // oder keine zur Auswahl 
  }   
  elseif ($strListe != '')
  {
    $strCond = " AND (tuv.$strIDAtt IN (" . substr($strListe,1) . ")) ";
  }
  elseif (($strIDAtt == 'fach_id') and (!empty($_SESSION['p_fach_id_bearb'])))
  {
    // CID:fh130914:Wenn ein Fach zur Bearbeitung in der Session angegeben ist, dieses nehmen:
    $strCond = " AND (tuv.$strIDAtt = " . $_SESSION['p_fach_id_bearb'] . ") ";
  }
  else
  {
     $numFehler=1;
     $strFehlercode=$strFehlerCodeMissing;   // Bitte geben Sie mindestens ein xxx an!
  } // IF: Element angegeben bzw. 'Alle'?  

  return (array($numFehler,$strFehlercode,$arrKat,$strCond)); // Array zurückgeben mit etwaige Fehlern, sowie Werteliste als Array und Bedingung
  // Ende p_read_auswahl
}

// ---------------------------------------------------

function p_read_auswahlform()
{
  // Liest die Auswahlfelder des Formulars ein, mit dem bestimmt wird, welche Unterrichtsvorhaben in dem Plan angezeigt werden
  //
  // Parameter:
  //  keine bisher
  // 
  // fh, 02-FEB-2012.
  // lr: fh, 14-SEP-2013, Anpassung daran, dass nur noch ein Fach bearbeitet werden kann (keine gesonderte Bearbeitungszeile).
  //                      (Anpassung an p_read_auswahl).

  global $boolDEBUG;
  global $strGtabKatSchulform,$strGtabKatFach,$strGtabKatStufe,$strGtabKatZug,$strGtabKatKursart;

  $numFehler=0;
  $strFehlercode='';
  
  // -------------------------------------------------------------
  // Fehlerprüfungen (und Parameter einlesen):
  // -------------------------------------------------------------
  
  // Wurde Schulform angegeben?
  if ($numFehler == 0)
  {
    $numSF=db_get_value("COUNT(*)",$strGtabKatSchulform,'',$boolDEBUG);
    if ($numSF > 1)
    {
       $numSF_ID=ut_get_webpar_n('nschulform');
       if ($numSF_ID == 0)
       {
          $numFehler=1;
          $strFehlercode='M0200';   // Bitte geben Sie eine Schulform an!
       }
       else
       {
         db_get_2values("schulform","schulformkuerzel",$strGtabKatSchulform,"schulform_id=$numSF_ID",
                        $strSchulform,$strSF_Kuerzel,$boolDEBUG);
       }// IF: Schulform angegeben?                 
    }
    else
    {
      // Wenn es nur eine Schulform gibt, diese auswählen:
      db_get_3values("schulform_id","schulform","schulformkuerzel",
                     $strGtabKatSchulform,'',$numSF_ID,$strSchulform,$strSF_Kuerzel,$boolDEBUG);
      $_SESSION['p_auswahl']['nschulform']= $numSF_ID;    // CID:fh131001:SF in Session ablegen, wenn nur eine vorhanden.        
    }// IF: Mehr als eine Schulfomr?                 
    
    // Sicherheitshalber noch prüfen, ob tatsächlich eine Schulform in der DB gefunden wurde:
    if (($numFehler == 0) and ($strSchulform == ''))
    {
       $numFehler=1;
       $strFehlercode='M0201';   // In der Datenbank konnte die Schulform nicht gefunden werden!
    }
    else
    {
      // Schulform in Session merken für Vorauswahl:
      $_SESSION['p_auswahl']['nschulform']=$numSF_ID;
    } //IF: Gültige Schulform?
  } // IF: Schulform/Fehler?  
  

  // -------------------------------------------------------------
  // Fächer:
  if ($numFehler == 0)
  {
    $arrAuswahlTabFach=array('idatt'=>'fach_id','labelatt'=>'fach','atts'=>'fachkuerzel,fach_farbe,fachreihenfolge',
                             'tab'=>$strGtabKatFach,'orderatts'=>'fachreihenfolge,fach');
    list($numFehler,$strFehlercode,$arrKatFaecher,$strFachCond) = 
        p_read_auswahl('nfach',$arrAuswahlTabFach,'M0202');
  } // IF: Fächer/Fehler?
   

  // -------------------------------------------------------------
  // Jahrgangsstufen:
  if ($numFehler == 0)
  {
    $arrAuswahlTabStufe=array('idatt'=>'stufe_id','labelatt'=>'stufe','atts'=>'',
                              'tab'=>$strGtabKatStufe,'orderatts'=>'CAST(stufe AS UNSIGNED)'); // numerische Sortierung
    list($numFehler,$strFehlercode,$arrKatStufen,$strStufenCond) = 
         p_read_auswahl('nstufe',$arrAuswahlTabStufe,'M0203');
  } // IF: Stufen/Fehler?

  // -------------------------------------------------------------
  // Züge/Klassen:
  if ($numFehler == 0)
  {
    $arrAuswahlTabZug=array('idatt'=>'zug_id','labelatt'=>'zug','atts'=>'','tab'=>$strGtabKatZug,'orderatts'=>'zug'); 
    list($numFehler,$strFehlercode,$arrKatZuege,$strZugCond) = 
         p_read_auswahl('nzug',$arrAuswahlTabZug,'M0204',true);
          // true: Wenn nur maximal einer vorhanden ist, wird hier keine als Auswahl übergeben
  } // IF: Züge/Fehler?
   

  // -------------------------------------------------------------
  // Kursarten:
  if ($numFehler == 0)
  {
    $arrAuswahlTabKurs=array('idatt'=>'kursart_id','labelatt'=>'kursart','atts'=>'kursart_bezeichnung','tab'=>$strGtabKatKursart,'orderatts'=>'kursart'); 
    list($numFehler,$strFehlercode,$arrKatKursarten,$strKursartCond) = 
         p_read_auswahl('nkurs',$arrAuswahlTabKurs,'M0205',true);
          // true: Wenn nur maximal einer vorhanden ist, wird hier keine als Auswahl übergeben
  } // IF: Kursarten/Fehler?

  // Alle eingelesenen Parameter zurückgeben:
  $arrErgebnis=array();
  if ($numFehler == 0)
  {
    $arrErgebnis=array($numSF_ID,$strSchulform,$strSF_Kuerzel,
                       $arrKatFaecher,$strFachCond,
                       $arrKatStufen,$strStufenCond,
                       $arrKatZuege,$strZugCond,
                       $arrKatKursarten,$strKursartCond);
  }  
  return (array($numFehler,$strFehlercode,$arrErgebnis));
  // Ende p_read_auswahlform
}

// ---------------------------------------------------

function p_dbread_uv($numSF_ID,$strCond,$boolBearb=false,$arrPlanIDs=array())
{
  // Liest die Daten der Unterrichtsvorhaben aus der Datenbank.
  //
  // Parameter:
  //  $numSF_ID             Schulform
  //  $strCond              weitere Abfragebedingungen
  //  $boolBearb            (optional, default false), wenn true, wird eine Bearbeitungszeile erzeugt
  //  $arrPlanIDs           (optional, default leer), wenn $boolBearb true enthält die IDs der Bearbeitungsauswahl. 
  //  
  // 
  // fh, 02-FEB-2012
  // lr: fh, 29-MAR-2012.
  // lr: fh, 14-SEP-2013, TODO: $boolBearb, $arrPlanIDs nicht mehr erforderlich, weil keine Bearbeitungszeile! 
  // lr: fh, 30-SEP-2013, Bestimmte Felder nur als Lehrkraft sichtbar.

  global $boolDEBUG;
  global $strGtabEinUnterrichtsvorhaben,$strGtabEinUVTextfelder,$strGtabKfgUVTextfelder;
  
  $boolLk=p_check_lehrkraft(false);   // CID:fh130930:Prüfen, ob mindestens als Lehrkraft angemeldet.
  
  if (($boolBearb) and (!empty($arrPlanIDs)))
  {
    // Plan-IDs:
    list ($numPlanFachID,$numPlanStufeID,$numPlanZugID,$numPlanKursartID) = $arrPlanIDs ;
  }   

  // Daten aus der DB auslesen:
  $arrUV=array();
  $arrFaecher=array();
  $arrTextfelder=array();
  $strSQL="SELECT DISTINCT tuv.uv_id,tuv.schulform_id,tuv.fach_id,
                    tuv.stufe_id,tuv.kursart_id,tuv.zug_id,tuv.uv_titel,tuv.zeitbedarf_std,
                    tuv.zeitbedarf_wochen,tuv.beginn_kw,tuv.ende_kw,tuv.aenderung_user_id,
                    ttf.textfeld_id,ttf.uv_text,
                    kft.textfeld,kft.textfeld_label,
                    kft.reihenfolge,kft.plananzeige,kft.nur_lehrkraefte
             FROM $strGtabEinUnterrichtsvorhaben AS tuv
             LEFT JOIN $strGtabEinUVTextfelder AS ttf
               ON tuv.uv_id=ttf.uv_id
             LEFT JOIN $strGtabKfgUVTextfelder AS kft
               ON ttf.textfeld_id=kft.textfeld_id
            WHERE (tuv.schulform_id=$numSF_ID)
                  $strCond
             ORDER BY kft.reihenfolge ";
   $stmtSQL = db_exec($strSQL,$boolDEBUG); 
   while (db_fetch_arr($stmtSQL,$arrSQL))
   {
     $numFachID=$arrSQL['fach_id'];           
     $numStufeID=$arrSQL['stufe_id'];           
     $numKursartID=$arrSQL['kursart_id'];           
     $numZugID=$arrSQL['zug_id'];  
     $numUVID=$arrSQL['uv_id'];  

     if ($boolDEBUG) {echo "DEBUG: [numFachID][numStufeID][numKursartID][numZugID][numUVID]:[$numFachID][$numStufeID][$numKursartID][$numZugID][$numUVID]<br />\n"; }
       
     if (!in_array($numFachID,$arrFaecher))
     {
       $arrFaecher[]=$numFachID;
     }  
     if (!isset($arrUV[$numFachID][$numStufeID][$numKursartID][$numZugID][$numUVID]))
     {
       $arrUV[$numFachID][$numStufeID][$numKursartID][$numZugID][$numUVID]=$arrSQL; // Alle Infos zu den Schlüsselfeldern ablegen.
     }   
       
     // Textfelder:
     $numTextfeldId=$arrSQL['textfeld_id'];  
     $strTextfeld=$arrSQL['textfeld'];
     $numTFPlanAnz=$arrSQL['plananzeige']; // Soll das Textfeld im Plan angezeigt werden?
     if (($numTFPlanAnz == 1) and (($boolLk) or (empty($arrSQL['nur_lehrkraefte']))))
     {
       if (!isset($arrTextfelder[$numTextfeldId]))
       {
          $arrTextfelder[$numTextfeldId]=array('textfeld' => $strTextfeld, 'textfeld_label' => $arrSQL['textfeld_label'],
                                               'plananzeige' => $arrSQL['plananzeige'],'reihenfolge' => $arrSQL['reihenfolge']);
       } // IF: Textfeld-Info schon vorhanden?
       
       // Jetzt für Unterrichtsvorhaben ablegen:
       $arrUV[$numFachID][$numStufeID][$numKursartID][$numZugID][$numUVID][$strTextfeld]=$arrSQL['uv_text'];
     } // IF: Soll das Textfeld im Plan berücksichtigt werden und bestehen keine Einschränkungen für Nicht-Lehrkräfte?
   } // DB-Schleife durch alle Unterrichtsvorhaben und durch die zugehörigen Textfelder.   

   // Prüfen, ob zu der aktuellen Bearbeitungszeile Daten vorliegen, sonst einen Leereintrag einfügen:
   if (($boolBearb) and (!isset($arrUV[$numPlanFachID][$numPlanStufeID][$numPlanKursartID][$numPlanZugID])))
   {
     $arrUV[$numPlanFachID][$numPlanStufeID][$numPlanKursartID][$numPlanZugID]=array();
   } // IF: Muss Leerzeile erzeugt werden?  
    
   ut_printr_dbg($arrUV,"UV:");  // DEBUG!

   return (array($arrUV,$arrTextfelder));
   // Ende p_dbread_uv
}
      
// ---------------------------------------------------
      
function p_erzeuge_plan($arrUV,$arrTextfelder,$arrKataloge,$boolBearb=false,$numPlanFachID='')
{
  // Liest die Daten der Unterrichtsvorhaben aus der Datenbank.
  //
  // Parameter:
  //  $arrUV                Array mit allen Daten der Unterrichtsvorhaben.
  //  $arrTextfelder        Informationen zu den konfigurierbaren Textfeldern.
  //  $arrKataloge          Kataloge der Elementlisten (Fächer, Kursarten, ...)
  //  $boolBearb            (optional, default false), wenn true, wird eine Bearbeitungszeile erzeugt
  //  $numPlanFachID        (optional, default leer), wenn $boolBearb true enthält die Id des zu bearbeitenden Fachs.


  //  $numSF_ID             Schulform
  //  $strCond              weitere Abfragebedingungen
  //  
  // 
  // fh, 02-FEB-2012
  // lr: fh, 29-MAR-2012, Einarbeitung der Änderungen von C.Peters. Ergänzung $arrTextfelder.
  // lr: fh, 12-APR-2012, kleine Optimierung für den Fall, dass keine Daten vorliegen.
  // lr: fh, 14-APR-2012, Kopieroption für ganze Zeilen.
  // lr: fh, 26-APR-2012, Klasse puvtext um UV-Textbereich.
  // lr: fh, 02-JUL-2012, bei Zug und Kursart sollen die Angaben "keine"/"keiner" (ID = 0) im Zeilentitel nicht ausgegeben werden. Lösch-Link.
  // lr: cp. 29-OKT-2012, Rahmen um die Auswahl zum Kopieren der ganzen Zeile entfernt
  // lr: fh, 31-OCT-2012, im Bearbeitungsmodus für die nicht aktiven Zeilen Link zur Bearbeitungs-Aktivierung ergänzt.
  // lr: fh, 14-SEP-2013, keine Bearbeitungszeile mehr, $numPlanFachID statt $arrPlanIDs. 
  //                      Sortierung nach vorgegebenen Sortierkriterien. Mehrere Fenster mit eindeutigem Namen öffnen, Fokus setzen.
  // lr: fh, 20-SEP-2013, Keinen allgemeinen Knopf mehr für neues UV.
  // lr: fh, 02-OCT-2013, Lösch-Knopf.
  // lr: fh, 22-OCT-2013, Ausblenden von Zeilen.
  // lr: fh, 10-NOV-2013, Optimierung der Kopfhöhe für Plan-Präsentation.
  // lr: fh, 25-NOV-2013, Korrektur der Sortierfunktion (Initialisierung des Arrays $varGSortKrit).


  global $boolDEBUG;
  global $varGFirstKey;
  global $varGSortKrit;
  global $strGtabEinWochenStd;
  $strStageHeader='';
  $strUVPlan='';
  $strZeilenKoepfe='';
  $strUVungeplant='';
  $arrDruckzeilen=array();    // Zeilen für die Druckausgabe.
  $numDruckZ=0;
  
  /*
  nicht mehr erforderlich
  if (($boolBearb) and (!empty($arrPlanIDs)))
  {
    // Plan-IDs:
    list ($numPlanFachID,$numPlanStufeID,$numPlanZugID,$numPlanKursartID) = $arrPlanIDs ;
  }   
  */

  // Wochenraster aufbauen (erstmal 1 - 52):
  $strWochen='';
  for ($numWo = 1;$numWo <= 52;$numWo++)
  {
     $strWochen .= "<span>$numWo</span>";
     // CID:fh130614:Möglichkeit, um doppelte Zahlendarstellung zu vermeiden: $strWochen .= "<span>&nbsp;</span>";
  }
  $strStageHeader .= $strWochen;
  $strStageHeader .= "</div>\n";

  // Initialisierungsparameter:
  // --------------------------
  // Die Raster-Breite wird über .header span{width:38px;} eingestellt,. 38px erzeugt 40px-Raster
  $numWoEinheit=40;           // Pixel pro Woche
  $numLiOffset=142;// 53;     // Basis-Offset links.
  $numRandBreite=13;          // Randbreite in Pixeln, die bei der Dauer abgezogen werden muss.
  $numWoStd=3;                // Standard-Dauer, wenn keine Dauer angegeben wurde.
  $strJSPositionen='';        // JavaScript-Code zum Ausführen der Positionierung.
  $numStartPosUngep=170;      // Start-Position der bisher ungeplanten Einheiten. 
  $boolEditZeile=$boolBearb;  // Boolsches Flag zur Erkennung der ersten = Bearbeitungszeile.
  $numZeilenKopfHoehe=244;
  $numZeilenKopfPos=(($boolBearb) ? 492 : 293) - $numZeilenKopfHoehe; // TODO:muss automatisch ermittelt werden! bisher 640 194/262
  $strZeilenKoepfe='';
  // CID:fh130914:Fokus auf das geöffnete Fenster setzen:
  $strWindowOpen=",\"puvwin\", \"toolbar=no,status=no,menubar=no,resizable=yes,scrollbars=yes, width=800,height=600\");puvwin.focus();return false;"; 
  $strDivTag='';              // leer initialisieren
  $strDividerID='';           // leer initialisieren

  // CID:fh130920:Informationen für neue Copy-Funktion in PopUp-Fenster:
  $strCopySessionCtl=md5($_SERVER['QUERY_STRING'] . time());
  $arrCopyInfo=array('aufruf_url'=>$_SERVER['QUERY_STRING'],'kataloge'=>$arrKataloge,'ctl'=>$strCopySessionCtl);
  $_SESSION['p_fv_copy_info']=$arrCopyInfo; // Aktuelle Angaben in die Session packen.                               

  // CID:fh131022:Ausblenden von Zeilen:
  $arrAusblend=(isset($_SESSION['p_plan_uv_ausblend'])) ? $_SESSION['p_plan_uv_ausblend'] : array();

  // Array so sortieren, dass das zu bearbeitende Fach ganz oben ist:
  $arrUVSort=$arrUV;
  // if (($boolBearb) and (isset($numPlanFachID)))
  {
    // UV immer nach der Fachreihenfolge sortieren:
    // $varGFirstKey=$numPlanFachID;
    unset($varGFirstKey);
    $varGSortKrit=array($arrKataloge['fach'],'fachreihenfolge'); // globales Array $varGSortKrit gibt Sortierkatalog an.
    uksort($arrUVSort,"p_cb_array_key_cmp");
    $varGSortKrit=array();
    // unset($varGSortKrit);
  }  
     
  // Geschachtelte Schleifen:
  foreach ($arrUVSort as $numFachID => $arrUVFach)
  {
    $strAktFachK=(isset($arrKataloge['fach'][$numFachID]['fachkuerzel'])) ? $arrKataloge['fach'][$numFachID]['fachkuerzel'] : 'unbekanntes Fach';
    $arrUVFachSort=$arrUVFach;  
    // if (($boolBearb) and (isset($numPlanStufeID)))
    {
       // $varGFirstKey=$numPlanStufeID;
       $varGSortKrit=array($arrKataloge['stufe'],'stufe'); // globales Array $varGSortKrit gibt Sortierkatalog an.
       uksort($arrUVFachSort,"p_cb_array_key_cmp");
       $varGSortKrit=array();
       // unset($varGSortKrit);
    }  
    $strFachFarbe=(!empty($arrKataloge['fach'][$numFachID]['fach_farbe'])) ? (" background:" . $arrKataloge['fach'][$numFachID]['fach_farbe'] . ";") : '';
    //$strFachFarbe='';
    
    foreach ($arrUVFachSort as $numStufeID => $arrUVStufe)
    {
      $arrUVStufeSort=$arrUVStufe;  
      // if (($boolBearb) and (isset($numPlanKursartID)))
      {
         // $varGFirstKey=$numPlanKursartID;
         $varGSortKrit=array($arrKataloge['kursart'],'kursart'); // globales Array $varGSortKrit gibt Sortierkatalog an.
         uksort($arrUVStufeSort,"p_cb_array_key_cmp");
         $varGSortKrit=array();
         // unset($varGSortKrit);
      }  
      foreach ($arrUVStufeSort as $numKursartID => $arrUVKursart)
      {
        $arrUVKursartSort=$arrUVKursart;  
        // if (($boolBearb) and (isset($numPlanZugID)))
        {
          // $varGFirstKey=$numPlanZugID;
          $varGSortKrit=array($arrKataloge['zug'],'zug'); // globales Array $varGSortKrit gibt Sortierkatalog an.
          uksort($arrUVKursartSort,"p_cb_array_key_cmp");
          $varGSortKrit=array();
          // unset($varGSortKrit);
        }  
        foreach ($arrUVKursartSort as $numZugID => $arrUVZug)
        {
           // Prüfen, ob die Zeile ausgeblendet werden soll:
           if (!in_array(array($numFachID,$numStufeID,$numKursartID,$numZugID),$arrAusblend))
           {
              $strDivTag='F' . $numFachID . '_S' .  $numStufeID . '_K' . $numKursartID . '_Z' . $numZugID;
              $numDruckZ++;
              if ($boolEditZeile)
              {
                 $boolEditZeile=false;
                 $strZeileKlasse="drag pplanedit";
              } 
              else
              {
                 $strZeileKlasse=($boolBearb) ? "drag" : "nodrag";  // Nur verschiebbar, wenn im Bearbeitungsmodus!
              } // IF: Zeile, die editiert werden soll?  
              $strUVPlan .= "<div class='$strZeileKlasse' id='line_" . "$strDivTag'>\n";
              foreach ($arrUVZug as $numUVID => $arrUVInfos)
              {
                // ut_printr_dbg($arrUVInfos,"UVInfos:",true);  // DEBUG!
                $numSF_ID=$arrUVInfos['schulform_id'];      // Schulform sicherheitshalber ablegen.
                $strUVTag='uv_' . $strDivTag . '_UV' . $numUVID; 
                $strTitel=(empty($arrUVInfos['uv_titel'])) ? 'ohne Titel' : $arrUVInfos['uv_titel'];
                // Konfigurierbare Textfelder ergänzen:
                $strTextfelder='';
                foreach ($arrTextfelder as $numTextfeldId => $arrTFInfo)
                {
                  $strTextfeld=$arrTFInfo['textfeld'];
                  $arrUVTextfelder[$strTextfeld]=$arrTFInfo;
                  $strTFWert=(empty($arrUVInfos[$strTextfeld])) ? '' : $arrUVInfos[$strTextfeld]; 
                  if ($strTFWert != '')
                  {
                    $strTextfelder .= "<strong>" . $arrTFInfo['textfeld_label'] . ":</strong><br />$strTFWert<br />\n";
                  }
                } // FOR-Schleife durch die Textfelder. 
                $strTextfelder=p_url_to_hyperlink($strTextfelder);    // URLs als Links.

                $numBeginn=(empty($arrUVInfos['beginn_kw'])) ? 0 : $arrUVInfos['beginn_kw'];
                $numStartPos=$numWoEinheit * ($numBeginn - 1) + $numLiOffset;
                $numEnde=(empty($arrUVInfos['ende_kw'])) ? 0 : $arrUVInfos['ende_kw'];
                $numDauer=$numEnde - $numBeginn + 1; // + eine Woche, da die End-Woche mitgerechnet wird
                $numDauer=($numDauer > 1) ? $numDauer : ((empty($arrUVInfos['zeitbedarf_wochen'])) ? $numWoStd : $arrUVInfos['zeitbedarf_wochen']);
                $numBreite=$numWoEinheit * $numDauer - $numRandBreite;

                // DEBUG: echo "<p>numBeginn $numBeginn numFachID $numFachID == numPlanFachID $numPlanFachID</p>\n";
                $strShowURL="p_a_uv_show.php?nuvid=$numUVID";
                $strShowURL .= ($boolBearb) ? '' : "&nlese=1";  // Im Nur-Lese-Modus öffnen
                $strWinName='win' . $numUVID;   // Eindeutiger Name für das Window.
                $strATag="href='$strShowURL' target='puvwin' onClick='puvwin=window.open(\"$strShowURL\" + \"&ssuche=\" + document.getElementById(\"ssuche\").value $strWindowOpen' title='Kenndaten der Unterichtsreihe anzeigen'";
                $strATag=str_replace('puvwin',$strWinName,$strATag); // Window mit eindeutigem Namen öffnen.
                $strDeleteLink="<img class='puvdelete' src='images/loeschen.png' ".
                                    "alt='Unterichtsreihe löschen' title='Unterichtsreihe löschen' " .
                                    "onclick='js_delete_uv(\"$strUVTag\");' border='0' />";
                $strShowImageLink=$strDeleteLink .
                                   "<a $strATag style='float:right;'>Kenndaten " .
                                   "<img class='puvedit' src='images/pencil.png'  ".
                                   "alt='Kenndaten der Unterichtsreihe anzeigen' title='Kenndaten der Unterichtsreihe anzeigen' border='0' /></a>";                                
                
                $arrDruckzeilen[$numDruckZ][]=array('beginn'=>$numBeginn,'ende'=>$numEnde,'nuvid'=>$numUVID,'titel'=>$strTitel,
                                                    'uvinfos'=>$arrUVInfos,'uvtf'=>$arrUVTextfelder);
                // CID:fh130920:nicht mehr zurücksetzen.
                // $strRemoveImageLink="<img class='puvremove' src='images/cross.png' ".
                //                    "alt='Unterichtsreihe zurücksetzen' title='Unterichtsreihe zurücksetzen' " .
                //                     "onclick='js_reset_uv(\"$strUVTag\");' border='0' />";
                $strRemoveImageLink='';
                if ($numBeginn > 0)
                {
                  // Bereits geplante Einheit:
                  $strUVPlan .= ($boolBearb) ? "<div class='ui-state-default draggable'" : "<div class='ui-state-default notdraggable'";
                  $strUVPlan .=  " style='$strFachFarbe position: absolute; width:" . $numBreite  . "px;left:" . $numStartPos . "px;' id='$strUVTag'>" .
                                 "<span class='ptoolbar'>$strShowImageLink $strRemoveImageLink &nbsp;</span><span class='puvtext'><span class='puvhead'>$strTitel</span><br />\n" .   // DEBUG:  $numBeginn $numEnde $numStartPos
                                 "$strTextfelder \n</span></div>";

                  // Korrekte Positionierung per JavaScript einstellen:               
                  $strJSPositionen .= "\$('#$strUVTag').offset({left: $numStartPos });  \n";    
                }
                /*
                 CID:fh130914:entfernt
                elseif (($boolBearb) and ($numFachID == $numPlanFachID) and ($numStufeID == $numPlanStufeID) and ($numKursartID == $numPlanKursartID) and ($numZugID == $numPlanZugID))
                {
                   // Bisher unverplante Einheiten des zu bearbeitenden Faches:
                   $strUVungeplant .=  "<div class='ui-state-default draggable storeable instore' style='$strFachFarbe position: absolute; width:" . $numBreite  . "px;left:" . $numStartPosUngep . "px;' id='$strUVTag'>" .
                                  "<span class='ptoolbar'>$strShowImageLink $strRemoveImageLink &nbsp;</span><span class='puvtext'><span class='puvhead'>$strTitel</span><br />\n" .   // DEBUG:  $numBeginn $numEnde $numStartPos
                                  "$strTextfelder \n</span></div>";


                   $numStartPosUngep += ($numBreite + $numWoEinheit);   // Startposition für nächste ungeplante Einheit
                } // IF: Einheit, bei der die Positionierung eingestellt ist?
                */

             }// FOR-Schleife durch einzelne UV.

             // Zeilenkopf zusammenstellen:
             // ---------------------------
             // CID:fh120702:Bei Zug und Kursart sollen die Angaben "keine"/"keiner" (ID = 0) nicht ausgegeben werden.
             $strZugTitel=( ($numZugID == 0) ? "" : ((isset($arrKataloge['zug'][$numZugID]['zug'])) ? $arrKataloge['zug'][$numZugID]['zug'] : '-') );
             $strKursTitel=( ($numKursartID == 0) ? "" : ((isset($arrKataloge['kursart'][$numKursartID]['kursart'])) ? $arrKataloge['kursart'][$numKursartID]['kursart'] : '-') );
             $strZeilenKopf=((isset($arrKataloge['fach'][$numFachID]['fach'])) ? $arrKataloge['fach'][$numFachID]['fach'] : '-') . 
                            " <br />Stufe: " .
                            ((isset($arrKataloge['stufe'][$numStufeID]['stufe'])) ? $arrKataloge['stufe'][$numStufeID]['stufe'] : '-') . 
                            " <br /> " .
                            $strZugTitel . 
                            " <br /> " .
                            $strKursTitel;
            $numZeilenKopfPos += $numZeilenKopfHoehe;

            // CID:fh130920:Neue Copy-Funktion in PopUp-Fenster:
            if ($boolBearb)
            {
              $strCopyLink = "p_fv_plan_copy_wahl.php?sctl=$strCopySessionCtl&nfach=$numFachID&nstufe=$numStufeID&nkurs=$numKursartID&nzug=$numZugID";
              $strCopyLink = "<br /><a class='pbutton' href='$strCopyLink' onClick='puvwin=window.open(\"$strCopyLink\" $strWindowOpen' " .
                              "title='Zeile mit Unterrichtsvorhaben kopieren' border='0'>Kopieren</a>"; 
              $strCopyLink=str_replace('puvwin','pcopywin',$strCopyLink);
              $strZeilenKopf .= $strCopyLink;
            } // IF: Bearbeitungsrechte?

            // CID:fh130914:Link zum Anlegen eines neuen UV in jeder Zeile:
            if ($boolBearb)
            {
              $strNewURL="p_a_uv_show.php?nuvid=0&nbearbeiten=1&nneu=1&s_fach_id=$numFachID&s_stufe_id=$numStufeID&s_kursart_id=$numKursartID&s_zug_id=$numZugID";
              $strNewLink = "<br />Neu:<a href='$strNewURL' onClick='puvwin=window.open(\"$strNewURL\" $strWindowOpen' title='neues Unterrichtsvorhaben' border='0'>" .
                                      "<img src='images/cross.png' title='neues Unterrichtsvorhaben' border='0'/></a>"; 
              $strNewLink=str_replace('puvwin','neupuvwin',$strNewLink);
              $strZeilenKopf .= $strNewLink;
            } // IF: Bearbeitungsrechte?

            // CID:fh130102:Lösch-Funktion der ganzen Zeile in PopUp-Fenster:
            if ($boolBearb)
            {
              $strDelLink = "p_fv_plan_del_frage.php?sctl=$strCopySessionCtl&nfach=$numFachID&nstufe=$numStufeID&nkurs=$numKursartID&nzug=$numZugID";
              $strDelLink = "<br /><a class='pbutton' href='$strDelLink' onClick='puvwin=window.open(\"$strDelLink\" $strWindowOpen' " .
                              "title='Zeile mit Unterrichtsvorhaben löschen' border='0'>Löschen</a>"; 
              $strDelLink=str_replace('puvwin','pcopywin',$strDelLink);
              $strZeilenKopf .= $strDelLink;
            } // IF: Bearbeitungsrechte?

            // CID:fh130122:Ausblenden der ganzen Zeile in PopUp-Fenster:
            $strHideLink = "p_fv_plan_ausblend.php?sctl=$strCopySessionCtl&nfach=$numFachID&nstufe=$numStufeID&nkurs=$numKursartID&nzug=$numZugID";
            $strHideLink = "<br /><a class='pbutton' href='$strHideLink' onClick='puvwin=window.open(\"$strHideLink\" $strWindowOpen' " .
                            "title='Zeile ausblenden' border='0'>ausblenden</a>"; 
            $strHideLink=str_replace('puvwin','pcopywin',$strHideLink);
            $strZeilenKopf .= $strHideLink;


            // CID:fh130930:Knopf zum Ausblenden der Zeile:
            /* Schwierig wg. Aufteilung, ggf. Seite neu laden ...
            $strTagAusblend='line_' . $strDivTag;
            $strAusblend="<br /><button class='pbutton' onclick='document.getElementById(\"$strTagAusblend\").style.display=\"none\";'>Ausblenden</button><br />\n";
            $strZeilenKopf .= $strAusblend;
            */

            // CID:fh130930:Wochenstunden:  
            $numWoStd=db_get_value('wochenstunden',$strGtabEinWochenStd,
                       "(schulform_id=$numSF_ID) and (fach_id=$numFachID) and (stufe_id=$numStufeID) and (kursart_id=$numKursartID) and (zug_id=$numZugID)",$boolDEBUG);
            if ($boolBearb)
            {
              $strTagWoStd='wostd_' . $strDivTag;
              $strWoStd="<br /><div><label for='$strTagWoStd'>Wochenstd.:</label>" .
                        "<input type='text' name='nwostd' id='$strTagWoStd' size='3' value='$numWoStd' />".
                        "<button class='pbutton' onclick='js_speicher_wostd(\"$strTagWoStd\",\"nsf=$numSF_ID&nfach=$numFachID&nstufe=$numStufeID&nzug=$numZugID&nkurs=$numKursartID\");'>".
                        "WS speichern</button></div>";
            }
            else
            {
              $strWoStd=(empty($numWoStd)) ? '' : "<br /><div>Wochenstd.: $numWoStd</div>\n";
            } // IF: Bearbeitungsrechte?
            $strZeilenKopf .= $strWoStd;  
            /* keine Bearbeitungszeile mehr
            elseif ($boolBearb)
            {
              // CID:fh121031:wenn nicht die aktuelle Bearbeitungszeile, Link ausgeben, mit der diese zur Bearbeitungszeile wird:
              $strBearbQueryString=$_SERVER['QUERY_STRING'] . '&'; // &-Zeichen am Ende ergänzen, um Suchen und Ersetzen einheitlicher zu machen.
              // CID:fh130914:erstmal deaktiviert:
              $arrBQSearch=array();
              $arrBQReplace=array();
              // $arrBQSearch=array("&nfach_bearb=$numPlanFachID&","&nstufe_bearb=$numPlanStufeID&","&nzug_bearb=$numPlanZugID&","&nkurs_bearb=$numPlanKursartID&");
              // $arrBQReplace=array("&nfach_bearb=$numFachID&","&nstufe_bearb=$numStufeID&","&nzug_bearb=$numZugID&","&nkurs_bearb=$numKursartID&");
              $strBearbQueryString=substr(str_replace($arrBQSearch,$arrBQReplace,$strBearbQueryString),0,-1); // & am Ende wieder abschneiden
              $strZeilenKopf .= "<p><br /><a href='p_fv_plan.php?$strBearbQueryString'>zur Bearbeitung aktivieren</a></p>";

            } // Aktuelle Bearbeitungszeile?  
            */

            $strZeilenKoepfe .= "<div class='pplanzkopf' style='position:absolute; top:" . $numZeilenKopfPos . "px; left:0px; '>$strZeilenKopf</div>\n";

            $strUVPlan .= "<br style='clear: left;'> \n";   
            $strUVPlan .= "</div><!-- End drag --> \n";
            $strDividerID='divider_' . $strDivTag;
            $strUVPlan .= "<div class='divider' id='$strDividerID'>&nbsp;</div> \n";
          } // IF: Soll die Zeile angezeigt werden?  
        } // FOR-Schleife durch Züge.
      } // FOR-Schleife durch Kursarten.
    } // FOR-Schleife durch Stufen.
  } // FOR-Schleife durch Fächer.

  $strJSPositionen="<script type='text/javascript'>\n" .
                   "//alert('Links-Offset:' + \$('line_" . "$strDivTag').offset().left); \n" . 
                   $strJSPositionen .
                   "$('#$strDividerID').hide();" . // Letzten Divider verbergen
                  "\n</script>\n";
  $strUVPlan .= $strJSPositionen;
 
  $strUVungeplant .= "<br style='clear: left;'>\n";
  // CID:fh130914: Bearbeitungszeile entfernt: $strUVungeplant .= "</div> \n";
  
  if ($boolBearb)
  {
     $numLinkNeuPos=350; // Position des Links für ein neues Unterrichtsvorhaben. CID:fh130914:von 550 geändert
  /* Keinen allgemeinen Knopf mehr für neues UV:   
     $strUVungeplant .= "<div class='pplanneu' style='position:absolute; top:" . $numLinkNeuPos . "px; left:0px;'>";
     // CID:fh130914:nur noch Fach vorgeben:
     //$strNewURL="p_a_uv_show.php?nuvid=0&nbearbeiten=1&nneu=1&s_fach_id=$numPlanFachID&s_stufe_id=$numPlanStufeID&s_zug_id=$numPlanZugID&s_kursart_id=$numPlanKursartID";
     $strNewURL="p_a_uv_show.php?nuvid=0&nbearbeiten=1&nneu=1&s_fach_id=$numPlanFachID";
     $strUVungeplant .= "<a href='$strNewURL' onClick='puvwin=window.open(\"$strNewURL\" $strWindowOpen' title='neues Unterrichtsvorhaben' border='0'>" .
                        "Neues<br />Unterrichts-<br />vorhaben<br />anlegen</a>"; 
     $strUVungeplant .= "</div>\n";
   */  
  } // IF: Im Bearbeitungsmodus?
  
  // Druckinfos in Session ablegen:
  $_SESSION['p_druckzeilen']=$arrDruckzeilen;
  
  // Erzeugte Planvariablen als Array zurückgeben:
  return (array($strStageHeader,$strUVPlan,$strZeilenKoepfe,$strUVungeplant));
 
  // Ende p_erzeuge_plan
}
      
// ---------------------------------------------------

function p_erzeuge_id($strTab,$strIDAtt,$arrNotNullDef=array())
{
  // Erzeugt neuen ID-Wert für übergebene Tabelle.
  //
  // Parameter:
  //  $strTab            Name der Tabelle
  //  $strIDAtt          Attribut-Name des (numerischen) ID-Attributs
  //  $arrNotNullDef     Default für Not-Null Values, #id# Platzhalter für IDs
  //        z.B.:
  //          $arrNotNullDef=array('schulform'=>'SF#id#');  // Default für Unique Values, #id# Platzhalter für IDs
  //  
  // 
  // fh, 27-FEB-2012

  global $boolDEBUG;
  $numMaxTry=5;       // Aus Sicherheitsgründen mehrfach versuchen.
  $numIDNeu=0;
  
  while (($numIDNeu == 0) and ($numMaxTry > 0))
  {
    $numMaxTry--;
    $numIDNeu=db_get_value("MAX($strIDAtt)",$strTab,'',$boolDEBUG) + 1;
    // Einfügen als neuen Datensatz:
    $strIns1="INSERT INTO $strTab ($strIDAtt";
    $strIns2="VALUES ($numIDNeu";
    if (count($arrNotNullDef) > 0)
    {
      foreach ($arrNotNullDef as $strUqAtt => $strUqWert)
      {
        $strUqWert=str_replace('#id#',$numIDNeu,$strUqWert);
        $strIns1 .= ",$strUqAtt";
        $strIns2 .= ",'$strUqWert'";
      }  
    } // IF: Not Null / Unique Values?  
    $strInsSQL=$strIns1 . ") " . $strIns2 . " )";
    $boolSuccess=db_exec($strInsSQL,$boolDEBUG);
    if ($boolSuccess)
    {
      $numIDCheck=db_get_value($strIDAtt,$strTab,"$strIDAtt=$numIDNeu",$boolDEBUG); // Sicherheitshalber nochmal abfragen.
      $numIDNeu=$numIDCheck;
    }
    else
    {
      $numIDNeu=0;
    }  
  } // Schleife zur Anlegen neuer ID.
  
  if ($numIDNeu == 0)
  {
    trigger_error("Systemfehler: ID für Tabelle $strTab ($strIDAtt) konnte nicht angelegt werden!");
    p_log(8000,"Tabelle $strTab ($strIDAtt)");
  } // IF: Fehler beim Anlegen der ID?
  
  return ($numIDNeu);    
 
  // Ende p_erzeuge_id
}

// ---------------------------------------------------

function p_sperre_bearb($strModus='F',$boolFachV=true,$boolFehlerseite=false,$numFachId='')
{
  // Diese Funktion dient dazu, sowohl Sperren freizugeben als auch 
  // eine Bearbeitungssperre neu anzulegen oder zu verlängern.
  //
  // Parameter:
  //        $strModus         - F (default) = Freigabe, oder S = Sperre, I = nur Info über vorhandene Sperre ausgeben, keine neue anlegen
  //        $boolFachV        - true (default), wenn Schreibrechte vorhanden, wenn false, wird an den Sperren nichts geändert.
  //        $boolFehlerseite  - wenn true (default false), wird auf eine Fehlerhinweis-Seite verzweigt.
  //        $numFachId        - Id des Faches, das gesperrt werden soll, die Sperre bezieht sich nur auf ein Fach.
  //
  // Rückgabewert:
  //    $strUserName:         Wenn nicht leer, kann Sperre nicht angebracht werden!
  //
  //
  // Friedel Hosenfeld -- hosenfeld@digsyland.de
  // fh, 12-APR-2012.
  // lr: fh, 19-AUG-2013, $numFachId, Sperre gilt pro Fach.

  global $intGSessionTimeout;
  global $strGtabSysSperren;
  global $strGtabSysUser;
  global $boolDEBUG;
  
  $strUserName='';   // Name des Users, der den Datensatz gesperrt hat.
  $strSessionID=(empty($_SESSION['p_session_id'])) ? '-' : $_SESSION['p_session_id'];
  
  if (($boolFachV) and ($strSessionID != ''))
  {
    if ($strModus == 'F')
    {
      // Eigene Sperren löschen, falls vorhanden:
      $strSQLDel="DELETE FROM $strGtabSysSperren WHERE session_id='$strSessionID'";
      db_exec($strSQLDel,$boolDEBUG);
    }
    elseif (($strModus=='S') or ($strModus=='I'))
    {
      // Prüfen, ob Sperre angelegt werden kann, wenn ja, diese anlegen, sonst Usernamen zurückgeben.
      // Eingetragene SessionID aus der DB auslesen, wenn Timeout-Zeitpunkt hinter aktuelle Zeit liegt:
      $datAktZeit=time();
      $numUserIDSperr=db_get_value("user_id",$strGtabSysSperren,
                                  "(sessionende > '$datAktZeit') and (session_id != '$strSessionID') and (fach_id = $numFachId)",$boolDEBUG);
      if ($numUserIDSperr > 0)
      {
        // Sperre vorhanden, User dazu heraussuchen:
        $strUserName=db_get_value("anmeldename",$strGtabSysUser,"user_id=$numUserIDSperr",$boolDEBUG);
        if ($boolFehlerseite)
        {
          // Da Sperre vorhanden, zu einer Fehlerseite verzweigen:
          header("location: p_fv_sperre.php?sun=$strUserName&nfach=$numFachId");
          exit;
        } // IF: Zur Fehlerseite verzweigen?
      }
      elseif ($strModus=='S')
      {
        // Evtl. vorhandene Sperren des Faches freigeben (können nur alte Sperren sein) und eine neue Sperre anlegen:
        $strSQLDel="DELETE FROM $strGtabSysSperren WHERE (fach_id = $numFachId)";
        db_exec($strSQLDel,$boolDEBUG);
        
        $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
        $datSessionEnde=time() + $intGSessionTimeout * 60;  
        $strSQLIns="INSERT INTO $strGtabSysSperren (session_id,user_id,sessionende,fach_id)
                           VALUES ('$strSessionID',$numUserID,'$datSessionEnde',$numFachId)";
        db_exec($strSQLIns,$boolDEBUG); // Neue Sessionsperre eintragen.
      } // IF: Sperre erfolgreich?  
    } // IF: Sperre freigeben oder anlegen?
  } // IF: Bestehen Schreibrechte?  
  
  return ($strUserName); // Wenn nicht leer, dann existiert Sperre durch anderen User.

  // Ende: p_sperre_bearb
}

// ---------------------------------------------------

function p_uv_retten($numUserID,$numUVID)
{
  // Sichert Daten aktueller UV in Sicherungstabelle.
  //
  // Parameter:
  //        $numUserID        - UserID des aktuellen Users
  //        $numUVID          - ID des Unterrichtsvorhabens.
  //
  // Rückgabewert:
  //    keiner
  //
  //
  // Friedel Hosenfeld -- hosenfeld@digsyland.de
  // fh, 12-APR-2012.

  global $strGtabSysAendSess;
  global $strGtabEinUnterrichtsvorhaben;
  global $boolDEBUG;

  // Wenn UV noch nicht in Änderungsspeicher, Angaben vor dem Speichern dort sichern:
  $numUVEx=db_get_value("COUNT(*)",$strGtabSysAendSess,"(user_id = $numUserID) and (uv_id=$numUVID)",$boolDEBUG);

  if ($numUVEx == 0)
  {
    $strSQLIns="INSERT INTO $strGtabSysAendSess
                            (user_id,uv_id,schulform_id,fach_id,stufe_id,kursart_id,zug_id,
                             zeitbedarf_std,zeitbedarf_wochen,beginn_kw,ende_kw,
                             aenderung_user_id,aenderung_zeitstempel)
                      SELECT $numUserID,uv_id,schulform_id,fach_id,stufe_id,kursart_id,zug_id,
                             zeitbedarf_std,zeitbedarf_wochen,beginn_kw,ende_kw,
                             aenderung_user_id,aenderung_zeitstempel
                        FROM $strGtabEinUnterrichtsvorhaben
                       WHERE (uv_id=$numUVID)";
    db_exec($strSQLIns,$boolDEBUG);                     
  } // IF: Existiert UV noch nicht der Tabelle?

  // Ende: p_uv_retten
}

// ---------------------------------------------------

function p_fv_fach()
{
  // Sucht das Fach heraus, das man als Fachverwalter/in bearbeiten darf.
  //
  // Parameter:
  //    keine
  //
  // Rückgabewert:
  //  $numFVFachBearb: Id des bearbeitbaren Faches.
  //
  // fh, 19-AUG-2013.
  
  global $boolDEBUG;
  global $strGtabSysUser;

  $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
  
  $numFVFachBearb='';
  
  if ($numUserID > 0)
  {
    $numFVFachBearb=db_get_value('fach_id',$strGtabSysUser,"user_id=$numUserID",$boolDEBUG);
  } // IF: User-ID vorhanden?  
  
  return($numFVFachBearb); // Ergebnis zurückgeben (nur relevant, wenn $boolExit = false).
  
  // Ende: p_fv_fach.
}

// ---------------------------------------------------

function p_berechne_uv_pos($numBeginnWo,$numEndeWo,$arrUVDaten)
{
  // Berechnet die optimale Position des Unterrichtsvorhabens.
  //
  // Parameter:
  //    $numBeginnWo       - geplante Start-Woche
  //    $numEndeWo         - geplante Ende-Woche
  //    $arrUVDaten        - übrige Parameter des UV (werden benötigt für genaue Positionierung).
  //
  // Rückgabewert:
  //  Array
  //    $numBeginnWoNeu    - neu festgelegte Start-Woche
  //    $numEndeWoNeu      - neu festgelegte Ende-Woche,
  //    $strMeldungWo      - Meldung, falls die ursprüngliche Positionierung nicht klappte.
  //
  // fh, 20-AUG-2013.
  
  global $boolDEBUG;
  global $strGtabEinUnterrichtsvorhaben;
  
  $strMeldungWo = '';
  $numAnzKoll = 0;                // Gibt es Kollisionen mit dem vorgegebenen Termin?
  $numStandardLaenge=1;           // Wenn keine Länge vorgegeben wurde, 1 Woche vorgeben.
  list($numUVID,$numSchulformId,$numFachId,$numStufeId,$numKursartId,$numZugId) = 
    array($arrUVDaten['uv_id'],$arrUVDaten['schulform_id'],$arrUVDaten['fach_id'],$arrUVDaten['stufe_id'],$arrUVDaten['kursart_id'],$arrUVDaten['zug_id']);
  
  $numBeginnWoNeu=$numBeginnWo;
  $numEndeWoNeu=$numEndeWo;

  if (empty($numBeginnWoNeu))
  {
    if ($numEndeWoNeu > $numStandardLaenge)
    {
      // Wenn nur der Beginn nicht angegeben wurde, diesen rückwärts ausrechnen:
      $numBeginnWoNeu = ($numEndeWoNeu - $numStandardLaenge);
    }
    else
    {
      // Beide standardmäßig auf die erste Woche legen, weil beide leer:
      $numBeginnWoNeu = 1;
      $numEndeWoNeu = (1 + $numStandardLaenge);
    } // Ende vorgegeben oder nicht? 
  } // IF: Anfang nicht vorgegeben?  
  

  if ($numBeginnWoNeu > 0)
  {
    // Wochenbeginn vorgegeben.
    if (empty($numEndeWoNeu) or ($numEndeWoNeu <= $numBeginnWoNeu))
    {
       $numEndeWoNeu = ($numBeginnWoNeu + $numStandardLaenge);
    } // IF: Ende-Woche nicht vorgegeben?   
  } // IF: Anfangswoche vorgegeben (muss eigentlich durch die vorgegebenen Abfragen so sein.                                   

  // Prüfen, ob es andere UV gibt, die sich mit den Daten überschneiden 
  // (gleiche Kombination aus Fach, Zug, ):
  $numLaengeWo=($numEndeWoNeu - $numBeginnWoNeu + 1);  // Länge bezieht Anfangs- und Endwoche mit ein!
  $numAnzKoll=db_get_value("COUNT(*)",$strGtabEinUnterrichtsvorhaben,
                           "     schulform_id=$numSchulformId
                             AND fach_id=$numFachId
                             AND stufe_id=$numStufeId
                             AND kursart_id=$numKursartId
                             AND zug_id=$numZugId
                             AND uv_id != $numUVID
                             AND (    ((ende_kw >= $numBeginnWoNeu) and (ende_kw <= $numEndeWoNeu))
                                   OR ((beginn_kw >= $numBeginnWoNeu) and (beginn_kw <= $numEndeWoNeu))
                                   OR ((beginn_kw <= $numBeginnWoNeu) and (ende_kw >= $numEndeWoNeu)) )", $boolDEBUG);
  if ($numAnzKoll > 0)
  {
     if ($boolDEBUG) {trigger_error("numAnzKoll: $numAnzKoll "); } 
 
     // Ersten möglichen Platz heraussuchen, an den eine Unterrichtseinheit der angegebenen Länge passt:
     // Alle UV der Zeile heraussuchen:
     $strSQL="SELECT DISTINCT uv_id,beginn_kw,ende_kw
                FROM $strGtabEinUnterrichtsvorhaben
               WHERE schulform_id=$numSchulformId
                AND fach_id=$numFachId
                AND stufe_id=$numStufeId
                AND kursart_id=$numKursartId
                AND zug_id=$numZugId
                AND uv_id != $numUVID                
            ORDER BY beginn_kw,ende_kw";
     $stmtSQL = db_exec($strSQL,$boolDEBUG); 
     $arrUVs=array();
     $numIdx=0;
     while (db_fetch_arr($stmtSQL,$arrSQL))
     {
       $numIdx++;
       $arrUVs[$numIdx]=$arrSQL;
       if ($boolDEBUG) {trigger_error("numIdx $numIdx: " . $arrUVs[$numIdx]['uv_id']); } 
     }
     $numAnzUV=$numIdx;
     
     $boolFound=false;
     $numDurchlauf=($numBeginnWoNeu == 1) ? 2 : 1; // Wenn schon bei erster Woche, dann gleich im 2. Durchlauf beginnen.
     $numWoStartPos=$numBeginnWoNeu;
     $numDurchlaufMax=$numLaengeWo + 1;
     
     while((!$boolFound) and ($numDurchlauf <= $numDurchlaufMax))
     {
        // 1. Durchlauf: Möglichen Platz nach dem angegebenen Start suchen.
        // 2. Durchlauf: Möglichen Platz auch von Anfang an suchen.
        // ab 3. Durchlauf: Dauer verkürzen.
        // Zum Schluss: UV hinten anfügen.
        if ($boolDEBUG) {trigger_error("Durchlauf: $numDurchlauf numWoStartPos: $numWoStartPos numBeginnWoNeu: $numBeginnWoNeu numEndeWoNeu $numEndeWoNeu numLaengeWo: $numLaengeWo boolFound:" . $boolFound); } 
        
        foreach ($arrUVs as $numIdx => $arrUVInfo)
        {
          // Beim 2. Durchlauf auch von vorne anfangen:
          if (($numDurchlauf > 1) or ($arrUVInfo['beginn_kw'] > $numWoStartPos))
          {
            // Entweder ist die UV ganz am Anfang, dann muss ab Wo 1 Platz sein,
            // oder zwischen der UV und der Vorgänger-UV muss ein Zwischenraum sein
            if  (($numIdx == 1) and ($arrUVInfo['beginn_kw'] >= ($numLaengeWo + 1)))
            {
              $numEndeWoNeu=$arrUVInfo['beginn_kw'] - 1;
              $numBeginnWoNeu = ($numEndeWoNeu - $numLaengeWo + 1);
              $boolFound=true;
              if ($boolDEBUG) {trigger_error("Found Zweig 1: numBeginnWoNeu: $numBeginnWoNeu numEndeWoNeu $numEndeWoNeu numLaengeWo: $numLaengeWo boolFound" . $boolFound); } 
              break; // Aus der FOR-Schleife herausgehen.
            }
            elseif (($numIdx > 1) and (($arrUVs[($numIdx -1)]['ende_kw'] + $numLaengeWo) < $arrUVInfo['beginn_kw']))
            {
              // Am Ende der vorhergehende UV beginnen:
              $numBeginnWoNeu = $arrUVs[($numIdx -1)]['ende_kw'] + 1;
              $numEndeWoNeu=($numBeginnWoNeu + $numLaengeWo - 1);
              $boolFound=true;
              if ($boolDEBUG) {trigger_error("Found Zweig 2: numIdx: $numIdx arrUVInfo['beginn_kw']: " .  $arrUVInfo['beginn_kw'] . "arrUVs[(numIdx -1)]['ende_kw']: " .  $arrUVs[($numIdx -1)]['ende_kw'] . " numBeginnWoNeu: $numBeginnWoNeu numEndeWoNeu $numEndeWoNeu numLaengeWo: $numLaengeWo boolFound" . $boolFound); } 
              break; // Aus der FOR-Schleife herausgehen.
            } // IF: Passt UV an diese Stelle?
          } // IF: Soll die Position untersucht werden?
        } // FOR-Schleife durch alle UV der Zeile.
        
        // Prüfen, ob vor der 52. Woche noch Platz ist:
        if ((!$boolFound) and ($arrUVs[$numAnzUV]['ende_kw'] <= (52 -  $numLaengeWo)))
        {
          $numBeginnWoNeu = $arrUVs[$numAnzUV]['ende_kw'] + 1;
          $numEndeWoNeu=($numBeginnWoNeu + $numLaengeWo - 1);
          $boolFound=true;
        } // IF: Ist am Ende noch Platz?
        
        $numDurchlauf++;
        if ((!$boolFound) and ($numDurchlauf > 2))
        {
           if ($numLaengeWo > 1)
           {
             $numLaengeWo--;    // Länge verkürzen
           }
           else
           {
             break; // Wenn nicht weiter verkürzt werden kann, aus der Schleife herausgehen!
           }  
        } // IF: Ab dem 2. Durchlauf Dauer verkürzen.    
     } // While-Schleife durch mehrere Durchläufe.   
     
     if (!$boolFound)
     {
       // Es wurde keine geeignete Position gefunden, also ganz hinten anhängen:
       $numLaengeWo=($numEndeWoNeu - $numBeginnWoNeu + 1); // Länge neu zuordnen.
       $numBeginnWoNeu=$arrUVs[$numAnzUV]['ende_kw'] + 1;
       $numEndeWoNeu=($numBeginnWoNeu + $numLaengeWo - 1);
     } // Keine Position gefunden?  
            
  } // IF: Kollision aufgetreten, so dass neu positioniert werden muss?

  if (($numBeginnWoNeu != $numBeginnWo) or ($numEndeWoNeu != $numEndeWo))
  {
    $strMeldungWo="Das Unterrichtsvorhaben wurde auf den Bereich von der $numBeginnWoNeu. bis zur $numEndeWoNeu. Woche gelegt.";
    if ($numLaengeWo != ($numEndeWo - $numBeginnWo + 1))
    {
      $strMeldungWo .= " Die Länge der Unterrichtseinheit wurde dabei auf $numLaengeWo " . (($numLaengeWo == 1) ? "Woche" : "Wochen") . " verändert.";
    } // IF: Länge verändert.
  } // IF: Ursprünliche Position geändert?  
  
  
  return (array($numBeginnWoNeu,$numEndeWoNeu,$strMeldungWo));
  // Ende: p_berechne_uv_pos.
}


// ---------------------------------------------------

function p_url_to_hyperlink($strText)
{
  // Erkennt URLs und wandelt diese in Links um.
  //
  // Parameter:
  //    $strText           - Text mit URLs, nicht als Links gekennzeichnet.
  //
  // Rückgabewert:
  //    $strTextLinks       - Text, in dem URLs in Links umgewandelt wurden.
  //
  // fh, 20-SEP-2013.
  
  global $boolDEBUG;
  $strTextLinks=$strText;
  
  $numStartPos=0;
  
  // Schleife, die durchlaufen wird, solange noch http:// gefunden wird:
  if ($boolDEBUG) { echo "DEBUG: p_url_to_hyperlink 000 Start: $numStartPos , LenText: " . strlen($strTextLinks) . "<br />\n"; }
  while (($numStartPos < strlen($strTextLinks)) and (strpos($strTextLinks,'http://',$numStartPos) !== false))
  {
    $numPosURL=strpos($strTextLinks,'http://',$numStartPos);
    if ((substr($strTextLinks,$numPosURL - 6,13) != "href='http://") and (substr($strTextLinks,$numPosURL - 2,9) != "'>http://"))
    {
      if ($boolDEBUG) {echo "DEBUG: Start: $numStartPos numPosURL: $numPosURL L1:" . substr($strTextLinks,$numPosURL - 6,13) . ", L2: " . substr($strTextLinks,$numPosURL - 2,9) . "<br />\n"; }
      $numPosURLEnd=strlen($strTextLinks);
      foreach(array('<',' ') as $strEndTag)
      {
         // prüfen, welches End-Tag als Erstes auftritt:
         $numP=strpos($strTextLinks,$strEndTag,$numPosURL);
         if ($numP !== false)
         {
           $numPosURLEnd=min($numPosURLEnd,$numP);
         }  
      } // FOR-Schleife durch mögliche End-Tags.
      $strURL=substr($strTextLinks,$numPosURL,($numPosURLEnd - $numPosURL));
      // Ggf. Punkt als Satzzeichen am Ende der URL entfernen:
      if (substr($strURL,-1) == '.')
      {
        $strURL=substr($strURL,0,-1);
        $numPosURLEnd--;
      } // IF: Punkt am Ende?  
      if ($boolDEBUG) { echo "<pre>URL: $numPosURLEnd |<br />$strURL</br></pre>\n"; }
      $strURLNew="<a class='verweis' href='$strURL' target='_blank'>$strURL</a>";
      // Jetzt die neue URL einsetzen;
      $strTextLinks=substr($strTextLinks,0,$numPosURL) . $strURLNew . substr($strTextLinks,$numPosURLEnd);
      $numStartPos=$numPosURL + strlen($strURLNew);
      // DEBUG: echo "DEBUG: ENDE Start: $numStartPos numPosURL: $numPosURL LenURL: " . strlen($strURLNew) . ", LenText: " . strlen($strTextLinks) . "<br />\n";
    }     
    else
    {
      $numStartPos+=7;
    } // IF: Wurde bereits Link ersetzt?  
  } // Schleife durch alle Vorkommen von http://  
  
  return ($strTextLinks);
  // Ende: p_url_to_hyperlink.
}

// ---------------------------------------------------

function p_adm_check_sperren()
{
  // Diese Funktion dient dazu, festzustellen, ob derzeit Sperren durch Fachverwalter vorliegen,
  // um dem Admin eine Warnung anzuzeigen.
  //
  // Parameter:
  //        keine derzeit
  //
  // Rückgabewert:
  //    $numSperren:         Anzahl aktiver Sperren
  //
  //
  // Friedel Hosenfeld -- hosenfeld@digsyland.de
  // fh, 29-SEP-2013.

  global $intGSessionTimeout;
  global $strGtabSysSperren;
  global $boolDEBUG;
  
  $datAktZeit=time();
  $numSperren=db_get_value("COUNT(user_id)",$strGtabSysSperren,"(sessionende > '$datAktZeit')",$boolDEBUG);

  return ($numSperren); // Anzahl aktiver Sperren.

  // Ende: p_adm_check_sperren
}

// ---------------------------------------------------

function p_read_katalog($strKatTyp)
{
  // Stellt die Katalog-Einträge für den übergebenen Typ zusammen.
  //
  // Parameter:
  //  $strKatTyp              Typ des Katalogs (fach,stufe,zug,kurs)
  // 
  // Aus Parametern entfernt:
  //    $strIDBearb             ID/Name des Bearbeitungsinputfeldes (im Allgemeinen $strTagPrefix . '_bearb')
  // Aus Ausgabe entfernt: $numPlanID
  // 
  // fh, 06-NOV-2013.

  global $boolDEBUG;
  $numFehler=0;
  $strFehlercode='';
  
  $arrKat=array();

  switch ($strKatTyp)
  {
    case 'fach':
        global $strGtabKatFach;
        $arrAuswahlTab=array('idatt'=>'fach_id','labelatt'=>'fach','atts'=>'fachkuerzel,fach_farbe,fachreihenfolge',
                             'tab'=>$strGtabKatFach,'orderatts'=>'fachreihenfolge,fach');
        break;
    case 'stufe':
        global $strGtabKatStufe;
        $arrAuswahlTab=array('idatt'=>'stufe_id','labelatt'=>'stufe','atts'=>'',
                              'tab'=>$strGtabKatStufe,'orderatts'=>'CAST(stufe AS UNSIGNED)'); // numerische Sortierung
        break;
    case 'zug':
        global $strGtabKatZug;
        $arrAuswahlTab=array('idatt'=>'zug_id','labelatt'=>'zug','atts'=>'','tab'=>$strGtabKatZug,'orderatts'=>'zug'); 
        break;
    case 'kurs':
        global $strGtabKatKursart;
        $arrAuswahlTab=array('idatt'=>'kursart_id','labelatt'=>'kursart','atts'=>'kursart_bezeichnung','tab'=>$strGtabKatKursart,'orderatts'=>'kursart'); 
        break;
  } // Ende der Fallunterscheidung
  
  // Elemente der Abfrage aus $arrAuswahlTab zusammenstellen:
  list($strIDAtt,$strLabelAtt,$strAtts,$strTab,$strOrderBy)=
       array($arrAuswahlTab['idatt'],$arrAuswahlTab['labelatt'],$arrAuswahlTab['atts'],
             $arrAuswahlTab['tab'],$arrAuswahlTab['orderatts']);
  

  // Katalog aufbauen:
  $strSQL="SELECT DISTINCT $strIDAtt, $strLabelAtt
                 FROM $strTab
                ORDER BY $strOrderBy"; 
  $stmtSQL = db_exec($strSQL,$boolDEBUG); 
  while (db_fetch_arr($stmtSQL,$arrSQL))
  {
     $numID=$arrSQL[$strIDAtt];
     $arrKat[$numID]=$arrSQL;
  } // DB-Schleife durch die Elemente.   

  return ($arrKat);  // Katalogarray zurückgeben.
  // Ende p_read_auswahl
} // p_read_katalog

// ---------------------------------------------------


// ---------------------------------------------------
//  Allgemeine Utils
// ---------------------------------------------------

function ut_get_webpar($strParamName)
{
  // Liest einen HTTP-Parameter aus.
  // Ab php 4.1.0 werden andere Funktionen empfohlen,
  // so dass abhaengig von der verwendeten Version
  // unterschiedliche Methoden zur Anwendung kommen.
  // Die Skripte bleiben damit versionsunabhängig.
  // Später kann die Versionsprüfung entfernt werden
  // (Wenn nur noch php >= 4.1 im Umlauf ist).
  //
  // Parameter:
  //    - $strParamName     Name des übergebenen Parameters.
  //
  // fh, 05-SEP-2002
  // lr: fh, 15-SEP-2002, Erweiterung um GET-Parameter.
  // lr: fh, 30-OCT-2002, Prüfen, ob Index definiert ist (noch nicht für PHP < 4.1.0).
  // lr: fh, 21-JAN-2003, isset jetzt auch bei PHP < 4.1.0.
  // lr: fh, 18-MAR-2003, Anführungszeichen werden mit htmlspecialchars entfernt.


  $strParam="";

  if (ut_check_php_version("4.1.0"))
  {

    if (isset($_REQUEST[$strParamName]))
    {
      return htmlspecialchars($_REQUEST[$strParamName],ENT_QUOTES);
    }
    else
    {
      return "";
    }
  }
  else
  {
    // Erst werden POST-Parameter überprüft, dann GET-Parameter.
    // Variable hier verfügbar machen:
    global $HTTP_POST_VARS;
    if (isset($HTTP_POST_VARS[$strParamName]))
    {
      $strParam=$HTTP_POST_VARS[$strParamName];
    }
    if ($strParam == "")
    {
      // Wenn Param leer, probieren wir mal GET:
      global $HTTP_GET_VARS;
      if (isset($HTTP_GET_VARS[$strParamName]))
      {
        $strParam=$HTTP_GET_VARS[$strParamName];
      }
     }
     return htmlspecialchars($strParam, ENT_QUOTES);
  }


}  // Ende ut_get_webpar.


// ---------------------------------------------------

function ut_get_webpar_def($strParamName,$strDefaultWert)
{
  // Variante der Funktion ut_get_webpar
  // bei der ein im Web übergebener Parameter übergeben wird.
  //
  // Falls der Parameter leer ist, wird der als
  // strDefaultWert übergebene Parameterwert zurückgegeben.
  //
  // Parameter:
  //    - $strParamName     Name des übergebenen Parameters.
  //    - $strDefaultWert   Wert, der zurückgegeben wird, falls der Parameter leer ist.
  //
  // fh, 07-FEB-2003

  $strParameter=ut_get_webpar($strParamName);
  if ($strParameter == "")
  {
    $strParameter=$strDefaultWert;
  }

  return $strParameter;

} // Ende ut_get_webpar_def.

// ---------------------------------------------------

function ut_get_webpar_n($strParamName)
{
  // Variante der Funktion ut_get_webpar
  // bei der ein im Web übergebener Parameter übergeben wird.
  //
  // Diese Funktion ist speziell für numerische Parameter konzipiert.
  // Falls der Parameterwert nicht numerisch ist, wird 0 zurückgegeben.
  //
  // Parameter:
  //    - $strParamName     Name des übergebenen Parameters.
  //
  // fh, 18-MAR-2003

  $numParameter=ut_get_webpar($strParamName);

  if (is_numeric($numParameter))
  {
    return $numParameter;
  }
  else
  {
    return 0;
  }

} // Ende ut_get_webpar_n.


// ---------------------------------------------------

function ut_get_webpar_n_def($strParamName,$numDefaultWert)
{
  // Variante der Funktionen ut_get_webpar, ut_get_webpar_def und ut_get_webpar_n
  // bei der ein im Web übergebener Parameter übergeben wird.
  //
  // Diese Funktion ist speziell für numerische Parameter konzipiert.
  // Falls der Parameterwert leer ist oder nicht numerisch ist, wird $numDefaultWert zurückgegeben.
  //
  // Parameter:
  //    - $strParamName     Name des übergebenen Parameters.
  //    - $numDefaultWert   numerischer Wert, der zurückgegeben wird, falls der Parameter leer ist.
  //
  // fh, 18-MAR-2003

  $numParameter=ut_get_webpar($strParamName);

  if ( (is_numeric($numParameter)) AND ($numParameter != "") )
  {
    return $numParameter;
  }
  else
  {
    return $numDefaultWert;
  }

} // Ende ut_get_webpar_n_def.

// ---------------------------------------------------

function ut_get_webpar_arr($strParamName)
{
  // Liest einen HTTP-Parameter aus.
  // Spezialfunktion für Arrays, da nicht mit htmlspecialchars behandelt.
  //
  // Parameter:
  //    - $strParamName     Name des übergebenen Parameters.
  //
  // fh, 30-JUL-2003


  $strParam="";

  if (ut_check_php_version("4.1.0"))
  {

    if (isset($_REQUEST[$strParamName]))
    {
      // return htmlspecialchars($_REQUEST[$strParamName],ENT_QUOTES);
      // htmlspecialchars geht nicht mit Arrays:
      return $_REQUEST[$strParamName];
    }
    else
    {
      return "";
    }
  }
  else
  {
    // Erst werden POST-Parameter überprüft, dann GET-Parameter.
    // Variable hier verfügbar machen:
    global $HTTP_POST_VARS;
    if (isset($HTTP_POST_VARS[$strParamName]))
    {
      $strParam=$HTTP_POST_VARS[$strParamName];
    }
    if ($strParam == "")
    {
      // Wenn Param leer, probieren wir mal GET:
      global $HTTP_GET_VARS;
      if (isset($HTTP_GET_VARS[$strParamName]))
      {
        $strParam=$HTTP_GET_VARS[$strParamName];
      }
     }
     // return htmlspecialchars($strParam, ENT_QUOTES);
     // htmlspecialchars geht nicht mit Arrays:
     return $strParam;

  }

}  // Ende ut_get_webpar_arr.

// ---------------------------------------------------

function ut_loadAvg() {
// Gibt den Load Avarage auf einem Unix-System zurück
// 2004-12-06  wh

global $strKonf;

  // Zum Testen Wert (für Development System) setzen:
  if ($strKonf == "dev")
  {
    return 1.0;
  }
  else
  {
    $la = strtok( exec( "cat /proc/loadavg" ), " ");
    return $la;
  }  
  
}

// ---------------------------------------------------

function ut_check_php_version ($version)
 {
   // Prüft, ob eine bestimmte PHP-Version oder neuer vorliegt.
   // Von http://www.php.net/manual/en/function.phpversion.php
   // return True if given php version is the same as or older than the version currently
   //
   // integriert von fh, 05-SEP-2002

   $testSplit = explode ('.', $version);
   $currentSplit = explode ('.', phpversion ());

   if ($testSplit[0] < $currentSplit[0])
     return True;
   if ($testSplit[0] == $currentSplit[0])
   {
     if ($testSplit[1] < $currentSplit[1])
       return True;
     if ($testSplit[1] == $currentSplit[1])
     {
       if ($testSplit[2] <= $currentSplit[2])
         return True;
     }
   }
   return False;
 }

// ---------------------------------------------------

function ut_printr_dbg($arrObj,$strLabel='',$boolDirektDebug=false)
{
  // Führt ein print_r für Arrays bzw. falls kein Array ein echo aus.
  // Dabei wird die globale Variable boolDEBUG bzw. der Parameter $boolDirektDebug ausgewertet und
  // ein <pre> um die Ausgabe gemacht.
  // 
  // fh, 20-DEC-2011.
  
  global $boolDEBUG;
  
  if (($boolDirektDebug) or ((isset($boolDEBUG)) and ($boolDEBUG)))
  {
     echo "<pre>";
     echo ($strLabel !='') ? "$strLabel \n" : '';
     if (is_array($arrObj))
     {
       print_r($arrObj);
     }
     else
     {
       echo $arrObj;
     } // IF: Array?  
     echo "</pre>\n";
  } // IF: boolDEBUG?   
} // Ende ut_printr_dbg

// ---------------------------------------------------

// ---------------------------------------------------
// Ende p_ut_allgemein.inc.php
// ---------------------------------------------------

?>
