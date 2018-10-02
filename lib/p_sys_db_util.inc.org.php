<?php
  // p_sys_db_util.inc.php
  // Spezialversion von db_util.inc.php
  // Öffnet die Datenbank und stellt nützliche Funktionen zur Verfügung.
  // Diese Datei kann in Abhängigkeit vom verwendeten Datenbanksystem gestaltet werden.
  //
  // DigSyLand http://www.digsyland.de/
  // Friedel Hosenfeld -- hosenfeld@digsyland.de
  //
  // Funktionen:
  //    function open_database()
  //    function db_exec($strQuery,$boolDebug=false)
  //    function db_fetch_arr($strBefehl,&$arrErgebnis)
  //    function db_get_value($strSpalte,$strTabelle,$strBedingung="",$boolDebug=false)
  //    function db_get_value_nl($strSpalte,$strTabelle,$strBedingung)
  //    function db_get_2values($strSpalte1,$strSpalte2,$strTabelle,$strBedingung,&$strErg1,&$strErg2)
  //    function db_get_3values($strSpalte1,$strSpalte2,$strSpalte3,$strTabelle,$strBedingung,
  //                            &$strErg1,&$strErg2,&$strErg3)
  //    function db_exist_table($strTabelle)
  //    function db_zeitstempel()
  //    function db_list_tables($strTabOwner="",$strCond="")
  //    function db_table_attribs($strTabelle)
  //    function db_insert_blob_oracle($strInsTab,$arrBindAtts,$arrDirectAtts,$arrBLOB,$boolDebug=false)
  //    function db_insert_return_oracle($strInsSQL,$strReturnAtt,$boolDebug=false)
  //    function db_oracle_dberror($numLen=0)
  //    function db_get_tabledata($strTabelle,$strIdxAtt='',$strCond='',$strOrderBy='',$boolDEBUG=false)
  //
  // fh, 10-JUN-2002.
  // ...
  // lr: fh, 19-MAY-2011, V3.02: Konsolidierung von Version 2.03 und 3.01, Übernahme von db_zeitstempel.
  // lr: fh, 15-DEC-2011, Anpassung an Partituren-Projekt.
  // ---------------------------------------------------------------------------------------------------
  
  // Globale Variablen (user,pass, ...) wurden in den jeweiligen XX_inivars.inc.php initialisiert.
  
  // ---------------------------------------------------------------------------------------------------
  $strGDBUtilVersion="3.02";
  $arrGDBError=array();         // Globale DB-Fehlervariable initialisieren.
                                // Beispiel: Array ( [code] => 24315 [message] => ORA-24315: Unzulässiger Attributtyp 
                                //                   [offset] => 33 [sqltext] => ) 
  // ---------------------------------------------------------------------------------------------------


  // ---------------------------------------------------------------------------------------------------
  // Variablen aus  p_sys_konfig_instanz.inc.php zuordnen:
  $dbtype=$strGDBtype;
  $dbsid=$strGDBSID;
  $dbuser=$strGDBUser;
  $dbpass=$strGDBPass;
  $schema=$strGDBName;
  $dbname=$strGDBName;   // DBName entspricht Schema in MySQL-
  $dbhost=$strGDBHost;
  // ---------------------------------------------------------------------------------------------------
  

  // Datenbank öffnen:
  global $dbtype;


  // Bei MySQL Datenbank einstellen:
  if ($dbtype == "mysql")
  {
    mysql_select_db($dbname, open_database());
  }


// ---------------------------------------------------

  function open_database()
  {

    // Öffnet die Datenbank zur weiteren Verwendung.
    //
    // fh, 10-JUN-2002.
    // lr: fh, 19-JUL-2003, MySQL.
    // lr: fh, 24-NOV-2005, Microsoft SQL Server.
    // lr: fh, 11-MAY-2006, keine Fehlermeldung bei fehlerhaften Verbindungsdaten.
    // lr: fh, 06-JAN-2006, Oracle-Verbindungen nicht mehr persistent öffnen.
    // lr: fh, 18-MAY-2010, PostgreSQL.

    // Globale Variablen auslesen:
    global $dbuser;
    global $dbpass;

    global $dbtype;

    switch ($dbtype)
    {
      case "oracle":
        // Oracle-DB:
        global $dbsid;
      // DEBUG: echo "ocilogon($dbuser,$dbpass,$dbsid)";
        // Datenbank öffnen: [ociplogon für persistente Verbindung, sonst ocilogon]
        $dblink = @ocilogon($dbuser,$dbpass,$dbsid); 
                  // or
                  // die("Datenbank-Fehler (Oracle): Kann DB $dbsid nicht öffnen.");
                // @ociplogon($dbuser,$dbpass,$dbsid);  CID:fh070106
        return $dblink;
        break;
        // --------- Ende Oracle ---------
     case "mysql":   
        // Datenbanktyp MySQL
        global $dbhost;
        // Datenbank persistent (=p) öffnen
        $dblink = @mysql_connect($dbhost,$dbuser,$dbpass) or
                  die("Datenbank-Fehler: Die Datenbank ist momentan überlastet, bitte versuchen Sie, die Seite neu zu laden!  (MySQL $dbhost) ");
        return $dblink;
        break;
        // --------- Ende MySQL ---------
     case "mssqlserver":   
        // Datenbanktyp Microsoft SQL-Server
        global $dbhost;
        $dblink= @mssql_connect ($dbhost,$dbuser,$dbpass) or
                   die("Datenbank-Fehler: Die Datenbank ist momentan nicht erreichbar!  (MS SQL-Server $dbhost) ");
        return $dblink;
        break;
        // --------- Ende Microsoft SQL-Server ---------
     case "postgresql":   
        // Datenbanktyp PostgreSQL
        global $dbhost;
        global $dbsid;
        // Datenbank persistent (=p) öffnen (sonst: pg_connect).
        $dblink = pg_pconnect("host=$dbhost dbname=$dbsid user=$dbuser password=$dbpass")
                  or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

        return $dblink;
        break;
        // --------- Ende PostgreSQL ---------
     default:
        die("Unbekannter Datenbanktyp");
        break;
        // --------- Ende: Sonstiges ---------
    } // Ende der Fallunterscheidung.

    // Ende von open_database
  }


