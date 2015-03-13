<?php

use Thumbsnag\FastImageAnalyzer;
use Thumbsnag\Thumbsnag;
use Thumbsnag\UrlDocument;

require_once __DIR__ . '/../vendor/autoload.php';

libxml_use_internal_errors(true);

$url = 'http://simplegifts.co';
$html = file_get_contents($url);
$doc = new DOMDocument();
$doc->loadHTML($html);

$analyzer = new FastImageAnalyzer(new FastImage());

$thumbsnag = Thumbsnag::load(new UrlDocument($doc, $url), $analyzer);
$images = $thumbsnag->process();

print_r($images);