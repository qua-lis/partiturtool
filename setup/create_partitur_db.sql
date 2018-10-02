-- create_partitur_db.sql
--
-- SQL-Statements für die Partituren-Anwendung.
--
-- Friedhelm Hosenfeld hosenfeld@digsyland.de DigSyLand http://www.digsyland.de/
--
-- fh, 15-DEC-2011 - 25-NOV-2013.
-- lr: fh, 19-DEC-2013, Korrekturen für MySQL 5.5.x (TIMESTAMP), Fremdschlüssel.
-- --------------------------------------------------------------

-- -------------------------------------------------------------------------------------------------------------------
-- Hinweis: Um Tabellen-Präfix einzusetzen: Mit Suchen & Ersetzen part1_ durch gewünschten Präfix, z.B. part_ ersetzen.
--          Wenn kein Präfix gewünscht wird, mit Suchen & Ersetzen part1_ überall entfernen
-- -------------------------------------------------------------------------------------------------------------------


-- Datenmodell-Version:
-- --------------------
-- Mit dieser Tabelle kann überprüft werden, ob Programm-Version und Datenmodell-Version zusammenpassen.
DROP TABLE IF EXISTS part1_t100_sys_dmversion;
CREATE TABLE part1_t100_sys_dmversion
  (dmversionsnr 	DOUBLE NOT NULL		COMMENT 'aktuelle Datenmodell-Version, Primärschlüssel, immer höchste Version wird ausgewertet',
   appversionsnr_min 	DOUBLE			COMMENT 'Minimale Version des Programms, die erforderlich ist',
   dm_bem		VARCHAR(200)		COMMENT 'Bemerkungen zur Datenmodell-Version',
   zeitstempel		TIMESTAMP		COMMENT 'Zeitstempel',
   CONSTRAINT pk_t100 PRIMARY KEY (dmversionsnr))
   COMMENT 'Datenmodell-Version';
   
-- Datenmodell
INSERT INTO part1_t100_sys_dmversion (dmversionsnr,appversionsnr_min,dm_bem) VALUES (0.02,0.15,'Erweiterungen Aug/Sep 2013');


-- Protokoll-Tabelle:
DROP TABLE IF EXISTS part1_t110_sys_log;
CREATE TABLE part1_t110_sys_log
  (sessionid    VARCHAR(35) NOT NULL	COMMENT 'ID der Session',
   user_id	INTEGER NOT NULL	COMMENT 'eindeutige ID für jeden Anmeldenamen, - nicht angemeldet',
   anmeldetyp	VARCHAR(1)		COMMENT 'Typ: F-Fachverwalter/in, A-Admin, - undefiniert',
   aktion_code	SMALLINT(5)		COMMENT 'Code der protokollierten Aktion',
   browser	VARCHAR(100)		COMMENT 'Verwendeter Browser',
   ipadresse	VARCHAR(15)		COMMENT 'IP-Adresse',
   logparam	VARCHAR(100)		COMMENT 'weitere Parameter zur protokollierten Aktion',
   zeitstempel	TIMESTAMP		COMMENT 'Zeitstempel')
   COMMENT 'Protokoll-Tabelle';


-- Fächer:
-- -------
-- CID:fh131219:Fächer müssen wg. Foreign Key vor Userkennungen angelegt werden:
DROP TABLE IF EXISTS part1_t320_kat_fach;
CREATE TABLE part1_t320_kat_fach
 (fach_id 		INTEGER(10) NOT NULL	COMMENT 'eindeutige Fach-ID, Primärschlüssel',
  fach			VARCHAR(50) NOT NULL	COMMENT 'Bezeichnung des Faches',
  fachkuerzel      	VARCHAR(5) NOT NULL	COMMENT 'Kürzel für das Fach, auch eindeutig',
  fach_farbe 		VARCHAR(7)		COMMENT 'Farbe zur Darstellung des Faches',
  fachreihenfolge 	INTEGER(10) NOT NULL	COMMENT 'Reihenfolge-Wert',
  fach_bem		VARCHAR(200)		COMMENT 'Bemerkungen zum Fach',
  CONSTRAINT pk_t320 PRIMARY KEY (fach_id),
  CONSTRAINT uk_t320_fachkuerzel UNIQUE (fachkuerzel))
 COMMENT 'Katalog der Fächer';

