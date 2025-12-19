I will replace the existing static themes showcase with a **Swiper.js** slider.

**Plan:**

1.  **Add Swiper.js Dependencies:**
    *   Include Swiper CSS and JS from CDN in the `<head>` and before `</body>`.

2.  **Update Themes Section (`#themes`):**
    *   Replace the current "Image Stack" static layout with a Swiper container.
    *   **Layout Change:**
        *   Left Side: Text content (Title, description, list) - *Keep as is*.
        *   Right Side: Swiper Slider showing template mockups.
    *   **Swiper Configuration:**
        *   Effect: 'cards' or 'coverflow' to give it a premium 3D look suitable for invitations.
        *   Autoplay: Yes, to attract attention.
        *   Images: Use placeholders or the existing `img1.png`, `img2.png` repeatedly for demo.

3.  **Implementation Details:**
    *   `swiper-container`
    *   `swiper-wrapper`
    *   `swiper-slide` (containing the template images)
    *   Initialize Swiper in the `<script>` section.

I will ensure the design matches the "Arvaya" premium aesthetic (Gold/Dark theme).