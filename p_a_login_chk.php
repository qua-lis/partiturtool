<?php
  // p_a_login_chk.php
  // Überprüfung des korrekten Login
  //
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 15-DEC-2011.
  // lr: fh, 20-DEC-2011, Vervollständigung.
  // lr: fh, 30-SEP-2013, Anmeldung als Lehrkraft.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="30.09.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Parameter einlesen:
  $numLoginTyp=ut_get_webpar_n_def("nltyp",1);  // Anmelde-Typ 1 - Fachverwalter/in, 2 - Admin, 3 - Lehrkraft
  $strUsername=ut_get_webpar("susername");        // Anmeldename
  $strPassword=ut_get_webpar_arr("skennwort");    // Anmelde-Kennwort

  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $strFehlerPar1='';                          // Eventuelle Parameter für Fehlermeldungen.
  $strFehlerPar2='';
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  // -------------------------------------------------------------


  // -------------------------------------------------------------
  // Fehlerprüfungen:
  if (($numFehler == 0) and (empty($arrGLoginTypen[$arrGLoginTypCodes[$numLoginTyp]])))
  {
    $numFehler=1;
    $strFehlercode='M0103'; // Der Anmelde-Typ konnte nicht festgestellt werden!
  }
  else
  {
    $strLoginTypKuerzel=$arrGLoginTypCodes[$numLoginTyp];  
    $strLoginTyp=$arrGLoginTypen[$strLoginTypKuerzel];
  } // IF: gültiger Login-Typ?


  if (($numFehler == 0) and ($strUsername==""))
  {
    $numFehler=1;
    $strFehlercode='M0100'; // Bitte geben Sie Ihren Anmeldenamen an!
  } // IF: Anmeldename?

  if (($numFehler == 0) and ($strPassword==""))
  {
    $numFehler=1;
    $strFehlercode='M0101'; // Bitte geben Sie Ihr Kennwort an!
  } // IF: Kennwort?

  if ($numFehler == 0)
  {
    // Prüfen, ob der Password und Schulnummer korrekt sind:
    db_get_3values("kennwort_crypt","anmeldename","anmeldetyp",$strGtabSysUser,
                   "(lower(anmeldename)='"  . strtolower($strUsername) . "') and (anmeldetyp='$strLoginTypKuerzel') ",
                   $strPasswordDB,$strUsernameDB,$strLoginTypKuerzelDB,$boolDEBUG);
    // Um SQL-Injections zu verhindert, auch Anmeldetyp und Username abgleichen.                                      
    $boolOK=FALSE;
    // PW-Verschlüsselung (hier nur md5):
    $boolOK=(     (md5($strPassword) == $strPasswordDB) 
              and ($strLoginTypKuerzelDB == $strLoginTypKuerzel) 
              and (strtolower($strUsernameDB) == strtolower($strUsername)));

    if (!($boolOK))
    {
      $numFehler=1;
      $strFehlerPar1=$strLoginTyp;
      $strFehlercode='M0102'; // Anmeldename und/oder Kennwort sind nicht bekannt. ...
    }
  } // IF: Konsistenzprüfungen.  

 
  // ------------------------------------------------------------------------
  // ========================================================================
    
  if ($numFehler > 0)
  {
    // Fehler aufgetreten:
    // *******************

    // Session löschen:
    p_session_start();   // Session-Ablaufzeit initialisieren.
    session_destroy();

    // Titel:
    $strGTitel="Fehler beim Anmelden";
    include($strGIncPath . "p_gui_kopf.inc.php");  // HTML-Seite aufbauen mit Header.

    p_fehler_ausgabe($strFehlercode,$strFehlerPar1,$strFehlerPar2);
    
    echo " <p><a href='javascript:history.back();'>zurück</a></p><br />\n";
    
    
    p_log(1105,"$strUsername");
    // Footer ausgeben:
    include($strGIncPath . "p_gui_fuss.inc.php");  // Fußblock.
    exit;
    
   }
   else
   {
     // Kein Fehler aufgetreten:
     // ------------------------
     // Login mit Initialisierung der Sitzung durchführen.
     // --------------------------------
     // Eigene Session-ID generieren (aus IP-Adr, Uhrzeit, Kennung und Zufallszahl):
     session_id(md5($_SERVER['REMOTE_ADDR'] . time() . $strUsername . "part" . mt_rand()));
     // Neue Session erzeugen (Session_Start muss vor jeder Ausgabe an den Browser erfolgen) und Timeout eintragen:
     p_session_neu(); 
     $strSessionID=session_id();
     
     $numUserID=db_get_value("user_id",$strGtabSysUser,
                             "(lower(anmeldename)='"  . strtolower($strUsername) . "') and (anmeldetyp='$strLoginTypKuerzel') ",$boolDEBUG);
 
 
     // Wenn keine Sperren für den aktuellen User vorhanden sind, den Sitzungsspeicher der Änderungen löschen:
     $datAktZeit=time();
     $numExUserSperr=db_get_value("COUNT(*)",$strGtabSysSperren,"(sessionende > '$datAktZeit') and (user_id = $numUserID)",$boolDEBUG);
     if ($numExUserSperr == 0)
     {
       // Sicherheitshalber gespeicherte Änderungen löschen:
       $strSQLDel="DELETE FROM $strGtabSysAendSess WHERE user_id = $numUserID";
       db_exec($strSQLDel,$boolDEBUG);
     } // IF:  Keine Sperren für den User aktiv (nur relevant, wenn mehrere unter gleichem Namen aktiv ...).  
     
 
     // Session-Variablen (alle mit Präfix p_ gekennzeichnet) belegen:
     $_SESSION['p_session_id']=$strSessionID;
     $_SESSION['p_username']=$strUsername;
     $_SESSION['p_user_id']=$numUserID;
     $_SESSION['p_logintyp']=$strLoginTypKuerzel;
     unset($_SESSION['p_admin']);
     

     // Einlog-Vorgang ggf. protokollieren:
     p_log(1100,"$strUsername");
     // Start-URLs je nach Anmeldetyp:
     $strURL=(isset($arrGLoginTypKonf[$strLoginTypKuerzel][1])) ? $arrGLoginTypKonf[$strLoginTypKuerzel][1] : 'p_a_start.php';  // Default-Belegung sonst ...
     
     header("Location: $strURL");
     exit;
   }  // IF: Eingaben ok?

   // Ende PHP
?>
