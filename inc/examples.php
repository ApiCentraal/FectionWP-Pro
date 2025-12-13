<?php
/**
 * Examples helper: shortcode and admin UI to create example pages from
 * template-parts/examples/*.php files.
 *
 * Provides:
 * - Shortcode: [fwp_example name="example-heroes"] to render an example.
 * - Admin: Appearance → Example Pages: preview available examples and
 *   create a new Page with the shortcode as content.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return available example names (without extension)
 *
 * @return array
 */
function fwp_get_example_names() {
    $dir = get_template_directory() . '/template-parts/examples';
    $names = array();
    if ( is_dir( $dir ) ) {
        $files = scandir( $dir );
        foreach ( $files as $f ) {
            if ( in_array( $f, array( '.', '..' ), true ) ) {
                continue;
            }
            $path = $dir . '/' . $f;
            if ( is_file( $path ) && pathinfo( $f, PATHINFO_EXTENSION ) === 'php' ) {
                $names[] = basename( $f, '.php' );
            }
        }
    }
    sort( $names );
    return $names;
}

/**
 * Shortcode to render an example template-part safely.
 * Usage: [fwp_example name="example-heroes"]
 */
function fwp_example_shortcode( $atts ) {
    $atts = shortcode_atts( array( 'name' => '' ), $atts, 'fwp_example' );
    $name = sanitize_file_name( $atts['name'] );
    if ( empty( $name ) ) {
        return ''; 
    }

    $allowed = fwp_get_example_names();
    if ( ! in_array( $name, $allowed, true ) ) {
        return ''; 
    }

    // Capture the output of the template-part
    ob_start();
    $located = locate_template( 'template-parts/examples/' . $name . '.php', true, false );
    $output = ob_get_clean();
    return $output;
}
add_shortcode( 'fwp_example', 'fwp_example_shortcode' );

/**
 * Admin UI: add a Theme Page under Appearance to list examples and create pages.
 */
function fwp_examples_admin_menu() {
    add_theme_page(
        __( 'Example Pages', 'fectionwp-pro' ),
        __( 'Example Pages', 'fectionwp-pro' ),
        'edit_theme_options',
        'fwp-example-pages',
        'fwp_examples_admin_page'
    );
}
add_action( 'admin_menu', 'fwp_examples_admin_menu' );

/**
 * Render admin page and handle creation form
 */
