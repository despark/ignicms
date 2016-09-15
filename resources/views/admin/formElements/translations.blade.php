<?php $i18ns = \Despark\Cms\Models\I18n::all(); ?>
@if(!empty($i18ns))
  <div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        @foreach($i18ns as $key => $i18n)
            @if($key == 0)
                <li role="presentation" class="active">
            @else
                <li role="presentation">
            @endif
            <a href="#{{$i18n->id}}" aria-controls="{{$i18n->id}}" role="tab" data-toggle="tab">{{$i18n->name}}</a></li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($i18ns as $key => $i18n)
            @if($key == 0)
                <div role="tabpanel" class="tab-pane active" id="{{$i18n->id}}">
            @else
                <div role="tabpanel" class="tab-pane" id="{{$i18n->id}}">
            @endif
                @include('ignicms::i18n.'.$model->getTable().'.form', array('model' => $model->translate((int) $i18n->id), 'i18n' => $i18n))
                </div>
        @endforeach
    </div>
@endif
