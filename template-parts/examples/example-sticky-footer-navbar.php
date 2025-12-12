<div class="example-sticky-footer-navbar d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sticky + Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#stickyNav" aria-controls="stickyNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="stickyNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1">
        <div class="container py-4">
            <h1 class="fw-bold">Sticky footer met navbar</h1>
            <p class="lead">Gebruik dit wanneer je een vaste top navigatie en een footer onderaan nodig hebt.</p>
        </div>
    </main>
    <footer class="mt-auto py-3 bg-body-tertiary border-top">
        <div class="container d-flex justify-content-between">
            <span class="text-muted">Footer content.</span>
            <span class="text-muted">© 2025</span>
        </div>
    </footer>
</div>
