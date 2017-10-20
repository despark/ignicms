<div class="form-group {{ $errors->has('twitter_title') ? 'has-error' : '' }}">
	<label for="seo_facebook_title">Twitter Title</label>
	<input type="text" id="twitter_title" name="twitter_title" placeholder="Twitter Title" class="form-control" value="{{ old('twitter_title') ?? $record->seo->twitter_title ?? null }}">
	<div class="help-text">If you don't want to use the current title for sharing on Facebook but instead want another title there, write it here.</div>
	<div class="text-red">
        {{ join($errors->get('twitter_title'), '<br />') }}
    </div>
</div>
<div class="form-group {{ $errors->has('twitter_description') ? 'has-error' : '' }}">
    <label for="twitter_description">Twitter Description</label>
    <textarea id="twitter_description" name="twitter_description" placeholder="Twitter Description" class="form-control">{{ old('twitter_description') ?? $record->seo->twitter_description ?? null }}</textarea>
    <div class="help-text">If you don't want to use the current meta description for sharing on Facebook but instead want another meta description there, write it here.</div>
    <div class="text-red">
        {{ join($errors->get('twitter_description'), '<br />') }}
    </div>
</div>
@include('ignicms::admin.formElements.seo.imageUploader', [
        'fieldName' => 'twitter_image',
        'label' => 'Twitter Image',
        'help' => 'If you want to override the image used on Twitter, upload an image here. The image size should be at least 1024x512 and with the same aspect ratio.',
])