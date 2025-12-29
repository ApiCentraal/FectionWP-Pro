# Migratieplan: The Funky Face Paint (React/Vite) → FectionWP (WordPress theme)

Datum: 2025-12-19  
Doel: De huidige React/Vite site (`the-funky-face-paint`) migreren naar WordPress (PHP latest) op basis van het FectionWP-Pro theme (als parent), met **echte WordPress pagina’s** en een pragmatische aanpak: **hardcoded templates eerst**, daarna **beheerbaar maken** via Gutenberg patterns en (waar nodig) ACF/CPT.

Zie ook:
- `MIGRATION_CHECKLIST_THE_FUNKY_FACE_PAINT.md` (afvinklijst: wat is af / wat mist nog)
- `MIGRATION_TASKBOARD_THE_FUNKY_FACE_PAINT.md` (tickets + acceptance criteria)

## Status / voortgang (bijgewerkt: 2025-12-29)

**Code (repo) afgerond:**
- Child theme scaffold staat klaar in `child-theme/fectionwp-pro-tffp/` (templates, assets, template-parts).
- Layout fix voor fullwidth: child `header.php` stuurt `.site-main` container gedrag voor TFFP pagina’s.
- Footer override voor TFFP aanwezig.
- Hero “story” image blend is geïmplementeerd (CSS overlay) en gebruikt nu de originele (niet `cropped-`) afbeelding.
- Stats sectie is “fluid” gemaakt (`container-fluid`).
- Typografie via Customizer:
  - Child theme: sectie-fonts via CSS vars (TFFP secties).
  - Parent theme: uitgebreide Typografie sectie met Google/Microsoft(system)/External stylesheet + per header/content/footer + sitetitle font.

**Nog nodig in WordPress (setup/QA):**
- WP pagina’s aanmaken + templates koppelen + front page instellen.
- Redirects instellen (plugin of server-level).
- Booking plugin configureren en E2E booking testen.

---

## 0) Deliverables (Definition of Done)

**Live-ready (minimaal):**
- Alle publieke routes uit React bestaan als WP pagina met correcte slug + trailing slash.
- Child theme rendert alle pagina’s server-side met Bootstrap layout + TFFP tokens (visuele parity “goed genoeg”).
- Redirects actief (301 voor publieke routes, 302 voor `/admin` → `/wp-admin/`).
- Booking werkt via FectionWP-Booking: submit → opslag → admin zichtbaar → emails verstuurd.
- Geen Tailwind bundling in productie (Bootstrap blijft leidend).

**Nice to have (na livegang / fase 2+):** Gutenberg patterns, ACF repeaters, gallery CPT/taxonomie, extra editor tooling.

---

## 1) Scope & uitgangspunten

### 1.1 Wat we wél doen
- WordPress rendert alle pagina’s server-side (geen SPA).
- UI/styling parity op basis van **Bootstrap latest** met **eigen design tokens** (CSS variables) en waar nodig custom CSS voor gradients/animaties.
- Content: “beheerbaar waar zinvol” (Gutenberg patterns, optioneel ACF voor repeaters), maar we starten met hardcoded template-parts.
- URL’s volgens WordPress conventies (o.a. trailing slash) + 301 redirects van oude React routes.
- Booking + admin migreren naar **FectionWP-Booking plugin** (CPT/REST/e-mails/iCal/admin), niet via client-side storage.

### 1.2 Wat we níet doen
- Geen headless WordPress.
- Geen volledige React app embedded als theme (alleen eventueel *kleine islands* wanneer echt nodig).

### 1.3 Tech context (bron)
- React routes en pagina’s:
  - `the-funky-face-paint/src/components/AnimatedRoutes.tsx`
  - `the-funky-face-paint/src/pages/*.tsx`
- Booking + admin UI is nu client-side (Spark KV):
  - `the-funky-face-paint/src/components/BookingSection.tsx`
  - `the-funky-face-paint/src/pages/AdminPage.tsx`
- Email + calendar helpers:
  - `the-funky-face-paint/src/lib/emailTemplates.ts`
  - `the-funky-face-paint/src/lib/calendarInvite.ts`
- Styling/tokens:
  - `the-funky-face-paint/tailwind.config.js`

---

## 2) URL structuur & redirects

