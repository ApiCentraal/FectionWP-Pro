<?php
/**
 * Example: Pricing
 * 
 * Available $atts from Visual Builder:
 * - title: Section title
 * - subtitle: Section subtitle  
 * - currency: Currency symbol (default €)
 * - btn_text: Button text
 */
$title    = isset( $atts['title'] ) ? $atts['title'] : 'Pricing';
$subtitle = isset( $atts['subtitle'] ) ? $atts['subtitle'] : 'Eenvoudige prijstabellen met CTA.';
$currency = isset( $atts['currency'] ) ? $atts['currency'] : '€';
$btn_text = isset( $atts['btn_text'] ) ? $atts['btn_text'] : 'Start';
?>
<section class="example-pricing py-4">
    <div class="text-center mb-5">
        <h1 class="display-6 fw-bold"><?php echo esc_html( $title ); ?></h1>
        <p class="lead text-muted"><?php echo esc_html( $subtitle ); ?></p>
    </div>
    <div class="row g-4 justify-content-center">
        <?php
        $plans = array(
            array('title' => 'Free', 'price' => '0',  'period' => '/mo', 'features' => array('10 users', '2 GB storage', 'Email support'), 'variant' => 'outline-primary'),
            array('title' => 'Pro',  'price' => '15', 'period' => '/mo', 'features' => array('20 users', '10 GB storage', 'Priority support'), 'variant' => 'primary', 'featured' => true),
            array('title' => 'Enterprise', 'price' => '29', 'period' => '/mo', 'features' => array('Unlimited users', '100 GB storage', 'Phone support'), 'variant' => 'outline-primary'),
        );
        foreach ( $plans as $plan ) :
            $featured = ! empty( $plan['featured'] );
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="pricing-card card h-100 shadow-sm <?php echo $featured ? 'border-primary featured' : ''; ?>">
                    <div class="card-header bg-transparent border-0">
                        <h3 class="h5 fw-bold mb-0"><?php echo esc_html( $plan['title'] ); ?></h3>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex align-items-baseline mb-3">
                            <span class="display-5 fw-bold me-2"><?php echo esc_html( $currency . $plan['price'] ); ?></span>
                            <span class="text-muted"><?php echo esc_html( $plan['period'] ); ?></span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <?php foreach ( $plan['features'] as $feature ) : ?>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span><?php echo esc_html( $feature ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a class="btn btn-<?php echo esc_attr( $plan['variant'] ); ?> w-100" href="#"><?php echo esc_html( $btn_text ); ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
