<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($fieldName, $options['label']) !!}
    {!! Form::select($fieldName, [null => 'Select '.$options['label']] + $record->{$options['selectOptions']}(), $record->{$fieldName}, ['class' => 'form-control '.array_get($options, 'additionalClass')]) !!}
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>