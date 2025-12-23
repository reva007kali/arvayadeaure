## Goal
Add a “Duplicate Invitation” button to the dashboard invitation index cards, visible only for admin users, that creates a copy of the selected invitation under the admin account.

## Scope
- UI: Show a duplicate icon button on each invitation card in `resources/views/livewire/dashboard/index.blade.php`, wrapped in an admin-only check.
- Livewire: Add a `duplicate($id)` method in `app/Livewire/Dashboard/Index.php` to perform server-side duplication.

## Duplication Logic
- Load the target invitation (by `id`).
- Create a new invitation record by replicating:
  - `title` (append “ (Copy)”)
  - `slug` (append “-copy” and ensure uniqueness)
  - `theme_template`, `package_type`
  - JSON fields: `couple_data`, `event_data`, `theme_config`, `gallery_data`, `gifts_data`
- Assign:
  - `user_id` to the current admin (`Auth::id()`)
  - `payment_status = 'paid'` and `amount = 0`, `due_amount = 0`, `refund_amount = 0`
  - `is_active = false`
  - Reset counters: `visit_count = 0`
- Save and flash a success message.

## UI Details
- Place a small button (e.g., `fa-copy`) in the card header area next to status badges or as an overlay action.
- Use `wire:click="duplicate({{ $invitation->id }})"`.
- Wrap with `@if(auth()->user()->role === 'admin')` to limit visibility.

## Safety & Validation
- Ensure slug uniqueness; if collision occurs, add an incrementing suffix (`-copy-2`, etc.).
- Guard: Only admins can call `duplicate()`; check `Auth::user()->role` in the method.

## Deliverables
- Updated blade with admin-only duplicate button.
- Livewire component with duplication implementation and success feedback.

If approved, I will implement the blade button and Livewire duplication method, verify slug uniqueness, and provide a success flash message visible on the dashboard.