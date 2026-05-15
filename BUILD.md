# CSS Build

Run all commands from the theme directory:

`/wp-content/themes/carlashub-v2`

## Install dependencies

```bash
npm install
```

## Build styles once

```bash
npm run build:css
```

## Watch and rebuild on SCSS changes

```bash
npm run watch:css
```

## Source and outputs

- Source theme styles: `scss/style.scss` + `scss/partials/_theme.scss`
- Source admin styles: `scss/admin.scss` + `scss/partials/_admin-widget-media.scss`
- Compiled theme stylesheet: `style.css`
- Compiled admin stylesheet: `assets/css/admin.css`
