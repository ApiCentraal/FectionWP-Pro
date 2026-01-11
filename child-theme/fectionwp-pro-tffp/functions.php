<?php
/**
 * FectionWP Pro – TFFP (child theme)
 */

defined( 'ABSPATH' ) || exit;

function tffp_sanitize_checkbox( $value ): bool {
    return (bool) $value;
}

function tffp_sanitize_hex_color_or_empty( $value ): string {
    $value = is_string( $value ) ? trim( $value ) : '';
    if ( '' === $value ) {
        return '';
    }
    $sanitized = sanitize_hex_color( $value );
    return is_string( $sanitized ) ? $sanitized : '';
}

function tffp_font_choices(): array {
    return array(
        '' => __( 'Standaard (theme)', 'fectionwp-pro-tffp' ),

        // Google Fonts
        'google:Inter'       => __( 'Google: Inter', 'fectionwp-pro-tffp' ),
        'google:Fredoka'     => __( 'Google: Fredoka', 'fectionwp-pro-tffp' ),
        'google:Poppins'     => __( 'Google: Poppins', 'fectionwp-pro-tffp' ),
        'google:Roboto'      => __( 'Google: Roboto', 'fectionwp-pro-tffp' ),
        'google:Montserrat'  => __( 'Google: Montserrat', 'fectionwp-pro-tffp' ),

        // Microsoft/System fonts (no external loading)
        'microsoft:Segoe UI' => __( 'Microsoft: Segoe UI (systeem)', 'fectionwp-pro-tffp' ),
        'microsoft:Calibri'  => __( 'Microsoft: Calibri (systeem)', 'fectionwp-pro-tffp' ),
        'system:Arial'       => __( 'Systeem: Arial', 'fectionwp-pro-tffp' ),

        // Vendor-hosted fonts (e.g. Microsoft cloud fonts via your licensed stylesheet URL)
        'custom:external'    => __( 'Extern (eigen font-URL)', 'fectionwp-pro-tffp' ),
    );
}

function tffp_sanitize_font_choice( $value ): string {
    $value = is_string( $value ) ? $value : '';
    $choices = tffp_font_choices();
    return array_key_exists( $value, $choices ) ? $value : '';
}

function tffp_font_stack_from_choice( string $choice, string $slot = 'body' ): string {
    if ( '' === $choice ) {
        return '';
    }

    if ( str_starts_with( $choice, 'google:' ) ) {
        $family = trim( substr( $choice, strlen( 'google:' ) ) );
        return $family ? ( "'" . $family . "', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif" ) : '';
    }

    if ( str_starts_with( $choice, 'microsoft:' ) ) {
        $family = trim( substr( $choice, strlen( 'microsoft:' ) ) );
        return $family ? ( "'" . $family . "', system-ui, -apple-system, Arial, sans-serif" ) : '';
    }

    if ( 'system:Arial' === $choice ) {
        return "Arial, system-ui, -apple-system, 'Segoe UI', sans-serif";
    }

    if ( 'custom:external' === $choice ) {
        $mod_key = ( 'headings' === $slot ) ? 'tffp_custom_font_family_headings' : 'tffp_custom_font_family_body';
        $family = trim( (string) get_theme_mod( $mod_key, '' ) );
        return $family ? ( "'" . $family . "', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif" ) : '';
    }

    return '';
}

function tffp_google_font_family_from_choice( string $choice ): string {
    if ( ! str_starts_with( $choice, 'google:' ) ) {
        return '';
    }
    return trim( substr( $choice, strlen( 'google:' ) ) );
}

function tffp_google_font_query_for_family( string $family ): string {
    $family = trim( $family );
    if ( '' === $family ) {
        return '';
    }

    $map = array(
        'Inter'      => 'family=Inter:wght@400;600;700',
        'Fredoka'    => 'family=Fredoka:wght@400;500;600;700',
        'Poppins'    => 'family=Poppins:wght@400;600;700',
        'Roboto'     => 'family=Roboto:wght@400;500;700',
        'Montserrat' => 'family=Montserrat:wght@400;600;700',
    );

    return $map[ $family ] ?? ( 'family=' . rawurlencode( $family ) . ':wght@400;600;700' );
}

function tffp_google_families_in_use(): array {
    $keys = array(
        'tffp_font_body' => 'google:Inter',
        'tffp_font_headings' => 'google:Fredoka',

        'tffp_font_section_hero' => '',
        'tffp_font_section_hero_headings' => '',
        'tffp_font_section_stats' => '',
        'tffp_font_section_stats_headings' => '',
        'tffp_font_section_testimonials' => '',
        'tffp_font_section_testimonials_headings' => '',
        'tffp_font_section_locations' => '',
        'tffp_font_section_locations_headings' => '',
    );

    $families = array();
    foreach ( $keys as $key => $default ) {
        $choice = (string) get_theme_mod( $key, $default );

        // If global is set to theme default, still include the theme’s default Google fonts.
        if ( '' === $choice && ( 'tffp_font_body' === $key || 'tffp_font_headings' === $key ) ) {
            $choice = (string) $default;
        }

        $family = tffp_google_font_family_from_choice( $choice );
        if ( $family ) {
            $families[ $family ] = true;
        }
    }

    return array_keys( $families );
}

function tffp_uses_external_fonts(): bool {
    $url = trim( (string) get_theme_mod( 'tffp_custom_font_css_url', '' ) );
    if ( '' === $url ) {
        return false;
    }

    $keys = array(
        'tffp_font_body',
        'tffp_font_headings',
        'tffp_font_section_hero',
        'tffp_font_section_hero_headings',
        'tffp_font_section_stats',
        'tffp_font_section_stats_headings',
        'tffp_font_section_testimonials',
        'tffp_font_section_testimonials_headings',
        'tffp_font_section_locations',
        'tffp_font_section_locations_headings',
    );

    foreach ( $keys as $key ) {
        if ( 'custom:external' === (string) get_theme_mod( $key, '' ) ) {
            return true;
        }
    }

    return false;
}

// Ensure menu locations exist (rendered by parent theme header).
add_action( 'after_setup_theme', function () {
    register_nav_menus( array(
        'primary' => __( 'Hoofdmenu', 'fectionwp-pro' ),
        'utility' => __( 'Top menu (logo/iconen)', 'fectionwp-pro' ),
        'footer'  => __( 'Footer Menu', 'fectionwp-pro' ),
    ) );
}, 20 );

// Prevent duplicate hero output: TFFP uses its own hero sections on key pages.
add_filter( 'fwp_render_hero_in_header', function ( $enabled, $context ) {
    if ( 'landing' === $context ) {
        $disable_parent_hero = (bool) get_theme_mod( 'tffp_disable_parent_hero_in_landing_header', true );
        return $disable_parent_hero ? false : $enabled;
    }

    if ( 'default' === $context ) {
        $disable_parent_hero = (bool) get_theme_mod( 'tffp_disable_parent_hero_in_default_header', false );
        if ( $disable_parent_hero ) {
            return false;
        }

        // When a per-page TFFP hero header is enabled, prevent the parent hero.
        if ( is_singular( 'page' ) ) {
            $post_id = (int) get_queried_object_id();
            if ( $post_id && function_exists( 'tffp_page_hero_should_render' ) && tffp_page_hero_should_render( $post_id ) ) {
                return false;
            }
        }

        return $enabled;
    }

    return $enabled;
}, 10, 2 );

/**
 * Per-page hero header (background + text + optional CTA).
 */
function tffp_page_hero_meta_keys(): array {
    return array(
        '_tffp_page_hero_enabled',
        '_tffp_page_hero_show_on_front',
        '_tffp_page_hero_bg_id',
        '_tffp_page_hero_align',
        '_tffp_page_hero_overlay',
        '_tffp_page_hero_badge',
        '_tffp_page_hero_title',
        '_tffp_page_hero_text',
        '_tffp_page_hero_primary_label',
        '_tffp_page_hero_primary_url',
        '_tffp_page_hero_secondary_label',
        '_tffp_page_hero_secondary_url',
    );
}

function tffp_page_hero_is_enabled( int $post_id ): bool {
    return (bool) get_post_meta( $post_id, '_tffp_page_hero_enabled', true );
}

function tffp_page_hero_show_on_front( int $post_id ): bool {
    return (bool) get_post_meta( $post_id, '_tffp_page_hero_show_on_front', true );
}

function tffp_page_hero_should_render( int $post_id ): bool {
    if ( ! $post_id ) {
        return false;
    }
    if ( ! tffp_page_hero_is_enabled( $post_id ) ) {
        return false;
    }

    // By default, avoid conflicts with the dedicated TFFP front-page layout.
    if ( is_front_page() ) {
        return tffp_page_hero_show_on_front( $post_id );
    }

    return true;
}

