<?php
/**
 * TGM Plugin Activation - Aanbevolen Plugins
 *
 * Adviseert gebruikers om aanbevolen plugins te installeren
 *
 * @package FectionWP_Pro
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register aanbevolen plugins
 */
function fwp_register_required_plugins() {
    $plugins = array(
        // FectionWP Visual Builder - AANBEVOLEN
        array(
            'name'               => 'FectionWP Visual Builder',
            'slug'               => 'fectionwp-visual-builder',
            'source'             => get_template_directory() . '/plugins/fectionwp-visual-builder.zip',
            'required'           => false,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
            'external_url'       => 'https://fectionlabs.com/fectionwp-visual-builder',
        ),
        
        // FectionWP Blocks - AANBEVOLEN
        array(
            'name'               => 'FectionWP Blocks',
            'slug'               => 'fectionwp-blocks',
            'source'             => get_template_directory() . '/plugins/fectionwp-blocks.zip',
            'required'           => false,
            'version'            => '1.0.0',
            'force_activation'   => false,
            'force_deactivation' => false,
            'external_url'       => 'https://fectionlabs.com/fectionwp-blocks',
        ),
        
        // Contact Form 7 - Optioneel
        array(
            'name'     => 'Contact Form 7',
            'slug'     => 'contact-form-7',
            'required' => false,
        ),
        
        // WooCommerce - Optioneel
        array(
            'name'     => 'WooCommerce',
            'slug'     => 'woocommerce',
            'required' => false,
        ),
    );

    $config = array(
        'id'           => 'fectionwp-pro',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
            'page_title'                      => __( 'Installeer Aanbevolen Plugins', 'fectionwp-pro' ),
            'menu_title'                      => __( 'Installeer Plugins', 'fectionwp-pro' ),
            'installing'                      => __( 'Installeren: %s', 'fectionwp-pro' ),
            'updating'                        => __( 'Updaten: %s', 'fectionwp-pro' ),
            'oops'                            => __( 'Er ging iets mis met de plugin API.', 'fectionwp-pro' ),
            'notice_can_install_required'     => _n_noop(
                'Dit thema vereist de volgende plugin: %1$s.',
                'Dit thema vereist de volgende plugins: %1$s.',
                'fectionwp-pro'
            ),
            'notice_can_install_recommended'  => _n_noop(
                'Dit thema beveelt de volgende plugin aan: %1$s.',
                'Dit thema beveelt de volgende plugins aan: %1$s.',
                'fectionwp-pro'
            ),
            'notice_ask_to_update'            => _n_noop(
                'De volgende plugin moet worden geüpdatet: %1$s.',
                'De volgende plugins moeten worden geüpdatet: %1$s.',
                'fectionwp-pro'
            ),
            'notice_ask_to_update_maybe'      => _n_noop(
                'Er is een update beschikbaar voor: %1$s.',
                'Er zijn updates beschikbaar voor: %1$s.',
                'fectionwp-pro'
            ),
            'notice_can_activate_required'    => _n_noop(
                'De volgende vereiste plugin is momenteel inactief: %1$s.',
                'De volgende vereiste plugins zijn momenteel inactief: %1$s.',
                'fectionwp-pro'
            ),
            'notice_can_activate_recommended' => _n_noop(
                'De volgende aanbevolen plugin is momenteel inactief: %1$s.',
                'De volgende aanbevolen plugins zijn momenteel inactief: %1$s.',
                'fectionwp-pro'
            ),
            'install_link'                    => _n_noop(
                'Begin met het installeren van plugin',
                'Begin met het installeren van plugins',
                'fectionwp-pro'
            ),
            'update_link'                     => _n_noop(
                'Begin met het updaten van plugin',
                'Begin met het updaten van plugins',
                'fectionwp-pro'
            ),
            'activate_link'                   => _n_noop(
                'Begin met het activeren van plugin',
                'Begin met het activeren van plugins',
                'fectionwp-pro'
            ),
            'return'                          => __( 'Terug naar Aanbevolen Plugins Installer', 'fectionwp-pro' ),
            'plugin_activated'                => __( 'Plugin succesvol geactiveerd.', 'fectionwp-pro' ),
            'activated_successfully'          => __( 'De volgende plugin is succesvol geactiveerd:', 'fectionwp-pro' ),
            'plugin_already_active'           => __( 'Geen actie ondernomen. Plugin %1$s was al actief.', 'fectionwp-pro' ),
            'plugin_needs_higher_version'     => __( 'Plugin niet geactiveerd. Een hogere versie van %s is vereist.', 'fectionwp-pro' ),
            'complete'                        => __( 'Alle plugins zijn succesvol geïnstalleerd en geactiveerd. %1$s', 'fectionwp-pro' ),
            'dismiss'                         => __( 'Negeer dit bericht', 'fectionwp-pro' ),
            'notice_cannot_install_activate'  => __( 'Er zijn één of meer vereiste of aanbevolen plugins om te installeren, updaten of activeren.', 'fectionwp-pro' ),
            'contact_admin'                   => __( 'Neem contact op met de beheerder van deze site voor hulp.', 'fectionwp-pro' ),
            'nag_type'                        => 'updated',
        ),
    );

    tgmpa( $plugins, $config );
}

/**
 * Simplified TGM Plugin Activation (inline versie)
 * Voor volledige functionaliteit, download de TGM-Plugin-Activation library
 */
if ( ! function_exists( 'tgmpa' ) ) {
    function tgmpa( $plugins, $config = array() ) {
        // Simplified version - just show admin notice
        add_action( 'admin_notices', function() use ( $plugins ) {
            $inactive_plugins = array();
            foreach ( $plugins as $plugin ) {
                $plugin_path = $plugin['slug'] . '/' . $plugin['slug'] . '.php';
                if ( ! is_plugin_active( $plugin_path ) ) {
                    $inactive_plugins[] = $plugin['name'];
                }
            }
            
            if ( ! empty( $inactive_plugins ) && current_user_can( 'install_plugins' ) ) {
                ?>
                <div class="notice notice-info is-dismissible">
                    <p>
                        <strong><?php esc_html_e( 'FectionWP Pro Aanbevolen Plugins', 'fectionwp-pro' ); ?></strong><br>
                        <?php
                        printf(
                            esc_html__( 'Voor de beste ervaring, installeer deze plugins: %s', 'fectionwp-pro' ),
                            '<strong>' . esc_html( implode( ', ', $inactive_plugins ) ) . '</strong>'
                        );
                        ?>
                    </p>
                    <p>
                        <a href="<?php echo esc_url( admin_url( 'plugin-install.php' ) ); ?>" class="button button-primary">
                            <?php esc_html_e( 'Plugins Installeren', 'fectionwp-pro' ); ?>
                        </a>
                    </p>
                </div>
                <?php
            }
        });
    }
}

add_action( 'tgmpa_register', 'fwp_register_required_plugins' );
