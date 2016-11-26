var dest = "./public";
var src = "./resources/assets";
var vendors = "./vendor/bower_components";
var neat = require("node-neat").includePaths;
var bourbon = require("node-bourbon").includePaths;

module.exports = {
    bowerComponents: [
        vendors + "/jquery/dist/jquery.js",
        vendors + "/fastclick/lib/fastclick.js",

        // Uncomment if Owl Carousel needed
        // vendors + "/owl.carousel/dist/owl.carousel.js",

        // Uncomment if polyfill for CSS units vw, vh & vmin needed
        // vendors + "/vminpoly/tokenizer.js",
        // vendors + "/vminpoly/parser.js",
        // vendors + "/vminpoly/vminpoly.js"
    ],
    sass: {
        src: src + "/scss/**/*.{sass,scss}",
        dest: dest + "/css",
        devSettings: {
            includePaths: bourbon.concat(neat),
            outputStyle: "expanded",
            indentedSyntax: false // Enable .sass syntax!
        },
        prodSettings: {
            includePaths: bourbon.concat(neat),
            outputStyle: "compressed",
            indentedSyntax: false
        }
    },
    js: {
        src: src + "/js/**/*.js",
        fileSrc: src + '/js/app.js',
        dest: dest + "/js"
    },
    images: {
        src: src + "/images/**",
        dest: dest + "/images"
    },
    fonts: {
        src: [
            src + "/fonts/**",
            vendors + "/font-awesome/fonts/**"
        ],
        dest: dest + "/fonts"
    },
    jsons: {
        src: src + "/samples/**",
        dest: dest + "/samples"
    },
    markup: {
        src: src + "/htdocs/**",
        dest: dest
    },
    production: {
        cssSrc: dest + "/*.css",
        jsSrc: dest + "/*.js",
        dest: dest
    }
};