function tffp_page_hero_bg_url( int $post_id ): string {
    $bg_id = (int) get_post_meta( $post_id, '_tffp_page_hero_bg_id', true );
    if ( $bg_id > 0 ) {
        $url = wp_get_attachment_image_url( $bg_id, 'full' );
        if ( is_string( $url ) && '' !== trim( $url ) ) {
            return $url;
        }
    }

    if ( has_post_thumbnail( $post_id ) ) {
        $url = get_the_post_thumbnail_url( $post_id, 'full' );
        if ( is_string( $url ) && '' !== trim( $url ) ) {
            return $url;
        }
    }

    return '';
}

function tffp_page_hero_overlay_value( int $post_id ): float {
    $raw = get_post_meta( $post_id, '_tffp_page_hero_overlay', true );
    $pct = is_numeric( $raw ) ? (int) $raw : 45;

    // Clamp: 0–80%.
    $pct = max( 0, min( 80, $pct ) );

    // Convert to 0–1 alpha.
    return $pct / 100;
}

function tffp_render_page_hero(): void {
    if ( ! is_singular( 'page' ) ) {
        return;
    }

    $post_id = (int) get_queried_object_id();
    if ( ! tffp_page_hero_should_render( $post_id ) ) {
        return;
    }

    get_template_part( 'template-parts/tffp/page-hero' );
}

// Inject background CSS variable per page (no inline background styles).
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_singular( 'page' ) ) {
        return;
    }

    $post_id = (int) get_queried_object_id();
    if ( ! tffp_page_hero_should_render( $post_id ) ) {
        return;
    }

    $bg_url = tffp_page_hero_bg_url( $post_id );
    $overlay = tffp_page_hero_overlay_value( $post_id );

    $handle = wp_style_is( 'tffp-style', 'enqueued' ) ? 'tffp-style' : 'tffp-tokens';
    if ( ! wp_style_is( $handle, 'enqueued' ) ) {
        return;
    }

    $css_parts = array();

    if ( '' !== $bg_url ) {
        $bg_url = esc_url_raw( $bg_url );
        $bg_url_css = str_replace( array( '\\', "'" ), array( '\\\\', "\\'" ), $bg_url );
        $css_parts[] = "--tffp-page-hero-bg:url('" . $bg_url_css . "')";
    }

    $overlay = max( 0.0, min( 0.8, $overlay ) );
    $css_parts[] = '--tffp-page-hero-overlay:' . rtrim( rtrim( number_format( $overlay, 2, '.', '' ), '0' ), '.' );

    $css = 'body.page-id-' . $post_id . ' .tffp-page-hero{' . implode( ';', $css_parts ) . ';}';

    wp_add_inline_style( $handle, $css );
}, 60 );

// Admin: meta box + media picker.
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'tffp_page_hero_meta',
        __( 'Hero header (TFFP)', 'fectionwp-pro-tffp' ),
        function ( WP_Post $post ) {
            wp_nonce_field( 'tffp_page_hero_meta', 'tffp_page_hero_nonce' );

            $enabled = (bool) get_post_meta( $post->ID, '_tffp_page_hero_enabled', true );
            $show_on_front = (bool) get_post_meta( $post->ID, '_tffp_page_hero_show_on_front', true );
            $bg_id = (int) get_post_meta( $post->ID, '_tffp_page_hero_bg_id', true );
            $align = (string) get_post_meta( $post->ID, '_tffp_page_hero_align', true );
            if ( '' === $align ) {
                $align = 'center';
            }
            $overlay_raw = get_post_meta( $post->ID, '_tffp_page_hero_overlay', true );
            $overlay_pct = is_numeric( $overlay_raw ) ? (int) $overlay_raw : 45;
            $overlay_pct = max( 0, min( 80, $overlay_pct ) );

            $badge = (string) get_post_meta( $post->ID, '_tffp_page_hero_badge', true );
            $title = (string) get_post_meta( $post->ID, '_tffp_page_hero_title', true );
            $text  = (string) get_post_meta( $post->ID, '_tffp_page_hero_text', true );

            $primary_label = (string) get_post_meta( $post->ID, '_tffp_page_hero_primary_label', true );
            $primary_url   = (string) get_post_meta( $post->ID, '_tffp_page_hero_primary_url', true );
            $secondary_label = (string) get_post_meta( $post->ID, '_tffp_page_hero_secondary_label', true );
            $secondary_url   = (string) get_post_meta( $post->ID, '_tffp_page_hero_secondary_url', true );

            $preview_html = '';
            if ( $bg_id > 0 ) {
                $src = wp_get_attachment_image_url( $bg_id, 'medium' );
                if ( $src ) {
                    $preview_html = '<img src="' . esc_url( $src ) . '" alt="" style="max-width:100%;height:auto;display:block;border:1px solid #dcdcde;" />';
                }
            }

            ?>
            <p>
              <label>
                <input type="checkbox" name="tffp_page_hero_enabled" value="1" <?php checked( $enabled ); ?> />
                <?php esc_html_e( 'Activeer hero header op deze pagina', 'fectionwp-pro-tffp' ); ?>
              </label>
            </p>

                        <p>
                            <label>
                                <input type="checkbox" name="tffp_page_hero_show_on_front" value="1" <?php checked( $show_on_front ); ?> />
                                <?php esc_html_e( 'Toon ook op de homepage (als dit de voorpagina is)', 'fectionwp-pro-tffp' ); ?>
                            </label>
                        </p>

            <p class="description">
              <?php esc_html_e( 'Tip: als je geen achtergrond kiest, gebruiken we de uitgelichte afbeelding (featured image) van de pagina.', 'fectionwp-pro-tffp' ); ?>
            </p>

            <p>
              <input type="hidden" id="tffp_page_hero_bg_id" name="tffp_page_hero_bg_id" value="<?php echo esc_attr( (string) $bg_id ); ?>" />
              <button type="button" class="button" id="tffp-hero-bg-select"><?php esc_html_e( 'Kies achtergrondafbeelding', 'fectionwp-pro-tffp' ); ?></button>
              <button type="button" class="button" id="tffp-hero-bg-clear"><?php esc_html_e( 'Verwijderen', 'fectionwp-pro-tffp' ); ?></button>
            </p>

            <div id="tffp_page_hero_bg_preview" style="margin: 8px 0 16px;">
              <?php echo $preview_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>

            <table class="form-table" role="presentation">
              <tbody>
                                <tr>
                                    <th scope="row"><label for="tffp_page_hero_align"><?php esc_html_e( 'Uitlijning', 'fectionwp-pro-tffp' ); ?></label></th>
                                    <td>
                                        <select id="tffp_page_hero_align" name="tffp_page_hero_align">
                                            <option value="center" <?php selected( $align, 'center' ); ?>><?php esc_html_e( 'Gecentreerd', 'fectionwp-pro-tffp' ); ?></option>
                                            <option value="left" <?php selected( $align, 'left' ); ?>><?php esc_html_e( 'Links', 'fectionwp-pro-tffp' ); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="tffp_page_hero_overlay"><?php esc_html_e( 'Donkere overlay', 'fectionwp-pro-tffp' ); ?></label></th>
                                    <td>
                                        <input
                                            id="tffp_page_hero_overlay"
                                            name="tffp_page_hero_overlay"
                                            type="range"
                                            min="0"
                                            max="80"
                                            step="5"
                                            value="<?php echo esc_attr( (string) $overlay_pct ); ?>"
                                            oninput="document.getElementById('tffp_page_hero_overlay_value').textContent=this.value + '%';"
                                        />
                                        <strong id="tffp_page_hero_overlay_value"><?php echo esc_html( (string) $overlay_pct . '%' ); ?></strong>
                                        <p class="description"><?php esc_html_e( 'Handig voor leesbaarheid op drukke foto’s. 0% = geen extra overlay, 80% = heel donker.', 'fectionwp-pro-tffp' ); ?></p>
                                    </td>
                                </tr>
                <tr>
                  <th scope="row"><label for="tffp_page_hero_badge"><?php esc_html_e( 'Badge (optioneel)', 'fectionwp-pro-tffp' ); ?></label></th>
                  <td><input class="regular-text" id="tffp_page_hero_badge" name="tffp_page_hero_badge" type="text" value="<?php echo esc_attr( $badge ); ?>" /></td>
                </tr>
                <tr>
                  <th scope="row"><label for="tffp_page_hero_title"><?php esc_html_e( 'Titel (optioneel)', 'fectionwp-pro-tffp' ); ?></label></th>
                  <td>
                    <input class="regular-text" id="tffp_page_hero_title" name="tffp_page_hero_title" type="text" value="<?php echo esc_attr( $title ); ?>" />
                    <p class="description"><?php esc_html_e( 'Leeg laten = paginatitel.', 'fectionwp-pro-tffp' ); ?></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><label for="tffp_page_hero_text"><?php esc_html_e( 'Tekst (optioneel)', 'fectionwp-pro-tffp' ); ?></label></th>
                  <td>
                    <textarea class="large-text" rows="3" id="tffp_page_hero_text" name="tffp_page_hero_text"><?php echo esc_textarea( $text ); ?></textarea>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><?php esc_html_e( 'CTA knop 1 (optioneel)', 'fectionwp-pro-tffp' ); ?></th>
                  <td>
                    <p><label><?php esc_html_e( 'Label', 'fectionwp-pro-tffp' ); ?> <input class="regular-text" name="tffp_page_hero_primary_label" type="text" value="<?php echo esc_attr( $primary_label ); ?>" /></label></p>
                    <p><label><?php esc_html_e( 'URL', 'fectionwp-pro-tffp' ); ?> <input class="large-text" name="tffp_page_hero_primary_url" type="url" value="<?php echo esc_attr( $primary_url ); ?>" /></label></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><?php esc_html_e( 'CTA knop 2 (optioneel)', 'fectionwp-pro-tffp' ); ?></th>
                  <td>
                    <p><label><?php esc_html_e( 'Label', 'fectionwp-pro-tffp' ); ?> <input class="regular-text" name="tffp_page_hero_secondary_label" type="text" value="<?php echo esc_attr( $secondary_label ); ?>" /></label></p>
                    <p><label><?php esc_html_e( 'URL', 'fectionwp-pro-tffp' ); ?> <input class="large-text" name="tffp_page_hero_secondary_url" type="url" value="<?php echo esc_attr( $secondary_url ); ?>" /></label></p>
                  </td>
                </tr>
              </tbody>
            </table>
            <?php
        },
        'page',
        'side',
        'high'
    );
} );

