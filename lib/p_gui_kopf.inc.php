<!doctype html>
<html lang="de">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
  // p_gui_kopf.inc.php
  // Kopf-Block für alle Seiten.
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 15-DEC-2011.
  // cp, 15-OCT-2012  
  // lr: fh, 30-SEP-2013.
  // -------------------------------------------------------------
  
  
  // -------------------------------------------------------------
  // Variablen aus globalen Variablen initialisieren, wenn diese nicht-leer sind:
  // Titel aus globaler Variable:
  echo (empty($strGTitel))  ? "<title>Partituren</title>\n" : "<title>$strGTitel</title>\n";
  // Status-Angaben aus globaler Variable entnehmen, wenn vorhanden:
  $strGStatus=(isset($strGStatus)) ? $strGStatus : "";
  
  $strGUICharset=(empty($strGGUICharset)) ? "utf-8" : $strGGUICharset; // Standard-Zeichensatz.
  $strAppTitel=(empty($strGAppTitel)) ? "Partituren" : $strGAppTitel;       // Standard-Applikationstitel.
  $strMenue=(empty($strGMenue)) ? '' : $strGMenue;                          // Falls Menü ausgegeben werden soll, steht dies in $strMenue.
  // -------------------------------------------------------------


  // Weitere HTML-Befehle zum Aufbau der Seite:
  // -------------------------------------------------------------
?>
<meta charset="<?php echo $strGUICharset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSS, JS laden: -->
<link media="screen" rel="stylesheet" type="text/css" href="css/style.css">
<link media="screen" rel="stylesheet" type="text/css" href="css/orange.css">
<link media="print" rel="stylesheet" type="text/css" href="css/print.css">
<link href="<?php echo $strGCSSPath; ?>/partitur.css" rel="stylesheet" type="text/css" media="screen,print" />
<!--[if lte IE 6]><link href="<?php echo $strGCSSPath; ?>/partitur_ie6.css" type="text/css" rel="stylesheet" media="screen,print" /><![endif]-->
<!--[if IE 7]><link href="<?php echo $strGCSSPath; ?>/partitur_ie7.css" type="text/css" rel="stylesheet" media="screen,print" /><![endif]-->
<!--[if IE 8]><link href="<?php echo $strGCSSPath; ?>/partitur_ie8.css" type="text/css" rel="stylesheet" media="screen,print" /><![endif]-->
<link href="<?php echo $strGCSSPath; ?>/partitur_print.css" rel="stylesheet" type="text/css" media="print" />
<!--
<script src="<?php echo $strGJSPath; ?>/jquery-1.4.4.min.js" type="text/javascript"></script>
<script src="<?php echo $strGJSPath; ?>/jquery.autotab.js" type="text/javascript"></script>
<script src="<?php echo $strGJSPath; ?>/jquery_accordion.js" type="text/javascript"></script>
<script src="<?php echo $strGJSPath; ?>/jquery.tablehover.min.js" type="text/javascript"></script>
-->
<?php  
  // Falls in globaler Variable $strGHeaderInclude Header-Include-Datei angegeben wurde, diese einbinden:
  if ((!empty($strGHeaderInclude)) and (file_exists($strGIncPath . $strGHeaderInclude)))
  {
    include ($strGIncPath . $strGHeaderInclude);
  } // IF: Header-Include-Datei (z.B. mit jQuery-Funktionen)?  
  
  // CID:fh130914:Schulnamen anzeigen, wenn vorhanden:
  $strSchulname = (empty($arrGMeta['schulname'])) ? '' : $arrGMeta['schulname'];

  // Schulformen: Wenn nur eine vorhanden ist, wird diese z.B. in Kopfzeile angezeigt:
  $numAnzSF=db_get_value("COUNT(*)",$strGtabKatSchulform,'',$boolDEBUG);
  $strSchulform='';
  if ($numAnzSF == 1)
  {
    $strSchulform= ', ' . db_get_value("MAX(schulform)",$strGtabKatSchulform,'',$boolDEBUG);
  } // IF: Nur eine Schulform?
     
  
  
?>
</head>
<?php echo "<body class='$strGTitel'>" ?>
<div id="pcontainer">
<a href="http://www.qua-lis.nrw.de" title="zur Startseite der QUA-LiS NRW" id="logo"><img src="images/logo.jpg" alt="Qualitäts- und Unterstützungsargentur - Landesinistut für Schule" /></a> 
<!-- div container für das Zentrieren --> 
<!-- KOPF Container -->
<div id="header">
    <p><span id="skip1"><a href="#navigation">Zur Navigation springen</a></span><span class="none"> &#8226; </span><span id="skip2"><a href="#top">Zum Inhalt springen</a></span></p>
    <div id="topnavi">
        <p id="pschule"><?php echo $strSchulname . $strSchulform; ?></p>
        <h1 id="standard_h1">Schulentwicklung NRW<br />
            <span class="angebot">Jahrgangspartituren</span></h1>
        <ul>
            <li><a href="/cms/kontakt.html" title="Kontakt">Kontakt</a></li>
            <li><a href="/cms/impressum.html" title="Impressum / Haftungsausschluss / Hinweise zum Datenschutz">Impressum</a></li>
        </ul>
      <!--  <p id="login"> <a href="/cms/anmelden">Anmelden Standardsicherung</a> </p> -->
    </div>
    <div id="suche">
        <ul>
            <li><a href="http://www.schulentwicklung.nrw.de">QUA-LiS NRW</a></li>
            <li><a href="/cms/">Schulentwicklung</a></li>
        </ul>
        <div id="search"> </div>
    </div>
    <!--<h1><?php echo $strAppTitel; ?></h1>
    <p class="pstatus"><?php echo $strGStatus; ?></p> 
    <a href="#"><img src="<?php echo $strGImgPath; ?>/logo.gif" alt="Logo" border="0" class="plogo" /></a>--> </div>
<?php
  // -------------------------------------------------------------
  echo $strMenue;
  echo "<!-- INHALT Container -->\n";
  echo "<div id='wrapper'>\n";
  echo "<div id='pinhalt'>\n";
  echo "<h3>$strGTitel</h3>\n";
  // -------------------------------------------------------------
?>
