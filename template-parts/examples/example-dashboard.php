<section class="example-dashboard">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="list-group shadow-sm">
                <a href="#" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action">Orders</a>
                <a href="#" class="list-group-item list-group-item-action">Products</a>
                <a href="#" class="list-group-item list-group-item-action">Customers</a>
                <a href="#" class="list-group-item list-group-item-action">Reports</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row g-3 mb-3">
                <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted small mb-1">KPI <?php echo $i; ?></p>
                            <h3 class="fw-bold mb-0"><?php echo rand(10, 99); ?>%</h3>
                            <small class="text-success">▲ 2.1%</small>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <div class="card shadow-sm mb-3">
                <div class="card-header">Recent activity</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr><th>Order</th><th>Status</th><th>Amount</th><th>Date</th></tr>
                            </thead>
                            <tbody>
                                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                <tr>
                                    <td>#100<?php echo $i; ?></td>
                                    <td><span class="badge bg-success-subtle text-success">Completed</span></td>
                                    <td>€<?php echo 40 + $i; ?></td>
                                    <td>10-12-2025</td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
