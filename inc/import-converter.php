<?php
/**
 * Divi to FWP Section Converter - Enhanced Version
 * 
 * Converts Divi Builder shortcodes to FWP Visual Builder sections.
 * Extracts full content including text, images, buttons, and more.
 */

if ( ! defined( 'ABSPATH' ) ) {
    if ( php_sapi_name() !== 'cli' ) {
        exit;
    }
}

class Divi_To_FWP_Converter {
    
    /**
     * Convert Divi content to FWP sections
     */
    public static function convert( $content ) {
        if ( empty( $content ) ) {
            return '';
        }
        
        $sections = array();
        
        // Parse Divi sections
        preg_match_all( '/\[et_pb_section([^\]]*)\](.*?)\[\/et_pb_section\]/s', $content, $matches, PREG_SET_ORDER );
        
        foreach ( $matches as $match ) {
            $section_attrs = self::parse_attributes( $match[1] );
            $section_content = $match[2];
            
            // Determine section type based on content analysis
            $section_type = self::determine_section_type( $section_content, $section_attrs );
            $section_settings = self::extract_settings( $section_content, $section_attrs, $section_type );
            
            // Extract actual content from modules
            $extracted_content = self::extract_content( $section_content, $section_type );
            
            $sections[] = array(
                'type' => $section_type,
                'settings' => $section_settings,
                'content' => $extracted_content
            );
        }
        
        // Build FWP shortcodes with content
        $output = '';
        foreach ( $sections as $section ) {
            $shortcode = '[fwp_section type="' . self::esc( $section['type'] ) . '"';
            foreach ( $section['settings'] as $key => $value ) {
                if ( ! empty( $value ) && $key !== 'content_html' ) {
                    $safe_key = preg_replace( '/[^a-z0-9_\-]/', '', strtolower( $key ) );
                    $shortcode .= ' ' . $safe_key . '="' . self::esc( $value ) . '"';
                }
            }
            $shortcode .= ']';
            
            // Add extracted content as comment for reference
            if ( ! empty( $section['content'] ) ) {
                $shortcode .= "\n<!-- Extracted content:\n" . print_r( $section['content'], true ) . "\n-->";
            }
            
            $output .= $shortcode . "\n\n";
        }
        
        return $output;
    }
    
    /**
     * HTML escape helper
     */
    private static function esc( $value ) {
        return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
    }
    
    /**
     * Parse Divi shortcode attributes
     */
    private static function parse_attributes( $attr_string ) {
        $attrs = array();
        // Handle attributes with various quote styles
        preg_match_all( '/(\w+)="([^"]*)"/', $attr_string, $matches, PREG_SET_ORDER );
        foreach ( $matches as $match ) {
            $attrs[ $match[1] ] = $match[2];
        }
        return $attrs;
    }
    
