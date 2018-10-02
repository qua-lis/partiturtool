<?php
  // p_gui_plan.inc.php
  // Zusätzliche Include-Datei für p_aus_plan.php mit jQuery-Elementen.
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
  // fh, 20-DEC-2011.
  // lr: fh, 19-JAN-2012, Fertigstellung der Positionierung, insbesondere des Bereichs der ungeplanten Einheiten.
  // ks, 7-MAR-2012, Änderungen Skripte, Struktur
  // lr: fh, 15-APR-2012, Beginn einer AJAX-basierten Suchfunktion.
  // lr: fh, 26-APR-2012, js_such_uv: Vorhandene Treffermarkierungen entfernen.
  // lr: fh, 02-JUL-2012, js_delete_uv: Löschen von UV per AJAX, js_checkUVKollision, verbesserte Kollisionserkennung.
  // lr: cp, 29-OKT-2012, Top-Position Ablagebereich an gepasst.
  // lr: fh, 14-SEP-2013, js_such_uv (Anzahl der Treffer anzeigen). containment geändert, damit in der 1. Woche begonnen werden kann.
  // lr: fh, 30-SEP-2013, js_speicher_wostd: Speichern der Wochenstundenzahl per AJAX.
  // lr: fh, 22-OCT-2013, jQuery-Skript aus $strGDateiJQuery, js_stage_start neu. Verkleinerung während dragging.
  // -------------------------------------------------------------
?>  
  <link rel="stylesheet" href="<?php echo $strGJSPath; ?>/jquery/themes/base/jquery.ui.all.css">
  <script src="<?php echo $strGJSPath; ?>/jquery/<?php echo $strGDateiJQuery; ?>"></script>
  <script src="<?php echo $strGJSPath; ?>/jquery/ui/jquery.ui.core.js"></script>
  <script src="<?php echo $strGJSPath; ?>/jquery/ui/jquery.ui.widget.js"></script>
  <script src="<?php echo $strGJSPath; ?>/jquery/ui/jquery.ui.mouse.js"></script>
  <script src="<?php echo $strGJSPath; ?>/jquery/ui/jquery.ui.sortable.js"></script>
  <script src="<?php echo $strGJSPath; ?>/jquery/ui/jquery.ui.draggable.js"></script>   
  <script src="<?php echo $strGJSPath; ?>/jquery/ui/jquery.ui.resizable.js"></script> 
  <script src="<?php echo $strGJSPath; ?>/jquery/ui/jquery.ui.droppable.js"></script> 
  <link rel="stylesheet" href="<?php echo $strGJSPath; ?>/jquery/themes/demos.css">
  <style>
  </style>
  <script type="text/javascript">
  $(function() {
        $( ".drag div" ).draggable( {
                                        axis: "x",                  // nur horizontal
                                        grid: [ 40, 1 ],            // 40px-Grid
                                        containment: "parent",      // bleibt im Eltern-Element, leider wird hinten und vorne Rand gelassen
                                        containment: [120,0,2200,0],      // Leider kann das UV dann hinten überlappen ...
                                        revert: "valid",            // springt zurück, wenn das Zeil droppable ist
                                        stack: ".drag div",         // beim Drag immer zindex nach oben
                                        cursor: "move",             // oder Handsymbol: pointer
                                        start: js_stage_start,    
                                        stop: js_stage_stop
                                    } );



        $( ".drag div" ).resizable({
                                        // containment: "parent",      // bleibt im Eltern-Element
                                        // containment: ".drag",       // macht Probleme, beim links-Ziehen verschwindet das Objekt
                                        grid: [ 40, 1 ],           // 40px-Grid
                                        handles: 'e, w',             // nur horizontal, links-rechts
                                        stop: js_stage_stop
                                } );


        $( ".drag div" ).droppable({                                // alle Elemente sind selber droppable für revert
                                        hoverClass: "hilight",
                                        drop: function( event, ui ) {
                                        $( this )
                                            .addClass( "ui-state-highlight" );
                                        }
                                } );


         // Elemente im Ablage-Speicher:
         $( ".storeable" ).draggable( {
                                          containment: ".drag",       // bleibt im Eltern-Element
                                          stack: ".drag div",         // beim Drag immer zindex nach oben
                                          distance: 20 ,			        // mind. 20 px bewegen, bevor etwas passiert

                                          stop: js_storable_stop
                                     } );


        $( "#store div" ).resizable({
                                       //  containment: ".drag",      // bleibt im Eltern-Element
                                        grid: [ 40, 1 ],           // 40px-Grid
                                        handles: 'e, w'            // nur horizontal, links-rechts
                                } );


        $( "#store div" ).droppable({                                // alle Elemente sind selber droppable für revert
                                        hoverClass: "hilight",
                                        drop: function( event, ui ) {
                                                $( this ).addClass( "ui-state-highlight" );
                                        }
                                } );

        // Gezogenes Element immer oben.
        $( ".draggable" ).draggable({ stack: ".drag" });


        // Alle auf "absolute" setzen, dann klappt die Kombi von drag and resize:
        // http://www.prodevtips.com/2008/11/12/jquery-ui-draggable-and-resizable-combination/
        // $(".drag div").css("position", "absolute"); // 1
        // $(".drag").css("height", "220px");
        // --> alles im CSS
 
}); // Ende $-Funktion