-- Füllen des Katalogs:
INSERT INTO part1_t320_kat_fach (fach_id,fach,fachkuerzel,fach_farbe,fachreihenfolge) VALUES (1, 'Deutsch', 'D', '#FFCCCC', 100);
INSERT INTO part1_t320_kat_fach (fach_id,fach,fachkuerzel,fach_farbe,fachreihenfolge) VALUES (2, 'Englisch', 'E', '#99FFFF', 200);
INSERT INTO part1_t320_kat_fach (fach_id,fach,fachkuerzel,fach_farbe,fachreihenfolge) VALUES (3, 'Mathematik', 'M', '#99FF00', 300);
INSERT INTO part1_t320_kat_fach (fach_id,fach,fachkuerzel,fach_farbe,fachreihenfolge) VALUES (4, 'Geschichte', 'GE', '#CCFF66', 400);
INSERT INTO part1_t320_kat_fach (fach_id,fach,fachkuerzel,fach_farbe,fachreihenfolge) VALUES (5, 'Erdkunde', 'EK', '#66FFFF', 410);
INSERT INTO part1_t320_kat_fach (fach_id,fach,fachkuerzel,fach_farbe,fachreihenfolge) VALUES (6, 'Politik', 'PK', '#FFCCFF', 420);
INSERT INTO part1_t320_kat_fach (fach_id,fach,fachkuerzel,fach_farbe,fachreihenfolge) VALUES (7, 'Biologie', 'BI', '#FFFF66', 310);
INSERT INTO part1_t320_kat_fach (fach_id,fach,fachkuerzel,fach_farbe,fachreihenfolge) VALUES (8, 'Gesellschaftslehre (integriert)', 'GL_i', '#99FF99', 0);



-- Userkennungen:
DROP TABLE IF EXISTS part1_t150_sys_user;
CREATE TABLE part1_t150_sys_user
 (user_id		INTEGER NOT NULL	COMMENT 'eindeutige ID für jeden Anmeldenamen, Primärschlüssel',
  anmeldename		VARCHAR(100) NOT NULL	COMMENT 'eindeutiger Anmeldename',
  vollname		VARCHAR(150)		COMMENT 'Vor- und Zuname',
  kennwort_crypt	VARCHAR(32)		COMMENT 'Einweg-verschlüsseltes Kennwort',
  kennwort_klar		VARCHAR(100)		COMMENT 'Klartext-Kennwort (bzw. b64)',
  anmeldetyp		VARCHAR(1)		COMMENT 'Typ: F-Fachverwalter/in, A-Admin, L-Lehrer/in',
  fach_id 		INTEGER(10) 		COMMENT 'Fach-ID des Faches, das von Fachverwalter/in bearbeitet wird',
  CONSTRAINT pk_t150 PRIMARY KEY (user_id),
  CONSTRAINT uk_t150_anmeldename UNIQUE (anmeldename),
  CONSTRAINT fk_t150_sys_user_fach_id FOREIGN KEY (fach_id) REFERENCES part1_t320_kat_fach (fach_id))
COMMENT 'Anmeldekennungen';


-- Admin-Kennung admin einrichten (PW: admin):
INSERT INTO part1_t150_sys_user (user_id,anmeldename,vollname,kennwort_crypt,kennwort_klar,anmeldetyp)
                   VALUES (1,'admin','Administrator/in','21232f297a57a5a743894a0e4a801fc3','','A');



