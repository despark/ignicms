<div id="seo_readability_content" class="form-group">
	<ul id="seo_readability_list" class="readability-instructions">
		<li id="text_length" class="is-red">You have far too little content, please add some content to enable a good analysis.</li>
		<li id="flesch_reading_ease_test"></li>
		<li id="words_per_subheading"></li>
		<li id="more_than_20_words"></li>
		<li id="passive_voice"></li>
		<li id="transition_words"></li>
		<li id="words_in_paragraph"></li>
	</ul>
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
			var readabilityColumn = '{{ $field->getOptions('for') ?? 'content' }}',
				token = '{{ csrf_token() }}';

	  		if (editor.id === readabilityColumn) {
	  			$.ajax({
	                url: '/admin/check/readability',
	                type: 'POST',
	                data: {html: editor.getContent(), _token: token}
	            }).done(function (data) {
	            	$('#flesch_reading_ease_test').html(data.fleschKincaidReadingEaseResult.text).addClass('is-' + data.fleschKincaidReadingEaseResult.color);
	            	$('#words_per_subheading').html(data.html.subheadings.text).addClass('is-' + data.html.subheadings.color);
	            	$('#passive_voice').html(data.sentences.passiveVoice.text).addClass('is-' + data.sentences.passiveVoice.color);
	            	$('#more_than_20_words').html(data.sentences.moreThan20Words.text).addClass('is-' + data.sentences.moreThan20Words.color);
	            	$('#transition_words').html(data.sentences.transitionWords.text).addClass('is-' + data.sentences.transitionWords.color);
	            	$('#words_in_paragraph').html(data.html.paragraphs.text).addClass('is-' + data.html.paragraphs.color);
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