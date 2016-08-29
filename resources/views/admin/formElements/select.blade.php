<div class="form-group">
    {!! Form::label($fieldName, $options['label']) !!}
    {!! Form::select($fieldName, [null => 'Select '.$options['label']] + $options['select_options'], $record->{$fieldName}, ['class' => 'form-control']) !!}
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>
