I will add a `category` selection field to the Admin Manage Templates feature, allowing you to categorize templates (Wedding, Birthday, Aqiqah, etc.).

**Plan:**
1.  **Update Livewire Component (`app/Livewire/Admin/ManageTemplates.php`):**
    *   Add `public $category;` property.
    *   Update `rules()` to validate `category` (nullable or required, likely required based on your request).
    *   Update `save()` method to include `category` in the create/update data.
    *   Update `edit()` method to load the existing `category` from the database.
    *   Update `openModal()` (reset) method to clear the `category` field.

2.  **Update View (`resources/views/livewire/admin/manage-templates.blade.php`):**
    *   Add a new `<select>` input field in the modal form for "Category".
    *   Populate the options with: Wedding, Birthday, Aqiqah, and "Other".

**Note:** Since the `Template` model uses `guarded = []`, the new field will automatically be mass-assignable, so no model changes are needed assuming the database column exists (which implies from your prompt "i have category column").

I will verify the changes by checking if the field appears and saves correctly.