### 2.1 Canonical WordPress URLs (voorgesteld)
| Pagina | WordPress URL (canonical) |
|---|---|
| Home | `/` |
| Kinderfeestjes | `/kinderfeestjes/` |
| Festivals | `/festivals/` |
| Glitter | `/glitter/` |
| Galerij | `/galerij/` |
| Cadeaubon | `/cadeaubon/` |
| Contact/Boeken | `/contact/` |
| Admin (privé) | `/wp-admin/` (geen publieke pagina) |

### 2.2 Redirect mapping (oud → nieuw)
We gaan uit van WordPress trailing slash policy.

| Oude React route | Nieuwe WP route | Type |
|---|---|---|
| `/kinderfeestjes` | `/kinderfeestjes/` | 301 |
| `/festivals` | `/festivals/` | 301 |
| `/glitter` | `/glitter/` | 301 |
| `/galerij` | `/galerij/` | 301 |
| `/cadeaubon` | `/cadeaubon/` | 301 |
| `/contact` | `/contact/` | 301 |
| `/admin` | `/wp-admin/` | 302 (aanrader) |

**Waarom `/admin` → 302?**
- `/wp-admin/` is afhankelijk van login en kan variëren per user. 302 is veiliger en voorkomt dat zoekmachines het als publieke canonical zien.

### 2.3 Redirect implementatie-keuze
Kies 1:
1) **Redirection plugin** (aanrader voor beheer + logging).
2) **Server-level redirects** (nginx/apache), sneller maar minder beheerbaar.

Minimale requirement:
- “no-slash” URLs altijd redirecten naar trailing slash.

Praktisch testje (acceptatie):
- `GET /kinderfeestjes` → 301 → `/kinderfeestjes/`
- `GET /admin` → 302 → `/wp-admin/`

---

## 3) Theme integratie (FectionWP-Pro → child theme)

### 3.1 Waarom child theme
- FectionWP-Pro blijft updatebaar.
- Project-specifieke templates/assets leven in child theme.

**Scaffold locatie (in repo):**
- `FectionWP-Pro (FFP)/child-theme/fectionwp-pro-tffp/`

Let op: voor WordPress deployment moet deze map als eigen theme folder onder `wp-content/themes/` terechtkomen.

Concrete setup-stappen (WP):
1) Activeer het child theme.
2) Maak WP pagina’s aan met slugs uit §2.1 (koppel templates zoals in §4.1).
3) Stel “Homepage” in als static front page (Settings → Reading).

### 3.2 Asset conflicts (Bootstrap vs Tailwind)
We kiezen expliciet voor **Bootstrap latest** (Optie A + C). Daarom:

**Actie:** in child theme:
- **Bootstrap blijft aan** (parent) als basis.
- We voegen een TFFP stylesheet toe met:
  - design tokens (CSS variables) die Bootstrap variabelen overriden
  - custom CSS voor gradients/achtergronden/kleine animaties
- We beperken extra JS tot het minimum (alleen wat echt nodig is op pagina’s).

### 3.3 Build tooling (keuze)
Omdat we Bootstrap-native gaan (A + C) is een Vite build **niet verplicht**.

Aanbevolen (simpel):
- Child theme heeft een eigen `style.css`/`assets/css/tffp.css` met token overrides + custom styles.
- Eventuele page-specifieke JS (bijv. lightbox voor galerij) als losse file(s) in `assets/js/`.

Optioneel (alleen als jullie het fijn vinden):
- Vite gebruiken voor bundling/minify van custom CSS/JS. Maar het migratiepad hangt er niet van af.

### 3.4 Styling migratie: Tailwind → Bootstrap (mogelijkheden)
Ja: dit **kan**, maar “automatisch omzetten” van Tailwind classes naar Bootstrap classes is zelden 1-op-1. Tailwind gebruikt veel design tokens + arbitrary values (en in jullie React ook custom gradients/oklch), terwijl Bootstrap vooral component + utility driven is.

Gekozen aanpak: **Optie A + Optie C**.

Dit betekent concreet:
- We nemen **Bootstrap semantics** overal als basis (grid, spacing, component markup).
- We migreren **jullie design tokens** naar CSS variables en sturen Bootstrap daarmee aan.
- Daarna refactoren we de React/Tailwind markup **volledig** naar Bootstrap component markup.

Kies 1 van onderstaande strategieën (van snelst/laag risico → meest “Bootstrap-native”):

