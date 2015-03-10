<?php

namespace Thumbsnag;

class BodyImages
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
     * Get body images
     *
     * @return array
     */
    public function images()
    {
        $images = [];
        $tags = $this->document->getElementsByTagName('img');

        foreach ($tags as $tag) {
            if (!$tag->hasAttribute('src')) {
                continue;
            }

            $images[] = Image::fromUrl($tag->getAttribute('src'));
        }

        return $images;
    }
}
