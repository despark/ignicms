var dest = './public';
var src = './resources/assets/admin';
var vendors = './vendor/bower_components';

module.exports = {
    css: [
        vendors + '/AdminLTE/bootstrap/css/bootstrap.css',
        vendors + '/AdminLTE/dist/css/AdminLTE.css',
        vendors + '/AdminLTE/dist/css/skins/skin-blue.css',
        vendors + '/font-awesome/css/font-awesome.css',
        vendors + '/datatables/media/css/dataTables.bootstrap.css',
        vendors + '/select2/dist/css/select2.css',
        vendors + '/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css',
        vendors + '/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    ],
    sass: src + '/sass/**/*.s[a|c]ss',
    dest: dest + '/css',
    devSettings: {
        outputStyle: 'expanded',
        indentedSyntax: false // Enable .sass syntax!
    },
    prodSettings: {
        outputStyle: 'compressed',
        indentedSyntax: false
    },
    flowjs: {
        src: [
            vendors + '/flow.js/dist/*'
        ],
        dest: dest + '/js/flow.js'
    },
    // todo!!
    // gallery: {
    //     src: [
    //         vendors + '/flow.js/dist/flow.js',
    //         src + '/js/igni_gallery.js'
    //     ],
    //     dest: dest + '/js/igni_gallery.js'
    // },
    sortable: {
        src: [
            vendors + '/Sortable/Sortable.js',
            vendors + '/Sortable/Sortable.min.js'
        ],
        dest: dest + '/js/sortable'
    },
    js: {
        adminSrc: src + '/js/**',
        vendorSrc: [
            vendors + '/jquery/dist/jquery.js',
            vendors + '/datatables/media/js/jquery.dataTables.min.js',
            vendors + '/datatables/media/js/dataTables.bootstrap.min.js',
            vendors + '/jquery-ui/jquery-ui.min.js',
            vendors + '/select2/dist/js/select2.full.min.js',
            vendors + '/moment/min/moment.min.js',
            vendors + '/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
            vendors + '/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
            src + '/js/**/*.js'
        ],
        dest: dest + '/js'
    },
    images: {
        src: src + '/images/**',
        dest: dest + '/images'
    }
};
