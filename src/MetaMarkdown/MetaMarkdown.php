<?php

namespace App\MetaMarkdown;

use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Yaml\Yaml;

class MetaMarkdown
{
    private $converter;

    public function __construct()
    {
        $this->converter = new CommonMarkConverter;
    }

    /**
     * Parse meta markdown.
     *
     * @param string $content
     *
     * @throws \InvalidArgumentException When content does not exist.
     */
    public function __invoke($content)
    {
        $result = preg_match_all('/^---\n(.+)\n---(.+)$/s', $content, $matches);

        if ($result === 1) {
            $metadata = $this->getMetadata($matches[1][0]);
            $html     = $this->getHtml($matches[2][0]);
        } else {
            $metadata = [];
            $html     = $this->getHtml($content);
        }

        return new MetaMarkdownResult($metadata, $html);
    }

    /**
     * Convert YAML to an array.
     *
     * @param string $yaml
     *
     * @param return array
     */
    private function getMetadata($yaml)
    {
        return Yaml::parse($yaml);
    }

    /**
     * Convert markdown to html.
     *
     * @param string $markdown Markdown input.
     *
     * @return string $html HTML output.
     */
    private function getHtml($markdown)
    {
        return $this->converter->convertToHtml($markdown);
    }
}
