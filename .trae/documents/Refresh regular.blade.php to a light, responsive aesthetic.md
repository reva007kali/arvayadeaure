## Overview
We will redesign `resources/views/components/themes/regular.blade.php` to a clean, light aesthetic using your existing Tailwind v4 stack (Vite + `@tailwindcss/vite`, `resources/css/app.css`). The structure stays intact (hero, quote, profiles, event details, gallery, gifts, RSVP, footer) while colors, spacing, typography, and interactions shift to a refined light theme.

## Key Changes
1. Palette & Typography
- Switch base background to soft ivory/white with warm gold accents; use subtle grays for text.
- Keep current fonts (Cinzel, Great Vibes, Raleway) and refine sizes/weights for readability.
- Replace dark noise with an ultra-light texture for depth without heaviness.

2. Hero
- Light gradient overlay over the cover image, increased contrast for text on light.
- Maintain gold gradient headings; balance script and serif; improve vertical rhythm.
- Make height responsive (`min-h-screen`) and reduce fixed values for small screens.

3. Loading Overlay
- Light theme version of the monogram loader: ivory background, gold lines, softer transition.
- Keep button interaction; add `aria-label` and consistent focus states.

4. Sections
- Quote: light card with gold divider and improved typographic scale.
- Profiles: lighten frames/backgrounds, soften shadows, add alt attributes and `loading="lazy"`.
- Event Details: light “golden ticket” card; refine dividers; readable date/time/venue.
- Gallery: keep masonry, add `loading="lazy"` and `decoding="async"`; tone down hover effects on light.
- Gifts: light card design with gold accent border; replace alert copy feedback with subtle visual confirmation.
- RSVP & Wishes: light form styling via Tailwind utilities; accessible labels, focus states; retain Livewire components.
- Footer: minimalist light footer with brand signature.

5. Responsiveness
- Audit all fixed heights; prefer `min-h`, intrinsic sizing, and responsive grids.
- Use Tailwind breakpoints (`md`, `lg`) already present; tighten mobile spacing.
- Ensure touch targets are large enough and interactive elements are keyboard accessible.

6. Accessibility & Performance
- Add descriptive `alt` text to images; ensure sufficient color contrast.
- Use `loading="lazy"` and `decoding="async"` on non-critical images.
- Avoid heavy animations on mobile; reduce motion for prefers-reduced-motion.

7. File & Naming
- Keep filename `regular.blade.php` and update its content only; confirm and preserve all references to this view.
- No changes to Livewire/Alpine component names or routes.

## Implementation Steps
1. Update the `<style>` block to light variables (colors, textures, scrollbar) and remove dark-only rules.
2. Refactor hero overlay, text colors, and spacing for light mode.
3. Adjust each section’s container/background/borders/shadows to the light palette.
4. Add `alt`, `loading`, `decoding` attributes to images and `aria-*` for buttons.
5. Review interactions (copy-to-clipboard, music player) for visual feedback on light.
6. Run the dev server, visually verify across breakpoints, and fix any regressions.

## Verification
- Start the dev server and preview the invitation with sample data; check mobile/desktop.
- Validate no console errors, and ensure countdown, Livewire forms, and gallery behave correctly.
- Confirm performance with network throttling and accessibility with keyboard and screen-reader basics.

If you approve, I’ll implement the redesign in `components/themes/regular.blade.php` and share the changes in a single patch for your review.