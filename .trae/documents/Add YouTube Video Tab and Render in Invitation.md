## Goals
- Add a dedicated Video tab in the invitation editor with a YouTube URL field.
- Add a tile in the editor’s grid menu to open the Video tab.
- Persist video configuration inside `theme_config` and render the video on invitation pages.

## Data Model & Validation
- Store settings under `theme_config`:
  - `video_enabled: boolean` (default: true)
  - `video_url: string` (YouTube watch/embed URL)
- Validation in Livewire `Edit.php`:
  - `theme.video_url`: `nullable|string|url|max:255`

## Editor UI Changes
- Update `resources/views/livewire/dashboard/invitation/edit.blade.php`:
  - Add a new menu item `video` with icon `fa-video` next to `music`.
  - Wire the menu to `openModal('video')`.
- Create `resources/views/livewire/dashboard/invitation/partials/tabs/video.blade.php`:
  - Header with toggle: `($theme['video_enabled'] ?? true)` using `$toggle('theme.video_enabled')`.
  - Single input for YouTube URL with helper text and validation error output.
  - Use consistent styles as `music.blade.php`; add `aria-label` and short guidance.

## Livewire Component Updates (`Edit.php`)
- Defaults in `loadInvitationData()`:
  - Merge `['video_enabled' => true, 'video_url' => '']` into `$this->theme`.
- Rules in `rules()`:
  - Add `'theme.video_url' => 'nullable|string|url|max:255'`.
- Save flow: No special processing; ensure `theme_config` writes `video_enabled` and `video_url`.

## Theme Rendering
- In each theme (or start with `resources/views/components/themes/royal-luxury.blade.php`):
  - Add an optional section that displays the embedded YouTube player if `($invitation->theme_config['video_enabled'] ?? true)` and a valid `video_url` exist.
  - Use existing Alpine `youtubePlayer` from `resources/js/app.js` to render a responsive player box (16:9 aspect).
  - Place the section in a sensible location (e.g., after gallery or before footer) with existing brand styles.

## Accessibility & UX
- Inputs include `aria-label` and helper text.
- Toggle uses safe defaults to avoid undefined index errors.
- Ensure responsive layout: 1-column mobile, centered on desktop.

## Testing & Verification
- Enter a valid YouTube URL; preview invitation shows the video section.
- Toggle OFF hides the video section.
- Run through Livewire interactions to ensure no errors and data persists.

## Files To Touch
- `app/Livewire/Dashboard/Invitation/Edit.php`
- `resources/views/livewire/dashboard/invitation/edit.blade.php`
- `resources/views/livewire/dashboard/invitation/partials/tabs/video.blade.php` (new)
- `resources/views/components/themes/*` (start with `royal-luxury.blade.php`) to conditionally display the video.

I will implement the Livewire data default, validation, new tab partial, add the menu tile, and render the section in the selected theme, using the existing Alpine player.