<?php
  // p_conf_variablen.inc.php
  // Defintion der Variablen für Setup-Prozess zur Erzeugung der Datei lib\p_sys_konfig_instanz.inc.php
  // aus p_sys_konfig_instanz.muster.inc.php.
  // 
  // 
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  //
  // fh, 25-NOV-2013, Version 0.18
  // -------------------------------------------------------------

$numVersion=0.18;

// Reihenfolge durch Index
// Jeweils Array:
//  symbol        Platzhalter
//  default       Default-Wert
//  bez           Bezeichnung
//  sel           Select-Auswahlliste
//  hinweis       Bemerkungen und Hinweise
//  pflicht       Wenn 1 dann Pflichtfeld.


$arrGCfgVar[110]=array('symbol'=>'##dbhost##','default'=>'localhost','bez'=>'Rechner/Host, auf dem MySQL-Datenbank läuft',
                       'hinweis'=>'Hostname der MySQL-Datenbank','pflicht'=>1);
$arrGCfgVar[115]=array('symbol'=>'##dbname##','default'=>'partitur','bez'=>'MySQL-Datenbank, in der alle Tabellen liegen',
                       'hinweis'=>'MySQL-Datenbankname','pflicht'=>1);
$arrGCfgVar[120]=array('symbol'=>'##dbuser##','default'=>'partitur','bez'=>'MySQL-Datenbank-Kennung für Zugriff auf DB-Tabellen',
                       'hinweis'=>'Mit diesem DB-Username erfolgt der Zugriff auf die Datenbanktabellen.','pflicht'=>1);
$arrGCfgVar[125]=array('symbol'=>'##dbpass##','default'=>'','bez'=>'Kennwort für den Zugriff auf die MySQL-Datenbank',
                       'hinweis'=>'Kennwort zu dem angegebenen DB-Usernamen','pflicht'=>1);
$arrGCfgVar[130]=array('symbol'=>'##dbpraefix##','default'=>'','bez'=>'Tabellenpräfix, das allen Tabellen vorangestellt wird, z.B. part_',
                       'hinweis'=>'Wenn mehrere Anwendungen in einer Datenbank verwaltet werden sollen, können so die Tabellen unterschieden werden.','pflicht'=>0);

$arrGCfgVar[140]=array('symbol'=>'##pwcodierung##','default'=>'','bez'=>'Wie sollen die Klartext-Kennworte der User hinterlegt werden?',
                       'sel'=>array(''=>'(leer), keine Ablage der Klartext-KW', 'b64'=> 'b64, base64-kodiert (nicht lesbar, aber entschlüsselbar)',
                                        'klar' => 'klar, unverschlüsselt als Klartext'),
                       'hinweis'=>'Wenn sicherheitshalber die Klartext-Kennworte in der DB hinterlegt werden sollen, kann das hier eingestellt werden.','pflicht'=>0);

$arrGCfgVar[200]=array('symbol'=>'##guicharset##','default'=>'UTF-8','bez'=>'Zeichensatz, der im Header angegeben wird.',
                       'hinweis'=>'Ggf. kann hier ein anderer Zeichensatz eingestellt werden.','pflicht'=>1);


$arrGCfgVar[300]=array('symbol'=>'##opsystem##','default'=>'win','bez'=>'Betriebssystem, win oder linux',
                       'sel'=>array('win'=>'win - Windows', 'linux'=> 'Linux'),
                       'hinweis'=>'Wichtig für System-Befehle und Pfade','pflicht'=>1);

$arrGCfgVar[310]=array('symbol'=>'##apptype##','default'=>'prod','bez'=>'Entwicklungs- oder Produktivsystem?',
                       'sel'=>array('prod'=>'prod - Produktivversion', 'dev'=> 'dev - Entwicklung / Test'),
                       'hinweis'=>'Zunächst nur für interne Zwecke.','pflicht'=>1);

$arrGCfgVar[320]=array('symbol'=>'##apptext##','default'=>'Produktivsystem','bez'=>'Frei wählbarer Text zur Identifizierung des Systems',
                       'hinweis'=>'','pflicht'=>0);

$arrGCfgVar[330]=array('symbol'=>'##apptitel##','default'=>'Jahrgangspartituren','bez'=>'Frei konfigurierbarer Titel der Applikation',
                       'hinweis'=>'','pflicht'=>0);

$arrGCfgVar[340]=array('symbol'=>'##appfuss##','default'=>'&copy; Qualit&auml;ts- und Unterst&uuml;tzungsAgentur - Landesinstitut f&uuml;r Schule',
                       'bez'=>'Frei konfigurierbare Fußzeile',
                       'hinweis'=>'','pflicht'=>0);


$arrGCfgVar[400]=array('symbol'=>'##meta_schulname##','default'=>'','bez'=>'Name der Schule',
                       'hinweis'=>'','pflicht'=>0);

$arrGCfgVar[410]=array('symbol'=>'##meta_schulnummer##','default'=>'','bez'=>'Schulnummer',
                       'hinweis'=>'','pflicht'=>0);

?>
