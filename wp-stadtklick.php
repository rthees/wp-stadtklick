<?php
/*
 Plugin Name: Stadtklick
 Version: 0.2
 Plugin URI: http://herrthees.de/
 Author: Ralf Thees
 Author URI: http://herrthees.de/
 Description: Plugin für "Lass den Klick in deiner Stadt"
 */
 
load_plugin_textdomain('wp_stadtklick', false, dirname(plugin_basename(__FILE__)) . '');
//include_once dirname( __FILE__ )  .'/wp_stadtklick_options.php';
 
 $wuebu_stadtklick_buchhandlungUrlArray=  Array(
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
 		),
 	array(
 		'name'=>'Buchhandlung erLesen',
 		'url'=>'http://272900.umbreitwebshop.de/cgi-bin/umb_shop.exe/show?page=vollanzeige.html&titel_id=%%isbn%%&action=vollanzeige'
 		)
	);
	
	function isbn10to13($isbn) {
		$isbn=str_replace('-', '', $isbn);
		if (strlen($isbn)==10) {
			$isbn="978".$isbn;  // Buchkennung
			$isbn=substr($isbn,0,strlen($isbn)-1); // ISBN-10-Prüfziffer abschneiden
			$pruefziffer=(10-(($isbn[0]+$isbn[2]+$isbn[4]+$isbn[6]+$isbn[8]+$isbn[10]+3*($isbn[1]+$isbn[3]+$isbn[5]+$isbn[7]+$isbn[9]+$isbn[11]))%10)%10); // Prüfziffer berechnen
			$isbn=$isbn.$pruefziffer; // Prüfziffer anhängen
			
		}
		return $isbn;
	}
	
	
	if ($_GET["stadtklick_isbn"]) {
		$buchlink=wuebu_stadtklick_get_random_shop($_GET['stadtklick_isbn']);
		$url=$buchlink['url'];
		header("Location: ".$url);
		exit;
	}
	
	function wuebu_stadtklick_get_random_shop($isbn) {
		global $wuebu_stadtklick_buchhandlungUrlArray;
		$isbn=isbn10to13($isbn);
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
			'name' => ''
		), $attr ) );
		$buchlink=wuebu_stadtklick_get_random_shop($isbn);
		if ($name) {
			$urltitle=$name;
		} else {
			$urltitle=$buchlink['name'];
		}
		
		return '<a href="'.$buchlink['url'].'">'.$urltitle.'</a>';
	}
	add_shortcode("stadtklick", "wuebu_stadtklick_shortcode_func");


// Options


add_action('admin_menu', 'wp_stadtklick_create_menu');
function wp_stadtklick_create_menu() {
	add_options_page('WP-Stadtklick-Einstellungen', 'WP-Stadtklick', 'manage_options', 'wp_stadtklick', 'wp_stadtklick_options_page');
}


add_action('admin_init', 'register_wp_stadtklick' );
function register_wp_stadtklick() {
	register_setting( 'wp_stadtklick_options', 'wp_stadtklick_options', 'wp_stadtklick_validate' );
	add_settings_section('wp_stadtklick_shops', 'Webshop-Einstellungen', 'wp_stadtklick_section_shop', 'wp_stadtklick');
	add_settings_field('wp_stadtklick_shop','Name des Buchladens', 'wp_stadtklick_shop_name_input', 'wp_stadtklick', 'wp_stadtklick_shops');
}

function wp_stadtklick_section_shop() {
	echo '<p>Webshop-EInstellungen</p>';
}

function wp_stadtklick_shop_name_input() {
	$options = get_option('wp_stadtklick_options');
	//echo "<pre>"; print_r($options); echo "</pre>";
	$i=0;
	if (is_array($options)) {
	foreach ($options as $o) {
		echo '<div style="border: 1px solid #999; padding: 0 0 10px 0;">';
		echo "<input id='wp_stadtklick_shop_name_$i' name='wp_stadtklick_options[$i][shop][name]' size='80' type='text' value='".$o['shop']['name']."' /><br/>";
		echo "<input id='wp_stadtklick_shop_url_$i' name='wp_stadtklick_options[$i][shop][url]' size='80' type='text' value='".$o['shop']['url']."' /><br/>";
		echo '</div>';
		$i++;
	}
	}
			echo "<input id='wp_stadtklick_shop_name' name='wp_stadtklick_options[$i][shop][name]' size='80' type='text' value='' /><br/>";
			echo "<input id='wp_stadtklick_shop_url_$i' name='wp_stadtklick_options[$i][shop][url]' size='80' type='text' value='' /><br/>";
		
	
}

// validate  options
function wp_stadtklick_validate($input) {
	$options = get_option('wp_stadtklick_options');
	$final=array();
	foreach($input as $o) {
		$o['shop']['name']=trim($o['shop']['name']);
		if ($o['shop']['name']!=='') $final[]=$o ;
	}
	$options=$final;
	return $options;
}



function wp_stadtklick_options_page() { 
	?>
	<div class="wrap">
	<h2>WP-Stadtklick - Einstellungen</h2>
	<form method="post" action="options.php"> 
		
	<?php settings_fields( 'wp_stadtklick_options' ); ?>
	
	<?php // $options = get_option('wp_stadtklick'); print_r($options); ?>
	<?php do_settings_sections('wp_stadtklick'); ?>
	<!--
	<table class="form-table">
		
	    		<tr><th colspan="2">Neue Buchhandlung</th></tr>
	    		<tr valign="top"><th scope="row"><?php __('Name der Buchhandlung','wp_stadtklick'); ?></th>
	                    <td><input name="wp_stadtklick" type="text" value="" /></td>
	                </tr>
	                <tr valign="top"><th scope="row"><?php __('URL zu einem Buch im Webshop (%%isbn%% anstelle der ISBN-Nummer','wp_stadtklick'); ?></th>
	                    <td><input type="text" name="wp_stadtklick2" value="" /></td>
	                </tr>
	            </table>
	           //-->
				<?php submit_button(); ?>
	</form>
	</div>
<?php 
} 
?>