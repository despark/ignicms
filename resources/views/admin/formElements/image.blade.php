{{-- Image --}}
<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($elementName, $options['label']) !!}

    @if($image = $record->imageFileByOrientation($options['orientation']))
        <div class="form-group">
            {!! Html::image($record->getAdminImageFile($image, $options['orientation']), null,['width' => $record->getAdminDimensions($options['orientation'], 'w'), 'height' => $record->getAdminDimensions($options['orientation'], 'h')]) !!}
        </div>
    @endif

    {!! Form::file($elementName,  [
        'id' => $elementName,
        'class' => "form-control",
        'placeholder' => $options['label'],
    ] ) !!}

    <div>{{ $options['help'] or '' }}</div>

    {!! Form::hidden('image_orientation['.$fieldName.']', $options['orientation']) !!}
    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>
</div>
