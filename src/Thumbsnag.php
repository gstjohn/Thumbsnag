<?php

namespace Thumbsnag;

use DOMDocument;

class Thumbsnag
{

    /**
     * @var DOMDocument
     */
    private $document;

    /**
     * @var array
     */
    private $images = [];

    /**
     * Constructor
     *
     * @param DOMDocument $document
     */
    private function __construct(DOMDocument $document)
    {
        $this->document = $document;
    }

    /**
     * Inspect a URL for representative images
     *
     * @param DOMDocument $document
     * @return Thumbsnag
     */
    public static function load(DOMDocument $document)
    {
        return new Thumbsnag($document);
    }

    /**
     * Get all representative images
     *
     * @return array
     */
    public function process()
    {
        $openGraph = new OpenGraph($this->document);
        $this->images = $openGraph->images();

        return $this->images;
    }
}