function fwp_examples_admin_page() {
    if ( ! current_user_can( 'edit_pages' ) ) {
        wp_die( __( 'Insufficient permissions', 'fectionwp-pro' ) );
    }

    // Handle form submit
    if ( isset( $_POST['fwp_create_example'] ) ) {
        check_admin_referer( 'fwp_create_example_action', 'fwp_create_example_nonce' );
        $name = isset( $_POST['example_name'] ) ? sanitize_file_name( wp_unslash( $_POST['example_name'] ) ) : '';
        $template = isset( $_POST['example_template'] ) ? sanitize_text_field( wp_unslash( $_POST['example_template'] ) ) : '';
        $set_front = isset( $_POST['example_set_front'] ) ? true : false;
        $add_to_menu = isset( $_POST['example_add_to_menu'] ) ? true : false;

        if ( $name ) {
            $content = '[fwp_example name="' . esc_attr( $name ) . '"]';
            $postarr = array(
                'post_title'   => ucwords( str_replace( array( '-', '_' ), ' ', $name ) ),
                'post_content' => $content,
                'post_status'  => 'publish',
                'post_type'    => 'page',
            );
            $new_id = wp_insert_post( $postarr );
            if ( $new_id && ! is_wp_error( $new_id ) ) {
                // Assign template if provided and exists
                if ( $template ) {
                    // Only allow templates that exist in theme
                    $available_templates = fwp_get_page_templates();
                    if ( in_array( $template, $available_templates, true ) ) {
                        update_post_meta( $new_id, '_wp_page_template', $template );
                    }
                }

                // Optionally set as front page
                if ( $set_front ) {
                    update_option( 'show_on_front', 'page' );
                    update_option( 'page_on_front', intval( $new_id ) );
                }

                // Optionally add to a menu (create 'Example Menu' if none)
                if ( $add_to_menu && function_exists( 'wp_update_nav_menu_item' ) ) {
                    $menu_name = 'Example Menu';
                    $menu = wp_get_nav_menu_object( $menu_name );
                    if ( ! $menu ) {
                        $menu_id = wp_create_nav_menu( $menu_name );
                    } else {
                        $menu_id = $menu->term_id;
                    }
                    if ( $menu_id ) {
                        wp_update_nav_menu_item( $menu_id, 0, array(
                            'menu-item-title' => get_the_title( $new_id ),
                            'menu-item-object' => 'page',
                            'menu-item-object-id' => $new_id,
                            'menu-item-type' => 'post_type',
                            'menu-item-status' => 'publish',
                        ) );
                    }
                }

                add_settings_error( 'fwp_examples', 'created', sprintf( __( 'Page created: %s', 'fectionwp-pro' ), '<a href="' . esc_url( get_edit_post_link( $new_id ) ) . '">' . esc_html( get_the_title( $new_id ) ) . '</a>' ), 'updated' );
            } else {
                add_settings_error( 'fwp_examples', 'error', __( 'Could not create page.', 'fectionwp-pro' ), 'error' );
            }
        }
    }

    $examples = fwp_get_example_names();

    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Example Pages', 'fectionwp-pro' ); ?></h1>
        <?php settings_errors( 'fwp_examples' ); ?>

        <p><?php esc_html_e( 'Use these examples to create starter pages. Click "Create Page" to add a new Page with the example inserted via shortcode.', 'fectionwp-pro' ); ?></p>

        <table class="widefat fixed" style="max-width:1000px;">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Example', 'fectionwp-pro' ); ?></th>
                    <th><?php esc_html_e( 'Preview', 'fectionwp-pro' ); ?></th>
                    <th><?php esc_html_e( 'Action', 'fectionwp-pro' ); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php if ( empty( $examples ) ) : ?>
                <tr><td colspan="3"><?php esc_html_e( 'No examples found.', 'fectionwp-pro' ); ?></td></tr>
            <?php else : ?>
                <?php foreach ( $examples as $ex ) : ?>
                        <tr>
                            <td style="vertical-align:top;"><strong><?php echo esc_html( $ex ); ?></strong></td>
                            <td style="vertical-align:top;">
                                <div style="background:#fff;border:1px solid #eee;padding:0.5rem;max-width:420px;">
                                    <?php
                                    // Show a rendered preview, but avoid side effects: include into output buffer
                                    ob_start();
                                    locate_template( 'template-parts/examples/' . $ex . '.php', true, false );
                                    $preview = ob_get_clean();
                                    echo wp_kses_post( wp_trim_words( $preview, 60 ) );
                                    ?>
                                </div>
                            </td>
                            <td style="vertical-align:top;">
                                <form method="post" style="display:inline-block; margin-bottom:0.5rem;">
                                    <?php wp_nonce_field( 'fwp_create_example_action', 'fwp_create_example_nonce' ); ?>
                                    <input type="hidden" name="example_name" value="<?php echo esc_attr( $ex ); ?>" />
                                    <p style="margin:0 0 0.5rem;">
                                        <label><?php esc_html_e( 'Template:', 'fectionwp-pro' ); ?>
                                            <select name="example_template">
                                                <option value="">— <?php esc_html_e( 'Default', 'fectionwp-pro' ); ?> —</option>
                                                <?php foreach ( fwp_get_page_templates() as $tmpl ) : ?>
                                                    <option value="<?php echo esc_attr( $tmpl ); ?>"><?php echo esc_html( $tmpl ); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </p>
                                    <p style="margin:0 0 0.5rem;"><label><input type="checkbox" name="example_set_front" /> <?php esc_html_e( 'Set as front page', 'fectionwp-pro' ); ?></label></p>
                                    <p style="margin:0 0 0.5rem;"><label><input type="checkbox" name="example_add_to_menu" /> <?php esc_html_e( 'Add to Example Menu', 'fectionwp-pro' ); ?></label></p>
                                    <p style="margin:0;"><button type="submit" name="fwp_create_example" class="button button-primary"><?php esc_html_e( 'Create Page', 'fectionwp-pro' ); ?></button></p>
                                </form>
                            </td>
                        </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
