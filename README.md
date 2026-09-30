# Magnetic Control — WordPress Theme

Custom WordPress + WooCommerce theme for **Magnetic Control** (industrial transformers, harmonic filters and drive chokes).

## Requirements
- WordPress 6.4+ (tested on 7.1)
- PHP 8.0+ with GD (WebP support)
- WooCommerce

## Install
1. Copy this folder to `wp-content/themes/magneticcontrol`.
2. Activate **Magnetic Control** in *Appearance → Themes*.
3. *Settings → Reading*: set a static front page, and the **Blog** page as the posts page.

## What's inside
| Path | Purpose |
|---|---|
| `front-page.php` | Homepage |
| `page-about-2.php`, `page-contact.php`, `page-manufacturing.php`, `page-careers.php` | Page templates (matched by page slug) |
| `page.php`, `home.php`, `single.php` | Default page, blog list, blog post |
| `woocommerce/` | Shop catalogue, product card, single product page |
| `inc/security.php` | Hardening: login lockout, no user enumeration, security headers, XML-RPC off |
| `inc/perf.php` | Performance: per-page asset loading, WebP copies of uploads |
| `inc/contact.php` | Contact form handler (emails the site address) |
| `inc/woocommerce.php` | Shop filters and extra product fields (highlights, specs, downloads) |
| `assets/css/main.css` | Design tokens — change the brand colour via `--mc-green` at the top |

## Site settings in code
- Contact details and social links: `mc_contact()` in `functions.php` (a social icon appears once its `'#'` is replaced with a URL).
- Header menu: `mc_primary_menu_fallback()` in `inc/template-tags.php`, used until a menu is assigned in *Appearance → Menus*.

## Server
The site's root `.htaccess` should include the security and WebP rules used in production
(block `xmlrpc.php` / `wp-config.php`, no PHP in `uploads/`, serve `*.webp` copies to browsers that accept WebP).
