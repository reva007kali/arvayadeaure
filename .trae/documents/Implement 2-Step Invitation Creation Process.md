I will implement a **2-Step Creation Process** for invitations:

**Step 1: Choose Template**
*   **Filter by Category:** A clean UI to filter templates (All, Wedding, Birthday, etc.).
*   **Template Grid:** Display available templates. Clicking one selects it and proceeds to Step 2.

**Step 2: Fill Details**
*   **Dynamic Form:** The form fields will adapt based on the *Category* of the selected template.
    *   **Wedding/Engagement:** Groom Name, Bride Name, Date.
    *   **Birthday:** Name, Age, Date.
    *   **Aqiqah/Khitan:** Child Name, Date.
    *   **Event:** Title, Organizer, Date.
*   **Save & Redirect:** Creates the invitation with the correct initial data structure and redirects to the editor.

**Implementation Plan:**

1.  **Update `Create.php` (Livewire):**
    *   Add `$step = 1` property to track progress.
    *   Add `$selectedTemplate` and `$selectedCategory` properties.
    *   Add `selectTemplate($slug)` method to fetch template details, set `$step = 2`, and initialize form fields.
    *   Update `rules()` to be dynamic based on `$selectedCategory`.
    *   Update `save()` to construct the correct JSON data structure (e.g., `couple_data`) based on the category.

2.  **Update `create.blade.php` (View):**
    *   **Step 1 Section:**
        *   Category Filter Buttons (Wedding, Birthday, etc.).
        *   Grid of templates (using `App\Models\Template`).
    *   **Step 2 Section:**
        *   Show "Selected Template" summary.
        *   Dynamic input fields that change based on `$selectedCategory`.

3.  **Refine Logic:**
    *   Ensure the `slug` (URL) generation is still handled correctly.
    *   Ensure `loadTemplates` logic is present to show the grid in Step 1.

I will verify that the flow works smoothly from selection to creation to editing.