// -----------------------------------------
// =========================================
// -----------------------------------------


function js_reset_uv(strID)
{
    // Setzt Unterrichtsvorhaben mit der übergebenen ID wieder in den Ablagebereich zurück.
    // fh, 01-FEB-2012.
    // lr: fh, 27-MAR-2012.

    // fh:revert ist ungünstig, weil die alten Positionen z.T wieder herstellt werden:
    //                          1. nicht gewollt, wenn man die Elemente in neue Position zieh
    //                          2. Funktioniert nicht bei, Elementen, die nie in dem Bereich waren (aus DB ausgelesen)
 	  // fh $('#' + strID).draggable({ revert: 'invalid' }); // ## als revert - an den Anfang zurück, macht dann nur beim nästen Mal einen Umweg
    //# 	ggf die Klassen wiederherstellen
    $('#' + strID).droppable( "destroy" ); // ## als revert
    $('#' + strID).removeClass('droppable');// ## als revert
    $('#' + strID).removeClass('ui-droppable');// ## als revert
    $('#' + strID).removeClass('resizable');// ## als revert

    $('#' + strID).addClass('storeable');        // wieder storeable.
    $('#' + strID).removeClass('instore');
    // $('#' + strID).detach();                  // aus dem DOM-Baum entfernen, nicht nötig.
    $('#' + strID).appendTo('#store');           // wieder zum Speicher hinzufügen.
    //# das ist doch unnötig, ohne das springt das Element auch auf top, aber beim nächsten Mal zu tief
    //# fh: nein, das wird doch benötigt, damit Elemente, die nicht aus dem Store kommen, dorthin gesetzt werden!
    
    var strTopWert=$('#' + strID).css("top");    // Alten Top-Wert 'merken'
    $('#' + strID).data('topwert',strTopWert);
    // DEBUG: alert('Topwert: ' + strTopWert);
    // $('#' + strID).css("top","");                // ganz nach oben setzen
    $('#' + strID).css("top","512px");              // (zuvor 432px (cp)) ganz nach oben setzen, CID:fh120327:erstmal hart reincodiert.
    $('#' + strID).removeClass('pplanedit');     // Klasse der Bearbeitungszeile.

    // Eigenschaften des Ablagespeichers wieder zuordnen:
    $('#' + strID).draggable( {
                                 containment: ".drag",       // bleibt im Eltern-Element
                                 stack: ".drag div",         // beim Drag immer zindex nach oben
                                 stop: js_storable_stop
                             } );
    // Position (nxpos=0) per Ajax abspeichern:
    $.ajax({
      type: "POST",
      url: "p_ax_save_uvpos.php?nxpos=0"+ "&suvid=" + strID + "&nuid=" + numGUserID,

      error: function(response) 
      {
        alert(response.responseText);
      }
    });
}  // Ende js_reset_uv

