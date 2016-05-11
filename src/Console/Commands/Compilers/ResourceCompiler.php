<?php

namespace Despark\Console\Commands\Compilers;

use Illuminate\Console\Command;
use Illuminate\Console\AppNamespaceDetectorTrait;

class ResourceCompiler
{
    use AppNamespaceDetectorTrait;

    protected $command;

    protected $identifier;

    protected $options;

    protected $modelReplacements = [
        ':identifier' => '',
        ':model_name' => '',
        ':app_namespace' => '',
        ':traits_include' => '',
        ':traits_use' => '',
        ':table_name' => '',
    ];

    protected $configReplacements = [
        ':image_fields' => '',
    ];

    /**
     * @param Command $command
     * @param string  $modelClass
     * @param string  $title
     */
    public function __construct(Command $command, $identifier, $options)
    {
        $this->command = $command;
        $this->identifier = $identifier;
        $this->options = $options;
    }

    public function renderModel($template)
    {
        if ($this->options['image_uploads']) {
            $this->modelReplacements[':traits_include'] = 'use Despark\Admin\Traits\AdminImage;';
            $this->modelReplacements[':traits_use'] = 'use AdminImage;';
        }

        $this->modelReplacements[':app_namespace'] = $this->getAppNamespace();
        $this->modelReplacements[':table_name'] = str_plural($this->identifier);
        $this->modelReplacements[':model_name'] = ucfirst(camel_case($this->identifier));
        $this->modelReplacements[':identifier'] = $this->identifier;

        $template = strtr($template, $this->modelReplacements);

        return $template;
    }

    public function renderConfig($template)
    {
        if ($this->options['image_uploads']) {
            $this->configReplacements[':image_fields'] = "'image_fields' => [
        'image'  => [
            'thumbnails' => [
                'admin' => [
                    'width' => 150,
                    'height' => null,
                    'type' => 'resize',
                ],
                'normal' => [
                    'width' => 960,
                    'height' => null,
                    'type' => 'crop',
                ],
            ],
        ],
    ],";
        }

        $template = strtr($template, $this->configReplacements);

        return $template;
    }
}
