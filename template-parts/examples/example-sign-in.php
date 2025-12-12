<?php
/**
 * Example: Sign-in
 * 
 * Available $atts from Visual Builder:
 * - title: Form title
 * - btn_text: Submit button text
 * - footer_text: Footer disclaimer text
 * - show_remember: Show remember me checkbox (yes/no)
 */
$title         = isset( $atts['title'] ) ? $atts['title'] : 'Meld je aan';
$btn_text      = isset( $atts['btn_text'] ) ? $atts['btn_text'] : 'Sign in';
$footer_text   = isset( $atts['footer_text'] ) ? $atts['footer_text'] : 'Door verder te gaan ga je akkoord met de voorwaarden.';
$show_remember = ! isset( $atts['show_remember'] ) || $atts['show_remember'] !== 'no';
?>
<section class="example-signin d-flex align-items-center justify-content-center" style="min-height:70vh;">
    <div class="w-100" style="max-width:420px;">
        <form class="p-4 p-md-5 border rounded-3 bg-body shadow-sm">
            <h1 class="h3 mb-3 fw-normal text-center"><?php echo esc_html( $title ); ?></h1>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="signinEmail" placeholder="name@example.com">
                <label for="signinEmail">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="signinPassword" placeholder="Password">
                <label for="signinPassword">Password</label>
            </div>
            <?php if ( $show_remember ) : ?>
            <div class="checkbox mb-3">
                <label><input type="checkbox" value="remember-me"> Remember me</label>
            </div>
            <?php endif; ?>
            <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo esc_html( $btn_text ); ?></button>
            <?php if ( $footer_text ) : ?>
            <hr class="my-4">
            <small class="text-muted"><?php echo esc_html( $footer_text ); ?></small>
            <?php endif; ?>
        </form>
    </div>
</section>
