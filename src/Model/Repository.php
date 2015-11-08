<?php

namespace App\Model;

use App\MetaMarkdown\MetaMarkdown;

class Repository implements RepositoryInterface
{
    private $repositoryManager;
    private $directory;
    private $metaMarkdown;

    /**
     * Repository constructor.
     *
     * @param RepositoryManagerInterface $manager   The repository manager.
     * @param string                     $directory The directory containing the entities.
     */
    public function __construct(RepositoryManagerInterface $repositoryManager, $directory)
    {
        $this->repositoryManager = $repositoryManager;
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
                $result = preg_match_all('/^\s*@([^:\s]+):([^:\s]+)\s*$/', $value, $matches);

                if (1 === $result) {
                    $metadata[$key] = new LazyLoadEntity($this->repositoryManager->getRepository($matches[1][0]), $matches[2][0]);
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
