<?php

namespace Thumbsnag;

class UrlDocument
{

    /**
     * @var \DOMDocument
     */
    private $document;

    /**
     * @var string
     */
    private $documentUrl;

    /**
     * @param \DOMDocument $document
     * @param              $documentUrl
     */
    public function __construct(\DOMDocument $document, $documentUrl)
    {
        $this->document = $document;
        $this->documentUrl = $documentUrl;
    }

    /**
     * @param \DOMDocument $document
     * @param              $documentUrl
     * @return UrlDocument
     */
    public static function build(\DOMDocument $document, $documentUrl)
    {
        return new UrlDocument($document, $documentUrl);
    }

    /**
     * @return \DOMDocument
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->documentUrl;
    }
}
