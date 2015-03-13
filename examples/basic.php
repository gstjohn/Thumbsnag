<?php

use Thumbsnag\Thumbsnag;

require_once __DIR__ . '/../vendor/autoload.php';

libxml_use_internal_errors(true);

$html = file_get_contents('http://simplegifts.co');
$doc = new DOMDocument();
$doc->loadHTML($html);

$thumbsnag = Thumbsnag::load($doc);
$images = $thumbsnag->process();

print_r($images);