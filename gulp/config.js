var dest = "./public";
var src = "./resources/assets";
var vendors = "./vendor/bower_components";
var neat = require("node-neat").includePaths;
var bourbon = require("node-bourbon").includePaths;

module.exports = {
    bowerComponents: [
        vendors + "/jquery/dist/jquery.js",
        vendors + "/fastclick/lib/fastclick.js",
        vendors + "/owl.carousel/dist/owl.carousel.js",
        vendors + "/vminpoly/tokenizer.js",
        vendors + "/vminpoly/parser.js",
        vendors + "/vminpoly/vminpoly.js"
    ],
    git: {
        productionBranch: "production"
    },
    sass: {
        src: src + "/scss/**/*.{sass,scss}",
        dest: dest + "/css",
        devSettings: {
            includePaths: bourbon.concat(neat),
            outputStyle: "expanded",
            indentedSyntax: false, // Enable .sass syntax!
        },
        prodSettings: {
            includePaths: bourbon.concat(neat),
            outputStyle: "compressed",
            indentedSyntax: false,
        }
    },
    admin: {
        css: [
            vendors + "/AdminLTE/bootstrap/css/bootstrap.css",
            vendors + "/AdminLTE/dist/css/AdminLTE.css",
            vendors + "/AdminLTE/dist/css/skins/skin-blue.css",
            vendors + "/font-awesome/css/font-awesome.css",
            vendors + "/datatables/media/css/dataTables.bootstrap.css",
            vendors + "/select2/dist/css/select2.css",
            vendors + "/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css",
            vendors + "/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css",
        ],
        sass: src + "/admin/sass/**/*.{sass,scss}",
        dest: dest + "/css",
        devSettings: {
            includePaths: bourbon.concat(neat),
            outputStyle: "expanded",
            indentedSyntax: false, // Enable .sass syntax!
        },
        prodSettings: {
            includePaths: bourbon.concat(neat),
            outputStyle: "compressed",
            indentedSyntax: false,
        }
    },
    flowjs: {
        src: [
            vendors + "/flow.js/dist/*"
        ],
        dest: dest + "/js/flow.js"
    },
    // todo!!
    // gallery: {
    //     src: [
    //         vendors + "/flow.js/dist/flow.js",
    //         src + "/js/igni_gallery.js"
    //     ],
    //     dest: dest + "/js/igni_gallery.js"
    // },
    sortable: {
        src: [
            vendors + "/Sortable/Sortable.js",
            vendors + "/Sortable/Sortable.min.js"
        ],
        dest: dest + "/js/sortable"
    },
    jsAdmin: {
        src: [
            vendors + "/jquery/dist/jquery.js",
            vendors + "/datatables/media/js/jquery.dataTables.min.js",
            vendors + "/datatables/media/js/dataTables.bootstrap.min.js",
            vendors + "/jquery-ui/jquery-ui.min.js",
            vendors + "/select2/dist/js/select2.full.min.js",
            vendors + "/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js",
            vendors + "/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
            src + "/admin/js/**/*.js"
        ],
        dest: dest + "/js"
    },
    js: {
        src: src + "/js/**/*.js",
        dest: dest + "/js"
    },
    images: {
        src: src + "/images/**",
        dest: dest + "/images"
    },
    fonts: {
        src: [
            src + "/fonts/**",
            vendors + "/font-awesome/fonts/**",
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