add_action( 'save_post_page', function ( int $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }
    if ( ! isset( $_POST['tffp_page_hero_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( (string) $_POST['tffp_page_hero_nonce'] ), 'tffp_page_hero_meta' ) ) {
        return;
    }

    $enabled = isset( $_POST['tffp_page_hero_enabled'] ) ? 1 : 0;
    update_post_meta( $post_id, '_tffp_page_hero_enabled', $enabled );

    $show_on_front = isset( $_POST['tffp_page_hero_show_on_front'] ) ? 1 : 0;
    update_post_meta( $post_id, '_tffp_page_hero_show_on_front', $show_on_front );

    $bg_id = isset( $_POST['tffp_page_hero_bg_id'] ) ? absint( $_POST['tffp_page_hero_bg_id'] ) : 0;
    if ( $bg_id > 0 ) {
        update_post_meta( $post_id, '_tffp_page_hero_bg_id', $bg_id );
    } else {
        delete_post_meta( $post_id, '_tffp_page_hero_bg_id' );
    }

    $align = isset( $_POST['tffp_page_hero_align'] ) ? sanitize_text_field( (string) $_POST['tffp_page_hero_align'] ) : 'center';
    if ( ! in_array( $align, array( 'center', 'left' ), true ) ) {
        $align = 'center';
    }
    update_post_meta( $post_id, '_tffp_page_hero_align', $align );

    $overlay = isset( $_POST['tffp_page_hero_overlay'] ) ? (int) $_POST['tffp_page_hero_overlay'] : 45;
    $overlay = max( 0, min( 80, $overlay ) );
    update_post_meta( $post_id, '_tffp_page_hero_overlay', $overlay );

    $badge = isset( $_POST['tffp_page_hero_badge'] ) ? sanitize_text_field( (string) $_POST['tffp_page_hero_badge'] ) : '';
    $title = isset( $_POST['tffp_page_hero_title'] ) ? sanitize_text_field( (string) $_POST['tffp_page_hero_title'] ) : '';
    $text  = isset( $_POST['tffp_page_hero_text'] ) ? sanitize_textarea_field( (string) $_POST['tffp_page_hero_text'] ) : '';

    update_post_meta( $post_id, '_tffp_page_hero_badge', $badge );
    update_post_meta( $post_id, '_tffp_page_hero_title', $title );
    update_post_meta( $post_id, '_tffp_page_hero_text', $text );

    $primary_label = isset( $_POST['tffp_page_hero_primary_label'] ) ? sanitize_text_field( (string) $_POST['tffp_page_hero_primary_label'] ) : '';
    $primary_url   = isset( $_POST['tffp_page_hero_primary_url'] ) ? esc_url_raw( (string) $_POST['tffp_page_hero_primary_url'] ) : '';

    $secondary_label = isset( $_POST['tffp_page_hero_secondary_label'] ) ? sanitize_text_field( (string) $_POST['tffp_page_hero_secondary_label'] ) : '';
    $secondary_url   = isset( $_POST['tffp_page_hero_secondary_url'] ) ? esc_url_raw( (string) $_POST['tffp_page_hero_secondary_url'] ) : '';

    update_post_meta( $post_id, '_tffp_page_hero_primary_label', $primary_label );
    update_post_meta( $post_id, '_tffp_page_hero_primary_url', $primary_url );
    update_post_meta( $post_id, '_tffp_page_hero_secondary_label', $secondary_label );
    update_post_meta( $post_id, '_tffp_page_hero_secondary_url', $secondary_url );
}, 10 );

add_action( 'admin_enqueue_scripts', function ( string $hook ) {
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }

    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( ! $screen || 'page' !== $screen->post_type ) {
        return;
    }

    wp_enqueue_media();

    $path = get_stylesheet_directory() . '/assets/js/tffp-page-hero-meta.js';
    $uri  = get_stylesheet_directory_uri() . '/assets/js/tffp-page-hero-meta.js';
    if ( file_exists( $path ) ) {
        wp_enqueue_script( 'tffp-page-hero-meta', $uri, array( 'jquery' ), filemtime( $path ), true );
    }
} );

/**
 * Ensure the custom page templates are selectable in wp-admin.
 *
 * WordPress normally detects templates by scanning file headers. In some environments
 * (caching, unusual installs, theme packaging), the scan can be flaky. This forces the
 * templates into the dropdown as long as the files exist in the active (child) theme.
 */
function tffp_page_templates_map(): array {
    return array(
        'page-contact.php'       => __( 'Contact (TFFP)', 'fectionwp-pro-tffp' ),
        'page-galerij.php'       => __( 'Galerij (TFFP)', 'fectionwp-pro-tffp' ),
        'page-kinderfeestjes.php'=> __( 'Kinderfeestjes (TFFP)', 'fectionwp-pro-tffp' ),
        'page-festivals.php'     => __( 'Festivals (TFFP)', 'fectionwp-pro-tffp' ),
        'page-glitter.php'       => __( 'Glitter (TFFP)', 'fectionwp-pro-tffp' ),
        'page-cadeaubon.php'     => __( 'Cadeaubon (TFFP)', 'fectionwp-pro-tffp' ),
        'page-over-ons.php'      => __( 'Over ons (TFFP)', 'fectionwp-pro-tffp' ),
    );
}

add_filter( 'theme_page_templates', function ( $templates, $theme, $post, $post_type ) {
    if ( 'page' !== $post_type ) {
        return $templates;
    }

    $map = tffp_page_templates_map();
    foreach ( $map as $file => $label ) {
        if ( is_string( $file ) && is_string( $label ) && file_exists( get_stylesheet_directory() . '/' . $file ) ) {
            $templates[ $file ] = $label;
        }
    }

    return $templates;
}, 20, 4 );

/**
 * Auto-add "Over ons" menu item to the primary nav (non-invasive).
 *
 * Only adds the item when:
 * - a page with slug "over-ons" exists
 * - the primary menu items do not already contain that URL
 *
 * Disable via:
 * add_filter('tffp_auto_add_over_ons_menu_item', '__return_false');
 */
add_filter( 'wp_nav_menu_items', function ( $items, $args ) {
    if ( ! is_object( $args ) || empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
        return $items;
    }

    $enabled = (bool) apply_filters( 'tffp_auto_add_over_ons_menu_item', true, $args );
    if ( ! $enabled ) {
        return $items;
    }

    $page = get_page_by_path( 'over-ons' );
    if ( ! $page instanceof WP_Post ) {
        return $items;
    }

    $url = get_permalink( $page );
    if ( ! $url ) {
        return $items;
    }

    // Prevent duplicates.
    if ( str_contains( (string) $items, $url ) || str_contains( (string) $items, '/over-ons/' ) ) {
        return $items;
    }

    $is_active = is_page( $page->ID );
    $link_class = 'nav-link' . ( $is_active ? ' active' : '' );
    $aria_current = $is_active ? ' aria-current="page"' : '';

    $items .= '<li class="nav-item menu-item' . ( $is_active ? ' current-menu-item' : '' ) . '">';
    $items .= '<a class="' . esc_attr( $link_class ) . '" href="' . esc_url( $url ) . '"' . $aria_current . '>';
    $items .= esc_html__( 'Over ons', 'fectionwp-pro-tffp' );
    $items .= '</a></li>';

    return $items;
}, 20, 2 );