-- Sperren:
-- Es gibt systemweit pro Fach eine Sperre, die die Bearbeitung des Plans für dieses Fach sperrt.
DROP TABLE IF EXISTS part1_t160_sys_sperren;
CREATE TABLE part1_t160_sys_sperren
 (fach_id 		INTEGER(10) NOT NULL	COMMENT 'Fach-ID des Faches, das bearbeitet und damit gesperrt wird, Primärschlüssel',
  session_id 		VARCHAR(35) NOT NULL	COMMENT 'eindeutige Session-ID',
  user_id		INTEGER			COMMENT 'eindeutige ID für jeden Anmeldenamen',
  sessionende		VARCHAR(40) 		COMMENT 'Ende der Session (Gültigkeit der Sperre)',
  CONSTRAINT pk_t160 PRIMARY KEY (fach_id))
COMMENT 'Sperren: Bearbeitung nur eines Faches zur Zeit erlaubt';


-- Tabelle, um Änderungen einer Sitzung rückgängig zu machen
-- --------------------------------------------------------
DROP TABLE IF EXISTS part1_t170_sys_aender_session_uv;
CREATE TABLE part1_t170_sys_aender_session_uv
 (user_id		INTEGER NOT NULL	COMMENT 'eindeutige ID für jeden Anmeldenamen, Teil-Primärschlüssel',
  uv_id 		INTEGER(12) NOT NULL	COMMENT 'eind. ID für das Unterrichtsvorhaben, Teil-Primärschlüssel',
  schulform_id 		INTEGER(10) NOT NULL	COMMENT 'Schulform-ID, Fremdschlüssel',
  fach_id 		INTEGER(10) NOT NULL	COMMENT 'Fach-ID, Fremdschlüssel',
  stufe_id 		INTEGER(10) NOT NULL	COMMENT 'Stufen-ID, Fremdschlüssel',
  kursart_id 		INTEGER(10) NOT NULL	COMMENT 'ID für Kursart, Fremdschlüssel, 0 wenn keine Kursart',
  zug_id 		INTEGER(10) NOT NULL	COMMENT 'Zug-ID (Klasse, Lerngruppe), Fremdschlüssel, 0 wenn kein Zug',
  zeitbedarf_std	INTEGER(5)		COMMENT 'Zeitbedarf in Stunden',
  zeitbedarf_wochen	INTEGER(5)		COMMENT 'Zeitbedarf in Wochen, wichtig für Zeitplan',
  beginn_kw		INTEGER(5)		COMMENT 'Kalenderwoche: Beginn',
  ende_kw		INTEGER(5)		COMMENT 'Kalenderwoche: Ende',
  aenderung_user_id	INTEGER			COMMENT 'Hinweis auf die Person, die zuletzt änderte',
  aenderung_zeitstempel	TIMESTAMP		COMMENT 'Zeitstempel der letzten Änderung',
  CONSTRAINT pk_t170 PRIMARY KEY (user_id,uv_id))
 COMMENT 'Angaben, um Änderungen einer Sitzung rückgängig zu machen';

-- --------------------------------------------------------
-- 200-299         Konfiguration (kfg)
-- --------------------------------------------------------

