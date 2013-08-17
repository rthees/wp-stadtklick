WP-StadtKlick
=============

Das Plugin setzt einen Link auf ein Buch in einem zufällig ausgewählten Online-Shop eines Buchladens. 

== Description ==

WP-Stadtklick ist ein Plugin, um die Aktion "Lass den Klick in deiner Stadt" in Wordpress zu integrieren. Die Aktion mancher lokaler Buchhändler will darauf Aufmerksam machen, dass man Bücher online nicht nur bei Amazon, sondern auch in Online-Shops der Buchläden vor Ort.

Will man nun auf ein Buch im Blog verlinken, steht man dabei vor dem Problem, dass man sich entweder für den Webshop eines Buchladens entscheiden oder eine länger Liste mit Links zu allen regionalen Webshops erstellen müsste. 

Das Plugin verlinkt nun zufällig auf einen Online-Shop eines Buchladens - im Moment nur auf Läden in Würzburg.

== Installation ==

Einfach installieren

== Anwendung ==

In den Einstellungen muss man mindestens einen Online-Shop anlegen. Dazu besucht man die Online-Shops der Buchhandlungen, die man als Links anbieten will. Man braucht nun die URL auf ein bestimmtes Buch, in der auch die ISBN-Nummer enthalten ist. Das geht je nach Shop-System mehr oder weniger einfach.
Manchmal kann man auch nur auf die Seite der Ergebnisse bei einer ISBN-Suche verlinken. 

Hat man eine URL mit ISBN gefunden, trägt man diese in die Einstellungen von WP-Stadtklick ein und ersetzt die echte ISBN mit dem Platzhalter %%isbn%%.
Das könnte so aussehen: http://ralfsbuchladen.de/shop/detail.php?desc=full&ean=%%isbn%%


Einen Link auf ein Buch setzt man per Shortcode [stadtklick] im Artikeleditor.

Beispiele:

Einen zufälligen Link auf einen der Online-Shops anzeigen, als Link-Text wird der Name in den Einstellungen verwendet:
[stadtklick isbn=9783862822355]

Einen zufälligen Link auf einen der Online-Shops anzeigen, mit einem festen Link-Text
[stadtklick isbn=9783862822355 name="Zufälliger Buchlanden"]

Alle Online-Shops mit den jeweiligen Namen als zufällig sortierte Liste ausgeben:
[stadtklick isbn=9783862822355 output="list"]

= 0.4 =
+ Shops als Liste ausgeben (output="list")

= 0.3 =
+ Einstellungs-Seite aufgehübscht

= 0.2 =

+ all isbn will be converted to isbn-13/ean
+ simple options-page to add new bookstores

= 0.1.1 =
Fix: 

== Changelog ==

= 0.1 =

* hardcoded URLs
* redirect with query-string
* one random link per shortcode