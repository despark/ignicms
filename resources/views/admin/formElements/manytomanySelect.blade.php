<div class="form-group {{ $errors->has($options['validateName']) ? 'has-error' : '' }}">
    {!! Form::label($elementName, $options['label']) !!}
    {!! Form::select($elementName, isset($options["ajaxRouteName"]) ? $record->{$options['relationMethod']}->pluck($options['relationTextField'], $options['selectedKey'])->all() : $sourceModel->toOptionsArray(), $record->{$options['relationMethod']}->pluck($options['selectedKey'])->all(), [
            'class' => 'form-control '.(isset($options["ajaxRouteName"]) ? '' : 'select2').' '.array_get($options, "additionalClass"),
            'multiple' => 'multiple',
        ]) !!}
    <div class="text-red">
        {{ join($errors->get($options['validateName']), '<br />') }}
    </div>
</div>

@if (isset($options['ajaxRouteName']) and isset($options['additionalClass']))
    @push('additionalScripts')
        <script type="text/javascript">
            $(".{{ $options['additionalClass'] }}").select2({
                tags: true,
                multiple: true,
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route($options['ajaxRouteName']) }}',
                    dataType: "json",
                    type: "GET",
                    data: function (params) {
                        var queryParameters = {
                            term: params.term
                        };

                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            })
                        };
                    }
                }
            });
        </script>
    @endpush
@endif
