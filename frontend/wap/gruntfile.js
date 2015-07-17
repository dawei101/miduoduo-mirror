module.exports = function(grunt) {
    //生成文件的目标根路径
    var targetRootPath = "../../../compile-mdd/frontend/dest/v1/";
    //ejs常量
    var destRootPath = "/v1/";
    var destCssRootPath = destRootPath + "css/";
    var destJsRootPath = destRootPath + "js_min/";
    var destImgRootPath = destRootPath + "img/";
    grunt.initConfig({
        ejs: {
            all: {
                options : {
                    title : "",
                    setTitle : function(param) { this.title = param},
                    baseUrl : destRootPath,
                    baseCssUrl : destCssRootPath,
                    baseJsUrl : destJsRootPath,
                    baseImgUrl : destImgRootPath,
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
                dest: targetRootPath,
                expand: true,
                ext: '.html'
            }
        },
        less: {
            options: {
                compress: true,
                yuicompress: true,
                optimization: 2,
                modifyVars: {
                    pic_url: '"/v1/img/"' //重写atom.less里的变量
                }
            },
            compile: {
                expand: true,
                cwd : "less",
                src: ['**/*.less'],
                dest: targetRootPath + 'css/',
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
                dest: targetRootPath + 'js_min/'
            }
        },
        copy : {
            main : {
                expand: true,
                cwd: 'img',
                src: ['**/*.*'],
                dest: targetRootPath + 'img/'
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
    grunt.loadNpmTasks('grunt-contrib-copy');



    grunt.registerTask('default', ['watch']);
    grunt.registerTask('all', ['ejs','less','uglify', 'copy']);

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