<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}" style="position: 'relative'">
    {!! Form::label($elementName, $options['label']) !!}
    <div class="datepicker input-group">
        {!! Form::text($elementName, $record->$fieldName, [
            'id' =>  $elementName,
            'class' => "form-control",
            'placeholder' => $options['label'],
        ] ) !!}
    </div>
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>