-- t210_kfg_uv_textfelder
-- ----------------------
-- Konfigurierbare Textfelder für Unterrichtsvorhaben
DROP TABLE IF EXISTS part1_t210_kfg_uv_textfelder;
CREATE TABLE part1_t210_kfg_uv_textfelder
 (textfeld_id 		INTEGER(10) NOT NULL	COMMENT 'eindeutige ID für Textfeld, Primärschlüssel',
  textfeld		VARCHAR(30) NOT NULL	COMMENT '(eindeutige) Bezeichnung des Textfeldes',
  textfeld_label	VARCHAR(100)		COMMENT 'Beschriftung des Textfeldes in Eingabeformular',
  textfeld_beschreibung	VARCHAR(200)		COMMENT 'Hinweise/Hilfetext zum Textfeld',
  textfeld_bem		VARCHAR(200)		COMMENT 'Bemerkungen zum Textfeld',
  feldlaenge		INTEGER(4)		COMMENT 'optionale Zeichenlängenbeschränkung',
  pflichtfeld		INTEGER(1)		COMMENT 'Muss Feld ausgefüllt werden (0/1 = nein/ja)?',
  plananzeige		INTEGER(1)		COMMENT 'Soll Feld in Planübersicht angezeigt werden (0/1 = nein/ja)?',
  reihenfolge		INTEGER(4)		COMMENT 'Reihenfolge zur Sortierung',
  nur_lehrkraefte	INTEGER(1)		COMMENT 'Soll Feld nur für Lehrkräfte sichtbar sein (0/1 = nein/ja)?',
  CONSTRAINT pk_t210 PRIMARY KEY (textfeld_id),
  CONSTRAINT uk_t210_textfeld UNIQUE (textfeld))
 COMMENT 'Konfigurierbare Textfelder für Unterrichtsvorhaben';


-- Initialisierung der Felder:
INSERT INTO part1_t210_kfg_uv_textfelder (textfeld_id,textfeld,textfeld_label,textfeld_beschreibung,textfeld_bem,feldlaenge,pflichtfeld,plananzeige,reihenfolge) 
                            VALUES (1, 'schwerpunkte', 'Inhaltliche Schwerpunkte','Aufzählung der inhaltlichen Schwerpunkte',null,null,1,1,100);
INSERT INTO part1_t210_kfg_uv_textfelder (textfeld_id,textfeld,textfeld_label,textfeld_beschreibung,textfeld_bem,feldlaenge,pflichtfeld,reihenfolge) 
                            VALUES (2, 'kompetenzen', 'Kompetenzen','Aufzählung der zu erlerndenen Kompetenzen',null,null,0,200);
INSERT INTO part1_t210_kfg_uv_textfelder (textfeld_id,textfeld,textfeld_label,textfeld_beschreibung,textfeld_bem,feldlaenge,pflichtfeld,reihenfolge) 
                            VALUES (3, 'inhaltsfelder', 'Inhaltsfelder','Aufzählung der Inhaltsfelder',null,null,0,300);
INSERT INTO part1_t210_kfg_uv_textfelder (textfeld_id,textfeld,textfeld_label,textfeld_beschreibung,textfeld_bem,feldlaenge,pflichtfeld,reihenfolge) 
                            VALUES (4, 'link', 'Konkretisierung (URL)','Link zu konkreteren Informationen',null,null,0,400);
INSERT INTO part1_t210_kfg_uv_textfelder (textfeld_id,textfeld,textfeld_label,textfeld_beschreibung,textfeld_bem,feldlaenge,pflichtfeld,reihenfolge) 
                            VALUES (5, 'zusatzinfo', 'Zusatzinformationen','Weitere Informationen zum Unterrichtsvorhaben','Testfeld',null,0,500);


-- --------------------------------------------------------
-- 300-499         Kataloge, auch konfigurierbar (kat)
-- --------------------------------------------------------

-- Schulformen:
-- ------------
DROP TABLE IF EXISTS part1_t310_kat_schulform;
CREATE TABLE part1_t310_kat_schulform
 (schulform_id 		INTEGER(10) NOT NULL	COMMENT 'eindeutige Schulform-ID, Primärschlüssel',
  schulform		VARCHAR(30) NOT NULL	COMMENT 'Bezeichnung der Schulform',
  schulformkuerzel      VARCHAR(5) NOT NULL	COMMENT 'Kürzel für die Schulform, auch eindeutig',
  schulform_bem		VARCHAR(200)		COMMENT 'Bemerkungen zur Schulform',
  CONSTRAINT pk_t310 PRIMARY KEY (schulform_id),
  CONSTRAINT uk_t310_schulformkuerzel UNIQUE (schulformkuerzel))
 COMMENT 'Katalog der Schulformen';

