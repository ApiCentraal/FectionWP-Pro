<div class="example-grid">
    <div class="row mb-3">
        <div class="col-md-8">
            <div class="p-4 border rounded-3">.col-md-8</div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3">.col-md-4</div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="p-4 border rounded-3">.col-md-4</div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3">.col-md-4</div>
        </div>
        <div class="col-md-4">
            <div class="p-4 border rounded-3">.col-md-4</div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
        <div class="col">
            <div class="p-4 border rounded-3 text-center">auto grid <?php echo $i; ?></div>
        </div>
        <?php endfor; ?>
    </div>
</div>