**Optie A — Hybrid (aanrader): Bootstrap layout + eigen CSS tokens**
- Bootstrap blijft de basis (grid, buttons, spacing utilities) voor WordPress pagina’s.
- We migreren Tailwind niet letterlijk, maar vertalen de *design tokens* (kleuren, radii, typografie) naar CSS variables en mappen die naar Bootstrap via overrides.
- Resultaat: Bootstrap “latest” + look/feel zoals React, met beperkt herschrijfwerk.

**Optie B — Utility mapping layer (incrementeel)**
- We maken een kleine “compat” stylesheet waarin we vaak gebruikte Tailwind util classes opnieuw definiëren met Bootstrap-equivalenten of custom CSS.
- Voorbeeld: `.pt-24 { padding-top: 6rem; }`, `.bg-muted\/50 { ... }` etc.
- Dit is geen puristische Bootstrap aanpak, maar laat je snel parity halen en vervolgens per component refactoren naar Bootstrap classes.

**Optie C — Volledige refactor naar Bootstrap componenten**
- Alle JSX/Tailwind markup wordt herschreven naar Bootstrap component markup (`container`, `row`, `col-*`, `card`, `btn`, `badge`, etc.).
- Custom styling (gradients/animations) blijft als extra CSS bovenop Bootstrap.
- Meeste werk, maar “schoonste” Bootstrap uitkomst.

**Optie D — Tailwind behouden en Bootstrap uitschakelen (meest 1-op-1)**
- Als het primaire doel parity is, is dit het snelst: we houden Tailwind build en zetten Bootstrap uit voor deze site.
- Nadeel: minder reuse van FectionWP-Pro Bootstrap componenten.

**Let op bij jullie huidige UI:**
- Veel backgrounds zijn inline `radial-gradient(... oklch(...))` en animaties via framer-motion. Dat blijft sowieso custom (dus niet “Bootstrap-only”).
- Voor het WordPress editor experience (Gutenberg) is Optie A het prettigst: je houdt Bootstrap semantics maar met jullie eigen branding variables.

**Concrete uitvoering (A → C):**
1) **Tokens (A):** definieer TFFP variables en override Bootstrap vars (minimaal):
  - `--bs-primary`, `--bs-link-color`, `--bs-body-color`, `--bs-body-bg`, `--bs-border-radius` (en eventueel `--bs-font-sans-serif`).
2) **Component refactor (C):** per template-part:
  - `container`/`row`/`col-*` voor layout
  - `card`/`btn`/`badge`/`list-group` waar passend
  - custom classes alleen voor unieke gradients/achtergronden.

### 3.5 Bevestigde token-set (bron van waarheid)
Bron: `the-funky-face-paint/src/index.css` (imported na `main.css`).

- `--background: oklch(0.995 0.01 90)`
- `--foreground: oklch(0.25 0.05 290)`
- `--primary: oklch(0.65 0.25 340)`
- `--secondary: oklch(0.6 0.2 290)`
- `--accent: oklch(0.72 0.20 45)`
- `--muted: oklch(0.96 0.01 290)`
- `--border: oklch(0.9 0.02 290)`
- `--radius: 1rem`
- Heading font: `Fredoka`
- Body font: `Inter`

Deze tokens zijn al verwerkt in de child theme scaffold in:
- `child-theme/fectionwp-pro-tffp/assets/css/tffp-tokens.css`

Let op (browser support): `oklch(...)` werkt in moderne browsers. Als er een oudere-support requirement is, voeg dan een fallback palette toe (hex/rgb) in dezelfde vars.

---

## 4) Page & template map (hardcoded-first)

### 4.1 WordPress templates
| React page | React route | WordPress template | WP pagina slug |
|---|---|---|---|
| HomePage | `/` | `front-page.php` | (front page) |
| KinderfeestjesPage | `/kinderfeestjes` | `page-kinderfeestjes.php` | `kinderfeestjes` |
| FestivalsPage | `/festivals` | `page-festivals.php` | `festivals` |
| GlitterPage | `/glitter` | `page-glitter.php` | `glitter` |
| GalleryPage | `/galerij` | `page-galerij.php` | `galerij` |
| CadeaubonPage | `/cadeaubon` | `page-cadeaubon.php` | `cadeaubon` |
| ContactPage | `/contact` | `page-contact.php` | `contact` |
| AdminPage | `/admin` | n.v.t. | n.v.t. |

Template-koppeling (simpel):
- Gebruik WP’s template naming (bv. `page-kinderfeestjes.php`).
- Of maak 1 page template met `/* Template Name: ... */` en wijs die toe in de editor.

### 4.2 Template-parts (component boundaries)
Doel: 1-op-1 markup parity met React component grenzen.