// -----------------------------------------


function js_storable_stop(event, ui)
{
  // Funktion, die ausgeführt wird, wenn ein Element im Ablagespeicher (store) losgelassen wird.
  // fh, 02-FEB-2012.
  // lr: fh, 02-JUL-2012, Kollisionserkennung ergänzt.
  
  // Kollision prüfen:
  var strKollision=0;

  // Prüfung auf Kollisionen:
  strKollision=js_checkUVKollision($(this).offset().left,$(this).css('width'),$(this).attr('id'));
  
  if (strKollision == 0)
  {
     //# $(this).css("position","top");     // wieder nach oben an den Rand setzen falls sie woanders liegen
     $(this).removeClass('storeable');  // ist nicht mehr storeable, sondern hat nur noch draggable-Eigenschaften
     // Fehlende Klassen ergänzen:
     $(this).addClass('ui-droppable');
     $(this).addClass('ui-resizable');
     $(this).addClass('resizable');
     $(this).addClass('droppable');


     $(this).addClass('pplanedit');     // Klasse der Bearbeitungszeile.

     //# brauchen wir im Moment nicht mehr
     // Falls das Element noch einen Top-Wert (alte Top-Position) gespeichert hat, diesen wieder einstellen:
     if ($(this).data('topwert'))
     {
       //# $(this).css("top",$(this).data('topwert'));
       //# alert('alter Topwert: ' + $(this).data('topwert'));
	     $(this).css("top","659px"); // (zuvor 598px (cp))Workaround, erstmal konstant auf 600px bzw. 580 = Oberkante des Positionierungsbereiches setzen
     }

     // Die Optionen von draggable ergänzen (kann wahrscheinlich schöner gelöst werden:
     $(this).draggable("option", "axis", "x" );
     $(this).draggable("option", "grid", [ 40, 1 ] );
     $(this).draggable("option", "revert", "valid" );
     $(this).draggable("option", "stack", ".drag div" );
     $(this).draggable("option", "stop", js_stage_stop);


     // Schliesslich noch aktuelle Position abspeichern:
     // DEBUG: alert('Test Ex-Store first');
     js_saveUVPosition($(this).offset().left,$(this).css('width'),$(this).attr('id'));

     // $(this).css("top","0px");    // wieder nach oben an den Rand setzen falls sie woanders liegen
     // pplanedit
     // var divpplanedit=$('.pplanedit').first();
     // var pptop=divpplanedit.css('top');
    // alert(divpplanedit.attr('id') + pptop);
    // $(this).css("top",pptop);    // wieder nach oben an den Rand setzen falls sie woanders liegen
  }
  else
  {
    js_reset_uv($(this).attr('id')); // Wieder in Ablagebereich zurücksetzen.
    // var arrPos=strKollision.split('|');
    // $(this).offset({left: arrPos[0] });
    // $(this).css('width',arrPos[1]);
  } // IF: Kollision erkannt?
}

// -----------------------------------------

function js_stage_stop(event, ui)
{
  // Funktion, die ausgeführt wird, wenn ein Element im Positionierungsbereich (stage) losgelassen wird.
  // fh, 02-FEB-2012.
  // lr: fh, 02-JUL-2012, verbesserte Kollisionserkennung und Korrektur.
  // lr: fh, 22-OCT-2013, Höhe am Ende wieder zurücksetzen (wurde mit js_stage_start verringert).

  
  var strKollision=0;

  // Prüfung auf Kollisionen:
  strKollision=js_checkUVKollision($(this).offset().left,$(this).css('width'),$(this).attr('id'));
  
  if (strKollision == 0)
  {
    // Stop-Funktion, die aktuelle Position in der Datenbank ablegt.
    js_saveUVPosition($(this).offset().left,$(this).css('width'),$(this).attr('id'));
  }
  else
  {
    // Element wieder an vorherige Position zurücksetzen:
    // DEBUG: alert('aktuell:' + $(this).offset().left + " -- -- " + $(this).css('width'));
    // DEBUG: alert('S2:' + strKollision);
    var arrPos=strKollision.split('|');
    $(this).offset({left: arrPos[0] });
    $(this).css('width',arrPos[1]);
  } // IF: Kollision erkannt?

  $(this).css('height',''); // Ursprüngliche Höhe wieder herstellen.
  $(this).css('min-height',''); // Ursprüngliche Höhe wieder herstellen.
  
}

