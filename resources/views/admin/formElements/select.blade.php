<div class="form-group">
    {!! Form::label($elementName, $options['label']) !!}
    {!! Form::select($elementName, [null => 'Select '.$options['label']] + $record->{$options['selectOptions']}(), $record->{$fieldName}, ['class' => 'form-control']) !!}
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>
