<?php

namespace Despark\Cms\Models;

use Despark\Cms\Admin\Interfaces\UploadImageInterface;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class AdminModel.
 */
abstract class AdminModel extends Model
{
    /**
     * @var array Files to save.
     */
    protected $files = [];

    /**
     * @var array
     */
    protected $dirtyFiles = [];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $rulesUpdate = [];

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $uploadType;

    /**
     * @param array $attributes
     * @return Model
     * @throws \Exception
     */
    public function fill(array $attributes)
    {
        // First fill the image and file attributes so they don't need to be guarded??
        if ($this instanceof UploadImageInterface) {
            // Check if we have upload type

            // Save the upload type to the model and remove it from attributes.

            //get all uploaded files to temp
            if (isset($attributes['_files'])) {
                $this->files = $attributes['_files'];
                unset($attributes['_files']);
            }

            // Get single uploads.
            foreach (array_keys($this->getImageFields()) as $imageFieldName) {
                // Check for direct upload
                if (array_key_exists($imageFieldName, $attributes)) {
                    $this->files['_single'][$imageFieldName] = $attributes[$imageFieldName];
                    unset($attributes[$imageFieldName]);
                }

                // Check for single delete
                if (array_key_exists($imageFieldName.'_'.'delete', $attributes)
                    && $attributes[$imageFieldName.'_'.'delete']
                ) {
                    // we mark it for delete
                    $this->files['_single'][$imageFieldName]['delete'] = 1;
                    unset($attributes[$imageFieldName.'_'.'delete']);
                }
            }
        }

        return parent::fill($attributes);
    }

    /**
     * Override is dirty so we can trigger update if we have dirty images.
     * @return array
     */
    public function getDirty()
    {
        $dirty = parent::getDirty();
        if (! empty($this->files)) {
            // We just set the ID to the same value to trigger the update.
            $dirty[$this->getKeyName()] = $this->getKey();
        }

        return $dirty;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return bool
     */
    public function hasImages()
    {
        return $this instanceof UploadImageInterface && $this->images()->exists();
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     * @return AdminModel
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @return array
     */
    public function getRulesUpdate()
    {
        return array_merge($this->rules, $this->rulesUpdate);
    }

    /**
     * @param array $rulesUpdate
     * @return AdminModel
     */
    public function setRulesUpdate($rulesUpdate)
    {
        $this->rulesUpdate = $rulesUpdate;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
