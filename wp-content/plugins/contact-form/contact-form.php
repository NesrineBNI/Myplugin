<?php
/*
Plugin Name: Contact Form Plugin-nes
Description: Un plugin pour ajouter un formulaire de contact personnalisé à votre site WordPress
Plugin URI:
Version: 1.0
Author: Nesrine
Author URI:
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Pour créer la table "wp_contact_form" dans la base de données lors de l'activation du plugin, utilisez la fonction WP register_activation_hook() en ajoutant le code suivant dans le fichier "contact-form.php":

function cf_activate_plugin() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      nom varchar(255) NOT NULL,
      prenom varchar(255) NOT NULL,
      email varchar(255) NOT NULL,
      sujet varchar(255) NOT NULL,
      message text NOT NULL,
      date_envoi datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'cf_activate_plugin' );


// Pour supprimer la table "wp_contact_form" de la base de données lors de la désactivation du plugin, utilisez la fonction WP register_deactivation_hook() en ajoutant le code suivant dans le fichier "contact-form.php":
    
    function cf_deactivate_plugin() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_form';
        $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
    }
    register_deactivation_hook( __FILE__, 'cf_deactivate_plugin' );

    function contact_form_plugin() {
        $output = '';
        global $wpdb;
     
        // check if the form has been submitted
        if(isset($_POST['submit'])) {
           // get the form data
           $nom = sanitize_text_field($_POST['nom']);
           $prenom = sanitize_text_field($_POST['prenom']);
           $email = sanitize_email($_POST['email']);
           $sujet = sanitize_text_field($_POST['sujet']);
           $message = sanitize_textarea_field($_POST['message']);

          
           // validate the form data
           if(empty($nom) || empty($prenom) || empty($email) || empty($sujet) || empty($message)) {
              $output = '<p class="error">Please fill in all fields.</p>';
           } elseif(!is_email($email)) {
              $output = '<p class="error">Invalid email address.</p>';
           } else {
               //   Insertion des données dans la table
               $wpdb->insert(
                $wpdb->prefix . 'contact_form',
                array(
                    'sujet' => $sujet,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'message' => $message,
                    'date_envoi' => current_time( 'mysql' )
                ),
                
            );

              $output = '<p class="success">Your message has been sent.</p>';
           }

             
     
        }
     
        // display the form
        $output .= '
        <div class="container">
            <div class="text">Contact Us</div>
           <form method="post">
                <div class="form-row">
                <div class="input-data">
              <label for="name">Nom</label>
              <input type="text" name="nom" id="nom" required>
                </div>
                <div class="input-data">
              <label for="name">Prenom</label>
              <input type="text" name="prenom" id="prenom" required>
                </div>
                </div>
                <div class="form-row">
                <div class="input-data">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" required>
              </div>
              <div class="input-data">
              <label for="subject">Sujet</label>
              <input type="text" name="sujet" id="sujet" required>
              </div>
              </div>
              <div class="form-row">
                <div class="input-data textarea">
              <label for="message">Message</label>
              <textarea name="message" id="message" cols="30" rows="10" required></textarea>
              </div>
              </div>
              <div class="form-row submit-btn">
              <div class="input-data">
              <div class="inner"></div>
              <input type="submit" name="submit" value="Send">
              </div>
              </div>
           </form>
        </div>
        ';
     
        return $output;
     }
     
     add_shortcode('contact_form', 'contact_form_plugin');



    //  add style action

    add_action('wp_head', 'add_plugin_style');

    function add_plugin_style(){
        $css_url = plugins_url('style.css', __FILE__);
        echo "<link rel='stylesheet' href='{$css_url}'>";
    }

// Créer un menu pour afficher les données envoyées via le formulaire de contact
add_action( 'admin_menu', 'contact_form_menu' );

function contact_form_menu() {
add_menu_page(
'Réponses du formulaire de contact',
'dashbord Formulaire de Contact',
'manage_options',
'contact-form-responses',
'contact_form_responses_page'
);
}
// Afficher les données envoyées via le formulaire de contact
function contact_form_responses_page() {
global $wpdb;
$table_name = $wpdb->prefix . 'contact_form';
// $table_name = $wpdb->prefix . 'contact_form';
$results = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY date_envoi DESC" );
?>
<div class="wrap">
<h2>Réponses du formulaire de contact</h2>
<table class="widefat">
<thead>
<tr>
<th>ID</th>
<th>Nom</th>
<th>Prénom</th>
<th>Email</th>
<th>Sujet</th>
<th>Message</th>
<th>Date</th>
</tr>
</thead>
<tbody>
<?php foreach ( $results as $result ) : ?>
<tr>
<td><?php echo $result->id; ?></td>
<td><?php echo $result->nom; ?></td>
<td><?php echo $result->prenom; ?></td>
<td><?php echo $result->email; ?></td>
<td><?php echo $result->sujet; ?></td>
<td><?php echo $result->message; ?></td>
<td><?php echo $result->date_envoi; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php
}
?>
<?php

// Add settings page
add_action('admin_menu', 'cf_add_options_page');
function cf_add_options_page() {
    add_menu_page(
        'Contact Form Settings', // Page title
        'Contact Form', // Menu title
        'manage_options', // Capability
        'cf-settings', // Menu slug
        'cf_options_page' // Callback function
    );
}



function cf_options_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('cf_options_group'); ?>
            <?php $options = get_option('cf_options'); ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">Nom</th>
                        <td><input type="checkbox" name="cf_field_nom" <?php checked(get_option('cf_field_nom'), 'on'); ?> /></td>
                    </tr>
                    <tr>
                        <th scope="row">Prénom</th>
                        <td><input type="checkbox" name="cf_field_prenom" <?php checked(get_option('cf_field_prenom'), 'on'); ?> /></td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td><input type="checkbox" name="cf_field_email" <?php checked(get_option('cf_field_email'), 'on'); ?> /></td>
                    </tr>
                    <tr>
                        <th scope="row">Sujet</th>
                        <td><input type="checkbox" name="cf_field_sujet" <?php checked(get_option('cf_field_sujet'), 'on'); ?> /></td>
                    </tr>
                    <tr>
                        <th scope="row">Message</th>
                        <td><input type="checkbox" name="cf_field_message" <?php checked(get_option('cf_field_message'), 'on'); ?> /></td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


function cf_register_settings() {
    register_setting('cf_options_group', 'cf_options');
}

add_action('admin_init', 'cf_register_settings');



?>
