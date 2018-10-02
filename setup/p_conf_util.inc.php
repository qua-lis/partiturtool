<?php
  // p_conf_util.inc.php
  // 
  // Hilfsfunktionen für Setup-Routine.
  //
  // Die Routine liest die Musterdatei p_sys_konfig_instanz.muster.inc.php ein und die
  // Variablen in p_conf_variablen.inc.php.
  // 
  // Funktionen:
  //
  //  * Spezielle p (Partituren)
  //    p_conf_head()
  //    p_conf_foot()
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // © Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 25-NOV-2013.
  // -------------------------------------------------------------



// -------------------------------------------

function p_conf_head()
{
  // Kopfbereich der Setup-Seiten.
  //
  // fh, 25-NOV-2013.

  echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> \n";
  echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='de' lang='de'> \n";
  echo "<head> \n";
  echo "  <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-15' /> \n";
  echo "  <meta http-equiv='content-language' content='de' /> \n";
  echo "  <title>Setup des Partiturtools</title> \n";
  echo "  <link media='screen,print' rel='stylesheet' type='text/css' href='p_setup.css'> \n";
  echo " </head> \n";
  echo "<body >\n";
  echo "<div id='pcontainer'> \n";

  // Ende: p_conf_head.
}

// -------------------------------------------

function p_conf_foot()
{
  // Fußbereich der Setup-Seiten.
  //
  // fh, 25-NOV-2013.

  echo "   </div> <!-- pcontainer --> \n"; 
  echo " </body>\n";
  echo "</html>\n";

  // Ende: p_conf_foot.
}

// -------------------------------------------

function p_conf_file_header($strDatTyp,$strDatei="",$strPfad="")
{
  // Gibt einen Export-Header zum Starten des Downloads von Dateien aus.
  //
  // Parameter:
  //    $strDatTyp   -   Dateityp (Datei-Endung wie "csv").
  //    $strDatei    -   (optional): Dateiname, der angezeigt wird.
  //    $strPfad     -   (optional): Dateipfad, der dann direkt ausgegeben wird.
  // 
  // Rückgabe:
  //    keine
  //
  // Friedel Hosenfeld -- hosenfeld@digsyland.de
  // fh, 25-NOV-2013.

  // --------------------------------------------------------------------------------------------
  // Dateidownload:
  // --------------------------------------------------------------------------------------------
  // Diese Anweisung ist für den IE 6 wichtig, damit
  // er die Session-Informationen akzeptiert:
  header("Cache-Control: public");
  if (($strDatTyp=="") and ($strDatei!=""))
  {
    $strDateityp=strtolower(substr($strDatei,-3));  // Dateiendung als Typ nehmen.
  }
  else
  {
    $strDateityp=$strDatTyp;
  } // IF: Dateityp angegeben?  

  // Passenden Datentyp erzeugen:
  header("Content-Type: application/$strDateityp");

  $strBrowserTyp=$_SERVER["HTTP_USER_AGENT"];
  // Zum Debuggen: Typ des Browsers:
  // echo "Browser: " . $_SERVER["HTTP_USER_AGENT"];

  // Jetzt wird speziell auf NS4.x geprüft. Leider geben IE und
  // Opera zum Teil auch Mozilla4 an, so dass wir auch
  // gucken, dass "MSIE" nicht im Typ vorkommt.
  // Kleiner Trick für folgende Abfrage:
  // Ein 'X' wird vorangestellt, damit der String an Position 1 und nicht 0 steht.
  // Position 0 lässt sich nicht so gut von 'false' = 'nicht gefunden' unterscheiden:
  if (     (strpos("X" . $strBrowserTyp,"Mozilla/4.") == 1)
       AND (strpos($strBrowserTyp,"MSIE") === FALSE))   // 3 Gleichheitszeichen !
  {
    // Dies ist wichtig, damit NS 4 die Datei abspeichert und nicht
    // ohne Rückfrage anzeigt:
    header("Content-Type: x-type/subtype");
  } // IF: NS 4.x?

  // Dateigröße feststellen und ausgeben:
  if ($strPfad != "")
  {
    $intLen=filesize($strPfad);
    header("Content-Length: $intLen");
  } // IF: Pfad angegeben?

  // Passenden Dateinamen im Download-Requester vorgeben.
  header("Content-Disposition: attachment; filename=$strDatei");
  // Um den Dateinamen dürfen keine Anführungszeichen stehen, auch
  // wenn das von einigen Browser trotzdem interpretiert wird!

  if ($strPfad !="")
  {
    // Datei ausgeben.
    readfile($strPfad);
  } // IF: Pfad angegeben?
  
} // Ende p_conf_file_header.


// ---------------------------------------------------



  
?>
