# CarlasHub V2 WordPress Theme

CarlasHub V2 is a classic WordPress theme for [carlashub.com](https://carlashub.com/). It uses a dark-first portfolio/blog design, custom archive templates, featured-image support, custom sitemap handling, and Sass-based styling.

## Requirements

- WordPress 6.4 or later
- PHP 8.0 or later
- Node.js and npm for rebuilding CSS

## Theme Structure

- `functions.php` registers theme support, widgets, assets, and theme behaviour.
- `inc/custom-sitemaps.php` provides custom sitemap output and legacy sitemap redirects.
- `scss/` contains Sass source.
- `style.css` is the compiled WordPress theme stylesheet and includes the required theme header.
- `assets/` contains theme JavaScript, CSS, and images.
- Template files such as `single.php`, `archive.php`, `front-page.php`, and `page.php` control front-end rendering.

## Build Commands

Install dependencies:

```bash
npm install
```

Build CSS:

```bash
npm run build
```

Watch Sass changes:

```bash
npm run watch:css
```

## Repository Notes

`node_modules/`, local machine files, archives, logs, and environment files are intentionally ignored. Commit source files, compiled theme assets required by WordPress, and documentation.
