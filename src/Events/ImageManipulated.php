<?php


namespace Despark\Cms\Events;


/**
 * Class ImageManipulated.
 */
class ImageManipulated
{

    /**
     * @var array
     */
    public $images;

    /**
     * ImageManipulated constructor.
     * @param array $images
     */
    function __construct(array $images)
    {
        $this->images = $images;
    }

}