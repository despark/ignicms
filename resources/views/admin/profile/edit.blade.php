@extends('admin.layouts.default')

@section('pageTitle', 'Edit profile')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $pageTitle }} - {{ $record->name  }}</h3>
                </div>
                {!!  Form::open([
                    'url' => route('admin.profile.update'),
                    'method' => (isset($formMethod)) ? $formMethod : 'POST',
                    'role' => 'form',
                    'enctype'=> 'multipart/form-data', ]
                ) !!}

                <div class="box-body">
                    {{-- Name --}}
                    @include('admin.formElements.text', [
                        'fieldName' => 'name',
                        'options' => [
                            'label' => 'Name',
                        ]
                    ])

                    {{-- Position --}}
                    @include('admin.formElements.text', [
                        'fieldName' => 'position',
                        'options' => [
                            'label' => 'Position',
                        ]
                    ])

                    {{-- Description --}}
                    @include('admin.formElements.textarea', [
                        'fieldName' => 'description',
                        'options' => [
                            'label' => 'Description',
                        ]
                    ])

                    {{-- Photos --}}
                    @include('admin.formElements.image', [
                        'fieldName' => 'images_upload_1',
                        'options' => [
                            'type'        => 'image',
                            'label'       => 'Image (landscape)',
                            'orientation' => '1',
                            'help'        => 'Image size should be at least 1804 x 1150 and with the same aspect ratio',
                        ]
                    ])

                    @include('admin.formElements.image', [
                        'fieldName' => 'images_upload_2',
                        'options' => [
                            'type'        => 'image',
                            'label'       => 'Image (portrait)',
                            'orientation' => '2',
                            'help'        => 'Image size should be at least 452 x 600 and with the same aspect ratio',
                        ]
                    ])

                    {{-- Password --}}
                    @include('admin.formElements.password', [
                        'fieldName' => 'password',
                        'options' => [
                            'label' => 'Password',
                        ]
                    ])

                    {{-- Password Repeat --}}
                    @include('admin.formElements.password', [
                        'fieldName' => 'password_confirmation',
                        'options' => [
                            'label' => 'Password Confirm',
                        ]
                    ])

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
