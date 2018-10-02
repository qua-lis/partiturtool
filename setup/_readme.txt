_readme.txt

************************************************************
Projektname: p = Partituren
************************************************************

© Ministerium für Schule und Weiterbildung des Landes Nordrhein-Westfalen 
DigSyLand http://www.digsyland.de/

Stand: 26.11.2013


----------------------------------------------------
Vorgehensweise zum Setup
----------------------------------------------------

1. Vorbereitungen:
-------------------

1.1 Datenbank:
--------------
 - Datenbank in MySQL muss vorhanden sein.
   Ggf. kann eine neue Datenbank in MySQL angelegt werden:
   
   CREATE DATABASE partitur;
   
   
 - Datenbank-Nutzer mit Schreib-/Lese-Zugriff auf die o.g. Datenbank muss vorhanden sein:
 
   GRANT CREATE,USAGE,SELECT,INSERT,UPDATE,DELETE,ALTER ON partitur.* TO 'partitur'@localhost IDENTIFIED BY 'partiturkennwort';


1.2 Skripte bereitstellen
--------------------------

 - Alle Skripte und Dateien müssen in dem Zielverzeichnis auf dem Server liegen,
   aus dem die Anwendung aufgerufen werden soll.
   
   

2. Konfiguration / Setup
------------------------

2.1 Setup-Routine
------------------
Hinweis:
Die Setup-Routine legt die Konfigurationsdatei lib/p_sys_konfig_instanz.inc.php an.
Aus Sicherheitsgründen kann das Setup nicht durchgeführt werden, wenn diese Datei vorhanden ist.
Ggf. muss sie für eine Umkonfiguration wieder gelöscht werden!

Außerdem legt die Setup-Routine das SQL-Skript create_partitur_db.sql im Setup-Verzeichnis
an, das dann anschließend auf der Datenbank ausgeführt werden muss.


1. Aufruf der Setup-Routine mit dem Internet-Browser durch Wählen von
    http://<server>/<pfad_zur_anwendung/setup/
   oder 
    http://<server>/<pfad_zur_anwendung/setup/p_setup.php

2. Ausfüllen der Felder.
   Zum Teil gibt es Vorbelegungen, Pflichtfelder müssen ausgefüllt werden!
   
3. Nach Betätigen von 'Konfigurationsdatei erzeugen' wird die 
   Konfigurationsdatei lib/p_sys_konfig_instanz.inc.php angelegt, wenn keine
   Fehler aufgetreten sind und Schreibrechte in "lib" vorhanden sind.
   
   Diese Datei kann auch immer noch nachträglich angepasst werden.
   
4. Außerdem wird das SQL-Skript create_partitur_db.sql im Setup-Verzeichnis angelegt,
   das in der Datenbank ausgeführt werden muss.

2.2 Wenn die Dateien nicht erzeugt werden können ...
----------------------------------------------------

1. Konfigurationsdatei lib/p_sys_konfig_instanz.inc.php

Wenn die Konfigurationsdatei nicht erzeugt werden kann, weil der
Webserver keine Schreibrechte auf das Verzeichnis "lib" hat, kann die
Datei aus der Setup-Routine mit der entsprechenden Schaltfläche heruntergeladen werden.
Diese muss dann manuell auf den Server in das Verzeichnis "lib" kopiert werden.
Alternativ kann eine Datei mit dem Namen "p_sys_konfig_instanz.inc.php" angelegt und
der Inhalt des angezeigten Textfeldes dort hinein kopiert werden.

2. SQL-Skript create_partitur_db.sql

Wenn das SQL-Skript nicht erzeugt werden kann, weil der
Webserver keine Schreibrechte auf das Verzeichnis "setup" hat, kann das Skript
aus der Setup-Routine mit der entsprechenden Schaltfläche heruntergeladen werden.
Dieses muss anschließend in der Datenbank ausgeführt werden.
Alternativ können die Befehle aus dem angezeigten Textfeld kopiert und
in der Datenbank ausgeführt werden.


2.3 Entfernen des Setup-Verzeichnisses
---------------------------------------
Wichtig:
Wenn alles korrekt läuft, sollte das Setup-Verzeichnis aus Sicherheitsgründen wieder vom Server entfernt werden!


3. Start der Anwendung
-----------------------

1. Aufruf der Anwendung mit dem Internet-Browser durch Wählen von
    http://<server>/<pfad_zur_anwendung/
   oder 
    http://<server>/<pfad_zur_anwendung/p_a_start.php

2. Voreingestellt ist eine Admin-Kennung mit dem Usernamen "admin" und dem Kennwort "admin".

3. Anmeldung:
   Wählen von "Anmeldung als Administrator/in zur Konfiguration der Anwendung",
   Anmelden mit "admin", "admin".

4. Kennwort ändern:
   - Funktionsauswahl
   - Verwaltung der Nutzer/innen / Liste der Nutzer/innen
   - Nutzer "admin" auswählen
   - Kennwort und ggf. andere Einstellungen ändern

5. Konfiguration der Schulform/en:
   Standardmäßig sind einige Schulformen eingerichtet, überflüssige können ggf.
   wieder gelöscht werden.
   - Funktionsauswahl
   - Konfiguration / Schulformen
   - Nicht benötigte löschen und fehlende anlegen

6. Fächer, Jahrgangsstufen, Züge und Kursarten konfigurieren
   Wie die Schulformen sind auch Fächer etc. vorkonfiguriert.
   Überflüssige sollten gelöscht und fehlende ergänzt werden.
  
7. Textfelder einrichten
   Zur Verwaltung der Unterrichtsvorhaben können die Textfelder nach Bedarf
   konfiguriert werden.
   Standardmäßig sind bereits einige Textfelder vorkonfiguriert.
   - Funktionsauswahl
   - Konfiguration / Textfelder
   - Textfelder nach Bedarf konfigurieren (ergänzen, bearbeiten, löschen)

8. User einrichten:
   Pro Fach muss mindestens ein Fachverwalter eingerichtet werden.
   - Funktionsauswahl
   - Verwaltung der Nutzer/innen / Neue/n Nutzer/in anlegen
   - Dort entsprechende Angaben vornehmen.
     Der Anmeldename sollte keine Leerzeichen und Sonderzeichen enthalten.
     Nur Fächer, die bereits konfiguriert wurden (siehe 6.), stehen zur Auswahl.
     
   - Neben den Fachverwalter/innen gibt es auch Kennungen für Lehrkräfte,
     die den Plan nicht bearbeiten können, aber zusätzliche Felder sehen dürfen,
     die ohne Anmeldung nicht sichtbar ist.
     Für Lehrkräfte muss keine Fachzuordnung erfolgen.
   
   
   
   

