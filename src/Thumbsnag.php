<?php

namespace Thumbsnag;

use DOMDocument;
use webignition\AbsoluteUrlDeriver\AbsoluteUrlDeriver;

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
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $documentUrl;

    /**
     * @var ImageSizeAnalyzer
     */
    private $analyzer;

    /**
     * Constructor
     *
     * @param DOMDocument       $document
     * @param ImageSizeAnalyzer $analyzer
     * @param                   $documentUrl
     * @param array             $config
     */
    private function __construct(DOMDocument $document, ImageSizeAnalyzer $analyzer, $documentUrl, array $config)
    {
        $this->document = $document;
        $this->analyzer = $analyzer;
        $this->documentUrl = $documentUrl;

        $defaultConfig = [
            'min_area' => 5000, // TODO: Figure out ideal area for design
            'ratio_threshold' => 3.0
        ];

        $this->config = array_merge($defaultConfig, $config);
    }

    /**
     * Inspect a URL for representative images
     *
     * @param DOMDocument       $document
     * @param ImageSizeAnalyzer $analyzer
     * @param null              $baseUrl
     * @param array             $config
     * @return Thumbsnag
     */
    public static function load(DOMDocument $document, ImageSizeAnalyzer $analyzer, $baseUrl = null, array $config = [])
    {
        return new Thumbsnag($document, $analyzer, $baseUrl, $config);
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

        $bodyImages = new BodyImages($this->document);
        $this->images = array_merge($this->images, $bodyImages->images());

        $this->completeImages();
        $this->filterImages();
        $this->prioritizeImages();

        return $this->images;
    }

    /**
     * Make sure images have absolute URLs and dimensions
     */
    private function completeImages()
    {
        foreach ($this->images as $key => &$image) {
            // Make sure we have an absolute URL
            $absoluteUrl = new AbsoluteUrlDeriver($image->getUrl(), $this->documentUrl);
            $image->setUrl((string)$absoluteUrl->getAbsoluteUrl());

            // Get dimensions if we don't have them
            if (!$image->hasDimensions()) {
                $this->analyzer->load($image->getUrl());
                list($width, $height) = $this->analyzer->getSize();

                $image->setDimensions($width, $height);
            }
        }
    }

    /**
     * Remove images that don't fit ideal parameters
     */
    private function filterImages()
    {
        //$this->images = array_filter($this->images, function ($image) {
        // TODO: check minimum width

        // TODO: check ratio < threshold

        // TODO: file name filter ("sprite")
        //});
    }

    /**
     * Order images based on best match
     */
    private function prioritizeImages()
    {
//        $this->images = array_filter($this->images, function ($image) {
//          // TODO: figure out best priority order of images
//        });
    }
}
