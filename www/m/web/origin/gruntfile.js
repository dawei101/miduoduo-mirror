module.exports = function(grunt) {
    var destRootPath = "/miduoduo/www/m/web/origin/dest/v1/";
    var destCssRootPath = destRootPath + "css/";
    var destJsRootPath = destRootPath + "js-min/";
    grunt.initConfig({
        ejs: {
            all: {
                options : {
                    title : "",
                    setTitle : function(param) { this.title = param},
                    baseUrl : destRootPath,
                    baseJsUrl : destJsRootPath,
                    mainJs : function(param) {
                        return "<script>seajs.use('" + param + "')</script>";
                    },
                    css : function(param) {
                        if (typeof param == "string") {
                            return "<link rel='stylesheet' type='text/css' href='" + destCssRootPath + param + ".css'/>"
                        } else if (param instanceof Array) {
                            var linkStr = "";
                            param.forEach(function(e) {
                                linkStr += "<link rel='stylesheet' type='text/css' href='" + destCssRootPath + e + ".css'/>\n";
                            })
                            return linkStr;
                        }
                    }

                },
                src: ['view/**/*.html'],
                dest: 'dest/v1/',
                expand: true,
                ext: '.html'
            }
        },
        less: {
            options: {
                paths: ['less'],
                compress: true,
                yuicompress: true,
                optimization: 2
            },
            compile: {
                expand: true,
                cwd: 'less',
                src: ['**/*.less'],
                dest: 'dest/v1/css/',
                ext: '.css'
            }
        },
        uglify: {
            build: {
                options : {
                    mangle: false
                },
                files: [
                    {
                        expand: true,
                        cwd: 'js',
                        src: ['**/*.js'],
                        dest: 'dest/v1/js-min/'
                    }]
            }
        },
        watch: {
            less: {
                files: ['less/**/*.less'],
                tasks: ['less'],
                options: {
                    nospawn: true
                }
            },
            ejs : {
                files : ['view/**/*.html'],
                tasks : ['ejs'],
                options: {
                    nospawn: true
                }
            },
            uglify : {
                files : ['js/**/*.js'],
                tasks : ['uglify'],
                options: {
                    nospawn: true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-ejs');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');


    grunt.registerTask('default', ['watch']);
}