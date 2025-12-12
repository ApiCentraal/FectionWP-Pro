<section class="example-checkout">
    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Jouw bestelling</span>
                <span class="badge bg-primary rounded-pill">3</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Productnaam</h6>
                        <small class="text-body-secondary">Korte omschrijving</small>
                    </div>
                    <span class="text-body-secondary">€12</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Tweede product</h6>
                        <small class="text-body-secondary">Korte omschrijving</small>
                    </div>
                    <span class="text-body-secondary">€8</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Derde item</h6>
                        <small class="text-body-secondary">Korte omschrijving</small>
                    </div>
                    <span class="text-body-secondary">€5</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Totaal (EUR)</span>
                    <strong>€25</strong>
                </li>
            </ul>
        </div>
        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Factuuradres</h4>
            <form class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label">Voornaam</label>
                        <input type="text" class="form-control" placeholder="Jan" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Achternaam</label>
                        <input type="text" class="form-control" placeholder="Jansen" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Adres</label>
                        <input type="text" class="form-control" placeholder="Hoofdstraat 1" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Land</label>
                        <select class="form-select" required>
                            <option value="">Kies...</option>
                            <option>Nederland</option>
                            <option>België</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Provincie</label>
                        <input type="text" class="form-control" placeholder="Noord-Holland" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Postcode</label>
                        <input type="text" class="form-control" placeholder="1234 AB" required>
                    </div>
                </div>
                <hr class="my-4">
                <h4 class="mb-3">Betaling</h4>
                <div class="my-3">
                    <div class="form-check">
                        <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                        <label class="form-check-label" for="credit">Creditcard</label>
                    </div>
                    <div class="form-check">
                        <input id="ideal" name="paymentMethod" type="radio" class="form-check-input" required>
                        <label class="form-check-label" for="ideal">iDEAL</label>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label">Naam op kaart</label>
                        <input type="text" class="form-control" placeholder="J. Jansen" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kaartnummer</label>
                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
                    </div>
                </div>
                <hr class="my-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit">Plaats bestelling</button>
            </form>
        </div>
    </div>
</section>
