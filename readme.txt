=== WP-StadtKlick ===
Contributors: wuerzblog
Donate link: https://flattr.com/thing/1316466/Lass-den-Klick-in-deiner-Stadt-Das-WordPress-Plugin
Tags: books, shop, ecommerce, deeplink, randomize
Requires at least: 2.8.0
Tested up to: 3.5.1
Stable tag: 0.1
License: GPLv2 or later

Setzt einen Link auf ein Buch in einem zufällig ausgewählten Online-Shop eines Buchladens. 

== Description ==

WP-Stadtklick ist ein Plugin, um die Aktion "Lass den Klick in deiner Stadt" in Wordpress zu integrieren. Die Aktion mancher lokaler Buchhändler will darauf Aufmerksam machen, dass man Bücher online nicht nur bei Amazon, sondern auch in Online-Shops der Buchläden vor Ort.

Will man nun auf ein Buch im Blog verlinken, steht man dabei vor dem Problem, dass man sich entweder für den Webshop eines Buchladens entscheiden oder eine länger Liste mit Links zu allen regionalen Webshops erstellen müsste. 

Das Plugin verlinkt nun zufällig auf einen Online-Shop eines Buchladens - im Moment nur auf Läden in Würzburg.

* [Website "Lass den Klick in deiner Stadt, Würzburg"](http://buylocal-wuerzburg.de/)
* [WP-StadtKlick bei GitHub](https://github.com/rthees/wp-stadtklick)

== Installation ==

Einfach installieren

== Anwendung ==

Einen Link auf ein Buch setzt man per Shortcode [stadtklick] im Artikeleditor.

Beispiel:
[stadtklick isbn=9783862822355]

== Upgrade Notice ==

= 0.2 =

+ all isbn will be converted to isbn-13/ean
+ simple options-page 

== Changelog ==

= 0.2 =

+ all isbn will be converted to isbn-13/ean

= 0.1 =

* hardcoded URLs
* redirect with query-string
* one random link per shortcode