-- Füllen des Katalogs:
INSERT INTO part1_t310_kat_schulform (schulform_id,schulform,schulformkuerzel) VALUES (1, 'Hauptschule', 'HS');
INSERT INTO part1_t310_kat_schulform (schulform_id,schulform,schulformkuerzel) VALUES (2, 'Gesamtschule', 'GE');
INSERT INTO part1_t310_kat_schulform (schulform_id,schulform,schulformkuerzel) VALUES (3, 'Realschule', 'RS');
INSERT INTO part1_t310_kat_schulform (schulform_id,schulform,schulformkuerzel) VALUES (4, 'Gymnasium', 'GY');



-- Stufen:
-- -------
-- Stufenbezeichnungen als String, damit auch individuelle Stufenbezeichnungen möglich sind.
DROP TABLE IF EXISTS part1_t330_kat_stufe;
CREATE TABLE part1_t330_kat_stufe
 (stufe_id 		INTEGER(10) NOT NULL	COMMENT 'eindeutige Stufen-ID, Primärschlüssel',
  stufe			VARCHAR(10) NOT NULL	COMMENT '(eindeutige) Bezeichnung der Stufe, normalerweise Zahl, kann aber auch Buchstaben enthalten',
  stufe_bem		VARCHAR(200)		COMMENT 'Bemerkungen zur Stufe',
  CONSTRAINT pk_t330 PRIMARY KEY (stufe_id),
  CONSTRAINT uk_t330_stufe UNIQUE (stufe))
 COMMENT 'Katalog der Jahrgangsstufen (5,6,7, ...)';

-- Füllen des Katalogs:
INSERT INTO part1_t330_kat_stufe (stufe_id,stufe) VALUES (1,'5');
INSERT INTO part1_t330_kat_stufe (stufe_id,stufe) VALUES (2,'6');
INSERT INTO part1_t330_kat_stufe (stufe_id,stufe) VALUES (3,'7');
INSERT INTO part1_t330_kat_stufe (stufe_id,stufe) VALUES (4,'8');
INSERT INTO part1_t330_kat_stufe (stufe_id,stufe) VALUES (5,'9');
INSERT INTO part1_t330_kat_stufe (stufe_id,stufe) VALUES (6,'10');


-- Züge:
-- -----
-- Bezeichnungen einzelner Züge / Klassen / Lerngruppen, wie a, b, c
DROP TABLE IF EXISTS part1_t340_kat_zug;
CREATE TABLE part1_t340_kat_zug
 (zug_id 		INTEGER(10) NOT NULL	COMMENT 'eindeutige ID für Zug (Klasse, Lerngruppe), Primärschlüssel',
  zug			VARCHAR(25) NOT NULL	COMMENT '(eindeutige) Bezeichnung des Zuges wie a, b, c',
  zug_bem		VARCHAR(200)		COMMENT 'Bemerkungen zum Zug',
  CONSTRAINT pk_t340 PRIMARY KEY (zug_id),
  CONSTRAINT uk_t340_stufe UNIQUE (zug))
 COMMENT 'Katalog der Züge (Klassen-Kürzel, Lerngruppen wie a, b, c)';

-- Füllen des Katalogs:
INSERT INTO part1_t340_kat_zug (zug_id,zug) VALUES (0,'keiner');
INSERT INTO part1_t340_kat_zug (zug_id,zug) VALUES (1,'a');
INSERT INTO part1_t340_kat_zug (zug_id,zug) VALUES (2,'b');
INSERT INTO part1_t340_kat_zug (zug_id,zug) VALUES (3,'c');
INSERT INTO part1_t340_kat_zug (zug_id,zug) VALUES (4,'d');
INSERT INTO part1_t340_kat_zug (zug_id,zug) VALUES (5,'e');
INSERT INTO part1_t340_kat_zug (zug_id,zug) VALUES (6,'f');

