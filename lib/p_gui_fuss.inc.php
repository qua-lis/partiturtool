<?php
  // p_gui_fuss.inc.php
  // Fuß-Block für alle Seiten.
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 15-DEC-2011.
  // cp, 15-OCT-2012
  // -------------------------------------------------------------
  
  // Änderungsdatum aus globaler Variable:
  $strDatum="Systemdatum: " . date("d.m.Y",time()) . ".";
  $strDatum = (empty($strGChangeDate)) ? $strDatum :  ("Letzte Aktualisierung dieser Seite: $strGChangeDate, $strDatum ");
  $strDatum .= (empty($strGAppVersion)) ? '' : $strGAppVersion;
  $strDatum .= (empty($numGDMVersion)) ? '' : " / DM: $numGDMVersion";
  $strFussZeile=(empty($strGAppFuss)) ? "&copy; Ministerium f&uuml;r Schule und Weiterbildung des Landes Nordrhein-Westfalen" : $strGAppFuss;

/*  
  echo "\n\n<!-- 
          Nur als Kommentar: 
          $strDatum Instanz: " 
          . ((isset($strGAppText)) ? $strGAppText : "-undef?-") 
          . " - " . ((isset($strGDBName)) ? $strGDBName : "-undef?-") .
       "\n-->\n";   
*/       
 echo "  </div></div> <!-- pinhalt --> \n";
 echo "   <div id='navigation'>$strGStatus\n";
 echo "   </div>\n"; 
 echo "   <div id='pfooter'>\n";
 echo "     <p>$strFussZeile<br />\n";
 echo "      $strDatum \n";
 echo "     </p>\n";
 echo "   </div> <!-- end #pfooter -->\n";
 echo "   </div> <!-- pcontainer --> \n"; 
 echo " </body>\n";
 echo "</html>\n";
?>
