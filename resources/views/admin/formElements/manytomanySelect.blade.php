<div class="form-group {{ $errors->has($options['validateName']) ? 'has-error' : '' }}">
    {!! Form::label($elementName, $options['label']) !!}
    {!! Form::select($elementName, $sourceModel->toOptionsArray(), $record->{$options['relationMethod']}->pluck($options['selectedKey'])->all(), [
            'class' => 'form-control select2 '.array_get($options, "additionalClass"),
            'multiple' => 'multiple',
        ]) !!}
    <div class="text-red">
        {{ join($errors->get($options['validateName']), '<br />') }}
    </div>
</div>
