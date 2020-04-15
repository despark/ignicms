@inject('assetManager', 'Despark\Cms\Contracts\AssetsContract')

@foreach($assetManager->getCss() as $item)
    <link rel="stylesheet" href="{{asset($item['path'])}}">
@endforeach
