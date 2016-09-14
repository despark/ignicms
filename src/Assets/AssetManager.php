<?php


namespace Despark\Cms\Assets;


use Despark\Cms\Contracts\AssetsContract;

/**
 * Class AssetManager
 */
class AssetManager implements AssetsContract
{
    
    /**
     * @var array
     */
    protected $assets = ['js' => [], 'css' => []];
    
    /**
     * AssetManager constructor.
     */
    public function __construct()
    {
        // Add globals
        $globalAssets = config('ignicms.admin_assets');
        if (isset($globalAssets['js'])) {
            foreach ($globalAssets['js'] as $jsAsset) {
                $this->addJs($jsAsset);
            }
        }
        if (isset($globalAssets['css']) && is_array($globalAssets['css'])) {
            foreach ($globalAssets['css'] as $cssAsset) {
                $this->addCss($cssAsset);
            }
        }
    }
    
    
    /**
     * @param $path
     * @param int $order
     */
    public function addJs($path, $order = 0)
    {
        if (! isset($this->assets['js'][$path])) {
            $this->assets['js'][$path] = [
                'path' => asset($path),
                'order' => $order,
            ];
        }
    }
    
    /**
     * @param $path
     * @param int $order
     */
    public function addCss($path, $order = 0)
    {
        if (! isset($this->assets['css'][$path])) {
            $this->assets['css'][$path] = [
                'path' => asset($path),
                'order' => $order,
            ];
        }
    }
    
    /**
     * @return array
     */
    public function getJs()
    {
        usort($this->assets['js'], [$this, 'orderAssetsArray']);
        
        return $this->assets['js'];
    }
    
    /**
     * @return array
     */
    public function getCss()
    {
        usort($this->assets['css'], [$this, 'orderAssetsArray']);
        
        return $this->assets['css'];
        
    }
    
    /**
     * @return array
     */
    public function getAssets()
    {
        return $this->assets;
    }
    
    
    /**
     * TODO
     */
    public function modifyAsset()
    {
        // todo
    }
    
    /**
     * @param $path
     * @return mixed
     */
    public function getAssetByPath($path)
    {
        if (isset($this->assets['css'][$path])) {
            return $this->assets['css'][$path];
        }
        if (isset($this->assets['js'][$path])) {
            return $this->assets['js'][$path];
        }
    }
    
    /**
     * @param $a
     * @param $b
     * @return int
     */
    public function orderAssetsArray($a, $b)
    {
        if ($a['order'] == $b['order']) {
            return 0;
        }
        
        return ($a['order'] < $b['order']) ? -1 : 1;
    }
    
}