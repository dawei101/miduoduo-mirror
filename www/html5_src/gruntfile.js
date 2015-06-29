module.exports = function(grunt) {
    var destRootPath = "/mdd/www/m/web/origin/dest/v1/";
    var destCssRootPath = destRootPath + "css/";
    var destJsRootPath = "/mdd/www/m/web/origin/js/";//destRootPath + "js_min/";
    grunt.initConfig({
        ejs: {
            all: {
                options : {
                    title : "",
                    setTitle : function(param) { this.title = param},
                    baseUrl : destRootPath,
                    baseCssUrl : destCssRootPath,
                    baseJsUrl : destJsRootPath,
                    styleFileExt : ".css",
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
                compress: true,
                yuicompress: true,
                optimization: 2
            },
            compile: {
                expand: true,
                cwd : "less",
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
                expand: true,
                cwd: 'js',
                src: ['**/*.js'],
                dest: 'dest/v1/js_min/'
            }
        },
        watch: {
            less: {
                files: ['less/**/*.less'],
                tasks: ['less'],
                options: {
                    spawn: false
                }
            },
            ejs : {
                files : ['view/**/*.html'],
                tasks : ['ejs'],
                options: {
                    spawn: false
                }
            },
            uglify : {
                files : ['js/**/*.js'],
                tasks : ['uglify'],
                options: {
                    spawn: false
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-ejs');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');


    grunt.registerTask('default', ['watch']);
    grunt.registerTask('uglify', ['uglify']);

    grunt.event.on('watch', function(action, filepath,target) {
        console.log("目标", target, filepath);
       switch (target) {
           case "ejs" :
               grunt.config('ejs.all.src', filepath);
               break;
           case "less" :
              grunt.config('less.compile.src', filepath.substr(5));
               break;
           case "uglify" :
               grunt.config('uglify.build.src', filepath.substr(3));
               break;
       }

    });
}