var gulp = require('gulp')
var ftp = require('vinyl-ftp')
var shell = require('gulp-shell')
var runSequence = require('run-sequence')

gulp.task('deploy-ftp', function () {

  var conn = ftp.create({
    host: 'grol55wy.beget.tech',
    user: 'grol55wy_pol',
    password: 'GEBJ0%cZ',
    parallel: 10
  })

  const path = '/wp-content/plugins/floor-calc/shortcode'

  var globs = [
    'dist/**'
  ]

  return gulp.src(globs, {base: '.', buffer: false})
    .pipe(conn.newer(path)) // only upload newer files
    .pipe(conn.dest(path))

})

gulp.task('vue', function () {
  return gulp.src(['./src/*.vue'])
    .pipe(shell('vue-cli-service build --target lib --name floorlib'))
})

gulp.task('vue-build-task', function () {
  return runSequence('vue', 'deploy-ftp')
})

gulp.task('watch', function () {
  gulp.watch('./src/*.vue', ['vue-build-task'])
})