Aanbevolen template-parts:
- `template-parts/tffp/hero.php`
- `template-parts/tffp/stats.php`
- `template-parts/tffp/testimonials.php`
- `template-parts/tffp/locations.php`
- `template-parts/tffp/booking.php`
- `template-parts/tffp/contact.php`
- `template-parts/tffp/gallery.php`
- `template-parts/tffp/whatsapp-fab.php`

---

## 5) Content model: beheerbaar, maar pragmatisch

### 5.1 Fase 1: hardcoded-first
- In elke `template-parts/tffp/*.php` staat de “broncopy” uit React.
- Deze fase is puur voor parity en snelheid.

### 5.2 Fase 2: Gutenberg patterns
Zet de meest wijzigbare secties om naar patterns:
- Hero
- CTA secties
- 2-kolommen card secties
- USP lists

Voordeel: editor-vriendelijk zonder direct custom fields.

### 5.3 Fase 3: ACF (optioneel, alleen waar nodig)
ACF inzetten voor repeaters/datasets:
- Testimonials (repeater)
- Locations (repeater)
- Services/pricing (repeater)
- Contactgegevens (site options)

---

## 6) Booking migratie (React → WordPress-native)

### 6.1 FectionWP-Booking is leidend
We gebruiken de bestaande **FectionWP-Booking** plugin in plaats van een nieuw bookingsysteem bouwen.

Waarom dit beter matcht dan de React-implementatie:
- Server-side opslag via plugin CPTs (`pbp_booking`, `pbp_service`, `pbp_staff`, locaties)
- REST endpoint met nonce + rate limiting + slot/holiday checks
- E-mail templates + reminders + logging
- iCal export + Google/Outlook kalenderlinks
- Admin dashboard (calendar/stats/export)

### 6.2 Front-end integratie (Contact/Boeken pagina)
Op de WordPress pagina `/contact/` embedden we de booking UI via:
- Shortcode: `[pbp_booking_form]` (optioneel `show_payment="yes"|"no"`)
- Of template tag: `pbp_booking_form()`

Belangrijk: de plugin laadt assets **alleen** wanneer de shortcode aanwezig is.
- CSS: `assets/css/style.css` (+ accessibility)
- JS: `assets/js/main.js` (+ payment-plans)
- JS krijgt automatisch `PBP.restUrl` en `PBP.nonce` (voor `fectionwp-booking/v1` calls)

Als de booking form in een custom template-part staat (dus niet in page content), is dit ook oké:
- Render `do_shortcode('[pbp_booking_form]')` in de template.
- Of force-load via de `fectionwp_booking_load_assets` filter (alleen doen als shortcode detectie niet werkt).

### 6.3 Styling van de booking form (past bij A+C)
De plugin injecteert eigen CSS vars (o.a. `--pbp-primary`, `--pbp-radius`) en zet zelfs een root `font-family`.

Aanpak:
1) Zet in WP Admin (Bookings → Style/Customizer) de plugin-styling gelijk aan TFFP tokens (primary kleur, radius, font).
2) Indien nodig: override in child theme met specifiekere selectors (bijv. `body { font-family: ... }`), zodat de booking-form niet de hele site-font “overneemt”.

### 6.4 Feature mapping (React → FectionWP-Booking)
| React veld/gedrag | FectionWP-Booking equivalent | Implementatiekeuze |
|---|---|---|
| Service selectie | `pbp_service` + `_pbp_service_id` | Services aanmaken in plugin admin |
| Datum/tijd + slot check | Availability module + REST `/book` checks | Business hours + slot-increment configureren |
| “Min 2 dagen vooruit” | Availability/min-notice instellingen | Zet min-notice op ~48 uur (of 2 dagen) |
| Notes/opmerkingen | `pbp_notes` | Standaard veld |
| Name/email/phone | `pbp_email`, `pbp_phone`, post_title | Standaard velden |
| Location (React) | Location module of custom field | Start als custom field (select/text), later koppelen aan locaties |
| Guests/aantal | Custom field (number) of Group module | Start custom field, uitbreiden als groepsbookings nodig |
| Admin beheer | Plugin dashboard/admin | Geen aparte `/admin` pagina |
| iCal + Google/Outlook | Plugin iCal REST + calendar URLs | In e-mails + success UI |

### 6.5 Wat we níet meer bouwen
- Geen eigen `tffp_booking` CPT
- Geen eigen booking REST endpoints
- Geen eigen admin lijst/calendar (plugin dekt dit)

