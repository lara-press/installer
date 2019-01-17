<?php

namespace LaraPress\Installer\Console;

class ComposerManager
{
    protected $composer;
    protected $directory;

    public function __construct($directory)
    {
        $this->composer = json_decode(file_get_contents($directory . '/composer.json'), true);
        $this->directory = $directory;
    }

    public function mergeOptions($options)
    {
        foreach ($options as $key => $option) {
            $this->mergeOption($key, $option);
        }

        return $this;
    }

    public function mergeOption($key, $option)
    {
        if (!isset($this->composer[$key])) {
            $this->composer[$key] = [];
        }

        $newOption = array_merge($this->composer[$key], $option);
        ksort($newOption);
        $this->composer[$key] = $newOption;

        return $this;
    }

    public function publish()
    {
        file_put_contents(
            $this->directory . '/composer.json',
            json_encode($this->composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }
}