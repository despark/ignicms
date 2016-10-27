<div class="form-group">
    <div class="checkbox">
        <label for="{{ $elementName }}">
            {!! Form::hidden($elementName, 0) !!}
            {!! Form::checkbox($elementName, 1, ($record->$fieldName), [
            'id' => $elementName,
            'class' => isset($options['class']) ? $options['class'] : null]) !!}
            {{ $options['label'] }}

        </label>
    </div>
</div>
