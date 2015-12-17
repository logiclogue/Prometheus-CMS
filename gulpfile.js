var gulp = require('gulp'),
	concat = require('gulp-concat'),
	inject = require('gulp-inject'),
	watch = require('gulp-watch');


var dir = {};

(function (self) {
	self.root = './promethius',
	self.app = self.root + '/app',
	self.controllers = self.root + '/controllers',
	self.build = self.root + '/build'
}(dir));



gulp.task('scripts', function () {
	return gulp.src([dir.app + '/*.js', dir.controllers + '/*.js'])
		.pipe(concat('all.js'))
		.pipe(gulp.dest(dir.build));
});



gulp.task('debug', function () {
	var target = gulp.src(dir.root + '/index.php');
	var sources = gulp.src([dir.app + '/*.js', dir.controllers + '/*.js'], { read: false });

	return target.pipe(inject(sources, { relative: true }))
		.pipe(gulp.dest(dir.root));
});



gulp.task('end-debug', function () {
	var target = gulp.src(dir.root + '/index.php');
	var sources = gulp.src(dir.build + '/all.js', { read: false });

	return target.pipe(inject(sources, { relative: true }))
		.pipe(gulp.dest(dir.root));
});