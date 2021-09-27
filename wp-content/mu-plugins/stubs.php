<?php
/**
 * Plugin Name: WordPress.org Stubs
 * Description: This plugin contains any stubs for other WordPress.org systems required to make the Theme Directory work.
 */

/**
 * Initial setup of the site, enable the plugins as wp-env doesn't do it.
 */
add_action(
    'template_redirect', function () {
        if (get_site_option('initial_setup') < 3 ) {

            echo '<h1 id="provision-message">Provisioning GlotPress, please wait a few moments...</h1>';
            ignore_user_abort(true);
            wp_ob_end_flush_all();
            flush();

            include_once ABSPATH . 'wp-admin/includes/admin.php';

            // GlotPress needs one permalink structure
            update_option('permalink_structure', '/%postname%/');

            activate_plugins(
                [
                'glotpress/glotpress.php',
                ] 
            );

            // Install GlotPress
            // This will create the tables in the database
            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            include_once ABSPATH  . 'wp-content/plugins/glotpress/gp-includes/schema.php';
            include_once ABSPATH . 'wp-content/plugins/glotpress/gp-includes/install-upgrade.php';
            gp_upgrade_db();

            // Set the WordPress admin as GlotPress admin
            add_admin(1, 'admin');
            // Add a user to translation
            wp_create_user('translator', 'password', 'translator@example.net');

            // Create the projects
            insert_projects('Core', 'core', 'core');
            insert_projects('Themes', 'themes', 'themes');
            insert_projects('Plugins', 'plugins', 'plugins');
            insert_projects('Twenty Twenty', 'twenty-twenty', 'themes/twenty-twenty', 2);
            insert_projects('Twenty Twenty-One', 'twenty-twenty-one', 'themes/twenty-twenty-one', 2);
            insert_projects('Akismet', 'akismet', 'plugins/akismet', 3);
            insert_projects('WooCommerce', 'woocommerce', 'plugins/woocommerce', 3);
            insert_projects('Jetpack', 'jetpack', 'plugins/jetpack', 3);

            // Download the .po files
            download_strings('wordpress', 'https://translate.wordpress.org/projects/wp/dev/gax/default/export-translations/');
            download_strings('twenty-twenty', 'https://translate.wordpress.org/projects/wp-themes/twentytwenty/gax/default/export-translations/');
            download_strings('twenty-twenty-one', 'https://translate.wordpress.org/projects/wp-themes/twentytwentyone/gax/default/export-translations/');
            download_strings('akismet', 'https://translate.wordpress.org/projects/wp-plugins/akismet/stable/gax/default/export-translations/');
            download_strings('woocommerce', 'https://translate.wordpress.org/projects/wp-plugins/woocommerce/stable/gax/default/export-translations/');
            download_strings('jetpack', 'https://translate.wordpress.org/projects/wp-plugins/jetpack/stable/gax/default/export-translations/');

            // Create translation sets
            for ($i=1; $i <=8; $i++ ) {
                insert_translation_set('Spanish (Spain)', 'default', $i, 'es');
                insert_translation_set('French (France)', 'default', $i, 'fr');
            }

            // Hide the provisioning message.
            echo '<style>#provision-message { display: none }</style>';

            update_site_option('initial_setup', 3);

            // Load the GlotPress homepage.
            $glotpress_homepage = get_bloginfo('url') . '/glotpress/projects/';
            echo '<script> location.replace("' . $glotpress_homepage . '"); </script>';
        }

    } 
);

function add_admin( $user_id, $action )
{
    global $wpdb;
    $wpdb->insert(
        "wp_gp_permissions", array(
        "user_id" => $user_id,
        "action" => $action,
        )
    );
}

function insert_projects( $name, $slug, $path, $parent_project_id = null )
{
    global $wpdb;
    $wpdb->insert(
        "wp_gp_projects", array(
        "name" => $name,
        "slug" => $slug,
        "path" => $path,
        "parent_project_id" => $parent_project_id,
        )
    );
}

function download_strings($project, $url )
{
    $file_path = ABSPATH  . 'wp-content/uploads/' . $project . '.po';
    if (! file_exists($file_path) ) {
        file_put_contents($file_path, file_get_contents($url));
    }
}

function insert_translation_set( $name, $slug, $project_id, $locale )
{
    global $wpdb;
    $wpdb->insert(
        "wp_gp_translation_sets", array(
        "name" => $name,
        "slug" => $slug,
        "project_id" => $project_id,
        "locale" => $locale,
        )
    );
}

