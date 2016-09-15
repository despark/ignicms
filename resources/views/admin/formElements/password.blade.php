<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($elementName, $options['label']) !!}
    {!! Form::password($elementName, [
	    'id' =>  $elementName,
	    'class' => "form-control",
	    'placeholder' => $options['label'],
	] ) !!}
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>
