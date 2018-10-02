#Partiturtool

Qualitäts- und Unterstützungsagentur - Landesinstitut für Schule (QUA-LiS NRW)

Weiter Informationen zu dem Jahrgangspartituren finden Sie unter http://www.schulentwicklung.nrw.de/cms/jahrgangspartitur/

##Installation der Jahrgangspartitur

Voraussetzung für die Installation der Jahrgangspartitur – Software ist ein Server mit den jeweils aktuellen Versionen von Apache, MySQL und PHP. Falls diese Software auf dem Schulserver noch nicht existiert, empfiehlt sich die Installation eines XAMPP – Systems.

## Download der Applikation
Laden Sie die Datei partitur.zip auf Ihren lokalen Rechner oder clonen sie das Repository.


Erstellen Sie ein Zielverzeichnis für die Jahrgangspartitur auf Ihrem Web-Server.
Kopieren Sie die Datei anschließend in das Zielverzeichnis auf Ihrem Web-Server.

Entpacken Sie die Datei im Zielverzeichnis Ihres Web-Servers und verfahren Sie wie im Folgenden beschrieben.

## Einrichtung der Datenbank
Richten Sie mit dem Befehl

   ```CREATE DATABASE partitur;```

eine leere Datenbank in MySQL an.

Legen Sie einen Benutzer mit Schreib- / Lese-Zugriff auf diese Datenbank über eine graphische Oberfläche (z.B. phpMyAdmin, HeidiSQL …) oder über ein Terminal mit

```
    GRANT CREATE, USAGE, SELECT, INSERT, UPDATE, DELETE, ALTER ON partitur.*
        TO 'partiturnutzer'@localhost IDENTIFIED BY 'partiturkennwort';
   FLUSH PRIVILEGES;
```

an. Dabei sollten 'partiturnutzer' und 'partiturkennwort' jeweils für die individuelle Installation entsprechend gewählt werden.

## Bereitstellung der PHP-Skripte
Legen Sie auf dem Web-Server im Veröffentlichungsverzeichnis ein Unterverzeichnis an, das die PHP-Skripte für die Jahrgangspartitur bereithält.

Entpacken Sie alle Dateien aus dem Installationspaket „partitur.zip“ und kopieren Sie diese in das Zielverzeichnis.

Konfiguration der Anwendung
Rufen Sie die Setup-Routine mit

   http://<server>/<pfad_zur_anwendung>/setup/

       oder

   http://<server>/<pfad_zur_anwendung>/setup/p_setup.php

auf und füllen Sie alle Felder des angezeigten Formulars aus. 
Nach dem Betätigen der Taste  „Konfigurationsdatei erzeugen“ wird die Konfigurationsdatei „lib/p_sys_konfig_instanz.inc.php“ angelegt, falls keine Konfigurationsfehler auftreten und Schreibrechte in „lib“ vorhanden sind. 
Die Datei „lib/p_sys_konfig_instanz.inc.php“ kann auch nachträglich mit einem Texteditor angepasst / verändert werden.

**Hinweis:** Die Setup-Routine kann nicht noch einmal ausgeführt werden, wenn die Datei „lib/p_sys_konfig_instanz.inc.php“ bereits vorhanden ist. Löschen Sie in diesem Fall diese Datei zunächst wieder im Verzeichnis „lib“.

Die Setup-Routine legt im Setup-Verzeichnis zusätzlich die Datei „create_partitur_db.sql“ an. Importieren Sie diese Datei in der bereits angelegten Datenbank. Anschließend sollten die erforderlichen Tabellen in der Datenbank vorhanden sein.

Falls die automatische Konfiguration aus Grund mangelnder Schreibrechte nicht durchgeführt werden kann, gehen Sie folgendermaßen vor:

### 1. Konfigurationsdatei „lib/p_sys_konfig_instanz.inc.php“

Wenn die Konfigurationsdatei nicht erzeugt werden kann, weil der Webserver keine Schreibrechte auf das Verzeichnis "lib" hat, kann die Datei aus der Setup-Routine mit der entsprechenden Schaltfläche heruntergeladen werden. Diese muss dann manuell auf den Server in das Verzeichnis "lib" kopiert werden.
Alternativ kann eine Datei mit dem Namen "p_sys_konfig_instanz.inc.php" angelegt und der Inhalt des angezeigten Textfeldes dort hinein kopiert werden.

### 2. SQL-Skript „create_partitur_db.sql”

Wenn das SQL-Skript nicht erzeugt werden kann, weil der Webserver keine Schreibrechte auf das Verzeichnis "setup" hat, kann das Skript aus der Setup-Routine mit der entsprechenden Schaltfläche heruntergeladen werden. Dieses muss anschließend in der Datenbank ausgeführt werden.
Alternativ können die Befehle aus dem angezeigten Textfeld kopiert und in der Datenbank ausge-führt werden.

Start der Anwendung
Rufen Sie die Anwendung mit dem Internet-Browser durch Wählen von

   http://<server>/<pfad_zur_anwendung/

oder

   http://<server>/<pfad_zur_anwendung/p_a_start.php

auf.



Voreingestellt ist eine Admin-Kennung mit dem Usernamen "admin" und dem Kennwort "admin". Melden Sie sich mit dieser Kennung zur erstmaligen Nutzung an.

Ändern Sie das Administrator-Kennwort durch

* Funktionsauswahl
* Verwaltung der Nutzer/innen / Liste der Nutzer/innen
* Nutzer “admin„ auswählen
* Kennwort und ggf. andere Einstellungen ändern

**Wichtiger Hinweis:**
Wenn die Anwendung korrekt läuft, sollte das Setup-Verzeichnis aus Sicherheitsgründen wieder vom Server entfernt werden!