// Optional debug: visit /wp-admin/?tffp_debug_templates=1 as admin.
add_action( 'admin_notices', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( ! isset( $_GET['tffp_debug_templates'] ) ) {
        return;
    }

    $theme = wp_get_theme();
    $templates = $theme->get_page_templates();

    echo '<div class="notice notice-info"><p><strong>TFFP template debug</strong></p>';
    echo '<p>Active theme: <code>' . esc_html( $theme->get( 'Name' ) ) . '</code></p>';
    echo '<p>Stylesheet: <code>' . esc_html( $theme->get_stylesheet() ) . '</code> | Template: <code>' . esc_html( $theme->get_template() ) . '</code></p>';
    echo '<p>Detected page templates: <code>' . esc_html( implode( ', ', array_keys( $templates ) ) ) . '</code></p>';
    echo '</div>';
} );

/**
 * Theme options (Customizer)
 *
 * Keep it minimal: WhatsApp number + default message + contact email/phone.
 */
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'tffp_header', array(
        'title'    => __( 'TFFP Header', 'fectionwp-pro-tffp' ),
        'priority' => 161,
    ) );

    $wp_customize->add_setting( 'tffp_disable_parent_hero_in_landing_header', array(
        'default'           => true,
        'sanitize_callback' => 'tffp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'tffp_disable_parent_hero_in_landing_header', array(
        'label'       => __( 'Hero tonen in landing header', 'fectionwp-pro-tffp' ),
        'description' => __( 'Toont de hero uit de parent Customizer ook op templates met de landing header. Zet dit uit als je een eigen hero/intro gebruikt en dubbele content wilt voorkomen.', 'fectionwp-pro-tffp' ),
        'section'     => 'tffp_header',
        'type'        => 'checkbox',
        'priority'    => 10,
    ) );

    $wp_customize->add_setting( 'tffp_disable_parent_hero_in_default_header', array(
        'default'           => false,
        'sanitize_callback' => 'tffp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'tffp_disable_parent_hero_in_default_header', array(
        'label'       => __( 'Hero tonen in standaard header', 'fectionwp-pro-tffp' ),
        'description' => __( 'Toont de hero uit de parent Customizer ook op templates met de standaard header. Zet dit uit als je een eigen hero/intro gebruikt en dubbele content wilt voorkomen.', 'fectionwp-pro-tffp' ),
        'section'     => 'tffp_header',
        'type'        => 'checkbox',
        'priority'    => 20,
    ) );

    $wp_customize->add_section( 'tffp_contact', array(
        'title'    => __( 'TFFP Contact', 'fectionwp-pro-tffp' ),
        'priority' => 160,
    ) );

    $wp_customize->add_setting( 'tffp_whatsapp_number', array(
        'default'           => '31612345678',
        'sanitize_callback' => function ( $value ) {
            $value = preg_replace( '/\D+/', '', (string) $value );
            return $value;
        },
    ) );

    $wp_customize->add_control( 'tffp_whatsapp_number', array(
        'type'        => 'text',
        'section'     => 'tffp_contact',
        'label'       => __( 'WhatsApp number (digits only)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Example: 31612345678 (no +, no spaces).', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_whatsapp_prefill', array(
        'default'           => __( 'Hallo! Ik wil graag informatie over jullie diensten.', 'fectionwp-pro-tffp' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'tffp_whatsapp_prefill', array(
        'type'        => 'text',
        'section'     => 'tffp_contact',
        'label'       => __( 'WhatsApp default message', 'fectionwp-pro-tffp' ),
        'description' => __( 'Used for the WhatsApp button and floating action button.', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_contact_email', array(
        'default'           => 'info@thefunkyfacepainter.nl',
        'sanitize_callback' => 'sanitize_email',
    ) );

    $wp_customize->add_control( 'tffp_contact_email', array(
        'type'    => 'email',
        'section' => 'tffp_contact',
        'label'   => __( 'Contact email', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_contact_phone', array(
        'default'           => '+31 6 1234 5678',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'tffp_contact_phone', array(
        'type'        => 'text',
        'section'     => 'tffp_contact',
        'label'       => __( 'Contact phone (display)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Shown on the contact page. For the WhatsApp link, the digits-only WhatsApp number is used.', 'fectionwp-pro-tffp' ),
    ) );

    // Typography (Google + Microsoft/System) - per section
    $wp_customize->add_section( 'tffp_typography', array(
        'title'    => __( 'TFFP Typography', 'fectionwp-pro-tffp' ),
        'priority' => 161,
    ) );

    $choices = tffp_font_choices();

    $wp_customize->add_setting( 'tffp_font_body', array(
        'default'           => 'google:Inter',
        'sanitize_callback' => 'tffp_sanitize_font_choice',
    ) );

    $wp_customize->add_control( 'tffp_font_body', array(
        'type'    => 'select',
        'section' => 'tffp_typography',
        'label'   => __( 'Body font (global)', 'fectionwp-pro-tffp' ),
        'choices' => $choices,
    ) );

    $wp_customize->add_setting( 'tffp_font_headings', array(
        'default'           => 'google:Fredoka',
        'sanitize_callback' => 'tffp_sanitize_font_choice',
    ) );

    $wp_customize->add_control( 'tffp_font_headings', array(
        'type'    => 'select',
        'section' => 'tffp_typography',
        'label'   => __( 'Headings font (global)', 'fectionwp-pro-tffp' ),
        'choices' => $choices,
    ) );

    $wp_customize->add_setting( 'tffp_custom_font_css_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'tffp_custom_font_css_url', array(
        'type'        => 'url',
        'section'     => 'tffp_typography',
        'label'       => __( 'Extern font stylesheet URL', 'fectionwp-pro-tffp' ),
        'description' => __( 'Plak hier een URL naar een CSS stylesheet die jouw fonts definieert (@font-face). Alleen nodig als je “Extern (eigen font-URL)” kiest. Gebruik alleen fonts/URL’s waarvoor je licentie hebt.', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_custom_font_family_body', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'tffp_custom_font_family_body', array(
        'type'        => 'text',
        'section'     => 'tffp_typography',
        'label'       => __( 'Extern font family name (body)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Moet exact matchen met de font-family naam uit het externe stylesheet.', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_custom_font_family_headings', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'tffp_custom_font_family_headings', array(
        'type'        => 'text',
        'section'     => 'tffp_typography',
        'label'       => __( 'Extern font family name (headings)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Moet exact matchen met de font-family naam uit het externe stylesheet.', 'fectionwp-pro-tffp' ),
    ) );

    $section_choices = array( '' => __( 'Overnemen van global', 'fectionwp-pro-tffp' ) ) + array_diff_key( $choices, array( '' => true ) );
    $sections = array(
        'hero'         => __( 'Hero', 'fectionwp-pro-tffp' ),
        'stats'        => __( 'Stats', 'fectionwp-pro-tffp' ),
        'testimonials' => __( 'Testimonials', 'fectionwp-pro-tffp' ),
        'locations'    => __( 'Locations', 'fectionwp-pro-tffp' ),
    );

    foreach ( $sections as $key => $label ) {
        $wp_customize->add_setting( 'tffp_font_section_' . $key, array(
            'default'           => '',
            'sanitize_callback' => 'tffp_sanitize_font_choice',
        ) );

        $wp_customize->add_control( 'tffp_font_section_' . $key, array(
            'type'    => 'select',
            'section' => 'tffp_typography',
            'label'   => sprintf( __( '%s section font (body)', 'fectionwp-pro-tffp' ), $label ),
            'choices' => $section_choices,
        ) );

        $wp_customize->add_setting( 'tffp_font_section_' . $key . '_headings', array(
            'default'           => '',
            'sanitize_callback' => 'tffp_sanitize_font_choice',
        ) );

        $wp_customize->add_control( 'tffp_font_section_' . $key . '_headings', array(
            'type'    => 'select',
            'section' => 'tffp_typography',
            'label'   => sprintf( __( '%s section font (headings)', 'fectionwp-pro-tffp' ), $label ),
            'choices' => $section_choices,
        ) );
    }

    // Layout (section spacing)
    $wp_customize->add_section( 'tffp_layout', array(
        'title'       => __( 'TFFP Layout', 'fectionwp-pro-tffp' ),
        'description' => __( 'Regelt de verticale ruimte tussen pagina-secties (front-end).', 'fectionwp-pro-tffp' ),
        'priority'    => 162,
    ) );

    $wp_customize->add_setting( 'tffp_section_spacing', array(
        'default'           => 'normal',
        'sanitize_callback' => function ( $value ) {
            $value = is_string( $value ) ? $value : '';
            $allowed = array( 'compact', 'normal', 'spacious' );
            return in_array( $value, $allowed, true ) ? $value : 'normal';
        },
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'tffp_section_spacing', array(
        'type'    => 'select',
        'section' => 'tffp_layout',
        'label'   => __( 'Sectie spacing', 'fectionwp-pro-tffp' ),
        'choices' => array(
            'compact'  => __( 'Compact', 'fectionwp-pro-tffp' ),
            'normal'   => __( 'Normaal', 'fectionwp-pro-tffp' ),
            'spacious' => __( 'Ruim', 'fectionwp-pro-tffp' ),
        ),
    ) );

    // Colors
    $wp_customize->add_section( 'tffp_colors', array(
        'title'       => __( 'TFFP Kleuren', 'fectionwp-pro-tffp' ),
        'description' => __( 'Optionele kleur-overschrijvingen voor knoppen en kopteksten. Laat leeg om defaults (tokens) te gebruiken.', 'fectionwp-pro-tffp' ),
        'priority'    => 163,
    ) );

    $wp_customize->add_setting( 'tffp_color_primary', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_color_primary', array(
        'label'   => __( 'Primary', 'fectionwp-pro-tffp' ),
        'section' => 'tffp_colors',
    ) ) );

    $wp_customize->add_setting( 'tffp_color_secondary', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_color_secondary', array(
        'label'   => __( 'Secondary', 'fectionwp-pro-tffp' ),
        'section' => 'tffp_colors',
    ) ) );

    $wp_customize->add_setting( 'tffp_color_accent', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_color_accent', array(
        'label'       => __( 'Accent (warning)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Wordt gebruikt voor “accent/warning” kleur in TFFP.', 'fectionwp-pro-tffp' ),
        'section'     => 'tffp_colors',
    ) ) );

    $wp_customize->add_setting( 'tffp_color_heading', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_color_heading', array(
        'label'       => __( 'Kopteksten (global)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Stelt de standaard heading kleur in (h1-h6) via Bootstrap variable.', 'fectionwp-pro-tffp' ),
        'section'     => 'tffp_colors',
    ) ) );

    // Button overrides (Primary)
    $wp_customize->add_setting( 'tffp_btn_primary_bg', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_btn_primary_bg', array(
        'label'   => __( 'Knop: Primary achtergrond', 'fectionwp-pro-tffp' ),
        'section' => 'tffp_colors',
    ) ) );

    $wp_customize->add_setting( 'tffp_btn_primary_text', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_btn_primary_text', array(
        'label'   => __( 'Knop: Primary tekst', 'fectionwp-pro-tffp' ),
        'section' => 'tffp_colors',
    ) ) );

    $wp_customize->add_setting( 'tffp_btn_primary_hover_bg', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_btn_primary_hover_bg', array(
        'label'   => __( 'Knop: Primary hover achtergrond', 'fectionwp-pro-tffp' ),
        'section' => 'tffp_colors',
    ) ) );

    // Button overrides (Secondary)
    $wp_customize->add_setting( 'tffp_btn_secondary_bg', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_btn_secondary_bg', array(
        'label'   => __( 'Knop: Secondary achtergrond', 'fectionwp-pro-tffp' ),
        'section' => 'tffp_colors',
    ) ) );

    $wp_customize->add_setting( 'tffp_btn_secondary_text', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_btn_secondary_text', array(
        'label'   => __( 'Knop: Secondary tekst', 'fectionwp-pro-tffp' ),
        'section' => 'tffp_colors',
    ) ) );

    $wp_customize->add_setting( 'tffp_btn_secondary_hover_bg', array(
        'default'           => '',
        'sanitize_callback' => 'tffp_sanitize_hex_color_or_empty',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tffp_btn_secondary_hover_bg', array(
        'label'   => __( 'Knop: Secondary hover achtergrond', 'fectionwp-pro-tffp' ),
        'section' => 'tffp_colors',
    ) ) );
} );

