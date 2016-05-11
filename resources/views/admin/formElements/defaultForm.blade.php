@extends('admin.layouts.default')

@section('pageTitle', $pageTitle)

@section('additionalStyles')
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $pageTitle }} - {{ $actionVerb or 'Edit'  }}</h3>
                </div>
                {!!  Form::open([
                    'url'=>route($formAction, ['id' => $record->id]),
                    'method' => (isset($formMethod)) ? $formMethod : 'POST',
                    'role' => 'form',
                    'enctype'=> 'multipart/form-data', ]
                ) !!}

                <div class="box-body">
                    {{ $record->buildForm() }}
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        {!! $record->adminPreviewButton() !!}

                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('additionalScripts')
    <script src="{{ asset('/admin_assets/plugins/tinymce/tinymce.min.js') }}"></script>

    <script type="text/javascript">
        $(".select2").select2();
        $(".select2-tags").select2({
            tags: true,
        });

        $(".my-colorpicker2").colorpicker({
            format: 'hex'
        });

        $(".datepicker input").datepicker({
            format: 'yyyy-m-d'
        });

        tinymce.init({
            selector: ".wysiwyg",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste imagetools jbimages"
            ],
            content_css: "/css/styles.css",
            menubar: false,
            width: 800,
            toolbar: "code undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image jbimages | media",
            image_advtab: true,
            relative_urls: false,
            height: 500,
            imagetools_cors_hosts: ['despark.app', 'despark.com', '2015.despark.com'],
            style_formats: [
                {title: 'Section paragraph (p)', block: 'p', classes: 'para-basic'},
                {title: 'Section header (h3)', block: 'h3', classes: 'title-section'},
                {title: 'Full width image', selector: 'img', classes: 'head-image'},
                {title: 'Smaller image - right', selector: 'img', classes: 'image-in-content image-smaller-right'},
                {title: 'Containers', items: [
                    {title: 'Video Wrapper Div', block: 'div', classes: 'video-wrapper', wrapper: true, merge_siblings: false},
                    {title: 'Right aligned article', block: 'article', classes: 'text-container-right', wrapper: true, merge_siblings: false},
                    {title: 'Center aligned article', block: 'article', classes: 'text-container', wrapper: true, merge_siblings: false},
                    {title: 'section', block: 'section', wrapper: true, merge_siblings: false},
                    {title: 'blockquote', block: 'blockquote', wrapper: true},
                    {title: 'hgroup', block: 'hgroup', wrapper: true},
                    {title: 'aside', block: 'aside', wrapper: true},
                    {title: 'figure', block: 'figure', wrapper: true},
                ]}
            ],
            visualblocks_default_state: true,
            end_container_on_empty_block: true
        });
    </script>
@stop
