I will fix the CSS specificity issue that is preventing the radio button background color from updating correctly in `rsvp-form.blade.php`.

**The Issue:**
The `peer-checked` class selector `!peer-checked:theme-bg` relies on the parent element's context or global styles. In the context of `neobrutalism.blade.php` (and potentially other themes), the `.theme-bg` class is defined, but Tailwind's JIT compiler might not be picking up the dynamic `peer-checked` variant combination correctly, or specificity rules are overriding it because of the scoped styles in the template.

Also, looking at `neobrutalism.blade.php`, there is a `.theme-scope` wrapper:
```html
<div class="theme-scope" style="--color-primary: {{ $primaryColor }};">
```
And inside `rsvp-form.blade.php`, the radio button uses:
```html
<div class="... !peer-checked:theme-bg ...">
```

However, `theme-bg` is defined as `background-color: var(--color-primary);` (or similar) in the theme's `<style>` block.

The problem likely stems from Tailwind's arbitrary value handling or how `!important` interacts with the custom class `theme-bg`. Since `theme-bg` is a custom CSS class defined in the parent Blade file's `<style>` tag, Tailwind doesn't know it should apply it on `peer-checked` unless it's a standard utility or properly configured.

**The Fix:**
I will modify `rsvp-form.blade.php` to explicitly use the style attribute for the active state or ensure the class selector works by removing the ambiguity. Since the background color is dynamic (`var(--color-primary)` or defined in the theme), relying on a utility class that might be purged or have low specificity is risky.

Better approach for the radio buttons:
Instead of just `!peer-checked:theme-bg`, I will use a more robust way to toggle the class using Alpine.js or ensuring the CSS rule matches.

However, since this is a Livewire component inside a theme, the simplest and most robust fix is to use inline styles for the checked state or ensure the CSS rule in the theme targets the checked state explicitly.

But wait, looking at the code:
`!peer-checked:theme-bg` implies "Important: apply theme-bg class when peer is checked".
If `theme-bg` is defined in the parent component's style tag:
```css
.theme-bg { background-color: var(--c-pink); }
```
It should work *if* the class is applied.

The issue is that `peer-checked:theme-bg` isn't a standard Tailwind utility. Tailwind generates classes like `peer-checked:bg-red-500`. It *cannot* generate `peer-checked:theme-bg` because `theme-bg` isn't a Tailwind color or utility; it's a custom class name. Tailwind doesn't generate variants for custom class names automatically unless configured.

**Solution:**
I will rewrite the radio button logic in `resources/views/livewire/frontend/rsvp-form.blade.php` to use Alpine.js `x-bind:class` or `x-bind:style` to apply the background color dynamically when checked. This guarantees it works regardless of Tailwind configuration.

Actually, since `rsvp_status` is wired to Livewire (`wire:model="rsvp_status"`), I can use Blade conditional classes, but that requires a round-trip or cleaner Alpine integration.

**Plan:**
1.  Modify `resources/views/livewire/frontend/rsvp-form.blade.php`.
2.  Wrap the form (or the specific inputs) in `x-data="{ status: @entangle('rsvp_status') }"`.
3.  Use `:class` (Alpine) to apply the `theme-bg` class and `text-white` when the value matches.
4.  Remove the failing `peer-checked:theme-bg` class.

This ensures the background color updates immediately and correctly uses the `.theme-bg` class defined in the parent theme.

**Files:**
*   `resources/views/livewire/frontend/rsvp-form.blade.php`

**Wait, simpler fix:**
The user mentioned `neobrutalism.blade.php`. In that file, the style is:
```css
    .theme-scope .theme-bg {
        background-color: var(--color-primary);
    }
```
(Actually, it was just `.theme-bg` in the latest edit).

In `rsvp-form.blade.php`, the radio button div has:
`class="... !peer-checked:theme-bg ..."`

Tailwind *does not* support applying custom classes via variants like `peer-checked:` out of the box for arbitrary CSS classes defined in style tags. It only works for Tailwind utilities (e.g., `peer-checked:bg-black`).

So, I must use AlpineJS to toggle the class.

**Revised Plan:**
1.  Open `resources/views/livewire/frontend/rsvp-form.blade.php`.
2.  Add `x-data="{ rsvp: @entangle('rsvp_status') }"` to the container.
3.  Change the radio button divs to use `:class="rsvp == 1 ? 'theme-bg text-white' : 'bg-white hover:bg-gray-50'"` (and similarly for value 2).
4.  Remove the `peer-checked` logic for the background.

This is the cleanest and most reliable way.