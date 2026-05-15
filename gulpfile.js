const { src, dest, watch, parallel } = require('gulp');
const gulpSass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');

function compileThemeStyles() {
	return src('scss/style.scss', { sourcemaps: true })
		.pipe(gulpSass.sync({ outputStyle: 'expanded' }).on('error', gulpSass.logError))
		.pipe(postcss([autoprefixer()]))
		.pipe(dest('.', { sourcemaps: '.' }));
}

function compileAdminStyles() {
	return src('scss/admin.scss', { sourcemaps: true })
		.pipe(gulpSass.sync({ outputStyle: 'expanded' }).on('error', gulpSass.logError))
		.pipe(postcss([autoprefixer()]))
		.pipe(dest('assets/css', { sourcemaps: '.' }));
}

function watchStyles() {
	watch('scss/**/*.scss', parallel(compileThemeStyles, compileAdminStyles));
}

exports.theme = compileThemeStyles;
exports.admin = compileAdminStyles;
exports.build = parallel(compileThemeStyles, compileAdminStyles);
exports.watch = watchStyles;
exports.default = exports.build;
