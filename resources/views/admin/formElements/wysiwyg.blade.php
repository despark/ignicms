<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($elementName, $options['label']) !!}
    {!! Form::textarea($elementName, $record->$fieldName, [
        'id' =>  $elementName,
        'class' => "form-control wysiwyg",
        'placeholder' => $options['label'],
    ] ) !!}
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>

@push('additionalScripts')
<script src="{{ asset('/admin_assets/plugins/tinymce/tinymce.min.js') }}"></script>

<script type="text/javascript">
    function merge_options(obj1, obj2) {
        var obj3 = {};
        for (var attrname in obj1) { obj3[attrname] = obj1[attrname]; }
        for (var attrname in obj2) { obj3[attrname] = obj2[attrname]; }
        return obj3;
    }

    var defaultOptions = {
        selector: ".wysiwyg",
        skin: "despark-cms",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen responsivefilemanager template",
            "insertdatetime media table contextmenu paste imagetools jbimages"
        ],
        content_css: "/css/styles.css",
        menubar: false,
        toolbar: "code undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image jbimages | media | template",
        image_advtab: true,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        height: 500,
        imagetools_cors_hosts: ['{{env('APP_URL')}}'],
        external_filemanager_path: "/plugins/filemanager/",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {
            "filemanager": "{{ asset('/plugins/filemanager/plugin.min.js') }}"
        },
        media_live_embeds: true,
        style_formats: [
            {title: 'Paragraph (p)', block: 'p', classes: ''},
            {
                title: 'Containers', items: [
                {
                    title: 'First div',
                    block: 'div',
                    classes: 'col-lg-4 col-lg-offset-2',
                    wrapper: true,
                    merge_siblings: false
                },
                {
                    title: 'Second div',
                    block: 'div',
                    classes: 'col-lg-4',
                    wrapper: true,
                    merge_siblings: false
                },
            ]
            }
        ],
        end_container_on_empty_block: true
    };

    @if (isset($options['additional_options']))
        var additionalOptions = {!! json_encode($options['additional_options']) !!};
        tinymce.init(merge_options(defaultOptions, additionalOptions));
    @else
        tinymce.init(defaultOptions);
    @endif
</script>
@endpush