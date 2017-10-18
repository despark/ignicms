<hr>
<h3>SEO</h3>
@if ($options['readability'])
	<hr>
	<h4>Readability</h4>
	<div id="seo_readability_content">
		@include('ignicms::admin.formElements.seoReadability')
	</div>
@endif

<hr>
<h4>Social</h4>
<div class="form-group">
	<a id="seo_google" name="seo_google" href="#" class="btn btn-primary btn-seo-social" role="button"><i id="seo_google" class="fa fa-google"></i></a>
    <a id="seo_facebook" name="seo_facebook" href="#" class="btn btn-primary btn-seo-social" role="button"><i id="seo_facebook" class="fa fa-facebook"></i></a>
    <a id="seo_twitter" name="seo_twitter" href="#" class="btn btn-primary btn-seo-social" role="button"><i id="seo_twitter" class="fa fa-twitter"></i></a>
</div>

<div id="seo_google_div">
	@include('ignicms::admin.formElements.seoGoogle')
</div>

<div id="seo_facebook_div">
	@include('ignicms::admin.formElements.seoFacebook')
</div>

<div id="seo_twitter_div">
	@include('ignicms::admin.formElements.seoTwitter')
</div>

@push('additionalScripts')
	@if ($options['readability'])
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
	@endif
    <script type="text/javascript">
    	var url = '{{ route(strtolower(class_basename($record)).'.'.(isset($options['actionVerb']) ?  $options['actionVerb'] : 'show'), '') }}',
    		slug = $('#slug').val(),
    		active = '#seo_google',
    		activeDevice = '#seo_google_desktop';

    	@if ($errors->has('twitter_title') || $errors->has('twitter_description') | $errors->has('twitter_image'))
    		$('#seo_twitter').addClass('btn-danger').removeClass('btn-primary');
    	@endif
    	@if ($errors->has('facebook_title') || $errors->has('facebook_description') | $errors->has('facebook_image'))
        	$('#seo_facebook').addClass('btn-danger').removeClass('btn-primary');
        @endif
        @if ($errors->has('meta_description'))
        	$('#seo_google').addClass('btn-danger').removeClass('btn-primary');
        @endif

    	if ($('#slug').val() == undefined) {
    		slug = '{{ $record->slug }}'
    	}

    	$('#seo_meta_title').html($('#title').val());
    	$('#seo_meta_url').html(url+'/'+slug);
    	$('#seo_meta_description').html($('#meta_description').val());
    	$(active).addClass('active');
    	$('#seo_facebook_div').hide();
    	$('#seo_twitter_div').hide();

    	$('#title').change(function() {
			$('#seo_meta_title').html($('#title').val());
		});

		$('#slug').change(function() {
			$('#seo_meta_url').html(url+'/'+$('#slug').val());
		});

		$('#meta_description').change(function() {
			$('#seo_meta_description').html($('#meta_description').val());
		});
	
		$('.btn-seo-social').click(function(event) {
			event.preventDefault();
			var targetId = event.target.id;

			if ('#'+targetId != active) {
				$(active+'_div').hide();
				$(active).removeClass('active');
				active = '#'+targetId;
				$(active+'_div').show();
				$(active).addClass('active');
			}
		});

		$(activeDevice).addClass('active');

		$('.btn-seo-google-switch').click(function(event) {
			event.preventDefault();
			var targetId = event.target.id;

			if ('#'+targetId != activeDevice) {
				// $(activeDevice+'_div').hide();
				$(activeDevice).removeClass('active');
				activeDevice = '#'+targetId;
				// $(activeDevice+'_div').show();
				$(activeDevice).addClass('active');
			}
		});

		@if ($options['readability'])
			$('#seo_readability_list').hide();

			setTimeout(function () {
				makeAjaxCall(tinymce.activeEditor);
			}, 2000);

			function wysiwygTextChanged(editor) {
			  	editor.on('keyup', _.debounce(function (e) {
			  		makeAjaxCall(editor);
			  	}, 2000));
			}

			function makeAjaxCall(editor) {
				var readabilityColumn = '{{ $options['readabilityColumn'] ?? 'content' }}',
					token = '{{ csrf_token() }}';
				
		  		if (editor.id === readabilityColumn) {
		  			$.ajax({
		                url: '/admin/check/readability',
		                type: 'POST',
		                data: {html: editor.getContent(), _token: token}
		            }).done(function (data) {
		            	$('#flesch_reading_ease_test').html(data.fleschKincaidReadingEaseResult.text).css('color', data.fleschKincaidReadingEaseResult.color);
		            	$('#words_per_subheading').html(data.html.subheadings.text).css('color', data.html.subheadings.color);
		            	$('#passive_voice').html(data.sentences.passiveVoice.text).css('color', data.sentences.passiveVoice.color);
		            	$('#more_than_20_words').html(data.sentences.moreThan20Words.text).css('color', data.sentences.moreThan20Words.color);
		            	$('#transition_words').html(data.sentences.transitionWords.text).css('color', data.sentences.transitionWords.color);
		            	$('#words_in_paragraph').html(data.html.paragraphs.text).css('color', data.html.paragraphs.color);
		            	if (data.showTextLengthError) {
		            		$('#text_length').show();
		            	} else {
		            		$('#text_length').hide();
		            	}
		            	$('#seo_readability_list').show();
		            }).fail(function (data) {
		            	$('#seo_readability_list').hide();
		            });
		  		}
			}
		@endif
    </script>
@endpush
