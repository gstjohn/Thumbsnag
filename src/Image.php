<?php

namespace Thumbsnag;

class Image
{

    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $width;

    /**
     * Constructor
     *
     * @param $url
     */
    private function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Build an Image with a URL
     *
     * @param $url
     * @return Image
     */
    public static function fromUrl($url)
    {
        return new Image($url);
    }

    /**
     * Set image dimensions
     *
     * @param $width
     * @param $height
     */
    public function setDimensions($width, $height)
    {
        $this->width = is_null($width) ? $this->width : $width;
        $this->height = is_null($height) ? $this->height : $height;
    }

    /**
     * Get image dimensions
     *
     * @returns array
     */
    public function getDimensions()
    {
        return [$this->width, $this->height];
    }

    /**
     * Get width-to-height ratio
     *
     * @returns double
     */
    public function getRatio()
    {
        return (double)$this->width / $this->height;
    }
}
