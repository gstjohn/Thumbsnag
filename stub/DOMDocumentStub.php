<?php

namespace Thumbsnag\Stub;

use DOMDocument;

class DOMDocumentStub {

    public static function getDocument()
    {
        $document = new DOMDocument();
        $document->loadHTMLFile(__DIR__ . '/document.html');

        return $document;
    }
}