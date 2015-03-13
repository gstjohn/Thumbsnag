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
            'min_area' => 5000,
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

        $this->makeUrlsAbsolute();
        $this->removeDuplicates();
        $this->completeImages();
        $this->filterImages();

        return $this->images;
    }

    /**
     * Make URLs absolute
     */
    public function makeUrlsAbsolute()
    {
        foreach ($this->images as $key => &$image) {
            // Make sure we have an absolute URL
            $absoluteUrl = new AbsoluteUrlDeriver($image->getUrl(), $this->documentUrl);
            $image->setUrl((string)$absoluteUrl->getAbsoluteUrl());
        }
    }

    /**
     * Remove duplicate URLs
     */
    public function removeDuplicates()
    {
        $images = [];

        foreach ($this->images as $image) {
            $images[$image->getUrl()] = $image;
        }

        $this->images = array_values($images);
    }

    /**
     * Make sure images have absolute URLs and dimensions
     */
    private function completeImages()
    {
        foreach ($this->images as $key => &$image) {
            // Get dimensions if we don't have them
            if (!$image->hasDimensions()) {
                try {
                    $this->analyzer->load($image->getUrl());

                    list($width, $height) = $this->analyzer->getSize();

                    $image->setDimensions($width, $height);
                } catch (\Exception $e) {
                    // Remove image if there was an issue analyzing it
                    unset($this->images[$key]);
                }
            }
        }
    }

    /**
     * Remove images that don't fit ideal parameters
     */
    private function filterImages()
    {
        $this->images = array_filter($this->images, function ($image) {
            list($width, $height) = $image->getDimensions();

            // check minimum size
            if ($width * $height < $this->config['min_area']) {
                return false;
            }

            // check ratio < threshold
            if ($image->getRatio() > $this->config['ratio_threshold']) {
                return false;
            }

            // TODO: file name filter ("sprite")

            return true;
        });
    }
}