// -----------------------------------------

function js_stage_start(event, ui)
{
  // Funktion, die ausgeführt wird, wenn ein Element im Positionierungsbereich (stage) bewegt wird (Bewegung startet).
  // fh, 22-OCT-2013.
  
  // DEBUG: alert('aktuell:' + $(this).offset().left + " -- -- " + $(this).css('width'));

  // Höhe verringern:
  // $(this).addClass('pdragmoving');  
  $(this).css('height',20);  // geht nicht über Klasse, sondern über direkte Zuweisung.
  $(this).css('min-height',20);  // geht nicht über Klasse, sondern über direkte Zuweisung.
}

// -----------------------------------------

function js_saveUVPosition(x,w, id)
{
  // Speichert die aktuelle Position per Ajax-Aufruf über PHP ab.
  // aus: http://www.mikesdotnetting.com/Article/101/Persisting-the-position-of-jQuery-Draggables-in-ASP.NET
  // DEBUG: alert ('x: ' + x + 'w: ' + w + ', element id: ' + id);
  $.ajax({
    type: "POST",
    url: "p_ax_save_uvpos.php?nxpos=" + x + "&sbreite=" + w + "&suvid=" + id + "&nuid=" + numGUserID,
    // data: "{x: '" + x + "', element: '" + id}",
    // contentType: "application/json; charset=utf-8",
    // dataType: "json",
    /*
    success: function(response)
    {
      if (response.d != '1')
      {
        alert('Fehler beim Speichern der Position in der Datenbank');
      }
    },
    */

    error: function(response)
    {
      alert(response.responseText);
    }
  });
}

// -----------------------------------------

function js_checkUVKollision(x,w, id)
{
  // Prüft anhand der übergebenen Position per Ajax-Aufruf über PHP, ob Kollision
  // mit anderem UV besteht und gibt sonst die bisherige Position zurück,
  // damit das UV zurückbewegt werden kann.
  // fh, 02-JUN-2012.

  var strKollision='0';

  $.ajax({
    type: "POST",
    async: false,  // nicht asynchron ausführen, da Ergebnis ausgewertet werden soll.
    url: "p_ax_check_uvpos.php?nxpos=" + x + "&sbreite=" + w + "&suvid=" + id + "&nuid=" + numGUserID,

    success: function(data)
    {
      // alert('Test!');
      // alert("Ergebnis: "  + data);
      // Das Ergebnis ist Links-Wert und Breite in Pixel getrennt durch | (z.B. 713|227)
      strKollision=data;
      // DEBUG: alert("Kol:" + strKollision);
    },

    error: function(response)
    {
      alert(response.responseText);
    }
  });
  
  return (strKollision);
}

// -----------------------------------------

