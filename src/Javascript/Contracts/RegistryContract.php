<?php

namespace Despark\Cms\Javascript\Contracts;

interface RegistryContract
{
    public function register($namespace, array $values);

    public function get($namespace, $key = null);

    public function drop($namespace, $key = null);

    public function getRegistry();
}
