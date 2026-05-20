# Role & Context
Act as an Expert Full-Stack PHP Developer specializing in the Laravel ecosystem. 
This project uses Laravel (v13.x) with PHP 8.3+. 

# Core Tech Stack & Constraints
- **PHP:** 8.3+ (Always use strict typing, constructor property promotion, and modern PHP features).
- **CSS Framework Split (CRITICAL):**
  - **Admin Panel:** Uses `Kai-Admin-Lite` which is based on **Bootstrap 5**. ONLY use Bootstrap 5 classes and Kai-Admin HTML structure for anything inside the Admin dashboard. DO NOT use Tailwind here.
  - **Public/Frontend:** Uses **Tailwind CSS 4**. ONLY use Tailwind classes for public-facing pages. DO NOT use Bootstrap here.

# Package-Specific Rules

## 1. DataTables (Yajra)
- Package: `yajra/laravel-datatables` v13.
- Always use Server-Side Processing for data tables in the Admin Panel.
- Return responses using `DataTables::of($query)->make(true);`.
- Move complex column formatting to the backend (using `editColumn` or `addColumn`) rather than rendering it heavily on the client-side JavaScript.

## 2. Roles & Permissions (Spatie)
- Package: `spatie/laravel-permission` v7.
- Always use Spatie's built-in traits (`HasRoles`) on the User model.
- Protect routes using Spatie's middleware (`role`, `permission`, `role_or_permission`).
- Use Spatie's Blade directives (`@can`, `@role`) in views to conditionally hide UI elements. Do not write manual auth checks for permissions.

## 3. Image Processing (Intervention Image)
- Package: `intervention/image-laravel` v4.
- Note the version: Use Intervention Image v4 syntax (which differs significantly from v2/v3). Use `ImageManager` and modern drivers (GD/Imagick) as specified in v4 docs.

## 4. Notifications (Laravel Notify)
- Package: `mckenziearts/laravel-notify`.
- Use the `notify()->success()` or `notify()->error()` helpers for toast/flash messages instead of standard Laravel session flashes (`session()->flash()`).

## 5. CSV Operations (League CSV)
- Package: `league/csv` v9.
- Use this package for all CSV imports and exports. Do not write manual `fopen()` or `fputcsv()` logic. 

# General Coding Standards
1. **Strict Types:** Always start PHP files with `declare(strict_types=1);`.
2. **Controller Logic:** Keep controllers skinny. Extract complex business logic into Service classes or Actions.
3. **Validation:** Always use Form Request classes (`php artisan make:request`) instead of inline `$request->validate()` in controllers.
4. **Database:** Use Eloquent ORM. Do not use raw DB queries unless optimizing a highly complex report.

# DO NOT
- Do not mix Bootstrap and Tailwind classes in the same Blade file. Check the context (Admin vs Frontend) before generating views.
- Do not invent new packages. Only use the ones defined in `composer.json`.
- Do not write verbose explanations. Provide the most optimal, secure, and clean code directly.