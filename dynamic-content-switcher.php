<?php
/**
 * Plugin Name: Dynamic Content Switcher
 * Description: Changes on-screen elements based on URI parameters.
 * Version: 1.0
 * Author: Jorgen Jensen
 */

// Enqueue the script
add_action('wp_enqueue_scripts', 'dcs_enqueue_script');
function dcs_enqueue_script() {
    wp_enqueue_script('dynamic-content-script', plugin_dir_url(__FILE__) . 'dynamic-content-script.js', array('jquery'), '1.0', true);

    $headlines = get_option('dcs_headlines', []);
    $images = get_option('dcs_images', []);
    $ctas = get_option('dcs_ctas', []);

	wp_localize_script('dynamic-content-script', 'DCS_Variations', array(
        'headlines' => $headlines,
        'images' => $images,
        'ctas' => $ctas
    ));

}

// Register the admin menu and settings
add_action('admin_menu', 'dcs_add_admin_menu');
function dcs_add_admin_menu() {
    add_menu_page('Dynamic Content Switcher', 'Dynamic Content', 'manage_options', 'dynamic_content_switcher', 'dcs_settings_page');
}

add_action('admin_init', 'dcs_settings_init');
function dcs_settings_init() {
    register_setting('dcs_plugin_settings', 'dcs_headlines');
    register_setting('dcs_plugin_settings', 'dcs_images');
    register_setting('dcs_plugin_settings', 'dcs_ctas');
}

// The settings page content
function dcs_settings_page() {
    ?>
    <div class="wrap">
        <h1>Dynamic Content Switcher Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('dcs_plugin_settings');
            do_settings_sections('dcs_plugin_settings');

			// Get existing headlines
            $headlines = get_option('dcs_headlines', []);
            ?>
            <h2>Headlines</h2>
            <div id="dcs_headlines_fields">
                <?php foreach ($headlines as $index => $headline):
						$headlineIndex = $index + 1;
				?>
                    <div class="dcs_headline">
                        <input type="text" name="dcs_headlines[]" value="<?php echo esc_attr($headline); ?>" style="margin:5px 5px 5px 0;" />
                        <button type="button" class="dcs_remove_headline" style="margin:5px 0 5px 0;">Delete</button>
						<input type="text" value="headline=<?php echo $headlineIndex; ?>" style="margin-left:5px;" />
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="dcs_add_headline" style="margin-top:5px;">Add Headline</button><span id="dcs_headlines_reminder" style="color:red; font-weight:bold; margin-left:10px;"></span>

			<?php
			// Get existing images
            $images = get_option('dcs_images', []);
            ?>
            <h2>Images</h2>
            <div id="dcs_images_fields">
                <?php foreach ($images as $index => $images):
						$imageIndex = $index + 1;
				?>
                    <div class="dcs_image">
                        <input type="text" name="dcs_images[]" value="<?php echo esc_attr($images); ?>" style="margin:5px 5px 5px 0;" />
                        <button type="button" class="dcs_remove_image" style="margin:5px 0 5px 0;">Delete</button>
						<input type="text" value="image=<?php echo $imageIndex; ?>" style="margin-left:5px;" />
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="dcs_add_image" style="margin-top:5px;">Add Image</button><span id="dcs_images_reminder" style="color:red; font-weight:bold; margin-left:10px;"></span>

			<?php
			// Get existing ctas
            $ctas = get_option('dcs_ctas', []);
            ?>
            <h2>CTAs</h2>
            <div id="dcs_ctas_fields">
                <?php foreach ($ctas as $index => $ctas):
						$ctaIndex = $index + 1;
				?>
                    <div class="dcs_cta">
                        <input type="text" name="dcs_ctas[]" value="<?php echo esc_attr($ctas); ?>" style="margin:5px 5px 5px 0;" />
                        <button type="button" class="dcs_remove_cta" style="margin:5px 0 5px 0;">Delete</button>
						<input type="text" value="cta=<?php echo $ctaIndex; ?>" style="margin-left:5px;" />
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="dcs_add_cta" style="margin-top:5px;">Add CTA</button><span id="dcs_ctas_reminder" style="color:red; font-weight:bold; margin-left:10px;"></span>

			<?php submit_button(); ?>
        </form>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
			// Handle Headlines section
            $('#dcs_add_headline').click(function() {
                $('#dcs_headlines_fields').append('<div class="dcs_headline"><input type="text" name="dcs_headlines[]" style="margin:5px 5px 5px 0;" /></div>');
				$('#dcs_headlines_reminder').html('* Remember to click "Save Changes"');
            });

            $(document).on('click', '.dcs_remove_headline', function() {
                $(this).parent('.dcs_headline').remove();
				$('#dcs_headlines_reminder').html('* Remember to click "Save Changes"');
            });

			// Handle Images section
            $('#dcs_add_image').click(function() {
                $('#dcs_images_fields').append('<div class="dcs_image"><input type="text" name="dcs_images[]" style="margin:5px 5px 5px 0;" /></div>');
				$('#dcs_images_reminder').html('* Remember to click "Save Changes"');
            });

            $(document).on('click', '.dcs_remove_image', function() {
                $(this).parent('.dcs_image').remove();
				$('#dcs_images_reminder').html('* Remember to click "Save Changes"');
            });

			// Handle CTA section
            $('#dcs_add_cta').click(function() {
                $('#dcs_ctas_fields').append('<div class="dcs_cta"><input type="text" name="dcs_ctas[]" style="margin:5px 5px 5px 0;" /></div>');
				$('#dcs_ctas_reminder').html('* Remember to click "Save Changes"');
            });

            $(document).on('click', '.dcs_remove_cta', function() {
                $(this).parent('.dcs_cta').remove();
				$('#dcs_ctas_reminder').html('* Remember to click "Save Changes"');
            });
        });
    </script>
    <?php
}
