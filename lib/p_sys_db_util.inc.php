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
  global $db;



// ---------------------------------------------------

  function open_database()
  {

    // Öffnet die Datenbank zur weiteren Verwendung.
    //
    // fh, 10-JUN-2002.
    // lr: fh, 19-JUL-2003, MySQL.
    //

    // Globale Variablen auslesen:
    global $dbuser;
    global $dbpass;

    global $dbtype;
    global $schema;
    
    $db = new PDO('mysql:host=localhost;dbname='.$schema.';charset=utf8mb4', $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;

    // Ende von open_database
  }


// ---------------------------------------------------
// ---------------------------------------------------
  function db_exec($strQuery,$boolDebug=false)
  {
     // Bereitet DB-Statement zur Ausführung vor und führt ihn aus.
     // Oracle-(OCI)-Version.
     //
     // fh, 10-JUN-2002.
     // lr: fh, 22-JUL-2003, MySQL.
     // lr: fh, 25-OCT-2006, Debug-Parameter.
     // lr: fh, 02-APR-2008, DEBUG-Parameter.

 
     if ($boolDebug)
     {
       // DEBUG: 
       echo "<br />DBExec:<pre>$strQuery</pre><br/>\n";
     } // IF: Debug?  

 
	 // Datenbanktyp MySQL
	 // DEBUG:   echo "<br />DBExec:<pre>$strQuery</pre><br/>\n";
	 $db=open_database();
	 try {
	    $stmt = $db->query($strQuery);
        return $stmt;
	} catch(PDOException $ex) {echo $ex."<br>"; die("Fehler in ".$strQuery);}
   } // Ende db_exec.
   

// ----------------------------------------------------------------
// Gibt beim Einfügen die LAST_ID zurück.   

 function db_insert($strQuery,$boolDebug=false)
  {
     if ($boolDebug)
     {
       // DEBUG: 
       echo "<br />DBExec:<pre>$strQuery</pre><br/>\n";
     } // IF: Debug?  

 
	 // Datenbanktyp MySQL
	 // DEBUG:   echo "<br />DBExec:<pre>$strQuery</pre><br/>\n";
	 $db=open_database();
	 try {
	    $stmt = $db->query($strQuery);
        return $db->lastInsertId();
	} catch(PDOException $ex) {echo die("Fehler in ".$strQuery);}
   } // Ende db_exec.
   
// ---------------------------------------------------

  function db_fetch_arr($resBefehl,&$arrErgebnis)
  {
     // Holt Daten in ein Array (für While-Schleife).
     // Oracle-(OCI)- und MySQL-Version.
     //
     // ACHTUNG: In Oracle müssen die Attribute (Feldnamen) bei den Assoziativen Arrays
     //          komplett gross geschrieben werden!
     //          In MySQL müssen sie exakt so geschrieben werden, wie sie
     //          in der Anfrage formuliert sind.
     //          Also sollten die Attribute für maximale Kompabilität
     //          im SQL-Statement und als Array-Index gross geschrieben werden.
     //
  
  	 // MySQL:
     // In MySQL wird das Ergebnisübergabe wie in Oracle nachgebildet.
     // Dadurch bleibt die Funktion kompatibel zu Oracle, ohne dass der Code geändert werden müsste.
	if ($resBefehl)
	{
	 return ($arrErgebnis=$resBefehl->fetch(PDO::FETCH_ASSOC));
	}
	else
	{
	 // Falls die Anfrage schon fehlerhaft war, nichts zurückgeben.
	 return false;
	}

  } // Ende: db_fetch_arr

// ---------------------------------------------------


  function db_get_value($strSpalte,$strTabelle,$strBedingung="",$boolDebug=false)
  {
     // Holt einen einzigen Wert aus einer Tabelle.
     // Oracle-(OCI)- & MySQL-Version.
     //
     // Parameter:
     //
     // fh, 10-JUN-2002
     // lr: fh, 29-OCT-2002, Wenn Aufruf fehlschlägt: leerer String.
     // lr: fh, 19-JUL-2003, MySQL.
     // lr: fh, 20-JUL-2003, Vervollständigung.
     // lr: fh, 29-JUL-2005, Bedingung standardmäßig leer setzen, so dass dieser Parameter fehlend darf.
     // lr: fh, 02-AUG-2005, MySQL-Version gibt bei leerer Menge keinen Fehler mehr aus.
     // lr: fh, 29-APR-2008, DEBUG-Parameter.

     global $dbtype;

     $strBefehl="SELECT " . $strSpalte . " Feld FROM " . $strTabelle;
     if ($strBedingung != "")
     {
         $strBefehl .= " WHERE " . $strBedingung;
     }

     if ($boolDebug)
     {
       // DEBUG: 
       echo "<br />SQL:<pre>$strBefehl</pre><br/>\n";
     } // IF: Debug?  
	 // MySQL:
	 
	 $db = open_database();
	 $resErgebnis = $db->query($strBefehl);
	 $strErgebnis = "";
 	 // Prüfen, ob Datenbank-Abfrage gültig ist:
	 if ($resErgebnis)
	 {
		// Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
		$arrErgebnis = $resErgebnis->fetch(PDO::FETCH_NUM);
		$strErgebnis=$arrErgebnis[0];
	 }  
	 
	 return $strErgebnis;

    // Ende db_get_value.
  }


// ---------------------------------------------------


  function db_get_value_nl($strSpalte,$strTabelle,$strBedingung)
  {
     // Holt einen einzigen Wert aus einer Tabelle und prüft
     // vorher, ob es überhaupt ein Ergebnis gibt. Wenn es
     // keines gibt, wird ein leerer String "" zurückgegeben.
     //


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


	 // Prüfen, ob Datensätze vorhanden sind:
	 $strErgebnis="";
	 $db = open_database();
	 $stmt = $db->query($strPruefBefehl);
	 if ($stmt->rowCount()>0)
	 {
		 $resErgebnis = $db->query($strBefehl);
		 if ($resErgebnis)
		 {
		   $arrErgebnis = $resErgebnis->fetch(PDO::FETCH_NUM);
		 }  // IF: Anfrage gültig & fehlerfrei?
	   }   // IF: Datensätze vorhanden?
	 $strErgebnis=$arrErgebnis[0];
	 return $strErgebnis;
	 // ENDE: MySQL.

      // Ende db_get_value_nl.
  }

// ---------------------------------------------------


  function db_get_2values($strSpalte1,$strSpalte2,$strTabelle,$strBedingung,&$strErg1,&$strErg2,$boolDebug=false)
  {
     // Holt genau zwei Werte aus einer Tabelle.
     //
     // Parameter:
     //
 
 
     $strBefehl="SELECT " . $strSpalte1 . " Feld1, " . $strSpalte2 . " Feld2 FROM " . $strTabelle;
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

	 // Datenbanktyp MySQL:
	 $db = open_database();
	 $resErgebnis = $db->query($strBefehl);
	 // Fehlermeldungen vermeiden:
	 $arrErgebnis=array("","");
	 if ($resErgebnis)
	 {
	   // Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
	   $arrErgebnis = $resErgebnis->fetch(PDO::FETCH_NUM);
	   //print_r($arrErgebnis);
	 } // IF: Ergebnis-Satz?  
	 $strErg1=$arrErgebnis[0];
	 $strErg2=$arrErgebnis[1];
 

  } // Ende db_get_2values.

// ---------------------------------------------------

  function db_get_3values($strSpalte1,$strSpalte2,$strSpalte3,$strTabelle,$strBedingung,
                          &$strErg1,&$strErg2,&$strErg3,$boolDebug=false)
  {
     // Holt genau drei Werte aus einer Tabelle.
     // Oracle-(OCI)-Version.
     //
     //
     // fh, 13-OCT-2002.
     // lr: fh, 22-JUL-2003, Anpassung an MySQL.
     // lr: fh, 23-JUL-2003, dbtype korrigiert.

     global $dbtype;


     $strBefehl="SELECT " . $strSpalte1 . " Feld1, " .
                            $strSpalte2 . " Feld2, " .
                            $strSpalte3 . " Feld3 FROM " . $strTabelle;
     if ($strBedingung != "")
     {
       $strBefehl .= " WHERE " . $strBedingung;
     }
    if ($boolDebug) echo $strBefehl."<br>";
	// MySQL:
	$db = open_database();
    $resErgebnis = $db->query($strBefehl);
    $arrErgebnis = $resErgebnis->fetch(PDO::FETCH_NUM);
    $strErg1=$arrErgebnis[0];
    $strErg2=$arrErgebnis[1];
    $strErg3=$arrErgebnis[2];

 } // Ende db_get_3values.

// ---------------------------------------------------

  function db_exist_table($strTabelle)
  {
     // Prüft, ob eine bestimmte Tabelle vorhanden ist.
     //
     // ACHTUNG:
     // Bisher nur MySQL-Version!
     // Ab MySQL 5 geht das über ein SQL-Statement.
     //
     // Parameter:
     //
     //     $strTabelle Name der zu überprüfenden Tabelle (inklusive schema.).
     //
     // fh, 27-SEP-2005.

	 global $dbtype;
	 global $schema;

	// MySQL:
	// Schema-Name aus dem Tabellen-Namen entfernen:
	$strBefehl="SHOW TABLES FROM $schema LIKE '" . str_replace($schema . ".","",$strTabelle) . "'";
	// DEBUG: echo "<p>SQL: $strBefehl <p>\n";

    $db = open_database();
    $resErgebnis = $db->query($strBefehl);
	$strErgebnis = "";
	// Prüfen, ob Datenbank-Abfrage gültig ist:
	if ($resErgebnis)
	{
		// Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
		$arrErgebnis = $resErgebnis->fetch(PDO::FETCH_NUM);
	}    
	return (($arrErgebnis[0]=="") ? false : true);
	// Ende db_exist_table.
  }


// ---------------------------------------------------

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
     
	 // MySQL:
	 $db = open_database();
  	 $resErgebnis = $db->query("SELECT now()");
	 if ($resErgebnis)
	 {
		// Fehlermeldung mit @ unterdrücken, bei Fehlern wird leeres Ergebnis zurückgegeben:
		$arrErgebnis = $resErgebnis->fetch(PDO::FETCH_NUM);
		$strErgebnis=$arrErgebnis[0];
	 }     
 
     return $strErgebnis;

    // Ende db_zeitstempel.
  }



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
     } // Schleife durch alle Datensdtze.  
     
     
     return ($arrResult);
    // Ende db_get_tabledata.
}


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


  global $schema;
  unset($arrAtts);
  
   // MySQL:
   // Schema-Name aus dem Tabellen-Namen entfernen:
   // 
   
   //$strBefehl="SHOW TABLES FROM $schema LIKE '" . str_replace($schema . ".","",$strTabelle) . "'";
   //echo "<p>Fehler: Bisher keine MySQL-Version von db_table_attribs! <p>\n";
   
   $stmtSQL=db_exec("SELECT * FROM $strTabelle");
   
   for ($intIdx = 0; $intIdx < $stmtSQL->columnCount(); $intIdx++) {
	  $col = $stmtSQL->getColumnMeta($intIdx);
	  
	  $strAttname = $col['name'];
	  $strPDOType = $col['native_type'];
	  switch ($strPDOType) {
	   case "VAR_STRING" : 
			$strType='string';
			break;
	   case  "LONG": 
			$strType='int';
	        break;
	   default:
	        $strType='unknown';  
	  }  
	  $arrAtts[$strAttname]["TYP"]=$strType;
	  $arrAtts[$strAttname]["LEN"]=$col['len'];
	  $arrAtts[$strAttname]["FLAGS"]=$col['flags'];
   }
 
  //DEBUG:    echo "<pre>";print_r($arrAtts);echo" </pre>";
   
  
  return (isset($arrAtts) ? $arrAtts : "");
  // Ende db_table_attribs.
}

  
// -------------------------------------------------------------
// Ende db_util.inc.php
?>
