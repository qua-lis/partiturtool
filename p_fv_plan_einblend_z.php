<?php
  // p_fv_plan_einblend_z.php
  // 
  // Fachverwalter/normaler Anwender: Blendet eine Zeile ein: Löscht diese aus dem Ausblend-Array.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // lr: fh, 22-OCT-2012.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="22.10.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php"); 

  // Session initialisieren:
  p_session_start();                 // Session-ID und Variablen zuordnen.

  // Parameter einlesen:
  $numABId=ut_get_webpar_n('nabid');
  
  // -------------------------------------------------------------
  // Variablen initialisieren:
  $numFehler=0;                               // Fehler-Indikator
  $strFehlercode='';                          // Code für aufgetretenen Fehler.
  $boolDEBUG=(($boolGDEBUG) or (false));      // Wenn true, wird Debugging angeschaltet, sonst wird $boolGDEBUG übernommen.
  $strGTitel=$strGAppTitel . " -  Einblenden einer gesamten Unterichtsvorhaben-Zeile";

  if ($numFehler == 0)
  {
     // Angaben aus der Session:
     $arrAusblend=(isset($_SESSION['p_plan_uv_ausblend'])) ? $_SESSION['p_plan_uv_ausblend'] : array();
     
     unset($arrAusblend[$numABId]); // Gewünschte Zeile aus dem Ausblend-Array löschen.
     
     $_SESSION['p_plan_uv_ausblend']=$arrAusblend;  // Ausgeblendete UV wieder in Session ablegen.
     
     if (!$boolDEBUG)
     {
        // JS-Code zum Aktualisieren der Plan-Seite:
        echo "<script type='text/javascript'> \n";
        echo "opener.location.reload(true);\n";
        echo "window.close();\n"; // Sich selbst schließen
        echo "</script>\n";
     } // IF: Debug-Modus?  
     
  } // IF: Fehler aufgetreten?
  // -----------------------------------------------------


  // -----------------------------------------------------
  // Fehlerausgabe:
  if ($numFehler > 0)
  {
    p_fehler_seite($strFehlercode);
  } // IF: Fehler aufgetreten?  
  // -----------------------------------------------------

  // -----------------------------------------------------
  // Ende PHP.
?>