-- Kursarten:
-- ----------
-- Kursarten wie EK, GK, etc.
DROP TABLE IF EXISTS part1_t350_kat_kursart;
CREATE TABLE part1_t350_kat_kursart
 (kursart_id 		INTEGER(10) NOT NULL	COMMENT 'eindeutige ID für Kursart, Primärschlüssel',
  kursart		VARCHAR(10) NOT NULL	COMMENT '(eindeutige) Kurz-Bezeichnung der Kursart (z.B. E-Kurs)',
  kursart_bezeichnung	VARCHAR(50)		COMMENT 'evtl. längere Bezeichnung der Kursart',
  kursart_bem		VARCHAR(200)		COMMENT 'Bemerkungen zur Kursart',
  CONSTRAINT pk_t350 PRIMARY KEY (kursart_id),
  CONSTRAINT uk_t350_kursart UNIQUE (kursart))
 COMMENT 'Katalog der Kursarten wie E-Kurs, GK, etc.';


-- Füllen des Katalogs:
INSERT INTO part1_t350_kat_kursart (kursart_id,kursart,kursart_bezeichnung,kursart_bem) VALUES (0,'keine','keine Kurs-Differenzierung',NULL);
INSERT INTO part1_t350_kat_kursart (kursart_id,kursart,kursart_bezeichnung) VALUES (1,'E-Kurs','Erweiterungskurs');
INSERT INTO part1_t350_kat_kursart (kursart_id,kursart,kursart_bezeichnung) VALUES (2,'G-Kurs','Grundkurs');


-- --------------------------------------------------------
-- 500-699         Eingabedaten (ein) 
-- --------------------------------------------------------

-- Unterrichtsvorhaben:
-- --------------------
DROP TABLE IF EXISTS part1_t510_ein_unterrichtsvorhaben;
CREATE TABLE part1_t510_ein_unterrichtsvorhaben
 (uv_id 		INTEGER(12) NOT NULL	COMMENT 'eindeutige ID für das Unterrichtsvorhaben, Primärschlüssel',
  schulform_id 		INTEGER(10) NOT NULL	COMMENT 'Schulform-ID, Fremdschlüssel',
  fach_id 		INTEGER(10) NOT NULL	COMMENT 'Fach-ID, Fremdschlüssel',
  stufe_id 		INTEGER(10) NOT NULL	COMMENT 'Stufen-ID, Fremdschlüssel',
  kursart_id 		INTEGER(10) NOT NULL	COMMENT 'ID für Kursart, Fremdschlüssel, 0 wenn keine Kursart',
  zug_id 		INTEGER(10) NOT NULL	COMMENT 'Zug-ID (Klasse, Lerngruppe), Fremdschlüssel, 0 wenn kein Zug',
  uv_titel		VARCHAR(100) NOT NULL	COMMENT 'Titel des Unterrichtsvorhabens',
  zeitbedarf_std	INTEGER(5)		COMMENT 'Zeitbedarf in Stunden',
  zeitbedarf_wochen	INTEGER(5)		COMMENT 'Zeitbedarf in Wochen, wichtig für Zeitplan',
  beginn_kw		INTEGER(5)		COMMENT 'Kalenderwoche: Beginn',
  ende_kw		INTEGER(5)		COMMENT 'Kalenderwoche: Ende',
  aenderung_user_id	INTEGER			COMMENT 'Hinweis auf die Person, die zuletzt änderte',
  aenderung_zeitstempel	TIMESTAMP		COMMENT 'Zeitstempel der letzten Änderung',
  CONSTRAINT pk_t510 PRIMARY KEY (uv_id),
  CONSTRAINT fk_t510_schulform FOREIGN KEY (schulform_id) REFERENCES part1_t310_kat_schulform (schulform_id),
  CONSTRAINT fk_t510_fach FOREIGN KEY (fach_id) REFERENCES part1_t320_kat_fach (fach_id),
  CONSTRAINT fk_t510_stufe FOREIGN KEY (stufe_id) REFERENCES part1_t330_kat_stufe (stufe_id),
  CONSTRAINT fk_t510_kursart FOREIGN KEY (kursart_id) REFERENCES part1_t350_kat_kursart (kursart_id),
  CONSTRAINT fk_t510_zug FOREIGN KEY (zug_id) REFERENCES part1_t340_kat_zug (zug_id))
 COMMENT 'Eingabetabelle mit allen Unterrichtsvorhaben';

