<?php
/*
 Plugin Name: WP-Stadtklick
 Version: 0.5
 Plugin URI: http://wuerzblog.de/2013/05/05/lass-den-klick-in-deiner-stadt-das-wordpress-plugin/
 Author: Ralf Thees
 Author URI: http://herrthees.de/
 Description: Plugin für "Lass den Klick in deiner Stadt"
 */
  
 $wuebu_stadtklick_buchhandlungUrlArray=  get_option('wp_stadtklick_options');
 
 
 	 if ( function_exists('register_uninstall_hook') ) register_uninstall_hook(__FILE__, 'wuebu_stadtklick_uninstall');

	function wuebu_stadtklick_uninstall() {
		 delete_option('wp_stadtklick_options'); 
	}

	function wuebu_stadtklick_activate() {
		update_option('wp_stadtklick_more_options',array("target"=>'_blank','version'=>'0.4.3'));
	    
	}
	register_activation_hook( __FILE__, 'wuebu_stadtklick_activate' );
	
	add_filter('plugin_row_meta', 'wuebu_stadtklick_plugin_meta', 10, 2);



	function wuebu_stadtklick_plugin_meta($links, $file) {
		$plugin = plugin_basename(__FILE__);
		// create link
		if ($file == $plugin) {
			return array_merge(
				$links, 
				array(sprintf('<a href="https://flattr.com/thing/1316466/Lass-den-Klick-in-deiner-Stadt-Das-WordPress-Plugin">%s</a>', __('Spende mit Flattr', 'wp_stadtklick'))));
		}
		return $links;
	}
 

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
		$shopUrl=$wuebu_stadtklick_buchhandlungUrlArray[$randomShopNumber]['shop']['url'];
		$shopUrl=str_replace('%%isbn%%', $isbn, $shopUrl);
		$randomShop=array(
			'isbn'=>$isbn,
			'name'=>$wuebu_stadtklick_buchhandlungUrlArray[$randomShopNumber]['shop']['name'],
			'url'=>$shopUrl
		);
		return $randomShop;
	}
	
	function wuebu_stadtklick_get_shoplist($isbn) {
		global $wuebu_stadtklick_buchhandlungUrlArray;
		shuffle($wuebu_stadtklick_buchhandlungUrlArray);
		$isbn=isbn10to13($isbn);
		$out='<ul class="wpstadtklick-list">';
		foreach ($wuebu_stadtklick_buchhandlungUrlArray as $bh) {
			$shopUrl=str_replace('%%isbn%%', $isbn, $bh['shop']['url']);
			$out.='<li><a href="'.$shopUrl.'">'.$bh['shop']['name'].'</a></li>';
		}
		$out.='</ul>';
		return $out;
		
	}
	
	function wuebu_stadtklick_shortcode_func( $attr ) {
		extract( shortcode_atts( array(
			'isbn' => '00000',
			'name' => '',
			'output' => ''
		), $attr ) );
		$buchlink=wuebu_stadtklick_get_random_shop($isbn);
		if ($name) {
			$urltitle=$name;
		} else {
			$urltitle=$buchlink['name'];
		}
		
		if ($output=='list') {
			return wuebu_stadtklick_get_shoplist($isbn);
		} else {
			return '<a href="'.site_url('/isbn/').isbn10to13($isbn).'">'.$urltitle.'</a>';	
			return '<a href="'.$buchlink['url'].'">'.$urltitle.'</a>';
		}
	}
	add_shortcode("stadtklick", "wuebu_stadtklick_shortcode_func");
	
	
  
function wuebu_stadtklick_add_rewrites() {  
    
  global $wp_rewrite;  
  $new_non_wp_rules = array(  
    'isbn/(.*)'       => '/index.php?stadtklick_isbn=$1'
  );  
  $wp_rewrite->non_wp_rules += $new_non_wp_rules;  
}  

add_action('generate_rewrite_rules', 'wuebu_stadtklick_add_rewrites');  

// Options


add_action('admin_menu', 'wp_stadtklick_create_menu');
function wp_stadtklick_create_menu() {
	add_options_page('WP-Stadtklick-Einstellungen', 'WP-Stadtklick', 'manage_options', 'wp_stadtklick', 'wp_stadtklick_options_page');
}


add_action('admin_init', 'register_wp_stadtklick' );
function register_wp_stadtklick() {
	load_plugin_textdomain('wp_stadtklick', false, dirname(plugin_basename(__FILE__)) . '');
	register_setting( 'wp_stadtklick_options', 'wp_stadtklick_options', 'wp_stadtklick_validate' );
	add_settings_section('wp_stadtklick_shops', 'Webshop-Einstellungen', 'wp_stadtklick_section_shop', 'wp_stadtklick');
	add_settings_field('wp_stadtklick_shop','Name des Buchladens', 'wp_stadtklick_shop_name_input', 'wp_stadtklick', 'wp_stadtklick_shops');
}

function wp_stadtklick_section_shop() {
	echo '<p>Webshop-Einstellungen</p>';
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
	
	wp_register_script( 'wpskscript', plugins_url('/wpskscript.js', __FILE__), array('jquery'));

	wp_enqueue_script( 'wpskscript' );
 

?>
<div class="wrap">
<h2>WP-Stadtklick - Einstellungen</h2>
<form method="post" action="options.php">
<?php $options = get_option('wp_stadtklick_options');
	// print_r($options);
?>
<?php settings_fields('wp_stadtklick_options'); ?>

<?php //do_settings_sections('wp_stadtklick'); ?>


<?php
$i=0;
if (is_array($options)) {
	echo '<table class="widefat">';
	echo '<thead>';
	echo '<tr  scope="col"><th>'.__('Name der Buchhandlung', 'wp_stadtklick').'</th><th scope="col">'.__('URL zu einem Buch im Webshop', 'wp_stadtklick').'</th><th>'.__('Aktion', 'wp_stadtklick').'</th></tr>';
	echo '</thead>';
	foreach ($options as $o) {
	?>

	<tr valign="top">
	<td id="<?php echo "wpskrowid$i"; ?>" scope="col"><input name="wp_stadtklick_options[<?php echo $i; ?>][shop][name]" size='34'  type="text" value="<?php echo $o['shop']['name']; ?>" /></td>
	<td scope="col"><input type="text" name="wp_stadtklick_options[<?php echo $i; ?>][shop][url]" size='80'  value="<?php echo $o['shop']['url']; ?>" /></td>
	<td scope="col"><a class="wpskrow" href="#"><?php echo __('Löschen', 'wp_stadtklick'); ?></a></td>
	</tr>
	<?php
	$i++;
	}
	echo '</table>';
	}
?>
<p></p>
<table class="widefat">
<tr><th colspan="2"><strong>Neue Buchhandlung</strong></th></tr>
<tr valign="top"><th scope="row"><?php echo __('Name der Buchhandlung', 'wp_stadtklick'); ?></th>
<td><input name="wp_stadtklick_options[<?php echo $i; ?>][shop][name]" size='30'  type="text" value="" /></td>
</tr>
<tr valign="top"><th scope="row"><?php echo __('URL zu einem Buch im Webshop<br/>(%%isbn%% anstelle der ISBN-Nummer)', 'wp_stadtklick'); ?></th>
<td><input type="text" name="wp_stadtklick_options[<?php echo $i; ?>][shop][url]"  size='80'  value="" /></td>
</tr>
</table>

<?php submit_button(); ?>
</form>
</div>
<?php
}
?>