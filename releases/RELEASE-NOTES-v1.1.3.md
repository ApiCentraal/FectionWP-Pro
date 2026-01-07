# Release Notes — v1.1.3

Released: 2026-01-07

## Highlights
- New **Hero Carrousel** option based on Bootstrap 5.3 carousel example.
- Selectable globally in the Customizer and overridable per page/post.

## What’s new
### Customizer
- Added **Hero type** (`Standaard` / `Carrousel (Bootstrap)`).
- Added global default carousel slide settings (1–3): image, title, text, button (text/url/style).

### Per page/post
- Meta box **Hero Sectie Instellingen** now supports:
  - Hero type override: inherit / standard / carousel / disabled
  - Optional per-page carousel slides via JSON (fallbacks to global Customizer slides)

### Developer hook
- Existing hook `fwp_render_hero_in_header` (contexts: `default`, `landing`) still applies.

## Notes
- For per-page slides JSON, you can use e.g.:
  ```json
  [
    {
      "image_url": "https://example.com/slide1.jpg",
      "heading": "Titel",
      "text": "Tekst",
      "btn_text": "Boek nu",
      "btn_url": "https://example.com/boeken",
      "btn_style": "primary"
    }
  ]
  ```
