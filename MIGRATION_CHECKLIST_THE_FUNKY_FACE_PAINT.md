# Migratie checklist: The Funky Face Paint → WordPress (FectionWP-Pro child theme)

Datum: 2025-12-19

Doel: snel peilen of de migratie **compleet** is, wat **nog open** staat, en wat **kritisch** is voor livegang.

Gebruik:
- Vink alles af vóór livegang.
- Als iets “n.v.t.” is, noteer kort waarom.

Zie ook:
- `MIGRATION_THE_FUNKY_FACE_PAINT.md` (plan + keuzes)
- `MIGRATION_TASKBOARD_THE_FUNKY_FACE_PAINT.md` (tickets)

---

## 0) Repo voortgang (code) — bijgewerkt: 2025-12-29

- [x] Child theme scaffold aanwezig: `child-theme/fectionwp-pro-tffp/`
- [x] TFFP templates aanwezig: `front-page.php` + `page-*.php`
- [x] TFFP template-parts aanwezig onder `template-parts/tffp/`
- [x] Fullwidth fix: child `header.php` (voorkomt container lock-in op TFFP pagina’s)
- [x] Footer override in child theme
- [x] Hero story image blend + grotere weergave + originele (niet `cropped-`) afbeelding
- [x] Stats sectie fluid (`container-fluid`)
- [x] Typografie via Customizer:
  - child theme: sectie-fonts via CSS vars
  - parent theme: uitgebreide typografie + sitetitle font


## 1) Routes & pagina’s (must-have)

- [ ] Alle publieke routes bestaan als WP pagina met correcte slug + trailing slash (slugs exact):
  - [ ] `/` (Home; ingesteld als **statische homepage**, child theme rendert via `front-page.php`)
  - [ ] `/kinderfeestjes/` (Template: **Kinderfeestjes (TFFP)**)
  - [ ] `/festivals/` (Template: **Festivals (TFFP)**)
  - [ ] `/glitter/` (Template: **Glitter (TFFP)**)
  - [ ] `/galerij/` (Template: **Galerij (TFFP)**)
  - [ ] `/cadeaubon/` (Template: **Cadeaubon (TFFP)**)
  - [ ] `/contact/` (Template: **Contact (TFFP)**)
  - [ ] `/booking-confirmation/` (Betalings-succes pagina; template: `page-booking-confirmation.php`)
  - [ ] `/booking-cancelled/` (Betalings-annulering pagina; template: `page-booking-cancelled.php`)
- [ ] Pagina’s zijn **Published** (niet Draft/Private).
- [ ] Front page staat goed: **Instellingen → Lezen → statische homepage** (Home pagina geselecteerd).
- [ ] Per pagina is het juiste template gekozen (Pagina bewerken → Template).

---

## 2) Content compleetheid (site inhoud)

- [ ] Copy/secties per pagina zijn ingevuld (geen placeholder-tekst).
- [ ] Galerij pagina bevat Gutenberg **Galerij** block met echte afbeeldingen (minimaal 6–12).
- [ ] CTA links werken en wijzen naar bestaande WP pagina’s (met trailing slash).
- [ ] Afbeeldingen hebben alt-tekst waar relevant.

---

## 3) Navigatie (must-have)

- [ ] WP menu “Primary” bestaat en is gekoppeld aan locatie **Primary**.
- [ ] Primary menu items komen overeen met de site:
  - [ ] Home
  - [ ] Kinderfeestjes
  - [ ] Festivals
  - [ ] Glitter
  - [ ] Galerij
  - [ ] Cadeaubon
  - [ ] Contact
- [ ] Alle menu links klikken door zonder 404.

---

## 4) Contact & WhatsApp (must-have)

- [ ] Customizer waarden ingevuld:
  - [ ] WhatsApp nummer (digits-only)
  - [ ] WhatsApp prefill bericht
  - [ ] Contact e-mail
  - [ ] Telefoonnummer
- [ ] WhatsApp FAB zichtbaar (waar gewenst) en linkt correct naar `wa.me/...`.
- [ ] Contactform (WhatsApp message) opent WhatsApp met een nette prefilled message.
- [ ] `mailto:` en `tel:` links werken.

---

## 5) Booking (must-have)

- [ ] FectionWP-Booking plugin actief.
- [ ] Minimaal 1 service is aangemaakt:
  - [ ] prijs in **centen**
  - [ ] duur in **minuten**
  - [ ] service actief
