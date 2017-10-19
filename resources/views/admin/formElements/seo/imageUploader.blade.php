<div id="file-widget-{{ $fieldName }}" class="file-widget">
    <h3 class="box-title">{{ $label }}</h3>
    <div class="files-list-wrapper">
        <ul class="file-list row">
            @foreach($record->getImages($type) as $item)
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <div class="gallery-item info-box">
                        <div class="gallery-image">
                            <img src="{{ asset($item->getOriginalImagePath('admin')) }}"
                                 srcset="{{ asset($item->getOriginalImagePath('admin')) }} 1x, {{ asset($item->getRetinaImagePath('admin')) }} {{ $item->retina_factor }}x"/>
                        </div>
                        <input type="hidden" class="file-order"
                               name="_files[image][{{ $fieldName }}][{{ $item->getKey() }}][order]"
                               value="{{ $item->order }}">
                        <input type="hidden" name="_files[image][{{ $fieldName }}][{{ $item->getKey() }}][id]"
                               value="{{ $item->getKey() }}">
                        <input type="hidden" class="delete-status"
                               name="_files[image][{{ $fieldName }}][{{ $item->getKey() }}][delete]" value="1">
                    </div>
                    <button type="button" class="btn btn-default btn-block btn-danger delete-item">Delete</button>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="file-upload-widget">
        <div class="uploader">
            <span class="pick-images btn btn-default"><i class="fa fa-picture-o"></i>&nbsp;Add image</span>
        </div>
        <br/>
        <div class="progress-group" style="display: none">
            <span class="progress-number"></span>
            <div class="progress sm">
                <div class="progress-bar progress-bar-aqua" style="width: 0%"></div>
            </div>
        </div>
    </div>
    <div class="help-text">{{ $help }}</div>
    <div id="gallery-validation" class="text-red"></div>
</div>

