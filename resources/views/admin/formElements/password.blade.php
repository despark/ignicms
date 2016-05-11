<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($fieldName, $options['label']) !!}
    {!! Form::password($fieldName, [
	    'id' =>  $fieldName,
	    'class' => "form-control",
	    'placeholder' => $options['label'],
	] ) !!}
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>
