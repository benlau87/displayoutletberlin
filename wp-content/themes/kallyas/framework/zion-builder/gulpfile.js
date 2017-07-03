var project  	  = 'zion-builder',
	text_domain   = project;

// Style related.
//
var scssSRC                = './assets/scss'; // Path to main .scss file.
var styleSRC                = scssSRC + '/*.scss'; // Path to main .scss file.
var styleDestination        = './assets/css/'; // Path to place the compiled CSS file.

// Browsers you care about for autoprefixing.
// Browserlist https://github.com/ai/browserslist
var AUTOPREFIXER_BROWSERS = [
	'last 2 version',
	'> 2%',
	'ie >= 11',
  ];

// Node modules
var gulp 		= require('gulp'),
	runSequence = require('run-sequence'),
	zip         = require('gulp-zip'),
	sort        = require('gulp-sort'),
	wpPot       = require('gulp-wp-pot'),
	bump        = require('gulp-bump'),
	prompt      = require('gulp-prompt'),
	del         = require('del'),
	fs          = require('fs'),
	replace     = require('gulp-replace'),

	// JS
	concat       = require('gulp-concat'),
	uglify       = require('gulp-uglify'),
	gutil        = require('gulp-util'),
	plumber      = require('gulp-plumber'),

	// CSS related plugins.
	sass         = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),

	// Utility related plugins.
	lineec       = require('gulp-line-ending-corrector'),
	sourcemaps   = require('gulp-sourcemaps'),

	notify       = require('gulp-notify');


gulp.task('styles', function () {

	return gulp.src( styleSRC )
		.pipe(plumber())
		.pipe( sourcemaps.init() )
		.pipe( sass( {
			errLogToConsole: true,
			outputStyle: 'compressed',
			precision: 10
		}))
		.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )
		.on('error', gutil.log)
		.pipe( sourcemaps.write ( '/css-source-maps/' ) )// Create non-minified sourcemap
		.pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
		.pipe( gulp.dest( styleDestination ) );

});

/**
 * Elements styles
 */

var elStylesSrc = ['./inc/modules/**/*.scss'];

gulp.task('el-styles', function () {

	gulp.src( elStylesSrc )
	.pipe( sass( {
	  errLogToConsole: true,
	  outputStyle: 'compact',
	  precision: 10
	} ) )
	.on('error', console.error.bind(console))
	.pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )
	.pipe( gulp.dest( function(file) {
	  return file.base;
	} ) )
	.pipe( notify( { message: 'TASK: "Modules Styles" Completed!', onLast: true } ) )

});

/**
 * Frontend Scripts
 *
*/
var frontendJsPath = './assets/js/editor';
var frontendJsSource = frontendJsPath + '/frontend-js/*.js';
gulp.task( 'frontendJS', function() {
	return gulp.src( frontendJsSource )
		.pipe(plumber())
		.pipe( concat( 'zn_frontend.js' ) )
		.pipe( uglify() )
		.pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
		.on('error', gutil.log)
		.pipe( gulp.dest( frontendJsPath ) );
});


 /**
  * Watch Tasks.
  *
  * Watches for file changes and runs specific tasks.
  */
 gulp.task( 'default', ['styles', 'el-styles', 'frontendJS'], function () {
	gulp.watch( styleSRC, [ 'styles' ] ); // Reload on SCSS file changes.
	gulp.watch( elStylesSrc, [ 'el-styles' ] ); // Reload on SCSS file changes.
	gulp.watch( frontendJsSource, [ 'frontendJS' ] ); // Reload on JS file changes.
});


/**
 * ==============================================
 * BUILD
 * ==============================================
 */

var build_path = './buildplugin/',
	build_path_theme = build_path + project,
	build_includes 	= [
		'**/*.*',

		// exclude files and folders
		'!assets/js/editor/frontend-js/**/*',
		'!assets/scss/**/*',
		'!assets/css/css-source-maps/**/*',
		'!node_modules/**/*',
		'!.git/**/*',
		'!webpack.config.js',
		'!package.json',
		'!gulpfile.js',
		'!code-guidelines.md',
		'!.gitignore',
		'!.babelrc',
		'!buildplugin/**/*',
		'!**/*.map',
		'!' + project + '.zip'
	];


// Change version
function getPackageJsonVersion() {
  // Parse the JSON file instead of using require because require
  // caches multiple calls so the version number won't be updated
  return JSON.parse(fs.readFileSync('./package.json', 'utf8')).version;
}
gulp.task('changeVersion', function(callback){

	gulp.src('./*')
		.pipe(prompt.prompt({
			type: 'input',
			name: 'version',
			message: 'What version number you are releasing?'
		},
		function(response){

			var old_version = getPackageJsonVersion();
			gulp.src([
				'./package.json',
				project + '.php',
			], { base: './' })
			.pipe(bump({version: response.version }))
			// .pipe(replace(old_version, response.version))
			.pipe(gulp.dest('./'));

			if(typeof(callback) === 'function') {
				callback();
			}
		})
	);
});


gulp.task( 'translate', function () {
	return gulp.src( './**/*.php' )
		.pipe(sort())
		.pipe(wpPot( {
			domain        : text_domain,
			package       : project,
			bugReport     : 'https://my.hogash.com/support/',
			team          : 'Hogash'
		} ))
		.pipe(gulp.dest( './languages/'+ text_domain +'.pot' ))
		.pipe( notify( { message: 'TASK: "translate" Completed! 💯', onLast: true } ) );
});


gulp.task('buildFiles', function() {
	return gulp.src(build_includes)
		.pipe(gulp.dest( build_path_theme ))
		.pipe(notify({ message: 'Copy from Build Files complete', onLast: true }));
});


gulp.task('buildZip', function () {
	return 	gulp.src( build_path + '/**/')
		.pipe(zip(project+'.zip'))
		.pipe(gulp.dest('./'))
		.pipe(notify({ message: 'Zip task complete', onLast: true }));
});


gulp.task('cleanup', function(){
	return del(build_path);
});

gulp.task('finish', function(){
	console.log('All done!');
});


// Package Distributable Theme
gulp.task('build', function(cb) {
	runSequence('styles', 'el-styles', 'frontendJS', 'translate', 'changeVersion', 'buildFiles', 'buildZip', 'cleanup', 'finish');
});
