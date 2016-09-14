@inject('assetManager', 'Despark\Cms\Contracts\AssetsContract')

@foreach($assetManager->getJs() as $item)
    <script src="{{$item['path']}}" type="text/javascript"></script>
@endforeach