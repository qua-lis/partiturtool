<?php
  // p_ut_meldungen_texte.inc.php
  // Fehler- und Hinweistexte nach Nummern.
  //
  // ************************************************************
  // Projektname: p = Partituren
  // ************************************************************
  //
  // DigSyLand http://www.digsyland.de/
  //
  // fh, 15-DEC-2011.
  // lr: fh, 20-DEC-2011.
  // lr: fh, 19-JAN-2012.
  // lr: fh, 27-MAR-2012.
  // lr: fh, 14-APR-2012.
  // lr: fh, 03-OCT-2012.
  // lr: fh, 14-SEP-2013, Erweiterungen der Fehlermeldungen.
  // lr: fh, 29-SEP-2013, Erweiterungen der Fehlermeldungen.
  // lr: fh, 22-OCT-2013, Erweiterungen der Fehlermeldungen.
  // -------------------------------------------------------------
  
// -------------------------------------------
// Meldungstexte
// -------------------------------------------

// M - Allgemeine Meldungen (nicht für spezielle Bereiche). 
// N - Ohne Login (nicht angemeldete User)
// F - Fachverwalter
// A - Admin-Login.

// %1, %2 sind Ersetzungsparameter (Platzhalter).


// Alle Hinweis-/Fehlermeldungen werden in das globale Array $arrGMeldText eingelesen.


// ----------- Bereich M - Allgemeine Meldungen (nicht für spezielle Bereiche). 
// ----------------------------------------------------------------------------
$arrGMeldText['M0100']="Bitte geben Sie Ihren Anmeldenamen an!";
$arrGMeldText['M0101']="Bitte geben Sie Ihr Kennwort an!";
$arrGMeldText['M0102']="Anmeldename und/oder Kennwort sind nicht bekannt.<br />\n
                        Anmeldung als %1 ist daher fehlgeschlagen.<br />
                        Sind Sie sicher, dass Sie die Kennung zur Anmeldung als %1 angegeben haben?";
$arrGMeldText['M0103']="Der Anmelde-Typ konnte nicht festgestellt werden!";

// Auswertungen:
$arrGMeldText['M0200']="Bitte geben Sie eine Schulform an!";
$arrGMeldText['M0201']="In der Datenbank konnte die Schulform nicht gefunden werden!";
$arrGMeldText['M0202']="Bitte geben Sie mindestens ein Fach an!";
$arrGMeldText['M0203']="Bitte geben Sie mindestens eine Jahrgangsstufe an!";
$arrGMeldText['M0204']="Bitte geben Sie mindestens einen Zug (eine Klasse/Lerngruppe) an!";
$arrGMeldText['M0205']="Bitte geben Sie mindestens eine Kursart an!";
$arrGMeldText['M0206']="Bitte geben Sie eine Unterrichtseinheit an!";
$arrGMeldText['M0207']="Die angegebene Unterrichtseinheit ist ungültig!";


$arrGMeldText['M020X']="Bitte geben Sie mindestens eine Jahrgangsstufe an!";

// ----------- Bereich N - Ohne Login (nicht angemeldete User) 
// ----------------------------------------------------------------------------


// ----------- Bereich F - Fachverwalter
// ----------------------------------------------------------------------------
$arrGMeldText['F0100']="Diese Funktion kann nur von Fachverwalter/innen und Administrator/innen genutzt werden!";

$arrGMeldText['F0110']="Fach oder Stufe konnte nicht festgestellt werden!";
$arrGMeldText['F0111']="Stufe / Kursart / Zug für die Kopie konnte nicht festgestellt werden!";
$arrGMeldText['F0112']="Keine Unterrichtsvorhaben vorhanden, die kopiert werden könnten!";
$arrGMeldText['F0113']="In Zielbereich sind bereits Unterrichtsvorhaben vorhanden, daher Kopieren nicht möglich!";
$arrGMeldText['F0114']="Für Sie wurde noch kein Fach zur Bearbeitung freigegeben.<br />Bitte wenden Sie sich an die Systemadministration!";
$arrGMeldText['F0115']="Für dieses Fach haben Sie keine Bearbeitungsrechte!";
$arrGMeldText['F0116']="Angaben zum Kopieren konnten nicht ermittelt werden. Bitte laden Sie den Plan erneut und starten dann die Kopierfunktion!";
$arrGMeldText['F0117']="Angaben zum Löschen konnten nicht ermittelt werden. Bitte laden Sie den Plan erneut und starten dann die Löschfunktion!";
$arrGMeldText['F0118']="Keine Unterrichtsvorhaben vorhanden, die gelöscht werden könnten!";
$arrGMeldText['F0119']="Stufe / Kursart / Zug konnte nicht festgestellt werden!";
$arrGMeldText['F0120']="Keine Unterrichtsvorhaben vorhanden, die eingeblendet werden könnten!";

$arrGMeldText['F0200']="SYS-F0200: Es ist ein Fehler beim Speichern in der Datenbank aufgetreten!";


// ----------- Bereich A - Admin-Login.
// ----------------------------------------------------------------------------
$arrGMeldText['A0100']="Diese Funktion kann nur von Administrator/innen genutzt werden!";

$arrGMeldText['A0110']="Kein gültiger Konfigurationsbereich ausgewählt!";
$arrGMeldText['A0111']="Bitte warten Sie, bis die Seite vollständig geladen ist, bevor Sie Änderungen vornehmen!";
$arrGMeldText['A0112']="Sie haben keine gültige Nutzer-Kennung ausgewählt!";
$arrGMeldText['A0113']="Bitte geben Sie einen Anmeldenamen an!";
$arrGMeldText['A0114']="Der Anmeldenamen existiert bereits!";
$arrGMeldText['A0115']="Bitte geben Sie zweimal das gleiche Kennwort an!";
$arrGMeldText['A0116']="Bitte geben Sie ein nicht-leeres Kennwort an!";
$arrGMeldText['A0117']="Kein gültiger Konfigurationseintrag gewählt!";
$arrGMeldText['A0118']="Konfigurationseintrag wurde nicht gefunden!";
$arrGMeldText['A0119']="Sitzungs-ID wurde nicht angegeben!";
$arrGMeldText['A0120']="Die angegebene Sitzungs-ID ist ungültig!";


$arrGMeldText['A0200']="SYS-A0200: Es ist ein Fehler beim Anlegen einer neuen ID in der Datenbank aufgetreten!";
$arrGMeldText['A0210']="SYS-A0210: Es ist ein Fehler beim Abspeichern der Nutzerdaten in der Datenbank aufgetreten!";

// ---------------------------------------------------
// Ende p_ut_meldungen_texte.inc.php
// ---------------------------------------------------

?>