function tffp_get_whatsapp_number(): string {
    $number = get_theme_mod( 'tffp_whatsapp_number', '31612345678' );
    $number = preg_replace( '/\D+/', '', (string) $number );
    return $number ?: '31612345678';
}

function tffp_get_whatsapp_prefill(): string {
    $prefill = (string) get_theme_mod( 'tffp_whatsapp_prefill', __( 'Hallo! Ik wil graag informatie over jullie diensten.', 'fectionwp-pro-tffp' ) );
    return trim( wp_strip_all_tags( $prefill ) );
}

function tffp_get_whatsapp_url( string $message ): string {
    $number = tffp_get_whatsapp_number();
    $message = trim( wp_strip_all_tags( $message ) );
    return 'https://wa.me/' . rawurlencode( $number ) . '?text=' . rawurlencode( $message );
}

/**
 * Enqueue TFFP token overrides + custom styles.
 *
 * Parent theme laadt Bootstrap + `fwp-style` (child style.css) + `fwp-custom`.
 * Hier voegen we TFFP assets toe na `fwp-custom`.
 */
add_action( 'wp_enqueue_scripts', function () {
    $child_dir = get_stylesheet_directory();
    $child_uri = get_stylesheet_directory_uri();

    // Google Fonts (dynamic based on Customizer).
    $families = tffp_google_families_in_use();
    $queries = array();
    foreach ( $families as $family ) {
        $q = tffp_google_font_query_for_family( $family );
        if ( $q ) {
            $queries[] = $q;
        }
    }

    if ( ! empty( $queries ) ) {
        $google_url = 'https://fonts.googleapis.com/css2?' . implode( '&', $queries ) . '&display=swap';
        wp_enqueue_style( 'tffp-google-fonts', $google_url, array(), null );
    } else {
        // Keep dependency chain intact without loading external resources.
        wp_register_style( 'tffp-google-fonts', false, array(), null );
        wp_enqueue_style( 'tffp-google-fonts' );
    }

    // External vendor stylesheet (e.g. Microsoft cloud fonts via your licensed URL)
    if ( tffp_uses_external_fonts() ) {
        $external_url = trim( (string) get_theme_mod( 'tffp_custom_font_css_url', '' ) );
        if ( $external_url ) {
            wp_enqueue_style( 'tffp-external-fonts', $external_url, array(), null );
        }
    }
    if ( ! wp_style_is( 'tffp-external-fonts', 'enqueued' ) ) {
        wp_register_style( 'tffp-external-fonts', false, array(), null );
        wp_enqueue_style( 'tffp-external-fonts' );
    }

    $tokens_path = $child_dir . '/assets/css/tffp-tokens.css';
    if ( file_exists( $tokens_path ) ) {
        wp_enqueue_style(
            'tffp-tokens',
            $child_uri . '/assets/css/tffp-tokens.css',
            array( 'fwp-custom', 'tffp-google-fonts', 'tffp-external-fonts' ),
            filemtime( $tokens_path )
        );
    }

    $tffp_path = $child_dir . '/assets/css/tffp.css';
    if ( file_exists( $tffp_path ) ) {
        wp_enqueue_style(
            'tffp-style',
            $child_uri . '/assets/css/tffp.css',
            array( 'tffp-tokens' ),
            filemtime( $tffp_path )
        );
    }

    // Inject typography variables (global + per section)
    $inline_handle = wp_style_is( 'tffp-style', 'enqueued' ) ? 'tffp-style' : 'tffp-tokens';
    $inline_css = '';

    $body_choice = (string) get_theme_mod( 'tffp_font_body', 'google:Inter' );
    $head_choice = (string) get_theme_mod( 'tffp_font_headings', 'google:Fredoka' );
    $body_stack  = tffp_font_stack_from_choice( $body_choice ?: 'google:Inter', 'body' );
    $head_stack  = tffp_font_stack_from_choice( $head_choice ?: 'google:Fredoka', 'headings' );

    if ( $body_stack || $head_stack ) {
        $inline_css .= ':root{';
        if ( $body_stack ) {
            $inline_css .= '--tffp-font-body:' . $body_stack . ';';
            $inline_css .= '--bs-font-sans-serif:' . $body_stack . ';';
        }
        if ( $head_stack ) {
            $inline_css .= '--tffp-font-heading:' . $head_stack . ';';
        }
        $inline_css .= "}\n";
    }

    $section_map = array(
        'hero'         => '.tffp-hero',
        'stats'        => '.tffp-stats',
        'testimonials' => '.tffp-testimonials',
        'locations'    => '.tffp-locations',
    );

    foreach ( $section_map as $key => $selector ) {
        $section_body_choice = (string) get_theme_mod( 'tffp_font_section_' . $key, '' );
        $section_head_choice = (string) get_theme_mod( 'tffp_font_section_' . $key . '_headings', '' );

        $section_body_stack = tffp_font_stack_from_choice( $section_body_choice, 'body' );
        $section_head_stack = tffp_font_stack_from_choice( $section_head_choice, 'headings' );

        if ( ! $section_body_stack && ! $section_head_stack ) {
            continue;
        }

        $inline_css .= $selector . '{';
        if ( $section_body_stack ) {
            $inline_css .= '--tffp-section-font:' . $section_body_stack . ';';
        }
        if ( $section_head_stack ) {
            $inline_css .= '--tffp-section-heading-font:' . $section_head_stack . ';';
        }
        $inline_css .= "}\n";
    }

    // Section spacing
    $spacing = (string) get_theme_mod( 'tffp_section_spacing', 'normal' );
    $spacing_map = array(
        'compact'  => '3rem',
        'normal'   => '4rem',
        'spacious' => '5rem',
    );
    $spacing_value = $spacing_map[ $spacing ] ?? '4rem';
    $inline_css .= ':root{--tffp-section-padding-y:' . $spacing_value . ';--fwp-section-padding-y:' . $spacing_value . ';}' . "\n";

    // Color overrides (tokens)
    $color_primary = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_color_primary', '' ) );
    $color_secondary = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_color_secondary', '' ) );
    $color_accent = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_color_accent', '' ) );
    $color_heading = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_color_heading', '' ) );

    $root_vars = '';
    if ( $color_primary ) {
        $root_vars .= '--tffp-primary:' . $color_primary . ';';
    }
    if ( $color_secondary ) {
        $root_vars .= '--tffp-secondary:' . $color_secondary . ';';
    }
    if ( $color_accent ) {
        $root_vars .= '--tffp-accent:' . $color_accent . ';';
    }
    if ( $color_heading ) {
        $root_vars .= '--bs-heading-color:' . $color_heading . ';';
        $root_vars .= '--tffp-page-title-color:' . $color_heading . ';';
    }
    if ( $root_vars ) {
        $inline_css .= ':root{' . $root_vars . '}' . "\n";
    }

    // Button overrides
    $btn_primary_bg = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_btn_primary_bg', '' ) );
    $btn_primary_text = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_btn_primary_text', '' ) );
    $btn_primary_hover_bg = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_btn_primary_hover_bg', '' ) );

    $btn_secondary_bg = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_btn_secondary_bg', '' ) );
    $btn_secondary_text = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_btn_secondary_text', '' ) );
    $btn_secondary_hover_bg = tffp_sanitize_hex_color_or_empty( get_theme_mod( 'tffp_btn_secondary_hover_bg', '' ) );

    $btn_vars = '';
    if ( $btn_primary_bg ) {
        $btn_vars .= '--tffp-btn-primary-bg:' . $btn_primary_bg . ';--tffp-btn-primary-border:' . $btn_primary_bg . ';';
    }
    if ( $btn_primary_text ) {
        $btn_vars .= '--tffp-btn-primary-color:' . $btn_primary_text . ';';
    }
    if ( $btn_primary_hover_bg ) {
        $btn_vars .= '--tffp-btn-primary-hover-bg:' . $btn_primary_hover_bg . ';--tffp-btn-primary-hover-border:' . $btn_primary_hover_bg . ';';
    }
    if ( $btn_secondary_bg ) {
        $btn_vars .= '--tffp-btn-secondary-bg:' . $btn_secondary_bg . ';--tffp-btn-secondary-border:' . $btn_secondary_bg . ';';
    }
    if ( $btn_secondary_text ) {
        $btn_vars .= '--tffp-btn-secondary-color:' . $btn_secondary_text . ';';
    }
    if ( $btn_secondary_hover_bg ) {
        $btn_vars .= '--tffp-btn-secondary-hover-bg:' . $btn_secondary_hover_bg . ';--tffp-btn-secondary-hover-border:' . $btn_secondary_hover_bg . ';';
    }
    if ( $btn_vars ) {
        $inline_css .= ':root{' . $btn_vars . '}' . "\n";
    }

    if ( $inline_css ) {
        wp_add_inline_style( $inline_handle, $inline_css );
    }

    // If FectionWP-Booking booking form is present, load overrides AFTER plugin CSS.
    // Plugin handle: `pbp-public-css` (see plugin bootstrap file).
    // Note: booking form may be rendered via templates (not page content), so also allow the contact template.
    $has_booking_form = false;
    if ( function_exists( 'has_shortcode' ) ) {
        global $post;
        $has_booking_form = is_a( $post, 'WP_Post' ) && has_shortcode( (string) $post->post_content, 'pbp_booking_form' );
    }
    if ( $has_booking_form || is_page_template( 'page-contact.php' ) ) {
        $pbp_overrides_path = $child_dir . '/assets/css/tffp-pbp-overrides.css';
        if ( file_exists( $pbp_overrides_path ) ) {
            wp_enqueue_style(
                'tffp-pbp-overrides',
                $child_uri . '/assets/css/tffp-pbp-overrides.css',
                array( 'pbp-public-css', 'tffp-style' ),
                filemtime( $pbp_overrides_path )
            );
        }
    }

    // Minimal JS for the WhatsApp contact form on the contact page.
    if ( is_page_template( 'page-contact.php' ) ) {
        $contact_js = $child_dir . '/assets/js/tffp-contact.js';
        if ( file_exists( $contact_js ) ) {
            wp_enqueue_script(
                'tffp-contact',
                $child_uri . '/assets/js/tffp-contact.js',
                array(),
                filemtime( $contact_js ),
                true
            );
        }
    }

    // Minimal JS for the React-like gallery UI on the gallery page.
    if ( is_page_template( 'page-galerij.php' ) ) {
        $gallery_js = $child_dir . '/assets/js/tffp-gallery.js';
        if ( file_exists( $gallery_js ) ) {
            wp_enqueue_script(
                'tffp-gallery',
                $child_uri . '/assets/js/tffp-gallery.js',
                array(),
                filemtime( $gallery_js ),
                true
            );
        }
    }
}, 30 );

