<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($fieldName, $options['label']) !!}
    <div class="input-group my-colorpicker2">
	    {!! Form::text($fieldName, $record->$fieldName, [
		    'id' =>  $fieldName,
		    'class' => "form-control",
		    'placeholder' => $options['label'],
		] ) !!}

		<div class="input-group-addon">
		  	<i></i>
		</div>
	</div>
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>
