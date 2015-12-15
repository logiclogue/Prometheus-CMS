var gulp = require('gulp'),
	concat = require('gulp-concat');


var dir = {};

(function (self) {
	self.root = './promethius',
	self.app = self.root + '/js',
	self.controllers = self.root + '/controllers',
	self.build = self.root + '/build'
}(dir));



gulp.task('scripts', function () {
	return gulp.src([dir.app + '/*.js', dir.controllers + '/*.js'])
		.pipe(concat('all.js'))
		.pipe(gulp.dest(dir.build));
});