<div id="file-widget-{{$fieldName}}" class="file-widget">
    <h3 class="box-title">{{$options['label']}}</h3>
    <div class="files-list-wrapper">
        <ul class="file-list row">
            @foreach($record->getImages($fieldName) as $image)
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <div class="image-item info-box">
                        <div class="gallery-image">
                            <img src="{{asset($image->getOriginalImagePath('admin'))}}"
                                 srcset="{{asset($image->getOriginalImagePath('admin'))}} 1x, {{asset($image->getRetinaImagePath('admin'))}} {{$image->retina_factor}}x"/>
                        </div>
                        <input type="hidden" class="file-order"
                               name="_files[{{$fieldName}}][{{$image->getKey()}}][order]"
                               value="{{$image->order}}">
                        <input type="hidden" name="_files[{{$fieldName}}][{{$image->getKey()}}][id]"
                               value="{{$image->getKey()}}">
                        {!! $record->getImageMetaFieldsHtml($fieldName,$image) !!}

                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="file-upload-widget">
        <div class="uploader">
            <span class="pickfiles btn btn-default">Add files</span>
        </div>
        <br/>
        <div class="progress-group" style="display: none">
            <span class="progress-number"></span>
            <div class="progress sm">
                <div class="progress-bar progress-bar-aqua" style="width: 0%"></div>
            </div>
        </div>
    </div>

</div>

@push('additionalScripts')
<script type="text/javascript">
    var IgniUploader = IgniUploader || {};

    IgniUploader.create = function (config, flowjs) {
        this.config = config;
        this.flowjs = flowjs;
        this.weight = 0;
        this.defaultWidth = '{{config('ignicms.images.admin_thumb_width',200)}}';
        this.defaultHeight = '{{config('ignicms.images.admin_thumb_height',200)}}';

        this.getImagePreview = function (id) {
            var src = this.config.previewUrl + '/' + id;
            var img = $('<div class="gallery-image"><img src="' + src + '" width="' + this.defaultWidth + '" height="' + this.defaultHeight + '"/></div>');
            return img;
        };

        this.createSortable = function () {
            this.sortable = Sortable.create(this.config.$fileList[0], {
                onSort: function (evt) {
                    $('li', evt.srcElement).each(function (i, el) {
                        $('input.file-order', el).val(i);
                    });
                },

            });
            return this.sortable;
        };
    };

    (function ($) {
        var uploader = new IgniUploader.create({
                    fieldName: '{{$fieldName}}',
                    previewUrl: '{{route('image.preview')}}',
                    fileFieldsHtml: {!! json_encode($record->getImageMetaFieldsHtml($fieldName)) !!},
                    $context: $('#file-widget-{{$fieldName}}'),
                    $formContainer: $('#file-widget-{{$fieldName}} .uploaded-images'),
                    $fileList: $('#file-widget-{{$fieldName}} .file-list'),
                    browseButton: $('#file-widget-{{$fieldName}} .pickfiles')[0],
                    dropZone: $('#file-widget-{{$fieldName}} .uploader')[0]
                },
                new Flow({
                    target: '{{route('image.upload')}}',
                    query: {_token: '{{csrf_token()}}'}
                })
        );

        uploader.createSortable();

        uploader.fileProgressHandler = function (file, chunk) {
            var progress = Math.round(file.progress(true) * 100);

            $('.progress-bar', uploader.config.$context).css('width', progress + '%');
            $('.progress-number', uploader.config.$context).html('<b>' + this.getSize() + ' bytes</b>/' + Math.round(this.sizeUploaded()) + ' bytes');
        };

        uploader.filesSubmittedHandler = function (array, event) {
            this.upload();
        };

        uploader.fileSuccessHandler = function (file, message, chunk) {
            var jsonResponse = $.parseJSON(message);
            file.serverId = jsonResponse.id;

            // Add file to the list.
            var li = $('<li class="col-md-3 col-sm-6 col-xs-12"></li>').appendTo(uploader.config.$fileList);
            var index = li.index();

            var item = $('<div class="image-item info-box"></div>').appendTo(li);

            // Add image preview
            uploader.getImagePreview(file.serverId).appendTo(item);

            // Add order field
            $('<input type="hidden" class="file-order" name="_files[new][' + uploader.config.fieldName + '][' + file.serverId + '][order]" value="' + index + '"/>')
                    .appendTo(item);

            var fileFieldsHtml = uploader.config.fileFieldsHtml.replace(/:fileId:/g, file.serverId);
            $(fileFieldsHtml).appendTo(item);

            // Add file ids
            $('<input type="hidden" name="_files[new][' + uploader.config.fieldName + '][' + file.serverId + '][id]" value="' + file.serverId + '"/>')
                    .appendTo(item);

        }

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
        }

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