// ---------------------------------------------------
  function db_exec($strQuery,$boolDebug=false)
  {
     // Bereitet DB-Statement zur Ausführung vor und führt ihn aus.
     // Oracle-(OCI)-Version.
     //
     // fh, 10-JUN-2002.
     // lr: fh, 22-JUL-2003, MySQL.
     // lr: fh, 05-NOV-2003, Oracle: Fehlerhafte DB-Verbindung abfangen.
     // lr: fh, 05-FEB-2004, Zusammenführung Ora Neu / MySQL.
     // lr: fh, 24-NOV-2005, Microsoft SQL Server.
     // lr: fh, 25-OCT-2006, Debug-Parameter.
     // lr: fh, 05-JAN-2010, Fehler in globale Variable $arrGDBError schreiben (nur Oracle bisher).
     //                      Damit kann ggf. eine Fehler-Analyse erfolgen.
     // lr: fh, 18-MAY-2010, PostgreSQL.
     
     global $dbtype;
     global $arrGDBError;
     if ($boolDebug)
     {
        // DEBUG: 
        echo "<br />DBExec:<pre>$strQuery</pre><br/>\n";
     } // IF: Debug?  


     // Fallunterscheidung nach Datenbank-Typen:
     switch ($dbtype)
     {
       case "oracle":
         // Oracle-DB:
         $rscDBLink=open_database();
         if (!$rscDBLink)
         {
           return $rscDBLink;
         }  
         else
         {
           $intBefehl = ociparse(open_database(),$strQuery);
           if (!$intBefehl)
           {
             $arrGDBError=ocierror();
             return $intBefehl;
           }
           else
           {
             if (@ociexecute($intBefehl))
             {
               return $intBefehl;
             }
             else
             {
               $arrGDBError=ocierror($intBefehl); // Fehlermeldung in globale Variable schreiben.
               if ($boolDebug) { print_r($arrGDBError); }
               return FALSE;
             }  
           }  // IF: Befehl ok?
         }  // IF: open_database ok?
         // --------- Ende Oracle ---------
       case "mysql":   
         // Datenbanktyp MySQL
         // DEBUG: echo "<br />DBExec:<pre>$strQuery</pre><br/>\n";
         return mysql_query($strQuery,open_database());
         break;
         // --------- Ende MySQL ---------
       case "mssqlserver":   
         // Datenbanktyp Microsoft SQL Server
         // DEBUG: echo "<br />DBExec:<pre>$strQuery</pre><br/>\n";
         return mssql_query ($strQuery,open_database());
         break;
         // --------- Ende Microsoft SQL Server ---------
       case "postgresql":   
         // Datenbanktyp PostgreSQL:
         // DEBUG: trigger_error("DEBUG: $strQuery");
         $resCon=pg_query(open_database(),$strQuery);
         if (!$resCon)
         {
            // Fehler in Log-Datei schreiben:
            trigger_error("DEBUG: " . pg_last_error());
            trigger_error("DEBUG Fehler in Anfrage: $strQuery");
         }// IF: Fehler in PG-Anfragè?   
         return ($resCon);
         break;
         // --------- Ende PostgreSQL ---------
       default:
         die("Unbekannter Datenbanktyp");
         break;
        // --------- Ende: Sonstiges ---------
     } // Ende der Fallunterscheidung.

   } // Ende db_exec.


// ---------------------------------------------------

  function db_fetch_arr($resBefehl,&$arrErgebnis)
  {
     // Holt Daten in ein Array (für While-Schleife).
     // Oracle-(OCI)-, MySQL- und MS SQL Server, PostgreSQL-Version.
     //
     // Parameter:
     //     - $resBefehl:   Resource-ID für einen Datenbank-Befehl (mit db_exec erzeugt).
     //     - $arrErgebnis: By Reference übergebenes Array, in dem das Ergebnis der DB-Abfrage abgelegt wird.
     // Wenn ein Fehler auftritt, wird FALSE zurückgegeben.    
     //
     // ACHTUNG: In Oracle müssen die Attribute (Feldnamen) bei den Assoziativen Arrays
     //          komplett gross geschrieben werden!
     //          In MySQL und SQL Server müssen sie exakt so geschrieben werden, wie sie
     //          in der Anfrage formuliert sind.
     //          Also sollten die Attribute für maximale Kompabilität
     //          im SQL-Statement und als Array-Index gross geschrieben werden.
     //
     // fh, 10-JUN-2002
     // lr: fh, 14-OCT-2002, +OCI_RETURN_NULLS hinzugefügt.
     // lr: fh, 22-JUL-2003, MySQL. $strBefehl der Klarheit halber in $resBefehl geändert.
     // lr: fh, 24-NOV-2003, Oracle: Fehlermeldung wird ggf. unterdrückt.
     //                              Damit z.B. Zugriffe auf Tabellen ohne entsprechende Rechte 
     //                              keine Warnungen oder Fehler in der Ausgabe produzieren.
     // lr: fh, 05-FEB-2004, Zusammenführung Ora Neu / MySQL.
     // lr: fh, 24-NOV-2005, Microsoft SQL Server.
     // lr: fh, 30-NOV-2005, Korrektur in Oracle-Version.
     // lr: fh, 28-MAR-2007, modifiziert, um Oracle-LOBs auszulesen (nur Oracle).
     // lr: fh, 18-MAY-2010, PostgreSQL.


     global $dbtype;
     // Fallunterscheidung nach Datenbank-Typen:
     switch ($dbtype)
     {
       case "oracle":
         // Oracle-DB:
         return @ocifetchinto($resBefehl,$arrErgebnis,OCI_ASSOC + OCI_RETURN_NULLS + OCI_RETURN_LOBS);
         // --------- Ende Oracle ---------
       case "mysql":   
         // Datenbanktyp MySQL:
         // In MySQL wird das Ergebnisübergabe wie in Oracle nachgebildet.
         // Dadurch bleibt die Funktion kompatibel zu Oracle, ohne dass der Code geändert werden müsste.
         if ($resBefehl)
         {
           return ($arrErgebnis=mysql_fetch_array($resBefehl));
         }
         else
         {
           // Falls die Anfrage schon fehlerhaft war, nichts zurückgeben.
           return false;
         }
         break;
         // --------- Ende MySQL ---------
       case "mssqlserver":   
         // Datenbanktyp Microsoft SQL Server:
         if ($resBefehl)
         {
           return ($arrErgebnis=mssql_fetch_array ($resBefehl));
         }
         else
         {
           // Falls die Anfrage schon fehlerhaft war, nichts zurückgeben.
           return false;
         }
         break;
         // --------- Ende Microsoft SQL Server ---------
      case "postgresql":   
         // Datenbanktyp PostgreSQL
         // In PostgreSQL wird das Ergebnisübergabe wie in Oracle nachgebildet.
         // Dadurch bleibt die Funktion kompatibel zu Oracle, ohne dass der Code geändert werden müsste.
         if ($resBefehl)
         {
           return ($arrErgebnis=pg_fetch_array($resBefehl,null, PGSQL_ASSOC));
           // Diese Funktion setzt NULL Felder auf den PHP Wert NULL.
         }
         else
         {
           // Falls die Anfrage schon fehlerhaft war, nichts zurückgeben.
           return false;
         }
         break;
         // --------- Ende PostgreSQL ---------
       default:
         die("Unbekannter Datenbanktyp");
         break;
         // --------- Ende: Sonstiges ---------
     } // Ende der Fallunterscheidung.

  } // Ende: db_fetch_arr

