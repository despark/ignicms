{{-- Image --}}
<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($fieldName, $options['label']) !!}

    @if($image = $record->$fieldName)
        <div class="form-group">
            {!! Html::image($record->getImageThumbnailPath($fieldName, 'admin')) !!}
        </div>
    @endif

    {!! Form::file($fieldName,  [
        'id' => $fieldName,
        'class' => "form-control",
        'placeholder' => $options['label'],
    ] ) !!}

    <div class="help-text">{{ $options['help'] or '' }}</div>

    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>

</div>
