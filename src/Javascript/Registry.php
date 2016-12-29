<?php

namespace Despark\Cms\Javascript;

use Despark\Cms\Javascript\Contracts\RegistryContract;

/**
 * Class Registry.
 */
class Registry implements RegistryContract
{
    /**
     * @var
     */
    protected $registry;

    /**
     * @param $namespace
     * @param $values
     * @return $this
     */
    public function register($namespace, array $values)
    {
        if (! isset($this->registry[$namespace])) {
            $this->registry[$namespace] = [];
        }
        $this->registry[$namespace] = array_merge($this->registry[$namespace], $values);

        return $this;
    }

    /**
     * @param $namespace
     * @param null $key
     * @return mixed
     */
    public function get($namespace, $key = null)
    {
        if (isset($this->registry[$namespace])) {
            if ($key) {
                return array_get($this->registry[$namespace], $key, null);
            }

            return $this->registry[$namespace];
        }

        return null;
    }

    /**
     * @param $namespace
     * @param null $key
     */
    public function drop($namespace, $key = null)
    {
        if (isset($this->registry[$namespace])) {
            if ($key) {
                array_forget($this->registry[$namespace], $key);
            } else {
                unset($this->registry[$namespace]);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getRegistry()
    {
        return $this->registry;
    }
}
