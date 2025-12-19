I will implement the **Admin Free Sample Workflow** and **Preview System**.

**Concept:**
Instead of building a separate system for "static previews," we will leverage the existing Invitation Builder.

1. **Admins create invitations for free:** When an admin creates an invitation, the system will bypass the payment requirement.
2. **Admins use these invitations as "Samples":** The admin creates a dummy invitation (e.g., "Romeo & Juliet" for a Wedding template), styles it perfectly, and then links it to the Template.
3. **Public Preview:** When a user clicks "Preview" on the template gallery, they are taken to this actual live invitation.

**Plan:**

1. **Modify** **`Create.php`** **(Invitation Builder):**

   * In the `save()` method, check if `Auth::user()->isAdmin()`.

   * If yes, force `$amount = 0` and `$payment_status = 'paid'`.

   * This allows admins to generate unlimited sample invitations without hitting the payment wall.

2. **Database Update (`templates`** **table):**

   * Create a migration to add a `preview_url` column to the `templates` table.

   * This column will store the link to the sample invitation (e.g., `/romeo-juliet-sample`).

3. **Update Admin Panel (`ManageTemplates.php`** **& View):**

   * Add an input field for `Preview URL` in the "Add/Edit Template" modal.

   * Admins will paste the URL of the sample invitation they created here.

4. **Update Frontend (`template-showcase.blade.php`):**

   * Update the "Preview" button logic:

     * If `preview_url` is set: Open it in a new tab (`target="_blank"`).

     * If not set: Show a disabled state or a default "No Preview" message.

   * (Optional) Update the "Lihat Contoh" button on the landing page to scroll to the themes section or link to the gallery.

**Workflow for You (User):**

1. Go to Dashboard > Create Invitation.
2. Select "Wedding Gold" template.
3. Fill dummy data.
4. (System automatically marks it paid).
5. Edit it until perfect.
6. Copy the URL (e.g., `arvaya.com/wedding-gold-sample`).
7. Go to Admin > Manage Templates.
8. Edit "Wedding Gold" and paste the URL into "Preview URL".
9. Done! Public users can now preview it.

