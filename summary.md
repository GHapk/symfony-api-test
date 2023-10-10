# Zusammenfassung

## Allgemeine Anmerkungen

Damit das Projekt lauffähig war musste ich eine Anpassung an der ddocker-compse.yml vornehmen, da sonst die DB nicht
gestartet und ausgeführt wurde.

Ich habe dem User web in der Datenbank noch einige Rechte für z.B. Bundesland und einigen Sequenzen geben da diese
vorhanden waren und die damit verbunden Aufgaben der Api nicht ausführbar waren. Ich habe mich dafür entschieden, da 
es in meinen Augen nicht verschiedene Entitymanager mit unterschiedlichen Usern benötigt und gerade beim auslesen 
zu Performanceverlusten kommt.

Ich habe Eigenes mit Objekttransformationen (Entity <-> DTO) gemacht. Diese wäre wahrscheinlicht so umfangreich 
nötig gewesen. Da es aber keine Vorgaben zur Sprache außer dem Output der API gabe habe ich mich entschieden den 
größten Teil Codes auf Englisch zur schreiben.

Da es keine Vorgaben für den User-Part der Api bezüglich der Vermittlerzuordnung gab habe ich mich hier entschieden das
jeder Vermittler zu jedem Kunden einen User angelgen kann.

Insgesamt habe ich ca. 12h Entwicklungs- und Recherchezeit aufgewendet für diesen Stand.

## Api

Die Api ist unter http://localhost:8080/foo erreichbar. Die Funktionen sind manuell getestet. Und sollten vollständig
sein. Ich habe mich gegen unittests entschieden um den Zeitraum bis zur Bereitstellung der Lösung nicht noch weiter 
zu verlängern.


## Zusatzaufgabe

Die Zusatzausfgabe zur Absicherung der Api mit einem JWT ist grundsätzlich umgesetzt. Bei mir gab es das Problem 
das bei der lokalen Ausführung der "Bearer"-Prefix im Header immer entfernt wurde. Jedoch konnte ich ohne den 
konfigurierten Prefix den Token nicht generieren. Darum habe ich mich entschieden im Rahmen der Umsetzung mich nicht
um die Headermanipulation serverseitig zu kümmern. Ich habe unter 
https://github.com/GHapk/symfony-api-test/blob/main/src/Service/CustomAuthorizationHeaderTokenExtractor.php einen
Workaraund gebaut der die Lösung der Aufgabe aktuell zulässt.

## Known-Issues und ToDo's

Die Api-Doc ist nicht zu 100% perfect da Teilweise noch Properties mit ausgegebn werden, die irrelevant sind und auch
nicht verarbeitet werden. Auch wird in der Responsestruktur teilweise im Doc-Part teilweise noch die Entity anstatt 
der DTO-Struktur ausgegeben (die Api-Response selbst sollte den Vorgaben entsprechen). Hier habe ich versucht eine
Lösung zu haben. Habe dabei aber immer wieder Fehler und Exceptions bekommen. Das wäre der Part wo ich auf 
Teammitglieder zugehen würde und um Hilfe bitten würden.

Gern kann die Aufgabe verbessert und kommentiert werden.