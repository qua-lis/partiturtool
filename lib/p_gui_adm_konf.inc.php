<?php
  // p_gui_adm_konf.inc.php
  // Zusätzliche Include-Datei für p_adm_konf.php mit jQuery-Elementen.
  // Wird durch p_gui_kopf.inc.php im Header eingebunden.
  //
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 22-OCT-2013, Colorpicker mit Hilfe von jquery und jquery-ui eingebaut.
  // -------------------------------------------------------------
?>  
<script src="<?php echo $strGJSPath; ?>/jquery/<?php echo $strGDateiJQuery; ?>"></script>
<script src="<?php echo $strGJSPath; ?>/jquery/ui/jquery-ui-1.8.16.custom.js"></script>
<script src="<?php echo $strGJSPath; ?>/jquery/module/evol.colorpicker.min.js"></script>

<link rel="stylesheet" href="<?php echo $strGJSPath; ?>/jquery/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="<?php echo $strGJSPath; ?>/jquery/module/evol.colorpicker.css">


<script type="text/javascript">
  $(document).ready(function(){
    // -----------------------------------------------

   // siehe http://www.codeproject.com/Articles/452401/ColorPicker-a-jQuery-UI-Widget
   // Den Colorpicker an alle input-Felder in dem (td-)Tag der Klasse "pcolorpicker" anhängen:
   $(".pcolorpicker input").colorpicker({
        strings: "Farbauswahl,Standardfarben,mehr Farben,weniger Farben"
    });

    // -----------------------------------------------
  }); // Ende document.ready
  </script>
