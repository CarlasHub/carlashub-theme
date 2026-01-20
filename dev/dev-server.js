const browserSync = require('browser-sync').create();

const args = process.argv.slice(2);
const arg = (name) => {
  const found = args.find((a) => a.startsWith(`--${name}=`));
  return found ? found.split('=').slice(1).join('=') : '';
};

const proxy = (arg('proxy') || process.env.PROXY_URL || process.env.BS_PROXY || 'http://carlashub-local.local').replace(/\/$/, '');
const port = Number(arg('port') || process.env.BS_PORT || 3011);

browserSync.init({
  proxy,
  host: '127.0.0.1',
  port,
  open: false,
  notify: false,
  ghostMode: false,
  reloadDebounce: 500,
  files: [
    '**/*.php',
    'assets/css/theme.css',
    'assets/css/woocommerce.css',
    'js/**/*.js'
  ]
});
