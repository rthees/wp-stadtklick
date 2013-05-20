<?php
add_action('admin_init', 'register_wp_stadtklick' );
add_action('admin_menu', 'wp_stadtklick_create_menu');


function wp_stadtklick_create_menu() {

	add_options_page('WP-Stadtklick-Einstellungen', 'WP-Stadtklick', 'manage_options', 'wp_stadtklick', 'wp_stadtklick_options_page');

}

function register_wp_stadtklick() {
	
	register_setting( 'wp_stadtklick_options', 'wp_stadtklick' );
}

function wp_stadtklick_options_page() { 
	?>
	<div class="wrap">
	<h2>WP-Stadtklick - Einstellungen</h2>
	<form method="post" action="wp_stadtklick.php"> 
		
	<?php settings_fields( 'wp_stadtklick_options' ); ?>
	<?php $options = get_option('wp_stadtklick'); print_r($options); ?>
	
	<table class="form-table">
		<?php foreach ($options as $o) { ?>
	                <tr valign="top"><th scope="row"><?php __('Name der Buchhandlung','wp_stadtklick'); ?></th>
	                    <td><input name="wp_stadtklick[shop][][name]" type="text" value="<?php echo $o['shop']['name']; ?>" /></td>
	                </tr>
	                <tr valign="top"><th scope="row"><?php __('URL zu einem Buch im Webshop (%%isbn%% anstelle der ISBN-Nummer','wp_stadtklick'); ?></th>
	                    <td><input type="text" name="wp_stadtklick[shop][][url]" value="<?php echo $o['shop']['url']; ?>" /></td>
	                </tr>
	    <?php } ?>
	    		<tr><th colspan="2">Neue Buchhandlung</th></tr>
	    		<tr valign="top"><th scope="row"><?php __('Name der Buchhandlung','wp_stadtklick'); ?></th>
	                    <td><input name="wp_stadtklick[name]" type="text" value="" /></td>
	                </tr>
	                <tr valign="top"><th scope="row"><?php __('URL zu einem Buch im Webshop (%%isbn%% anstelle der ISBN-Nummer','wp_stadtklick'); ?></th>
	                    <td><input type="text" name="wp_stadtklick[url]" value="" /></td>
	                </tr>
	            </table>
				<?php submit_button(); ?>
	</form>
	</div>
<?php 
} 
?>
