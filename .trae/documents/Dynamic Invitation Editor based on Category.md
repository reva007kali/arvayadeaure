I will refactor the invitation editor to dynamically adapt based on the template's category (Wedding, Birthday, Aqiqah, etc.).

**Plan:**

1.  **Update Livewire Component (`app/Livewire/Dashboard/Invitation/Edit.php`):**
    *   Add a `$category` property to the component.
    *   In the `mount` method, fetch the category from the related `Template` and assign it to `$category`. Default to 'Wedding' if not found.
    *   Update the `loadInvitationData()` method to initialize default data structures appropriate for the category.
        *   If `Birthday`: Initialize `profile` (name, age, photo) instead of `groom`/`bride`.
        *   If `Aqiqah`: Initialize `child` (name, birth date, parents).
    *   Update `rules()` to dynamically validate fields based on `$category`.

2.  **Refactor View (`resources/views/livewire/dashboard/invitation/edit.blade.php`):**
    *   **Dynamic Tabs:** Rename the "Mempelai" (Couple) tab dynamically based on category:
        *   Wedding: "Mempelai"
        *   Birthday: "Profil Yang Ulang Tahun"
        *   Aqiqah: "Data Anak"
        *   Other: "Profil Utama"
    *   **Dynamic Content:** Inside the Profile tab, use `@if($category == 'Wedding')` blocks to show the Groom/Bride form.
        *   Add `@elseif($category == 'Birthday')` block for Birthday inputs (Name, Age/Date of Birth, Parents, Photo).
        *   Add `@elseif($category == 'Aqiqah')` block for Aqiqah inputs (Child Name, Date of Birth, Parents, Photo).
    *   **Dynamic Quote Tab:** Rename "Kata Pengantar" tab if necessary (e.g., "Doa/Ucapan" for Aqiqah).

3.  **Data Persistence:**
    *   I will reuse the `couple_data` JSON column in the database but structure the keys differently for non-wedding categories to avoid database migrations.
        *   Wedding: `['groom' => ..., 'bride' => ...]`
        *   Birthday: `['name' => ..., 'age' => ..., 'parents' => ...]`
    *   This ensures backward compatibility and simplicity.

I will verify that the editor correctly switches forms when a template with a different category is selected.