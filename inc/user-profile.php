<?php
/**
 * User Profile Extensions
 *
 * Voegt extra social media velden toe aan gebruikersprofielen.
 *
 * @package FectionWP_Pro
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Voegt extra contactmethodes toe aan gebruikersprofielen
 *
 * @param array $methods Bestaande contact methodes.
 * @return array Uitgebreide contact methodes.
 */
function fwp_user_contact_methods($methods) {
    // Social Media
    $methods['twitter']   = __('X (Twitter) gebruikersnaam', 'fectionwp-pro');
    $methods['facebook']  = __('Facebook URL', 'fectionwp-pro');
    $methods['instagram'] = __('Instagram gebruikersnaam', 'fectionwp-pro');
    $methods['linkedin']  = __('LinkedIn URL', 'fectionwp-pro');
    $methods['github']    = __('GitHub gebruikersnaam', 'fectionwp-pro');
    $methods['youtube']   = __('YouTube kanaal URL', 'fectionwp-pro');

    return $methods;
}
add_filter('user_contactmethods', 'fwp_user_contact_methods');
