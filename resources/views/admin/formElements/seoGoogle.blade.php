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

<div class="form-group {{ $errors->has('seo_social_image') ? 'has-error' : '' }}">
    <label for="seo_social_image">Social Image</label>
    @if($record->hasImages('seo_social_image'))
        <div class="form-group">
            @foreach($record->getImages('seo_social_image') as $image)
                <div class="image-row">
                    {!! Html::image($image->getOriginalImagePath('admin'), $image->alt, ['title' => $image->title]) !!}
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="seo_social_image_delete">
                {!! Form::checkbox('seo_social_image_delete',1,null,['id' => 'seo_social_image_delete']) !!}
                Delete
            </label>
        </div>
    @endif

    {!! Form::file('seo_social_image',  [
        'id' => 'seo_social_image',
        'class' => "form-control",
        'placeholder' => 'Social Image',
    ] ) !!}

    <div class="help-text">Default social image. The image size should be at least 1200x630px and with the same aspect ratio.</div>
    <div class="text-red">
        {{ join($errors->get('seo_social_image'), '<br />') }}
    </div>
</div>