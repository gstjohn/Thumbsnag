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
        if (!is_numeric($width) || !is_numeric($height)) {
            throw new \InvalidArgumentException('Values for width and height must be numeric for setDimensions()');
        }

        $this->width = $width;
        $this->height = $height;
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

    /**
     * Determine if the images has dimensions set
     *
     * @returns bool
     */
    public function hasDimensions()
    {
        return ($this->width && $this->height);
    }

    /**
     * Get image url
     *
     * @returns string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set image url
     *
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Cast to string
     *
     * @return string
     */
    function __toString()
    {
        return $this->getUrl();
    }
}
