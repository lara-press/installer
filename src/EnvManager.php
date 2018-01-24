<?php

namespace LaraPress\Installer\Console;

class EnvManager
{
    protected $env;
    protected $directory;

    public function __construct($directory)
    {
        $this->env = file_get_contents($directory . '/.env');
        $this->directory = $directory;
    }

    public function update($keyValues)
    {
        foreach ($keyValues as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    public function set($key, $value)
    {
        $this->env = preg_replace("/$key=[a-z].*/", "$key=$value", $this->env);

        return $this;
    }

    public function publish()
    {
        file_put_contents($this->directory . '/.env', $this->env);
    }
}