<?php

namespace Thumbsnag;

class OpenGraph
{

    /**
     * @var \DOMDocument
     */
    private $document;

    /**
     * Constructor
     *
     * @param \DOMDocument $document
     */
    public function __construct(\DOMDocument $document)
    {
        $this->document = $document;
    }

    /**
     * Get OpenGraph images
     *
     * @return array
     */
    public function images()
    {
        $images = [];
        $tags = $this->document->getElementsByTagName('meta');

        if ($tags->length <= 0) {
            return [];
        }

        foreach ($tags as $tag) {
            if (!$tag->hasAttribute('property')) {
                continue;
            }

            $property = $tag->getAttribute('property');

            if ($this->isOpenGraphImageTag($property)) {
                $images[] = $tag->getAttribute('content');
            }
        }

        return $images;
    }

    /**
     * Check for a valid OpenGraph image
     *
     * @param $property
     * @return bool
     */
    private function isOpenGraphImageTag($property)
    {
        if (substr($property, 0, 8) === 'og:image') {
            return true;
        } elseif ($property === 'http://ogp.me/ns#image') {
            return true;
        }

        return false;
    }
}
