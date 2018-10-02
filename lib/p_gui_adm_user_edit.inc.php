<?php
  // p_gui_adm_user_edit.inc.php
  // Zusätzliche Include-Datei für p_adm_user_edit.php mit jQuery-Elementen.
  // Wird durch p_gui_kopf.inc.php im Header eingebunden.
  //
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 19-AUG-2013.
  // lr: fh, 22-OCT-2013, jQuery-Skript aus $strGDateiJQuery.
  // -------------------------------------------------------------
?>  
  <link rel="stylesheet" href="<?php echo $strGJSPath; ?>/jquery/themes/base/jquery.ui.all.css">
  <script src="<?php echo $strGJSPath; ?>/jquery/<?php echo $strGDateiJQuery; ?>"></script>
  <script type="text/javascript">
  $(function() {

  
  // -----------------------------------------
  function js_toggle_fach()
  {
    // Funktion, die die Fachauswahl je nach Anmeldetyp ein- oder ausblendet.
    // Nur für F (Fachverwalter/in) soll die Fachauswahl erscheinen.
    //
    // fh, 19-AUG-2013.

    var strAnmeldetyp=$('#anmeldetyp').val(); 
    
    if (strAnmeldetyp == 'F')
    {
      $('#div_fach_id').show();
    }
    else
    {
      $('#div_fach_id').hide();
    } // IF: Zeigen oder Ausblenden?  
      
  } // Ende 

  // An das Feld anmeldetyp binden:
  $('#anmeldetyp').bind( "change", js_toggle_fach);
  
  // Einmal zu Beginn aufrufen, um das Feld ggf. ein- oder auszublenden:
  js_toggle_fach();
 
}); // Ende $-Funktion

// -----------------------------------------
// =========================================

</script>
