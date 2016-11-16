<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($elementName, $options['label']) !!}
    {!! Form::text($elementName, $record->$fieldName, array_merge([
    'id' =>  $elementName,
    'class' => "form-control ".$options['class'],
    'placeholder' => $options['label'],
], array_get($options, 'attributes', []))) !!}
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>