---

## 7) Galerij migratie (React placeholders → WP media)

De huidige React galerij is vooral metadata + gradients (geen echte foto’s). In WP willen we echte Media Library.

Aanpak (Fase 1 — simpel en WP-native):
- De Galerij pagina (`/galerij/`) beheert de afbeeldingen via de **pagina-inhoud** (Gutenberg).
  - Voeg in de editor een WordPress **“Galerij” block** toe (Media Library) en publiceer.
  - Het child theme rendert de pagina-inhoud in de Galerij template-part (dus geen hardcoded “foto 1..9” placeholders meer).
- Geen lightbox/filters verplicht in Fase 1 (geen extra JS nodig).

Optioneel (Fase 2+ — beheerbaar met structuur):
- CPT `tffp_gallery_item` of standaard Media + taxonomieën.
- Taxonomie “categorie” (Kinderfeestje/Festival/Fantasy/Glitter Art/Halloween/Seizoenen)
- Taxonomie “doelgroep” (Kinderen/Volwassenen)
- Lightbox en/of filters pas toevoegen als er echt behoefte aan is.

---

## 8) Navigatie, footer, WhatsApp

- Navigatie items matchen huidige React nav:
  - Home, Kinderfeestjes, Festivals & Events, Glitter & Mini Art, Galerij, Cadeaubon, Contact
- WP Admin (setup, éénmalig):
  1) Ga naar **Weergave → Menu’s** (of **Weergave → Editor → Navigatie** afhankelijk van WP setup).
  2) Maak een menu aan (bijv. “Primary”) en voeg bovenstaande pagina’s toe.
  3) Koppel het menu aan de locatie **Primary**.
- WhatsApp CTA:
  - Floating button (FAB) + CTA knoppen op Hero/secties.
  - Phone number + message via WordPress Customizer (theme mods) zodat dit zonder codewijziging te beheren is.

---

## 9) SEO & tracking

- Canonical URLs volgen WP permalinks.
- 301 redirects consistent.
- Title/meta/OG:
  - via SEO plugin (RankMath/Yoast) of minimal theme hooks.
- Sitemap via plugin.
- Check: headings, alt text, focus states.

---

## 10) Performance baseline

- Doel: geen dubbele CSS frameworks.
- JS minimaliseren: alleen laden op pagina’s waar nodig.
- Images: responsive (`srcset`), lazy-load, WebP.

---

## 11) Implementatievolgorde (uitvoerbaar, zonder open eindjes)

### Stap A — Voorbereiding
1. Child theme aanmaken/activeren.
2. TFFP tokens + Bootstrap overrides toevoegen in child theme.
3. WP pagina’s aanmaken + slugs instellen + front page configureren.

Definition of Done:
- Child theme actief, laadt tokens CSS.
- Navigatie kan naar alle pagina’s (desnoods met placeholder templates).

### Stap B — Pagina parity (hardcoded-first)
4. Templates aanmaken per pagina.
5. Template-parts aanmaken per sectie.
6. Bootstrap markup refactor per sectie (Optie C) + custom CSS voor gradients.
7. Galerij vullen: open de WP pagina “Galerij” en voeg een Gutenberg **Galerij** block toe met echte afbeeldingen.

Definition of Done:
- Alle routes uit §2.1 renderen zonder JS errors.
- Visuele parity: layout/typografie/kleuren “close enough” t.o.v. React.

### Stap C — Booking naar WP
7. FectionWP-Booking configureren (services, availability, e-mails).
8. `/contact/` template embed `[pbp_booking_form]` en style afstemmen via tokens/customizer.
9. Booking flow e2e testen (REST booking, bevestigingsmail, iCal/Google/Outlook links).

Definition of Done:
- Booking POST (`fectionwp-booking/v1/book`) werkt met nonce.
- Booking verschijnt in WP admin + status/paid zijn zichtbaar.
- Emails gaan eruit (admin + klant) en bevatten juiste datum/tijd/service.

### Stap D — Beheerbaar maken
10. Gutenberg patterns aanmaken.
11. ACF waar repeaters nodig zijn.

### Stap E — Redirects & livegang
12. Redirects implementeren (plugin of server).
13. QA checklist.
14. Go-live.

Definition of Done:
- Redirects getest (zie §2.3).
- SEO basis ok (canonicals, sitemap via SEO plugin, no soft-404).

---