// ---------------------------------------------------


function db_get_value($strSpalte,$strTabelle,$strBedingung="",$boolDebug=false)
{
   // Holt einen einzigen Wert aus einer Tabelle.
   // Version für Oracle-(OCI), MySQL, MSSQL und PostgreSQL.
   //
   // Parameter:
   //
   // fh, 10-JUN-2002
   // lr: fh, 29-OCT-2002, Wenn Aufruf fehlschlägt: leerer String.
   // lr: fh, 19-JUL-2003, MySQL.
   // lr: fh, 20-JUL-2003, Vervollständigung.
   // lr: fh, 05-NOV-2003, Oracle: Fehlerhafte DB-Verbindung abfangen.
   // lr: fh, 05-FEB-2004, Zusammenführung Ora Neu / MySQL.
   // lr: fh, 29-JUL-2005, Bedingung standardmäßig leer setzen, so dass dieser Parameter fehlend darf.
   // lr: fh, 02-AUG-2005, MySQL-Version gibt bei leerer Menge keinen Fehler mehr aus.
   // lr: fh, 24-NOV-2005, Microsoft SQL Server.
   // lr: fh, 16-OCT-2006, Debug-Parameter.
   // lr: fh, 18-MAY-2010, PostgreSQL.

   global $dbtype;


   $strAS=($dbtype=="postgresql") ? " AS " : "";  // Bei PostgreSQL immer ein AS setzen.
   $strBefehl="SELECT " . $strSpalte . $strAS . " Feld FROM " . $strTabelle;

   if ($strBedingung != "")
   {
       $strBefehl .= " WHERE " . $strBedingung;
   }
   // DEBUG:
   if ($boolDebug)
   {
      echo "<br />SQL:<pre>$strBefehl</pre><br />\n";
   }   

   // Fallunterscheidung nach Datenbank-Typen:
   switch ($dbtype)
   {
     case "oracle":
       // Oracle-DB:
       $intExec=db_exec($strBefehl);
       if (!$intExec)
       {
          // Fehlerhafte DB-Connection oder Befehl.
          return $intExec;
       }
       else
       {
         if (ocifetch($intExec))
         {
           $strErgebnis=ociresult($intExec,"FELD");
         }
         else
         {
           $strErgebnis="";
         }
         return $strErgebnis;
       }  // IF: db_exec ok?  
       // --------- Ende Oracle ---------
     case "mysql":   
       // Datenbanktyp MySQL:
       $resErgebnis = mysql_query($strBefehl,open_database());
       $strErgebnis = "";
       // Prüfen, ob Datenbank-Abfrage gültig ist:
       if ($resErgebnis)
       {
           // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
           $strErgebnis = @mysql_result($resErgebnis,0,0);
       }    
       return $strErgebnis;
       break;
       // --------- Ende MySQL ---------
     case "mssqlserver":   
       // Datenbanktyp Microsoft SQL Server:
       $resErgebnis = mssql_query($strBefehl,open_database());  // Hier könnten mit dem @ Fehler unterdrückt werden!
       // Prüfen, ob Datenbank-Abfrage gültig ist:
       if ($resErgebnis === FALSE)
       {
         return "";
       }
       else
       {
           // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
           $strErgebnis = @mssql_result($resErgebnis,0,0);  // Datensatz 0 (=1.), Attribut 0 (=1.)
       }    
       return $strErgebnis;
       break;
       // --------- Ende Microsoft SQL Server ---------
     case "postgresql":   
       // Datenbanktyp PostgreSQL:
       $resErgebnis = pg_query(open_database(),$strBefehl);
       $strErgebnis = "";
       // Prüfen, ob Datenbank-Abfrage gültig ist:
       if ($resErgebnis)
       {
           // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
           $strErgebnis = @pg_fetch_result($resErgebnis,0,0);  // 1. Feld aus 1. Spalte zurückgeben.
       }    
       return $strErgebnis;
       break;
       // --------- Ende PostgreSQL ---------
     default:
       die("Unbekannter Datenbanktyp.");
       break;
       // --------- Ende: Sonstiges ---------
   } // Ende der Fallunterscheidung.

   // Ende db_get_value.
}


// ---------------------------------------------------


  function db_get_value_nl($strSpalte,$strTabelle,$strBedingung)
  {
     // Holt einen einzigen Wert aus einer Tabelle und prüft
     // vorher, ob es überhaupt ein Ergebnis gibt. Wenn es
     // keines gibt, wird ein leerer String "" zurückgegeben.
     //
     // DIESE FUNKTION IST NUR AUS KOMPABILITÄTSGRÜNDEN VORHANDEN, WIRD NICHT MEHR BENÖTIGT!
     //
     // Oracle-(OCI)- & MySQL-Version.
     // 
     // Parameter:
     //
     // fh, 28-OCT-2002.
     // lr: fh, 22-JUL-2003, Anpassung an MySQL.
     // lr: fh, 23-JUL-2003, dbtype korrigiert.
     // lr: fh, 24-NOV-2003, Oracle: Abfangen von DB-Fehlern.
     // lr: fh, 05-FEB-2004, Zusammenführung Ora Neu / MySQL.

     global $dbtype;


     $strPruefBefehl="SELECT COUNT(" . $strSpalte . ") Anzahl FROM " . $strTabelle;
     $strBefehl="SELECT " . $strSpalte . " Feld FROM " . $strTabelle;
     if ($strBedingung != "")
     {
       $strPruefBefehl .= " WHERE " . $strBedingung;
       $strBefehl .= " WHERE " . $strBedingung;
     }

     // DEBUG.
     // echo "<p>Befehl: $strBefehl <p>\n";
     // echo "<p>PruefBefehl: $strPruefBefehl <p>\n";

       if ($dbtype == "oracle")
       {
         // ORACLE:
         $strErgebnis="";
         $intPruef=db_exec($strPruefBefehl);
         if (!$intPruef)
         {
            // Fehlerhafte DB-Connection oder Befehl: Leerstring.
            $strErgebnis="";
         }
         else
         {
           if (ocifetch($intPruef))
           {
             $intAnzahl=ociresult($intPruef,"ANZAHL");
             if ($intAnzahl > 0)
             {
               $intExec=db_exec($strBefehl);
               ocifetch($intExec);
               $strErgebnis=ociresult($intExec,"FELD");
             } // IF: DS gefunden?
           } // IF: Anzahl ohne Fehler ermittelbar?
         } // IF: Fehler bei Anfrage?

         return $strErgebnis;
         // ENDE: Oracle.
       }
       else
       {
         // MySQL:
         // DEBUG:
         // echo "get_value_nl: $strBefehl\n";

         // Prüfen, ob Datensätze vorhanden sind:
         $strErgebnis="";
         $resPruef = mysql_query($strPruefBefehl,open_database());
         if ($resPruef)
         {
           if (mysql_result($resPruef,0,0) > 0)
           {
             $resErgebnis = mysql_query($strBefehl,open_database());
             if ($resErgebnis)
             {
               $strErgebnis = mysql_result($resErgebnis,0,0);
             }  // IF: Anfrage gültig & fehlerfrei?
           }   // IF: Datensätze vorhanden?
         }  // IF: Datensatz-Zähl-Anfrage gültig & fehlerfrei?
         return $strErgebnis;
         // ENDE: MySQL.

       } // IF: Oracle oder MySQL?

      // Ende db_get_value_nl.
  }

