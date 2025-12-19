I will transform the Quote Generator into an interactive AI Chat interface as requested.

**1. Update `OpenAIService.php`**
*   Create a new method `chatQuoteGenerator($message, $history)` specifically for this feature.
*   **System Prompt Strategy**: The AI will be instructed to be a "Creative Wedding Assistant" capable of various styles (Islamic, Gen Z, Poetry, etc.).
*   **Data Structure**: To ensure the generated quotes (especially Quran/Bible verses) are formatted correctly in your invitation, I will instruct the AI to append a hidden JSON block (e.g., `|||JSON_DATA|||`) to its responses when it provides a concrete suggestion. This allows the system to capture Arabic text, translations, and sources accurately.

**2. Update `Edit.php` (Livewire Controller)**
*   Remove the "Wizard Step" logic (`$quoteWizardStep`, `$quoteWizardStyle`).
*   Add Chat Logic:
    *   `$chatMessages`: Stores the conversation history.
    *   `$chatInput`: Captures user input.
    *   `sendChatMessage()`: Sends input to the new AI service and updates the chat.
    *   `applyQuoteFromChat($messageIndex)`: Logic to parse the selected AI response (extracting the hidden JSON or using the raw text) and apply it to the Invitation data.

**3. Update `edit.blade.php` (View)**
*   **Replace the Wizard UI** with a modern **Chat Interface**:
    *   **Chat Window**: Scrollable area showing the conversation.
    *   **Assistant Bubbles**: Will have a **"Gunakan Ini" (Use This)** button. Clicking this instantly applies the quote to the invitation preview.
    *   **Input Area**: Text field for you to chat (e.g., "Buatkan pantun lucu", "Ayat tentang jodoh").
*   **Preview Area**: Remains available so you can see the applied result immediately and edit it manually if needed.

**Outcome**:
Users will see a chat window where the AI greets them ("Mau quotes seperti apa?"). They can type anything ("Versi Gen Z dong", "Yang Islami tapi singkat"). The AI replies, and the user picks the best one by clicking "Use This".