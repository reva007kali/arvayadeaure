I will implement the **Dress Code** feature along with the **Advanced Tier & Expiration System** as requested.

### 1. Database & Model Updates
*   **Migration**: Create a migration to add:
    *   `dress_code_data` (JSON) for storing style guidelines, palette, and settings.
    *   `expires_at` (Timestamp) to handle the active duration logic.
*   **`Invitation` Model**:
    *   Update `PACKAGES` constant to include **Basic**, **Premium**, and **Exclusive** tiers with specific limitations:
        *   **Basic**: Active 3 months. No Dress Code, GuestBook, RSVP.
        *   **Premium**: Active 6 months. Full features.
        *   **Exclusive**: Active forever. Full features.
    *   Implement `hasFeature($feature)` logic to gate access based on the selected tier.

### 2. Dashboard Editor (`Edit.php` & Views)
*   **Feature Gating**: Update the editor to lock/hide tabs (Dress Code, RSVP, GuestBook) if the user is on the **Basic** tier.
*   **Section Toggles**: Add "Enable/Disable" switches to **ALL** major sections (Events, Gallery, Gifts, Dress Code, etc.) to give users full control.
*   **Dress Code Tab**:
    *   Implement the full UI: Description, Color Palette Picker, Image Upload, and Notes.
*   **Expiration Logic**: Update the `save()` method to calculate and set the `expires_at` date based on the selected tier (e.g., `now() + 6 months` for Premium).

### 3. Frontend Templates (`neobrutalism` & `redcreamromantic`)
*   **Conditional Rendering**: Wrap all sections (RSVP, GuestBook, Dress Code, etc.) in checks that verify both:
    1.  **Tier Permission**: Does the package allow this feature?
    2.  **User Setting**: Has the user enabled this section?
*   **Dress Code Section**:
    *   **Neobrutalism**: "DRESS_CODE.TXT" style with raw color blocks.
    *   **RedCreamRomantic**: Elegant script typography with soft color circles.

This plan delivers the requested Dress Code feature while restructuring the system to support the new Tier and Expiration requirements.