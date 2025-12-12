<?php
/**
 * Template Name: Demo Landing Page
 * Description: Demonstrates all Bootstrap 5.3 page block shortcodes
 *
 * @package FectionWP_Pro
 */

get_header('landing'); // Gebruik transparante landing header
?>

    <?php
    // Hero Section - Full-width centered with gradient background
    echo do_shortcode('[hero-centered 
        title="Bootstrap 5.3 Page Blocks" 
        subtitle="WP Bootstrap Starter" 
        description="Build stunning landing pages with our collection of Bootstrap 5.3 shortcodes. No coding required - just use simple shortcodes to create professional layouts." 
        btn_text="Get Started" 
        btn_url="#features" 
        btn2_text="View Docs" 
        btn2_url="#faq"
        image="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo-shadow.png"
    ]');
    ?>

    <?php
    // Features Section with Icons
    echo do_shortcode('[features title="Powerful Features" subtitle="Why Choose Us" columns="3"]
        [feature 
            icon="bi-speedometer2" 
            title="Fast Performance" 
            description="Optimized for speed with minimal dependencies. Your pages load instantly."
        ]
        [feature 
            icon="bi-puzzle" 
            title="Easy to Use" 
            description="Simple shortcodes that anyone can use. No coding knowledge required."
        ]
        [feature 
            icon="bi-phone" 
            title="Fully Responsive" 
            description="Looks great on all devices, from mobile phones to large desktop screens."
        ]
        [feature 
            icon="bi-palette" 
            title="Customizable" 
            description="Easily adjust colors, fonts, and layouts to match your brand."
        ]
        [feature 
            icon="bi-shield-check" 
            title="Secure" 
            description="Built with security in mind. All output is properly escaped."
        ]
        [feature 
            icon="bi-arrow-repeat" 
            title="Regular Updates" 
            description="Continuously improved with new features and Bootstrap updates."
        ]
    [/features]');
    ?>

    <?php
    // Stats Section
    echo do_shortcode('[stats title="Trusted by Developers Worldwide"]
        [stat number="10K+" label="Downloads" icon="bi-download"]
        [stat number="500+" label="Happy Clients" icon="bi-people"]
        [stat number="99%" label="Satisfaction" icon="bi-heart"]
        [stat number="24/7" label="Support" icon="bi-headset"]
    [/stats]');
    ?>

    <?php
    // Pricing Section
    echo do_shortcode('[pricing-table 
        title="Simple, Transparent Pricing" 
        subtitle="Pricing Plans" 
        description="Choose the plan that works best for you. All plans include core features."
    ]
        [pricing-card 
            title="Free" 
            price="0" 
            period="/forever" 
            features="5 page blocks,Basic support,Community access,Regular updates" 
            btn_text="Get Started" 
            btn_url="#"
        ]
        [pricing-card 
            title="Pro" 
            price="29" 
            period="/month" 
            features="All page blocks,Priority support,Developer tools,White label,Custom blocks,API access" 
            btn_text="Start Free Trial" 
            btn_url="#" 
            featured="true"
        ]
        [pricing-card 
            title="Enterprise" 
            price="99" 
            period="/month" 
            features="Everything in Pro,Dedicated support,Custom development,SLA guarantee,Training sessions" 
            btn_text="Contact Sales" 
            btn_url="#"
        ]
    [/pricing-table]');
    ?>

    <?php
    // CTA Banner
    echo do_shortcode('[cta-banner 
        title="Ready to build amazing landing pages?" 
        description="Start creating professional WordPress pages with Bootstrap 5.3 components today." 
        btn_text="Get Started Free" 
        btn_url="#" 
        btn2_text="View Documentation" 
        btn2_url="#"
    ]');
    ?>

    <?php
    // Testimonials Section
    echo do_shortcode('[testimonials title="What Our Customers Say"]
        [testimonial 
            content="This theme has transformed how I build WordPress sites. The shortcodes are intuitive and the output is beautiful." 
            author="Sarah Johnson" 
            role="Web Designer" 
            avatar="https://i.pravatar.cc/150?img=1" 
            rating="5"
        ]
        [testimonial 
            content="Finally, a Bootstrap theme that actually works! Clean code, great documentation, and excellent support." 
            author="Mark Peters" 
            role="Developer" 
            avatar="https://i.pravatar.cc/150?img=3" 
            rating="5"
        ]
        [testimonial 
            content="I have tried many themes but this one stands out. The page blocks save me hours of work on every project." 
            author="Lisa Chen" 
            role="Agency Owner" 
            avatar="https://i.pravatar.cc/150?img=5" 
            rating="4"
        ]
    [/testimonials]');
    ?>

    <?php
    // FAQ Section
    echo do_shortcode('[faq title="Frequently Asked Questions" description="Got questions? We have answers."]
        [faq-item 
            question="How do I install the theme?" 
            answer="Simply upload the theme via WordPress admin under Appearance > Themes > Add New, or upload via FTP to wp-content/themes/."
        ]
        [faq-item 
            question="Is this theme compatible with Gutenberg?" 
            answer="Yes! The shortcodes work perfectly alongside the WordPress block editor. You can use them in Classic blocks or Custom HTML blocks."
        ]
        [faq-item 
            question="Can I customize the colors?" 
            answer="Absolutely. All blocks use Bootstrap CSS variables, so you can easily customize colors through the Customizer or by adding custom CSS."
        ]
        [faq-item 
            question="Do you offer support?" 
            answer="Yes, we provide support through our documentation, community forum, and direct email for Pro users."
        ]
        [faq-item 
            question="Is the theme SEO friendly?" 
            answer="Yes, the theme outputs semantic HTML5 and is optimized for search engines. It works great with popular SEO plugins."
        ]
    [/faq]');
    ?>

    <?php
    // Final CTA
    echo do_shortcode('[cta 
        title="Start Building Today" 
        description="Join thousands of developers who trust WP Bootstrap Starter for their WordPress projects." 
        btn_text="Download Free" 
        btn_url="#" 
        bg_class="bg-dark" 
        text_class="text-white"
    ]');
    ?>

<?php
get_footer('landing'); // Minimale landing footer