// ---------------------------------------------------


  function db_get_2values($strSpalte1,$strSpalte2,$strTabelle,$strBedingung,&$strErg1,&$strErg2,$boolDebug=false)
  {
     // Holt genau zwei Werte aus einer Tabelle.
     // Version für Oracle-(OCI), MySQL, MSSQL und PostgreSQL.
     //
     // Parameter:
     //
     // fh, 15-SEP-2002.
     // lr: fh, 22-JUL-2003, Anpassung an MySQL.
     // lr: fh, 23-JUL-2003, dbtype korrigiert.
     // lr: fh, 10-JUL-2006, Code-Optimierungen (Anpassungen an SQL-Server).
     // lr: fh, 08-FEB-2007, Debug-Parameter.
     // lr: fh, 13-FEB-2007, Konsolidierung.
     // lr: fh, 28-FEB-2007, Fehlermeldungen in MySQL vermeiden.
     // lr: fh, 11-DEC-2007, Oracle: leere Ergebnisse abgefangen.
     // lr: fh, 18-MAY-2010, PostgreSQL.

     global $dbtype;

     $strAS=($dbtype=="postgresql") ? " AS " : "";  // Bei PostgreSQL immer ein AS setzen.
     $strBefehl="SELECT " . $strSpalte1 . $strAS . " Feld1, " . $strSpalte2 . $strAS . " Feld2 FROM " . $strTabelle;
     if ($strBedingung != "")
     {
       $strBefehl .= " WHERE " . $strBedingung;
     }

     if ($boolDebug)
     {
       // DEBUG:
       echo "<br />DEBUG db_get_2values<pre>$strBefehl</pre>\n";
     }  // DEBUG?
 
     $strErg1="";
     $strErg2="";

     // Fallunterscheidung nach Datenbank-Typen:
     switch ($dbtype)
     {
       case "oracle":
         // Oracle-DB:
         $intExec=db_exec($strBefehl);
         if (($intExec) and (ocifetch($intExec)))
         {
           $strErg1=ociresult($intExec,"FELD1");
           $strErg2=ociresult($intExec,"FELD2");
         }  // IF: Gültiger Befehl?
         break;
         // --------- Ende Oracle ---------
       case "mysql":   
         // Datenbanktyp MySQL:
         $resErgebnis = mysql_query($strBefehl,open_database());
         // Fehlermeldungen vermeiden:
         $arrErgebnis=array("","");
         if ($resErgebnis)
         {
           // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
           $arrErgebnis = @mysql_fetch_row($resErgebnis);
         } // IF: Ergebnis-Satz?  
         $strErg1=$arrErgebnis[0];
         $strErg2=$arrErgebnis[1];
         break;
         // --------- Ende MySQL ---------
       case "mssqlserver":   
         // Datenbanktyp Microsoft SQL Server:
         $resErgebnis = mssql_query($strBefehl,open_database());  // Hier könnten mit dem @ Fehler unterdrückt werden!
         // Prüfen, ob Datenbank-Abfrage gültig ist:
         if (!($resErgebnis === FALSE))
         {
            $arrErgebnis = @mssql_fetch_array($resErgebnis);
            $strErg1=$arrErgebnis[0];
            $strErg2=$arrErgebnis[1];
         }    
         break;
         // --------- Ende Microsoft SQL Server ---------
       case "postgresql":   
         // Datenbanktyp PostgreSQL:
         $resErgebnis = pg_query(open_database(),$strBefehl);
         // Prüfen, ob Datenbank-Abfrage gültig ist:
         if ($resErgebnis)
         {
             // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
             $arrErgebnis=@pg_fetch_assoc($resErgebnis);
             $strErg1 = $arrErgebnis["feld1"];
             $strErg2 = $arrErgebnis["feld2"];
         }    
       break;
       // --------- Ende PostgreSQL ---------
       default:
         die("Unbekannter Datenbanktyp.");
         break;
         // --------- Ende: Sonstiges ---------
     } // Ende der Fallunterscheidung.
     

  } // Ende db_get_2values.

