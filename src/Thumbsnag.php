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
     * @var ImageSizeAnalyzer
     */
    private $analyzer;

    /**
     * Constructor
     *
     * @param ImageSizeAnalyzer $analyzer
     * @param array             $config
     */
    public function __construct(ImageSizeAnalyzer $analyzer, array $config = [])
    {
        $this->analyzer = $analyzer;

        $defaultConfig = [
            'min_area' => 5000,
            'ratio_threshold' => 3.0,
            'filename_filters' => ['sprite', 'blank', 'spacer']
        ];

        $this->config = array_merge($defaultConfig, $config);
    }

    /**
     * Inspect a URL for representative images
     *
     * @param UrlDocument       $document
     * @param ImageSizeAnalyzer $analyzer
     * @param array             $config
     * @return Thumbsnag
     */
    public static function load(UrlDocument $document, ImageSizeAnalyzer $analyzer, array $config = [])
    {
        $thumbsnag = new Thumbsnag($analyzer, $config);
        $thumbsnag->setDocument($document);

        return $thumbsnag;
    }

    /**
     * Set document
     *
     * @param UrlDocument $document
     */
    public function setDocument(UrlDocument $document)
    {
        $this->document = $document;
    }

    /**
     * Get all representative images
     *
     * @return array
     * @throws \Exception
     */
    public function process()
    {
        if (is_null($this->document)) {
            throw new \Exception('A document must be set on the object before processing.');
        }

        $document = $this->document->getDocument();

        $openGraph = new OpenGraph($document);
        $this->images = $openGraph->images();

        $bodyImages = new BodyImages($document);
        $this->images = array_merge($this->images, $bodyImages->images());

        $this->makeUrlsAbsolute();
        $this->removeDuplicates();
        $this->completeImages();
        $this->filterImages();

        return array_values($this->images);
    }

    /**
     * Make URLs absolute
     */
    private function makeUrlsAbsolute()
    {
        foreach ($this->images as $key => &$image) {
            // Make sure we have an absolute URL
            $absoluteUrl = new AbsoluteUrlDeriver($image->getUrl(), $this->document->getUrl());
            $image->setUrl((string)$absoluteUrl->getAbsoluteUrl());
        }
    }

    /**
     * Remove duplicate URLs
     */
    private function removeDuplicates()
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

            // file name filter
            $fileNameFilters = $this->config['filename_filters'];
            $filename = basename($image->getUrl());
            foreach ($fileNameFilters as $filter) {
                if (strpos($filename, $filter) !== false) {
                    return false;
                }
            }

            return true;
        });
    }
}
