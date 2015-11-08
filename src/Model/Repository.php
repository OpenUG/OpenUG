<?php

namespace App\Model;

use App\MetaMarkdown\MetaMarkdown;

class Repository implements RepositoryInterface
{
    private $manager;
    private $directory;
    private $metaMarkdown;

    /**
     * {@inheritdoc}
     */
    public function __construct(Manager $manager, $directory)
    {
        $this->manager = $manager;
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

        $metaMarkdownResult = call_user_func($this->metaMarkdown, $content);

        $metaData = $metaMarkdownResult->getMetadata();
        $properties = $this->mapMetadata($metaData);
        $properties['html'] = $metaMarkdownResult->getHtml();

        return new Entity($id, $properties);
    }

    private function mapMetadata(array $metadata)
    {
        foreach ($metadata as $key => $value) {
            if (is_string($value)) {
                $result = preg_match_all('/^@([a-Z0-9\-_]+):([a-Z0-9\-_]+)$/', $content, $matches);

                if (1 === $result) {
                    $metadata[$key] = $this->manager->getRepository($matches[1][0])->get($matches[2][0]);
                }
            } elseif (is_array($value)) {
                $metadata[$key] = $this->mapMetadata($value);
            }
        }

        return $metadata;
    }

    public function getAll()
    {
        $files = glob($this->directory . '*.md');
        sort($files);

        $items = [];
        foreach ($files as $file) {
            $id = substr($file, strlen($this->directory), -3);
            $items[$id] = $this->get($id);
        }

        return $items;
    }
}
