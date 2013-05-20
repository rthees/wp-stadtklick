<?php

add_action('admin_menu', 'wp_stadtklick_create_menu');

function wp_stadtklick_create_menu() {


	add_options_page('WP-Stadtklick-Einstellungen', 'WP-Stadtklick', 'manage_options', 'wp_stadtklick', 'wp_stadtklick_options_page');


	add_action( 'admin_init', 'register_wp_stadtklick' );
}



function register_wp_stadtklick() {
	
	register_setting( 'wp_stadtklick', 'shop' );
}

function wp_stadtklick_options_page() {
?>
<div class="wrap">
<?php screen_icon(); ?>
<h2>WP-Stadtklick - Einstellungen</h2>
<form method="post" action="options.php"> 
	
<?php settings_fields( 'wp_stadtklick_options' ); ?>
<?php $options = get_option('wp_stadtklick_options'); ?>




<table class="form-table">
	<?php foreach ($options as $o) {
	 ?>
                <tr valign="top"><th scope="row">__('Name der Buchhandlung','wp_stadtklick')</th>
                    <td><input name="wp_stadtklick_options[shop][name][]" type="text" value="<?php echo $options['shop']['name']; ?>" /></td>
                </tr>
                <tr valign="top"><th scope="row">__('URL zu einem Buch im Webshop (%%isbn%% anstelle der ISBN-Nummer','wp_stadtklick')</th>
                    <td><input type="text" name="wp_stadtklick_options[shop][url][]" value="<?php echo $options['shop']['url']; ?>" /></td>
                </tr>
    <?php } ?>
    		<tr><th><?php __('Neue Buchhandlung','wp_stadtklick'); ?></th></tr>
    		<tr valign="top"><th scope="row">__('Name der Buchhandlung','wp_stadtklick')</th>
                    <td><input name="wp_stadtklick_options[shop][name][]" type="text" value="" /></td>
                </tr>
                <tr valign="top"><th scope="row">__('URL zu einem Buch im Webshop (%%isbn%% anstelle der ISBN-Nummer','wp_stadtklick')</th>
                    <td><input type="text" name="wp_stadtklick_options[shop][url][]" value="" /></td>
                </tr>
            </table>
<?php submit_button(); ?>
</form>

</div>
<?php 
} 
?>
