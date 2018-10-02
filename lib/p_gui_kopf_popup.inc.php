<html lang="de">
<head>
<?php
  // p_gui_kopf_popup.inc.php
  // Kopf-Block für PopUp-Fenster.
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 19-JAN-2012.
  // cp, 16-OCT-2012.
  // lr: fh, 14-SEP-2013, Styles auch für Druckansicht und partitur_print.css.
  // -------------------------------------------------------------
  
  
  // -------------------------------------------------------------
  // Variablen aus globalen Variablen initialisieren, wenn diese nicht-leer sind:
  // Titel aus globaler Variable:
  echo (empty($strGTitel))  ? "<title>Partituren</title>\n" : "<title>$strGTitel</title>\n";
  // Status-Angaben aus globaler Variable entnehmen, wenn vorhanden:
  $strGStatus=(isset($strGStatus)) ? $strGStatus : "";
  
  $strGUICharset=(empty($strGGUICharset)) ? "iso-8859-1" : $strGGUICharset; // Standard-Zeichensatz.
  $strAppTitel=(empty($strGAppTitel)) ? "Partituren" : $strGAppTitel;       // Standard-Applikationstitel.
  // -------------------------------------------------------------


  // Weitere HTML-Befehle zum Aufbau der Seite:
  // -------------------------------------------------------------
?>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $strGUICharset; ?>" />
<<!-- CSS, JS laden: -->
<link href="<?php echo $strGCSSPath; ?>/partitur.css" rel="stylesheet" type="text/css" media="screen,print" />
<!--[if lte IE 6]><link href="<?php echo $strGCSSPath; ?>/partitur_ie6.css" type="text/css" rel="stylesheet" media="screen,print" /><![endif]-->
<!--[if IE 7]><link href="<?php echo $strGCSSPath; ?>/partitur_ie7.css" type="text/css" rel="stylesheet" media="screen,print" /><![endif]-->
<!--[if IE 8]><link href="<?php echo $strGCSSPath; ?>/partitur_ie8.css" type="text/css" rel="stylesheet" media="screen,print" /><![endif]-->
<link href="<?php echo $strGCSSPath; ?>/partitur_print.css" rel="stylesheet" type="text/css" media="print" />
<?php  
  // Falls in globaler Variable $strGHeaderInclude Header-Include-Datei angegeben wurde, diese einbinden:
  if ((!empty($strGHeaderInclude)) and (file_exists($strGIncPath . $strGHeaderInclude)))
  {
    include ($strGIncPath . $strGHeaderInclude);
  } // IF: Header-Include-Datei (z.B. mit jQuery-Funktionen)?  
?>  
  <script type="text/javascript">
    function js_fun_check_formpflicht(strPflichtfeldIDs)
    {
      // JS-Funktion, die prüft, ob die in der Liste übergebenen Pflichtfelder ausgefüllt wurden.
      // fh, 29-MAR-2012.
      // alert("Test "  + strPflichtfeldIDs);
      var boolResult=true;
      if (strPflichtfeldIDs != '')
      {
        var arrPIDs=strPflichtfeldIDs.split(",");
        for (numI=0;numI < arrPIDs.length;numI++)
        {
          strPFID=arrPIDs[numI];
          fldPF=document.getElementById(strPFID);
          if (typeof fldPF != 'undefined')
          {
            if (fldPF.value == '')
            {
              boolResult=false;
              strTitle=fldPF.title;
              alert("Bitte füllen Sie das Pflichtfeld '" + strTitle + "' aus!");
            } // IF: Pflichtfeld leer?
          } // IF: Pflichtfeld vorhanden?  
         } // FOR-Schleife durch alle Pflichtfelder?
      } // IF: Nicht-leere Liste von Pflichtfeld IDs.
      return (boolResult);
    }  
  </script>

</head>
<body id="popup">
<div id="pcontainer">
    <!-- div container für das Zentrieren -->
<?php
  // -------------------------------------------------------------
  echo "<!-- INHALT Container -->\n";
  echo "<div id='pinhalt'>\n";
  // -------------------------------------------------------------
?>
