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
