I will create sample template views for each category (Engagement, Birthday, Aqiqah, Khitan, Event) and ensure the `ShowInvitation` controller can dynamically render them based on the category, although the current logic already supports dynamic theme loading based on the template slug.

**Plan:**

1.  **Create Template View Components:**
    I will create basic, clean sample templates for each new category in `resources/views/components/themes/`.
    *   `engagement-basic.blade.php`: Similar to wedding but with "Tunangan" terminology.
    *   `birthday-fun.blade.php`: Colorful, focused on the birthday person's profile and age.
    *   `aqiqah-bless.blade.php`: Islamic style, focused on the baby's name and prayer.
    *   `khitan-brave.blade.php`: Similar to Aqiqah but for Khitan context.
    *   `event-general.blade.php`: Generic event layout (Title, Host, Description).

2.  **Verify/Update `ShowInvitation.php`:**
    *   The current controller (`app/Livewire/Frontend/ShowInvitation.php`) already uses `$themeName = $this->invitation->theme_template ?? 'default';` to determine the view.
    *   This logic is **already sufficient**. As long as the `theme_template` column in the database matches the blade file name (e.g., `engagement-basic`), it will work automatically.
    *   I don't need to change the controller logic, just ensure the *templates exist* and match the slugs I will assign to them.

3.  **Seed/Update Database (via `ManageTemplates` or direct SQL for testing):**
    *   I will assume you will use the "Manage Templates" page we just built to add these templates. I will just provide the **files** so they exist when you try to select them.

4.  **Refinement:**
    *   I will ensure each template correctly pulls the dynamic data structure we defined earlier (e.g., `$invitation->couple_data['child_name']` for Aqiqah).

**Actionable Steps:**
1.  Create `resources/views/components/themes/engagement-basic.blade.php`
2.  Create `resources/views/components/themes/birthday-fun.blade.php`
3.  Create `resources/views/components/themes/aqiqah-bless.blade.php`
4.  Create `resources/views/components/themes/khitan-brave.blade.php`
5.  Create `resources/views/components/themes/event-general.blade.php`

I will make these templates simple but functional, using Tailwind CSS and the data structures we established.