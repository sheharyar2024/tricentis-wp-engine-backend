/**
 * Define extensions, paths
 */
const gulp = require('gulp'),
	babel = require('gulp-babel'),
	sass = require('gulp-sass'),
	sourcemaps = require('gulp-sourcemaps'),
	autoprefixer = require('gulp-autoprefixer'),
	cssnano = require('gulp-cssnano'),
	concat = require('gulp-concat'),
	fs = require('fs'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	notify = require('gulp-notify'),
	imagemin = require('gulp-imagemin'),
	plumber = require('gulp-plumber'),
	path = {
		WATCH_ADMIN_JS: [
			'assets/js/admin/*.js',
			'assets/js/admin/**/*.js'
		],
		WATCH_APP_JS: [
			'assets/js/app/*.js',
			'assets/js/app/**/*.js'
		],
		WATCH_VENDOR_JS: [
			'assets/js/vendor/*.js',
			'assets/js/vendor/**/*.js'
		],
		WATCH_CSS: [
			'assets/scss/*.scss',
			'assets/scss/**/*.scss'
		],
		ADMIN_JS: 'assets/js/admin/',
		APP_JS: 'assets/js/app/',
		VENDOR_JS: 'assets/js/vendor/',
		CSS: 'assets/scss/',
		IMG: 'assets/img/',
		BUILD: 'assets/build',
		BUILD_CSS: ['assets/build/*.css', 'assets/build/**/*.css'],
		BUILD_JS: ['assets/build/*.js', 'assets/build/**/*.js'],
		DIST: 'assets/dist'
	};

/**
 * Development Tasks
 */
gulp.task('sass', async function () {
	gulp.src([path.CSS + '*.scss', path.CSS + '**/*.scss'])
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass()
			.on('error', notify.onError({
				message: 'Sass failed. Check console for errors'
			}))
			.on('error', sass.logError))
		.pipe(autoprefixer())
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(path.BUILD))
		.pipe(notify('Sass successfully compiled'));
});

// Compile Admin JS
gulp.task('admin_js', async function () {
	gulp.src(path.WATCH_ADMIN_JS)
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(babel({
			presets: ["@babel/preset-env"]
		}))
		.pipe(concat('admin_scripts.js'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(path.BUILD))
		.pipe(notify('Admin JS successfully compiled'));
});

// Compile App JS
gulp.task('app_js', async function () {
	gulp.src(path.WATCH_APP_JS)
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(babel({
			presets: ["@babel/preset-env"]
		}))
		.pipe(concat('app_scripts.js'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(path.BUILD))
		.pipe(notify('App JS successfully compiled'));
});

// Compile Vendor JS
gulp.task('vendor_js', async function () {
	gulp.src(path.WATCH_VENDOR_JS)
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(concat('vendor_scripts.js'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(path.BUILD))
		.pipe(notify('Vendor JS successfully compiled'));
});

gulp.task('default', gulp.parallel('sass', 'vendor_js', 'app_js', 'admin_js'));

/**
 * Production Tasks
 */
// Concatenate, minify, move style files
gulp.task('buildCss', async function () {
	gulp.src([path.BUILD + ' /*.css', path.BUILD + '/**/*.css'
	])
		.pipe(plumber())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(cssnano({
			safe: true
		}))
		.pipe(gulp.dest(path.DIST))
		.pipe(notify('CSS successfully minified.'));
});

// Concatenate, minify, move script files
gulp.task('buildJs', async function () {
	gulp.src([path.BUILD + ' /*.js', path.BUILD + '/**/*.js'
	])
		.pipe(plumber())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(uglify())
		.pipe(gulp.dest(path.DIST))
		.pipe(notify('JS successfully uglified.'));
});

// Optimize images
gulp.task('compressImgs', async function () {
	return gulp.src([path.IMG + '*.*', path.IMG + '**/*.*'])
		.pipe(plumber())
		.pipe(imagemin())
		.pipe(gulp.dest(path.IMG))
		.pipe(notify('Theme images compressed successfully.'));
});

gulp.task('assetVersion', async function (cb) {
	fs.writeFile('version.php', `<?php\n\ndefine( 'TL_ASSET_VERSION', ${Math.floor(Date.now() / 1000)} );`, cb);
});

gulp.task('stage', gulp.parallel('buildCss', 'buildJs'));
gulp.task('prod', gulp.parallel('buildCss', 'buildJs', 'compressImgs', 'assetVersion'));

// Build tasks
gulp.task('watch', async function () {
	gulp.watch(path.WATCH_ADMIN_JS, gulp.series('admin_js'));
	gulp.watch(path.WATCH_APP_JS, gulp.series('app_js'));
	gulp.watch(path.WATCH_VENDOR_JS, gulp.series('vendor_js'));
	gulp.watch(path.WATCH_CSS, gulp.series('sass'));

	gulp.watch(path.BUILD_JS.concat(path.BUILD_CSS), gulp.series('stage'));

});