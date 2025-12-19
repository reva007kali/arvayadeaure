I will modify the User Interface to create a "Quote Page" experience with a vertical flow and auto-scroll interaction, while maintaining the existing logic.

**1. Livewire Controller (`Edit.php`)**
*   **URL State**: Add `activeTab` to the `$queryString` so the URL updates (e.g., `?tab=couple_quote`). This gives the feeling of "going to a page" and allows bookmarking/refreshing.
*   **Event Dispatch**: In `applyQuoteFromChat()`, dispatch a browser event `scroll-to-result` to trigger the smooth scrolling.

**2. Blade View (`edit.blade.php`)**
*   **Full Screen Mode**: Update the Modal Container styling. If the active tab is `couple_quote`, the modal will expand to **full screen** (removing margins and rounded corners), effectively acting as a dedicated page.
*   **Vertical Layout**:
    *   **Chat Section (Top)**: Occupies the upper part of the screen.
    *   **Result Section (Bottom)**: Placed directly below the chat.
    *   **Scroll Behavior**: Add a JavaScript listener to scroll the page down to the Result Section when the "Use This" button is clicked.

**User Experience Improvement:**
*   Users click "Kata Pengantar" -> The interface transforms into a full-page Quote Studio.
*   They chat with Arvaya.
*   They click "Gunakan Ini".
*   The page smoothly scrolls down to reveal the generated Quote Card ready for review.

This approach meets the requirement "go to quotes page" (via URL and full-screen UI) and "scroll directly to result" without needing a complex backend refactor.