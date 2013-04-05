<?php
/*
Plugin Name: Equipe Api Integration
Plugin URI: http://raketwebbyrå.se
Description: Integration plugin to Equipes Api
Author: Gustav Arrhenius
Version: 1.0
Author URI: http://raketwebbyrå.se
*/

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'equipe_api_install');

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'equipe_api_remove' );

function equipe_api_install() {
    /* Creates new database field */
    add_option("equipe_api_id", 'Default', '', 'yes');
}

function equipe_api_remove() {
    /* Deletes the database field */
    delete_option('equipe_api_id');
}


/* Setup admin navigation */
if ( is_admin() ){
    /* Call the html code */
    add_action('admin_menu', 'equipe_api_admin_menu');

    function equipe_api_admin_menu() {
        add_options_page('Equipe Api', 'Equipe Api', 'administrator',
            'equipe-api', 'equipe_api_html_page');
    }
}

/* Generate a plugin option Form */
function equipe_api_html_page() {
    ?>
    <div>
        <h2><?php _e('Equipe Api Inställningar'); ?></h2>

        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="equipe_api_id"><?php _e('Skriv in tävlings ID'); ?></label></th>
                    <td>
                        <input name="equipe_api_id" type="text" id="equipe_api_id"
                               value="<?php echo get_option('equipe_api_id'); ?>" class="regular-text"/>
                    </td>
                </tr>

            </table>

            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="equipe_api_id" />

            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>

        </form>
    </div>
<?php
}

/* Include Class Equipe */
require_once('Equipe.php');


