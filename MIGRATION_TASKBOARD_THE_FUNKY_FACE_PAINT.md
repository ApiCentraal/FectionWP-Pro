# Taskboard: Migratie The Funky Face Paint → WordPress (FectionWP-Pro)

Datum: 2025-12-19

Doel: Werkbaar ticket-overzicht op basis van het migratieplan in [MIGRATION_THE_FUNKY_FACE_PAINT.md](MIGRATION_THE_FUNKY_FACE_PAINT.md).

Conventies:
- Elk ticket heeft Acceptance Criteria (DoD) en Dependencies.
- Scope is “hardcoded-first”, daarna beheerbaar (patterns/ACF) zoals beschreven.

---

## Milestone A — Voorbereiding

### A1 — Child theme activeren + basisstructuur
**Status (2025-12-29):** ✅ Code klaar (child theme scaffold in repo). ⚠️ Nog te doen in WP: deploy naar `wp-content/themes/` en activeren.

**Werk**
- Zorg dat het child theme `child-theme/fectionwp-pro-tffp/` als theme kan draaien in `wp-content/themes/`.
- Activeer het theme in WP.

**Acceptance Criteria**
- Site draait op child theme zonder PHP errors.
- TFFP CSS laadt zichtbaar (bv. body background/typografie wijkt af van parent).

**Dependencies**
- Werkende WordPress install met FectionWP-Pro als parent.

---

### A2 — Tokens + Bootstrap overrides finaliseren
**Status (2025-12-29):** ✅ Tokens scaffold aanwezig + custom CSS (incl. gradients/animaties) in child theme.

**Werk**
- Bevestig dat [child-theme/fectionwp-pro-tffp/assets/css/tffp-tokens.css](child-theme/fectionwp-pro-tffp/assets/css/tffp-tokens.css) geladen wordt en Bootstrap variabelen effectief overridet.

**Acceptance Criteria**
- Bootstrap `--bs-*` vars reflecteren TFFP tokens (primary/body/bg/radius/font).
- Geen Tailwind CSS build in productie.

**Dependencies**
- A1.

---

### A3 — Pagina’s aanmaken + slugs + front page
**Werk**
- Maak WP pagina’s aan: `kinderfeestjes`, `festivals`, `glitter`, `galerij`, `cadeaubon`, `contact`.
- Zet static front page.

**Acceptance Criteria**
- Alle slugs bestaan en renderen 200 met trailing slash.
- Front page staat correct ingesteld.

**Dependencies**
- A1.

---

## Milestone B — Pagina parity (hardcoded-first)

### B1 — Template skeletons per pagina
**Status (2025-12-29):** ✅ Templates aanwezig (front-page + alle page-*.php in child theme).

**Werk**
- Maak templates aan voor: `front-page.php`, `page-kinderfeestjes.php`, `page-festivals.php`, `page-glitter.php`, `page-galerij.php`, `page-cadeaubon.php`, `page-contact.php`.

**Acceptance Criteria**
- Elke pagina rendert server-side met basis markup en correcte page title.
- Navigatie links werken naar alle pagina’s.

**Dependencies**
- A3.

---

### B2 — Template-parts scaffold (1-op-1 secties)
**Status (2025-12-29):** ✅ Template-parts aanwezig onder `child-theme/fectionwp-pro-tffp/template-parts/tffp/`.

**Werk**
- Voeg template-parts toe onder `template-parts/tffp/`: `hero.php`, `stats.php`, `testimonials.php`, `locations.php`, `booking.php`, `contact.php`, `gallery.php`, `whatsapp-fab.php`.

**Acceptance Criteria**
- Templates includen template-parts zonder warnings.
- Secties verschijnen op de bedoelde pagina’s.

**Dependencies**
- B1.

---

### B3 — Markup refactor: Bootstrap layout (Optie C)
**Status (2025-12-29):** ✅ Secties zijn Bootstrap-first; custom CSS alleen voor unieke gradients/animaties.

**Werk**
- Per sectie Bootstrap markup toepassen (`container/row/col`, cards, buttons) en TFFP custom classes alleen voor unieke gradients/achtergronden.

**Acceptance Criteria**
- Layout is consistent met React (grid/spacing/typografie) “close enough”.
- Geen Tailwind classes in output.

**Dependencies**
- B2.

---

### B4 — Navigatie + footer + WhatsApp CTA
**Status (2025-12-29):** ◑ Footer/CTA’s aanwezig in child theme; menu-items nog te zetten in WP menu beheer.

**Werk**
- Zet menu-items gelijk aan React.
- Voeg WhatsApp CTA (FAB + knoppen) toe met site option (initieel hardcoded mag, later beheerbaar).

