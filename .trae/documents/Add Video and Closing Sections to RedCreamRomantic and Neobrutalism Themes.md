## Goals
- Add a YouTube Video section and a Closing/Thank You message section to two themes:
  - `neobrutalism.blade.php` → add Closing (video already exists)
  - `redcreamromantic.blade.php` → add Video + Closing
- Respect each theme’s visual style and use existing data in `invitation.theme_config`.

## Data Sources
- Video: `theme_config['video_enabled']` (default true) and `theme_config['video_url']` (YouTube watch/embed URL). Extract `v` param to embed.
- Closing message: `theme_config['thank_you_message']` fallback to a default polite message.

## Neobrutalism (Closing Section)
- Insert after Gifts section and before footer.
- Style: neobrutalist cards (thick borders, drop-shadows, bright accent colors). Content:
  - Title (e.g., THANK YOU) in the theme’s bold style.
  - Body text uses `thank_you_message` or default.
  - Names of couple displayed prominently.

## RedCreamRomantic (Video + Closing)
- Insert Video section near the gallery or before closing content.
- Style: soft cream background (`#FFFBF2`), theme accent color (`primary_color`), rounded corners and elegant typography.
- Video block:
  - Use `video_enabled` + extracted `videoId` to render `<iframe>` in `aspect-video` container.
  - Heading “Our Story” in script serif combination.
- Closing block:
  - Elegant centered message using `thank_you_message`.
  - Couple names in `font-title` with theme accent.

## Implementation Outline
1. Neobrutalism: add a new Blade section guarded by `thank_you_message` fallback.
2. RedCreamRomantic: add two new Blade sections: Video (guarded by `video_enabled` && `videoId`) and Closing.
3. Use existing assets and fonts already loaded by each theme.
4. Keep all code strictly within the two Blade files; no controller/model changes.

## Verification
- Load invitations with/without `video_url` and see conditional rendering.
- Confirm closing text shows the custom message if present.
- Confirm styles align with the theme and do not break layout.

If approved, I will implement these sections in the two theme Blade files with theme-consistent styling and data guards, then test with sample data.