// ---------------------------------------------------

  function db_get_3values($strSpalte1,$strSpalte2,$strSpalte3,$strTabelle,$strBedingung,
                          &$strErg1,&$strErg2,&$strErg3,$boolDebug=false)
  {
     // Holt genau drei Werte aus einer Tabelle.
     // Version für Oracle-(OCI), MySQL, MSSQL und PostgreSQL.
     //
     //
     // fh, 13-OCT-2002.
     // lr: fh, 22-JUL-2003, Anpassung an MySQL.
     // lr: fh, 23-JUL-2003, dbtype korrigiert.
     // lr: fh, 18-DEC-2007, Oracle: leere Ergebnisse abgefangen.
     // lr: fh, 12-JAN-2009, Debug-Parameter.
     // lr: fh, 18-MAY-2010, PostgreSQL und mssqlserver, CASE-Fallunterscheidung.

     global $dbtype;

     // Initialisieren:
     $strErg1="";
     $strErg2="";
     $strErg3="";

     $strAS=($dbtype=="postgresql") ? " AS " : "";  // Bei PostgreSQL immer ein AS setzen.
     $strBefehl="SELECT " . $strSpalte1 . " $strAS Feld1, " .
                            $strSpalte2 . " $strAS Feld2, " .
                            $strSpalte3 . " $strAS Feld3 FROM " . $strTabelle;
     if ($strBedingung != "")
     {
       $strBefehl .= " WHERE " . $strBedingung;
     }

     if ($boolDebug)
     {
       // DEBUG:
       echo "<br />DEBUG db_get_3values<pre>$strBefehl</pre>\n";
     }  // DEBUG?

     // Fallunterscheidung nach Datenbank-Typen:
     switch ($dbtype)
     {
       case "oracle":
         // Oracle-DB:
         $intExec=db_exec($strBefehl);
         if (($intExec) and (ocifetch($intExec)))
         {
           $strErg1=ociresult($intExec,"FELD1");
           $strErg2=ociresult($intExec,"FELD2");
           $strErg3=ociresult($intExec,"FELD3");
         } // IF: Ergebnis vorhanden?  
         break;
         // --------- Ende Oracle ---------
       case "mysql":   
         // Datenbanktyp MySQL:
         $resErgebnis = mysql_query($strBefehl,open_database());
         $arrErgebnis = mysql_fetch_row($resErgebnis);
         $strErg1=$arrErgebnis[0];
         $strErg2=$arrErgebnis[1];
         $strErg3=$arrErgebnis[2];
         break;
         // --------- Ende MySQL ---------
       case "mssqlserver":   
         // Datenbanktyp Microsoft SQL Server:
         $resErgebnis = mssql_query($strBefehl,open_database());  // Hier könnten mit dem @ Fehler unterdrückt werden!
         // Prüfen, ob Datenbank-Abfrage gültig ist:
         if (!($resErgebnis === FALSE))
         {
            $arrErgebnis = @mssql_fetch_array($resErgebnis);
            $strErg1=$arrErgebnis[0];
            $strErg2=$arrErgebnis[1];
            $strErg3=$arrErgebnis[2];
         }    
         break;
         // --------- Ende Microsoft SQL Server ---------
       case "postgresql":   
         // Datenbanktyp PostgreSQL:
         $resErgebnis = pg_query(open_database(),$strBefehl);
         // Prüfen, ob Datenbank-Abfrage gültig ist:
         if ($resErgebnis)
         {
             // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
             $arrErgebnis=@pg_fetch_assoc($resErgebnis);
             $strErg1 = $arrErgebnis["feld1"];
             $strErg2 = $arrErgebnis["feld2"];
             $strErg3 = $arrErgebnis["feld3"];
         }    
       break;
       // --------- Ende PostgreSQL ---------
       default:
         die("Unbekannter Datenbanktyp.");
         break;
         // --------- Ende: Sonstiges ---------
     } // Ende der Fallunterscheidung.

 } // Ende db_get_3values.

// ---------------------------------------------------

  function db_exist_table($strTabelle)
  {
     // Prüft, ob eine bestimmte Tabelle vorhanden ist.
     //
     // ACHTUNG:
     // Bisher nur MySQL- und Oracle-Version!
     // Ab MySQL 5 geht das über ein SQL-Statement.
     //
     // Parameter:
     //
     //     $strTabelle Name der zu überprüfenden Tabelle (inklusive schema.).
     //
     // fh, 27-SEP-2005.
     // lr: fh, 02-APR-2008, Oracle-Version.

     global $dbtype;
     global $schema;
     
     $boolExist=false;

     if ($strTabelle != "")
     {
       if ($dbtype == "oracle")
       {
          // ORACLE:
          // echo "<p>Fehler: Bisher keine Oracle-Version von db_exist_table! <p>\n";
          // In Oracle kann auch ein Fremdschema angegeben werden.
          $strOwner=strtoupper(strtok($strTabelle,"."));
          $strDBTab=strtoupper(strtok("."));
          if ($strOwner=="")
          {
            // Kein Owner angegeben: 
            $strDBTab=$strOwner;
            $strOwner=strtoupper($schema);  // Standardmäßig aktuelle Kennung nehmen.
          } // IF: Owner angegeben? 
          
          $numExist=db_get_value("COUNT(*)","ALL_TABLES","OWNER='$strOwner' AND TABLE_NAME='$strDBTab'");
          $boolExist=($numExist > 0);
          
       }  // Ende ORACLE.
       else
       {
          // MySQL:
          // Schema-Name aus dem Tabellen-Namen entfernen:
          $strBefehl="SHOW TABLES FROM $schema LIKE '" . str_replace($schema . ".","",$strTabelle) . "'";
          // DEBUG: echo "<p>SQL: $strBefehl <p>\n";

          $resErgebnis = mysql_query($strBefehl,open_database());
          $strErgebnis = "";
          // Prüfen, ob Datenbank-Abfrage gültig ist:
          if ($resErgebnis)
          {
              // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
              $strErgebnis = @mysql_result($resErgebnis,0,0);
          }    
          $boolExist = (($strErgebnis=="") ? false : true);
       }
     } // IF: Wurde Tabelle übergeben?  
     
     return $boolExist;
    // Ende db_exist_table.
  }

// ------------------------------------------------------------------------

  function db_zeitstempel()
  {
     // Gibt aktuellen Datenbank-Zeitstempel zurück.
     //
     // ACHTUNG:
     // Bisher nur MySQL-Version!
     //
     // Parameter:
     //     keine
     //
     // fh, 05-MAR-2007.

     global $dbtype;

     $strErgebnis="";
     
     if ($dbtype != "mysql")
     {
        // ORACLE:
        echo "<p>Fehler: Bisher keine Version von db_zeitstempel für den Datenbank-Typ $dbtype! <p>\n";
     }  // Ende ORACLE.
     else
     {
        // MySQL:
        $resErgebnis = mysql_query("SELECT now()",open_database());
        if ($resErgebnis)
        {
            // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
            $strErgebnis = @mysql_result($resErgebnis,0,0);
        }    
     } // IF: MySQL?
     
     return $strErgebnis;

    // Ende db_zeitstempel.
  }


