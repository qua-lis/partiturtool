<?php
  // p_gui_auswahl.inc.php
  // Zusätzliche Include-Datei für p_fv_ausw_plan.php mit jQuery-Elementen.
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
  // fh, 01-FEB-2012.
  // lr: fh, 22-OCT-2013, jQuery-Skript aus $strGDateiJQuery.
  // -------------------------------------------------------------
?>  
<script src="<?php echo $strGJSPath; ?>/jquery/<?php echo $strGDateiJQuery; ?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // -----------------------------------------------

    function fun_uncheck(event)
    {
      // 'Uncheckt' alle Elemente der Klasse strClass.
      // Bekommt die Klasse oder ID als Data-Element 'sel' übergeben,
      // (ID in der Notation #id, Klasse in der Notation .klasse).
      //
      // fh, 01-FEB-2012.
      
      var strSel=event.data.sel;
      var strChecked=$( this ).attr('checked');
      
      if ((strChecked) && (strSel != ''))
      {
        // DEBUG: alert(strClass);
        $(strSel).attr('checked',false); // Alle Checkboxen der Klasse zurücksetzen.
        // $(strSel).each(function(index) { $(this).attr('checked',false); });   // Alternativ mit each
      } // IF: Klasse angegeben?  
    } // Ende fun_uncheck

   // ======================

   // ------------------------
   // Eventbehandlungen
   // ------------------------


   // Checkboxen deaktivieren, wenn 'alle' gewählt wird und umgekehrt.
   $('#nfach_X').bind('click',{sel:'.pfachwahl'},fun_uncheck);
   $('.pfachwahl').bind('click',{sel:'#nfach_X'},fun_uncheck);

   $('#nstufe_X').bind('click',{sel:'.pstufenwahl'},fun_uncheck);
   $('.pstufenwahl').bind('click',{sel:'#nstufe_X'},fun_uncheck);

   $('#nzug_X').bind('click',{sel:'.pzugwahl'},fun_uncheck);
   $('.pzugwahl').bind('click',{sel:'#nzug_X'},fun_uncheck);

   $('#nkurs_X').bind('click',{sel:'.pkurswahl'},fun_uncheck);
   $('.pkurswahl').bind('click',{sel:'#nkurs_X'},fun_uncheck);
  
    // -----------------------------------------------
  }); // Ende document.ready
  </script>
