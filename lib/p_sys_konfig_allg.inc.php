<?php
  // p_sys_konfig_allg.inc.php
  // 
  // Die hier definierten Konfigurationseinstellungen ergänzen die Instanz-spezifischen Einstellungen aus p_sys_konfig_instanz.inc.php.
  // Hier stehen im Einstellungen, die nicht von Variable strKonf abhängig sind
  // und nicht zur Anpassung an eine Instanz angepasst werden müssen.
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 15-DEC-2011.
  // lr: fh, 20-DEC-2011.
  // lr: fh, 29-MAR-2012, Konfigurationsbereich der Kataloge.
  // lr: fh, 12-APR-2012, Farbpalette als Auswahlliste, neue Tabellen: Sperren.
  // lr: fh, 19-AUG-2013, neuer User-Typ ($arrGLoginTypen): L.
  // lr: fh, 14-SEP-2013, $boolGAdminAnlegen.
  // lr: fh, 30-SEP-2013, nur_lehrkraefte., $arrGLoginTypKonf ,arrGLoginTypCodes, strGtabEinWochenStd.
  // lr: fh, 22-OCT-2013, jQuery $strGDateiJQuery
  // -----------------------------------------------------------------
  // Zur Kenntlichmachung der globalen Variablen wird ein G verwendet:
  // -----------------------------------------------------------------
  
  
  // -----------------------------------------------------------
  // Tabellen-Bezeichner:
  // -----------------------------------------------------------
  
  // Vor jeden Tabellennamen wird der DBName und (wenn vorhanden) ein globaler Tabellenpräfix gesetzt (siehe p_sys_konfig_instanz.inc.php):
  $strTabPfx=$strGDBName . '.' . ((empty($strGDBTabPraefix)) ? '' : $strGDBTabPraefix);
  // -----------------------------------------------------------------------------------
  
  // Verwaltungstabellen (User-Kennungen, Log, ...):
  $strGtabSysDMVersion=$strTabPfx . 't100_sys_dmversion';            // Datenmodell-Version
  $strGtabSysLog=$strTabPfx . 't110_sys_log';                        // Protokoll-Tabelle
  $strGtabSysUser=$strTabPfx . 't150_sys_user';                      // Anmeldedaten
  $strGtabSysSperren=$strTabPfx . 't160_sys_sperren';                // Sperren, um gleichzeitige Bearbeitungen zu verhindern.
  $strGtabSysAendSess=$strTabPfx . 't170_sys_aender_session_uv';     // Angaben, um Änderungen einer Sitzung rückgängig zu machen.


  // Konfigurationstabellen:
  $strGtabKfgUVTextfelder=$strTabPfx . 't210_kfg_uv_textfelder';     // Konfigurierbare Textfelder für Unterrichtsvorhaben

  // Kataloge:
  $strGtabKatSchulform=$strTabPfx . 't310_kat_schulform';            // Katalog der Schulformen
  $strGtabKatFach=$strTabPfx . 't320_kat_fach';                      // Katalog der Fächer
  $strGtabKatStufe=$strTabPfx . 't330_kat_stufe';                    // Katalog der Jahrgangsstufen (5,6,7, ...)
  $strGtabKatZug=$strTabPfx . 't340_kat_zug';                        // Katalog der Züge (Klassen-Kürzel, Lerngruppen wie a, b, c)
  $strGtabKatKursart=$strTabPfx . 't350_kat_kursart';                // Katalog der Kursarten wie E-Kurs, GK, etc.


  // Datentabellen:
  $strGtabEinUnterrichtsvorhaben=$strTabPfx . 't510_ein_unterrichtsvorhaben';     // Eingabetabelle mit allen Unterrichtsvorhaben
  $strGtabEinUVTextfelder=$strTabPfx . 't520_ein_r_uv_textfelder';                // Weitere Text-Angaben zu Unterrichtsvorhaben
  $strGtabEinWochenStd=$strTabPfx . 't540_ein_wochenstunden';                     // Wochenstundenzahlen




  // -----------------------------------------------------------
  // Verschiedene Voreinstellungen:
  // -----------------------------------------------------------
  $strGConfFormatierungsoptionen="Formatierung: #kursiv#, ##fett##, ###unterstrichen###, **farbig**, ***Ueberschrift***, -- Listenpunkt";

  $arrGLoginTypen=array('F'=>'Fachverwalter/in','A'=>'Administrator/in','L'=>'Lehrkraft');
  $arrGLoginTypKonf=array('F'=>array($arrGLoginTypen['F'],'p_fv_auswahl.php'),
                          'A'=>array($arrGLoginTypen['A'],'p_adm_auswahl.php'),
                          'L'=>array($arrGLoginTypen['L'],'p_aus_auswahl.php'));
                             // Start-Seite für Lehrkräfte: Normale Auswahlseite
  $arrGLoginTypCodes=array(1=>'F',2=>'A',3=>'L');   // Zuordnung der numerischen Codes für Login-Seiten.                           


  $boolGAdminAnlegen=false;   // Wenn false, kann der Admin keine neuen Admins anlegen.
  
  // jquery-Datei (damit diese zentral konfiguriert werden kann):
  // $strGDateiJQuery="jquery-1.6.2.js";  // muss in $strGJSPath/jquery/ liegen.
  $strGDateiJQuery="jquery-1.7.2.js";  // muss in $strGJSPath/jquery/ liegen.

  // -----------------------------------------------------------
  // Konfigurationsbereich der Kataloge:
  // -----------------------------------------------------------
  // Einstellungen für den Admin-Bereich, welche Kataloge werden in welcher Form zur Konfiguration angeboten?
  // Damit kann das jeweilige Bearbeitungsformular automatisch aufgebaut werden.
  $arrGKatalogKonf=array('sf'=>'Schulformen','fach'=>'Fächer','stufe'=>'Jahrgangstufen',
                         'zug'=>'Züge','kurs'=>'Kursarten','textfeld'=>'Textfelder');

  // Zu den Katalogen:
  // In 'notnullatts' werden die Default-Werte für Not-Null / Unique Values-Felder angegeben, #id# Platzhalter für IDs

  // Schulformen-Katalog:
  $arrGKatalogData['sf']=array('idatt'=> 'schulform_id',
                               'notnullatts'=>array('schulform'=>'SF#id#', 'schulformkuerzel'=>'S#id#'), 
                               'atts'=>array('schulform'=>'Bezeichnung der Schulform',
                                             'schulformkuerzel' => 'Kürzel für die Schulform',
                                             'schulform_bem' => 'Bemerkungen zur Schulform'),
                               'tab'=>$strGtabKatSchulform,              
                               'orderby'=>'ORDER BY schulform_id');
  // Fächer-Katalog:
  $arrGKatalogData['fach']=array('idatt'=> 'fach_id',
                                 'notnullatts'=>array('fach'=>'Fach#id#', 'fachkuerzel'=>'F#id#','fachreihenfolge'=>'#id#'), 
                                 'atts'=>array('fach'=>'Bezeichnung des Faches',
                                             'fachkuerzel' => 'Kürzel für das Fach',
                                             'fach_farbe' => 'Farbe zur Darstellung des Faches',
                                             'fachreihenfolge' => 'Reihenfolge-Wert',
                                             'fach_bem' => 'Bemerkungen zum Fach'),
                                 'tab'=>$strGtabKatFach,              
                                 'orderby'=>'ORDER BY fachreihenfolge');
  $arrGFarbKatalog=
            array('#9db9c4','#9dc4ad','#c0c49d','#c4a89d','#c49db1','#ecba6c',
                  '#A5BEDB','#A7D19D','#D1C89D','#DBBCA4','#DBA4A4','#fcae3c',
                  '#A5DBDB','#A4DBAB','#c0c49d','#D1BB9D','#D1A59D','#E5C23A',
                  '#8CE8E8','#9cdec9','#dfe5a2','#E8D2A3','#e1bdbd','#f7d078'); // Farbpalette
  // Wenn folgende Zeile auskommentiert ist, wird statt des Colorpickers der angegebene Farbkatalog als Auswahl verwendet:
  // $arrGKatalogData['fach']['sel']['fach_farbe']=$arrGFarbKatalog;
  
  // Stufen-Katalog:
  $arrGKatalogData['stufe']=array('idatt'=> 'stufe_id',
                                  'notnullatts'=>array('stufe'=>'S#id#'), 
                                  'atts'=>array('stufe'=>'(eindeutige) Bezeichnung der Stufe',
                                                'stufe_bem' => 'Bemerkungen zur Stufe'),
                                  'tab'=>$strGtabKatStufe,              
                                  'orderby'=>'ORDER BY cast(stufe as unsigned)');

  // Züge-Katalog:
  $arrGKatalogData['zug']=array('idatt'=> 'zug_id',
                                'notnullatts'=>array('zug'=>'Z#id#'), 
                                'atts'=>array('zug'=>'(eindeutige) Bezeichnung des Zuges',
                                              'zug_bem' => 'Bemerkungen zum Zug'),
                                'tab'=>$strGtabKatZug,              
                                'orderby'=>'ORDER BY zug');

  // Kursarten-Katalog:
  $arrGKatalogData['kurs']=array('idatt'=> 'kursart_id',
                                 'notnullatts'=>array('kursart'=>'Kurs#id#'), 
                                 'atts'=>array('kursart'=>'Kurz-Bezeichnung der Kursart',
                                               'kursart_bezeichnung'=>'längere Bezeichnung der Kursart',
                                               'kursart_bem' => 'Bemerkungen zur Kursart'),
                                 'tab'=>$strGtabKatKursart,              
                                 'orderby'=>'ORDER BY kursart');

  // Textfelder:
  $arrGKatalogData['textfeld']=array('idatt'=> 'textfeld_id',
                                 'notnullatts'=>array('textfeld'=>'TF#id#'), 
                                 'atts'=>array('textfeld'=>'(eindeutige) Bezeichnung des Textfeldes',
                                               'textfeld_label'=>'Beschriftung des Textfeldes in Eingabeformular',
                                               'textfeld_beschreibung'=>'Hinweise/Hilfetext zum Textfeld',
                                               'textfeld_bem' => 'Bemerkungen zum Textfeld',
                                               'textfeld_label'=>'längere Bezeichnung der Kursart',
                                               'feldlaenge'=>'optionale Zeichenlängenbeschränkung',
                                               'pflichtfeld'=>'Muss Feld ausgefüllt werden?',
                                               'plananzeige'=>'Soll Feld in Planübersicht angezeigt werden?',
                                               'nur_lehrkraefte'=>'Soll Feld nur für angemeldete Lehrkräfte sichtbar sein?',
                                               'reihenfolge'=>'Reihenfolge zur Sortierung'),
                                 'chkatts'=>array('pflichtfeld','plananzeige','nur_lehrkraefte'),                                            
                                 'tab'=>$strGtabKfgUVTextfelder,              
                                 'orderby'=>'ORDER BY reihenfolge,textfeld');
                                 // chkatts: Durch Checkboxen symbolisiert
                                 

  // -----------------------------------------------------------
  // Log-Aktionen:
  // -----------------------------------------------------------
  // Vierstelliger Zahlencode für jeden Aktionstypen, außerdem ab welchem Log-Level protokolliert wird.
  // Loglevel in p_sys_konfig_instanz.inc.php von 1 - 5.
  $arrGLogAkt[0]=array(0,'alle anzeigen');    // Dummy-Eintrag zur Protokollkontrolle.

  $arrGLogAkt[1100]=array(2,'Anmeldung'); 
  $arrGLogAkt[1105]=array(3,'Fehlversuch der Anmeldung'); 
  $arrGLogAkt[1110]=array(2,'Abmeldung'); 

  $arrGLogAkt[3110]=array(2,'Konfiguration gespeichert'); 
  $arrGLogAkt[3120]=array(2,'Konfigurationseintrag gelöscht'); 
  $arrGLogAkt[3210]=array(1,'Userkennung geändert'); 

  $arrGLogAkt[3310]=array(3,'Bearbeitungssitzung gelöscht'); 

  
  $arrGLogAkt[8000]=array(1,'ERR: Generierung XX-ID fehlgeschlagen'); 
  $arrGLogAkt[8010]=array(1,'ERR: Fehler beim Anlegen/Ändern einer Kennung'); 
  $arrGLogAkt[8120]=array(2,'ERR: DB-Fehler beim Löschen eines Konfigurationseintrages'); 
  $arrGLogAkt[8130]=array(3,'ERR: DB-Fehler beim Löschen einer Sitzung'); 
  $arrGLogAkt[9000]=array(5,'Debug-Infos');    
  $arrGLogAkt[9999]=array(5,'reserviert');    


  
  // -----------------------------------------------------------
  // Session-Namen und weitere Session-Informationen einstellen:
  // -----------------------------------------------------------
  $strGSessionName="partituren";
  session_name($strGSessionName);

  if ($strKonf == "prod")
  {
    $intGSessionTimeout=25;           // Timeout-Zeit in Minuten.
  }
  else
  {
    $intGSessionTimeout=300;           // Timeout-Zeit in Minuten.
  }
  
  
  $strGStartURL="p_a_start.php";              // Anfangs-URL, auf die im Zweifelsfall verzweigt wird.

?>
