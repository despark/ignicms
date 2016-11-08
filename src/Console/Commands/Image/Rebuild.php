<?php


namespace Despark\Cms\Console\Commands\Image;


use Despark\Cms\Admin\Traits\AdminImage;
use Despark\Cms\Models\Image;
use Illuminate\Console\Command;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;

class Rebuild extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'igni:image:rebuild';

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
        // Get all config files.
        // Get all uploaded images grouped by model / type
        $count = Image::count();
        $images = Image::all();

        $bar = $this->output->createProgressBar($count);

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