**Acceptance Criteria**
- Menu items: Home, Kinderfeestjes, Festivals & Events, Glitter & Mini Art, Galerij, Cadeaubon, Contact.
- WhatsApp links openen correct (tel/wa.me) met verwachte tekst.

**Dependencies**
- B1.

---

### B5 — Over-ons pagina + per-page hero + header layout
**Status (2026-01-11):** ✅ Code klaar (child theme).

**Werk**
- Voeg een Over-ons pagina toe (template + layout) die consistent is met de rest van TFFP.
- Refactor “hero copy” zodat deze dezelfde TFFP hero/styling gebruikt.
- Voeg per-pagina hero-header instellingen toe (achtergrond, tekst, optionele CTA).
- Pas header/menu layout aan: burger links, logo/titel in het midden, utilities rechts, hoofdmenu gecentreerd onder de titel.

**Acceptance Criteria**
- Over-ons template is selecteerbaar en rendert zonder warnings.
- Per pagina kan een hero-header geconfigureerd worden via de editor (meta box) en rendert onder de header.
- Header voldoet aan het gewenste layout-patroon zonder Customizer regressies.

**Dependencies**
- B1.

---

## Milestone C — Booking naar WP (FectionWP-Booking)

### C1 — Plugin configuratie: services + availability + email
**Werk**
- Configureer services, availability (business hours, holidays), en email instellingen in FectionWP-Booking.

**Acceptance Criteria**
- Min-notice is ingesteld (±48 uur) als dit gewenst is.
- Minimaal 1 service is boekbaar en verschijnt in de form.

**Dependencies**
- Werkende FectionWP-Booking plugin installatie.

---

### C2 — Contact pagina: booking form embed
**Werk**
- Embed `[pbp_booking_form]` op `/contact/` (via page content of via template).

**Acceptance Criteria**
- Form laadt met scripts/styles (plugin conditionele enqueue werkt).
- Submit maakt booking aan via REST en geeft success response.

**Dependencies**
- C1.

---

### C3 — Booking styling match met TFFP tokens
**Werk**
- Zet plugin customizer opties (primary/radius/font) gelijk aan TFFP.
- Indien nodig theme overrides toepassen zodat plugin niet de site-wide font onverwacht overschrijft.

**Acceptance Criteria**
- Booking form voelt visueel consistent met de rest van de site.
- Geen onverwachte font overrides buiten de booking UI.

**Dependencies**
- C2.

---

### C4 — E2E test: booking opslag + admin + mails
**Werk**
- Doorloop complete flow: submit → admin ziet booking → status update → mails (admin + klant).

**Acceptance Criteria**
- Booking verschijnt in admin dashboard.
- Bevestigingsmails versturen met correcte datum/tijd/service.

**Dependencies**
- C2.

---

## Milestone D — Beheerbaar maken (na parity)

### D1 — Gutenberg patterns voor kernsecties
**Werk**
- Maak patterns voor: Hero, CTA secties, 2-kolommen cards, USP lists.

**Acceptance Criteria**
- Editor kan content aanpassen zonder code wijzigingen.
- Patterns renderen identiek aan hardcoded output (binnen redelijkheid).

**Dependencies**
- B3.

---

### D2 — ACF (optioneel) voor repeaters/datasets
**Werk**
- Alleen waar echt nodig: testimonials, locations, pricing/services, contactgegevens (site options).

**Acceptance Criteria**
- Repeaters werken en renderen correct in templates.
- Geen regressie in performance (geen zware queries zonder caching waar nodig).

**Dependencies**
- D1.
- ACF beschikbaar/licentie beslissing.

---

## Milestone E — Redirects, SEO, QA, livegang

### E1 — Redirects implementeren
**Werk**
- Implementatie via Redirection plugin of server-level redirects.

**Acceptance Criteria**
- `GET /kinderfeestjes` → 301 → `/kinderfeestjes/`.
- `GET /admin` → 302 → `/wp-admin/`.

**Dependencies**
- B1.

---

### E2 — SEO basis + tracking
**Werk**
- Canonicals ok, sitemap via SEO plugin, headings/alt/focus states check.

**Acceptance Criteria**
- Geen soft-404s voor belangrijke pagina’s.
- OG/title meta configureerbaar (Yoast/RankMath of minimaal via theme).

**Dependencies**
- B1.

---

### E3 — Performance sanity check
**Werk**
- Controleer dat er geen dubbele frameworks geladen worden.
- JS alleen op pagina’s waar nodig.

**Acceptance Criteria**
- Lighthouse check op home + contact zonder opvallende regressies.

**Dependencies**
- B3 + C2.

---

### E4 — Go-live checklist
**Werk**
- Final QA run + redirects live + smoke test booking.

**Acceptance Criteria**
- Alle acceptance checks uit E1–E3 groen.
- Booking flow live werkt (minimaal 1 testboeking).

**Dependencies**
- E1–E3.