/**
 * Block patterns (Gutenberg)
 *
 * Lightweight building blocks for editors, using Bootstrap classes via `className`.
 */
add_action( 'init', function () {
    if ( ! function_exists( 'register_block_pattern' ) || ! function_exists( 'register_block_pattern_category' ) ) {
        return;
    }

    register_block_pattern_category(
        'fectionwp-tffp',
        array( 'label' => __( 'TFFP', 'fectionwp-pro-tffp' ) )
    );

    register_block_pattern(
        'fectionwp-pro-tffp/newsletter',
        array(
            'title'       => __( 'TFFP: Newsletter', 'fectionwp-pro-tffp' ),
            'description' => __( 'Een eenvoudige nieuwsbrief-sectie met Bootstrap layout.', 'fectionwp-pro-tffp' ),
            'categories'  => array( 'fectionwp-tffp' ),
            'content'     => "<!-- wp:group {\"align\":\"full\",\"className\":\"tffp-newsletter py-5 bg-body-tertiary\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull tffp-newsletter py-5 bg-body-tertiary\">\n<!-- wp:group {\"className\":\"container\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group container\">\n<!-- wp:group {\"className\":\"row justify-content-center\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group row justify-content-center\">\n<!-- wp:group {\"className\":\"col-12 col-lg-9 col-xl-8\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group col-12 col-lg-9 col-xl-8\">\n<!-- wp:group {\"className\":\"card border-0 shadow-sm\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group card border-0 shadow-sm\">\n<!-- wp:group {\"className\":\"card-body p-4 p-md-5\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group card-body p-4 p-md-5\">\n<!-- wp:columns {\"className\":\"g-4 align-items-center\"} -->\n<div class=\"wp-block-columns g-4 align-items-center\">\n<!-- wp:column {\"width\":\"55%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:55%\">\n<!-- wp:heading {\"level\":2,\"className\":\"h3 mb-2\"} -->\n<h2 class=\"wp-block-heading h3 mb-2\">Blijf op de hoogte</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"className\":\"mb-0 text-body-secondary\"} -->\n<p class=\"mb-0 text-body-secondary\">Ontvang af en toe inspiratie, acties en beschikbaarheid.</p>\n<!-- /wp:paragraph -->\n</div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"width\":\"45%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:45%\">\n<!-- wp:html -->\n<form class=\"row g-2\">\n  <div class=\"col-12 col-md\">\n    <label class=\"visually-hidden\" for=\"tffp-pattern-newsletter-email\">E-mailadres</label>\n    <input id=\"tffp-pattern-newsletter-email\" type=\"email\" class=\"form-control\" placeholder=\"jij@voorbeeld.nl\" autocomplete=\"email\" required>\n  </div>\n  <div class=\"col-12 col-md-auto\">\n    <button type=\"submit\" class=\"btn btn-primary w-100\">Aanmelden</button>\n  </div>\n  <div class=\"col-12\">\n    <small class=\"text-body-secondary\">Geen spam. Afmelden kan altijd.</small>\n  </div>\n</form>\n<!-- /wp:html -->\n</div>\n<!-- /wp:column -->\n</div>\n<!-- /wp:columns -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n<!-- /wp:group -->",
        )
    );

    register_block_pattern(
        'fectionwp-pro-tffp/quote',
        array(
            'title'       => __( 'TFFP: Quote', 'fectionwp-pro-tffp' ),
            'description' => __( 'Een quote/testimonial highlight sectie met Bootstrap markup.', 'fectionwp-pro-tffp' ),
            'categories'  => array( 'fectionwp-tffp' ),
            'content'     => "<!-- wp:group {\"align\":\"full\",\"className\":\"tffp-quote py-5 bg-light\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull tffp-quote py-5 bg-light\">\n<!-- wp:group {\"className\":\"container\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group container\">\n<!-- wp:group {\"className\":\"row justify-content-center\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group row justify-content-center\">\n<!-- wp:group {\"className\":\"col-12 col-lg-10\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group col-12 col-lg-10\">\n<!-- wp:html -->\n<div class=\"text-center mb-4\">\n  <span class=\"badge text-bg-secondary mb-3\">Quote</span>\n</div>\n\n<figure class=\"mb-0\">\n  <blockquote class=\"blockquote text-center mb-3\">\n    <p class=\"display-6 mb-0\">“Superleuk en professioneel! De kinderen vonden het geweldig en de schmink bleef de hele dag zitten.”</p>\n  </blockquote>\n  <figcaption class=\"blockquote-footer text-center mb-0\">— Een blije ouder</figcaption>\n</figure>\n<!-- /wp:html -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n<!-- /wp:group -->",
        )
    );

    register_block_pattern(
        'fectionwp-pro-tffp/cta',
        array(
            'title'       => __( 'TFFP: CTA', 'fectionwp-pro-tffp' ),
            'description' => __( 'Call-to-action sectie met twee knoppen in Bootstrap layout.', 'fectionwp-pro-tffp' ),
            'categories'  => array( 'fectionwp-tffp' ),
            'content'     => "<!-- wp:group {\"align\":\"full\",\"className\":\"tffp-cta py-5 bg-body-tertiary\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull tffp-cta py-5 bg-body-tertiary\">\n<!-- wp:group {\"className\":\"container\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group container\">\n<!-- wp:group {\"className\":\"row justify-content-center\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group row justify-content-center\">\n<!-- wp:group {\"className\":\"col-12 col-lg-10 col-xl-9\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group col-12 col-lg-10 col-xl-9\">\n<!-- wp:html -->\n<div class=\"card border-0 shadow-sm\">\n  <div class=\"card-body p-4 p-md-5\">\n    <div class=\"row align-items-center g-4\">\n      <div class=\"col-12 col-lg-7\">\n        <h2 class=\"h3 mb-2\">Klaar om te boeken?</h2>\n        <p class=\"mb-0 text-body-secondary\">Stuur een bericht of vraag vrijblijvend een offerte aan. We reageren snel.</p>\n      </div>\n      <div class=\"col-12 col-lg-5\">\n        <div class=\"d-grid gap-2 d-sm-flex justify-content-lg-end\">\n          <a class=\"btn btn-primary\" href=\"/contact/\">Neem contact op</a>\n          <a class=\"btn btn-outline-primary\" href=\"/galerij/\">Bekijk galerij</a>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n<!-- /wp:html -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n<!-- /wp:group -->",
        )
    );

    register_block_pattern(
        'fectionwp-pro-tffp/faq',
        array(
            'title'       => __( 'TFFP: FAQ', 'fectionwp-pro-tffp' ),
            'description' => __( 'FAQ sectie met Bootstrap accordion.', 'fectionwp-pro-tffp' ),
            'categories'  => array( 'fectionwp-tffp' ),
            'content'     => "<!-- wp:group {\"align\":\"full\",\"className\":\"tffp-faq py-5 bg-light\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull tffp-faq py-5 bg-light\">\n<!-- wp:group {\"className\":\"container\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group container\">\n<!-- wp:group {\"className\":\"text-center mb-4\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group text-center mb-4\">\n<!-- wp:heading {\"level\":2,\"className\":\"h1 mb-2\"} -->\n<h2 class=\"wp-block-heading h1 mb-2\">Veelgestelde vragen</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"className\":\"lead mb-0 text-body-secondary\"} -->\n<p class=\"lead mb-0 text-body-secondary\">Snel antwoord op de meest voorkomende vragen.</p>\n<!-- /wp:paragraph -->\n</div>\n<!-- /wp:group -->\n\n<!-- wp:group {\"className\":\"row justify-content-center\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group row justify-content-center\">\n<!-- wp:group {\"className\":\"col-12 col-lg-10\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group col-12 col-lg-10\">\n<!-- wp:html -->\n<div class=\"accordion\" id=\"tffp-pattern-faq\">\n  <div class=\"accordion-item\">\n    <h3 class=\"accordion-header\" id=\"tffp-pattern-faq-h1\">\n      <button class=\"accordion-button\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#tffp-pattern-faq-c1\" aria-expanded=\"true\" aria-controls=\"tffp-pattern-faq-c1\">\n        Hoe lang duurt schminken op een kinderfeestje?\n      </button>\n    </h3>\n    <div id=\"tffp-pattern-faq-c1\" class=\"accordion-collapse collapse show\" aria-labelledby=\"tffp-pattern-faq-h1\" data-bs-parent=\"#tffp-pattern-faq\">\n      <div class=\"accordion-body\">Meestal 1 tot 2 uur, afhankelijk van het aantal kinderen en de gewenste ontwerpen.</div>\n    </div>\n  </div>\n\n  <div class=\"accordion-item\">\n    <h3 class=\"accordion-header\" id=\"tffp-pattern-faq-h2\">\n      <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#tffp-pattern-faq-c2\" aria-expanded=\"false\" aria-controls=\"tffp-pattern-faq-c2\">\n        Voor welke leeftijden is het geschikt?\n      </button>\n    </h3>\n    <div id=\"tffp-pattern-faq-c2\" class=\"accordion-collapse collapse\" aria-labelledby=\"tffp-pattern-faq-h2\" data-bs-parent=\"#tffp-pattern-faq\">\n      <div class=\"accordion-body\">Voor vrijwel alle leeftijden. We passen de ontwerpen aan op leeftijd en wensen.</div>\n    </div>\n  </div>\n\n  <div class=\"accordion-item\">\n    <h3 class=\"accordion-header\" id=\"tffp-pattern-faq-h3\">\n      <button class=\"accordion-button collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#tffp-pattern-faq-c3\" aria-expanded=\"false\" aria-controls=\"tffp-pattern-faq-c3\">\n        Werken jullie door heel Nederland?\n      </button>\n    </h3>\n    <div id=\"tffp-pattern-faq-c3\" class=\"accordion-collapse collapse\" aria-labelledby=\"tffp-pattern-faq-h3\" data-bs-parent=\"#tffp-pattern-faq\">\n      <div class=\"accordion-body\">Ja. We komen op locatie en stemmen reiskosten/afstand vooraf af.</div>\n    </div>\n  </div>\n</div>\n<!-- /wp:html -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n<!-- /wp:group -->",
        )
    );

    register_block_pattern(
        'fectionwp-pro-tffp/features',
        array(
            'title'       => __( 'TFFP: Features', 'fectionwp-pro-tffp' ),
            'description' => __( 'USP/features grid met kaarten in Bootstrap layout.', 'fectionwp-pro-tffp' ),
            'categories'  => array( 'fectionwp-tffp' ),
            'content'     => "<!-- wp:group {\"align\":\"full\",\"className\":\"tffp-features py-5 bg-body\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull tffp-features py-5 bg-body\">\n<!-- wp:group {\"className\":\"container\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group container\">\n<!-- wp:group {\"className\":\"text-center mb-4\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group text-center mb-4\">\n<!-- wp:heading {\"level\":2,\"className\":\"h1 mb-2\"} -->\n<h2 class=\"wp-block-heading h1 mb-2\">Waarom kiezen voor ons?</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"className\":\"lead mb-0 text-body-secondary\"} -->\n<p class=\"lead mb-0 text-body-secondary\">Een paar redenen waarom klanten ons boeken voor feestjes en events.</p>\n<!-- /wp:paragraph -->\n</div>\n<!-- /wp:group -->\n\n<!-- wp:html -->\n<div class=\"row g-3 g-md-4\">\n  <div class=\"col-12 col-md-6 col-lg-3\">\n    <div class=\"card h-100 border-0 shadow-sm\">\n      <div class=\"card-body p-4\">\n        <div class=\"mb-3 text-primary\" aria-hidden=\"true\"><i class=\"bi bi-stars\" style=\"font-size:1.5rem\"></i></div>\n        <h3 class=\"h5 mb-2\">Creatieve designs</h3>\n        <p class=\"mb-0 text-body-secondary\">Van snelle mini-art tot uitgebreide face paint: altijd passend bij je thema.</p>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"col-12 col-md-6 col-lg-3\">\n    <div class=\"card h-100 border-0 shadow-sm\">\n      <div class=\"card-body p-4\">\n        <div class=\"mb-3 text-primary\" aria-hidden=\"true\"><i class=\"bi bi-clock\" style=\"font-size:1.5rem\"></i></div>\n        <h3 class=\"h5 mb-2\">Snel & professioneel</h3>\n        <p class=\"mb-0 text-body-secondary\">Strakke planning, fijne flow en aandacht voor ieder kind.</p>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"col-12 col-md-6 col-lg-3\">\n    <div class=\"card h-100 border-0 shadow-sm\">\n      <div class=\"card-body p-4\">\n        <div class=\"mb-3 text-primary\" aria-hidden=\"true\"><i class=\"bi bi-shield-check\" style=\"font-size:1.5rem\"></i></div>\n        <h3 class=\"h5 mb-2\">Huidvriendelijke materialen</h3>\n        <p class=\"mb-0 text-body-secondary\">We werken met kwalitatieve, huidvriendelijke schmink en glitters.</p>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"col-12 col-md-6 col-lg-3\">\n    <div class=\"card h-100 border-0 shadow-sm\">\n      <div class=\"card-body p-4\">\n        <div class=\"mb-3 text-primary\" aria-hidden=\"true\"><i class=\"bi bi-geo-alt\" style=\"font-size:1.5rem\"></i></div>\n        <h3 class=\"h5 mb-2\">Op locatie in NL</h3>\n        <p class=\"mb-0 text-body-secondary\">Beschikbaar door heel Nederland voor kinderfeestjes, festivals en events.</p>\n      </div>\n    </div>\n  </div>\n</div>\n<!-- /wp:html -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n<!-- /wp:group -->",
        )
    );

    register_block_pattern(
        'fectionwp-pro-tffp/pricing',
        array(
            'title'       => __( 'TFFP: Pricing', 'fectionwp-pro-tffp' ),
            'description' => __( '3 prijskaarten/pakketten met Bootstrap cards.', 'fectionwp-pro-tffp' ),
            'categories'  => array( 'fectionwp-tffp' ),
            'content'     => "<!-- wp:group {\"align\":\"full\",\"className\":\"tffp-pricing py-5 bg-light\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-group alignfull tffp-pricing py-5 bg-light\">\n<!-- wp:group {\"className\":\"container\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group container\">\n<!-- wp:group {\"className\":\"text-center mb-4\",\"layout\":{\"type\":\"default\"}} -->\n<div class=\"wp-block-group text-center mb-4\">\n<!-- wp:heading {\"level\":2,\"className\":\"h1 mb-2\"} -->\n<h2 class=\"wp-block-heading h1 mb-2\">Pakketten &amp; prijzen</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph {\"className\":\"lead mb-0 text-body-secondary\"} -->\n<p class=\"lead mb-0 text-body-secondary\">Indicatieve pakketten. Vraag gerust een offerte op maat aan.</p>\n<!-- /wp:paragraph -->\n</div>\n<!-- /wp:group -->\n\n<!-- wp:html -->\n<div class=\"row g-3 g-lg-4 justify-content-center\">\n  <div class=\"col-12 col-md-6 col-lg-4\">\n    <div class=\"card h-100 border-0 shadow-sm\">\n      <div class=\"card-body p-4 p-md-5 d-flex flex-column\">\n        <h3 class=\"h4 mb-2\">Mini</h3>\n        <p class=\"text-body-secondary mb-3\">Kort feestje of kleine groep</p>\n        <p class=\"display-6 fw-semibold mb-3\">€ 125</p>\n        <ul class=\"list-unstyled mb-4\">\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Schminken (± 1 uur)</span></li>\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Mini designs</span></li>\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Reiskosten in overleg</span></li>\n        </ul>\n        <div class=\"mt-auto\"><a class=\"btn btn-outline-primary w-100\" href=\"/contact/\">Offerte aanvragen</a></div>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"col-12 col-md-6 col-lg-4\">\n    <div class=\"card h-100 border-primary shadow\">\n      <div class=\"card-body p-4 p-md-5 d-flex flex-column\">\n        <div class=\"d-flex align-items-baseline justify-content-between mb-2\">\n          <h3 class=\"h4 mb-0\">Populair</h3>\n          <span class=\"badge text-bg-primary\">Populair</span>\n        </div>\n        <p class=\"text-body-secondary mb-3\">Meest gekozen voor kinderfeestjes</p>\n        <p class=\"display-6 fw-semibold mb-3\">€ 195</p>\n        <ul class=\"list-unstyled mb-4\">\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Schminken (± 1,5 uur)</span></li>\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Meer variatie designs</span></li>\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Glitter accents mogelijk</span></li>\n        </ul>\n        <div class=\"mt-auto\"><a class=\"btn btn-primary w-100\" href=\"/contact/\">Beschikbaarheid checken</a></div>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"col-12 col-md-6 col-lg-4\">\n    <div class=\"card h-100 border-0 shadow-sm\">\n      <div class=\"card-body p-4 p-md-5 d-flex flex-column\">\n        <h3 class=\"h4 mb-2\">Event</h3>\n        <p class=\"text-body-secondary mb-3\">Festivals &amp; bedrijfsfeesten</p>\n        <p class=\"display-6 fw-semibold mb-3\">Op aanvraag</p>\n        <ul class=\"list-unstyled mb-4\">\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Schminken + glittertattoos</span></li>\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Hoge doorloop mogelijk</span></li>\n          <li class=\"d-flex gap-2 mb-2\"><span class=\"text-primary\" aria-hidden=\"true\">•</span><span>Afstemming op locatie</span></li>\n        </ul>\n        <div class=\"mt-auto\"><a class=\"btn btn-outline-primary w-100\" href=\"/contact/\">Vraag een offerte</a></div>\n      </div>\n    </div>\n  </div>\n</div>\n<!-- /wp:html -->\n</div>\n<!-- /wp:group -->\n</div>\n<!-- /wp:group -->\n<!-- /wp:group -->",
        )
    );
} );