    /**
     * Determine FWP section type from Divi content - ENHANCED
     */
    private static function determine_section_type( $content, $attrs ) {
        // Count different module types
        $has_contact_form = strpos( $content, 'et_pb_contact_form' ) !== false;
        $has_pricing = strpos( $content, 'et_pb_pricing_table' ) !== false;
        $has_accordion = strpos( $content, 'et_pb_accordion' ) !== false;
        $has_video = strpos( $content, 'et_pb_video' ) !== false;
        $has_blog = strpos( $content, 'et_pb_blog' ) !== false;
        $has_signup = strpos( $content, 'et_pb_signup' ) !== false;
        $has_blurb = strpos( $content, 'et_pb_blurb' ) !== false;
        $has_button = strpos( $content, 'et_pb_button' ) !== false;
        
        $image_count = preg_match_all( '/\[et_pb_image/', $content );
        $text_count = preg_match_all( '/\[et_pb_text/', $content );
        $column_count = preg_match_all( '/\[et_pb_column/', $content );
        $row_count = preg_match_all( '/\[et_pb_row/', $content );
        
        // Check for fullwidth/hero sections
        $is_fullwidth = isset( $attrs['fullwidth'] ) && $attrs['fullwidth'] === 'on';
        $has_bg_image = ! empty( $attrs['background_image'] );
        $has_parallax = isset( $attrs['parallax'] ) && $attrs['parallax'] === 'on';
        
        // Priority-based detection
        
        // 1. Contact form
        if ( $has_contact_form ) {
            return 'contact-form';
        }
        
        // 2. Newsletter/Signup
        if ( $has_signup ) {
            return 'newsletter';
        }
        
        // 3. Pricing tables
        if ( $has_pricing ) {
            return 'pricing-table';
        }
        
        // 4. Accordion/FAQ
        if ( $has_accordion ) {
            return 'accordion';
        }
        
        // 5. Video section
        if ( $has_video ) {
            return 'video';
        }
        
        // 6. Blog posts
        if ( $has_blog ) {
            return 'blog-posts';
        }
        
        // 7. Hero section - first section with background image
        if ( $has_bg_image && ( $is_fullwidth || $has_parallax ) ) {
            if ( $has_button ) {
                return 'hero-cta';
            }
            return 'hero-centered';
        }
        
        // 8. CTA banner - button prominent
        if ( $has_button && $text_count <= 2 ) {
            return 'cta-banner';
        }
        
        // 9. Features with blurbs
        if ( $has_blurb ) {
            return 'features';
        }
        
        // 10. Multi-column layouts
        if ( $column_count >= 3 ) {
            if ( $image_count >= 3 ) {
                return 'gallery';
            }
            return 'cards-grid';
        }
        
        // 11. Two column with image
        if ( $column_count == 2 && $image_count >= 1 && $text_count >= 1 ) {
            return 'text-image';
        }
        
        // 12. Image gallery
        if ( $image_count >= 3 ) {
            return 'gallery';
        }
        
        // 13. Text only section
        if ( $text_count >= 1 && $image_count == 0 ) {
            return 'text-block';
        }
        
        // 14. Background image with content
        if ( $has_bg_image ) {
            return 'hero-split';
        }
        
        // Default
        return 'content-block';
    }
    
    /**
     * Extract settings from Divi content - ENHANCED
     */
    private static function extract_settings( $content, $section_attrs, $type ) {
        $settings = array(
            'bg' => 'white',
            'py' => '5',
            'container' => 'container',
            'text_color' => 'dark'
        );
        
        // Background color analysis
        if ( isset( $section_attrs['background_color'] ) ) {
            $bg_color = strtolower( $section_attrs['background_color'] );
            $settings['bg_hex'] = $bg_color;
            
            // Determine Bootstrap class equivalent
            if ( preg_match( '/#([0-3][0-9a-f]{5}|000|111|222|333)/', $bg_color ) ) {
                $settings['bg'] = 'dark';
                $settings['text_color'] = 'light';
            } elseif ( preg_match( '/#([f][0-9a-f]{5}|[e][0-9a-f]{5})/', $bg_color ) ) {
                $settings['bg'] = 'light';
            } elseif ( strpos( $bg_color, 'rgba' ) !== false ) {
                $settings['bg'] = 'transparent';
            }
        }
        
        // Background image
        if ( isset( $section_attrs['background_image'] ) && ! empty( $section_attrs['background_image'] ) ) {
            $settings['bg_image'] = $section_attrs['background_image'];
            $settings['bg'] = 'dark';
            $settings['text_color'] = 'light';
        }
        
        // Parallax
        if ( isset( $section_attrs['parallax'] ) && $section_attrs['parallax'] === 'on' ) {
            $settings['parallax'] = 'true';
        }
        
        // Padding analysis
        if ( isset( $section_attrs['custom_padding'] ) ) {
            $padding = $section_attrs['custom_padding'];
            if ( preg_match( '/(\d+)(px|vh|%)/', $padding, $p_match ) ) {
                $padding_val = intval( $p_match[1] );
                if ( $padding_val > 100 ) {
                    $settings['py'] = '6';
                } elseif ( $padding_val > 60 ) {
                    $settings['py'] = '5';
                } elseif ( $padding_val > 30 ) {
                    $settings['py'] = '4';
                } else {
                    $settings['py'] = '3';
                }
            }
        }
        
        // Extract all headings
        $headings = self::extract_headings( $content );
        if ( ! empty( $headings['h1'] ) ) {
            $settings['title'] = $headings['h1'][0];
        } elseif ( ! empty( $headings['h2'] ) ) {
            $settings['title'] = $headings['h2'][0];
        }
        
        if ( ! empty( $headings['h3'] ) ) {
            $settings['subtitle'] = $headings['h3'][0];
        }
        
        // Extract first meaningful paragraph as description
        $paragraphs = self::extract_paragraphs( $content );
        if ( ! empty( $paragraphs ) ) {
            foreach ( $paragraphs as $p ) {
                $p_clean = trim( strip_tags( $p ) );
                if ( strlen( $p_clean ) > 20 && strlen( $p_clean ) < 500 ) {
                    $settings['description'] = $p_clean;
                    break;
                }
            }
        }
        
        // Extract buttons
        $buttons = self::extract_buttons( $content );
        if ( ! empty( $buttons ) ) {
            $settings['btn_text'] = $buttons[0]['text'];
            $settings['btn_url'] = $buttons[0]['url'];
            if ( isset( $buttons[1] ) ) {
                $settings['btn2_text'] = $buttons[1]['text'];
                $settings['btn2_url'] = $buttons[1]['url'];
            }
        }
        
        // Type-specific settings
        switch ( $type ) {
            case 'cards-grid':
            case 'features':
            case 'gallery':
                $column_count = preg_match_all( '/\[et_pb_column/', $content );
                $row_count = preg_match_all( '/\[et_pb_row/', $content );
                $items_per_row = $row_count > 0 ? ceil( $column_count / $row_count ) : $column_count;
                $settings['cols'] = min( 4, max( 2, $items_per_row ) );
                break;
                
            case 'hero-centered':
            case 'hero-cta':
            case 'hero-split':
                $settings['container'] = 'container-fluid';
                $settings['py'] = '6';
                $settings['min_height'] = '60vh';
                break;
                
            case 'pricing-table':
                $table_count = preg_match_all( '/\[et_pb_pricing_table/', $content );
                $settings['cols'] = min( 4, max( 2, $table_count ) );
                break;
        }
        
        return $settings;
    }
    
