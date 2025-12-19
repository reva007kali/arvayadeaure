I will revamp the `couple_quote` section of the editor to be more interactive and guided, while preserving the existing data structure and manual editing capabilities.

**Plan:**

1.  **Redesign the UI (`edit.blade.php` - `couple_quote` tab):**
    *   Instead of showing all select boxes at once, I will implement a step-by-step "Wizard" or "Guided" feel.
    *   **Step 1: Choose Goal:** "What kind of message do you want?" (e.g., Islamic Prayer, Modern Quote, Bible Verse, Manual Entry).
    *   **Step 2: Customize:** Based on the choice, show relevant options (Tone, Language, Preset Verses).
    *   **Step 3: Generate/Preview:** Show the AI generation button or the manual text area.
    *   **Result Area:** Show the generated/selected quote with a "Use This" or "Edit Manually" option.

2.  **Update Logic (`Edit.php`):**
    *   Add a new property `$quoteWizardStep` to track the user's progress in the guided flow.
    *   Ensure the existing `generateQuote`, `composeManualQuote`, etc., work seamlessly with this new flow.

**Detailed UI Flow:**
*   **Initial View:** 3 Big Cards: "Islamic Prayer", "Christian Verse", "Modern/General Quote". Plus a "Write Manually" link.
*   **Selection:** Clicking a card sets `$aiContentMode` and advances to customization.
*   **Customization:**
    *   If Islamic: Show "Quran Preset" dropdown or "Tone" (Doa, Syukur).
    *   If Christian: Show "Bible Verse" presets or "Tone".
    *   If Modern: Show "Tone" (Romantic, Poetic, Funny).
*   **Action:** "Generate with AI" button.
*   **Result:** Display the result. Provide a button to "Edit Manually" which reveals the raw textareas (the existing manual editor).

This approach makes the AI feature feel like a helpful assistant rather than a form to fill out.