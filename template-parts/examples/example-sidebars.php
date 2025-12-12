<div class="example-sidebars row g-4">
    <div class="col-md-4">
        <div class="position-sticky" style="top: 2rem;">
            <div class="p-4 mb-3 bg-body-tertiary rounded">
                <h4 class="fw-semibold">Sidebar</h4>
                <p class="mb-0">Gebruik deze kolom voor filters, links of context.</p>
            </div>
            <div class="p-4">
                <h4 class="fw-semibold">Links</h4>
                <ol class="list-unstyled mb-0">
                    <li><a href="#">Eerste link</a></li>
                    <li><a href="#">Tweede link</a></li>
                    <li><a href="#">Derde link</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
        <article class="mb-4 pb-4 border-bottom">
            <h2 class="h4 fw-bold">Content blok <?php echo $i; ?></h2>
            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur at.</p>
            <a href="#" class="link-primary">Lees meer →</a>
        </article>
        <?php endfor; ?>
    </div>
</div>
