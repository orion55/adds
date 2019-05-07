var gulp = require('gulp')
var ftp = require('vinyl-ftp')
var shell = require('gulp-shell')
var runSequence = require('run-sequence')

gulp.task('deploy-ftp', function () {

  var conn = ftp.create({
    host: 'grol55wy.beget.tech',
    user: 'grol55wy_address',
    password: 'G8Mcav0%',
    parallel: 10,
  })

  const path = '/wp-content/plugins/address-module/shortcode'

  var globs = [
    'dist/**',
  ]

  return gulp.src(
    globs,
    {
      base: '.',
      buffer: false,
    })
    .pipe(conn.newer(path)) // only upload newer files
    .pipe(conn.dest(path))

})

gulp.task('vue', function () {
  return gulp.src(['./src/*.vue'])
    .pipe(shell('vue-cli-service build --target lib --name adds'))
})

gulp.task('vue-build-task', function () {
  return runSequence('vue', 'deploy-ftp')
})

gulp.task('watch', function () {
  gulp.watch(
    ['./src/*.*', './src/components/*.*', './src/assets/css/*.*', './src/components/ListAddress/*.*'],
    ['vue-build-task'])
})
