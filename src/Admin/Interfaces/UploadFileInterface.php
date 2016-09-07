<?php

namespace Despark\Cms\Admin\Interfaces;

interface UploadFileInterface
{
    public function saveFiles();

    public function getFileFields();

    public function files();
}