    /**
     * Extract actual content from Divi modules - NEW
     */
    private static function extract_content( $content, $type ) {
        $extracted = array();
        
        // Extract all text blocks
        preg_match_all( '/\[et_pb_text[^\]]*\](.*?)\[\/et_pb_text\]/s', $content, $text_matches );
        if ( ! empty( $text_matches[1] ) ) {
            $extracted['text_blocks'] = array();
            foreach ( $text_matches[1] as $text ) {
                $clean = trim( strip_tags( $text, '<strong><em><a><br>' ) );
                if ( ! empty( $clean ) ) {
                    $extracted['text_blocks'][] = $clean;
                }
            }
        }
        
        // Extract images
        preg_match_all( '/\[et_pb_image[^\]]*src="([^"]*)"[^\]]*\]/', $content, $img_matches );
        if ( ! empty( $img_matches[1] ) ) {
            $extracted['images'] = $img_matches[1];
        }
        
        // Extract buttons
        $extracted['buttons'] = self::extract_buttons( $content );
        
        // Extract blurbs (icon boxes)
        preg_match_all( '/\[et_pb_blurb([^\]]*)\](.*?)\[\/et_pb_blurb\]/s', $content, $blurb_matches, PREG_SET_ORDER );
        if ( ! empty( $blurb_matches ) ) {
            $extracted['blurbs'] = array();
            foreach ( $blurb_matches as $blurb ) {
                $attrs = self::parse_attributes( $blurb[1] );
                $extracted['blurbs'][] = array(
                    'title' => isset( $attrs['title'] ) ? $attrs['title'] : '',
                    'icon' => isset( $attrs['font_icon'] ) ? $attrs['font_icon'] : '',
                    'content' => trim( strip_tags( $blurb[2] ) )
                );
            }
        }
        
        // Extract pricing tables
        if ( $type === 'pricing-table' ) {
            preg_match_all( '/\[et_pb_pricing_table([^\]]*)\](.*?)\[\/et_pb_pricing_table\]/s', $content, $pricing_matches, PREG_SET_ORDER );
            if ( ! empty( $pricing_matches ) ) {
                $extracted['pricing'] = array();
                foreach ( $pricing_matches as $table ) {
                    $attrs = self::parse_attributes( $table[1] );
                    $features = array();
                    preg_match_all( '/<li[^>]*>(.*?)<\/li>/s', $table[2], $li_matches );
                    if ( ! empty( $li_matches[1] ) ) {
                        foreach ( $li_matches[1] as $li ) {
                            $features[] = trim( strip_tags( $li ) );
                        }
                    }
                    $extracted['pricing'][] = array(
                        'title' => isset( $attrs['title'] ) ? $attrs['title'] : '',
                        'subtitle' => isset( $attrs['subtitle'] ) ? $attrs['subtitle'] : '',
                        'price' => isset( $attrs['sum'] ) ? $attrs['sum'] : '',
                        'currency' => isset( $attrs['currency'] ) ? $attrs['currency'] : '€',
                        'period' => isset( $attrs['per'] ) ? $attrs['per'] : '',
                        'featured' => isset( $attrs['featured'] ) && $attrs['featured'] === 'on',
                        'features' => $features,
                        'button_text' => isset( $attrs['button_text'] ) ? $attrs['button_text'] : '',
                        'button_url' => isset( $attrs['button_url'] ) ? $attrs['button_url'] : ''
                    );
                }
            }
        }
        
        // Extract accordion items
        if ( $type === 'accordion' ) {
            preg_match_all( '/\[et_pb_accordion_item([^\]]*)\](.*?)\[\/et_pb_accordion_item\]/s', $content, $acc_matches, PREG_SET_ORDER );
            if ( ! empty( $acc_matches ) ) {
                $extracted['accordion'] = array();
                foreach ( $acc_matches as $item ) {
                    $attrs = self::parse_attributes( $item[1] );
                    $extracted['accordion'][] = array(
                        'title' => isset( $attrs['title'] ) ? $attrs['title'] : '',
                        'content' => trim( strip_tags( $item[2] ) ),
                        'open' => isset( $attrs['open'] ) && $attrs['open'] === 'on'
                    );
                }
            }
        }
        
        // Extract contact form fields
        if ( $type === 'contact-form' ) {
            preg_match_all( '/\[et_pb_contact_field([^\]]*)\]/', $content, $field_matches );
            if ( ! empty( $field_matches[1] ) ) {
                $extracted['form_fields'] = array();
                foreach ( $field_matches[1] as $field_attrs ) {
                    $attrs = self::parse_attributes( $field_attrs );
                    $extracted['form_fields'][] = array(
                        'id' => isset( $attrs['field_id'] ) ? $attrs['field_id'] : '',
                        'title' => isset( $attrs['field_title'] ) ? $attrs['field_title'] : '',
                        'type' => isset( $attrs['field_type'] ) ? $attrs['field_type'] : 'input',
                        'required' => ! isset( $attrs['required_mark'] ) || $attrs['required_mark'] !== 'off'
                    );
                }
            }
        }
        
        // Extract video URLs
        if ( $type === 'video' ) {
            preg_match_all( '/\[et_pb_video[^\]]*src="([^"]*)"/', $content, $video_matches );
            if ( ! empty( $video_matches[1] ) ) {
                $extracted['videos'] = $video_matches[1];
            }
        }
        
        return $extracted;
    }
    
