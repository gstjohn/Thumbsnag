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

            $image = Image::fromUrl($tag->getAttribute('src'));

            $width = $tag->hasAttribute('width') ? (int)$tag->getAttribute('width') : null;
            $height = $tag->hasAttribute('height') ? (int)$tag->getAttribute('height') : null;

            if (!is_null($width) && !is_null($height)) {
                $image->setDimensions($width, $height);
            }

            $images[] = $image;
        }

        return $images;
    }
}
