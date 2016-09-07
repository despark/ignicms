<?php

namespace Despark\Cms\Admin\Interfaces;

interface UploadImageInterface
{
    public function saveImages();

    public function getImageFields();

    public function images();
}