    /**
     * Extract headings from content
     */
    private static function extract_headings( $content ) {
        $headings = array( 'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array() );
        
        foreach ( array( 'h1', 'h2', 'h3', 'h4' ) as $tag ) {
            preg_match_all( '/<' . $tag . '[^>]*>(.*?)<\/' . $tag . '>/si', $content, $matches );
            if ( ! empty( $matches[1] ) ) {
                foreach ( $matches[1] as $heading ) {
                    $clean = trim( strip_tags( $heading ) );
                    if ( ! empty( $clean ) ) {
                        $headings[ $tag ][] = $clean;
                    }
                }
            }
        }
        
        return $headings;
    }
    
    /**
     * Extract paragraphs from content
     */
    private static function extract_paragraphs( $content ) {
        $paragraphs = array();
        preg_match_all( '/<p[^>]*>(.*?)<\/p>/si', $content, $matches );
        if ( ! empty( $matches[1] ) ) {
            foreach ( $matches[1] as $p ) {
                $clean = trim( strip_tags( $p ) );
                if ( ! empty( $clean ) && strlen( $clean ) > 10 ) {
                    $paragraphs[] = $clean;
                }
            }
        }
        return $paragraphs;
    }
    
    /**
     * Extract buttons from content
     */
    private static function extract_buttons( $content ) {
        $buttons = array();
        preg_match_all( '/\[et_pb_button([^\]]*)\]/', $content, $matches );
        if ( ! empty( $matches[1] ) ) {
            foreach ( $matches[1] as $btn_attrs ) {
                $attrs = self::parse_attributes( $btn_attrs );
                if ( isset( $attrs['button_text'] ) ) {
                    $buttons[] = array(
                        'text' => $attrs['button_text'],
                        'url' => isset( $attrs['button_url'] ) ? $attrs['button_url'] : '#'
                    );
                }
            }
        }
        return $buttons;
    }
    
    /**
     * Process a WordPress export XML file
     */
    public static function process_xml_file( $xml_path ) {
        if ( ! file_exists( $xml_path ) ) {
            return array( 'error' => 'File not found' );
        }
        
        $xml = simplexml_load_file( $xml_path );
        if ( ! $xml ) {
            return array( 'error' => 'Invalid XML' );
        }
        
        $results = array();
        $namespaces = $xml->getNamespaces( true );
        
        foreach ( $xml->channel->item as $item ) {
            $wp = $item->children( $namespaces['wp'] );
            $content_ns = $item->children( $namespaces['content'] );
            
            if ( (string) $wp->post_type !== 'page' ) {
                continue;
            }
            
            if ( (string) $wp->status !== 'publish' ) {
                continue;
            }
            
            $title = (string) $item->title;
            $slug = (string) $wp->post_name;
            $original_content = (string) $content_ns->encoded;
            
            // Skip WooCommerce pages
            if ( in_array( $slug, array( 'winkel', 'winkelwagen', 'afrekenen', 'mijn-account' ) ) ) {
                continue;
            }
            
            // Convert content
            $converted = self::convert( $original_content );
            
            $results[] = array(
                'title' => $title,
                'slug' => $slug,
                'original_length' => strlen( $original_content ),
                'converted' => $converted,
                'section_count' => substr_count( $converted, '[fwp_section' )
            );
        }
        
        return $results;
    }
    
    /**
     * Generate WordPress import script
     */
    public static function generate_import_script( $results ) {
        $output = "<?php\n";
        $output .= "/**\n";
        $output .= " * Auto-generated import script for The Funky Facepainter\n";
        $output .= " * Generated: " . date( 'Y-m-d H:i:s' ) . "\n";
        $output .= " * \n";
        $output .= " * Run via WP-CLI: wp eval-file funky-facepainter-import.php\n";
        $output .= " * Or place in theme and run via admin\n";
        $output .= " */\n\n";
        $output .= "if ( ! defined( 'ABSPATH' ) ) {\n";
        $output .= "    // Allow WP-CLI execution\n";
        $output .= "    if ( ! defined( 'WP_CLI' ) ) {\n";
        $output .= "        exit( 'Direct access not allowed' );\n";
        $output .= "    }\n";
        $output .= "}\n\n";
        $output .= "\$imported = 0;\n";
        $output .= "\$updated = 0;\n\n";
        
        foreach ( $results as $page ) {
            if ( empty( $page['converted'] ) ) {
                continue;
            }
            
            // Strip the HTML comments with extracted content for the actual import
            $clean_content = preg_replace( '/\n<!-- Extracted content:.*?-->/s', '', $page['converted'] );
            
            $output .= "// ==========================================\n";
            $output .= "// Page: {$page['title']}\n";
            $output .= "// Sections: {$page['section_count']}\n";
            $output .= "// ==========================================\n";
            $output .= "\$page_data = array(\n";
            $output .= "    'post_title'   => " . var_export( $page['title'], true ) . ",\n";
            $output .= "    'post_name'    => " . var_export( $page['slug'], true ) . ",\n";
            $output .= "    'post_content' => " . var_export( trim( $clean_content ), true ) . ",\n";
            $output .= "    'post_status'  => 'publish',\n";
            $output .= "    'post_type'    => 'page',\n";
            $output .= ");\n\n";
            $output .= "\$existing = get_page_by_path( '{$page['slug']}' );\n";
            $output .= "if ( \$existing ) {\n";
            $output .= "    \$page_data['ID'] = \$existing->ID;\n";
            $output .= "    wp_update_post( \$page_data );\n";
            $output .= "    \$updated++;\n";
            $output .= "    echo \"Updated: {$page['title']}\\n\";\n";
            $output .= "} else {\n";
            $output .= "    wp_insert_post( \$page_data );\n";
            $output .= "    \$imported++;\n";
            $output .= "    echo \"Imported: {$page['title']}\\n\";\n";
            $output .= "}\n\n";
        }
        
        $output .= "echo \"\\n=== Import Complete ===\\n\";\n";
        $output .= "echo \"Imported: \$imported pages\\n\";\n";
        $output .= "echo \"Updated: \$updated pages\\n\";\n";
        
        return $output;
    }
    
    /**
     * Generate detailed conversion report
     */
    public static function generate_report( $results ) {
        $output = "# Divi to FWP Conversion Report\n\n";
        $output .= "Generated: " . date( 'Y-m-d H:i:s' ) . "\n\n";
        $output .= "## Summary\n\n";
        $output .= "| Page | Sections | Original Size |\n";
        $output .= "|------|----------|---------------|\n";
        
        $total_sections = 0;
        foreach ( $results as $page ) {
            $output .= "| {$page['title']} | {$page['section_count']} | " . number_format( $page['original_length'] ) . " chars |\n";
            $total_sections += $page['section_count'];
        }
        
        $output .= "\n**Total: " . count( $results ) . " pages, {$total_sections} sections**\n\n";
        
        $output .= "## Converted Content\n\n";
        
        foreach ( $results as $page ) {
            $output .= "### {$page['title']} (`{$page['slug']}`)\n\n";
            $output .= "```\n" . $page['converted'] . "```\n\n";
        }
        
        return $output;
    }
}

// CLI execution
if ( php_sapi_name() === 'cli' && isset( $argv[1] ) ) {
    $xml_path = $argv[1];
    echo "=== Divi to FWP Converter ===\n\n";
    echo "Processing: $xml_path\n\n";
    
    $results = Divi_To_FWP_Converter::process_xml_file( $xml_path );
    
    if ( isset( $results['error'] ) ) {
        echo "Error: {$results['error']}\n";
        exit( 1 );
    }
    
    // Generate section type statistics
    $type_stats = array();
    foreach ( $results as $page ) {
        preg_match_all( '/type="([^"]+)"/', $page['converted'], $types );
        foreach ( $types[1] as $type ) {
            if ( ! isset( $type_stats[ $type ] ) ) {
                $type_stats[ $type ] = 0;
            }
            $type_stats[ $type ]++;
        }
    }
    
    echo "=== Section Type Distribution ===\n";
    arsort( $type_stats );
    foreach ( $type_stats as $type => $count ) {
        echo sprintf( "  %-20s %d\n", $type, $count );
    }
    echo "\n";
    
    echo "=== Converted " . count( $results ) . " pages ===\n\n";
    foreach ( $results as $page ) {
        echo "--- {$page['title']} ({$page['slug']}) ---\n";
        echo "Original: " . number_format( $page['original_length'] ) . " chars | Sections: {$page['section_count']}\n";
        echo $page['converted'] . "\n";
    }
    
    // Generate and save import script
    $import_script = Divi_To_FWP_Converter::generate_import_script( $results );
    $import_path = dirname( $xml_path ) . '/funky-facepainter-import.php';
    file_put_contents( $import_path, $import_script );
    echo "\n=== Import script saved to: $import_path ===\n";
    
    // Generate and save report
    $report = Divi_To_FWP_Converter::generate_report( $results );
    $report_path = dirname( $xml_path ) . '/funky-facepainter-report.md';
    file_put_contents( $report_path, $report );
    echo "=== Report saved to: $report_path ===\n";
}
