<hr>
<p id="seo_meta_title"></p>
<p id="seo_meta_url"></p>
<p id="seo_meta_description"></p>  
{{-- <div id="seo_google_desktop_div">
	<p id="seo_meta_title"></p>
	<p id="seo_meta_url"></p>
	<p id="seo_meta_description"></p>  
</div>
<div id="seo_google_mobile_div">
	<p id="seo_meta_title"></p>
	<p id="seo_meta_url"></p>
	<p id="seo_meta_description"></p>  
</div> --}}
<a id="seo_google_desktop" name="seo_google_desktop" href="#" class="btn btn-default btn-seo-google-switch" role="button"><i id="seo_google_desktop" class="fa fa-desktop"></i></a>
<a id="seo_google_mobile" name="seo_google_mobile" href="#" class="btn btn-default btn-seo-google-switch" role="button"><i id="seo_google_mobile" class="fa fa-mobile fa-lg"></i></a>
<hr>

<div class="form-group {{ $errors->has('meta_description') ? 'has-error' : '' }}">
    <label for="meta_description">Meta Description</label>
    <textarea id="meta_description" name="meta_description" placeholder="Meta Description" class="form-control">{{ old('meta_description') ?? $record->seo->meta_description ?? null }}</textarea>
    <div class="text-red">
        {{ join($errors->get('meta_description'), '<br />') }}
    </div>
</div>
@include('ignicms::admin.formElements.seo.imageUploader', [
        'fieldName' => 'seo_social_image',
        'label' => 'Social Image',
        'help' => 'Default social image. The image size should be at least 1200x630px and with the same aspect ratio.',
])