// Force FectionWP-Booking public assets on pages where the booking form is rendered via PHP templates.
// The plugin conditionally enqueues assets by scanning post_content for the shortcode.
add_filter( 'fectionwp_booking_load_assets', function ( $should_load ) {
    if ( $should_load ) {
        return true;
    }

    if ( is_page_template( 'page-contact.php' ) ) {
        return true;
    }

    return false;
} );

// Redirect legacy SPA admin route to WordPress admin.
add_action( 'template_redirect', function () {
    if ( is_admin() ) {
        return;
    }

    if ( empty( $_SERVER['REQUEST_URI'] ) ) {
        return;
    }

    $request_path = wp_parse_url( home_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), PHP_URL_PATH );
    if ( ! is_string( $request_path ) ) {
        return;
    }

    $site_path = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
    $site_path = is_string( $site_path ) ? rtrim( $site_path, '/' ) : '';

    // Normalize and compare against the install base path.
    $relative = $request_path;
    if ( '' !== $site_path && str_starts_with( $relative, $site_path ) ) {
        $relative = substr( $relative, strlen( $site_path ) );
    }

    $relative = '/' . ltrim( $relative, '/' );

    if ( '/admin' === rtrim( $relative, '/' ) ) {
        wp_safe_redirect( admin_url(), 302 );
        exit;
    }
}, 1 );

// Global WhatsApp floating action button.
add_action( 'wp_footer', function () {
    if ( is_admin() ) {
        return;
    }

    get_template_part( 'template-parts/tffp/whatsapp-fab' );
}, 50 );

// Resource hints for Google Fonts.
add_filter( 'wp_resource_hints', function ( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        if ( empty( tffp_google_families_in_use() ) ) {
            return $urls;
        }
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}, 10, 2 );
