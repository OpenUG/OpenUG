<?php

namespace App\Model;

use App\MetaMarkdown\MetaMarkdown;

trait RepositoryTrait
{
    private $directory;
    private $metaMarkdown;

    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->metaMarkdown = new MetaMarkdown;
    }

    public function get($id)
    {
        $file = $this->directory . $id . '.md';

        if (!file_exists($file)) {
            throw new \Exception('File does not exist: ' . $file);
        }

        $content = file_get_contents($file);

        return call_user_func($this->metaMarkdown, $content);
    }

    public function getAll()
    {
        $files = glob($directory . '*.md');
        sort($files);

        $items = [];
        foreach ($files as $file) {
            $id = substr($file, strlen($directory), -3);
            $items[$id] = $this->get($id);
        }

        return $items;
    }
}
