=== WP-StadtKlick ===
Contributors: wuerzblog
Donate link: https://flattr.com/thing/1316466/Lass-den-Klick-in-deiner-Stadt-Das-WordPress-Plugin
Tags: books, shop, ecommerce, deeplink, randomize
Requires at least: 2.8.0
Tested up to: 3.6
Stable tag: 0.4
License: GPLv2 or later

Setzt einen Link auf ein Buch in einem zufällig ausgewählten Online-Shop eines Buchladens. 

== Description ==

WP-Stadtklick ist ein Plugin, um die Aktion "Lass den Klick in deiner Stadt" in Wordpress zu integrieren. Die Aktion mancher lokaler Buchhändler will darauf aufmerksam machen, dass man Bücher online nicht nur bei Amazon, sondern auch in Online-Shops der Buchläden vor Ort kaufen kann.

Will man nun auf ein Buch im Blog verlinken, steht man dabei vor dem Problem, dass man sich entweder für den Webshop eines Buchladens entscheiden oder eine länger Liste mit Links zu allen regionalen Webshops erstellen müsste. 

Das Plugin bietet die Möglichkeit, als einem Artikel auf ein Buch zu verlinken - zufällig in einem Online-Shop eines Buchladens.

* [Website "Lass den Klick in deiner Stadt, Würzburg"](http://buylocal-wuerzburg.de/)
* [WP-StadtKlick bei GitHub](https://github.com/rthees/wp-stadtklick)

== Installation ==

Einfach installieren

== Anwendung ==

=== Einstellungen ===

In den Einstellungen muss man mindestens einen Online-Shop anlegen. Dazu besucht man die Online-Shops der Buchhandlungen, die man als Links anbieten will. Man braucht nun die URL auf ein bestimmtes Buch, in der auch die ISBN-Nummer enthalten ist. Das geht je nach Shop-System mehr oder weniger einfach.
Manchmal kann man auch nur auf die Seite der Ergebnisse bei einer ISBN-Suche verlinken. 

Hat man eine URL mit ISBN gefunden, trägt man diese in die Einstellungen von WP-Stadtklick ein und ersetzt die echte ISBN mit dem Platzhalter %%isbn%%.
Das könnte so aussehen: http://ralfsbuchladen.de/shop/detail.php?desc=full&ean=%%isbn%%

* [Beispiele für Online-Shops von Buchhandlungen in Würzburg](https://gist.github.com/rthees/6257484)

=== Links auf Bücher im Artikel erzeugen ===
Einen Link auf ein Buch setzt man per Shortcode [stadtklick] im Artikeleditor.

Beispiele:

Einen zufälligen Link auf einen der Online-Shops anzeigen, als Link-Text wird der Name in den Einstellungen verwendet:
[stadtklick isbn=9783862822355]

Einen zufälligen Link auf einen der Online-Shops anzeigen, mit einem festen Link-Text
[stadtklick isbn=9783862822355 name="Zufälliger Buchlanden"]

Alle Online-Shops mit den jeweiligen Namen als zufällig sortierte Liste ausgeben:
[stadtklick isbn=9783862822355 output="list"]


=== Links auf Bücher für externe Nutzung erzeugen ===

Um "von Außen" auf ein Buch in einem zufälligen Online-Shop zu verlinken, gibt es folgende Möglichkeit:

Die "schöne" Möglichkeit ist, z.B. mit http://blogname.de/isbn/9783862822355 auf ein Buch zu verlinken.
Das Plugin legt dazu eine Umleitung an, wenn
* die Wordpress-Installation Permalinks verwendet
* die Permalinks in den Einstellungen neu gespeichert werden

Fall keine Text-Permalinks verwendet werden, kann man über den URL-Parameter "stadtklick_isbn" verlinken. So führt http://blogname.de?stadtklick_isbn=9783862822355 direkt zu einem Buch in einem zufällig ausgewählten Online-Shop.


== Upgrade Notice ==

= 0.3 =
+ Einstellungs-Seite für beliebige URLs von Online-Shops


== Changelog ==

= 0.3 =
+ Einstellungs-Seite für beliebige URLs von Online-Shops

= 0.2 =

+ Alle ISBN werden in ISBN-13/EAN konvertiert


= 0.1 =

* hardcoded URLs
* redirect with query-string
* one random link per shortcode