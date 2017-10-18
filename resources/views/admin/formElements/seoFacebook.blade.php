<div class="form-group {{ $errors->has('facebook_title') ? 'has-error' : '' }}">
	<label for="seo_facebook_title">Facebook Title</label>
	<input type="text" id="facebook_title" name="facebook_title" placeholder="Facebook Title" class="form-control" value="{{ old('facebook_title') ?? $record->seo->facebook_title ?? null }}">
	<div class="help-text">If you don't want to use the current title for sharing on Facebook but instead want another title there, write it here.</div>
	<div class="text-red">
        {{ join($errors->get('facebook_title'), '<br />') }}
    </div>
</div>
<div class="form-group {{ $errors->has('facebook_description') ? 'has-error' : '' }}">
    <label for="facebook_description">Facebook Description</label>
    <textarea id="facebook_description" name="facebook_description" placeholder="Facebook Description" class="form-control">{{ old('facebook_description') ?? $record->seo->facebook_description ?? null }}</textarea>
    <div class="help-text">If you don't want to use the current meta description for sharing on Facebook but instead want another meta description there, write it here.</div>
    <div class="text-red">
        {{ join($errors->get('facebook_description'), '<br />') }}
    </div>
</div>
<div class="form-group {{ $errors->has('facebook_image') ? 'has-error' : '' }}">
    <label for="facebook_image">Facebook Image</label>
    @if($record->hasImages('facebook_image'))
        <div class="form-group">
            @foreach($record->getImages('facebook_image') as $image)
                <div class="image-row">
                    {!! Html::image($image->getOriginalImagePath('admin'), $image->alt, ['title' => $image->title]) !!}
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="facebook_image_delete">
                {!! Form::checkbox('facebook_image_delete',1,null,['id' => 'facebook_image_delete']) !!}
                Delete
            </label>
        </div>
    @endif

    {!! Form::file('facebook_image',  [
        'id' => 'facebook_image',
        'class' => "form-control",
        'placeholder' => 'Facebook Image',
    ] ) !!}

    <div class="help-text">If you want to override the image used on Facebook, upload an image here. The image size should be at least 1200x630px and with the same aspect ratio.</div>
    <div class="text-red">
        {{ join($errors->get('facebook_image'), '<br />') }}
    </div>
</div>