// ---------------------------------------------------


  function db_list_tables($strTabOwner="",$strCond="")
  {
     // Listet alle Tabellen nach einem bestimmten Kriterium auf.
     // (nur Tabellen, in Oracle keine Objekte etc.).
     // Gibt Ergebnis als Array zurück.
     //
     // ACHTUNG:
     // Bisher nur MySQL- und Oracle-Version!
     //
     // Parameter:
     //
     //     $strOwner   (optional) zu durchsuchendes Schema, sonst aktuelles Schema.
     //     $strCond    (optional) Bedingung für den Tabellennamen für LIKE-Ausdruck (A% oder so).
     //
     // fh, 02-APR-2008.

     global $dbtype;
     global $schema;
     
     $strOwner=($strTabOwner=="") ? $schema : $strTabOwner;
     $arrTables=array();
     $arrSQL=array();
     $strSQL="";

     switch ($dbtype)
     {
       case "oracle":
         // Oracle-Version:
         $strSQL="SELECT DISTINCT TABLE_NAME TABNAME FROM ALL_TABLES
                   WHERE (OWNER='" . strtoupper($strOwner) . "') ";
         $strSQL .= ($strCond != "") ? " AND (TABLE_NAME LIKE '$strCond') " : "";          
         $strSQL .= " ORDER BY TABLE_NAME ";
         $stmtSQL=db_exec($strSQL);
         while (db_fetch_arr($stmtSQL,$arrSQL))
         {
           $arrTables[]=$arrSQL["TABNAME"];
         } // Schleife durch alle Datensätze.  
         break;
       case "mysql":
         // MySQL-Version:
         $strSQL="SHOW TABLES FROM $strOwner";
         $strSQL .= ($strCond != "") ? " LIKE '$strCond'" : "";
         $stmtSQL=db_exec($strSQL);
         while (db_fetch_arr($stmtSQL,$arrSQL))
         {
           $arrTables[]=$arrSQL[0];
         } // Schleife durch alle Datensätze.  
         break;
      default:
        echo "<p>Fehler: Bisher keine $dbtype-Version von db_list_tables! <p>\n";
        break;
    } // Ende der Fallunterscheidung.

    return $arrTables;
    // Ende db_list_tables.
  }

// ------------------------------------------------------------------------

function db_table_attribs($strTabelle)
{
  // Sucht alle Attribute zu einer gegebenen Tabelle heraus.
  //
  // ACHTUNG:
  // Ab MySQL 5 geht das über ein SQL-Statement.
  //
  // Parameter:
  //   $strTabelle Name der Tabelle (inklusive schema., außer bislang bei MS SQLServer).
  //
  // Rückgabe: 
  //    Array mit Liste der Attribute.
  // 
  // fh, 05-JUL-2006.
  // lr: fh, 06-JUL-2006, $schema bei MS SQL Server weggelassen.
  // lr: fh, 23-APR-2008, um MySQL und Oracle erweitert, bei MSSQLServer nur der Name.

  global $dbtype;
  global $schema;

  unset($arrAtts);
  
  switch ($dbtype)
  {
    case "oracle":
        // ORACLE:
        // echo "<p>Fehler: Bisher keine Oracle-Version von db_table_attribs! <p>\n";
        // Falls das Schema nicht im Tabellennamen enthalten ist, Standard-Schema verwenden.

        $strTabelle1=strtoupper($strTabelle);
        if (strpos($strTabelle,".") !== false)
        {
          $strOwner=substr($strTabelle1,0,strpos($strTabelle1,"."));
          $strTabelle1=substr($strTabelle1,strpos($strTabelle1,".")+1);
        }
        else
        {
          $strOwner=$schema;
        }    

        $strSQL="SELECT COLUMN_NAME,DATA_TYPE,DATA_LENGTH,DATA_PRECISION
                   FROM all_tab_columns
                  WHERE OWNER='$strOwner'
                    AND TABLE_NAME='$strTabelle1'";
        // DEBUG: echo "DEBUG:<br /><pre>$strSQL</pre><br />\n";
        // Data_Length ist interessant bei VARCHAR,
        // data_precision bei NUMBER, im Moment aber irrelvant.
        $stmtSQL=db_exec($strSQL);
        while (db_fetch_arr($stmtSQL,$arrSQL))
        {
          $strAtt=$arrSQL["COLUMN_NAME"];
          $arrAtts[$strAtt]["TYP"]=$arrSQL["DATA_TYPE"];
          if ($arrAtts[$strAtt]["TYP"]=="VARCHAR2")
          {
            $arrAtts[$strAtt]["LEN"]=$arrSQL["DATA_LENGTH"];
          }
          else
          {
            $arrAtts[$strAtt]["LEN"]="";
          } // IF: VARCHAR2?

        } // Ende der DB-Schleife durch die Attribute.
        // Ende ORACLE.
        break;
    case "mssqlserver":
        // Microsoft SQL Server:
        // Hier wird der Name bislang ohne Schema übergeben. Die Variable $schema enthält außerdem den Punkt.
        // Schema wird erstmal bei den Sys-Tabellen weggelassen:
        // vorher: 
        //             FROM " . $schema . "dbo.syscolumns AS dsc 
        //             INNER JOIN " . $schema . "dbo.sysobjects AS dso 
        // Aber es muss hier sonst der Datenbank-Name eingesetzt werden, nicht der in $schema abgelegte Username.
        $strSQL="SELECT dsc.name
                     FROM dbo.syscolumns AS dsc 
                     INNER JOIN dbo.sysobjects AS dso 
                        ON dsc.id=dso.id
                     WHERE dso.name='$strTabelle' 
                     ORDER BY dsc.colid";
          $stmtSQL=db_exec($strSQL);             
          while (db_fetch_arr($stmtSQL,$arrSQL))
          {
            // $arrAtts[]=$arrSQL["name"];
            $arrAtts[$arrSQL["name"]]["NAME"]=$arrSQL["name"];
          } // DB-Schleife durch die Attribute der Tabelle.  
          break;
          // Ende Microsoft SQL Server
   case "mysql":
       // MySQL:
       // Schema-Name aus dem Tabellen-Namen entfernen:
       // $strBefehl="SHOW TABLES FROM $schema LIKE '" . str_replace($schema . ".","",$strTabelle) . "'";
       // echo "<p>Fehler: Bisher keine MySQL-Version von db_table_attribs! <p>\n";
       $stmtSQL=db_exec("SELECT * FROM $strTabelle");
       $numFields = mysql_num_fields($stmtSQL);
       $numRows   = mysql_num_rows($stmtSQL);
       $strTable = mysql_field_table($stmtSQL, 0);
       // echo "Die Tabelle '".$strTable."'hat ".$numFields." Felder und ".$numRows." Datensätze:\n";
       // echo "Die Tabelle hat folgende Felder:\n";
       for ($intIdx=0; $intIdx < $numFields; $intIdx++) 
       {
         $strType  = mysql_field_type($stmtSQL, $intIdx);
         $strAttname  = mysql_field_name($stmtSQL, $intIdx);
         $numLen   = mysql_field_len($stmtSQL, $intIdx);
         $strFlags = mysql_field_flags($stmtSQL, $intIdx);
         $arrAtts[$strAttname]["TYP"]=$strType;
         $arrAtts[$strAttname]["LEN"]=$numLen;
         $arrAtts[$strAttname]["FLAGS"]=$strFlags;
         // echo $type." ".$name." ".$len." ".$flags."\n";
       } // FOR-Schleife durch die Attribute.
       
       break;
       // ENDE MySQL.
   default:
       // Sonstige?:
       echo "<p>Fehler: Bisher keine Version von db_table_attribs für Datenbank-Typ $dbtype! <p>\n";
       break;
  }  // Ende der Fallunterscheidung..
  
  
  return (isset($arrAtts) ? $arrAtts : "");
  // Ende db_table_attribs.
}