## 12) QA / Acceptatie checklist

Voor een snelle “wat is af / wat mist nog” afvinklijst, zie `MIGRATION_CHECKLIST_THE_FUNKY_FACE_PAINT.md`.

Functioneel:
- Alle pagina’s renderen zonder JS.
- Booking: validatie, conflicts, opslag, admin, emails.
- Contact: WhatsApp links + mailto/tel.
- Galerij: pagina toont echte afbeeldingen via het Gutenberg Galerij block (lightbox optioneel in fase 2+).

SEO:
- Canonicals correct.
- 301 redirects correct.
- 404’s/soft-404’s weg.

Performance:
- Geen Bootstrap+Tailwind conflict.
- Lighthouse check op home/contact.

Security:
- Booking endpoint rate limited (plugin).
- Nonces + sanitize/escape (plugin + theme overrides).

---

## 13) Pre-flight checklist (vóór content & redirects)

1) **Instellingen → Permalinks**
  - Kies een “pretty permalink” structuur (niet “Plain”).
  - Zorg dat trailing slash gedrag consistent is met §2.
2) **Themes**
  - Child theme “TFFP” actief.
  - Cache legen na theme wissel (page cache + object cache indien aanwezig).
3) **Plugins (minimum)**
  - FectionWP-Booking actief en basisconfig aanwezig (services/availability/email).
  - (Optioneel) SEO plugin gekozen (Yoast/RankMath) of besluit “later”.
4) **Pagina’s & templates**
  - Alle pagina’s uit §2.1 zijn aangemaakt en published.
  - Per pagina het juiste TFFP template geselecteerd.
5) **Test data**
  - Voeg minimaal 1 service toe + availability window, zodat booking testbaar is.
  - Voeg minimaal 6–12 echte foto’s toe in Media Library voor Galerij.
6) **Snelle check**
  - Open Home + Contact + Galerij in incognito: geen 404/redirect loops.

---

## 14) Go-live checklist (WP Admin)

**Content & pagina’s**
1) **Instellingen → Lezen**
  - Zet “Homepage toont” op **Een statische pagina**.
  - Kies de juiste Home pagina als **Homepage**.
2) **Pagina’s → Alle pagina’s**
  - Controleer dat deze pagina’s bestaan en gepubliceerd zijn (slugs exact):
    - `/kinderfeestjes/`, `/festivals/`, `/glitter/`, `/galerij/`, `/cadeaubon/`, `/contact/`
  - Controleer per pagina dat het juiste template actief is (TFFP templates).

**Navigatie**
3) **Weergave → Menu’s** (of Site Editor → Navigation)
  - Maak/controleer menu “Primary” met: Home, Kinderfeestjes, Festivals, Glitter, Galerij, Cadeaubon, Contact.
  - Koppel dit menu aan locatie **Primary**.

**Galerij (zonder extra JS)**
4) Open pagina **Galerij** en voeg een Gutenberg **Galerij** block toe met echte afbeeldingen uit de Media Library.

**Contact & WhatsApp (Customizer)**
5) **Weergave → Customizer**
  - Vul WhatsApp nummer (digits-only), standaard berichttekst, contact e-mail en telefoon.
  - Verifieer dat de WhatsApp FAB en het WhatsApp contactformulier werken.

**Booking (plugin)**
6) **Bookings/Booking Settings** (FectionWP-Booking)
  - Services: prijs (centen), duur (minuten), actief.
  - Availability: openingstijden, slot increments, min-notice (bv. 48 uur) en holidays.
  - Email: afzender/onderwerp, confirmaties aan/uit.
7) Test een booking end-to-end op `/contact/`.

**Redirects & SEO (minimum)**
8) Zet redirects aan (server of plugin) voor no-slash → trailing slash (zie §2.3).
9) Controleer met een paar requests:
  - `/kinderfeestjes` → 301 → `/kinderfeestjes/`
  - `/contact` → 301 → `/contact/`
  - `/admin` → 302 → `/wp-admin/`
10) Als er een SEO plugin is: check sitemap + titles/OG defaults.

---

## Open punten (moeten we vóór start finaliseren)
1) Welke plugin-keuze voor “beheerbaar”: alleen Gutenberg patterns, of ACF beschikbaar/licentie?
2) Waar moeten bookings terecht: alleen WP admin, of ook export/mail notificaties naar meerdere adressen?
3) Definitieve WhatsApp nummer/berichttekst (nu staat voorbeeldnummer in React).
