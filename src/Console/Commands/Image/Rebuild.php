<?php

namespace Despark\Cms\Console\Commands\Image;

use Despark\Cms\Models\Image;
use Illuminate\Console\Command;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class Rebuild extends Command
{
    /**
     * The console signature.
     *
     * @var string
     */
    protected $signature = 'igni:image:rebuild {--r|resources=*} {--W|without=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuilds all image styles (Experimental)';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $resource = $this->option('resources');
        $without = $this->option('without');

        // Prepare query
        $query = Image::query();

        if ($resource) {
            if (! is_array($resource)) {
                $resource = [$resource];
            }
            $query->whereIn('resource_model', $resource);
        }
        if ($without) {
            if (! is_array($without)) {
                $without = [$without];
            }
            $query->whereNotIn('resource_model', $without);
        }

        // Get all uploaded images grouped by model / type
        $count = $query->count();
        if (! $count) {
            $this->info('Nothing to process');

            return;
        }

        $images = $query->get();

        $bar = $this->output->createProgressBar($count);

        $checked = [];
        // Validate all relations first.
        foreach ($images as $image) {
            if (! in_array($image->resource_model, $checked)) {
                $className = $image->getActualClassNameForMorph($image->resource_model);
                if (! class_exists($className)) {
                    $this->error('Resource model '.$className.' doesn\'t exist. Review your images table and fix it.');

                    return;
                }
                $checked[] = $image->resource_model;
            }
        }

        foreach ($images as $image) {
            // delete all images
            $imageTypes = $image->getAllImages();
            unset($imageTypes['__source__']);
            foreach ($imageTypes as $images) {
                foreach ($images as $path) {
                    \File::delete(public_path($path));
                }
            }

            $model = $image->image;
            if (method_exists($model, 'manipulateImage')) {
                try {
                    $sourceImage = new File(public_path($image->getSourceImagePath()));
                } catch (FileNotFoundException $exc) {
                    continue;
                }
                $options = $model->getImageField($image->image_type);
                // This is pretty stupid we need to know if the image_type is actual image field or admin field?!
                if ($formField = $model->getFormField($image->image_type)) {
                    // we need to check if it's gallery
                    if ($formField['type'] == 'gallery' && isset($formField['image_field'])) {
                        $options = $model->getImageField($formField['image_field']);
                    }
                }
                $model->manipulateImage($sourceImage, $options);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info('Images were rebuild successfully');
    }
}