// ------------------------------------------------------------------------

function db_insert_blob_oracle($strInsTab,$arrBindAtts,$arrDirectAtts,$arrBLOB,$boolDebug=false)
{
  // Fügt BLOB in eine Oracle-Tabelle ein.
  //
  // ACHTUNG:
  // Version nur für ORACLE!
  // Falls später allgemeine Version ergänzt wird, sollte diese db_insert_blob heißen. 
  //
  //
  // siehe: http://wiki.oracle.com/page/PHP+Oracle+FAQ
  // http://de.php.net/manual/de/function.ocinewdescriptor.php
  // Dort auch:
  //   Just a note. When INSERTing a CLOB, if a VALUES clause is used, Oracle notes: 
  //   You cannot initialize an internal LOB attribute in an object with a value other than empty or null. 
  //   That is, you cannot use a literal.
  // Über die Methode mit den Bind-Variablen wird auch sichergestellt, dass Anführungszeichen nicht stören.
  //
  // Parameter:
  //   - $strInsTab:        Tabelle, in die eingefügt werden soll.
  //   - $arrBindAtts:      Array mit Bind-Attributen und Werten. Key = Attribut, Wert=Wert.
  //   - $arrDirectAtts:    Array mit direkt einzufügenden Attributen (wie sysdate). Key = Attribut, Wert=Wert.
  //                        Bei Wert müssen hier die einfachen Anführungszeichen ggf. mitenthalten sein: $strWert="'test'";
  //   - $arrBLOB:          Array mit BLOB-Attribut + BLOB-Wert + Angabe ob BLOB aus Variable oder Datei eingefügt wird.
  //                        3. Wert: "string" (default) oder "file".
  //   - $boolDebug:        (optional) wenn true, werden DEBUG-Angaben ausgegeben.
  //
  // Rückgabe: 
  //   - $boolErfolg        true, wenn erfolgreich. false sonst.
  //
  // Hinweis:
  //    Es werden nicht alle Parameter auf korrekte Inhalte geprüft (Vorhandensein der Tabelle, Füllung der Arrays).
  // 
  // fh, 30-SEP-2009 (V2.00).

  global $dbtype;
  global $schema;
  
  $boolErfolg=false;
 
  if ($dbtype=="oracle")
  {
    // Nur für Oracle:
    // ---------------
    $conConn=open_database();

    // Statement zusammenstellen, Beispiel:
    //  "INSERT INTO $strInsTab (IMPORT_ID, DATEINAME, IMPORT_DATUM, IMPORTER, DATEI, QK, BENUTZER)  "
    //  . " VALUES (:IMPORT_ID, :DATEINAME, SYSDATE, :IMPORTER, EMPTY_BLOB(), :QK, :BENUTZER) RETURNING DATEI INTO :DATEI");
    
    $strInsSQL="INSERT INTO $strInsTab (";
    $strInsAtts="";
    $strInsVals="";

    if (count($arrBindAtts) > 0)
    {
      foreach ($arrBindAtts as $strAtt => $strAttWert)
      {
        $strInsAtts .= "," . $strAtt;
        $strInsVals .= ",:" . $strAtt;
      } // Schleife durch Bind-Attribute. 
    } // IF: Bind-Variablen vorhanden?  

    if (count($arrDirectAtts) > 0)
    {
      foreach ($arrDirectAtts as $strAtt => $strAttWert)
      {
        $strInsAtts .= "," . $strAtt;
        $strInsVals .= "," . $strAttWert;
      } // Schleife durch Direkt-Attribute. 
    } // IF: Direkt-Variablen vorhanden?  
    
    $strBLOBAtt=$arrBLOB[0];
    $strBLOBType=($arrBLOB[2]=="file") ? "file" : "string";
    
    $strInsSQL .= $arrBLOB[0] . $strInsAtts  . ") " .
               " VALUES (EMPTY_BLOB() " . $strInsVals . " ) RETURNING $strBLOBAtt INTO :" . $strBLOBAtt; 

    if ($boolDebug) { echo "<br />DEBUG db_insert_blob_oracle:<pre>$strInsSQL</pre><br />\n"; }
    
    // Statement parsen und Bind-Variablen zuordnen:
    $lob = ocinewdescriptor($conConn, OCI_D_LOB);
    $stid = ociparse($conConn, $strInsSQL);
    
    if (count($arrBindAtts) > 0)
    {
      foreach ($arrBindAtts as $strAtt => $strAttWert)
      {
        ocibindbyname($stid, ':' . $strAtt, $arrBindAtts[$strAtt]); // ACHTUNG: Hier muss direkt das Array und nicht $strAttWert genommen werden!
        if ($boolDebug) { echo "ocibindbyname($stid, ':' . $strAtt, " . $arrBindAtts[$strAtt] . ");<br />\n"; }
      } // Schleife durch Bind-Attribute. 
    } // IF: Bind-Variablen vorhanden?  
    
    ocibindbyname($stid, ':' . $strBLOBAtt, $lob, -1, OCI_B_BLOB);
    $boolErfolg=ociexecute($stid, OCI_DEFAULT);
    
    // The function $lob->savefile(...) reads from the uploaded file.
    // If the data was already in a PHP variable $myv, the
    // $lob->save($myv) function could be used instead.
    // if ($lob->savefile($_FILES['lob_upload']['tmp_name'])) 
    if ($boolErfolg)
    {
      if ($strBLOBType=="string")
      {
        $boolErfolg=$lob->save($arrBLOB[1]);
      }
      else
      {
        $boolErfolg=$lob->savefile($arrBLOB[1]);
      } // IF: BLOB in String-Variable oder Datei?
      
      if ($boolErfolg)
      {
        ocicommit($conConn);
      }
      else 
      {
        echo "DB-Fehler: Oracle-BLOB konnte nicht gespeichert werden.\n";
      } // IF: Einfügen erfolgreich?  
    } // IF: Execute erfolgreich?
    
    // Aufräumen:
    $lob->free();
    ocifreestatement($stid);
    // ---------------------------------------------------------------
  }
  else
  {
    $strFehlertext="Fehler: Bisher keine Version von db_insert_blob_oracle für Datenbank-Typ $dbtype!";
    echo "<p> $strFehlertext<p>\n";
    trigger_error($strFehlertext);
  } // IF: Anderer Datenbanktyp?

  // Erfolg zurückgeben:
  return ($boolErfolg);

  // Ende db_insert_blob_oracle.
}

// ---------------------------------------------------