@push('additionalScripts')
<script type="text/javascript">
    var IgniGallery = IgniGallery || {};

    (function ($) {
        // Attach delete handler
        $(document).on('click', '.file-widget .delete-item', function (e) {
            e.preventDefault();
            var $item = $(this).closest('li');
            $('input.delete-status', $item).val(1);
            $item.fadeOut('slow');
        });

        $('#file-widget-{{ $fieldName }}').on('change', 'input.main-media', function (ev) {
            if ($(this).is(':checked')) {
                $('#file-widget-{{ $fieldName }} input.main-media:checked')
                        .not($(this))
                        .prop('checked', false);
            }
        });

        $('#file-widget-{{ $fieldName }}').on('change', 'input.featured-media', function (ev) {
            if ($(this).is(':checked')) {
                // check how many and alert two much

                if ($('#file-widget-{{ $fieldName }} input.featured-media:checked').length > 2) {
                    $(this).prop('checked', false);
                    alert('No more than 2 items can be set as featured');
                }
            }
        });

        IgniGallery.create = function (config, flowjs) {
            this.config = config;
            this.flowjs = flowjs;
            this.weight = 0;
            this.defaultWidth = '{{ config('ignicms.images.admin_thumb_width',200) }}';
            this.defaultHeight = '{{ config('ignicms.images.admin_thumb_height',200) }}';

            this.getImagePreview = function (id) {
                var src = this.config.previewUrl + '/' + id;
                return $('<div class="gallery-image"><img src="' + src + '" width="' + this.defaultWidth + '" height="' + this.defaultHeight + '"/></div>');
            };

            this.createSortable = function () {
                this.sortable = Sortable.create(this.config.$fileList[0], {
                    onSort: function (evt) {
                        $('li', evt.srcElement).each(function (i, el) {
                            $('input.file-order', el).val(i);
                        });
                    }
                });
                return this.sortable;
            };

            this.addField = function (type, className, name, value, appendTo, label) {
                className += ' form-control';
                if (typeof label != 'undefined') {
                    var group = $('<div class="form-group"/>').appendTo(appendTo);
                    $('<label>' + label + '</label>').appendTo(group);
                    $('<input type="' + type + '" class="' + className + '" name="' + name + '" value="' + value + '"/>')
                            .appendTo(group);
                } else {
                    $('<input type="' + type + '" class="' + className + '" name="' + name + '" value="' + value + '"/>')
                            .appendTo(appendTo);
                }
            };
        };

        var uploader = new IgniGallery.create({
                    fieldName: '{{ $fieldName }}',
                    previewUrl: '{{ route('image.preview') }}',
                    $context: $('#file-widget-{{ $fieldName }}'),
                    $formContainer: $('#file-widget-{{ $fieldName }} .uploaded-images'),
                    $fileList: $('#file-widget-{{ $fieldName }} .file-list'),
                    browseButton: $('#file-widget-{{ $fieldName }} .pick-images')[0],
                    dropZone: $('#file-widget-{{ $fieldName }} .uploader')[0],
                    singleFile: true
                },
                new Flow({
                    target: '{{ route('image.upload') }}',
                    query: {_token: '{{csrf_token()}}'},
                    singleFile: true
                })
        );

        uploader.createSortable();

        uploader.fileProgressHandler = function (file, chunk) {
            var progress = Math.round(file.progress(true) * 100);

            $('.progress-bar', uploader.config.$context).css('width', progress + '%');
            $('.progress-number', uploader.config.$context).html('<b>' + this.getSize() + ' bytes</b>/' + Math.round(this.sizeUploaded()) + ' bytes');
        };

        uploader.filesSubmittedHandler = function (array, event) {
            var maxImageUploadSize = '{{ config('ignicms.images.max_upload_size', 5000) }}';
            var validUpload = true;
            array.forEach(function (image) {
                if (image.size * 0.001 > maxImageUploadSize) {
                    validUpload = false;
                }
            });
            if (validUpload) {
                document.getElementById('gallery-validation').innerHTML = '';
                this.upload();
            } else {
                this.files = [];
                document.getElementById('gallery-validation').innerHTML = 'Image size should not be greater than ' + maxImageUploadSize / 1000 + ' megabytes';
            }
            
        };

        uploader.fileSuccessHandler = function (file, message, chunk) {
            var jsonResponse = $.parseJSON(message);
            var elementType = 'image';
            file.serverId = jsonResponse.id;
            // Add file to the list.
            var li = $('<li class="col-md-3 col-sm-6 col-xs-12"></li>').appendTo(uploader.config.$fileList);
            var index = li.index();

            var item = $('<div class="gallery-item image-item info-box"></div>').appendTo(li);

            // Add image preview
            uploader.getImagePreview(file.serverId).appendTo(item);

            // Add order field
            var name = '_files[new][' + elementType + '][' + uploader.config.fieldName + '][' + file.serverId + '][order]';
            uploader.addField('hidden', 'file-order', name, index, item);

            // Add delete fields
            name = '_files[new][' + elementType + '][' + uploader.config.fieldName + '][' + file.serverId + '][delete]';
            uploader.addField('hidden', 'delete-status', name, 0, item);

            // Add delete button
            $('<button type="button" class="btn btn-default btn-block btn-danger delete-item">Delete</button>')
                    .appendTo(li);

            // Add file ids
            name = '_files[new][' + elementType + '][' + uploader.config.fieldName + '][' + file.serverId + '][id]';
            uploader.addField('hidden', 'uploaded-ids', name, file.serverId, item);

        };

        uploader.uploadStartHandler = function () {
            $('.progress-group', uploader.config.$context).show();
        };

        uploader.completeHandler = function () {
            $('.progress-group', uploader.config.$context).hide();
            $('.progress-number', uploader.config.$context).empty();
            uploader.sortable = Sortable.create(uploader.config.$fileList[0]);

        };

        uploader.fileAddedHandler = function (file, event) {
            // check if file is actually image
            if (file.file.type.indexOf('image/') !== 0) {
                return false;
            }
        };

        uploader.errorHandler = function (message, file, chunk) {
            // todo
        };

        uploader.flowjs.assignBrowse(uploader.config.browseButton, false, false, {
            accept: 'image/*'
        });
        uploader.flowjs.assignDrop(uploader.config.dropZone);

        // Events
        uploader.flowjs.on('fileProgress', uploader.fileProgressHandler);
        uploader.flowjs.on('filesSubmitted', uploader.filesSubmittedHandler);
        uploader.flowjs.on('fileAdded', uploader.fileAddedHandler);
        uploader.flowjs.on('fileSuccess', uploader.fileSuccessHandler);

        uploader.flowjs.on('uploadStart', uploader.uploadStartHandler);
        uploader.flowjs.on('complete', uploader.completeHandler);
        uploader.flowjs.on('error', uploader.errorHandler);

    })(jQuery);
</script>
@endpush