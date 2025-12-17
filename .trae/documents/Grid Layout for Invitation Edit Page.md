## Overview
- Convert `resources/views/livewire/dashboard/invitation/edit.blade.php` into a responsive, app-like grid while preserving all Livewire bindings and behaviors.
- Use existing Tailwind CSS utilities and Font Awesome icons already included in the layout.
- No backend or component logic changes; purely structural/styling updates in the Blade view.

## Files to Modify
- `resources/views/livewire/dashboard/invitation/edit.blade.php` (primary)
- No changes to `app/Livewire/Dashboard/Invitation/Edit.php` or `resources/views/components/layouts/app.blade.php`.

## Grid Structure
- Wrap page content in a responsive grid container:
  - `grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4`
- Convert each major section into a tile card:
  - Cover & Gallery
  - Couple Information (Groom/Bride)
  - Events
  - Moments
  - Theme & Music
  - Gifts
- Tile pattern:
  - Container: `rounded-xl shadow-sm bg-white/80 dark:bg-neutral-900 p-4 relative`
  - Header row with icon + title using Font Awesome
  - Content area retains the existing form fields and `wire:model` bindings
  - Footer actions (e.g., Save, Add) remain within each tile and maintain `wire:click` + `wire:loading` behaviors
- Responsive tweaks:
  - Use `col-span-2` for wide tiles (e.g., Events or Cover/Gallery) on small screens
  - Keep inputs full-width within tiles; avoid horizontal scroll

## Styling & Icons
- Tailwind utilities only (already in `resources/css/app.css`): spacing, typography, colors, grid, shadow, rounded.
- Icons: use Font Awesome (`<i class="fa-solid fa-image">`, `fa-user`, `fa-calendar`, `fa-photo-film`, `fa-palette`, `fa-gift`).
- Respect existing color palette (e.g., `text-[#B89760]`) when present.

## Livewire Compatibility
- Preserve all `wire:model`, nested models, and array bindings (e.g., `events.{index}.*`, `gifts.{index}.*`).
- Keep `wire:click` actions (`save`, `addEvent`, `removeEvent`, `generateQuote`, `removeMoment`, `addGift`, etc.).
- Maintain `wire:loading`/`wire:target` spinners inside tile containers; use `relative` + overlay when necessary.
- Do not alter `wire:navigate` links in the layout.

## Accessibility
- Use descriptive headings inside tiles and keep label associations (`for` + `id`) intact.
- Ensure focus states are visible and keyboard navigation flows linearly across tiles.
- Maintain ARIA roles/labels where currently used.

## Verification
- Visual check at `/dashboard/{invitation}/edit`:
  - Tiles render in a 2/3/4-column responsive grid
  - All forms and actions still work; loading states show correctly
  - Mobile viewport shows app-like grid with consistent tap targets
- Browser testing on mobile emulation and desktop breakpoints; confirm no overflow and proper wrapping.

## Deliverables
- Updated `edit.blade.php` with grid-based tile layout, retaining all Livewire behaviors and existing styles.
- No changes to routes, components, or assets. Ready for user review after implementation.