<?php

use Thumbsnag\FastImageAnalyzer;
use Thumbsnag\Thumbsnag;

require_once __DIR__ . '/../vendor/autoload.php';

libxml_use_internal_errors(true);

$url = 'http://creativeclutterblog.com';

$html = file_get_contents($url);
$doc = new DOMDocument();
$doc->loadHTML($html);

$analyzer = new FastImageAnalyzer(new Fastimage());

$thumbsnag = Thumbsnag::load($doc, $analyzer, $url);
$images = $thumbsnag->process();

print_r($images);