function js_such_uv(strPar)
{
  // Suche nach Stichworten in den angezeigten UV.
  // Die betroffenen UV werden anhand der PHP-Aufrufparameter (strPar) ermittelt
  // und AJAX
  //
  // fh, 15-APR-2012.
  // lr: fh, 26-APR-2012, Vorhandene Treffermarkierungen entfernen.
  // lr: fh, 14-SEP-2013, Anzahl der Treffer anzeigen.
  

  // Evtl. vorhandene Treffer-Markierungen entfernen:
  $('.psuchtreffer').removeClass( "psuchtreffer" ); // Treffer-Markierungsklasse entfernen.
  
  var strSuchbegriff=$('#ssuche').val();
  if (strSuchbegriff != '')
  {
    // DBEUG: alert(strSuchbegriff);
    // DBEUG: alert(strPar);

    $.ajax({
      type: "POST",
      url: "p_ax_such_uv.php?ssuche=" + strSuchbegriff + "&" + strPar,
    // data: "{x: '" + x + "', element: '" + id}",
      contentType: "application/json; charset=utf-8",
      dataType: "json",
    success: function(data)
    {
      // alert('Test!');
      var numAnzTreffer=0;
      $.each(data, function(key, val) 
      {
         // DEBUG: alert('Treffer' + key + ':' + val + '!');
         if ($('#'+val))
         {
           $('#'+val).addClass( "psuchtreffer" ); // als Treffer markieren!
           numAnzTreffer++;
         }
      });
      // Ausgeben, ob etwas gefunden wurde:
      if (numAnzTreffer > 0)
      {
        alert(numAnzTreffer + " Treffer gefunden. Die gefundenen Unterrichtsvorhaben wurden gelb markiert.");
      }
      else
      {
        alert("Suchbegriff wurde nicht gefunden!");
      } // IF: Treffer?  
      
      /*
      $.each(data, function(key, val) {
        items.push('<li id="' + key + '">' + val + '</li>');
      });
      */
      
      /*
      if (response.d != '1')
      {
        alert('Fehler beim Speichern der Position in der Datenbank');
      }
      */
    },

    error: function(response)
    {
      alert(response.responseText);
    }
  }); // Ende AJAX.
  
    
  } // IF: Suchbegriff angegeben?  

} // Ende Funktion js_such_uv.

// -----------------------------------------

function js_delete_uv(strID)
{
    // Löscht Unterrichtsvorhaben mit der übergebenen ID aus der Datenbank.
    // fh, 02-JUL-2012.

    // Fragen, ob diese Unterrichtseinheit tatsächlich gelöscht werden soll:
    boolCheck = confirm("Möchten Sie das gewählte Unterrichtsvorhaben umwiederbringlich aus der Datenbank löschen?\n" +
                        "(Dies kann nicht rückgängig gemacht werden!)");
    if (boolCheck)
    {
      var numSuccess=1;
      // UV per Ajax löschen:
      $.ajax({
        type: "POST",
        url: "p_ax_del_uv.php?suvid=" + strID + "&nuid=" + numGUserID,

        error: function(response) 
        {
          numSuccess=0;
          alert(response.responseText);
        }
      });

      if (numSuccess == 1)
      {
         $('#' + strID).detach();                  // aus dem DOM-Baum entfernen.
      } // IF: Ajax erfolgreich?   
   } // IF: UV tatsächlich löschen?   
}  // Ende js_delete_uv

// -----------------------------------------

// -----------------------------------------

function js_speicher_wostd(strWoStdId,strPar)
{
  // Speichert Wochenstundenzahl in DB.
  // Die entsprechenden Schlüssel werden anhand der PHP-Aufrufparameter (strPar) ermittelt
  // und AJAX
  //
  // Parameter:
  //  - strWoStdId: Id des Feldes mit Wochenstundenzahl
  //  - strPar: weitere Parameter als Primärschlüssel der DB-Tabelle.
  //
  // fh, 30-SEP-2013.
  
  // DEBUG: alert('Parameter: ' + strPar + '!');
  
  
  var numWoStd=$('#' + strWoStdId).val();
  // DEBUG: alert('ID: ' + strWoStdId + '!' + numWoStd);
  if (strPar != '')
  {
    var numSuccess=1;
    $.ajax({
      type: "POST",
      url: "p_ax_speicher_wostd.php?nwostd=" + numWoStd + "&" + strPar,
        error: function(response) 
        {
          numSuccess=0;
          alert(response.responseText);
        }
      }); // Ende AJAX.

      if (numSuccess == 1)
      {
         alert('Wochenstundenzahl gespeichert!');                  // Rückmeldung.
      } // IF: Ajax erfolgreich?   

  } // IF: Parameter angegeben?  

} // Ende Funktion js_speicher_wostd.

// -----------------------------------------


// -----------------------------------------
// =========================================

</script>
