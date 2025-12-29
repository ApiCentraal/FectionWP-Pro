<?php
/**
 * WhatsApp Floating Action Button.
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'tffp_get_whatsapp_url' ) ) {
    return;
}

$href = tffp_get_whatsapp_url( tffp_get_whatsapp_prefill() );
?>
<a class="tffp-whatsapp-fab" href="<?php echo esc_url( $href ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__( 'Open WhatsApp chat', 'fectionwp-pro-tffp' ); ?>">
    <span class="tffp-whatsapp-fab__label"><?php echo esc_html__( 'WhatsApp', 'fectionwp-pro-tffp' ); ?></span>
</a>