function db_insert_return_oracle($strInsSQL,$strReturnAtt,$boolDebug=false)
{
  // Führt ein Insert-Statement durch und gibt einen Return-Wert zurück.
  // Das ist sinnvoll, wenn z.B. eindeutige IDs (ohne Sequence) erzeugt werden sollen.
  // 
  // Funktioniert bei INSERT nur mit VALUES-Statement, aber auch bei UPDATE.
  //
  // ACHTUNG:
  // Version nur für ORACLE!
  // Falls später allgemeine Version ergänzt wird, sollte diese db_insert_return heißen. 
  //
  // Man könnte auch eine allgemeinere Version mit verschiedenen Return-Werten machen.
  // Diese soll möglichst einfach funktionieren.
  // 
  // siehe: http://www.psoug.org/reference/insert.html
  //
  // Parameter:
  //   - $strInsSQL:        SQL-Statement.
  //   - $strReturnAtt:     Attributname, das den Return-Wert enthält.
  //   - $boolDebug:        (optional) wenn true, werden DEBUG-Angaben ausgegeben.
  //
  // Rückgabe: 
  //   - $strReturnWert     Enthält den Returnwert, sonst leer.
  //
  // 
  // fh, 12-OCT-2009 (V2.01).

  global $dbtype;
  global $schema;
  
  $boolErfolg=false;
  $strReturnWert="";
 
  if ($dbtype=="oracle")
  {
    // Nur für Oracle:
    // ---------------
    $conConn=open_database();

    // Statement zusammenstellen, Beispiel:
    //  "INSERT INTO $strInsTab (IMPORT_ID, DATEINAME, IMPORT_DATUM, IMPORTER, DATEI, QK, BENUTZER)  "
    //  . " VALUES (:IMPORT_ID, :DATEINAME, SYSDATE, :IMPORTER, EMPTY_BLOB(), :QK, :BENUTZER) RETURNING DATEI INTO :DATEI");
    
    $strInsSQLStmt=$strInsSQL . " RETURNING $strReturnAtt INTO :" . $strReturnAtt;
    $stid = ociparse($conConn, $strInsSQLStmt);
    ocibindbyname($stid, ':' . $strReturnAtt, $strReturnWert); 
    if ($boolDebug) { echo "ocibindbyname($stid, ':' . $strReturnAtt, " . $strReturnWert . ");<br />\n"; }
    $boolErfolg=ociexecute($stid, OCI_DEFAULT);
    if ($boolDebug) { echo "<br />DEBUG db_insert_return_oracle:<pre>$strInsSQLStmt</pre><br />\n"; }

    if ($boolErfolg)
    {
      ocicommit($conConn);
      if ($boolDebug) { echo "db_insert_return_oracle strReturnWert: $strReturnWert <br />\n"; }
    }
    else 
    {
      trigger_error ("DB-Fehler: Oracle-Return-Insert konnte nicht durchgeführt werden.\n");
    } // IF: Einfügen erfolgreich?  
    
    // Aufräumen:
    ocifreestatement($stid);
    // ---------------------------------------------------------------
  }
  else
  {
    $strFehlertext="Fehler: Bisher keine Version von db_insert_return_oracle für Datenbank-Typ $dbtype!";
    echo "<p> $strFehlertext<p>\n";
    trigger_error($strFehlertext);
  } // IF: Anderer Datenbanktyp?

  // Erfolg zurückgeben:
  return ($strReturnWert);

  // Ende db_insert_return_oracle.
}

// --------------------------------------------------------------------

function db_oracle_dberror($numLen=0)
{
  // Bildet aus der globalen DB-Fehler-Array-Variable $arrGDBError einen String.
  //
  // Parameter:
  //   - $numLen:           (optional) kürzt Statement auf die angegebene Länge, wenn 0, dann nicht.
  //
  // Rückgabe: 
  //   - $strDBError     Enthält die Fehlerwerte.
  //
  // 
  // fh, 05-JAN-2010 (V2.02).

  global $arrGDBError;
  
  $strDBError="";
  
  if ((isset($arrGDBError)) and (count($arrGDBError) > 0))
  {
    $strDBError .= (isset($arrGDBError['code'])) ? ("Code: " . $arrGDBError['code'] . " ") : "";
    $strDBError .= (isset($arrGDBError['message'])) ? ("Msg: " . $arrGDBError['message'] . " ") : "";
    $strDBError .= (isset($arrGDBError['offset'])) ? ("Offs: " . $arrGDBError['offset'] . " ") : "";
    $strDBError .= (isset($arrGDBError['sqltext'])) ? ("SQL: " . $arrGDBError['sqltext'] . " ") : "";
    
    $strDBError = ($numLen > 0) ? substr($strDBError,0,$numLen) : $strDBError;
  } // IF: Liegt Fehler-Info vor?
  
  return ($strDBError);

} // Ende db_oracle_dberror

// --------------------------------------------------------------------


function db_get_tabledata($strTabelle,$strIdxAtt='',$strCond='',$strOrderBy='',$boolDEBUG=false)
{
     // Lädt alle Daten einer Tabelle in ein assoziatives Array,
     // die der Bedingung $strCond entsprechen (nur wenn angegeben).
     //
     // Parameter:
     //     $strTabelle     Name der abgefragten Tabelle (inklusive schema.).
     //     $strIdxAtt      Attribut, das als Index der Daten verwendet wird (optional).
     //     $strCond        Bedingung (optional)
     //     $strOrderBy     Sortierattribut(e) (optional)
     //     $strTabelle     Name der abgefragten Tabelle (inklusive schema.).
     //
     // fh, 13-MAY-2011 (Version 2.03).
     
     $arrResult=array();
     
     $strSQL="SELECT * FROM $strTabelle";
     if ($strCond != '')
     {
        $strSQL .= " WHERE $strCond ";
     } // IF: Bedingung angegeben?

     if ($strOrderBy != '')
     {
        $strSQL .= " ORDER BY $strOrderBy ";
     } // IF: Sortierung angegeben?
     
     $stmtSQL=db_exec($strSQL,$boolDEBUG);
     while (db_fetch_arr($stmtSQL,$arrSQL))
     {
        if ($strIdxAtt != '')
        {
           $arrResult[$arrSQL[$strIdxAtt]]=$arrSQL; // Mit angegebenem Attribut als Index.
        }   
        else
        {
          $arrResult[]=$arrSQL;   // Ohne spezielles Index-Attribut.
        } // IF: Index-Att angegeben?   
     } // Schleife durch alle Datensätze.  
     

     return ($arrResult);
    // Ende db_get_tabledata.
}
  
// -------------------------------------------------------------
// Ende db_util.inc.php
?>