- [ ] Availability ingesteld:
  - [ ] openingstijden
  - [ ] slot increments
  - [ ] min-notice (bv. 48 uur) indien vereist
  - [ ] holidays (indien gebruikt)
- [ ] `/contact/` gebruikt Template **Contact (TFFP)** en toont het booking form via shortcode `[pbp_booking_form]`.
- [ ] Frontend booking assets laden op `/contact/` (plugin laadt conditioneel; formulier is bruikbaar/styled).
- [ ] E2E booking test:
  - [ ] nieuwe booking kan worden geplaatst
  - [ ] booking verschijnt in WP admin
  - [ ] admin mail verstuurd
  - [ ] klant bevestiging verstuurd
  - [ ] (optioneel) iCal/Google/Outlook links aanwezig/kloppen

---

## 6) Redirects (must-have)

- [ ] No-slash URLs redirecten naar trailing slash (301):
  - [ ] `/kinderfeestjes` → `/kinderfeestjes/`
  - [ ] `/festivals` → `/festivals/`
  - [ ] `/glitter` → `/glitter/`
  - [ ] `/galerij` → `/galerij/`
  - [ ] `/cadeaubon` → `/cadeaubon/`
  - [ ] `/contact` → `/contact/`
- [ ] `/admin` redirect:
  - [ ] `/admin` → `/wp-admin/` (302 aanbevolen)
- [ ] Canonical URLs geven direct `200` (geen 302/redirect-chain):
  - [ ] `/kinderfeestjes/`
  - [ ] `/festivals/`
  - [ ] `/glitter/`
  - [ ] `/galerij/`
  - [ ] `/cadeaubon/`
  - [ ] `/contact/`
- [ ] Geen redirect loops.

Snelle check (staging/live):
```bash
# pas aan naar je staging/live URL
BASE_URL="https://example.com"

# no-slash → slash (verwacht: 301)
curl -sS -o /dev/null -D - "$BASE_URL/kinderfeestjes" | head -n 5
curl -sS -o /dev/null -D - "$BASE_URL/festivals"      | head -n 5
curl -sS -o /dev/null -D - "$BASE_URL/glitter"        | head -n 5
curl -sS -o /dev/null -D - "$BASE_URL/galerij"        | head -n 5
curl -sS -o /dev/null -D - "$BASE_URL/cadeaubon"      | head -n 5
curl -sS -o /dev/null -D - "$BASE_URL/contact"        | head -n 5

# canonical URLs (verwacht: 200)
curl -sS -o /dev/null -D - "$BASE_URL/kinderfeestjes/" | head -n 5
curl -sS -o /dev/null -D - "$BASE_URL/contact/"       | head -n 5

# admin redirect (verwacht: 302 naar /wp-admin/)
curl -sS -o /dev/null -D - "$BASE_URL/admin"          | head -n 10
```

---

## 7) SEO basis (should-have)

- [ ] Canonicals zijn correct (via WP/SEO plugin).
- [ ] Sitemap aanwezig (via SEO plugin of WP core).
- [ ] Titels + meta descriptions (minimaal home/contact) ingesteld.
- [ ] Open Graph defaults ok (als social belangrijk is).

---

## 8) Performance & assets (should-have)

- [ ] Geen React/Vite/Tailwind bundles worden ingeladen op de WP site (Bootstrap blijft leidend).
- [ ] JS is minimaal en laadt alleen waar nodig.
- [ ] Afbeeldingen zijn geoptimaliseerd (WebP waar mogelijk, lazy-load, juiste afmetingen).

---

## 9) Accessibility (should-have)

- [ ] Keyboard navigatie werkt (menu, buttons, formulieren).
- [ ] Focus states zichtbaar.
- [ ] Contrast is acceptabel (met tokens/Bootstrap varianten).

---

## 10) Release hygiene (must-have)

- [ ] Permalinks staan niet op “Plain”.
- [ ] Cache geleegd (page cache/object cache/CDN).
- [ ] Geen debug output, geen placeholder strings.
- [ ] Backups / rollback plan aanwezig (minimaal: theme switch terug naar parent).

---

## 11) Open punten (noteer)

- [ ] Beheerbaar maken fase 2 (Gutenberg patterns) – gepland / n.v.t.
- [ ] ACF (repeaters) – beschikbaar? nodig?
- [ ] Extra gallery features (lightbox/filters) – bewust uitgesteld

Notities:
- 
