I will implement the requested drag-and-drop gallery functionality and category-specific upload sections in `resources/views/livewire/dashboard/invitation/partials/tabs/gallery.blade.php`.

### Plan Details

1.  **Dynamic Photo Upload Sections**:
    *   I will replace the hardcoded `['cover', 'groom', 'bride']` loop with dynamic logic based on the `$category` variable (Wedding, Birthday, Aqiqah, etc.).
    *   **Wedding/Engagement**: Shows Cover, Groom, Bride.
    *   **Birthday**: Shows Cover, Profile Photo.
    *   **Aqiqah/Khitan**: Shows Cover, Child Photo.
    *   **Event/General**: Shows Cover, Main Photo.

2.  **Drag & Drop Reordering (Desktop & Mobile)**:
    *   I will include **SortableJS** via CDN to handle the drag-and-drop logic robustly.
    *   I will implement an **Alpine.js** component to initialize SortableJS on the gallery container.
    *   **Configuration**:
        *   `animation: 150`: Smooth animation when moving items.
        *   `delay: 2000`: 2-second hold delay for mobile devices (as requested) to prevent accidental drags while scrolling.
        *   `delayOnTouchOnly: true`: Instant drag on desktop, delayed on mobile.
        *   `ghostClass`: A custom CSS class to create a "placeholder" effect (dashed border, semi-transparent) indicating where the item will be dropped.
    *   **Backend Integration**: The `onEnd` event will trigger the existing `$wire.reorderMoments()` method with the new order of indices.

3.  **UI/UX Improvements**:
    *   I will add a visual "Grab" cursor for desktop.
    *   I will add a helper text indicating "Hold to reorder" on mobile.
    *   The design will be clean and minimalist, removing the manual Up/Down buttons to reduce clutter, relying on the intuitive drag-and-drop interface.

### Files to Modify
*   `resources/views/livewire/dashboard/invitation/partials/tabs/gallery.blade.php`

No other files need modification as the backend logic in `Edit.php` already supports reordering by index.