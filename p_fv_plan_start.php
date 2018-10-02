<?php
  // p_fv_plan_start.php
  //
  // FACHVERWALTER/IN
  // Wird aufgerufen von der Planauswahl und leitet zur Planbearbeitung weiter.
  // Sinn dieser Zwischenseite ist das Zurücksetzen der Sitzungsinformationen, so dass alle
  // Änderungen bis zu diesem Aufruf rückgängig gemacht werden können.
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 02-JUL-2012.
  // lr: fh, 19-AUG-2013, nur Sperre für bearbeitbares Fach prüfen.
  // lr: fh, 14-SEP-2013, Prüfen, ob Rechte für ausgewähltes Fach bestehen.
  // -------------------------------------------------------------

  // Änderungsdatum:
  $strGChangeDate="19.08.2013";

  // PHP-Kopf, include-Dateien:
  require_once ("lib/p_sys_includes.inc.php");

  // Session initialisieren:
  p_session_start();    // Session-ID und Variablen zuordnen.
  p_check_fv();         // Prüfung, ob (mindestens) als Fachverwalter/in angemeldet.
  $numFachBearbRecht=p_fv_fach();                // CID:fh130819:Fach heraussuchen, das bearbeitet werden darf.
  
  // Abgleichen, ob für das ausgewählte Fach auch Bearbeitungsrechte vorhanden sind:
  $numFachBearb=ut_get_webpar_n('nfach_bearb');
  if ($numFachBearbRecht != $numFachBearb)
  {
    p_fehler_seite('F0115');  // Für dieses Fach haben Sie keine Bearbeitungsrechte!
    exit; // Skript verlassen
  } // IF: Rechte für dieses Fach?
  p_sperre_bearb('S',true,true,$numFachBearb);                   // Sperre einrichten, sonst Fehlermeldungsseite

  // Alle gespeicherte Änderungen löschen:
  $numUserID=(empty($_SESSION['p_user_id'])) ? 0 : $_SESSION['p_user_id'];
  $strSQLDel="DELETE FROM $strGtabSysAendSess WHERE user_id = $numUserID";
  db_exec($strSQLDel,$boolDEBUG);

  // Parameter einlesen:
  // alle Parameter werden unverändert weitergegeben:
  $strPlanURL='p_fv_plan.php?'. $_SERVER['QUERY_STRING'];
  header("location: $strPlanURL");
  exit;
  // Ende PHP.
?>