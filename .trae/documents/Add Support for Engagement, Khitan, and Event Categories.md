I will extend the Invitation Editor to support **Engagement**, **Khitan**, and **Event** categories, in addition to the existing Wedding, Birthday, and Aqiqah.

**Plan:**

1.  **Update `Edit.php` (Logic & Data):**
    *   **Engagement:** Will reuse the `Wedding` data structure (`groom`/`bride`) but validation rules will be identical.
    *   **Khitan:** Will reuse the `Aqiqah` data structure (`child_name`, `parents`).
    *   **Event:** Will use a generic structure (`title`, `host`, `description`).
    *   **Validation:** Update `rules()` to cover these new categories.

2.  **Update `edit.blade.php` (View & Forms):**
    *   **Tabs & Labels:** Update the dynamic label logic:
        *   **Engagement:** "Pasangan" / "Couple"
        *   **Khitan:** "Data Anak"
        *   **Event:** "Detail Acara"
    *   **Form Logic:**
        *   **Engagement:** Reuse the **Wedding** form layout. I will adjust the `foreach` loop to handle labels dynamically (e.g., "Calon Mempelai Pria" for Engagement).
        *   **Khitan:** Reuse the **Aqiqah** form layout.
        *   **Event:** Use the **Generic** form layout (Title, Description).

3.  **Update `manage-templates.blade.php` (Optional but recommended):**
    *   Add "Event" to the dropdown list if it's not already covered by "Other".

I will ensure that selecting any of these categories in the admin panel correctly changes the editor interface.