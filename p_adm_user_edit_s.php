<?php
  // p_adm_user_edit_s.php
  // 
  // ADMIN
  // Nutzer/innen abspeichern.
  //
  // Parameter:
  //      nuserid     ID des Users
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 29-MAR-2012.
  // lr: fh, 19-AUG-2013, Fach mit abspeichern, Prüfen ob für Fachverwalter Fach angegeben wurde!
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2012";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_adm();         // Prüfung, ob als Admin angemeldet.

  // Parameter einlesen:
  $numUserID=ut_get_webpar_n('user_id');      // ID des zu bearbeitenden Users, 0 wenn neuer User.
  // weitere Parameter unten.
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Nutzer/in und Nutzer bearbeiten";

  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if (($numFehler == 0) and ($numUserID != 0))
  {
    $numExist=db_get_value("COUNT(*)",$strGtabSysUser,"user_id=$numUserID",$boolDEBUG);
    if ($numExist == 0)
    {
      $numFehler = 1;
      $strFehlercode='A0112'; // Sie haben keine gültige Nutzer-Kennung ausgewählt!
    }
  } // IF:Fehler?  

  // -------------------------------------------------------------

  if ($numFehler == 0)
  {
    $strAnmeldename=ut_get_webpar('anmeldename');
    if ($strAnmeldename == '')
    {
      $numFehler=1;
      $strFehlercode='A0113'; // Bitte geben Sie einen Anmeldenamen an!
    }
    else
    {
      $numExistAN=db_get_value("COUNT(*)",$strGtabSysUser,"(user_id != $numUserID) and (lower(anmeldename) = lower('$strAnmeldename'))",$boolDEBUG);
      if ($numExistAN > 0)
      {
        $numFehler=1;
        $strFehlercode='A0114'; // Der Anmeldenamen existiert bereits!
      }
    } // IF: Anmeldename gültig?
  } // IF: Fehler?  

  if ($numFehler == 0)
  {
    $strPWDB=db_get_value("kennwort_crypt",$strGtabSysUser,"(user_id = $numUserID)",$boolDEBUG);
    $strKennwort1=ut_get_webpar('kennwort1');
    $strKennwort2=ut_get_webpar('kennwort2');
    if (($strKennwort1 != $strPWDB) or ($strPWDB == ''))
    {
      if ($strKennwort1 != $strKennwort2)
      {
        $numFehler = 1;
        $strFehlercode='A0115'; // Bitte geben Sie zweimal das gleiche Kennwort an!
      }
      elseif (($strKennwort1 == '') or ($strKennwort2 == ''))
      {
        $numFehler = 1;
        $strFehlercode='A0116'; // Bitte geben Sie ein nicht-leeres Kennwort an!
      }
      else
      {
        $strPWCrypt=md5($strKennwort1);
        switch ($strGPWKlar)
        {
          case 'b64':
            $strPWKlar="'" . base64_encode($strKennwort1) . "'"; // Base 64-Verschleierung
            break;
          case 'klar':
            $strPWKlar="'" . $strKennwort1 . "'"; // Klartext.
            break;
          default:
            $strPWKlar="NULL"; // Klartext wird gar nicht abgelegt.
            break;
        } // Fallunterscheidung für Klartext-PW.
        $strPWUpdate = ",kennwort_crypt='$strPWCrypt',kennwort_klar=$strPWKlar";  
      } // IF: Kennwort gültig?
    }
    else
    {
      $strPWUpdate='';
    } // IF: Muss das Kennwort geändert werden?  
    
  } // IF: Fehler?  


  if (($numFehler == 0) and ($numUserID == 0))
  {
    // Neue ID anlegen:
    $numUserID=p_erzeuge_id($strGtabSysUser,'user_id',array('anmeldename'=>$strAnmeldename));
    if ($numUserID == 0)
    {
      $numFehler = 1;
      $strFehlercode='A0200'; // SYS-A0200: Es ist ein Fehler beim Anlegen einer neuen ID in der Datenbank aufgetreten!
    }
  } // IF: Fehler?  


  if ($numFehler == 0)
  {
    // Übrige Parameter auswerten:
    $strVollname=ut_get_webpar('vollname');
    $strATyp=ut_get_webpar('anmeldetyp');
    $numFachId=ut_get_webpar('fach_id');
    $numFachId=(($numFachId === '') or (!is_numeric($numFachId))) ? 'NULL' : $numFachId;
    
    $strSQLUpdate="UPDATE $strGtabSysUser
                      SET anmeldename='$strAnmeldename',
                          vollname='$strVollname',
                          anmeldetyp='$strATyp',
                          fach_id=$numFachId
                          $strPWUpdate
                   WHERE user_id=$numUserID";
    $boolSuccess=db_exec($strSQLUpdate,$boolDEBUG);
    
    if ($boolSuccess) 
    {
      p_log(3210,"$numUserID");
      if (!$boolDEBUG)
      {
        header("location: p_adm_user_edit.php?nuserid=$numUserID");
        exit;
      } // IF: DEBUG?
    }
    else
    {
      $numFehler = 1;
      $strFehlercode='A0210'; // SYS-A0210: Es ist ein Fehler beim Abspeichern der Nutzerdaten in der Datenbank aufgetreten!
      p_log(8010,"$numUserID");
    } // IF: Fehler beim Ausführen des Update!
    
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
    
    echo " <p><a href='javascript:history.back();'>zurück</a></p><br />\n";

    echo "<ul>\n";
    echo " <li><a href='p_adm_user_list.php'>zurück zur Liste der Nutzer/innen</a></li> \n";
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
