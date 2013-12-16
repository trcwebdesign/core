module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            build: {
                files: {
                    'system/modules/isotope/assets/js/isotope.min.js' : ['system/modules/isotope/assets/js/isotope.js'],
                    'system/modules/isotope/assets/js/backend.min.js' : ['system/modules/isotope/assets/js/backend.js']
                }
            }
        },
        cssmin: {
            build: {
                files: {
                    'system/modules/isotope/assets/css/isotope.min.css' : ['system/modules/isotope/assets/css/isotope.css'],
                    'system/modules/isotope/assets/css/backend.min.css' : ['system/modules/isotope/assets/css/backend.css'],
                    'system/modules/isotope/assets/css/print.min.css' : ['system/modules/isotope/assets/css/print.css']
                }
            }
        },
        watch: {
            scripts: {
                files: ['system/modules/isotope/assets/js/*.js','system/modules/isotope/assets/css/*.css'],
                tasks: ['uglify', 'cssmin'],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['uglify', 'cssmin']);
};