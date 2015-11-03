<?php

namespace App\MetaMarkdown;

use League\CommonMark\CommonMarkConverter;
use Symfony\Component\Yaml\Yaml;

class MetaMarkdownResult
{
    /**
     * @var array
     */
    private $metadata;

    /**
     * @var string
     */
    private $html;

    /**
     * Constructor.
     *
     * @param array  $metadata An array of metadata
     * @param string $html     The converted HTML
     */
    public function __construct(array $metadata, $html)
    {
        $this->metadata = $metadata;
        $this->html = $html;
    }

    /**
     * Check the metadata for a value.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->metadata[$key]);
    }

    /**
     * Get metadata value.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new \Exception('Key does not exist: ' . $key);
        }

        return $this->metadata[$key];
    }

    /**
     * Get the metadata.
     *
     * @return array The metadata.
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Get the HTML.
     *
     * @return string The HTML.
     */
    public function getHtml()
    {
        return $this->html;
    }
}
