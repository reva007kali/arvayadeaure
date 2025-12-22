## Objectives
- Unify and modernize the UI for all invitation editor tabs.
- Make forms highly usable and responsive across mobile, tablet, and desktop.
- Provide clear labels, helper text, validation feedback, and consistent interactions.

## Design Principles
- Consistent section headers with subtitle and optional actions.
- Mobile-first responsive grids (1→2→4 columns with sensible breakpoints).
- Standard spacing: 8/12/16 px scale; avoid cramped layouts.
- Clear input semantics: visible labels, placeholders for examples, helper text, and inline validation.
- Accessible focus rings, ARIA attributes, and keyboard-friendly controls.

## Global Form UX Improvements
- Labels: always visible, small uppercase, bold (existing style preserved).
- Helper text: short guidance below labels where needed (e.g., examples for date/time).
- Validation: show `@error` messages inline under fields, consistent red styling.
- Group actions: primary “Simpan Perubahan” visible and sticky within the modal when applicable.
- Toggles: unify appearance and behavior (`$toggle`) and default states, including feature-gating messages.

## Tabs To Update (Files)
- `partials/tabs/bio.blade.php` + `partials/forms/*` (wedding, birthday, aqiqah, event, general)
  - Unify grids (name fields side-by-side on md+, stack on mobile).
  - Add helper texts for nicknames vs full names; Instagram handles.
  - Improve date inputs with placeholders and examples.
  - Standardize spacing and borders.
- `partials/tabs/events.blade.php`
  - Header with toggle retains; ensure `events_enabled` safe default.
  - Use a 1→2 grid for event fields; align timezone selector; add helper text for map link.
  - Standardize delete buttons and icons; ensure consistent gap and focus states.
- `partials/tabs/gallery.blade.php`
  - Improve upload cards with clearer empty states and max-size helper.
  - Maintain progress overlay and sorting; ensure responsive thumbnails.
  - Align delete and reorder controls spacing, keyboard focusable.
- `partials/tabs/gifts.blade.php`
  - Card layout stays; unify toggle and field spacing, add helper text for bank/e-wallet.
  - Validate numeric input styling; ensure consistent label sizes and error placement.
- `partials/tabs/music.blade.php`
  - Keep single input; add helper text about supported links and autoplay; clear success indicator.
- `partials/tabs/quote.blade.php`
  - Keep current two-mode (preview/edit); refine spacing and headings; ensure textarea line-heights.
- `partials/tabs/theme.blade.php`
  - Template grid spacing and hover states consistent; search input with loading state.
  - Tidy badges for tiers and price footer; responsive adjustments.
- `partials/tabs/dress-code.blade.php`
  - Standardize toggle; color pickers aligned in responsive grid; helper text; image upload preview consistent.

## Accessibility
- Add `aria-label`/`aria-describedby` for inputs with helper text.
- Ensure buttons have discernible labels; icons accompanied by text where needed.
- Maintain focus-visible rings on interactive elements.

## Responsive Behavior
- Use Tailwind responsive classes to adapt grids (e.g., `grid-cols-1 md:grid-cols-2`)
- Avoid horizontal overflows; ensure long text wraps and containers have `min-w-0`.

## Livewire Integration Safety
- Keep `wire:model` bindings as-is; only adjust markup and classes.
- Preserve `$toggle` and `wire:click` actions.
- Avoid caching dynamic POST endpoints (already handled in SW).

## Validation & Feedback
- Use `@error` blocks under each field.
- Success toast remains via `x-notification-toast`; ensure consistent placement.

## Rollout & QA
- Update the tab blades iteratively, test on mobile and desktop.
- Verify no bindings were broken; run through typical user flows.
- Optional follow-up: small reusable Blade partials for form groups if needed (kept minimal to honor existing file structure).

If approved, I will implement the layout and UX refinements across all tab blades in one pass, keeping your existing styles and component patterns while making the forms cohesive and responsive.