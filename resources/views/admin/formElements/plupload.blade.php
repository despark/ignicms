<div id="uploader">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
@push('additionalStyles')
    <link rel="stylesheet" href="{{asset('js/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css')}}">
@endpush
@push('additionalScripts')
    <script src="{{asset('js/plupload/plupload.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/plupload/jquery.ui.plupload/jquery.ui.plupload.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        (function ($) {
            // Custom example logic
            plupload.addFileFilter('min_width', function (minWidth, file, cb) {
                var self = this, img = new o.Image();

                function finalize(result) {
                    // cleanup
                    img.destroy();
                    img = null;

                    // if rule has been violated in one way or another, trigger an error
                    if (!result) {
                        self.trigger('Error', {
                            code: plupload.IMAGE_DIMENSIONS_ERROR,
                            message: "Resolution exceeds the allowed width limit of " + minWidth + " pixels.",
                            file: file
                        });

                    }
                    cb(result);
                }

                img.onload = function () {
                    // check if resolution cap is not exceeded
                    finalize(img.width > minWidth || minWidth == 0);
                };

                img.onerror = function () {
                    finalize(false);
                };

                img.load(file.getSource());
            });

            plupload.addFileFilter('min_height', function (minHeight, file, cb) {
                var self = this, img = new o.Image();

                function finalize(result) {
                    // cleanup
                    img.destroy();
                    img = null;

                    // if rule has been violated in one way or another, trigger an error
                    if (!result) {
                        self.trigger('Error', {
                            code: plupload.IMAGE_DIMENSIONS_ERROR,
                            message: "Resolution exceeds the allowed height limit of " + minHeight + " pixels.",
                            file: file
                        });

                    }
                    cb(result);
                }

                img.onload = function () {
                    // check if resolution cap is not exceeded
                    finalize(img.height > minHeight || minHeight == 0);
                };

                img.onerror = function () {
                    finalize(false);
                };

                img.load(file.getSource());
            });
            $("#uploader").plupload({
                // General settings
                runtimes: 'html5,flash,silverlight,html4',
                url: "{{route('plupload.upload')}}",
                // User can upload no more then 20 files in one go (sets multiple_queues to false)
//                max_file_count: 20,
                filters: {
                    // Maximum file size
                    max_file_size: '{{config('ignicms.images.max_upload_size') / 1024}}mb',
                    // Specify what files to browse for
                    mime_types: [
                        {title: "Image files", extensions: "jpg,gif,png"},
                    ],
                    min_width: '{{$record->getMinDimensions($fieldName)['width']}}',
                    min_height: '{{$record->getMinDimensions($fieldName)['height']}}'
                },
                // Rename files by clicking on their titles
                rename: true,

                // Sort files
                sortable: true,
                // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
                dragdrop: true,
                // Views to activate
                views: {
                    list: true,
                    thumbs: true, // Show thumbs
                    active: 'thumbs'
                },
                prevent_duplicates: true,
                // Flash settings
                flash_swf_url: '{{asset('js/plupload/Moxie.swf')}}',
                // Silverlight settings
                silverlight_xap_url: '{{asset('js/plupload/Moxie.xap')}}',
                // CSRF
                multipart_params: {
                    '_token': '{{csrf_token()}}'
                }

            });
        })(jQuery);
    </script>
@endpush