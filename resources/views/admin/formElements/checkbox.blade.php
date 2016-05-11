<div class="form-group">
    <div class="checkbox">
        <label for="{{ $fieldName }}">
            {!! Form::hidden($fieldName, 0) !!}
            {!! Form::checkbox($fieldName, 1, ($record->$fieldName), ['id' => $fieldName]) !!}
            {{ $options['label'] }}

        </label>
    </div>
</div>
