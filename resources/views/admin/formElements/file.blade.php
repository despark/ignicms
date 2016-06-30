{{-- File --}}
<div class="form-group {{ $errors->has($fieldName) ? 'has-error' : '' }}">
    {!! Form::label($fieldName, $options['label']) !!}

    @if($record->{$fieldName})
        <div class="form-group">
            <a href="{{ asset($record->{$fieldName}) }}">Download/View file</a>
            <a href="{{ url('admin/'.str_plural($record->identifier).'/'.$record->id.'/delete/'.$fieldName) }}" style="color: crimson;">Delete file</a>
        </div>
    @endif

    {!! Form::file($fieldName,  [
        'id' => $fieldName,
        'class' => "form-control",
        'placeholder' => $options['label'],
    ] ) !!}

    <div class="text-red">
        {{ join($errors->get($fieldName), '<br />') }}
    </div>

</div>
