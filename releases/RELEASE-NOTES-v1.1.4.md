# Release Notes — v1.1.4

Released: 2026-01-07

## Fixes
- **TFFP child theme** now renders the parent Customizer Hero (including the new Carousel Hero), so changing **Hero type** actually affects the frontend.
- The **Hero widget area** is now used only as a fallback (when the Customizer Hero is disabled), matching parent theme behavior.

## Impact
- If you previously had widgets in the `hero` sidebar while also expecting the Customizer hero to appear, the Customizer hero can now show as intended.
