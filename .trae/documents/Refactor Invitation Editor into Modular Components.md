I will simplify `edit.blade.php` by breaking it down into smaller, manageable components and separating category-specific logic into their own files.

**1. Create Component Directory Structure**
I will create a structured folder system in `resources/views/livewire/dashboard/invitation/partials/` to house the separated code:

* `tabs/`

  * `quote.blade.php` (The Chat Studio)

  * `gallery.blade.php`

  * `events.blade.php`

  * `theme.blade.php`

  * `music.blade.php`

  * `gifts.blade.php`

* `forms/` (Category-specific Bio Forms)

  * `bio-wedding.blade.php`

  * `bio-birthday.blade.php`

  * `bio-aqiqah.blade.php` (Shared with Khitan)

  * `bio-event.blade.php`

  * `bio-general.blade.php`

**2. Refactor** **`edit.blade.php`**
The main file will be drastically reduced (from \~1200 lines to \~200 lines). It will act as a layout shell that:

* Renders the Header and Menu Grid.

* Handles the Modal wrapper.

* Dynamically includes the correct content file based on `$activeTab` and `$category`.

**3. Separation of Concerns**

* **Wedding logic** will be isolated in `bio-wedding.blade.php`.

* **Birthday logic** will be isolated in `bio-birthday.blade.php`.

* This ensures that when you edit a Wedding feature, you don't risk breaking the Birthday layout, fulfilling your request for "not mixed up".

**Outcome:**

* `edit.blade.php` becomes clean and readable.

* Each feature has its own dedicated file.

* Category-specific forms are isolated.

* Maintenance becomes much easier.