-- Kein Fremdschlüssel für user_id, um ggf. auch Daten ohne User-Zuordnung verwalten zu können.

-- Weitere Angaben zu Unterrichtsvorhaben in weiterer Tabelle:
-- Präfix "r_" für Relationstabelle (Verbindung zwischen t510_ein_unterrichtsvorhaben und t210_kfg_uv_textfelder):
DROP TABLE IF EXISTS part1_t520_ein_r_uv_textfelder;
CREATE TABLE part1_t520_ein_r_uv_textfelder
 (uv_id 		INTEGER(12) NOT NULL	COMMENT 'ID für das Unterrichtsvorhaben, Teil-Primärschlüssel',
  textfeld_id 		INTEGER(10) NOT NULL	COMMENT 'ID für Textfeld, Teil-Primärschlüssel',
  uv_text 		TEXT			COMMENT 'Textwert für dieses Feld',
  CONSTRAINT pk_t520 PRIMARY KEY (uv_id,textfeld_id),
  CONSTRAINT fk_t520_uv FOREIGN KEY (uv_id) REFERENCES part1_t510_ein_unterrichtsvorhaben (uv_id),
  CONSTRAINT fk_t520_textfeld FOREIGN KEY (textfeld_id) REFERENCES part1_t210_kfg_uv_textfelder (textfeld_id))
 COMMENT 'Weitere Text-Angaben zu Unterrichtsvorhaben';

-- Wochenstundenzahlen:
-- --------------------
DROP TABLE IF EXISTS part1_t540_ein_wochenstunden;
CREATE TABLE part1_t540_ein_wochenstunden
 (schulform_id 		INTEGER(10) NOT NULL	COMMENT 'Schulform-ID, Teilprimärschlüssel, FK',
  fach_id 		INTEGER(10) NOT NULL	COMMENT 'Fach-ID, Teilprimärschlüssel, FK',
  stufe_id 		INTEGER(10) NOT NULL	COMMENT 'Stufen-ID, Teilprimärschlüssel, FK',
  kursart_id 		INTEGER(10) NOT NULL	COMMENT 'ID für Kursart, Teilprimärschlüssel, FK, 0 wenn keine Kursart',
  zug_id 		INTEGER(10) NOT NULL	COMMENT 'Zug-ID (Klasse, Lerngruppe), Teilprimärschlüssel, FK, 0 wenn kein Zug',
  wochenstunden		INTEGER(5)		COMMENT 'Wochenstundenzahl',
  aenderung_zeitstempel	TIMESTAMP		COMMENT 'Zeitstempel der letzten Änderung',
  CONSTRAINT pk_t540 PRIMARY KEY (schulform_id,fach_id,stufe_id,kursart_id,zug_id),
  CONSTRAINT fk_t540_schulform FOREIGN KEY (schulform_id) REFERENCES part1_t310_kat_schulform (schulform_id),
  CONSTRAINT fk_t540_fach FOREIGN KEY (fach_id) REFERENCES part1_t320_kat_fach (fach_id),
  CONSTRAINT fk_t540_stufe FOREIGN KEY (stufe_id) REFERENCES part1_t330_kat_stufe (stufe_id),
  CONSTRAINT fk_t540_kursart FOREIGN KEY (kursart_id) REFERENCES part1_t350_kat_kursart (kursart_id),
  CONSTRAINT fk_t540_zug FOREIGN KEY (zug_id) REFERENCES part1_t340_kat_zug (zug_id))
 COMMENT 'Eingabetabelle mit Wochenstundenzahlen';

      
