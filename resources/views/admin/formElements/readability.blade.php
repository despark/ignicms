<div id="seo_readability_content" class="form-group">
	<ol id="seo_readability_list">
		<li id="text_length"><span style="color: red;">You have far too little content, please add some content to enable a good analysis.</span></li>
		<li><span id="flesch_reading_ease_test"></span></li>
		<li><span id="words_per_subheading"></span></li>
		<li><span id="more_than_20_words"></span></li>
		<li><span id="passive_voice"></span></li>
		<li><span id="transition_words"></span></li>
		<li><span id="words_in_paragraph"></span></li>
	</ol>
</div>

@push('additionalScripts')
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
    <script type="text/javascript">
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
			var readabilityColumn = '{{ $options['for'] ?? 'content' }}',
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
    </script>
@endpush