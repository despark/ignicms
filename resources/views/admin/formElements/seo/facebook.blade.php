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
@include('ignicms::admin.formElements.seo.imageUploader', [
        'fieldName' => 'facebook_image',
        'label' => 'Facebook Image', 
        'type' => 'facebook_image',
        'help' => 'If you want to override the image used on Facebook, upload an image here. The image size should be at least 1200x630px and with the same aspect ratio.',
])