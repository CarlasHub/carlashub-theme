# CarlaHub local dev

This theme uses a single Sass source folder and compiles into `assets/css/`.

## Source of truth

Edit Sass here:

- `sass/style.scss` (main theme)
- `sass/woocommerce.scss` (WooCommerce overrides)

Do not edit generated CSS here:

- `assets/css/theme.css`
- `assets/css/woocommerce.css`

## Run

1) In LocalWP, start your site and copy its URL (example: `http://carlashub-local.local`).

2) From the theme folder:

```bash
npm install
PROXY_URL="http://carlashub-local.local" npm run dev
```

3) Open BrowserSync:

- `http://localhost:3011`

If your site domain is different, update the `PROXY_URL` value.
