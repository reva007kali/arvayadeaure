I will implement the public Template Showcase features.

**Plan:**

1.  **Create Template Showcase Page (`resources/views/templates/index.blade.php`):**
    *   This page will be the public gallery of all templates.
    *   **Features:**
        *   **Search Box:** Input to filter templates by name.
        *   **Category Filter:** Buttons or dropdown for Wedding, Birthday, etc.
        *   **Tier Filter:** Checkboxes or buttons for Basic, Premium, Exclusive.
        *   **Grid Display:** Show templates with thumbnails, names, categories, tiers, and prices.
    *   **Livewire Component (`app/Livewire/Frontend/TemplateShowcase.php`):**
        *   I will use Livewire to make the filtering and searching dynamic (instant updates without page reload).
        *   Properties: `$search`, `$category`, `$tier`.
        *   Method: `render()` with filtered query.

2.  **Update Landing Page (`welcome.blade.php`):**
    *   Modify the "Themes" section (#themes) to showcase a few featured templates dynamically (or static featured ones).
    *   Change the "Lihat Contoh" / "Coba Tema" buttons to link to the new `route('templates.index')`.

3.  **Define Routes (`routes/web.php`):**
    *   Add `Route::get('/templates', App\Livewire\Frontend\TemplateShowcase::class)->name('templates.index');`

4.  **Implementation Detail:**
    *   I will reuse the style of the landing page (navbar, footer) for the templates page to maintain consistency.

I will verify that searching "Wedding" shows wedding templates and clicking a template could potentially link to a preview or the register/login page to use it.