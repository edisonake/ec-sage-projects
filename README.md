# EC Sage Projects

A custom WordPress plugin built to pair with a **Roots Sage v11** theme using **Tailwind CSS + DaisyUI**. It registers a **Project** custom post type, a **Project Tags** taxonomy, and provides **Sage Blade templates** styled with DaisyUI components for:

- Project archive (`/projects`)
- Single project items
- Project tag taxonomy archives
- A reusable Project **Card** component for displaying items in grids/lists

The plugin works on activation while allowing ** theme overrides** of templates and components.

---

## Features

- ✅ **Project** CPT (`project`) with archive `/projects`
- ✅ **Project Tags** taxonomy (`project_tag`)
- ✅ DaisyUI-styled Blade templates & components
- ✅ Sage/Acorn **View Composer** for project data
- ✅ Theme-override friendly (copy to override)

---

## Requirements

| Requirement | Version                 |
|-------------|-------------------------|
| WordPress | 6.0+                    |
| PHP | 8.0+ (8.2 recommended)  |
| Roots Sage | v11+ (Acorn/Blade required) |
| Tailwind CSS | v3+                     |
| **DaisyUI** | v5+                     |


> The CPT/taxonomy registration works without Sage, but the included templates require a Sage v11 theme to render Blade views.

---

## Installation

1. Copy or clone this plugin into:

   `wp-content/plugins/ec-sage-projects`

2. Activate **EC Sage Projects** in WordPress Admin → Plugins.

3. Visit **Settings → Permalinks** and click **Save Changes** once (flushes rewrite rules) if needed.
4. **Visit `/projects`** to see the archive!


---

## What it registers

### Custom Post Type: `project`
- Archive: `/projects`
- Single: `/projects/{slug}`
- REST API: enabled (`show_in_rest`)

### Taxonomy: `project_tag`
- Archive: `/project-tag/{term}`
- Hierarchical: No


---

## Templates, components, and composer included (Blade)

Located in: `resources/views/`

| File | Purpose |
|------|---------|
| `archive-project.blade.php` | Project archive |
| `single-project.blade.php` | Single project |
| `partials/content-project-loop.blade.php` | Loop partial |
| `partials/content-project-tags.blade.php` | Tag list |
| `components/card.blade.php` | Project card component |


### View Composer

The plugin also includes a Sage/Acorn view composer:

- `includes/View/Composers/Project.php`

This composer provides helper data to the project views.

---

## Overriding templates, components, and composer in your Sage theme

Sage resolves views from the theme first. To override plugin views:



1. Copy the plugin view file into your theme’s `resources/views/` directory.
2. Keep the same relative path and name.

Examples:

- Override archive:

  Copy  
  `wp-content/plugins/ec-sage-projects/resources/views/archive-project.blade.php`  
  to  
  `wp-content/themes/<your-sage-theme>/resources/views/archive-project.blade.php`

- Override the Card component:

  Copy  
  `wp-content/plugins/ec-sage-projects/resources/views/components/card.blade.php`  
  to  
  `wp-content/themes/<your-sage-theme>/resources/views/components/card.blade.php`

- Override partials:

  Copy  
  `.../resources/views/partials/content-project-loop.blade.php`  
  to  
  `.../resources/views/partials/content-project-loop.blade.php`

### Overriding the Composer

If you want to fully customize the data available to project views, you can implement your own composer in the theme and register it there.

The plugin’s composer lives at:

- `wp-content/plugins/ec-sage-projects/includes/View/Composers/Project.php`

> Note: composer override behavior depends on how/where composers are registered. If you register a different composer for the same views in your theme, it can replace or augment the data passed to those views.

---

## Notes

- The plugin integrates with Sage’s view finder by registering `resources/views` as an additional view location.
- Enable `WP_DEBUG` to see plugin logs

