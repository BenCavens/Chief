module.exports = function (grunt){

	grunt.initConfig({

		sass: {
	      dist: {
	        options: {
	          style: 'compressed', // compressed - expanded
	          sourcemap: true
	        },
	        files: {
	          'css/dist/main.min.css':'css/src/main.scss'
	        }
	      }
	    },

	    autoprefixer: {
	      no_dest: {
	        src: 'css/dist/main.min.css'
	      }
	    },

		uglify: {
			options:{
				mangle:true,
				compressed: true,
				sourceMap: "js/dist/application.map"
			},
			target: {
				src: "js/src/tmp/main.js",
				dest: "js/dist/main.min.js"
			},
			vendor: {
				src: "js/src/tmp/vendor.js",
				dest: "js/dist/vendor.min.js"
			}
		},
		jshint:{
			options: {
				eqeqeq: true, // no double equals, only triple
				curly: true,
				undef: true, // always use var keyword
				unused: true
			},
			target: {
				src: "js/src/*.js"
			}
		},
		concat:{
			options:{
				seperator: ";",
				banner: "/* Ben Cavens <cavensben@gmail.com> */"
			},
			target:{
				src: ["js/src/vendor/jquery-1.10.2.min.js","js/src/vendor/bootstrap.min.js"],
				dest: "js/src/tmp/vendor.js"
			},
			vendor:{
				src: ["js/src/main.js"],
				dest: "js/src/tmp/main.js"
			},
			cssBootstrap: {
				src: ["css/src/vendor/reset.css","css/src/vendor/bootstrap.min.css"],
				dest: "css/dist/vendor/bootstrap.min.css"
			},
		},

		copy:{
			
			fonts: {
				dest:'css/dist/',
				src: ['fonts/**'],
				cwd: 'css/src/',
				expand: true
			},
			redactor: {
				dest:'js/dist/vendor/',
				src: ['redactor/**'],
				cwd: 'js/src/vendor',
				expand: true
			}

		},

		watch:{
			options: {
	        	livereload: true,
	      	},
	      	css: {
	        	files: ['css/src/*.scss'],
	        	tasks: ['sass','autoprefixer']
	      	},
	      	js: {
	        	files: ['js/src/*.js'],
	        	tasks: ['jshint','concat','uglify']
	      	}
		},
		clean:{
			target:["css/dist","js/dist"]			
		}

	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-copy');

	grunt.registerTask("default", ["default-js","default-css","copy"]);

	grunt.registerTask("default-js", ["jshint","concat","uglify"]);
	grunt.registerTask("default-css", ["sass","autoprefixer"]);
	//grunt.registerTask("reboot", ["clean","default"]);

};
