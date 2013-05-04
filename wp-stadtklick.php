<?php
/*
 Plugin Name: Stadtklick
 Version: 0.1
 Plugin URI: http://herrthees.de/
 Author: Ralf Thees
 Author URI: http://herrthees.de/
 Description: Plugin für "Lass den Klick in deiner Stadt"
 */
 
 
 $wuebu_stadtklick_buchhandlungUrlArray=  Array(
 	array(
 		'name'=>'Buchhandlung erLesen',
 		'url'=>'http://272900.umbreitwebshop.de/cgi-bin/umb_shop.exe/show?page=vollanzeige.html&ISBN=%%isbn%%&action=vollanzeige'
 		),
	array(
 		'name'=>'Buchhandlung Neuer Weg',
 		'url'=>'http://www.buchkatalog.de/kod-bin/isuche.cgi?dbname=Buchkatalog&lang=deutsch&uid=neuerweg-29042013-211453993-C03344&caller=neuerweg&usecookie=ja&sb=%%isbn%%'
 		),
	array(
 		'name'=>'Buchhandlung Schöningh',
 		'url'=>'http://www.schoeningh-buch.de/shop/item/%%isbn%%'
 		),
	array(
 		'name'=>'Buchhandlung Knodt',
 		'url'=>'http://knodt.shop-asp.de/shop/action/quickSearch?aUrl=90007222&searchString=%%isbn%%'
		), 
	array(
 		'name'=>'Buchhandlung Dreizehneinhalb',
 		'url'=>'http://shop.dreizehneinhalb.de/webapp/wcs/stores/servlet/SearchCmd/66216/4099276460822233275/-3/%%isbn%%'
 		),
 	array(
 		'name'=>'Hätzfelder Bücherstube',
 		'url'=>'http://www.buchkatalog-reloaded.de/webapp/wcs/stores/servlet/SearchCmd/38220/4099276460822233274/-3/%%isbn%%'
 		),
 	array(
 		'name'=>'Stephans-Buchhandlung',
 		'url'=>'http://shop.stephans-buchhandlung.de/buchkatalog/search/result/?q=%%isbn%%'
 		)
		
	);
	
	
	if ($_GET["stadtklick_isbn"]) {
		$buchlink=wuebu_stadtklick_get_random_shop($_GET['stadtklick_isbn']);
		$url=$buchlink['url'];
		header("Location: ".$url);
		exit;
	}
	
	function wuebu_stadtklick_get_random_shop($isbn) {
		global $wuebu_stadtklick_buchhandlungUrlArray;
		$isbn=str_replace('-', '', $isbn);
		$randomShopNumber=rand(0, sizeof($wuebu_stadtklick_buchhandlungUrlArray)-1);
		$shopUrl=$wuebu_stadtklick_buchhandlungUrlArray[$randomShopNumber]['url'];
		$shopUrl=str_replace('%%isbn%%', $isbn, $shopUrl);
		$randomShop=array(
			'isbn'=>$isbn,
			'name'=>$wuebu_stadtklick_buchhandlungUrlArray[$randomShopNumber]['name'],
			'url'=>$shopUrl
		);
		return $randomShop;
	}
	
	function wuebu_stadtklick_shortcode_func( $attr ) {
		extract( shortcode_atts( array(
			'isbn' => '00000',
		), $attr ) );
		$buchlink=wuebu_stadtklick_get_random_shop($isbn);
		return '<a href="'.$buchlink['url'].'">'.$buchlink['name'].'</a>';
	}
	add_shortcode("stadtklick", "wuebu_stadtklick_shortcode_func");


?>